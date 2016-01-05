        <div class="control-group">
            <label class="control-label" for="<?php echo $field; ?>">
                <?php echo $popo->getFieldName($field); ?>
            </label>
            <div class="controls">
                <textarea name="<?php echo $field; ?>" id="<?php echo $field; ?>" style="height: 150px;" class="span12 editor"><?php echo HString::decodeHtml($record[$field]); ?></textarea>
                <small class="help-info"><?php echo $popo->getFieldComment($field); ?></small>
            </div>
            <div class="clearfix"></div>
        </div>
        <script type="text/javascript">editorList.push({field: '<?php echo $field; ?>', type: 'base'});</script>
