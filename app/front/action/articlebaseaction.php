<?php

/**
 * @version			$Id$
 * @create 			2013-06-18 10:06:22 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.articlepopo, app.front.action.frontaction, model.articlemodel');

/**
 * 文章的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.front.action
 * @since 			1.0.0
 */
class ArticleBaseAction extends FrontAction 
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
        return HSqlHelper::whereInByListMap(
            'parent_id', 'id',
            $this->_category->getSubCategoryByIdentifier($identifier, $self)
        );
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
        return HSqlHelper::whereInByListMap('parent_id', 'id', $this->_category->getSubCategory($id));
    }

    /**
     * {@inheritDoc}
     */
    protected function _getTypeWhere($id)
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
     * @desc
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
