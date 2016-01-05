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

									<li data-target="#step2" class="complete">
										<span class="step">2</span>
										<span class="title">初始化配置</span>
									</li>

									<li data-target="#step3" class="active" id="step3">
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
    								<div class="step-pane active">
                                        <h2>
                                            <span class="pull-right" id="progress-percent">20%</span>
                                            安装进度
                                        </h2>
                                        <div class="progress progress-mini">
                                            <div class="progress-bar progress-danger" style="width: 20%;" id="progress-bar"></div>
                                        </div>
                                        <div class="well">
                                            <h4 class="green smaller lighter">正在安装</h4>
                                            <ul class="job-list" id="job-list">
                                                <li>创建系统配置文件。<i class="green icon-ok"></i> </li>
                                            </ul>
                                        </div>
                                        <input id="site-name" type="hidden" value="<?php echo HRequest::getParameter('site_name'); ?>"/>
                                        <input id="site-lang" type="hidden"  value="<?php echo HRequest::getParameter('site_lang'); ?>"/>
                                        <input id="name" type="hidden" value="<?php echo HRequest::getParameter('name'); ?>" />
                                        <input id="password" type="hidden" value="<?php echo HRequest::getParameter('password'); ?>" />
                                        <input id="email" type="hidden" value="<?php echo HRequest::getParameter('email'); ?>" />
    								</div>
    							</div>
    							<hr />
    							<div class="row-fluid text-right">
                                    <div class="container">        
        								<a href="javascript:history.go(-1);" class="btn btn-sm btn-grey hide" id="goback-btn">
        									<i class="icon-arrow-left icon-on-left"></i>
        									返回上一步
        								</a>
        								<button class="btn btn-sm btn-primary hide" id="continue-btn">
                                            <i class="icon-refresh blue"></i>
        									错误修正，刷新继续安装
        									<i class="icon-arrow-right icon-on-right"></i>
        								</button>
        								<button class="btn btn-sm disabled" id="progress-btn">
                                            <i class="icon-spinner icon-spin white bigger-125"></i>
        									正在安装，请稍等...
        									<i class="icon-arrow-right icon-on-right"></i>
        								</button>
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
        <script type="text/javascript" src="<?php echo HResponse::uri(); ?>/js/setup.js"></script>
    </body>
</html>
