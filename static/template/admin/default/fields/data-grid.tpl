                                <form action="<?php echo HResponse::url('' . $modelEnName . '/quick'); ?>" method="post" id="list-form">
                                    <table id="data-grid-box" class="table table-striped table-bordered table-hover dataTable tablesorter" >
                                        <thead>
                                            <tr>
                                                <th class="center">
                                                    <label><input type="checkbox" /><span class="lbl"></span></label>
                                                </th>
                                                <?php
                                                    $columns        = 2;
                                                    $showFields     = HResponse::getAttribute('show_fields');
                                                    foreach($showFields as $key => $cfg ) {
                                                        echo '<th class="field-' . $key . '" title="' . $cfg['comment'] . '">' . $cfg['name'] . '</th>';
                                                        $columns ++;
                                                    }
                                                ?>
                                                <th>操作</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if(HVerify::isEmpty(HResponse::getAttribute('list'))) {
                                                    echo '<tr><td colspan="' . $columns . '" class="center">暂无相关记录</td></tr>';
                                                }
                                                foreach(HResponse::getAttribute('list') as $key => $record) {
                                                    echo $key % 2 == 0 ? '<tr class="odd"' . '" id="' . $record['id'] .'">' : '<tr ' . '" id="' . $record['id'] .'">';
                                                    echo '<td class="center"><label><input type="checkbox" name="id[]" value="' .  $record['id'] . '"/><span class="lbl"></span></label>';
                                                    echo '</td>';
                                                    foreach($showFields as $field => $cfg) {
                                                         echo '<td class="field field-' . $field . '" field="' . $field . '" data="' . $record[$field] . '" id="' . $record['id'] . '">' . HResponse::formatText($field, $record) . '</td>';
                                                    }
                                            ?>
                                                    <td>
                                                        <div class="hidden-phone visible-desktop btn-group"> 
                                                            <a href="<?php echo HResponse::url('' . $modelEnName . '/editview', 'id=' . $record['id']); ?>" title="编辑记录" class='btn btn-mini btn-info'><i class="icon-edit"></i></a>
                                                            <a href="<?php echo HResponse::url('' . $modelEnName . '/delete', 'id=' .  $record['id']);?>" title="删除信息" class="btn btn-mini btn-danger delete"><i class="icon-trash"></i></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <div class="dataTables_info" id="table_report_info">
                                                一共 <?php echo HResponse::getAttribute('totalRows');?> 条记录 
                                                当前位置: <?php echo HResponse::getAttribute('curPage') . '/' . HResponse::getAttribute('totalPages')?></strong>页
                                            </div>
                                        </div>
                                        <div class="span6">
                                            <div class="dataTables_paginate paging_bootstrap pagination">
                                                <ul><?php echo HResponse::getAttribute('pageHtml');?></ul>
                                            </div>
                                        </div>
                                        <div class="span3 txt-right">
                                            <div class="quick-operation">
                                                <label>批量操作:</label>
                                                <select name="operation" class="span7" id="operation">
                                                    <option value="">选择操作</option>
                                                    <option value="delete">删除</option>
                                                    <?php
                                                        foreach(HPopoHelper::getMoreFields($popo) as $field => $cfg) {
                                                            echo '<option value="' . $field . '">'. $cfg['name'] . '</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </form>
