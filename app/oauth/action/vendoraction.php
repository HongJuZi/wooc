<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

//导入认证应用基础类
HClass::import('app.oauth.action.oauthaction');

/**
 * 第三方认证父类
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.sdk.action
 * @since 1.0.0
 */
abstract class VendorAction extends OAuthAction
{

    /**
     * @var Array $_cfg 登录配置信息
     */
    protected $_cfg;

    /**
     * @var Object $_sdk 认证对象
     */
    protected $_sdk;

    /**
     * @var Object $_client 客户端对象
     */
    protected $_client;

    /**
     * @var protected $_callbackUrl 回跳的URL
     */
    protected $_callbackUrl;

    /**
     * 登陆回调处理
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    abstract public function login();

    /**
     * 添加用户的新浪同步信息
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $vId 类型，第三方的唯一标识
     * @param  String $identifier 标识，如：weibo
     * @param  Array $token 令牌信息
     * @param  Array $userData 用户数据
     * @throws HRequestException 请求异常
     */
    protected function _addUserSync($vId, $identifier, $token, $userData)
    {
        $syncInfo       = null;
        $typeMap        = array('weibo' => 1, 'qq' => 2);
        $type           = $typeMap[$identifier];
        $where          = '`vid` = \'' . $vId . '\'';
        if(HSession::getAttribute('id', 'user')) {
            $where      = '(`parent_id` = ' . HSession::getAttribute('id', 'user') . ' OR ' . $where . ')';
        }
        $sync       = HClass::quickLoadModel('sync');
        $syncInfo   = $sync->getRecordByWhere(
            '`type` = ' . $type . ' AND ' . $where
        );
        //检测用户是否已经绑定过
        $userInfo   = $syncInfo ? $this->_addUserToWebSite($userData, $syncInfo['parent_id']) : $this->_addUserToWebSite($userData, HSession::getAttribute('id', 'user'));
        $data   = array(
            'vid' => $vId,
            'identifier' => $identifier,
            'sync' => 1,
            'token' => json_encode($token),
            'author' => $userInfo['id'] 
        );
        if(!$syncInfo) {
            $data['type']           = $type;
            $data['parent_id']      = $userInfo['id'];
            if(1 > $sync->add($data)) {
                throw new HRequestException('添加您的同步信息失败！');
            }
            return $userInfo;
        }
        $data['id'] = $syncInfo['id'];
        if(1 > $sync->edit($data)) {
            throw new HRequestException('更新您的同步信息失败！');
        }

        return $userInfo;
    }

    /**
     * 添加用户的扩展信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  int $uId 用户ID
     * @param  Array $data 需要更新的数据
     * @throws HRequestException 请求异常
     */
    protected function _addUserInfo($uId, $data)
    {
        $userInfo   = HClass::quickLoadModel('userinfo');
        $extendInfo = $userInfo->getRecordByWhere('`parent_id` = ' . $uId);
        if($extendInfo) {
            foreach($data as $field => $item) {
                if($extendInfo[$field]) {
                    unset($data[$field]);
                    continue;
                }
                $extendInfo[$field]     = $item;
            }
            if(empty($data)) { return; }
            $data['id'] = $extendInfo['id'];
            if(1 > $userInfo->edit($data)) {
                throw new HRequestException('更新用户基础数据写入失败～');
            }
            HSession::setAttributeByDomain($extendInfo, 'userinfo');
            return;
        }
        HSession::setAttributeByDomain($data, 'userinfo');
        if(1 > $userInfo->add($data)) {
            throw new HRequestException('用户基础数据写入失败～');
        }
    }

    /**
     * 获取对应社交媒体分享的配置
     * 
     * @author licheng
     * @access private
     */
    protected function _getShareSetting($identifier)
    {
        $setting =  HClass::quickLoadModel('sharesetting')->getRecordByWhere(
            '`identifier` = \'' . $identifier . '\''
        );
        if(empty($setting)){
            throw new HVerifyException('请先添加该分享的配置信息！');
        }
        return $setting;
    }

}

?>
