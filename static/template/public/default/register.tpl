<?php require_once(HResponse::path() . '/common/header.tpl'); ?>
</head>

<body>
	<div class="reg_wrap">
		<div class="header_wrap pt10">
			<div class="m_head clearfix">
				<div class="head_logo">
					<a href="http://www.chaobaida.net/" class="logo_b fl" title="潮百搭">潮百搭</a>
				</div>
			</div>
		</div>
		<div class="main_wrap">
			<div class="registerbox clearfix">
				<div class="register_left">
					<h1>新用户注册</h1>
					<form id="J_register_form" action="<?php echo HResponse::url('auser/register','','oauth');?>" method="post">
						<div class="ipt_mail">
							<span>电子邮箱：</span>
							<input type="text" maxlength="36" name="email" id="J_email" class="input_text">
							<div id="J_emailTip" class="onError">请输入邮件地址</div>
						</div>
						<div class="ipt_ulike">
							<span>用户名：</span>
							<input maxlength="36" type="text" name="name" id="J_username" class="input_text">
							<div id="J_usernameTip" class="onError">请输入用户名</div>
						</div>
						<div class="ipt_sex">
							<span>性别：</span>
							<div class="rdo">
								<label><input type="radio" name="sex" value="0" checked="checked" class="ck">女</label>
								<label><input type="radio" name="sex" value="1" class="ck ml10">男</label>
							</div>
						</div>
						<div class="ipt_password">
							<span>密码：</span>
							<input maxlength="36" type="password" name="password" id="J_password" class="input_text">
							<div id="J_passwordTip" class="onError">密码太短啦，至少要6位哦</div>
						</div>
						<div class="ipt_respassword">
							<span>确认密码：</span>
							<input type="password" maxlength="36" name="repassword" id="J_repassword" class="input_text">
							<div id="J_repasswordTip" class="onError">请重复输入一次密码</div>
						</div>
						<div class="ipt_check">
							<span>验证码：</span>
							<input type="text" name="captcha" id="J_captcha" maxlength="10" class="check input_text">
							<img src="<?php echo HResponse::url('vcode');?>" id="J_captcha_img" class="captcha_img" alt="验证码">
							<a href="###" id="vcode_change">换一张</a>
							<div id="J_captchaTip" class="onError">请输入验证码</div>
						</div>
						<div class="ipt_box">
							<input class="box fl" name="agreement" type="checkbox" checked="checked">
							<span class="fl">我已看过并同意《<a href="javascript:;" id="J_protocol_btn">潮百搭网络服务使用协议</a>》</span>
						</div>
						<div class="ipt_sub">
							<input type="submit" id="J_regsub" class="sub" value="轻松注册">
						</div>
					</form>
				</div>
				<div class="register_right">
					<div class="rst_login">
						<span>已经有帐号？请直接登录</span>
						<a href="<?php echo HResponse::url('userinfo/login');?>">登录</a>
					</div>
					<div class="other_login">
						<span>您也可以用以下方式登录：</span>
						<a href="http://www.chaobaida.net/index.php?m=oauth&a=index&mod=sina" class="o_icon">
							<img src="<?php echo HResponse::uri('public');?>/images/sina_icon.png">微博登陆
						</a>
						<a href="http://www.chaobaida.net/index.php?m=oauth&a=index&mod=qq" class="o_icon">
							<img src="<?php echo HResponse::uri('public');?>/images/qq_icon.png">QQ登录
						</a>
						<a href="http://www.chaobaida.net/index.php?m=oauth&a=index&mod=taobao" class="o_icon">
							<img src="<?php echo HResponse::uri('public');?>/images/tao_icon.png">淘宝登录
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="w960"><!--矩形广告位--></div>
		
		<?php require_once(HResponse::path() . '/common/footer.tpl'); ?>
			<script type="text/javascript">
				var PINER = {
				    root: "",
				    uid: "", 
				    async_sendmail: "",
				    config: {
				        wall_distance: "500",
				        wall_spage_max: "5"
				    },
				    //URL
				    url: {}
				};
				//语言项目
				var lang = {};
				lang.please_input = "请输入";lang.username = "用户名";lang.password = "密码";lang.login_title = "用户登陆";
				lang.share_title = "我要分享";lang.correct_itemurl = "正确的商品地址";lang.join_album = "加入专辑";
				lang.create_album = "创建新专辑";lang.edit_album = "修改专辑";lang.confirm_del_album = "删除专辑，专辑里所有的图片都会被删除哦！你确定要删除此专辑吗？";
				lang.title = "标题";lang.card_loading = "正在获取用户信息";lang.confirm_unfollow = "确定要取消关注么？";lang.wait = "请稍后......";
				lang.user_protocol = "网络服务使用协议";lang.email = "邮件地址";lang.email_tip = "请填写正确的常用邮箱，以便找回密码";
				lang.email_format_error = "邮件格式不正确";lang.email_exists = "电子邮件地址已经被使用";lang.username_tip = "最多20个字符，中文算两个字符";
				lang.username_exists = "这昵称太热门了，被别人抢走啦，换一个吧";lang.password_tip = "20个字符，数字、字母或者符号";
				lang.password_too_short = "密码太短啦，至少要6位哦";lang.password_too_long = "密码太长";lang.repassword_tip = "这里要重复输入一次密码";
				lang.repassword_empty = "请重复输入一次密码";lang.passwords_not_match = "两次输入的密码不一致";lang.captcha_tip = "输入图片中的字符";
				lang.captcha_empty = "请输入验证码";lang.uploading_cover = "封面上传中，请稍后......";lang.consignee = "收货人";lang.address = "详细地址";
				lang.mobile = "手机";
			</script>
			<script type="text/javascript">
				$(function(){
			    	$.pinphp.user.register_form($('#J_register_form')); //注册验证
				});
				$(function(){
					$("#vcode_change").click(function(){
						var src = "<?php echo HResponse::url('vcode');?>"+"?n="+Math.random();
						$("#J_captcha_img").attr('src',src);
					});
				});
			</script>
		<div id="J_protocol" class="hide">
			<pre class="dialog_protocol clr6">
				一、总则
				用户应当同意本协议的条款并按照页面上的提示完成全部的注册程序。
				用户在进行注册程序过程中点击"立即注册"按钮即表示用户与潮百搭公司达成协议，完全接受本协议项下的全部条款。
			</pre>
		</div>
	</div>
	
</body>
</html>




