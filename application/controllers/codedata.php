<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/api/basedata.php";

class CodeData extends BaseData
{
    function __construct($parameters=array())
    {
        parent::__construct($parameters);
        $this->entityName = "Code";

        $this->entityInfo = array(
          "id"        =>"",
          "category"  =>"String",
          "code"      =>"String",
          "name"      =>"String",
          "note"      =>"String",
          "reserve1"  =>"String",
          "reserve2"  =>"String",
          "reserve3"  =>"String",
          "reserve4"  =>"String",
          "reserve5"  =>"String"
        );
    }
}
