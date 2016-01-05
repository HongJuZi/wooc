
/**
 * @version $Id$
 * @create Sat 03 Aug 2013 16:47:50 CST By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
//注册登陆页面脚本
HHJsLib.register({
    init: function() {
        this.bindShowForgotBox();
        this.bindShowLoginBox();
        this.bindLoginBtn();
        this.bindSendBtn();
        this.bindVCodeChange();
    },
    bindVCodeChange: function() {
        var vcodeUrl    = $("#vcode-img").attr('src');
        $("#vcode-img").click(function() {
            $(this).attr('src', vcodeUrl + '?t=' + (new Date().getTime()));
        });
    },
    bindSendBtn: function() {
        $("#forgot-btn").click(function() {
            try {
                HHJsLib.isEmailByDom('#email');
                HHJsLib.info('正在发送找回密码的邮件中，请您稍等...');
                var email   = $("#email").val();
                $.getJSON(
                    queryUrl + "/oauth/auser/afindpwd",
                    {email: email},
                    function(response) {
                        if(false === response.rs) {
                            return HHJsLib.notice(response.message);
                        }
                        var emailLink   = '<a href="http://www.' 
                            + email.substring(email.lastIndexOf('@') + 1) + '" target="_blank"><strong>' 
                            + email + '</strong></a>';
                        HHJsLib.succeed(
                            '邮件已经发送成功，请快快去' + emailLink + '查收吧！'
                        );
                    }
                );
                return false;
            } catch(e) {
                return HHJsLib.notice(e);
            }
        });
    },
    bindLoginBtn: function() {
        $("#login-btn").unbind("click").click(function() {
            try {
                HHJsLib.isEmailByDom('#in-email');
                HHJsLib.isEmptyByDom('#password', '密码');
                HHJsLib.isEmptyByDom('#vcode', '验证码');
                HHJsLib.info('正在验证您的登陆信息中，请您稍等...');
                $.post(
                    siteUrl + "index.php/oauth/auser/alogin",
                    {email: $("#in-email").val(), password: $("#password").val(), vcode: $("#vcode").val()},
                    function(response) {
                        if(false === response.rs) {
                            $("#vcode-img").click();
                            return HHJsLib.notice(response.message);
                        }
                        HHJsLib.succeed('登陆成功，正在跳转中...');
                        setTimeout(function() {
                            window.location.href    = siteUrl + "index.php/admin";
                        }, 2000);
                    },
                    "json"
                );
                return false;
            } catch(e) {
                return HHJsLib.notice(e);
            }
        });
    },
    bindShowForgotBox: function() {
        var _root   = this;
        $("#forgot-box-btn").click(function() {
            _root.showBox('forgot-box');
            return false;
        });
    },
    bindShowLoginBox: function() {
        var _root   = this;
        $("#login-box-btn").click(function() {
            _root.showBox('login-box');
            return false;
        });
    },
    showBox: function(id) {
        $('.widget-box.visible').removeClass('visible');
        $('#'+id).addClass('visible');
    }
});
