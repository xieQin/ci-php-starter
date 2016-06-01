<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->load->service('login_service');
    $loginuser = $this->login_service->getUser();
    if(!$loginuser) {
      echo '非法请求';
      exit;
    }
  }
}