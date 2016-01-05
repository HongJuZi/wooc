
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

HHJsLib.register({
    init: function() {
        this.bindBtnFile();
    },
    bindBtnFile: function() {
        var self        = this;
        var content     ='<div class="tabbable">'
        + ' <ul class="nav nav-tabs" id="myTab">'
        + ' <li class="active">'
        + ' <a data-toggle="tab" href="#local-file">'
        + ' <i class="green icon-home bigger-110"></i>'
        + ' 本地上传'
        + ' </a>'
        + ' </li>'
        + ' <li>'
        + ' <a data-toggle="tab" href="#insert-remote">'
        + ' 插入远程图片'
        + ' </a>'
        + ' </li>'
        + ' </ul>'
        + ' <div class="tab-content">'
        + ' <div id="local-file" class="tab-pane in active">'
        + ' <div id="dialog-upload-file-uploader" class="wu-example">'
        + ' <div id="dialog-upload-file-thelist" class="uploader-list">'
        + ' <div id="demo-file-box"></div>'
        + '</div>'
        + ' <div class="btns">'
        + ' <div id="dialog-upload-file-btn">选择文件</div>'
        + ' </div>'
        + ' </div>'
        + ' </div>'
        + ' <div id="insert-remote" class="tab-pane row-fluid">'
        + ' <div class="form-group">'
        + ' <label class="control-label no-padding-right" for="form-url"> 地址： </label>'
        + ' <div>'
        + ' <input type="text" id="from-remote-url" placeholder="请输入图片地址..." class="span12">'
        + ' </div>'
        + ' </div>'
        + ' </div>'
        + ' </div>'
        + '</div>';
        $("button.btn-file").click(function() {
            var field   = $(this).attr('data-field');
            var t       = HHJsLib.Modal.confirm(
                '选择图片',
                content,
                function() { }
            );
            self.bindFromRemoteUrl(field);
            self.bindUploadBtn(field, $(this).attr('data-type'));
        });
    },
    bindUploadBtn: function(field, type) {
        switch(type) {
            case 'image': {
                this.uploadImage(field);
                break;
            }
            case 'file': 
            default: {
                this.uploadFile(field);
            }
        }
    },
    uploadImage: function(field) {
        var uploader = HJZUploader.createImage('#dialog-upload-file-btn', {
            formData: formData[field],
            auto: true,
            fileVal: 'path'
        }, function(file, response) {
            if(false == response.rs) {
                uploader.reset();
                return HHJsLib.warn(response.message);
            }
            var data    = response.data;
            $('#' + field).val(data.src).attr(
                'data-url', 
                siteUrl + data.src
            );
            $('#demo-file-box').html('<img src="' + siteUrl + data.src + '"/>');
            $('#' + field + '-lightbox')
            .html('<img src="' + siteUrl + data.small + '"/>')
            .attr('href', siteUrl + data.src);
            uploader.reset();
            HHJsLib.succeed('恭喜，上传成功！');
        }); 
    },
    uploadFile: function(field) {
        var uploader = HJZUploader.createFile('#dialog-upload-file-btn', {
            formData: formData[field],
            auto: true,
            fileVal: 'path'
        }, function(file, response) {
            if(false == response.rs) {
                uploader.reset();
                return HHJsLib.warn(response.message);
            }
            var data    = response.data;
            $('#' + field).val(data.src).attr(
                'data-url', 
                siteUrl + data.src
            );
            $('#demo-file-box').html(
                '上传文件：<a href="' + data.src + '" title="点击下载">' + data.name + '</a>'
            );
            uploader.reset();
            HHJsLib.succeed('恭喜，上传成功！');
        }); 
    },
    bindFromRemoteUrl: function(field) {
        $('#from-remote-url').bind('change', function() {
            try {
                HHJsLib.isUrlByDom($(this), '图片地址');
                var url     = $(this).val();
                $('#' + field).val(url).attr('data-url', url);
                $('#' + field + '-lightbox')
                .html('<img src="' + url + '"/>')
                .attr('href', url);
            } catch(e) {
                $(this).val('');
                return HHJsLib.warn(e);
            }
        });
    }
});
