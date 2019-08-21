<?php
date_default_timezone_set('Australia/Sydney'); 

$m = $_GET["m"];
if($m == null){
  $m = "instagram";
}

function user_agent(){
  $iPod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
  $iPhone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
  $iPad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
  $android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
  if($iPad||$iPhone||$iPod){
    return 'ios';
  }else if($android){
    return 'android';
  }else{
    return 'desktop';
  }
}
$user_agent = user_agent();

$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$frameurl = $root."/framework";

$url = $frameurl."/index.php/trackit/getmediaurl/".$_GET["acode"]."/Y";
$retdata = file_get_contents($url);

$retdata = json_decode($retdata);
$mediaurl = $retdata->mediaurl;

?>
<!DOCTYPE html>
<html>
<head>
  <title>Share to instagram</title>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="style.css" rel="stylesheet" type="text/css">
  <style>
    h3{font-weight:bold}

    <?php if(user_agent() == "desktop"):?>
      p{margin:0px;font-size:13px;}
    <?php else: ?>
      p{margin:0px;font-size:11px;}
    <?php endif ?>

    .wrapper{
      padding: 0px 10px;
      width:200px;
      margin: 0px auto;
    }
    .header{
      text-align:center;
    }
    .content{
      text-align:center;
    }
    p.alert{
      color:red;
      text-align:center;
      margin:10px 0px;
    }
  </style>
</head>
<body>
  <div class='wrapper'>
    <div class='header'>
      <?php if($m == "instagram"): ?>
        <h4>SHARE TO INSTAGRAM</h4>
      <?php elseif($m == "email"): ?>
        <h4>SHARE TO INSTAGRAM</h4>
      <?php else: ?>
        <h4>DOWNLOAD YOUR IMAGE</h4>
      <?php endif; ?>
    </div>
    <div class='content'>
      <img src="./img/logo.png" width="120px" style="width:120px;"/>
      <img src="<?php echo $mediaurl; ?>" width="120px" style="width:120px;">
    </div>
    <div class='footer' style="text-align:center;">
      <?php if($m == "instagram"): ?>
        <?php if(user_agent() != "desktop"):?>
          <p>1. Tap & hold the photo to save</p>
          <p>2. Launch the Instagram app</p>
          <p>3. Upload and tag #AUSvTJK</p>
        <?php else: ?>
          <p>1. Please open this website from your mobile device</p>
          <p>2. Download the image</p>
          <p>3. Launch the Instagram app</p>
          <p>4. Upload and tag #AUSvTJK</p>
        <?php endif ?>
        <p class='alert'><i>NOTE: Please make sure your <br/>Instagram profile is set to PUBLIC</i></p>
      <?php elseif($m == "email"): ?>
        <p>We've sent you an email with an MP4 of your GIF, so you can share it with your followers on Instagram!</p> 
      <?php else: ?>
        <p>1. Tap & hold the image</p>
        <p>2. Tap 'Save Image'</p>
        <p>3. Upload and tag #AUSvTJK</p>
      <?php endif; ?>
    </div>
  </div>
</body>
</html> 

