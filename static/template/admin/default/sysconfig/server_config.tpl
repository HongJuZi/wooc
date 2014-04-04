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
                    <?php $dbCfg = HResponse::getAttribute('dbCfg');?>
                    <form name="model_form" action="<?php echo HObject::GC('SITE_URL');?>/index.php/admin/serverconfig/editdb" method="post">
					<fieldset>
                        <legend>数据库服务器配置</legend>
                        <h2>基本设置</h2>
						<p>
                            <label>服务器主机:</label>
                            <?php HHtml::text('dbHost', $dbCfg['dbHost'], 'id="db_host_id" class="lf"');?>
							<span class="field_desc">Field description</span>
                        </p>
						<p>
                            <label>服务器端口:</label>
                            <?php HHtml::text('dbPort', $dbCfg['dbPort'], 'id="db_port_id" class="lf"');?>
							<span class="field_desc">Field description</span>
                        </p>
                        <p>
							<label>数据库类型:</label>
                            <?php HHtml::text('dbDriver', $dbCfg['dbDriver'], 'id="db_driver_id" class="mf"');?>
							<span class="field_desc">Field description</span>
						</p>
						<p>
                            <label>数据库名:</label>
                            <?php HHtml::text('dbName', $dbCfg['dbName'], 'id="db_name_id" class="lf"');?>
							<span class="field_desc">Field description</span>
                        </p>
						<p>
                            <label>服务器用户名:</label>
                            <?php HHtml::text('dbUserName', $dbCfg['dbUserName'], 'id="db_user_name_id" class="lf"');?>
							<span class="field_desc">Field description</span>
                        </p>
						<p>
                            <label>服务器密码:</label>
                            <?php HHtml::text('dbUserPasswd', $dbCfg['dbUserPassword'], 'id="db_user_passwd_id" class="lf"');?>
							<span class="field_desc">服务器密码</span>
                        </p>
                        <div class="clearboth"></div>
						<p><input class="button" type="submit" value="提交" /> <input
                        class="button" type="reset" value="还原" /></p>
					</fieldset>
                    </form>
					<div class="clearboth"></div>
                    <form name="model_form" action="<?php echo HResponse::url('serverconfig/editmail'); ?>" method="post">
                    <?php $mailCfg = HResponse::getAttribute('mailCfg');?>
					<fieldset>
                        <legend>邮件服务器配置</legend>
                        <h2>基本设置</h2>
						<p>
                            <label>服务器主机:</label>
                            <?php HHtml::text('mailHost', $mailCfg['mailHost'], '', 'mail_host_id', 'lf');?>
							<span class="field_desc">Field description</span>
                        </p>
						<p>
                            <label>服务器端口:</label>
                            <?php HHtml::text('mailPort', $mailCfg['mailPort'], '', 'mail_port_id', 'lf');?>
							<span class="field_desc">Field description</span>
                        </p>
						<p>
                            <label>发送方式:</label>
                            <?php HHtml::select('mailMethod',
                                    array('smtp', 'gmail', 'pop3'),
                                    $mailCfg['mailMethod'],
                                    'mail_host_id',
                                    'lf',
                                    true);?>
							<span class="field_desc">Field description</span>
                        </p>
                        <p>
							<label>服务器用户名:</label>
                            <?php HHtml::text('mailUserName', $mailCfg['mailUserName'], '', 'mail_user_name_id', 'mf');?>
							<span class="field_desc">Field description</span>
						</p>
						<p>
                            <label>服务器密码:</label>
                            <?php HHtml::text('mailUserPasswd', $mailCfg['mailUserPasswd'], '', 'mail_user_passwd_id', 'lf');?>
							<span class="field_desc">Field description</span>
                        </p>
						<p>
                            <label>发件人地址:</label>
                            <?php HHtml::text('mailFromEmail', $mailCfg['mailFromEmail'], '', 'from_email_id', 'lf');?>
							<span class="field_desc">Field description</span>
                        </p>
						<p>
                            <label>发件人名:</label>
                            <?php HHtml::text('mailFromName', $mailCfg['mailFromName'], '', 'from_name_id', 'lf');?>
							<span class="field_desc">Field description</span>
                        </p>
						<p>
                            <label>回复地址:</label>
                            <?php HHtml::text('mailReplyEmail', $mailCfg['mailReplyEmail'], '', 'reply_email_id', 'lf');?>
							<span class="field_desc">Field description</span>
                        </p>
						<p>
                            <label>发件人名:</label>
                            <?php HHtml::text('mailReplyName', $mailCfg['mailReplyName'], '', 'reply_name_id', 'lf');?>
							<span class="field_desc">Field description</span>
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
