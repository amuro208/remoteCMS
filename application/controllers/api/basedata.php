<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/doctrinautoloadrestful.php';

class BaseData extends DoctrinAutoloadRestful
{

  protected $serializer;
  protected $entityName;
  protected $entityInfo = array();
  protected $today = null;
  private $primitiveType = array("String","Char","Boolean","Number","Date","DateTime");
  private $likeType = array("String","Date","Boolean","DateTime");

  function __construct($parameters = array())
  {
    parent::__construct($parameters);

    $this->serializer = new Serializer($this->em); // Pass the EntityManager object
    $this->entityName = "Base";
    $this->today = date("Y-m-d");

  }

  public static function getEntityInfo(){
    return $this->$entityInfo;
  }

  public function index_get()
  {
    $this->log('START ['.$this->entityName.']BaseData::index_get()---------------------------------------------');
    if(!$this->checkAuth()) return;

    $this->log('### argurment:'.json_encode($this->_get_args));
    $this->log("### pageParams:".json_encode(json_decode($this->get("pageParams"))));
    $this->log('### entityName:'.$this->entityName);

    if ($this->get('id')) {
      $entity = $this->getEntity();
      $data = $this->fetchEntityReturnData($entity);
    }else{
      $pageParams = json_decode($this->get("pageParams"));
      if($this->get("pageMode")){
        $this->log("### pageMode : true");
        $data = $this->getListByPage($pageParams);
        $data["data"] = $this->fetchListReturnData($data["data"]);
      }else{
        $this->log("### pageMode : false");
        $list = $this->getList($pageParams);
        $data = $this->fetchListReturnData($list);
      }
    }

    $this->log('END ['.$this->entityName.']BaseData::index_get()###############################################');
    $this->response($data,200);
  }

  protected function getAid(){

    if($this->get("test") == "Y") return false;

    if(isset($this->entityInfo["aid"])){
      $isAid = true;
      if(!$this->get("aid") && !$this->authUser->aid){
        $this->response(array('error' => 'There is no information about aid in url.'),404);
        return;
      }

      if($this->authUser->aid){
        return $this->authUser->aid;
      }

      return $this->get("aid");
    }

    return false;
  }

  public function getList($pageParams){
    $this->log('getList:'.json_encode($pageParams));

    $filter = array();
    $sorting = array();
    if(isset($pageParams) && $pageParams != null){
      if(isset($pageParams->filter) && $pageParams->filter != null){
        $filter = json_decode(json_encode($pageParams->filter), true);
      }

      if(isset($pageParams->sorting) && $pageParams->sorting != null){
        $sorting = json_decode(json_encode($pageParams->sorting), true);
      }
    }

    $repository = $this->em->getRepository($this->entityName);
    $this->log("getRepository() is successful");

    $qb = $repository->createQueryBuilder('e');
    $qb = $this->addJoin($qb,$filter);

    $qb->where("e.valid = 'Y'");
    $aid = $this->getAid();
    if($aid){
      $qb->andWhere("e.aid = $aid");
    }

    if(count($filter) > 0){
      foreach($filter as $key => $value){
        if(isset($this->entityInfo[$key])){
          if($this->entityInfo[$key] == "" || in_array($this->entityInfo[$key],$this->likeType)){
            $key = strtolower($key);
            if($value == "NULL"){
              $qb->andWhere("e.$key is NULL");
            }else if($value == ""){

            }else{
              $qb->andWhere("e.$key LIKE '%$value%'");
            }
          }else{
            $key = strtolower($key);
            if($value == "NULL"){
              $qb->andWhere("e.$key is NULL");
            }else if($value == ""){
              $qb->andWhere("e.$key = ''");
            }else{
              $qb->andWhere("e.$key = '$value'");
            }
          }
        }
      }
    }
    $qb = $this->addWhere($qb,$filter);

    if(count($sorting) > 0){
      $isFirst = true;
      foreach($sorting as $key => $value){
        if(isset($this->entityInfo[$key])){
          $key = strtolower($key);
          if($isFirst){
            $qb->orderBy("e.$key","$value");
            $isFirst = false;
          }else{
            $qb->addOrderBy("e.$key","$value");
          }
        }
      }
      $qb = $this->addOrderBy($qb,$sorting,$isFirst);
    }


    $this->log($qb->getQuery()->getSQL());

    return $qb->getQuery()->getResult();
  }

