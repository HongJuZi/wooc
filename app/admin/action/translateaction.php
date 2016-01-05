<?php

/**
 * @version			$Id$
 * @create 			2015-04-06 20:04:53 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.translatepopo, app.admin.action.AdminAction, model.translatemodel');

/**
 * 翻译的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class TranslateAction extends AdminAction
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
        $this->_popo        = new TranslatePopo();
        $this->_model       = new TranslateModel($this->_popo);
    }

    /**
     * 加载详细页面Hook内容
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _otherJobsAfterInfo()
    {
        parent::_otherJobsAfterInfo();

        HResponse::setAttribute('parent_id_list', $this->_assignLangList());
    }

}

?>
