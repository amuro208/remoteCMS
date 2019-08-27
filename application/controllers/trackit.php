<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/doctrinautoload.php';

class TrackIt extends DoctrinAutoload {

  function __construct(){

    $parameters = array("NoAuthCheck"=>"Y");
    parent::__construct($parameters);

    $this->load->library('email'); // load the library
    $this->load->library('parser');
    $this->load->helper('url');
    $this->load->helper('mx');
    $this->load->library('user_agent');
    $this->load->database();


  }

  function index(){
  }

  public function getmediaurl(){
    $accessCode = $this->uri->segment(3);
    $origin = $this->uri->segment(4);

    if($origin == false || $origin == null){
      $origin = 'N';
    }


    log_message("debug","#############################################################");
    log_message("debug","###getmediaurl");
    log_message("debug","###AccessCode:".$accessCode);
    log_message("debug","###origin :".$origin);
    log_message("debug","#############################################################");

    $retdata = array();

    $qb = $this->em->createQueryBuilder();
    $qb->select('e')
      ->from('Emaillog','e')
      ->where("e.valid = 'Y'")
      ->andWhere("(e.accesscode = '$accessCode' OR e.shareaccesscode = '$accessCode')");
    $query = $qb->getQuery();
    try{
      $emaillog = $query->getSingleResult();
      if($emaillog != null){
        $user = $emaillog->getUserid();
        $this->config->load($this->getConfigPath($user));
        $cmsurl = $this->config->item("cms_home_url");
        $homeurl = $this->config->item("home_url");
        $edmMedia = $emaillog->getEdmmedia();
        $medias = $user->getMedias();

        if($origin == 'N'){
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
        }

        //if the system is in manual upload mode, check reserve1
        // $manualUpload = $this->getOptionValue($user->getEventcode()."_manual_upload");
        // if( "Y" == $manualUpload){
        //   if($user->getReserve1() == "Y"){
        //     $edmMedia = "Upload";
        //   }
        // }

        foreach($medias as $media){

          if($media->getValid() == "N") continue;

          if($media->getTypecode() == $edmMedia){

            $longurl = $cmsurl."uploads/".$media->getFilepath();
            $longfile = $this->uploadPath.$media->getFilepath();

            $shareurl = $homeurl."index.php?".$emaillog->getShareaccesscode();
            $shareurl2 = $homeurl."index.php?acode=".$emaillog->getShareaccesscode();
            $shorturl = get_bitly_short_url($shareurl2);

            $retdata["mediaurl"] = trim($longurl);
            $retdata["mediaid"] = trim($media->getId());
            $retdata["mediafile"] = trim($longfile);
            $retdata["longurl"] = trim($longurl);
            $retdata["shorturl"] = trim($shorturl);
            $retdata["shareurl"] = trim($shareurl);
            $retdata["shareurl2"] = trim($shareurl2);
            $retdata["eventcode"] = trim($user->getEventcode());
            $retdata["reserve1"] = trim($user->getReserve1());
            $retdata["reserve2"] = trim($user->getReserve2());
            $retdata["reserve3"] = trim($user->getReserve3());

            $retdata["fb_title"] = trim($this->config->item("fb_title"));
            $retdata["fb_message"] = trim($this->config->item("fb_message"));
            $retdata["twitter_title"] = trim($this->config->item("twitter_title"));

            // $sendsnses = $user->getSendSNSes();
            // foreach($sendsnses as $sendsns){
            //   if($sendsns->getSnstypecode() == "Youtube"){
            //     $retdata["youtubeurl"] = trim($sendsns->getSnsurl());
            //     $retdata["youtubeid"] = trim($sendsns->getSnsid());
            //     $retdata["youtubeshorturl"] = trim("https://youtu.be/".$sendsns->getSnsid());
            //   }
            // }
          }

          if($media->getTypecode() == $emaillog->getEdmmedia()){
            $longurl = $cmsurl."uploads/".$media->getFilepath();
            $retdata["edmurl"] = trim($longurl);
          }

          if($media->getTypecode() == "videoId"){
            $longurl = $cmsurl."uploads/".$media->getFilepath();
            $longfile = $this->uploadPath.$media->getFilepath();
            $retdata["videourl"] = trim($longurl);
            $retdata["videofile"] = trim($longfile);
            $retdata["videoid"] = trim($media->getId());
          }
        }
      }

    }catch(Exception $e){
      log_message("error",$e->getMessage());
    }

    echo json_encode($retdata);
    return $retdata;
  }

