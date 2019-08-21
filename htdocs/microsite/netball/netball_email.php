<?php 
$accessCode = $_REQUEST["accessCode"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Netball Worldcup 2015</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
    body,div,span,td,p{padding:0px;margin:0px;font-size:12px;}
    a{color:red;text-decoration:underline;}
    p{margin:0px 0px 15px 0px;font-weight:normal;}
  </style>
</head>
<body style="margin: 0; padding: 0;">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
    <tr>
      <td align="center" bgcolor="#000000" valign="top">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">  
        <tr>
          <td>
            <img src="http://www.fanfestnwc2015.com.au/img/img_header.jpg" width="600px">
          </td>
        </tr>
        <tr>
          <td>
            <?php if($accessCode=="pp"||$accessCode=="mvp"||$accessCode=="qs"):?>
              <img src="http://www.fanfestnwc2015.com.au/img/bg_facebook2.jpg" width="600px">
            <?php elseif($accessCode=="ls"):?>
              <img src="http://www.fanfestnwc2015.com.au/img/bg_lipsync.png" width="600px">
            <?php elseif($accessCode=="fc"||$accessCode=="fc2"):?>
              <img src="http://www.fanfestnwc2015.com.au/img/bg_cheercam.png" width="600px">
            <?php endif;?>
          </td>
        </tr>
        <tr>
          <td style="background-color:#2b3594;color:#ffffff;font-family:Helvetica,Arial;font-size:12px;padding:20px 60px 5px 60px;">
            <p style="font-size:12px;font-weight:100;">Dear <?php echo $firstName;?>,</p>
            <p style="font-size:12px;font-weight:100;">Thanks for visiting the Riverbank Precinct Footbal Fan Zone!  We hope you enjoyed the Virtual Shootout experience and would love to see you back here again for future events.</p>
            <!--
            This is the standard email template of TCS CMS.<br>
            <b style="color:red">You should add the title and template of Event on System Option.</b>
            <br>
            <br>
            AccessCode : <?php echo $accessCode;?><br>
            CMSHomeUrl : <?php echo $cmsHomeUrl;?><br>
            HomeUrl : <?php echo $homeUrl;?><br>
            Userid : <?php echo $userid;?><br>
            EventCode : <?php echo $eventCode;?><br>
            FirstName : <?php echo $firstName;?><br>
            LastName : <?php echo $lastName;?><br>
            EmailTestData : <?php echo $emailTestData;?><br>
            FileName : <?php echo $fileName;?><br>
            OpenEmailLink : <a href="<?php echo $cmsHomeUrl;?>trackit/showcontent/<?php echo $accessCode;?>">Show Contents</a><br>
            OpenShareLink : <a href="<?php echo $cmsHomeUrl;?>trackit/showcontent/<?php echo $shareAccessCode;?>">Show Contents</a>
            -->
          </td>
        </tr>
        <tr>
          <td style="background-color:#2b3594;padding:20px 20px 50px 20px;text-align:center;">
            <a href="<?php echo $cmsHomeUrl;?>trackit/showcontent/<?php echo $accessCode;?>"><img src="http://www.fanfestnwc2015.com.au/img/gr_click_here.png" width="225px"></a>
          </td>
        </tr>
        <tr>
          <td style="background-color:#2b3594;padding:0px 20px;">
            <table border="0" cellpadding="0" cellspacing="0" width="560">
              <tr><td style="height:1px;background-color:white;"></td></tr>
            </table>
          </td>
        </tr>
        <tr>
          <td style="background-color:#2b3594;color:#cdcdcd;font-family:Helvetica,Arial;font-size:9px;font-weight:100;padding:10px 20px;">
            You've received this email because you, or someone you know, recently participated in an activity at Adelaide Oval. To unsubscribe or if you have received this in error, please contact <a href="http://riverbank.sa.gov.au/contact-us">Riverbank</a> &copy;2015 Renewal SA | All Rights Reserved
          </td>
        </tr>
        <tr>
          <td align="center" style="background-color:#2b3594;padding:10px 0px 20px 0px;">
            <img src="http://www.fanfestnwc2015.com.au/img/gr_tcs.png" width="150px" height="23px" style="width:150px;height:23px;"/>
          </td>
        </tr>
        </table>
      </td>
    </tr>     
  </table>
</body>
</html>
