            <a href="#" id="menu-toggler"><span></span></a><!-- menu toggler -->
            <div id="sidebar" class="menu-min" data-spy="affix" data-offset-top="60">
				<div id="sidebar-shortcuts">
					<div id="sidebar-shortcuts-large">
						<a class="btn btn-small btn-success" href="<?php echo HResponse::url('category'); ?>"><i class="icon-tag" title="分类"></i></a>
						<a class="btn btn-small btn-info" href="<?php echo HResponse::url('article'); ?>" title="文章"><i class="icon-pencil"></i></a>
						<a class="btn btn-small btn-warning" href="<?php echo
                        HResponse::url('user/addview'); ?>" title="<?php HTranslate::_('用户'); ?>"><i class="icon-group"></i></a>
						<a class="btn btn-small btn-danger" href="<?php echo HResponse::url('information'); ?>" title="网站信息"><i class="icon-info"></i></a> 
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
						<i class="icon-desktop"></i>
						<span><?php HTranslate::_('后台桌面'); ?></span>
					  </a>
					</li>
					<li>
					  <a href="<?php echo HResponse::url('article'); ?>" class="single" >
                        <i class="icon-file"></i>
						<span>文章管理</span>
					  </a>
					</li>
					<li>
					  <a href="###" class="dropdown-toggle" >
                        <i class="icon-folder-open"></i>
						<span>信息分类</span>
						<b class="arrow icon-angle-down"></b>
					  </a>
					  <ul class="submenu">
						<li><a href="<?php echo HResponse::url('category/addview'); ?>"><i class="icon-double-angle-right"></i> 添加分类</a></li>
                        <?php foreach(HResponse::getAttribute('rootCatList') as $cat) { ?>
						<li><a href="<?php echo HResponse::url('category/search', 'type=' . $cat['id']); ?>"><i class="icon-double-angle-right"></i> <?php echo $cat['name']; ?></a></li>
                        <?php } ?>
						<li><a href="<?php echo HResponse::url('category'); ?>"><i class="icon-double-angle-right"></i> 所有分类</a></li>
					  </ul>
					</li>
					<li>
					  <a href="<?php echo HResponse::url('navmenu'); ?>" class="single" >
                        <i class="icon-list"></i>
						<span>导航菜单</span>
					  </a>
					</li>
					<li>
					  <a href="<?php echo HResponse::url('information'); ?>" class="single" >
                        <i class="icon-info"></i>
						<span>网站信息</span>
					  </a>
					</li>
					<li>
					  <a href="<?php echo HResponse::url('contact'); ?>" class="single" >
                        <i class="icon-phone"></i>
						<span>联系方式</span>
					  </a>
					</li>
					<li>
					  <a href="<?php echo HResponse::url('staticcfg'); ?>" class="single" >
                        <i class="icon-code"></i>
						<span>静态配置</span>
					  </a>
					</li>
					<li>
					  <a href="<?php echo HResponse::url('theme'); ?>" class="single" >
                        <i class="icon-magic"></i>
						<span>主题管理</span>
					  </a>
					</li>
					<li>
					  <a href="###" class="dropdown-toggle" >
                        <i class="icon-group"></i>
						<span>系统用户</span>
						<b class="arrow icon-angle-down"></b>
					  </a>
					  <ul class="submenu">
						<li><a href="<?php echo HResponse::url('user'); ?>"><i class="icon-double-angle-right"></i><?php HTranslate::_('系统用户'); ?></a></li>
                        <li><a href="<?php echo HResponse::url('actor'); ?>"><i class="icon-double-angle-right"></i>系统角色</a></li>
					  </ul>
					</li>

				</ul><!--/.nav-list-->
				<div id="sidebar-collapse"><i class="icon-double-angle-left"></i></div>
			</div><!--/#sidebar-->

