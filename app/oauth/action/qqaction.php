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
class QQAction extends VendorAction
{

    //初始化APIMap
    /*
     * 加#表示非必须，无则不传入url(url中不会出现该参数)， 'key' => 'val' 表示key如果没有定义则使用默认值val
     * 规则 array( baseUrl, argListArr, method)
     */
    public static $APIMap = array(
        /*                       qzone                    */
        'add_blog' => array(
            'https://graph.qq.com/blog/add_one_blog',
            array('title', 'format' => 'json', 'content' => null),
            'POST'
        ),
        'add_topic' => array(
            'https://graph.qq.com/shuoshuo/add_topic',
            array('richtype','richval','con','#lbs_nm','#lbs_x','#lbs_y','format' => 'json', '#third_source'),
            'POST'
        ),
        'get_user_info' => array(
            'https://graph.qq.com/user/get_user_info',
            array('format' => 'json'),
            'GET'
        ),
        'add_one_blog' => array(
            'https://graph.qq.com/blog/add_one_blog',
            array('title', 'content', 'format' => 'json'),
            'GET'
        ),
        'add_album' => array(
            'https://graph.qq.com/photo/add_album',
            array('albumname', '#albumdesc', '#priv', 'format' => 'json'),
            'POST'
        ),
        'upload_pic' => array(
            'https://graph.qq.com/photo/upload_pic',
            array('picture', '#photodesc', '#title', '#albumid', '#mobile', '#x', '#y', '#needfeed', '#successnum', '#picnum', 'format' => 'json'),
            'POST'
        ),
        'list_album' => array(
            'https://graph.qq.com/photo/list_album',
            array('format' => 'json')
        ),
        'add_share' => array(
            'https://graph.qq.com/share/add_share',
            array('title', 'url', '#comment','#summary','#images','format' => 'json','#type','#playurl','#nswb','site','fromurl'),
            'POST'
        ),
        'check_page_fans' => array(
            'https://graph.qq.com/user/check_page_fans',
            array('page_id' => '314416946','format' => 'json')
        ),
        /*                    wblog                             */

        'add_t' => array(
            'https://graph.qq.com/t/add_t',
            array('format' => 'json', 'content','#clientip','#longitude','#compatibleflag'),
            'POST'
        ),
        'add_pic_t' => array(
            'https://graph.qq.com/t/add_pic_t',
            array('content', 'pic', 'format' => 'json', '#clientip', '#longitude', '#latitude', '#syncflag', '#compatiblefalg'),
            'POST'
        ),
        'del_t' => array(
            'https://graph.qq.com/t/del_t',
            array('id', 'format' => 'json'),
            'POST'
        ),
        'get_repost_list' => array(
            'https://graph.qq.com/t/get_repost_list',
            array('flag', 'rootid', 'pageflag', 'pagetime', 'reqnum', 'twitterid', 'format' => 'json')
        ),
        'get_info' => array(
            'https://graph.qq.com/user/get_info',
            array('format' => 'json')
        ),
        'get_other_info' => array(
            'https://graph.qq.com/user/get_other_info',
            array('format' => 'json', '#name', 'fopenid')
        ),
        'get_fanslist' => array(
            'https://graph.qq.com/relation/get_fanslist',
            array('format' => 'json', 'reqnum', 'startindex', '#mode', '#install', '#sex')
        ),
        'get_idollist' => array(
            'https://graph.qq.com/relation/get_idollist',
            array('format' => 'json', 'reqnum', 'startindex', '#mode', '#install')
        ),
        'add_idol' => array(
            'https://graph.qq.com/relation/add_idol',
            array('format' => 'json', '#name-1', '#fopenids-1'),
            'POST'
        ),
        'del_idol' => array(
            'https://graph.qq.com/relation/del_idol',
            array('format' => 'json', '#name-1', '#fopenid-1'),
            'POST'
        ),
        /*                           pay                          */
        'get_tenpay_addr' => array(
            'https://graph.qq.com/cft_info/get_tenpay_addr',
            array('ver' => 1,'limit' => 5,'offset' => 0,'format' => 'json')
        )
    );

    /**
     * @var private $_shareCfg 分享对象
     */
    private $_shareCfg;

    /**
     * @var private $_identifier 同步分享标志 qq
     */
    private $_identifier;

    /**
     * 构造函数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        $this->_sdk = null;
        $this->_identifier = 'qq';
        $this->_cfg = $this->_getShareSetting($this->_identifier);
        $this->_shareCfg        = null;
        $this->_callbackUrl     = urlencode(HResponse::url('qq/login', '', 'oauth'));
    }

    /**
     * 初始化应用配置
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _initCfg()
    {
        if('oauth' != HResponse::getAttribute('HONGJUZI_APP')) {
            HObject::loadAppCfg('oauth');
        }
        $this->_cfg = $this->_getShareSetting($this->_identifier);
    }

    /**
     * 得到认证链接
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $scope 权限范围
     * @return String 得到认证URL
     */
    public function getAuthorizeURL($scope = 'get_user_info,list_album,upload_pic,do_like,add_t,add_pic_t,get_info')
    {
        HSession::setAttribute('qq_state', md5(uniqid(rand(), TRUE)));
        return 'https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=' 
            . $this->_cfg['appid'] . '&redirect_uri=' . $this->_callbackUrl 
            . '&scope=' . $scope . '&state=' . HSession::getAttribute('qq_state');
    }
    
