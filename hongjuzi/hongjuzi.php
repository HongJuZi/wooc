<?php 

/**
 * @version			$Id$
 * @create 			2012-5-12 17:36:11 By xjiujiu
 * @package 		hongjuzi
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 * HongJuZi Framework
 */

/*********************系统环境配置开始*********************/
//配置错误信息
@error_reporting(E_ALL & ~E_NOTICE); //E_ALL & ~E_NOTICE | 0
@ini_set('display_errors', 'On'); //On | Off
//定义路径，跟系统路径分隔符的快捷符号
define('DS', '/'); //DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
//配置超时时间
!ini_get('safe_mode') ? set_time_limit(25) : ''; //设置最大的执行时间

//定义网站根目录路径
$loc    = strpos($_SERVER['REQUEST_URI'], 'index.php');
$loc    = false === $loc ? strpos($_SERVER['REQUEST_URI'], '?') : $loc;
@define(
    'SITE_URL',
    'http://' . $_SERVER['HTTP_HOST'] 
    . (false === $loc ?  $_SERVER['REQUEST_URI'] : substr($_SERVER['REQUEST_URI'], 0, $loc))
);
/*********************系统环境配置结束*********************/

/*********************框架环境配置开始*********************/
//定义HongJuZi框架目录
@define('HPATH_BASE', dirname(__FILE__) . '/..');
//把框架目录放到系统环境路径里
@ini_set('include_path', ini_get('include_path') . PS . HPATH_BASE);
/*********************框架环境配置结束*********************/

/*********************框架基础文件导入开始*********************/
require('hongjuzi/core/hobject.php');
require('hongjuzi/filesystem/hclass.php');
require('hongjuzi/exception/hexceptions.php');
require('hongjuzi/filesystem/hfile.php');
require('hongjuzi/language/hlanguage.php');
require('hongjuzi/log/hlog.php');
require('hongjuzi/utils/hstring.php');
require('hongjuzi/utils/hverify.php');
require('hongjuzi/utils/harray.php');
require('hongjuzi/utils/hpopohelper.php');
require('hongjuzi/utils/hsqlhelper.php');
require('hongjuzi/net/hsession.php');
require('hongjuzi/net/hrequest.php');
require('hongjuzi/net/hresponse.php');
require('hongjuzi/core/happlication.php');
require('hongjuzi/core/hpopo.php');
require('hongjuzi/core/hrouter.php');
require('hongjuzi/mvc/hmodel.php');
require('hongjuzi/mvc/haction.php');
/*********************框架基础文件导入结束*********************/

//设置错误信息舞控制对象
set_error_handler('HObject::errorHandler');?>
