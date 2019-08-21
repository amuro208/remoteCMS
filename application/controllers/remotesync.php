<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/doctrinautoload.php';
require_once APPPATH . 'libraries/Application.php';

class RemoteSync extends DoctrinAutoload
{
  private $previousId;
  function __construct($parameters=array())
  {
      parent::__construct(array("NoAuthCheck"=>"Y"));
      $this->previousId = "";
      
      if (function_exists("set_time_limit") == TRUE AND @ini_get("safe_mode") == 0)
      {
        log_message("debug","###set_time_limit in remotesync###");
        @set_time_limit(7200);
      }
  }

  //OPTIONS
  //EVENT_remotesync : [Y|N]
  //EVENT_uploadmethod : [post|ftp]
  //lateupload_delayseconds
  public function index(){
      log_message("debug","========================================================================================");
      log_message("debug","=======================START REMOTE SYNC==============================");
      log_message("debug","======================================================================");

      $processing = Application::getVar('app_level_remotesync');
      log_message("debug","+++processing:".$processing."+++");
      if ($processing !== false){
        if($processing == "Y"){
          $lasttime = Application::getVar('app_level_remotesync_time'); 
          if($lasttime !== false){
            if(time() - $lasttime < 180){
              log_message("debug","###The process is still doing - Application.###");
              log_message("debug","========================================================================================");
              return ;
            }
          }
        }
      }

      Application::setVar('app_level_remotesync', "Y");
      Application::setVar('app_level_remotesync_time', time());

      $data = $this->getNextSyncData();
      if($data !== false){
        $this->startRemoteSync($data);
        log_message("debug","NextRemoteSyncData:".$data->getId());
      }else{
        log_message("debug","###The process is still doing - Database.###");
        log_message("debug","========================================================================================");
      }
      
      while($data !== false){
        try{
          $this->processRemoteSync($data);
          Application::setVar('app_level_remotesync_time', time());

          $eventCode = $data->getEventcode(); 

          //Check if or not using remote sync.
          log_message("debug","###Check if skipping remotesync.");
          $syncoption = $this->getOptionValue($eventCode."_remotesync");
          if($syncoption !== false && $syncoption == "N"){
            log_message("debug","###PASS REMOTE SYCN###");
            $this->errorRemoteSync($data);
            $data = $this->getNextSyncData(true);
            continue;
          }

          //Check if or not late upload.
          log_message("debug","###Check if late upload.");
          if(!$this->doLateUpload($data)){
            $this->errorRemoteSync($data);
            $data = $this->getNextSyncData(true);
            continue;       
          }

          $params = array();

          log_message("debug","###Check if uploading via FTP.");
          $uploadmethod = $this->getOptionValue($eventCode."_uploadmethod");
          if($uploadmethod === false || $uploadmethod == ""){
            $uploadmethod = "post";
          }

          log_message("debug","###loading files...");
          $medias = $data->getMedias(); 
          $hasError = false;
          foreach($medias as $media){
            //if($uploadmethod == "ftp" && $media->getMimetype()=="video/mp4"){
            if($uploadmethod == "ftp"){
              $filePath = $this->localUploadPath.$media->getFilepath();
              if(!$this->sendData2ServerViaFTP($filePath)){
                log_message("error","Could not transfer a file via FTP-".$media->getFilePath());
                $this->errorRemoteSync($data);
                $hasError = true;
                $data = $this->getNextSyncData();
                break;       
              }
            }else{ 
              $filePath = $this->localUploadPath.$media->getFilepath();
              $mimeType = $this->getMimetype($media->getFilename());
              $fileName = $media->getFilename();
              log_message("debug","typeCode:".$media->getTypecode());
              log_message("debug","filePath:".$filePath);
              log_message("debug","mimeType:".$mimeType);
              log_message("debug","fileName:".$fileName);
              $params[$media->getTypecode()] = new CURLFile($filePath,$mimeType,$fileName);
            }
          }
          if($hasError){
            continue;
          }
          log_message("debug","======================================================================");
          log_message("debug","==========================REMOTE SYNC=================================");
          log_message("debug","###files are loaded...");
          log_message("debug","======================================================================");

          $params["siteCode"] = $data->getSitecode();
          $params["eventCode"] = $data->getEventcode();
          $params["firstName"] = $data->getFirstName();
          $params["lastName"] = $data->getLastName();
          $params["phone"] = $data->getPhone();
          $params["mobile"] = $data->getMobile();
          $params["zipCode"] = $data->getZipcode();
          $params["email"] = $data->getEmail();
          $params["gameCode"] = $data->getGamecode();
          $params["teamCode"] = $data->getTeamcode();
          $params["teamPlayerCode"] = $data->getTeamplayercode();
          $params["reserve1"] = $data->getReserve1();
          $params["reserve2"] = $data->getReserve2();
          $params["reserve3"] = $data->getReserve3();
          $params["reserve4"] = $data->getReserve4();
          $params["reserve5"] = $data->getReserve5();
          $params["localId"] = $data->getId();
          $params["localSiteCode"] = $data->getSitecode();
          $params["localCreateDate"] = $data->getCreatedate()->format('Y-m-d H:i:s');

          $localRfidScans = $data->getLocalRFIDScans();
          if($localRfidScans != null){
            $rfid = "";
            foreach($localRfidScans as $item){
              $rfid .= $item->getRfid();
              $rfid .= ",";
            };
            $rfid = substr($rfid,0,strlen($rfid)-1);
            $params["localRFIDs"] = $rfid;
          }

          $copyVideoId = $this->getOptionValue($data->getEventcode()."_copy_videoId");
          if($copyVideoId === false) $copyVideoId = "Y";
          //if($copyVideoId != "Y"){  
          if($copyVideoId != "Y" || $uploadmethod == "ftp"){
            $params["videoId"] = $data->getVideoid();
          }

          $copyPhotoId = $this->getOptionValue($data->getEventcode()."_copy_photoId");
          if($copyPhotoId === false) $copyPhotoId = "Y";
          //if($copyPhotoId != "Y"){
          if($copyPhotoId != "Y" || $uploadmethod == "ftp"){
            $params["photoId"] = $data->getPhotoid();
          }
          
          log_message("debug","======================================================================");
          log_message("debug","==========================REMOTE SYNC=================================");
          log_message("debug","###params loaded...");
          log_message("debug","======================================================================");

          $postUrl = $this->getOptionValue("upload_url");
          log_message("debug","postUrl:".$postUrl);
          $response = $this->sendData2ServerViaPost($postUrl,$params);
          log_message("debug","response:".$response);

          //Result
          $response = json_decode(trim($response));
          if($response != false){
            if($response->Result == "OK"){
              log_message("debug","======================================================================");
              log_message("debug","==========================REMOTE SYNC=================================");
              log_message("debug","Remote Sync is successful.");
              log_message("debug","======================================================================");
              $this->completeRemoteSync($data);
            }else{
              log_message("error","======================================================================");
              log_message("error","==========================REMOTE SYNC=================================");
              log_message("error","Remote Sync is failed.");
              log_message("error","======================================================================");
              $this->errorRemoteSync($data);
            }
          }else{
            log_message("error","======================================================================");
            log_message("error","==========================REMOTE SYNC=================================");
            log_message("error","Remote Sync is failed.");
            log_message("error","======================================================================");
            $this->errorRemoteSync($data);
          }

        }catch(Exception $e){
          log_message("error","======================================================================");
          log_message("error","==========================REMOTE SYNC=================================");
          log_message("error","Remote Sync Exception : ".$e->getMessage());
          log_message("error","======================================================================");
          $this->errorRemoteSync($data);
          break;
        }

        $data = $this->getNextSyncData(true);
        if($data !== false){
          log_message("debug","NextRemoteSyncData:".$data->getId());
        }
      }
      
      $this->finishRemoteSync();

      Application::setVar('app_level_remotesync', "N");
      Application::setVar('app_level_remotesync_time', 0);

      log_message("debug","======================================================================");
      log_message("debug","========================END REMOTE SYNC===============================");
      log_message("debug","========================================================================================");
  }
            
