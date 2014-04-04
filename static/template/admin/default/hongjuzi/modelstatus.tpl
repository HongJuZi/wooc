<?php require_once(HObject::GC('TPL_DIR') . '/admin/common/header.tpl');?>
    <style type="text/css">
        ul, li { border: 0px; margin: 0px; padding: 0px; }
        ul.model_list li { float: left; min-width: 100px; line-height: 20px; list-style-type: none; }
    </style>
</head>
<body>
	<div id="container">
		<div id="bgwrap">
			<div id="primary_left">
                <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/left_menu.tpl'); ?>
			</div> <!-- sidebar end -->
			<div id="primary_right">
				<div class="inner">
                    <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/quick_control_pannel.tpl');?>
                    <div class="clearfix"></div>
					<hr />
                    <h1>网站各模块统计信息</h1>
					 <div class="sortable">
						<div class="two_third column">
						  <div class="portlet">
							<div class="portlet-header">模块信息总览</div>
                            <?php $modelStatus   = HResponse::getAttribute('modelStatus');?>
							<div class="portlet-content" style="display: block;">
                                <label>总模块数：</label>
                                <span class="validate_success"><?php echo count($modelStatus);?></span>
                                <br/>
                                <ul class="model_list">
                                    <?php foreach($modelStatus as $model) {
                                        echo '<li><a href="#' .
                                             $model['model_en_name'] . '">' .
                                             $model['modelmanager_name'] . '</a></li>';
                                    } ?>
                                </ul>
                                <br/>
                                <p>&nbsp;</p>
							</div>
						  </div>
						</div>
                        <hr />
                        <?php
                            foreach($modelStatus as $key => $model) {
                        ?>
                        <div class="one_third <?php echo ($key + 1) % 3 == 0 ? 'last' : '';?> column">
						  <div class="portlet">
							<div class="portlet-header">
                                <?php echo $model['modelmanager_name'];?>信息
                                <a name="<?php echo $model['model_en_name']?>"></a>
                            </div>
							<div class="portlet-content" style="display: block;">
                                <p>
                                    <label>模块名称：</label>
                                    <span class="validate_success"><?php echo $model['modelmanager_name']?></span>
                                    <br/>
                                    <label>模块总信息条数：</label>
                                    <span class="validate_success"><?php echo $model['status']['pass'] + $model['status']['unpass'];?></span>
                                    <br/>
                                    <label>审核通过条数：</label>
                                    <span class="validate_success"><?php echo $model['status']['pass']; ?></span>
                                    <br/>
                                    <label>审核不通过条数：</label>
                                    <span class="validate_error"><?php echo $model['status']['unpass']; ?></span>
                                    <br/>
                                    <label>进入管理页：</label>
                                    <span class="validate_success">
                                        <a href="<?php echo HResponse::url($model['model_en_name']); ?>">
                                            <?php echo $model['modelmanager_name'];?>管理页
                                        </a>
                                    </span>
                                </p>
							</div>
						  </div>
						</div>
                        <?php
                                echo ($key + 1) % 3 == 0 ? '<hr />' : '';
                            }
                        ?>
					  </div> <!-- sortable end -->
					  <div class="clearboth"></div>
					<?php echo ($key + 1) % 3 != 0 ? '<hr />' : ''; ?>
				</div> <!-- inner -->
			</div> <!-- primary_right -->
		</div> <!-- bgwrap -->
	</div> <!-- container -->
    <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/footer.tpl');?>
    <script text="text/javascript">
        jQuery(function() {
            jQuery(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all").find(".portlet-header").addClass("ui-widget-header ui-corner-all").prepend('<span class="ui-icon ui-icon-circle-arrow-s"></span>').end().find(".portlet-content");
            jQuery(".portlet-header .ui-icon").click(function() {
                jQuery(this).toggleClass("ui-icon-minusthick");
                jQuery(this).parents(".portlet:first").find(".portlet-content").toggle();
            });
        });
    </script>
</body>
</html>
