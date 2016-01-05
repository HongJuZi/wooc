<?php

/**
 * @version			$Id$
 * @create 			2015-05-02 22:05:02 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.sharesettingpopo, app.admin.action.AdminAction, model.sharesettingmodel');

/**
 * 分享设置的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class SharesettingAction extends AdminAction
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
        $this->_popo        = new SharesettingPopo();
        $this->_model       = new SharesettingModel($this->_popo);
    }

    private $_identifierList = 
                array('0' => array('id' => 'qq', 'name' => 'QQ'),
                  '1' => array('id' => 'weibo', 'name' => '新浪微博'),
                  '2' => array('id' => 'weixin', 'name' => '微信')
                );

    protected function _otherJobsAfterAddView()
    {
        parent::_otherJobsAfterAddView();
        HResponse::setAttribute(
            'identifier_list',
            $this->_identifierList
        );
    }

    protected function _otherJobsAfterEditView()
    {
        parent::_otherJobsAfterAddView();
        HResponse::setAttribute(
            'identifier_list',
            $this->_identifierList
        );
    }
}

?>
