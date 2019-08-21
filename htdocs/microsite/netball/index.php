<?php
date_default_timezone_set('Australia/Sydney'); 

$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

$accessCode = $_GET["accessCode"];
if(empty($_GET['acode'])){
  exit;
}
$url = "http://www.fanfestnwc2015.com.au/framework/index.php/trackit/getmediaurl/".$_GET['acode'];
$retdata = file_get_contents($url);

$retdata = json_decode($retdata);
$mediaurl = $retdata->mediaurl;
if(empty($mediaurl)){
  exit;
}
$fb_title = $retdata->fb_title;
$fb_message = $retdata->fb_message;
$longurl = $retdata->longurl;
$shorturl = $retdata->shorturl;
$shareurl = $retdata->shareurl;
$eventcode = $retdata->eventcode; 
$reserve1 = $retdata->reserve1; 
$reserve2 = $retdata->reserve2; 
$reserve3 = $retdata->reserve3; 

if($eventcode == "LK"){
  $songs = array(
    "1"=>"Call Me Maybe - Carly Rae Jepsen",
    "2"=>"Girls Just Want To Have Fun - Cyndi Lauper",
    "3"=>"I Don't Like It, I Love It - Flo Rida",
    "4"=>"Shake It Off - Taylor Swift",
    "5"=>"Spice Up Your Life - Spice Girls",
  );
  $fb_title = $songs[$reserve1];
}

$referer =  urlencode($_SERVER['HTTP_REFERER']);
$surl="/framework/index.php/trackit/showcontent/".$_GET['acode']."/".$referer;

$downloadurl = "http://www.fanfestnwc2015.com.au/downloadurl.php?acode=".$_GET['acode'];
/*
if($eventcode == "SR" || $eventcode == "LK"){
  if($iPod || $iPhone || $iPad){
    $downloadurl = $retdata->videourl;
  }
}
*/
?>

<!DOCTYPE HTML>
<html>
<head>
  <title></title>
  <link href="style.css" rel="stylesheet" type="text/css">

  <!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <meta charset="utf-8"/>

  <!--Pinterest TAG-->
  <meta property="image" content="<?php echo $longurl;?>"/>
  <meta property="title" content="<?php echo $fb_title;?>"/>
  <meta property="description" content="<?php echo $fb_message;?>"/>
  <meta property="url" content="<?php echo $shareurl;?>"/>

  <!--Facebook TAG-->
  <meta property="og:image" content="<?php echo $longurl;?>"/>
  <meta property="og:title" content="<?php echo $fb_title;?>"/>
  <meta property="og:description" content="<?php echo $fb_message;?>"/>
  <meta property="og:url" content="<?php echo $shareurl;?>"/>

  <!--Twitter TAG-->
  <meta property="twitter:image" content="<?php echo $longurl;?>"/>
  <meta property="twitter:title" content="<?php echo $fb_title;?>"/>
  <meta property="twitter:description" content="<?php echo $fb_message;?>"/>
  <meta property="twitter:url" content="<?php echo $shorturl;?>"/>

  <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
  <script src="http://modernizr.com/downloads/modernizr-latest.js" type="text/javascript"></script>

  <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
  <script type="text/javascript">
    stLight.options({publisher: "03ae05d7-e2ca-4a77-bbd9-1d873c63e0c8", doNotHash: false, doNotCopy: false, hashAddressBar: false, shorten:false});
    function myCallbackFunction (event,service)
    {
       //alert("event called is:"+event); //the event type. Only "click" is supported.
       //alert("service called is:"+service); //the service shared by user. e.g. facebook
       //console.log("event called is:"+event);
       //console.log("service called is:"+service);
       jQuery.ajax("/framework/index.php/trackit/click/"+service);
    }
    stLight.subscribe("click",myCallbackFunction); //register the callback function with sharethis 
  </script>

  <script>
    jQuery.browser = {};
    (function () {
        jQuery.browser.msie = false;
        jQuery.browser.version = 0;
        if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
            jQuery.browser.msie = true;
            jQuery.browser.version = RegExp.$1;
        }
    })();

    $(document).ready(function(){
      <?php if($_COOKIE["_freml"] != "Y"):?>
        jQuery.ajax("<?php echo $surl;?>");
      <?php endif;?>

      $("#banner").click(function(){
          jQuery.ajax("/framework/index.php/trackit/click/banner");
      });
      $("#download").click(function(){
          jQuery.ajax("/framework/index.php/trackit/click/download");
          //var url = "http://www.fanfestnwc2015.com.au/downloadurl.php?acode=<?php echo $_GET['acode'];?>";
          //$("#download_frame").attr("src",url) 
      });
      $("#content").click(function(){
          jQuery.ajax("/framework/index.php/trackit/click/content");
      });
      $(".fancybox").fancybox({ 
          'width'             : '80%',
          'height'            : '80%',
          'autoScale'         : false,
          'transitionIn'      : 'none',
          'transitionOut'     : 'none',
          'type'              : 'iframe',
          'padding'           : 0,
          'margin'            : 0,
          'autoDimensions'    : true
      });
      
      $(".fancybox_video").fancybox({
        'width'  : 728,           // set the width
        'height' : 426,           // set the height
        'type'   : 'iframe',       // tell the script to create an iframe
        'autoScale' : false,
        'autoSize': false,
      });

    });
  </script>
  <script type="text/javascript" src="/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
  <link rel="stylesheet" href="/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />

