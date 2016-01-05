
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
HHJsLib.register({
    init: function() {
        this.bindCheckedAllBtn();
        this.bindCancelAllBtn();
    },
    bindCancelAllBtn: function() {
        var self    = this;
        $('a.cancel-all-btn').click(function(){
            var id  = $(this).attr('data-id');
            if(0 == id) {
                self.checkedAll('input.rights-item', false);
                return;
            }
            self.checkedAll('#group-' + id + ' input.rights-item', false);
        });
    },
    bindCheckedAllBtn: function() {
        var self    = this;
        $('a.checked-all-btn').click(function(){
            var id  = $(this).attr('data-id');
            if(0 == id) {
                self.checkedAll('input.rights-item', true);
                return;
            }
            self.checkedAll('#group-' + id + ' input.rights-item', true);
        });
    },
    checkedAll: function(dom, val) {
        $(dom).each(function() {
            $(this).attr('checked', val);
        });
    }
});


