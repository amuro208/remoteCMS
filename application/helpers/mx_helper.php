<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

if (!function_exists('validate_email')) {
  function validate_email($email)
  {
    $mailparts = explode("@", $email);
    $hostname  = $mailparts[1];
    $b_server_found = 'N';

    // validate email address syntax
    $exp            = "/^[a-z\'0-9]+([._-][a-z\'0-9]+)*@([a-z0-9]+([._-][a-z0-9]+))+$/";
    $b_valid_syntax = preg_match($exp, $email);
    //if($b_valid_syntax === false || $b_valid_syntax == 0){
    //  return 'F';  
    //}
    
    // get mx addresses by getmxrr
    $b_mx_avail     = getmxrr($hostname, $mx_records, $mx_weight);
    if($b_mx_avail === false){
      return 'D';  
    }
    
    if ($b_valid_syntax && $b_mx_avail) {
      // copy mx records and weight into array $mxs
      $mxs = array();
      
      for ($i = 0; $i < count($mx_records); $i++) {
        $mxs[$mx_weight[$i]] = $mx_records[$i];
      } 

      // sort array mxs to get servers with highest prio
      ksort($mxs, SORT_NUMERIC);
      reset($mxs);
      
      while (list($mx_weight, $mx_host) = each($mxs)) {
        if ($b_server_found == 'N') {
          log_message("debug","MX - host : ".$mx_host);
          //try connection on port 25
          try{
            $fp = @fsockopen($mx_host, 25, $errno, $errstr, 2);
            if ($fp) {
              log_message("debug","connected to 25 port");
              $ms_resp = "";
              // say HELO to mailserver
              $ms_resp .= send_command($fp, "HELO microsoft.com");
              log_message("debug","sent message HELO microsoft.com");
              
              // initialize sending mail 
              $ms_resp .= send_command($fp, "MAIL FROM:<support@microsoft.com>");
              log_message("debug","sent message FROM");
              
              // try receipent address, will return 250 when ok..
              $rcpt_text = send_command($fp, "RCPT TO:<" . $email . ">");
              log_message("debug","sent message TO");

              $ms_resp .= $rcpt_text;
              
              if (substr($rcpt_text, 0, 3) == "250")
                $b_server_found = 'Y';
              
              // quit mail server connection
              $ms_resp .= send_command($fp, "QUIT");
              
              fclose($fp);
            }else{
              return 'E';
            }
          }catch(Exception $e){
            log_message("error",$e->getMessage());
            return 'E';
            continue;
          }
        }
      }
    }
    
    return $b_server_found;
  }
}

if (!function_exists('send_command')) {
  function send_command($fp, $out)
  {
    
    fwrite($fp, $out . "\r\n");
    return get_data($fp);
  }
}

if (!function_exists('get_data')) {
  function get_data($fp)
  {
    $s = "";
    stream_set_timeout($fp, 2);
    
    for ($i = 0; $i < 2; $i++)
      $s .= fgets($fp, 1024);
    
    return $s;
  }
}

// support windows platforms
if (!function_exists('getmxrr')) {
  function getmxrr($hostname, &$mxhosts, &$mxweight)
  {
    if (!is_array($mxhosts)) {
      $mxhosts = array();
    }
    
    if (!empty($hostname)) {
      $output = "";
      @exec("nslookup.exe -type=MX $hostname.", $output);
      $imx = -1;
      
      foreach ($output as $line) {
        $imx++;
        $parts = "";
        if (preg_match("/^$hostname\tMX preference = ([0-9]+), mail exchanger = (.*)$/", $line, $parts)) {
          $mxweight[$imx] = $parts[1];
          $mxhosts[$imx]  = $parts[2];
        }
      }
      return ($imx != -1);
    }
    return false;
  }
}

if (!function_exists('goo_gl_short_url')) {
  function goo_gl_short_url($longUrl){
      $GoogleApiKey = 'AIzaSyCuIF2AT3y-9GHAqvp0XxydpiwnuFGkkuc'; //thecreateiveshop.tcs@gmail.com/NewPassword1
      $postData = array('longUrl' => $longUrl,'key' => $GoogleApiKey);
      $jsonData = json_encode($postData);
      $curlObj = curl_init();
      curl_setopt($curlObj, CURLOPT_URL, 'https://www.googleapis.com/urlshortener/v1/url');
      curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
      //As the API is on https, set the value for CURLOPT_SSL_VERIFYPEER to false. This will stop cURL from verifying the SSL certificate.
      curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
      curl_setopt($curlObj, CURLOPT_HEADER, 0);
      curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
      curl_setopt($curlObj, CURLOPT_POST, 1);
      curl_setopt($curlObj, CURLOPT_POSTFIELDS, $jsonData);
      $response = curl_exec($curlObj);
      log_message("debug","-------------------SHORTEN------------------------");
      log_message("debug",$response);
      log_message("debug","-------------------SHORTEN------------------------");
      $json = json_decode($response);
      curl_close($curlObj);
      return $json->id;
  }
}

if (!function_exists('get_bitly_short_url')) {

  /* returns the shortened url */
  function get_bitly_short_url($url) {
    $login = "luisyoun";
    $appkey = "R_94d3c56f6c3342c7a8e0e5e4c2cf42d5";
    /*
    $login = "tcsit";
    $appkey = "R_27f9706a2d6d4d21a3115ba0f1b2b95c";
    */
    $format = "txt";
    $connectURL = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
    return curl_get_bitly_result($connectURL);
  }

  /* returns expanded url */
  function get_bitly_long_url($url) {
    $login = "luisyoun";
    $appkey = "R_94d3c56f6c3342c7a8e0e5e4c2cf42d5";
    /*
    $login = "tcsit";
    $appkey = "R_27f9706a2d6d4d21a3115ba0f1b2b95c";
    */
    $format = "txt";
    $connectURL = 'http://api.bit.ly/v3/expand?login='.$login.'&apiKey='.$appkey.'&shortUrl='.urlencode($url).'&format='.$format;
    return curl_get_bitly_result($connectURL);
  }

  /* returns a result form url */
  function curl_get_bitly_result($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
  }

}
