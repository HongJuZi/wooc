		<div class="navbar navbar-default" id="navbar">
			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
                    <a href="http://www.hongjuzi.net?from=wooc1.0.0" class="navbar-brand" target="_blank">
                        红橘子科技工作室
                        <img src="<?php echo HResponse::uri(); ?>/images/logo.png">
                    </a>
				</div><!-- /.navbar-header -->
				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
                        <li class="red">
                            <a class="lang-list dropdown-toggle" href="#" data-toggle="dropdown">
                                <i class="icon-globe"></i>
                                <?php HTranslate::_('切换语言'); ?>
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
                        <li class="light-blue dropdown-info">
                            <a class="dropdown-toggle" href="###" data-toggle="dropdown">
                                <i class="icon-question"></i>
                                <?php HTranslate::_('安装帮助'); ?>
                                <span class="icon-caret-down"></span>
                            </a>
                            <ul class="pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
                                <li>
                                    <a href="http://wooc.hongjuzi.net/help">
                                        <i class="icon-cog"></i><?php HTranslate::_('官方QQ交流群'); ?>
                                    </a>
                                </li>
                                <li>
                                    <a href="http://wooc.hongjuzi.net/help">
                                        <i class="icon-cog"></i><?php HTranslate::_('官方帮助手册'); ?>
                                    </a>
                                </li>
                            </ul>
                        </li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>
