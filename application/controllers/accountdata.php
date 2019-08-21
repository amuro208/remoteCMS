<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/api/basedata.php";
//require APPPATH . "models/Entities/Account.php";

class AccountData extends BaseData
{
  function __construct($parameters=array())
  {
    parent::__construct($parameters);
    $this->entityName = "Account";

    $this->entityInfo = array(
      "id"        => "",
      "email"     => "String",
      "password"  => "",
      "firstName" => "String",
      "lastName"  => "String",
      "approval"  => "Boolean"
    );
  }

  protected function prePost(){
    if($this->post("password") != ""){
      $password = $this->post("password");
      $this->_post_args["password"] = md5($password);
    }
  }

  protected function prePut(){
    if($this->put("password") != ""){
      $password = $this->put("password");
      $this->_put_args["password"] = md5($password);
    }
  }

  protected function postDelete($mainEntity){
    $this->deleteChildren($mainEntity->getAccountRoles());
  }
}