    /**
     * 回调处理
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function login()
    {
        if(empty($_GET['code'])) {
            HResponse::warn('请求过期，请重新绑定发起！', HResponse::url());
        }
        try {
            $token  = $this->_getAccessToken($_GET['code']);
            $openId = $this->_getOpenId($token);
        } catch(OAuthException $ex) {
            throw new HVerifyException('腾讯微博认证失败，请重新认证！');
        }
        $qqUserData     = $this->_api('get_user_info', $token['access_token'], $openId);
        if(!$qqUserData || 0 !== $qqUserData['ret']) {
            throw new HVerifyException('获取用户数据失败，请重新认证！');
        }
        //添加新的令牌
        $cfg        = array(
            'openid'    => $openId,
            'username'  => $qqUserData['nickname'],
            'key' => $this->_cfg['appid'],
            'secret'    => $this->_cfg['key'],
            'token'     => $token['access_token'],
            'server_name'=> $this->_cfg['content'],
            'all' => $qqUserData
        );
        $data       = array(
            'identifier' => 'qq-share',
            'name' => $cfg['username'],
            'token'     => $token['access_token'],
            'end_time' => intval($token['expires_in']) + intval($_SERVER['REQUEST_TIME']),
            'content' => json_encode($cfg, JSON_UNESCAPED_UNICODE),
        );
        $this->_shareCfg= HClass::quickLoadModel('shareCfg');
        $where          = '`token` = \'' . $data['token'] . '\' AND `identifier` = \'qq-share\'';
        $record         = $this->_shareCfg->getRecordByWhere($where); 
        if(!$record) {
            $this->_addTokenDataForNewUser($data);
            return;
        }
        if(!$record['parent_id']) {
            $this->_shareCfg->delete($record['id']);
            $this->_addTokenDataForNewUser($data);
            return;
        }
        if($record) {
            $this->_updateTokenData($data, $record);
            return;
        }
    }

    /**
     * 添加新的认证数据到系统中
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $data 认证数据
     */
    private function _addTokenDataForNewUser($data)
    {
        if(HSession::getAttribute('id', 'user')) {
            $data['parent_id']  = HSession::getAttribute('id', 'user');
            $data['status']     = 2;
        } else {
            $data['parent_id']  = '0';
            $data['status']     = 1;
        }
        $id     = $this->_shareCfg->add($data);
        if(1 > $id) {
            throw new HRequestException('添加认证信息失败！');
        }
        if($data['parent_id'] > 0) {
            HResponse::succeed(
                '信息通过验证，正在为您导航到完善个人信息页面。', 
                HResponse::url()
            );
            return;
        }

        HResponse::succeed(
            'Hi ' . $data['name'] . '，您的信息通过验证，正在为您导航到完善个人信息页面。', 
            HResponse::url('enter/signup', 'id=' . $id, 'cms')
        );
    }

    /**
     * 更新当前认证信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $data 信息
     * @param  $id 编号
     * @throws HRequestException
     */
    private function _updateTokenData($data, $record)
    {
        //更新据到表中
        if(1 > $this->_shareCfg->editByWhere($data, '`id` = ' . $record['id'])) {
            throw new HRequestException('腾讯微博登录更新失败,请稍后再试');
        }
        $user       = HClass::quickLoadModel('user');
        $userInfo   = $user->getRecordById($record['parent_id']);
        $this->_setUserLoginInfo($userInfo);
        $this->_setUserRights($userInfo['parent_id']);

        HResponse::succeed(
            'QQ认证成功，您可以同步分享信息到腾讯微博了！', 
            HResponse::url()
        );
    }

