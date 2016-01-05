
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

/**
 * 华为网盘抓取JS工具脚本
 * 
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @package js
 * @since 1.0.0
 */
HHJsLib.register({
    task: new HHTask({logBoxId: '#log-message-box'}),
    init: function() {
        this.bindInfoFormSubmit();
        this.bindAutoWriteSpiderUrl();
    },
    bindAutoWriteSpiderUrl: function() {
        $("span.url").click(function() {
            $("#url").val($(this).html());
        });
    },
    bindInfoFormSubmit: function() {
        var _root   = this;
        $("#start-btn").click(function() {
            try {
                HHJsLib.isUrlByDom("#url", '请求链接');
                HHJsLib.isNumberByDom("#start", '起始位置');
                var method  = $($("#myTab li.active")[0]).attr('data-method');
                if('undefined' === typeof(_root[method])) {
                    throw { message: '没有抓取功能，请确认！' };
                }
                _root[method]();
            } catch(e) {
                return HHJsLib.warn(e);
            }
        });
    },
    getFiles: function() {
        HHJsLib.isEmptyByDom("#category", '分类');
        var _root       = this;
        this.task.run(
            siteUrl + "index.php/spider/vdisk/agetfiles",
            function() {
                return {
                    url: $("#url").val(),
                    category: $("#category").val(),
                    start: $("#start").val()
                };
            },
            function(data, task) {
                if('undefined' !== typeof(data.message)) {
                    task.warn(data.message);
                }
                if(1 > data.total && 1 > data.next) {
                    task.stop();
                    HHJsLib.succeed("抓取资源完成～");
                    task.succeed("一共成功抓取约" + task.total + "个资源，任务完成～");
                    return;
                }
                var start   = parseInt($("#start").val());
                task.total  += data.total;
                task.succeed(
                    "从" + start + "开始，成功抓取<strong>" + data.total 
                     + "</strong>位，已经抓取<b>" + task.total + "</b>个资源！"
                );
                $("#start").val(data.next);
            }
        );
    }
});
