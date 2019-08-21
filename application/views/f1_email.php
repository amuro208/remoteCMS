<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
      body,
      table,
      td,
      a {
          -webkit-text-size-adjust: 100%;
          -ms-text-size-adjust: 100%;
      }
      /* Prevent WebKit and Windows mobile changing default text sizes */
      
      table,
      td {
          mso-table-lspace: 0pt;
          mso-table-rspace: 0pt;
      }
      /* Remove spacing between tables in Outlook 2007 and up */
      
      img {
          -ms-interpolation-mode: bicubic;
      }
      /* Allow smoother rendering of resized image in Internet Explorer */
      /* RESET STYLES */
      
      body {
          margin: 0;
          padding: 0;
          background-color: #ffffff;
      }
      img {
          border: 0;
          height: auto;
          line-height: 100%;
          outline: none;
          text-decoration: none;
      }
      table {
          border-collapse: collapse !important;
      }
      body {
          height: 100% !important;
          margin: 0;
          padding: 0;
          width: 100% !important;
      }
      /* iOS BLUE LINKS */
      
      .appleBody a {
          color: #68440a;
          text-decoration: none;
      }
      .appleFooter a {
          color: #999999;
          text-decoration: none;
      }
      td[class="padding"] {
          padding: 0px 20px !important;
      }
      img#content_img{
          max-width:160px !important;
      }
      /* MOBILE STYLES */
      
      @media screen and (max-width: 525px) {
          /* ALLOWS FOR FLUID TABLES */
          
          table[class="wrapper"] {
              width: 100% !important;
          }
          /* ADJUSTS LAYOUT OF LOGO IMAGE */
          
          td[class="logo"] {
              text-align: left;
              padding: 20px 0 20px 0 !important;
          }
          td[class="logo"] img {
              margin: 0 auto!important;
          }
          /* USE THESE CLASSES TO HIDE CONTENT ON MOBILE */
          
          td[class="mobile-hide"] {
              display: none;
          }
          img[class="mobile-hide"] {
              display: none !important;
          }
          img[class="img-max"] {
              max-width: 100% !important;
              height: auto !important;
          }
          img[class="img-ninty"] {
              max-width: 90% !important;
              height: auto !important;
          }
          /* FULL-WIDTH TABLES */
          
          table[class="responsive-table"] {
              width: 100%!important;
          }
          /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
          
          td[class="padding"] {
              padding: 0px 2%!important;
          }
          td[class="padding-subject"] {
              padding: 20px 5% 10px 5% !important;
              text-align: center;
          }
          td[class="padding-copy"] {
              padding: 10px 5% 10px 5% !important;
              text-align: left;
          }
          td[class="padding-button"] {
              padding: 20px 5% 40px 5% !important;
              text-align: left;
          }
          td[class="padding-meta"] {
              padding: 30px 5% 0px 5% !important;
              text-align: center;
          }
          td[class="no-pad"] {
              padding: 0 0 20px 0 !important;
          }
          td[class="no-padding"] {
              padding: 0 !important;
          }
          td[class="section-padding"] {
              padding: 0px 0px 0px 0px !important;
          }
          td[class="section-header"] {
              padding: 10px 15px 10px 15px !important;
          }
          td[class="section-padding-bottom-image"] {
              padding: 50px 15px 0 15px !important;
          }
          /* ADJUST BUTTONS ON MOBILE */
          
          td[class="mobile-wrapper"] {
              padding: 10px 5% 15px 5% !important;
          }
          /*
          table[class="mobile-button-container"] {
              margin: 0 auto;
              width: 100% !important;
          }
          a[class="mobile-button"] {
              width: 80% !important;
              padding: 15px !important;
              border: 0 !important;
              font-size: 16px !important;
          }
          */
      }
    </style>
  </head>
  <body style="margin:0px;padding:0px;">
    <!-- ONE COLUMN SECTION -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 0px 0px 0px 0px;" class="section-padding">
          <table border="0" cellpadding="0" cellspacing="0" width="600" class="responsive-table">
            <tr>
              <td bgcolor="#000000">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <!--Header-->
                  <tr>
                    <td><img src="http://www.f1forreal.com.au/microsite/f1/img/edm_img_header.png" width="600" height="273" border="0" alt="F1 For Real Header" style="display: block; padding: 0; color: #666666; text-decoration: none; font-family: Helvetica, arial, sans-serif; font-size: 16px;" class="img-max">
                    </td>
                  </tr>
                  <tr>
                    <td><img src="http://www.f1forreal.com.au/microsite/f1/img/edm_txt_experiencing.png" width="600" height="85" border="0" alt="F1 For Real Header" style="display: block; padding: 0; color: #666666; text-decoration: none; font-family: Helvetica, arial, sans-serif; font-size: 16px;" class="img-max">
                    </td>
                  </tr>
                  <!-- Copy -->
                  <tr>
                    <td bgcolor="#000000">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td style="padding: 20px 40px 20px 40px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #fff;" class="padding-copy">
                            <p>Dear <?php echo $firstName;?>,<p>
                            <p>Now that you're starring on the cover of the official #AusGP magazine don't forget to share it online to all of your fans and tag us on Facebook <a href="<?php echo $cmsHomeUrl;?>trackit/clickedmlink2/6/<?php echo $accessCode;?>">@ausgrandprix</a>, Twitter <a href="<?php echo $cmsHomeUrl;?>trackit/clickedmlink2/7/<?php echo $accessCode;?>">@ausgrandprix</a> and Instagram <a href="<?php echo $cmsHomeUrl;?>trackit/clickedmlink2/8/<?php echo $accessCode;?>">@ausgp</a>.</p> 

                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <!--Content-->
                  <tr>
                    <td align="center" bgcolor="#000000">
                      <a href="<?php echo $cmsHomeUrl;?>trackit/showcontent/<?php echo $accessCode;?>" target="_blank"><img src="http://www.f1forreal.com.au/framework/uploads/<?php echo $fileName;?>" width="160" style="width:160px;"></a>
                    </td>
                  </tr>
                  <!-- Copy -->
                  <tr>
                    <td bgcolor="#000000">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td style="padding: 20px 40px 0 40px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #fff;" class="padding-copy">
                            <p>To experience all the thrills and spills at the 2016 Formula 1 Australian Grand Prix head to <a href="<?php echo $cmsHomeUrl;?>trackit/clickedmlink2/1/<?php echo $accessCode;?>">GrandPrix.com.au</a> for more information.</p> 
                            <p>F1. For Real.</p> 

                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <!-- BUTTON -->
                  <tr>
                    <td bgcolor="#000000" align="center">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
                        <tr>
                          <td style="padding: 40px 41px 40px 41px;" class="padding-button">
                            <a href="<?php echo $cmsHomeUrl;?>trackit/showcontent/<?php echo $accessCode;?>" target="_blank" class="mobile-button" style="margin:0px 17px 0px 0px"><img src="http://www.f1forreal.com.au/microsite/f1/img/edm_btn_clickhere.png"></a>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <!-- FOOTER -->
                  <tr>
                    <td align="center" style="height:1px;padding:0px;margin:0px;"><img src="http://www.f1forreal.com.au/microsite/f1/img/edm_hr.png" class="img-ninty"></td>
                  <tr>
                    <td align="left" bgcolor="#000000" class="padding-copy" style="padding:10px 41px 10px 41px; font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#ccc;">
                    You've received this email because you, or someone you know, recently participated in an activity relating to the 2016 Formula 1 Australian Grand Prix. To unsubscribe or if you have received this in error, please visit <a href="http://www.grandprix.com.au/privacy-policy" target="about:blank">http://www.grandprix.com.au/privacy-policy</a> &copy; 2016 Australian Grand Prix Corporation - All rights reserved.
                    </td>
                    <tr>
                      <td align="center" style="background-color:#000;padding:10px 0px 20px 0px;"><a href="<?php echo $cmsHomeUrl;?>trackit/clickedmlink2/2/<?php echo $accessCode;?>"><img src="http://www.f1forreal.com.au/microsite/f1/img/edm_gr_tcs.png" width="116" height="19" style="width:116px;height:19px;" alt='TCS Logo'/></a></td>
                    </tr>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
