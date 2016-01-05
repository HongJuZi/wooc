<?php

/**
 * @version $Id$
 * @create 2013/10/13 12:51:32 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

/**
 * 错误控制类
 *
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package app.public.action
 * @since 1.0.0
 */
class ErrorAction extends HAction
{

    /**
     * 没有找到对应的文件或网址不存在
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function notfound()
    {
        $this->_render('404');
    }

    /**
     * 正在维护
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     */
    public function fixing()
    {
        $this->_render('fixing');
    }

}
