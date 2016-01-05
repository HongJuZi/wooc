                    <div id="breadcrumbs">
						<ul class="breadcrumb">
							<li>
                                <i class="icon-home"></i> <a href="<?php echo HResponse::url('', '', 'admin'); ?>">后台桌面</a>
                                <span class="divider"><i class="icon-angle-right"></i></span>
                            </li>
							<li><a href="<?php echo HResponse::url($modelEnName); ?>"><?php echo $modelZhName; ?></a> <span class="divider"><i class="icon-angle-right"></i></span></li>
							<li class="active"><?php echo $modelZhName; ?><?php HTranslate::_('内容'); ?></li>
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
                                        HTranslate::_('编辑');
                                        echo ' - ';
                                        echo isset($record['name']) ? $record['name'] : 'ID：' . $record['id'];
                                    } else {
                                        !HResponse::getAttribute('list') ? HTranslate::_('添加') : '';
                                        HTranslate::_($modelZhName);
                                        echo $copyRecord ? '(' . HTranslate::__('基于') . 'ID：' . $copyRecord['id'] . ')' : '';
                                    }
                                    $catId  = !HRequest::getParameter('cat') ? '' : 'cat=' . HRequest::getParameter('cat');
                                ?>
                                <small>
                                <i class="icon-double-angle-right"></i>
                               【 <a href="<?php echo HResponse::url($modelEnName .  '/addview', $catId); ?>">添加新信息</a> 】
                                </small>
                            </h1>
						</div><!--/page-header-->                   
