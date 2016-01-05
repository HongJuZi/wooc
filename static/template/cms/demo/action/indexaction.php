<?php

/**
 * @version			$Id$
 * @create 			2012-4-7 17:27:43 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import(HResponse::getCurThemePath() . '.action.defaultaction');

/**
 * 主页的动作类
 *
 * 主要处理主页的相关请求动作
 *
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.cms.action
 * @since 			1.0.0
 */
class IndexAction extends DefaultAction
{

    /**
     * 构造函数
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $this->_popo->modelEnName   = 'index';
        $this->_popo->modelZhName   = '首页';
    }

    /**
     * 网站首页
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function index()
    {
        $this->_assignBannerList();
        $this->_assignNewsList();
        $this->_assignCasesList();
        $this->_assignBessinessInfo();
        $this->_assignContactInfo();
        $this->_commAssign();

        $this->_render('index');
    }

    /**
     * 加载业务范围
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignBessinessInfo()
    {
        $staticCfg      = HClass::quickLoadModel('staticcfg');
        $bessinessInfo  = $staticCfg->getRecordByIdentifier('yie-wu-fan-wei');
        HResponse::setAttribute('bessinessInfo', $bessinessInfo);
    }

    /**
     * 加载案例列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignCasesList()
    {
        $catCases   = $this->_category->getRecordByIdentifier('cases-cat');
        if(!$catCases) {
            throw new HVerifyException('案例分类没有配置，请先配置哦～');
        }
        $article    = HClass::quickLoadModel('article');
        HResponse::setAttribute(
            'casesList',
            $article->getSomeRowsByFields(
                3,
                '`id`, `name`, `image_path`, `create_time`, `description`',
                '`parent_id` = ' . $catCases['id']
            )
        );
    }

    /**
     * 加载新闻列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignNewsList()
    {
        $catNews    = $this->_category->getRecordByIdentifier('news-cat');
        if(!$catNews) {
            throw new HVerifyException('新闻分类没有配置，请先配置哦～');
        }
        $article    = HClass::quickLoadModel('article');
        HResponse::setAttribute(
            'newsList',
            $article->getSomeRowsByFields(
                3,
                '`id`, `name`, `image_path`, `create_time`',
                '`parent_id` = ' . $catNews['id']
            )
        );
    }

    /**
     * 加载大图广告列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     */
    private function _assignBannerList()
    {
        $catBanner   = $this->_category->getRecordByIdentifier('banner');
        if(!$catBanner) {
            throw new HVerifyException('广告大图还没有配置！');
        }
        $adv        = HClass::quickLoadModel('adv');
        $list       = $adv->getSomeRowsByFields(
            5, 
            '`id`, `name`, `image_path`, `url`',
            '`parent_id` = ' . $catBanner['id']
        );
        HResponse::setAttribute('bannerList', $list);
    }

}

?>
