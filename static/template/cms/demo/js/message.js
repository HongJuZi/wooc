
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

HHJsLib.register({
    init: function() {
        this.bindMessageFormSubmit();
    },
    bindMessageFormSubmit: function() {
        $('#message-form').submit(function() {
            try {
                HHJsLib.isEmptyByDom('#name', '姓名');
                HHJsLib.isPhoneByDom('#phone');
                HHJsLib.isEmailByDom('#email');
                HHJsLib.isStrLenByDom('#content', '留言内容', 6, 255);

                return true;
            } catch(e) {
                return HHJsLib.warn(e);
            }
        });
    }
});
