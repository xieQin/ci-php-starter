<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Z_test
 *
 * @author ws
 */
include 'My_Base_Controller.php';

class Z_test extends My_Base_Controller {

    public function __construct() {
        parent::__construct();

        $this->load->model('Z_test_model');
        $this->load->service('user_service');
        $this->load->service('MailService');
        //        echo ENVIRONMENT;
        $this->load->driver('cache');
    }
    
    //test echoTest
    public function echoTest() {

        echo SERVER_PLAT;
    }

    //test database
    public function insert() {

        $this->Z_test_model->set_data();
    }

     //test Service layer
    public function testService() {
        $this->user_service->login();
    }

    //test memcache set
    public function memcacheSet() {
        $this->cache->memcached->set('foo', 'bar', 10);
        echo "success";
    }

    //test memcache get
    public function memcacheGet() {
        echo $this->cache->memcached->get('foo');
    }
    
     //test redis set
    public function redisSet() {
        $this->cache->redis->set('redisSet', 'redisValue', 10);
        echo "success";
    }
    
    
    //test redis get
    public function redisGet() {
        echo $this->cache->redis->get('redisSet');
    }
    

    //test My_Des encode
    public function encode() {
//        echo ENVIRONMENT;
       echo $this->my_des->encode("WhJSN0B9CTSAZAG84XfFIJMkzlf5CzPZ", "sycs84ju");
    }
    
    //test My_Des decode
    public function decode() {
//        echo ENVIRONMENT;
//       $re = $this->my_des->encode("WhJSN0B9CTSAZAG84XfFIJMkzlf5CzPZ", "sycs84ju");
//       echo $this->my_des->decode($re, "sycs84ju");
        
        $url = "gQd4yeeCs1Pm2QCPgLw2jCA8hzQhF5Z@@";
        $url = "W5@@9RPgXxm8x444kkSm2vOjUUL21ENHjBVn98T$\$TlIVRxzkPmc2SnA==";
        echo $this->my_des->decode($url, MY_DES_KEY);
    }
    
     //test echoErrorMsg
    public function echoErrorMsg() {

        echo $this->config->item('my_error_code400')."<br>";
        echo $this->config->item('my_error_code401');
    }
    
    //test echoResponse
    public function echoResponse() {

//        echo MY_DES_KEY;
//        $this->my_response->responseFail(400, 1212);
        
        $this->my_response->responseSuccess(array(1 => 121, 2 => 2313));
    }
    
    //test inPara
    public function inPara($para) {
        $para = $this->preDealPara($para);
        echo $para;
    }
    
    
    //test token
    public function testToken($para) {
       
        echo $para."<br>";
        $para = $this->preDealPara($para);
        print_r($para); echo "<br>";
        echo $para->token;echo "<br>";
       
        $this->my_response->responseSuccess("right token!");
    }
    
    
    //testHooks
    public function testHooks($para) {
       
        echo "testHooks"."<br>";
        $para = $this->preDealPara($para);
       
        print_r($para);
    }
    
    //testHooksIgnore
    public function testHooksIgnore($para) {
       
        echo "testHooks"."<br>";
        echo $para."<br>";
       
    }
    
    
    //testPost
    public function testPost() {
       
//        echo "testPost"."<br>";
        
        $para = $this->input->post("p");
        $para = $this->preDealPara($para);
       
        
//        print_r($para) ."<br>"; 
        $this->my_response->responseSuccess($para);
//       echo "<br>"."----------".time()."-------------------"."<br>";
    }
    
    
    //testView
    public function testView() {
        
        $this->load->view('z_test/test');
        
    }
    
    //testMail
    public function testMail() {
        
        $this->MailService->sendMail("1111");
        
    }
    
    
    
    /**
     * @ACT：接口名称、作用
     * @param :入参
     *  h:
     *      h1:含义，类型，是否必填
     *      h2:含义，类型，是否必填
     *  p:
     *      p1:含义，类型，是否必填
     *      p2:含义，类型，是否必填
     * @return : 出参   
     *  s:
     *  d：
     *      a1:含义
     *      a2:含义 
     *          a21:含义
     *          a22：含义         
     */
    public function testAnnotation($param) {
        
    }
}
