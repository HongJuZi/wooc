                                <div class="control-group">
                                    <h3><?php echo $popo->getFieldName($field); ?>【<a href="###" id="delete-more-btn">批量删除</a>】<span class="help-inline"><?php echo $popo->getFieldComment($field); ?></span></h3>
                                    <div class="row-fluid">
                                        <ul class="ace-thumbnails" id="album-list-box">
                                            <?php 
                                                $resourceMap    = HResponse::getAttribute('resourceMap');
                                                foreach(HResponse::getAttribute('album') as $pic) { 
                                                    $res        = $resourceMap[$pic['res_id']];
                                            ?>
                                          <li id="pic-<?php echo $pic['id']; ?>" class="pic btn-app">
                                            <a href="###" id="<?php echo $pic['id']; ?>" class="check-item">
                                               <img alt="<?php echo $pic['name']; ?>" src="<?php echo HResponse::url() .  HFile::getImageZoomTypePath($res['path'], 'small'); ?>" id="img-<?php echo $pic['id']; ?>"/>
                                               <div class="text">
                                                    <div class="inner" id="description-<?php echo $pic['id']; ?>"><?php echo $pic['description']; ?></div>
                                               </div>
                                            </a>
                                            <div class="tools tools-bottom">
                                                <a target="_blank" href="<?php echo HResponse::url() . $res['path']; ?>" class="pic-link" title="查看原图"><i class="icon-link"></i></a>
                                                <a href="###" class="pic-edit" title="编辑描述" id="<?php echo $pic['id']; ?>"><i class="icon-pencil"></i></a>
                                                <a href="###" class="pic-delete" id="<?php echo $pic['id']; ?>" title="删除图片"><i class="icon-remove red"></i></a>
                                            </div>
                                            <span class="hide label label-info icon-check">&nbsp;</span>
                                            <input type="checkbox" id="item-<?php echo $pic['id']; ?>" value="<?php echo $pic['id']; ?>" class="hide check-item"/>
                                          </li>
                                            <?php }?>
                                         </ul>
                                        <div class="uploader-box">
                                            <input id="file_upload" type="file" multiple="true">
                                            <div id="queue"></div>
                                        </div>
                                        <?php $hash     = empty($record['album_hash']) ? HString::getUUID('') : $record['album_hash']; ?>
                                        <input name="album_hash" type="hidden" value="<?php echo $hash; ?>"/>
                                    </div>
                                </div>
                                <div class="hide">
                                    <ul id="pic-tpl">
                                        <li id="pic-{id}" class="pic btn-app">
                                            <a href="###" id="{id}" class="check-item">
                                            <img alt="{name}" src="{small}" />
                                            <div class="text">
                                                <div class="inner description">{description}</div>
                                            </div>
                                            </a>
                                            <div class="tools tools-bottom">
                                                <a target="_blank" href="{src}" class="pic-link" title="查看原图"><i class="icon-link"></i></a>
                                                <a href="###" class="pic-edit" title="编辑描述" id="{id}"><i class="icon-pencil"></i></a>
                                                <a href="###" class="pic-delete" id="{id}" title="删除图片"><i class="icon-remove red"></i></a>
                                            </div>
                                            <span class="hide label label-info icon-check">&nbsp;</span>
                                            <input type="checkbox" id="item-{id}" value="{id}" class="hide check-item"/>
                                        </li>
                                    </ul>
                                    <div id="dialog-pic-edit-tpl">
                                        <div id="dialog-pic-edit" class="modal hide fade dialog-box">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h3>修改<span id="pic-title"></span>信息</h3>
                                            </div>
                                            <div class="modal-body dialog-box-body">
                                                <div class="row-fluid">
                                                    <label for="form-field-8">名称：</label>
                                                    <input type="text" class="span12" id="pic-name" placeholder="请添加名称" value="">
                                                </div>
                                                <div class="row-fluid">
                                                    <label for="form-field-8">简介：</label>
                                                    <textarea class="span12" id="pic-description" placeholder="请添简介"></textarea>
                                                </div>
                                                <p class="aright">
                                                    <input type="hidden" value="" id="pic-id"/>
                                                    <a href="###" id="edit-pic-btn" class="btn btn-primary">确认</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    <?php $timestamp    = time(); ?>
                                    var formData        = {
                                        'timestamp' : '<?php echo $timestamp; ?>',
                                        'token'     : '<?php echo md5('unique_salt' .  $timestamp);?>', 
                                        'model'     : modelEnName,
                                        'field'     : '<?php echo $field; ?>',
                                        '<?php echo $field; ?>'      : '<?php echo $hash; ?>'
                                    };
                                </script>
                                <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/album.js"></script>

