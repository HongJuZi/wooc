/**
 * @version $Id$
 * @create 2012-9-26 10:29:57 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

/**
 * 详细信息页的初始化信息 
 * 
 * @desc
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package js 
 * @since 1.0.0
 */
HHJsLib.register({
    errors: {total: 0, obj: {}},  //错误信息统计
    init: function() {
        this.bindName();
        this.clickCheckBox();
        this.bindEditorList();
        this.bindCodeEditorList();
        this.bindSyncDescriptionAndSeoDesc();
        this.bindFieldVerify();
        this.bindFileField();
        this.bindInfoFormSubmit();
        this.initCurWebsiteId();
        this.initWebsiteDataSelect();
        this.bindLookUpBtn();
        HHJsLib.autoSelect('select.auto-select');
    },
    bindLookUpBtn: function() {
        $("a.lookup-btn").click(function() {
            $("<div></div>").load($(this).attr('data-lookup-url'), function(response) {
                HHJsLib.dialogByHtml(response, "#lookup-checkbox-dialog");
            });
        });
    },
    initWebsiteDataSelect: function() {
        if(0 < $("#website_data").length) {
            $("#website_data").html($("#website-list").html());
        }
    },
    initCurWebsiteId: function() {
        if(1 > $('#website_id').length) {
            return;
        }
        if(/addview/i.test(window.location.href)) {
            $('#website_id').val($('#website-list').val());
        }
    },
    bindInfoFormSubmit: function() {
        var _root = this;
        $("#info-form").submit(function() {
            if(0 < _root.errors.total) {
                alert('您还有' + _root.errors.total + '处错误录入没有修正，请按提示修正！');
                for(var ele in _root.errors.obj) {
                    if('undefined' != typeof _root.errors.obj[ele].attr('name')) {
                        _root.errors.obj[ele].focus();
                        return false;
                    }
                }
            }

            return true;
        });
    },
    verifyFeildTools: {
        verifyNull: function(cfgValue, value) {
            if(false === cfgValue && !value) {
                throw "不能为空！";
            }
        },
        verifyLen: function(cfgValue, value) {
            if(value && cfgValue < value.length) {
                throw "字符太多！最大长度：" + cfgValue + "。";
            }
        },
        verifyNumeric: function(cfgValue, value) {
            if(true === cfgValue && !/^-?(\d+\.)?\d+$/.test(value)) {
                throw "不是有效数字！";
            }
        }
    },
    bindFieldVerify: function() {
        var _root   = this;
        $("div.controls input[type=text], div.controls textarea").bind("blur", function() {
            var value           = $(this).val();
            var verifyItems     = eval("(" + $(this).attr('data-verify') + ")");
            for(var item in verifyItems) {
                var cfgValue    = verifyItems[item];
                var method      = "verify" + item.substring(0, 1).toUpperCase() + item.substring(1);
                if(typeof _root.verifyFeildTools[method] != 'undefined') {
                    try {
                        _root.verifyFeildTools[method](cfgValue, value);
                    } catch(e) {
                        tips    = e;
                        _root.showTips(e, $(this));
                        return false;
                    }
                }
            }
            _root.removeTips($(this));
        });
    },
    //显示提示
    showTips: function(tips, $field) {
        var $parent     = $field.parent();
        if(1 > $parent.find('span.arrowed').length) {
            $field.css('border', '1px #ff0000 solid');
            var $tipHtml    = $('<span class="label label-warning arrowed hide fade in">' + tips + '</span>');
            $tipHtml.insertBefore($field.parent().find('span.help-inline'));
            $tipHtml.fadeIn();
            this.errors.total ++;
            this.errors.obj[$field.attr('name')]  = $field;
            return;
        }
        $parent.find('span.arrowed').html(tips);
    },
    //移除提示
    removeTips: function ($field) {
        var $parent     = $field.parent();
        if(0 < $parent.find('span.arrowed').length) {
            $parent.find('span.arrowed').remove();
            $field.css('border', '1px #ccc solid');
            this.errors.total --;
            delete this.errors.obj[$field.attr('name')];
        }
    },
    bindCodeEditorList: function() {
        for(var ele in codeEditorList) {
            this._setCodeEditor(codeEditorList[ele]);
        }
    },
    _setCodeEditor: function(targetId) {
         if('undefined' == document.getElementById(targetId)) {
             return null;
         }
         CodeMirror.commands.autocomplete = function(cm) {
            CodeMirror.simpleHint(cm, CodeMirror.javascriptHint);
         };
         var editor = CodeMirror.fromTextArea(document.getElementById(targetId), {
            lineNumbers: true,
            extraKeys: {
                "Ctrl-Space": "autocomplete"
            },
            onCursorActivity: function() {
                editor.setLineClass(hlLine, null, null);
                hlLine = editor.setLineClass(editor.getCursor().line, null, "activeline");
            },
            theme: 'ambiance',
            lineWrapping: true,
            tabMode: 'spaces',
            tabSize: 4,
            indentUnit: 4,
            indentWithTabs: false 
         });
         var hlLine  = editor.setLineClass(0, null, 'activeline');
         editor.setSize(800, 200);

         return editor;
    },
    bindEditorList: function() {
        for(var ele in editorList) {
            HHJsLib.bindEditor(editorList[ele], siteUrl + "vendor/editor/ueditor", 'ueditor');
        }
    },
    clickCheckBox: function() {
        $("input.ace-switch").each(function() {
            if($(this).val() == $(this).attr("cur")) {
                $(this).click();
                return false;
            }
            if('true' == $(this).attr('def')) {
                $(this).click();
                return false;
            }
        });
    },
    bindFileField: function() {
        $('input.file-field').each(function() {
            $(this).ace_file_input({
                no_file:'没有文件...',
                btn_choose:'选择',
                btn_change:'修改',
                droppable:false,
                onchange:null,
                thumbnail:true, //| true | large
                whitelist: $(this).attr('file-type')
                //blacklist:'exe|php'
            });
        });
    },
    bindName: function() {
        $("#name").bind('change', function() {
            var seoName     = $(this).val();
            var curId       = $("#id").val();
            var $this       = $(this);
            $.getJSON(
                siteUrl + "index.php/admin/" + modelEnName + "/ahasname",
                {name: seoName, id: curId},
                function(data) {
                    if(false == data.rs) {
                        alert(data.message);
                        $this.css('border', '1px #ff0000 solid').focus();
                        return;
                    }
                    $this.css('border', '1px #ccc solid');
                }
            );
        }).blur(function() {
            if(0 < $('#seo_keywords').length && !$('#seo_keywords').val()) {
                $('#seo_keywords').val($(this).val()); 
            }
        });
    },
    bindSyncDescriptionAndSeoDesc: function() {
        $('#description').blur(function() {
            if(0 < $('#seo_desc').length && !$('#seo_desc').val()) {
                $('#seo_desc').val($(this).val()); 
            }
        });
    }
});
