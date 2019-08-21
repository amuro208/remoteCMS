<?php
require_once(APPPATH . '/controllers/test/base_tests.php');

class Upload_tests_4_netball extends Base_tests
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

    $fileData = __DIR__ . "/testfile/fileName0081.png";
    $params["FileData00"] = new CURLFile($fileData,"image/png","fileName0081.png");

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

  function test_qs(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userFirstName"] = "Luis";
    //$params["userLastName"] = "Youn";
    //$params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["userEmail"] = "yhy0215@gmail.com";
    //$params["userEmail"] = "andy.kelly@thecreativeshop.com.au";
    $params["eventCode"] = "QS";

    $rand = rand(1,99);
    $params["userScore"] = $rand;
    $rand = rand(1,12);
    $params["userCountryId"] = $rand;
    $params["photoId"] = "user_1438323064500";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "reserve2"=>$params["userScore"],
        "reserve3"=>$params["userCountryId"],
        "photoid"=>$params["photoId"]
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

  function test_qs_zeroscore(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "QS";

    $rand = rand(1,99);
    $params["userScore"] = "0";
    $rand = rand(1,12);
    $params["userCountryId"] = $rand;
    $params["photoId"] = "img_fb_cc";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "reserve2"=>$params["userScore"],
        "reserve3"=>$params["userCountryId"],
        "photoid"=>$params["photoId"]
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
  
  function test_qs_missing_field(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "";
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "QS";

    $rand = rand(1,99);
    $params["userScore"] = $rand;
    $rand = rand(1,12);
    $params["userCountryId"] = $rand;
    $params["photoId"] = "desert";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "reserve2"=>$params["userScore"],
        "reserve3"=>$params["userCountryId"],
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

  function test_qs_wo_photo(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "QS";

    $rand = rand(1,99);
    $params["userScore"] = $rand;
    $rand = rand(1,12);
    $params["userCountryId"] = $rand;
    $params["photoId"] = "nothing";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "reserve2"=>$params["userScore"],
        "reserve3"=>$params["userCountryId"],
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

  function test_pp(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userFirstName"] = "Luis";
    //$params["userLastName"] = "Youn";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    //$params["userEmail"] = "andy.kelly@thecreativeshop.com.au";
    $params["eventCode"] = "PP";
    $params["photoId"] = "luis_1438571811809";

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
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
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

  function test_sr(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userFirstName"] = "Luis";
    //$params["userLastName"] = "Youn";
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    //$params["userEmail"] = "andy.kelly@thecreativeshop.com.au";
    $params["eventCode"] = "SR";
    $params["choosenYear"] = "1";
    $params["videoId"] = "1438326940601";

    //$fileData = __DIR__ . "/testfile/img_fb_fc.png";
    //$params["FileData00"] = new CURLFile($fileData,"image/png","img_fb_fc.png");

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "reserve1"=>$params["choosenYear"],
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

  function test_sr2(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userFirstName"] = "Luis";
    //$params["userLastName"] = "Youn";
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    //$params["userEmail"] = "andy.kelly@thecreativeshop.com.au";
    $params["eventCode"] = "SR";
    $params["choosenYear"] = "2";
    $params["videoId"] = "1438326940601";

    //$fileData = __DIR__ . "/testfile/img_fb_fc.png";
    //$params["FileData00"] = new CURLFile($fileData,"image/png","img_fb_fc.png");

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "reserve1"=>$params["choosenYear"],
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
  function test_sr_missing_field(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "";
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

  function test_sr_wo_thumb(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "SR";
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

  function test_sr_wo_video(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    $params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["eventCode"] = "SR";
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
    //$params["userEmail"] = "andy.kelly@thecreativeshop.com.au";
    $params["eventCode"] = "LK";
    $params["choosenSong"] = "1";
    $params["videoId"] = "user_2015_7_31_18_12_03";
    
    $fileData = __DIR__ . "/testfile/fileName00102.jpg";
    $params["FileData00"] = new CURLFile($fileData,"image/jpeg","fileName00102.jpg");

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
    $params["videoId"] = "user_2015_7_31_18_10_12";
    
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
