<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import(HResponse::getCurThemePath() . '.action.defaultAction');
HClass::import('config.popo.messagepopo, model.messagemodel');

/**
 * 留言本
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package demo.action
 * @since 1.0.0
 */
class MessageAction extends DefaultAction
{

    /**
     * 初始化数据
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    public function __construct()
    {
        parent::__construct();
        $this->_popo    = new MessagePopo();
        $this->_model   = new MessageModel($this->_popo);
    }

    /**
     * 首页方法
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function index()
    {
        $this->_assignContactInfo();
        $this->_commAssign();

        $this->_render('message');
    }

    /**
     * 提交留言内容
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function post()
    {
        HVerify::isEmpty(HRequest::getParameter('name'), '姓名');
        HVerify::isPhone(HRequest::getParameter('phone'));
        HVerify::isEmail(HRequest::getParameter('email'));
        HVerify::isStrLen(HRequest::getParameter('content'), '留言内容', 6, 255);
        $data   = array(
            'name' => HRequest::getParameter('name'),
            'phone' => HRequest::getParameter('phone'),
            'email' => HRequest::getParameter('email'),
            'content' => HRequest::getParameter('content'),
            'ip' => HRequest::getClientIp(),
            'author' => 0
        );
        if(1 > $this->_model->add($data)) {
            throw new HRequestException('留言失败，请您稍后再试！');
        }

        HResponse::succeed('留言成功，我们正在为您处理...', HResponse::url('message'));
    }

}

?>
