<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/doctrinautoload.php';

class Ping extends DoctrinAutoload{
  
  function __construct($parameters=array())
  {
    parent::__construct(array("NoAuthCheck"=>"Y"));
    $this->load->database();
    $this->load->helper('url');
    $this->em = $this->doctrine->em;
  }

  public function index(){
    log_message("debug","################START ping()################");
    
    $sql = '
      SELECT count(*) RX,
             sum(case when isRemoteSynced = "Y" then 1 else 0 end) TX,
             0 BX
        FROM localuser a
       WHERE valid = "Y"           
    ';
    
    $query = $this->db->query($sql);
    $rows = $query->row();
    
    $agenturloption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"agent_url"));
    $kioskcodeoption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"kiosk_code"));
    
    if($agenturloption != null) $agenturl = $agenturloption->getValue();
    if($kioskcodeoption != null) $kioskcode = $kioskcodeoption->getValue();

    $flag = $this->uri->segment(3);

    $pingurl = $agenturl."?kioskCode=".$kioskcode.
                    "&action=ping&status=".$flag.
                    "&rx=".$rows->RX.
                    "&bx=".$rows->BX.
                    "&tx=".$rows->TX;
    log_message("debug",$pingurl);
    
    try{
      $ctx = stream_context_create(
          array('http'=>array('timeout'=>5)));
      $action = file_get_contents($pingurl,false,$ctx);
    }catch(Exception $e){
      echo $e;
    }
    
    log_message("debug","return : ".$action);
    log_message("debug","################END ping()################");

    if($action !== false){
      log_message("debug","action:".$action);
      $data = json_decode($action);
      
      if(@$data->deleteposts == "on"){
        $this->deletePosts($data->deleteposts_kind);
      }
      if(@$data->downloadconfig == "on"){
        $this->downloadConfig(stripslashes(html_entity_decode($data->config)));
      }
      if(@$data->uploadconfig == "on"){
        $this->uploadConfig();
      }
      if(@$data->gitpull == "on"){
        $this->gitpull();
      }
    } 
    log_message("debug","################END ping()################");
  }

  function gitpull(){
    log_message("debug","###START gitpull()");
    $gitcommandoption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"git_command"));
    if($gitcommandoption!=null) $gitcommand = $gitcommandoption->getValue();
    $batchfile = __DIR__ . "\\tcsgitpull.bat";
    if (!file_exists($batchfile)) {
      $data = "cd " . __DIR__ . "\n";
      $data .= "cd .."."\n";
      $data .= $gitcommand."\n";
      $data .= "cd .."."\n";
      $data .= "cd htdocs"."\n";
      $data .= "cd static"."\n";
      $data .= $gitcommand."\n";
      file_put_contents($batchfile, $data);
    }
    exec("cmd.exe /c " . $batchfile);
    log_message("debug","###END gitpull()");
  }
  
  function deletePosts($kind){
    log_message("debug","###START deletePosts()");
    $this->db->empty_table('localrfidscan');
    $this->db->empty_table('localmedia');
    $this->db->empty_table('localuser');
    $this->db->empty_table('activitylog');
    $this->db->empty_table('emaillog');
    $this->db->empty_table('rfidscan');
    $this->db->empty_table('media');
    $this->db->empty_table('rfid');
    $this->db->empty_table('user');
    log_message("debug","###END deletePosts()");
  }
  
  function downloadConfig($config){
    log_message("debug","###START downloadConfig()");

    $configdata = json_decode("{\"datas\":".$config."}");

    foreach($configdata->datas as $data){
      $option = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>$data->name));
      if($option != null){
        log_message("debug","[Options]found ".$data->name);
        $option->setValue($data->value);
      }else{
        log_message("debug","[Options]found not ".$data->name);
        $option = new Systemoption();
        $option->setName($data->name);
        $option->setValue($data->value);
      }
      $this->em->persist($option);
      $this->em->flush();
    }

    log_message("debug","###END downloadConfig()");
  }
  
  function uploadConfig(){
    log_message("debug","###START uploadConfig()");

    $agenturloption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"agent_url"));
    $kioskcodeoption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"kiosk_code"));
    
    if($agenturloption != null) $agenturl = $agenturloption->getValue();
    if($kioskcodeoption != null) $kioskcode = $kioskcodeoption->getValue();

    $systemoptiondata = new SystemOptionData(array("NoAuthCheck"=>"Y"));    
    $list = $systemoptiondata->getList(array());
    $list = $systemoptiondata->fetchListReturnData($list);
    $config = json_encode($list);

    $configfile = __DIR__ . "\\project.config";
    file_put_contents($configfile , $config);
    
    $params = array();
    $params["action"] = "uploadconfig";
    $params["kioskCode"] = $kioskcode;
    $params["configFile"] = new CURLFile($configfile,"plain/text","project.config");
    $this->sendData2ServerViaPost($agenturl, $params);

    log_message("debug","###END uploadConfig()");
  }
}
