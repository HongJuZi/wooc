                                <div class="control-group">
                                    <label class="control-label" for="<?php echo $field; ?>">
                                        <?php echo $popo->getFieldName($field); ?>：
                                    </label>
                                    <div class="controls">
                                        <input type="text" id="<?php echo $field; ?>"
                                        name="<?php echo $field; ?>" 
                                        class="span12 input-field-<?php echo $field; ?>"
                                        value="<?php echo !empty($record[$field]) ? $record[$field] : $popo->getFieldAttribute($field, 'default'); ?>"
                                        placeholder="请添加<?php echo $popo->getFieldName($field); ?>" 
                                        data-verify='<?php echo json_encode($popo->getFieldVerifyCfg($field));?>' />
                                        <small class="help-info"><?php echo $popo->getFieldComment($field); ?></small>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>                               
