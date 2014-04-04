                                <div class="control-group">
                                    <label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?></label>
                                    <div class="controls">
                                        <label><input cur="<?php echo !empty($record[$field]) ? $record[$field] : $popo->getFieldAttribute($field, 'default'); ?>"
                                        class="ace-switch ace-switch-7" type="checkbox"
                                        value="<?php HResponse::lang('YES'); ?>"
                                        name="<?php echo $field; ?>" verify-data="<?php echo json_encode($popo->getFieldVerifyCfg($field));?>" />
                                        <span class="lbl"></span>
                                        <span class="help-inline"><?php echo $popo->getFieldComment($field); ?></span></label>
                                    </div>
                                </div>
