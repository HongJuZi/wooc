        <div class="control-group">
			<label class="control-label" for="website_id"><?php echo $popo->getFieldName('website_id'); ?>： </label>
            <div class="controls">
                <select  name="website_id" id="website_id" cur="<?php echo !empty($record['website_id']) ? $record['website_id'] : $popo->getFieldAttribute('website_id', 'default'); ?>" class="auto-select span3">
                    <option value="">--<?php HResponse::lang('SELECT_LANG_TYPE'); ?>--</option>
                    <?php foreach(HResponse::getAttribute('langtype_list') as $type) { ?>
                    <option value="<?php echo $type['identifier']; ?>"><?php echo $type['name']; ?></option>
                    <?php  }?>
                </select>
				<span class="help-inline"><?php echo $popo->getFieldComment('website_id'); ?></span>
            </div>
		</div>
