<?php

/**
 * @version			$Id$
 * @create 			2012-4-7 17:27:43 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.cms.action.cmsaction');

/**
 * 主页的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.cms.action
 * @since 			1.0.0
 */
class IndexAction extends CmsAction
{

    /**
     * 网站主页 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function index()
    {
        $this->_assignSiteConfig();
        $this->_assignSeoInfo();
        $this->_assignNavmenus();
        $this->_assignBanner();
        $this->_assignCompany();
        $this->_assignArticleInfoAndList();
        $this->_assignGoods();
        $this->_assignLink();

        $this->_render('index');
    }

    /**
     * 得到公司简
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     * @return void
     * @throws none
     */
    protected function _assignArticleInfoAndList()
    {
        $article    = HClass::quickLoadModel('article', 'site');
        //加载文章类型
        $this->_assignArticleList($article);
    }

    /**#
     * 加载公司简介
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignCompany()
    {
        HResponse::setAttribute('company', HClass::quickLoadModel('company')->getSomeRows(1));
    }

    /**
     * 加载最新新闻
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignArticleList($article)
    {
        $category   = HClass::quickLoadModel('category');
        foreach(array('news' => 5, 'knowledge' => 1) as $type => $rows) {
            $categoryList   = $category->getSubCategoryByIdentifier($type, true);
            HResponse::setAttribute(
                $type . 'List', 
                $article->getSomeRows($rows, HSqlHelper::whereInByListMap('parent_id', 'id', $categoryList))
            );
        }
    }

    /**
     * 加载广告大图
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignBanner()
    {
        HResponse::setAttribute('bannerList', HClass::quickLoadModel('banner')->getSomeRows(5));
    }

    /**
     * 加载产品展示
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignGoods()
    {
        $category   = HClass::quickLoadModel('category');
        $catGoods   = $category->getRecordByIdentifier('goods');
        if(!$catGoods) {
            return;
        }
        $article    = HClass::quickLoadModel('article');
        HResponse::setAttribute(
            'goodsList', 
            $article->getSomeRows(8, '`parent_id` LIKE \'%,' . $catGoods ['id'] . ',%\'')
        );
    }

    /**
     * 加载友情链接
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignLink()
    {
        HResponse::setAttribute('linkList', HClass::quickLoadModel('link')->getSomeRows(5));
    }

}

?>
