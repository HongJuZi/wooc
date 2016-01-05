                                <div class="widget-box">
                                    <div class="widget-header">
                                        <h4>维护</h4>
                                        <div class="widget-toolbar">
                                            <a href="#" data-action="collapse">
                                                <i class="icon-chevron-up"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <?php $field = 'total_comments'; require(HResponse::path('admin') . '/fields/hidden.tpl'); ?>
                                            <?php $field = 'total_visits'; require(HResponse::path('admin') . '/fields/hidden.tpl'); ?>
                                            <?php $field = 'edit_time'; require(HResponse::path('admin') . '/fields/datetime.tpl'); ?>
                                            <?php $field = 'create_time'; require(HResponse::path('admin') . '/fields/datetime.tpl'); ?>
                                            <?php require_once(HResponse::path('admin') . '/fields/author.tpl'); ?>
                                        </div>
                                    </div>
                                </div>
