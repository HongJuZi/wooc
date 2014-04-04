                                <div class="control-group">
                                    <label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?></label>
                                    <div class="controls">
                                        <input type="password" id="<?php echo $field; ?>" class="span6" name="<?php echo $field; ?>" value="" />
                                        <span class="help-inline"><?php echo $popo->getFieldComment($field); ?></span>
                                    </div>
                                </div>                               
