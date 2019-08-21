<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/doctrinautoload.php';
//require_once APPPATH . 'controllers/sendemail.php';

class Remote extends DoctrinAutoload
{
  private $previousId;
  function __construct($parameters=array())
  {
      parent::__construct(array("NoAuthCheck"=>"Y"));
      $this->previousId = "";
  }

  public function index(){
      ob_start();

      log_message("debug","++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");
      log_message("debug","+++++++++++++++++++++++START REMOTE++++++++++++++++++++++++++++++");
      log_message("debug","+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");
      log_message("debug","+++++++++++++++++++++++CHECK INPUT+++++++++++++++++++++++++++++++");
      log_message("debug",json_encode($this->input));
      log_message("debug","+++++++++++++++++++++++CHECK _POST+++++++++++++++++++++++++++++++");
      log_message("debug",json_encode($_POST));
      log_message("debug","+++++++++++++++++++++++CHECK _FILES+++++++++++++++++++++++++++++++");
      log_message("debug",json_encode($_FILES));
      log_message("debug","++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");

      //Check if or not synced.
      $qb = $this->em->createQueryBuilder();
      $qb->select('count(u.id)')
         ->from('User','u')
         ->where("u.valid = 'Y'")
         ->andWhere("u.eventcode = '".$this->input->post("eventCode")."'")
         ->andWhere("u.projectcode = '".$this->input->post("projectCode")."'")
         ->andWhere("u.localsitecode = '".$this->input->post("localSiteCode")."'")
         ->andWhere("u.localid = '".$this->input->post("localId")."'")
         ->andWhere("u.isapproved = 'Y'");
      $query = $qb->getQuery();

      log_message("debug",$query->getSQL());

      $count = $qb->getQuery()->getSingleScalarResult();
      $user = new User();

      if($count >= 1){
        log_message("debug","------------------------------------------------");
        log_message("debug","This data has already synced.");
        log_message("debug","------------------------------------------------");
      }else{

        $user->setSitecode($this->input->post("siteCode"));
        $user->setEventcode($this->input->post("eventCode"));
        $user->setProjectcode($this->input->post("projectCode"));
        $user->setFirstname($this->input->post("firstName"));
        $user->setLastname($this->input->post("lastName"));
        $user->setPhone($this->input->post("phone"));
        $user->setMobile($this->input->post("mobile"));
        $user->setZipcode($this->input->post("zipCode"));
        $user->setEmail($this->input->post("email"));
        $user->setVideoid($this->input->post("videoId"));
        $user->setPhotoid($this->input->post("photoId"));
        $user->setGamecode($this->input->post("gameCode"));
        $user->setTeamcode($this->input->post("teamCode"));
        $user->setTeamplayercode($this->input->post("teamPlayerCode"));
        $user->setReserve1($this->input->post("reserve1"));
        $user->setReserve2($this->input->post("reserve2"));
        $user->setReserve3($this->input->post("reserve3"));
        $user->setReserve4($this->input->post("reserve4"));
        $user->setReserve5($this->input->post("reserve5"));
        $user->setLocalid($this->input->post("localId"));
        $user->setLocalsitecode($this->input->post("localSiteCode"));
        $date = DateTime::createFromFormat("Y-m-d H:i:s",$this->input->post("localCreateDate"));
        $user->setLocalcreatedate($date);
        $user->setCreatedate($this->currentTime);

        $this->config->load($this->getConfigPath($user));

        //Auto Approval
        $value = $this->config->item("auto_approval");
        if($value != null && $value == "N"){
          $user->setIsapproved("N");
        }else{
          $user->setIsapproved("Y");
        }

        //if the system is in manual upload mode, check reserve1
        $manualUpload = $this->config->item("manual_upload");
        if( "Y" == $manualUpload){
          if($user->getReserve1() == "Y"){
            $user->setIsapproved("N");
          }
        }

        //Check if there is the folder for this contents.
        log_message("debug",$this->uploadPath);
        log_message("debug","DEBUG 1 ");
        $folder = $user->getProjectcode()."-".$user->getEventcode();
        log_message("debug","DEBUG 2 ".$folder);
        $fdate = date('Y-m-d');
        log_message("debug","DEBUG 3 ".$fdate);

        if(file_exists($this->uploadPath)){
          if(!file_exists($this->uploadPath.$folder)){
            mkdir($this->uploadPath.$folder);
          }
          if(!file_exists($this->uploadPath.$folder."/".$fdate)){
            mkdir($this->uploadPath.$folder."/".$fdate);
          }
        }else{
          mkdir($this->uploadPath);
          mkdir($this->uploadPath.$folder);
          mkdir($this->uploadPath.$folder."/".$fdate);
        }

        //videoId upload from ftp --------------------------------------
        $media = null;
        $mediaFile = null;
        $uploadmethod = $this->config->item($user->getEventcode()."_uploadmethod");
        if($user->getVideoid() != null && $user->getVideoid() != ""){
          $videoId = $user->getVideoid();
          $mediaFile = $this->uploadPath.$videoId.".mp4";
          if($this->waitFor($mediaFile)){
            copy($mediaFile, $this->uploadPath.$folder."/".$fdate."/".$videoId.".mp4");

            $media = new Media();
            $media->setUserid($user);
            $media->setTypecode("videoId");
            $media->setFilepath($folder."/".$fdate."/".$videoId.".mp4");
            $media->setFilename($videoId.".mp4");
            $media->setMimetype($this->getMimetype($videoId.".mp4"));
            $media->setCreatedate($this->currentTime);
            $this->em->persist($media);
            //$value = $this->config->item("make_remotethumbnail");
            //if(false != $value && "Y" == $value){
            //  $this->make_thumbnail($media);
            //}
            unlink($mediaFile);
          }else{
            log_message("error","There is no file or being copied for $mediaFile on ".$this->uploadPath);
            $this->printErrorMessage("There is no file or being copied for $mediaFile on ".$this->uploadPath);
            return;
          }
          //VideoId_edm...

          $hasEDM = $this->config->item("has_edm");
          if($hasEDM !== false && $hasEDM == "Y"){
              $mediaFile = $this->uploadPath.$videoId."_edm.png";
              if( $this->waitFor($mediaFile) ){
                copy($mediaFile, $this->uploadPath.$folder."/".$fdate."/".$videoId.".png");

                $media = new Media();
                $media->setUserid($user);
                $media->setTypecode("videoId_edm");
                $media->setFilepath($folder."/".$fdate."/".$videoId.".png");
                $media->setFilename($videoId.".png");
                $media->setMimetype($this->getMimetype($videoId.".png"));
                $media->setCreatedate($this->currentTime);
                $this->em->persist($media);
                $value = $this->config->item("make_remotethumbnail");
                if(false != $value && "Y" == $value){
                  $this->make_thumbnail($media);
                }
                unlink($mediaFile);

              }else{
                log_message("error","There is no file or being copied for $mediaFile on ".$this->uploadPath);
                $this->printErrorMessage("There is no file or being copied for $mediaFile on ".$this->uploadPath);
                return;
              }
            }
          }

        //gif photo upload from ftp --------------------------------------

        if($user->getPhotoid() != null && $uploadmethod == "ftp"){
          $photoIds = explode(",",$user->getPhotoid());
          $index = 0;
          foreach($photoIds as $photoId){
            if(count($photoIds) == 1){
              $index = "";
            }else{
              $index++;
            }

            $mediaFile = $this->uploadPath.$photoId.".gif";
            log_message("debug","###mediaFile:".$mediaFile);
            if($this->waitFor($mediaFile)){
              //Copy the file into CMS.
              copy($mediaFile, $this->uploadPath.$folder."/".$fdate."/".$photoId.".gif");

              $media = new Media();
              $media->setUserid($user);
              $media->setTypecode("photoId".$index);
              $media->setFilepath($folder."/".$fdate."/".$photoId.".gif");
              $media->setFilename($photoId.".gif");
              $media->setMimetype($this->getMimetype($photoId.".gif"));
              $media->setCreatedate($this->currentTime);
              $value = $this->config->item("make_remotethumbnail");
              if(false != $value && "Y" == $value){
                $this->make_thumbnail($media);
              }
              $this->em->persist($media);
              unlink($mediaFile);

            }else{
              log_message("error","There is no file or being copied for $mediaFile on ".$this->uploadPath);
              $this->printErrorMessage("There is no file or being copied for $mediaFile on ".$this->uploadPath);
              return;
            }
         }

         $hasEDM = $this->config->item("has_edm");
         if($hasEDM !== false && $hasEDM == "Y"){
           $mediaFile = $this->uploadPath.$photoId."_edm.png";
           if($this->waitFor($mediaFile)){
             //Copy the file into CMS.
             copy($mediaFile, $this->uploadPath.$folder."/".$fdate."/".$photoId.".png");

             $media = new Media();
             $media->setUserid($user);
             $media->setTypecode("photoId".$index."_edm");
             $media->setFilepath($folder."/".$fdate."/".$photoId.".png");
             $media->setFilename($photoId.".png");
             $media->setMimetype($this->getMimetype($photoId.".png"));
             $media->setCreatedate($this->currentTime);

             $value = $this->config->item("make_remotethumbnail");
             if(false != $value && "Y" == $value){
               $this->make_thumbnail($media);
             }
             $this->em->persist($media);
             unlink($mediaFile);

           }else{
             log_message("error","There is no file or being copied for $mediaFile on ".$this->uploadPath);
             $this->printErrorMessage("There is no file or being copied for $mediaFile on ".$this->uploadPath);
             return;
           }
        }
       }

        //gif photo upload from ftp --------------------------------------

        //Upload from post----------------------------------------------
        if(count($_FILES) > 0){
          $config['upload_path'] = $this->uploadPath.$folder."/".$fdate;
          $config['allowed_types'] = 'gif|jpg|jpeg|png|mp4';
          $config['overwrite'] = false;
          $config['max_size']	= 1024*10;
          //$config['max_width']  = '1024';
          //$config['max_height']  = '768';
          $this->load->library('upload', $config);
          $this->upload->initialize($config);

          foreach($_FILES as $key => $value){
            try{
              if (!$this->upload->do_upload($key)){
                log_message("error",$this->upload->display_errors());
                $this->printErrorMessage("Could not upload file : ".$key." ".$this->upload->display_errors());
                return;
              }else{
                $data = $this->upload->data();

                $media = new Media();
                $media->setUserid($user);
                $media->setTypecode($key);
                $media->setFilepath($folder."/".$fdate."/".$data["file_name"]);
                $media->setFilename($data["file_name"]);
                $media->setMimetype($data["file_type"]);
                $media->setCreatedate($this->currentTime);
                $this->em->persist($media);

                $value = $this->config->item("make_remotethumbnail");
                if(false != $value && "Y" == $value){
                  $this->make_thumbnail($media);
                }

                log_message("debug","+++".$key." is uploaded.");
              }
            }catch(Exception $e){
              log_message("error",$e->getMesssage());
              $this->printErrorMessage("Could not upload file : ".$e->getMessage());
              return;
            }
          }
        }


        //Upload from post----------------------------------------------

        //Link RFID-----------------------------------------------------
        if($media != null){
          $localRFIDs = $this->input->post("localRFIDs");
          if(isset($localRFIDs)){
            $rfids = explode(",",$localRFIDs);
            foreach($rfids as $rfid){
              $tag = $this->em->getRepository("Rfid")->findOneBy(array(
                "valid"=>"Y",
                "rfid"=>$rfid
              ));

              if($tag != null){
                $rfidscan = new Rfidscan();
                $rfidscan->setRfidid($tag);
                $rfidscan->setUserid($user);
                $rfidscan->setMediaid($media);
                $rfidscan->setCreatedate($this->currentTime);

                $this->em->persist($rfidscan);
              }
            }
          }
        }
        //Link RFID-----------------------------------------------------

        $this->em->persist($user);
        $this->em->flush();


      $this->printSuccessMessage();

      log_message("debug","+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");
      log_message("debug","++++++++++++++++++++++++END REMOTE+++++++++++++++++++++++++++++++");
      log_message("debug","++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");

      $size = ob_get_length();
      header("Content-Length: $size");
      header('Connection: close');
      header("Content-Encoding: none");
      if( ob_get_level() > 0 )
      {
          ob_end_flush();
          ob_get_level()? ob_flush():null;
          flush();
      }

      $eventCode = $this->input->post("eventCode");
      log_message("debug","++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");
      log_message("debug","++++++++++++++++++++++++START AFTER REMOTE[$eventCode]++++++++++++++++++++++++++++++#");

      $cmsHomeUrl = $this->config->item("cms_home_url");

      //if the system is in manual upload mode, check reserve1
      $manualUpload = $this->config->item("manual_upload");
      //$param = array();
      //$param["em"] = $this->em;
      //$sendEmailCtrl = new SendEmail($param);

      $returnContents = false;
      if( "Y" == $manualUpload){
        if($user->getReserve1() != "Y"){
          log_message("debug","Trying to send an email");
          log_message("debug",$cmsHomeUrl."sendemail/standard/".$user->getId());
          $returnContents = file_get_contents($cmsHomeUrl."sendemail/standard/".$user->getId());
          //$sendEmailCtrl->send($user->getId());
        }else{
          log_message("debug","Sending email later.");
          $returnContents = "OK";
        }
      }else{
        log_message("debug","Trying to send an email");
        log_message("debug",$cmsHomeUrl."sendemail/standard/".$user->getId());
        $returnContents = file_get_contents($cmsHomeUrl."sendemail/standard/".$user->getId());
        //$sendEmailCtrl->send($user->getId());
      }

      if($returnContents === false || $returnContents == "" || $returnContents != "OK"){
        log_message("error","###################################################");
        log_message("error","Can't call the url for sending email");
        log_message("error",$returnContents);
        log_message("error","###################################################");
      }

      /*
      //upload Video to Youtube.
      $sendsns = new Sendsns();
      $sendsns->setUserid($user);
      $sendsns->setSnstypecode("Youtube");
      $sendsns->setIssent('P');
      $sendsns->setCreatedate($this->currentTime);
      $this->em->persist($sendsns);
      $this->em->flush();
      //Youbut Upload
      $response = file_get_contents($cmsHomeUrl."youtube/upload/".$user->getId());

      //Flickr Upload
      //file_get_contents($cmsHomeUrl."flickr/upload/".$user->getId());

      //log_message("debug","++++ $response ++++");
      //log_message("debug","++++ Finish uploading to Flickr ++++");
      //log_message("debug","++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");


      if(trim($response) == "OK"){
        //Sending Email To
        file_get_contents($cmsHomeUrl."sendemail/standard/".$user->getId());
        log_message("debug","++++ Finish sending an email ++++");
        log_message("debug","++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");
      }

      */

      log_message("debug","++++++++++++++++++++++++END AFTER REMOTE[$eventCode]++++++++++++++++++++++++++++++#");
      log_message("debug","++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++");

  }
}
  public function complete(){
      $vid = $this->input->get("vid");
  }

  private function printErrorMessage($msg){
      $result = array(
        "Result"=>"ERROR",
        "Data"=>"",
        "Msg"=>$msg
      );

      echo json_encode($result);
  }

  private function printSuccessMessage(){
      $result = array(
        "Result"=>"OK",
        "Data"=>"",
        "Msg"=>""
      );

      echo json_encode($result);
  }
}
