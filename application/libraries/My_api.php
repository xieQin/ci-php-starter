<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Api Class
 *
 * 掌金api调用库
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	xieq
 * @license
 * @link
 */
class My_api {

	protected $_ci;  //ci实例
	protected $url;  //api根地址
	protected $act;  //调用的接口名
	protected $deskey;  //加解密key
	protected $token;  //token
	protected $para;  //请求参数

	/**
	 * [__construct my_api构造方法]
	 * @param [string] $api  [api名]
	 * @param [string] $act  [接口名]
	 * @param [array] $para [请求参数]
	 */
	function __construct()
	{
		$this->_ci = & get_instance();
	}

	/**
	 * [post_des zj_php的post请求接口方法]
	 * @param [string] $api  [api名]
	 * @param [string] $act  [接口名]
	 * @param [array] $para [请求参数]
	 * @return [type]       [description]
	 */
	public function post_des($api, $act, $para) {
		//加载api根地址
		$url = $this->_ci->config->item('url', $api);
		//加载api加解密key
		$deskey = $this->_ci->config->item('deskey', $api);
		//加载api token
		$token = $this->_ci->config->item('token', $api);
		//生成h参数
		$header = $this->postHeader($token, $act, $deskey);
		//生成p参数
		$para = $this->postPara($para, $deskey);
		//组装参数
		// $url = $url . '?' . $header . $para;
		$para = $header . $para;
		//post请求
		$data = $this->_ci->my_curl->doCurlPostRequest($url, $para);

		$data = $this->_ci->security->xss_clean($data);

		return json_decode($this->_ci->my_des->decode($data, $deskey));
	}

	public function get_des($api, $act, $para) {
		//加载api根地址
		$url = $this->_ci->config->item('url', $api);
		//加载api加解密key
		$deskey = $this->_ci->config->item('deskey', $api);
		//加载api token
		$token = $this->_ci->config->item('token', $api);
		//生成参数
		$para = $this->getParaDes($para, $deskey, $token);
		//组装url
		$url = $url . '/' . $act . '?'. $para . '&apitoken=' . $token;
		//post请求
		$data = $this->_ci->my_curl->doCurlGetRequest($url, $para);

		$data = $this->_ci->security->xss_clean($data);

		return json_decode($this->_ci->my_des->decode($data, $deskey));
	}

	public function rt_quote_get($api, $act, $para) {
		$url = $this->_ci->config->item('url', $api);
		$deskey = $this->_ci->config->item('deskey', $api);
		$token = $this->_ci->config->item('token', $api);
		$para = $this->getParaDes($para, $deskey, $token);
		$url = $url . $act . '?' . $para;

		$data = $this->_ci->my_curl->doCurlGetRequest($url);

		$data = $this->_ci->security->xss_clean($data);

		return $this->_ci->my_des->decode($data, $deskey);
	}

	/**
	 * [simple_get description]
	 * @param  [string] $api  [api名]
	 * @param  [string] $act  [接口名]
	 * @param  [array] $para [请求参数]
	 * @return [type]       [description]
	 */
	public function simple_get($api, $act, $para) {
		//加载api根地址
		$url = $this->_ci->config->item('url', $api);
		//加载api加解密key
		$deskey = $this->_ci->config->item('deskey', $api);
		//生成参数
		$para = $this->simple_para($para, $deskey, $api);
		//组装url
		$url = $url . '/' . $act . '/' . $para;

		//get请求
		$data = $this->_ci->my_curl->doCurlGetRequest($url);

		$data = $this->_ci->security->xss_clean($data);

		return json_decode($this->_ci->my_des->decode(urldecode($data), $deskey));
	}

	/**
	 * [simple_post description]
	 * @param  [string] $api  [api名]
	 * @param  [string] $act  [接口名]
	 * @param  [array] $para [请求参数]
	 * @return [type]       [description]
	 */
	public function simple_post($api, $act, $para) {
		//加载api根地址
		$url = $this->_ci->config->item('url', $api);
		//加载api加解密key
		$deskey = $this->_ci->config->item('deskey', $api);
		//生成参数
		$para = 'p=' . $this->simple_para($para, $deskey, $api);
		//组装url
		$url = $url . $act;

		//get请求
		$data = $this->_ci->my_curl->doCurlPostRequest($url, $para);

		$data = $this->_ci->security->xss_clean($data);

		return json_decode($this->_ci->my_des->decode($data, $deskey));
	}

	/**
	 * [simple_para simple_get组装参数]
	 * @param  [array] $para [参数]
	 * @param  [string] $key  [加解密key]
	 * @param  [string] $api  [api名]
	 * @return [type]       [description]
	 */
	public function simple_para($para, $key, $api) {
		$para['os'] = $this->_ci->config->item('os', $api);;
		$para['token'] = time(). '&'. $this->_ci->config->item('token', $api);

		return urlencode($this->_ci->my_des->encode(json_encode($para), $key));
	}

	/**
	 * [postHeader post_des组装h参数]
	 * @param  [string] $token [token名]
	 * @param  [string] $act   [接口名]
	 * @param  [string] $key  [ 加解密key]
	 * @return [type]        [description]
	 */
	public function postHeader($token, $act, $key) {
		$header = array(
			'token' => $token,
			'act' => $act
		);
		return "h=" . $this->_ci->my_des->encode(json_encode($header), $key);
	}

	/**
	 * [postPara post_des组装p参数]
	 * @param  [array] $para [请求参数]
	 * @param  [string] $key  [加解密key]
	 * @return [type]       [description]
	 */
	public function postPara($para, $key) {
		if($para) {
            return "&p=" . $this->_ci->my_des->encode(json_encode($para), $key);
        }
        else {
            return '';
        }
	}

	/**
	 * [getParaDes get请求组装参数]
	 * @param  [array] $para [请求参数]
	 * @param  [string] $key  [加解密key]
	 * @param  [string] $token  [token]
	 * @return [string]         [加密后的get请求参数]
	 */
	public function getParaDes($para, $deskey, $token) {
		$p = '';
		foreach ($para as $key => $value) {
			$p .= $key . '=' . $this->_ci->my_des->encode($value, $deskey) . "&";
		}
		$p = $p . 'token=' . $this->_ci->my_des->encode(time() . '&' . $token, $deskey);
		return $p;
	}

}