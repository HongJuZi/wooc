<?php require_once(HResponse::path('template') . '/admin/common/header.tpl');?>
</head>
<body>
	<div id="container">
		<div id="bgwrap">
			<div id="primary_left">
				<?php require(HResponse::path('template') . '/admin/common/left_menu.tpl'); ?>
			</div> <!-- sidebar end -->
			<div id="primary_right">
				<div class="inner">
                    <?php require_once(HResponse::path('template') . '/admin/common/quick_control_pannel.tpl'); ?>
                    <div class="clearboth"></div>
                    <hr/>
					<h2>系统模块</h2>
                    <ul class="dash">
			            <?php
                            foreach(HResponse::getAttribute('list') as $category) {
                        ?>	
						<li class="fade_hover tooltip" title="<?php echo empty($category['description']) ?
                        $category['name'] : $category['description'];?>">
							<a href="<?php echo HResponse::url('admin/category/model', 'n=' . $category['id']);?>">
                                <?php HHtml::image(
                                        HResponse::uri() .
                                        HFile::getImageZoomTypePath(
                                            $category['image_path'],
                                            'qo'
                                        ), $category['name']); ?>
								<span><?php echo $category['name'];?></span>
							</a>
						</li>
					    <?php } ?>
					</ul> <!-- end dashboard items -->
                    <div class="clearboth"></div>
				</div> <!-- inner -->
			</div> <!-- primary_right -->
		</div> <!-- bgwrap -->
	</div> <!-- container -->
    <?php require_once(HResponse::path('template'). '/admin/common/footer.tpl');?>
</body>
</html>
