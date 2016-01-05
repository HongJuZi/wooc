<?php

/**
 * @version			$Id$
 * @create 			2013-11-09 21:11:44 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('config.popo.commentpopo, app.public.action.publicaction, model.commentmodel');

/**
 * 评论的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.public.action
 * @since 			1.0.0
 */
class CommentAction extends PublicAction
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
        $this->_popo    = new CommentPopo();
        $this->_model   = new CommentModel($this->_popo);
    }

    /**
     * 提交评论信息
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function apost()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('name'), '昵称');
        HVerify::isEmpty(HRequest::getParameter('email'), '邮箱');
        HVerify::isEmpty(HRequest::getParameter('content'), '内容');
        HVerify::isEmpty(HRequest::getParameter('item_id'), '评论资源');
        HVerify::isEmpty(HRequest::getParameter('model'), '当前模块');
        HRequest::setParameter('ip', HRequest::getClientIp());
        HRequest::setParameter('parent_id', 0);
        HRequest::setParameter('author', 0);
        if(1 > $this->_model->add(HPopoHelper::getAddFieldsAndValues($this->_popo))) {
            throw new HRequestException('添加评论失败，请您稍后再试！');
        }
        HResponse::json(
            array(
                'rs' => true, 
                'data' => array(
                    'hash' => md5(HRequest::getParameter('email')), 
                    'create_time' => date('Y-m-d H:m:s')
                )
            )
        );
    }

    /**
     * 加载对应的评论列表
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function aload()
    {
        HVerify::isAjax();
        HVerify::isEmpty(HRequest::getParameter('item_id'), '评论资源');
        HVerify::isEmpty(HRequest::getParameter('model'), '当前模块');
        $where  = '`item_id` = ' . HRequest::getParameter('item_id')
            . ' AND `model` = \'' . HRequest::getParameter('model') . '\'';

        HResponse::json(array('rs' => true, 'data' => $this->_model->getAllRows($where)));
    }

}

?>
