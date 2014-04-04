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
                    <?php $record = hresponse::getattribute('record');?>
                    <form name="model_form" action="<?php echo HResponse::url('siteconfig/' . HResponse::getattribute('nextaction'));?>" method="post">
					<fieldset>
                        <legend>网站配置</legend>
                        <h2>基本设置</h2>
						<p>
                            <label>网站名称:</label>
                            <?php hhtml::text('site_name', HObject::GC('SITE_NAME'), 'id="site_name_id" class="lf"');?>
							<span class="field_desc">字符串长度。</span>
                        </p>
						<p>
                            <label>网站域名:</label>
                            <?php hhtml::text('site_url', c('siteurl'), 'id="site_url_id" class="lf"');?>
							<span class="field_desc">field description</span>
                        </p>
                        <p>
							<label>公司理念:</label>
                            <?php hhtml::textarea('slogan', $record['slogan'], 'id="slogan_id" class="mf"');?>
							<span class="field_desc">field description</span>
						</p>
						<p>
                            <label>公司电话:</label>
                            <?php hhtml::text('phone', $record['phone'], 'id="phone_id" class="lf"');?>
							<span class="field_desc">field description</span>
                        </p>
						<p>
                            <label>公司微博:</label>
                            <?php hhtml::text('weibo', $record['weibo'], 'id="weibo_id" class="lf"');?>
							<span class="field_desc">field description</span>
                        </p>
						<p>
                            <label>公司qq:</label>
                            <?php hhtml::text('qq', $record['qq'], 'id="qq_id" class="lf"');?>
							<span class="field_desc">field description</span>
                        </p>
						<p>
                            <label>公司msn:</label>
                            <?php hhtml::text('msn', $record['msn'], 'id="msn_id" class="lf"');?>
							<span class="field_desc">field description</span>
                        </p>
						<p>
                        <label>公司邮箱:</label>
                        <?php hhtml::text('email', $record['email'], 'id="email_id" class="lf"');?>
							<span class="field_desc">field description</span>
                        </p>
						<p>
                        <label>公司传真:</label>
                        <?php hhtml::text('fax', $record['fax'], 'id="fax_id" class="lf"');?>
							<span class="field_desc">field description</span>
                        </p>
                        <p class="p_editor">
							<label>公司地址:</label>
                            <?php hhtml::editor('address', $record['address'], 'id="editor_id" class="editor"');?>
							<span class="field_desc">field description</span>
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