  public function showcontent(){
    $accessCode = $this->uri->segment(3);
    $referer = urldecode($this->uri->segment(4));
    log_message("debug","#############################################################");
    log_message("debug","###Showcontent");
    log_message("debug","###AccessCode:".$accessCode);
    log_message("debug","###Referer:".$referer);
    log_message("debug","#############################################################");

    $qb = $this->em->createQueryBuilder();
    $qb->select('e')
      ->from('Emaillog','e')
      ->where("e.valid = 'Y'")
      ->andWhere("e.accesscode = '$accessCode'");
    $query = $qb->getQuery();
    try{
      $single = $query->getSingleResult();
      $single->SetIsvalidemail('Y');
      $single->SetIsopened('Y');
      $this->em->persist($single);
      if($single != null){

        $user = $single->getUserid();
        $this->config->load($this->getConfigPath($user));
        $cmsurl = $this->config->item("cms_home_url");
        $homeurl = $this->config->item("home_url");

        $activityLog = new Activitylog();
        $activityLog->setEmaillogid($single);
        $activityLog->setPlatform($this->agent->platform());
        $activityLog->setBrowser($this->agent->browser());
        $activityLog->setVersion($this->agent->version());
        $activityLog->setReferer($this->agent->referrer());
        if($referer == "1"){
          //click contents itself
          $activityLog->setActivitytype("CNTFRMEML1");
        }else{
          //click button...
          $activityLog->setActivitytype("CNTFRMEML2");
        }
        $activityLog->setCreatedate(new DateTime('now'));
        $this->em->persist($activityLog);
        $this->em->flush();

        $redirect=$homeurl."index.php?acode=".$single->getAccesscode();
        setcookie("_aid",$activityLog->getId(),time() + 60*60*24*30, '/');
        setcookie("_acode",$accessCode,time() + 60*60*24*30, '/');
        setcookie("_freml","Y",time() + 3, '/');

        header("Location: $redirect");

        return $activityLog->getId();
      }

    }catch(Exception $e){
      log_message("error",$e->getMessage());
    }
  }

  public function clickedmlink(){
    ob_start();

    $accessCode = $this->uri->segment(3);
    log_message("debug","#############################################################");
    log_message("debug","###clickEdmLink");
    log_message("debug","###AccessCode:".$accessCode);
    log_message("debug","#############################################################");

    $qb = $this->em->createQueryBuilder();
    $qb->select('e')
      ->from('Emaillog','e')
      ->where("e.valid = 'Y'")
      ->andWhere("e.accesscode = '$accessCode'");
    $query = $qb->getQuery();
    try{
      $emaillog = $query->getSingleResult();
      log_message("debug","xxxx");
      if($emaillog != null){
        $user = $emaillog->getUserid();
        $this->config->load($this->getConfigPath($user));

        log_message("debug","There is a emaillog");
        log_message("debug","###clickEdmLink000000");

        if($emaillog->getIsopened() == 'N'){
          $emaillog->setIsvalidemail('Y');
          $emaillog->setIssent('Y');
          $emaillog->setIsopened('Y');
          $emaillog->setOpeneddate(new DateTime('now'));
        }

        $emaillog->setReserve1("Y");
        $emaillog->setUpdatedate(new DateTime('now'));

        $this->em->persist($emaillog);

        $this->em->flush();
      }
    }catch(Exception $e){
      log_message("error",$e->getMessage());
    }

    //header("Location: http://sbs.com.au/popweekend/");
  }

  public function clickedmlink2(){
    ob_start();

    $linkName = $this->uri->segment(3);
    $accessCode = $this->uri->segment(4);
    $user = null;
    log_message("debug","#############################################################");
    log_message("debug","###clickEdmLink2");
    log_message("debug","###AccessCode:".$accessCode);
    log_message("debug","#############################################################");

    $qb = $this->em->createQueryBuilder();
    $qb->select('e')
      ->from('Emaillog','e')
      ->where("e.valid = 'Y'")
      ->andWhere("e.accesscode = '$accessCode'");
    $query = $qb->getQuery();
    try{
      $emaillog = $query->getSingleResult();
      $user = $emaillog->getUserid();
      if($emaillog != null){
        $user = $emaillog->getUserid();
        $this->config->load($this->getConfigPath($user));
        
        if($emaillog->getIsopened() == 'N'){
          $emaillog->setIsvalidemail('Y');
          $emaillog->setIssent('Y');
          $emaillog->setIsopened('Y');
          $emaillog->setOpeneddate(new DateTime('now'));
        }

        if($linkName == "1"){
          log_message("debug","setReserve1");
          $emaillog->setReserve1("Y");
        }else if($linkName == "2"){
          log_message("debug","setReserve2");
          $emaillog->setReserve2("Y");
        }else if($linkName == "3"){
          log_message("debug","setReserve3");
          $emaillog->setReserve3("Y");
        }else if($linkName == "4"){
          log_message("debug","setReserve4");
          $emaillog->setReserve4("Y");
        }else if($linkName == "5"){
          log_message("debug","setReserve5");
          $emaillog->setReserve5("Y");
        }else if($linkName == "6"){
          log_message("debug","setReserve6");
          $emaillog->setReserve6("Y");
        }else if($linkName == "7"){
          log_message("debug","setReserve7");
          $emaillog->setReserve7("Y");
        }else if($linkName == "8"){
          log_message("debug","setReserve8");
          $emaillog->setReserve8("Y");
        }else if($linkName == "9"){
          log_message("debug","setReserve9");
          $emaillog->setReserve9("Y");
        }else{
          log_message("debug","setReserve10");
          $emaillog->setReserve10("Y");
        }
        $emaillog->setUpdatedate(new DateTime('now'));

        $this->em->persist($emaillog);

        $this->em->flush();
      }
    }catch(Exception $e){
      log_message("error",$e->getMessage());
    }

    $link = "";
    if($linkName == "1"){
      log_message("debug",$this->config->item("edmtrack_link1"));
      $link = $this->config->item("edmtrack_link1");
    }else if($linkName == "2"){
      log_message("debug",$this->config->item("edmtrack_link2"));
      $link = $this->config->item("edmtrack_link2");
    }else if($linkName == "3"){
      log_message("debug",$this->config->item("edmtrack_link3"));
      $link = $this->config->item("edmtrack_link3");
    }else if($linkName == "4"){
      log_message("debug",$this->config->item("edmtrack_link4"));
      $link = $this->config->item("edmtrack_link4");
    }else if($linkName == "5"){
      log_message("debug",$this->config->item("edmtrack_link5"));
      $link = $this->config->item("edmtrack_link5");
    }else if($linkName == "6"){
      log_message("debug",$this->config->item("edmtrack_link6"));
      $link = $this->config->item("edmtrack_link6");
    }else if($linkName == "7"){
      log_message("debug",$this->config->item("edmtrack_link7"));
      $link = $this->config->item("edmtrack_link7");
    }else if($linkName == "8"){
      log_message("debug",$this->config->item("edmtrack_link8"));
      $link = $this->config->item("edmtrack_link8");
    }else if($linkName == "9"){
      log_message("debug",$this->config->item("edmtrack_link9"));
      $link = $this->config->item("edmtrack_link9");
    }else{
      log_message("debug",$this->config->item("edmtrack_link10"));
      $link = $this->config->item("edmtrack_link10");
    }

    log_message("debug","link:".$link);
    log_message("debug","#############################################################");
    header("Location: ".$link);
  }

