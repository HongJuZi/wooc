/**
 * @version $Id$
 * @create 2012-9-26 10:29:57 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

/**
 * 详细信息页的初始化信息 
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
        this.bindLinkedLangAutoSearch();
        this.bindDeleteLangLinkedBtn('a.btn-remove-lang-linked');
        this.bindTagList();
        this.bindSelectList();
    },
    bindSelectList: function() {
        HHJsLib.importCss([cdnUrl + "/jquery/plugins/chosen/chosen.css"]);
        HHJsLib.importJs([cdnUrl + "/jquery/plugins/chosen/chosen.jquery.js"], function() {
            for(var ele in selectList) {
                $(selectList[ele]).chosen({no_results_text: "没有找对应内容!"}); 
            }
        });
    },
    bindTagList: function() {
        if(1 > tagList.length) {
            return;
        }
        HHJsLib.importCss([cdnUrl + "/jquery/plugins/tagsinput/jquery.tagsinput.css"]);
        HHJsLib.importJs([cdnUrl + "/jquery/plugins/tagsinput/jquery.tagsinput.min.js"], function() {
            for(var ele in tagList) {
                HHJsLib.Tags.initTags(tagList[ele]);
            }
        });
    },
    bindLinkedLangAutoSearch: function() {
        var self    = this;
        var process = false;
        $('#linked-lang-keyword').bind('blur change', function(evt) {
            var $target     = $(this);
            if(evt.keyCode > 35 && evt.keyCode < 41) { //方向键
                return this.isDownMove($target, keyCode);
            }
            if(false === process) {
                return;
            }
            $target.css('color', '#333');
            var val    = encodeURIComponent($target.val());
            if(!val) {
                return;
            }
            var process     = true;
            $.getJSON(
                queryUrl + '/admin/' + modelEnName + '/akeyword',
                {keyword: val, ids: self.getHasLinkedIds()},
                function(response) {
                    process     = false;
                    if(false === response.rs) {
                        return HHJsLib.warn(response.message);
                    }
                    if(!response.data || 1 > response.data.length) {
                        $('#linked-search-result-list').html('<li>没有找到符合条件的记录！</li>');
                        return;
                    }
                    var liHtml      = '';
                    var liTpl       = '<li id="linked-item-{id}" data-id="{id}">'
                        + '<a href="###" data-id="{id}" title="{name}" data-lang="{lang}"><strong>[{lang}]</strong> - ' 
                        + '{sname}</a></li>';
                    for(var ele in response.data) {
                        var item        = response.data[ele];
                        var itemHtml    = liTpl.replace(/{id}/g, item.id);
                        itemHtml        = itemHtml.replace(/{name}/g, item.name);
                        itemHtml        = itemHtml.replace(/{sname}/g, item.name.substring(0, 16));
                        liHtml          += itemHtml.replace(/{lang}/g, langMap[item.lang_id].name);
                    }
                    $('#linked-search-result-list').html(liHtml).show();
                    $('#linked-search-result-list li').hover(function() {
                        $("#linked-search-result-list li.on").removeClass('on');
                    });
                    self.bindAcWordsList();
                }
            );
        });
    },
    getHasLinkedIds: function() {
        var ids     = new Array();
        $('#lang-linked-box p.linked-item input').each(function() {
            ids.push($(this).val());
        });
        if($('#id').val()) {
            ids.push($('#id').val());
        }

        return ids.join(',');
    },
    bindAcWordsList: function() {
        var self    = this;
        $('#linked-search-result-list a').click(function() {
            var $this   = $(this);
            $("#linked-lang-keyword").val('').css('color', '#333');
            self.appendLangLinkedInfo({
                id: $this.attr('data-id'), 
                name: $this.attr('title'),
                lang: $this.attr('data-lang')
            });
            $('#linked-search-result-list').hide();
        });
    },
    appendLangLinkedInfo: function(data) {
        var itemHtml    = '<p class="linked-item" id="item-{id}">'
        + ' <a href="' + queryUrl + '/admin/' + modelEnName + '/editview?id={id}" title="{lang}">{name}</a>'
        + ' <a href="###" class="btn-remove-lang-linked" data-rel-id="" data-id="{id}"><i class="icon-remove"></i></a>'
        + ' <input type="hidden" name="lang_linked[]" value="{id}" id="lang-linked-{id}"/>'
        + ' </p>';
        itemHtml        = itemHtml.replace(/{id}/g, data.id);
        itemHtml        = itemHtml.replace(/{name}/g, data.name);
        itemHtml        = itemHtml.replace(/{lang}/g, data.lang);
        if(1 > $('#lang-linked-box p.linked-item').length) {
            $('#lang-linked-box').html(itemHtml);
        } else {
            $('#lang-linked-box').append(itemHtml);
        }
        this.bindDeleteLangLinkedBtn('#item-' + data.id + ' a.btn-remove-lang-linked');
    },
    bindDeleteLangLinkedBtn: function(dom) {
        $(dom).click(function() {
            var id      = $(this).attr('data-id');
            var relId   = $(this).attr('data-rel-id');
            HHJsLib.confirm(
                '您真的要删除这个对应语言吗？删除后将解除所有关联关系，不可恢复！',
                function() {
                    if(!relId) {
                        $('#item-' + id).remove();
                        return;
                    }
                    $.getJSON(
                        queryUrl + '/admin/' + modelEnName + '/adellanglinked',
                        {extend: id, id: $('#id').val()},
                        function(response) {
                            if(false === response.rs) {
                                return HHJsLib.warn(response.message);
                            }
                            $('#item-' + id).remove();
                            return HHJsLib.succeed('对应语言记录，删除成功！');
                        }
                    );
                }
            );
        });
    },
    bindInfoFormSubmit: function() {
        var _root = this;
        $("#info-form").submit(function() {
            if(0 < _root.errors.total) {
                for(var ele in _root.errors.obj) {
                    if('undefined' != typeof _root.errors.obj[ele].attr('name')) {
                        _root.errors.obj[ele].focus();
                        return false;
                    }
                }
                return HHJsLib.warn('您还有' + _root.errors.total + '处错误录入没有修正，请按提示修正！');
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
        this.errors.obj[$field.attr('name')]  = $field;
        this.errors.total ++;
        if(1 > $parent.find('span.arrowed').length) {
            $field.css('border', '1px #ff0000 solid');
            var $tipHtml    = $('<span class="label label-warning arrowed hide fade in">' + tips + '</span>');
            $tipHtml.insertBefore($field.parent().find('span.help-inline'));
            $tipHtml.fadeIn();
            return;
        }
        $parent.find('span.arrowed').html(tips);
    },
    //移除提示
    removeTips: function ($field) {
        var $parent     = $field.parent();
        if(0 < this.errors.total) {
            this.errors.total --;
            delete this.errors.obj[$field.attr('name')];
        }
        if(0 < $parent.find('span.arrowed').length) {
            $parent.find('span.arrowed').remove();
            $field.css('border', '1px #ccc solid');
        }
    },
    bindCodeEditorList: function() {
        if(1 > codeEditorList.length) {
            return;
        }
        var _root   = this;
        HHJsLib.importCss([
            cdnUrl + "/codemirror/lib/codemirror.css",
            cdnUrl + "/codemirror/theme/eclipse.css"
        ]);
        HHJsLib.importJs([
            cdnUrl + "/codemirror/lib/codemirror.js",
            cdnUrl + "/codemirror/mode/javascript/javascript.js"
        ], 
        function() {
            for(var ele in codeEditorList) {
                HHJsLib.codeEditor[codeEditorList[ele]]     = _root.setCodeEditor(codeEditorList[ele]);
            }
        }
        );
    },
    setCodeEditor: function(targetId) {
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
            theme: 'monokai',
            lineWrapping: true,
            tabMode: 'spaces',
            tabSize: 4,
            indentUnit: 4,
            indentWithTabs: false 
        });
        var hlLine  = editor.setLineClass(0, null, 'activeline');
        editor.setSize('100%', 200);
        $(".CodeMirror").css("font-size", "13px");

        return editor;
    },
    bindEditorList: function() {
        for(var ele in editorList) {
            HHJsLib.bindEditor(
                editorList[ele].field, 
                siteUrl + "vendor/editor/ueditor", 
                'ueditor', 
                editorList[ele].type
            );
        }
    },
    clickCheckBox: function() {
        $("input.ace-switch").each(function() {
            if($(this).val() == $(this).attr("data-cur")) {
                $(this).click();
                return true;
            }
            if($(this).val() == $(this).attr("data-def")) {
                $(this).click();
                return true;
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
