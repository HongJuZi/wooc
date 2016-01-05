<?php require_once(HObject::GC('TPL_DIR') . '/admin/common/header.tpl');?>
    <link rel="stylesheet" type="text/css" href="<?php echo HResponse::uri('template');?>/admin/css/common.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo HResponse::uri('template');?>/admin/css/page.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo HResponse::uri('rendor');?>/uploadify/css/uploadify.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo HResponse::uri('rendor');?>/codemirror/lib/codemirror.css" />
    <link rel="stylesheet" href="<?php echo HResponse::uri('rendor');?>/codemirror/theme/monokai.css">
    <link rel="stylesheet" href="<?php echo HResponse::uri('rendor');?>/codemirror/lib/util/simple-hint.css">
    <style type="text/css">
        .activeline {background: #2F393C !important;}
    </style>
</head>
<body>
	<div id="container">
		<div id="bgwrap">
			<div id="primary_left">
				<?php require(HObject::GC('TPL_DIR') . '/admin/common/left_menu.tpl'); ?>
			</div> <!-- sidebar end -->
			<div id="primary_right">
				<div class="inner">
                    <fieldset>
                        <legend>资源管理</legend>
                            <div class="container noside msub">
                                <div class="col-main" id="js_cantain_box">
                                <div class="operate-panel" id="js_top_bar_box">
                                    <div class="opt-button">
                                        <a href="javascript:;" class="button" menu="upload">
                                            <i class="ico-btn ib-upload" menu="upload">
                                            </i>
                                            <span menu="upload" class="">
                                                上传文件
                                            </span>
                                        </a>
                                        <a href="javascript:;" class="button btn-gray" data_title="删除" id="btn-remove-id">
                                            <i class="ico-btn ib-remove"></i>
                                            <em class="">删除</em>
                                        </a>
                                        <a href="javascript:;" class="button btn-gray" data_title="新建文件" id="btn-add-id">
                                            <i class="ico-btn ib-add"></i>
                                            <em class="">新建文件</em>
                                        </a>
                                        <a href="javascript:;" class="button btn-gray" data_title="新建文件夹" id="btn-newdir-id">
                                            <i menu="adddir" class="ico-btn ib-newdir"></i>
                                            <em menu="adddir" class="">新建文件夹</em>
                                        </a>
                                        <div class="top-search">
                                            <form id="js_search_file_form">
                                                <label for="js_search_name_input" rel="label" style="">搜索文件</label>
                                                <input type="text" rel="txt" name="search_name" id="js_search_name_input"
                                                autocomplete="off">
                                                <button type="submit"><i>搜索</i></button>
                                            </form>
                                        </div>
                                        <a href="javascript:;" class="button btn-gray" rel="more_btn" style=""
                                        is_bind="1">
                                            <b>更多操作</b>
                                            <i class="arrow"></i>
                                        </a>
                                    </div>
                                    <div class="opt-side">
                                    </div>
                                    <div class="nav-refresh">
                                        <a href="javascript:;" class="nr-refresh" data_title="刷新"  onclick="if(!Main.ReInstance()){window.location.reload();}">&nbsp;</a>
                                    </div>
                                </div>
                                <form action="<?php echo HResponse::url('resource'); ?>" name="resource_form" id="resource_form_id" method="post">
                                <div class="directory-path">
                                    <input type="checkbox" style="display:none;" check="all" id="js_check_all_top">
                                    <div class="checkbox" id="check_all_file" for="js_check_all_top"></div>
                                    <div class="path-contents" rel="page_local">
                                        <a href="javascript:;" title="当前路径">当前路径</a>
                                        <?php 
                                            $curDirPath     = '';
                                            foreach(HSession::getAttribute('curDirLevel') as $level => $dir) {
                                                $curDirPath     .= '/' . $dir;
                                                echo '<i>&gt;&gt;</i>';
                                                HHtml::a(
                                                    HResponse::url(
                                                        'admin/resource',
                                                        '?dir=' . $dir . '&l=' . $level
                                                    ),
                                                    $dir
                                                );
                                            }
                                        ?>
                                    </div>
                                    <div class="list-filter" id="js_fileter_box">
                                        <dl>
                                            <dd rel="cal" hide_status="1">
                                                <a href="javascript:;" class="filter-title">
                                                    <b class="lf-date" data_title="按日期搜索">日期</b>
                                                </a>
                                            </dd>
                                            <dd rel="star">
                                                <a href="javascript:;" class="filter-title">
                                                    <b class="lf-star" data_title="星标">星标</b>
                                                </a>
                                            </dd>
                                            <dd rel="taxis" hide_status="1">
                                                <a href="javascript:;" class="filter-title">
                                                    <b class="order-new" data_title="排序">排序</b>
                                                    <i>
                                                    </i>
                                                </a>
                                                <ul class="filter-menu" style="display: none; ">
                                                    <li val="a_file_name">
                                                        <a href="javascript:;">
                                                            <b class="order-desc"></b>
                                                            <span>按文件名倒序</span>
                                                        </a>
                                                    </li>
                                                    <li val="d_file_name">
                                                        <a href="javascript:;">
                                                            <b class="order-asc"></b>
                                                            <span>按文件名顺序</span>
                                                        </a>
                                                    </li>
                                                    <li val="a_user_ptime">
                                                        <a href="javascript:;">
                                                            <b class="order-new"></b>
                                                            <span>时间从新到旧</span>
                                                        </a>
                                                    </li>
                                                    <li val="d_user_ptime">
                                                        <a href="javascript:;">
                                                            <b class="order-old"></b>
                                                            <span>时间从旧到新</span>
                                                        </a>
                                                    </li>
                                                    <li val="a_file_size">
                                                        <a href="javascript:;">
                                                            <b class="order-large"></b>
                                                            <span>文件从大到小</span>
                                                        </a>
                                                    </li>
                                                    <li val="d_file_size">
                                                        <a href="javascript:;">
                                                            <b class="order-small"></b>
                                                            <span>文件从小到大</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </dd>
                                            <dd rel="filter" hide_status="1">
                                                <a href="javascript:;" class="filter-title">
                                                    <b class="lf-all" data_title="筛选">筛选</b>
                                                    <i></i>
                                                </a>
                                                <ul class="filter-menu" style="display: none; ">
                                                    <li val="lf">
                                                        <a href="javascript:;">
                                                            <b class="lf-all"></b>
                                                            <span>全部文件</span>
                                                        </a>
                                                    </li>
                                                    <li val="lf-1">
                                                        <a href="javascript:;">
                                                            <b class="lf-document"></b>
                                                            <span>文档</span>
                                                        </a>
                                                    </li>
                                                    <li val="lf-2">
                                                        <a href="javascript:;">
                                                            <b class="lf-photo"></b>
                                                            <span>图片</span>
                                                        </a>
                                                    </li>
                                                    <li val="lf-3">
                                                        <a href="javascript:;">
                                                            <b class="lf-music"></b>
                                                            <span>音乐</span>
                                                        </a>
                                                    </li>
                                                    <li val="lf-4">
                                                        <a href="javascript:;">
                                                            <b class="lf-video"></b>
                                                            <span>视频</span>
                                                        </a>
                                                    </li>
                                                    <li val="lf-5">
                                                        <a href="javascript:;">
                                                            <b class="lf-archive"></b>
                                                            <span>压缩包</span>
                                                        </a>
                                                    </li>
                                                    <li val="lf-6">
                                                        <a href="javascript:;">
                                                            <b class="lf-application"></b>
                                                            <span>应用程序</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </dd>
                                            <dd rel="view" data_title="图标">
                                                <a href="javascript:;" class="filter-title">
                                                    <b class="ls-thumb">缩略图</b>
                                                </a>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                                <div class="page-list   " id="resource_list_outer" style="">
                                    <div style="min-height: 100%; cursor: default; background-color: rgb(255, 255, 255); background-position: initial initial; background-repeat: initial initial; " id="js_data_list">
                                        <ul rel="list" id="resource_list_inner" style="overflow: hidden;_zoom: 1;">
                                        <?php
                                            foreach(HResponse::getAttribute('dirs') as $dir) {
                                                $changeTime = HFile::getChangeTime($dir, 'Y-m-d H:m:s');
                                                $dirName    = HDir::getDirName($dir);
                                        ?>
                                            <li rel="item">
                                                <input type="checkbox" value="<?php echo $dirName?>" style="">
                                                <div class="checkbox"></div>
                                                <div style="position:absolute;top:0;left:0;width:34px;height:50px;" checkbox="1"></div>
                                                <i class="file-type tp-folder"></i>
                                                <div class="file-name">
                                                    <a href="<?php echo HResponse::url('resource', '?dir=' . $dirName); ?>" title="<?php echo $dirName; ?>">
                                                        <?php echo $dirName; ?>
                                                    </a>
                                                </div>
                                                <div class="file-info">
                                                    <em><?php echo $changeTime; ?></em>
                                                    <span class="file-ctrl" style="display: none; ">

                                                        <a href="javascript:;" class="ico-lio i-rename" data_title="重命名">重命名</a>
                                                        <a href="javascript:;" class="ico-lio i-delete" data_title="删除">删除</a>
                                                        <a href="javascript:;" class="ico-lio i-share" menu="share_one" data_title="分享">分享</a>
                                                        <a href="javascript:;" class="ico-lio i-more" menu="more_btn" data_title="更多">更多</a>
                                                    </span>
                                                </div>
                                            </li>
                                        <?php 
                                            }
                                            foreach(HResponse::getAttribute('files') as $file) {
                                                $changeTime     = HFile::getChangeTime($file, 'Y-m-d H:m:s');
                                                $fileSize       = HFile::getFileSize($file);
                                                $fileName       = HFile::getFileName($file);
                                                $fileExtension  = HFile::getFileExtension($file);
                                        ?> 
                                            <li rel="item"  ico="<?php echo $fileExtension;?>">
                                                <input type="checkbox" value="<?php echo $fileName . $fileExtension; ?>" style="">
                                                <div class="checkbox"></div>
                                                <div style="position:absolute;top:0;left:0;width:34px;height:50px;" checkbox="1">
                                                </div>
                                                <i class="file-type tp-<?php echo substr($fileExtension, 1);?>">
                                                </i>
                                                <div class="file-name">
                                                    <span>
                                                        <a href="<?php echo HResponse::url($curDirPath . '/' . $fileName . $fileExtension);?>" target="_blank" title="<?php echo $fileName . $fileExtension?>" rel="file" field="file_name">
                                                            <?php echo $fileName . $fileExtension; ?>
                                                        </a>
                                                    </span>
                                                    <?php if(in_array($fileExtension, HResponse::getAttribute('imageFileTypes'))) { ?>
                                                    <a href="javascript:;" class="ico-lio
                                                        i-star" menu="star"
                                                        data_title="加入或更改相册">&nbsp;</a>
                                                    <?php } ?>
                                                </div>
                                                <div class="file-info">
                                                    <em><?php echo $changeTime; ?></em>
                                                    <em><?php echo $fileSize; ?></em>
                                                    <span class="file-ctrl" style="display: none;">
                                                        <a href="javascript:;" class="ico-lio i-rename" data_title="重命名">重命名</a>
                                                        <?php if(in_array($fileExtension, HResponse::getAttribute('editFileTypes'))) { ?>
                                                        <a href="javascript:;" class="ico-lio i-edit" data_title="编辑">编辑</a>
                                                        <?php } ?>
                                                        <a href="javascript:;" class="ico-lio i-delete" data_title="删除">删除</a>
                                                        <a href="javascript:;" class="ico-lio i-preview" data_title="预览">预览</a>
                                                        <a href="javascript:;" class="ico-lio i-download" menu="download_one" data_title="下载">下载</a>
                                                        <a href="javascript:;" class="ico-lio i-more" menu="more_btn" data_title="更多">更多</a>
                                                    </span>
                                                </div>
                                            </li>
                                        <?php } ?>
                                        </ul>
                                        <div style="position: absolute; top: 146px; left: 1023px; border: 1px solid rgb(7, 34, 70); background-color: rgb(107, 176, 201); opacity: 0.15; overflow: hidden; z-index: 99999; width: 0px; height: 0px; display: none; background-position: initial initial; background-repeat: initial initial; ">
                                        </div>
                                    </div>
                                </div>
                                <div style="display: none; " id="js_no_file_box"></div>
                                <div class="main-sub" id="js_main_sub">
                                    <div class="msub-switch" style="display:none">
                                        <a href="javascript:;" class="mss-o"><i></i>展开
                                        <a href="javascript:;" class="mss-c"><i></i>收起</a>
                                    </div>
                                    <div class="msb-info" id="js_file_msb_info" style="">
                                        <i class="file-type tp-folder"></i>
                                        <span title="桌面效果">桌面效果</span><br>
                                        <span>
                                            访问链接：
                                            <a title="点进查看源文件" href="<?php echo HObject::GC('SITE_URL');?>" target="_blank">
                                                fetpzijz
                                            </a>
                                        </span>
                                        <span>创建时间：<i detail="ptime">2012-08-20</i></span>
                                        <span>包含：<i>1个文件</i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="clearboth"></div>
                            <div class="page-footer">
                                <div class="sub-nav">
                                    <ul>
                                        <li><a href="javascript:;" id="js_recycle_full_box" onclick="TOP.PageCTL.GOTO(7, 0);return false;"><i class="sn-recycle"></i><span>回收站</span></a></li>
                                        <li><a href="javascript:;" onclick="TOP.URL_CTL.ChangeURL('other', '/?ct=file&ac=user_share_space&user_id=' + TOP.USER_ID);return false;"><i class="sn-share"></i><span>分享空间</span></a></li>
                                        <li><a href="javascript:;" onclick="TOP.Core.FrameDG.Open('/?ac=setting', {title:'网盘设置',width: 700, height:500}); return false;"><i class="sn-setting"></i><span>设置</span></a></li>
                                        <li><a href="javascript:;" onclick="TOP.Core.FrameDG.Open('/?ct=plug', {title:'网盘实验室',width: 700, height:500});return false;" ><i class="sn-lab"></i><span>实验室</span></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="space-info space-sub" id="js_space_box" style="z-index:9999999;">
                                <i style="width:0;" rel="space_line"></i>
                                <em rel="space_text">0GB/0GB</em>
                            </div>
                        </form>
                        </fieldset>
                        <div id="dialog-form" title="对话框" class="dialog-input" style="display: none;"> </div>
					<div class="clearboth"></div>				
				</div> <!-- inner -->
			</div> <!-- primary_right -->
		</div> <!-- bgwrap -->
	</div> <!-- container -->
    <?php require_once(HObject::GC('TPL_DIR') . '/admin/common/footer.tpl');?>
    <script type="text/javascript" src="<?php echo HResponse::uri('rendor');?>/uploadify/uploadify.js"></script>
    <script type="text/javascript" src="<?php echo HResponse::uri('rendor');?>/codemirror/lib/codemirror.js"></script>
    <script src="<?php echo HResponse::uri('rendor');?>/codemirror/lib/util/simple-hint.js"></script>
    <script src="<?php echo HResponse::uri('rendor');?>/codemirror/lib/util/javascript-hint.js"></script>
    <script src="<?php echo HResponse::uri('rendor');?>/codemirror/mode/javascript/javascript.js"></script>
    <script type="text/javascript" src="<?php echo HResponse::uri('template');?>/admin/js/util-min.js"></script>
    <script type="text/javascript" src="<?php echo HResponse::uri('template');?>/admin/js/file_manage_view.js"></script>
</body>
</html>
