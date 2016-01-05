<?php

/**
 * @version			$Id$
 * @create 			2014-10-09 20:10:51 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.staticcfgpopo, app.admin.action.AdminAction, model.staticcfgmodel');

/**
 * 静态配置的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class StaticcfgAction extends AdminAction
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
        parent::__construct();
        $this->_popo        = new StaticcfgPopo();
        $this->_model       = new StaticcfgModel($this->_popo);
    }

}

?>
