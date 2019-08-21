<?php
/*
1. Get Raw Access Log from webhosting site First.
2. Get Database backup.
3. Restore database on localhost.
4. Run this script.
5. Backup localhost and restore remote database.
*/

$servername = "localhost";
$username = "root";
$password = "NewPassword1";
$dbname = "pjt_pepper";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
    
$filedata = file_get_contents("./pepperfanzone.com.au-Jan-2016");

$lines = explode("\n",$filedata);

foreach($lines as $line){
  //if(strrpos($line,'GET /index.php?acode=') > 0 && strrpos($line,'facebook.com') > 0 && strrpos($line,'externalhit_uatext.php') === false){
  if(strpos($line,'GET /index.php?acode=') > 0 && strpos($line,'facebook.com') > 0){
    $pos1 = strpos($line,"[");
    if($pos1 >= 0){
      //echo $line."\n\r";
      
      $pos2 = strpos($line,"]");
      $time = substr($line,$pos1+1,$pos2-$pos1-1);
      echo $time.",";
      
      $t = strtotime($time);
      $t = strtotime("+19 hours",$t);
      $t = date('Y/m/d H:i:s',$t);
      $ts = strtotime($t);
      echo $t.",$ts,";
      
      $pos3 = strpos($line,'GET /index.php?acode=');
      $pos3 += strlen('GET /index.php?acode=');
      $code = substr($line,$pos3,24);
      echo $code.",";
      
      $pos4 = strpos($line,'http',$pos3+24+6);
      $pos5 = strpos($line,'.com',$pos4);
      
      $ref = substr($line,$pos4,$pos5 - $pos4 + 4);
      echo $ref.",";
      
      $sql = "select id from emaillog where shareAccessCode = '$code'";
      $result = $conn->query($sql);
      $id = 0;
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $id = $row["id"];
          }
      }
      
      $sql = "select id, createDate from activitylog x where emailLogId = '$id' and activityType = 'CNTFRMSHR'";
      $result = $conn->query($sql);
      $id = 0;
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $t2 = strtotime($row["createDate"]);
              $ts2 = $t2;
              $t2 = date('Y/m/d H:i:s',$t2);
              if($ts < $ts2 && $ts2 < $ts+10){
                echo $row["id"].",";
                $sql = "update activitylog set referer = '$ref' where id=".$row["id"];
                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
                }

              }
          }
      }
      
      echo "\n\r";
    }
  }
}

foreach($lines as $line){
  //if(strrpos($line,'GET /index.php?acode=') > 0 && strrpos($line,'facebook.com') > 0 && strrpos($line,'externalhit_uatext.php') === false){
  if(strpos($line,'GET /index.php?acode=') > 0 && strpos($line,'/t.co/') > 0){
    $pos1 = strpos($line,"[");
    if($pos1 >= 0){
      //echo $line."\n\r";
      
      $pos2 = strpos($line,"]");
      $time = substr($line,$pos1+1,$pos2-$pos1-1);
      echo $time.",";
      
      $t = strtotime($time);
      $t = strtotime("+19 hours",$t);
      $t = date('Y/m/d H:i:s',$t);
      $ts = strtotime($t);
      echo $t.",$ts,";
      
      $pos3 = strpos($line,'GET /index.php?acode=');
      $pos3 += strlen('GET /index.php?acode=');
      $code = substr($line,$pos3,24);
      echo $code.",";
      
      $pos4 = strpos($line,'http',$pos3+24+6);
      $pos5 = strpos($line,'\"',$pos4+4);
      
      $ref = substr($line,$pos4,$pos5 - $pos4 + 4);
      echo $ref.",";
      
      $sql = "select id from emaillog where shareAccessCode = '$code'";
      $result = $conn->query($sql);
      $id = 0;
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $id = $row["id"];
          }
      }
      
      $sql = "select id, createDate from activitylog x where emailLogId = '$id' and activityType = 'CNTFRMSHR'";
      $result = $conn->query($sql);
      $id = 0;
      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $t2 = strtotime($row["createDate"]);
              $ts2 = $t2;
              $t2 = date('Y/m/d H:i:s',$t2);
              if($ts < $ts2 && $ts2 < $ts+10){
                echo $row["id"].",";
                $sql = "update activitylog set referer = '$ref' where id=".$row["id"];
                if ($conn->query($sql) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
                }

              }
          }
      }
      
      echo "\n\r";
    }
  }
}

$conn->close();