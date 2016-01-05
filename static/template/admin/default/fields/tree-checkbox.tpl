        <div class="control-group">
			<label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?>： </label>
            <div class="controls ztree-checkbox">
                <ul id="<?php echo $field; ?>-tree" class="ztree"
                    data-cur="<?php echo !empty($record[$field]) ? $record[$field] : $popo->getFieldAttribute($field, 'default'); ?>"
                ></ul>
                <input name="<?php echo $field;?>" type="hidden" id="<?php echo $field;?>" value="<?php echo $record[$field]; ?>"/>
                <small class="help-info"><?php echo $popo->getFieldComment($field); ?></small>
            </div>
            <div class="clearfix"></div>
		</div>
        <script type="text/javascript"> 
            treeCheckboxList.push({
                dom: '#<?php echo $field; ?>-tree',
                data: <?php echo json_encode(HResponse::getAttribute($field . '_nodes')); ?>
            });
        </script>
