<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/api/basedata.php";

class RfidData extends BaseData{
  function __construct($parameters=array())
  {
    parent::__construct($parameters);
    $this->entityName = "Rfid";

    $this->entityInfo = array(
      "id"          => "",
      "firstName"   => "String",
      "lastName"    => "String",
      "BOD"         => "Date",
      "email"       => "String",
      "mobile"      => "String",
      "rfid"        => "String",
      "fbUserId"    => "String",
      "accessCode"  => "String",
      "reserve1"    => "String",
      "reserve2"    => "String",
      "reserve3"    => "String",
      "reserve4"    => "String",
      "reserve5"    => "String",
    );
  }
}