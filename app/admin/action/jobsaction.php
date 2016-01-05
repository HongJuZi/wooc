<?php

/**
 * @version			$Id$
 * @create 			2015-10-15 10:10:01 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.jobspopo, app.admin.action.AdminAction, model.jobsmodel');

/**
 * 工作内推的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class JobsAction extends AdminAction
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
        $this->_popo        = new JobsPopo();
        $this->_model       = new JobsModel($this->_popo);
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
        HResponse::registerFormatMap('status', 'name', JobsPopo::$statusMap);
    }

    /**
     * 添加视图
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    protected function _otherJobsAfterAddView()
    {
        parent::_otherJobsAfterAddView();
        HResponse::setAttribute('status_list', JobsPopo::$statusMap);
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
        HResponse::setAttribute('status_list', JobsPopo::$statusMap);
    }

    /**
     * 验证数据
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    protected function _verifyDataByPopoCfg()
    {
        $endTime    = strtotime(HRequest::getParameter('end_time'));
        HRequest::setParameter('end_time', $endTime);
        parent::_verifyDataByPopoCfg();
    }

}

?>
