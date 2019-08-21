<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['sender_name'] = "Reflexwall";
$config['sender_email'] = "no_reply@reflexwall.com.au";
$config['useragent'] = 'CodeIgniter';

$config['protocol'] = 'smtp';
$config['smtp_host'] = 'mail.reflexwall.com.au';
$config['smtp_user'] = 'no_reply@reflexwall.com.au';
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
