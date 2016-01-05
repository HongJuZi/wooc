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
                        <li class="active">操作数据库</li>
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
                        <h1>数据库工具&amp;备份、恢复<small><i class="icon-double-angle-right"></i>操作面板</small></h1>
                    </div><!--/page-header-->
                    <div class="row-fluid">
                    <!-- PAGE CONTENT BEGINS HERE -->
                        <div class="span6">
                            <div class="widget-box">
                              <div class="widget-header"><h4>备份数据库</h4></div>
                              <div class="widget-body">
                               <div class="widget-main no-padding">
                                <form action="<?php echo HResponse::url('dbtool/backup'); ?>" method="post" id="backup-form">
                                  <!-- <legend>Form</legend> -->
                                  <fieldset>
                                    <label>保存文件名</label>
                                    <input type="text" value="backup-<?php echo date('Ymdhms')?>" name="backup_file_name" id="backup-file-name"/>
                                    <span class="help-block">如：backup-2012; 系统将自动保存为*.sql文件格式。</span>
                                  </fieldset>
                                  <div class="form-actions center">
                                    <button type="submit" class="btn btn-small btn-success">开始备份 <i class="icon-arrow-right icon-on-right"></i></button>
                                  </div>
                                </form>
                               </div>
                              </div>
                            </div>
                        </div>
                        <div class="span6">
                            <div class="widget-box">
                              <div class="widget-header"><h4>数据库恢复</h4></div>
                              <div class="widget-body">
                               <div class="widget-main no-padding">
                                <form action="<?php echo HResponse::url('dbtool/recovery'); ?>" method="post" id="recovery-form">
                                  <!-- <legend>Form</legend> -->
                                  <fieldset>
                                        <label>上传需要恢复的文件</label>
                                        <div class="ace-file-input span8">
                                            <input type="file" id="recovery-file" name="recovery_file" class="file-path"/>
                                            <label data-title="选择" for="recovery-file">
                                                <span data-title="没有文件"><i class="icon-upload-alt"></i></span>
                                            </label>
                                            <a class="remove" href="#"><i class="icon-remove"></i></a>
                                        </div>
                                        <span class="help-block clearfix">只支持通过系统备份后下载的.sql文件。</span>
                                  </fieldset>
                                  <div class="form-actions center">
                                    <button type="submit" class="btn btn-small btn-success">开始恢复 <i class="icon-arrow-right icon-on-right"></i></button>
                                  </div>
                                </form>
                               </div>
                              </div>
                            </div>
                        </div>
                     </div><!--/row-->
                </div><!--/#page-content-->
                <!-- PAGE CONTENT ENDS HERE -->
			</div><!-- #main-content -->
		</div><!--/.fluid-container#main-container-->
        <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/dbtools.js"></script>
	</body>
</html>
