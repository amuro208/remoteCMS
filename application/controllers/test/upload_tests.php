<?php
require_once(APPPATH . '/controllers/test/base_tests.php');

class Upload_tests extends Base_tests
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
  
  function test_basic_info(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["eventCode"] = "FC";
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userCountryCode"] = "1";
    $params["userScore"] = "1";
    $params["matchCode"] = "1";
    $params["userSelectTeam"] = "1";
    $params["userSelectPlayer"] = "1";
    $params["userPhone"] = "0410399309";
    $params["userPostcode"] = "2121";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "reserve1"=>$params["userCountryCode"],
        "reserve2"=>$params["userScore"],
        "gameCode"=>$params["matchCode"],
        "teamCode"=>$params["userSelectTeam"],
        "teamPlayercode"=>$params["userSelectPlayer"],
        "phone"=>$params["userPhone"],
        "zipcode"=>$params["userPostcode"],
      )
    );

    $pageParams = json_decode(json_encode($filter));
    $list = $this->localuserdata->getList($pageParams);
    if(count($list)){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    }
  }    

  function test_basic_info_with_eventcode(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "QS";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"]
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

  function test_basic_info_with_sitecode(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["siteCode"] = "2";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "siteCode"=>$params["siteCode"]
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

  function test_basic_info_with_file_upload(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";

    $fileData = __DIR__ . "/testfile/lighthouse.jpg";
    $params["FileData"] = new CURLFile($fileData,"image/jpeg","lighthouse.jpg");

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"]
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

  function test_basic_info_with_multi_file_upload(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";

    $fileData = __DIR__ . "/testfile/lighthouse.jpg";
    $params["FileData"] = new CURLFile($fileData,"image/jpeg","lighthouse.jpg");
    $fileData = __DIR__ . "/testfile/desert.jpg";
    $params["FileData00"] = new CURLFile($fileData,"image/jpeg","desert.jpg");
    $fileData = __DIR__ . "/testfile/koala.jpg";
    $params["FileData01"] = new CURLFile($fileData,"image/jpeg","koala.jpg");
    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"]
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

  function test_basic_info_with_videoid(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "SR";
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
    if(count($list)==1){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    }
  }    

  function test_basic_info_with_photoid(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "PP";
    $params["photoId"] = "koala";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "photoId"=>$params["photoId"]
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

  function test_basic_info_with_multiphotoid(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "QS";
    $params["photoId"] = "lighthouse,desert";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "photoId"=>$params["photoId"]
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

  function test_basic_info_with_photoid_lateupload(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "MVP";
    $params["photoId"] = "jellyfish";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "photoId"=>$params["photoId"]
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
}
