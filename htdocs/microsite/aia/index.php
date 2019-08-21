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
  $mediaurl = "http://placehold.it/360x480";
  $fb_title = "TEST Facebook Title"; 
  $fb_message = "Test Facebook Message";
  $twitter_title = "Test Twitter Message";
  $longurl = "";
  $shorturl = "";
  $shareurl = "";
  $eventcode = "FP";
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
}

$referer =  urlencode($_SERVER['HTTP_REFERER']);
$surl= $frameurl."/index.php/trackit/showcontent/".$accessCode."/".$referer;
$downloadurl = $root."/downloadurl.php?acode=".$accessCode;

?>

<!DOCTYPE HTML>
<html>
<head>
  <title>AIA Microsite</title>

  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <link href="style.css" rel="stylesheet" type="text/css">

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
  <meta property="twitter:title" content="<?php echo $twitter_title;?>"/>
  <meta property="twitter:description" content="<?php echo $twitter_title;?>"/>
  <meta property="twitter:url" content="<?php echo $shorturl;?>"/>

  <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
  <script src="http://modernizr.com/downloads/modernizr-latest.js" type="text/javascript"></script>

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
          <?php if($eventcode == "VK"): ?>
            var href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $mediaurl;?>&t=<?php echo $fb_title;?>";
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
          'padding'           : 0,
          'margin'            : 0,
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
  <div id="top_banner" style="background-color:#d31145;width:100%;text-align:center;padding:26px 0px 12px;">
    <img src="img/desktop/gr_aia_logo.png">
  </div>
  <div id="outer_wrapper">
    <div id="wrapper" style="padding-top:50px;">
      <section>
        <!--Contents-->
        <?php if($eventcode == "VK"): ?>
          <div class="vk_content">
            <?php if($user_agent == "desktop"):?>
              <img src="<?php echo $mediaurl;?>" id="content">
            <?php else:?>
              <a href="<?php echo $root;?>/instagram.php?acode=<?php echo $accessCode;?>&m=down" id="download" class="various"><img src="<?php echo $mediaurl;?>" id="content"></a>
            <?php endif;?>
          </div>
        <?php else: ?>  
          <div class="fp_content">
            <?php if($user_agent == "desktop"):?>
              <img src="<?php echo $mediaurl;?>" id="content">
            <?php else:?>
              <a href="<?php echo $root;?>/instagram.php?acode=<?php echo $accessCode;?>&m=down" id="download" class="various"><img src="<?php echo $mediaurl;?>" id="content"></a>
            <?php endif;?>
          </div>
        <?php endif; ?>
        <!--//Contents-->
        
        <!--Share Button-->
        <div class="sharebutton">
          <?php if($eventcode == "VK"): ?>
            <!--Facebook Share-->
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $mediaurl;?>&t=<?php echo $fb_title;?>" class="desktop" id="facebook"><img src="./img/mobile/btn_facebook_396x110.png" class="mobile" width="198px"/></a>
            <!--Twitter Share-->
            <a href="<?php echo $frameurl;?>/twitter/oauth2callback/?acode=<?php echo $accessCode;?>" id="twitter"><img src="./img/mobile/btn_twitter_396x110.png" class="mobile" width="198px"/></a>
            <!--Instagram Share-->
            <a href="<?php echo $root;?>/instagram.php?acode=<?php echo $accessCode;?>" id="instagram" class='various'><img src="./img/mobile/btn_instagram_396x110.png" class="mobile" width="198px"/></a>
          <?php else: ?>  
            <!--Facebook Share-->
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $shareurl;?>&t=<?php echo $fb_title;?>" class="desktop" id="facebook"><img src="./img/mobile/btn_facebook_396x110.png" class="mobile" width="198px"/></a>
            <!--Twitter Share-->
            <a href="<?php echo $frameurl;?>/twitter/oauth2callback/?acode=<?php echo $accessCode;?>" id="twitter"><img src="./img/mobile/btn_twitter_396x110.png" class="mobile" width="198px"/></a>
            <!--
            <a href="http://twitter.com/share?text=<?php echo $twitter_title;?>&hashtags=AUSvTJK&url=<?php echo $shorturl;?>" id="twitter"><img src="./img/mobile/btn_twitter_396x110.png" class="mobile" width="198px"/></a>
            -->
            <!--Instagram Share-->
            <a href="<?php echo $root;?>/instagram.php?acode=<?php echo $accessCode;?>" id="instagram" class='various'><img src="./img/mobile/btn_instagram_396x110.png" class="mobile" width="198px"/></a>
          <?php endif; ?>
        </div>
        <div class="message">
          <img src="img/desktop/txt_sharenow.png">
        </div>
        <!--//Share Button-->
        
        <!--Download-->
        <div class="sharebutton" style="margin:30px 0px 0px 0px;">
          <?php if($user_agent == "desktop"):?>
            <a href="<?php echo $downloadurl;?>" id="download" target="download_frame"><img src="./img/mobile/btn_download_396x110.png" class="mobile" width="198px"/></a>
          <?php else: ?>
            <?php if($user_agent == "android"):?>
              <a href="<?php echo $downloadurl;?>" id="download" target="download_frame"><img src="./img/mobile/btn_download_396x110.png" class='mobile' width="198px"/></a>
            <?php else: ?>
              <a href="<?php echo $root;?>/instagram.php?acode=<?php echo $accessCode;?>&m=down" id="download" class="various"><img src="./img/mobile/btn_download_396x110.png" class='mobile' width="198px"/></a>
            <?php endif ?>
          <?php endif ?>
        </div>
        <!--//Download-->
        
        <!--banner-->
        <div class="banner">
          <div class="sponsor">
            <a href="<?php echo $frameurl;?>/trackit/clickedmlink2/3/<?php echo $accessCode;?>" target="about:blank"><img id="sponsor_img" src="img/desktop/gr_poweredbytcs.png"></a>
          </div>
        </div>
        <!--//banner-->
      </section>
    </div>
  </div>
  <iframe name="download_frame" id="download_frame" width="0px" height="0px" style="display:none;"></iframe>
  <script>
    (function(){
      <?php if($user_agent == "desktop"):?>
        var min_wrapper = 930;
        var top_banner = 118;
      <?php else: ?>
        var min_wrapper = 400;
        var top_banner = 118;
      <?php endif ?>
    
      var windowH = $(window).height();
      if(windowH > (min_wrapper + top_banner)) {
          $('#outer_wrapper').css({'height':(windowH)+'px'});
      }else{
          $('#outer_wrapper').css({'height':(min_wrapper)+'px'});
      }

      $(window).resize(function(){
          var windowH = $(window).height();
          if(windowH > (min_wrapper + top_banner)) {
              $('#outer_wrapper').css({'height':(windowH)+'px'});
          }else{
              $('#outer_wrapper').css({'height':(min_wrapper)+'px'});
          }
      })       
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
