<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
        <link rel="stylesheet" href="<?php echo HResponse::uri('cdn');?>/jquery/plugins/ztree/css/metroStyle/metroStyle.css" />
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
                    <form  action="<?php echo HResponse::url($modelEnName . '/' . HResponse::getAttribute('nextAction') ); ?>" method="post" enctype="multipart/form-data" id="info-form">
                        <div class="row-fluid">
                            <div class="span9 content-box">
                            <!-- PAGE CONTENT BEGINS HERE -->
                                <?php $field = 'id'; require(HResponse::path('admin') . '/fields/hidden.tpl'); ?>
                                <?php $field = 'parent_path'; require(HResponse::path('admin') . '/fields/hidden.tpl'); ?>
                                <?php $record = !$record ? $copyRecord : $record; ?>
                                <?php $field = 'name'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
                                <?php $field = 'content'; require(HResponse::path('admin') . '/fields/editor.tpl'); ?>
                                <div class="clearfix"></div>
                                <hr/>
                                <?php $field = 'description'; require(HResponse::path('admin') . '/fields/textarea.tpl'); ?>
                                <hr/>
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
                                            <?php $field = 'sort_num'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
                                            <?php $field = 'identifier'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
                                            <?php $field = 'status'; require(HResponse::path('admin') . '/fields/select.tpl'); ?>
                                            <?php require_once(HResponse::path('admin') . '/common/info-buttons.tpl'); 
 ?>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="widget-box">
                                    <div class="widget-header">
                                        <h4>分类</h4>
                                        <div class="widget-toolbar">
                                            <a href="#" data-action="collapse">
                                                <i class="icon-chevron-up"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <?php $field = 'parent_id'; require(HResponse::path('admin') .  '/fields/tree-checkbox.tpl'); ?>
                                            <p><a href="###" id="open-new-cat-box-btn" class="text-blod open-new-cat-box-btn">+ 新加分类</a></p>
                                            <div class="add-category-box hide" id="add-category-box">
                                                <div class="control-group">
                                                    <label class="control-label" for="new-category-name">名称：</label>
                                                    <div class="controls">
                                                        <input type="text" id="new-cat-name" class="span12" value="" placeholder="请添输入类名称"/>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="control-group">
                                                        <?php $field    = 'parent_id';?>
                                                        <label class="control-label" for="new-<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?>： </label>
                                                        <div class="controls">
                                                            <select id="new-<?php echo $field; ?>" data-cur="<?php echo !empty($record[$field]) ? $record[$field] : $popo->getFieldAttribute($field, 'default'); ?>" 
                                                            class="auto-select span12">
                                                                <?php 
                                                                    HClass::import('hongjuzi.utils.HTree');
                                                                    $hTree  = new HTree(
                                                                        HResponse::getAttribute($field . '_list'),
                                                                        'id',
                                                                        $field,
                                                                        'name',
                                                                        'id',
                                                                        '<option value="{id}">' .
                                                                        '{name}' .
                                                                        '</option>'
                                                                    );
                                                                    echo $hTree->getTree();
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <script type="text/javascript">selectList.push('#new-<?php echo $field; ?>');</script>
                                                    <p class="text-right">
                                                        <a href="###" class="btn btn-mini" id="cancel-add-cat-btn">取消</a>
                                                        <a href="###" class="btn btn-mini btn-info" id="add-cat-btn">确认</a>
                                                    </p>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="widget-box">
                                    <div class="widget-header">
                                        <h4>封面</h4>
                                        <div class="widget-toolbar">
                                            <a href="#" data-action="collapse">
                                                <i class="icon-chevron-up"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <?php $field = 'image_path'; require(HResponse::path('admin') . '/fields/image.tpl'); ?>
                                            <div class="clearfix"></div>
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

                                <?php require_once(HResponse::path('admin') . '/common/manage-widget.tpl'); ?>  
                            </div>
                         </div><!--/row-->
                     </form>
                </div><!--/#page-content-->
			</div><!-- #main-content -->
		</div><!--/.fluid-container#main-container-->
        <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/info.js"></script>
        <script type="text/javascript" src="<?php echo HResponse::uri('cdn'); ?>/jquery/plugins/ztree/js/jquery.ztree.core-3.5.min.js"></script>
        <script type="text/javascript" src="<?php echo HResponse::uri('cdn'); ?>/jquery/plugins/ztree/js/jquery.ztree.excheck-3.5.min.js"></script>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/article.js"></script>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/sidebar-category.js"></script>
	</body>
</html>
