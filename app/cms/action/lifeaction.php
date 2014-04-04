<?php 

/**
 * @version $Id$
 * @create 2013-8-6 10:20:09 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.cms.action.articleaction');

/**
 * 关于我们信息类
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.cms.action
 * @since 1.0.0
 */
class LifeAction extends ArticleAction
{

    /**
     * 构造函数
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $this->_identifier    = 'life';
        $this->_popo->modelZhName   = '营地生活';
    }

    /**
     * {@inheritDoc}
     */
    public function name()
    {
        parent::_name();
        HResponse::setAttribute('identifier', $this->_identifier);

        $this->_render('introduce-detail');
    }
    
    /**
     * 覆盖父类
     */
    public function _detail(){
    	HVerify::isRecordId(HRequest::getParameter('id'));
        $this->_record('`id` = ' . HRequest::getParameter('id'));
        HResponse::setAttribute('identifier', $this->_identifier);
        $this->_render('life-detail');
    }

}

?>
