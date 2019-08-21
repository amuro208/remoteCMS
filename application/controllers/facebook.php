<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/doctrinautoload.php';

class Facebook extends DoctrinAutoload {

    private $token;
    
    function __construct()
    {
      parent::__construct();
      $this->load->database();
      
      $this->config->load('facebook');
      $this->load->helper('url');

    }

    public function index()
    {

    }
    
    public function upload(){
      log_message("debug","####################################################");
      log_message("debug","############# START FACEBOOK UPLOAD ################");
      log_message("debug","####################################################");
      $userid = $this->uri->segment(3);
      $user = $this->em->find("User", $userid);
      $sendsnses = $user->getSendSNSes(); 
      foreach($sendsnses as $sendsns){
        $access_token = $sendsns->getAccesstoken(); 
        $status = $sendsns->getIssent();
        $snsid = $sendsns->getSnsid();

        if($status == "S" || $status == "Y"){
          continue;
        }

        $sendsns->setIssent("S");
        $this->em->persist($sendsns);
        
        try{

          $medias = $user->getMedias();
          $filePath = "";
          foreach($medias as $media){
            if($media->getTypecode() == "videoId"){
              $filePath = $media->getFilepath();
            }
          }

          if($filePath == ""){
            $sendsns->setIssent("N");
            $this->em->persist($sendsns);
            continue;
          }

          $fbVideoId = $this->uploadVedioFile2Facebook($user,$snsid,$access_token,$filePath);

          if(!empty($fbVideoId)){
            $sendsns->setIssent("Y");
            $sendsns->setUpdatedate(new DateTime('now'));
            $sendsns->setSnsurl($fbVideoId);
            $this->em->persist($sendsns);
          }else{
            $sendsns->setIssent("N");
            $this->em->persist($sendsns);
          }

        }catch(Exception $e){
          $sendsns->setIssent("N");
          $this->em->persist($sendsns);
        }
      }

      $this->em->flush();

      log_message("debug","####################################################");
      log_message("debug","############## END FACEBOOK UPLOAD #################");
      log_message("debug","####################################################");
    }

    public function reuploadcron(){
      $sendsns = $this->em->getRepository("Sendsns")->findOneBy(array(
                  "valid" => "Y",
                  "issent" => "N"
                ));
      $this->reupload($sendsns);
    }

    public function reuploadtest(){
      $sendsnsid = $this->uri->segment(3);
      $sendsns = $this->em->find("Sendsns", $sendsnsid);
      $this->reupload($sendsns);
    }

    public function reupload($sendsns){
      log_message("debug","####################################################");
      log_message("debug","############ START FACEBOOK RE-UPLOAD ##############");
      log_message("debug","############ ID : ".$sendsns->getId()." ##############");
      log_message("debug","####################################################");

      //$sendsnsid = $this->uri->segment(3);
      //$sendsns = $this->em->find("Sendsns", $sendsnsid);
      
      $access_token = $sendsns->getAccesstoken(); 
      $status = $sendsns->getIssent();
      $snsid = $sendsns->getSnsid();

      if($status == "N" || $status == "P"){
        $sendsns->setIssent("P");
        $this->em->flush();

        $user = $sendsns->getUserid(); 
        try{

          $medias = $user->getMedias();
          $filePath = "";
          foreach($medias as $media){
            if($media->getTypecode() == "videoId"){
              $filePath = $media->getFilepath();
            }
          }

          if($filePath == ""){
            $sendsns->setIssent("N");
            $this->em->persist($sendsns);
            continue;
          }

          $fbVideoId = $this->uploadVedioFile2Facebook($user,$snsid,$access_token,$filePath);
          
          log_message("debug","fbVideoId:$fbVideoId");

          if($fbVideoId == "ERROR"){
            $sendsns->setIssent("E");
            $sendsns->setUpdatedate(new DateTime('now'));
            $this->em->persist($sendsns);
          }else{
            if(!empty($fbVideoId)){
              $sendsns->setIssent("Y");
              $sendsns->setUpdatedate(new DateTime('now'));
              $sendsns->setSnsurl($fbVideoId);
              $this->em->persist($sendsns);
            }else{
              $sendsns->setIssent("Z");
              $this->em->persist($sendsns);
            }
          }

        }catch(Exception $e){
          $sendsns->setIssent("N");
          $this->em->persist($sendsns);
        }

        $this->em->flush();
      }

      log_message("debug","####################################################");
      log_message("debug","############  END FACEBOOK RE-UPLOAD  ##############");
      log_message("debug","####################################################");

    }

