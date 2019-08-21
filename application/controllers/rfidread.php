<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/doctrinautoload.php';

class RfidRead extends DoctrinAutoload
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
      log_message("debug","#######################START READ RFID##############################");
      log_message("debug","####################################################################");
      log_message("debug","#######################CHECK INPUT##################################"); 
      log_message("debug",json_encode($this->input));
      log_message("debug","#######################CHECK _POST##################################"); 
      log_message("debug",json_encode($_POST));
      log_message("debug","####################################################################");

      $localrfidscan = new Localrfidscan();
      $localrfidscan->setRfid($this->input->post("rfid"));
      $localrfidscan->setCreatedate($this->currentTime);
      $this->em->persist($localrfidscan);
      $this->em->flush();

      $this->printSuccessMessage("");

      log_message("debug","####################################################################");
      log_message("debug","########################END READ RFID###############################");
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
      log_message("debug","########################START AFTER READ RFID###############################");

      log_message("debug","########################END AFTER READ RFID ################################");
      log_message("debug","######################################################################################################");
  }

  private function printErrorMessage($msg){
    $result = array(
      "status"=>"error",
      "message"=>$msg
    );
    echo json_encode($result);
  }

  private function printSuccessMessage($message){
    $result = array(
      "status"=>$message,
      "message"=>"success"
    );
    echo json_encode($result);
  }
}
