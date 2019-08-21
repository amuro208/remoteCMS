<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/doctrinautoload.php';

class RfidRegister extends DoctrinAutoload
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
      log_message("debug","#######################START REGISTER RFID##############################");
      log_message("debug","####################################################################");
      log_message("debug","#######################CHECK INPUT##################################"); 
      log_message("debug",json_encode($this->input));
      log_message("debug","#######################CHECK _POST##################################"); 
      log_message("debug",json_encode($_POST));
      log_message("debug","####################################################################");

      $rfid = new Rfid();
      $rfid->setFirstname($this->input->post("firstName"));
      $rfid->setLastname($this->input->post("lastName"));
      $rfid->setBod($this->input->post("BOD"));
      $rfid->setEmail($this->input->post("email"));
      $rfid->setMobile($this->input->post("mobile"));
      $rfid->setRfid($this->input->post("rfid"));
      $rfid->setFbuserid($this->input->post("fbUserId"));
      $rfid->setAccesscode($this->input->post("accessCode"));
      $rfid->setCreatedate($this->currentTime);
      $this->em->persist($rfid);
      $this->em->flush();

      $this->printSuccessMessage("");

      log_message("debug","####################################################################");
      log_message("debug","########################END REGISTER RFID###############################");
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
      log_message("debug","########################START AFTER REGISTER RFID###############################");

      log_message("debug","########################END AFTER REGISTER RFID ################################");
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
