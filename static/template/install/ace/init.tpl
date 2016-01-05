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
                                <form role="form" method="post" action="<?php echo HResponse::url('setup');?>" id="init-form">
                                    <div class="container">
                                        <div class="step-pane active" id="step2">
                                            <h2>确认您的安装配置</h2>
                                            <div class="col-xs-6">
                                                <h3 class="header">1. 数据库配置</h3>
                                                <div class="form-group">
                                                    <label class="control-label" for="db-driver"> 数据库驱动器</label>
                                                    <select id="db-driver" name="dbDriver">
                                                        <option value="mysqli">Mysqli 原生函数驱动器</option>
                                                        <option value="mysql">Mysql 原生函数驱动器</option>
                                                        <option value="pdo">PDO 驱动MYSQL驱动器</option>
                                                    </select>
                                                    <div class="space-4"></div>
                                                    <small class="help-inline block">
                                                        （必填）请根据您的数据库类型选择合适的驱动器 
                                                    </small>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="control-label" for="db-host"> 数据库地址 </label>
                                                    <input type="text" id="db-host"
                                                        name="dbHost"
                                                        placeholder="请输入您的数据库服务器地址，如：localhost"
                                                        class="col-xs-12" value="localhost">
                                                    <small class="help-inline block">
                                                        （必填）您可能会使用 "localhost"
                                                    </small>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="control-label" for="db-port"> 数据库端口 </label>
                                                    <input type="text" id="db-port"
                                                        placeholder="请输入您的数据库服务器端口，默认为：3306"
                                                        name="dbPort"
                                                        class="col-xs-12" value="3306">
                                                    <small class="help-inline block">（必填）如果您不知道此选项的意义, 请保留默认设置</small>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="control-label" for="db-user"> 数据库用户名 </label>
                                                    <input type="text" id="db-user" name="dbUserName"
                                                        placeholder="请输入您的数据库服务器用户名，如：root"
                                                        class="col-xs-12" value="root">
                                                    <span class="help-inline block">（必填）您可能会使用 "root"</span>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="control-label" for="db-password"> 数据库密码 </label>
                                                    <input type="password" id="db-password"
                                                        name="dbUserPassword"
                                                        placeholder="请输入您的数据库服务器用户密码"
                                                        class="col-xs-12" value="">
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="control-label" for="db-name"> 数据库名 </label>
                                                    <input type="text" id="db-name"
                                                        name="dbName"
                                                        placeholder="请输入您的数据库名称"
                                                        class="col-xs-12" value="wooc">
                                                    <small class="help-inline block">（必填）请您指定数据库名称</small>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="control-label" for="table-prefix"> 数据库表前缀 </label>
                                                    <input type="text" id="table-prefix" placeholder="请输入您的数据表前缀"
                                                        name="tablePrefix"
                                                        class="col-xs-12" value="wooc_">
                                                        <small class="help-inline block">（必填）默认前缀是 "wooc_"</small>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                            <div class="col-xs-6">
                                                <h3 class="header">2. 设置您的网站信息</h3>
                                                <div class="form-group">
                                                    <label class="control-label" for="site-lang"> 默认语言</label>
                                                    <select id="site-lang" name="site_lang">
                                                        <?php foreach(HResponse::getAttribute('lang_id_list') as $lang) { ?>
                                                        <option value="<?php echo $lang['id']; ?>"><?php echo $lang['name']; ?></option>
                                                        <?php }?>
                                                    </select>
                                                    <div class="space-4"></div>
                                                    <small class="help-inline block">
                                                        （必填）请选择您网站使用的默认语言。
                                                    </small>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label" for="site_name"> 网站名称 </label>
                                                    <input type="text" id="site-name" name="site_name"
                                                        placeholder="请输入您的网站名称"
                                                        class="col-xs-12" value="你好 Wooc">
                                                    <small class="help-inline block">（必填）。</small>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <h3 class="header">3. 创建您的管理员账号</h3>
                                                <div class="form-group">
                                                    <label class="control-label" for="name"> 用户名 </label>
                                                    <input type="text" id="name" name="name"
                                                        placeholder="请输入您的用户名"
                                                        class="col-xs-12" value="admin">
                                                    <small class="help-inline block">（必填）请输入您的用户名，最少2个字符。</small>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="control-label" for="password"> 登陆密码 </label>
                                                    <input type="password" id="password"
                                                    name="password" class="col-xs-12"
                                                    value=""
                                                    placeholder="请输入您的登陆密码...">
                                                    <small class="help-inline block">
                                                    （必填）请填写您的登录密码, 如果留空系统将为您随机生成一个，最少6个字符。
                                                    </small>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="space-4"></div>
                                                <div class="form-group">
                                                    <label class="control-label" for="email"> 常用邮箱 </label>
                                                    <input type="text" id="email" placeholder="请输入您的常用邮箱地址" class="col-xs-12" value="" name="email">
                                                        <small class="help-inline block">（必填）请填写一个您的常用邮箱，用于找回密码等。</small>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="row-fluid text-right">
                                        <div class="container">        
                                            <a href="###" id="submit-btn" class="btn btn-primary btn-next btn-sm">
                                                确认， 开始安装 
                                                <i class="icon-arrow-right icon-on-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </form>
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
        <script type="text/javascript" src="<?php echo HResponse::uri(); ?>/js/init.js"></script>
    </body>
</html>
