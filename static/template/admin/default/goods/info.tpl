<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
	</head>
	<body>
        <?php require_once(HResponse::path('admin') . '/common/navmenu.tpl'); ?>
		<div class="container-fluid" id="main-container">
            <?php require_once(HResponse::path('admin') . '/common/sidebar.tpl'); ?>
			<div id="main-content" class="clearfix">
                    <?php $record         = HResponse::getAttribute('record'); ?>    
                    <?php require_once(HResponse::path('admin') . '/common/cur-location.tpl'); ?>
						<div class="row-fluid">
                        <!-- PAGE CONTENT BEGINS HERE -->
                            <form class="form-horizontal" action="<?php echo HResponse::url($modelEnName . '/' . HResponse::getAttribute('nextAction') ); ?>" method="post" enctype="multipart/form-data" id="info-form">
                               <div class="tabbable tabs-right tabs-shadow tabs-space">
                                <?php require_once(HResponse::path('admin') . '/common/tabs-sidebar.tpl'); ?>
                                <div class="tab-content">
                                  <div id="base-box" class="tab-pane in active">
                                    <?php $field = 'sort_num'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'id'; require(HResponse::path('admin') . '/fields/hidden.tpl'); ?>
<?php $field = 'name'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'parent_id'; require(HResponse::path('admin') . '/fields/tree.tpl'); ?>
<?php $field = 'us_price'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'hk_price'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'quantity'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'start_time'; require(HResponse::path('admin') . '/fields/datetime.tpl'); ?>
<?php $field = 'end_time'; require(HResponse::path('admin') . '/fields/datetime.tpl'); ?>
<?php $field = 'total_like'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'size'; require(HResponse::path('admin') . '/fields/textarea.tpl'); ?>
<?php $field = 'description'; require(HResponse::path('admin') . '/fields/textarea.tpl'); ?>
<?php $field = 'content'; require(HResponse::path('admin') . '/fields/editor.tpl'); ?>
<?php $field = 'image_path'; require(HResponse::path('admin') . '/fields/file.tpl'); ?>
<?php $field = 'is_best'; require(HResponse::path('admin') . '/fields/checkbox.tpl'); ?>

                                  </div>
                                  <div id="seo-box" class="tab-pane">
                                    <?php $field = 'seo_keywords'; require(HResponse::path('admin') . '/fields/textarea.tpl'); ?>
<?php $field = 'seo_desc'; require(HResponse::path('admin') . '/fields/textarea.tpl'); ?>

                                  </div>
                                  <div id="album-box" class="tab-pane">
                                    <?php $field = 'album_hash'; require(HResponse::path('admin') . '/fields/album.tpl'); ?>

                                  </div>
                                  <div id="manage-box" class="tab-pane">
                                    <?php $field = 'total_visits'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'create_time'; require(HResponse::path('admin') . '/fields/datetime.tpl'); ?>
<?php require_once(HResponse::path('admin') . '/fields/author.tpl'); ?>

                                  </div>
                                <?php require_once(HResponse::path('admin') . '/common/info-form-buttons.tpl'); ?>
                              </div>
                             </form>
                        <!-- PAGE CONTENT ENDS HERE -->
						 </div><!--/row-->
					</div><!--/#page-content-->
                <?php require_once(HResponse::path('admin') . '/common/setting-bar.tpl'); ?>  
			</div><!-- #main-content -->
		</div><!--/.fluid-container#main-container-->
        <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/info.js"></script>
	</body>
</html>
