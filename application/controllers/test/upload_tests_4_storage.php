<?php
require_once(APPPATH . '/controllers/test/base_tests.php');

class Upload_tests_4_storage extends Base_tests
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

  function test_mvp(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userFirstName"] = "Luis";
    //$params["userLastName"] = "Youn";
    //$params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    //$params["userEmail"] = "andy.kelly@thecreativeshop.com.au";
    $params["userEmail"] = "yhy0215@gmail.com";
    $params["eventCode"] = "MVP";
    
    $params["test1"] = "MVP1";
    $params["test2"] = "MVP2";
    $params["test3"] = "MVP3";
    $params["test4"] = "MVP4";
    $params["test5"] = "MVP5";

    $rand = rand(1,12);
    $params["userSelectTeam"] = $rand;
    $prand = "".(rand(1,2));
    if(strlen($prand) == 1) $prand = "0".$prand;
    $params["userSelectPlayer"] = $rand.$prand;

    $fileData = __DIR__ . "/testfile/fileName0081.jpg";
    $params["FileData00"] = new CURLFile($fileData,"image/jpeg","fileName0081.jpg");

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    print_r($response);
    
    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "teamCode"=>$params["userSelectTeam"],
        "teamPlayerCode"=>$params["userSelectPlayer"]
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
  function test_mvp2(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //$params["userFirstName"] = "TestFirstName".$rand;
    //$params["userLastName"] = "TestLastName".$rand;
    $params["userFirstName"] = "Andy";
    $params["userLastName"] = "Kelly";
    //$params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["userEmail"] = "andy.kelly@thecreativeshop.com.au";
    //$params["userEmail"] = "yhy0215@gmail.com";
    $params["eventCode"] = "MVP";

    $rand = rand(1,12);
    $params["userSelectTeam"] = $rand;
    $prand = "".(rand(1,2));
    if(strlen($prand) == 1) $prand = "0".$prand;
    $params["userSelectPlayer"] = $rand.$prand;

    $fileData = __DIR__ . "/testfile/fileName0081.jpg";
    $params["FileData00"] = new CURLFile($fileData,"image/jpeg","fileName0081.jpg");

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "teamCode"=>$params["userSelectTeam"],
        "teamPlayerCode"=>$params["userSelectPlayer"]
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
  
  /*
  function test_mvp_port(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "MVP";

    $rand = rand(1,12);
    $params["userSelectTeam"] = $rand;
    $prand = "".(rand(1,2));
    if(strlen($prand) == 1) $prand = "0".$prand;
    $params["userSelectPlayer"] = $rand.$prand;

    $fileData = __DIR__ . "/testfile/Player_LGeitz_Port.png";
    $params["FileData00"] = new CURLFile($fileData,"image/png","Player_LGeitz_Port.png");

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "teamCode"=>$params["userSelectTeam"],
        "teamPlayerCode"=>$params["userSelectPlayer"]
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
  function test_mvp_missing_field(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "MVP";

    $rand = rand(1,12);
    $params["userSelectTeam"] = $rand;
    $rand = $rand.rand(1,16);
    $params["userSelectPlayer"] = $rand;

    $fileData = __DIR__ . "/testfile/Player_LGeitz.png";
    $params["FileData"] = new CURLFile($fileData,"image/png","Player_LGeitz.png");

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "teamCode"=>$params["userSelectTeam"],
        "teamPlayerCode"=>$params["userSelectPlayer"]
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

  function test_mvp_wo_filedata(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "MVP";

    $rand = rand(1,12);
    $params["userSelectTeam"] = $rand;
    $rand = $rand.rand(1,16);
    $params["userSelectPlayer"] = $rand;

    //$fileData = __DIR__ . "/testfile/Player_LGeitz.png";
    //$params["FileData"] = new CURLFile($fileData,"image/png","Player_LGeitz.png");

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "teamCode"=>$params["userSelectTeam"],
        "teamPlayerCode"=>$params["userSelectPlayer"]
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
