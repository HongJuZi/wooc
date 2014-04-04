        <div class="control-group">
		    <label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?>： </label>
            <div class="controls">
                <select  name="<?php echo $field; ?>" id="<?php echo $field; ?>" data-cur="<?php echo !empty($record[$field]) ? $record[$field] : $popo->getFieldAttribute($field, 'default'); ?>" class="auto-select span3">
                    <?php foreach(HResponse::getAttribute($field . '_list') as $type) { ?>
                    <option value="<?php echo $type['id']; ?>"><?php echo $type['name']; ?></option>
                    <?php  }?>
                </select>
		        <span class="help-inline"><?php echo $popo->getFieldComment($field); ?></span>
            </div>
	    </div>
