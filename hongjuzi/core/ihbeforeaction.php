<?php

/**
 * @version			$Id$
 * @create 			2012-5-20 16:46:56 By xjiujiu
 * @package 		hongjuzi.core
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */

/**
 * 执行动作之前执行的操作规则接口 
 * 
 * 实现此接口的类，在执行对应的动作之前就必须先执行此接口里所定义的方法 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.core
 * @since 			1.0.0
 */
interface IHBeforeAction
{

    /**
     * 在所有动作执行之前调用的方法 
     * 
     * 如检测用户是否已经登陆等 
     * 
     * @access public
     * @return void
     * @exception none
     */
    function beforeAction();
}

?>
