<?php

/**
 * @version			$Id$
 * @create 			2013-10-03 18:10:42 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
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
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function autolearn()
    {
        HVerify::isAjax();
        if(!HRequest::getParameter('tag')) {
            HResponse::json(array('rs' => true));
            return;
        }
        $record = $this->_model->getRecordByWhere('`name` = \'' . HRequest::getParameter('tag') . '\'');
        if($record) {
            $this->_addTagRelationship($record['id']);
            HResponse::json(array('rs' => true, 'id' => $record['id']));
            return;
        }
        $data   = array(
            'sort_num' => $_SERVER['REQUEST_TIME'],
            'name' => HRequest::getParameter('tag'),
            'author' => HSession::getAttribute('id', 'user')
        );
        $tagId  = $this->_model->add($data);
        if(1 > $tagId) {
            throw new HRequestException('标签添加失败！');
        }
        $this->_addTagRelationship($tagId);
        HResponse::json(array('rs' => true, 'id' => $tagId));
    }

    /**
     * 添加标签外键关系数据
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  int $relId 关联ID
     */
    private function _addTagRelationship($itemId)
    {
        if(!HRequest::getParameter('id')) {
            return;
        }
        $relationship   = HClass::quickLoadModel('relationship');
        $relationship->add(array(
            'item_id' => $itemId,
            'rel_id' => HRequest::getParameter('id'),
            'model' => !HRequest::getParameter('model') ? HResponse::getAttribute('HONGJUZI_APP') : HRequest::getParameter('model'),
            'author' => HSession::getAttribute('id', 'user')
        ));
    }

    /**
     * 删除标签
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aremovetag()
    {
        HVerify::isAjax();
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
        $relationship   = HClass::quickLoadModel('relationship');
        $whereAuthor    = '';
        if(!in_array(HSession::getAttribute('actor', 'user'), array('root', 'editor'))) {
            $whereAuthor    = ' AND `author` = ' . HSession::getAttribute('id', 'user');
        }
        $relationship->deleteByWhere(
            '`item_id` = ' . $tagInfo['id'] .
            ' AND `rel_id` = ' . HRequest::getParameter('id') . 
            $whereAuthor
        );
        HResponse::json(array('rs' => true));
    }

    /**
     * 自动匹配
     * 
     * @desc
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
