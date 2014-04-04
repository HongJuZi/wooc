<?php

/**
 * @version			$Id$
 * @create 			2012-04-21 11:04:10 By xjiujiu
 * @description     HongJuZi Framework
 * @copyRight 		Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
defined('_HEXEC') or die('Restricted access!');

return array (
  'DEFAULT_APP' => 'cms',
  'DATABASE' => 
  array (
    'tablePrefix' => 'hjz_',
    //'dbHost' => '172.28.138.234',
    'dbHost' => 'localhost',
    'dbPort' => '3306',
    'dbType' => 'Mysql',
    'dbDriver' => 'mysqli',
    'dbCharset' => 'utf8',
    'dbName' => 'hjz_cms',
    'dbUserName' => 'xyrj_remote',
    'dbUserPassword' => 'xyrj123456'
  ),
  'MAIL' => 
  array (
    'charset' => 'UTF-8',
    'mailMethod' => 'gmail',
    'mailHost' => 'smtp.gmail.com',
    'mailPort' => '465',
    'mailUserName' => 'xjiujiukf@gmail.com',
    'mailUserPasswd' => 'xjiujiu89',
    'mailFromEmail' => 'admin@hongjuzi.com',
    'mailFromName' => '九九',
    'mailReplyEmail' => 'xjiujiu@foxmail.com',
    'mailReplyName' => '九九'
  ),
  //'CDN_URL' => 'http://cdn.hongjuzi.net',
  'CDN_URL' => 'http://localhost/hjz-cms/vendor',
  'ADMIN_EMAIL' => 'xjiujiu@foxmail.com',
  'COOKIE_ENCODE' => 'xyrj',
  'TIME_ZONE' => 'Asia/Shanghai',
  'PAGE_STYLE' => 'bootstrap',
  'CUR_THEME' => 'default',
  'URL_MODE' => 'pathinfo',
  'VENDOR_DIR' => 'vendor',
  'RUNTIME_DIR' => 'runtime',
  'TPL_DIR' => 'static/template',
  'RES_DIR' => 'static/uploadfiles',
  'FONTS' => 
  array (
    'monaco' => 
    array (
      'path' => '/resource/fonts/monaco.ttf',
      'space' => 4,
    ),
    'fangzhenzhongqian' => 
    array (
      'path' => '/resource/fonts/fangzhenzhongqian.ttf',
      'space' => 1,
    ),
  ),
  'MASK_ITEM' => 
  array (
    'font' => 'fangzhenzhongqian',
    'size' => 16,
  ),
'LOG' => array(
    'dir' => 'runtime/log',  //存储目录
    'size' => 50,                   //归档文件大小,单位MB
    'method' => array(              //日志方式配置
        //'page' => 'info, notice, error, wran',
        'file' => 'error, wran',
        //'email' => 'error'
    ),
    'tpl' =>'public/template/common/email-log.tpl',
),
  'RSS_TTL' => '120',
  'PROTACL_MASK' => '|',
  'SYS_NAME' => '红橘子',
  'SYS_VERSION' => '1.0.0',
  'STATIC_VERSION' => '20131213',
  'INSTALL' => 2,
  'DEBUG' => false
);

?>
