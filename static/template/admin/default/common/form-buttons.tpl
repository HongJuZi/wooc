<div class="pre-next-record span8">
    <?php 
        $preRecord      = HResponse::getAttribute('preRecord');
        echo empty($preRecord) ? '' : HHtml::a(
            HResponse::url(
                HResponse::getAttribute('HONGJUZI_MODEL') . '/editview',
                'id=' . $preRecord['id']
            ),
            '上一条：' . $preRecord['name'],
            'title="' . $preRecord['name'] . '" class="pre-record"'
        );
        $nextRecord     = HResponse::getAttribute('nextRecord');
        echo empty($nextRecord) ? '': HHtml::a(
            HResponse::url(
                HResponse::getAttribute('HONGJUZI_MODEL'),
                'id=' . $nextRecord['id']
            ),
            '下一条：' . $nextRecord['name'],
            'title="' . $nextRecord['name'] . '" class="next-record"'
        );
    ?>
</div>
<div class="span4">
    <input class="button" type="submit" value="<?php HResponse::lang('SUBMIT'); ?>" />
    <input class="button" type="reset" value="<?php HResponse::lang('RESET'); ?>" />
    <a class="button_link" href="javascript:void(0);" id="go-back-id"><?php HResponse::lang('RETURN'); ?></a>
</div>
