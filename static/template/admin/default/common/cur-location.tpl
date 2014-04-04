                    <div id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
                                <i class="icon-home"></i> <a href="<?php echo HResponse::url('', '', 'admin'); ?>">后台桌面</a>
                                <span class="divider"><i class="icon-angle-right"></i></span>
                            </li>
							<li><a href="<?php echo HResponse::url($modelEnName); ?>"><?php echo $modelZhName; ?></a> <span class="divider"><i class="icon-angle-right"></i></span></li>
							<li class="active"><?php echo $modelZhName; ?><?php HResponse::lang('CONTENT'); ?></li>
						</ul><!--.breadcrumb-->
						<div id="nav-search">
                            <span id="time-info">正在加载时钟...</span>
						</div><!-- #nav-search -->
					</div><!-- #breadcrumbs -->
                    <div id="page-content" class="clearfix">
						<div class="page-header position-relative">
							<h1>
                                <?php
                                    if(!empty($record)) {
                                        echo HResponse::lang('EDIT');
                                    } else {
                                        echo !HResponse::getAttribute('list') ?  HResponse::lang('ADD') : '';
                                    }
                                    echo $modelZhName;
                                ?>
                                <small>
                                <i class="icon-double-angle-right"></i>
                                <?php
                                    if(!empty($record)) {
                                        echo  $record['name'] . '【<a href="' . HResponse::url($modelEnName, 'id=' . $record['id']) . '">查看信息</a>】'; 
                                    }
                                ?>
                               【<a href="<?php echo HResponse::url($modelEnName . '/addview'); ?>">添加新信息</a>】
                                </small>
                            </h1>
						</div><!--/page-header-->                   
