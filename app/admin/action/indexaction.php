<?php

/**
 * @version			$Id$
 * @create 			2012-4-8 8:30:17 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.admin.action.AdminBaseAction');

/**
 * 管理主页的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class IndexAction extends AdminBaseAction
{

    /**
     * 主页动作 
     * 
     * @desc
     * 
     * @access public
     */
    public function index()
    {
        $mManager    = HClass::quickLoadModel('ModelManager');
        HResponse::setAttribute('list', $mManager->getOnDesktopModel());
        
        $this->_render('index');
    }

}

?>
