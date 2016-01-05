                                <div class="btn-group"> 
                                    <a href="<?php echo HResponse::url('' . $modelEnName . '/editview', 'id=' . $record['id']); ?>" title="编辑记录" class='btn btn-mini btn-info'><i class="icon-edit"></i></a>
                                    <a href="<?php echo HResponse::url('' . $modelEnName . '/delete', 'id=' .  $record['id']);?>" title="删除信息" class="btn btn-mini btn-danger delete"><i class="icon-trash"></i></a>
                                </div>
