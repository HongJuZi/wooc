<?php 

/**
 * @version			$Id$
 * @create 			2012-4-25 21:50:27 By xjiujiu
 * @description     HongJuZi Framework
 * @copyright 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.front.action.frontaction');

/**
 * CMS应用的Action基类部分
 * 
 * 提取CMS模块对应action的公用方法 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.cms.action
 * @since 			1.0.0
 */
class CmsAction extends FrontAction
{

    /**
     * 公用的赋值方法 
     * 
     * @desc
     * 
     * @access protected
     */
    protected function _commAssign()
    {
        parent::_commAssign();
        $this->_assignNavmenus();
    }

    /**
     * 得到导航栏链接 
     * 
     * @desc
     * 
     * @access protected
     */
    protected function _assignNavmenus()
    {
        $navmenu    = HClass::quickLoadModel('navmenu');
        HResponse::setAttribute('navmenuList', $navmenu->getAllRows());
    }

}

?>
