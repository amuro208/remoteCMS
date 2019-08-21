<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/autoload.php';

class Auth extends CI_Controller{

  //private static $isAutoLoadRegister = false;

  protected $em;

  function __construct($parameters=array())
  {
      parent::__construct($parameters);

      new Autoload($this);

      $this->load->helper('form'); //loading form helper
      $this->em = $this->doctrine->em;
  }

  public function signin(){

    $email    = $this->input->post("email");
    $password = $this->input->post("password");

    if($password != ""){
      $password = md5($password);
    }

    $account = $this->em->getRepository("Account")
                        ->findOneBy(array(
                            "valid"=>"Y",
                            "approval"=>"Y",
                            "email"=>$email,
                            "password"=>$password
                          ));



    if($account != null){

      if($account->getApproval() == "N"){
        header("HTTP/1.1 403 Forbidden");
        echo json_encode(array("error"=>"This account is waiting for approval to use.","code"=>"403"));
        return;
      }

      $key = "example_key";

      $aid = $account->getId();
      
      $token = array(
        "id"        => $account->getId(),
        "aid"       => $aid,
        "email"     => $account->getEmail(),
        "firstName" => $account->getFirstname(),
        "lastName"  => $account->getLastname(),
      );
log_message("debug",$account->getEmail());
log_message("debug",$account->getFirstname());
log_message("debug",$account->getLastname());
//log_message("debug",$token);

      $jwt = JWT::encode($token, $key);
	  log_message("debug",$jwt);
      $retrun = array(
        "token"=>$jwt,
        "authority"=>$this->getAuthority($account)
      );
 log_message("debug",json_encode($retrun));
      echo json_encode($retrun);

    }else{
      header("HTTP/1.1 404 Not Found");
      echo json_encode(array("error"=>"There is no account.","code"=>"404"));
    }

  }

  public function signup(){

    $firstName = $this->input->post("firstName");
    $lastName = $this->input->post("lastName");
    $email = $this->input->post("email");
    $password = $this->input->post("password");
    if($password != ""){
      $password = md5($password);
    }

    $account = new Account;

    $account->setFirstname($firstName);
    $account->setLastname($lastName);
    $account->setEmail($email);
    $account->setPassword($password);
    $account->setCreatedate(new DateTime("now"));

    $this->em->persist($account);
    $this->em->flush();

  }

  public function changePassword(){
    $email = $this->input->post("email");

    $account = $this->em->getRepository("Account")
                        ->findOneBy(array(
                            "valid"=>"Y",
                            "approval"=>"Y",
                            "email"=>$email
                          ));

    $password = $this->input->post("password");

    if($account != null){
      $encrypedPassword = md5($password);
      $account->setPassword($encrypedPassword);
      $account->setUpdatedate(new DateTime("now"));
      $account->setUpdateuser($account->getId());
      $this->em->persist($account);
      $this->em->flush();
    }
  }

  public function forgetPassword(){
    $email = $this->input->post("email");

    $account = $this->em->getRepository("Account")
                        ->findOneBy(array(
                            "valid"=>"Y",
                            "approval"=>"Y",
                            "email"=>$email
                          ));

    if($account != null){

      $sendemail = new SendEmail();
      $newPassword = $this->randomPassword();
      $data = array(
        "name"=>$account->getFirstname()." ".$account->getLastname(),
        "email"=>$email,
        "password"=>$newPassword
      );
      log_message("debug","###".json_encode($data));
      $sendemail->resetPassword($data);

      $encrypedPassword = md5($newPassword);
      $account->setPassword($encrypedPassword);
      $account->setUpdatedate(new DateTime("now"));
      $account->setUpdateuser($account->getId());
      $this->em->persist($account);
      $this->em->flush();
    }

  }

  function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
  }

  public function getAuthority($account){
    $data = array();
    $data["id"] = $account->getId();

    $menus = array();
    $accountRoles = $account->getAccountRoles();
	//log_message("debug","######### ".count($accountRoles->getValues()));
    if($accountRoles == null){
      return $data; 
    }
    foreach($accountRoles as $accountRole){
      if($accountRole->getValid() != 'Y') continue;

      $menuroles = $accountRole->getRoleid()->getMenuRoles();
      foreach($menuroles as $menurole){
        if($menurole->getValid() != 'Y') continue;

        $menu = $menurole->getMenuid();
        if($menu->getValid() == "Y"){
          $menudata = array();
          $menudata["url"] = $menu->getUrl();
          $menudata["accessable"] = $menurole->getAccessable();
          $menudata["readable"] = $menurole->getReadable();
          $menudata["writable"] = $menurole->getWritable();

          if(isset($menus[$menu->getUrl()])){
            $temp = $menus[$menu->getUrl()];
            $menudata["accessable"] = $menudata["accessable"] || $temp["accessable"];
            $menudata["readable"] = $menudata["readable"] || $temp["readable"];
            $menudata["writable"] = $menudata["writable"] || $temp["writable"];
          }

          $menus[$menu->getUrl()] = $menudata;
        }
      }
    }

    $data["menus"] = $menus;

    return $data;
  }

}
