<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
	</head>
	<body>
        <?php require_once(HResponse::path('admin') . '/common/navmenu.tpl'); ?>
		<div class="container-fluid" id="main-container">
            <?php require_once(HResponse::path('admin') . '/common/sidebar.tpl'); ?>
			<div id="main-content" class="clearfix">
                <div id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li>
                            <i class="icon-home"></i> <a href="<?php echo HResponse::url('', '', 'admin'); ?>">后台桌面</a>
                            <span class="divider"><i class="icon-angle-right"></i></span>
                        </li>
                        <li><a href="<?php echo HResponse::url($modelEnName); ?>"><?php echo $modelZhName; ?></a> <span class="divider"><i class="icon-angle-right"></i></span></li>
                        <li class="active"><?php echo $modelZhName; ?><?php HTranslate::_('内容'); ?></li>
                    </ul><!--.breadcrumb-->
                    <div id="nav-search">
                        <span id="time-info">正在加载时钟...</span>
                    </div><!-- #nav-search -->
                </div><!-- #breadcrumbs -->
                <div id="page-content" class="clearfix">
                    <div class="page-header position-relative">
                        <h1>
                            主题风格
                            <small>
                                <i class="icon-double-angle-right"></i>
                                设置网站主题风格
                            </small>
                        </h1>
                    </div><!--/page-header-->      
                    <div class="row-fluid">
                        <!-- PAGE CONTENT BEGINS HERE -->
                        <div class="dataTables_wrapper" role="grid">
                            <?php require_once(HResponse::path('admin') . '/common/list-tool-bar.tpl'); ?>
                            <div class="theme-box">
                                <ul class="ace-thumbnails theme-list" id="theme-list">
                                    <?php 
                                        foreach(HResponse::getAttribute('list') as $item) { 
                                            if(!file_exists(ROOT_DIR . 'static/template/cms/' . $item['identifier'])) {
                                    ?>
                                    <li id="theme-<?php echo $item['id']; ?>" class="span3 not-exists">
                                        <a href="###">
                                            <div class="text danger">
                                                <i class="icon-eye-close"></i>
                                                主题已经不存在，请确认！
                                            </div>
                                        </a>
                                        <div class="tags">
                                            <span class="label-holder">
                                                <span class="label label-info"><?php echo $item['name']; ?></span>
                                            </span>
                                            <span class="label-holder">
                                                <span class="label label-success">
                                                    By <a href="<?php echo $item['website']; ?>" target="_blank"><?php echo $item['publisher']; ?></a>
                                                </span>
                                            </span>
                                            <?php if(3 == $item['status']) { ?>
                                            <span class="label-holder">
                                                <span class="label label-warning arrowed-in">正在使用</span>
                                            </span>
                                            <?php }?>
                                        </div>
                                        <div class="tools tools-right"> 
                                            <a href="###" title="删除" class="del-theme-btn" data-id="<?php echo $item['id']; ?>">
                                                <i class="icon-remove red"></i>
                                            </a>
                                        </div>
                                    </li>
                                    <?php continue; } ?>
                                    <li id="theme-<?php echo $item['id']; ?>" class="span3">
                                        <a href="###" data-id="<?php echo $item['id']; ?>"
                                            class="cboxElement theme-btn" 
                                            title="查看详细：<?php echo $item['name']; ?>"
                                            data-title="<?php echo $item['name']; ?>"
                                            data-status="<?php echo $item['status']?>"
                                        >
                                            <img alt="<?php echo $item['name']; ?>" src="<?php echo $item['image_path'];?>">
                                        </a>
                                        <div class="tags">
                                            <span class="label-holder">
                                                <span class="label label-info"><?php echo $item['name']; ?></span>
                                            </span>
                                            <span class="label-holder">
                                                <span class="label label-success">
                                                    By <a href="<?php echo $item['website']; ?>" target="_blank"><?php echo $item['publisher']; ?></a>
                                                </span>
                                            </span>
                                            <?php if(1 == $item['status']) { ?>
                                            <span class="label-holder">
                                                <span class="label label-pink">
                                                    <a href="<?php echo HResponse::url('theme/install', 'id=' . $item['id']); ?>">立即安装</a>
                                                </span>
                                            </span>
                                            <?php } else if(2 == $item['status']) { ?>
                                            <span class="label-holder">
                                                <span class="label label-danger">
                                                    <a href="<?php echo HResponse::url('theme/active', 'id=' . $item['id']); ?>">换上此主题</a>
                                                </span>
                                            </span>
                                            <?php } else if(3 == $item['status']) { ?>
                                            <span class="label-holder">
                                                <span class="label label-warning arrowed-in">正在使用</span>
                                            </span>
                                            <?php }?>
                                        </div>
                                        <div class="tools tools-right"> 
                                            <?php if(3 != $item['status']) { ?>
                                            <a href="###" title="删除" class="del-theme-btn" data-id="<?php echo $item['id']; ?>">
                                                <i class="icon-remove red"></i>
                                            </a>
                                            <?php }?>
                                            <a href="<?php echo HResponse::url('theme/preview', 'id=' . $item['id']);?>" title="预览">
                                                <i class="icon-zoom-in"></i>
                                            </a>
                                        </div>
                                    </li>
                                    <?php }?>
                                    <li class="add-new-theme span3">
                                        <a href="<?php echo HResponse::url('theme/market'); ?>">
                                            <i class="icon-plus"></i>
                                        </a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-fluid">
                                <div class="span4">
                                    <div class="dataTables_info" id="table_report_info">
                                        共 <?php echo HResponse::getAttribute('totalRows');?> 条
                                        当前: <?php echo HResponse::getAttribute('curPage') . '/' . HResponse::getAttribute('totalPages')?></strong>页
                                    </div>
                                </div>
                                <div class="span8">
                                    <div class="dataTables_paginate paging_bootstrap pagination">
                                        <ul><?php echo HResponse::getAttribute('pageHtml');?></ul>
                                    </div>
                                </div>
                            </div>
                        <!-- PAGE CONTENT ENDS HERE -->
                         </div><!--/row-->
                        </div><!--/#page-content-->
                    </div><!-- #main-content -->
                </div><!--/.fluid-container#main-container-->
         <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
         <script type="text/javascript" src="<?php echo HResponse::uri(); ?>/js/theme.js"></script>
	</body>
</html>
