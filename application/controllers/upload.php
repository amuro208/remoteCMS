<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/doctrinautoload.php';
require_once APPPATH . 'controllers/remotesync.php';

class Upload extends DoctrinAutoload
{
  function __construct($parameters=array())
  {
      parent::__construct(array("NoAuthCheck"=>"Y"));
      $this->load->helper('form'); //loading form helper
      $this->load->database();
  }

  public function index(){
      ob_start();

      log_message("debug","######################################################################################################");
      log_message("debug","#######################START UPLOAD###############################");
      log_message("debug","##################################################################");
      log_message("debug","#######################CHECK INPUT################################"); 
      log_message("debug",json_encode($this->input));
      log_message("debug","#######################CHECK _POST################################"); 
      log_message("debug",json_encode($_POST));
      log_message("debug","#######################CHECK _FILES###############################"); 
      log_message("debug",json_encode($_FILES));
      log_message("debug","######################################################################################################");

      $user = new Localuser();

      $eventCode = $this->checkEventCode($user);
      if($eventCode === false) return;

      $siteCode = $this->checkSiteCode($user);
      if($siteCode === false) return;

      if($this->checkMustField($user) === false) return;

      $this->makeUserInfo($user);

      if($this->copyVideo($user) === false) return;
      if($this->copyPhoto($user) === false) return;

      $this->em->persist($user);

      if($this->linkRFID($user) === false) return;
      if($this->uploadFile($user) === false) return;

      $this->em->flush();

      //TODO get a ranking for QS,MVP
      $message = "";
      $value = $this->getOptionValue($user->getEventcode()."_use_rank");
      if(false != $value && "Y" == $value){
        $rankquery = $this->getOptionValue($user->getEventcode()."_rank_query");
        $ranklimit = $this->getOptionValue($user->getEventcode()."_rank_limit");
        $currentrank = $this->getOptionValue($user->getEventcode()."_current_rank");
        $currentrankfield = $this->getOptionValue($user->getEventcode()."_current_rank_field");
        $message = $this->getRank($user,$rankquery,$ranklimit,$currentrank,$currentrankfield);
      }

      $this->printSuccessMessage($message);

      log_message("debug","#################################################################");
      log_message("debug","########################END UPLOAD###############################");
      log_message("debug","######################################################################################################");

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

      log_message("debug","######################################################################################################");
      log_message("debug","########################START AFTER UPLOAD[$eventCode]###############################");
      
      //Sending Email To
      $option = $this->getOptionValue($user->getEventcode()."_sendemail_on_upload");
      if(false !== $option && "" != $option){
        $this->load->library('email');
        
        $this->email->from('your@example.com', 'TCS Local CMS');
        $this->email->to($option); 

        $this->email->subject('A media file has uploaded.');
        $this->email->message('Media File ID : '.$this->input->post("photoId"));	

        $this->email->send();
      }
      
      //Remote Sync
      //Waiting for finishing randering video process for 30 seconds.
      /*
      log_message("debug","#################################################################");
      log_message("debug","###################### Waiting for 30 seconds####################");
      log_message("debug","#################################################################");
      for($i=0 ; $i < 30 ; $i++){
        sleep(1);
        log_message("debug","###################### ".(30 - $i)." seconds remain ####################");
      }
      */
      
      log_message("debug","###Call Remote Sync-----------1");
      $this->load->library('../controllers/remotesync'); 
      $this->remotesync->index();
      log_message("debug","###Call Remote Sync-----------2");

      log_message("debug","########################END AFTER UPLOAD[$eventCode]###############################");
      log_message("debug","######################################################################################################");
  }

