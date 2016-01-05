<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

//导入引用文件
HClass::import(HResponse::getCurThemePath() . '.action.pageAction');

/**
 * 关于我们单页
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package demo.action
 * @since 1.0.0
 */
class AboutusAction extends PageAction
{

    /**
     * 初始化 
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    public function __construct()
    {
        parent::__construct();

        $this->_identifier  = 'about-us';
    }

    /**
     * 加载其他任务
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    protected function _otherJobs()
    {
        parent::_otherJobs();
        $this->_assignContactInfo();
    }

}

?>
