<?php

/**
 * @version			$Id$
 * @create 			2013-12-06 15:12:17 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.syncpopo, app.public.action.publicaction, model.syncmodel');

/**
 * 第三方同步的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.public.action
 * @since 			1.0.0
 */
class SyncAction extends PublicAction
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
        $this->_popo    = new SyncPopo();
        $this->_model   = new SyncModel($this->_popo);
    }

    /**
     * 取消同步绑定
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function unbind()
    {
        HVerify::isRecordId(HRequest::getParameter('id'), '同步类型');
        $syncInfo   = $this->_model->getRecordByWhere(
            '`type` = ' . HRequest::getParameter('id') . 
            ' AND `parent_id` = ' . HSession::getAttribute('id', 'user')
        );
        if(!$syncInfo) {
            throw new HVerifyException('您还没有绑定过此类型的账号，请确认！');
        }
        $data       = array(
            'id' => $syncInfo['id'],
            'sync' => '2',
            'author' => HSession::getAttribute('id', 'user')
        );
        if(1 > $this->_model->edit($data)) {
            throw new HRequestException('解除绑定失败，请您稍后再试～');
        }
        HResponse::alertAndJump('解除绑定成功～', HResponse::url('user', '', $this->_getReferenceApp(1)));
    }

}

?>
