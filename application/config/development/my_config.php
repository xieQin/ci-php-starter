<?php
defined('BASEPATH') OR exit('No direct script access allowed');


//--------------------以下内容正式发布时需根据实际环境进行配置
/**
 * 8位deskey（正式环境需要更换）
 */
define('MY_DES_KEY', 'abcdefgh');

/**
 * API配置
 */
//百倍相关配置
$config['100bei'] = array(
  'share_url' => 'http://weixin.100bei.com/weixin12/euroSign.do?', //分享地址
  'register_url' => 'http://www.baidu.com' //注册地址
);
//--------------------以下内容正式发布时不需要配置
/**
 * 返回结果是否加密，默认设置加密，供开发测试使用，或较少的非加密场景
 */
define('MY_ISDES', true);

/**
 * os参数，每个接口必须传
 */
$config['my_osPara'] = array("Web", "Android", "iPhone", "iWatch", "iPad", "wp", "PHP", "Java");


/**
 * 是否启用hooks，一般web需调整为false
 */
$config['my_hooks_enabled'] = false;

/**
 * 过滤不需要hooks的Controller或者Action
 *  Controller，例如：Z_test
 *  Action，例如：Z_test/testHooks
 */
$config['my_hooks_ignore'] = array("Z_test/testHooksIgnore");


/**
 * 错误码表
 */
//-------------------------------框架级错误码、错误消息（1-401）-------------------------------
$config['my_error_code398'] = "参数错误";
$config['my_error_code399'] = "os缺失或者不在规定范围";
$config['my_error_code400'] = "参数缺失";
$config['my_error_code401'] = "token错误";
//-------------------------------应用级错误码、错误消息（402-1000）-------------------------------

//-------------------------------应用级正确码、正确消息（1001-2000）-------------------------------
