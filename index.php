<?php 

//配置错误信息
@error_reporting(E_ALL & ~E_NOTICE); //E_ALL & ~E_NOTICE | 0
@ini_set('display_errors', 'On'); //On | offset

//定义执行标示
@define('_HEXEC', 1);
//定义应用的根目录，并把windows里的\转换成/末尾以“/dir/subdir/”结尾
@define('ROOT_DIR', dirname(__FILE__) . '/');
//定义HongJuZi框架目录
@define('HJZ_DIR', ROOT_DIR . 'hongjuzi/');

//导入HongJuZi框架入口文件
require(HJZ_DIR . 'hongjuzi.php');

//运行应用
//要做的工作：
//1. 加载配置
//2. 加载路由，调用路由的解析
//3. 完成应用初始化
//4. 把动作执行交给目标控制器 
HApplication::run();

?>
