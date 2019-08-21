<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/api/basedata.php";

class SystemOptionData extends BaseData
{
    function __construct($parameters=array())
    {
        if(count($parameters) == 0){
          $parameters = array("NoSendError"=>"Y");
        }else{
          $parameters["NoSendError"] = "Y";
        }
        parent::__construct($parameters);
        $this->entityName = "Systemoption";

        $this->entityInfo = array(
          "id"        =>"",
          "name"      =>"String",
          "value"     =>"String",
        );
    }

    function option_get(){
      $optionname = $this->uri->segment(3);
      $optionvalue = $this->getOptionValue($optionname);
      echo $optionvalue;
    }

    function initoptions_get(){
      $opt = "is_local_server";

      $result = array(
        "is_local_server" => $this->getOptionValue("is_local_server"),
        "cms_name" => $this->getOptionValue("cms_name"),
        "cms_version" => $this->getOptionValue("cms_version"),
        "csrf_hash" => $this->security->get_csrf_hash(),
        "environment" => ENVIRONMENT,
      );

      echo json_encode($result);
    }
}
