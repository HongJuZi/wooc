<?php

/**
 * @version			$Id$
 * @create 			2012-10-29 15:10:05 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.cms.action.articleaction');

/**
 * 产品展示的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.cms.action
 * @since 			1.0.0
 */
class ProductAction extends ArticleAction
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
        parent::__construct();
        $this->_identifier    = 'product';
        $this->_popo->modelZhName   = '产品展示';
    }

    /**
     * {@inheritDoc}
     */
    protected function _list()
    {
        parent::_list($this->_getSubCategoryWhereByIdentifier($this->_identifier), 9);
        
        $this->_render('product-list');
    }

    /**
     * 产品类型列表 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function type()
    {
        parent::_type(9);
        
        $this->_render('product-list');
    }
    
    /**
     * {@inheritDoc}
     */
    public function search()
    {
        parent::search();

        $this->_render('product-list');
    }

}

?>
