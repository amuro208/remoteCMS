<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/doctrinautoload.php';

class MVPList extends DoctrinAutoload
{

  function __construct($parameters=array())
  {
    parent::__construct();
    $this->load->database();
  }

  public function index(){
    $sql="
SELECT a.teamPlayerCode id,count(*) cnt
  FROM `localuser` a
 WHERE a.eventCode = 'MVP'
 GROUP BY a.teamPlayerCode
 ORDER BY a.teamPlayerCode
      ";
    $query = $this->db->query($sql);
    $datas = $query->result_array();

    //echo json_encode($datas);
    echo "<mvplists>";
    foreach($datas as $data){
      echo '<player id="'.$data->id.'" count="'.$data->cnt.'"/>';
    }
    echo "</mvplists>";
  }
}
