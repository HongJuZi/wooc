
/**
 * @version $Id$
 * @create 2012-9-26 10:34:25 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
(function($) {
    /**
     * 自动生成模块页面对应的JS工具类 
     * 
     * @desc
     * 
     * @author xjiujiu <xjiujiu@foxmail.com>
     * @package js 
     * @since 1.0.0
     */
    var HModelManagerInfo    = {
        init: function () {
            this.bindSpanChoise();
        },
        bindSpanChoise: function() {
            $("div.span-item span").each(function() {
                $(this).click(function(e) {
                    if($(e.target).attr('type') == 'checkbox') {
                        return true;;
                    }
                    var $field   = jQuery(this).find("input");
                    if($field.attr('checked') == 'checked') {
                        $field.attr('checked', false);
                    } else {
                        $field.attr('checked', true);
                    }
                });
            });
        }
    };
    //注册初始化方法
    HHJsLib.register(HModelManagerInfo, HModelManagerInfo.init, 'init');
})(jQuery);
