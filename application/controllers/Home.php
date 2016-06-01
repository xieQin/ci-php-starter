<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 首页
 */
class Home extends CI_Controller {

  public function index () {
    $this->load->view('home/index');
  }

}