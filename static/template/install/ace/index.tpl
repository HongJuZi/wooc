<?php require_once(HResponse::path() . '/common/header.tpl'); ?>	
    </head>
	<body>
        <?php require_once(HResponse::path() . '/common/navmenu.tpl'); ?>	
		<div class="main-container" id="main-container">
			<div class="main-container-inner">
				<div class="page-content">
					<div class="row-fluid">
						<div class="span12 main-box">
							<h1 class="title text-center">Wooc</h1>
							<div id="fuelux-wizard" class="row-fluid" data-target="#step-container">
								<ul class="wizard-steps">
									<li data-target="#step1" class="active">
										<span class="step">1</span>
										<span class="title">欢迎使用</span>
									</li>

									<li data-target="#step2">
										<span class="step">2</span>
										<span class="title">初始化配置</span>
									</li>

									<li data-target="#step3">
										<span class="step">3</span>
										<span class="title">开始安装</span>
									</li>

									<li data-target="#step4">
										<span class="step">4</span>
										<span class="title">安装成功</span>
									</li>
								</ul>
							</div>

							<hr />
							<div class="step-content row-fluid position-relative" id="step-container">
                                <div class="container">
    								<div class="step-pane active" id="step1">
    									<h2>欢迎使用 Wooc</h2>

                                        <h3 >安装说明</h3>
                                        
                                        <p>本安装程序将自动检测服务器环境是否符合最低配置需求. 如果不符合, 将在上方出现提示信息, 请按照提示信息检查您的主机配置.  如果服务器环境符合要求, 将在下方出现"开始下一步"的按钮, 点击此按钮即可一步完成安装.</p>
                                        <h3 >许可及协议</h3>
                                        
                                        <p>Wooc 基于 GPL 协议发布, 我们允许用户在 GPL 协议许可的范围内使用, 拷贝, 修改和分发此程序. 在GPL许可的范围内，您可以自由地将其用于商业以及非商业用途.</p>
                                        
                                        <p>Wooc 软件由<a href="http://www.hongjuzi.net" target="_blank"> 红橘子科技工作室 </a>提供支持,核心开发团队负责维护程序日常开发工作以及新特性的制定.  如果您遇到使用上的问题, 程序中的 BUG, 以及期许的新功能, 欢迎您在 Wooc 社区中交流或者直接向我们贡献代码. 对于贡献突出者, 他的名字将出现在贡献者名单中，期待您的提交！</p>
                                        <h3 >版本信息</h3>
                                        <p>当前版本：<strong>1.0.0</strong></p>
    								</div>
    							</div>
    							<hr />
    							<div class="row-fluid text-right">
                                    <div class="container">        
        								<a href="<?php echo HResponse::url('init'); ?>" class="btn btn-primary btn-next btn-sm">
        									我准备好了， 开始安装
        									<i class="icon-arrow-right icon-on-right"></i>
        								</a>
                                    </div>
    							</div>
    						</div>
                         </div>
					</div>
				</div>
			</div><!-- /.page-content -->
			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->
        <?php require_once(HResponse::path() . '/common/footer.tpl'); ?>	
    </body>
</html>
