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
                                <i class="icon-home"></i> <a href="<?php echo HResponse::url('', '', 'admin'); ?>">后台桌面</a>
                            </li>
                        </ul><!--.breadcrumb-->

						<div id="nav-search">
                            <span id="time-info">正在加载时钟...</span>
						</div><!--#nav-search-->
					</div><!--#breadcrumbs-->
					<div id="page-content" class="clearfix">
						<div class="page-header position-relative">
							<h1>后台桌面<small><i class="icon-double-angle-right"></i> 功能 & 概况</small></h1>
						</div><!--/page-header-->
						<div class="row-fluid">
                            <div class="space-6"></div>
                            <div class="row-fluid">
                             <div class="span12">
                                <div class="widget-box transparent">
                                    <div class="widget-header">
                                        <h4 class="lighter smaller"><i class="icon-rss orange"></i>功能项目</h4>
                                        <div class="widget-toolbar no-border">
                                            <ul class="nav nav-tabs" id="model-tab">
                                                <li class="active"><a data-toggle="tab"
                                                href="#normal-tab">常用功能</a></li>
                                                <li><a data-toggle="tab"
                                                href="#system-tab">系统功能</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                     <div class="widget-main padding-5">
                                        <div class="tab-content padding-8">
                                            <div id="normal-tab" class="tab-pane active">
                                                <div class="clearfix">
                                                    <?php foreach(HResponse::getAttribute('list') as $model) {?>
                                                    <div class="itemdiv memberdiv">
                                                        <div class="user">
                                                            <img alt="<?php echo $model['name']; ?>" src="<?php echo HResponse::url() . $model['image_path']; ?>" />
                                                        </div>
                                                        <div class="body">
                                                            <div class="name"><a href="<?php echo HResponse::url('' . $model['identifier']); ?>"><?php echo $model['name']; ?></a></div>
                                                            <div class="time"><i class="icon-info-sign"></i> <span class="green"><?php echo $model['description'];?></span></div>
                                                        </div>
                                                    </div>
                                                    <?php }?>
                                                </div>
                                            </div>
                                            
                                            <div id="system-tab" class="tab-pane">
                                                <div class="clearfix">
                                                    <div class="itemdiv memberdiv">
                                                        <div class="user">
                                                            <img alt="模块状态" src="<?php echo HResponse::uri('admin'); ?>/images/status.png" />
                                                        </div>
                                                        <div class="body">
                                                            <div class="name"><a href="<?php echo HResponse::url('modelstatus'); ?>">模块状态</a></div> <div class="time"><i class="icon-time"></i><span class="green">系统模块状态信息</span></div>
                                                        </div>
                                                    </div>
                                                    <div class="itemdiv memberdiv">
                                                        <div class="user">
                                                            <img alt="服务器状态" src="<?php echo HResponse::uri('admin'); ?>/images/server.png" />
                                                        </div>
                                                        <div class="body">
                                                            <div class="name"><a href="<?php echo HResponse::url('server'); ?>">服务器状态</a></div> <div class="time"><i class="icon-time"></i><span class="green">系统服务器信息</span></div>
                                                        </div>
                                                    </div>
                                                    <div class="itemdiv memberdiv">
                                                        <div class="user">
                                                            <img alt="技术支持" src="<?php echo HResponse::uri('admin'); ?>/images/help.png" />
                                                        </div>
                                                        <div class="body">
                                                            <div class="name"><a href="http://www.hongjuzi.net">技术支持</a></div> <div class="time"><i class="icon-time"></i><span class="green">系统技术问题支持</span></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- member-tab -->
                                        </div>
                                     </div><!--/widget-main-->
                                    </div><!--/widget-body-->
                                </div><!--/widget-box-->
                             </div><!--/span-->
                             </div><!-- /row -->
                             <div class="vspace"></div>
                            </div><!--/row-->
                            <!-- PAGE CONTENT ENDS HERE -->
						 </div><!--/row-->
                         <div class="hr hr8"></div>
					</div><!--/#page-content-->
					<?php require_once(HResponse::path('admin') . '/common/setting-bar.tpl'); ?>  
			</div><!-- #main-content -->
		</div><!--/.fluid-container#main-container-->
        <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
    </body>
</html>
