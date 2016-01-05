                                <div class="control-group">
                                    <label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?></label>
                                    <div class="controls">
                                        <input data-cur="<?php echo !empty($record[$field]) ? $record[$field] : $popo->getFieldAttribute($field, 'default'); ?>"
                                        class="ace-switch ace-switch-4" type="checkbox" value="2"
                                        name="<?php echo $field; ?>" 
                                        verify-data='<?php echo json_encode($popo->getFieldVerifyCfg($field));?>' 
                                        data-def='<?php echo $popo->getFieldAttribute($field, 'default'); ?>' />
                                        <span class="lbl"></span>
                                        <small class="help-info"><?php echo $popo->getFieldComment($field); ?></small>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
