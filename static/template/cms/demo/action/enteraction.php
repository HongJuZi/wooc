<?php

/**
 * @version         $Id$
 * @create          2013-06-18 10:06:22 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight       Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import(HResponse::getCurThemePath() . '.action.defaultaction');

/**
 * 入口的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author          xjiujiu <xjiujiu@foxmail.com>
 * @package         app.front.action
 * @since           1.0.0
 */
class EnterAction extends DefaultAction 
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
        parent::__construct();
    }

    /**
     * 登陆首页
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function index()
    {
        if(AuserAction::isLoginedByBool()) {
            HResponse::redirect(HResponse::url('home'));
        }
        $this->_commAssign();

        $this->_render('login');
    }

    /**
     *注册页面
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function register()
    {
        if(AuserAction::isLoginedByBool()) {
            HResponse::redirect(HResponse::url('home'));
        }
        $this->_commAssign();

        $this->_render('register');
    }

}
