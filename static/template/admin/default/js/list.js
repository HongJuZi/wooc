
/**
 * @version $Id$
 * @create Sat 03 Aug 2013 17:50:39 CST By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
(function($) {
    var HList   = {
        init: function() {
            //var oTable1 = $('#table_report').dataTable();
            this.bindCheckAll();
            this.bindPerpageCategoryChange();
            this.bindOperationChange();
            this.bindEditField();
            this.bindExcelImport();
            HHJsLib.autoSelect('#category');
            HHJsLib.autoSelect('#perpage');
            HHJsLib.fieldHint('input.search-query');
            $("#data-grid-box").tablesorter({headers:{0:{sorter:false}}});
        },
        bindExcelImport: function() {
            $('#excel-import').click(function() {
                $('#dialog-excel-import').modal('show');
                $('#import-btn').click(function() {
                    try {
                        HHJsLib.isEmptyByDom('#m', '当前模块名称');
                        HHJsLib.isEmptyByDom('#excel-file', '需要导入的Excel文件');
                        $('#excel-form').submit();
                        return true;
                    } catch(e) {
                        return HHJsLib.warn(e);
                    }
                });
            });
        },
        bindEditField: function() {
            var textAreaTpl = '<textarea name="{field}" id="{id}" class="field-data" data="{data}">{data}</textarea>';
            $('td.field').bind('dblclick', function() {
                var _this           = $(this);
                if(_this.html() == _this.attr('data')) {
                    //todo:: 加上关联表的信息加载
                }
                var textAreaHtml    = textAreaTpl.replace(/{field}/, _this.attr('field'));
                textAreaHtml        = textAreaHtml.replace(/{id}/, _this.attr('id'));
                textAreaHtml        = textAreaHtml.replace(/{data}/g, _this.attr('data'));
                _this.html(textAreaHtml);
                HList.bindTextAreaFieldData();
            });
        },
        bindTextAreaFieldData: function() {
            $('td.field textarea.field-data').bind('blur', function() {
                var _this   = $(this);
                if(_this.val() == _this.attr('data')) {
                    _this.parent().html(_this.val());
                    _this.remove();
                    return HHJsLib.succeed('修改成功！');
                }
                $.getJSON(
                    siteUrl + 'index.php/admin/' + modelEnName + '/aupdate',
                    {id: _this.attr('id'), field: _this.attr('name'), data: _this.val()},
                    function(data) {
                        if(false === data.rs) {
                            return HHJsLib.warn(data.message);
                        }
                        _this.parent().html(_this.val());
                        _this.remove();
                        HHJsLib.succeed(data.message);
                    }
                );
            });
        },
        bindCheckAll: function() {
            $('table th input:checkbox').on('click' , function(){
                var that = this;
                $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function(){
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });
            });
        },
        bindPerpageCategoryChange: function() {
            $("#category, #perpage").bind('change', function() {
                if($(this).val()) {
                    $("#search-form").submit();
                }
            });
        },
        bindOperationChange: function() {
            $("#operation").bind('change', function() {
                try {
                    if(!$(this).val()) {
                        return false;
                    }
                    var items       = $("#list-form input:checked"); 
                    if(typeof items.length == 'undefined' || items.length < 1 ) {
                        $(this).find("option:first").attr("selected", "true");
                        return HHJsLib.warn("请选择需要操作的记录！");
                    }
                    $("#list-form").submit();
                } catch(e) {
                    return HHJsLib.warn(e);
                }
                return false;
            });
        }
    };
    //注册对象事件
    HHJsLib.register(HList, HList.init, 'init'); 
})(jQuery);
