<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

set_include_path(__DIR__ . '/../libraries/phpflickr');
require_once("phpFlickr.php");
require_once APPPATH . 'controllers/api/doctrinautoload.php';

class Flickr extends DoctrinAutoload {

    private $api_key = NULL;
    private $secret_api_key = NULL;
    private $token = NULL;
  
    function __construct()
    {
      $parameters = array("NoAuthCheck"=>"Y");
      parent::__construct($parameters);
      $this->load->database();
      
      $this->config->load('flickr');
      $this->load->helper('url');
      
    }

    public function index()
    {
      $this->api_key = $this->config->item('flickr_api_key');
      $this->secret_api_key = $this->config->item('flickr_secret_api_key');
      $this->token = $this->config->item('flickr_token');
      
      if(empty($this->token)){
        $this->oauth2callback();
      }else{
        $this->upload();
      }
    }


    public function testUpload(){
      
      $this->api_key = $this->config->item('flickr_api_key');
      $this->secret_api_key = $this->config->item('flickr_secret_api_key');
      $this->token = $this->config->item('flickr_token');
      
      $this->f = new phpFlickr($this->api_key, $this->secret_api_key, TRUE);
      if(isset($this->token))
      {
        $this->f->setToken($this->token);
      }
      
      $videoPath = __DIR__ ."/test/testfile/1mb.jpg";
      $videoTitle = "tutorial";
      $videoDescription = "A video tutorial on how to upload to YouTube";
      $videoTags = "tutorial";
      
      /*
      echo $videoPath;
      echo $videoTitle;
      echo $videoDescription;
      echo $videoTags;
      echo $_SESSION['phpFlickr_auth_token'];
      */
      
      $resu = $this->f->sync_upload( $videoPath , $videoTitle , $videoDescription , $videoTags );

      echo "<pre>"; print_r($resu);
    }

    
    public function upload(){
      log_message("debug","##################################################");
      log_message("debug","############# START FLICKR UPLOAD ################");
      log_message("debug","##################################################");
      
      $userid = $this->uri->segment(3);
      $user = $this->em->find("User", $userid);
      $sendsnses = $user->getSendSNSes(); 
      foreach($sendsnses as $sendsns){
        $status = $sendsns->getIssent();
        $snsid = $sendsns->getSnsid();

        if($status == "S" || $status == "Y"){
          continue;
        }

        $sendsns->setIssent("S"); //Status is sending...
        $this->em->persist($sendsns);
        
        try{
          $medias = $user->getMedias();
          $filePath = "";
          foreach($medias as $media){
            if($media->getTypecode() == "videoId"){
              $filePath = $media->getFilepath();
            }
            if($media->getTypecode() == "photoId"){
              $filePath = $media->getFilepath();
            }
          }

          if($filePath == ""){
            $sendsns->setIssent("N");
            $this->em->persist($sendsns);
            continue;
          }

          $this->api_key = $this->config->item('flickr_api_key');
          $this->secret_api_key = $this->config->item('flickr_secret_api_key');
          $this->token = $this->config->item('flickr_token');
          
          $this->f = new phpFlickr($this->api_key, $this->secret_api_key, TRUE);
          if(isset($this->token))
          {
            $this->f->setToken($this->token);
          }

          $videoPath = $this->uploadPath . $filePath;
          $videoTitle = trim($this->getOptionValue($user->getEventcode()."_fl_title"));
          $videoDescription = trim($this->getOptionValue($user->getEventcode()."_fl_message"));
          $videoTags = trim($this->getOptionValue($user->getEventcode()."_fl_tag"));
          $urlTemplate = trim($this->getOptionValue($user->getEventcode()."_fl_url"));

          $flVideoId = $this->f->sync_upload( $videoPath, $videoTitle , $videoDescription , $videoTags );

          if(!empty($flVideoId)){
            $sendsns->setIssent("Y"); //Status is sent
            $sendsns->setUpdatedate(new DateTime('now'));
            $sendsns->setSentdate(new DateTime('now'));
            $sendsns->setSnsid($flVideoId);
            $sendsns->setSnsurl($urlTemplate.$flVideoId);
            $this->em->persist($sendsns);
            echo "OK";
          }else{
            $sendsns->setIssent("N"); //Status is not sent.
            $this->em->persist($sendsns);
          }

        }catch(Exception $e){
          $sendsns->setIssent("N");
          $this->em->persist($sendsns);
        }
      }

      log_message("debug","##################################################");
      log_message("debug","#############  END FLICKR UPLOAD  ################");
      log_message("debug","##################################################");
    }
    
    public function oauth2callback(){
      
      $api_key                 = $this->config->item("flickr_api_key");
      $api_secret              = $this->config->item("flickr_secret_api_key");
      $default_redirect        = $this->config->item("flickr_redirect");
      
      $permissions             = "write";
      
      unset($_SESSION['phpFlickr_auth_token']);
       
      if ( isset($_SESSION['phpFlickr_auth_redirect']) && !empty($_SESSION['phpFlickr_auth_redirect']) ) {
        $redirect = $_SESSION['phpFlickr_auth_redirect'];
        unset($_SESSION['phpFlickr_auth_redirect']);
      }
      
      $f = new phpFlickr($api_key, $api_secret);
   
      if (empty($_GET['frob'])) {
          $f->auth($permissions, false);
      } else {
          $f->auth_getToken($_GET['frob']);
          print_r($_SESSION['phpFlickr_auth_token']);
      }
      /* 
      if(empty($redirect)) {
        header("Location: " . $default_redirect);
      } else {
        header("Location: " . $redirect);
      }
      */ 
    }
}
