<?php require_once(HResponse::path() . '/common/header.tpl'); ?>
</head>
	
	<body>
		<div class="login_wrap">
			<div class="header_wrap pt10">
				<div class="m_head clearfix">
					<div class="head_logo">
						<a href="<?php echo HResponse::url();?>" class="logo_b fl" title="校园派">校园派</a>
					</div>
				</div>
			</div>
			<div class="main_wrap">
				<div class="login clearfix">
					<div class="lg_left fl">
						<h1>用户登录</h1>
						<div class="lg_form">
							<form id="J_login_form" action="<?php echo HResponse::url('auser/login','','oauth');?>" method="post">
								<div class="lg_name clearfix">
									<span>用户名：</span>
									<input type="text" name="email" id="J_name" class="input_text" maxlength="20">
									<div id="J_nameTip" class="onShow"> </div>
								</div>
								<div class="lg_pass clearfix">
									<span>密码：</span>
									<input type="password" name="password" id="J_pass" class="input_text" maxlength="32">
									<div id="J_passTip" class="onShow"> </div>
								</div>
								<div class="lg_remember clearfix">
									<label>
										<input type="checkbox" value="1" name="remember" class="check" checked="checked">
										<span>记住我（两周免登录）</span>
									</label>
								</div>
								<div class="lg_login">
									<input type="hidden" value="<?php echo HResponse::getAttribute('next_url');?>" name="next_url">
									<input type="submit" value="登录" class="sub">
									<a href="<?php echo HResponse::url('userinfo/findpasswd');?>">忘记密码？</a>
								</div>
							</form>
							<div class="ot_login">
								<span>您也可以用以下方式登录：</span>
								<div class="ot_btn">
									<a href="" class="mr5">
										<img src="<?php echo HResponse::uri();?>/images/login_sina.png">
									</a>
									<a href="" class="mr5">
										<img src="<?php echo HResponse::uri();?>/images/login_qq.png">
									</a>
									<a href="" class="mr5">
										<img src="<?php echo HResponse::uri();?>/images/login_taobao.png">
									</a>
								</div>
							</div>
						</div>
					</div>
					<div class="lg_right">
						<h2>注册</h2>
						<span style="margin-left:40px;">还没有账号？</span>
						<a style="margin-left:40px;" class="reg" href="<?php echo HResponse::url('userinfo/register');?>">轻松注册</a>
					</div>
				</div>
			</div>
			
			<div class="w960"><!--矩形广告位--></div>
			<?php require_once(HResponse::path() . '/common/footer.tpl'); ?>
			<script>
				$(function(){
    				$.pinphp.user.login_validate($('#J_login_form')); //登陆验证
				});
			</script>
		</div>
	</body>
</html>