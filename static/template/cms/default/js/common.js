
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */
HHJsLib.register({
    init: function() {
        $("#nav-strip > ul > li").each(function() {
            if(1 > $(this).find('div.subnav').length) {
                return true;
            }
            $(this).removeClass('no-subnav');
        });
        HHJsLib.dropMenu('#nav-strip > ul > li', 'div.subnav', 'active');
        this.highLightElement();
        this.bindSideCases();
    },
    highLightElement: function() {
        var href    = window.location.href;
        var loc     = href.indexOf('?');
        if(0 > loc) {
            HHJsLib.highLightElement('#nav-strip > ul > li', 'current', 0);
            return ;
        }
	    HHJsLib.highLightElementByUrl(href.substring(0, loc), '#nav-strip > ul > li', 'current', 0);
    },
    bindSideCases: function() {
        $("#cases-list").KinSlideshow({
            moveStyle:"left",       //设置切换方向为向下 [默认向左切换]
            intervalTime: 5,         //设置间隔时间为8秒  [默认为5秒]
            mouseEvent:"mouseover",      //设置鼠标事件为“鼠标滑过切换”  [默认鼠标点击时切换]
            titleFont:{TitleFont_size:14,TitleFont_color:"#FF0000"} //设置标题文字大小为14px，颜色：#FF0000
        });
    }
});
