
/**
 * @version $Id$
 * @create 2013-8-5 8:40:51 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

 (function($) {
     var HDbtools     = {
         init: function() {
            this.bindFileInput();
            this.bindBackupFormSubmit();
            //this.bindRecoveryFormSubmit();
         },
         bindRecoveryFormSubmit: function() {
             $("#recovery-form").submit(function() {
                 try {
                     HHJsLib.isEmptyByDom('#recover-file', '恢复文件');
                     return true;
                 } catch(e) {
                     HHJsLib.wran(e);
                     return false;
                 }
             });
         },
         bindBackupFormSubmit: function() {
             $("#backup-form").submit(function() {
                 try {
                     HHJsLib.isEmptyByDom('#backup-file-name', '备份文件名');
                     return true;
                 } catch(e) {
                     HHJsLib.wran(e);
                     return false;
                 }
             });
         },
         bindFileInput: function() {
            $('input.file-path').ace_file_input({
                no_file:'没有文件 ...',
                btn_choose:'选择',
                btn_change:'修改',
                droppable:false,
                onchange:null,
                thumbnail:false, //| true | large
                whitelist:'sql'
				//blacklist:'exe|php'
			});
        },
     };
     //注册初始化事件
     HHJsLib.register(HDbtools, HDbtools.init, 'init');
 })(jQuery);
