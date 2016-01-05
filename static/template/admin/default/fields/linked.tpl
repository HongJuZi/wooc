                                <div class="control-group">
                                    <label class="control-label" for="<?php echo $field; ?>">
                                        <?php echo $popo->getFieldName($field); ?>：
                                    </label>
                                    <div class="controls">
                                        <input type="text" readonly="readonly"
                                        class="span12 input-field-<?php echo $field; ?>"
                                        value="<?php echo $record[$field]['name']; ?>"
                                        placeholder="请添加<?php echo $popo->getFieldName($field); ?>" 
                                        />
                                        <input name="<?php echo $field; ?>" type="hidden" id="<?php echo $field; ?>" 
                                        value="<?php echo !empty($record[$field]) ? $record[$field]['id'] : $popo->getFieldAttribute($field, 'default'); ?>"
                                        data-verify='<?php echo json_encode($popo->getFieldVerifyCfg($field));?>' 
                                        />
                                        <small class="help-info"><?php echo $popo->getFieldComment($field); ?></small>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>                               
