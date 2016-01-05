<?php require_once(HObject::GC('TPL_DIR') . '/admin/common/header.tpl');?>
    <link rel="stylesheet" type="text/css" href="<?php echo HResponse::uri('rendor');?>/uploadify/css/uploadify.css" />
</head>
<body>
	<div id="container">
		<div id="bgwrap">
			<div id="primary_left">
				<?php require(HObject::GC('TPL_DIR') . '/admin/common/left_menu.tpl'); ?>
			</div> <!-- sidebar end -->
			<div id="primary_right">
				<div class="inner">
                    <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/quick_control_pannel.tpl'); ?>
                    <div class="clearboth"></div>
					<fieldset>
                    <legend>上传资源</legend>
                        <h2>上传文件 <a href="<?php echo HResponse::url('resource/filemanage'); ?>">返回文件管理</a></h2>
                        <p>
                            <input type="file" name="res_file" id="res_file_id" class="mf" value="" />
                            <span class="field_desc">可以同时上传多个文件。</span>
                        </p>
                        <div class="clearboth"></div>
                        <hr />
                        <h2>上传图片</h2>
						<p>
                            <input type="file" name="res_image" id="res_image_id" class="mf" value="" />
							<span class="field_desc">可以同时上传多张图片。</span>
						</p>
                        </legend>
                    </fieldset>
					<div class="clearboth"></div>				
				</div> <!-- inner -->
			</div> <!-- primary_right -->
		</div> <!-- bgwrap -->
	</div> <!-- container -->
    <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/footer.tpl');?>
    <script type="text/javascript" src="<?php echo HResponse::uri('rendor');?>/uploadify/uploadify.js"></script>
    <script type="text/javascript" src="<?php echo HResponse::uri('template');?>/admin/js/upload_res_view.js"></script>
</body>
</html>
