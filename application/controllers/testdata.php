<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/autoload.php';

class TestData extends CI_Controller
{
  private $codedata;
  function __construct($parameters=array())
  {
      parent::__construct($parameters);

      new Autoload($this);

      $this->load->helper('form'); //loading form helper
      $this->em = $this->doctrine->em;
  }

  public function index(){
      log_message("debug","######################################################################################################");
      log_message("debug","#######################START UPLOAD##############################");
      log_message("debug","#################################################################");
      log_message("debug","#######################CHECK INPUT###############################"); 
      log_message("debug",json_encode($this->input));
      log_message("debug","#######################CHECK _POST###############################"); 
      log_message("debug",json_encode($_POST));
      log_message("debug","#######################CHECK _FILES###############################"); 
      log_message("debug",json_encode($_FILES));
      log_message("debug","#################################################################");

      //$this->codedata = new Codedata(array("NoAuthCheck"=>"Y"));
      $list = $this->em->getRepository("Code")->findBy(array(
                "category"=>"EVENT",
                "valid"=>"Y" 
              ));
      foreach($list as $code){
        log_message("debug",$code->getCode());
      }

      //File Upload....
      $config['upload_path'] = __DIR__ . "/../uploads";
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_size']	= '2048';
      $config['max_width']  = '1024';
      $config['max_height']  = '768';

      $this->load->library('upload', $config);
      if (!$this->upload->do_upload('FileData'))
      {
        $error = array('error' => $this->upload->display_errors());
        log_message("error",$this->upload->display_errors());
        //$this->load->view('upload_form', $error);
      }
      else
      {
        $data = array('upload_data' => $this->upload->data());
        
        log_message("debug","###uploaded data".json_encode($data));

        //$this->load->view('upload_success', $data);
      }
      
      $this->printSuccessMessage();


      log_message("debug","#################################################################");
      log_message("debug","########################END UPLOAD###############################");
      log_message("debug","######################################################################################################");
  }

  private function printErrorMessage($msg){
    echo '<result_data>';
    echo '  <result status="error" message="'.$msg.'" />';
    echo '</result_data>';
  }

  private function printSuccessMessage(){
    echo '<result_data>';
    echo '  <result status="success" message="" />';
    echo '</result_data>';
  }
}

