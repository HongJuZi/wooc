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
        parent::__construct();
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
        $this->_assignHasRightsList();
        $this->_assignRightsList();

        $this->_render('actor/info');
    }

    /**
     * 加载已经有的权限列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignHasRightsList()
    {
        $linkedData     = HClass::quickLoadModel('linkeddata');
        $linkedData->setRelItemModel('actor', 'rights');
        $record         = HResponse::getAttribute('record');
        HResponse::setAttribute(
            'hasRightsMap', 
            HArray::turnItemValueAsKey(
                $linkedData->getAllRows('`rel_id` = ' . $record['id']), 'item_id'
            )
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function _assignRightsList()
    {
        $rights     = HClass::quickLoadModel('rights');

        HResponse::setAttribute(
            'topRightsList', 
            $rights->getAllRows('`parent_id` IS NULL OR `parent_id` < 1')
        );
        HResponse::setAttribute(
            'subRightsList', 
            $rights->getAllRows('`parent_id` > 1')
        );
    }

    /**
     * {@inheritDoc}
     */
    public function edit()
    {
        $record     = $this->_edit();
        $this->_addRightsLinkedData($record);

        HResponse::succeed('更新成功！', $this->_getReferenceUrl(1));
    }

    /**
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    public function add()
    {
        $record     = $this->_add();
        $this->_addRightsLinkedData($record);

        HResponse::succeed('添加成功！', $this->_getReferenceUrl(1));
    }

    /**
     * 加入权限关联数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _addRightsLinkedData($record)
    {
        $linkedData     = HClass::quickLoadModel('linkeddata');
        $linkedData->setRelItemModel('actor', 'rights');
        $linkedData->deleteByWhere('`rel_id` = ' . $record['id']);
        $list           = array();
        foreach(HRequest::getParameter('rights') as $id) {
            $list[]     = array(
                'item_id' => $id,
                'rel_id' => $record['id'],
                'author' => HSession::getAttribute('id', 'user')
            );
        }
        $linkedData->addMore('`item_id`, `rel_id`, `author`', $list);
    }

    /**
     * 得到权限资源条件
     *  
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @return 权限资源ID的条件部分
     */
    private function _getItemIdWhere()
    {
    	if(0 < intval(HRequest::getParameter('p_id'))) {
    		return '`item_id` = ' . HRequest::getParameter('item_id');
    	}
    	$model 		= HClass::quickLoadModel(HRequest::getParameter('item_model'));
    	
        return '`item_id` = ' . HRequest::getParameter('item_id') 
            . ' OR ' . HSqlHelper::whereInByListMap(
            'item_id', 'id',
            $model->getAllRows('`parent_id` = ' . HRequest::getParameter('item_id'))
        );
    }

}

?>
