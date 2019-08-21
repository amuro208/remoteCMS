<?php
$accessCode = $_REQUEST["accessCode"];

$url = "http://www.afcasiancupfanpark.com:8081/wordpress/cmd/api/?m=participants&action=getuserbyaccesscode&accessCode=".$accessCode;

$ch=curl_init();
$timeout=1;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$result=curl_exec($ch);
curl_close($ch);

$json = json_decode($result);
$file = $json->{'videoFile'};
$contentClass = $json->{'class'};

if (file_exists($file) && $contentClass == "ic") {
  header('Content-Type: video/mp4');
  header('Content-Length: ' . filesize($file));
  
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');  
  
  readfile($file);
  exit;
}else{
  
}
?>