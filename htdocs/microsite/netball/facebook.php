<?php
/*
if($_COOKIE["_freml"] != "Y"){
  $acode = $_GET['acode'];
  if($acode != null){
    $url="/codeigniter/index.php/trackit/showcontent/".$acode;
    header("Location: $url"); 
    exit;
  }
}
*/
?>
<!DOCTYPE HTML>
<html>
<head>
  <title></title>
  <link href="style.css" rel="stylesheet" type="text/css">

  <!--Facebook TAG-->
  <meta property="og:title" content="This is a test title" />
  <meta property="og:description" content="This is a test description" />
  <meta property="og:image" content="http://www.naircare.co.uk/images/main/hub/bg-face.jpg" />

  <!--[if lt IE 9]>
  <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
  <script src="http://modernizr.com/downloads/modernizr-latest.js" type="text/javascript"></script>

  <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
  <script type="text/javascript">
    stLight.options({publisher: "03ae05d7-e2ca-4a77-bbd9-1d873c63e0c8", doNotHash: false, doNotCopy: false, hashAddressBar: false, shorten:false});
    function myCallbackFunction (event,service)
    {
       //alert("event called is:"+event); //the event type. Only "click" is supported.
       //alert("service called is:"+service); //the service shared by user. e.g. facebook
       console.log("event called is:"+event);
       console.log("service called is:"+service);
       jQuery.ajax("/codeigniter/index.php/trackit/click/"+service);
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
      //if('<?php echo $acode;?>' != ''){
      //  jQuery.ajax("/codeigniter/index.php/trackit/showcontent/<?php echo $acode;?>");
      //}
      $("#banner").click(function(){
          console.log("#banner");
          jQuery.ajax("/codeigniter/index.php/trackit/click/banner");
      });

      $("#download").click(function(){
          console.log("#download");
          jQuery.ajax("/codeigniter/index.php/trackit/click/download");
      });

      $("#content").click(function(){
          console.log("#content");
          jQuery.ajax("/codeigniter/index.php/trackit/click/content");
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
          'width'  : 730,       // set the width
          'height' : 420,       // set the height
          'type'   : 'iframe',  // tell the script to create an iframe
          'autoScale' : false,
          'autoSize': false,
          /*
          onStart : function() {
              jQuery.ajax("/codeigniter/index.php/trackit/click/content");
              return true;
          },
           */
      });

      /* 
      $(".st_facebook_custom").click(function(){
        ga('send', 'event', 'snsshare', 'facebook');
      });
      $(".st_twitter_custom").click(function(){
        ga('send', 'event', 'snsshare', 'twitter');
      });
      $(".st_download_custom").click(function(){
        $("#download").attr("src","/downloadurl.php?accessCode=<?php echo $accessCode;?>")
        ga('send', 'event', 'snsshare', 'download');
      });
      */ 
      
    });
    
    /*
    function clickHere(){
      ga('send', 'event', 'clickhere', 'click');
      document.location.href="http://tickets.cricketworldcup.com/fixtures/default.aspx";
    }
    */
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
    <div class="sharebutton">
      <span class='st_facebook_large' displayText='Facebook'></span>
      <span class='st_twitter_large' displayText='Tweet'></span>
      <span class='st__large' displayText=''></span>
    </div>
    <div>
      <button id="banner">Banner</button>
      <button id="download">Download</button>
      <button id="content">Content</button>
    </div>
  </section>
  <footer>
  </footer>
  <!-- end html block -->

  <iframe id="download_frame" width="0px" height="0px"></iframe>
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

