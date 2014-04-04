
/**
 * @version $Id$
 * @create 2013-8-12 10:21:28 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

 (function($) {
    var HHLangMask  = {
        init: function () {
            //$("select#tpl").chosen({allow_single_deselect:true}); 
            $("#zh-cn").bind('keydown change', function() {
                $("#zh-tw").val(HHJsLib.toTw($(this).val()));
            });
            $("#zh-tw").bind('keydown change', function() {
                $("#zh-cn").val(HHJsLib.toCn($(this).val()));
            });
        }
    };
    //注册初始化事件
    HHJsLib.register(HHLangMask, HHLangMask.init, 'init');
 })(jQuery);