    private function uploadVedioFile2Facebook($user,$facebook_id,$access_token,$filePath){

      $videoPath = $this->uploadPath . $filePath;
      $videoTitle = trim($this->getOptionValue($user->getEventcode()."_fb_title"));
      $videoDescription = trim($this->getOptionValue($user->getEventcode()."_fb_message"));

      $access_token = str_replace("access_token=","",$access_token);
      $index = strrpos($access_token,"&");
      $access_token = substr($access_token,0,$index);
      
      $params = array();
      $params['title']         = $videoTitle;
      $params['description']   = $videoDescription;
      $params['access_token']  = $access_token;
      $params['source']        = "@".$videoPath;

      $graph_url = "https://graph.facebook.com/".$facebook_id."/videos";

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $graph_url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
      $result = curl_exec($ch);

      log_message("debug","FB RESULT:".$result);

      $fbvideo = json_decode($result, true);
      curl_close($ch);
      
      if(isset($fbvideo['id'])){
        return $fbvideo['id'];
      }

      if(isset($fbvideo['error'])){
        return "ERROR"; 
      }

      return $fbvideo['id'];
    }

    public function oauth2callback(){
      session_start();

      if(isset($_GET["acode"])){
        $_SESSION["acode"] = $_GET["acode"];
      }

      $app_id = $this->config->item("facebook_api_key");//"590751330982720";
      $app_secret = $this->config->item("facebook_secret");//"40e1cf151cc03e2764aac1c9ba0a29a4";
      $app_callback = $this->config->item("facebook_callbaclurl");//"http://www.sbspopweekend.com.au/fb_test.php?x=1243";
 
      $code = "";
      if(isset($_GET["code"])){
        $code = $_GET["code"];
      }

      if(empty($code)) {
      
         $dialog_url = "http://www.facebook.com/dialog/oauth?client_id="
           . $app_id . "&redirect_uri=" . urlencode($app_callback)
           . "&scope=publish_actions";
          echo('<script>top.location.href="' . $dialog_url . '";</script>');
          return;
      }

      $token_url = "https://graph.facebook.com/oauth/access_token?client_id="
          . $app_id . "&redirect_uri=" . urlencode($app_callback)
          . "&client_secret=" . $app_secret
          . "&code=" . $code;

      $access_token = file_get_contents($token_url);
      $acode = $_SESSION["acode"];
      
      $user_url = "https://graph.facebook.com/me?".$access_token;
      $result = file_get_contents($user_url);
      $fb_user = json_decode($result);
      
      $qb = $this->em->createQueryBuilder();
      $qb->select('e')
        ->from('Emaillog','e')
        ->where("e.valid = 'Y'")
        ->andWhere("e.accesscode = '$acode' OR e.shareaccesscode = '$acode'"); 
      $query = $qb->getQuery();
      $emaillog = $query->getSingleResult();
      $user = $emaillog->getUserid();

      //Upload a media file to Facebook.
      $sendsns = new Sendsns();
      $sendsns->setUserid($user);
      $sendsns->setSnstypecode("Facebook");
      $sendsns->setIssent('P');
      $sendsns->setSnsid($fb_user->id);
      $sendsns->setAccesstoken($access_token);
      $sendsns->setCreatedate($this->currentTime);
      $this->em->persist($sendsns);
      $this->em->flush();

      $cmsHomeUrl = $this->getOptionValue("cms_home_url");
      file_get_contents($cmsHomeUrl . "facebook/upload/" . $user->getId());

      echo "<script>window.close();</script>";
    }
}