  private function makeUserInfo($user){
      $user->setFirstname($this->input->post("userFirstName"));
      if($this->input->post("userName")){
          $user->setFirstname($this->input->post("userName"));
      }
      $user->setlastname($this->input->post("userLastName"));
      $user->setEmail($this->input->post("userEmail"));
      
      $userPhone = $this->input->post("userPhone");
      if(isset($userPhone)){
        $user->setPhone($userPhone);
      }
      $userMobile = $this->input->post("userMobile");
      if(isset($userMobile)){
        $user->setMobile($userMobile);
      }
      $userPostcode = $this->input->post("userPostcode");
      if(isset($userPostcode)){
        $user->setZipcode($userPostcode);
      }
      $matchCode = $this->input->post("matchCode");
      if(isset($matchCode)){
        $user->setGamecode($this->input->post("matchCode"));
      }
      $userSelectTeam = $this->input->post("userSelectTeam");
      if(isset($userSelectTeam)){
        $user->setTeamcode($this->input->post("userSelectTeam"));
      }
      $userSelectPlayer = $this->input->post("userSelectPlayer");
      if(isset($userSelectPlayer )){
        $user->setTeamplayercode($this->input->post("userSelectPlayer"));
      }
      
      //Reserved Values.
      $value = $this->getOptionValue($user->getEventcode()."_reserve_field");
      if(false !== $value && "" != $value){
        $fields = explode(",",$value);
        for($ndx = 1 ; $ndx <= count($fields) ; $ndx++){
          $fieldName = $fields[$ndx-1];
          $reserveName = "setReserve".$ndx;
          $fieldValue = $this->input->post($fieldName);
          if(false !== $fieldValue && !empty($fieldValue)){
            $user->$reserveName($fieldValue);
          }
        } 
      }
      
      /*
      $userCountryCode = $this->input->post("userCountryCode");
      if(isset($userCountryCode)){
        $user->setReserve1($userCountryCode);
      }
      $userChosenYear = $this->input->post("choosenYear");
      if(isset($userChosenYear) && $userChosenYear != ""){
        $user->setReserve1($userChosenYear);
      }
      $userChosenSong = $this->input->post("choosenSong");
      if(isset($userChosenSong) && $userChosenSong!="" ){
        $user->setReserve1($userChosenSong);
      }
	    $userNumberOfPeople = $this->input->post("userNumberOfPeople");
      if(isset($userNumberOfPeople) && $userNumberOfPeople!="" ){
        $user->setReserve1($userNumberOfPeople);
      }
      $userScore = $this->input->post("userScore");
      if(isset($userScore)){
        $user->setReserve2($userScore);
      }
      $userCountryId = $this->input->post("userCountryId");
      if(isset($userCountryId)){
        $user->setReserve3($userCountryId);
      }
      $userAgreeTNC = $this->input->post("userAgreeTNC");
      if(isset($userAgreeTNC)){
        $user->setReserve4($userAgreeTNC);
      }
      $userEDMTNC = $this->input->post("userEDMTNC");
      if(isset($userAgreeTNC)){
        $user->setReserve5($userEDMTNC);
      }
      */

      //Auto Approval
      $value = $this->getOptionValue($user->getEventcode()."_auto_approval");
      if($value != null && $value == "N"){
        $user->setIsapproved("N");
      }else{
        $user->setIsapproved("Y");
      }
      
      $user->setCreatedate($this->currentTime);
  }

  private function checkEventCode($user){
      $eventCode = "";
      $defaultEventCode = $this->getOptionValue("default_event_code");
      if(!empty($this->input->post("eventCode"))){
        $code = $this->em->getRepository("Code")->findOneBy(array(
                  "category"=>"EVENT",
                  "code"=>$this->input->post("eventCode"),
                  "valid"=>"Y" 
                ));
        if($code != null){
          $user->setEventcode($this->input->post("eventCode"));
          $eventCode = $this->input->post("eventCode");
        }else{
          $this->printErrorMessage("There is no eventCode matched in the local server.");
          log_message("error","There is no eventCode in server-".$this->input->post("eventCode"));
          return false;
        }
      }else{
        if(!$defaultEventCode){
          $this->printErrorMessage("There is no options for default_event_code.");
          log_message("error","There is no options for default_event_code.");
          return false;
        }
        $user->setEventcode($defaultEventCode);
        $eventCode = $defaultEventCode;
      }

      return $eventCode;
  }

  private function checkSiteCode($user){
      $siteCode = "";
      $defaultSiteCode = $this->getOptionValue("default_site_code");
      if(!empty($this->input->post("siteCode"))){
        $code = $this->em->getRepository("Code")->findOneBy(array(
                  "category"=>"SITE",
                  "code"=>$this->input->post("siteCode"),
                  "valid"=>"Y" 
                ));
        if($code != null){
          $user->setSitecode($this->input->post("siteCode"));
          $siteCode = $this->input->post("siteCode");
        }else{
          $this->printErrorMessage("There is no siteCode matched in the local server.");
          log_message("error","There is no siteCode in server-".$this->input->post("siteCode"));
          return false;
        }
      }else{
        if(!$defaultSiteCode){
          $this->printErrorMessage("There is no options for default_site_code.");
          log_message("error","There is no options for default_site_code.");
          return false;
        }
        $user->setSitecode($defaultSiteCode);
        $siteCode = $defaultSiteCode;
      }

      return $siteCode;
  }

