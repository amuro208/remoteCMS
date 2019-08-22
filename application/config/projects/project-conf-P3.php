<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//Project General
$config['home_url'] = "http://karrinyup.ampcapital-digitalforest.com.au/m/";
$config['cms_home_url'] = "http://karrinyup.ampcapital-digitalforest.com.au/";

$config['auto_approval'] = 'Y';
$config['manual_upload'] = 'N';
$config['make_remotethumbnail'] = 'Y';
$config['has_edm'] = 'Y';
$config['edm_ext'] = '.png';

//Event Specific

$config['VK_uploadmethod'] = 'ftp';
$config['VK_edm_media'] = "photoId";
$config['VK_email_title'] = "AMP Virtual Shootout!";
$config['VK_email_message'] = "";
$config['VK_email_template'] = "P3-VK_amp_email";

$config['WA_uploadmethod'] = 'post';
$config['WA_edm_media'] = "";
$config['WA_email_title'] = "Congratulations ##[FIRST_NAME]. You have caught the magic butterfly.";
$config['WA_email_message'] = "";
$config['WA_email_template'] = "P3-WA_amp_email";

$config['edmtrack_link1'] = "https://www.karrinyupcentre.com.au/";


//Email
$config['sender_name'] = "Karrinyup";
$config['sender_email'] = "no-reply@ampcapital-digitalforest.com.au";
$config['useragent'] = 'CodeIgniter';
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'smtp.gmail.com';
$config['smtp_user'] = 'no-reply@ampcapital-digitalforest.com.au';
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
