<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/doctrinautoload.php';

define("ACCESSCODE","0d2b31106c7addaf4a09c09f446a1b3d");

class System extends DoctrinAutoload{
  
  function __construct($parameters=array())
  {
    parent::__construct(array("NoAuthCheck"=>"Y"));
    $this->load->database();
    $this->load->helper('url');
    $this->em = $this->doctrine->em;
  }

  public function installdatabase(){
    $accesscode = md5($this->uri->segment(3));
    if($accesscode != ACCESSCODE){
      echo "Wrong Accesscode!";
      return;
    }

    $filename = __DIR__."/tcscmsdb.sql";
    $handle = fopen($filename, "r");
    $sql = fread($handle, filesize($filename));
    fclose($handle);

    $tmp = explode("\n",$sql);
    $sql = "";
    foreach($tmp as $item){
      if(substr($item,0,2) != "--"){
        $sql .= $item;
      }
    }

    $sqls = explode(";",$sql);
    foreach($sqls as $item){
      $item = trim($item);
      if(!empty($item)){
        $this->db->query($item);
      }
    }

    echo "Done!";
  }
  /*
  public function uninstalldatabase(){
    $accesscode = md5($this->uri->segment(3));
    if($accesscode != ACCESSCODE){
      echo "Wrong Accesscode!";
      return;
    }

    $filename = __DIR__."/../leadersdb_uninstall.sql";
    $handle = fopen($filename, "r");
    $sql = fread($handle, filesize($filename));
    fclose($handle);

    $sqls = explode(";",$sql);
    foreach($sqls as $item){
      $item = trim($item);
      if(!empty($item)){
        $this->db->query($item);
      }
    }

    echo "Done!";
  }

  public function initializecustomer(){
    $accesscode = md5($this->uri->segment(3));
    if($accesscode != ACCESSCODE){
      echo "Wrong Accesscode!";
      return;
    }

    $filename = __DIR__."/../leadersdb_initialize_customer.sql";
    $handle = fopen($filename, "r");
    $sql = fread($handle, filesize($filename));
    fclose($handle);

    $tmp = explode("\n",$sql);
    $sql = "";
    foreach($tmp as $item){
      if(substr($item,0,2) != "--"){
        $sql .= $item;
      }
    }

    $sqls = explode(";",$sql);
    foreach($sqls as $item){
      $item = trim($item);
      if(!empty($item)){
        $this->db->query($item);
      }
    }

    echo "Done!";
  }
  */

  public function initializeuser(){
    $accesscode = md5($this->uri->segment(3));
    if($accesscode != ACCESSCODE){
      echo "Wrong Accesscode!";
      return;
    }

    log_message("debug","###START INITIALIZE USER###");
    $this->db->empty_table('localrfidscan');
    $this->db->empty_table('localmedia');
    $this->db->empty_table('localuser');
    $this->db->empty_table('activitylog');
    $this->db->empty_table('emaillog');
    $this->db->empty_table('rfidscan');
    $this->db->empty_table('media');
    $this->db->empty_table('rfid');
    $this->db->empty_table('sendsns');
    $this->db->empty_table('user');
    log_message("debug","###END INITIALIZE USER###");
    
    echo "Done!";
  }

  public function backupdatabase(){
    log_message("debug","###START DATABASE BACKUP###");

    $accesscode = md5($this->uri->segment(3));
    if($accesscode != ACCESSCODE){
      echo "Wrong Accesscode!";
      return;
    }

    $key_name1 = $this->db->database . '_';
    $key_name2 = '_db';
    //$key_name3 = date("YmdHis");
    $key_name3 = date("YmdH");
    $file_name = $key_name1 . $key_name3 . $key_name2 . '.zip';

    include_once(__DIR__ . '/../libraries/Ifsnop/Mysqldump/Mysqldump.php');
    $dump = new Ifsnop\Mysqldump\Mysqldump(
      $this->db->database,
      $this->db->username,
      $this->db->password,
      $this->db->hostname,
      "mysql",
      array('compress' => Ifsnop\Mysqldump\Mysqldump::GZIP));

    $dump->start(__DIR__ . '/../dbbackup/'.$file_name);

    log_message("debug","###END DATABASE BACKUP###");

    echo "Done!";
  }

  public function restoredatabase(){
    log_message("debug","###START DATABASE RESTORE###");

    $accesscode = md5($this->uri->segment(3));
    if($accesscode != ACCESSCODE){
      echo "Wrong Accesscode!";
      return;
    }

    $hosts = explode(":",$this->db->hostname);
    if(count($hosts) == 1){
      echo "/usr/bin/mysql --user=".$this->db->username." --password=".$this->db->password." --host=".$hosts[0]." ".$this->db->database." < filename.sql";
    }else{
      echo "/usr/bin/mysql --user=".$this->db->username." --password=".$this->db->password." --port=".$hosts[1]." --host=".$hosts[0]." ".$this->db->database." < filename.sql";
    }

    log_message("debug","###END DATABASE RESTORE###");
  }

