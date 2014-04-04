
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
        HHJsLib.autoSelect('select.auto-select');
        HHJsLib.bindLightBox("a.lightbox", cdnUrl + '/jquery/plugins/lightbox');
        HHJsLib.highLightElement('ul.nav-list li', 'active', 0, function(targetDom, target) {
            if(!$(target).hasClass('single')) {
                $(target).parent().parent().addClass('active');
            }
        });
        this.bindTimeInfo();
        this.bindSwitchWebsite();
        HHJsLib.fieldHint('input.search-query');
    },
    bindDeleteHint: function() {
        $("a.delete").click(function() {
            if(confirm("您确认要删除这条记录吗？删除后，就不能找回了！")) {
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
    }
});
