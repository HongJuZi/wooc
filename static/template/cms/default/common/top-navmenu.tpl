	<div class="header">
		<div class="header-top">
			<div class="wrapper">
				<img src="<?php echo HResponse::uri(); ?>/images/logo.png"/>
				<div class="header-top-right">
					<span>人工服务热线</span><br/>
                    <?php $siteCfg    = HResponse::getAttribute('siteCfg'); ?>
					<strong><?php echo $siteCfg['phone']; ?></strong>
				</div>
			</div>
		</div>
        <div class="header-mune">
			<div class="wrapper1">
				<div class="mune">
					<ul>
                        <?php 
                            foreach(HResponse::getAttribute('navmenuList') as $navmenu) { 
                                $url    = 0 === strpos($navmenu['jump_url'], 'http://') ? $navmenu['jump_url'] : HResponse::url($navmenu['jump_url']);
                        ?>
						<li><a  href="<?php echo $url; ?>"><?php echo $navmenu['name']; ?></a></li>
                        <?php } ?>
					</ul>
				</div>
			</div>
		</div>

