<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>TCS CMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <style>
    p{padding:0px;margin:5px 0px;font-size:12px;}
  </style>
</head>
<body style="margin: 0; padding: 0;">
  <table align="center" border="0" cellpadding="0" cellspacing="0" width="800">
    <tr>
      <td align="center" bgcolor="#00acbf" valign="top">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="800">  
        <tr>
          <td style="background-color:#00acbf;color:#f0f9fa;font-family:Arial;font-size:15px;padding:20px 20px 10px 20px;">
          <b>STANDARD EMAIL TEMPLATE</b>
          </td>
        </tr>
        <tr>
          <td style="background-color:white;color:#282a2b;font-family:Arial;font-size:13px;padding:20px 20px 30px 20px;">
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
          </td>
        </tr>
        <tr>
          <td>
            <img alt="" src="<?php echo $cmsHomeUrl;?>trackit/openemail/<?php echo $accessCode;?>" width="0" height="0" style="width:0px;height:0px;"/>
          </td>
        </tr>
        <tr>
          <td style="color:#f0f9fa;font-family:Arial;font-size:13px;padding:20px 20px 20px 20px;">
          </td>
        </tr>
        <tr>
          <td height="80px" style="background-color:#363636;color:#c7ccd1;font-family:Arial;font-size:10px;padding:4px 20px;">
          </td>
        </tr>
        </table>
      </td>
    </tr>     
  </table>
</body>
</html>
