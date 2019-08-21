<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/autoload.php';
require_once APPPATH . 'libraries/REST_Controller.php';
require_once APPPATH . 'libraries/ImageManipulator.php';

class DoctrinAutoloadRestful extends REST_Controller{

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

    if(!isset($parameters["em"]) || $parameters["em"] == null){
      $this->em = $this->doctrine->em;
    }else{
      $this->em = $parameters["em"];
    }

    $this->config->load('uploadpath');
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
      if($this->get("TEST") != "Y"){
        $sendError = true;        
        if(isset($parameters["NoSendError"])){
          $sendError = false;        
        }

        $this->authUser = $autoload->parseUser($sendError);
      }
    }
  }

  protected function log($str){
    if($this->D) log_message("debug",$str);
  }

  protected function error($e){
    if($this->E) log_message("error",$e);
  }

  protected function checkAuth(){
    if($this->get("TEST") == "Y") return true;
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
      return "";
  }
}
