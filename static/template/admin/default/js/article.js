
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
HHJsLib.register({
    len: 0,
    isFenci: false,
    init: function() {
        this.bindAutoFenci();
        this.bindNamePinYin();
    },
    bindNamePinYin: function() {
        $('#name').change(function() {
            if(!$(this).val()) {
                return;
            }
            $.getJSON(
                queryUrl + 'public/tstring/apinyin',
                {data: encodeURIComponent($(this).val())},
                function(response) {
                    if(false === response.rs) {
                        return HHJsLib.warn(response.message);
                    }
                    $('#identifier').val(response.data);
                }
            );
        });
    },
    bindAutoFenci: function() {
        var self    = this;
        var process = false;
        setInterval(function() {
            if(true === process) {
                return;
            }
            if('undefined' === typeof(HHJsLib.editor['content'])) {
                return;
            }
            var content     = HHJsLib.editor['content'].getContentTxt();
            if(!content) {
                return;
            }
            var contentLen  = content.length;
            if(self.len == contentLen && self.isFenci == true) {
                return;
            }
            $('#description').val(content.substring(0, 200));
            self.len    = contentLen;
            process     = true;
            $.post(
                queryUrl + 'public/tstring/afenci',
                {data: content},
                function (response) {
                    process     = false;
                    if(false === response.rs) {
                        return HHJsLib.warn(response.message);
                    }
                    var tagTopHtml  = '建议：';
                    for(var ele in response.data) {
                        tagTopHtml  += '<a href="###">' + response.data[ele].word + '</a>';
                    }
                    self.isFenci    = true;
                    $('#tags-top-list').html(tagTopHtml);
                    self.bindAddTag();
                },
                'json'
            );
        }, 3000);
    },
    bindAddTag: function() {
        var _root       = this;
        $('#tags-top-list a').click(function() {
            var tag         = $(this).html();
            var tagsName    = $('#tags_name').val();
            if(tagsName && 0 <= tagsName.indexOf(',' + tag + ',')) {
                $("#tags").removeTag(tag);
                return;
            }
            $("#tags").addTag(tag);
        });
    }
});