  protected function addJoin($qb,$filter){
    return $qb;
  }

  protected function addWhere($qb,$filter){
    return $qb;
  }

  protected function addOrderBy($qb,$sorting,$isFirst){
    return $qb;
  }

  protected function getListByPage($pageParams){

    $filter = array();
    $sorting = array();
    $page = 0;
    $pageSize = 0;
    if(isset($pageParams) && $pageParams != null){
      if(isset($pageParams->filter) && $pageParams->filter != null){
        $filter = json_decode(json_encode($pageParams->filter), true);
      }
      if(isset($pageParams->sorting) && $pageParams->sorting != null){
        $sorting = json_decode(json_encode($pageParams->sorting), true);
      }
      if(isset($pageParams->page)){
        $page = $pageParams->page;
      }
      if(isset($pageParams->count)){
        $pageSize = $pageParams->count;
      }
    }

    $repository = $this->em->getRepository($this->entityName);
    $qb = $repository->createQueryBuilder('e');
    $qb = $this->addJoin($qb,$filter);
    $qb->where("e.valid = 'Y'");
    $aid = $this->getAid();
    if($aid){
      $qb->andWhere("e.aid = $aid");
    }

    if(count($filter) > 0){
      foreach($filter as $key => $value){
        if(isset($this->entityInfo[$key])){
          if($this->entityInfo[$key] == "" || in_array($this->entityInfo[$key],$this->likeType)){
            $key = strtolower($key);
            if($value == "NULL"){
              $qb->andWhere("e.$key is NULL");
            }else if($value == ""){

            }else{
              $qb->andWhere("e.$key LIKE '%$value%'");
            }
          }else{
            $key = strtolower($key);
            if($value == "NULL"){
              $qb->andWhere("e.$key is NULL");
            }else if($value == ""){
              $qb->andWhere("e.$key = ''");
            }else{
              $qb->andWhere("e.$key = '$value'");
            }
          }
        }
      }
    }

    $qb = $this->addWhere($qb,$filter);
    $list = $qb->getQuery()->getResult();
    $total = count($list);

    if(count($sorting) > 0){
      $isFirst = true;
      foreach($sorting as $key => $value){
        if(isset($this->entityInfo[$key])){
          $key = strtolower($key);
          if($isFirst){
            $qb->orderBy("e.$key","$value");
            $isFirst = false;
          }else{
            $qb->addOrderBy("e.$key","$value");
          }
        }
      }
      $qb = $this->addOrderBy($qb,$sorting,$isFirst);
    }

    $this->log($qb->getQuery()->getSQL());

    $list = $qb->getQuery()->setMaxResults($pageSize)
               ->setFirstResult(($page-1)*$pageSize)
               ->getResult();

    return array(
      "code" => "OK",
      "message" => "",
      "total" => $total,
      "page" => $page,
      "pageSize" => $pageSize,
      "data" => $list
    );
  }

  protected function getEntity(){
    $aid = $this->getAid();
    if($aid){
      $entity = $this->em->getRepository($this->entityName)
                         ->findOneBy(array(
                            'id' => $this->get("id"),
                            'aid' => $aid,
                            'valid' => 'Y'
                         ));
    }else{
      $entity = $this->em->getRepository($this->entityName)
                         ->findOneBy(array(
                            'id' => $this->get("id"),
                            'valid' => 'Y'
                         ));
    }

    if(!$entity){
      $this->response(array('error' => 'Couldn\'t find any information!'),404);
      return;
    }

    return $entity;
  }

  /**
  this is to make the return array of an entity.
  */
  protected function fetchEntityReturnData($entity){
    return $this->toArray($entity);
  }

  /**
  this is to make the return array of list.
  */
  public function fetchListReturnData($list){
    $data = array();
    if(count($list) == 0) return $data;

    foreach($list as $entity){
      if($entity->getValid() == "Y"){
        //$data[] = $this->fetchEntityReturnData($entity);
        $temp = $this->fetchEntityReturnData($entity);
        if($temp != null){
          $data[] = $temp;
        }
      }
    }
    return $data;
  }

