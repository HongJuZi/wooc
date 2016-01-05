<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
        <link rel="stylesheet" href="<?php echo HResponse::uri('cdn'); ?>/jquery/plugins/ztree/css/zTreeStyle/zTreeStyle.css" />
	</head>
	<body>
        <?php require_once(HResponse::path('admin') . '/common/navmenu.tpl'); ?>
		<div class="container-fluid" id="main-container">
            <?php require_once(HResponse::path('admin') . '/common/sidebar.tpl'); ?>
			<div id="main-content" class="clearfix">
                <?php require_once(HResponse::path('admin') . '/common/cur-location.tpl'); ?>
                    <div class="row-fluid">
                        <div class="span7">
                            <!-- PAGE CONTENT BEGINS HERE -->
                            <div id="table_report_wrapper" class="dataTables_wrapper" role="grid">
                                <?php require_once(HResponse::path('admin') . '/common/list-tool-bar.tpl'); ?>
                                <?php require_once(HResponse::path('admin') . '/fields/data-grid.tpl'); ?>
                            <!-- PAGE CONTENT ENDS HERE -->
                             </div><!--/row-->
                        </div><!--/#page-content-->
                        <div class="span5">
                           <div class="tabbable tabs-right">
                            <ul class="nav nav-tabs" id="myTab3">
                              <li class="active"><a data-toggle="tab" href="#rights-box"><i class="pink icon-dashboard bigger-110"></i> 操作权限</a></li>
                              <li class=""><a data-toggle="tab" href="#menu-box"><i class="blue icon-user bigger-110"></i> 操作菜单</a></li>
                            </ul>
                            <div class="tab-content actor-functions-box">
                              <h4 class="config-box">
                                  <span class="current-actor">请选择需要配置的角色<span>
                              </h4>
                              <div id="rights-box" class="tab-pane active">
                                  <div class="tree-rights ztree" id="rights-tree"></div>
                              </div>
                              <div id="menu-box" class="tab-pane">
                                <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.</p>
                                <p>Raw denim you probably haven't heard of them jean shorts Austin.</p>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div><!-- #main-content -->
                </div><!--/.fluid-container#main-container-->
         <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
		<script type="text/javascript" src="<?php echo HResponse::uri('cdn'); ?>/jquery/plugins/jquery.tablesorter/jquery.tablesorter.min.js"></script>       
        <script type="text/javascript" src="<?php echo HResponse::uri('cdn'); ?>/jquery/plugins/ztree/js/jquery.ztree.excheck-3.5.js"></script>
        <script type="text/javascript">
            var rightsNodes     = [];
        <?php foreach(HResponse::getAttribute('rightsList') as $rights) { ?>
            rightsNodes.push({ 
                id: <?php echo $rights['id']; ?>, 
                pId: "<?php echo -1 == $rights['parent_id'] ? 0 : $rights['parent_id']; ?>",
                name: "<?php echo $rights['name']; ?>",
                isParent: true 
            });
        <?php } ?>
        </script>
		<script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/list.js"></script>       
	</body>
</html>
