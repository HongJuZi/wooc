<?php require_once(HResponse::path('admin') . '/common/header.tpl'); ?>
	</head>
	<body>
        <?php require_once(HResponse::path('admin') . '/common/navmenu.tpl'); ?>
		<div class="container-fluid" id="main-container">
            <?php require_once(HResponse::path('admin') . '/common/sidebar.tpl'); ?>
			<div id="main-content" class="clearfix">
                <?php $record         = HResponse::getAttribute('record'); ?>    
                <?php require_once(HResponse::path('admin') . '/common/cur-location.tpl'); ?>
                    <div class="row-fluid">
                    <!-- PAGE CONTENT BEGINS HERE -->
                        <form class="form-horizontal" action="<?php echo HResponse::url($modelEnName . '/' . HResponse::getAttribute('nextAction') ); ?>" method="post" enctype="multipart/form-data" id="info-form">
                           <div class="tabbable tabs-right tabs-shadow tabs-space">
                            <?php require_once(HResponse::path('admin') . '/common/tabs-sidebar.tpl'); ?>
                            <div class="tab-content">
                              <div id="base-box" class="tab-pane in active">
                                <?php $field = 'id'; require(HResponse::path('admin') . '/fields/hidden.tpl'); ?>
                                <?php $field = 'name'; require(HResponse::path('admin') . '/fields/textarea.tpl'); ?>
                                <?php 
                                    $langList       = HResponse::getAttribute('lang_id_list');
                                    $translateMap   = HResponse::getAttribute('translateMap');
                                    foreach($langList as $lang) { 
                                        $translate  = $translateMap && isset($translateMap[$lang['id']]) ? $translateMap[$lang['id']] : array();
                                ?>
                                <div class="control-group">
                                    <label class="control-label" for="lang-<?php echo $lang['id'];?>"><?php echo $lang['name']; ?></label>
                                    <div class="controls">
                                        <textarea id="lang-<?php echo $lang['id']; ?>" 
                                        class="span10" placeholder="添加<?php echo $lang['name'];?>翻译" 
                                        name="lang_<?php echo $lang['id'];?>"><?php echo $translate['content']; ?></textarea>
                                        <input name="translate_<?php echo $lang['id']; ?>" type="hidden" value="<?php echo $translate['id'];?>"/>
                                    </div>
                                </div>
                                <script type="text/javascript">codeEditorList.push('lang-<?php echo $lang['id'];?>');</script>
<?php } ?>
                              </div>
                              <div id="seo-box" class="tab-pane">
                                
                              </div>
                              <div id="album-box" class="tab-pane">
                                
                              </div>
                              <div id="manage-box" class="tab-pane">
                                <?php $field = 'create_time'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
<?php require_once(HResponse::path('admin') . '/fields/author.tpl'); ?>

                              </div>
                            <div class="form-actions">
                                <div class="span4">
                                    <button class="btn btn-info" type="reset"><i class="icon-undo"></i>重置</button>
                                    <button class="btn btn-success" type="submit"><i class="icon-ok"></i>提交</button>
                                    <button class="btn btn-warning" type="button" id="auto-translate-btn"><i class="icon-ok"></i>自动翻译</button>
                                </div>
                                <div class="pre-next-record span5">
                                    <?php 
                                        $preRecord      = HResponse::getAttribute('preRecord');
                                        echo empty($preRecord) ? '' : HHtml::a(
                                            HResponse::url(
                                                HResponse::getAttribute('HONGJUZI_MODEL') . '/editview',
                                                'id=' . $preRecord['id']
                                            ),
                                            '上一条：' . $preRecord['name'],
                                            'title="' . $preRecord['name'] . '" class="pre-record"'
                                        ) . '<br/>';
                                        $nextRecord     = HResponse::getAttribute('nextRecord');
                                        echo empty($nextRecord) ? '': HHtml::a(
                                            HResponse::url(
                                                HResponse::getAttribute('HONGJUZI_MODEL') . '/editview',
                                                'id=' . $nextRecord['id']
                                            ),
                                            '下一条：' . $nextRecord['name'],
                                            'title="' . $nextRecord['name'] . '" class="next-record"'
                                        );
                                    ?>
                                </div>
                            </div>
                            <div class="hr"></div>
                         </form>
                    <!-- PAGE CONTENT ENDS HERE -->
                     </div><!--/row-->
                </div><!--/#page-content-->
			</div><!-- #main-content -->
		</div><!--/.fluid-container#main-container-->
        <?php require_once(HResponse::path('admin') . '/common/footer.tpl'); ?>
        <script type="text/javascript">
            var langList    = [];
            <?php 
                foreach($langList as $lang) { 
                    echo 'langList.push({id:\'' . $lang['id'] . '\','
                    . 'name:\'' . $lang['name'] . '\','
                    . 'identifier:\'' . $lang['identifier'] . '\','
                    . '});';
                }
            ?>
        </script>
        <script type="text/javascript" src="<?php echo HResponse::uri('cdn'); ?>/js/fanti.js"></script>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/info.js"></script>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/mark-info.js"></script>
	</body>
</html>
