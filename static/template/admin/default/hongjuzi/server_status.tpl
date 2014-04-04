<?php require_once(HObject::GC('TPL_DIR') . '/admin/common/header.tpl');?>
    
</head>
<body>
	<div id="container">
		<div id="bgwrap">
			<div id="primary_left">
                <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/left_menu.tpl'); ?>
			</div> <!-- sidebar end -->
			<div id="primary_right">
				<div class="inner">
                    <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/quick_control_pannel.tpl');?>
                    <div class="clearfix"></div>
					<hr />
                    <h1>服务器当前信息</h1>
					 <div class="sortable">
						<div class="two_third column">
						  <div class="portlet">
							<div class="portlet-header">web服务器信息</div>
                            <?php $serverInfo = hresponse::getattribute('serverInfo');?>
							<div class="portlet-content" style="display: block;">
                                <p>
                                    <label>php版本：</label>
                                    <span class="validate_success"><?php echo $serverInfo['php_version']?></span>
                                    <br />
                                    <label>php运行方式：</label>
                                    <span class="validate_success"><?php echo $serverInfo['php_run_method'];?></span>
                                    <br />
                                    <label>zend引擎版本：</label>
                                    <span class="validate_success"><?php echo $serverInfo['zend_version']; ?></span>
                                    <br />
                                    <label>服务器端口：</label>
                                    <span class="validate_success"><?php echo $serverInfo['server_port']; ?></span>
                                    <br />
                                    <label>主域名：</label>
                                    <span class="validate_success"><?php echo $serverInfo['server_host']; ?></span>
                                    <br />
                                    <label>服务器ip：</label>
                                    <span class="validate_success"><?php echo $serverInfo['server_ip']; ?></span>
                                    <br />
                                    <label>扩展支持：</label>
                                    <span class="validate_success"><?php echo $serverInfo['extensions']; ?></span>
                                    <br />
                                    <label>最大上传文件大小：</label>
                                    <span class="validate_success"><?php echo $serverInfo['upload_max_filesize']; ?></span>
                                    <br />
                                    <label>最大内存使用限制：</label>
                                    <span class="validate_success"><?php echo $serverInfo['memory_limit']; ?></span>
                                    <br />
                                    <label>服务器端软件信息：</label>
                                    <span class="validate_success"><?php echo $serverInfo['server_software']; ?></span>
                                </p>
							</div>
						  </div>
						</div>
						<div class="one_third last column">
						  <div class="portlet">
							<div class="portlet-header">操作系统信息</div>
                            <?php $osInfo = hresponse::getattribute('osInfo');?>
							<div class="portlet-content" style="display: block;">
                                <p>
                                    <label>系统名称：</label>
                                    <span class="validate_success"><?php echo $osInfo['os_name']?></span>
                                    <br/>
                                    <label>系统版本：</label>
                                    <span class="validate_success"><?php echo $osInfo['os_version'];?></span>
                                    <br/>
                                    <label>系统类型：</label>
                                    <span class="validate_success"><?php echo $osInfo['os_type']; ?></span>
                                    <br/>
                                    <label>稳定版本号：</label>
                                    <span class="validate_success"><?php echo $osInfo['os_release']; ?></span>
                                    <br/>
                                    <label>机器类型：</label>
                                    <span class="validate_success"><?php echo $osInfo['machine_type']; ?></span>
                                    <br/>
                                    <label>当前用户进程：</label>
                                    <span class="validate_success"><?php echo $osInfo['current_user']; ?></span>
                                </p>
							</div>
						  </div>
						</div>
                        <hr />
						<div class="two_third column">
						  <div class="portlet">
							<div class="portlet-header">数据库服务器信息</div>
                            <?php $dbInfo   = hresponse::getattribute('dbInfo'); ?>
							<div class="portlet-content" style="display: block;">
                                <p>
                                    <label>类型：</label>
                                    <span class="validate_success"><?php echo $dbInfo['db_type']?></span>
                                    <br/>
                                    <label>当前驱动：</label>
                                    <span class="validate_success"><?php echo $dbInfo['db_driver'];?></span>
                                    <br/>
                                    <label>版本号：</label>
                                    <span class="validate_success"><?php echo $dbInfo['db_version'];?></span>
                                    <br/>
                                    <label>mysql持续连接：</label>
                                    <span class="validate_success"><?php echo $dbInfo['db_persistent']; ?></span>
                                    <br/>
                                    <label>mysql最大连接数：</label>
                                    <span class="validate_success"><?php echo $dbInfo['max_connect_number']; ?></span>
                                </p>
							</div>
						  </div>
						</div>
						<div class="one_third last column">
						  <div class="portlet">
							<div class="portlet-header">缓存服务器信息</div>
							<div class="portlet-content" style="display: block;">
							  <p>暂无缓存服务器相关信息！</p>
							</div>
						  </div>
						</div>
					  </div> <!-- sortable end -->
					  <div class="clearboth"></div>
					<hr />
				</div> <!-- inner -->
			</div> <!-- primary_right -->
		</div> <!-- bgwrap -->
	</div> <!-- container -->
    <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/footer.tpl');?>
    <script text="text/javascript">
        jQuery(function() {
            jQuery(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all").find(".portlet-header").addClass("ui-widget-header ui-corner-all").prepend('<span class="ui-icon ui-icon-circle-arrow-s"></span>').end().find(".portlet-content");
            jQuery(".portlet-header .ui-icon").click(function() {
                jQuery(this).toggleClass("ui-icon-minusthick");
                jQuery(this).parents(".portlet:first").find(".portlet-content").toggle();
            });
        });
    </script>
</body>
</html>
