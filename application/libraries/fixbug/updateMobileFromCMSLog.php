<?php
$servername = "localhost";
$username = "root";
$password = "NewPassword1";

/*Local CMS*/
//$dbname="tcscms"
//$tableName = "localuser";
//$timeColumName = "createDate";
/*Remote CMS*/
//$dbname = "pjt_f1_2016012l7";
$dbname = "pjt_f1_2016012l7";
$tableName = "user";
$timeColumName = "localCreateDate";
$logdir = __DIR__ . "../../../logs/f1old2";
//$logdir = "C:\\Users\\Luis-Window\\Downloads\\F1LogFile\\Old1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//$logfiles = scandir($logdir);
$logfiles = array(
      'log-2016-01-12.php',
      'log-2016-01-13.php',
      'log-2016-01-14.php',
      'log-2016-01-15.php',
      'log-2016-01-16.php',
      'log-2016-01-17.php',
      'log-2016-01-18.php',
      'log-2016-01-19.php',
      'log-2016-01-20.php',
      'log-2016-01-21.php',
      'log-2016-01-22.php');

$d1="###START UPLOAD###";
$d2="###CHECK INPUT####";
$d3="###CHECK _POST###";

foreach($logfiles as $logfile){
  $logdata = file_get_contents($logdir."/".$logfile);
  $lines = explode("\n",$logdata);
  
  $total = count($lines);
  
  for($ndx = 0 ; $ndx < $total ; $ndx++){
    $line = $lines[$ndx];
    if(strpos($line,$d1) > 0){
      if(strpos($lines[$ndx+2],$d2) > 0){
        if(strpos($lines[$ndx+4],$d3) > 0){
          $data = $lines[$ndx+5];
          $ndx += 10;

          //Handle Data...
          $createtime = substr($data,8,19);
          $pos = strpos($data,"-->");
          $jsondata = json_decode(substr($data,$pos+3));
          
          /*
          echo substr($data,$pos+3)."\n";
          print_r($jsondata);
          if(isset($jsondata->userMobile)){
            echo "---------------------------------";
            echo $jsondata->userMobile."\n";
            echo "---------------------------------";
          }
          */
          
          if(isset($jsondata->userMobile)){
            $userFirstName = $jsondata->userFirstName;
            $userLastName = $jsondata->userLastName;
            $userEmail = $jsondata->userEmail;
            $userMobile = $jsondata->userMobile;
            //$userPostCode = $jsondata->userPostcode;
            $eventCode = $jsondata->eventCode;
            
            $sql = "select id, $timeColumName 
                      from $tableName x 
                     where firstName = '$userFirstName' 
                       and lastName = '$userLastName' 
                       and email = '$userEmail' 
                       and eventCode = '$eventCode'";
            
            $result = $conn->query($sql);
            if($result->num_rows == 1){
              $row = $result->fetch_assoc();
              //$sql = "update $tableName set mobile = '$userMobile', zipCode = '$userPostCode' where id='".$row["id"]."';";
              $sql = "update $tableName set mobile = '$userMobile' where id='".$row["id"]."';";
            }else{
              if ($result->num_rows > 0) {
                $isfound = false;
                while($row = $result->fetch_assoc()) {
                  $ct = strtotime($createtime);
                  $ct2 = strtotime($row[$timeColumName]);
                  if($ct - 3 < $ct2 && $ct2 < $ct + 3){
                    //$sql = "update $tableName set mobile = '$userMobile', zipCode = '$userPostCode' where id='".$row["id"]."';";
                    $sql = "update $tableName set mobile = '$userMobile' where id='".$row["id"]."';";
                    $isfound = true;
                    break;
                  }
                }
                if($isfound === false){
                  $sql = "";
                }
              }else{
                //echo "NO DATA - ";
                //echo $sql;
                $sql = "";
              }
            }
            
            if(!empty($sql)){
              echo $sql." -> ";
              
              if ($conn->query($sql) === TRUE) {
                  echo "Record updated successfully";
              } else {
                  echo "Error updating record: " . $conn->error;
              }
            }
            echo "\n\r";
          }
        }
      }
    }
  }  
}

$conn->close();