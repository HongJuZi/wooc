<?php

/**
 * @version			$Id$
 * @create 			2013-06-18 10:06:22 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.articlepopo, app.admin.action.AdminAction, model.articlemodel');

/**
 * 文章的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class ArticleAction extends AdminAction
{

    /**
     * 前驱方法
     * @return [type] [description]
     */
    public function beforeAction()
    {
        //$this->_hverifyUserActor();
    }

    /**
     * [_hverifyUserActor description]
     * @return [type] [description]
     */
    private function _hverifyUserActor()
    {
        $actor  = $this->_getUserActor();
        if(!in_array($actor['identifier'], array('root', 'editor'))) {
            throw new HRequestException('对不起您没有该权限');
        }
    }

    /**
     * 构造函数 
     * 
     * @access public
     */
    public function __construct() 
    {
        parent::__construct();
        $this->_popo        = new ArticlePopo();
        $this->_popo->setFieldAttribute('tags', 'is_show', false);
        $this->_popo->setFieldAttribute('tags_name', 'is_show', false);
        $this->_popo->setFieldAttribute('description', 'is_show', false);
        $this->_popo->setFieldAttribute('author', 'is_show', false);
        $this->_model       = new ArticleModel($this->_popo);
    }

    /**
     * 视图后驱
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    protected function _otherJobsAfterAddView()
    {
        parent::_otherJobsAfterAddView();
        $this->_assignMyCategory();
        HResponse::setAttribute('status_list', ArticlePopo::$statusMap);
    }

    /**
     * 编辑后驱
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _otherJobsAfterEditView($record)
    {
        parent::_otherJobsAfterEditView($record);
        $this->_assignParentInfo($record['parent_id']);
        $this->_assignMyCategory();
        $this->_assignTags();
        HResponse::setAttribute('status_list', ArticlePopo::$statusMap);
    }

    /**
     * 执行模块的添加 
     * 
     * @access public
     */
    public function add()
    {
        $id     = $this->_add();
        $this->_setParentPath($id);
        $this->_addTagLinkedData($id);
        $this->_addLangLinkedData($id);
        //发布的时候才同步

        HResponse::succeed($acName . '添加成功！', HResponse::url('article'));
    }

    /**
     * 加载当前分类信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignMyCategory()
    {
        $record     = HResponse::getAttribute('record');

        HResponse::setAttribute(
            'parent_id_nodes', 
            $this->_formatToZTreeNodes(HResponse::getAttribute('parent_id_list'), array($record['parent_id']))
        );
    }

    /**
     * 编辑提示动作 
     * 
     * @access public
     */
    public function edit()
    {
        $record     = $this->_edit();
        $this->_setParentPath($record['id']);
        $this->_addTagLinkedData(HRequest::getParameter('id'));
        $this->_addLangLinkedData($record['id']);

        HResponse::succeed('更新成功！', HResponse::url('article'));
    }

    /**
     * 设置层级
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param $id 编号
     */
    private function _setParentPath($id)
    {
        $cat    = $this->_category->getRecordById(HRequest::getParameter('parent_id'));
        if(!$cat) {
            throw new HVerifyException('分类不存在，请确认！');
        }
        $this->_model->editByWhere(array('parent_path' => $cat['parent_path']), '`id` = ' . $id);
    }

    /**
     * 得到当前模块的所有父类 
     * 
     * 根据当前popo类里的parentTable来判断是否有父类 
     * 
     * @access protected
     */
    protected function _assignAllParentList()
    {
        $list       = $this->_category->getSubcategoryByIdentifier('article-cat', true);
        $list       = array_merge($list, $this->_category->getSubcategoryByIdentifier('single-page', true));

        HResponse::setAttribute('parent_id_list', $list);
    }

    /**
     * 执行额外的删除操作
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    protected function _otherJobsAfterDelete($ids)
    {
        parent::_otherJobsAfterDelete();
        $this->_deleteTagsLinkedData($ids);
    }

    /**
     * 得到上层条件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param $id 编号
     * @return String 
     */
    protected function _getParentWhere($id)
    {
        $cat    = $this->_category->getRecordById($id);
        if(!$cat) {
            throw new HVerifyException('分类已经不存在，请确认！');
        }

        return '`parent_path` LIKE \'' . $cat['parent_path'] . '%\'';
    }
}

?>
