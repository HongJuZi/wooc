<?php

/**
 * @version			$Id$
 * @create 			2015-03-17 21:03:10 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.sharecfgpopo, app.admin.action.AdminAction, model.sharecfgmodel');

/**
 * 分享配置的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class SharecfgAction extends AdminAction
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
        parent::__construct();
        $this->_popo        = new SharecfgPopo();
        $this->_model       = new SharecfgModel($this->_popo);
    }

    /**
     * 搜索方法 
     * 
     * @access public
     */
    public function search()
    {
        $this->_search($this->_combineWhere());

        $this->_render('sharecfg/list');
    }

    /**
     * 分享主页
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function index()
    {
        $this->_search();

        $this->_render('sharecfg/list');
    }

    /**
     * 列表的后驱方法
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _otherJobsAfterList()
    {
        HResponse::setAttribute(
            'sharesettingList',
            HClass::quickLoadModel('sharesetting')->getAllRows()
        );

        parent::_otherJobsAfterList();
        HClass::import('app.oauth.action.weiboaction');
        HClass::import('app.oauth.action.qqaction');

        HObject::loadAppCfg('oauth');
        HResponse::setAttribute(
            'syncUrls', 
            array(
                'weibo' => WeiboAction::getInstance()->getAuthorizeURL(),
                'qq' => QQAction::getInstance()->getAuthorizeURL()
            )
        );
    }


}

?>
