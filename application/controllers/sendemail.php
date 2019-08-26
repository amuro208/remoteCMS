<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/doctrinautoload.php';
//require_once APPPATH . 'controllers/api/autoload.php';
//require_once APPPATH . 'libraries/ImageManipulator.php';

class SendEmail extends DoctrinAutoload {

  function __construct(){
    $parameters = array("NoAuthCheck"=>"Y");
    parent::__construct($parameters);
    $this->init();
  }

  /*
  function __construct($params){
    if($params == null){
      $params = array();
    }
    $params["NoAuthCheck"] = "Y";
    parent::__construct($params);

    $this->init();
  }
  */

  function init(){
    $this->load->library('email'); // load the library
    $this->load->library('parser');
    $this->load->helper('url');
    $this->load->helper('mx');
    $this->load->library('user_agent');
    $this->load->database();
  }

  function index(){
    $this->testEmail();
  }

  public function testEmail(){
    $this->config->load("email");
    $senderEmail =  $this->config->item("smtp_user");
    $senderName =  $this->config->item("sender_name");
    $this->email->from($senderEmail,$senderName);
    $this->email->to("amuro208@gmail.com");
    $this->email->subject("This is test subject from NEAT CMS.");
    $this->email->message("Mail sent test message...");
    $data['message'] = "Sorry Unable to send email...";
    if($this->email->send()){
      $data['message'] = "Mail sent...";
    }
    echo $this->email->print_debugger();
  }

  public function error(){
    $this->config->load("email");
    $errorarea = $this->uri->segment(3);
    $senderEmail =  $this->config->item("smtp_user");
    $senderName =  $this->config->item("sender_name");
    $this->email->from($senderEmail,$senderName);
    $this->email->to("amuro208@gmail.com");
    $this->email->subject("!!Error the remote cms!!");
    $this->email->message("You need to check in the area [$errorarea]");
    if($this->email->send()){
    }
  }

  public function notify(){
    $userid = $this->uri->segment(3);
    $user = $this->em->find("User", $userid);
    //if the system is in manual upload mode, check reserve1
    $edmMedia = "FileData00";
    $manualUpload = $this->config->item("manual_upload");
    if( "Y" == $manualUpload){
      if($user->getReserve1() == "Y"){
        $edmMedia = "Upload";
      }
    }

    $medias = $user->getMedias();
    $mediafile = false;
    foreach($medias as $media){
      if($media->getTypecode() == $edmMedia){
        $mediafile = $this->uploadPath.$media->getFilepath();
        break;
      }
    }

    if($mediafile !== false){

      $senderEmail =  $this->config->item("smtp_user");
      $senderName =  $this->config->item("sender_name");

      $this->email->from($senderEmail,$senderName);
      $this->email->to("richard.pangemanan@thecreativeshop.com.au");
      //$this->email->to("luis.youn@thecreativeshop.com.au");
      $this->email->subject("You got a new photo.");
      $message = "-----------------------------------------<br>";
      $message .= "User Id : ".$userid."\n\r<br>";
      $message .= "-----------------------------------------<br>";
      $message .= "1. Get to the remote CMS with http://www.f1forreal.com.au/framework\n\r<br>";
      $message .= "2. Log in with admin@thecreativeshop.com.au\n\r<br>";
      $message .= "3. Choose the menu 'Total Event'\n\r<br>";
      $message .= "4. Type 'User Id' into ID filter\n\r<br>";
      $message .= "5. Click 'edit' button\n\r<br>";
      $message .= "6. Upload a file that you made\n\r<br>";
      $message .= "7. Click the checkbox 'Approval' \n\r<br>";
      $this->email->message($message);
      $this->email->attach($mediafile);

      $data['message'] = "Sorry Unable to send email...";
      if($this->email->send()){
        $data['message'] = "Mail sent...";
      }

      //echo $this->email->print_debugger();
    }
  }

