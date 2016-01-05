<?php 
/*请设置“{site_url}”的配置信息*/

return array (
  'DEF_APP' => 'cms',
  'DATABASE' => 
  array (
    'tablePrefix' => 'xxx_',
    'dbHost' => 'xxx.xxx.xxx.xxx',
    'dbPort' => '3306',
    'dbType' => 'mysql',
    'dbDriver' => 'mysqli',
    'dbCharset' => 'utf8',
    'dbName' => 'xxxx',
    'dbUserName' => 'xxxxx',
    'dbUserPassword' => 'xxxx',
  ),
  'STATIC_URL' => '{site_url}',
  'CDN_URL' => '{site_url}vendor/',
  'SALT' => '{salt}',
  'TIME_ZONE' => 'Asia/Shanghai',
  'RES_DIR' => 'static/uploadfiles/sites/{site}/'
); ?>
