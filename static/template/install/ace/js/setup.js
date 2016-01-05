
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

HHJsLib.register({
    curStep: 1,
    space: 20, //5步
    init: function() {
        this.startCreateTableJob();
    },
    startCreateTableJob: function() {
        var self    = this;
        this.appendJobLi('初始化数据库存储表。', 'init-table');
        $.getJSON(
            queryUrl + 'setup/inittable',
            {},
            function(response) {
                if(false === response.rs) {
                    self.errorJob('init-table');
                    return HHJsLib.Modal.warn(response.message);
                }
                self.doneJob('init-table');
                self.startInitDataJob();
            }
        );
    },
    startInitDataJob: function() {
        var self    = this;
        this.appendJobLi('初始化网站数据。', 'init-data');
        $.getJSON(
            queryUrl + 'setup/initdata',
            {},
            function(response) {
                if(false === response.rs) {
                    self.errorJob('init-data');
                    return HHJsLib.Modal.warn(response.message);
                }
                self.doneJob('init-data');
                self.startInitSiteInfoJob();
            }
        );
    },
    startInitSiteInfoJob: function() {
        var self    = this;
        this.appendJobLi('初始化网站数据。', 'init-website');
        try {
            HHJsLib.isStrLenByDom('#site-name', '网站名称');
            HHJsLib.isStrLenByDom('#site-lang', '网站语言');
            $.getJSON(
                queryUrl + 'setup/initwebsite',
                {
                    name: $('#site-name').val(), 
                    lang: $('#site-lang').val(),
                    administrator: $('#name').val(),
                    email: $("#email").val()
                },
                function(response) {
                    if(false === response.rs) {
                        self.errorJob('init-website');
                        return HHJsLib.Modal.warn(response.message);
                    }
                    self.doneJob('init-website');
                    self.startInitAdminJob();
                }
            );
        } catch(e) {
            return HHJsLib.Modal.warn(e);
        }
    },
    startInitAdminJob: function() {
        var self    = this;
        this.appendJobLi('初始化管理员用户信息。', 'init-admin');
        try {
            HHJsLib.isStrLenByDom('#name', '管理员名称', 2);
            HHJsLib.isStrLenByDom('#password', '管理员密码', 6);
            HHJsLib.isEmailByDom('#email', '常用邮箱');
            $.post(
                queryUrl + 'setup/initadmin',
                {
                    name: $('#name').val(),
                    password: $('#password').val(),
                    email: $('#email').val()
                },
                function(response) {
                    if(false === response.rs) {
                        self.errorJob('init-admin');
                        return HHJsLib.Modal.warn(response.message);
                    }
                    self.doneJob('init-admin');
                    self.finished();
                },
                'json'
            );
        } catch(e) {
            return HHJsLib.Modal.warn(e);
        }
    },
    appendJobLi: function(message, slug) {
        $('#job-list').append(
            '<li>' + message + '<i id="' + slug + '-job-icon" class="icon-spinner icon-spin blue bigger-125"></i> </li>'
        );
    },
    doneJob: function(slug) {
        $('#' + slug + '-job-icon').removeClass('icon-spinner icon-spin blue bigger-125')
        .addClass('green icon-ok');
        this.curStep ++;
        var percent     = (this.curStep * this.space) + '%';
        $('#progress-bar').css("width", percent);
        $('#progress-percent').html(percent);
    },
    finished: function() {
        $("#step3").removeClass('active').addClass('complete');
        HHJsLib.succeed('安装完成，正在为您导航到成功页面...');
        setTimeout(function() {
            window.location.href    = queryUrl + 'finished';
        }, 1000);
    },
    errorJob: function(slug) {
        $('#' + slug + '-job-icon').removeClass('icon-spinner icon-spin blue bigger-125')
        .addClass('red icon-remove');
        $('#continue-btn').removeClass('hide').show();
        $('#goback-btn').removeClass('hide').show();
        $('#progress-btn').hide();
    },
    bindContinueBtn: function() {
        $('#continue-btn').click(function() {
            window.location.reload();
        });
    }
});
