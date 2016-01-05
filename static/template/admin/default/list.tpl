<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
	</head>
	<body>
        <?php require_once(HResponse::path('admin') . '/common/navmenu.tpl'); ?>
		<div class="container-fluid" id="main-container">
            <?php require_once(HResponse::path('admin') . '/common/sidebar.tpl'); ?>
			<div id="main-content" class="clearfix">
                <?php require_once(HResponse::path('admin') . '/common/cur-location.tpl'); ?>
                    <div class="row-fluid">
                        <!-- PAGE CONTENT BEGINS HERE -->
                        <div id="table_report_wrapper" class="dataTables_wrapper" role="grid">
                            <?php require_once(HResponse::path('admin') . '/common/list-tool-bar.tpl'); ?>
                            <?php require_once(HResponse::path('admin') . '/fields/data-grid.tpl'); ?>
                        <!-- PAGE CONTENT ENDS HERE -->
                         </div><!--/row-->
                        </div><!--/#page-content-->
                    </div><!-- #main-content -->
                </div><!--/.fluid-container#main-container-->
         <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
		<script type="text/javascript" src="<?php echo HResponse::uri('cdn'); ?>/jquery/plugins/jquery.tablesorter/jquery.tablesorter.min.js"></script>       
		<script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/list.js"></script>       
	</body>
</html>
