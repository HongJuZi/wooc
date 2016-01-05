                                <form action="<?php echo HResponse::url('' . $modelEnName . '/quick'); ?>" method="post" id="list-form">
                                    <table id="data-grid-box" class="table table-striped table-bordered table-hover" >
                                        <thead>
                                            <tr>
                                                <th class="center">
                                                    <label><input type="checkbox"/><span class="lbl"></span></label>
                                                </th>
                                                <?php
                                                    $columns        = 2;
                                                    $showFields     = HResponse::getAttribute('show_fields');
                                                    foreach($showFields as $key => $cfg ) {
                                                        echo '<th class="field-' . $key . '" title="' . $cfg['comment'] . '">' . HTranslate::__($cfg['name']) . '</th>';
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
                                                echo '<td class="center"><label><input type="checkbox" name="id[]" value="' .  $record['id'] . '" class="chk-me"/><span class="lbl"></span></label>';
                                                echo '</td>';
                                                foreach($showFields as $field => $cfg) {
                                                    echo '<td class="field field-' .  $field . '" field="'
                                                         . $field . '" data-old="' . $record[$field]
                                                         . '" id="' .  $field . '-' . $record['id']
                                                    . '" data-id="' .  $record['id'] . '">' ;
                                                    echo HResponse::formatText($field, $record);
                                                    echo '</td>' ;
                                                }
                                        ?>
                                                <td>
                                                    <?php 
                                                        if($modelCfg && 2 == $modelCfg['has_multi_lang']) {
                                                            require(HResponse::path('admin') . '/common/multi-lang-actions.tpl'); 
                                                        } else {
                                                            require(HResponse::path('admin') . '/common/single-lang-actions.tpl'); 
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="row-fluid">
                                        <div class="span3">
                                            <div class="dataTables_info" id="table_report_info">
                                                共 <?php echo HResponse::getAttribute('totalRows');?> 条
                                                当前: <?php echo HResponse::getAttribute('curPage') . '/' . HResponse::getAttribute('totalPages')?></strong>页
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
