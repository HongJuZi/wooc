<?php 

/**
 * @version $Id$
 * @create 2012-9-29 17:58:42 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('HJZ_DIR') or die();

/**
 * 表单验证类接口 
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package hongjuzi.core
 * @since 1.0.0
 */
interface IHForm
{

    /**
     * 验证方法 
     * 
     * 执行当前的验证操作 
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @access public
     * @return void
     * @throws HVerifyException 
     */
    function validate();
}

?>
