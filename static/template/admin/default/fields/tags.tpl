                                <div class="control-group">
                                    <label class="control-label" for="<?php echo $field;?>"><?php echo $popo->getFieldName($field); ?>：</label>
                                    <div class="controls">
                                        <input type="text" id="<?php echo $field;?>" class="span12" placeholder="<?php echo $popo->getFieldName($field); ?>" value="<?php echo $record[$field . '_name']; ?>" />
                                        <input type="hidden" id="tag_ids" name="<?php echo $field;?>" value="<?php echo $record[$field]; ?>" />
                                    </div>
                                    <div class="clearfix"></div>
                                    <div id="<?php echo $field;?>-top-list" class="<?php echo $field;?>-top-list">建议： 暂时没有建议。</div>
                                </div>
                                <script type="text/javascript"> tagList = ['#tags'];</script>
