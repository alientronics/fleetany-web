window.onload=function(){
	$(".mdl-button--notifications").click(function() {
	  $(".mdl-layout__drawer-right").addClass("active");
	  $(".mdl-layout__obfuscator-right").addClass("ob-active");
	});

	$(".mdl-layout__obfuscator-right, .mdl-search__div-close").click(function() {
	  $(".mdl-layout__drawer-right").removeClass("active");
	  $(".mdl-layout__obfuscator-right").removeClass("ob-active");
	});
}