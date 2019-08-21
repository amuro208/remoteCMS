<?php
//$accessCode = $_REQUEST["accessCode"];
//$url = "http://www.fanfestnwc2015.com.au/framework/?m=participants&action=getuserbyaccesscode&accessCode=".$accessCode;

$url = "http://www.fanfestnwc2015.com.au/framework/index.php/trackit/getmediaurl/".$_GET['acode'];
$retdata = file_get_contents($url);

/*
$ch=curl_init();
$timeout=1;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$result=curl_exec($ch);
curl_close($ch);
*/

if($retdata == ""){
  exit;
}

$retdata = json_decode($retdata);
/*
$mediaurl = $retdata->mediaurl;
$fb_title = $retdata->fb_title;
$fb_message = $retdata->fb_message;
$longurl = $retdata->longurl;
$shorturl = $retdata->shorturl;
*/

//print_r($retdata);

$file = $retdata->mediafile;

if($retdata->videofile){
  $file = $retdata->videofile;
}

$filePrefix = "";
$path_parts = pathinfo($file);
if($retdata->eventcode == "MVP"){
  $filePrefix = "FansMVP".$retdata->mediaid.".".$path_parts["extension"];
}else if($retdata->eventcode == "QS"){
  $filePrefix = "CoverTheCourt".$retdata->mediaid.".".$path_parts["extension"];
}else if($retdata->eventcode == "SR"){
  $filePrefix = "CheerCam".$retdata->mediaid.".".$path_parts["extension"];
}else if($retdata->eventcode == "LK"){
  $filePrefix = "LipSyncing".$retdata->mediaid.".".$path_parts["extension"];
}else if($retdata->eventcode == "PP"){
  $filePrefix = "PerfectPass".$retdata->mediaid.".".$path_parts["extension"];
}

if (file_exists($file)) {
    if(ini_get('zlib.output_compression'))
    ini_set('zlib.output_compression', 'Off');

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.$filePrefix.';');
    header('Expires: 0');
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private',false);
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
?>
