<?php

/**
 * @version			$Id$
 * @create 			2012-5-20 16:55:39 By xjiujiu
 * @package 		None
 * @subpackage 		None
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */

/**
 * 控制层类执行动作之后需要执行动作的接口 
 * 
 * 实现此接口的类，在完成对应的动作执行之后，会执行此
 * 接口定义的afterAction方法 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.core
 * @since 			1.0.0
 */
interface IHAfterAction
{

    /**
     * 完成用户请求动作之后执行的操作 
     * 
     * 可以完成如日志记录之类的后续操作 
     * 
     * @access public
     * @return void
     * @exception none
     */
    function afterAction();
}

?>
