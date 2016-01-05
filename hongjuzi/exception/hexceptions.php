<?php

/**
 * @version			$Id: HIOException.php 1859 2012-05-20 04:47:19Z xjiujiu $
 * @create 			2012-3-29 16:29:12 By xjiujiu
 * @package 		hongjuzi
 * @subpackage 		exception
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */
defined('HJZ_DIR') or die();

/**
 * IO操作异常类 
 * 
 * 当出现如读取，写入文件，文件夹的失败操作时，就可以抛出此异常 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.exception
 * @since 			1.0.0
 */
class HIOException extends Exception { public $status = 500; }

/**
 * 没有找到对应对象或是方法的异常
 * 
 * 如，实例化一个类，或是调用类的方法与之对应的内容没有实现等
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package hongjuzi.exception 
 * @since 1.0.0
 */
class HNotFoundException extends Exception { public $status = 404; }

/**
 * 用户请求异常 
 * 
 * 用户异常请求，都会抛出些异常 
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package hongjuzi.exception 
 * @since 1.0.0
 */
class HRequestException extends Exception { public $status = 501; }

/**
 * Sql解析异常 
 * 
 * Sql出现解析错误则抛出此异常 
 * 
 * @author 			xjiujiu <xjiujiu@foxmail.com>
 * @package 		hongjuzi.exception
 * @since 			1.0.0
 */
class HSqlException extends Exception { public $status = 300; }

/**
 * 验证异常类 
 * 
 * 所有验证出错的信息都要抛出此异常 
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package hongjuzi.exception 
 * @since 1.0.0
 */
class HVerifyException extends exception { public $status = 301; }

?>
