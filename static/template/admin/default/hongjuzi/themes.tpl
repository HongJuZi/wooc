<?php require_once(HObject::GC('TPL_DIR') . '/admin/common/header.tpl');?>
    <style type="text/css">
        ul, li { border: 0px; margin: 0px; padding: 0px; }
        ul.theme_list li { float: left; min-width: 100px; line-height: 20px; list-style-type: none; }
    </style>
</head>
<body>
	<div id="container">
		<div id="bgwrap">
			<div id="primary_left">
                <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/left_menu.tpl'); ?>
			</div> <!-- sidebar end -->
			<div id="primary_right">
				<div class="inner">
                    <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/quick_control_pannel.tpl');?>
                    <div class="clearfix"></div>
					<hr />
                    <h1>管理主题</h1>
					 <div class="sortable">
						<div class="two_third column">
						  <div class="portlet">
							<div class="portlet-header">当前使用主题</div>
                            <?php $currentTheme   = HResponse::getAttribute('currentTheme');?>
							<div class="portlet-content tpl-item" style="display: block;">
                                <?php 
                                    HHtml::image(HResponse::uri('template') . '/themes/'
                                            . $currentTheme['name'] .'/' . $currentTheme['image'],
                                            'class="current_theme_img theme_img"');
                                ?>
                                <p><strong>主题作者：</strong><?php echo $currentTheme['author'];?></p>
                                <p><strong>主题简介：</strong><?php echo $currentTheme['desc'];?></p>
                                <p><strong>主题目录位置：</strong><?php echo $currentTheme['path'];?></p>
							</div>
						  </div>
						</div>
                        <div class="clearfix"></div>
                        <hr />
                        <h2>可用主题</h2>
                        <?php
                            foreach(HResponse::getAttribute('themes') as $key => $theme) {
                        ?>
                        <div class="one_third <?php echo ($key + 1) % 3 == 0 ? 'last' : '';?> column">
						  <div class="portlet">
							<div class="portlet-header">
                                <?php echo $theme['name'];?>
                                <a name="<?php echo $theme['name']?>"></a>
                            </div>
							<div class="portlet-content tpl-item" style="display: block;">
                                <p>
                                <?php
                                    if(!isset($theme['error'])) {
                                        HHtml::image(HResponse::uri('theme') . $theme['name'] .'/' . $theme['image'], 'class="theme_img"');
                                ?>
                                <br/>
                                <label>主题作者：</label>
                                <span class="validate_success"><?php echo $theme['author'];?></span>
                                <br/>
                                <label>主题简介：</label>
                                <span class="validate_success"><?php echo $theme['desc'];?></span>
                                <?php } else { ?>
                                <label>错误信息：</label>
                                <span class="validate_error"> <?php echo $theme['error'] . '</span><br/>'; }?>
                                <br/>
                                <label>主题目录位置：</label>
                                <span class="validate_success"><?php echo $theme['path'];?></span>
                                <br/>
                                <label>管理项：</label>
                                <span class="validate_success">
                                    <a href="<?php echo HResponse::url('themes/open', '?name=' . $theme['name']);?>">启用</a> |
                                    <a href="<?php echo HResponse::url('themes/preview', '?name=' . $theme['name']);?>">预览</a> |
                                    <a href="<?php echo HResponse::url('themes/delete', '?name=' . $theme['name']);?>">删除</a>
                                </span>
                                <br/>
                                <br/>
                                </p>
							</div>
						  </div>
						</div>
                        <?php
                                echo ($key + 1) % 3 == 0 ? '<hr />' : '';
                            }
                        ?>
					  </div> <!-- sortable end -->
					  <div class="clearboth"></div>
					<?php echo ($key + 1) % 3 != 0 ? '<hr />' : ''; ?>
				</div> <!-- inner -->
			</div> <!-- primary_right -->
		</div> <!-- bgwrap -->
	</div> <!-- container -->
    <?php require_once(HResponse::path('tpl') . '/admin/common/footer.tpl');?>
</body>
</html>
