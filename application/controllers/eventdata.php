<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/api/basedata.php";

class EventData extends BaseData
{
    function __construct($parameters=array())
    {
        parent::__construct($parameters);
        $this->entityName = "Event";

        $this->entityInfo = array(
          "id"          =>"",
          "projectCode"   =>"String",
          "eventCode"   =>"String",
          "siteCode"    =>"String",
          "startDate"   =>"Date",
          "endDate"     =>"Date",
        );
    }
}
