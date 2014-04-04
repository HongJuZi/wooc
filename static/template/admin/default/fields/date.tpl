                                <div class="control-group">
                                    <label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?></label>
                                    <div class="controls">
                                        <div class="row-fluid input-append date span3">
                                            <input class="span10 date-picker" id="<?php echo $field; ?>" type="text" name="<?php echo $field; ?>" value="<?php echo empty($record[$field]) ? date('Y-m-d') : date('Y-m-d', strtotime($record[$field])); ?>" placeholder="请添加<?php echo $popo->getFieldName($field); ?>" data-date-format="yyyy-mm-dd"/>
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                        <span class="help-inline"><?php echo $popo->getFieldComment($field); ?></span>
                                    </div>
                                </div>
                                <script type="text/javascript">
                                    HHJsLib.importCss(["<?php echo HResponse::uri(); ?>/css/datepicker.css"]); 
                                    HHJsLib.importJs(
                                        ["<?php echo HResponse::uri(); ?>/js/bootstrap-datepicker.min.js"],
                                        function() {
                                            $("input.date-picker").datepicker({
                                                format: 'yyyy-mm-dd',
                                                autoclose: true,
                                                todayBtn: true,
                                                minuteStep: 2,
                                                todayHighlight: 1,
                                                language: 'zh-CN'
                                            }); 
                                        }
                                    );
                                </script>
