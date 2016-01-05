
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
HHJsLib.register({
    init: function() {
        this.bindOpenAddCatBoxBtn();
        this.bindCancelCatBtn();
        this.bindAddCatBtn();
        this.bindTreeCheckBoxList();
    },
    bindTreeCheckBoxList: function() { 
        if(1 > treeCheckboxList.length) {
            return;
        }
        var self    = this;
        var setting = {
            check: {
                chkStyle: "radio",
                radioType: "all",
                enable: true 
            },
            data: {
                simpleData: {
                    enable: true
                }
            },
            callback: {
                onCheck: function() {
                    self.setParentIds();
                }
            }
        };
        for(var ele in treeCheckboxList) {
            $.fn.zTree.init($(treeCheckboxList[ele].dom), setting, treeCheckboxList[ele].data);
        }
    },
    setParentIds: function() {
        var zTree   = $.fn.zTree.getZTreeObj("parent_id-tree");
        var nodes   = zTree.getCheckedNodes(true);
        var ids     = [];
        for(var ele in nodes) {
            ids.push(nodes[ele].id);
        }
        $("#parent_id").val(ids.join(','));
    },
    bindAddCatBtn: function() {
        var self    = this;
        $("#add-cat-btn").click(function() {
            try {
                HHJsLib.isEmptyByDom('#new-cat-name', '新分类名称');
                HHJsLib.isEmptyByDom('#new-parent_id', '所属分类');
                $.getJSON(
                    queryUrl + 'admin/category/anew',
                    {name: encodeURIComponent($('#new-cat-name').val()), pid: $('#new-parent_id').val()},
                    function(response) {
                        if(false === response.rs) {
                            return HHJsLib.warn(response.message);
                        }
                        $('#add-category-box').fadeOut('fast');
                        var zTree   = $.fn.zTree.getZTreeObj("parent_id-tree"); 
                        var pNode   = zTree.getNodeByParam('id', $('#new-parent_id').val());
                        zTree.addNodes(pNode, response.node);
                        self.setParentIds();
                        $('#new-cat-name').val('');
                    }
                );
            } catch(e) {
                return HHJsLib.warn(e);
            }
        });
    },
    bindCancelCatBtn: function() {
        $('#cancel-add-cat-btn').click(function() {
            $('#add-category-box').hide();
        });
    },
    bindOpenAddCatBoxBtn: function() {
        $('#open-new-cat-box-btn').click(function() {
            $("#add-category-box").show();
        });
    }
});
