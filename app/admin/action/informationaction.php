<?php

/**
 * @version			$Id$
 * @create 			2013-12-19 21:12:37 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.informationpopo, app.admin.action.AdminAction, model.informationmodel');

/**
 * 网站管理的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class InformationAction extends AdminAction
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
        $this->_popo        = new InformationPopo();
        $this->_model       = new InformationModel($this->_popo);
    }

    /**
     * 详细Page Hook
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    protected function _otherJobsAfterInfo()
    {
        parent::_otherJobsAfterInfo();
        HResponse::setAttribute('parent_id_list', $this->_assignLangList());
    }

}

?>
