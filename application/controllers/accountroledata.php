<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/api/basedata.php";

class AccountRoleData extends BaseData{

  function __construct($parameters=array())
  {
    parent::__construct($parameters);
    $this->entityName = "Accountrole";

    $this->entityInfo = array(
      "id"        => "",
      "aid"       => "Account",
      "roleId"    => "Role",
    );
  }

  public function getList($listParams){
    if(isset($listParams) && isset($listParams->filter) && isset($listParams->filter->aid)){
      $list = $this->em->getRepository($this->entityName)
                      ->findBy(array(
                        'aid' => $this->em->find('Account',$listParams->filter->aid),
                        'valid' => 'Y'
                      ));
      return $list;
    }
  }

  protected function mainPost($preEntity){
    $entity = $this->mainPostWithData($this->_post_args);
    $this->em->persist($entity);
    return $entity;
  }

  protected function fetchEntityReturnData($entity){
    $data = $this->toArray($entity);
    $role = $entity->getRoleid();
    $data["roleName"] = $role->getName();

    return $data;
  }

}
