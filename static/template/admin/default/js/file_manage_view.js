
/**
 * @version $Id$
 * @create 2012-10-12 10:24:35 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
 (function($) {
    /**
     * @var object HFileManagerView  资源管理对象 
     */
    var HFileManagerView   = {
        codeEditor: null,
        $dialog: $("#dialog-form"),
        init: function() {
            this.bindTopToolBar();
            this.bindFilterBox();
            this.bindCheckAllBtn();
            this.bindResourceListLi();
        },
        bindTopToolBar: function() {
            $('#btn-add-id').click(function() {
                HFileManagerView.createNewFileDialog();
                HFileManagerView.$dialog.dialog('open');
                HFileManagerView.codeEditor     = HFileManagerView.setCodeEditor('content-id');
            });
            $('#btn-newdir-id').click(function() {
                HFileManagerView.createNewDirDialog();
                HFileManagerView.$dialog.dialog('open');
            });
        },
        createNewFileDialog: function() {
            this.setDialogParams(
                '新建文件',
                '<label>文件名：<input type="text" id="file-name-id" value="" class="text" /></label>' +
                '<label>内&nbsp;&nbsp;&nbsp;容：<textarea id="content-id" class="lf"></textarea></label>' +
                '<label>覆盖同名文件：<input type="checkbox" id="override-id" /></label>',
                {
                    autoOpen: false,
                    modal: true,
                    height: 520,
                    width: 650,
                    buttons: {
                        "确定": function() {
                            var fileName    = $("#file-name-id").val();
                            $.post(
                                siteUrl + "/index.php/admin/resource/newfile",
                                {
                                    "file_name": fileName ,
                                    "content": HFileManagerView.codeEditor.getValue(), 
                                    "override": $("#override-id").attr('checked')
                                },
                                function(data) {
                                    alert(data.msg);
                                    if(typeof data.st != 'undefined' && data.st == 1) {
                                        HFileManagerView.$dialog.dialog("close");       
                                        window.location.href = window.location.href;
                                    }
                                },
                                "json"
                             );
                        },
                        "取消": function() {
                            HFileManagerView.$dialog.dialog("close");
                        }
                    }
                }
            );
        },
        createNewDirDialog: function() {
            this.setDialogParams(
                '新建文件夹',
                '<label>文件夹名：<input type="text" id="dir-name-id" value="" class="text" /></label>',
                {
                    autoOpen: false,
                    modal: true,
                    height: 200,
                    width: 450,
                    buttons: {
                        "确定": function() {
                            var dirName    = $("#dir-name-id").val();
                            $.post(
                                siteUrl + "/index.php/admin/resource/newdir",
                                {
                                    "dir_name": dirName
                                },
                                function(data) {
                                    alert(data.msg);
                                    if(typeof data.st != 'undefined' && data.st == 1) {
                                        HFileManagerView.$dialog.dialog("close");       
                                        window.location.href = window.location.href;
                                    }
                                },
                                "json"
                             );
                        },
                        "取消": function() {
                            HFileManagerView.$dialog.dialog("close");
                        }
                    }
                }
            );
        },
        bindFilterBox: function() {
            $('#js_fileter_box dl dd').bind('mouseover click', function() {
                $(this).find('ul').css('display', 'block'); 
            }).bind('mouseout', function() {
                $(this).find('ul').css('display', 'none'); 
            });
        },
        bindCheckAllBtn: function() {
            var $checkAll       = $('#check_all_file');
            var oldCheckStatus  = $checkAll.hasClass('checked');
            $('#check_all_file').click(function() {
                if(!oldCheckStatus) {
                    oldCheckStatus  = true;
                    $checkAll.addClass('checked');
                    $("#resource_list_inner li").each(function() {
                        $(this).find('input:checkbox').attr('checked', 'checked');
                        $(this).addClass('focus');
                    });
                } else {
                    oldCheckStatus  = false;
                    $checkAll.removeClass('checked');
                    $("#resource_list_inner li").each(function() {
                        $(this).find('input:checkbox').attr('checked', '');
                        $(this).removeClass('focus');
                    });
                }
            });
        },
        bindResourceListLi: function() {
            $('#resource_list_inner li').bind('click', function(e) {
                var $target  = $(e.target);
                if($target.hasClass('i-delete')) {
                    return HFileManagerView.deleteItem($target);
                }
                if($target.hasClass('i-rename')) {
                    return HFileManagerView.renameItem($target);
                }
                if($target.hasClass('i-edit')) {
                    return HFileManagerView.editItem($target);
                }
                if($target.hasClass('i-star')) {
                    return HFileManagerView.addToAlbum($target);
                }
                if($(this).hasClass('focus')) {
                    $(this).removeClass('focus');
                    $(this).find('input:checkbox').attr('checked', 'false');
                } else {
                    $(this).addClass('focus');
                    $(this).find('input:checkbox').attr('checked', 'checked');
                }
            });
            $('#resource_list_inner li').bind('mouseover', function() {
                $(this).find('span.file-ctrl').css('display', 'block');
            }).bind('mouseout', function() {
                $(this).find('span.file-ctrl').css('display', 'none');
            });
        },
        deleteItem: function($target) {
            var $item   = $target.parent().parent().parent().find("input:checkbox");
            var itemName = $item.val();
            if(!itemName) {
                alert('删除项目不能为空！');
                return false;
            }
            if(!confirm('真的要删除' + itemName + '吗？')) {
                return false;
            }
            $.get(
                siteUrl + "/index.php/admin/resource/delete",
                {"name": itemName },
                function(data) {
                    alert(data.msg);
                    if(typeof data.st != 'undefined' && data.st == 1) {
                        $item.parent().remove();
                    }
                },
                "json"
             );

            return true;
        },
        renameItem: function($target) {
            var $item   = $target.parent().parent().parent().find("input:checkbox");
            var itemName = $item.val();
            if(!itemName) {
                alert('重命名项目不能为空！');
                return false;
            }
            this.createRenameDailog();
            this.$dialog.dialog('open');
            $('#old-name-id').val(itemName);
            $('#new-name-id').val(itemName).select();
        },
        createRenameDailog: function() {
            this.setDialogParams(
                '重命名文件',
                '<input type="hidden" name="old_name" id="old-name-id" value="" />' +
                '<input type="text" name="new_name" id="new-name-id" value="" class="text" />',
                {
                    resizable: false,
                    autoOpen: false,
                    modal: true,
                    height: 160,
                    width: 450,
                    buttons: {
                        "确定": function() {
                            var newName     = $("#new-name-id").val();
                            $.get(
                                siteUrl + "/index.php/admin/resource/rename",
                                {
                                    "new_name": newName ,
                                    "old_name": $("#old-name-id").val()
                                },
                                function(data) {
                                    alert(data.msg);
                                    if(typeof data.st != 'undefined' && data.st == 1) {
                                        HFileManagerView.$dialog.dialog("close");
                                        window.location.href = window.location.href;
                                    }
                                },
                                "json"
                             );
                        },
                        "取消": function() {
                            HFileManagerView.$dialog.dialog("close");
                        }
                    }
                }
            );
        },
        editItem: function($target) {
            var $item   = $target.parent().parent().parent().find("input:checkbox");
            var itemName = $item.val();
            if(!itemName) {
                alert('编辑文件不能为空！');
                return false;
            }
            $.get(
                siteUrl + "/index.php/admin/resource/getfilecontent",
                {"file_name": itemName},
                function(data) {
                    if(typeof data.st != 'undefined' && 1 == data.st) {
                        HFileManagerView.createEditDailog(itemName);
                        HFileManagerView.$dialog.dialog('open');
                        $('#file-name-id').attr('value', itemName);
                        $('#content-id').val(data.msg);
                        HFileManagerView.codeEditor     = HFileManagerView.setCodeEditor('content-id');
                        return ;
                    }
                    alert(data.msg);
                },
                "json"
            );
            
        },
        createEditDailog: function(fileName) {
            this.setDialogParams(
                '正在编辑文件 - ' + fileName,
                '<label>文件名：<input type="text" id="file-name-id" value="" class="text" readonly="readonly"/></label>' +
                '<label>内&nbsp;&nbsp;&nbsp;容：<textarea id="content-id" class="lf"></textarea></label>',
                {
                    resizable: false,
                    autoOpen: false,
                    modal: true,
                    height: 490,
                    width: 650,
                    buttons: {
                        "确定": function() {
                            var fileName    = $("#file-name-id").val();
                            $.get(
                                siteUrl + "/index.php/admin/resource/edit",
                                {
                                    "file_name": fileName,
                                    "content": HFileManagerView.codeEditor.getValue() 
                                },
                                function(data) {
                                    alert(data.msg);
                                    if(typeof data.st != 'undefined' && data.st == 1) {
                                        HFileManagerView.$dialog.dialog("close");
                                        window.location.href = window.location.href;
                                    }
                                },
                                "json"
                             );
                        },
                        "取消": function() {
                            HFileManagerView.$dialog.dialog("close");
                        }
                    }
                }
            );
        },
        addToAlbum: function($target) {
            var fileName    = $target.parent().first().find('a').attr('title');
            this.showAddToAblumDialog(fileName);
            this.$dialog.dialog('open');
            this.findCurAlbum(fileName);
        },
        findCurAlbum: function(fileName) {
            $.get(
                siteUrl + "/index.php/admin/picture/albumid",
                { 'picture_name': fileName },
                function(data) {
                    if(data.st != 'undefined' && data.st == 1) {
                        HFileManagerView.loadAlbums(data.id);
                        return ;
                    }
                    alert(data.msg);
                },
                'json'
            );
        },
        loadAlbums: function(curAlbumId) {
            $.getJSON(
                siteUrl + "/index.php/admin/photoalbum/load",
                function(data) {
                    if(data.st != 'undefined' && data.st == 1) {
                        var options     = '';
                        var albums      = eval('(' + data.albums + ')');
                        for(var ele in albums) {
                            var selected    = '';
                            if(curAlbumId == albums[ele].photoalbum_id) {
                               selected     = '" selected = "selected'; 
                            }
                            options     += '<option value="' + albums[ele].photoalbum_id
                                        + selected + '">'
                                        + albums[ele].photoalbum_name
                                        + '</option>';
                        }
                        $("#album-id").append(options);
                    }
                }
            );
        },
        showAddToAblumDialog: function(fileName) {
            this.setDialogParams(
                '添加到相册 - ' + fileName,
                '<input type="hidden" name="file_name" id="file-name-id" value="' + fileName + '"/>' + 
                '<label>请选择相册：<select name="album" id="album-id" class="text"><option value="">请选择相册</option></select>' + 
                '<a href="javascript: ;" class="button">新建相册</a></label>' +
                '<label>新相册名称：<input type="text" name="photoalbum_name" value="" class="text"/></label>' +
                '<label><span>新相册简介：</span><textarea name="model_desc"></textarea></label>',
                {
                    resizable: false,
                    autoOpen: false,
                    modal: true,
                    height: 330,
                    width: 650,
                    buttons: {
                        "确定": function() {
                            var fileName    = $("#file-name-id").val();
                            $.get(
                                siteUrl + "/index.php/admin/picture/addtoalbum",
                                {
                                    "picture_name": $('#file-name-id').val(),
                                    "parent_id": $('#album-id').val() 
                                },
                                function(data) {
                                    alert(data.msg);
                                    if(typeof data.st != 'undefined' && data.st == 1) {
                                        HFileManagerView.$dialog.dialog("close");
                                        window.location.href = window.location.href;
                                    }
                                },
                                "json"
                             );
                        },
                        "取消": function() {
                            HFileManagerView.$dialog.dialog("close");
                        }
                    }
                }
            );

        },
        setDialogParams: function(title, html, options) {
            this.$dialog.remove();
            this.$dialog.attr('title', title);
            this.$dialog.html(html);
            this.$dialog.dialog(options);
        },
        setCodeEditor: function(targetId) {
            CodeMirror.commands.autocomplete = function(cm) {
                CodeMirror.simpleHint(cm, CodeMirror.javascriptHint);
            };
            var editor  = CodeMirror.fromTextArea(document.getElementById(targetId), {
                lineNumbers: true,
                extraKeys: {
                    "Ctrl-Space": "autocomplete"
                },
                onCursorActivity: function() {
                    editor.setLineClass(hlLine, null, null);
                    hlLine = editor.setLineClass(editor.getCursor().line, null, "activeline");
                },
                theme: 'monokai',
                lineWrapping: true,
                tabMode: 'spaces',
                tabSize: 4,
                indentUnit: 4,
                indentWithTabs: true
             });
             var hlLine  = editor.setLineClass(0, null, 'activeline');

             return editor;
        },
        getTotalCheckedItem: function() {
            return jQuery('.resource_area :checked').length;
        },
        getFileName: function(filePath) {
            return filePath.substring(0, filePath.lastIndexOf('.'));
        }
    };
    //注册初始化动作
    HHJsLib.register(HFileManagerView, HFileManagerView.init, 'init');
})(jQuery);

