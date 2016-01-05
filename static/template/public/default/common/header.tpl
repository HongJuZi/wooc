<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
        <?php $siteCfg  = HResponse::getAttribute('siteCfg'); ?>
        <title><?php echo !HResponse::getAttribute('title') ? $siteCfg['site_name'] : HResponse::getAttribute('title') . '-' . $siteCfg['site_name'];?></title>
        <meta name="description" content="<?php echo HResponse::getAttribute('seoKeywords');?>">
        <meta name="keywords" content="<?php echo HResponse::getAttribute('seoDesc');?>">
        <meta name="author" content="红橘子信息科技工作室">
        <meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <link rel="icon" href="favicon.gif" type="image/gif">
        <meta property="qc:admins" content="13313374166076725216654" />
        <meta name="robots" content="all" />
        <meta name="Identifier-URL" content="http://www.hongjuzi.net" />
        <link rel="Bookmark" href="/favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" href="<?php echo HResponse::uri(); ?>/css/base.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo HResponse::uri(); ?>/css/style.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo HResponse::uri(); ?>/css/user.css" type="text/css" media="screen">
		<link rel="stylesheet" href="<?php echo HResponse::uri(); ?>/css/index.css" type="text/css" media="screen">
		
