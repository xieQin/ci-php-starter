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
    public function __construct() {
        parent::__construct();

        //sae上需要开启
        if ('SAE' == SERVER_PLAT) {
            session_start();
        }

        $this->load->driver('cache');
    }

    /**
     * 预处理参数，jsondecode(desdecode(urldecode($paraEncoded))
     * 检查必填参数（除os、token以外的参数）
     * @param type $para
     */
    protected function preDealPara($para, $arr = array()) {

//        $result = $this->my_des->decode(urldecode($para), MY_DES_KEY);
        //接口改用post调用
        $result = $this->my_des->decode($para, MY_DES_KEY);
        $result = urldecode($result);
        $resultArr = json_decode($result, true);
        $result = json_decode($result);

        for ($i = 0; $i < count($arr); $i ++) {
            if (false === isset($resultArr[$arr[$i]])) {
                $this->my_response->responseFail(400, $this->config->item('my_error_code400'));
                die();
            }
        }

        return $result;
    }

    protected function alertFailsMsgAndBack($msg = "操作失败") {

        header("Cache-control: no-store");
        $str = "<script type='text/javascript'>\n";
        $str .= "alert('【×】 {$msg}');\n";
        $str .= "location.href = '{$_SERVER['HTTP_REFERER']}';\n";
        $str .= "</script>";

        echo $str;
        exit;
    }

    function alertSuccessAndToPage($toPage = "", $msg = "操作成功") {
        header("Cache-control: no-store");
        $str = "<script type='text/javascript'>\n";
        $str .= "alert('【√】 {$msg}');\n";
        if (!$toPage) {
            $str .= "history.go(0);\n";
        } else {
            $str .= "location.href = '{$toPage}';\n";
        }

        $str .= "</script>";

        echo $str;
        exit;
    }

    function alertSuccessAndBack($msg = "操作成功") {
        header("Cache-control: no-store");
        $str = "<script type='text/javascript'>\n";
        $str .= "alert('{$msg}');\n";
        $str .= "location.href = '{$_SERVER['HTTP_REFERER']}';\n";
        $str .= "</script>";

        echo $str;
        exit;
    }

}
