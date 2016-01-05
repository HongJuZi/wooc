
/**
 * @version $Id$
 * @create 2013/10/3 18:48:19 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

HHJsLib.register({
    init: function () {
         this.bindUserNameVerify(); 
    },
    bindUserNameVerify: function () {
        jQuery('#user_name_id').blur(function() {
            var userName    = jQuery(this).val();
            if(userName == "") {
                return;
            }
            jQuery.post(
                siteUrl + '/index.php/admin/user/isunused',
                {user_name: userName},
                function(data) {
                    if(typeof data.error != 'undefined') {
                        alert(data.error);
                    }
                },
                "json"
            );
        });
    }
});