  private function checkMustField($user){
      $mustField = $this->getOptionValue($user->getEventcode()."_must_field");
      log_message("debug","##############################################");
      log_message("debug",$mustField);
      if(false != $mustField && !empty($mustField)){
        $mustFields = explode(",",$mustField);
        foreach($mustFields as $field){
          //Checking if there is a field in $_POST.
          $fieldValue = $this->input->post($field);
          if(false === $fieldValue || empty($fieldValue)){
            //Checking if there is a field in $_FILES.
            $fieldValue = $_FILES[$field];
            if(false === $fieldValue || empty($fieldValue)){
              $this->printErrorMessage("There is a missing MUST-field[".$field."].");
              log_message("error","There is a missing MUST-field[".$field."].");
              return false;
            }
          }
        }
      }
      log_message("debug","##############################################");
      return true;
  }

  private function copyVideo($user){
      if(!empty($this->input->post("videoId"))){
        $videoId = $this->input->post("videoId");
        $user->setVideoid($videoId);

        $copyVideoId = $this->getOptionValue($user->getEventcode()."_copy_videoId");
        if($copyVideoId === false) $copyVideoId = "Y";
        if($copyVideoId == "Y"){
          if(!$this->copyMedia($user,"videoId",$videoId)){
            $this->printErrorMessage("Could not copy video file-$videoId.");
            log_message("error","Could not copy video file-$videoId.");
            return false;
          }
        }
      }

      return true;
  }

  private function copyPhoto($user){
      if(!empty($this->input->post("photoId"))){
        $copyPhotoId = $this->getOptionValue($user->getEventcode()."_copy_photoId");
        if(false === $copyPhotoId) $copyPhotoId = "Y";
        if("Y" == $copyPhotoId){
          $user->setPhotoid($this->input->post("photoId"));
          $photoIds = explode(",",$this->input->post("photoId")); 
          $fileuploadcount = $this->getOptionValue($user->getEventcode()."_file_upload_count");
          log_message("debug","###photoId_count:".count($photoIds));
          log_message("debug","###file_count:".$fileuploadcount);
          if($fileuploadcount !== false && $fileuploadcount != 1){
            if($fileuploadcount == count($photoIds)){
              $index = 1;
              foreach($photoIds as $photoId){
                if(!$this->copyMedia($user,"photoId".$index,$photoId)){
                  $this->printErrorMessage("Could not copy photo file-$photoId.");
                  log_message("error","Could not copy photo file-$photoId.");
                  return false;
                }
                $index++;
              }
            }else{
              $this->printErrorMessage("Could not upload multi-photos.");
              log_message("error","Could not upload multi-photos#1.");
              log_message("error","The count is not matched.");
              return false;
            }
          }else{
            $photoId = $this->input->post("photoId");
            if(!$this->copyMedia($user,"photoId",$photoId)){
              $this->printErrorMessage("Could not copy photo file-$photoId.");
              log_message("error","Could not copy photo file-$photoId.");
              return false;
            }
          }
        }
      }

      return true;
  }

  private function uploadFile($user){
      log_message("debug","##########################################################");
      log_message("debug","##################### START uploadFile() #######################");
      log_message("debug","##########################################################");
      if(count($_FILES) > 0){
        if(file_exists($this->localUploadPath)){
          if(!file_exists($this->localUploadPath.$user->getEventcode())){
            mkdir($this->localUploadPath.$user->getEventcode());
          }
          if(!file_exists($this->localUploadPath.$user->getEventcode()."/".date('Y-m-d'))){
            mkdir($this->localUploadPath.$user->getEventcode()."/".date('Y-m-d'));
          }
        }else{
          mkdir($this->localUploadPath);
          mkdir($this->localUploadPath.$user->getEventcode());
          mkdir($this->localUploadPath.$user->getEventcode()."/".date('Y-m-d'));
        }

        $config['upload_path'] = $this->localUploadPath.$user->getEventcode()."/".date('Y-m-d');
        //$config['allowed_types'] = 'gif|jpg|png';
        $config['allowed_types'] = 'gif|jpg|jpeg|png|mp4';
        $confif['overwrite'] = false;
        $config['max_size']	= 1024*5;
        //$config['max_width']  = '1024';
        //$config['max_height']  = '768';
        $this->load->library('upload', $config);
      }

      //$fileDatas = array("FileData","FileData00","FileData01");
      
      try{
        foreach($_FILES as $fileData => $fileContent){
          if(isset($_FILES[$fileData])){
            if (!$this->upload->do_upload($fileData)){
              $error = array('error' => $this->upload->display_errors());
              log_message("error",$this->upload->display_errors());
              $this->printErrorMessage("Could not upload file : ".$fileData);
              return;
            }else{
              $data = $this->upload->data();

              $media = new Localmedia();
              $media->setUserid($user);
              $media->setTypecode($fileData);
              $media->setFilePath($user->getEventcode()."/".date('Y-m-d')."/".$data["file_name"]);
              $media->setFilename($data["file_name"]);
              $media->setMimetype($data["file_type"]);
              $media->setCreatedate($this->currentTime);

              $value = $this->getOptionValue($user->getEventcode()."_make_localthumbnail");
              if(false != $value && "Y" == $value){
                $this->make_localthumbnail($media);
              }

              $this->em->persist($media);

              log_message("debug","###".$fileData." is uploaded.");
            }
          }
        }
      }catch(Exception $e){
        log_message("error",$e->getMessage());
        $this->printErrorMessage("Could not upload file : ".$e->getMessage());
        return false;
      }

      log_message("debug","##########################################################");
      log_message("debug","###################### END uploadFile() ########################");
      log_message("debug","##########################################################");
      
      return true;
  }

