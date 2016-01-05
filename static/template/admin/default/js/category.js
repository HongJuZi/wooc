$(function(){
	//删除之后的select
	function removeSubItem(classname,id)
	{
		$("."+classname).each(function() {
			if($(this).attr("id") > id) {
				$(this).remove();
			}	
		});
	}
    $("#category-items-id select.category-items").bind("change", function(){
		loadSubItemList($(this));
	});
    
	//加载下级部门
	function loadSubItemList($target)
	{
		var thatId      = $target.attr("id");
		var pid         = $target.val();
		removeSubItem('category-items', thatId);
		setItemId($target);
        if(!pid || pid == 0 ) {
            return;
        }
		$.post(siteUrl + 'index.php/admin/category/asubcategory',
			{'pid': pid , 'model_name':modelName},
			function(data) {
				if(typeof data == 'undefined' || typeof data.list == 'undefined' || 1 > data.list.length) {
					return ;
				}
				var options         = "";
				var categoryList    = data.list;
				for(var i = 0; i < categoryList.length; i ++) {
					var category    = categoryList[i];
					options         += "<option value='"
					+ category.id
					+ "'>"
					+ category.name
					+ "</option>";
				}
				removeSubItem('category-items', thatId);
			    $("#"+$target.parent().attr("id")).append("<select class=\""
			    	+ "category-items" 
			    	+ "\" id=\""
		    		+ (++ thatId)
		    		+ "\">"
		    		+ "<option value=\"\">--请选择分类--</option>"
		    		+ options
		    		+ "</option>"
	    		);
                $(".category-items").bind("change", function(){
                    loadSubItemList($(this));
                });
			},
			"json"
		);
	}
	//设置当前选中的组织信息
	var setItemId = function($target) {
    	$('#' + categoryFieldId).val($target.val());
    };
    //初始化当前的分类列表
    var initSubItemList = function() {
        var $items      = $("#category-items-id select.category-items");
        if(1 > $items.length || !$items[0].value || 1 > $items[0].value) {
            return;
        }
        loadSubItemList($($items[0]));
    };
    initSubItemList();
});
