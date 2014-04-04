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
                    <form name="model_form" action="<?php echo HResponse::url('siteconfig/' . HResponse::getAttribute('nextAction'));?>" method="post">
					<fieldset>
                        <legend>网站配置</legend>
                        <h2>基本设置</h2>
						<p>
                            <label>网站名称:</label>
                            <?php HHtml::text('site_name', HObject::GC('SITE_NAME'), 'id="site_name_id" class="lf"');?>
                            <span class="field_desc">网站叫啥名称。</span>
                        </p>
						<p>
                            <label>网站域名:</label>
                            <?php HHtml::text('site_url', HObject::GC('SITE_URL'), 'id="site_url_id" class="lf"');?>
							<span class="field_desc">如：http://www.example.com</span>
                        </p>
						<p>
                        <label>公司CEO:</label>
                        <?php HHtml::text('ceo', $record['ceo'], '', 'ceo-id', 'lf');?>
							<span class="field_desc">如：http://www.example.com</span>
                        </p>
						<p>
                        <label>网站SEO关键字:</label>
                        <?php HHtml::textarea('seo_keywords', HObject::GC('SEO_KEYWORDS'),
                                'id="seo_keywords_id" class="lf"');?>
							<span
                            class="field_desc">用于搜索引擎优化，描述网站有哪些服务，如：旅游｜国外旅游｜国内旅游等，中间用"｜"分开。</span>
                        </p>
                        <p>
                            <label>网站SEO描述:</label>
                            <?php HHtml::textarea('seo_desc', HObject::GC('SEO_DESC'), 'id="seo_desc_id" class="lf"');?>
							<span class="field_desc">用于搜索引擎优化，简要描述网站的功能，300字以内。</span>
                        </p>
                        <p>
							<label>公司理念:</label>
                            <?php HHtml::textarea('slogan', $record['slogan'], 'id="slogan_id" class="mf"');?>
							<span class="field_desc"></span>
						</p>
						<p>
                            <label>公司电话:</label>
                            <?php HHtml::text('phone', $record['phone'], 'id="phone_id" class="lf"');?>
							<span class="field_desc">如：0745-2826523</span>
                        </p>
						<p>
                            <label>公司微博:</label>
                            <?php HHtml::text('weibo', $record['weibo'], 'id="weibo_id" class="lf"');?>
							<span class="field_desc">如：http://www.weibo.com/xxxx</span>
                        </p>
						<p>
                            <label>公司QQ:</label>
                            <?php HHtml::text('qq', $record['qq'], 'id="qq_id" class="lf"');?>
							<span class="field_desc">最多支持两个，请用“,”分开（英语的输入法状态下的逗号）。</span>
                        </p>
						<p>
                            <label>公司MSN:</label>
                            <?php HHtml::text('msn', $record['msn'], 'id="msn_id" class="lf"');?>
							<span class="field_desc">如：example@live.com</span>
                        </p>
						<p>
                            <label>公司邮箱:</label>
                            <?php HHtml::text('email', $record['email'], '', 'id="email_id" class="lf"');?>
							<span class="field_desc">如：example@example.com</span>
                        </p>
						<p>
                            <label>邮政编码:</label>
                            <?php HHtml::text('code', $record['code'], 'id="code_id" class="lf"');?>
							<span class="field_desc">如：418000</span>
                        </p>
						<p>
                            <label>公司传真:</label>
                            <?php HHtml::text('fax', $record['fax'], 'id="fax_id" class="lf"');?>
							<span class="field_desc">如：010-12323423</span>
                        </p>
                        <p>
							<label>公司地址:</label>
                            <?php HHtml::textarea('address', $record['address'], 'id="address_id" class="mf"');?>
							<span class="field_desc">详细的所在地</span>
						</p>
                        <div class="field-area">
							<label>最新公告:</label>
                            <?php 
                                HHtml::editor('message', $record['message'], 'id="editor-id" class="editor"');
                            ?>
							<span class="field_desc">最新的网站通知等。</span>
						</div>
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
