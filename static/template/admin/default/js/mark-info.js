
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

HHJsLib.register({
    langMap: {
        'zh-cn': 'cn',
        'en': 'En'
    },
    process: false,
    api: 'http://fanyi.baidu.com/v2transapi?from=zh&query=%E7%94%A8%E8%BD%A6%E8%B5%84%E8%AE%AF&to=en',
    init: function() {
        this.bindAutoTranslateBtnClick();
    },
    bindAutoTranslateBtnClick: function() {
        var self    = this;
        $('#auto-translate-btn').click(function() {
            var cn  = '';
            for(var ele in langList) {
                if('zh-cn' == langList[ele].identifier) {
                    cn  = $('#lang-' + langList[ele].id).val();
                    break;
                }
            }
            for(var ele in langList) {
                if('zh-cn' == langList[ele].identifier) {
                    continue;
                }
                if('zh-tw' == langList[ele].identifier) {
                    $('#lang-' + langList[ele].id).val(s2t($('#name').val()));
                    continue;
                }
                self.doTranslateText(langList[ele], cn);
            }

            return HHJsLib.succeed('翻译完成！');
        });
    },
    doTranslateText: function(lang, content) {
        HHJsLib.info('正在自动翻译“' + lang.name + '”...');
        this.process    = true;
        var self        = this;
        $.getJSON(
            queryUrl + 'admin/mark/aautotranslate',
            {to: this.langMap[lang.identifier], content: content},
            function(response) {
                self.process    = false;
                if(false === response.rs) {
                    return HHJsLib.warn(response.message);
                }
                HHJsLib.codeEditor["lang-" + lang.id].setValue(response.data);
            }
        );
    }
});