  public function openemail(){
    ob_start();

    $accessCode = $this->uri->segment(3);
    log_message("debug","#############################################################");
    log_message("debug","###Openemail");
    log_message("debug","###AccessCode:".$accessCode);
    log_message("debug","#############################################################");

    $name = __DIR__ .'/img/line.png';
    $fp = fopen($name, 'rb');
    header("Content-Type: image/png");
    header("Content-Length: " . filesize($name));
    fpassthru($fp);

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

    $qb = $this->em->createQueryBuilder();
    $qb->select('e')
      ->from('Emaillog','e')
      ->where("e.valid = 'Y'")
      ->andWhere("e.accesscode = '$accessCode'");
    $query = $qb->getQuery();
    try{
      $single = $query->getSingleResult();
      if($single != null){
        log_message("debug","There is a emaillog");
        if($single->getIsopened() == 'N'){
 	  log_message("debug","The email has not opened.");
          $single->setIsvalidemail('Y');
          $single->setIssent('Y');
          $single->setIsopened('Y');
          $single->setOpeneddate(new DateTime('now'));
          $single->setUpdatedate(new DateTime('now'));
          $this->em->persist($single);
        }

        $activityLog = new Activitylog();
        $activityLog->setEmaillogid($single);
        $activityLog->setPlatform($this->agent->platform());
        $activityLog->setBrowser($this->agent->browser());
        $activityLog->setVersion($this->agent->version());
        $activityLog->setReferer($this->agent->referrer());
        $activityLog->setActivitytype("OPENEMAIL");
        $activityLog->setCreatedate(new DateTime('now'));
        $this->em->persist($activityLog);

        $this->em->flush();
      }

    }catch(Exception $e){
      log_message("error",$e->getMessage());
    }

  }

  public function click(){
    $type = $this->uri->segment(3);
    $aid = $_COOKIE["_aid"];
    $acode = $_COOKIE["_acode"];
    log_message("debug","#############################################################");
    log_message("debug","###type:".$type);
    log_message("debug","###aid:".$aid);
    log_message("debug","###acode:".$acode);
    echo "type:".$type."<br>";
    echo "aid:".$aid."<br>";
    echo "acode:".$acode."<br>";
    log_message("debug","#############################################################");

    $alog = $this->em->find("Activitylog",$aid);
    if($alog != null){
      $elog = $alog->getEmaillogid();
      if($elog->getAccesscode() == $acode || $elog->getShareaccesscode() == $acode){
        if($type=="facebook"){
          $alog->setShared1($alog->getShared1()+1);
        }else if($type=="twitter"){
          $alog->setShared2($alog->getShared2()+1);
        }else if($type=="weibo" || $type=="instagram"){
          $alog->setShared3($alog->getShared3()+1);
        }else if($type=="download"){
          $alog->setDownloaded($alog->getDownloaded()+1);
        }else if($type=="content"){
          $alog->setClicked($alog->getClicked()+1);
        }else if($type=="banner"){
          $alog->setReserve1($alog->getReserve1()+1);
        }

        $this->em->persist($alog);
        $this->em->flush();
      }
    }
  }
}
