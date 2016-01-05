
/**
 * @version $Id$
 * @create Sat 03 Aug 2013 17:50:39 CST By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
HHJsLib.register({
    formatDateTimeList: ['td.field-edit_time'],
    init: function() {
        this.bindCheckAll();
        this.bindPerpageCategoryChange();
        this.bindOperationChange();
        this.bindEditField();
        this.bindFormatTimestamp();
        HHJsLib.autoSelect('#category');
        HHJsLib.autoSelect('#brand-category');
        HHJsLib.autoSelect('#rows');
        HHJsLib.fieldHint('input.search-query');
        $("#data-grid-box").tablesorter({headers:{0:{sorter:false}}});
        this.initDatePicker();
    },
    initDatePicker: function() {
        HHJsLib.importCss([siteUri + "css/datepicker.css"]); 
        HHJsLib.importJs(
            [siteUri + "js/bootstrap-datepicker.min.js"],
            function() {
                $("input.date-picker").datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true,
                    todayBtn: true,
                    minuteStep: 2,
                    todayHighlight: 1,
                    language: 'zh-CN'
                }); 
            }
        );
    },
    bindFormatTimestamp: function() {
        if(1 > this.formatDateTimeList.length) {
            return;
        }
        for(var ele in this.formatDateTimeList) {
            $(this.formatDateTimeList[ele]).each(function() {
                $(this).html(HHJsLib.timestampToDateTime($.trim($(this).text())));
            });
        }
    },
    bindEditField: function() {
        var _root       = this;
        var textAreaTpl = '<textarea name="{field}" data-id="{id}" id="{field}-{id}" class="field-data" data-old="{data}">{data}</textarea>';
        $('td.field').bind('dblclick', function() {
            var _this           = $(this);
            if(_this.html() == _this.attr('data-old')) {
                //todo:: 加上关联表的信息加载
            }
            var textAreaHtml    = textAreaTpl.replace(/{field}/g, _this.attr('field'));
            textAreaHtml        = textAreaHtml.replace(/{id}/g, _this.attr('data-id'));
            textAreaHtml        = textAreaHtml.replace(/{data}/g, _this.attr('data-old'));
            _this.html(textAreaHtml);
            _root.bindTextAreaFieldData();
        });
    },
    bindTextAreaFieldData: function() {
        $('td.field textarea.field-data').bind('blur', function() {
            var _this   = $(this);
            if(_this.val() == _this.attr('data-old')) {
                _this.parent().html(_this.val());
                _this.remove();
                return HHJsLib.succeed('修改成功！');
            }
            $.getJSON(
                siteUrl + 'index.php/admin/' + modelEnName + '/aupdate',
                {id: _this.attr('data-id'), field: _this.attr('name'), data: _this.val()},
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
        $("#category, #brand-category, #rows").bind('change', function() {
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
        });
    }
});
