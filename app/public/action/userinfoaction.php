<?php

/**
 * @version			$Id$
 * @create 			2013-11-17 18:11:51 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.userinfopopo, app.public.action.publicaction, model.userinfomodel');

/**
 * 用户扩展信息处理的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.public.action
 * @since 			1.0.0
 */
class UserinfoAction extends PublicAction
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
        $this->_popo    = new UserinfoPopo();
        $this->_model   = new UserinfoModel($this->_popo);
    }

    /**
     * 用户扩展信息更新
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function update()
    {
        $data       = array(
            'parent_id' => HSession::getAttribute('id', 'user'),
            'url' => HRequest::getParameter('url'),
            'birthday' => HRequest::getParameter('birthday'),
            'location' => HRequest::getParameter('location'),
            'school' => HRequest::getParameter('school'),
            'department' => HRequest::getParameter('department'),
            'class' => HRequest::getParameter('class'),
            'edit_time' => $_SERVER['REQUEST_TIME'],
            'author' => HSession::getAttribute('id', 'user')
        );
        $extendInfo     = $this->_model->getRecordByWhere(
            '`parent_id` = ' . HSession::getAttribute('id', 'user')
        );
        if(!HSession::getAttribute('id', 'userinfo')) {
            if(1 > $this->_model->add($data)) {
                throw new HRequestException('更新用户其它信信息失败～');
            }
        } else {
            $data['id']     = $extendInfo['id'];
            if(1 > $this->_model->edit($data)) {
                throw new HRequestException('更新用户其它信信息失败～');
            }
        }
        HSession::setAttribute(null, $data, 'userinfo');
        HResponse::succeed('更新成功！');
    }

	        
    /**
     * 暂时的用户中心
     */
    public function usercenter(){
    	$userid = HSession::getAttribute('id','user');
    	if(empty($userid)){
    		throw new HVerifyException('请先登录~');
    	}
    	$userModel = HClass::quickLoadModel('user');
    	$record = $userModel->getRecordById($userid);
    	HResponse::setAttribute('record',$record);
    	$this->_render('user-center');
    }
    
    
    /**
     * 跳转登录页面
     */
    public function login(){
    	$nextUrl = HRequest::getParameter('next_url');
    	HResponse::setAttribute('next_url',$nextUrl);
    	$this->_render('login');
    }
    
    /**
     * 跳转注册页面
     */
    public function register(){
    	$this->_render('register');
    }
    
    /**
     * 跳转找回密码页面
     */
    public function findpasswd(){
    	$this->_render('findpassword');
    }
    

}

?>
