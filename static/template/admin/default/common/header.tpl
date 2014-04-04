<!DOCTYPE html>
<html lang="en">
	<head>
    <meta http-equiv="X-UA-Compatible" content="IE=8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
    <?php $siteCfg  = HResponse::getAttribute('siteCfg'); ?>
	<title>红橘子<?php HResponse::lang('ADMIN_MANAGEMENT'); ?></title>
    <meta name="keywords" content="<?php echo $siteCfg['site_keywords'];?>">
    <meta name="description" content="<?php echo $siteCfg['site_desc'];?>">
    <meta name="author" content="红橘子信息技术工作室">
    <meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="icon" href="/favicon.png" type="image/gif">
    <meta name="robots" content="No" />
    <meta name="Identifier-URL" content="http://xyrj.hhtc.edu.cn, http://www.hongjuzi.net" />
    <link rel="Bookmark" href="/favicon.ico" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="<?php echo HResponse::uri('cdn'); ?>/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo HResponse::uri('cdn'); ?>/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo HResponse::uri('admin'); ?>/css/font-awesome.min.css" />

    <!--[if IE 7]>
      <link rel="stylesheet" href="<?php echo HResponse::uri('admin'); ?>/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo HResponse::uri('admin'); ?>/css/ace.min.css" />
    <link rel="stylesheet" href="<?php echo HResponse::uri('admin'); ?>/css/ace-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo HResponse::uri('admin'); ?>/css/ace-skins.min.css" />
    <!--[if lt IE 9]>
      <link rel="stylesheet" href="<?php echo HResponse::uri('admin'); ?>/css/ace-ie.min.css" />
    <![endif]-->
    <link rel="stylesheet" href="<?php echo HResponse::uri('admin'); ?>/css/style.css" />
    <?php 
        $popo           = HResponse::getAttribute('popo'); 
        $modelEnName    = $popo->modelEnName;
        $modelZhName    = $popo->modelZhName;
    ?>
    <script src="<?php echo HResponse::uri('cdn'); ?>/jquery/jquery.js"></script>
    <script type='text/javascript' src="<?php echo HResponse::uri('cdn');?>/hhjslib/hhjslib.js"></script>
    <script type='text/javascript' src="<?php echo HResponse::uri('cdn');?>/hhjslib/hhjslib.hhfile.js"></script> 
    <script type='text/javascript' src="<?php echo HResponse::uri('cdn');?>/hhjslib/hhjslib.hhdialog.js"></script>
    <script type='text/javascript' src="<?php echo HResponse::uri('cdn');?>/hhjslib/hhjslib.hhutils.js"></script>
    <script type="text/javascript">
        var editorList  = [];
        var codeEditorList  = [];
        var siteUrl     = '<?php echo HResponse::url(); ?>';
        var siteUri     = '<?php echo HResponse::uri(); ?>';
        var queryUrl    = '<?php echo HResponse::url(); ?>index.php/';
        var cdnUrl      = '<?php echo HResponse::uri('cdn'); ?>';
        var modelEnName = '<?php echo $modelEnName; ?>';
        HHJsLib.curLang = '<?php echo HSession::getAttribute('lang_type', 'website'); ?>';
    </script>
    <script type='text/javascript' src="<?php echo HResponse::uri('admin');?>/js/hjz-extend.js"></script>
    <script type='text/javascript' src="<?php echo HResponse::uri('admin');?>/js/common.js"></script>
