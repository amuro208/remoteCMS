<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/autoload.php';
require_once APPPATH . 'libraries/ImageManipulator.php';

class DoctrinAutoload extends CI_Controller{

  protected $authUser = null;
  protected $em;
  protected $D;
  protected $E;

  protected $uploadPath;
  protected $localUploadPath;
  protected $currentTime;

  protected $imageTypes = array(
    "image/jpeg","image/gif","image/png","image/bmp"
  );

  function __construct($parameters = array())
  {
    parent::__construct();

    $this->config->load('uploadpath');

    if(!isset($parameters["em"]) || $parameters["em"] == null){
      $this->em = $this->doctrine->em;
    }else{
      $this->em = $parameters["em"];
    }
    //$this->em = $this->doctrine->em;
    $this->D = true;
    $this->E = true;

    $this->uploadPath =__DIR__ . $this->config->item("remote_path");
    $this->localUploadPath =__DIR__ . $this->config->item("local_path");

    log_message("debug","uploadPath:".__DIR__ . $this->config->item("remote_path"));
    log_message("debug","localUploadPath:".__DIR__ . $this->config->item("local_path"));

    $this->currentTime =new \DateTime("now");

    $autoload = new Autoload($this);

    if(isset($parameters["NoAuthCheck"])){

    }else{
      $this->authUser = $autoload->parseUser();
    }
  }

  public function log($str){
    if($this->D) log_message("debug",$str);
  }

  public function error($e){
    if($this->E) log_message("error",$e);
  }

  public function checkAuth(){
    if(isset($_GET["test"]) && $_GET["test"] == "Y") return true;
    if($this->authUser == null || $this->authUser == false) return false;
    return true;
  }

  public function getCodeName($category,$code){
    return $this->em->getRepository("Code")->findOneBy(array("category"=>$category,"code"=>$code,"valid"=>"Y"))->getName();
  }

  protected function getOption($name){
      $option = $this->em->getRepository("Systemoption")->findOneBy(array(
                   "valid" => "Y",
                   "name" => $name
                 ));
      return $option;
  }

  protected function getOptionValue($name){
      $option = $this->em->getRepository("Systemoption")->findOneBy(array(
                   "valid" => "Y",
                   "name" => $name
                 ));
      if($option != null) return $option->getValue();
      return false;
  }

  protected function updateOption($name,$value){
      $option = $this->em->getRepository("Systemoption")
                         ->findOneBy(array(
                             "valid" => "Y",
                             "name" => $name
                           ));
      if($option == null){
        $option = new Systemoption();
        $option->setName($name);
      }
      $option->setValue($value);
      $this->em->persist($option);
      $this->em->flush();
  }

  function sendData2ServerViaGet($url)
  {
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
    $response = curl_exec($ch);
    $error    = curl_error($ch);
    curl_close($ch);

    return $response;
  }

  function sendData2ServerViaPost($url, $data)
  {
    log_message("debug","===========================~sendData2ServerViaPost===========================");
    log_message("debug","url=".$url);
    log_message("debug","data=".json_encode($data));
    log_message("debug","===========================~sendData2ServerViaPost===========================");

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
    curl_setopt($ch, CURLOPT_TIMEOUT, 600);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    $error    = curl_error($ch);
    curl_close($ch);

    log_message("debug","===========================~sendData2ServerViaPost===========================");
    log_message("debug","response=".$response);
    log_message("debug","error=".$error);
    log_message("debug","===========================~sendData2ServerViaPost===========================");
    return $response;
  }

