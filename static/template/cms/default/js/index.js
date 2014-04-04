
/**
 * @version $Id$
 * @author xjiujiu <xjiujiu@foxmail.com>
 * @description HongJuZi Framework
 * @copyright Copyright (c) 2011-2012 http://www.xjiujiu.com.All right reserved
 */

//��ҳ��js
HHJsLib.register({
    init: function() {
        this.bindBanner();
        this.bindCasesList();
        $.focus("#teacher-list");
    },
    bindCasesList: function() {
        var MarqueeDiv2Control=new Marquee("marquee-cases-list"); 
        MarqueeDiv2Control.Direction="left";
        MarqueeDiv2Control.Step=1;
        MarqueeDiv2Control.Width=600;
        MarqueeDiv2Control.Height=370;
        MarqueeDiv2Control.Timer=20;
        MarqueeDiv2Control.ScrollStep=1;
        MarqueeDiv2Control.Start();
    },
    bindBanner: function() {
        $('#slider').nivoSlider({
            pauseTime: 3000,
            animSpeed: 500, 
            controlNav: false,
            directionNavHide: true,
            prevText: "‹",
            nextText: "›"
        });
    }
});
