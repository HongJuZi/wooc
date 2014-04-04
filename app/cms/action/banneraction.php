<?php

/**
 * @version			$Id$
 * @create 			2013-08-05 16:08:13 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.bannerpopo, app.cms.action.CmsAction, model.bannermodel');

/**
 * 大图展示的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.site.action
 * @since 			1.0.0
 */
class BannerAction extends CmsAction
{

    /**
     * 构造函数 
     * 
     * 初始化类里的变量 
     * 
     * @access public
     */
    public function __construct() 
    {
        $this->_popo    = new BannerPopo();
        $this->_model   = new BannerModel($this->_popo);
    }

    /**
     * {@inheritDoc}
     */
    protected function _list()
    {
        parent::_list();
        
        $this->_render('banner-list');
    }

    /**
     * {@inheritDoc}
     */
    protected function _detail()
    {
        parent::_detail();

        $this->_render('detail');
    }

}

?>
