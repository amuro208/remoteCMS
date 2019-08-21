<?php
date_default_timezone_set('Australia/Sydney'); 

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

$accessCode = $_GET["acode"];
if(empty($_GET['acode'])){
  exit;
}

if(substr($accessCode,0,4) == "TEST"){

  $mediaurl = "http://www.f1forreal.com.au/framework/uploads/PD/2016-01-06/fileName0064.jpg";
  $fb_title = "TEST Facebook Title"; 
  $fb_message = "Test Facebook Message";
  $twitter_title = "Test Twitter Message";
  $longurl = "http://www.f1forreal.com.au/?acode=a568c4ae516f39451024512z";
  $shorturl = "http://www.f1forreal.com.au/?acode=a568c4ae516f39451024512z";
  $shareurl = "http://www.f1forreal.com.au/?acode=a568c4ae516f39451024512z";
  $eventcode = "PD";
  $reserve1 = "";
  $reserve2 = "";
  $reserve3 = "";

  $accessCode = "a568c4ae516f39451024512z";

}else if(substr($accessCode,0,6) == "DESIGN"){
  $mediaurl = "http://placehold.it/960x540";
  $fb_title = "TEST Facebook Title"; 
  $fb_message = "Test Facebook Message";
  $twitter_title = "Test Twitter Message";
  $longurl = "";
  $shorturl = "";
  $shareurl = "";
  $eventcode = "VK";
  $reserve1 = "";
  $reserve2 = "";
  $reserve3 = "";

}else{
  $url = $frameurl."/index.php/trackit/getmediaurl/".$accessCode;
  $retdata = file_get_contents($url);

  $retdata = json_decode($retdata);
  $mediaurl = $retdata->mediaurl;
  if(empty($mediaurl)){
    exit;
  }

  $fb_title = $retdata->fb_title;
  $fb_message = $retdata->fb_message;
  $twitter_title = $retdata->twitter_title;
  $longurl = $retdata->longurl;
  $shorturl = $retdata->shorturl;
  $shareurl = $retdata->shareurl2;
  $eventcode = $retdata->eventcode; 
  $reserve1 = $retdata->reserve1; 
  $reserve2 = $retdata->reserve2; 
  $reserve3 = $retdata->reserve3; 
  $youtubeid = $retdata->youtubeid; 
}

$referer =  urlencode($_SERVER['HTTP_REFERER']);
$surl= $frameurl."/index.php/trackit/showcontent/".$accessCode."/".$referer;
$downloadurl = $root."/downloadurl.php?acode=".$accessCode;

?>

