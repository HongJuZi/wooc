<?php 

/**
 * @version			$Id$
 * @create 			2012-5-12 17:36:11 By xjiujiu
 * @package 		hongjuzi
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */

//开启session
@session_start();

/*********************系统环境配置开始*********************/
/* 初始化设置 */
@ini_set('session.use_trans_sid', 0);
@ini_set('session.use_cookies',   1);
@ini_set('session.auto_start',    0);

//配置超时时间
!ini_get('safe_mode') ? set_time_limit(30) : ''; //设置最大的执行时间
setlocale(LC_ALL, '');
//定义路径，跟系统路径分隔符的快捷符号
define('DS', '/'); //DIRECTORY_SEPARATOR);
define('MEMERY_USAGE', memory_get_usage());
@define('IS_CLI', (substr(php_sapi_name(), 0, 3) == 'cli') ? true : false);
/*********************系统环境配置结束*********************/

/*********************框架环境配置开始*********************/
//把框架目录放到系统环境路径里
@ini_set('include_path', ini_get('include_path') . PS . HJZ_DIR . ';');
/*********************框架环境配置结束*********************/

/*********************框架基础文件导入开始*********************/
require('core/hobject.php');
require('filesystem/hclass.php');
require('exception/hexceptions.php');
require('filesystem/hfile.php');
require('language/htranslate.php');
require('log/hlog.php');
require('utils/hstring.php');
require('utils/hverify.php');
require('utils/harray.php');
require('utils/hpopohelper.php');
require('utils/hsqlhelper.php');
require('net/hsession.php');
require('net/hrequest.php');
require('net/hresponse.php');
require('core/happlication.php');
require('core/hpopo.php');
require('core/hrouter.php');
require('mvc/hmodel.php');
require('mvc/haction.php');
/*********************框架基础文件导入结束*********************/

//设置错误信息舞控制对象
set_error_handler('HObject::errorHandler');?>
