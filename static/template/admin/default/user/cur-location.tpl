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
                            <div class="row-fluid">
                              <div class="span7">
                                <h2 class="title">
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
                                </h2>
                              </div>
                              <div class="span5 text-right">
                              <div class="btn-group">
                                  <a href="javascript:void(0);" class="btn btn-mini btn-success dropdown-toggle" data-toggle="dropdown">
                                      微信用户功能
                                      <span class="caret"></span>
                                  </a>
                                  <ul class="dropdown-menu text-left">
                                    <li><a href="javascript:void(0);" id="btn-wx-list">获取列表</a></li>
                                    <li><a href="javascript:void(0);" id="btn-wx-info">获取基本信息</a></li>
                                    <li><a href="javascript:void(0);" id="btn-wx-group">用户分组</a></li>
                                    <li><a href="javascript:void(0);" id="btn-wx-pos">用户地理位置</a></li>
                                  </ul>
                              </div>
                                <a href="<?php echo HResponse::url($modelEnName . '/addview', $catId); ?>" class="mr-10 btn btn-mini btn-default">添加新信息</a> 
                              </div>
                            </div>
						</div><!--/page-header-->                   