  public function updateOption($name,$value){
    $option = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>$name));
    $option->setValue($value);
    $this->em->persist($option);
    $this->em->flush();
  }

  public function syncpath(){
    log_message("debug","###START SYNCPATH###");

    $agenturloption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"agent_url"));
    $kioskcodeoption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"kiosk_code"));
    
    if($agenturloption != null) $agenturl = $agenturloption->getValue();
    if($kioskcodeoption != null) $kioskcode = $kioskcodeoption->getValue();

    log_message("debug",$agenturl."?kioskCode=".$kioskcode."&action=get");
    $new_value = file_get_contents($agenturl."?kioskCode=".$kioskcode."&action=get");
    if($new_value){
      $option_name = "get_url";
      $this->updateOption($option_name,$new_value);
      echo "GET...OK ".$new_value."<br>";
    }
    log_message("debug",$agenturl."?kioskCode=".$kioskcode."&action=post");
    $new_value = file_get_contents($agenturl."?kioskCode=".$kioskcode."&action=post");
    if($new_value){
      $option_name = "post_url";
      $this->updateOption($option_name,$new_value);
      echo "POST...OK ".$new_value."<br>";
    }
    log_message("debug",$agenturl."?kioskCode=".$kioskcode."&action=upload");
    $new_value = file_get_contents($agenturl."?kioskCode=".$kioskcode."&action=upload");
    if($new_value){
      $option_name = "upload_url";
      $this->updateOption($option_name,$new_value);
      echo "UPLOAD...OK ".$new_value."<br>";
    }

    log_message("debug","###END SYNCPATH###");

    echo "Done!";
  }

  public function reversesync(){
    log_message("debug","==================================================================================================="); 
    log_message("debug","===================START REVERSE SYNC==================="); 
    log_message("debug","========================================================");

    log_message("debug","===================START FILE SYNC==================="); 
    require_once APPPATH . 'libraries/Outlandish/Sync/AbstractSync.php';
    require_once APPPATH . 'libraries/Outlandish/Sync/Client.php';

    $syncServerUrl = $this->getOptionValue("sync_server_url");
    if($syncServerUrl === false || $syncServerUrl == ""){
      log_message("error","There is no option for sync_server_url");
      log_message("debug","===================END REVERSE SYNC==================="); 
      return;
    } 

    $client = new \Outlandish\Sync\Client(ACCESSCODE, $this->uploadPath);
    $client->run($syncServerUrl."reversesyncfile"); //connect to server and start sync
    log_message("debug","===================END FILE SYNC==================="); 

    log_message("debug","===================START DATABASE SYNC==================="); 
    //DATABASE SYNC
    $filePath = __DIR__ . '/../dbbackup/dump.sql';
    $dumpsql = file_get_contents($syncServerUrl."reversesyncdb");
    file_put_contents($filePath,$dumpsql);    
    log_message("debug","===Complete downloading sql files...");

    $connection = mysqli_connect($this->db->hostname, $this->db->username, $this->db->password, $this->db->database);
    if (mysqli_connect_errno())
    {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      log_message("error","Could not connect to database.");
      log_message("debug","===================END REVERSE SYNC==================="); 
      return;
    }

    log_message("debug","===Connected database...");
    
    mysqli_query($connection,"drop table sendsns;") or print('Error performing query \'<strong>drop table sendsns\': ' . mysqli_error($connection) . '<br /><br />');
    mysqli_query($connection,"drop table emaillog;") or print('Error performing query \'<strong>drop table emaillog\': ' . mysqli_error($connection) . '<br /><br />');
    mysqli_query($connection,"drop table media;") or print('Error performing query \'<strong>drop table media\': ' . mysqli_error($connection) . '<br /><br />');
    mysqli_query($connection,"drop table user;") or print('Error performing query \'<strong>drop table user\': ' . mysqli_error($connection) . '<br /><br />');
    mysqli_query($connection,"drop table code;") or print('Error performing query \'<strong>drop table code\': ' . mysqli_error($connection) . '<br /><br />');
    mysqli_query($connection,"drop table event;") or print('Error performing query \'<strong>drop table event\': ' . mysqli_error($connection) . '<br /><br />');

    log_message("debug","===Drop tables...");

    $templine = "";
    $lines = file($filePath);
    // Loop through each line
    foreach ($lines as $line){
        // Skip it if it's a comment
        if (substr($line, 0, 2) == '--' || $line == ''){ continue; }

        // Add this line to the current segment
        $templine .= $line;
        // If it has a semicolon at the end, it's the end of the query
        if (substr(trim($line), -1, 1) == ';'){
          // Perform the query
          mysqli_query($connection,$templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($connection) . '<br /><br />');
          // Reset temp variable to empty
          $templine = '';
        }
    }
    log_message("debug","===Insert tables...");
    mysqli_close($connection);
    log_message("debug","===Closed database...");
    unlink($filePath);
    log_message("debug","===================END DATABASE SYNC==================="); 

    log_message("debug","======================================================");
    log_message("debug","===================END REVERSE SYNC==================="); 
    log_message("debug","==================================================================================================="); 

    echo "Done!";
  }

  public function reversesyncfile(){
    log_message("debug","===================START REVERSE SYNC SERVER==================="); 

    require_once APPPATH . 'libraries/Outlandish/Sync/AbstractSync.php';
    require_once APPPATH . 'libraries/Outlandish/Sync/Server.php';

    $server = new \Outlandish\Sync\Server(ACCESSCODE, $this->uploadPath);
    $server->run(); //process the request

    log_message("debug","===================END REVERSE SYNC SERVER==================="); 
  }

  public function reversesyncdb(){
    log_message("debug","===================START REVERSE SYNC DB==================="); 
    include_once(__DIR__ . '/../libraries/Ifsnop/Mysqldump/Mysqldump.php');
    $dump = new Ifsnop\Mysqldump\Mysqldump(
      $this->db->database,
      $this->db->username,
      $this->db->password,
      $this->db->hostname,
      "mysql",
      array("include-tables"=>array("event","user","media","emaillog","sendsns","code")));
    
    $filePath = __DIR__ . '/../dbbackup/syncdump.sql';
    $dump->start($filePath);
    echo file_get_contents($filePath);
    unlink($filePath);
    log_message("debug","===================END REVERSE SYNC DB==================="); 
  }
}