  public function index_post()
  {
    $this->log('START ['.$this->entityName.']BaseData::index_post()---------------------------------------------');
    if(!$this->checkAuth()) return;

    $this->log('argurment:'.json_encode($this->_post_args));
    $this->log('entityName:'.$this->entityName);

    try{

      $preEntity = $this->prePost();
      $mainEntity = $this->mainPost($preEntity);
      $this->postPost($mainEntity);
      $this->em->flush();

      //$mainEntity = $this->em->find($this->entityName,$mainEntity->getId());
      $this->em->refresh($mainEntity);
      $data = $this->fetchEntityReturnData($mainEntity);

    }catch (Exception $e) {
      $this->error($e);

      $this->log("reutrn : error");
      $this->log('END ['.$this->entityName.']BaseData::index_post()###############################################');

      $this->response(array('error' => 'Exception-['.$e->getMessage().'].'),500);
      throw $e;
    }

    $this->log('END ['.$this->entityName.']BaseData::index_post()###############################################');
    $this->response($data,200);
  }

  protected function prePost(){
    return null;
  }

  protected function mainPost($preEntity){
    $entity = $this->mainPostWithData($this->_post_args);
    $aid = $this->getAid();
    if($aid){
      $entity->setAid($this->em->find("Account",$aid));
    }
    $this->em->persist($entity);
    return $entity;
  }

  public function mainPostWithData($arrayData){
    $entity = $this->createEntity();
    $entity = $this->toEntity($entity,$arrayData);
    $entity = $this->setCreateControlData($entity);
    return $entity;
  }

  protected function setCreateControlData($entity){
    $entity->setCreatedate(new DateTime("now"));
    if($this->authUser != null){
      $entity->setCreateuser($this->authUser->id);
    }
    return $entity;
  }

  protected function postPost($mainEntity){
    return $mainEntity;
  }

  public function index_put()
  {
    $this->log('START ['.$this->entityName.']BaseData::index_put()---------------------------------------------');
    if(!$this->checkAuth()) return;
    $this->log('argurment:'.json_encode($this->_put_args));
    $this->log('entityName:'.$this->entityName);

    try{
      $preEntity = $this->prePut();
      $mainEntity = $this->mainPut($preEntity);
      $this->postPut($mainEntity);
      $this->em->flush();

      $this->em->refresh($mainEntity);
      $data = $this->fetchEntityReturnData($mainEntity);

    }catch (Exception $e) {
      $this->error($e);

      $this->log("reutrn : error");
      $this->log('END ['.$this->entityName.']BaseData::index_post()###############################################');

      $this->response(array('error' => 'Exception-['.$e->getMessage().'].'),500);
      throw $e;
    }

    $this->log('END ['.$this->entityName.']BaseData::index_put()###############################################');
    $this->response($data,200);
  }

  protected function prePut(){
    return null;
  }

  protected function mainPut($preEntity){
    $entity = $this->mainPutWithData($this->_put_args);
    $aid = $this->getAid();
    if($aid){
      $entity->setAid($this->em->find("Account",$aid));
    }
    return $entity;
  }

  public function mainPutWithData($arrayData){
    $entity = $this->fetchEntity($arrayData);
    $entity = $this->toEntity($entity,$arrayData);
    $entity = $this->setUpdateControlData($entity);
    return $entity;
  }

  protected function setUpdateControlData($entity){
    $entity->setUpdatedate(new DateTime("now"));
    if($this->authUser != null){
      $entity->setUpdateuser($this->authUser->id);
    }
    return $entity;
  }

  protected function postPut($mainEntity){
    return $mainEntity;
  }

  public function index_delete()
  {
    $this->log('START ['.$this->entityName.']BaseData::index_delete()---------------------------------------------');
    if(!$this->checkAuth()) return;

    $this->log('argurment:'.json_encode($this->_delete_args));

    try{

      $preEntity = $this->preDelete($this->em->find($this->entityName,$this->get("id")));
      $mainEntity = $this->mainDelete($preEntity);
      $this->postDelete($mainEntity);
      $this->em->flush();
      $data = $this->toArray($mainEntity);

    }catch (Exception $e) {
      $this->error($e);

      $this->log("reutrn : error");
      $this->log('END ['.$this->entityName.']BaseData::index_post()###############################################');

      $this->response(array('error' => 'Exception-['.$e->getMessage().'].'),500);
      throw $e;
    }

    $this->log('END ['.$this->entityName.']BaseData::index_delete()###############################################');
    $this->response($data,200);
  }