</head>

<body class="main">
<div id="wrapper">
  <!-- start html block -->
  <header>
  </header>
  <section>
    <div class="content">
      <?php if($accessCode==""):?>
        
        <?php if($eventcode=="SR" || $eventcode=="LK"):?>
          <a href="/playvideo.php?acode=<?php echo $_GET['acode'];?>" class="fancybox_video">
            <img src="<?php echo $mediaurl;?>" width="780px" id="content" height="411px">
          </a> 
        <?php else:?>
          <img src="<?php echo $mediaurl;?>" width="780px" id="content" height="411px">
        <?php endif;?>
      <?php else:?>
        <?php if($accessCode=="pp"||$accessCode=="mvp"||$accessCode=="qs"):?>
          <img src="img/bg_facebook2.jpg" width="780px" id="content" height="411px">
        <?php elseif($accessCode=="ls"):?>
          <img src="img/bg_lipsync.png" width="780px" id="content" height="411px">
        <?php elseif($accessCode=="fc"||$accessCode=="fc2"):?>
          <img src="img/bg_cheercam.png" width="780px" id="content" height="411px">
        <?php endif;?>
      <?php endif;?>
    </div>
    <div class="message">
      <img src="img/txt_share_now.png">
    </div>
    <div class="sharebutton">
      <div class='st_facebook_custom' displayText='Facebook'></div>
      <div class='st_twitter_custom' displayText='Tweet' st_url="<?php echo $shorturl;?>"></div>
      <div class='st_pinterest_custom'></div>
      <a href="<?php echo $downloadurl;?>" id="download"><div class='st_download_custom' ></div></a>
      <div class='st_hash_custom'></div>
      <!--
      <span class='st_facebook_large' displayText='Facebook'></span>
      <span class='st_twitter_large' displayText='Tweet'></span>
      <span class='st_instagram_large' displayText='Instagram Badge' st_username='AndyKellzz' st_image="<?php echo $contentUrl;?>"></span>
      <span class='st__large' displayText=''></span>
      -->
    </div>
    <div class="banner">
      <a href="http://tickets.nwc2015.com.au/shows/show.aspx?sh=nwc2015"><img id="banner" src="img/img_banner.png"></a>
    </div>
  </section>
  <footer>
    <div class="policy"><a href="/privacy.html" class="fancybox">Policy Statement</a></div>
    <div class="tnc"><?php if($eventcode=="MVP"):?><a href="/tnc.html" class="fancybox">Terms & Conditions</a><?php endif;?></div>
    <div class="sponsor">
      <img src="img/gr_tcs.png">
    </div>
  </footer>
  <!-- end html block -->
  <iframe id="download_frame" width="0px" height="0px" style="display:none;"></iframe>
</div>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-60030327-1', 'auto');
  ga('send', 'pageview');
</script>
</body>
</html>