  private function doLateUpload($data){
    //Check late upload...
    log_message("debug","@@@@doLateUpload@@@@");
    $option = $this->getOptionValue($data->getEventcode()."_late_upload");
    if($option !== false && $option == "Y"){
      //Check waiting time.
      $delayTime = $this->getOptionValue("lateupload_delayseconds");
      if($delayTime === false) $delayTime = 30;
      $cdate = $data->getCreatedate();
      log_message("debug","cdate createdate:".$cdate->getTimestamp());
      log_message("debug","current createdate:".$this->currentTime->getTimestamp());
      if(abs($this->currentTime->getTimestamp() - $cdate->getTimestamp()) < $delayTime){
        log_message("error","Time is not yet up.");
        return false;
      }       

      //VideoId
      if($data->getVideoid() != null && $data->getVideoid() != ""){
        $copyVideoId = $this->getOptionValue($data->getEventcode()."_copy_videoId");
        if($copyVideoId === false) $copyVideoId = "Y";
        if($copyVideoId == "Y"){
          log_message("debug","@@@@copyMedia-Video@@@@");
          if(!$this->copyMedia($data,"videoId",$data->getVideoid())){
            return false;
          }
        }
      }

      //PhotoId
      if($data->getPhotoid() != null && $data->getPhotoid() != ""){
        $copyPhotoId = $this->getOptionValue($data->getEventcode()."_copy_photoId");
        if($copyPhotoId === false) $copyPhotoId = "Y";
        if($copyPhotoId == "Y"){
          $photoIds = explode(",",$data->getPhotoid()); 
          if(count($photoIds) > 1){
            $index = 1;
            $hasError = false;
            foreach($photoIds as $photoId){
              log_message("debug","@@@@copyMedia-Photo@@@@");
              if(!$this->copyMedia($data,"photoId".$index,$photoId)){
                $hasError = true;
                break;
              }
              $index++;
            }
            if($hasError){
              log_message("error","Media file is still not valid.");
              return false;
            }
          }else{
            if(!$this->copyMedia($data,"photoId",$data->getPhotoid())){
              log_message("error","Media file is still not valid.");
              return false;
            }
          }
        }
      }
      log_message("debug","@@@@doLateUpload@@@@");
    }

    return true;
  }

