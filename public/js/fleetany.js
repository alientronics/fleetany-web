window.onload=function(){
	$(".mdl-button--search").click(function() {
	  $(".mdl-layout__drawer-right").addClass("active");
	  $(".mdl-layout__obfuscator-right").addClass("ob-active");
	});

	$(".mdl-layout__obfuscator-right, .mdl-search__div-close").click(function() {
	  $(".mdl-layout__drawer-right").removeClass("active");
	  $(".mdl-layout__obfuscator-right").removeClass("ob-active");
	});
}

function showSnackBar(message) {
	(function() {
	  'use strict';
	  var snackbarContainer = document.querySelector('#demo-snackbar-example');
	  var showSnackbarButton = document.querySelector('#demo-show-snackbar');
	  var handler = function(event) {
	  };
	  window.addEventListener("load", function() {
	    'use strict';
	    var data = {
	      message: message,
	      timeout: 2000,
//		       actionHandler: handler,
	      actionText: 'Undo'
	    };
	    snackbarContainer.MaterialSnackbar.showSnackbar(data);
	  });
	}());
}