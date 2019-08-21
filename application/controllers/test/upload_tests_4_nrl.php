<?php
require_once(APPPATH . '/controllers/test/base_tests.php');

class Upload_tests_4_nrl extends Base_tests
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

  function test_vk(){
    log_message("debug","==============START TEST================");

    $user_rand = rand(1000,9999);
    $score_rand = rand(0,3);
    $team_rand = rand(1,12);
    $postcode_rand = rand(2000,8000);
    $tnc_rand = rand(0,1);

    $params = array();
    $params["userFirstName"] = "TestFirstName".$user_rand;
    $params["userLastName"] = "TestLastName".$user_rand;
  	$params["userEmail"] = "luis.youn@thecreativeshop.com.au";
    $params["eventCode"] = "NRL";
  	$params["userSelectTeam"] = $team_rand;
  	$params["userPostcode"] = $postcode_rand;
  	$params["userScore"] = $score_rand;
  	$params["userAgreeTNC"] = $tnc_rand?'Y':'N';

    $response = $this->utils->sendData2ServerViaPost($this->url, $params);

    $filter = array(
      "filter"=>array(
        "firstName"=>$params["userFirstName"],
        "lastName"=>$params["userLastName"],
        "email"=>$params["userEmail"],
        "eventCode"=>$params["eventCode"],
        "teamCode"=>$params["userSelectTeam"],
        "zipCode"=>$params["userPostcode"],
        "reserve2"=>$params["userScore"],
        "reserve4"=>$params["userAgreeTNC"]
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
