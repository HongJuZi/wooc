<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
        <link rel="stylesheet" href="<?php echo HResponse::uri('cdn'); ?>/jquery/plugins/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
	</head>
	<body>
        <?php require_once(HResponse::path('admin') . '/common/navmenu.tpl'); ?>
		<div class="container-fluid" id="main-container">
            <?php require_once(HResponse::path('admin') . '/common/sidebar.tpl'); ?>
			<div id="main-content" class="clearfix">
                    <?php $record         = HResponse::getAttribute('record');  ?>
                    <?php require_once(HResponse::path('admin') . '/common/cur-location.tpl'); ?>
                    <div class="row-fluid">
                    <!-- PAGE CONTENT BEGINS HERE -->
                        <form class="form-horizontal" action="<?php echo HResponse::url($modelEnName . '/' . HResponse::getAttribute('nextAction') ); ?>" method="post" enctype="multipart/form-data" id="info-form">
                            <div class="tabbable tabs-right tabs-shadow tabs-space">
                                <ul class="nav nav-tabs" id="myTab">
                                    <li class="active"><a data-toggle="tab" href="#base-box"><i class="pink icon-leaf bigger-110"></i> 基本信息</a></li>
                                    <li><a data-toggle="tab" href="#right-box"><span class="badge badge-success badge-icon"><i class="icon-cog"></i></span> 权限分类</a></li>
                                    <li><a data-toggle="tab" href="#manage-box"><span class="badge badge-success badge-icon"><i class="icon-cog"></i></span> 管理维护</a></li>
                                </ul>
                                <div class="tab-content">
                                  <div id="base-box" class="tab-pane in active">
                                    <input type="hidden" name="id" value="<?php echo $record['id'];?>" />
                                    <?php $field = 'sort_num'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
                                    <?php $field = 'name'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
                                    <?php $field = 'identifier'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
                                    <?php $field = 'description'; require(HResponse::path('admin') . '/fields/textarea.tpl'); ?>
                                  </div>
                                  <div id="right-box" class="tab-pane">
                                    <h3>
                                        <a href="###" class="pull-right checked-all-btn" data-id="0">
                                            <i class="icon-check"></i> 全选
                                        </a>
                                        <a href="###" class="pull-right cancel-all-btn" data-id="0"><i class="icon-remove"></i> 取消</a>
                                    权限配置
                                    </h3>
                                    <hr/>
                                    <div id="accordion" class="accordion-style1 panel-group rights-box">
                                        <?php 
                                            $hasRightsMap   = HResponse::getAttribute('hasRightsMap');
                                            foreach(HResponse::getAttribute('topRightsList') as $key => $top) {  
                                        ?>
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    <a href="###" class="pull-right checked-all-btn" data-id="<?php echo $top['id'];?>">
                                                        <i class="icon-check"></i> 全选
                                                    </a>
                                                    <a href="###" class="pull-right cancel-all-btn" data-id="<?php echo $top['id'];?>"><i class="icon-remove"></i> 取消</a>
                                                    <a class="accordion-toggle"
                                                    data-toggle="collapse"
                                                    data-parent="#accordion"
                                                    href="#collapse-<?php echo $key?>">
                                                        <i class="icon-angle-down bigger-110" data-icon-hide="icon-angle-down" data-icon-show="icon-angle-right"></i>
                                                        &nbsp;<?php echo $top['name']; ?>
                                                    </a>
                                                </h4>
                                            </div>
                                            <div class="panel-collapse collapse <?php echo $key === 0 ? 'in' : '';?>" id="collapse-<?php echo $key;?>">
                                                <div class="panel-body" id="group-<?php echo $top['id'];?>">
                                                    <div class="row-fulid">
                                                    <?php 
                                                        $key    = 1;
                                                        foreach(HResponse::getAttribute('subRightsList') as $sub) { 
                                                            if($top['id'] != $sub['parent_id']) { continue; }
                                                    ?>
                                                        <div class="checkbox span3">
                                                            <label>
                                                                <input name="rights[]"
                                                                type="checkbox"
                                                                class="ace rights-item" value="<?php
                                                                echo $sub['id'];?>" <?php echo isset($hasRightsMap[$sub['id']]) ? 'checked' : '';?>/>
                                                                <span class="lbl"> <?php echo $sub['name']; ?></span>
                                                            </label>
                                                        </div>
                                                    <?php 
                                                            if($key % 4 == 0) {
                                                                echo '</div><div class="row-fulid">';
                                                            }
                                                            $key ++;
                                                        }
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php }?>
                                    </div>
                                  </div>
                                  <div id="manage-box" class="tab-pane">
                                    <?php $field = 'create_time'; require(HResponse::path('admin') . '/fields/date.tpl'); ?>
                                    <?php require_once(HResponse::path('admin') . '/fields/author.tpl'); ?>
                                  </div>
                                </div>
                              </div>
                            <?php require_once(HResponse::path('admin') .  '/common/info-form-buttons.tpl'); ?>
                         </form>
                        <div class="clearfix"></div>
                    <!-- PAGE CONTENT ENDS HERE -->
                     </div><!--/row-->
                </div><!--/#page-content-->
			</div><!-- #main-content -->
		</div><!--/.fluid-container#main-container-->
        <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/info.js"></script>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/actor-info.js"></script>
	</body>
</html>
