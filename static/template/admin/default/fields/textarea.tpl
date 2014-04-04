		<div class="control-group">
			<label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?></label>
			<div class="controls">
				<textarea class="autosize-transition span6" id="<?php echo
                $field; ?>" placeholder="请添加<?php echo $popo->getFieldName($field); ?>" class="span6"
                data-verify='<?php echo json_encode($popo->getFieldVerifyCfg($field));?>'
                name="<?php echo $field; ?>"><?php echo !empty($record[$field]) ? trim($record[$field]) : trim($popo->getFieldAttribute($field, 'default')); ?></textarea>
				<span class="help-inline"><?php echo $popo->getFieldComment($field); ?></span>
			</div>
		</div>
