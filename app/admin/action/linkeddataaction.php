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
        parent::__construct();
        $this->_popo        = new LinkeddataPopo();
        $this->_model       = new LinkeddataModel($this->_popo);
    }

    /**
     * 异步添加
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aadd()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('rel_id'), '关联编号');
        HVerify::isEmpty(HRequest::getParameter('item_id'), '被关联编号');
        $this->_setRelItemModel();
        $record     = $this->_model->getRecordByWhere(
            '`rel_id` = ' . HRequest::getParameter('rel_id') 
            . ' AND `item_id` = ' . HRequest::getParameter('item_id') 
        );
        if($record) {
            throw new HVerifyException('此资料已经存在，请确认！');
        }
        HRequest::setParameter('author', HSession::getAttribute('id', 'user'));
        $linkId     = $this->_model->add(HPopoHelper::getAddFieldsAndValues($this->_popo));
        if(1 > $linkId) {
            throw new HRequestException('添加失败，请您稍后再试！');
        }
        HResponse::json(array('rs' => true, 'id' => $linkId));
    }

    /**
     * Ajax请求删除
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function adelete()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('id'), '编号');
        $this->_setRelItemModel();
        $ids    = array_filter(explode(',', HRequest::getParameter('id')));
        if(1 > $this->_model->deleteByWhere(HSqlHelper::whereIn('id', $ids)) ) {
            throw new HRequestException('删除失败，请您稍后再试！');
        }
        HResponse::json(array('rs' => true));
    }

    /**
     * 设置关联与被关联表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _setRelItemModel()
    {
        HVerify::isEmpty(HRequest::getParameter('rel_model'), '关联模块');
        HVerify::isEmpty(HRequest::getParameter('item_model'), '被关联模块');
        $this->_model->setRelItemModel(
            HRequest::getParameter('rel_model'), 
            HRequest::getParameter('item_model')
        );
    }

    /**
     * 异步编辑
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

    /**
     * 加载所有关联对象
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aload()
    {
        HVerify::isAjax();
        $this->_setRelItemModel();
        HVerify::isRecordId(HRequest::getParameter('rel_id'), '关联编号');
        $where  = '`rel_id` = \'' . HRequest::getParameter('rel_id') . '\'';
        HResponse::json(
            array('rs' => true, data => $this->_model->getAllRows($where))
        );
    }

}

?>
