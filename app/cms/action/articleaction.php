<?php

/**
 * @version			$Id$
 * @create 			2013-06-18 10:06:22 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.articlepopo, app.cms.action.cmsaction, model.articlemodel');

/**
 * 文章的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.front.action
 * @since 			1.0.0
 */
class ArticleAction extends CmsAction 
{

    /**
     * @var String $_identifier 分类
     */
    protected $_identifier;

    /**
     * @var protected $_category  分类对象
     */
    protected $_category    = null;

    /**
     * {@inheritDoc}
     */
    public function beforeAction() 
    { 
        $this->_commAssign();
    }

    /**
     * 构造函数 
     * 
     * 初始化类里的变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_popo        = new ArticlePopo();
        $this->_model       = new ArticleModel($this->_popo);
        $this->_category    = HClass::quickLoadModel('category');
    }

    /**
     * {@inheritDoc}
     */
    protected function _list()
    {
        parent::_list($this->_getSubCategoryWhereByIdentifier($this->_identifier, true));
        $this->_otherJobs();

        $this->_render(HResponse::getAttribute('HONGJUZI_MODEL') . '-list');
    }

    /**
     * {@inheritDoc}
     */
    public function type()
    {
        parent::_type();
        $this->_otherJobs();
        
        $this->_render(HResponse::getAttribute('HONGJUZI_MODEL') . '-list');
    }

    /**
     * 执行其它事务，如加载分类等
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _otherJobs()
    {
    }

    /**
     * {@inheritDoc}
     */
    public function search()
    {
        parent::search();
        $this->_otherJobs();

        $this->_render(HResponse::getAttribute('HONGJUZI_MODEL') . '-list');
    }

    /**
     * 按标签查找文章
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function tag()
    {
        parent::_tag();
        $this->_otherJobs();

        $this->_render(HResponse::getAttribute('HONGJUZI_MODEL') . '-list');
    }

    /**
     * {@inheritDoc}
     */
    protected function _detail()
    {
        parent::_detail();
        HResponse::setAttribute('identifier', $this->_identifier);
        $this->_otherJobs();

        $this->_render(HResponse::getAttribute('HONGJUZI_MODEL') . '-detail');
    }

    /**
     * {@inheritDoc}
     */
    public function name()
    {
        parent::_name();
        HResponse::setAttribute('identifier', $this->_identifier);
        $this->_otherJobs();

        $this->_render(HResponse::getAttribute('HONGJUZI_MODEL') . '-detail');
    }

    /**
     * 加载当前分类列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignCatList()
    {
        HResponse::setAttribute(
            'catList', 
            $this->_category->getSubCategoryByIdentifier($this->_identifier, false)
        );
    }

    /**
     * 加载最新招聘信息 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignJob()
    {
        $cat    = $this->_category->getRecordByIdentifier('job');
        HResponse::setAttribute(
            'job', 
            $this->_model->getSomeRows(5, '`parent_id` = ' . $cat['id'])
        );
    }

    /**
     * 通过链接名称得到子分类条件
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  String $identifier 链接名称
     * @param  boolean $self 是否包括自己，默认为：false
     * @return String 分类条件
     */
    protected function _getSubCategoryWhereByIdentifier($identifier, $self = false)
    {
        $cat    = $this->_category->getRecordByIdentifier($identifier);
        if(!$cat) {
            return '1 = 2';
        }

        return '`parent_id` LIKE \'%,' . $cat['id'] . ',%\'';
    }

    /**
     * 通过上级ID得到所有下级的分类ID
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  int $id  当前上级分类
     * @return String 条件
     */
    protected function _getSubCategoryWhereById($id)
    {
        return '`parent_id` LIKE \'%,' . $id . ',%\'';
    }

    /**
     * {@inheritDoc}
     */
    protected function _getCategoryWhere($id)
    {
        return $this->_getSubCategoryWhereById($id);
    }

    /**
     * {@inheritDoc}
     */
    protected function _getSearchWhere($keywords)
    {
        return '(' . $this->_getSubCategoryWhereByIdentifier($this->_identifier)
            . ') AND (' . $this->_getSearchWhere($keywords) . ')';
    }

    /**
     * 加载记录对应的标签
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignTagList()
    {
        $record         = HResponse::getAttribute('record');
        $relationship   = HClass::quickLoadModel('relationship');
        $relList        = $relationship->getAllRows(
            '`rel_id` = ' . $record['id'] . ' AND `model` = \'article\'' 
        );
        if(empty($relList)) { 
            return;
        }
        $tags   = HClass::quickLoadModel('tags');
        HResponse::setAttribute(
            'tagList', 
            $tags->getAllRows(HSqlHelper::whereInByListMap('id', 'item_id', $relList))
        );
    }

}

?>
