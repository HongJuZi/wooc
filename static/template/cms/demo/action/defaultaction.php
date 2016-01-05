<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.cms.action.cmsaction');
HClass::import('app.oauth.action.auseraction');

/**
 * 父动作类
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package theme.default.action
 * @since 1.0.0
 */
class DefaultAction extends CmsAction
{

    /**
     * 得到用户映射
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $list 条件列表
     * @return Map
     */
    protected function _getUserMap($list, $field = 'parent_id')
    {
        if(!$list) {
            return $list;
        }
        $user       = HClass::quickLoadModel('user');
        $userList   = $user->getAllRowsByFields(
            '`id`, `name`, `image_path`',
            HSqlHelper::whereInByListMap('id', $field, $list)
        );

        return HArray::turnItemValueAsKey($userList, 'id');
    }

    /**
     * 加载联系我们信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignContactInfo()
    {
        $contact    = HClass::quickLoadModel('contact');
        $phone      = $contact->getRecordByIdentifier('phone');
        $address    = $contact->getRecordByIdentifier('address');
        $email      = $contact->getRecordByIdentifier('email');
        $manager    = $contact->getRecordByIdentifier('manager');

        HResponse::setAttribute('phone', $phone);
        HResponse::setAttribute('address', $address);
        HResponse::setAttribute('manager', $manager);
        HResponse::setAttribute('email', $email);
    }

}
