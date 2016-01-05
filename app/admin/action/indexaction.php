<?php

/**
 * @version			$Id$
 * @create 			2012-4-8 8:30:17 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.admin.action.AdminAction');

/**
 * 管理主页的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class IndexAction extends AdminAction
{

    /**
     * 构造函数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 主页动作 
     * 
     * @desc
     * 
     * @access public
     */
    public function index()
    {
        $this->_assignModelManagerList();
        $this->_assignModelTypeList();
        $this->_assignLangList();
        
        $this->_render('index');
    }

    /**
     * 加载模块管理所有列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignModelManagerList()
    {
        $mManager    = HClass::quickLoadModel('ModelManager');

        HResponse::setAttribute('list', $mManager->getAllRows());
    }

    /**
     * 加载模块类型列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignModelTypeList()
    {
        if(!HResponse::getAttribute('list')) {
            return;
        }
        $category   = HClass::quickLoadModel('category');
        HResponse::setAttribute(
            'catModelList', 
            $category->getSubCategoryByIdentifier('model-category', false)
        );
    }

}

?>
