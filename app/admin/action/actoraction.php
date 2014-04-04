<?php

/**
 * @version			$Id$
 * @create 			2012-04-21 11:04:10 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入模块工具类
HClass::import('config.popo.actorpopo, app.admin.action.AdminAction, model.actormodel');

/**
 * 用户角色的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class ActorAction extends AdminAction
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
        $this->_popo        = new ActorPopo();
        $this->_model       = new ActorModel($this->_popo);
    }

    /**
     * {@inheritDoc}
     */
    public function addview()
    {
        $this->_addview();
        $this->_assignRightsList();

        $this->_render('actor/info');
    }

    /**
     * {@inheritDoc}
     */
    public function editview()
    {
        $this->_editview();
        $this->_assignRightsList();

        $this->_render('actor/info');
    }

    /**
     * {@inheritDoc}
     */
    protected function _assignRightsList()
    {
        $rights     = HClass::quickLoadModel('rights');
        HResponse::setAttribute('rightsList', $rights->getAllRows());
    }

    /**
     * {@inheritDoc}
     */
    public function edit()
    {
        $this->_edit();
        if(HRequest::getParameter('id') == HSession::getAttribute('parent_id', 'user')) {
            HSession::setAttribute('rights', HRequest::getParameter('rights'), 'user');
        }
        HResponse::succeed('更新成功！', $this->_getReferenceUrl(2));
    }

}

?>