  private function getNextSyncData($skip=false){
      log_message("debug","###getNextSyncData-----------------------1###");
      if(!$skip){
        $optionvalue = $this->getOptionValue('begin_remotesync');
        log_message("debug","begin_remotesync:".$optionvalue);
        if($optionvalue !== false){
          if($optionvalue == "1"){
            $optionvalue = $this->getOptionValue('begin_remotesync_time');
            log_message("debug","begin_remotesync_time:".$optionvalue);
            if($optionvalue !== false){
              log_message("debug","Time DIFF:".(time() - $optionvalue));
              if(time() - $optionvalue < 180){
                return false;
              }else{
                //Retore processing data.
                $qb = $this->em->createQueryBuilder();
                $qb->select('u')->from('Localuser','u')
                                ->where("u.valid = 'Y'")
                                ->andWhere("u.isremotesynced = 'P'");
                $query = $qb->getQuery();
                $results = $query->getResult();
                foreach($results as $result){
                  $result->setIsremotesynced('N');
                  $this->em->persist($result);
                }
                $this->em->flush();
              }
            }
          }
        }else{
          log_message("error","There is no option 'begin_remotesync'");
          log_message("error","There is no option 'begin_remotesync_time'");
          return false;
        }
      }

      try{
        $qb = $this->em->createQueryBuilder();

        if($this->previousId == ""){
          $qb->select('u')->from('Localuser','u')
             ->where("u.valid = 'Y'")
             ->andWhere("u.isremotesynced = 'N'")
             ->andWhere("u.isapproved = 'Y'")
             ->orderBy("u.id","ASC")
             ->setMaxResults(1);
        }else{
          $qb->select('u')->from('Localuser','u')
             ->where("u.valid = 'Y'")
             ->andWhere("u.isremotesynced = 'N'")
             ->andWhere("u.isapproved = 'Y'")
             ->andWhere("u.id > ".$this->previousId)
             ->orderBy("u.id","ASC")
             ->setMaxResults(1);
        }

        $query = $qb->getQuery();
        log_message("debug",$query->getSQL());
        $results = $query->getResult();
        $data = null;
        foreach($results as $result){
          $data = $result;
          break;
        }
        if($data == null) return false;

      }catch(Exception $e){
        log_message("error",$e->getMessage());
        return false;
      }

      $this->previousId = $data->getId();

      log_message("debug","###getNextSyncData-----------------------2###");
      return $data;
  }

  private function startRemoteSync($data){
    $option_name = 'begin_remotesync' ;
    $new_value = '1';
    $this->updateOption( $option_name, $new_value );

    $option_name = 'begin_remotesync_time' ;
    $new_value = time();
    $this->updateOption( $option_name, $new_value );
  }

  private function processRemoteSync($data){
    $data->setIsremotesynced('P');
    $this->em->persist($data);
    $this->em->flush();
  }

  private function completeRemoteSync($data){
    $data->setIsremotesynced('Y');
    $this->em->persist($data);
    $this->em->flush();
  }

  private function errorRemoteSync($data){
    $this->updateOption('begin_remotesync', '0');
    $this->updateOption('begin_remotesync_time', '');
    $data->setIsremotesynced('N');
    $this->em->persist($data);
    $this->em->flush();
  }

  private function finishRemoteSync(){
    $this->updateOption('begin_remotesync', '0');
    $this->updateOption('begin_remotesync_time', '');
  }
}