  function make_seed()
  {
    list($usec, $sec) = explode(' ', microtime());
    return (float) $sec + ((float) $usec * 100000);
  }

  //public function sendStandardEmail($user,$title,$msg,$template,$frameFileName){
  public function sendStandardEmail($user,$title,$msg,$template){
    log_message("debug","-------------------Start sendStandardEmail-----------------------");
	$this->email->protocol = $this->config->item("protocol");
	$this->email->smtp_host = $this->config->item("smtp_host");
	$this->email->smtp_user = $this->config->item("smtp_user");
	$this->email->smtp_pass = $this->config->item("smtp_pass");
	$this->email->smtp_port = $this->config->item("smtp_port");
    //$senderEmail =  $this->config->item("smtp_user");
    $senderEmail =  $this->config->item("sender_email");
    $senderName =  $this->config->item("sender_name");

    $receiveList = explode('|',$user->getEmail());
    $firstNameList = explode('|',$user->getFirstname());
    $lastNameList = explode('|',$user->getLastname());

    log_message("debug","-------------------#1 sendStandardEmail-----------------------");
    $index = 0;
    $totalLen = count($receiveList);
    foreach($receiveList as $receiver){

      mt_srand($this->make_seed());
      //$accessCode = substr(base64_encode(sha1(mt_rand())), 0, 32);
      $accessCode = uniqid("",true);
      //I don't know the reason why facebook reject number url...
      $accessCode = "a".str_replace(".","",$accessCode)."z";
      $emaillog = new Emaillog();
      $emaillog->setUserid($user);
      $emaillog->setEmail($receiver);
      $emaillog->setAccesscode($accessCode);
      $shareAccessCode = uniqid("",true);

      //I don't know the reason why facebook reject number url...
      $shareAccessCode = "a".str_replace(".","",$shareAccessCode )."z";
      $emaillog->setShareaccesscode($shareAccessCode);

      $longurl = $this->config->item("home_url").$accessCode;
      /*
      $shorturl = get_bitly_short_url($longurl);
      log_message("debug","shorturl:".$shorturl);
      $emaillog->setShorturl($shorturl);
      */

      log_message("debug","-------------------#2 sendStandardEmail-----------------------");
      $isValidEmail = validate_email($receiver);
      log_message("debug","isValidEmail = ".$isValidEmail);

      $emaillog->setIsvalidemail($isValidEmail);
      $emaillog->setCreatedate(new DateTime("now"));
      $this->em->persist($emaillog);

      log_message("debug","-------------------#3 sendStandardEmail-----------------------");

      if($isValidEmail == 'Y' || $isValidEmail == 'E' || $isValidEmail == 'N' ){
		
        $this->email->clear(TRUE);
        $this->email->from($senderEmail,$senderName);
        $this->email->to($receiver);
        $this->email->subject($title);

        $data["accessCode"] = $emaillog->getAccesscode();
        $data["shareAccessCode"] = $emaillog->getShareaccesscode();
        $data["cmsHomeUrl"] = $this->config->item("cms_home_url");
        $data["homeUrl"] = $this->config->item("home_url");
        $data["emailTestData"] = $this->config->item("email_test_data");
        $data["userid"] = $user->getId();
        $data["eventCode"] = $user->getEventcode();
        $data["firstName"] = $firstNameList[$index];
        $data["lastName"] = $lastNameList[$index];

		

        $medias = $user->getMedias();
        $edmMedia = $this->config->item($user->getEventcode()."_edm_media");// $this->getOptionValue($user->getEventcode()."_edm_media");
        if($edmMedia === false){
          $edmMedia = "FileData00";
        }else{
          if(false !== strpos($edmMedia,'index')){
            $edmMedia = str_replace('index',($index+1),$edmMedia);
          }
        }

        //add emaillog to add edmMedia...
        $emaillog->setEdmmedia($edmMedia);

        foreach($medias as $media){
          if($media->getTypecode() == $edmMedia){
            $data["fileName"] = $media->getFilepath();
          }
        }

        log_message("debug","-------------------#4 sendStandardEmail-----------------------");

        $message = $this->parser->parse($template, $data, true);
        log_message("debug",$template);
        //log_message("debug",$message);

        $this->email->message($message);

        log_message("debug","-------------------#5 sendStandardEmail-----------------------");

        if($this->email->send()){
          log_message("debug","-------------------#6 sendStandardEmail-----------------------");
          $emaillog->setSentdate(new DateTime('now'));
          $emaillog->setIssent('Y');
          echo "OK";
        }else{
          log_message("debug","-------------------#7 sendStandardEmail-----------------------");
          log_message("error","###############EMAIL ERROR##################");
          $message = $this->email->print_debugger();
          log_message("error",$message);
          log_message("error","###############EMAIL ERROR##################");
          $emaillog->setIssent('N');
        }
      }
      $index++;
    }

    log_message("debug","-------------------#8 sendStandardEmail-----------------------");
    $user->setIssentemail('Y');
    $this->em->persist($user);
    $this->em->persist($emaillog);

    log_message("debug","-------------------End sendStandardEmail-----------------------");
  }

