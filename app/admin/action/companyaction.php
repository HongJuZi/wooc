<?php

/**
 * @version			$Id$
 * @create 			2014-03-23 23:03:14 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.companypopo, app.admin.action.AdminAction, model.companymodel');

/**
 * 公司信息的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class CompanyAction extends AdminAction
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
        $this->_popo        = new CompanyPopo();
        $this->_model       = new CompanyModel($this->_popo);
    }

    /**
     * 主页动作 
     * 
     * @access public
     */
    public function index()
    {
        $record     = $this->_model->getRecordByWhere('1 = 1');
        if(!$record) {
            HResponse::setAttribute('nextAction', 'add');
        } else {
            $this->_assignAuthorInfo($record['author']);
            HResponse::setAttribute('nextAction', 'edit');
        }
        HResponse::setAttribute('record', $record);
        HResponse::setAttribute('popo', $this->_popo);
        $this->_render('company/info');
    }

}

?>
