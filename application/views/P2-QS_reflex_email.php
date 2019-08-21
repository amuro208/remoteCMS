<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
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

        @media screen and (max-width: 600px) {
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
                margin: 0 auto !important;
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
                width: 100% !important;
            }

            /* UTILITY CLASSES FOR ADJUSTING PADDING ON MOBILE */
            td[class="padding"] {
                padding: 0px 2% !important;
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
        }
    </style>
</head>
<body style="margin: 0; padding: 0;">
<!-- ONE COLUMN SECTION -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 0px 0px 0px 0px;" class="section-padding">
            <table border="0" cellpadding="0" cellspacing="0" width="600" class="responsive-table">
                <tr>
                    <td bgcolor="#ffffff" align="center" style="padding:0px 0px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <!--Header-->
                            <tr>
                                <td bgcolor="#161f56">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="center" style="padding:40px;"><img
                                                        src="<?php echo $homeUrl; ?>/images/EDM/edm_top_logo_1.png"
                                                        width="142" height="52" border="0">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding: 0px 30px 0px 30px;"><img
                                                        src="<?php echo $homeUrl; ?>/images/EDM/mobile_top_copy_1.png"
                                                        width="356" height="20" border="0" class='img-max'>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!-- Copy -->
                            <tr>
                                <td bgcolor="#161f56">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td style="padding: 40px; font-size: 16px; line-height: 24px; font-family: Helvetica, Arial, sans-serif; color: #ffffff;"
                                                class="padding-copy">
                                                <p>Congatulations <?php echo $firstName; ?>, what a game!</p>
                                                <p>All your action at the Reflex Winc Wall has been captured in this
                                                    awesome video which you can now share with your mates for bragging
                                                    rights – or upload to Workplace.</p>
                                                <p>Don't forget to hashtag #reflexwall #teamwinc on your social
                                                    posts.</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <!--Content-->
                            <tr>
                                <td bgcolor="#161f56" style="padding-bottom:50px;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td style="text-align:center;" class="padding">
                                                <a href="<?php echo $cmsHomeUrl; ?>index.php/trackit/showcontent/<?php echo $accessCode; ?>"
                                                   target="_blank"><img
                                                            src="<?php echo $cmsHomeUrl; ?>uploads/<?php echo $fileName; ?>"
                                                            width="520" style="width:520px;" class='img-max'></a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <!-- BUTTON -->
                            <tr>
                                <td align="center">
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tr>
                                            <td background="<?php echo $homeUrl; ?>/images/EDM/edm_bg_1.png"
                                                bgcolor="#161f56" valign="top"
                                                style="padding:10px 40px 110px;text-align:center;background-color:#161f56;background: #161f56 url(<?php echo $homeUrl; ?>/images/EDM/edm_bg.png) no-repeat bottom right;background-size: 600px 220px;">
                                                <!--[if gte mso 9]>
                                                <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true"
                                                        stroke="false" style="mso-width-percent:1000;">
                                                    <v:fill type="tile"
                                                            src="http://cms-p2-ge.reflexwall.com.au/images/EDM/edm_bg.png"
                                                            color="#161f56" style="v-text-align:right;"/>
                                                    <v:textbox style="mso-fit-shape-to-text:true" inset="0,0,0,0">
                                                <![endif]-->
                                                <div>
                                                    <a href="<?php echo $cmsHomeUrl; ?>index.php/trackit/showcontent/<?php echo $accessCode; ?>"
                                                       target="_blank"><img
                                                                src="<?php echo $homeUrl; ?>/images/EDM/edm_btn_share_1.png"
                                                                width="302" height='84' class='img-max'
                                                                style="width:302px;height:84px;"></a>
                                                </div>
                                                <!--[if gte mso 9]>
                                                </v:textbox>
                                                </v:rect>
                                                <![endif]-->
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <!-- FOOTER -->
                            <tr>
                                <td align="center" style="background-color:#ffffff;padding:20px 0px 20px 0px;"><img
                                            src="<?php echo $homeUrl; ?>/images/EDM/edm_winc_bottom_logo_1.png" width="600"
                                            height="74" style="width:600px;height:74px;"/></td>
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