  function get_remote_size($url) {
    $headers = get_headers($url, 1);
    if (isset($headers['Content-Length'])) return $headers['Content-Length'];
    if (isset($headers['Content-length'])) return $headers['Content-length'];

    $c = curl_init();
    curl_setopt_array($c, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => array('User-Agent: Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.5; en-US; rv:1.9.1.3) Gecko/20090824 Firefox/3.5.3'),
        ));
    curl_exec($c);
    return curl_getinfo($c, CURLINFO_SIZE_DOWNLOAD);
  }

  function sendData2ServerViaFTP($filePath){
    global $logger;

    $ftp_server = $this->getOptionValue("ftp_server");
    $ftp_user = $this->getOptionValue("ftp_user");
    $ftp_password = $this->getOptionValue("ftp_password");
    $ftp_root_url = $this->getOptionValue("ftp_root_url");

    log_message("error","===========================~uploadFile2ServerViaFTP===========================");
    log_message("debug","$filePath");
    log_message("debug","$ftp_server");
    log_message("debug","$ftp_user");
    log_message("debug","$ftp_password");
    log_message("error","===========================~uploadFile2ServerViaFTP===========================");


    if(!$ftp_server || !$ftp_user || !$ftp_password){
      log_message("error","===========================~uploadFile2ServerViaFTP===========================");
      log_message("error","The options for FTP(ftp_server,ftp_user,ftp_password) might be not set yet.");
      log_message("error","===========================~uploadFile2ServerViaFTP===========================");
      return false;
    }

    try{
      $localfile = $filePath;
      $fileName = basename($filePath);
      log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
      log_message("debug","file=".$localfile);
      log_message("debug","filesize=".filesize($localfile));
      log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
      $fp = fopen($localfile, 'r');
      if($fp === false){
        log_message("error","===========================~uploadFile2ServerViaFTP===========================");
        log_message("error","Could not open the stream of the file . ".$localfile);
        log_message("error","===========================~uploadFile2ServerViaFTP===========================");
        return false;
      }else{
        log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
        log_message("debug","opened the stream of the file . ".$localfile);
        log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
      }

      // set up basic connection
      $conn_id = ftp_connect($ftp_server,21,5);
      if($conn_id === false){
        log_message("error","===========================~uploadFile2ServerViaFTP===========================");
        log_message("error","Could not connect FTP Server.");
        log_message("error","===========================~uploadFile2ServerViaFTP===========================");
        return false;
      }else{
        log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
        log_message("debug","connected FTP Server.");
        log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
      }

      // login with username and password
      ftp_set_option($conn_id, FTP_TIMEOUT_SEC, 5);
      $login_result = ftp_login($conn_id, $ftp_user, $ftp_password);
      if($login_result === false){
        log_message("error","===========================~uploadFile2ServerViaFTP===========================");
        log_message("error","Could not login to FTP Server.");
        log_message("error","===========================~uploadFile2ServerViaFTP===========================");
        return false;
      }else{
        log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
        log_message("debug","logined to FTP Server.");
        log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
      }
      ftp_pasv($conn_id, true);

      $url = $ftp_root_url.$fileName;
      $fsize = $this->get_remote_size($url);
      log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
      log_message("debug","Found existed file url - ".$url);
      log_message("debug","Found existed file filename- ".$fileName);
	    log_message("debug","Found existed file fsize- ".$fsize);
      log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
      $startpos = 0;
      if ($fsize != -1){
        if($fsize > 1024*1024){ //1MB...
          $startpos = $fsize;
        }
      }
      /*
      $fsize = ftp_size($conn_id, $fileName);
      $startpos = 0;
	    log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
      log_message("debug","Found existed file - ".$fileName);
	    log_message("debug","Found existed file - ".$startpos);
      log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
      if ($fsize != -1){
        $startpos = $fsize;
      }
      */

      // upload a file
      $result = false;
      if (ftp_fput($conn_id, $fileName, $fp, FTP_BINARY, $startpos)) {
        log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
        log_message("debug","return:true");
        log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
        //echo "successfully uploaded $file\n";
        $result = true;
      } else {
        log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
        log_message("debug","return:false");
        log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
        //echo "There was a problem while uploading $file\n";
        $result = false;
      }

      // close the connection
      ftp_close($conn_id);
    }catch(Exception $e){
      log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
      log_message("error",$e->getMessage());
      log_message("debug","===========================~uploadFile2ServerViaFTP===========================");
      $result = false;

      ftp_close($conn_id);
    }

    return $result;
  }

  function waitFor($file, $delay = 0.1,$max = 100){
      $index = 0;
      log_message("debug","Check if the file is changing");
      if (file_exists($file)) {
          $current_size = filesize($file);
          while (true) {
              usleep($delay*1000000);
              clearstatcache(false, $file); // requires >= 5.3
              $new_size = filesize($file);
              $index++;
              if($index == $max){
                  log_message("debug","It's being copied.");
                  return false;
              }
              if($new_size == $current_size) {
                  break;
              }
              $current_size = $new_size;
          }
          log_message("debug","It's ok.");
          return $current_size;
      } else {
          log_message("debug","There is no file now.");
          return false;
      }
  }

  private function copyMediaFile($user,$mediaType,$mediaId,$rootPath,$fileExt){
    $mediaFile = $rootPath.$mediaId.$fileExt;
    //Several Options.
    $fileExts = explode("|",$fileExt);
    if(count($fileExts) > 1){
      $found = false;
      foreach($fileExts as $ext){
        $mediaFile = $rootPath.$mediaId.$ext;
        if(file_exists($mediaFile)){
          $fileExt = $ext;
          $found = true;
          break;
        }
      }
      if(!$found){
        foreach($fileExts as $ext){
          $mediaFile = $rootPath.$mediaId.$ext;
          log_message("error","There is no file for $mediaFile on $rootPath");
          log_message("error","There might be something wrong in option for '".$user->getEventcode()."_file_ext'");
        }
        return false;
      }
    }

    //if(file_exists($mediaFile)){
    //check if the file is changinge for 2 seconds.
    if($this->waitFor($mediaFile)){
      //Copy the file into CMS.
      $medias = $user->getMedias();
      $found = false;
      foreach($medias as $media){
        log_message("debug","XXXX=".$media->getTypecode());
        if($media->getTypecode() == $mediaType){
          $found = true;
          break;
        }
      }

      if(!$found || !file_exists($this->localUploadPath.$user->getEventcode()."/".date('Y-m-d')."/".$mediaId.$fileExt)){
        copy($mediaFile, $this->localUploadPath.$user->getEventcode()."/".date('Y-m-d')."/".$mediaId.$fileExt);

        $media = new Localmedia();
        $media->setUserid($user);
        $media->setTypecode($mediaType);
        $media->setFilepath($user->getEventcode()."/".date('Y-m-d')."/".$mediaId.$fileExt);
        $media->setFilename($mediaId.$fileExt);
        $media->setMimetype($this->getMimetype($mediaId.$fileExt));
        $media->setCreatedate($this->currentTime);
        $this->em->persist($media);

        log_message("debug","### $mediaType $mediaId is copied.");
      }else{

        log_message("debug","### $mediaType $mediaId has already copied.");
      }
    }else{
      log_message("error","There is no file or being copied for $mediaFile on $rootPath");
      return false;
    }

    return true;
  }

  protected function copyMedia($user,$mediaType,$mediaId){
    //Making local upload path.
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
    //--------------------------------------------------------

    $rootPath = $this->getOptionValue($user->getEventcode()."_root_path");
    if($rootPath !== false){
      //Copy original file.
      log_message("debug","copying original file...");
      $fileExt = $this->getOptionValue($user->getEventcode()."_file_ext");
      if($fileExt === false){
        log_message("error","There is no option for '".$user->getEventcode()."_file_ext'");
        return false;
      }
      if($this->copyMediaFile($user,$mediaType,$mediaId,$rootPath,$fileExt)===false){
        return false;
      }

      //Has Thumbnail
      log_message("debug","copying thumbnail file...");
      $hasThumbnail = $this->getOptionValue($user->getEventcode()."_has_thumbnail");
      if($hasThumbnail !== false && $hasThumbnail == "Y"){
        $fileExt = $this->getOptionValue($user->getEventcode()."_thumbnail_ext");
        $mediaType2 = $mediaType."_thumb";
        $mediaId2 = $mediaId."_thumb";
        if($this->copyMediaFile($user,$mediaType2,$mediaId2,$rootPath,$fileExt)===false){
          return false;
        };
      }

      //Has EDM
      log_message("debug","copying edm file...");
      $hasEDM = $this->getOptionValue($user->getEventcode()."_has_edm");
      if($hasEDM !== false && $hasEDM == "Y"){
        $fileExt = $this->getOptionValue($user->getEventcode()."_edm_ext");
        $mediaType2 = $mediaType."_edm";
        $mediaId .= "_edm";
        if($this->copyMediaFile($user,$mediaType2,$mediaId,$rootPath,$fileExt)===false){
          return false;
        };
      }

    }else{
      log_message("error","There is no option for '".$user->getEventcode()."_root_path'");
      return false;
    }

    return true;
  }

  function getMimetype($file)
  {
    // our list of mime types
    $mime_types = array(
      "pdf"=>"application/pdf"
      ,"exe"=>"application/octet-stream"
      ,"zip"=>"application/zip"
      ,"docx"=>"application/msword"
      ,"doc"=>"application/msword"
      ,"xls"=>"application/vnd.ms-excel"
      ,"ppt"=>"application/vnd.ms-powerpoint"
      ,"gif"=>"image/gif"
      ,"png"=>"image/png"
      ,"jpeg"=>"image/jpeg"
      ,"jpg"=>"image/jpeg"
      ,"mp3"=>"audio/mpeg"
      ,"wav"=>"audio/x-wav"
      ,"mpeg"=>"video/mpeg"
      ,"mpg"=>"video/mpeg"
      ,"mpe"=>"video/mpeg"
      ,"mov"=>"video/quicktime"
      ,"avi"=>"video/x-msvideo"
      ,"3gp"=>"video/3gpp"
      ,"css"=>"text/css"
      ,"jsc"=>"application/javascript"
      ,"js"=>"application/javascript"
      ,"php"=>"text/html"
      ,"htm"=>"text/html"
      ,"html"=>"text/html"
      ,"mp4"=>"video/mp4"
    );
    $extension = strtolower(end(explode('.',$file)));
    return $mime_types[$extension];
  }

  private $types = array(
    ".png"=>IMAGETYPE_PNG,
    ".gif"=>IMAGETYPE_GIF,
    ".jpg"=>IMAGETYPE_JPEG
  );

  function make_localthumbnail($media){
      $fileName = $media->getFilename();
      $mimeType = $media->getMimetype();
      if(in_array($mimeType,$this->imageTypes)){
          $filePath = $media->getFilepath();
          $thumbFilepath = str_replace($fileName,"thumb_50_".$fileName,$filePath);

          $src = $this->localUploadPath.$media->getFilepath();
          $dest = $this->localUploadPath.$thumbFilepath;

          try{
            $manipulator = new ImageManipulator($src);
            $manipulator->resample(50,40,true);
            $fileExtension = strrchr($dest, ".");
            $manipulator->save($dest,$this->types[$fileExtension]);
          }catch(Exception $e){
            log_message("error",$e->getMessage());
            return false;
          }

          $media->setThumbfilepath($thumbFilepath);
          $this->em->persist($media);
          return $thumbFilepath;
      }
      return "";
  }

  function make_thumbnail($media){
      try{
        $fileName = $media->getFilename();
        $mimeType = $media->getMimetype();
        if(in_array($mimeType,$this->imageTypes)){
            $filePath = $media->getFilepath();
            $thumbFilepath = str_replace($fileName,"thumb_50_".$fileName,$filePath);

            $src = $this->uploadPath.$media->getFilepath();
            $dest = $this->uploadPath.$thumbFilepath;

            try{
              $manipulator = new ImageManipulator($src);
              $manipulator->resample(50,40,true);
              $fileExtension = strrchr($dest, ".");
              $manipulator->save($dest,$this->types[$fileExtension]);
            }catch(Exception $e){
              log_message("error",$e->getMessage());
              return false;
            }

            $media->setThumbfilepath($thumbFilepath);
            $this->em->persist($media);
            return $thumbFilepath;
        }
      }catch(Exception $e){
      }
      return "";
  }

  function getConfigPath($user){
    return "projects/project-conf-".$user->getProjectcode();
  }
}
