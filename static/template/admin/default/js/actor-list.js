
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

 HHJsLib.register({
     actorId: null,
     rightsTree: null,
     init: function() {
         this.bindRightsTree();
         this.bindCheckedMeClick();
     },
     bindCheckedMeClick: function() {
         var _root      = this;
         $("input.chk-me").click(function() {
             var id     = $(this).val();
             if(!$(this).hasClass('checked')) {
                 _root.actorId   = id;
                 $(this).addClass('checked');
                 $("h4.config-box span.current-actor").html("正在配置“" + $("#name-" + id).text() + "”");
                 _root.loadActorInfo(id);
                 return;
             }
             $(this).removeClass('checked');
             if(1 > $("input.checked").length) {
                 $("h4.config-box span.current-actor").html("请选择配置角色");
                 _root.actorId  = null;
                 _root.rightsTree.checkAllNodes(false);
                 return;
             }
             if(_root.actorId == id) {
                id  = $("input.checked:first").val();
                _root.actorId   = id;
                 $("h4.config-box span.current-actor").html("正在配置“" + $("#name-" + id).text() + "”");
                 _root.loadActorInfo(id);
             }
         });
     },
     loadActorInfo: function(id) {
         var _root   = this;
         $.getJSON(
             queryUrl + "admin/linkeddata/aload",
             {rel_id: id, rel_model: "actor", item_model: "rights"},
             function(response) {
                 if(false === response.rs) {
                     return HHJsLib.warn(response.message);
                 }
                 _root.rightsTree.checkAllNodes(false);
                 for(var ele in response.data) {
                     var rights  = response.data[ele];
                     var node    = _root.rightsTree.getNodeByParam("id", rights.item_id, null);
                     if(!node) {
                         continue;
                     }
                     node.checked    = true;
                     node.oncheck    = true;
                     _root.rightsTree.updateNode(node);
                 }
             }
         );
     },
     bindRightsTree: function() {
         var _root  = this;
         var setting = {
             check: { enable: true },
             async: {
				enable: true,
				url: queryUrl + "admin/rights/aloadztree",
				autoParam:["id", "name=n", "level=lv"],
				otherParam:{},
				dataFilter: function (treeId, parentNode, childNodes) {
					if (!$.trim(childNodes)) return null;
					$("#" + treeId).css("display", "block");
					for (var i=0, l=childNodes.lengthj; i<l; i++) {
						if(typeof childNodes[i].name != 'undefined') {
							childNodes[i].name = childNodes[i].name.replace(/\.n/g, '.');
						}
					}
					
					return childNodes;
				}
			},
            view: { showIcon: true, showLine: true },
            callback: {
                onCheck: function(event, treeId, treeNode, clickFlag) {
                    if(null == _root.actorId) {
                        _root.rightsTree.checkAllNodes(false);
                        HHJsLib.warn("请先选择右边列表中需要编辑的角色！");
                        return;
                    }
                    if(treeNode.checked) {
                        _root.updateInfo(treeNode.id, treeNode.pId, "admin/actor/aaddfeature", "rights");
                        return;
                    }
                    _root.updateInfo(treeNode.id, treeNode.pId, "admin/actor/adeletefeature", "rights");
                }
            }
         };
         this.rightsTree    = $.fn.zTree.init($("#rights-tree"), setting, rightsNodes);
     },
     updateInfo: function(itemId, pId, url, model) {
         var _root  = this;
         $.getJSON(
             queryUrl + url,
             {item_id: itemId, rel_id: _root.actorId, p_id: pId, item_model: model},
             function(response) {
                 if(false == response.rs) {
                     return HHJsLib.warn(response.message);
                 }
                 HHJsLib.succeed("更新成功！");
             }
         );
     }
 });
