<?php 

/**
 * @version			$Id$
 * @create 			2012-4-25 21:50:27 By xjiujiu
 * @description     HongJuZi Framework
 * @copyright 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.base.action.baseaction');

/**
 * 前台应用的Action基类部分
 * 
 * 提取前台应用对应action的公用方法 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.front.action
 * @since 			1.0.0
 */
class FrontAction extends BaseAction 
{

    /**
     * 初始化数据
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $this->_assignWebSite();
        $this->_switchLangById(HSession::getAttribute('lang_id', 'siteCfg'));
    }

    /**
     * 模块主页显示方法 
     * 
     * @access protected
     * @param int $perpage 每页加载的记录条数，默认为10
     */
    protected function _list($where = '', $perpage = 10)
    {
        $this->_assignModelList($where, $perpage);
        $this->_commAssign();
        $this->_otherJobs();

        HResponse::setAttribute('title', $this->_popo->modelZhName);
        HResponse::setAttribute('typeName', $this->_popo->modelZhName);
    }

    /**
     * 加载其它任务
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _otherJobs() { }

    /**
     * 公用的赋值方法 
     * 
     * @access protected
     */
    protected function _commAssign()
    {
        $this->_assignSeoInfo();
        HResponse::setAttribute('modelEnName', $this->_popo->modelEnName);
        HResponse::setAttribute('modelZhName', $this->_popo->modelZhName);
    }

    /**
     * 设置页面的SEO信息 
     * 
     * @access protected
     * @param string $seoKeyWords 网站的SEO Keywords部分
     * @param string $seoDesc 网站SEO DESC 部分
     */
    protected function _assignSeoInfo($seoKeyWords = '', $seoDesc = '')
    {
        $record     = HResponse::getAttribute('record');
        if(!$record) {
            return;
        }
        $siteCfg        = HSession::getAttributeByDomain('siteCfg');
        $seoDesc        = HString::cutString(HString::cleanHtmlTag(HString::decodeHtml($record['content'])), 150);
        $seoKeyWords    = !$record['tags_name'] ? $record['name'] : $record['tags_name'];
        $siteCfg['seo_desc']     = $seoDesc ? $seoDesc . ',' . $siteCfg['seo_desc'] : $siteCfg['seo_desc'];
        $siteCfg['seo_keywords'] = $seoKeyWords ? $seoKeyWords . '|' . $siteCfg['seo_keywords'] : $siteCfg['seo_keywords'];
        HSession::setAttributeByDomain($siteCfg, 'siteCfg');
    }
    
    /**
     * 得到所有的父类型 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignParentList()
    {
        $parent    = HClass::quickLoadModel($this->_popo->get('parent'));
        HResponse::setAttribute('parentList', $parent->getAllRows());
    }

    /**
     * 加载默认网站信息
     *
     * 如果这个网站还没有指定默认的网站信息，刚加载默认。
     * 如果这个用户是以Lang的参加加载，刚加载对应的语言
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    protected function _assignWebSite()
    {
        if(!HSession::getAttribute('id', 'siteCfg') && !HRequest::getParameter('lang')) {
            $this->_assignDefWebsite();
            return;
        }
        $langId     = HRequest::getParameter('lang') 
            ? HRequest::getParameter('lang') : HSession::getAttribute('lang_id', 'siteCfg');
        $record     = $this->_getWebSite(
            '`lang_id` = ' . $langId . ' AND `is_open` = 2'
        );
        if(!$record) {
            $this->_assignDefWebsite();
            HResponse::info('此语言版本的网站还没有开放，正在为您导航到正常语言版本！', HResponse::url());
        }
        HSession::setAttributeByDomain($record, 'siteCfg');
    }

    /**
     * 加载默认网站
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignDefWebsite()
    {
        $record     = $this->_getWebSite('`is_default` = 2 AND `is_open` = 2');
        if(!$record) {
            HResponse::redirect(HResponse::url('error/fixing', '', 'public'));
            return;
        }
        HSession::setAttributeByDomain($record, 'siteCfg');
    }

}

?>
