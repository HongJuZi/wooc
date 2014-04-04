<?php 

//开启session
session_start();

//定义执行标示
@define('_HEXEC', 1);
//定义应用的根目录，并把windows里的\转换成/末尾以“/dir/subdir/”结尾
@define('ROOT_DIR', strtr(dirname(__FILE__), array('\\' => '/')) . '/');
//导入HongJuZi框架入口文件
require(ROOT_DIR . '/hongjuzi/hongjuzi.php');

//运行应用
//要做的工作：
//1. 加载配置
//2. 加载路由解析对象
//3. 调用路由的解析
//4. 把对应的调用交给路:
HApplication::run();

?>
