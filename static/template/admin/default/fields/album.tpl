                                <div class="control-group">
                                    <h3 class="title "><?php echo $popo->getFieldName($field); ?>【<a href="###" id="delete-more-btn">批量删除</a>】<span class="help-inline"><?php echo $popo->getFieldComment($field); ?></span></h3>
                                    <div class="row-fluid">
                                        <ul class="ace-thumbnails album-list-box" id="album-list-box">
                                            <?php 
                                                $resourceMap    = HResponse::getAttribute('resourceMap');
                                                foreach(HResponse::getAttribute('album') as $pic) { 
                                                    $res        = $resourceMap[$pic['item_id']];
                                            ?>
                                          <li id="pic-<?php echo $pic['id']; ?>" class="pic btn-app">
                                            <a href="###" id="<?php echo $pic['id']; ?>" class="check-item pic">
                                               <img alt="<?php echo $pic['name']; ?>" src="<?php echo HResponse::url() .  HFile::getImageZoomTypePath($res['path'], 'small'); ?>" id="img-<?php echo $pic['id']; ?>"/>
                                               <div class="text">
                                                    <div class="inner" id="description-<?php echo $pic['id']; ?>"><?php echo $pic['description']; ?></div>
                                               </div>
                                            </a>
                                            <div class="tools tools-bottom">
                                                <a target="_blank" href="<?php echo HResponse::url() . $res['path']; ?>" class="pic-link" title="查看原图"><i class="icon-link"></i></a>
                                                <a href="###" class="pic-delete" id="pic-<?php echo $pic['id']; ?>" data-model="<?php echo $modelEnName; ?>" data-id="<?php echo $pic['id']; ?>" title="删除图片"><i class="icon-remove red"></i></a>
                                            </div>
                                            <span class="hide label label-info icon-check">&nbsp;</span>
                                            <input type="checkbox" id="item-<?php echo $pic['id']; ?>" value="<?php echo $pic['id']; ?>" class="hide check-item"/>
                                          </li>
                                            <?php }?>
                                         </ul>
                                         <div id="uploader" class="uploader-box">
                                             <!--用来存放文件信息-->
                                             <div id="thelist" class="uploader-list"></div>
                                             <div class="btns">
                                                 <div id="file-upload">选择文件</div>
                                             </div>
                                        </div>
                                        <?php $hash     = empty($record[$field]) ?  HString::getUUID('') : $record[$field]; ?>
                                        <input name="<?php echo $field; ?>" type="hidden" value="<?php echo $hash; ?>"/>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    <?php $timestamp    = time(); ?>
                                    if('undefined' === typeof(albumFormData)) {
                                        var albumFormData   = {};
                                    } 
                                    albumFormData['<?php echo $field; ?>']   = {
                                        'timestamp' : '<?php echo $timestamp; ?>',
                                        'token'     : '<?php echo md5('unique_salt' .  $timestamp);?>', 
                                        'model'     : modelEnName,
                                        'field'     : '<?php echo $field; ?>',
                                        'linked'    : '<?php echo $hash; ?>'
                                    };
                                </script>
