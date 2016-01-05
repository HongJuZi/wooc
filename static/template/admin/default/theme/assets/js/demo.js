var theme_list_open = false;
$(document).ready(function () { 
	function fixHeight() {
		var headerHeight = $("#switcher").height();
		$("#iframe").attr("height", $(window).height() - 74 + "px");

	}
	$(window).resize(function () {
		fixHeight();
	}).resize();
	$(".icon-mobile-3").click(function () {
		$("#by").css("overflow-y", "auto");
		$('#iframe-wrap').removeClass().addClass('mobile-width-3');
		$('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
		$(this).addClass('active');
		return false;
	});

	$(".icon-mobile-2").click(function () {
		$("#by").css("overflow-y", "auto");
		$('#iframe-wrap').removeClass().addClass('mobile-width-2');
		$('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
		$(this).addClass('active');
		return false;
	});

	$(".icon-mobile-1").click(function () {
		$("#by").css("overflow-y", "auto");
		$('#iframe-wrap').removeClass().addClass('mobile-width');
		$('.icon-tablet,.icon-mobile,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
		$(this).addClass('active');
		return false;
	});

	$(".icon-tablet").click(function () {
		$("#by").css("overflow-y", "auto");
		$('#iframe-wrap').removeClass().addClass('tablet-width');
		$('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
		$(this).addClass('active');
		return false;
	});

	$(".icon-monitor").click(function () {
		$("#by").css("overflow-y", "hidden");
		$('#iframe-wrap').removeClass().addClass('full-width');
		$('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
		$(this).addClass('active');
		return false;
	});
});  

function Responsive($a) {
  if ($a == true) $("#Device").css("opacity", "100");
  if ($a == false) $("#Device").css("opacity", "0");
  $('#iframe-wrap').removeClass().addClass('full-width');
  $('.icon-tablet,.icon-mobile-1,.icon-monitor,.icon-mobile-2,.icon-mobile-3').removeClass('active');
  $(this).addClass('active');
  return false;
}; 