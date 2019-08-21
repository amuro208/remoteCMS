<html>
<head>
<link href="/framework/static/css/video-js.css" rel="stylesheet">
<script src="/framework/static/js/video/video.js"></script>
<style>
    .video-js{
        margin:10px auto;
    }
</style>
</head>
<body>

<video id="video_<?php echo $vid;?>" class="video-js vjs-default-skin"
    preload="auto" width="710" height="400" autoplay
    data-setup='{"controls":true}'>
    <source src="<?php echo $vurl;?>" type='video/mp4' />
    <source src="http://video-js.zencoder.com/oceans-clip.webm" type='video/webm' />
    <source src="http://video-js.zencoder.com/oceans-clip.ogv" type='video/ogg' />
</video>

</body>
</html>  
