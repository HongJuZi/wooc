<?php

/**
 * @version			$Id$
 * @create 			2013-12-19 21:12:37 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.websitepopo, app.public.action.PublicAction, model.websitemodel');

/**
 * 网站管理的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.public.action
 * @since 			1.0.0
 */
class WebsiteAction extends PublicAction
{

    /**
     * 构造函数 
     * 
     * 初始化类变量 
     * 
     * @access public
     */
    public function __construct() { }

    /**
     * 切换网站
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aswitch()
    {
        $this->_aswitch('website');
    }

    /**
     * 切换网站数据
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aswitchdata()
    {
        $this->_aswitch('website_data');
    }

    /**
     * 切换网站数据
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access private
     * @param  String $name session属性名称
     */
    private function _aswitch($name)
    {
        HVerify::isAjax();
        HVerify::isRecordId(HRequest::getParameter('id'), '网站编号');
        if(0 < intval(HRequest::getParameter('id'))) {
            $this->_popo        = new WebsitePopo();
            $this->_model       = new WebsiteModel($this->_popo);
            $website            = $this->_model->getRecordById(HRequest::getParameter('id'));
            if(!$website) {
                throw new HVerifyException('网站不存在，请确认～');
            }
            HSession::setAttributeByDomain($website, $name);
        }
        HResponse::json(array('rs' => true));
    }

}

?>
