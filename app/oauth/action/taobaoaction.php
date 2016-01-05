<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//加载第三方抽象父类
HClass::import('app.oauth.action.vendoraction');

/**
 * 腾讯微博认证接口
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.sdk.action
 * @since 1.0.0
 */
class TaobaoAction extends VendorAction
{

    /**
     * @var private static $_instance 唯一操作实例存储器
     */
    private static $_instance   = null;

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
        $this->_sdk  = null;
        $this->_cfg = $this->_getShareSetting($this->_identifier);
        $this->_callbackUrl     = urlencode(HResponse::url('taobao/login', '', 'oauth'));
    }

    /**
     * 得到腾讯同步唯一实例
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     * @return QQAction 腾讯操作实例
     */
    public static function getInstance()
    {
        if(null === self::$_instance) {
            self::$_instance    = new self();
        }

        return self::$_instance;
    }

    /**
     * 得到认证链接
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return String 得到认证URL
     */
    public function getAuthorizeURL()
    {
        return 'http://container.api.taobao.com/container?encode=utf-8&appkey=' . $this->_cfg['appid'];
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
        try {
            $topSession     = $this->_getAccessToken();
            exit;
            $token          = $this->_getOpenId($topSession);
        } catch(OAuthException $ex) {
            throw new HVerifyException('淘宝认证失败，请重新认证！');
        }
    }

    /**
     * 得到进入的口令
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _getAccessToken()
    {
        $params     = array();
        parse_str(file_get_contents($this->getAuthorizeURL()), $params);
        var_dump($params);
        
        return $params;
    }

    /**
     * 得到开放接口操作ID
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  String $token 令牌信息
     * @return String $openId 认证的开放接口ID
     * @throws HVerifyException 验证异常
     */
    private function _getOpenId($token)
    {
        $graph_url  = 'https://graph.qq.com/oauth2.0/me?access_token=' . $token['access_token'];
        $str        = file_get_contents($graph_url);
        if(false === strpos($str, 'callback')) {
            throw new HVerifyException('获取OPEN ID失败，请重新发起绑定腾讯账号～');
        }
        $response   = $this->_parseResponse($str);
        if(isset($response['error'])) {
            throw new HVerifyException('获取OPEN ID失败，请重新发起绑定腾讯账号～');
        }

        return $response['openid'];
    }

    /**
     * 添加用户的基础信息到网站
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  Array $qqUserData 微博用户数据
     * @param  int $uId 当前用户ID 
     */
    protected function _addUserToWebSite($qqUserData, $uId)
    {
        $user           = HClass::quickLoadModel('user');
        if(null !== $uId) {
            return $user->getRecordById($uId);
        }
        $actorInfo      = $this->_getActorByIdentifier('qq');
        $sex            = 3;
        $sexMap         = array('男' => 1, '女' => 2);
        if(isset($sexMap[$qqUserData['gender']])) {
            $sex        = $sexMap[$qqUserData['gender']];
        }
        $data           = array(
            'name' => $qqUserData['nickname'],
            'sex' => $sex,
            'truename' => $qqUserData['nickname'],
            'description' => $qqUserData['description'],
            'image_path' => json_encode(
                array(
                    '1' => $qqUserData['figureurl_qq_2'],
                    '2' => $qqUserData['figureurl_qq_1'],
                    '3' => $qqUserData['figureurl_qq_1']
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
     * @param  Array $qqUserData 当前微博数据
     * @throws HRequestException 请求异常
     */
    private function _addUserExtendInfo($uId, $qqUserData)
    {
        $data = array(
            'parent_id' => $uId,
            'edit_time' => $_SERVER['REQUEST_TIME']
        );
        $this->_addUserInfo($uId, $data);
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
            $this->_initSDK($token);
            if(false && isset($data['img'])) {
                $array_files	    = array();
                $array_files['pic'] = '@' . ROOT_DIR . $data['img'];
                $ret    = $this->_sdk->add_pic_t(array('content' => $data['content'], $array_files));
            } else {
                $ret    = $this->_sdk->add_t(array('content' => $data['content']));
            }
        } catch(Exception $ex) {
            throw new HVerifyException('腾讯微博同步失败，请重新绑定您的微博信息!' . $ex->getMessage());
        }
        if(0 !== $ret['errcode']) {
            throw new HVerifyException('腾讯微博同步失败，原因：' . $ret['msg']);
        }
    }

    /**
     * 解析返回值
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  String $response 需要解析的返回结果
     * @return Array 解析后的结果
     */
    private function _parseResponse($str)
    {
        $lpos   = strpos($str, '{');
        $rpos   = strrpos($str, '}');
        $str    = substr($str, $lpos, $rpos - $lpos + 1);

        return json_decode($str, true);
    }

    /**
     * 初始化SDK
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _initSDK($token)
    {
        require_once(ROOT_DIR . 'vendor/sdk/tx/qqConnectAPI.php');
        try {
            $this->_sdk     = new QC($token['token'], $token['openid'], $this->_cfg['appid']);
        } catch(Exception $ex) {
            throw new HVerifyException('腾讯账号绑定过期，请重新绑定一次！');
        }
    }

}


?>
