<?php

/**
 * @version			$Id$
 * @create 			2013-12-19 21:12:37 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.websitepopo, app.admin.action.AdminAction, model.websitemodel');

/**
 * 网站管理的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class WebsiteAction extends AdminAction
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
        $this->_popo        = new WebsitePopo();
        $this->_model       = new WebsiteModel($this->_popo);
    }
    
    /**
     * 编辑动作 
     * 
     * @desc
     * 
     * @access public
     */
    public function editview()
    {
        $this->_editview();
        $this->_assignLangTypeList();
        $this->_render('website/info');
    }

    /**
     * 添加模块视图 
     * 
     * @desc
     * 
     * @access public
     */
    public function addview()
    {  
        $this->_addview();
        $this->_assignLangTypeList();
        $this->_render('website/info');
    }
    
    /**
     * 加载语言类型列表
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignLangTypeList()
    {
        $langType   = HClass::quickLoadModel('langtype');
        HResponse::setAttribute('langtype_list', $langType->getAllRows());
    }

}

?>
