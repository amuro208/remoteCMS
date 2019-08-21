<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/autoload.php';
require_once APPPATH . 'libraries/crontab.php';

define("ACCESSCODE","0d2b31106c7addaf4a09c09f446a1b3d");

class BatchCronJob extends CI_Controller{
  function __construct()
  {
    parent::__construct();
    new Autoload($this);

    $this->load->database();
    $this->load->library('email'); // load the library
    $this->load->helper('url');
    $this->em = $this->doctrine->em;
    
    $this->config->load('email');

    date_default_timezone_set('Australia/Sydney');
  }

  function cron(){
    //This method will be called every minutes.

    log_message("debug","----------------------------------------------------");
    log_message("debug","---------------------START CRON---------------------");
    log_message("debug","----------------------------------------------------");

    $current = time();

    if($current == Crontab::parse("4 16 4 * * ")) {
      log_message("debug","#2");
      try{
        $this->sendVoteResult();
      }catch(Exception $e){
      }
    }
    if($current == Crontab::parse("0 17 15 * * ")) {
      log_message("debug","#2");
      try{
        $this->sendVoteResult();
      }catch(Exception $e){
      }
    }
    if($current == Crontab::parse("1 17 15 * * ")) {
      log_message("debug","#3");
      try{
        $this->sendVoteResult();
      }catch(Exception $e){
      }
    }
    if($current == Crontab::parse("2 17 15 * * ")) {
      log_message("debug","#4");
      try{
        $this->sendVoteResult();
      }catch(Exception $e){
      }
    }
    if($current == Crontab::parse("3 17 15 * * ")) {
      log_message("debug","#5");
      try{
        $this->sendVoteResult();
      }catch(Exception $e){
      }
    }
    if($current == Crontab::parse("4 17 15 * * ")) {
      log_message("debug","#6");
      try{
        $this->sendVoteResult();
      }catch(Exception $e){
      }
    }
    
    if($current == Crontab::parse("* * * * * ")) {
      log_message("debug","#1");
      try{
        $this->serverMonitorJob();
      }catch(Exception $e){
      }
    }
    log_message("debug","----------------------------------------------------");
    log_message("debug","--------------------- END CRON ---------------------");
    log_message("debug","----------------------------------------------------");
  }

  function sendVoteResult(){
    
    $sql = "
SELECT id,
       firstName,
       lastName,
       email,
       teamPlayerCode
  FROM `user` a
 WHERE a.valid = 'Y'
   AND a.teamPlayerCode = (
        SELECT pcode
          FROM (
                SELECT `teamPlayerCode` pcode,
                       count(*) cnt
                  FROM `user` a
                 WHERE eventCode = 'MVP'
                 GROUP BY `teamPlayerCode`
                ) x,(SELECT @rn:=0) y
         ORDER BY cnt DESC
         LIMIT 1)
 ORDER BY rand()
 LIMIT 1  
    ";
    
    $query = $this->db->query($sql);
    $datas = $query->result_array();
    foreach($datas as $data){
      $firstName = $data["firstName"]; 
      $lastName = $data["lastName"]; 
      $email = $data["email"]; 
      $pcode = $data["teamPlayerCode"]; 

      $senderEmail =  $this->config->item("smtp_user");
      $senderName =  $this->config->item("sender_name");

      $this->email->clear(TRUE);
      $this->email->from($senderEmail,$senderName);
      $receivers = array(
        "luis.youn@thecreativeshop.com.au",
        "alex.lee@thecreativeshop.com.au",
        "andy.kelly@thecreativeshop.com.au",
      );
      $this->email->to($receivers);
      $this->email->subject("The winner of MVP");
      $this->email->message("
        <p>Hi there,</p>
        <p>This is sending automatically form the server.</p>
        <p>The Player code of MVP is ".$pcode."</p>
        <p></p>
        <p>The winner of MVP is</p> 
        <p>FirstName : ".$firstName."</p>
        <p>LastName : ".$lastName."</p>
        <p>Email : ".$email."</p>
        <p>Thanks</p>"
      );

      $isSendResult = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"is_send_mvp_result"));
      if($isSendResult == null || $isSendResult->getValue() == null || $isSendResult->getValue() != "Y" ){
        if($this->email->send()){
          $isSendResult->setValue("Y");
          $this->em->persist($isSendResult);
          $this->em->flush();
        }
      }

