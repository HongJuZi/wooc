
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

 var HJZLookupTreeCheckBox  = {
     tree: null,
     init: function(setting) {
         this.initTree('undefined' === typeof(setting) ? {} : setting);
         this.bindLookUpDoneBtn();
     },
     bindLookUpDoneBtn: function() {
         var _root  = this;
         $("#lookup-done-btn").click(function() {
             var ids    = [];
             var names  = [];
             var nodes = _root.tree.getCheckedNodes(true);  
             for (var i = 0; i < nodes.length; i++) {  
                 ids.push(nodes[i].id);
                 names.push(nodes[i].name);
             }
             $("#lookup-ids-" + field).val(1 > ids.length ? '' : ',' + ids.join(",") + ',');
             $("#lookup-values-" + field).val(names.join(","));
             $("#lookup-checkbox-dialog").modal('hide');
         });
     },
     initTree: function(setting) {
         var _root  = this;
         var defSetting = {
             check : {
                 enable : true  
             },
             view: { 
                 showIcon: false, showLine: true,
                 dblClickExpand: false
             },
             async: {
                 enable: true,
                 url: syncUrl,
                 autoParam:["id", "name=n", "level=lv"],
                 otherParam:{},
                 dataFilter: function (treeId, parentNode, childNodes) {
                     if (!$.trim(childNodes)) return null;
                         $("#" + treeId).css("display", "block");
                     for (var i=0, l=childNodes.length; i<l; i++) {
                         if(typeof childNodes[i].name != 'undefined') {
                             childNodes[i].name = childNodes[i].name.replace(/\.n/g, '.');
                         }
                     }

                     return childNodes;
                 }
             },
             callback: {
                 onClick: function(event, treeId, treeNode) {
                     var zTree = $.fn.zTree.getZTreeObj(treeId);
                     zTree.expandNode(treeNode);
                 } 
             }
         };
         for(var ele in setting) {
             defSetting[ele]    = setting[ele];
         }
         this.tree  = $.fn.zTree.init($("#lookup-tree"), defSetting, lookupCheckNodes);
     }
 };
