<?php

/**
 * @version			$Id$
 * @create 			2013-08-05 16:08:27 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.navmenupopo, app.admin.action.AdminAction, model.navmenumodel');

/**
 * 导航菜单的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class NavmenuAction extends AdminAction
{

    /**
     * 构造函数 
     * 
     * 初始化类变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_popo        = new NavmenuPopo();
        $this->_model       = new NavmenuModel($this->_popo);
    }

}

?>
