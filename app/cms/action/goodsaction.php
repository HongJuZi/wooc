<?php

/**
 * @version $Id$
 * @create 2014/3/24 17:40:55 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.cms.action.articleaction');

/**
 * 产品信息的动作类
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package None
 * @since 1.0.0
 */
class GoodsAction extends ArticleAction
{

    /**
     * 构造函数
     * 
     * 初始化类里面的变量
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $this->_identifier    = 'goods';
        $this->_popo->modelZhName   = '产品展示';
    }

    /**
     * 加载完必要内容后，执行其它的任务
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    protected function _otherJobs()
    {
        $this->_assignCatList();
    }

    /**
     * {@inheritDoc}
     */
    public function type()
    {
        parent::_type(9);
        $this->_assignCatList();
        
        $this->_render('goods-list');
    }

}
?>
