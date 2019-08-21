<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

    function __construct()
    {
      parent::__construct();

      $this->load->database();
      $this->load->helper('url');
    }

    public function index()
    {
        $sql = "SELECT name,value FROM systemoption a WHERE valid = 'Y' AND name in ('cms_version','cms_name')";
        $query = $this->db->query($sql);
        $datas = $query->result_array();

        $data = array();
        foreach($datas as $row){
          if($row['name'] == 'cms_version'){
            $data['version'] = $row['value'];
          }else if($row['name'] == 'cms_name'){
            $data['name'] = $row['value'];
          }
        }

        $this->load->view('welcome_message',$data);
    }
}