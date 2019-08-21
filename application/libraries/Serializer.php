<?php

use Doctrine\ORM\EntityManager;

class Serializer
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function serialize($entity)
    {
        $className = get_class($entity);

        $uow = $this->em->getUnitOfWork();
        $entityPersister = $uow->getEntityPersister($className);
        $classMetadata = $entityPersister->getClassMetadata();

        $result = array();
        foreach ($uow->getOriginalEntityData($entity) as $field => $value) {
            if (isset($classMetadata->associationMappings[$field])) {
                $assoc = $classMetadata->associationMappings[$field];

                // Only owning side of x-1 associations can have a FK column.
                if ( ! $assoc['isOwningSide'] || ! ($assoc['type'] & \Doctrine\ORM\Mapping\ClassMetadata::TO_ONE)) {
                    continue;
                }

                if ($value !== null) {
                    $newValId = $uow->getEntityIdentifier($value);
                }

                $targetClass = $this->em->getClassMetadata($assoc['targetEntity']);
                $owningTable = $entityPersister->getOwningTable($field);

                foreach ($assoc['joinColumns'] as $joinColumn) {
                    $sourceColumn = $joinColumn['name'];
                    $targetColumn = $joinColumn['referencedColumnName'];

                    if ($value === null) {
                        $result[$sourceColumn] = null;
                    } else if ($targetClass->containsForeignIdentifier) {
                        $result[$sourceColumn] = $newValId[$targetClass->getFieldForColumn($targetColumn)];
                    } else {
                        $result[$sourceColumn] = $newValId[$targetClass->fieldNames[$targetColumn]];
                    }
                }
            } elseif (isset($classMetadata->columnNames[$field])) {
                $columnName = $classMetadata->columnNames[$field];
                $result[$columnName] = $value;
            }
        }

        //return array($className, $result);
        return $result;
    }

    public function deserialize($object,$data){
        foreach ($data as $property => $value) {

            if($property == "id") continue;
            if($property == "selected") continue;
            if($property == "nodes") continue;
            if($property == "children") continue;

            //Skep control field.
            if($property == "createDate") continue;
            if($property == "createUser") continue;
            if($property == "updateDate") continue;
            if($property == "updateUser") continue;
            if($property == "valid") continue;


            log_message('debug',"deserialize : $property, $value");

            $property = strtolower($property);
            $method = sprintf('set%s', ucwords($property));
            $object->$method($value);
            /*
            if($classMetadata != null){
              log_message('debug',"classMetadata");

              if (isset($classMetadata->associationMappings[$property])){
                log_message('debug','AAAA');
                $method = sprintf('set%s', ucwords($property));
                $object->$method($value);
              }

              $property = strtolower($property);
              log_message('debug','BBBB');
              if(isset($classMetadata->associationMappings[$property])){
                log_message('debug','CCCC');
                $method = sprintf('set%s', ucwords($property));
                $object->$method($value);
              }

            }
            else{
              $method = sprintf('set%s', ucwords($property));
              $object->$method($value);
            }
            */
        }

        return $object;
    }
}
