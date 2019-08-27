<?php
$accessCode = $_REQUEST["accessCode"];
if(!isset($accessCode) || empty($accessCode)){
  exit;
}

$url = "http://www.sydneyfanzones.com:8081/wordpress/cmd/api/?m=participants&action=getuserbyaccesscode&accessCode=".$accessCode;

$ch=curl_init();
$timeout=1;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$result=curl_exec($ch);
curl_close($ch);

$json = json_decode($result);
$file = $json->{'imageFile'};
$contentClass = $json->{'class'};

if (file_exists($file)) {
    header('Content-Type: image/jpg');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
?>