var MarqueeDiv2Control=new Marquee("MarqueeDiv2");		
	MarqueeDiv2Control.Direction="right";
	MarqueeDiv2Control.Step=1;
	MarqueeDiv2Control.Width=937;
	MarqueeDiv2Control.Height=183;
	MarqueeDiv2Control.Timer=20;
	MarqueeDiv2Control.ScrollStep=1;				
	MarqueeDiv2Control.Start();
	MarqueeDiv2Control.BakStep=MarqueeDiv2Control.Step;
	$("LeftButton2").onmouseover=function(){MarqueeDiv2Control.Direction=2};
	$("LeftButton2").onmouseout=$("LeftButton2").onmouseup=function(){MarqueeDiv2Control.Step=MarqueeDiv2Control.BakStep};
	$("LeftButton2").onmousedown=$("RightButton2").onmousedown=function(){MarqueeDiv2Control.Step=MarqueeDiv2Control.BakStep+3};
	$("RightButton2").onmouseover=function(){MarqueeDiv2Control.Direction=3};
	$("RightButton2").onmouseout=$("RightButton2").onmouseup=function(){MarqueeDiv2Control.Step=MarqueeDiv2Control.BakStep};
	
