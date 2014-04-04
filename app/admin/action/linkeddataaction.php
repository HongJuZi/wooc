<?php

/**
 * @version			$Id$
 * @create 			2013-11-04 22:11:51 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.linkeddatapopo, app.admin.action.AdminAction, model.linkeddatamodel');

/**
 * 关联数据的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class LinkeddataAction extends AdminAction
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
        $this->_popo        = new LinkeddataPopo();
        $this->_model       = new LinkeddataModel($this->_popo);
    }

    /**
     * Ajax请求删除
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function adelete()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('id'), '图片ID');
        $ids    = array_filter(explode(',', HRequest::getParameter('id')));
        if(1 > $this->_model->deleteByWhere(HSqlHelper::whereIn('id', $ids)) ) {
            throw new HRequestException('删除失败，请您稍后再试！');
        }
        HResponse::json(array('rs' => true));
    }

    /**
     * 异步编辑
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aedit()
    {
        HVerify::isAjax();
        HVerify::isNumber(HRequest::getParameter('id'), '图片ID');
        HVerify::isEmpty(HRequest::getParameter('name', '名称'));
        if(1 > $this->_model->edit(HPopoHelper::getUpdateFieldsAndValues($this->_popo))) {
            throw new HRequestException('服务器繁忙，修改失败，请稍后再试！');
        }
        HResponse::json(array('rs' => true));
    }

}

?>
