<?php
date_default_timezone_set('Australia/Sydney'); 

$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$frameurl = $root."/framework";

$url = $frameurl."/index.php/trackit/getmediaurl/".$_GET["acode"];
$retdata = file_get_contents($url);

$retdata = json_decode($retdata);
$mediaurl = $retdata->mediaurl;


//Detecting 
$tablet_browser = 0;
$mobile_browser = 0;

if (preg_match('/(tablet|ipad|playbook)|(android(?!.*(mobi|opera mini)))/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $tablet_browser++;
}

if (preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android|iemobile)/i', strtolower($_SERVER['HTTP_USER_AGENT']))) {
    $mobile_browser++;
}

if ((strpos(strtolower($_SERVER['HTTP_ACCEPT']),'application/vnd.wap.xhtml+xml') > 0) or ((isset($_SERVER['HTTP_X_WAP_PROFILE']) or 
isset($_SERVER['HTTP_PROFILE'])))) {
    $mobile_browser++;
}

$mobile_ua = strtolower(substr($_SERVER['HTTP_USER_AGENT'], 0, 4));
$mobile_agents = array(
    'w3c ','acs-','alav','alca','amoi','audi','avan','benq','bird','blac',
    'blaz','brew','cell','cldc','cmd-','dang','doco','eric','hipt','inno',
    'ipaq','java','jigs','kddi','keji','leno','lg-c','lg-d','lg-g','lge-',
    'maui','maxo','midp','mits','mmef','mobi','mot-','moto','mwbp','nec-',
    'newt','noki','palm','pana','pant','phil','play','port','prox',
    'qwap','sage','sams','sany','sch-','sec-','send','seri','sgh-','shar',
    'sie-','siem','smal','smar','sony','sph-','symb','t-mo','teli','tim-',
    'tosh','tsm-','upg1','upsi','vk-v','voda','wap-','wapa','wapi','wapp',
    'wapr','webc','winw','winw','xda ','xda-');
 
if (in_array($mobile_ua,$mobile_agents)) {
    $mobile_browser++;
}
 
if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']),'opera mini') > 0) {
    $mobile_browser++;
    //Check for tablets on opera mini alternative headers
    $stock_ua = 
strtolower(isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])?$_SERVER['HTTP_X_OPERAMINI_PHONE_UA']:(isset($_SERVER['HTTP_DEVICE_STOCK_UA'])?$_SERVER['HTTP_DEVICE_STOCK_UA']:''));
    if (preg_match('/(tablet|ipad|playbook)|(android(?!.*mobile))/i', $stock_ua)) {
      $tablet_browser++;
    }
}

$is_mobile_or_table = false;
if ($tablet_browser > 0) {
   // do something for tablet devices
    $is_mobile_or_table = true;
}
else if ($mobile_browser > 0) {
   // do something for mobile devices
    $is_mobile_or_table = true;
}
else {
   // do something for everything else
}  
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
    p{margin:0px;font-size:13px;}
    .wrapper{
      padding: 0px 10px;
      width:230px;
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
      <h3>SHARE TO INSTAGRAM</h3>
      <p>2016 Formula 1 Australian Grand Prix</p>
      <p>17-20 March</p>
      <p><i>Experience <strong>F1. FOR REAL.</strong></i></p>
    </div>
    <div class='content'>
      <img src="<?php echo $mediaurl; ?>" width="120px" style="width:120px;">
    </div>
    <div class='footer'>
      <?php if($is_mobile_or_table):?>
        <p>1.Click the 'Download' button</p>
        <p>2.Launch the Instagram app</p>
        <p>3.Upload and tag #AusGP</p>
      <?php else: ?>
        <p>1.Please open this website from your mobile device</p>
        <p>2.Click the 'Download' button</p>
        <p>3.Launch the Instagram app</p>
        <p>4.Upload and tag #AusGP</p>
      <?php endif ?>
      <p class='alert'><i>NOTE: Please make sure your <br/>Instagram profile is set to PUBLIC</i></p>
    </div>
  </div>
</body>
</html> 

