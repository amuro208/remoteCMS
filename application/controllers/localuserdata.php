<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/api/basedata.php";

class LocalUserData extends BaseData
{
    function __construct($parameters=array())
    {
        parent::__construct($parameters);
        $this->entityName = "Localuser";

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
          "isApproved"      =>"Boolean",
          "approvedDate"    =>"String",
          "approvedUser"    =>"Number",
          "isRemoteSynced"  =>"Boolean"
        );
    }

    protected function fetchEntityReturnData($entity){
      $data = $this->toArray($entity);
      $medias = $entity->getMedias();
      $files = array();
      $index = 1;
      foreach($medias as $media){
        $file = array(
          "id"=>$media->getId(),
          "fileName"=>$media->getFilename(),
          "filePath"=>$media->getFilepath(),
          "mimeType"=>$media->getMimetype()
        );
        $files[] = $file;
        $data["file".$index]="/codeigniter/localuploads/".$media->getFilepath();

        $value = $this->getOptionValue($entity->getEventCode()."_make_localthumbnail");
        if( false != $value && "Y" == $value){
          $thumbFilePath = $media->getThumbfilepath();

          if( null == $thumbFilePath ||  "" == $thumbFilePath){
            $thumbFilePath = $this->make_localthumbnail($media);
          }
          
          if(false != $thumbFilePath && $thumbFilePath != null && "" != $thumbFilePath ){
            $data["thumbfile".$index]="/codeigniter/localuploads/".$thumbFilePath;
            $data["usethumbnail".$index] = "Y";
          }
        }

        $index++;
      }

      $data["files"] = $files;
      return $data;
    }

    protected function addWhere($qb,$filter){
      $maxId = $this->getOptionValue("max_local_maderated_id");
      if($this->get("maderation") == "y"){
        if($maxId === false){
          $maxId = 0;
        }
        $qb->andWhere("e.id > $maxId");
        $qb->andWhere("e.isapproved = 'N'");
      }

      return $qb;
    }

    public function playvideo_get(){
      $data["vid"] = $this->get("id");
      $localmedia = $this->em->find("Localmedia",$this->get("id"));
      //echo $this->get("id");
      $data["vurl"] = "/codeigniter/localuploads/".$localmedia->getFilepath();
      $this->load->view('playvideo',$data);
    }

    public function maderate_get(){
      $maxid = $this->get("maxid");
      $this->updateOption("max_local_maderated_id",$maxid);
      $maxid = $this->getOptionValue("max_local_maderated_id");
      echo json_encode(array("result"=>"OK","maxid"=>$maxid));
    }
}
