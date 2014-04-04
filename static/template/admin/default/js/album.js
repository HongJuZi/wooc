
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
HHJsLib.register({
    init: function() {
        this.initEditPicDialog();
        this.initUploadify();
        this.bindToolLinks();
        this.bindEditPicBtn();
        this.bindDeleteMoreBtn();
    },
    initEditPicDialog: function() {
        $('body').append($("#dialog-pic-edit-tpl").html());
        $("#dialog-pic-edit-tpl").html("");
    },
    initUploadify: function() {
        var _root   = this;
        HHJsLib.importCss([cdnUrl + "/uploadify/css/uploadify.css"]);
        HHJsLib.importJs([cdnUrl + "/uploadify/jquery.uploadify.min.js"],
            function() {
                $(function() {
                    $('#file_upload').uploadify({
                        'fileObjName'   : 'path',
                        'buttonText'    : '添加图片',
                        'formData'      : formData,
                        'height'        : 120,
                        'width'         : 100,
                        'swf'           : cdnUrl + '/uploadify/uploadify.swf',
                        'uploader'      : siteUrl + 'index.php/public/resource/aupload',
                        'onUploadSuccess' : function(file, data, response) {
                            data    = eval("(" + data + ")");
                            if(false == data.rs) {
                                alert(data.message);
                                return;
                            }
                            var picTpl  = $('#pic-tpl').html();
                            picTpl      = picTpl.replace(/{id}/g, data.id);
                            picTpl      = picTpl.replace(/{name}/g, data.name);
                            picTpl      = picTpl.replace(/{description}/g, data.name);
                            picTpl      = picTpl.replace(/{src}/g, siteUrl + data.src);
                            picTpl      = picTpl.replace(/{small}/g, siteUrl + data.small);
                            $pic        = $(picTpl).hide().fadeIn('fast');
                            $("#album-list-box").append($pic);
                            _root._bindDeletePic($pic.find("a.pic-delete"));
                            _root._bindEditPicLink($pic.find("a.pic-edit"));
                            _root._bindCheckLink($pic.find("a.check-item"));
                            showMessage(':）上传成功！');
                        }
                    });
                });
            }
        );
    },
    bindToolLinks: function() {
        this._bindDeletePic("a.pic-delete");
        this._bindEditPicLink('a.pic-edit');
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
                {id: $this.attr('id')},
                function(data) {
                    if(false === data.rs) { 
                        showMessage(data.message, 'warning');
                        return;
                    }
                    var $parent     = $this.parent().parent();
                    $parent.fadeOut('normal', function() {
                        $parent.remove();
                    });
                    showMessage(':）删除成功！');
                }
            );
        });
    },
    _bindEditPicLink: function(target) {
        $(target).click(function() {
            var id  = $(this).attr('id');
            $('#pic-id').val(id);
            $('#pic-name').val($('#img-' + id).attr('alt'));
            $('#pic-title').html($('#img-' + id).attr('alt'));
            $('#pic-description').val($("#description-" + id).html())
            $("#dialog-pic-edit").modal('show');
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
    bindEditPicBtn: function() {
        $("#edit-pic-btn").click(function() {
            try {
                HHJsLib.isEmptyByDom('#pic-id', '图片ID');
                HHJsLib.isEmptyByDom('#pic-name', '名称');
                HHJsLib.isEmptyByDom('#pic-description', '简介');
                var id      = $("#pic-id").val();
                $.getJSON(
                    siteUrl + "index.php/admin/linkeddata/aedit",
                    {id: id, name: $('#pic-name').val(), description: $('#pic-description').val()},
                    function(data) {
                        if(false === data.rs) {
                            showMessage(data.message, 'warning');
                            return;
                        }
                        $('#description-' + id).html($('#pic-description').val());
                        $('#img-' + id).attr('alt', $('#pic-name').val());
                        $('#dialog-pic-edit').modal('hide');
                        showMessage(':）修改成功！');
                    }
                );
            } catch(e) {
                showMessage(e.message, 'wraning');
                e.dom.focus();
                return false;
            }
        });
    },
    bindDeleteMoreBtn: function() {
        $("#delete-more-btn").click(function() {
            var $checkedItems   = $("#album-list-box input:checked");
            if(1 > $checkedItems.length) {
                showMessage('您还没有选择需要删除的图片！', 'info');
                return false;
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
                {id: ids.toString()},
                function(data) {
                    if(false === data.rs) { 
                        showMessage(data.message, 'warning');
                        return;
                    }
                    for(var ele in ids) {
                        $('#pic-' + ids[ele]).fadeOut('fast', function() {
                            $(this).remove();
                        });
                    }
                    showMessage(':）删除成功！');
                }
            );
        });
    }
});