  protected function preDelete($entity){
    return $entity;
  }

  protected function mainDelete($preEntity){
    if($preEntity == null){
      $preEntity = $this->em->find($this->entityName,$this->get("id"));
    }

    $preEntity->setValid("N");
    $preEntity = $this->setUpdateControlData($preEntity);

    return $preEntity;
  }

  protected function postDelete($mainEntity){
    return null;
  }

  protected function deleteChildren($children){
    foreach($children as $child){
      $child->setValid('N');
      $child = $this->setUpdateControlData($child);
    }
  }

  public function data_get(){
    $this->log('###############BaseData::data_get()###############');
    return $this->index_get();
  }

  public function data_post(){
    $this->log('###############BaseData::data_post()###############');
    return $this->index_post();
  }

  public function data_put(){
    $this->log('###############BaseData::data_put()###############');
    return $this->index_put();
  }

  public function data_delete(){
    $this->log('###############BaseData::data_delete()###############');
    return $this->index_delete();
  }

  public function toArray($entity){
    return $this->toArrayWithInfo($entity,$this->entityInfo);
  }
  public function toEntity($entity,$arrayEntity){
    return $this->toEntityWithInfo($entity,$arrayEntity,$this->entityInfo);
  }
  public function toList($data){
    $items = array();
    if(count($data) == 0) return $items;

    foreach($data as $item){
      if(is_array($item)){
        $items[] = $this->toList($item);
      }else{
        if($item->getValid()=="Y"){
          $items[] = $this->toArray($item);
        }
      }
    }
    return $items;
  }

  private function toArrayWithInfo($entity,$entityInfo){
    $result = array();

    if($entity != null){
      foreach($entityInfo as $field => $type){
        if($type == "" || in_array($type,$this->primitiveType)){
          $method = sprintf('get%s', ucwords(strtolower($field)));
          $result[$field] = $entity->$method();
        }else{
          $method = sprintf('get%s', ucwords(strtolower($field)));
          $object = $entity->$method();
          if($object != null){
            $method = "getId";
            $result[$field] = $object->$method();
          }
        }
      }
    }

    return $result;
  }

  private function toEntityWithInfo($entity,$arrayEntity,$entityInfo){
    if($entity != null){
      foreach($entityInfo as $field => $type){
        if($field == "id") continue;
        if(isset($arrayEntity[$field])){
          $fieldName = strtolower($field);
          $method = sprintf('set%s', ucwords($fieldName));
          if($type == ""){
            $entity->$method($arrayEntity[$field]);
          }else if(in_array($type,$this->primitiveType)){
            if($type == "Boolean"){
              if(gettype($arrayEntity[$field]) == "boolean"){
                if($arrayEntity[$field]){
                  $entity->$method('Y');
                }else{
                  $entity->$method('N');
                }
              }else{
                if(in_array($arrayEntity[$field],array("1","Y"))){
                  $entity->$method('Y');
                }else{
                  $entity->$method('N');
                }
              }
            }else if($type == "Date"){
              $pos = strrpos($arrayEntity[$field],"/");
              if($pos){
                $date = DateTime::createFromFormat("d/m/Y",$arrayEntity[$field]);
                $fmtdate = $date->format('Y-m-d');
                $entity->$method($fmtdate);
              }else{
                $entity->$method($arrayEntity[$field]);
              }
            }else{
              $entity->$method($arrayEntity[$field]);
            }
          }else{
            $typeEntity = $this->em->find($type,$arrayEntity[$field]);
            if($typeEntity){
              $entity->$method($typeEntity);
            }
          }
        }
      }
    }

    return $entity;
  }

  protected function createEntity(){
    return new $this->entityName;
  }

  protected function fetchEntity($arrayEntity){
    $this->log("argument:".json_encode($arrayEntity));

    if(isset($arrayEntity["id"]) && $arrayEntity["id"] != null){
      $entity = $this->em->find($this->entityName,$arrayEntity["id"]);
    }else{
      $entity = new $this->entityName;
    }

    if(isset($arrayEntity["pid"])){
      $entity->setPid($this->em->find($this->entityName,$arrayEntity["pid"]));
    }

    return $entity;
  }

}
