<!DOCTYPE html>
<html>
<head>
    <?php
        $modelZhName    = HResponse::getAttribute('modelZhName');
        $modelEnName    = HResponse::getAttribute('modelEnName');
        $siteCfg        = HSession::getAttributeByDomain('siteCfg');
        $v              = $version = '1.0.4';
        $isLogin        = AuserAction::isLoginedByBool();
    ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="theme-color" content="#2196f3">
    <title><?php echo !HResponse::getAttribute('title') ? $siteCfg['name'] : HResponse::getAttribute('title') . '-' . $siteCfg['name'];?></title>
    <!-- Path to Framework7 Library CSS-->
    <link rel="stylesheet" href="<?php echo HResponse::uri('cdn'); ?>/bootstrap/v3/css/bootstrap.min.css" />
    <!-- Path to your custom app styles-->
    <link rel="stylesheet" href="<?php echo HResponse::uri(); ?>/css/style.css?v=<?php echo $version; ?>">
    <script type="text/javascript">
        var siteUrl     = '<?php echo HResponse::url(); ?>';
        var queryUrl    = siteUrl + 'index.php/';
        var cdnUrl      = '<?php echo HResponse::uri('cdn'); ?>';
        var siteUri     = '<?php echo HResponse::uri(); ?>';
        var modelZhName = '<?php echo $modelZhName; ?>';
        var modelEnName = '<?php echo $modelEnName; ?>';
    </script>
