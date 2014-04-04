<?php

/**
 * @version $Id$
 * @create 2014/3/24 21:40:39 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('config.popo.messagepopo,app.cms.action.articleaction,model.messagemodel');

/**
 * 联系方式的动作类
 * 
 * 主要处理联系方式的相关请求动作 
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package None
 * @since 1.0.0
 */
class MessageAction extends ArticleAction
{

    /**
     * @var String $_identifier分类名称
     */
    protected $_identifier;

    /**
     * 构造方法
     * 
     * 初始化类里面的变量
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        $this->_popo    = new MessagePopo();
        $this->_model   = new MessageModel($this->_popo);
        $this->_identifier      = 'message';
        $this->_popo->modelZhName   = '联系方式';
    }

    /**
     * 加载联系方式详细信息
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    public function index()
    {
        $this->_assignSeoInfo();
        $this->_assignSiteConfig();
        $this->_commAssign();
        $this->_assignContent();

        $this->_render('message-detail');
    }

    /**
     * 加载详细内容
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access protected
     */
    protected function _assignContent()
    {
        $category       = HClass::quickLoadModel('category');
        $categoryRecord = $category->getRecordByIdentifier('message');
        HResponse::setAttribute('message', $this->_model->getSomeRows(1, HSqlHelper::whereInByListMap('parent_id', 'id', array($categoryRecord['id']))));
    }
}
?>
