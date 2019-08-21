<?php

require_once(APPPATH . '/libraries/RestClient.php');

class RestClient4Json extends RestClient{
  public function __construct($options=array()){
    parent::__construct($options);
  }

  public function postjson($url, $parameters=array(), $headers=array()){
      $data_string = json_encode($parameters);
      $headers["Content-Type"] = "application/json";
      $headers["Content-Length"]="" . strlen($data_string);
      return $this->execute($url, 'POST_JSON', $data_string, $headers);
  }

  public function putjson($url, $parameters=array(), $headers=array()){
      $data_string = json_encode($parameters);
      $headers["Content-Type"] = "application/json";
      $headers["Content-Length"]="" . strlen($data_string);
      return $this->execute($url, 'PUT_JSON', $data_string, $headers);
  }

  public function deletejson($url, $parameters=array(), $headers=array()){
      $data_string = json_encode($parameters);
      $headers["Content-Type"] = "application/json";
      $headers["Content-Length"]="" . strlen($data_string);
      return $this->execute($url, 'DELETE_JSON', $data_string, $headers);
  }

  public function execute($url, $method='GET', $parameters=array(), $headers=array()){
      $client = clone $this;
      $client->url = $url;
      $client->handle = curl_init();
      $curlopt = array(
          CURLOPT_HEADER => TRUE,
          CURLOPT_RETURNTRANSFER => TRUE,
          CURLOPT_USERAGENT => $client->options['user_agent']
      );

      if($client->options['username'] && $client->options['password'])
          $curlopt[CURLOPT_USERPWD] = sprintf("%s:%s",
              $client->options['username'], $client->options['password']);

      if(count($client->options['headers']) || count($headers)){
          $curlopt[CURLOPT_HTTPHEADER] = array();
          $headers = array_merge($client->options['headers'], $headers);
          foreach($headers as $key => $value){
              $curlopt[CURLOPT_HTTPHEADER][] = sprintf("%s:%s", $key, $value);
          }
      }

      if($client->options['format'])
          $client->url .= '.'.$client->options['format'];

      if(strtoupper($method) != 'POST_JSON' && strtoupper($method) != 'PUT_JSON' && strtoupper($method) != 'DELETE_JSON'){
        $parameters = array_merge($client->options['parameters'], $parameters);
      }

      if(strtoupper($method) == 'POST'){
          $curlopt[CURLOPT_POST] = TRUE;
          $curlopt[CURLOPT_POSTFIELDS] = $client->format_query($parameters);
      }
      elseif(strtoupper($method) == 'POST_JSON'){
          $curlopt[CURLOPT_POST] = TRUE;
          $curlopt[CURLOPT_POSTFIELDS] = $parameters;
      }
      elseif(strtoupper($method) == 'PUT_JSON'){
          $curlopt[CURLOPT_HEADER] = false;
          $curlopt[CURLOPT_CUSTOMREQUEST] = "PUT";
          $curlopt[CURLOPT_POSTFIELDS] = $parameters;
      }
      elseif(strtoupper($method) == 'DELETE_JSON'){
          $curlopt[CURLOPT_HEADER] = false;
          $curlopt[CURLOPT_CUSTOMREQUEST] = "DELETE";
          $curlopt[CURLOPT_POSTFIELDS] = $parameters;
      }
      elseif(strtoupper($method) != 'GET'){
          $curlopt[CURLOPT_CUSTOMREQUEST] = strtoupper($method);
          $curlopt[CURLOPT_POSTFIELDS] = $client->format_query($parameters);
      }
      elseif(count($parameters)){
          $client->url .= strpos($client->url, '?')? '&' : '?';
          $client->url .= $client->format_query($parameters);
      }

      if($client->options['base_url']){
          if($client->url[0] != '/' && substr($client->options['base_url'], -1) != '/')
              $client->url = '/' . $client->url;
          $client->url = $client->options['base_url'] . $client->url;
      }
      $curlopt[CURLOPT_URL] = $client->url;

      if($client->options['curl_options']){
          // array_merge would reset our numeric keys.
          foreach($client->options['curl_options'] as $key => $value){
              $curlopt[$key] = $value;
          }
      }

      curl_setopt_array($client->handle, $curlopt);

      $client->parse_response(curl_exec($client->handle));
      $client->info = (object) curl_getinfo($client->handle);
      $client->error = curl_error($client->handle);

      curl_close($client->handle);
      return $client;
  }
}
