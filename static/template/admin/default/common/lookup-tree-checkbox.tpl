<div class="modal hide fade" id="lookup-checkbox-dialog">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>请选择分类</h3>
    </div>
    <div class="modal-body">
        <div class="ztree lookup-tree-checkbox-box" id="lookup-tree"></div>
    </div>
    <div class="modal-footer">
        <a href="###" data-dismiss="modal" aria-hidden="true" class="btn">关闭</a>
        <a href="###" class="btn btn-primary" id="lookup-done-btn">确定选择</a>
    </div>
</div>
<script type="text/javascript">
    var lookupCheckNodes    = [];
    var field               = "<?php echo HRequest::getParameter('field'); ?>";
    var syncUrl             = "<?php echo HResponse::getAttribute('sync_url'); ?>";
    <?php 
        $ids    = explode(',', HRequest::getParameter('id'));
        foreach(HResponse::getAttribute('list') as $node) { 
            $checked        = !in_array($node['id'], $ids) ? '' : ', checked: true';
    ?>
    lookupCheckNodes.push({
        id: <?php echo $node['id']; ?>,
        name: "<?php echo $node['name']; ?>",
        isParent: true
        <?php echo $checked; ?>
    });    
    <?php } ?>
    HHJsLib.importCss([
        cdnUrl + '/jquery/plugins/ztree/css/zTreeStyle/zTreeStyle.css'
    ]);
    HHJsLib.importJs(
        [
            cdnUrl + '/jquery/plugins/ztree/js/jquery.ztree.core-3.5.min.js',
            cdnUrl + '/jquery/plugins/ztree/js/jquery.ztree.excheck-3.5.min.js',
            siteUri + '/js/lookup-checkbox.js'
        ],
        function() {
           HJZLookupTreeCheckBox.init();
        }
    );
</script>
