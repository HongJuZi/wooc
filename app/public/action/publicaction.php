<?php

/**
 * @version $Id$
 * @create 2013/10/13 12:51:32 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

/**
 * 公用控制父类
 *
 * @desc
 *
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.public.action
 * @since 1.0.0
 */
class PublicAction extends HAction
{

    /**
     * 主页入口
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function index()
    {
        HResponse::redirect(HResponse::url());
    }

    /**
     * 赋值网站的配置信息 
     * 
     * @desc
     * 
     * @access protected
     */
    protected function _assignSiteConfig()
    {
        $config     = HClass::quickLoadModel('config');
        HResponse::setAttribute(
            'siteCfg', 
            $config->getRecordByWhere('`lang_type` = \'' . $this->_getCurLang() . '\'')
        );
    }
    

}