    /**
     * 前台登陆
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function signin()
    {
        if($_GET['state'] != HSession::getAttribute('qq_state') || !isset($_GET['code']) || empty($_GET['code'])) {
            HResponse::warn('请求过期，请重新绑定发起！', HResponse::url());
        }
        try {
            $token  = $this->_getAccessToken($_GET['code']);
            $openId = $this->_getOpenId($token);
        } catch(OAuthException $ex) {
            throw new HVerifyException('腾讯微博认证失败，请重新认证！');
        }
        $qqUserData     = $this->_api('get_user_info', $token['access_token'], $openId);
        if(!$qqUserData || 0 !== $qqUserData['ret']) {
            throw new HVerifyException('获取用户数据失败，请重新认证！');
        }
        //添加新的令牌
        $cfg        = array(
            'openid'    => $openId,
            'username'  => $qqUserData['nickname'],
            'key' => $this->_cfg['appid'],
            'secret'    => $this->_cfg['key'],
            'token'     => $token['access_token'],
            'server_name'=> $this->_cfg['content'],
            'all' => $qqUserData
        );
        HSession::setAttribute('name', $cfg['username'], 'user');

        HResponse::succeed(
            'Hi' . $cfg['username'] . '，您已经登陆成功，正在为您导航到首页～请稍等...',
            HResponse::url()
        );
    }

    /**
     * 调用腾讯信息接口 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @return Array 得到的结果集
     */
    private function _api($api, $token, $openId, $data = array())
    {
        if(!self::$APIMap[$api]) {
            throw new HVerifyException('当前不支持此API');
        }
        $cfg    = self::$APIMap[$api];
        $params = array(
            'access_token' => $token,
            'oauth_consumer_key' => $this->_cfg['appid'],
            'openid' => $openId
        );
        $method = isset($cfg[2]) ? $cfg[2] : 'GET';
        foreach($cfg[1] as $key => $val) {
            if(!is_int($key)) {
                $params[$key]   = $val;
                continue;
            }
            if(0 !== strpos($val, '#')) {
                if(!$data[$val]) {
                    throw new HVerifyException($val . '不能为空！');
                }
                $params[$val]   = $data[$val];
                continue;
            }
            $val    = substr($val, 1);
            if($data[$val]) {
                $params[$val]   = $data[$val];
            }
        }
        if('POST' === $method) {
            $response   = HRequest::post(self::$APIMap[$api][0], $params);
        } else {
            $response   = HRequest::getRequest(self::$APIMap[$api][0], $params);
        }

        return json_decode($response, true);
    }

    /**
     * 得到进入的口令
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param String $code 认证CODE
     */
    private function _getAccessToken($code)
    {
        $tokenUrl = 'https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&'
            . 'client_id=' . $this->_cfg['appid'] . '&redirect_uri=' . $this->_callbackUrl
            . '&client_secret=' . $this->_cfg['content'] . '&code=' . $code;
        $params     = array();
        parse_str(file_get_contents($tokenUrl), $params);
        if(isset($params['access_token'])) {
            return $params;
        }
        throw new HVerifyException('腾讯微博认证失败，请重新发起一次认证操作！');
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
    public function syncToWeibo($data, $cfg)
    {
        $this->_initCfg();
        if(isset($data['pic']) && file_exists(ROOT_DIR . $data['pic'])) {
            $data['pic']    = '@' . ROOT_DIR . $data['pic'];
            $rs     = $this->_api('add_pic_t', $cfg['token'], $cfg['openid'], $data);
        } else {
            $rs     = $this->_api('add_t', $cfg['token'], $cfg['openid'], $data);
        }
        if($rs['ret'] > 0) {
            throw new HRequestException($rs['msg']);
        }

        return $rs;
    }

    /**
     * 同步到说说
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $data 数据
     * @param  $cfg 配置
     * @return 结果
     */
    public function syncToTopic($data, $cfg)
    {
        $this->_initCfg();
        $data['con']            = $data['content'];
        if(isset($data['pic']) && file_exists(ROOT_DIR . $data['pic'])) {
            $data['richtype']   = 1;
            $size               = getimagesize(ROOT_DIR . $data['pic']);
            $data['richval']    = HResponse::url() . $data['pic'] . '&width=' . $size[0] . '&height=' . $size[1];
        } else {
            $data['richtype']   = 2;
            $data['richval']    = $data['url'];
        }
        $rs     = $this->_api('add_topic', $cfg['token'], $cfg['openid'], $data);
        if($rs['ret'] > 0) {
            throw new HRequestException($rs['msg']);
        }

        return $rs;
    }

    /**
     * 同步到日志
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param $data 数据
     * @param  $cfg 配置
     * @return 结果
     */
    public function syncToBlog($data, $cfg)
    {
        $this->_initCfg();
        $rs     = $this->_api('add_blog', $cfg['token'], $cfg['openid'], $data);
        if($rs['ret'] > 0) {
            throw new HRequestException($rs['msg']);
        }

        return $rs;
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
        require_once(ROOT_DIR . 'vendor/sdk/tx/API/qqConnectAPI.php');
        try {
            $this->_sdk     = new QC($token['token'], $token['openid'], $this->_cfg['appid']);
        } catch(Exception $ex) {
            throw new HVerifyException('腾讯账号绑定过期，请重新绑定一次！');
        }
    }

    /**
     * @var private static $_instance 实例
     */
    private static $_instance = null; 

    /**
     * 得到唯一实例
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public static
     */
    public static function getInstance()
    {
        if(null === self::$_instance) {
            self::$_instance    = new self();
        }

        return self::$_instance;
    }

}


?>
