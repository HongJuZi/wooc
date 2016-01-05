		<div class="navbar navbar-inverse">
		  <div class="navbar-inner">
		   <div class="container-fluid">
              <a class="brand" href="<?php echo HResponse::url('', '', 'admin'); ?>">
                  <?php echo $siteCfg['name']; ?><small>后台管理平台</small>
                  <img src="<?php echo HResponse::uri('admin'); ?>/images/logo.png" />
              </a>
			  <ul class="nav ace-nav pull-right">
					<li class="green">
						<a href="<?php echo HResponse::url(); ?>" class="dropdown-toggle" target="_blank">
							<i class="icon-home icon-animated-vertical icon-only"></i>
							<span><?php HTranslate::_('去网站'); ?></span>
						</a>
					</li>
					<li class="purple">
						<a href="<?php echo HResponse::url('auser/logout', '', 'oauth'); ?>" class="dropdown-toggle">
							<i class="icon-off icon-animated-bell icon-only"></i>
							<span class=""><?php HTranslate::_('退出'); ?></span>
						</a>
					</li>
					<li class="red">
						<a class="lang-list dropdown-toggle" href="#" data-toggle="dropdown">
                            <i class="icon-globe"></i>
                            切换语言
                            <span class="icon-caret-down"></span>
                        </a>
                        <ul class="dropdown-menu dropdown-info pull-right">
                            <?php foreach($langMap as $lang){ ?>
                            <li>
                                <a href="<?php echo HRequest::getCurUrl(array('lang'), 'lang=' . $lang['id']); ?>">
                                    <?php echo $lang['name']; ?>
                                    <?php if(HSession::getAttribute('id', 'lang') == $lang['id']) { ?>
                                    <i class="icon-ok green"></i>
                                    <?php }?>
                                </a>
                            </li>
                            <?php }?>
                        </ul>
					</li>
					<li class="light-blue user-profile">
						<a class="user-menu dropdown-toggle" href="#" data-toggle="dropdown">
							<img src="<?php echo !HSession::getAttribute('image_path', 'user') ? HResponse::uri('admin') . '/avatars/user.jpg' :
                            HResponse::touri(HSession::getAttribute('image_path', 'user')); ?>" class="nav-user-photo" />
							<span id="user_info">
								<small><?php HTranslate::_('您好'); ?>,</small>
                                <?php echo HSession::getAttribute('name', 'user'); ?>
							</span>
							<i class="icon-caret-down"></i>
						</a>
						<ul id="user_menu" class="pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
                            <li>
                                <a href="<?php echo HResponse::url('information'); ?>">
                                    <i class="icon-cog"></i><?php HTranslate::_('网站设置'); ?>
                                </a>
                            </li>
							<li>
                                <a href="<?php echo HResponse::url('user/editview', 'id=' . HSession::getAttribute('id', 'user')); ?>">
                                    <i class="icon-user"></i><?php HTranslate::_('个人设置'); ?>
                                </a>
                            </li>
							<li class="divider"></li> 
                            <li>
                                <a href="<?php echo HResponse::url('auser/logout', '', 'oauth'); ?>">
                                    <i class="icon-off"></i><?php HTranslate::_('安全退出'); ?>
                                </a>
                            </li>
						</ul>
					</li>
			  </ul><!--/.ace-nav-->
		   </div><!--/.container-fluid-->
		  </div><!--/.navbar-inner-->
		</div><!--/.navbar-->
