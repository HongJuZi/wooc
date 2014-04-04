<?php

/**
 * @version			$Id$
 * @create 			2012-04-25 12:04:22 By xjiujiu
 * @package 	 	app.admin
 * @subpackage 	 	action
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.userpopo, app.admin.action.AdminAction, model.usermodel');

/**
 * 用户列表的动作类 
 * 
 * 主要处理后台管理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.admin.action
 * @since 			1.0.0
 */
class UserAction extends AdminAction
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
        $this->_popo        = new UserPopo();
        $this->_model       = new UserModel($this->_popo);
    }

    /**
     * 全称为CheckUserName即检测当前的用户名 
     * 
     * 当用户名存在时给出错误的提示 
     * 
     * @access public
     */
    public function isunused()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('name'), '用户名');
        if(true === $this->_model->isUserNameUsed($userName)) {
            throw new HVerifyException('用户名已经使用！');
        }
        HResponse::json(array('rs' => true, 'message' => '可以使用！'));
    }

    /**
     * 执行模块的添加 
     * 
     * @desc
     * 
     * @access public
     */
    public function add()
    {
        $where  = '`name` = \'' . HRequest::getParameter('name') . '\'';
        if(true === $this->_model->getRecordByWhere($where)) {
            throw new HVerifyException('用户名已经使用！');
        }
        HRequest::setParameter('password', md5(HRequest::getParameter('password', false)));
        $this->_add();

        HResponse::succeed('添加成功！');
    }

    /**
     * 编辑提示动作 
     * 
     * @desc
     * 
     * @access public
     */
    public function edit()
    {
        HVerify::isRecordId(HRequest::getParameter('id'), '用户ID');
        $record     = $this->_model->getRecordById(HRequest::getParameter('id'));
        $password   = HRequest::getParameter('password', false);
        if($password) {
            HVerify::isStrLen($password, '登录密码', 6, 20);
            HRequest::setParameter('password', md5($password));
        } else {
            HRequest::deleteParameter('password');
        }
        $this->_edit();

        HResponse::succeed('更新成功！', HResponse::url($this->_popo->modelEnName, '', 'admin'));
    }

    /**
     * 删除动作 
     * 
     * @desc
     * 
     * @access public
     * @return void
     * @exception none
     */
    public function delete()
    {
        $recordIds  = HRequest::getParameter('id');
        if(!is_array($recordIds)) {
            $recordIds  = array($recordIds);
        }
        if(in_array(HSession::getAttribute('id', 'user'), $recordIds)) {
            throw new HRequestException('删除用户中不能包含自己！');
        }
        $this->_delete($recordIds);
        HResponse::succeed(
            '删除成功！', 
            HResponse::url($this->_popo->modelEnName, '', 'admin')
        );
    }

    /**
     * 得到用户的头像地址
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @param  String $uid 用户ID
     * @param  String $size='middle' 图片大小
     * @return String
     */
    public function getAvatar($uid) 
    {
        $uid    = abs(intval($uid));    //UID取整数绝对值
        $uid    = sprintf("%09d", $uid); //前边加0补齐9位，例如UID为31的用户变成 000000031
        $dir1   = substr($uid, 0, 3);   //取左边3位，即 000
        $dir2   = substr($uid, 3, 2);   //取4-5位，即00
        $dir3   = substr($uid, 5, 2);   //取6-7位，即00

        // 下面拼成用户头像路径，即000/00/00/31_avatar_middle.jpg
        return $dir1 . '/' . $dir2 . '/' . $dir3 . '/' . substr($uid, -2) . '_avatar_%s.jpg';
    }

}

?>
