                                <?php $fileType     = str_replace('.', '', implode('|', $popo->getFieldAttribute($field, 'type'))); ?> 
                                <div class="control-group">
                                    <label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?></label>
                                    <div class="controls">
                                        <div class="span6">
                                            <input type="file" id="<?php echo $field; ?>"
                                                name="<?php echo $field; ?>"
                                                data-field="<?php echo $field; ?>"
                                                data-type="|<?php echo $fileType; ?>|" 
                                                class="file-field"
                                            />
                                            <?php
                                                if(!empty($record[$field])) {
                                                    if(preg_match('/jpg|png|gif|bmp/i', $fileType)) {
                                                        echo '<div class="old-file-box"><a href="' . HResponse::url() . $record[$field] . '" class="lightbox">'; $detailImagePath    = HFile::getImageZoomTypePath($record[$field], 'small');
                                                        HHtml::image(HResponse::url() . $detailImagePath );
                                                    } else {
                                                        echo '<a href="' . HResponse::url() . $record[$field] . '" title="下載' . HFile::getName($record[$field]) . '">';
                                                    }
                                                    echo '</a><input type="hidden" name="old_<?php echo $field; ?>" value="' . $record[$field] . '" /></div>';
                                                }
                                            ?>
                                        </div>
                                        <span class="help-inline">
                                            <?php echo $popo->getFieldComment($field); ?>
                                        </span>
                                    </div>
                                </div>
