<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/api/basedata.php";

class MenuData extends BaseData{
  
  function __construct($parameters=array())
  {
    parent::__construct($parameters);
    $this->entityName = "Menu";

    $this->entityInfo = array(
      "id"      =>"",
      "name"    =>"String",
      "url"     =>"String",
      "order"   =>"Number",
      "pid"     =>"Menu"
    );

  }

  protected function preDelete($entity){
    $this->deleteChildren($entity->getMenuRoles());
  }

}
