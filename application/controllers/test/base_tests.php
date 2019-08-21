<?php
require_once(APPPATH . '/controllers/test/Toast.php');
require_once(APPPATH . '/libraries/RestClient4Json.php');
require_once(APPPATH . '/controllers/api/doctrinautoload.php');

class Base_tests extends Toast
{
  function __construct($file)
  {
    parent::__construct($file);
    // Load any models, libraries etc. you need here
    /*
    $this->api = new RestClient(array(
        'base_url' => TESTBASEURL ,
        'headers' => array('Authorization' => 'Bearer '.OAUTH_BEARER),
    ));
    $this->listurl = "/agencydata/data/format/json";
    */
  }

  /**
   * OPTIONAL; Anything in this function will be run before each test
   * Good for doing cleanup: resetting sessions, renewing objects, etc.
   */
  function _pre() {

  }

  /**
   * OPTIONAL; Anything in this function will be run after each test
   * I use it for setting $this->message = $this->My_model->getError();
   */
  function _post() {}

}
