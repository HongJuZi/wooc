                                <div class="row-fluid">
                                    <form id="search-form" action="<?php echo HResponse::url('' . $modelEnName . '/search'); ?>" method="get">
                                        <div class="span4">
                                            <div id="table_report_length" class="dataTables_length">
                                                    <label>每页显示:
                                                        <select size="1" name="perpage" id="perpage" aria-controls="table_report" data-cur="<?php echo HRequest::getParameter('perpage'); ?>">
                                                            <option value="10" selected="selected">10</option>
                                                            <option value="25">25</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select>
                                                        条
                                                </label>
                                            </div>
                                        </div>
                                        <div class="span8 txt-right f-right">
                                            <?php if(2 == $modelCfg['has_multi_lang']) { ?>
                                            <label>语言分类: 
                                                <select name="lang_id" id="lang-id" class="auto-select input-medium" data-cur="<?php echo HRequest::getParameter('lang_id'); ?>">
                                                    <option value="">全部</option>
                                                    <?php foreach($langMap as $lang) { ?>
                                                    <option value="<?php echo $lang['id'];?>"><?php echo $lang['name']; ?></option>
                                                    <?php }?>
                                                </select>
                                            </label>
                                            <?php } ?>
                                            <?php if(HResponse::getAttribute('parent_id_list')) { ?>
                                            <label><?php echo str_replace('分类', '', $modelZhName); ?>分类（<=100）: 
                                                <select name="type" id="category" class="input-medium" data-cur="<?php echo HRequest::getParameter('type'); ?>">
                                                    <option value="">全部</option>
                                                    <?php 
                                                        HClass::import('hongjuzi.utils.HTree');
                                                        $hTree  = new HTree(
                                                            HResponse::getAttribute('parent_id_list'),
                                                            'id',
                                                            'parent_id',
                                                            'name',
                                                            'id',
                                                            '<option value="{id}">' .
                                                            '{name}' .
                                                            '</option>'
                                                        );
                                                        echo $hTree->getTree();
                                                    ?>
                                                </select>
                                            </label>
                                            <?php } ?>
                                            <label>搜索<?php echo $modelZhName;?>: 
                                                <input type="text" class="input-medium search-query" name="keywords" id="keywords" data-def="<?php echo !HRequest::getParameter('keywords') ? '关键字...' : HRequest::getParameter('keywords'); ?>">
                                                <button type="submit" class="btn btn-purple btn-small">搜索<i class="icon-search icon-on-right"></i></button>
                                            </label>
                                        </div>
                                    </form>
                                </div>
