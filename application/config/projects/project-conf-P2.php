<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Project General
$config['home_url'] = "http://cms-p2.reflexwall.com.au/m/";
$config['cms_home_url'] = "http://cms-p2.reflexwall.com.au/";

$config['auto_approval'] = 'Y';
$config['manual_upload'] = 'N';
$config['make_remotethumbnail'] = 'Y';
$config['has_edm'] = 'Y';
$config['edm_ext'] = '.png';

//Event Specific
$config['QS_uploadmethod'] = 'ftp';
$config['QS_edm_media'] = "photoId";
$config['QS_email_title'] = "Reflex Wall Reaction Wall!";
$config['QS_email_message'] = "";
$config['QS_email_template'] = "P2-QS_reflex_email";

$config['VK_uploadmethod'] = 'ftp';
$config['VK_edm_media'] = "videoId";
$config['VK_email_title'] = "Reflex Wall Virtual Shootout!";
$config['VK_email_message'] = "";
$config['VK_email_template'] = "P2-VK_reflex_email";

$config['PP_uploadmethod'] = 'post';
$config['PP_edm_media'] = "Filedata01";
$config['PP_email_title'] = "Reflex Wall Photo Event!";
$config['PP_email_message'] = "";
$config['PP_email_template'] = "P2-PP_reflex_email";

$config['WA_uploadmethod'] = 'post';
$config['WA_edm_media'] = "";
$config['WA_email_title'] = "Reflex Wall Servay";
$config['WA_email_message'] = "";
$config['WA_email_template'] = "P2-WA_reflex_email";

$config['PO_uploadmethod'] = 'post';
$config['PO_edm_media'] = "";
$config['PO_email_title'] = "Reflex Wall Voting!";
$config['PO_email_message'] = "";
$config['PO_email_template'] = "P2-PO_reflex_email";

//Email
$config['sender_name'] = "Reflexwall";
$config['sender_email'] = "noreply@griffith2018dome.com.au";
$config['useragent'] = 'CodeIgniter';
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com';
$config['smtp_user'] = 'noreply@griffith2018dome.com.au';
$config['smtp_pass'] = 'NewPassword1';
$config['smtp_port'] = 587;
$config['smtp_timeout'] = 60;
$config['wordwrap'] = TRUE;
$config['wrapchars'] = 76;
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['validate'] = FALSE;
$config['priority'] = 3;
$config['crlf'] = "\r\n";
$config['newline'] = "\r\n";
$config['bcc_batch_mode'] = FALSE;
$config['bcc_batch_size'] = 200;


//Columns
