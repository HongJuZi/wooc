<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
	</head>
	<body>
        <?php require_once(HResponse::path('admin') . '/common/navmenu.tpl'); ?>
		<div class="container-fluid" id="main-container">
            <?php require_once(HResponse::path('admin') . '/common/sidebar.tpl'); ?>
			<div id="main-content" class="clearfix">
                <?php require_once(HResponse::path('admin') . '/common/cur-location.tpl'); ?>
                    <div class="row-fluid">
                            <div class="span8">
                                <!-- PAGE CONTENT BEGINS HERE -->
                                <div id="table_report_wrapper" class="dataTables_wrapper" role="grid">
                                    <?php require_once(HResponse::path('admin') . '/common/list-tool-bar.tpl'); ?>
                                    <?php require_once(HResponse::path('admin') . '/fields/data-grid.tpl'); ?>
                                <!-- PAGE CONTENT ENDS HERE -->
                                 </div><!--/row-->
                            </div>
                            <?php $settingList = HResponse::getAttribute('sharesettingList'); ?>
                            <div class="span4">
                                <div class="tabbable">
                                    <h3 class="header smaller lighter green">同步设置</h3>
                                    <ul class="nav nav-tabs padding-12 tab-color-blue background-blue">
                                        <?php 
                                            foreach ($settingList as $setting) {
                                        ?>
                                        <li><a data-toggle="tab" href="#setting-<?php echo $setting['id'];?>"><?php echo $setting['name'];?></a></li>
                                        <?php } ?>
                                    </ul>
                                    <div class="tab-content" id="tab-content">
                                        <?php 
                                            foreach ($settingList as $setting) {
                                        ?>
                                        <div id="setting-<?php echo $setting['id'];?>" class="tab-pane">
                                            <p>如果对应的<?php echo $setting['name'];?>同步状态为“未开启”状态，您可以点击下面的按钮开启对QQ微博的同步功能。</p>
                                            <p class="text-right">
                                                <a href="<?php echo $setting['content']; ?>" class="btn btn-info btn-sm" ><i class="icon-tx"></i> 开启<?php echo $setting['name'];?></a>
                                            </p>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div><!--/#page-content-->
                    </div><!-- #main-content -->
                </div><!--/.fluid-container#main-container-->
         <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
		<script type="text/javascript" src="<?php echo HResponse::uri('cdn'); ?>/jquery/plugins/jquery.tablesorter/jquery.tablesorter.min.js"></script>       
		<script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/list.js"></script>       
        <script type="text/javascript">
            $('#tab-content div.tab-pane:first').addClass('active');
            $('ul.nav-tabs li:first').addClass('active');
        </script>
	</body>
</html>
