
/**
 * @version $Id$
 * @create 2013/10/3 18:39:41 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

//注册标签相关的工具脚本
HHJsLib.extend({
    Tags: {
        initTags: function(dom) {
            var _root       = this;
            $(dom).tagsInput({
                width: '100%', 
                height: 36, 
                'defaultText': '添加标签',
                onAddTag: function(tag) {
                    $.getJSON(
                        siteUrl + 'index.php/public/tags/autolearn',
                        {tag: tag, id: $("#id").val(), rel_model: modelEnName},
                        function(response) {
                            if(false === response.rs) {
                                return HHJsLib.warn(response.message);
                            }
                            _root.addTargetValue("#tag_ids", response.id);
                            _root.addTargetValue("#tags_name", tag);
                        }
                    );
                },
                onRemoveTag: function(tag) {
                    $.getJSON(
                        siteUrl + 'index.php/public/tags/aremovetag',
                        {tag: tag, id: $("#id").val(), rel_model: modelEnName },
                        function(response) {
                            if(false === response.rs) {
                                HHJsLib.warn(response.message);
                                return false;
                            }
                            _root.removeTargetValue("#tag_ids", $("#id").val());
                            _root.removeTargetValue("#tags_name", tag);
                            HHJsLib.succeed('删除' + tag + "标签成功～");
                        }
                    );
                }
            });
        },
        addTargetValue: function(target, value) {
            var $target = $(target); 
            if(1 > $target.length) {
                return;
            }
            var cur     = $.trim($target.val());
            if(!value) {
                $target.val("," + value + ",");
                return;
            }
            var values    = cur.split(",");
            values.shift();
            values.pop();
            for(var ele in values) {
                if(values[ele] == value) {
                    return;
                }
            }
            values.push(value);
            $target.val("," + values.join(",") + ",");
        },
        removeTargetValue: function(target, value) {
            var $target   = $(target); 
            if(1 > $target.length) {
                return;
            }
            var cur     = $target.val().replace("," + value + ",", ","); 
            if(',' == cur) {
                $target.val("");
                return;
            }
            $target.val(cur);
        }
    }
});
