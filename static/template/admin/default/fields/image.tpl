                                <?php $fileType     = str_replace('.', '', implode('|', $popo->getFieldAttribute($field, 'type'))); ?> 
                                <div class="control-group">
                                    <label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?></label>
                                    <div class="controls">
                                        <div class="span12">
                                            <button type="button"
                                                data-field="<?php echo $field; ?>"
                                                data-type="image" 
                                                class="btn btn-white btn-mini span12 btn-file"
                                            ><i class="icon-file"></i> 请选择图片</button>
                                            <input name="<?php echo $field; ?>" type="hidden" id="<?php echo $field; ?>" value="<?php echo $record[$field]; ?>"/>
                                            <div class="old-file-box">
                                                <a href="<?php echo HResponse::touri($record['image_path']); ?>" class="lightbox" id="<?php echo $field; ?>-lightbox"> 
                                                    <?php if($record['image_path']) { ?>
                                                    <img src="<?php echo HResponse::touri(HFile::getImageZoomTypePath($record[$field], 'small')); ?>" />
                                                    <?php }?>
                                               </a>
                                               <input type="hidden" name="old_<?php echo $field; ?>" value="<?php echo $record[$field]; ?>" />
                                            </div>
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
