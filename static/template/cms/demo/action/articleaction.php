<?php

/**
 * @version			$Id$
 * @create 			2013-06-18 10:06:22 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.articlepopo, model.articlemodel');
HClass::import(HResponse::getCurThemePath() . '.action.defaultAction');

/**
 * 文章的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.front.action
 * @since 			1.0.0
 */
class ArticleAction extends DefaultAction 
{

    /**
     * @var protected $_identifier 针对于单页
     */
    protected $_identifier;

    /**
     * 构造函数 
     * 
     * 初始化类里的变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        parent::__construct();
        $this->_popo        = new ArticlePopo();
        $this->_model       = new ArticleModel($this->_popo);
        $this->_model->setMustWhere('status', '`status` = 2');
        $this->_model->setMustWhere('lang', ' AND `lang_id` = ' . HSession::getAttribute('id', 'lang'));
    }

    /**
     * 设置必须条件通过分类
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  $identifier 标识
     */
    protected function _setMusetWhereByCategory($identifier, $isSelf = false)
    {
        $this->_model->setMustWhere(
            $identifier . '-cat-where', 
            ' AND (' . $this->_getSubCategoryWhereByIdentifier($identifier) . ')'
        );
    }

    /**
     * {@inheritDoc}
     */
    protected function _list($where = null, $perpage = 15)
    {
        if($this->_catIdentifier) {
            $where      = HSqlHelper::mergeWhere(array(
                $where, $this->_getSubCategoryWhereByIdentifier($this->_catIdentifier, true)
            ), 'AND');
        }
        $this->_assignCurListLocation();
        parent::_list($where, $perpage);
        $this->_otherJobs();

        $this->_render($this->_popo->modelEnName . '-list');
    }

    /**
     * {@inheritDoc}
     */
    public function type()
    {
        $id     = HRequest::getParameter('id');
        HVerify::isEmpty($id, '分类编号');
        $categoryRecord     = $this->_category->getRecordById($id);
        if(empty($categoryRecord)) {
            throw new HRequestException('该分类不存在，请稍后再试');
        }
        $where      = $this->_getSubCategoryWhereById($categoryRecord['id'], true);
        parent::_list($where);
        $this->_assignCurListLocation();
        
        $this->_render($this->_popo->modelEnName . '-list');
    }

    /**
     * 加载当前列表路径地址
     * @param  [type] $record 当前记录
     * @return [type]         [description]
     */
    protected function _assignCurListLocation()
    {
        if($this->_catIdentifier) {
            $record     = $this->_category->getRecordByIdentifier($this->_catIdentifier);
        }
        if(HRequest::getParameter('id')) {
            $record     = $this->_category->getRecordById(HRequest::getParameter('id'));
            // $this->_catIdentifier   = $record['identifier'];
        }
        if(empty($record)) {
            return;
        }
        $parentPath     = explode(':', $record['parent_path']);
        $curLocation        = array();
        foreach($parentPath as $key => $value) {
            if(!empty($value) && '447' != $value) {
                $curLocation[$value]  = $this->_category->getRecordById($value);
            }
        } 

        HResponse::setAttribute('cid', $record['id']);
        $this->_popo->modelZhName   = $record['name'];
        HResponse::setAttribute('curLocation', $curLocation);
    }

    /**
     * {@inheritDoc}
     */
    public function search()
    {
        parent::search();
        $this->_otherJobs();

        $this->_render('article-list');
    }

    /**
     * {@inheritDoc}
     */
    protected function _detail()
    {
        parent::_detail();
        $this->_otherJobs();

        $this->_render($this->_popo->modelEnName . '-detail');
    }

    /**
     * {@inheritDoc}
     */
    public function name()
    {
        parent::_name();
        HResponse::setAttribute('identifier', $this->_catIdentifier);
        $this->_otherJobs();
        
        $this->_render('article-list');
    }

    /**
     * 公共加载
     * @return [type] [description]
     */
    protected function _commAssign()
    {
        parent::_commAssign();
        $this->_assignCatList();
    }

    /**
     * 加载当前分类列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignCatList()
    {
        $catInfo    = $this->_category->getRecordByIdentifier($this->_catIdentifier);
        if(!$catInfo) {
            return;
        }
        $catList        = array();
        $threeCatList   = array();
        $subCatList     = $this->_category->getSubCategoryByIdentifier($this->_catIdentifier, false);
        foreach($subCatList as $key => $subCat) {
            if($subCat['parent_id'] == $catInfo['id']) {
                array_push($catList, $subCat) ;
            }
        }
        foreach($subCatList as $key => $subCat) {
            foreach($catList as $cat) {
                if($cat['id'] == $subCat['parent_id']) {
                    $threeCatList[$cat['id']][$subCat['id']] = $subCat;
                }
            }
        }

        HResponse::setAttribute('catList', $catList);
        HResponse::setAttribute('threeCatList', $threeCatList);
    }

    /**
     * 通过链接名称得到子分类条件
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

        return '`parent_path` LIKE \'' . $cat['parent_path'] . '%\'';
    }

    /**
     * 通过上级ID得到所有下级的分类ID
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @param  int $id  当前上级分类
     * @return String 条件
     */
    protected function _getSubCategoryWhereById($id)
    {
        $cat    = $this->_category->getRecordById($id);
        if(!$cat) {
            return '1 = 2';
        }

        return '`parent_path` LIKE \'' . $cat['parent_path'] . '%\'';
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
        return '(' . $this->_getSubCategoryWhereByIdentifier($this->_catIdentifier)
            . ') AND (' . $this->_getSearchWhere($keywords) . ')';
    }

    /**
     * 根据标识得到推荐的文件列表
     * @param  [type] $identifier [description]
     * @param  [type] $rows       [description]
     * @return [type]             [description]
     */
    protected function _getRecommendArticleList($identifier, $rows = 5)
    {
        $where  = HSqlHelper::whereInByListMap(
            'parent_id', 'id', 
            $this->_category->getSubCategoryByIdentifier($identifier, true)
        );
        $articleList    = $this->_model->getSomeRowsByFields(
            $rows, '`id`, `name`, `description`, `image_path`, `edit_time`, `create_time`',
            $where
        );

        return $articleList;
    }

    /**
     * 得到首页推荐文章
     * @return [type] [description]
     */
    public function getrecommendarticle()
    {
        HVerify::isAjax();
        $identifier     = HRequest::getParameter('identifier');
        HVerify::isEmpty($identifier, '标识');
        $record         = $this->_category->getRecordByIdentifier($identifier);
        $articleList    = $this->_getRecommendArticleList($identifier, 8);

        HResponse::json(array('rs' => true, 'data' => array('list' => $articleList, 'id' => $record['id'])));
    }

}

?>
