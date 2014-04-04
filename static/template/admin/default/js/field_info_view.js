
/**
 * @version $Id$
 * @create 2012-10-15 11:27:26 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
 (function($) {
     var HFieldInfoView  = {
         init: function() {
             this.setCodeEditor('field_sql_id');
             this.tplEditor  = this.setCodeEditor('field_tpl_id');
             this.bindNormalTpl();
         },
         tplEditor: null,
         normalFieldTpl: {
             'tpl-text': "<p>\r\n"
                        + "    <label>{-}</label> \r\n"
                        + "    <?php HHtml::text('{#}', $record['{#}'], 'id=\"{#}_id\" class=\"sf\"'); ?>\r\n"
                        + "    <span class=\"field_desc\">帮助说明信息。</span>\r\n"
                        + "</p>",
             'tpl-textarea': "<p>\r\n"
							+ "    <label>{-}:</label>\r\n"
                            + "    <?php HHtml::textarea('{#}', $record['{#}'], 'id=\"{#}_id\" class=\"lf\"'); ?>\r\n"
							+ "    <span class=\"field_desc\">帮助说明信息。</span>\r\n"
						    + "</p>",
             'tpl-checkbox': "<p>\r\n"
                            + "    <label>{-}：</label>\r\n"
                            + "<?php\r\n"
                            + "    HHtml::checkbox('{#}', 2, $record['{#}'], 'id = \"{#}_id\" class=\"iphone\"');\r\n"
                            + "    if(!isset($record['{#}']) || $record['{#}] == 2) {\r\n"
                            + "        HHtml::invokeJs('jQuery('#{#}_id').click();');\r\n"
                            + "    }\r\n"
                            + "?>\r\n"
                            + "<span class=\"field_desc\">帮助说明信息。</span>\r\n"
                            + "</p>",
             'tpl-radiobox': "<p>\r\n"
							+ "<label>{-}：</label>\r\n"
                            + "<input type=\"radio\" name=\"{#}\" id=\"{#}_id\" value=\"男\"/> 男\r\n"
                            + "<input type=\"radio\" name=\"{#}\" id=\"{#}_id\" value=\"女\"/> 女\r\n"
							+ "<span class=\"field_desc\">帮助说明信息。</span>\r\n"
                            + "<script type=\"text/javascript\">\r\n"
                            + "    jQuery(\"input[name=sex]\").each(function() {\r\n"
                            + "        if(jQuery(this).val() == '<?php echo $record['{#}'];?>') {\r\n"
                            + "            jQuery(this).attr('checked', 'checked');\r\n"
                            + "        }\r\n"
                            + "    });\r\n"
                            + "</script>\r\n"
                            + "</p>",
             'tpl-select': "<p>\r\n"
                         + "    <label>{-}:</label>\r\n"
                         + "    <select name=\"{#}\" id=\"{#}_id\" class=\"dropdown\">\r\n"
                         + "        <option value=\"-1\">请选择类型</option>\r\n"
                         + "    </select>\r\n"
						 + "    <span class=\"field_desc\">帮助说明。</span>\r\n"
                         + "</p>",
             'tpl-file': "<p>\r\n"
					     + "    <label>{-}</label>\r\n"
						 + "    <input class=\"sf\" name=\"{#}\" type=\"file\" value=\"\" id=\"{#}_id\"/>\r\n"
						 + "    <span class=\"field_desc\">支持的文件类型：.jpg, .png, .gif; 大小：小于0.5M。</span>\r\n"
						 + "</p>",
             'tpl-tree': "<p>\r\n"
                         + "    <label>{-}:</label>\r\n"
                         + "    <select name=\"{#}\" id=\"{#}_id\" class=\"dropdown\">\r\n"
                         + "       <option value=\"-1\">请选择类型</option>\r\n"
                         + "    <?php\r\n "
                         + "        himport('hongjuzi.utils.HTree');\r\n"
                         + "        $hTree  = new HTree(\r\n"
                         + "            HResponse::getAttribute('parents'),\r\n"
                         + "            HResponse::getAttribute('parentName') . '_id',\r\n"
                         + "            'parent_id',\r\n"
                         + "            HResponse::getAttribute('parentName') . '_name',\r\n"
                         + "            HResponse::getAttribute('parentName') . '_id',\r\n"
                         + "            '<option value=\"{' .\r\n"
                         + "            HResponse::getAttribute('parentName') . '_id' . '}\">' .\r\n"
                         + "            '{' . HResponse::getAttribute('parentName') . '_name' .  '}' .\r\n"
                         + "            '</option>'\r\n"
                         + "        );\r\n"
                         + "        echo $hTree->getTreeStrByRecursion();\r\n"
                         + "    ?>\r\n"
                         + "    </select>\r\n"
						 + "    <span class=\"field_desc\">请选择需要的类型。</span>\r\n"
                         + "</p>",
             'tpl-editor': "<div class=\"p_editor\">\r\n"
						   + "  <label>{-}:</label>\r\n"
                           + "  <?php HHtml::editor('{#}', $record['{#}'], 'id=\"editor-id\" class=\"editor\"');?>\r\n"
						   + "</div>"
         },
         bindNormalTpl: function() {
             $('#normal-field-tpl').click(function(e) {
                 var $target    = $(e.target);
                 for(var tplField in HFieldInfoView.normalFieldTpl) {
                     if($target.hasClass(tplField)) {
                         if(typeof HFieldInfoView.normalFieldTpl[tplField] != 'undefined') {
                             var fieldEnName    = $('#field_name_id').val();
                             var fieldZhName    = $('#field_zh_name_id').val();
                             var tplCode        = HFieldInfoView.normalFieldTpl[tplField].replace(/{-}/g, fieldZhName);
                             tplCode            = tplCode.replace(/{#}/g, fieldEnName);
                             HFieldInfoView.tplEditor.setValue(tplCode);
                         }
                         return;
                     }
                 }
                 
             });
         },
         setCodeEditor: function(targetId) {
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
                indentWithTabs: true
             });
             var hlLine  = editor.setLineClass(0, null, 'activeline');

             return editor;
         }
     };
     //注册初始事件
     HHJsLib.register(HFieldInfoView, HFieldInfoView.init, 'init');
 })(jQuery);
