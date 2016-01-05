<?php

/**
 * @version			$Id$
 * @create 			2015-04-19 17:04:38 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.modelmanagerpopo, app.admin.action.AdminAction, model.modelmanagermodel');

/**
 * 模块管理的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class ModelmanagerAction extends AdminAction
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
        $this->_popo        = new ModelmanagerPopo();
        $this->_model       = new ModelmanagerModel($this->_popo);
    }

    /**
     * 列表后驱
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    protected function _otherJobsAfterList()
    {
        parent::_otherJobsAfterList();
        $this->_assignModelTypeMap();
        HResponse::registerFormatMap(
            'has_multi_lang',
            'name',
            ModelmanagerPopo::$hasMultiLangMap
        );
    }

    /**
     * 添加视图后驱
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    protected function _otherJobsAfterAddView()
    {
        parent::_otherJobsAfterAddView();
        $this->_assignModelTypeList();
        HResponse::setAttribute('has_multi_lang_list', ModelmanagerPopo::$hasMultiLangMap);
    }

    /**
     * 编辑视图后驱
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    protected function _otherJobsAfterEditView()
    {
        parent::_otherJobsAfterEditView();
        $this->_assignModelTypeList();
        HResponse::setAttribute('has_multi_lang_list', ModelmanagerPopo::$hasMultiLangMap);
    }

    /**
     * 加载模块类型映射
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignModelTypeMap()
    {
        $category   = HClass::quickLoadModel('category');
        HResponse::registerFormatMap(
            'type', 
            'name', 
            HArray::turnItemValueAsKey(
                $category->getSubCategoryByIdentifier('model-category', false), 'id'
            )
        );
    }

    /**
     * 加载模块类型列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignModelTypeList()
    {
        $category   = HClass::quickLoadModel('category');
        HResponse::setAttribute(
            'type_list', 
            $category->getSubCategoryByIdentifier('model-category', false)
        );
    }

}

?>
