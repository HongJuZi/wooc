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
                        <li class="active">写邮件</li>
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
                        <h1>新邮件<small><i class="icon-double-angle-right"></i>邮件信息</small></h1>
                    </div><!--/page-header-->
                    <div class="row-fluid">
                    <!-- PAGE CONTENT BEGINS HERE -->
                        <form class="form-horizontal" action="<?php echo HResponse::url('email/send'); ?>" method="post" enctype="multipart/form-data" id="info-form">
                            <div class="control-group">
                                <label class="control-label" for="subject">标题</label>
                                <div class="controls span6">
                                    <input type="text" id="subject" placeholder="标题" name="subject" value="" class="span6">
                                    <span class="help-inline">长度：100个中文字符以内。</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="to">收件人</label>
                                <div class="controls span6">
                                    <input type="text" id="to" placeholder="收件人" name="to" value="" class="span6"/>
                                    <span class="help-inline">有效的Email地址，如：example@example.com</span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="image-path">添加附件</label>
                                <div class="controls">
                                    <div class="span5"><input type="file" name="attachments" class="file-path" id="file-path"/></div>
                                    <span class="help-inline">
                                        支持的文件类型：.rar, .zip, .jpg, .png, .gif; 大小：小于5M以下。
                                    </span>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="content">邮件内容</label>
                                <div class="controls">
                                    <textarea name="content" id="content" style="width: 800px;" class="editor"></textarea>
                                </div>
                            </div>
                            <script type="text/javascript">editorList.push('content');</script>
                            <?php require_once(HResponse::path('admin') .  '/common/info-form-buttons.tpl'); ?>
                            <div class="hr"></div>
                         </form>
                     </div><!--/row-->
                </div><!--/#page-content-->
                <!-- PAGE CONTENT ENDS HERE -->
			</div><!-- #main-content -->
		</div><!--/.fluid-container#main-container-->
        <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/email.js"></script>
	</body>
</html>
