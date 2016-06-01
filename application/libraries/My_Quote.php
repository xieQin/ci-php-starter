<?php
/**
 *
 * @author xieq
 * @date    2016-03-08 10:48:39
 */

class My_Quote {

	protected $_ci;  //ci实例
	protected $url;  //api根地址
	protected $act;  //调用的接口名
	protected $deskey;  //加解密key
	protected $token;  //token
	protected $para;  //请求参数

	/**
	 * [__construct my_quote构造方法]
	 * @param [string] $api  [api名]
	 * @param [string] $act  [接口名]
	 * @param [array] $para [请求参数]
	 */
	function __construct()
	{
		$this->_ci = & get_instance();
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
}