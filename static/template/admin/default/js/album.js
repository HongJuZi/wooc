
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
HHJsLib.register({
    thumbTpl: ' <li id="pic-{id}" class="pic btn-app">'
    + ' <a href="###" id="{id}" class="check-item pic">'
    + ' <img alt="{name}" src="{small}" />'
    + ' <div class="text">'
    + ' <div class="inner description">{description}</div>'
    + ' </div>'
    + ' </a>'
    + ' <div class="tools tools-bottom">'
    + ' <a target="_blank" href="{src}" class="pic-link" title="查看原图"><i class="icon-link"></i></a>'
    + ' <a href="###" class="pic-delete" id="thumb-{id}" data-id="{id}" data-model="{model}" title="删除图片"><i class="icon-remove red"></i></a>'
    + ' </div>'
    + ' <span class="hide label label-info icon-check">&nbsp;</span>'
    + ' <input type="checkbox" id="item-{id}" value="{id}" class="hide check-item"/>'
    + ' </li>',
    init: function() {
        this.initUploadify();
        this.bindToolLinks();
        this.bindDeleteMoreBtn();
    },
    initUploadify: function() {
        var _root   = this;
        for(var ele in albumFormData) {
            var time    = new Date();
            var item    = albumFormData[ele];
            var uploader        = HJZUploader.createImage('#file-upload', {
                formData: item,
                auto: true,
                fileVal: 'path'
            }, function(file, response) {
                if(false == response.rs) {
                    uploader.reset();
                    return HHJsLib.warn(response.message);
                }
                var data    = response.data;
                var picTpl  = _root.thumbTpl.replace(/{id}/g, data.id);
                picTpl      = picTpl.replace(/{name}/g, data.name);
                picTpl      = picTpl.replace(/{description}/g, data.name);
                picTpl      = picTpl.replace(/{src}/g, siteUrl + data.src);
                picTpl      = picTpl.replace(/{model}/g, item.model);
                picTpl      = picTpl.replace(/{small}/g, siteUrl + data.small);
                $pic        = $(picTpl).hide().fadeIn('fast');
                $("#album-list-box").append($pic);
                _root._bindDeletePic($pic.find("a.pic-delete"));
                _root._bindCheckLink($pic.find("a.check-item"));
                HHJsLib.succeed('恭喜，上传成功！');
            }); 
        }
    },
    bindToolLinks: function() {
        this._bindDeletePic("a.pic-delete");
        this._bindCheckLink('a.check-item');
    },
    _bindDeletePic: function(target) {
        $(target).click(function() {
            if(!confirm('您真的要从相册里删除此图片吗？')) {
                return;
            }
            var $this   = $(this);
            $.getJSON(
                siteUrl + "index.php/admin/linkeddata/adelete",
                {id: $this.attr('data-id'), rel_model: $this.attr('data-model'), 'item_model': 'resource'},
                function(data) {
                    if(false === data.rs) { 
                        return HHJsLib.warn(data.message);
                    }
                    var $parent     = $this.parent().parent();
                    $parent.fadeOut('normal', function() {
                        $parent.remove();
                    });
                    return HHJsLib.succeed(':）删除成功！');
                }
            );
        });
    },
    _bindCheckLink: function(target) {
        $(target).click(function() {
            var $item   = $('#item-' + $(this).attr('id'));
            if(!$item.attr('checked')) {
                $item.attr('checked', true);
                $(this).parent().find('span.icon-check:first').show();
                return;
            }
            $item.attr('checked', null);
            $(this).parent().find('span.icon-check:first').hide();
        });
    },
    bindDeleteMoreBtn: function() {
        $("#delete-more-btn").click(function() {
            var $checkedItems   = $("#album-list-box input:checked");
            if(1 > $checkedItems.length) {
                return HHJsLib.info('您还没有选择需要删除的图片！');
            }
            if(!confirm('您真的要删除选中的图片吗？')) {
                return false;
            }
            var ids     = [];
            $checkedItems.each(function() {
                ids.push($(this).val());
            });
            $.getJSON(
                siteUrl + "index.php/admin/linkeddata/adelete",
                {id: ids.toString(), rel_model: modelEnName, item_model: 'resource'},
                function(data) {
                    if(false === data.rs) { 
                        return HHJsLib.warn(data.message);
                    }
                    for(var ele in ids) {
                        $('#pic-' + ids[ele]).fadeOut('fast', function() {
                            $(this).remove();
                        });
                    }
                    return HHJsLib.succeed(':）删除成功！');
                }
            );
        });
    }
});
