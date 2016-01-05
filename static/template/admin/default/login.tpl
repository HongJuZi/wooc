<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
	</head>
	<body class="login-layout">
		<div class="container-fluid" id="main-container">
			<div id="main-content">
				<div class="row-fluid">
					<div class="span12">
                        <div class="login-container">
                        <div class="row-fluid">
                            <div class="center">
                                <h1><span class="white"><?php echo $siteCfg['name']; ?></span></h1>
                                <h4 class="blue">
                                    &copy; 2015 
                                    <a href="http://www.hongjuzi.net" target="_blank">
                                        红橘子科技有限公司
                                        <img src="<?php echo HResponse::uri(); ?>/images/logo.png" />
                                    </a>
                                </h4>
                            </div>
                        </div>
                        <div class="space-6"></div>
                        <div class="row-fluid">
                        <div class="position-relative">
                            <div id="login-box" class="visible widget-box no-border">
                                <div class="widget-body">
                                 <div class="widget-main">
                                    <h4 class="header lighter bigger"><i class="icon-coffee green"></i>请输入您的的登陆信息</h4>
                                    <div class="space-6"></div>
                                    <form action="<?php echo HResponse::url('auser/login', '', 'oauth'); ?>" id="login-form" method="post">
                                         <fieldset>
                                            <label>
                                                <span class="block input-icon input-icon-right">
                                                    <input type="text" class="span12" placeholder="注册邮箱" name="email" id="in-email"/>
                                                    <i class="icon-user"></i>
                                                </span>
                                            </label>
                                            <label>
                                                <span class="block input-icon input-icon-right">
                                                    <input type="password" class="span12" placeholder="密码" id="password" name="password"/>
                                                    <i class="icon-lock"></i>
                                                </span>
                                            </label>
                                            <label>
                                                <span class="block input-icon input-icon-right">
                                                    <img src="<?php echo HResponse::url('vcode', '', 'public'); ?>" class="span3" title="看不清楚?请点击更换." id="vcode-img"/>
                                                    <input type="text" class="span9" placeholder="请输入验证码..." id="vcode" name="vcode" data-def="请输入验证码..."/>
                                                </span>
                                            </label>
                                            <div class="space"></div>
                                            <div class="row-fluid">
                                                <label class="span8">
                                                    <input type="checkbox" name="remember" value="1"><span class="lbl">记住我</span>
                                                </label>
                                                <button id="login-btn" class="span4 btn btn-small btn-primary"><i class="icon-key"></i>进入系统</button>
                                                <input type="hidden" value="<?php echo HResponse::url('', '', 'admin'); ?>" name="next_url" />
                                            </div>
                                          </fieldset>
                                    </form>
                                 </div><!--/widget-main-->
                                 <div class="toolbar clearfix">
                                    <div>
                                        <a href="#" id="forgot-box-btn" class="forgot-password-link"><i class="icon-arrow-left"></i>忘记密码?</a>
                                    </div>
                                    <div>
                                        <a href="<?php echo HResponse::url(); ?>" class="user-signup-link">返回网站?<i class="icon-arrow-right"></i></a>
                                    </div>
                                 </div>
                                </div><!--/widget-body-->
                            </div><!--/login-box-->
                            
                            <div id="forgot-box" class="widget-box no-border">
                                <div class="widget-body">
                                 <div class="widget-main">
                                    <h4 class="header red lighter bigger"><i class="icon-key"></i>找回密码</h4>
                                    <div class="space-6"></div>
                                    <p>请输入您的管理邮箱地址</p>
                                    <form action="<?php echo HResponse::url('enter/send'); ?>" id="forgot-form">
                                         <fieldset>
                                            <label>
                                                <span class="block input-icon input-icon-right">
                                                    <input type="email" class="span12" placeholder="邮箱地址" id="email" name="email"/>
                                                    <i class="icon-envelope"></i>
                                                </span>
                                            </label>
                                            <div class="row-fluid">
                                                <button id="forgot-btn" class="span5 offset7 btn btn-small btn-danger"><i class="icon-lightbulb"></i>发送邮件!</button>
                                            </div>
                                          </fieldset>
                                    </form>
                                 </div><!--/widget-main-->
                                
                                 <div class="toolbar center">
                                    <a href="#" id="login-box-btn" class="back-to-login-link">返回登陆<i class="icon-arrow-right"></i></a>
                                 </div>
                                </div><!--/widget-body-->
                            </div><!--/forgot-box-->
                        </div><!--/position-relative-->
                        </div>
                        </div>
					</div><!--/span-->
				</div><!--/row-->
			</div>
		</div><!--/.fluid-container-->
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/hjz-extend.js"></script>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/login.js"></script>
	</body>
</html>
