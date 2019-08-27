<?php
$url = "http://www.fanfestnwc2015.com.au/framework/index.php/trackit/getmediaurl/".$_REQUEST['acode'];
$retdata = file_get_contents($url);
if($retdata == ""){
  exit;
}

$retdata = json_decode($retdata);
$mediaurl = $retdata->mediaurl;
$vurl = $retdata->videourl;
?>
<html>
<head>
<link href="http://vjs.zencdn.net/4.1/video-js.css" rel="stylesheet">
<script src="http://vjs.zencdn.net/4.1/video.js"></script>
<style>
    .video-js{
        margin:5px auto;
    }
</style>
</head>
<body>

<video id="video_<?php echo $vid;?>" class="video-js vjs-default-skin"
  controls preload="auto" width="710" height="400">
  <source src="<?php echo $vurl;?>" type='video/mp4' />
  <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
</video>

</body>
</html>  
