        <div class="control-group">
		    <label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?>： </label>
            <div class="controls">
                <select multiple
                name="<?php echo $field; ?>[]" 
                id="<?php echo $field; ?>" 
                data-cur="<?php echo !empty($record[$field]) ? $record[$field] : $popo->getFieldAttribute($field, 'default'); ?>" 
                class="auto-select span12 chosen-select" 
                data-placeholder="请选择（可多选）" >
                    <?php foreach(HResponse::getAttribute($field . '_list') as $type) { ?>
                    <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
                    <?php  }?>
                </select>
                <small class="help-info"><?php echo $popo->getFieldComment($field); ?></small>
            </div>
            <div class="clearfix"></div>
	    </div>
        <script type="text/javascript"> 
            selectList.push('#<?php echo $field; ?>');
            HHJsLib.autoMultiSelect('#<?php echo $field; ?>');
        </script>
