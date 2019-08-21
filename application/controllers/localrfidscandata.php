<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/api/basedata.php";

class LocalRfidScanData extends BaseData{
  function __construct($parameters=array())
  {
    parent::__construct($parameters);
    $this->entityName = "Localrfidscan";

    $this->entityInfo = array(
      "id"          => "",
      "rfid"        => "String",
      "localUserId" => "Localuser",
    );
    
  }
}
