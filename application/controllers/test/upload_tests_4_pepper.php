<?php
require_once(APPPATH . '/controllers/test/base_tests.php');

class Upload_tests_4_pepper extends Base_tests
{
  private $url;
  private $utils;
  private $localuserdata;

  function __construct()
  {
    parent::__construct(__FILE__);
    $this->url = "http://localhost/codeigniter/index.php/upload/";
    $this->utils = new DoctrinAutoload(array("NoAuthCheck"=>"Y")); 
    $this->localuserdata = new LocalUserData(array("NoAuthCheck"=>"Y"));
  }

  function test_pp(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    //$params["userEmail"] = "andy.kelly@thecreativeshop.com.au";
    $params["eventCode"] = "PP";
    
    $fileData = __DIR__ . "/testfile/photo_sample.png";
    $params["FileData00"] = new CURLFile($fileData,"image/png","photo_sample.png");

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
      )
    );
    $pageParams = json_decode(json_encode($filter));
    $list = $this->localuserdata->getList($pageParams);
    if(count($list)==1){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    }

  }

  function test_pp_missing_field(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "";
    $params["eventCode"] = "PP";
    $params["photoId"] = "desert";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "photoid"=>$params["photoId"]
      )
    );
    $pageParams = json_decode(json_encode($filter));
    $list = $this->localuserdata->getList($pageParams);
    if(count($list)==0){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    }

  }

  function test_pp_wo_photo(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "PP";
    $params["photoId"] = "nothing";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "photoid"=>$params["photoId"]
      )
    );
    $pageParams = json_decode(json_encode($filter));
    $list = $this->localuserdata->getList($pageParams);
    if(count($list)==0){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    }

  }

  function test_vv(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    //$params["userEmail"] = "andy.kelly@thecreativeshop.com.au";
    $params["eventCode"] = "VV";
    $params["videoId"] = "sample";
    
    $fileData = __DIR__ . "/testfile/video_sample.png";
    $params["FileData00"] = new CURLFile($fileData,"image/png","video_sample.png");

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "videoId"=>$params["videoId"]
      )
    );
    $pageParams = json_decode(json_encode($filter));
    $list = $this->localuserdata->getList($pageParams);
    if(count($list)==1){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    }
  }

  function test_vv_missing_field(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "";
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "VV";
    $params["videoId"] = "1mb";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "videoId"=>$params["videoId"]
      )
    );
    $pageParams = json_decode(json_encode($filter));
    $list = $this->localuserdata->getList($pageParams);
    if(count($list)==0){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    }
  }

  function test_vv_wo_thumb(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "VV";
    $params["videoId"] = "2mb";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "videoId"=>$params["videoId"]
      )
    );
    $pageParams = json_decode(json_encode($filter));
    $list = $this->localuserdata->getList($pageParams);
    if(count($list)==0){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    }
  }

  function test_vv_wo_edm(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "VV";
    $params["videoId"] = "3mb";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "videoId"=>$params["videoId"]
      )
    );
    $pageParams = json_decode(json_encode($filter));
    $list = $this->localuserdata->getList($pageParams);
    if(count($list)==0){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    }
  }

  function test_vv_wo_video(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "VV";
    $params["videoId"] = "4mb";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "videoId"=>$params["videoId"]
      )
    );
    $pageParams = json_decode(json_encode($filter));
    $list = $this->localuserdata->getList($pageParams);
    if(count($list)==0){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    }
  }
}
