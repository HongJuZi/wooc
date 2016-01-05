<!DOCTYPE html>
<html lang="en">
	<head>
    <meta http-equiv="X-UA-Compatible" content="IE=8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
    <?php 
        $langList       = HResponse::getAttribute('lang_id_list');
        $langMap        = HResponse::getAttribute('lang_id_map');
    ?>
    <title>Wooc <?php HTranslate::_('安装程序'); ?></title>
    <meta name="keywords" content="<?php echo $siteCfg['seo_keywords'];?>">
    <meta name="description" content="<?php echo $siteCfg['seo_desc'];?>">
    <meta name="author" content="九九">
    <meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
    <meta name="robots" content="all" />
    <meta name="Identifier-URL" content="http://www.hongjuzi.net" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="/favicon.png" type="image/gif">
    <meta name="robots" content="No" />
    <meta name="Identifier-URL" content="http://www.hongjuzi.net" />
    <link rel="Bookmark" href="/favicon.ico" type="image/x-icon" />
    <!-- basic styles -->
    <link href="<?php echo HResponse::uri(); ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo HResponse::uri(); ?>/assets/css/font-awesome.min.css" />
    <!--[if IE 7]>
      <link rel="stylesheet" href="<?php echo HResponse::uri(); ?>/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo HResponse::uri(); ?>/assets/css/ace.min.css" />
    <link rel="stylesheet" href="<?php echo HResponse::uri(); ?>/assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="<?php echo HResponse::uri(); ?>/assets/css/ace-skins.min.css" />
    <!--[if lte IE 8]>
      <link rel="stylesheet" href="<?php echo HResponse::uri(); ?>/assets/css/ace-ie.min.css" />
    <![endif]-->
    <!-- inline styles related to this page -->
    <!-- ace settings handler -->
    <script src="<?php echo HResponse::uri(); ?>/assets/js/ace-extra.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="<?php echo HResponse::uri(); ?>/assets/js/html5shiv.js"></script>
    <script src="<?php echo HResponse::uri(); ?>/assets/js/respond.min.js"></script>
    <![endif]-->
    <!-- basic styles -->
    <link rel="stylesheet" href="<?php echo HResponse::uri(); ?>/css/style.css" />
    <script type="text/javascript">
        var siteUrl     = '<?php echo HResponse::url(); ?>';
        var queryUrl    = '<?php echo HResponse::url(); ?>index.php/install/';
        var cdnUrl      = '<?php echo HResponse::uri('cdn'); ?>/';
        var siteUri     = '<?php echo HResponse::uri(); ?>/';
        var langMap     = <?php echo json_encode($langMap, JSON_UNESCAPED_UNICODE); ?>;
    </script>
