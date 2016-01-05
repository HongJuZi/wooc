                                <div class="control-group">
                                    <label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?></label>
                                    <div class="controls">
                                        <input type="password" id="<?php echo $field; ?>" class="span12" name="<?php echo $field; ?>" value="" />
                                        <small class="help-info"><?php echo $popo->getFieldComment($field); ?></small>
                                    </div>
                                </div>
