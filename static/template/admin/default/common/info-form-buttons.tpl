                                <div class="form-actions">
                                    <div class="pre-next-record">
                                        <?php 
                                            $preRecord      = HResponse::getAttribute('preRecord');
                                            echo empty($preRecord) ? '' : HHtml::a(
                                                HResponse::url(
                                                    HResponse::getAttribute('HONGJUZI_MODEL') . '/editview',
                                                    'id=' . $preRecord['id']
                                                ),
                                                '上一条：' . $preRecord['name'],
                                                'title="' . $preRecord['name'] . '" class="pre-record"'
                                            ) . '<br/>';
                                            $nextRecord     = HResponse::getAttribute('nextRecord');
                                            echo empty($nextRecord) ? '': HHtml::a(
                                                HResponse::url(
                                                    HResponse::getAttribute('HONGJUZI_MODEL') . '/editview',
                                                    'id=' . $nextRecord['id']
                                                ),
                                                '下一条：' . $nextRecord['name'],
                                                'title="' . $nextRecord['name'] . '" class="next-record"'
                                            );
                                        ?>
                                    </div>
                                    <button class="btn" type="reset"><i class="icon-undo"></i>重置</button>
                                    <button class="btn btn-info" type="submit"><i class="icon-ok"></i>提交</button>
                                </div>
                                <div class="hr"></div>
