		<div class="control-group">
			<label class="control-label" for="<?php echo $field; ?>"><?php echo $popo->getFieldName($field); ?></label>
			<div class="controls">
                <textarea name="content" id="<?php echo $field; ?>" style="width: 700px;" class="editor"><?php echo HString::decodeHtml($record[$field]); ?></textarea>
			</div>
		</div>
        <script type="text/javascript">editorList.push('<?php echo $field; ?>');</script>
