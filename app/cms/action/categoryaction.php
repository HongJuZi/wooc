<?php

/**
 * @version			$Id$
 * @create 			2013-06-17 01:06:41 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.categorypopo, app.cms.action.CmsAction, model.categorymodel');

/**
 * 信息分类的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.site.action
 * @since 			1.0.0
 */
class CategoryAction extends CmsAction
{

    /**
     * 构造函数 
     * 
     * 初始化类里的变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_popo    = new CategoryPopo();
        $this->_model   = new CategoryModel($this->_popo);
    }

    /**
     * {@inheritDoc}
     */
    protected function _list()
    {
        parent::_list();
        
        $this->_render('category-list');
    }

    /**
     * {@inheritDoc}
     */
    protected function _detail()
    {
        parent::_detail();

        $this->_render('detail');
    }

}

?>
