<?php
require_once(APPPATH . '/controllers/test/base_tests.php');

class Upload_tests_4_afc extends Base_tests
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
/*
  function test_fp(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "FP";

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

  function test_fp_invalidemail(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "aaaa.aaaa@thecreativeshop.com.au";
    $params["eventCode"] = "FP";

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

  function test_fp_wrongemail(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "aaaa.aaaa@testtesttest.com.au";
    $params["eventCode"] = "FP";

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

  function test_fp_invalidformat(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "aaaa.aaaa_testtesttest.com.au";
    $params["eventCode"] = "FP";

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

  function test_fp_without_FileData(){
    
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "FP";

    //$fileData = __DIR__ . "/testfile/lighthouse.jpg";
    //$params["FileData"] = new CURLFile($fileData,"image/jpeg","lighthouse.jpg");

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
    if(count($list)==0){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    }

  }
  function test_ic(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "IC";
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

  function test_ic_without_videoId(){

    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "IC";
    //$params["videoId"] = "1mb";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        //"videoId"=>$params["videoId"]
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
*/

  function test_vk(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);
    $rand2 = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand.","."TestFirstName".$rand2;
    $params["userLastName"] = "TestLastName".$rand.","."TestLastName".$rand2;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    //$params["userEmail"] = "andy.kelly@thecreativeshop.com.au,andy.kelly@thecreativeshop.com.au";
	$params["userEmail"] = "luis.youn@thecreativeshop.com.au,yhy0215@gmail.com";
    $params["eventCode"] = "VK";
	$params["userCountryCode"] = "10,10";
	$params["userScore"] = "5,5";
    $params["photoId"] = "runner_user1_1436510876269,runner_user2_1436511481670";

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

  function test_vk_computer(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);
    $rand2 = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand.","."TestFirstName".$rand2;
    $params["userLastName"] = "TestLastName".$rand.","."TestLastName".$rand2;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    //$params["userEmail"] = "andy.kelly@thecreativeshop.com.au,andy.kelly@thecreativeshop.com.au";
	$params["userEmail"] = "luis.youn@thecreativeshop.com.au,test@test.com";
    $params["eventCode"] = "VK";
	$params["userCountryCode"] = "10,-1";
	$params["userScore"] = "5,5";
    $params["photoId"] = "runner_user1_1436510876269,runner_user2_1436511481670";

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

  function test_vk_computer2(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);
    $rand2 = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand.","."TestFirstName".$rand2;
    $params["userLastName"] = "TestLastName".$rand.","."TestLastName".$rand2;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    //$params["userEmail"] = "andy.kelly@thecreativeshop.com.au,andy.kelly@thecreativeshop.com.au";
	$params["userEmail"] = "test@test.com,luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "VK";
	$params["userCountryCode"] = "-1,10";
	$params["userScore"] = "5,5";
    $params["photoId"] = "runner_user1_1436510876269,runner_user2_1436511481670";

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
 
  function test_vk_1photo_2email(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);
    $rand2 = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand.","."TestFirstName".$rand2;
    $params["userLastName"] = "TestLastName".$rand.","."TestLastName".$rand2;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au,yhy0215@gmail.com";
    $params["eventCode"] = "VK";
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

  function test_vk_with_one_photoId(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "VK";
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
    if(count($list)==0){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    }
  }

  function test_vk_without_photoId(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "VK";
    //$params["photoId"] = "koala";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        //"photoId"=>$params["photoId"]
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
/*
  function test_ft(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);
    $rand2 = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand.","."TestFirstName".$rand2;
    $params["userLastName"] = "TestLastName".$rand.","."TestLastName".$rand2;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au,yhy0215@gmail.com";
    $params["eventCode"] = "FT";
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

  function test_ft_with_one_photoId(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "FT";
    $params["photoId"] = "lighthouse";

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
    if(count($list)==0){
      $this->_assert_true(true);
    }else{
      $this->_assert_true(false);
    }
  }    

  function test_ft_without_photoId(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "FT";
    //$params["photoId"] = "lighthouse";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        //"photoId"=>$params["photoId"]
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

  function test_tp(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "TP";
    $params["photoId"] = "lighthouse";

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

  function test_tp_without_photoId(){
    log_message("debug","==============START TEST================");

    $rand = rand(1000,9999);

    $params = array();
    //new CURLFile($configfile,"plain/text","project.config");
    $params["userFirstName"] = "TestFirstName".$rand;
    $params["userLastName"] = "TestLastName".$rand;
    //$params["userEmail"] = "testemail".$rand."@test.com.au";
    $params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "TP";
    //$params["photoId"] = "lighthouse";

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        //"photoId"=>$params["photoId"]
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
 */  
}
