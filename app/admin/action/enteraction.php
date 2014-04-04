<?php

/**
 * @version			$Id$
 * @create 			2012-4-8 8:48:15 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

/**
 * 管理主页的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class EnterAction extends HAction
{

    /**
     * 进入初始动作 
     * 
     * @desc
     * 
     * @access public
     */
    public function index()
    {
        $this->_render('login');
    }

}

?>