  private function linkRFID($user){
      if($user->getEventcode() == "FC"){
          $qb = $this->em->createQueryBuilder();
          $qb->select("e")
             ->from("Localrfidscan","e")
             ->where("e.valid = 'Y'")
             ->andWhere("e.localuserid IS NULL");
          $scanlist = $qb->getQuery()->getResult();
          foreach($scanlist as $rfid){
              $rfid->setLocaluserid($user);
              $this->em->persist($rfid);
          }
      } 

      return true;
  }

  public function qsrank(){
      $rankquery = $this->getOptionValue("QS_rank_query");
      $ranklimit = $this->getOptionValue("QS_rank_limit");
      $currentrank = "N";
      $currentrankfield = "";
      $message = $this->getRank(null,$rankquery,$ranklimit,$currentrank,$currentrankfield);

      $this->printSuccessMessage($message);
  }

  private function getRank($user,$rankquery,$ranklimit,$currentrank,$currentrankfield){
      if($ranklimit == false){
        $ranklimit = 50;
      }

      if($rankquery !== false && $rankquery != ""){
        $currentrankmessage = "";
        $message = "<ranks>";
        $query = $this->db->query($rankquery);

        $prevRank = 0;
        $prevScore = 0;
        $calcRank = 0;
        $index = 0;

        foreach ($query->result_array() as $row)
        {
          $calcRank++;
          $index++;
          
          if($row['score'] != $prevScore){
            $row['rank'] = $calcRank; 
          }else{
            $row['rank'] = $prevRank; 
          }
          $prevRank = $row['rank'];
          $prevScore = $row['score'];

          if($currentrank !== false && $currentrank == "Y"){
            if($currentrankfield !== false){
              if($currentrankfield == "userSelectPlayer"){
                if($user != null){
                  if($user->getTeamplayercode() == $row["id"]){
                    $currentrankmessage = 
                      '<currentrank no="'.$row['rank'].'" name="'.$row['name'].'" id="'.$row['id'].'" country="'.$row['country'].'" score="'.$row['score'].'"/>';
                  } 
                }
              }
            }
          }

          $rankmessage = '<rank no="'.$row['rank'].'" name="'.$row['name'].'" id="'.$row['id'].'" country="'.$row['country'].'" score="'.$row['score'].'"/>';
          if($index <= $ranklimit){
            $message .= $rankmessage;
          }else{
            if($currentrank !== false && $currentrank == "Y"){
              if($currentrankmessage != ""){
                break;
              }
            }else{
              break;
            }
          }
        }
        $message .="</ranks>";

        return $message.$currentrankmessage;
      }

      return "";
  }
  
  protected function copyMedia($user,$mediaType,$mediaId){
    //Check late upload.
    //TODO If file is set of late upload, then try again on RemoteSync
    $option = $this->getOptionValue($user->getEventcode()."_late_upload");
    if($option !== false && $option == "Y"){
      log_message("debug","### $mediaType $mediaId is not copied because late upload is set.");
      return true;
    }

    return parent::copyMedia($user,$mediaType,$mediaId);
  }

  private function printErrorMessage($msg){
    echo '<result_data>';
    echo '  <result status="error" message="'.$msg.'" />';
    echo '</result_data>';
  }

  private function printSuccessMessage($message){
    echo '<result_data>';
    echo '  <result status="success" message="" />';
    echo $message;
    echo '</result_data>';
  }
}
