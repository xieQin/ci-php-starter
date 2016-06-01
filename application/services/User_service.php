<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_service extends CI_Service
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('news_model');
    }
    
    public function login()
    {
//        echo "Controller,User_service;Action,login";
        $this->news_model->test_Service();
    }
    
}