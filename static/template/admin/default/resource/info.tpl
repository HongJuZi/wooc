<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
	</head>
	<body>
        <?php require_once(HResponse::path('admin') . '/common/navmenu.tpl'); ?>
		<div class="container-fluid" id="main-container">
            <?php require_once(HResponse::path('admin') . '/common/sidebar.tpl'); ?>
			<div id="main-content" class="clearfix">
                <?php 
                    $copyRecord     = HResponse::getAttribute('copyRecord'); 
                    $record         = HResponse::getAttribute('record'); 
                ?>   
                <?php require_once(HResponse::path('admin') . '/common/cur-location.tpl'); ?>
                    <div class="row-fluid">
                    <!-- PAGE CONTENT BEGINS HERE -->
                        <form action="<?php echo HResponse::url($modelEnName . '/' . HResponse::getAttribute('nextAction') ); ?>" method="post" enctype="multipart/form-data" id="info-form">
                            <div class="row-fluid">
                                <div class="span9 content-box">
                                <!-- PAGE CONTENT BEGINS HERE -->
                                    <?php $field = 'id'; require(HResponse::path('admin') . '/fields/hidden.tpl'); ?>
                                    <?php $record = !$record ? $copyRecord : $record; ?>
                                    <?php $field = 'name'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'path'; require(HResponse::path('admin') . '/fields/file.tpl'); ?>
<?php $field = 'type'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'fhash'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'total_use'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>

                                    
                                    
                                <!-- PAGE CONTENT ENDS HERE -->
                                </div>
                                <div class="span3">
                                    <div class="widget-box">
                                        <div class="widget-header">
                                            <h4>发布</h4>
                                            <div class="widget-toolbar">
                                                <a href="#" data-action="collapse">
                                                    <i class="icon-chevron-up"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                
                                                <div class="control-group text-right btn-form-box" data-spy="affix" data-offset-top="160" >
                                                    <button type="reset" class="btn btn-mini">重置</button>
                                                    <button type="submit" class="btn btn-success btn-mini">发布</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr/>
                                    <?php 
                                        if($modelCfg && '2' == $modelCfg['has_multi_lang']) { 
                                            require_once(HResponse::path('admin') . '/common/lang-widget.tpl'); 
                                            echo '<hr/>';
                                        }
                                    ?>  
                                    <div class="widget-box collapsed">
                                        <div class="widget-header">
                                            <h4>维护</h4>
                                            <div class="widget-toolbar">
                                                <a href="#" data-action="collapse">
                                                    <i class="icon-chevron-up"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="widget-body">
                                            <div class="widget-main">
                                                <?php $field = 'create_time'; require(HResponse::path('admin') . '/fields/datetime.tpl'); ?>
<?php require_once(HResponse::path('admin') . '/fields/author.tpl'); ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                             </div><!--/row-->
                          </div>
                         </form>
                    <!-- PAGE CONTENT ENDS HERE -->
                     </div><!--/row-->
                </div><!--/#page-content-->
			</div><!-- #main-content -->
		</div><!--/.fluid-container#main-container-->
        <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
        <script type="text/javascript"> var fromId = '<?php echo HRequest::getParameter('fid');?>';</script>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/info.js"></script>
	</body>
</html>
