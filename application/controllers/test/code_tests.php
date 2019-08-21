<?php
require_once(APPPATH . '/controllers/test/base_tests.php');

class Code_tests extends Base_tests
{
  function __construct()
  {
    parent::__construct(__FILE__);
    $this->listurl = "/codedata/data/format/json";
  }
}
