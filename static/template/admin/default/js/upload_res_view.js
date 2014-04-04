var uploadResView    = {
    init: function () {
       this.bindUploadFileTarget();
       this.bindUploadImageTarget();
    },
    bindUploadFileTarget: function () {
        jQuery('#res_file_id').uploadify({
            'auto': true,
            'fileObjName': 'res_file',
            'fileSizeLimit': 20000,
            'fileUploadLimit': 999,
            'wmode': 'transparent',
            'buttonText': '请选择文件',
            'fileTypeExt': '*.*',
            'fileTypeDesc': '所有文件',
            'swf': siteUrl + '/public/rendor/uploadify/uploadify.swf',
            'uploader': siteUrl + '/index.php/admin/resource/uploadfile',
            'onUploadSuccess': function(file, data, response) {
                //alert(data);
                return true;
            }
        });
    },
    bindUploadImageTarget: function () {
        jQuery('#res_image_id').uploadify({
            'auto': true,
            'fileObjName': 'res_image',
            'fileSizeLimit': 2000,
            'fileUploadLimit': 999,
            'wmode': 'transparent',
            'buttonText': '请选择图片',
            'fileTypeExt': '*.png;*.jpg;*.gif;*.bmp;*.jpeg',
            'fileTypeDesc': '图片文件',
            'swf': siteUrl + '/public/rendor/uploadify/uploadify.swf',
            'uploader': siteUrl + '/index.php/admin/resource/uploadimage',
            'onUploadSuccess': function(file, data, response) {
                //alert(data);
                return true;
            }
        });
    }
};
jQuery(document).ready(function() {
    uploadResView.init();
});
