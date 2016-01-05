<?php

/**
 * @version			$Id$
 * @create 			2012-5-13 23:52:52 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.install.action.installaction');

/**
 * 安装程序应用主页控制层类 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.install.action
 * @since 			1.0.0
 */
class IndexAction extends InstallAction 
{

    /**
     * 安装程序主页 
     * 
     * @access public
     */
    public function index()
    {
        $this->_render('index');
    }

}

?>
