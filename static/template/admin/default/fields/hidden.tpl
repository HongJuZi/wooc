                            <input type="hidden" id="<?php echo $field; ?>" name="<?php
                            echo $field; ?>" value="<?php echo !empty($record[$field]) ? $record[$field] : $popo->getFieldAttribute($field, 'default'); ?>" />
