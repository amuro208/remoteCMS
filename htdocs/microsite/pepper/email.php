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
          background-color: white;
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
              text-align: center;
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
              width: 80% !important; padding: 15px !important; border: 0 !important; font-size: 16px !important; } */ }
    </style>
  </head>
  <body style="margin: 0; padding: 0;">
    <!-- ONE COLUMN SECTION -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td bgcolor="#fff" align="center" style="padding: 0px 0px 0px 0px;" class="section-padding">
          <table border="0" cellpadding="0" cellspacing="0" width="600" class="responsive-table">
            <tr>
              <td bgcolor="#000">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <!--Header-->
                  <tr>
                    <td>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><img src="./img/edm_img_header.png" width="600" height="262" border="0" alt="F1 For Real Header" style="display: block; padding: 0; color: #666666; text-decoration: none; font-family: Helvetica, arial, sans-serif; font-size: 16px;" class="img-max">
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <!--Content-->
                  <tr>
                    <td>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td style="text-align:center;">
                            <a href="<?php echo $cmsHomeUrl;?>trackit/showcontent/<?php echo $accessCode;?>" target="_blank"><img src="http://www.pepperfanzone.com.au/framework/uploads/<?php echo $fileName;?>" style="width:100%"></a>
                            <!--
                            <img src="http://placehold.it/600x316/" style="width:100%"/> 
                            -->
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>

                  <!-- Copy -->
                  <tr>
                    <td>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td style="padding: 20px 40px 0 40px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #fff;" class="padding-copy">
                            <p>Dear <?php echo $firstName;?>,<p>

                            <p>Thank you for visiting the Pepper Ultimate FanZone!</p>
                            <p>We hope you enjoyed sharing your Wanderers story with us.</p>
                            <p>Don't forget to share your video or photos with your friends and family on social with the tag #WeAreWanderers. And look out for your story on the stadium big screen!</p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>

                  <!-- BUTTON -->
                  <tr>
                    <td align="center">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
                        <tr>
                          <td style="padding: 20px 0px 0px 0px;text-align:center;" class="padding-button">
                            <a href="<?php echo $cmsHomeUrl;?>trackit/showcontent/<?php echo $accessCode;?>" target="_blank" class="mobile-button" style="margin:0px 17px 0px 0px"><img src="./img/edm_btn_clickhere.png" class="img-max"></a>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>

                  <tr>
                    <td>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td style="padding: 20px 40px 0 40px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #fff;" class="padding-copy">
                            <p>Pepper is one of Australia's largest non-bank home loan lenders that can help you with your purchase or refinancing needs. Want to learn more? Check out our <a href="<?php echo $cmsHomeUrl;?>trackit/clickedmlink2/1/<?php echo $accessCode;?>">website</a> or call a Pepper lending specialist today on 13 73 77.</p>

                            <p>Go the Wanderers!<br/>
                               The Pepper Team</p>

                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>

                  <tr>
                    <td>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><img src="./img/edm_img_footer.png" width="600" height="200" border="0" alt="F1 For Real Header" style="display: block; padding: 0; color: #666666; text-decoration: none; font-family: Helvetica, arial, sans-serif; font-size: 16px;" class="img-max">
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>

                  <!-- FOOTER -->
                  <tr>
                    <td align="center" style="height:1px;padding:0px;margin:0px;"><img src="./img/edm_hr.png" class="img-ninty"></td>
                  </tr>

                  <tr>
                    <td align="left" class="padding-copy" style="padding:10px 40px 10px 40px; font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#ccc;">
                    <p>Pepper Group Limited ACN 094 317 665, Australian Credit Licence Number 286655, is the servicer of loans made by Pepper Finance Corporation Limited ACN 094 317 647. To unsubscribe or if you have received this e-mail in error, please contact <a href="mailto:wsw@pepper.com.au">wsw@pepper.com.au</a></p>
                    </td>
                    <tr>
                      <td align="center" style="background-color:#000;padding:10px 0px 20px 0px;"><a href="<?php echo $cmsHomeUrl;?>trackit/clickedmlink2/2/<?php echo $accessCode;?>"><img src="./img/edm_gr_tcs.png" width="116" height="19" style="width:116px;height:19px;" alt='TCS Logo'/></a></td>
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
