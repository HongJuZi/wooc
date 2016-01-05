        <?php $parentInfo     = HResponse::getAttribute('parentInfo'); ?>
        <div class="control-group">
			<label class="control-label" for="<?php echo $field; ?>">选择分类： </label>
            <div id="category-area-id" class="controls">
                <div id="category-items-id" class="span6">
                    <select class="category-items auto-select" id="1" data-cur="<?php echo $record[$field];?>">
                        <option value="">请选择分类</option>
                        <option value="0">无</option>
                        <?php 
                            foreach(HResponse::getAttribute($field . '_list') as $category) {
                                if(0 < intval($category['parent_id'])) { continue; }
                        ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                        <?php }?>
                    </select>
                </div>
                <input type="hidden" value="<?php echo $record[$field];?>" name="<?php echo $field;?>" id="<?php echo $field; ?>"/>
                <span class="help-inline">（*）当前分类：<b><?php echo empty($parentInfo['name']) ? '无' : $parentInfo['name'];?></b>，默认为当前分类。</span>
            </div>
            <div class="clearfix"></div>
		</div>
        <script type="text/javascript"> 
        	var categoryFieldId = "<?php echo $field; ?>";
        	var modelName = "<?php echo $modelName; ?>";
        </script>
        <script type="text/javascript" src="<?php echo HResponse::uri('admin'); ?>/js/category.js"></script>
