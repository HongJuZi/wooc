<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
	</head>
	<body>
        <?php require_once(HResponse::path('admin') . '/common/navmenu.tpl'); ?>
		<div class="container-fluid" id="main-container">
            <?php require_once(HResponse::path('admin') . '/common/sidebar.tpl'); ?>
			<div id="main-content" class="clearfix">
                    <?php $record         = HResponse::getAttribute('record'); ?>    
                    <div id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
                                <i class="icon-home"></i> <a href="<?php echo
                                HResponse::url('', '', 'admin'); ?>">后台桌面</a>
                                <span class="divider"><i class="icon-angle-right"></i></span>
                            </li>
							<li><a href="<?php echo HResponse::url($modelEnName); ?>"><?php echo $modelZhName; ?></a> <span class="divider"><i class="icon-angle-right"></i></span></li>
							<li class="active"><?php echo $modelZhName; ?><?php HResponse::lang('CONTENT'); ?></li>
						</ul><!--.breadcrumb-->
						<div id="nav-search">
                            <span id="time-info">正在加载时钟...</span>
						</div><!-- #nav-search -->
					</div><!-- #breadcrumbs -->
                    <div id="page-content" class="clearfix">
						<div class="page-header position-relative">
							<h1>管理<?php echo $modelZhName; ?></h1>
						</div><!--/page-header-->
						<div class="row-fluid">
                        <!-- PAGE CONTENT BEGINS HERE -->
                            <form class="form-horizontal" action="<?php echo HResponse::url($modelEnName . '/' . HResponse::getAttribute('nextAction') ); ?>" method="post" enctype="multipart/form-data" id="info-form">
                               <div class="tabbable tabs-right tabs-shadow tabs-space">
                                    <ul class="nav nav-tabs" id="myTab">
                                      <li class="active"><a data-toggle="tab" href="#base-box"><i class="pink icon-leaf bigger-110"></i> 基本信息</a></li>
                                      <li><a data-toggle="tab" href="#phone-box"><i class="green icon-phone bigger-110"></i> 联系方式</a></li>
                                      <li><a data-toggle="tab" href="#seo-box"><i class="blue icon-barcode bigger-110"></i> SEO优化</a></li>
                                      <li><a data-toggle="tab" href="#manage-box"><span class="badge badge-success badge-icon"><i class="icon-cog"></i></span> 管理维护</a></li>
                                    </ul>
                                <div class="tab-content">
                                  <div id="base-box" class="tab-pane in active">
                                    <?php $field = 'id'; require(HResponse::path('admin') . '/fields/hidden.tpl'); ?>
<?php $field = 'site_name'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'image_path'; require(HResponse::path('admin') . '/fields/file.tpl'); ?>
<?php $field = 'description'; require(HResponse::path('admin') . '/fields/textarea.tpl'); ?>
<?php $field = 'content'; require(HResponse::path('admin') . '/fields/editor.tpl'); ?>
<?php $field = 'copyright'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>

                                  </div>
                                  <div id="phone-box" class="tab-pane">
<?php $field = 'administrator'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'qq'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'weibo'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'weixin'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'wangwang'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'email'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'phone'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'fax'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php $field = 'address'; require(HResponse::path('admin') . '/fields/textarea.tpl'); ?>
                                  </div>
                                  <div id="seo-box" class="tab-pane">
                                    <?php $field = 'seo_keywords'; require(HResponse::path('admin') . '/fields/textarea.tpl'); ?>
<?php $field = 'seo_desc'; require(HResponse::path('admin') . '/fields/textarea.tpl'); ?>
                                  </div>
                                  <div id="manage-box" class="tab-pane">
<?php $field = 'website_id'; require(HResponse::path('admin') . '/fields/hidden.tpl'); ?>
                                    <?php $field = 'create_time'; require(HResponse::path('admin') . '/fields/datetime.tpl'); ?>
<?php require_once(HResponse::path('admin') . '/fields/author.tpl'); ?>
                                  </div>
                                <?php require_once(HResponse::path('admin') . '/common/info-form-buttons.tpl'); ?>
                              </div>
                             </form>
                        <!-- PAGE CONTENT ENDS HERE -->
						 </div><!--/row-->
					</div><!--/#page-content-->
                <?php require_once(HResponse::path('admin') . '/common/setting-bar.tpl'); ?>  
			</div><!-- #main-content -->
		</div><!--/.fluid-container#main-container-->
        <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/info.js"></script>
	</body>
</html>
