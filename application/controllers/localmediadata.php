<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . "/api/basedata.php";

class LocalMediaData extends BaseData
{
    function __construct($parameters=array())
    {
        parent::__construct(array("NoAuthCheck"=>"Y"));

        $this->entityName = "Localmedia";

        $this->entityInfo = array(
          "id"              =>"",
          "filePath"        =>"String",
          "fileName"        =>"String",
          "typeCode"        =>"String",
        );

        $this->load->database();
    }

    function file_get(){
        log_message("debug","------------------START FILE---------------------");
        $id = $this->get('id');
        $thumbnail = $this->get('thumbnail');
        
        log_message("debug","------------------FILE---------------------");
        $media = $this->em->find($this->entityName,$id);
        $src = $this->localUploadPath . $media->getFilepath();
        $filePath = $media->getFilepath();
        $fileName = $media->getFilename();

        /*
        $query = $this->db->query("select * from localmedia where id = $id ");
        foreach($query->result() as $row){
          $src =$this->localUploadPath . $row->filePath;         
          $filePath = $row->filePath;         
          $fileName = $row->fileName;         
        }
        */
        log_message("debug","------------------FILE---------------------");

        $destFilepath = str_replace($fileName,"thumb_".$thumbnail."_".$fileName,$filePath);
        $destFilepath = str_replace(".png",".jpg",$destFilepath);
        $destFilepath = str_replace(".gif",".jpg",$destFilepath);
        $destFilepath = str_replace(".bmp",".jpg",$destFilepath);
        $dest = $this->localUploadPath . $destFilepath; 

        log_message("debug","------------------FILE---------------------");
        if(!file_exists($dest)){
          $this->make_thumb($src,$dest,$thumbnail);
        }

        header("Content-Type: image/jpg");
        echo file_get_contents($dest);
        log_message("debug","------------------END FILE---------------------");
    }

    function make_thumb($src, $dest, $desired_width) {
        /* read the source image */
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        
        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));
        
        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        
        /* copy source image at a resized size */
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        
        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, $dest);

        imagedestroy($virtual_image);
    }
}
