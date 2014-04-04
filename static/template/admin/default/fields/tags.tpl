                                <div class="control-group">
                                    <label class="control-label" for="tags"><?php echo $popo->getFieldName('tags'); ?></label>
                                    <div class="controls tags-box">
                                        <input type="text" id="tags" name="tags" class="span6" placeholder="<?php echo $popo->getFieldName('tags'); ?>" value="<?php echo $record['tag_names']; ?>" />
                                        <input type="hidden" id="tag-ids" name="tag_ids" value="<?php echo $record['tag_ids']; ?>" />
                                        <span class="help-inline f-left"><?php echo $popo->getFieldComment('tags'); ?></span>
                                        <div class="clearfix"></div>
                                        <div class="tag-list" id="tag-list">
                                            可选标签：
                                            <?php 
                                                $colors     = array(
                                                    'yellow', 'grey', 'pink', 'light', 'purple', 'inverse',
                                                    'danger', 'warning', 'primary', 'success', 'info', 'default'
                                                );
                                                $tag        = HClass::quickLoadModel('tags');
                                                foreach($tag->getSomeRows(9) as $tag) { 
                                            ?>
                                            <a class="btn btn-mini btn-<?php echo $colors[ceil(rand(0, 12))]; ?> tag" href="###"><?php echo $tag['name']; ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/tags.js"></script>
