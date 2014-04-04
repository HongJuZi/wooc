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
     * 构造函数 
     * 
     * 初始化类变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_popo        = new ArticlePopo();
        $this->_model       = new ArticleModel($this->_popo);
    }

    /**
     * 组合搜索条件
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return String 组合成的搜索条件
     */
    protected function _combineWhere()
    {
        $where          = array('1 = 1');
        if(1 < intval(HRequest::getParameter('type'))) {
            array_push($where, '`parent_id` LIKE \'%,' . HRequest::getParameter('type') . ',%\'');
        }
        $keywords       = HRequest::getParameter('keywords');
        if(!$keywords || '关键字...' === $keywords) {
            return implode(' AND ', $where);
        }
        $keywordsWhere  = $this->_getSearchWhere($keywords);
        if($keywordsWhere) {
            array_push($where, $keywordsWhere);
        }

        if(!$where) {
            return null;
        }

        return implode(' AND ', $where);
    }

    /**
     * 添加模块视图 
     * 
     * @desc
     * 
     * @access public
     */
    public function addview()
    {  
        $this->_addview();

        $this->_render('article/info');
    }

    /**
     * 执行模块的添加 
     * 
     * @desc
     * 
     * @access public
     */
    public function add()
    {
        HRequest::setParameter(
            'cat_names', 
            HRequest::getParameter('lookup_checkbox_values')
        );
        $id     = $this->_add();
        $this->_addTagRelationship($id);
        HResponse::succeed($acName . '添加成功！', $this->_getReferenceUrl(2));
    }

    /**
     * 编辑动作 
     * 
     * @desc
     * 
     * @access public
     */
    public function editview()
    {
        $this->_editview();
        $record     = HResponse::getAttribute('record');
        $this->_assignParentInfo($record['parent_id']);
        $this->_assignMyCategory();

        $this->_render('article/info');
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
        if(!$record['parent_id']) {
            return;
        }
        $category   = HClass::quickLoadModel('category');
        $catIds     = array_filter(explode(',', $record['parent_id']));
        $list       = $category->getAllRows('`id` IN (' . implode(',', $catIds) . ')');
        $catNodes   = array();
        foreach($list as $item) {
            array_push($catNodes, $item['name']);
        }
        $record['lookup_parent_id']     = implode(',', $catNodes);
        HResponse::setAttribute('record', $record);
    }

    /**
     * 加载相册
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignAlbum()
    {
        $record     = HResponse::getAttribute('record');
        $linkedData = HClass::quickLoadModel('linkeddata');
        $linkList   = $linkedData->getAllRows('`hash` = \'' . $record['album_hash'] . '\'');
        if(empty($linkList)) { return ; } 
        $resource   = HClass::quickLoadModel('resource');
        $resourceList   = $resource->getAllRows(HSqlHelper::whereInByListMap('id', 'res_id', $linkList));
        HResponse::setAttribute('album', $linkList);
        HResponse::setAttribute('resourceMap', HArray::turnItemValueAsKey($resourceList, 'id'));
    }

    /**
     * 编辑提示动作 
     * 
     * @desc
     * 
     * @access public
     */
    public function edit()
    {
        HRequest::setParameter(
            'cat_names', 
            HRequest::getParameter('lookup_checkbox_values')
        );
        $record     = $this->_edit();
        HResponse::succeed($acName . HResponse::lang('UPDATE_SUCCESS', false), $this->_getReferenceUrl(2));
    }

    /**
     * 得到当前模块的所有父类 
     * 
     * 根据当前popo类里的parentTable来判断是否有父类 
     * 
     * @access protected
     */
    protected function _assignParentRootList()
    {
        HResponse::setAttribute('parentName', 'category');
        HResponse::setAttribute(
            'parents', 
            HClass::quickLoadModel('category')->getAllRows('`parent_id` = 0 OR `parent_id` IS NULL')
        );
    }

    /**
     * 执行Lookup功能
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function lookup()
    {
        $category   = HClass::quickLoadModel('category');
        HResponse::setAttribute('list', $category->getAllRows('`parent_id` < 1'));
        HResponse::setAttribute('sync_url', HResponse::url('category/aload'));

        $this->_render('common/lookup-tree-checkbox');
    }

}

?>
