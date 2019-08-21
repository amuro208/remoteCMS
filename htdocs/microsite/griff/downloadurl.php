<?php
$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
$url = $root."framework/index.php/trackit/getmediaurl/".$_GET['acode'];
$retdata = file_get_contents($url);

if($retdata == ""){
  exit;
}

$retdata = json_decode($retdata);
$file = $retdata->mediafile;
if($retdata->videofile){
  $file = $retdata->videofile;
}

$filePrefix = "";
$path_parts = pathinfo($file);
$filePrefix = "Griffith".$retdata->mediaid.".".$path_parts["extension"];

if (file_exists($file)) {
    if(ini_get('zlib.output_compression')){
      ini_set('zlib.output_compression', 'Off');
    }
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
