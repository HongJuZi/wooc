<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.oauth.action.vendoraction');
//引入WeiXin SDK
HClass::import('vendor.sdk.weixin.wechatcheckhelper');
HClass::import('vendor.sdk.weixin.wechatoauthhelper');
HClass::import('vendor.sdk.weixin.wechatuserhelper');

/**
 * 新浪微博认证接口
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.sdk.action
 * @since 1.0.0
 */
class WeixinAction extends VendorAction
{

    /**
     * @var private $_identifier 同步分享标志 weibo
     */
    private $_identifier;

    /**
     * @var private $_wechatCfg 微信配置
     */
    private $_wechatCfg;

    /**
     * @var private $_wxOAuthHelper 微信认证助手类
     */
    private $_wxOAuthHelper;

    /**
     * @var private $_wxUserHelper 微信用户工具类
     */
    private $_wxUserHelper;

    /**
     * @var private $_vendorToken 第三方令牌工具类
     */
    private $_vendorToken;

    /**
     * 构造函数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        $this->_wxUserHelper    = null;
        $this->_identifier      = 'weixin';
        $this->_wechatCfg       = HObject::GC('WECHAT');
        $this->_wxOAuthHelper   = new WechatOAuthHelper(
            $this->_wechatCfg['appid'],
            $this->_wechatCfg['secret']
        );
        $this->_vendorToken = HClass::quickLoadModel('vendortoken');
        $this->_callbackUrl = HResponse::url('weixin/login', '', 'oauth');
    }

    /**
     * @var private static $_token  TOKEN值，WeiXin配置
     */
    private static $_token  = 'hongjuzijsjwx20150932KDSDLK';

    /**
     * 进入微信登录入口
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function enter()
    {
        HResponse::redirect(
            $this->_wxOAuthHelper->getOAuthByUserInfo($this->_callbackUrl, self::$_token)
        );
    }

    /**
     * 回调处理
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function login()
    {
        if(!isset($_GET['code']) || empty($_GET['code'])) {
            throw new HVerifyException('验证失败，请重新登陆下～');
        }
        $token      = $this->_wxOAuthHelper->getToken($_GET['code']);
        $userInfo   = $this->_getUserInfo($token);
        $userInfo   = $this->_addUserToWebSite($userInfo, $token);
        $token      = $this->_addToken($token, $userInfo['id']);
        $this->_setUserLoginInfo($userInfo);
        $this->_setUserRights($userInfo['parent_id']);
        
        HResponse::redirect($this->_getNextUrl());
    }

    /**
     * 得到下一跳地址
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @return String
     */
    private function _getNextUrl()
    {
        if(HSession::getAttribute('refer_url')) {
            return HSession::getAttribute('refer_url');
        }

        return HResponse::url('', '', HObject::GC('DEF_APP'));
    }

    /**
     * 得到用户信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $token 令牌数组
     * @return Array
     */
    private function _getUserInfo($token)
    {
        $this->_wxUserHelper    = new WeChatUserHelper(
            $this->_wechatCfg['appid'],
            $this->_wechatCfg['secret']
        );

        return $this->_wxUserHelper->getUserInfo($token['access_token']);
    }

    /**
     * 微信URL认证
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function valid()
    {
        if(!HRequest::getParameter('echostr')) {
            throw new HVerifyException('参数错误！');
        }
        $wechatCheckHelper  = new WechatCheckHelper(self::$_token);
        $wechatCheckHelper->valid();
    }

    /**
     * 添加认证令牌
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $token 令牌
     */
    protected function _addToken($token, $uId)
    {
        $record         = $this->_vendorToken->getRecordByWhere(
            '`name` = \'' . $token['access_token'] . '\''
            . ' AND `vendor` = \'' . $this->_identifier . '\''
        );
        $data           = array(
            'name'  => $token['access_token'],
            'vendor' => $this->_identifier,
            'end_time' => $token['expires_in'] + time(),
            'parent_id' => $uId,
            'content' => json_encode($token, JSON_UNESCAPED_UNICODE),
            'author' => $uId
        );
        if(!$record) {
            if(1 > $this->_vendorToken->add($data)) {
                throw new HVerifyException('用户数据添加失败，请稍后再试！');
            }
            return;
        }
        if($record['end_time'] < time()) {
            $token  = $this->_wxOAuthHelper->refreshToken($token['access_token']);
            $data           = array(
                'name'  => $token['access_token'],
                'vendor' => $this->_identifier,
                'end_time' => $token['expires_in'] + time(),
                'parent_id' => $uId,
                'content' => json_encode($token, JSON_UNESCAPED_UNICODE),
                'author' => $uId
            );
        }
        if(1 > $this->_vendorToken->editByWhere($data, '`id` = ' . $record['id'])) {
            throw new HRequestException('更新微信认证信息失败，请稍后再试！');
        }
    }

    /**
     * @var private $_linkedData 关联对象
     */
    private $_linkedData;

    /**
     * 添加用户的基础信息到网站
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  Array $weiboUserData 微博用户数据
     * @param  int $uId 当前用户ID 
     */
    protected function _addUserToWebSite($json)
    {
        $data           = array(
            'name' => $json['nickname'],
            'sex' => $json['sex'],
            'u_from' => $this->_identifier,
            'image_path' => $json['headimgurl'],
            'province' => $json['province'],
            'city' => $json['city'],
            'description' => $json['country'] . '-' . $json['province'] . '-' . $json['city'],
            'login_time' => $_SERVER['REQUEST_TIME']
        );
        $this->_linkedData     = HClass::quickLoadModel('linkeddata');
        $this->_linkedData->setRelItemModel('user', 'openid');
        $info           = $linkedData->getRecordByWhere('`item_id` = \'' . $json['openid'] . '\'');
        if($info['rel_id'] > 0) {
            $user           = HClass::quickLoadModel('user');
            $record         = $user->getRecordById($info['rel_id']);
        }
        if($record) {
            if(1 > $user->editByWhere($data, '`id` = ' . $record['id'])) {
                throw new HRequestException('修改更新用户信息失败，请稍后再试！');
            }
            $this->_updateUserOpenIdLinkedData($json, $record['id'], $info['id']);
            return $user->getRecordById($record['id']);
        }
        $actorInfo          = $this->_getActorByIdentifier('member');
        $data['parent_id']  = $actorInfo['id'];
        $data['id']         = $user->add($data);
        if(1 > $data['id']) {
            throw new HRequestException('用户数据写入失败～，请稍后再试！');
        }
        $this->_updateUserOpenIdLinkedData($json, $data['id']);

        return $data;
    }

    /**
     * 更新用户OPENID关联数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $json 关联数据
     * @param  $uid 用户编号
     */
    private function _updateUserOpenIdLinkedData($json, $uid, $id = null)
    {
        $data               = array(
            'item_id' => $json['openid'],
            'rel_id' => $uid,
            'extend' => json_encode($json, JSON_UNESCAPED_UNICODE),
            'author' => $uid
        );
        if(!$id) {
            $this->_linkedData->add($data);
            return;
        }
        $this->_linkedData->editByWhere($data, '`id` = ' . $id);
    }

}


?>
