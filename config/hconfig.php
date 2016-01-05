<?php return array (
  'DEF_APP' => 'cms',
  'OPEN_SHORT_URL' => false,
    //数据库配置
  'DATABASE' => 
  array (
    'tablePrefix' => 'hjz_',
    'dbHost' => '172.28.138.70',
    'dbPort' => '3306',
    'dbType' => 'mysql',
    'dbDriver' => 'mysqli',
    'dbCharset' => 'utf8',
    'dbName' => 'hjz_wooc_demo',
    'dbUserName' => 'xyrj_remote',
    'dbUserPassword' => 'xyrj123456',
),
//邮件配置
  'MAIL' => 
  array (
    'charset' => 'UTF-8',
    'mailMethod' => 'smtp',
    'mailHost' => 'smtp.163.com',
    'mailPort' => '25',
    'mailUserName' => 'smengxiaomeng@163.com',
    'mailUserPasswd' => 'xiaomengku',
    'mailFromEmail' => 'smengxiaomeng@163.com',
    'mailFromName' => '红橘子客服邮箱',
    'mailReplyEmail' => 'smengxiaomeng@163.com',
    'mailReplyName' => 'smengxiaomeng@163.com'
),
  'WECHAT' => array(
      'name' => '',
      'appid' => '',
      'secret' => ''
  ),
  //静态资源访问链接
  'STATIC_URL' => 'http://localhost/hjz-wooc-demo/',
  //加速资源访问链接
  'CDN_URL' => 'http://localhost/hjz-wooc-demo/vendor/',
  'CUR_THEME' => 'ace',
  'COOKIE_ENCODE' => 'SDFL@@#@SDF',
  'TIME_ZONE' => 'Asia/Shanghai',
  'PAGE_STYLE' => 'bootstrap',
  'URL_MODE' => 'pathinfo',
  'VENDOR_DIR' => 'vendor',
  'RUNTIME_DIR' => 'runtime',
  'CONFIG_TPL' => 'config/config.tpl',
  'TPL_DIR' => 'static/template',
  'RES_DIR' => 'static/uploadfiles/sites/localhost/',
  'LOG' => 
  array (
    'dir' => 'runtime/log',
    'size' => 50,
    'method' => 
    array (
      'file' => 'error, wran',
    ),
    'tpl' => 'public/template/common/email-log.tpl',
  ),
  'RSS_TTL' => '120',
  'SYS_NAME' => 'Wooc-红橘子科技',
  'SYS_VERSION' => '1.0.0',
  'DEBUG' => false,
); ?>