<!DOCTYPE HTML>
<html>
<head>
  <title>CA Microsite</title>

  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <link href="style.css" rel="stylesheet" type="text/css">

  <!--Facebook TAG-->
  <?php if($eventcode == "FC"): /*share youtube video*/?>
    <meta property="og:title" content="<?php echo $fb_title;?>"/>
    <meta property="og:description" content="<?php echo $fb_message;?>"/>
    <meta property="og:url" content="<?php echo $shareurl;?>"/>
    <meta property="og:type" content="video">
    <meta property="og:video:url" content="https://www.youtube.com/embed/<?php echo $youtubeid?>">
    <meta property="og:video:type" content="text/html">
    <meta property="og:video:width" content="640">
    <meta property="og:video:height" content="360">
    <meta property="og:video:url" content="http://www.youtube.com/v/<?php echo $youtubeid?>?version=3&amp;autohide=1">
    <meta property="og:video:type" content="application/x-shockwave-flash">
    <meta property="og:video:width" content="640">
    <meta property="og:video:height" content="360">
  <?php else:?>
    <meta property="og:image" content="<?php echo $longurl;?>"/>
    <meta property="og:title" content="<?php echo $fb_title;?>"/>
    <meta property="og:description" content="<?php echo $fb_message;?>"/>
    <meta property="og:url" content="<?php echo $shareurl;?>"/>
  <?php endif;?>

  <!--Twitter TAG-->
  <meta property="twitter:image" content="<?php echo $longurl;?>"/>
  <meta property="twitter:title" content="<?php echo $twitter_title;?>"/>
  <meta property="twitter:description" content="<?php echo $twitter_title;?>"/>
  <meta property="twitter:url" content="<?php echo $shorturl;?>"/>

  <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>

  <script>
    "use.strict";
    
    jQuery.browser = {};
    (function () {
        jQuery.browser.msie = false;
        jQuery.browser.version = 0;
        if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
            jQuery.browser.msie = true;
            jQuery.browser.version = RegExp.$1;
        }
    })();

    $(function(){
      <?php if($_COOKIE["_freml"] != "Y"):?>
        jQuery.ajax("<?php echo $surl;?>");
      <?php endif;?>
      
      $("#banner").click(function(){
          jQuery.ajax("/framework/index.php/trackit/click/banner");
      });
      $("#download").click(function(){
          jQuery.ajax("/framework/index.php/trackit/click/download");
      });
      $("#content").click(function(){
          jQuery.ajax("/framework/index.php/trackit/click/content");
      });
      $("#facebook").click(function(e) {
          e.preventDefault();
          <?php if($eventcode == "VK"): /*share gif file*/?>
            var href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $mediaurl;?>&t=<?php echo $fb_title;?>";
          <?php elseif($eventcode == "FC"): /*share youtube video*/?>
            var href="https://www.facebook.com/sharer/sharer.php?u=http://www.youtube.com/watch?v=<?php echo $youtubeid?>&t=<?php echo $fb_title;?>";
          <?php else:?>
            var href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $shareurl;?>&t=<?php echo $fb_title;?>";
          <?php endif;?>
          popupCenter(href,"facebook",550,300); 
          jQuery.ajax("/framework/index.php/trackit/click/facebook");
      });
      $("#twitter").click(function(e) {
          e.preventDefault();
          var href="<?php echo $frameurl;?>/twitter/oauth2callback/?acode=<?php echo $accessCode;?>";
          popupCenter(href,"tweet",550,300); 
          jQuery.ajax("/framework/index.php/trackit/click/twitter");
      });
      $("#instagram").click(function(e) {
          jQuery.ajax("/framework/index.php/trackit/click/instagram");
      });
      $(".fancybox").fancybox({ 
          'width'             : '80%',
          'height'            : '80%',
          'autoScale'         : false,
          'transitionIn'      : 'none',
          'transitionOut'     : 'none',
          'type'              : 'iframe',
          //'padding'           : 0,
          //'margin'            : 0,
          'autoDimensions'    : true
      });
      
      $(".various").fancybox({
          maxWidth     : 300,
          maxHeight    : 550,
          fitToView    : false,
          width        : '80%',
          height       : '80%',
          autoSize     : false,
          closeClick   : false,
          openEffect   : 'none',
          closeEffect  : 'none'
      });
      /*
      $(".fancybox_video").fancybox({
        'width'  : 728,           // set the width
        'height' : 426,           // set the height
        'type'   : 'iframe',       // tell the script to create an iframe
        'autoScale' : false,
        'autoSize': false,
      });
      */
    });

    function popupCenter(pageURL, title,w,h) {
      var left = (screen.width/2)-(w/2);
      var top = (screen.height/2)-(h/2);
      var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
      return targetWin;
    } 

  </script>
  <script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
  <link rel="stylesheet" href="./fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
</head>