  public function send($userid){
    log_message("debug","#############################################################");
    log_message("debug","################## START SEND EMAIL##########################");
    log_message("debug","#############################################################");

    $user = $this->em->find("User", $userid);
    log_message("debug","userid:".$user->getId());
    log_message("debug",$user->getEmail()."  ".$this->getConfigPath($user));
    $this->config->load($this->getConfigPath($user));
	
    //$frameFileName = $this->makeEDMFrameImage($user);
    //if($frameFileName !== false){;
      //Delete if there is already logs.
      $emaillogs = $user->getEmailLogs();
      foreach($emaillogs as $emaillog){
        $emaillog->setValid('N');
        $emaillog->setUpdatedate(new DateTime('now'));
        $this->em->persist($emaillog);
      }

      $titleOption = $this->config->item($user->getEventcode()."_email_title");
      $messageOption = $this->config->item($user->getEventcode()."_email_message");
      $templateOption = $this->config->item($user->getEventcode()."_email_template");
      if($titleOption !== false && $titleOption != ""){
        $title = $titleOption;
        if(stripos($title,"##")>-1){
            $firstIndex = stripos($title, "[");
            $lastIndex = strripos($title, "]");
  		      $keyw = substr($title,$firstIndex+1,$lastIndex-$firstIndex-1);
    		  if($keyw == "FIRST_NAME"){
    			     $title=str_replace("##[FIRST_NAME]",$user->getFirstname(),$title);
    		  }else if($keyw == "LAST_NAME"){
    			     $title=str_replace("##[LAST_NAME]",$user->getLastname(),$title);
    		  }
        }
      }else{
        $title = "STANDARD MAIL TITLE";
      }
      if($messageOption !== false && $messageOption != ""){
        $message = $messageOption;
      }else{
        $message = "STANDARD MAIL MESSAGE";
      }
      if($templateOption !== false && $templateOption != ""){
        $template = $templateOption;
      }else{
        $template = "standard_email";
      }
      //$this->sendStandardEmail($user,$title,$message,$template,$frameFileName);
      $this->sendStandardEmail($user,$title,$message,$template);

      $this->em->flush();
    //}

    log_message("debug","#############################################################");
    log_message("debug","################### END SEND EMAIL###########################");
    log_message("debug","#############################################################");
  }

  public function standard(){
    log_message("debug","#############################################################");
    log_message("debug","###############START STANDARD EMAIL##########################");
    log_message("debug","#############################################################");

    $userid = $this->uri->segment(3);
    $this->send($userid);

    log_message("debug","#############################################################");
    log_message("debug","#################END STANDARD EMAIL##########################");
    log_message("debug","#############################################################");
  }

