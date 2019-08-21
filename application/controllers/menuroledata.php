<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/api/basedata.php";

class MenuroleData extends BaseData{

  function __construct($parameters=array())
  {
    parent::__construct($parameters);
    $this->entityName = "Menurole";

    $this->entityInfo = array(
      "id"            => "",
      "roleId"        => "Role",
      "menuId"        => "Menu",
      "readable"      => "Boolean",
      "writable"      => "Boolean",
      "confirmable"   => "Boolean",
    );
  }

  public function getList(){
    if($this->get('roleid')){
      $list = $this->em->getRepository($this->entityName)
                       ->findBy(array(
                          'roleid' => $this->em->find('Role',$this->get("roleid")),
                          'valid' => 'Y'
                       ));

      $data = $this->toList($list);

      $this->response($data,200);
    }
  }

  protected function mainPut(){
    $entity = null;
    if(isset($this->_put_args["id"])){
      $entity = $this->fetchEntity($this->_put_args);
      $entity = $this->toEntity($entity,$this->_put_args);

      $entity->setUpdateDate(new DateTime("now"));
      $entity->setUpdateUser($this->authUser->id);
      $this->em->flush();
    }else{
      $entity = $this->fetchEntity($this->_put_args);
      $entity = $this->toEntity($entity,$this->_put_args);

      $entity->setCreateDate(new DateTime("now"));
      $entity->setCreateUser($this->authUser->id);
      $this->em->persist($entity);
      $this->em->flush();
    }

    return $entity;
  }

}
