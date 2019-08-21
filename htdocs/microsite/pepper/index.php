<?php
date_default_timezone_set('Australia/Sydney'); 

$root = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$frameurl = $root."/framework";

$accessCode = $_GET["acode"];
if(empty($_GET['acode'])){
  exit;
}

if(substr($accessCode,0,4) == "TEST"){

  $mediaurl = "http://www.peperfanzone.com.au/framework/uploads/PD/2016-01-06/fileName0064.jpg";
  $fb_title = "TEST Facebook Title"; 
  $fb_message = "Test Facebook Message";
  $longurl = "http://www.peperfanzone.com.au/?acode=a568c4ae516f39451024512z";
  $shorturl = "http://www.peperfanzone.com.au/?acode=a568c4ae516f39451024512z";
  $shareurl = "http://www.peperfanzone.com.au/?acode=a568c4ae516f39451024512z";
  $eventcode = "PD";
  $reserve1 = "";
  $reserve2 = "";
  $reserve3 = "";

  $accessCode = "a568c4ae516f39451024512z";

}else if(substr($accessCode,0,6) == "DESIGN"){

  $mediaurl = "http://placehold.it/537x282";
  $fb_title = "TEST Facebook Title"; 
  $fb_message = "Test Facebook Message";
  $longurl = "";
  $shorturl = "";
  $shareurl = "";
  $eventcode = "";
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
  <title></title>

  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <link href="style.css" rel="stylesheet" type="text/css">

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
      });
      $("#content").click(function(){
          jQuery.ajax("/framework/index.php/trackit/click/content");
      });
      $("#facebook").click(function(e) {
          e.preventDefault();
          var href = $(e.target.parentElement).attr('href');
          popupCenter(href,"facebook",550,300); 
          jQuery.ajax("/framework/index.php/trackit/click/facebook");
      });
      $("#twitter").click(function(e) {
          e.preventDefault();
          var href = $(e.target.parentElement).attr('href');
          popupCenter(href,"tweet",550,300); 
          jQuery.ajax("/framework/index.php/trackit/click/twitter");
      });
      $("#instagram").click(function(e) {
          e.preventDefault();
          var href = $(e.target.parentElement).attr('href');
          popupCenter(href,"instagram",300,470); 
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
  <div id="wrapper">
    <section>
      <div class="header">
        <img src="./img/gr_header.png" id="header">
      </div>
      <div class="content">
        <img src="<?php echo $mediaurl;?>" id="content">
      </div>
      <div class="sharenow">
        <img src="img/txt_sharenow.png">
      </div>
      <div class="sharebutton">
        <!--Facebook Share-->
        <!--
        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $shareurl;?>&t=<?php echo $fb_title;?>" id="facebook">
          <img src="./img/btn_facebook.png" alt=""></a>
        -->
        <!--Facebook Upload-->
        <a href="<?php echo $frameurl;?>/facebook/auto2callback/?acode=<?php echo $accessCode;?>" id="facebook"><img src="./img/btn_facebook.png" alt=""></a>

        <!--Twitter Share-->
        <a href="http://twitter.com/share?text=<?php echo $fb_title;?>&hashtags=AusGP&url=<?php echo $shorturl;?>" id="twitter">
          <img src="./img/btn_twitter.png" alt=""></a>

        <!--Instagram Share-->
        <a href="http://www.peperfanzone.com.au/instagram.php?acode=<?php echo $accessCode;?>" id="instagram">
          <img src="./img/btn_instagram.png" alt=""></a>
      </div>
      <div class="sharemessage">
        <p>You can check other Wanderers Fan stories below and download your clip to keep forever!</p>
      </div>
      <div class="sharebutton">
        <a href="<?php echo $frameurl;?>/facebook/auto2callback/?acode=<?php echo $accessCode;?>" id="facebook"><img src="./img/btn_flickr.png" alt=""></a>
      </div>
      <div class="message">
        <p>Pepper is one of Australia's largest non-bank home loan lenders that can help you with your purchase or refinancing needs. Want to learn more? Check out our <a href="http://www.pepper.com.au/">website</a> or call a Pepper Lending Specialist today on 13 73 77.</p>
      </div>
      <div class="footer-line">
         <img src="./img/gr_line.png" style="width:100%;">
      </div>
      <div class="footer">
        <p>Pepper Group Limited ACN 094 317 665, Australian Credit Licence Number 286655, is the servicer of loans made by Pepper
Finance Corporation Ltd ACN 094 317 647.</p>
      </div>
      <div class="banner">
        <a href="<?php echo $frameurl;?>/trackit/clickedmlink2/5/<?php echo $accessCode;?>" target="about:blank"><img src="img/gr_tcs.png"></a>
      </div>
    </section>
  </div>
  <iframe name="download_frame" id="download_frame" width="0px" height="0px" style="display:none;"></iframe>
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
