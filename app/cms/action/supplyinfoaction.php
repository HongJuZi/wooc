<?php

/**
 * @version $Id$
 * @create 2014/3/25 21:36:45 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.cms.action.articleaction');

/**
 * 供求信息动作类
 * 
 * 主要处理主页的相关请求动作
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package None
 * @since 1.0.0
 */
class SupplyinfoAction extends ArticleAction
{

    /**
     * 构造函数
     * 
     * 初始化类里的变量
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function __construct()
    {
        parent::__construct();
        $this->_identifier  = 'supplyinfo';
        $this->_popo->modelZhName   = '供求信息';
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

}
?>
