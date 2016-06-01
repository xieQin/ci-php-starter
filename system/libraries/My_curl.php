<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class CI_My_curl {

    /**
     * 封装curl的调用接口，get的请求方式
     */
    function doCurlGetRequest($url, $data = array(), $timeout = 5) {
        if ($url == "" || $timeout <= 0) {
            return false;
        }
        if ($data != array()) {
            $url = $url . '?' . http_build_query($data);
        }

        // 创建一个新cURL资源
        $con = curl_init((string) $url);

        $header = array(
            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
            'User-Agent:Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.104 Safari/537.36',
            'X-DevTools-Emulate-Network-Conditions-Client-Id:66970D96-2E02-475F-8159-0610D042C33B',
        );

        // 设置URL和相应的选项
//    curl_setopt($con, CURLOPT_HEADER, false);
        curl_setopt($con, CURLOPT_HTTPHEADER, $header);
        curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($con, CURLOPT_TIMEOUT, (int) $timeout);

        // 抓取URL并把它传递给浏览器
        $result = curl_exec($con);

        // 关闭cURL资源，并且释放系统资源
        curl_close($con);

        return ($result);
        //把 < 和 > 等转换为实体常用于防止浏览器将其用作 HTML 元素。当用户有权在您的页面上显示输入时，对于防止代码运行非常有用。
//    return htmlspecialchars($result);
    }

    /**
     * 封装curl的调用接口，post的请求方式
     */
    function doCurlPostRequest($url, $requestString, $timeout = 5) {
        if ($url == "" || $requestString == "" || $timeout <= 0) {
            return false;
        }

        // 创建一个新cURL资源
        $con = curl_init((string) $url);

        // 设置URL和相应的选项
        curl_setopt($con, CURLOPT_HEADER, false);
        curl_setopt($con, CURLOPT_POSTFIELDS, $requestString);
        curl_setopt($con, CURLOPT_POST, true);
        curl_setopt($con, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($con, CURLOPT_TIMEOUT, (int) $timeout);

        // 抓取URL并把它传递给浏览器
        $result = curl_exec($con);

        // 关闭cURL资源，并且释放系统资源
        curl_close($con);

        //把 < 和 > 等转换为实体常用于防止浏览器将其用作 HTML 元素。当用户有权在您的页面上显示输入时，对于防止代码运行非常有用。
        return htmlspecialchars($result);
    }

}
