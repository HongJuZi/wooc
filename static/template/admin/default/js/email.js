
/**
 * @version $Id$
 * @create 2013-8-5 8:40:51 By xjiujiu
 * @description HongJuZi Framework
 * @copyRight Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
 HHJsLib.register({
     init: function() {
        this.bindFileInput();
        this.bindInfoFormSubmit();
        HHJsLib.bindEditor("content", siteUrl + "vendor/editor/ueditor", 'ueditor');
     },
     bindInfoFormSubmit: function() {
         $("#info-form").submit(function() {
             try {
                 HHJsLib.isEmptyByDom('#subject', '标题');
                 HHJsLib.isEmailByDom('#to', '收件人');
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
            //whitelist:'gif|png|jpg|jpeg'
            //blacklist:'exe|php'
        });
    },
 });
