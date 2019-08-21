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
          padding: 0px 0px !important;
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
  <body style="margin: 0; padding: 0;">
    <!-- ONE COLUMN SECTION -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
      <tr>
        <td bgcolor="#FFF" align="center" style="padding: 0px 0px 0px 0px;" class="section-padding">
          <table border="0" cellpadding="0" cellspacing="0" width="600" class="responsive-table">
            <tr>
              <td bgcolor="#FFF">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                
                  <!--Header-->
                  <tr>
                    <td>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><img src="http://youunlimited360cam.com/img/edm/header.png" width="600" height="200" border="0" alt="CA Header" style="display: block; padding: 0; color: #666666; text-decoration: none; font-family: Helvetica, arial, sans-serif; font-size: 16px;" class="img-max">
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <!--/Header-->
                  
                  <!--Content-->
                  <tr>
                    <td>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td<a href="<?php echo $cmsHomeUrl;?>trackit/showcontent/<?php echo $accessCode;?>/1"><img src="http://youunlimited360cam.com/framework/uploads/<?php echo $fileName;?>" width="100%" border='0' alt='CA Main Contents' style='display:block;'></a></td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <!--/Content-->
                  
                  <!-- Copy -->
                  <tr>
                    <td>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td style="padding: 20px 40px 0 40px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #000;" class="padding-copy">
                            <p>Dear <? echo $firstName; ?>,<p>
                            <?php /* ?>   
                            <p>Glad you could make it to Meet the Business Leader NSW 2016 brought to you by Chartered Accountants Australia and New Zealand. We hope you enjoyed your 360CAM experience.</p>
                            <?php */?>
                            <p>Glad you could make it to Meet the Business Leader NSW 2016 brought to you by Chartered Accountants Australia and New Zealand.</p>
                            <p>Don't forget to share your 360CAM video over the next couple of days and tag with #youunlimited for your chance to <b>WIN</b> one of <b>10 Westfield vouchers</b> valued at <b>$100</b> each. Winners will be selected at 3pm AEST Friday 13 May, so be sure to share by then.</p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <!-- /Copy -->
                  
                  <!-- BUTTON -->
                  <tr>
                    <td align="center">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
                        <tr>
                          <td style="padding: 10px 40px 20px 40px;" class="padding-button" align="center" >
                            <table border="0" cellspacing="0" cellpadding="0" class="responsive-table">
                              <tr>
                                <td align="center" style="padding:20px 0px">
                                  <a href="<?php echo $cmsHomeUrl;?>trackit/showcontent/<?php echo $accessCode;?>/1" target="_blank" class="mobile-button" style="margin:0px 0px 0px 0px"><img src="http://youunlimited360cam.com/img/edm/btn_clickhere.png" class="img-ninty"></a>
                                </td>
                              </tr> 
                              <tr>
                                <td align="center" style="padding:20px 0px 0px 0px">
                                  <img src="http://youunlimited360cam.com/img/edm/gr_calogo.png" class="img-ninty">
                                </td>
                              </tr>                               
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <!-- /BUTTON -->
                  
                  <!-- COPY2 -->
                  <tr>
                    <td>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td style="padding: 0px 40px 0 40px; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #000;" class="padding-copy">
                            <p>Visit <a href="<?php echo $cmsHomeUrl;?>trackit/clickedmlink2/1/<?php echo $accessCode;?>">youunlimitedanz.com</a> for career tips from top business leaders</p>
                            <p style="font-size:12px;">Terms and Conditions Apply.</p>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <!-- /COPY2 -->
                  
                  <!-- FOOTER -->
                  <tr>
                    <td align="center" class="padding-copy" style="background-color:rgb(238,53,36);padding:10px 40px 10px 40px; font-size: 12px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#ccc;">
                      © 2016 Chartered Accountants Australia and New Zealand. All rights reserved. ABN 50 084 642 571. This material is subject to our full terms and conditions, available at <a style="color:#ccc;" href="http://www.charteredaccountantsanz.com">www.charteredaccountantsanz.com</a>
                    </td>
                    <tr>
                      <td align="center" style="background-color:rgb(238,53,36);padding:10px 0px 20px 0px;"><a href="<?php echo $cmsHomeUrl;?>trackit/clickedmlink2/2/<?php echo $accessCode;?>"><img src="http://youunlimited360cam.com/img/edm/gr_poweredbytcs.png" width="116" height="19" style="width:116px;height:19px;" alt='TCS Logo'/></a></td>
                    </tr>
                  </tr>
                  <!-- /FOOTER -->
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>