      break;
    }
  }

  function serverMonitorJob(){
    $islocalserveroption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"is_local_server"));
    if($islocalserveroption!=null) $islocalserver = $islocalserveroption->getValue();

    if($islocalserver == "Y"){
      $remotesyncoption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"remote_sync"));
      $reversesyncoption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"reverse_sync"));
      $syncpathoption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"sync_path"));
      $dailybackupoption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"daily_backup"));
      $gitpulloption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"git_pull"));
      $pingoption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"ping"));
      $serverportoption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"server_port"));
      
      if($remotesyncoption!=null) $remotesync = $remotesyncoption->getValue();
      if($reversesyncoption!=null) $reversesync = $reversesyncoption->getValue();
      if($syncpathoption!=null) $syncpath = $syncpathoption->getValue();
      if($dailybackupoption!=null) $dailybackup = $dailybackupoption->getValue();
      if($gitpulloption!=null) $gitpull = $gitpulloption->getValue();
      if($pingoption!=null) $ping = $pingoption->getValue();
      if($serverportoption!=null) $serverport = $serverportoption->getValue();

      $current = time();
      $flag = "";
      if ($remotesync == "Y" && $current == Crontab::parse("* * * * * ")){
        $flag .= "F"; 
        $msg = file_get_contents("http://localhost:".$serverport."/codeigniter/index.php/remotesync/");
        log_message("debug",$msg);
      }
      if ($reversesync == "Y" && $current == Crontab::parse("*/30 * * * * ")){
        $flag .= "B"; 
        $msg = file_get_contents("http://localhost:".$serverport."/codeigniter/index.php/system/reversesync");
        log_message("debug",$msg);
      }
      if ($syncpath == "Y" && $current == Crontab::parse("30 * * * * ")){
        $flag .= "P"; 
        $msg = file_get_contents("http://localhost:".$serverport."/codeigniter/index.php/system/syncpath");
        log_message("debug",$msg);
      }
      if ($dailybackup  == "Y" && $current == Crontab::parse("1 * * * * ")){
        $flag .= "D"; 
        $msg = file_get_contents("http://localhost:".$serverport."/codeigniter/index.php/system/backupdatabase/wnsgurwpdnjs");
        log_message("debug","@@@".$msg."@@@");
      }
      if ($gitpull  == "Y" && $current == Crontab::parse("20 * * * * ")){
        $gitcommandoption = $this->em->getRepository("Systemoption")->findOneBy(array("valid"=>"Y","name"=>"git_command"));
        if($gitcommandoption!=null) $gitcommand = $gitcommandoption->getValue();

        $flag .= "G"; 
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
      }
      if ($ping  == "Y"){
        $msg = file_get_contents("http://localhost:".$serverport."/codeigniter/index.php/ping/index/".$flag);
        log_message("debug",$msg);
      }
    }

  }
  /*
  function sendEmailJob(){
    $option = $this->em->getRepository("Systemoption")
                       ->findOneBy(array(
                         "valid"=>"Y",
                         "name"=>"last_email_sent")); 
    $run = false;

    if($option == null){
      $option = new Systemoption();
      $option->setName("last_email_sent");
      $option->setValue("".time());
      $this->em->persist($option);
      $this->em->flush();
      $run = true;
    }else{
      $last_email_sent = $option->getValue() + 0;
      
      //if this module executed 5 mintues ago, it should be run again.
      if(time() - $last_email_sent > 300){
        $run = true;
      }
    }

    if($run){
      $customerEDMs = $this->em->getRepository("Customeredm")
                               ->findBy(array(
                                 "valid"=>"Y",
                                 "sendresult"=>"N"
                               )); 

      foreach($customerEDMs as $customerEDM){
        
        $this->sendemail->sendStandardEmail($customerEDM->getId());

        $option->setValue("".time());
        $this->em->persist($option);
        $this->em->flush();

      }
    }
  }
  
  function makeTermServiceJob(){
    $sql = "
      SELECT a.cid,a.id customerserviceId,c.goodsId,
             d.price,d.GST,d.total,
             DATE_FORMAT(DATE_ADD(NOW(),INTERVAL 1 MONTH),'%Y-%m-%d') startdate,
             CASE WHEN b.defaultPeriod = 'M' AND (DATE_FORMAT(NOW(),'%m')) MOD  1 = 0 THEN 'Y' ELSE 'N' END isM,
             CASE WHEN b.defaultPeriod = 'Q' AND (DATE_FORMAT(NOW(),'%m')) MOD  3 = 0 THEN 'Y' ELSE 'N' END isQ,
             CASE WHEN b.defaultPeriod = 'Y' AND (DATE_FORMAT(NOW(),'%m')) MOD 12 = 6 THEN 'Y' ELSE 'N' END isY
        FROM `customerservice` a
        JOIN `goodsinstance` c
          ON a.goodsInstanceId = c.id
        JOIN `goodshistory` d
          ON d.goodsInstanceId = c.id
        JOIN `goods` b
          ON c.goodsId = b.id
       WHERE a.valid = 'Y'
         AND b.valid = 'Y'
         AND c.valid = 'Y'
         AND d.valid = 'Y'
         AND d.effectiveDate <= DATE_FORMAT(NOW(),'%Y-%m-%d')
         AND d.expiryDate >= DATE_FORMAT(NOW(),'%Y-%m-%d')
         AND b.isPeriod = 'Y'
         AND a.startDate <= DATE_FORMAT(NOW(),'%Y-%m-%d')
         AND (a.quitDate is null OR a.quitDate = '')      
    ";
    $query = $this->db->query($sql);
    $datas = $query->result_array(); 

    $customertermservicedata = new CustomerTermServiceData(array("NoAuthCheck"=>"Y"));

    foreach($datas as $data){
      if($data["isM"] == "Y" || $data["isQ"] == "Y" || $data["isY"] == "Y"){
         $customertermservicedata->batchPost($data);
      }
    }   
  }
   */
} 
