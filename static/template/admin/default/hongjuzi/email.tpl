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
                    <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/quick_control_pannel.tpl'); ?>
                    <div class="clearboth"></div>
					<hr />
					<fieldset>
						<legend>写邮件</legend>
                        <form name="model_form" action="<?php echo HResponse::url('email/send'); ?>" method="post" enctype="multipart/form-data">
                        <h2>基本设置</h2>
						<p>
							<label>邮件标题:</label>
                            <input type="text" name="subject" value="" class="mf" />
							<span class="field_desc">长度：100个中文字符以内。</span>
						</p>
						<p>
							<label>收件人:</label>
                            <input type="text" name="to" value="" class="mf" />
							<span class="field_desc">长度：100个中文字符以内。</span>
						</p>
						<p>
							<label>添加附件:</label>
                            <input type="file" name="attachments[]" value="" class="mf" />
							<span class="field_desc">小于500K, 不然可能会超时。</span>
						</p>
						<p>
							<label>添加附件:</label>
                            <input type="file" name="attachments[]" value="" class="mf" />
							<span class="field_desc">小于500K, 不然可能会超时。</span>
						</p>
                        <?php HHtml::editor('body', '', 'id="editor-id" class="editor"');?>
                        <div class="clearboth"></div>
                        <?php require_once(HObject::GC('TPL_DIR') .  '/admin/common/form-buttons.tpl'); ?>
                        </form>
                        </legend>
                    </fieldset>
					<div class="clearboth"></div>				
				</div> <!-- inner -->
			</div> <!-- primary_right -->
		</div> <!-- bgwrap -->
	</div> <!-- container -->
    <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/footer.tpl');?>
</body>
</html>
