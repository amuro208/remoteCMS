<?php
require_once(APPPATH . '/controllers/test/base_tests.php');

class Upload_tests_4_ca extends Base_tests
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

  function test_fc(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userName"] = "TestName".$rand;
    $params["userEmail"] = "yhy0215@gmail.com";
    $params["userMobile"] = "0410399309";
    $params["userDateOfBirth"] = "15/02/1972";
    $params["eventCode"] = "FC";
    $params["videoId"] = "1438326940601";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userName"],
        "email"=>$params["userEmail"],
        "mobile"=>$params["userMobile"],
        "reserve1"=>$params["userDateOfBirth"],
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
}
