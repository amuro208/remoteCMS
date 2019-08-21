<?php
date_default_timezone_set('Australia/Sydney');

//$root             = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$micrositeRootUrl = "http://cms-p2.reflexwall.com.au/m";
  //echo '<script language="javascript">';
  //echo 'alert("'.$root.'")';  //not showing an alert box.
  //echo '</script>';
$frameurl         = "http://cms-p2.reflexwall.com.au/framework";

$accessCode = $_GET["acode"];
if (empty($_GET['acode'])) {
    exit;
}

if (substr($accessCode, 0, 4) == "TEST") {

    $mediaurl   = "http://www.reflexwall.com.au/framework/uploads/PD/2016-01-06/fileName0064.jpg";
    $fb_title   = "TEST Facebook Title";
    $fb_message = "Test Facebook Message";
    $longurl    = "http://www.reflexwall.com.au/?acode=a568c4ae516f39451024512z";
    $shorturl   = "http://www.reflexwall.com.au/?acode=a568c4ae516f39451024512z";
    $shareurl   = "http://www.reflexwall.com.au/?acode=a568c4ae516f39451024512z";
    $eventcode  = "PD";
    $reserve1   = "";
    $reserve2   = "";
    $reserve3   = "";

    $accessCode = "a568c4ae516f39451024512z";

} else {
    if (substr($accessCode, 0, 6) == "DESIGN") {

        $mediaurl   = "./images/DESKTOP/micro_sample_img.png";
        $fb_title   = "TEST Facebook Title";
        $fb_message = "Test Facebook Message";
        $longurl    = "";
        $shorturl   = "";
        $shareurl   = "";
        $eventcode  = "VK";
        $reserve1   = "";
        $reserve2   = "";
        $reserve3   = "";

    } else {
        $url     = $frameurl . "/index.php/trackit/getmediaurl/" . $accessCode;
        $retdata = file_get_contents($url);

        $retdata  = json_decode($retdata);
        $mediaurl = $retdata->mediaurl;
        if (empty($mediaurl)) {
            //exit;
        }

        $fb_title   = $retdata->fb_title;
        $fb_message = $retdata->fb_message;
        $longurl    = $retdata->longurl;
        $shorturl   = $retdata->shorturl;
        $shareurl   = $retdata->shareurl2;
        $eventcode  = $retdata->eventcode;
        $reserve1   = $retdata->reserve1;
        $reserve2   = $retdata->reserve2;
        $reserve3   = $retdata->reserve3;
        $vurl       = $retdata->videourl;
    }
}

$referer     = urlencode($_SERVER['HTTP_REFERER']);
$surl        = $frameurl . "/index.php/trackit/showcontent/" . $accessCode . "/" . $referer;
$downloadurl = $micrositeRootUrl . "/downloadurl.php?acode=" . $accessCode;
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
    <link href="./style.css?v=1.0.1" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>

    <!--Pinterest TAG-->
    <meta property="image" content="<?php echo $longurl; ?>"/>
    <meta property="title" content="<?php echo $fb_title; ?>"/>
    <meta property="description" content="<?php echo $fb_message; ?>"/>
    <meta property="url" content="<?php echo $shareurl; ?>"/>

    <!--Facebook TAG-->
    <meta property="og:image" content="<?php echo $longurl; ?>"/>
    <meta property="og:title" content="<?php echo $fb_title; ?>"/>
    <meta property="og:description" content="<?php echo $fb_message; ?>"/>
    <meta property="og:url" content="<?php echo $shareurl; ?>"/>

    <!--Twitter TAG-->
    <meta property="twitter:image" content="<?php echo $longurl; ?>"/>
    <meta property="twitter:title" content="<?php echo $fb_title; ?>"/>
    <meta property="twitter:description" content="<?php echo $fb_message; ?>"/>
    <meta property="twitter:url" content="<?php echo $shorturl; ?>"/>

    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js" type="text/javascript"></script>

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

        $(document).ready(function () {
            <?php if($_COOKIE["_freml"] != "Y"):?>
            jQuery.ajax("<?php echo $surl;?>");
            <?php endif;?>

            $("#banner").click(function () {
                jQuery.ajax("/framework/index.php/trackit/click/banner");
            });
            $("#download").click(function () {
                jQuery.ajax("/framework/index.php/trackit/click/download");
            });
            $("#content").click(function () {
                jQuery.ajax("/framework/index.php/trackit/click/content");
            });
            $("#facebook").click(function (e) {
                e.preventDefault();
                var href = $(this).attr('href');
                popupCenter(href, "facebook", 550, 300);
                jQuery.ajax("/framework/index.php/trackit/click/facebook");
            });
            $("#twitter").click(function (e) {
                e.preventDefault();
                var href = $(this).attr('href');
                popupCenter(href, "tweet", 550, 300);
                jQuery.ajax("/framework/index.php/trackit/click/twitter");
            });
            $("#instagram").click(function (e) {
                e.preventDefault();
                var href = $(this).attr('href');
                popupCenter(href, "instagram", 300, 470);
                jQuery.ajax("/framework/index.php/trackit/click/instagram");
            });
        });

        function popupCenter(pageURL, title, w, h) {
            var left = (screen.width / 2) - (w / 2);
            var top = (screen.height / 2) - (h / 2);
            var targetWin = window.open(pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
            return targetWin;
        }
    </script>
</head>

<body class="main">
<div id="wrapper">
    <div class="section_wrapper">
        <section>
            <div class="logo">
                <img src="<?php echo $micrositeRootUrl; ?>/images/DESKTOP/micro_top_logo.png">
            </div>
            <div class="logo-text">
                <img src="<?php echo $micrositeRootUrl; ?>/images/DESKTOP/micro_top_copy.png">
            </div>
            <div class="content">
                <?php if($eventcode=='PP'){ ?>
                    <img src="<?php echo $mediaurl;?>" id="content">
                <?php }elseif($eventcode=='QS'){ ?>
                  <img src="<?php echo $mediaurl;?>" id="content">
                <?php }elseif($eventcode=='VK'){ ?>
                    <video id="video_<?php echo $vid;?>" class="video-js vjs-default-skin vk"
                      controls preload="auto" width="620" height="350">
                      <source src="<?php echo $videourl;?>" type='video/mp4' />
                      <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
                    </video>
                <?php } ?>

            </div>
            <div class="hash-text">
                <img src="./images/DESKTOP/micro_middle_copy.png">
            </div>
            <div class="sharebutton">
                <!--Facebook Share-->
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $shareurl; ?>&t=<?php echo $fb_title; ?>"
                   id="facebook"></a>

                <!--Twitter Share-->
                <a href="http://twitter.com/share?text=<?php echo $fb_title; ?>&hashtags=Reflexwall&url=<?php echo $shorturl; ?>"
                   id="twitter"></a>

                <!--Instagram Share-->
                <a href="<?php echo $micrositeRootUrl; ?>/instagram.php?acode=<?php echo $accessCode; ?>"
                   id="instagram"></a>
            </div>
            <div class="message">
                <img src="<?php echo $micrositeRootUrl; ?>/images/DESKTOP/micro_bottom_copy.png">
            </div>
            <div class="downloadbutton">
                <!--Download-->
                <a href="<?php echo $downloadurl; ?>" id="download" target="download_frame"></a>
            </div>

        </section>
    </div>
</div>
<div class="sponsor">
    <img src="<?php echo $micrositeRootUrl; ?>/images/DESKTOP/micro_bottom_logo.png">
</div>
<iframe name="download_frame" id="download_frame" width="0px" height="0px" style="display:none;"></iframe>
</body>
</html>
