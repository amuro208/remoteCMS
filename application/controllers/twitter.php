<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/doctrinautoload.php';
require_once APPPATH . "libraries/twitter/autoload.php";

use Abraham\TwitterOAuth\TwitterOAuth;

class Twitter extends DoctrinAutoload {

    private $token;
    protected $twitter;
    
    function __construct()
    {
      parent::__construct(array("NoAuthCheck"=>"Y"));
      $this->load->database();
      $this->config->load('twitter');
      $this->load->helper('url');

    }

    public function index()
    {

    }
    
    public function upload(){
      log_message("debug","###################################################");
      log_message("debug","############# START TWITTER UPLOAD ################");
      log_message("debug","###################################################");

      $acode = $this->uri->segment(3);
      $qb = $this->em->createQueryBuilder();
      $qb->select('e')
        ->from('Emaillog','e')
        ->where("e.valid = 'Y'")
        ->andWhere("e.accesscode = '$acode' OR e.shareaccesscode = '$acode'"); 
      $query = $qb->getQuery();
      $emaillog = $query->getSingleResult();
      $user = $emaillog->getUserid();

      //$user = $this->em->find("User", $userid);
      $sendsnses = $user->getSendSNSes(); 

      $app_key = $this->config->item("twitter_api_key");
      $app_secret = $this->config->item("twitter_secret");

      foreach($sendsnses as $sendsns){
        if($sendsns->getAccesscode() === $acode){
          $status = $sendsns->getIssent();
          $snsid = $sendsns->getSnsid();

          if($status == "S" || $status == "Y"){
              continue;
          }

          $sendsns->setIssent("S");
          $this->em->persist($sendsns);

          $this->twitter = new TwitterOAuth($app_key, 
                                            $app_secret, 
                                            $sendsns->getAccesstoken(),
                                            $sendsns->getSecrettoken());
          $this->twitter->setTimeouts(60, 30);

          try{
            $medias = $user->getMedias();

            $edmMedia = $emaillog->getEdmmedia();

            /*
            $tmpEdmMedia = str_replace("_edm","",$edmMedia);
            if($tmpEdmMedia !== $edmMedia){
              foreach($medias as $media){
                if($media->getValid() === "N") continue;
                if($media->getTypecode() === $tmpEdmMedia){
                  $edmMedia = $tmpEdmMedia;    
                  break;
                }
              }
            }
            */

            log_message("debug","###edmMedia:".$edmMedia);

            $filePath = "";
            //$photoMediaType = true;
            foreach($medias as $media){
              if($media->getTypecode() == $edmMedia){
                $filePath = $media->getFilepath();
                //$photoMediaType = false;
                break;
              }
            }
            log_message("debug","###filePath:".$filePath);
            /*
            if($photoMediaType){
              foreach($medias as $media){
                if($media->getTypecode() == "FileData00"){
                  $filePath = $media->getFilepath();
                  break;
                }

                if($media->getTypecode() == "photoId"){
                  $filePath = $media->getFilepath();
                  break;
                }
              }
            }
            */

            if($filePath == ""){
              $sendsns->setIssent("N");
              $this->em->persist($sendsns);
              continue;
            }

            $message = $this->getOptionValue($user->getEventcode()."_twitter_title");
            $photoPath = $this->uploadPath . $filePath;

            $result = $this->twitter->upload('media/upload', array('media' => $photoPath));
            $this->twitter->post('statuses/update', array('status' =>$message,"media_ids" => $result->media_id));

            log_message("debug","twiter result---------------------------------");
            log_message("debug",json_encode($result));
            log_message("debug","twiter result---------------------------------");

            if(!empty($result)){
              $sendsns->setIssent("Y");
              $sendsns->setUpdatedate(new DateTime('now'));
              $sendsns->setSnsurl($result->media_id);
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
      }

      $this->em->flush();

      log_message("debug","###################################################");
      log_message("debug","############## END TWITTER UPLOAD #################");
      log_message("debug","###################################################");
    }

    public function oauth2callback(){
      session_start();

      if(isset($_GET["acode"])){
        $_SESSION["acode"] = $_GET["acode"];
      }

      $app_key = $this->config->item("twitter_api_key");//"590751330982720";
      $app_secret = $this->config->item("twitter_secret");//"40e1cf151cc03e2764aac1c9ba0a29a4";
      $app_callback = $this->config->item("twitter_callbaclurl");//"http://www.sbspopweekend.com.au/fb_test.php?x=1243";
 
      $code = "";
      if(isset($_GET["oauth_verifier"])){
        $code = $_GET["oauth_verifier"];
      }

      //TWITTER APP KEYS
      $consumer_key = $app_key;
      $consumer_secret = $app_secret;

      if(empty($code)) {
          //CONNECTION TO THE TWITTER APP TO ASK FOR A REQUEST TOKEN
          $connection = new TwitterOAuth($consumer_key, $consumer_secret);
          $request_token = $connection->oauth("oauth/request_token", array("oauth_callback" => $app_callback));
          //callback is set to where the rest of the script is

          //TAKING THE OAUTH TOKEN AND THE TOKEN SECRET AND PUTTING THEM IN COOKIES (NEEDED IN THE NEXT SCRIPT)
          $oauth_token=$request_token['oauth_token'];
          $token_secret=$request_token['oauth_token_secret'];
          //setcookie("token_secret", " ", time()-3600);
          //setcookie("token_secret", $token_secret, time()+60*10);
          //setcookie("oauth_token", " ", time()-3600);
          //setcookie("oauth_token", $oauth_token, time()+60*10);
          
          $_SESSION["token_secret"] = $token_secret;
          $_SESSION["oauth_token"] = $oauth_token;

          //GETTING THE URL FOR ASKING TWITTER TO AUTHORIZE THE APP WITH THE OAUTH TOKEN
          $url = $connection->url("oauth/authorize", array("oauth_token" => $oauth_token));

          //REDIRECTING TO THE URL
          header('Location: ' . $url);

          return;
      }

      //GETTING ALL THE TOKEN NEEDED
      $oauth_verifier = $_GET['oauth_verifier'];
      //$token_secret = $_COOKIE['token_secret'];
      //$oauth_token = $_COOKIE['oauth_token'];
      $token_secret = $_SESSION["token_secret"];
      $oauth_token = $_SESSION["oauth_token"];

      //EXCHANGING THE TOKENS FOR OAUTH TOKEN AND TOKEN SECRET
      $connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $token_secret);
      $access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $oauth_verifier));

      $accessToken=$access_token['oauth_token'];
      $secretToken=$access_token['oauth_token_secret'];

      $acode = $_SESSION["acode"];
      
      $qb = $this->em->createQueryBuilder();
      $qb->select('e')
        ->from('Emaillog','e')
        ->where("e.valid = 'Y'")
        ->andWhere("e.accesscode = '$acode' OR e.shareaccesscode = '$acode'"); 
      $query = $qb->getQuery();
      $emaillog = $query->getSingleResult();
      $user = $emaillog->getUserid();

      $sendsns = new Sendsns();
      $sendsns->setUserid($user);
      $sendsns->setAccesscode($acode);
      $sendsns->setSnstypecode("Twitter");
      $sendsns->setIssent('P');
      $sendsns->setAccesstoken($accessToken);
      $sendsns->setSecrettoken($secretToken);
      $sendsns->setCreatedate($this->currentTime);
      $this->em->persist($sendsns);
      $this->em->flush();

      $cmsHomeUrl = $this->getOptionValue("cms_home_url");
      //file_get_contents($cmsHomeUrl . "twitter/upload/" . $user->getId());
      file_get_contents($cmsHomeUrl . "twitter/upload/" . $acode);

      echo "<script>window.close();</script>";
    }
}
