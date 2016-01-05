<!DOCTYPE html>
<html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <?php $record   = HResponse::getAttribute('record');?>
    <title>模板预览-<?php echo $record['name']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="description" content="<?php echo $record['description']; ?>">
    <meta name="keywords" content="<?php echo $record['tags']; ?>">
    <link href="<?php echo HResponse::uri(); ?>/theme/assets/css/demo.css" media="screen" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo HResponse::uri(); ?>/theme/assets/css/pace-theme-barber-shop.css">
    <style type="text/css">
        body { padding-top: 16px; }
    </style>
    <!--[if IE]>
    <style type="text/css">
      li.purchase a {
          padding-top: 5px;
          background-position: 0px -4px;
      }
      
      li.remove_frame a {
          padding-top: 5px;
          background-position: 0px -3px;
      }  
    </style>
    <![endif]-->
    <script type="text/javascript">
      var txt = 'http://www.hongjuzi.net'
      window.g1=txt.substr(0,3)
      window.g2=txt.substr(0,20)
    </script>
    <script src="<?php echo HResponse::uri(); ?>/theme/assets/js/jquery.min.js"></script>
    <script src="<?php echo HResponse::uri(); ?>/theme/assets/js/pace.min.js"></script>
    <script src="<?php echo HResponse::uri(); ?>/theme/assets/js/demo.js"></script>
  </head>
  <body id="by" style="overflow-y: auto;" class=" pace-done"><div class="pace  pace-inactive"><div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
  <div class="pace-progress-inner"></div>
</div>
<div class="pace-activity"></div></div>
    <div id="switcher">
      <div class="center">
        <ul>
          <div id="Device">
            <li class="device-monitor">
              <a href="javascript:">
                <div class="icon-monitor active"></div>
              </a>
            </li>
            <li class="device-mobile">
              <a href="javascript:">
                <div class="icon-tablet"></div>
              </a>
            </li>
            <li class="device-mobile">
              <a href="javascript:">
                <div class="icon-mobile-1"></div>
              </a>
            </li>
            <li class="device-mobile-2">
              <a href="javascript:">
                <div class="icon-mobile-2"></div>
              </a>
            </li>
            <li class="device-mobile-3">
              <a href="javascript:">
                <div class="icon-mobile-3"></div>
              </a>
            </li>
            <li class="logoTop"><?php echo $record['name']; ?></li>
            <li class="remove_frame">
              <a href="<?php echo HResponse::url('theme');?>" title="关闭并返回模板主页"></a>
            </li>
          </div>
        </ul>
      </div>
    </div>
    <div id="iframe-wrap" class="device-monitor">
      <iframe id="iframe" src="<?php echo HResponse::url('', 'theme=' . $record['identifier'], 'cms'); ?>" frameborder="0" width="100%" height="645px"></iframe>
    </div>
  	<div style="display: none;"><script src="http://s9.cnzz.com/stat.php?id=5679288&web_id=5679288" language="JavaScript"></script></div>
	</body>
</html>
