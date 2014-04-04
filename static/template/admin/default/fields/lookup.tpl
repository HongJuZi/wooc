                                <div class="control-group">
                                    <label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?></label>
                                    <div class="controls">
                                        <input type="text" class="span6 txt-blod" 
                                            placeholder="请添加<?php echo $popo->getFieldName($field); ?>" 
                                            id="lookup-values-<?php echo $field; ?>"
                                            value="<?php echo $record['lookup_' . $field]; ?>"
                                            name="lookup_checkbox_values"
                                            data-verify='<?php echo json_encode($popo->getFieldVerifyCfg($field));?>'
                                            readonly
                                        />
                                        <input type="hidden" 
                                            id="lookup-ids-<?php echo $field; ?>" 
                                            name="<?php echo $field; ?>" 
                                            value="<?php echo !empty($record[$field]) ? $record[$field] : $popo->getFieldAttribute($field, 'default'); ?>"
                                        />
                                        <a href="###" data-lookup-url="<?php echo HResponse::url($popo->modelEnName . '/lookup', 'id=' . $record[$field] . '&field=' . $field); ?>" class="btn btn-small btn-info icon-search lookup-btn">选择</a>
                                        <span class="help-inline"><?php echo $popo->getFieldComment($field); ?></span>
                                    </div>
                                </div>         
