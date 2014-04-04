<?php require_once(HObject::GC('TPL_DIR') . '/admin/common/header.tpl');?>
</head>
<body>
	<div id="container">
		<div id="bgwrap">
			<div id="primary_left">
				<?php require(HObject::GC('TPL_DIR') . '/admin/common/left_menu.tpl'); ?>
			</div> <!-- sidebar end -->
			<div id="primary_right">
				<div class="inner">
                    <?php $record = HResponse::getAttribute('record');?>
                    <form name="model_form" action="<?php echo HResponse::url('normalconfig/' . HResponse::getAttribute('nextAction'));?>" method="post">
					<fieldset>
                        <legend>常规配置</legend>
                        <h2>基本设置</h2>
						<p>
                        <label>选择内容编辑器:</label>
                        <?php HHtml::select('editor', HResponse::getAttribute('editors'), HObject::GC('editor'), 'id="editor_id" class="mf"');?>
							<span class="field_desc">指定当前的内容编辑器。</span>
                        </p>
						<p>
                            <label>网站域名:</label>
                            <?php HHtml::text('site_url', HResponse::url(), 'id="site_url_id" class="lf"');?>
                        </p>
						<div class="clearboth"></div>
                        <?php require_once(HObject::GC('TPL_DIR') .  '/admin/common/form-buttons.tpl'); ?>
					</fieldset>
                    </form>
					<div class="clearboth"></div>
				</div> <!-- inner -->
			</div> <!-- primary_right -->
		</div> <!-- bgwrap -->
	</div> <!-- container -->
    <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/footer.tpl');?>
</body>
</html>
