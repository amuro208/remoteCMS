<?php
require_once(APPPATH . '/controllers/test/base_tests.php');

class Upload_tests_4_fancam extends Base_tests
{
  private $url;
  private $rfidscanurl;
  private $utils;
  private $localrfidscandata;
  private $localuserdata;

  function __construct()
  {
    parent::__construct(__FILE__);
    $this->url = "http://localhost/codeigniter/index.php/upload/";
    $this->rfidscanurl = "http://localhost/codeigniter/index.php/rfidread/";
    $this->rfidregisterurl = "http://localhost/codeigniter/index.php/rfidregister/";
    $this->utils = new DoctrinAutoload(array("NoAuthCheck"=>"Y")); 

    $this->localrfidscandata = new LocalRfidScanData(array("NoAuthCheck"=>"Y"));
    $this->localuserdata = new LocalUserData(array("NoAuthCheck"=>"Y"));
  }
  
  function test_scan_rfid(){
    $rand = rand(90000000,99999999);

    $params = array();
    $params["rfid"] = strtoupper(dechex($rand));

    $response = $this->utils->sendData2ServerViaPost($this->rfidscanurl, $params);
    if(!strpos($response,"success") > 0){
      $this->_assert_true(false);
    }
    
    $params["firstName"] = "TestFirstName";
    $params["lastName"] = "TestLastName";
    $params["BOD"] = "15/02/1972";
    $response = $this->utils->sendData2ServerViaPost($this->rfidregisterurl, $params);
    if(!strpos($response,"success") > 0){
      $this->_assert_true(false);
    }

    $filter = array(
      "filter"=>array(
        "rfid"=>$params["rfid"],
      )
    );

    $pageParams = json_decode(json_encode($filter));
    $list = $this->localrfidscandata->getList($pageParams);
    if(count($list)){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    }
  }    

  function test_fc(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["eventCode"] = "FC";
    $params["videoId"] = "1438326940601";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "videoId"=>$params["videoId"]
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

  function test_fc_link2(){
    $rand = rand(90000000,99999999);
    $params = array();
    $params["rfid"] = strtoupper(dechex($rand));

    $response = $this->utils->sendData2ServerViaPost($this->rfidscanurl, $params);
    if(!strpos($response,"success") > 0){
      $this->_assert_true(false);
    }

    $params["firstName"] = "TestFirstName";
    $params["lastName"] = "TestLastName";
    $params["BOD"] = "15/02/1972";
    $response = $this->utils->sendData2ServerViaPost($this->rfidregisterurl, $params);
    if(!strpos($response,"success") > 0){
      $this->_assert_true(false);
    }

    $rand = rand(90000000,99999999);
    $params = array();
    $params["rfid"] = strtoupper(dechex($rand));

    $response = $this->utils->sendData2ServerViaPost($this->rfidscanurl, $params);
    if(!strpos($response,"success") > 0){
      $this->_assert_true(false);
    }

    $params["firstName"] = "TestFirstName";
    $params["lastName"] = "TestLastName";
    $params["BOD"] = "15/02/1972";
    $response = $this->utils->sendData2ServerViaPost($this->rfidregisterurl, $params);
    if(!strpos($response,"success") > 0){
      $this->_assert_true(false);
    }


    $rand = rand(1000,9999);

    $params = array();
    $params["eventCode"] = "FC";
    $params["videoId"] = "1438326940602";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);
    if(!strpos($response,"success") > 0){
      $this->_assert_true(false);
    }

    $filter = array(
      "filter"=>array(
        "videoId"=>$params["videoId"]
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

  function test_fc_link3(){
    $rand = rand(90000000,99999999);
    $params = array();
    $params["rfid"] = strtoupper(dechex($rand));

    $response = $this->utils->sendData2ServerViaPost($this->rfidscanurl, $params);
    if(!strpos($response,"success") > 0){
      $this->_assert_true(false);
    }

    $params["firstName"] = "TestFirstName";
    $params["lastName"] = "TestLastName";
    $params["BOD"] = "15/02/1972";
    $response = $this->utils->sendData2ServerViaPost($this->rfidregisterurl, $params);
    if(!strpos($response,"success") > 0){
      $this->_assert_true(false);
    }

    $rand = rand(90000000,99999999);
    $params = array();
    $params["rfid"] = strtoupper(dechex($rand));

    $response = $this->utils->sendData2ServerViaPost($this->rfidscanurl, $params);
    if(!strpos($response,"success") > 0){
      $this->_assert_true(false);
    }

    $params["firstName"] = "TestFirstName";
    $params["lastName"] = "TestLastName";
    $params["BOD"] = "15/02/1972";
    $response = $this->utils->sendData2ServerViaPost($this->rfidregisterurl, $params);
    if(!strpos($response,"success") > 0){
      $this->_assert_true(false);
    }

    $rand = rand(90000000,99999999);
    $params = array();
    $params["rfid"] = strtoupper(dechex($rand));

    $response = $this->utils->sendData2ServerViaPost($this->rfidscanurl, $params);
    if(!strpos($response,"success") > 0){
      $this->_assert_true(false);
    }

    $params["firstName"] = "TestFirstName";
    $params["lastName"] = "TestLastName";
    $params["BOD"] = "15/02/1972";
    $response = $this->utils->sendData2ServerViaPost($this->rfidregisterurl, $params);
    if(!strpos($response,"success") > 0){
      $this->_assert_true(false);
    }

    $rand = rand(1000,9999);

    $params = array();
    $params["eventCode"] = "FC";
    $params["videoId"] = "1438326940603";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);
    if(!strpos($response,"success") > 0){
      $this->_assert_true(false);
    }

    $filter = array(
      "filter"=>array(
        "videoId"=>$params["videoId"]
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

  function test_fc_without_videoid(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["eventCode"] = "FC";
    //$params["videoId"] = "1438326940601";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);
    if(strpos($response,"error") > 0 && strpos($response,"missing MUST-field") > 0){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    };
  }

  function test_fc_without_eventcode(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //$params["eventCode"] = "FC";
    $params["videoId"] = "1438326940601";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);
    if(strpos($response,"error") > 0 && strpos($response,"eventCode") > 0){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    };
  }
}

