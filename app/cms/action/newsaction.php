<?php

/**
 * @version			$Id$
 * @create 			2012-10-29 15:10:57 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import('app.cms.action.articleaction');

/**
 * 新闻文章的动作类 
 * 
 * 主要处理主页的相关请求动作 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		app.cms.action
 * @since 			1.0.0
 */
class NewsAction extends ArticleAction
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
        parent::__construct();
        $this->_identifier    = 'news';
        $this->_popo->modelZhName   = '新闻中心';
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
