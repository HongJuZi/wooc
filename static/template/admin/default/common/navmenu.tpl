		<div class="navbar navbar-inverse">
		  <div class="navbar-inner">
		   <div class="container-fluid">
              <a class="brand" href="<?php echo HResponse::url('', '', 'admin'); ?>">
                  红橘子信息科技<small>后台管理平台</small>
                  <img src="<?php echo HResponse::uri('admin'); ?>/images/logo.png" />
              </a>
			  <ul class="nav ace-nav pull-right">
					<li class="green">
						<a href="<?php echo HResponse::url(); ?>" class="dropdown-toggle" target="_blank">
							<i class="icon-home icon-animated-vertical icon-only"></i>
							<span class=""><?php HResponse::lang('GO_SITE'); ?></span>
						</a>
					</li>
					<li class="purple">
						<a href="<?php echo HResponse::url('auser/logout', '', 'oauth'); ?>" class="dropdown-toggle">
							<i class="icon-off icon-animated-bell icon-only"></i>
							<span class=""><?php HResponse::lang('LOGOUT'); ?></span>
						</a>
					</li>
					<li class="light-blue user-profile">
						<a class="user-menu dropdown-toggle" href="#" data-toggle="dropdown">
							<img alt="<?php echo HSession::getAttribute('userName'); ?>"
                            src="<?php echo !HSession::getAttribute('image_path', 'user') ?
                            HResponse::uri('admin') . '/avatars/user.jpg' :
                            HResponse::url() . HSession::getAttribute('image_path', 'user'); ?>" class="nav-user-photo" />
							<span id="user_info">
								<small><?php HResponse::lang('HELLO'); ?>,</small><?php echo HSession::getAttribute('name', 'user'); ?>
							</span>
							<i class="icon-caret-down"></i>
						</a>
						<ul id="user_menu" class="pull-right dropdown-menu dropdown-yellow
                        dropdown-caret dropdown-closer"><li><a href="<?php echo
                        HResponse::url('siteconfig'); ?>"><i
                        class="icon-cog"></i><?php HResponse::lang('SETTING'); ?></a></li>
							<li><a href="<?php echo HResponse::url('user/editview', 'id=' . HSession::getAttribute('id', 'user')); ?>"><i class="icon-user"></i><?php HResponse::lang('PROFILE'); ?></a></li>
							<li class="divider"></li> <li><a href="<?php echo HResponse::url('auser/logout', '', 'oauth');
                            ?>"><i class="icon-off"></i><?php HResponse::lang('LOGOUT_SYSTEM'); ?></a></li>
						</ul>
					</li>
			  </ul><!--/.ace-nav-->
		   </div><!--/.container-fluid-->
		  </div><!--/.navbar-inner-->
		</div><!--/.navbar-->
