<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/api/basedata.php";

ini_set("display_errors", "On");

spl_autoload_register(function ($class) {

    if(strpos($class,"Doctrine") !== false) return;
    if(strpos($class,"CI_") !== false) return;
    if(strpos($class,"MY_") !== false) return;

    $file = APPPATH . 'models/Entities/' . $class . '.php';
    if (file_exists($file)){
       require $file;
    }
});

class Api extends BaseData
{

    function __construct()
    {
        parent::__construct();
        $this->entityName = "Api";

    }

    function data_get()
    {
      $auth = $this->getHeaders("Authorization");
      if($auth == null){
        $this->response(array('error' => 'Unauthorized.','code'=>"401"),401);
        return;
      }

      if(!$this->get("stype"))
      {
        $this->response(array('error' => 'There is no information about stype in url.'),404);
        return;
      }
      $this->entityName = ucwords($this->get("stype"));
      return parent::index_get();
    }

    function data_post()
    {
      if(!$this->get("stype"))
      {
        $this->response(array('error' => 'There is no information about stype in url.'),404);
        return;
      }
      $this->entityName = ucwords($this->get("stype"));
      return parent::index_post();
    }

    function data_put()
    {
      if(!$this->get("stype"))
      {
        $this->response(array('error' => 'There is no information about stype in url.'),404);
        return;
      }
      $this->entityName = ucwords($this->get("stype"));
      return parent::index_put();
    }

    function data_delete()
    {
      if(!$this->get("stype"))
      {
        $this->response(array('error' => 'There is no information about stype in url.'),404);
        return;
      }
      $this->entityName = ucwords($this->get("stype"));
      return parent::index_delete();
    }

    function batch_post()
    {
      if(!$this->get("stype"))
      {
        $this->response(array('error' => 'There is no information about stype in url.'),404);
        return;
      }
      $this->entityName = ucwords($this->get("stype"));
      return parent::batch_post();
    }

    protected function toArray($entity){
      $entity = parent::toArray($entity);

      return $this->serializer->serialize($entity);
    }

    protected function toEntity($entity,$arrayEntity){
      $arrayEntity = parent::toEntity($arrayEntity);

      if(isset($arrayEntity["id"])){
        $entity = new $this->entityName;
        $entity = $this->serializer->deserialize($record,$arrayEntity);
        return $entity;
      }else{
        $entity = $this->em->find($this->entityName,$this->put("id"));
        $entity = $this->serializer->deserialize($entity,$arrayEntity);
        return $entity;
      }
    }

}