  //Make Frame from only PNG file...
  //EVENTCODE_edm_merge_image : [Y|N]
  //EVENTCODE_edm_frame_path : String
  //EVENTCODE_edm_image_rect : x,y,w,h
  /*public function makeEDMFrameImage($user){
    if($user == null){
      log_message("error","invalid argument");
      return false;
    }
    //Check if I need to merge image.
    $option = $this->getOptionValue($user->getEventcode()."_edm_merge_image");
    if($option === false || $option == "" || $option == "N"){
      $medias = $user->getMedias();

      $edmMedia =  $this->getOptionValue($user->getEventcode()."_edm_media");
      if($edmMedia === false){
        $edmMedia = "FileData00";
      }

      //if the system is in manual upload mode, check reserve1
      $manualUpload = $this->getOptionValue($user->getEventcode()."_manual_upload");
      if( "Y" == $manualUpload){
        if($user->getReserve1() == "Y"){
          $edmMedia = "Upload";
        }
      }

      foreach($medias as $media){
        if($media->getTypecode() == $edmMedia){
          $longurl = $this->getOptionValue("home_url")."/uploads/".$user->getEventcode()."/".$media->getFilename();

          $shorturl = get_bitly_short_url($longurl);
          log_message("debug","shorturl:".$shorturl);
          $media->setShorturl($shorturl);

          //return $user->getEventcode()."/".$media->getFilename();
          return $media->getFilepath();
        }
      }
      return "";
    }

    //Check if the root path exists.
    $rootFrame = $this->uploadPath."frame/";
    if(!file_exists($rootFrame)){
      mkdir($rootFrame);
    }
    $rootFrame = $this->uploadPath."frame/".strtolower($user->getEventcode())."/";
    if(!file_exists($rootFrame)){
      mkdir($rootFrame);
    }

    try{
      $contentUrl = false;
      $medias = $user->getMedias();
      $edmMedia =  $this->getOptionValue($user->getEventcode()."_edm_media");
      if($edmMedia === false){
        $edmMedia = "FileData00";
      }
      foreach($medias as $media){
        if($media->getTypecode() == $edmMedia){
          $longurl = $this->getOptionValue("home_url")."/uploads/".$user->getEventcode()."/".$media->getFilename();

          $shorturl = get_bitly_short_url($longurl);
          log_message("debug","shorturl:".$shorturl);
          $media->setShorturl($shorturl);

          $contentUrl = $media->getFilepath();
          break;
        }
      }

      if($contentUrl !== false){
        $content = new ImageManipulator($this->uploadPath.$contentUrl);

        $optionName = $user->getEventcode()."_edm_image_rect";
        $contentFrame = $this->getOptionValue($optionName); //x,y,w,h
        if($contentFrame!==false && $contentFrame != null){
          $dims = json_decode($contentFrame);

          $frameOptionName = $user->getEventcode()."_edm_frame_path";
          $framePath = $this->getOptionValue($frameOptionName);
          if($framePath === false){
            log_message("error","There is no option for ".$frameOptionName);
            return false;
          }

          $content->merge($framePath,$dims);
        }else{
          log_message("error","There is no option for ".$optionName);
          return false;
        }

        $rd = rand(100000000,999999999);
        $fileName =  $rd."_".$user->getId().".png";
        $filePath =  $rootFrame.$fileName;

        $content->save($filePath,IMAGETYPE_PNG);

        $media = new Media();
        $media->setUserid($user);
        $media->setTypecode("Frame");
        $media->setMimetype("image/png");
        $media->setFilepath("frame/".strtolower($user->getEventcode())."/".$fileName);
        $media->setFilename($fileName);
        $this->em->persist($media);

        return $fileName;
      }
    }catch(Exception $e){
      log_message("error",$e->getMessage());
      return false;
    }

    return false;
  }
*/
}
