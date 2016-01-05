<?php

/**
 * @version			$Id$
 * @create 			2013-10-03 18:10:42 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.oauth.action.auserAction');
HClass::import('config.popo.tagspopo, app.public.action.PublicAction, model.tagsmodel');

/**
 * 标签的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class TagsAction extends PublicAction
{

    /**
     * {@inheritDoc}
     */
    public function beforeAction()
    {
        try {
            AuserAction::isLogined();
        } catch(HVerifyException $ex) {
            HResponse::redirect(HResponse::url('enter', '', 'admin'));
        }
    }

    /**
     * 构造函数 
     * 
     * 初始化类变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_popo        = new TagsPopo();
        $this->_model       = new TagsModel($this->_popo);
    }

    /**
     * 自学习 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function autolearn()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('rel_model'), '当前模块');
        if(!HRequest::getParameter('tag')) {
            HResponse::json(array('rs' => true));
            return;
        }
        $record = $this->_model->getRecordByWhere('`name` = \'' . HRequest::getParameter('tag') . '\'');
        if($record) {
            $this->_addTagLinkedData($record['id']);
            $this->_updateTagHots($record['id'], intval($record['hots']) + 1);
            HResponse::json(array('rs' => true, 'id' => $record['id']));
            return;
        }
        $data   = array(
            'name' => HRequest::getParameter('tag'),
            'author' => HSession::getAttribute('id', 'user')
        );
        $tagId  = $this->_model->add($data);
        if(1 > $tagId) {
            throw new HRequestException('标签添加失败！');
        }
        $this->_addTagLinkedData($tagId);
        HResponse::json(array('rs' => true, 'id' => $tagId));
    }

    /**
     * 添加标签外键关系数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  int $relId 关联ID
     */
    private function _addTagLinkedData($itemId)
    {
        if(!HRequest::getParameter('id')) {
            return;
        }
        $linkedData     = HClass::quickLoadModel('linkedData');
        $linkedData->setRelItemModel(HRequest::getParameter('rel_model'), 'tags');
        $where          = '`item_id` = ' . $itemId 
            . ' AND `rel_id` = ' . HRequest::getParameter('id');
        if($linkedData->getRecordByWhere($where)) {
            return;
        }
        $linkedData->add(array(
            'item_id' => $itemId,
            'rel_id' => HRequest::getParameter('id'),
            'author' => HSession::getAttribute('id', 'user')
        ));
    }

    /**
     * 删除标签
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aremovetag()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('rel_model'), '当前模块');
        if(!HRequest::getParameter('tag') || !HRequest::getParameter('id')) {
            HResponse::json(array('rs' => true));
            return;
        }
        $tagInfo        = $this->_model->getRecordByWhere(
            '`name` = \'' . HRequest::getParameter('tag') . '\''
        );
        if(!$tagInfo) {
            $this->autolearn();
            return;
        }
        $linkedData = HClass::quickLoadModel('linkedData');
        $where      = '`item_id` = ' . $tagInfo['id'] 
            . ' AND `rel_id` = ' . HRequest::getParameter('id');
        $linkedData->setRelItemModel(HRequest::getParameter('rel_model'), 'tags')
            ->deleteByWhere($where);
        $this->_updateTagHots($tagInfo['id'], intval($tagInfo['hots']) - 1);

        HResponse::json(array('rs' => true));
    }

    /**
     * 更新标签使用数量
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  $id 标签编号
     * @param  $hots 使用数量
     */
    private function _updateTagHots($id, $hots)
    {
        $hots       = 0 > $hots ? 0 : $hots;
        if(1 > $this->_model->edit(array('id' => $id, 'hots' => $hots))) {
            throw new HRequestException('更新标签数量失败，请稍后再试！');
        }
    }

    /**
     * 自动匹配
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function amatch()
    {
        HVerify::isAjax();
        if(!HRequest::getParameter('term')) {
            echo '[]';
            return;
        }
        $list   = $this->_model->getAllRows(
            '`name` LIKE \'%' . HRequest::getParameter('term') . '%\''
        );
        $data   = array();
        foreach($list as $tag) {
            $data[]     = array(
                'id' => $tag['id'],
                'label' => $tag['name'],
                'value' => $tag['name']
            );
        }
        HResponse::json($data);
    }

}

?>
