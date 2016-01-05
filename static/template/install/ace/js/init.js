
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

HHJsLib.register({
    init: function() {
        this.bindInitFormSubmit();
    },
    bindInitFormSubmit: function() {
        var self    = this;
        $('#submit-btn').click(function() {
            try {
                HHJsLib.isEmptyByDom('#db-driver', '数据库驱动器');
                HHJsLib.isEmptyByDom('#db-host', '数据库地址');
                HHJsLib.isEmptyByDom('#db-port', '数据库端口');
                HHJsLib.isEmptyByDom('#db-user', '数据库用户');
                HHJsLib.isEmptyByDom('#db-password', '数据库密码');
                HHJsLib.isEmptyByDom('#db-name', '数据库名称');
                HHJsLib.isEmptyByDom('#table-prefix', '数据库表前缀');
                HHJsLib.isStrLenByDom('#site-name', '网站名称');
                HHJsLib.isStrLenByDom('#site-lang', '网站语言');
                HHJsLib.isStrLenByDom('#name', '管理员名称', 2);
                HHJsLib.isStrLenByDom('#password', '管理员密码', 6);
                HHJsLib.isEmailByDom('#email', '常用邮箱');
                self.testDb();
            } catch(e) {
                return HHJsLib.warn(e);
            }
        });
    },
    testDb: function() {
        HHJsLib.info('正在测试您的数据库信息是否正确，请稍等...');
        try {
            $.post(
                queryUrl + "init/testdb",
                {
                    db_driver: $('#db-driver').val(),
                    db_host: $('#db-host').val(),
                    db_port: $('#db-port').val(),
                    db_name: $('#db-name').val(),
                    db_user: $('#db-user').val(),
                    db_password: $('#db-password').val()
                },
                function(response) {
                    if(false === response.rs) {
                        return HHJsLib.Modal.warn(response.message);
                    }
                    HHJsLib.succeed('数据库测试成功，正在为您导航到安装页面。');
                    setTimeout(function() {
                        $('#init-form').submit();
                    }, 500);
                },
                'json'
            );
        } catch(e) {
            return HHJsLib.warn(e);
        }
    }
});
