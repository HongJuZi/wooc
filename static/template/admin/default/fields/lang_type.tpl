        <div class="control-group">
			<label class="control-label" for="parent-id"><?php echo $popo->getFieldName('lang_type'); ?>： </label>
            <div class="controls">
                <select  name="lang_type" id="lang_type" cur="<?php echo !empty($record['lang_type']) ? $record['lang_type'] : $popo->getFieldAttribute('lang_type', 'default'); ?>" class="auto-select span3">
                    <option value="">--<?php HResponse::lang('SELECT_LANG_TYPE'); ?>--</option>
                    <?php foreach(HResponse::getAttribute('langtype_list') as $type) { ?>
                    <option value="<?php echo $type['identifier']; ?>"><?php echo $type['name']; ?></option>
                    <?php  }?>
                </select>
            </div>
		</div>
