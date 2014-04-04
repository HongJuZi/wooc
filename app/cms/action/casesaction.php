<?php

/**
 * @version			$Id$
 * @create 			2012-10-29 15:10:38 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.cms.action.articleaction');

/**
 * 案例展示的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.site.action
 * @since 			1.0.0
 */
class CasesAction extends ArticleAction
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
        $this->_identifier    = 'cases';
        $this->_popo->modelZhName   = '成功案例';
    }

    /**
     * {@inheritDoc}
     */
    protected function _list()
    {
        parent::_list($this->_getSubCategoryWhereByIdentifier($this->_identifier, true), 9);
        $this->_assignClasstypeList();
        $this->_assignKnowledgeList();
        
        $this->_render('cases-list');
    }

}

?>
