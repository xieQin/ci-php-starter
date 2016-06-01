<?php

class Login_service extends CI_Service {

  const LOGIN_KEY = "_YWP_EURO_USERID";
  const WEIXIN_KEY = "_YWP_EURO_WEIXIN";

  function __construct () {
    parent::__construct();
    $this->load->driver('cache');
  }

  /**
   * [Login 获取用户信息]
   * @param [type] $openid [description]
   * @param [type] $phone  [description]
   */
  public function Login($openid = '', $phone = '') {
    $res = $this->my_api->simple_post(
      'eurocup',
      'addUserID',
      array(
        'openid' => $openid,
        'phone' => $phone
      )
    );
    $res = $this->my_api->simple_post(
      'eurocup',
      'queryUserID',
      array(
        'openid' => $openid,
        'phone' => $phone
      )
    );
    if(!empty($res) && !empty($res->d) && !empty($res->d->Data)) {
      set_cookie(self::LOGIN_KEY, $res->d->Data[0]->id, 3600*24*30);
      self::doLogin($res->d->Data[0]);
    }
    else {
      $key = get_cookie(self::LOGIN_KEY);
      set_cookie(self::LOGIN_KEY, -1);
      $loginuser = $this->cache->memcached->set('_ywp_login_user###' . $key, null);
    }
  }

  /**
   * [doLogin 保存用户信息]
   * @param  [type] $user [description]
   * @return [type]       [description]
   */
  public function doLogin($user) {
    $this->cache->memcached->set('_ywp_login_user###' . $user->id , $user, 3600*24*30);
  }

  /**
   * [GetUser 获取登录用户信息]
   * @param [type] $openid [description]
   */
  public function getUser () {
    $key = get_cookie(self::LOGIN_KEY);
    $loginuser = $this->cache->memcached->get('_ywp_login_user###' . $key);
    if($loginuser != null) {
      return $loginuser;
    }
    else {
      return false;
    }
  }

  /**
   * [refreshUser 刷新用户信息]
   * @return [type] [description]
   */
  public function refreshUser () {
    $user = self::getUser();
    self::Login($user->openid, $user->phone);
  }

  /**
   * [setShow 设置是否只在微信中打开]
   * @return boolean [description]
   */
  public function setShow ($tag) {
    set_cookie(self::WEIXIN_KEY, $tag, 3600*24*30);
  }

  /**
   * [isShow 获取是否只在微信中打开]
   * @return boolean [description]
   */
  public function isShow () {
    $tag = get_cookie(self::WEIXIN_KEY);
    return $tag == "0" ? true : false;
  }

}