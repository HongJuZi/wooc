                                <?php $fileType     = str_replace('.', '', implode('|', $popo->getFieldAttribute($field, 'type'))); ?> 
                                <div class="control-group">
                                    <label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?></label>
                                    <div class="controls">
                                        <div class="span12">
                                            <button type="button"
                                                data-field="<?php echo $field; ?>"
                                                data-type="file" 
                                                class="btn btn-white btn-mini span12 btn-file"
                                            ><i class="icon-file"></i> 请选择文件</button>
                                            <input name="<?php echo $field; ?>" type="hidden" id="<?php echo $field; ?>" value="<?php echo $record[$field]; ?>"/>
                                            <?php
                                                if(!empty($record[$field])) {
                                                    echo '<a href="' . HResponse::touri() . '" title="下載' . HFile::getName($record[$field]) . '">';
                                                    echo '</a><input type="hidden" name="old_' . $field . '" value="' . $record[$field] . '" />';
                                                }
                                            ?>
                                            <small class="help-info"><?php echo $popo->getFieldComment($field); ?></small>
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    <?php $timestamp    = time() . rand(1000, 9999); ?>
                                    formData['<?php echo $field; ?>']        = {
                                        'timestamp' : '<?php echo $timestamp; ?>',
                                        'token'     : '<?php echo md5('unique_salt' .  $timestamp);?>', 
                                        'model'     : modelEnName,
                                        'field'     : '<?php echo $field; ?>',
                                        'nolinked'  : 1
                                    };
                                </script>
