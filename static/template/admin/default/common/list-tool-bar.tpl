                                <div class="row-fluid">
                                    <form id="search-form" action="<?php echo HResponse::url('' . $modelEnName . '/search'); ?>" method="get">
                                        <div class="span4">
                                            <div id="table_report_length" class="dataTables_length">
                                                    <label>每页显示:
                                                        <select size="1" name="perpage" id="perpage" aria-controls="table_report" cur="<?php echo HRequest::getParameter('perpage'); ?>">
                                                            <option value="10" selected="selected">10</option>
                                                            <option value="25">25</option>
                                                            <option value="50">50</option>
                                                            <option value="100">100</option>
                                                        </select>
                                                        条
                                                </label>
                                            </div>
                                        </div>
                                        <div class="span7 txt-right f-right">
                                            <div class="dataTables_filter" id="table_report_filter">
                                                <?php if(HResponse::getAttribute('parent_id_list')) { ?>
                                                <label><?php echo str_replace('分类', '', $modelZhName); ?>分类: 
                                                    <select name="type" id="category" class="input-medium" cur="<?php echo HRequest::getParameter('type'); ?>">
                                                        <option value="-1">全部</option>
                                                        <option value="0">无</option>
                                                        <?php foreach(HResponse::getAttribute('parent_id_list') as $type) { ?>
                                                        <option value="<?php echo $type['id'] . '">' . $type['name']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </label>
                                                <?php } ?>
                                                <label>关键字: 
                                                    <input type="text" class="input-medium search-query" name="keywords" id="keywords" def="<?php echo !HRequest::getParameter('keywords') ? '关键字...' : HRequest::getParameter('keywords'); ?>">
                                                    <button type="submit" class="btn btn-purple btn-small">搜索<i class="icon-search icon-on-right"></i></button>
                                                </label>
                                            </div>
                                        </div>
                                    </form>
                                </div>
