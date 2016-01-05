<?php 
/*请设置“http://localhost/hjz-taobaoke/”的配置信息*/
return array (
  'DEF_APP' => 'cms',
  'DATABASE' => 
  array (
    'tablePrefix' => 'hjz_', //
    'dbHost' => '172.28.138.70', //
    'dbPort' => '3306',
    'dbType' => 'mysql',
    'dbDriver' => 'mysqli',
    'dbCharset' => 'utf8',
    'dbName' => 'hjz_wooc_demo', //
    'dbUserName' => 'xyrj_remote', //
    'dbUserPassword' => 'xyrj123456', //
  ),
  'STATIC_URL' => 'http://localhost/hjz-wooc-demo/',
  'CDN_URL' => 'http://localhost/hjz-wooc-demo/vendor/',
  'SALT' => '3b009cae55f3487ea5c703e7a44bdfb6',
  'TIME_ZONE' => 'Asia/Shanghai',
  'RES_DIR' => 'static/uploadfiles/sites/localhosthjz-wooc-demo/'
); ?>
