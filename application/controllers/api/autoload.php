<?php defined('BASEPATH') OR exit('No direct script access allowed');

date_default_timezone_set("Australia/Sydney");
ini_set("display_errors", "On");

require_once APPPATH . 'libraries/Serializer.php';
require_once APPPATH . 'libraries/JWT.php';

class Autoload{
  private static $isAutoLoadRegister = false;

  private $controller;

  function __construct($controller)
  {
    $this->controller = $controller;

    if(!Autoload::$isAutoLoadRegister){

      spl_autoload_register(function ($class) {

        if(strpos($class,"Doctrine") !== false) return;
        if(strpos($class,"CI_") !== false) return;
        if(strpos($class,"MY_") !== false) return;

        $file = APPPATH . 'models/Entities/' . $class . '.php';
        if (file_exists($file)){
          require $file;
        }

        $file = APPPATH . 'controllers/' . strtolower($class) . '.php';
        if (file_exists($file)){
          require $file;
        }

        $file = APPPATH . 'controllers/api/' . strtolower($class) . '.php';
        if (file_exists($file)){
          require $file;
        }

      });

      Autoload::$isAutoLoadRegister = true;
    }
  }

  function parseUser($sendError = true){
    try{
      $auth = $this->getHeaders("Authorization");

      if(strrpos($auth,"Bearer ") === false){
        if($sendError)
          header('HTTP/1.0 401 Unauthorized');
        echo 'Unauthorized';
        exit;
      }

      if($auth == null){
        if($sendError)
          header('HTTP/1.0 401 Unauthorized');
        echo 'Unauthorized';
        exit;
      }

      $token = substr($auth, strlen("Bearer "));
      $key = "example_key";

      return JWT::decode($token, $key);

    }catch (Exception $e) {
      $this->error($e);
      $this->response(NULL,500);
      throw $e;
    }

    return false;
  }

  public function getHeaders($header_name=null)
  {
    $headers = getallheaders();
    if(isset($headers[$header_name])){
      return $headers[$header_name];
    }
    return null;
  }
}
