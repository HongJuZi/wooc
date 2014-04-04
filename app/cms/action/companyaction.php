<?php

/**
 * @version			$Id$
 * @create 			2014-03-23 23:03:14 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.companypopo, app.cms.action.cmsaction, model.companymodel');

/**
 * 公司信息的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.cms.action
 * @since 			1.0.0
 */
class CompanyAction extends CmsAction
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
        $this->_popo    = new CompanyPopo();
        $this->_model   = new CompanyModel($this->_popo);
    }

    /**
     * {@inheritDoc}
     */
    public function index()
    {
        $record     = $this->_model->getRecordByWhere('1 = 1');
        $this->_assignProductList();
        $this->_commAssign();
        HResponse::setAttribute('record', $record);
        
        $this->_render('company');
    }

    /**
     *  加载产品列表
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignProductList()
    {
        HResponse::setAttribute(
            'catList', 
            HClass::quickLoadModel('category')->getSubCategoryByIdentifier('goods', false)
        );
    }

}

?>
