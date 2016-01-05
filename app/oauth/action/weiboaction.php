<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.oauth.action.vendoraction');
//引入WeiBo SDK
HClass::import('vendor.sdk.weibo.saetv2..ex..class');

/**
 * 新浪微博认证接口
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.sdk.action
 * @since 1.0.0
 */
class WeiboAction extends VendorAction
{

    /**
     * @var private static $_instance 唯一实例存储器
     */
    private static $_instance   = null;

    /**
     * @var private $_identifier 同步分享标志 weibo
     */
    private $_identifier;

    /**
     * 构造函数
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        $this->_client  = null;
        $this->_identifier = 'weibo';
        $this->_cfg = $this->_getShareSetting($this->_identifier);
        $this->_callbackUrl     = HResponse::url('weibo/login', '', 'oauth');
        $this->_initAuthorize();
    }

    
    /**
     * 得到新浪微博同步唯一实例
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @return Weibo 操作对象
     */
    public static function getInstance()
    {
        if(null === self::$_instance) {
            self::$_instance     = new self(); 
        }

        return self::$_instance;
    }

    /**
     * 初始化认证对象
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return Object 认证对象
     */
    protected function _initAuthorize()
    {
        $this->_sdk   = new SaeTOAuthV2($this->_cfg['appid'] , $this->_cfg['key']);
    }

    /**
     * 初始化端操作对象
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _initClient($token)
    {
        $this->_client  = new SaeTClientV2(
            $this->_cfg['appid'], $this->_cfg['key'], $token
        );
    }

    /**
     * 认证主页
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function getAuthorizeURL()
    {
        return $this->_sdk->getAuthorizeURL($this->_callbackUrl);
    }

    /**
     * 回调处理
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function login()
    {
        if(!isset($_GET['code']) || empty($_GET['code'])) {
            HResponse::redirect(HResponse::url());
            exit;
        }
        try {
            $token      = $this->_getAccessToken($_GET['code']);
            $this->_initClient($token['access_token']);
        } catch(OAuthException $ex) {
            throw new HVerifyException($ex->getMessage() . '新浪微博认证失败，请重新认证！');
        }
        $weiboUserData  = $this->_client->show_user_by_id($token['uid']);
        if(empty($weiboUserData) || $weiboUserData['error_code'] > 0) {
            throw new HVerifyException('新浪微博认证失败，请重新认证！原因：' . $weiboUserData['error']);
        }
        $cfg        = array(
            'key'       => $this->_cfg['appid'],
            'secret'    => $this->_cfg['key'],
            'token'     => $token['access_token'],
            'expires_in'=> intval($token['expires_in']) + intval($_SERVER['REQUEST_TIME'])
        );
        HSession::setAttribute('access_token', $token['access_token'], 'token');
        //添加微博用户信息到表中
        $syncsModel     = HClass::quickLoadModel('syncs');
        $record         = $syncsModel->getRecordByWhere('`vid` = ' . $weiboUserData['id']);
        if(empty($record)) {
            $data       = array(
                'vid' => $weiboUserData['id'],
                'username' => $weiboUserData['name'],
                'type'  => 1,
                'expires_in' => intval($token['expires_in']) + intval($_SERVER['REQUEST_TIME']),
                'token' => $token['access_token'],
                'cfg'   => json_encode($cfg),
                'author' => $weiboUserData['id'],
            );
            if(1 > $syncsModel->add($data)) {
                throw new HRequestException('登录失败，请稍后再试');
            }    
        }else{
            $data       = array(
                'id' => $record['id'],
                'username' => $weiboUserData['name'],
                'expires_in' => intval($token['expires_in']) + intval($_SERVER['REQUEST_TIME']),
                'token' => $token['access_token'],
                'cfg'   => json_encode($cfg)
            );
            if(1 > $syncsModel->edit($data)) {
                throw new HRequestException('登录失败，请稍后再试');
            }
        }
        
        HResponse::redirect(HResponse::url('syncs/wbsync', '' ,'admin'));
    }

    /**
     * 添加用户的基础信息到网站
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  Array $weiboUserData 微博用户数据
     * @param  int $uId 当前用户ID 
     */
    protected function _addUserToWebSite($weiboUserData, $uId)
    {
        $user           = HClass::quickLoadModel('user');
        if(null !== $uId) {
            return $user->getRecordById($uId);
        }
        $actorInfo      = $this->_getActorByIdentifier('weibo');
        $data           = array(
            'name' => $weiboUserData['screen_name'],
            'truename' => $weiboUserData['name'],
            'description' => $weiboUserData['description'],
            'image_path' => json_encode(
                array(
                    '1' => $weiboUserData['avatar_hd'],
                    '2' => $weiboUserData['profile_image_url'],
                    '3' => $weiboUserData['profile_image_url']
                )
            ),
            'parent_id' => $actorInfo['id']
        );
        $data['id']         = $user->add($data);
        if(1 > $data['id']) {
            throw new HRequestException('用户数据写入失败～');
        }

        return $data;
    }

    /**
     * 添加用户基础数据
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  Array $user 用户操作对象
     * @param  int $uId 用户ID
     * @param  Array $weiboUserData 当前微博数据
     * @throws HRequestException 请求异常
     */
    private function _addUserExtendInfo($uId, $weiboUserData)
    {
        $data = array(
            'parent_id' => $uId,
            'city' => $weiboUserData['id'],
            'province' => $weiboUserData['province'],
            'location' => $weiboUserData['location'],
            'url' => $weiboUserData['url'],
            'edit_time' => $_SERVER['REQUEST_TIME']
        );

        $this->_addUserInfo($uId, $data);
    }

    /**
     * 得到访问令牌信息
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  Array $code 相关参数信息
     * @return Array 认证信息
     */
    protected function _getAccessToken($code)
    {
        return $this->_sdk->getAccessToken(
            'code', 
            array('code' => $code, 'redirect_uri' => $this->_callbackUrl)
        );
    }

    /**
     * 同步到微博 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  Array $data 需要同步的内容
     *  --格式：
     *  --array(
     *      'content' => '',    //内容
     *      'img' => ''         //图片
     *  )
     *  @param String JSON格式的令牌信息
     */
    public function sync($data, $token)
    {
        try {
            $this->_initClient($token['token']);
            if (isset($data['img']) && !empty($data['img'])) {
                return $this->_client->upload($data['content'], HResponse::url() . $data['img']);
            }
            return $this->_client->update($data['content']);
        } catch(Exception $e) {
            throw new HVerifyException('新浪微博同步失败，请重新绑定您的微博信息');
        }
    }

}


?>
