
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
HHJsLib.register({
    init: function() {
        this.bindBtnWxAdd();
        this.bindBtnWxDel();
        this.bindBtnWxQuery();
        this.bindBtnWxCfg();
    },
    bindBtnWxDel: function() {
        $('#btn-wx-del').click(function() {
            $.getJSON(
                queryUrl + 'admin/wxmenu/awxdel',
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
    bindBtnWxQuery: function() {
        $('#btn-wx-query').click(function() {
            $.getJSON(
                queryUrl + 'admin/wxmenu/awxquery',
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
    bindBtnWxCfg: function() {
        $('#btn-wx-cfg').click(function() {
            $.getJSON(
                queryUrl + 'admin/wxmenu/awxcfg',
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
    bindBtnWxAdd: function() {
        $('#btn-wx-add').click(function() {
            $.getJSON(
                queryUrl + 'admin/wxmenu/awxadd',
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
