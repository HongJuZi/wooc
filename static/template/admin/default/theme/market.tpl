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
                            主题风格市场
                            <small>
                                <i class="icon-double-angle-right"></i>
                                挑选网站主题风格
                            </small>
                        </h1>
                    </div><!--/page-header-->      
                    <div class="row-fluid">
                        <!-- PAGE CONTENT BEGINS HERE -->
                        <div class="dataTables_wrapper" role="grid">
                            <div class="row-fluid">
                                <div class="span4">
                                    <div class="dataTables_length">
                                        <label>每页显示:
                                            <select size="1" id="perpage" id="perpage" data-cur="10">
                                                <option value="10" selected="selected">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                            条
                                        </label>
                                    </div>
                                </div>
                                <div class="span8 txt-right f-right">
                                    <label>搜索<?php echo $modelZhName;?>: 
                                        <input type="text" class="input-medium search-query" name="keywords" id="keywords" data-def="<?php echo !HRequest::getParameter('keywords') ? '关键字...' : HRequest::getParameter('keywords'); ?>">
                                        <button type="button" id="search-btn" class="btn btn-purple btn-small">搜索<i class="icon-search icon-on-right"></i></button>
                                    </label>
                                </div>
                            </div>
                            <div class="theme-box">
                                <h3 class="text-center" id="theme-loading-box">
                                    <i class="icon-spinner icon-spin orange bigger-125"></i>
                                    正在为您加载中...
                                </h3>
                                <ul class="ace-thumbnails theme-list hide" id="theme-list"></ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="row-fluid">
                                <div class="span4">
                                    <div class="dataTables_info" id="theme-pages">
                                        共 <strong id="total-themes">0</strong> 条
                                        当前: <strong id="cur-page">0</strong>/<strong id="total-pages">0</strong> 页
                                    </div>
                                </div>
                                <div class="span8">
                                    <div class="dataTables_paginate paging_bootstrap pagination">
                                        <ul id="pages"></ul>
                                    </div>
                                </div>
                            </div>
                        <!-- PAGE CONTENT ENDS HERE -->
                         </div><!--/row-->
                        </div><!--/#page-content-->
                    </div><!-- #main-content -->
                </div><!--/.fluid-container#main-container-->
         <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
         <script type="text/javascript" src="<?php echo HResponse::uri(); ?>/js/theme-market.js"></script>
	</body>
</html>
