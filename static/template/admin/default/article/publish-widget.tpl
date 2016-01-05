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
                                            <?php $field = 'extend_class'; ?>
                                            <div class="control-group">
                                                <label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?>：</label>
                                                <div class="controls">
                                                    <div class="span10">
                                                        <input type="text" id="<?php echo $field; ?>" class="span12" 
                                                        name="<?php echo $field; ?>" 
                                                        value="<?php echo !empty($record[$field]) ? $record[$field] : $popo->getFieldAttribute($field, 'default'); ?>"
                                                        placeholder="请添加<?php echo $popo->getFieldName($field); ?>" 
                                                        data-verify='<?php echo json_encode($popo->getFieldVerifyCfg($field));?>' />
                                                    </div>
                                                    <div class="span2 btn-group">
                                                        <button data-toggle="dropdown" class="btn btn-mini btn-info dropdown-toggle">
                                                            <i class="icon-angle-down icon-on-right"></i>
                                                        </button>
                                                        <ul class="dropdown-menu xele-list" id="xele-list">
                                                            <?php
                                                                $xeleInfo  = HResponse::getAttribute('xele-list');
                                                                $xeleList  = json_decode(HString::decodeHtml($xeleInfo['content']), true);
                                                                foreach($xeleList as $item) { 
                                                                    if('-' != $item) { 
                                                            ?>
                                                            <li><a href="###" title="<?php echo $item; ?>" class="item-xele"><?php echo $item; ?></a></li>
                                                                <?php } else { ?>
                                                            <li class="divider"></li>
                                                            <?php } } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $field = 'status'; require(HResponse::path('admin') . '/fields/select.tpl'); ?>
                                            <div class="control-group text-right btn-form-box" data-spy="affix" data-offset-top="160" >
                                                <button type="reset" class="btn btn-mini">重置</button>
                                                <button type="submit" class="btn btn-success btn-mini">发布</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
