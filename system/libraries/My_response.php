<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class CI_My_response {

    /**
     * 返回错误操作
     * @param type $code 错误码
     * @param type $msg  错误信息
     * @param type $des  是否需要加密
     */
    public function responseFail($code , $msg) {
        $response = array();
        $response["s"] = $code;
        $response["d"] = $msg;
        echo $this->responseJson($response);
    }

    
    /**
     * 返回正确操作
     * 错误码默认是200
     * @param type $data
     * @param type $des
     */
    public function responseSuccess($data) {
        $response = array();
        $response["s"] = 200;
        $response["d"] = $data === null ? "" : $data;
        echo $this->responseJson($response);
    }

    private function responseJson($response) {
        //$des = false;
        $json = json_encode($response);
        if (!MY_ISDES) {
            echo $json;
        } else {
            $CI =& get_instance();
            echo $CI->my_des->encode($json, MY_DES_KEY);
        }
    }

}
