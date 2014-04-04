<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
        <?php $popo     = HResponse::getAttribute('popo'); ?>
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
                        <?php require_once(HResponse::path('admin') . '/common/setting-bar.tpl'); ?>  
                    </div><!-- #main-content -->
                </div><!--/.fluid-container#main-container-->
         <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
         <div id="dialog-excel-import" class="modal hide fade dialog-box">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>从Excel文件导入数据到<?php echo $modelZhName; ?>模块</h3>
              </div>
              <div class="modal-body dialog-box-body">
                <form action="<?php echo HResponse::url('excel/import'); ?>" method="post" enctype="multipart/form-data" id="excel-form">
                    <p>
                        <strong>上传Excel文件：</strong>
                        <input type="file" id="excel-file" name="excel_file"/>
                        <input type="hidden" value="<?php echo $modelEnName; ?>" name="m" id="m"/>
                        <a href="###" id="import-btn" class="btn btn-primary">开始导入</a>
                    </p>
                </form>
                <p class="alert alert-info"><strong>说明：</strong>需要导入的Excel文件，请<a href="<?php echo HResponse::url('excel/template', 'm=' . $modelEnName); ?>">下载<?php echo $modelZhName; ?>导入Excel模板</a>进行修改，原模板里的格式不能改动，否则不能正常导入！</p>
             </div>
         </div>
		<script type="text/javascript" src="<?php echo HResponse::uri('cdn'); ?>/jquery/plugins/jquery.tablesorter/jquery.tablesorter.min.js"></script>       
		<script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/list.js"></script>       
	</body>
</html>
