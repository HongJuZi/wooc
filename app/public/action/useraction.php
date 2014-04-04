<?php

/**
 * @version			$Id$
 * @create 			2013-11-17 18:11:51 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.userpopo, app.public.action.publicaction, model.usermodel');

/**
 * 用户扩展信息处理的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.public.action
 * @since 			1.0.0
 */
class UserAction extends PublicAction
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
        $this->_popo    = new UserPopo();
        $this->_model   = new UserModel($this->_popo);
    }

    /**
     * 用户信息更新
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aupdate()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('name'), '用户名');
        HVerify::isEmail(HRequest::getParameter('email'), '邮箱地址');
        HVerify::isPhone(HRequest::getParameter('phone'), '电话号码');
        HRequest::setParameter('id', HSession::getAttribute('id', 'user'));
        if(1 > $this->_model->edit(HPopoHelper::getUpdateFieldsAndValues($this->_popo))) {
            throw new HRequestException('服务器繁忙，更新信息失败，请您稍后再试～');
        }
        $userInfo   = $this->_model->getRecordById(HSession::getAttribute('id', 'user'));
        foreach($userInfo as $field => $info) {
            HSession::setAttributeByDomain($field, $info, 'user');
        }
        HResponse::json(array('rs' => true));
    }

    /**
     * 保存头像
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function saveavatar()
    {
        try {
            if(empty($_FILES)) {
                throw new HVerifyException('头像不能为空～');
            }
            //定义一个变量用以储存当前头像的序号
            $key                = 'path';
            $maxSize            = 0.1 * 1024 * 1024; //单位Bytes 100k
            $type               = array('.jpg', '.png', '.gif');
            $avatarPathPrefix   = HFile::getAvatarPathByUserIdPrefix(HSession::getAttribute('id', 'user'));
            //遍历所有文件域
            if($_FILES[$key]['error'] > 0) {
                throw new HVerifyException('文件信息不正确，请重新选择！');
            }
            if($maxSize < $_FILES[$key]['size']) {
                throw new HVerifyException('头像文件太大！');
            }
            if(!in_array(HFile::getExtension($_FILES[$key]['name']), $type)) {
                throw new HVerifyException('头像文件类型不对！');
            }
            $filePath   = HObject::GC('RES_DIR') . '/user/' . $avatarPathPrefix . '1.jpg';
            HClass::import('hongjuzi.filesystem.hdir');
            HDir::create(dirname($filePath));
            if(!move_uploaded_file($_FILES[$key]['tmp_name'], ROOT_DIR . $filePath)) {
                throw new HVerifyException('上传失败，服务器繁忙～');
            }
            HSession::setAttribute('image_path', $filePath, 'user');
            HResponse::json(array('rs' => true, 'path' => $filePath));
        } catch(Exception $ex) {
            HResponse::json(array('rs' => false, 'message' => $ex->getMessage()));
        }
    }

    /**
     * 异步修改密码
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aresetpwd()
    {
        HVerify::isAjax();
        HVerify::isStrLen(HRequest::getParameter('old_password'), '原始密码', 6, 20);
        HVerify::isStrLen(HRequest::getParameter('password'), '新密码', 6, 20);
        HVerify::isStrLen(HRequest::getParameter('repassword'), '确认新密码', 6, 20);
        if(HRequest::getParameter('repassword') != HRequest::getParameter('password')) {
            throw new HVerifyException('两次新密码不一致！');
        }
        $newPwd     = md5(HRequest::getParameter('password'));
        if(HSession::getAttribute('password', 'user') != $newPwd) {
            throw new HVerifyException('原始密码不正确！');
        }
        $data       = array(
            'id' => HSession::getAttribute('id', 'user'),
            'password' => $newPwd 
        );
        if(!$this->_model->edit($data)) {
            throw new HRequestException('服务器繁忙，请您稍后再试～');
        }
        HSession::setAttribute('password', $newPwd, 'user');
        HResponse::json(array('rs' => true));
    }

}

?>
