
/**
 * @version $Id$
 * @create 2013/10/3 18:39:41 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

//注册标签相关的工具脚本
HHJsLib.register({
    init: function() {
        HHJsLib.importCss([cdnUrl + "/jquery/plugins/tagsinput/jquery.tagsinput.css"]);
        HHJsLib.importJs([cdnUrl + "/jquery/plugins/tagsinput/jquery.tagsinput.min.js"], function() {
            $('#tags').tagsInput({
                width: '47.517948717948715%', 
                height: 45, 
                'defaultText': '添加标签',
                onAddTag: function(tag) {
                    $.getJSON(
                        siteUrl + 'index.php/public/tags/autolearn',
                        {tag: tag, id: $("#id").val(), model: modelEnName},
                        function(response) {
                            if(false === response.rs) {
                                HHJsLib.warn(response.message);
                                return false;
                            }
                            $("#tag-ids").val($("#tag-ids").val() + "," + response.id);
                        }
                    );
                },
                onRemoveTag: function(tag) {
                    $.getJSON(
                        siteUrl + 'index.php/public/tags/aremovetag',
                        {tag: tag, id: $("#id").val(), model: modelEnName },
                        function(response) {
                            if(false === response.rs) {
                                HHJsLib.warn(response.message);
                                return false;
                            }
                            var tagIds  = $("#tag-ids").val();
                            tagIds      = ("," + tagIds + ",").replace(',' + response.id + ',', ',');
                            tagIds      = tagIds === ',' ? '' : tagIds;
                            $("#tag-ids").val(tagIds);
                            HHJsLib.succeed('删除' + tag + "标签成功～");
                        }
                    );
                }
            });
        });
        this.bindAddTag();
    },
    bindAddTag: function() {
        $('#tag-list a.tag').click(function() {
            var tag     = $(this).html();
            var tags    = $('input#tags').val();
            if(-1 < ("," + tags + ",").indexOf("," + tag + ",")) {
                return;
            }
            $("#tags").addTag(tag);
        });
    }
});
