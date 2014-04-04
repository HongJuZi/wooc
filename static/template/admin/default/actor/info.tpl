<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
        <link rel="stylesheet" href="<?php echo HResponse::uri('cdn'); ?>/jquery/plugins/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
	</head>
	<body>
        <?php require_once(HResponse::path('admin') . '/common/navmenu.tpl'); ?>
		<div class="container-fluid" id="main-container">
            <?php require_once(HResponse::path('admin') . '/common/sidebar.tpl'); ?>
			<div id="main-content" class="clearfix">
                    <?php $record         = HResponse::getAttribute('record');  ?>
                    <?php require_once(HResponse::path('admin') . '/common/cur-location.tpl'); ?>
						<div class="row-fluid">
                        <!-- PAGE CONTENT BEGINS HERE -->
                            <form class="form-horizontal" action="<?php echo HResponse::url($modelEnName . '/' . HResponse::getAttribute('nextAction') ); ?>" method="post" enctype="multipart/form-data" id="info-form">
                                <div class="tabbable tabs-right tabs-shadow tabs-space">
                                    <?php require_once(HResponse::path('admin') . '/common/tabs-sidebar.tpl'); ?>
                                    <div class="tab-content">
                                      <div id="base-box" class="tab-pane in active">
                                        <input type="hidden" name="id" value="<?php echo $record['id'];?>" />
                                        <?php $field = 'sort_num'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
                                        <?php $field = 'name'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
                                        <?php $field = 'identifier'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
                                        <?php $field = 'description'; require(HResponse::path('admin') . '/fields/textarea.tpl'); ?>
                                        <div class="control-group rights-list">
                                            <label class="control-label" for="rights">分配权限</label>
                                            <div class="controls">
                                                <ul id="rights-list" class="ztree span6"></ul>
                                                <input type="hidden" name="rights" id="rights" value=""/>
                                                <span class="help-inline"><?php echo $popo->getFieldComment('rights'); ?></span>
                                            </div>
                                        </div>
                                      </div>
                                      <div id="manage-box" class="tab-pane">
                                        <?php $field = 'top'; require(HResponse::path('admin') . '/fields/checkbox.tpl'); ?>
                                        <?php $field = 'create_time'; require(HResponse::path('admin') . '/fields/date.tpl'); ?>
                                        <?php require_once(HResponse::path('admin') . '/fields/author.tpl'); ?>
                                      </div>
                                    </div>
                                  </div>
                                <?php require_once(HResponse::path('admin') .  '/common/info-form-buttons.tpl'); ?>
                             </form>
                        <!-- PAGE CONTENT ENDS HERE -->
						 </div><!--/row-->
					</div><!--/#page-content-->
                <?php require_once(HResponse::path('admin') . '/common/setting-bar.tpl'); ?>  
			</div><!-- #main-content -->
		</div><!--/.fluid-container#main-container-->
        <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/info.js"></script>
        <script type="text/javascript" src="<?php echo HResponse::uri('cdn'); ?>/jquery/plugins/ztree/js/jquery.ztree.core-3.5.js"></script>
        <script type="text/javascript" src="<?php echo HResponse::uri('cdn'); ?>/jquery/plugins/ztree/js/jquery.ztree.excheck-3.5.js"></script>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/usertype.js"></script>
        <script type="text/javascript">
            var rightsNodes     = [
                <?php 
                    foreach(HResponse::getAttribute('rightsList') as $rights) { 
                        $checked    = false !== strpos($record['rights'], ',' . $rights['id'] . ',') ? 'true' : 'false';
                        $nodes      .= ',{ id:' . $rights['id'] . ', pId: ' . $rights['parent_id'] . ', name:"' . $rights['name'] . '", checked: ' . $checked . '}';
                    }
                    $nodes{0}   = ' ';
                    echo $nodes;
                ?>
            ];
        </script>
	</body>
</html>
