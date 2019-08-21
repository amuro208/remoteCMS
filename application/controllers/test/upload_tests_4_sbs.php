<?php
require_once(APPPATH . '/controllers/test/base_tests.php');

class Upload_tests_4_sbs extends Base_tests
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

  function test_lk(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userFirstName"] = "Andy";
    //$params["userLastName"] = "Kelly";
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "LK";
    $params["userAgreeTNC"] = "N";
    $params["userEDMTNC"] = "N";
    $params["choosenSong"] = "1";
    $params["videoId"] = "user_2015_9_10_15_40_27";
    
    $fileData = __DIR__ . "/testfile/fileName001.jpg";
    $params["FileData00"] = new CURLFile($fileData,"image/jpeg","fileName001.jpg");

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "reserve1"=>$params["choosenSong"],
        "reserve4"=>$params["userAgreeTNC"],
        "reserve5"=>$params["userEDMTNC"],
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
  
  /*
  function test_lk2(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //$params["userFirstName"] = "TestFirstName".$rand;
    //$params["userLastName"] = "TestLastName".$rand;
    $params["userFirstName"] = "Andy";
    $params["userLastName"] = "Kelly";
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    //$params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["userEmail"] = "andy.kelly@thecreativeshop.com.au";
    $params["eventCode"] = "LK";
    $params["choosenSong"] = "4";
    $params["videoId"] = "user_2015_7_31_18_12_03";
    
    $fileData = __DIR__ . "/testfile/fileName0092.jpg";
    $params["FileData00"] = new CURLFile($fileData,"image/jpeg","fileName0092.jpg");

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "reserve1"=>$params["choosenSong"],
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
  */

  function test_lk_missing_field(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "";
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "LK";
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

  function test_lk_wo_thumb(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "LK";
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

  function test_lk_wo_edm(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "LK";
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

  function test_lk_wo_video(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "LK";
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
