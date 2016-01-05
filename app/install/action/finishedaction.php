<?php 

/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

HClass::import('app.install.action.installaction');

/**
 * 完成类
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.install.action
 * @since 1.0.0
 */
class FinishedAction extends InstallAction
{

    /**
     * 前驱
     * 
     * {@inheritdoc}
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     */
    public function beforeAction()
    {
        if(!file_exists(ROOT_DIR . '/config/install.lock')) {
            HResponse::warn('程序还没有安装成功，请重新安装！', HResponse::url('install'));
        }
    }

    /**
     * 初始化首页
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function index()
    {
        $this->_render('finished');
    }

}

?>
