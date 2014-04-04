            <a href="#" id="menu-toggler"><span></span></a><!-- menu toggler -->
			<div id="sidebar">
				
				<div id="sidebar-shortcuts">
					<div id="sidebar-shortcuts-large">
						<a class="btn btn-small btn-success" href="<?php echo HResponse::url('category'); ?>"><i class="icon-tag" title="<?php HResponse::lang('CLASSIFICATION'); ?>"></i></a>
						<a class="btn btn-small btn-info" href="<?php echo HResponse::url('article'); ?>" title="<?php HResponse::lang('ARTICLE'); ?>"><i class="icon-pencil"></i></a>
						<a class="btn btn-small btn-warning" href="<?php echo HResponse::url('user'); ?>" title="<?php HResponse::lang('MEMBER'); ?>"><i class="icon-group"></i></a>
						<a class="btn btn-small btn-danger" href="<?php echo HResponse::url('company'); ?>" title="公司信息"><i class="icon-file"></i></a> 
					</div>
					<div id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>
						<span class="btn btn-info"></span>
						<span class="btn btn-warning"></span>
						<span class="btn btn-danger"></span>
					</div>
				</div><!-- #sidebar-shortcuts -->

				<ul class="nav nav-list">
					
					<li>
					  <a href="<?php echo HResponse::url('', '', 'admin'); ?>" class="single">
						<i class="icon-dashboard"></i>
						<span>后台桌面</span>
					  </a>
					</li>
					<li>
					  <a href="<?php echo HResponse::url('company'); ?>" class="single" >
                        <i class="icon-file"></i>
						<span>公司信息</span>
					  </a>
					</li>
					<li>
					  <a href="<?php echo HResponse::url('article'); ?>" class="single" >
                        <i class="icon-book"></i>
						<span>文章管理</span>
					  </a>
					</li>
					<li>
					  <a href="<?php echo HResponse::url('category'); ?>" class="single" >
                        <i class="icon-folder-open"></i>
						<span>信息分类</span>
					  </a>
					</li>
					<li>
					  <a href="<?php echo HResponse::url('navmenu'); ?>" class="single" >
                        <i class="icon-globe"></i>
						<span>导航菜单</span>
					  </a>
					</li>
					<li>
					  <a href="<?php echo HResponse::url('banner'); ?>" class="single" >
                        <i class="icon-picture"></i>
						<span>幻灯片大图</span>
					  </a>
					</li>
					<li>
					  <a href="###" class="dropdown-toggle" >
                        <i class="icon-wrench"></i>
						<span><?php HResponse::lang('SYSTEM_TOOLS'); ?></span>
						<b class="arrow icon-angle-down"></b>
					  </a>
					  <ul class="submenu">
						<li><a href="<?php echo HResponse::url('email'); ?>"><i class="icon-double-angle-right"></i><?php HResponse::lang('WRITE_EMAIL'); ?></a></li>
                        <li><a href="<?php echo HResponse::url('dbtool'); ?>"><i class="icon-double-angle-right"></i><?php HResponse::lang('DATABASE_TOOLS'); ?></a></li>
					  </ul>
					</li>
					<li>
					  <a href="###" class="dropdown-toggle" >
                        <i class="icon-group"></i>
						<span>系统管理员</span>
						<b class="arrow icon-angle-down"></b>
					  </a>
					  <ul class="submenu">
						<li><a href="<?php echo HResponse::url('user'); ?>"><i class="icon-double-angle-right"></i><?php HResponse::lang('SYSTEM_USER'); ?></a></li>
                        <li><a href="<?php echo HResponse::url('actor'); ?>"><i class="icon-double-angle-right"></i>系统角色</a></li>
					  </ul>
					</li>
				</ul><!--/.nav-list-->
				<div id="sidebar-collapse"><i class="icon-double-angle-left"></i></div>
			</div><!--/#sidebar-->

