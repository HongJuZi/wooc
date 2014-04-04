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
						<legend>数据库备份</legend>
                        <form name="model_form" action="<?php echo HResponse::url('dbtool/backup'); ?>" method="post" enctype="multipart/form-data">
                        <h2>基本设置</h2>
						<p>
							<label>保存文件名称:</label>
                            <?php HHtml::text('backup_file_name', 'backup-' . date('Y-d-m'), 'id="backup_file_name_id" class="mf"');?>
							<span class="field_desc">如：backup-2012; 系统将自动保存为*.sql文件格式</span>
						</p>
                        <div class="clearboth"></div>
						<p>
                            <input class="button" type="submit" value="开始备份" />
                            <input class="button" type="reset" value="清除" />
                        </p>
                        </form>
                        </legend>
                    </fieldset>
					<fieldset>
						<legend>数据库还原</legend>
                            <form name="model_form" action="<?php echo HResponse::url('admin/dbtool/recovery'); ?>"
                            method="post" enctype="multipart/form-data">
                            <h2>基本设置</h2>
                            <p>
                                <label>上传还原文件:</label>
                                <?php HHtml::file('recovery_file', 'id="recovery_file_id" class="mf"');?>
                                <span class="field_desc">只支持.sql格式文件。</span>
                            </p>
                            <div class="clearboth"></div>
                            <?php require_once(HObject::GC('TPL_DIR') .  '/admin/common/form-buttons.tpl'); ?>
                        </form>
					</fieldset>
					<div class="clearboth"></div>				
				</div> <!-- inner -->
			</div> <!-- primary_right -->
		</div> <!-- bgwrap -->
	</div> <!-- container -->
    <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/footer.tpl');?>
</body>
</html>
