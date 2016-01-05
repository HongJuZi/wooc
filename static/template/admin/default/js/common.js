
/**
 * @version $Id$
 * @create Sat 03 Aug 2013 21:49:02 CST By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

//日钟工具
function Clock() {
    var date = new Date();
    this.year = date.getFullYear();
    this.month = date.getMonth() + 1;
    this.date = date.getDate();
    this.day = new Array("星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六")[date.getDay()];
    this.hour = date.getHours() < 10 ? "0" + date.getHours() : date.getHours();
    this.minute = date.getMinutes() < 10 ? "0" + date.getMinutes() : date.getMinutes();
    this.second = date.getSeconds() < 10 ? "0" + date.getSeconds() : date.getSeconds();

    this.toString = function() {
        return (this.year) + "年" + this.month + "月" + this.date + "日 " + this.day + " " + this.hour + ":" + this.minute + ":" + this.second + " ";
    };

    this.toSimpleDate = function() {
        return this.year + "-" + this.month + "-" + this.date;
    };

    this.toDetailDate = function() {
        return this.year + "-" + this.month + "-" + this.date + " " + this.hour + ":" + this.minute + ":" + this.second;
    };
}

//公用的脚本
HHJsLib.register({
    init: function() {
        this.bindDeleteHint();
        $('[data-rel="tooltip"]').tooltip();
        HHJsLib.bindLightBox("a.lightbox", cdnUrl + '/jquery/plugins/lightbox');
        this.highLightNavmenuBox();
        this.bindTimeInfo();
        this.bindSwitchWebsite();
        this.bindNewByCopyBtn();
        this.bindDateList();
        this.bindDateTimeList();
        HHJsLib.fieldHint('input.search-query');
        HHJsLib.autoSelect('select.auto-select');
        this.bindUserExitBtn();
    },
    bindDateList: function() {
        HHJsLib.importCss([siteUri + "/css/datepicker.css"]); 
        HHJsLib.importJs(
            [siteUri + "/js/bootstrap-datepicker.min.js"],
            function() {
                for(var ele in dateList) {
                    $(dateList[ele]).datepicker({
                        format: 'yyyy-mm-dd',
                        autoclose: true,
                        todayBtn: true,
                        minuteStep: 2,
                        todayHighlight: 1,
                        language: 'zh-CN'
                    }); 
                }
            }
        );
    },
    bindDateTimeList: function() {
        HHJsLib.importCss([cdnUrl + "/bootstrap/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css"]); 
        HHJsLib.importJs(
            [cdnUrl + "/bootstrap/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js"],
            function() {
                for(var ele in datetimeList) {
                    $(datetimeList[ele]).datetimepicker({
                        format: 'yyyy-mm-dd hh:ii:ss',
                        autoclose: true,
                        todayBtn: true,
                        minuteStep: 2,
                        todayHighlight: 1,
                        language: 'zh-CN'
                    }); 
                }
            }
        );
    },
    bindNewByCopyBtn: function() {
        var self    = this;
        $('#btn-new-copy').click(function() {
            $.getJSON(
                queryUrl + 'admin/' + modelEnName + '/aloadlist',
                {page: 1},
                function(response) {
                    if(false === response.rs) {
                        return HHJsLib.warn(e);
                    }
                    self.showTableGridDialog(response.data);
                }
            );
        });
    },
    showTableGridDialog: function(data) {
        var theadHtml   = '';
        var tbodyHtml   = '';
        for(var field in data.fields) {
            theadHtml   += '<th data-column-id="' + field 
            + '" data-align="center" data-header-align="center">' 
            + data.fields[field].name + '</th>';
        }
        for(var ele in data.list) {
            tbodyHtml   += '<tr>';
            for(var field in data.fields) {
                tbodyHtml   += '<td>' + data.list[ele][field] +'</td>';
            }
            tbodyHtml       += '</tr>';
        }
        var t           = new Date().valueOf();
        var tableHtml   = TplMap.TableGrid.replace(/{thead}/g, theadHtml);
        tableHtml       = tableHtml.replace(/{tbody}/g, tbodyHtml);
        tableHtml       = tableHtml.replace(/{t}/g, t);
        var $dialog     = HHJsLib.Modal.confirm(
            '请选择基于的文章', 
            tableHtml, 
            function($dialog) { 
                HHJsLib.Modal.info($dialog.attr('data-id')); 
            }
        ).css('width', '1002px').css('left', '36%');
        this.initGridTable('#grid-' + t);
    },
    initGridTable: function(dom) {
        HHJsLib.importCss([
            cdnUrl + 'jquery/plugins/jquery.bootgrid/jquery.bootgrid.min.css'
        ]);
        HHJsLib.importJs([
            cdnUrl + 'jquery/plugins/jquery.bootgrid/jquery.bootgrid.min.js'
        ], function() {
            $(dom).bootgrid({
                formatters: {
                    "link": function(column, row) {
                        return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                    }
                }
            });
        });
    },
    highLightNavmenuBox: function() {
        HHJsLib.highLightElement('ul.nav-list li', 'active', 1, function(targetDom, target) {
            if(!$(target).hasClass('single')) {
                $(target).parent().parent().parent().addClass('active');
            }
        });
    },
    bindDeleteHint: function() {
        $("a.delete").click(function() {
            if(confirm("您确认要删除这条记录及关联数据吗？删除后，就不能找回了！")) {
                return true;
            }
            return false;
        });
    },
    bindTimeInfo: function() {
        setInterval(function() {
            $('#time-info').html(new Clock().toString());
        }, 1000);
    },
    bindSwitchWebsite: function() {
        $("#website-list").change(function() {
            var $this   = $(this);
            var href    = window.location.href;
            if(/editview|addview/i.test(href)) {
                if(1 ===  $('#website_id').length) {
                    $('#website_id').val($this.val());
                    HHJsLib.info('当前信息已经移动到“' + $this.find('option:selected').text() + '”，请提交！');
                }
                return;
            }
            HHJsLib.info('正在切换中...');
            $.getJSON(
                siteUrl + "/index.php/public/website/aswitch",
                {id: $this.val()},
                function(response) {
                    if(false === response.rs) {
                        return HHJsLib.warn(response.message);
                    }
                    HHJsLib.confirm('切换成功！是否现在刷新页面？', function() {
                        window.location.reload();
                    });
                }
            );
        });
    },
    bindUserExitBtn: function() {
        $('#exit-btn').click(function() {
            HHJsLib.confirm('确定退出？', function() {
                window.location.href = queryUrl + 'oauth/auser/logout';
            });
        });
    }
});
