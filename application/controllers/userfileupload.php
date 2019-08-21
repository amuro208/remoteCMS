<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/userdata.php";

class UserFileUpload extends UserData
{
    function __construct($parameters=array())
    {
        parent::__construct(array("NoAuthCheck"=>"Y"));
    }

    public function upload_delete(){
      $fileid = $this->uri->segment(3, 0);
      log_message("debug","#####################################"); 
      log_message("debug","########### DELETE UPLOAD ###########"); 
      log_message("debug","#############".$fileid."#############"); 
      log_message("debug","#####################################"); 
      
      $media   = $this->em->getRepository("Media")
                          ->findOneBy(array(
                            'id' => $fileid,
                            'valid' => 'Y'
                         ));

      $media->setValid("N");
      $media = $this->setUpdateControlData($media);
      $this->em->persist($media);
      $this->em->flush();

      $user = $media->getUserid();
      $retData = $this->fetchEntityReturnData($user);
      echo json_encode(array("status"=>"success","msg"=>"","user"=>$retData));
    }

    public function upload_post(){
      $status = "";
      $msg = "";

      $userid = $this->uri->segment(3, 0);
      $user   = $this->em->getRepository($this->entityName)
                         ->findOneBy(array(
                            'id' => $userid,
                            'valid' => 'Y'
                         ));

      $config['upload_path']   = $this->uploadPath.$user->getEventcode()."/".date('Y-m-d');
      $config['allowed_types'] = 'gif|jpg|jpeg|png|mp4';
      $config['overwrite']     = false;
      $config['max_size']      = 1024*10;
      $this->load->library('upload', $config);
      $this->upload->initialize($config);

      if(!file_exists($config['upload_path'])){
        mkdir($config['upload_path']);
      }
      
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
            $media->setTypecode("Upload");
            $media->setFilepath($user->getEventcode()."/".date('Y-m-d')."/".$data["file_name"]);
            $media->setFilename($data["file_name"]);
            $media->setMimetype($data["file_type"]);
            $media->setCreatedate($this->currentTime);
            $this->em->persist($media);
            $this->em->flush();

            $value = $this->getOptionValue($user->getEventcode()."_make_remotethumbnail");
            if(false != $value && "Y" == $value){
              $this->make_thumbnail($media);
            }

            log_message("debug","+++".$key." is uploaded.");
            $msg = array(
              "fileName" => $data["client_name"],
              "fileType" => $data["file_type"],
              "filePath" => $data["file_path"],
              "fullPath" => $data["full_path"],
              "fileSize" => $data["file_size"],
              "fileId"   => $media->getId()
            );
            $retData = $this->fetchEntityReturnData($user);
            echo json_encode(array("status"=>"success","msg"=>$msg,"user"=>$retData));
          }
        }catch(Exception $e){
          log_message("error",$e->getMesssage());
          $this->printErrorMessage("Could not upload file : ".$e->getMessage());
          return;
        }
      }
    }
}
