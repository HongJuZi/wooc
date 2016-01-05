
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

HHJsLib.register({
    task: new HHTask({logBoxId: '#log-message-box'}),
    fieldsMap: {
        getHotUsers: ["url", "start", "limit"],
        getFans: ["uid", "url", "start", "limit", "is_self"],
        getFollow: ["uid", "url", "start", "limit", "is_self"],
        getFiles: ["uid", "url", "category", "parent_id", "replace", "start", "limit", "is_self", "tags", "title_name"],
        getDirFiles: ["url", "category", "parent_id", "replace", "start", "tags", "title_name"],
        replaceTesting: ["replace", "testing", "tags", "title_name"],
        getAlbumFiles: ["url", "category", "parent_id", "replace", "start", "tags", "title_name", "album_id", "album_name"],
        getAllFans:["url", "start", "limit"]
    },
    init: function() {
        this.bindInfoFormSubmit();
        this.bindAutoWriteSpiderUrl();
        this.bindTabClick();
        this.initTabFields("getHotUsers");
    },
    bindTabClick: function() {
        var _root   = this;
        $("#myTab > li > a").click(function() {
            var type    = $(this).parent().attr('data-method');
            _root.initTabFields(type);
        });
    },
    initTabFields: function(type) {
        if('undefined' === typeof(this.fieldsMap[type])) {
            return HHJsLib.warn("抓取类型不支持！");
        }
        $("#common-box div.control-group").hide();
        for(var ele in this.fieldsMap[type]) {
            $("#" + this.fieldsMap[type][ele]).parent().parent().show();
        }
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
                HHJsLib.isEmptyByDom("#url", '请求链接');
                HHJsLib.isNumberByDom("#start", '起始位置');
                HHJsLib.isNumberByDom("#limit", '抓取总数');
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
    getHotUsers: function() {
        var _root       = this;
        this.task.run(
            siteUrl + "index.php/spider/baiduuser/agethotusers",
            function() {
                return {
                    url: $("#url").val(),
                    start: $("#start").val(),
                    limit: $('#limit').val()
                };
            },
            function(data, task) {
                if(1 > data.total) {
                    task.stop();
                    HHJsLib.succeed("成功抓取热门用户完成～");
                    task.succeed("一共成功抓取约" + task.total + "位热门用户，任务完成～");
                    return;
                }
                var start   = parseInt($("#start").val());
                task.total  += data.total;
                task.succeed(
                    "从" + start + "开始，成功抓取<strong>" + data.total 
                     + "</strong>位，已经抓取<b>" + task.total + "</b>位热门用户！"
                );
                $("#start").val((start + parseInt($("#limit").val())));
            }
        );
    },
    getAllFans: function() {
        var _root       = this;
        this.task.run(
            siteUrl + "index.php/spider/baidu/agetallfans",
            function() {
                return {
                    url: $("#url").val(),
                    start: $("#start").val(),
                    limit: $('#limit').val()
                };
            },
            function(data, task) {
                if(1 > data.total) {
                    task.stop();
                    HHJsLib.succeed("成功抓取热门用户完成～");
                    task.succeed("一共成功抓取约" + task.total + "位热门用户，任务完成～");
                    return;
                }
                var start   = parseInt($("#start").val());
                task.total  += data.total;
                task.succeed(
                    "从" + start + "开始，成功抓取<strong>" + data.total 
                     + "</strong>位，已经抓取<b>" + task.total + "</b>位热门用户！"
                );
                $("#start").val((start + parseInt($("#limit").val())));
            }
        );
    },
    getFans: function() {
        HHJsLib.isNumberByDom("#uid", '用户编号');
        var _root       = this;
        this.task.run(
            siteUrl + "index.php/spider/baiduuser/agetfans",
            function() {
                return {
                    url: $("#url").val(),
                    start: $("#start").val(),
                    next: $('#next').val(),
                    uid: $('#uid').val(),
                    limit: $('#limit').val(),
                    is_self: _root.getIsSelf()
                };
            },
            function(data, task) {
                if(1 > data.total) {
                    task.stop();
                    HHJsLib.succeed("抓取粉丝用户完成～");
                    task.succeed("一共成功抓取约" + task.total + "位粉丝用户，任务完成～");
                    return;
                }
                var start   = parseInt($("#start").val());
                task.total  += data.total;
                task.succeed(
                    "从" + start + "开始，成功抓取<strong>" + data.total 
                     + "</strong>位，已经抓取<b>" + task.total + "</b>位粉丝！"
                );
                $("#uid").val(data.uid);
                $("#next").val(data.next);
                $("#start").val((start + parseInt($("#limit").val())));
            }
        );
    },
    getSingleFans: function() {
        HHJsLib.isNumberByDom("#uid", '用户UK');
        var _root       = this;
        this.task.run(
            siteUrl + "index.php/spider/baiduuser/agetsinglefans",
            function() {
                return {
                    url: $("#url").val(),
                    start: $("#start").val(),
                    uid: $('#uid').val(),
                    limit: $('#limit').val()
                };
            },
            function(data, task) {
                if(1 > data.total && 0 === data.next) {
                    task.stop();
                    HHJsLib.succeed("抓取粉丝用户完成～");
                    task.succeed("一共成功抓取约" + task.total + "位粉丝用户，任务完成～");
                    return;
                }
                var start   = parseInt($("#start").val());
                task.total  += data.total;
                task.succeed(
                    "从" + start + "开始，成功抓取<strong>" + data.total 
                     + "</strong>位，已经抓取<b>" + task.total + "</b>位粉丝！"
                );
                $("#uid").val(data.uid);
                $("#next").val(data.next);
                $("#start").val((start + parseInt($("#limit").val())));
            }
        );
    },
    getFollow: function() {
        HHJsLib.isNumberByDom("#uid", '用户编号');
        var _root       = this;
        this.task.run(
            siteUrl + "index.php/spider/baiduuser/agetfollow",
            function() {
                return {
                    url: $("#url").val(),
                    start: $("#start").val(),
                    next: $('#next').val(),
                    uid: $('#uid').val(),
                    limit: $('#limit').val(),
                    is_self: _root.getIsSelf()
                };
            },
            function(data, task) {
                if(1 > data.total) {
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
                $("#uid").val(data.uid);
                $("#next").val(data.next);
                $("#start").val((start + parseInt($("#limit").val())));
            }
        );
    },
    getIsSelf: function() {
        return 1 > $("input[name=is_self]:checked").length ? 0 : 1;
    },
    getFiles: function() {
        HHJsLib.isNumberByDom("#uid", '用户编号');
        HHJsLib.isNumberByDom("#category", '分类');
        var _root       = this;
        this.task.run(
            siteUrl + "index.php/spider/baidufiles/agetfiles",
            function() {
                return {
                    url: $("#url").val(),
                    category: $("#category").val(),
                    parent_id: $("#parent_id").val(),
                    replace: $("#replace").val(),
                    start: $("#start").val(),
                    next: $('#next').val(),
                    uid: $('#uid').val(),
                    limit: $('#limit').val(),
                    is_self: _root.getIsSelf(),
                    tags: $("#tags").val(),
                    title_name: $("#title_name").val()
                };
            },
            function(data, task) {
                if('undefined' !== typeof(data.message)) {
                    task.warn(data.message);
                    task.pause();
                    return;
                }
                if(1 > data.total && 0 === data.next) {
                    task.stop();
                    HHJsLib.succeed("抓取资源完成～");
                    task.succeed("一共成功抓取约" + task.total + "个资源，任务完成～");
                    return;
                }
                var start   = parseInt($("#start").val());
                task.total  += data.total;
                task.succeed(
                    "从" + start + "开始，成功抓取<strong>" + data.total 
                     + "</strong>位，重复抓取<strong>" + data.existTotal + "</strong>位，已经抓取<b>" + task.total + "</b>个资源！"
                );
                $("#uid").val(data.uid);
                $("#next").val(data.next);
                $("#start").val((start + parseInt($("#limit").val())));
            }
        );
    },
    replaceTesting: function() {
        try {
            HHJsLib.isEmptyByDom("#replace", '替换正则');
            HHJsLib.isEmptyByDom("#testing", '测试内容');
            $.getJSON(
                queryUrl + "spider/baidufiles/areplacetest",
                {
                    replace: $("#replace").val(),
                    testing: $("#testing").val()
                },
                function(response) {
                    if(false === response.rs) {
                        return HHJsLib.wran(response.message);
                    }
                    $("#testing").val($("#testing").val() + "\r\n\r\n替换结果：\r\n" + response.data);
                    HHJsLib.succeed('替换成功，请查看结果 ;)');
                }
            );
        } catch(e) {
            return HHJsLib.warn(e);
        }
    },
    getDirFiles: function() {
        HHJsLib.isNumberByDom("#category", '分类');
        var _root       = this;
        this.task.run(
            siteUrl + "index.php/spider/baidufiles/agetdirfiles",
            function() {
                return {
                    url: $("#url").val(),
                    category: $("#category").val(),
                    parent_id: $("#parent_id").val(),
                    replace: $("#replace").val(),
                    start: $("#start").val(),
                    tags: $("#tags").val(),
                    title_name: $("#title_name").val()
                };
            },
            function(data, task) {
                if('undefined' !== typeof(data.message)) {
                    task.warn(data.message);
                    task.pause();
                    return;
                }
                if(1 > data.total && 0 === data.next) {
                    task.stop();
                    HHJsLib.succeed("抓取资源完成～");
                    task.succeed("一共成功抓取约" + task.total + "个资源，任务完成～");
                    return;
                }
                var start   = parseInt($("#start").val());
                task.total  += data.total;
                task.succeed(
                    "从" + start + "开始，成功抓取<strong>" + data.total 
                     + "</strong>位，重复抓取<strong>" + data.existTotal + "</strong>位，已经抓取<b>" + task.total + "</b>个资源！"
                );
                $("#next").val(data.next);
                $("#start").val((start + 1));
            }
        );
    },
    getAlbumFiles: function() {
        HHJsLib.isNumberByDom("#category", '分类');
        var _root       = this;
        this.task.run(
            siteUrl + "index.php/spider/baidufiles/agetalbumfiles",
            function() {
                return {
                    url: $("#url").val(),
                    category: $("#category").val(),
                    parent_id: $("#parent_id").val(),
                    replace: $("#replace").val(),
                    start: $("#start").val(),
                    tags: $("#tags").val(),
                    title_name: $("#title_name").val(),
                    album_id: $("#album_id").val(),
                    album_name: $("#album_name").val()
                };
            },
            function(data, task) {
                if('undefined' !== typeof(data.message)) {
                    task.warn(data.message);
                    task.pause();
                    return;
                }
                if(1 > data.total) {
                    task.stop();
                    HHJsLib.succeed("抓取资源完成～");
                    task.succeed("一共成功抓取约" + task.total + "个资源，任务完成～");
                    return;
                }
                var start   = parseInt($("#start").val());
                task.total  += data.total;
                task.succeed(
                    "从" + start + "开始，成功抓取<strong>" + data.total 
                     + "</strong>位，重复抓取<strong>" + data.existTotal + "</strong>位，已经抓取<b>" + task.total + "</b>个资源！"
                );
                $("#start").val(data.next);
            }
        );
    }
}); 
