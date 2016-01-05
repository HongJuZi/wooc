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
									<li data-target="#step1" class="complete">
										<span class="step">1</span>
										<span class="title">欢迎使用</span>
									</li>

									<li data-target="#step2" class="active">
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
                                        <h2>
                                            Woo~，安装出错了！
                                        </h2>
                                        <div class="alert alert-danger">
                                            <p><strong>出错项目：</strong></p>
                                            <div class="content">
                                                <ul>
                                                    <?php foreach(HResponse::getAttribute('errors') as $key => $error) { ?>
                                                    <li>
                                                        <?php echo $error; ?>
                                                        <a href="http://wooc.hongjuzi.net/faq?i=<?php echo $key;?>" target="_blank">
                                                            [点击查看错误说明]
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <p>
                                                <a href="<?php echo HResponse::getAttribute('redoUrl'); ?>" class="btn btn-sm btn-success">
                                                    完成修正，继续重试
                                                    <i class="icon-arrow-right icon-on-right"></i>
                                                </a>
                                                <em>（注意, 请修正完以下问题才可以继续安装! ） </em>
                                            </p>
                                        </div>
    								</div>
    							</div>
    							<hr />
    							<div class="row-fluid text-right">
                                    <div class="container text-center join-us-box">
                                        <h2 class="title join-us-title">参与讨论</h2>
                                        <p>
                                            <a href="###"><i class="icon-plus"></i> 加入 Wooc QQ交流群</a>
                                            <a href="###"><i class="icon-comment"></i> 进入 Wooc 讨论区</a>
                                        </p>
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
