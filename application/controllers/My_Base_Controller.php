<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of My_Base_Controller
 *
 * @author wu
 */
class My_Base_Controller extends CI_Controller {
    //put your code here

    
    /**
     * 预处理参数，jsondecode(desdecode(urldecode($paraEncoded))
     * 检查必填参数（除os、token以外的参数）
     * @param type $para
     */
    protected function preDealPara($para, $arr = array()) {

//        $result = $this->my_des->decode(urldecode($para), MY_DES_KEY);
        //接口改用post调用
        $result = $this->my_des->decode($para, MY_DES_KEY);
        $resultArr = json_decode($result, true);
        $result = json_decode($result);
        
        for($i = 0; $i < count($arr); $i ++){
            if(false === isset($resultArr[$arr[$i]])){
                $this->my_response->responseFail(400, $this->config->item('my_error_code400'));
                die();
            }
        }
                
        return $result;
    }

}
