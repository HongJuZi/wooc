                                <div class="widget-box">
                                    <div class="widget-header">
                                        <h4>语言</h4>
                                        <div class="widget-toolbar">
                                            <a href="#" data-action="collapse">
                                                <i class="icon-chevron-up"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <?php $field = 'lang_id'; ?>
                                            <div class="control-group">
                                                <label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?>： </label>
                                                <div class="controls">
                                                    <?php 
                                                        $langId     = !HRequest::getParameter('lang') ? $record[$field] : HRequest::getParameter('lang');
                                                        $langId     = !$langId ?  $popo->getFieldAttribute($field, 'default') : $langId;
                                                    ?>
                                                    <select  name="<?php echo $field; ?>" id="<?php echo $field; ?>" data-cur="<?php echo $langId; ?>" class="auto-select span12">
                                                        <?php foreach(HResponse::getAttribute('lang_id_list') as $type) { ?>
                                                        <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
                                                        <?php  }?>
                                                    </select>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <script type="text/javascript">
                                                selectList.push("#<?php echo $field; ?>");
                                            </script>
                                            <div class="control-group">
                                                <label class="control-label" for="linked-article">翻译到：</label>
                                                <div class="controls" id="lang-linked-box">
                                                    <?php   
                                                        $langLinkedMap  = HResponse::getAttribute('langLinkedMap');
                                                        if(!$langLinkedMap) { 
                                                    ?>
                                                    <p id="no-lang-linked-list">暂无其它语言对应信息！</p>
                                                    <?php }?>
                                                    <?php 
                                                        foreach($langList as $lang) { 
                                                            if(!isset($langLinkedMap[$lang['id']])) {
                                                                continue;
                                                            }
                                                            $item   = $langLinkedMap[$lang['id']];
                                                    ?>
                                                    <p class="linked-item" id="item-<?php echo $item['id']; ?>">
                                                        <a href="<?php echo HResponse::url($modelEnName . '/editview', 'id=' . $item['id']); ?>"
                                                            title="<?php echo $lang['name']?>"
                                                            data-rel-id="<?php echo $record['id']; ?>">
                                                            <?php echo $item['name']; ?>
                                                        </a>
                                                        <a href="###"
                                                        class="btn-remove-lang-linked" 
                                                        data-id="<?php echo $item['id']; ?>"><i class="icon-remove"></i></a>
                                                        <input type="hidden"
                                                        name="lang_linked[]" 
                                                        value="<?php echo $item['id'];?>" 
                                                        id="lang-linked-<?php echo $item['id']; ?>"/>
                                                    </p>
                                                    <?php }?>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="linked-article">搜索关联：</label>
                                                <div class="controls auto-linked-search-box">
                                                    <input type="text" class="input-medium" placeholder="输入关键字搜索..." id="linked-lang-keyword"/>
                                                    <ul class="linked-search-result-list" id="linked-search-result-list"></ul>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
