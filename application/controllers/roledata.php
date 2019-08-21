<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/api/basedata.php";

class RoleData extends BaseData{

  private $menuroledata;

  function __construct($parameters=array())
  {
    parent::__construct($parameters);
    $this->entityName = "Role";

    $this->entityInfo = array(
      "id"      => "",
      "name"    => "String",
      "note"    => "String",
    );

    $this->menuroledata = new MenuRoleData($parameters);
  }

  protected function postPost($roleEntity){
    $menudatas = $this->post('menudata');
    //$menuroledata = new MenuRoleData;
    foreach($menudatas as $menudata){
      $menurole = $this->menuroledata->mainPostWithData($menudata);
      $menurole->setRoleid($roleEntity);
      $menurole->setMenuid($this->em->find('Menu',$menudata["id"]));
      $this->em->persist($menurole);
    }
  }

  protected function preDelete($entity){
    $this->deleteChildren($entity->getMenuRoles());
  }

  /*
  protected function preDelete(){
    $entities = $this->em->getRepository("Menurole")
                        ->findBy(array(
                          'roleid' => $this->em->find('Role',$this->get("id")),
                          'valid' => 'Y'
                        ));

    foreach($entities as $entity){
      $this->em->remove($entity);
    }
  }
  */

}
