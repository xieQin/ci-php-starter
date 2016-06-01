<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | Hooks
  | -------------------------------------------------------------------------
  | This file lets you define "hooks" to extend CI without hacking the core
  | files.  Please see the user guide for info:
  |
  |	http://codeigniter.com/user_guide/general/hooks.html
  |
 */

$hook['post_controller_constructor'] = function() {
    
//    echo "<br>"."----------".time()."-------------------"."<br>";
//    echo "hooks enabled!";
    $CI = & get_instance();
    
    
    //配置不检查hooks
    if(false === $CI->config->item('my_hooks_enabled')){
        return;
    }
    
    
    //过滤不需要加hooks的Controller和Action
    $my_hooks_ignore = $CI->config->item('my_hooks_ignore');
    $my_controller = $CI->uri->segment(1, 0);
    $my_action = $CI->uri->segment(1, 0)."/".$CI->uri->segment(2, 0);
//    echo $my_controller;echo $my_action;
    if(!(false === array_search($my_controller, $my_hooks_ignore)))    return;
    if(!(false === array_search($my_action, $my_hooks_ignore)))    return;
    
    
    //接口都要求用post请求，必须包含参数p
    $para = $CI->input->post("p");
    if(NULL === $para){//参数缺失
        
        $CI->my_response->responseFail(400, $CI->config->item('my_error_code400'));
        die();
    }else{//p参数传了
                
        try {
            $paraRaw = json_decode($CI->my_des->decode($para, MY_DES_KEY));
            
            if(false === isset($paraRaw->os)
                    || false === array_search($paraRaw->os, $CI->config->item('my_osPara'))){
                
                $CI->my_response->responseFail(399, $CI->config->item('my_error_code399'));
                die();
            }            
            
            $token = $paraRaw->token;
            $tokenArr = explode('&', $token);

            if (MY_DES_KEY != $tokenArr[1]) {
                $CI->my_response->responseFail(401, $CI->config->item('my_error_code401'));
                die();
            }
            if (time() - $tokenArr[0] > 180) {
                $CI->my_response->responseFail(401, $CI->config->item('my_error_code401'));
                die();
            }
        } catch (Exception $ex) {
            echo "para error!";
            die();
        }
    }
    
    
    
//    $para = $CI->uri->segment(3, 0);
////    print_r($para);
//    if (0 === $para) {
//        $CI->my_response->responseFail(400, $CI->config->item('my_error_code400'));
//        die();
//    } else {
//
//        try {
//            $paraRaw = json_decode($CI->my_des->decode(urldecode($para), MY_DES_KEY));
//            
//            if(false === isset($paraRaw->os)
//                    || false === array_search($paraRaw->os, $CI->config->item('my_osPara'))){
//                
//                $CI->my_response->responseFail(399, $CI->config->item('my_error_code399'));
//                die();
//            }            
//            
//            $token = $paraRaw->token;
//            $tokenArr = explode('&', $token);
//
//            if (MY_DES_KEY != $tokenArr[1]) {
//                $CI->my_response->responseFail(401, $CI->config->item('my_error_code401'));
//                die();
//            }
//            if (time() - $tokenArr[0] > 180) {
//                $CI->my_response->responseFail(401, $CI->config->item('my_error_code401'));
//                die();
//            }
//        } catch (Exception $ex) {
//            echo "para error!";
//            die();
//        }
//    }
};
