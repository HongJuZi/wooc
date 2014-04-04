<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
	</head>
	<body>
        <?php require_once(HResponse::path('admin') . '/common/navmenu.tpl'); ?>
		<div class="container-fluid" id="main-container">
            <?php require_once(HResponse::path('admin') . '/common/sidebar.tpl'); ?>
			<div id="main-content" class="clearfix">
                    <?php 
                        $record     = HResponse::getAttribute('record');  
                        $database   = HObject::GC('DATABASE'); 
                    ?>
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
                                        <div class="control-group">
                                            <label class="control-label" for="name">所属分类</label>
                                            <div class="controls">
                                                <select name="parent_id" id="parent-id" class="auto-select" cur="<?php echo $record['parent_id']; ?>">
                                                    <option value="-1">请选择类型</option>
                                                    <option value="0">自己</option>
                                                <?php 
                                                    HObject::import('hongjuzi.utils.HTree');
                                                    $hTree  = new HTree(
                                                        HResponse::getAttribute('parent_id_list'),
                                                        'id',
                                                        'parent_id',
                                                        'name',
                                                        'id',
                                                        '<option value="{' . 'id' . '}">' .
                                                        '{' . 'name' .  '}' .
                                                        '</option>'
                                                    );
                                                    echo $hTree->getTree();
                                                ?>
                                                </select>
                                                <span class="help-inline">只能选择“自己”或者“下拉”中的项目。</span>
                                            </div>
                                        </div>
                                        <?php $field = 'image_path'; require(HResponse::path('admin') . '/fields/file.tpl'); ?>
                                      </div>
                                      <div id="manage-box" class="tab-pane">
                                        <?php $field = 'on_desktop'; require(HResponse::path('admin') . '/fields/checkbox.tpl'); ?>
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
        <script type='text/javascript' src="<?php echo HResponse::uri('admin'); ?>/js/modelmanager-info.js"></script> <!-- the "addmake them work" script -->
	</body>
</html>
