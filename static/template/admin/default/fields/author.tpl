                                <div class="control-group">
                                    <?php $author = HResponse::getAttribute('author'); ?>
                                    <label class="control-label" for="author"><?php echo $popo->getFieldName('author'); ?></label>
                                    <div class="controls">
                                        <input type="text" id="author" class="span12" placeholder="<?php echo $popo->getFieldName('author'); ?>" value="<?php echo $author; ?>" readonly="readonly" />
                                        <small class="help-info"><?php echo $popo->getFieldComment($field); ?></small>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
