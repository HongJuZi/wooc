
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
HHJsLib.register({
    init: function() {
        this.bindBtnWxList();
        this.bindBtnWxInfo();
        this.bindBtnWxGroup();
        this.bindBtnWxPos();
    },
    bindBtnWxList: function() {
        $('#btn-wx-list').click(function() {
            $.getJSON(
                queryUrl + 'admin/user/awxlist',
                {},
                function(response) {
                    if(false === response.rs) {
                        return HHJsLib.warn(response.message);
                    }

                    return HHJsLib.succeed(response.message);
                }
            );
        });
    },
    bindBtnWxInfo: function() {
        $('#btn-wx-info').click(function() {
            $.getJSON(
                queryUrl + 'admin/user/awxinfo',
                {},
                function(response) {
                    if(false === response.rs) {
                        return HHJsLib.warn(response.message);
                    }

                    return HHJsLib.succeed(response.message);
                }
            );
        });
    },
    bindBtnWxGroup: function() {
        $('#btn-wx-group').click(function() {
            $.getJSON(
                queryUrl + 'admin/user/awxgroup',
                {},
                function(response) {
                    if(false === response.rs) {
                        return HHJsLib.warn(response.message);
                    }

                    return HHJsLib.succeed(response.message);
                }
            );
        });
    },
    bindBtnWxPos: function() {
        $('#btn-wx-pos').click(function() {
            $.getJSON(
                queryUrl + 'admin/user/awxpos',
                {},
                function(response) {
                    if(false === response.rs) {
                        return HHJsLib.warn(response.message);
                    }

                    return HHJsLib.succeed(response.message);
                }
            );
        });
    }
});
