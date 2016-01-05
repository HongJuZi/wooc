                                <div class="widget-box">
                                    <div class="widget-header">
                                        <h4>发布</h4>
                                        <div class="widget-toolbar">
                                            <a href="#" data-action="collapse">
                                                <i class="icon-chevron-up"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <?php $field = 'sort_num'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
                                            <?php $field = 'identifier'; require(HResponse::path('admin') . '/fields/text.tpl'); ?>
                                            <div class="control-group text-right btn-form-box" data-spy="affix" data-offset-top="160" >
                                                <button type="reset" class="btn btn-mini">重置</button>
                                                <button type="submit" class="btn btn-success btn-mini">发布</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
