<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
	</head>
	<body>
        <?php require_once(HResponse::path('admin') . '/common/navmenu.tpl'); ?>
		<div class="container-fluid" id="main-container">
            <?php require_once(HResponse::path('admin') . '/common/sidebar.tpl'); ?>
			<div id="main-content" class="clearfix">
					<div id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
                                <i class="icon-home"></i> <a href="<?php echo HResponse::url('admin'); ?>">后台桌面</a>
                                <span class="divider"><i class="icon-angle-right"></i></span>
                            </li>
							<li class="active">网站配置</li>
						</ul><!--.breadcrumb-->
						<div id="nav-search">
							<form class="form-search" action="<?php echo HResponse::url('email/search'); ?>" method="post">
									<span class="input-icon">
										<input autocomplete="off" id="nav-search-input" type="text" class="input-small search-query" placeholder="搜索 ..." name="keywords"/>
										<i id="nav-search-icon" class="icon-search"></i>
									</span>
							</form>
						</div><!-- #nav-search -->
					</div><!-- #breadcrumbs -->
					<div id="page-content" class="clearfix">
						<div class="page-header position-relative">
							<h1>系统配置<small><i class="icon-double-angle-right"></i>网站配置</small></h1>
						</div><!--/page-header-->
						<div class="row-fluid">
                            <form class="form-horizontal" action="<?php echo HResponse::url('siteconfig/edit'); ?>" method="post" id="info-form">
                                <?php $record = HResponse::getAttribute('record');?>
                                <div class="control-group">
                                    <label class="control-label" for="site-name">网站名称</label>
                                    <div class="controls">
                                        <input type="text" id="site-name"
                                        placeholder="网站名称" name="site_name" value="<?php echo HObject::GC('SITE_NAME'); ?>" class="span6">
                                        <span class="help-inline">网站名称。</span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="site-url">网站域名</label>
                                    <div class="controls">
                                        <input type="text" id="site-url" placeholder="网站域名" name="site_url" value="<?php echo HObject::GC('SITE_URL'); ?>" class="span6">
                                        <span class="help-inline">网站域名。</span>
                                    </div>
                                </div>
                                <div class="control-group"> 
                                    <label class="control-label" for="ceo">网站负责人</label>
                                    <div class="controls">
                                        <input type="text" id="ceo" placeholder="网站负责人" name="ceo" value="<?php echo $record['ceo']; ?>" class="span6">
                                        <span class="help-inline">网站负责人员。</span>
                                    </div>
                                </div>
                                <div class="control-group"> 
                                    <label class="control-label" for="seo-keywords">网站SEO关键字</label>
                                    <div class="controls">
                                        <textarea id="seo-keywords" placeholder="网站SEO关键字" name="seo_keywords" class="span6"><?php echo HObject::GC('SEO_KEYWORDS'); ?></textarea>
                                        <span class="help-inline">网站SEO关键字。</span>
                                    </div>
                                </div>
                                <div class="control-group"> 
                                    <label class="control-label" for="seo-desc">网站SEO描述</label>
                                    <div class="controls">
                                        <textarea id="seo-desc"
                                        placeholder="网站SEO关键字" name="seo_desc" class="span6"><?php
                                        echo HObject::GC('SEO_DESC'); ?></textarea>
                                        <span class="help-inline">网站SEO描述。</span>
                                    </div>
                                </div>
                                <div class="control-group"> 
                                    <label class="control-label" for="phone">公司电话</label>
                                    <div class="controls">
                                        <input type="text" id="phone" placeholder="公司电话" name="phone" value="<?php echo $record['phone']; ?>" class="span6">
                                        <span class="help-inline">如：0745-2826523。</span>
                                    </div>
                                </div>
                                <div class="control-group"> 
                                    <label class="control-label" for="weibo">公司微博</label>
                                    <div class="controls">
                                        <input type="text" id="weibo" placeholder="公司微博" name="weibo" value="<?php echo $record['weibo']; ?>" class="span6">
                                        <span class="help-inline">如：http:://www.weibo.com/xjiujiu。</span>
                                    </div>
                                </div>
                                <div class="control-group"> 
                                    <label class="control-label" for="qq">客服QQ</label>
                                    <div class="controls">
                                        <input type="text" id="weibo" placeholder="客服QQ" name="qq" value="<?php echo $record['qq']; ?>" class="span6">
                                        <span class="help-inline">可以有多个，如：123456，33223245。</span>
                                    </div>
                                </div>
                                <div class="control-group"> 
                                    <label class="control-label" for="email">公司邮箱</label>
                                    <div class="controls">
                                        <input type="text" id="email" placeholder="公司邮箱" name="email" value="<?php echo $record['email']; ?>" class="span6">
                                        <span class="help-inline">可以有多个，如：example@example.com。</span>
                                    </div>
                                </div>
                                <div class="control-group"> 
                                    <label class="control-label" for="address">公司地址</label>
                                    <div class="controls">
                                        <textarea id="address" placeholder="公司地址" name="address" class="span6"><?php echo $record['address']; ?></textarea>
                                        <span class="help-inline">您公司的地址位置。</span>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button class="btn btn-info" type="submit"><i class="icon-ok"></i>提交</button>
                                    &nbsp; &nbsp; &nbsp;
                                    <button class="btn" type="reset"><i class="icon-undo"></i>重置</button>
                                </div>
                                <div class="hr"></div>
                             </form>
						 </div><!--/row-->
					</div><!--/#page-content-->
                    <!-- PAGE CONTENT ENDS HERE -->
                <?php require_once(HResponse::path('admin') . '/common/setting-bar.tpl'); ?>  
			</div><!-- #main-content -->
		</div><!--/.fluid-container#main-container-->
        <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/dbtools.js"></script>
	</body>
</html>
