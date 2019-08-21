<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/api/basedata.php";

class UserData extends BaseData
{
    function __construct($parameters=array())
    {
        //parent::__construct(array("NoAuthCheck"=>"Y"));
        parent::__construct($parameters);
        $this->entityName = "User";
        $this->entityInfo = array(
          "id"              =>"",
          "siteCode"        =>"String",
          "eventCode"       =>"String",
          "firstName"       =>"String",
          "lastName"        =>"String",
          "phone"           =>"String",
          "mobile"          =>"String",
          "zipCode"         =>"String",
          "email"           =>"String",
          "gameCode"        =>"String",
          "teamCode"        =>"String",
          "teamPlayerCode"  =>"String",
          "reserve1"        =>"String",
          "reserve2"        =>"String",
          "reserve3"        =>"String",
          "reserve4"        =>"String",
          "reserve5"        =>"String",
          "videoId"         =>"String",
          "photoId"         =>"String",
          "localid"         =>"Number",
          "localSiteCode"   =>"String",
          "localCreateDate" =>"DateTime",
          "isApproved"      =>"String",
          "approvedDate"    =>"String",
          "approvedUser"    =>"Number",
          "isSentEmail"     =>"Boolean",
          "isSentSNS"       =>"Boolean",
		      "isFavorite"      =>"String",
          "projectCode"     =>"String"
        );
		$em=$this->doctrine->em;
    }

    protected function fetchEntityReturnData($entity){
      $data = $this->toArray($entity);
      $medias = $entity->getMedias();
      $files = array();
      $index = 1;
      foreach($medias as $media){

        if($media->getValid() == "N") continue;

        $file = array(
          "id"=>$media->getId(),
          "fileName"=>$media->getFilename(),
          "filePath"=>$media->getFilepath(),
          "mimeType"=>$media->getMimetype(),
          "typeCode"=>$media->getTypecode(),
        );
        $files[] = $file;
        $data["file".$index]="/framework/uploads/".$media->getFilepath();

        //$value = $this->getOptionValue($entity->getEventcode()."_make_remotethumbnail");
        //if( false != $value && "Y" == $value){
          $thumbFilePath = $media->getThumbfilepath();

          if( null == $thumbFilePath || "" == $thumbFilePath){
            $thumbFilePath = $this->make_thumbnail($media);
          }

          if(false != $thumbFilePath && null != $thumbFilePath &&  "" != $thumbFilePath ){
            $data["thumbfile".$index]="/framework/uploads/".$thumbFilePath;
            $data["usethumbnail".$index] = "Y";
          }
        //}

        $index++;
      }

      $emaillogs = $entity->getEmailLogs();
      $opendata = "";
      $validdata = "";
      $acode = "";
      foreach($emaillogs as $emaillog){
        $opendata .= $emaillog->getIsopened();
        $validdata .= $emaillog->getIsvalidemail();
        $acode = $emaillog->getAccesscode();
      }
      $data["emaillog"] = $opendata."(".$validdata.")";
      $data["acode"] = $acode;
      $data["files"] = $files;

      $data["RDFirstName"] = "Fname";
      $data["RDLastName"] = "Lname";
      $data["RDPhone"] = "None";
      return $data;
    }

    protected function addWhere($qb,$filter){

      if($this->get("projectCode") != null){
        $qb->andWhere("e.projectcode = '".$this->get("projectCode")."'");
      }

      //log_message("debug","this->get(projectId) ::: ".$this->get("projectId"));
      //$this->log(":::::::::::::::::::::::::".$qb->getQuery()->getSQL());

      if($this->get("eventCode") != null && $this->get("eventCode")!="TOTAL" && $this->get("eventCode")!="Maderation"){
        $qb->andWhere("e.eventcode = '".$this->get("eventCode")."'");
      }
      //$this->log(":::::::::::::::::::::::::".$qb->getQuery()->getSQL());

      if($this->get("eventCode") == "Maderation"){
        $maxId = $this->getOptionValue("max_maderated_id");
        if($maxId === false){
          $maxId = 0;
        }
        $qb->andWhere("e.id > $maxId");
        $qb->andWhere("e.isapproved = 'N'");
      }

	  //$qb->andWhere("e.firstname = 'Amuro'");
      return $qb;
    }

    public function playvideo_get(){
      $data["vid"] = $this->get("id");
      $media = $this->em->find("Media",$this->get("id"));
      $data["vurl"] = "/framework/uploads/".$media->getFilepath();
      $this->load->view('remote_playvideo',$data);
    }

    public function maderate_get(){
      $maxid = $this->get("maxid");
      $this->updateOption("max_maderated_id",$maxid);
      $maxid = $this->getOptionValue("max_maderated_id");
      echo json_encode(array("result"=>"OK","maxid"=>$maxid));
    }

    public function batch_delete(){
      $ids = $this->get("ids");
      $ids_arr = explode("_",$ids);

      foreach($ids_arr as $id){
        if(isset($id) && !empty($id)){
          $entity = $this->em->find($this->entityName,$id);
          $entity->setValid("N");
          $entity = $this->setUpdateControlData($entity);
        }
      }
      $this->em->flush();

      echo json_encode(array("result"=>"OK","ids"=>$ids));
    }

    protected function postPut($mainEntity){
      if($mainEntity->getIssentemail() == "N"){
        //Sending Email To
        $cmsHomeUrl = $this->getOptionValue("cms_home_url");
        file_get_contents($cmsHomeUrl."sendemail/standard/".$mainEntity->getId());
      }
      return $mainEntity;
    }

    protected function prePut(){
      unset($this->_put_args["localCreateDate"]);
      unset($this->_put_args["localid"]);
      unset($this->_put_args["localSiteCode"]);
      return null;
    }
}
