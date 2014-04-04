<?php

/**
 * @version			$Id$
 * @create 			2012-06-26 22:06:42 By xjiujiu
 * @package 	 	app.site
 * @subpackage 		action
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.cms.action.articleaction');

/**
 * 服务的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.cms.action
 * @version			$Id$
 */
class ServiceAction extends ArticleAction
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
        $this->_identifier          = 'service';
        $this->_popo->modelZhName   = '服务项目';
    }

    /**
     * {@inheritDoc}
     */
    protected function _list()
    {
        parent::_list($this->_getSubCategoryWhereByIdentifier($this->_identifier, true));
        
        $this->_render('service-list');
    }

}

?>