<body class="main">
  <div id="outer_wrapper">
    <div id="wrapper" style="padding-top:20px;">
      <section>
        <!--HEADER-->
        <div id="top_banner" style="background-color:#ffffff;width:100%;text-align:center;padding:0px 0px 20px;">
          <img src="./img/desktop/header.png" style="width:100%;">
        </div>        
        <!--/HEADER-->
        
        <!--Contents-->
        <div class="fc_content">
          <?php if($user_agent == "desktop"):?>
            <iframe id="vid_frame" src="http://www.youtube.com/embed/<?php echo $youtubeid?>?rel=0&showinfo=0&autohide=1" width="872" height="490" frameborder="0"></iframe>
          <?php endif;?>
        </div>
        <!--//Contents-->
        
        <!--Share Tags-->
        <div class="message">
          <img id="tagtxt_img" src="./img/desktop/gr_youunlimited.png">
        </div>
        <!--//Share Tags-->
        
        <!--Share Button-->
        <div class="sharebutton">
            <!--Facebook Share-->
            <a href="https://www.facebook.com/sharer/sharer.php?u=http://www.youtube.com/watch?v=<?php echo $youtubeid?>&t=<?php echo $fb_title;?>" class="desktop" id="facebook"><img src="./img/mobile/btn_share.png" class="mobile" width="198px"/></a>
            <!--Instagram Share-->
            <a href="<?php echo $root;?>/instagram.php?acode=<?php echo $accessCode;?>" id="instagram" class='various'><img src="./img/mobile/btn_post.png" class="mobile" width="198px"/></a>
        </div>
        <!--//Share Button-->
        
        <!--Share Message-->
        <div class="message">
          <img id="downloadtxt_img" src="./img/desktop/txt_downloadclip.png">
        </div>
        <!--//Share Message-->
        
        <!--Download-->
        <div class="sharebutton">
          <?php if($user_agent == "desktop"):?>
            <a href="<?php echo $downloadurl;?>" id="download" target="download_frame"><img src="./img/mobile/btn_download.png" class="mobile" width="198px"/></a>
          <?php else: ?>
            <?php if($user_agent == "android"):?>
              <a href="<?php echo $downloadurl;?>" id="download" target="download_frame"><img src="./img/mobile/btn_download.png" class="mobile" width="198px"/></a>
            <?php else: ?>
              <a href="<?php echo $root;?>/instagram.php?acode=<?php echo $accessCode;?>&m=down" id="download" class="various"><img src="./img/mobile/btn_download.png" class="mobile" width="198px"/></a>
            <?php endif ?>
          <?php endif ?>
        </div>
        <!--//Download-->
        
        <!--banner-->
        <div class="banner">
          <div class="sponsor">
            <img id="wintxt_img" src="./img/desktop/txt_win.png" style="width:100%;">
          </div>
        </div>
        <!--//banner-->
        
        <!--Links-->
        <div class="links">
          <p>You unlimited <a href="<?php echo $frameurl;?>/trackit/clickedmlink2/3/<?php echo $accessCode;?>" target="about:blank">youunlimitedanz.com</a></p>
          <p>Facebook: <a href="<?php echo $frameurl;?>/trackit/clickedmlink2/4/<?php echo $accessCode;?>" target="about:blank">https://www.facebook.com/charteredaccountants</a></p>
          <p>Instagram: <a href="<?php echo $frameurl;?>/trackit/clickedmlink2/5/<?php echo $accessCode;?>" target="about:blank">https://www.instagram.com/charteredaccountantsanz/</a></p>
          <p>YouTube: <a href="<?php echo $frameurl;?>/trackit/clickedmlink2/6/<?php echo $accessCode;?>" target="about:blank">https://www.youtube.com/user/mycareerpathway</a></p>
        </div>
        <!--//Links-->
        
        <!--FollowUs-->
        <div class="followus mobile" style="text-align:center;">
          <img id="followustxt_img" src="./img/mobile/txt_followus_mb.png" width="86px">
        </div>
        <!--/FollowUs-->
        
        <!--Link Buttons-->
        <div class="linkbuttons">
          <a href="<?php echo $frameurl;?>/trackit/clickedmlink2/4/<?php echo $accessCode;?>" target="about:blank"><img src="./img/desktop/icon_facebook.png"></a>
          <a href="<?php echo $frameurl;?>/trackit/clickedmlink2/5/<?php echo $accessCode;?>" target="about:blank"><img src="./img/desktop/icon_instagram.png"></a>
          <a href="<?php echo $frameurl;?>/trackit/clickedmlink2/6/<?php echo $accessCode;?>" target="about:blank"><img src="./img/desktop/icon_youtube.png"></a>
        </div>
        <!--//Link Buttons-->
        
        <!--Terms&Contidtion-->
        <div class="tnc" style="text-align:center;margin-bottom:10px;">
          <a href="./tnc.htm" class="fancybox" style="font-size:12px;text-decoration:none;">"MEET THE BUSINESS 360CAM COMPETITION"
          TERMS AND CONDITIONS</a>
        </div>
        <!--//Terms&Contidtion-->
      </section>
    </div>
    <!--Footer-->
    <div class="footer" style="">
      <section>
        <p>© 2016 Chartered Accountants Australia and New Zealand. All rights reserved. ABN 50 084 642 571. This material is subject to
  our full terms and conditions, available at <a style="color:#fff" href="http://www.charteredaccountantsanz.com">www.charteredaccountantsanz.com</a></p>
        <a href="<?php echo $frameurl;?>/trackit/clickedmlink2/7/<?php echo $accessCode;?>" target="about:blank"><img src="./img/desktop/gr_poweredby.png"></a>
      </section>
    </div>
    <!--//Footer-->
  </div>
  <iframe name="download_frame" id="download_frame" width="0px" height="0px" style="display:none;"></iframe>
  <script>
    (function(){
    })();  
  </script>
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
