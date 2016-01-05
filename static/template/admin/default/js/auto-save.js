
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

//注册自动保存事件
HHJsLib.register({
    //是否已经开启自动保存
    _startAutoSaveId: null,
    //初始化动作
    init: function() {
        this.bindAutoSave();
    },
    bindAutoSave: function() {
        var _root   = this;
        $("#info-form input[name='name']").bind('change', function() {
            _root.startAutoSave();
        });
    },
    startAutoSave: function() {
        if(null !== this._startAutoSaveId) {
            return ;
        }
        var _root   = this;
        this._startAutoSaveId   = setInterval(function() {
            var formData    = $('#info-form').serialize();
            if('undefined' != typeof HHJsLib.editor['content']) {
                formData    += '&content=' + HHJsLib.editor['content'].getContent();
            }
            $.post(
                siteUrl + '/index.php/admin/' + modelEnName + '/autosave',
                formData,
                function(data) {
                    if(false == data.rs) {
                        showMessage(data.info, 'error');
                        return;
                    }
                    if(data.id > 0) {
                        $('#id').val(data.id);
                        $('#info-form').attr('action', siteUrl + '/index.php/admin/' + modelEnName + '/edit');
                    }
                    showMessage('自动保存成功！');
                },
                "json"
            );
        }, 30000);
    }
});
