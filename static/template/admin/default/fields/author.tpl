                                <div class="control-group">
                                    <label class="control-label" for="author"><?php echo $popo->getFieldName('author'); ?></label>
                                    <div class="controls">
                                        <input type="text" id="author" class="span6" placeholder="<?php echo $popo->getFieldName('author'); ?>" value="<?php echo HResponse::getAttribute('author'); ?>" readonly="readonly">
                                        <span class="help-inline"><?php echo $popo->getFieldComment('author'); ?></span>
                                    </div>
                                </div>
