
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
HHJsLib.register({
    themeDialogTpl: '<div class="row-fluid">'
    + ' <div class="span7">'
    + ' <div class="screenshot"><img src="{image_path}" alt="{name}"></div>'
    + ' </div>'
    + ' <div class="span5">'
    + ' <div class="theme-info">'
    + ' <h3 class="theme-name">{name}<span class="theme-version">Version: {version}</span></h3>'
    + ' <h4 class="theme-author">By <a href="{website}" target="_blank">{publisher}</a></h4>'
    + ' <p class="theme-description">{description}</p>'
    + ' <p class="theme-tags"><span>Tags:</span> {tag}</p>'
    + ' </div>'
    + ' </div>'
    + ' </div>',
    init: function() {
        this.bindDeleteThemeBtn();
        this.bindThemeBtn();
    },
    bindThemeBtn: function() {
        var self        = this;
        $('a.theme-btn').click(function() {
            var id      = $(this).attr('data-id');
            var footer  = self.getFooter(id, $(this).attr('data-status')); 
            var $dialog     = HHJsLib.Modal.dialog(
                $(this).attr('data-title'), 
                '<p class="text-center">正在为您加载中...</p>',
                footer,
                function($dialog) { }
            );
            $dialog.css({'width': '90%', 'left': '26%'});
            $.getJSON(
                queryUrl + 'admin/theme/adetail',
                {id: id}, 
                function(response) {
                    if(false === response.rs) {
                        return HHJsLib.warn(response.message);
                    }
                    $('#dialog-body-' + $dialog.attr('data-id')).html(self.getThemeContent(response.data));
                }
            );
        });
    },
    getFooter: function(id, status) {
        var footer  = ' <a href="javascript:return false;" class="btn btn-grey btn-sm" data-dismiss="modal" aria-hidden="true" data-id="{id}" id="cancel-btn-{id}">关闭</a>' 
            + ' <a href="' + queryUrl + 'admin/theme/preview?id=' + id + '" class="btn btn-danger btn-sm" data-id="{id}" id="preview-btn-{id}">预览</a>';
        if(3 != status) {
             footer     += ' <a href="' + queryUrl + 'admin/theme/active?id=' + id + '" class="btn  btn-primary btn-sm" data-id="{id}" id="ok-btn-{id}">换上此主题</a>';
        }

        return footer;
    },
    getThemeContent: function(data) {
        var content     = this.themeDialogTpl.replace(/{name}/g, data.name);
        for(var ele in data) {
            var reg     = new RegExp('{' + ele + '}', 'ig');
            content     = content.replace(reg, data[ele]);
        }

        return content;
    },
    bindDeleteThemeBtn: function() {
        $('a.del-theme-btn').click(function() {
            var id  = $(this).attr('data-id');
            HHJsLib.Modal.confirm(
                '系统操作提示',
                '您确认要删除这个主题吗？删除后主题相关的所有文件也将会被移除，且不可恢复！', 
                function($dialog) {
                    HHJsLib.info('正在删除主题中，请稍等...');
                    $.getJSON(
                        queryUrl + 'admin/theme/adelete',
                        {id: id},
                        function(response) {
                            if(false === response.rs) {
                                return HHJsLib.Modal.warn(response.message);
                            }
                            $("#theme-" + id).fadeOut('slow', function() {
                                $(this).remove();
                            });

                            return HHJsLib.succeed('主题删除成功！');
                        }
                    );
                }
            );

            return false;
        });
    }
});
