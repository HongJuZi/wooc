<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.base.action.baseaction');

/**
 * 用户认证基础类
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.oauth.action
 * @since 1.0.0
 */
class OAuthAction extends BaseAction
{

    /**
     * 设置用户登陆信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  Array $userInfo 当前用户的信息
     */
    protected function _setUserLoginInfo($userInfo)
    {
        HSession::setAttributeByDomain($userInfo, 'user');
        HSession::setAttribute('time', (time() + 7200), 'user');
    }

    /**
     * 设置用户权限
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param int $parentId 用户所属的角色
     */
    protected function _setUserRights($parentId)
    {
        $actor      = HClass::quickLoadModel('actor');
        $actorInfo  = $actor->getRecordById($parentId);
        HSession::setAttribute('actor', $actorInfo['identifier'], 'user');
        HSession::setAttribute('actor_name', $actorInfo['name'], 'user');
        HSession::setAttribute('rights', $actorInfo['rights'], 'user');
    }

    /**
     * 得到会员角色信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $identifier 标识 默认为会员
     * @return Array 会员角色信息
     * @throws HVerifyException 验证异常
     */
    protected function _getActorByIdentifier($identifier = 'member')
    {
        $actor      = HClass::quickLoadModel('actor');
        $actorInfo  = $actor->getRecordByWhere('`identifier` = \'' . $identifier . '\'');
        if(!$actorInfo) {
            throw new HVerifyException('抱赚，网站还没有开放注册，请您耐心等待～');
        }

        return $actorInfo;
    }

}

?>
