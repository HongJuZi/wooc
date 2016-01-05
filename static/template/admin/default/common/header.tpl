<!DOCTYPE html>
<html lang="en">
	<head>
    <meta http-equiv="X-UA-Compatible" content="IE=8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
    <?php 
        $siteCfg        = HSession::getAttributeByDomain('siteCfg'); 
        $popo           = HResponse::getAttribute('popo'); 
        $modelZhName    = $popo->modelZhName; 
        $modelEnName    = $popo->modelEnName; 
        $langList       = HResponse::getAttribute('lang_id_list');
        $langMap        = HResponse::getAttribute('lang_id_map');
        $modelCfg       = HResponse::getAttribute('modelCfg');
    ?>
    <title><?php echo !HResponse::getAttribute('title') ? $siteCfg['name'] : HResponse::getAttribute('title') . '-' . $siteCfg['name'];?><?php HTranslate::_('后台管理平台'); ?></title>
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
    <link href="<?php echo HResponse::uri('cdn'); ?>bootstrap/v2/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo HResponse::uri('cdn'); ?>bootstrap/v2/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo HResponse::url(); ?>vendor/font/font-awesome/v3/css/font-awesome.min.css" />
    <!--[if IE 7]>
      <link rel="stylesheet" href="<?php echo HResponse::uri('cdn'); ?>/font/font-awesome/v3/css/font-awesome-ie7.min.css" />
      <link href="http://cdn.staticfile.org/font-awesome/3.2.1/css/font-awesome-ie7.min.css" rel="stylesheet">
    <![endif]-->
    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo HResponse::uri(); ?>css/ace.css" />
    <link rel="stylesheet" href="<?php echo HResponse::uri(); ?>css/ace-responsive.min.css" />
    <link rel="stylesheet" href="<?php echo HResponse::uri(); ?>css/ace-skins.min.css" />
    <!--[if lt IE 9]>
    <link rel="stylesheet" href="<?php echo HResponse::uri(); ?>/css/ace-ie.min.css" />
    <![endif]-->
    <link rel="stylesheet" href="<?php echo HResponse::uri('cdn') . 'webuploader/webuploader.css'; ?>" />
    <link rel="stylesheet" href="<?php echo HResponse::uri(); ?>css/style.css" />
    <script type="text/javascript">
        var dateList    = [];
        var selectList  = [];
        var datetimeList= [];
        var editorList  = [];
        var tagList     = [];
        var codeEditorList      = [];
        var treeCheckboxList    = [];
        var siteUrl     = '<?php echo HResponse::url(); ?>';
        var queryUrl    = '<?php echo HResponse::url(); ?>index.php/';
        var cdnUrl      = '<?php echo HResponse::uri('cdn'); ?>';
        var siteUri     = '<?php echo HResponse::uri(); ?>';
        var modelEnName = '<?php echo $modelEnName; ?>';
        var formData    = {};
        var langMap     = <?php echo json_encode($langMap, JSON_UNESCAPED_UNICODE); ?>;
    </script>
    <script type="text/javascript" src="http://libs.baidu.com/jquery/1.7.2/jquery.min.js"></script>
    <script type="text/javascript">
        if (!window.jQuery) {
            var script = document.createElement('script');
            script.src = cdnUrl + "/jquery/jquery.js";
            document.body.appendChild(script);
        }
    </script>
    <script type='text/javascript' src="<?php echo HResponse::uri('cdn');?>/zeroclipboard/ZeroClipboard.js"></script>
    <script type="text/javascript" src="<?php echo HResponse::uri('cdn'); ?>/webuploader/webuploader.min.js"></script>
    <script type='text/javascript' src="<?php echo HResponse::uri('cdn');?>/js/md5.min.js"></script>
    <script type='text/javascript' src="<?php echo HResponse::uri('cdn');?>/requirejs/require.js"></script>
    <script type='text/javascript' src="<?php echo HResponse::uri('cdn');?>/hhjslib/hhjslib.min.js"></script>
    <script type="text/javascript">
        HHJsLib.curLang = '<?php echo HSession::getAttribute('identifier', 'lang'); ?>';
    </script>
