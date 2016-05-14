window.onload=function(){
	$(".mdl-button--search").click(function() {
	  $(".mdl-layout__drawer-right").addClass("active");
	  $(".mdl-layout__obfuscator-right").addClass("ob-active");
	});

	$(".mdl-layout__obfuscator-right, .mdl-search__div-close").click(function() {
	  $(".mdl-layout__drawer-right").removeClass("active");
	  $(".mdl-layout__obfuscator-right").removeClass("ob-active");
	});
	
	$(".mdl-textfield__maskmoney").keyup(function() {
		$(this).parent().addClass('is-dirty');
	});

	$(".mdl-textfield__maskmoney").focusout(function() {
		if($(this).val() == '0,00' || $(this).val() == '0.00') {
			$(this).parent().removeClass('is-dirty');
		}
	});
	
    var dialog = $('dialog')[0];
    if (dialog) {
	    if (! $('dialog')[0].showModal) {
	      dialogPolyfill.registerDialog(dialog);
	    }
	    $('.show-confirm-operation').click(function(event) {
	        event.preventDefault();
	        $('#url-confirm').val($(this).attr('href'));
	        dialog.showModal();
	    });
	    $('.confirm-operation').click(function(event) {
	    	window.location.href = $('#url-confirm').val();
	      });
	    $('.close').click(function() {
	      dialog.close();
	    });
	}
    

	function fillCountries(data) {
		var countryVal = $('#country').val();
		var stateVal = $('#state').val();
		var cityVal = $('#city').val();
		
		var countries = [];
		$.each(data.geonames, function (index, country) {
	        item = {}
	        item ["text"] = country.countryName;
	        item ["value"] = country.geonameId;
	        countries.push(item);
		});
		$('#country').immybox({
		    choices: countries
		});
		$('#state').immybox({choices: [{text: stateVal, value: stateVal}]});
		$('#city').immybox({choices: [{text: cityVal, value: 1}]});
		$('#country').val(countryVal);
		$('#state').val(stateVal);
		$('#city').val(cityVal);
		
		if($('#country').val().length) {
			$('#country').parent().addClass('is-dirty');
		}
		if($('#state').val().length) {
			$('#state').parent().addClass('is-dirty');
		}
		if($('#city').val().length) {
			$('#city').parent().addClass('is-dirty');
		}
	};

	
	if ($("#country").length) {
		
		var urlCountries = 'http://api.geonames.org/countryInfoJSON?username=' +
							$('meta[name="geonames-username"]').attr('content') +
							'&lang=' + $('meta[name="geonames-lang"]').attr('content');
		
		$.ajax({
		    url: urlCountries,
		    type: 'GET',
		    crossDomain: true,
		    dataType: 'jsonp',
		    success: fillCountries,
		    error: function() { console.log('Failed!'); }
		});
	}

	function fillStates(data){
		var states = [];
		$.each(data.geonames, function (index, state) {
			item = {}
	        item ["text"] = state.name;
	        item ["value"] = state.name;
	        states.push(item);
		});
		$('#state').immybox('setChoices', states);
	}

	$('#country').on('update', function() {
		var urlStates = "http://api.geonames.org/childrenJSON?geonameId=" + 
							$('#country').immybox('getValue') + 
							'&username=' + $('meta[name="geonames-username"]').attr('content') +
							'&lang=' + $('meta[name="geonames-lang"]').attr('content');
		$.ajax({
		    url: urlStates,
		    type: 'GET',
		    crossDomain: true,
		    dataType: 'jsonp',
		    success: fillStates,
		    error: function() { console.log('Failed!'); }
		});
	});

	function fillCities(data){
		var cities = [];
		var cityVal = $('#city').val();
		$.each(data.geonames, function (index, city) {
			item = {}
	        item ["text"] = city.toponymName;
	        item ["value"] = city.geonameId;
	        cities.push(item);
		});
		$('#city').immybox('setChoices', cities);
		$('#city').val(cityVal);
		if($('#city').val().length) {
			$('#city').parent().addClass('is-dirty');
		}
	}
	
	$('#state').on('update', function(){
		$('#city').val('');
	});
	
	var firstSearch = true;
	$('#city').keydown(function() {
		if(($('#city').val().length != 1) && !firstSearch) {
			return;
		}

		firstSearch = false;
		
    	var urlCities = "http://api.geonames.org/searchJSON?q="+encodeURIComponent($('#state').immybox('getValue'))+
                    		"&name_startsWith="+encodeURIComponent($('#city').val())+
                    		'&fcode=ADM2'+
                    		'&username=' + $('meta[name="geonames-username"]').attr('content') +
        					'&lang=' + $('meta[name="geonames-lang"]').attr('content');

    	$.ajax({
		    url: urlCities,
		    type: 'GET',
		    crossDomain: true,
		    dataType: 'jsonp',
		    success: fillCities,
		    error: function() { console.log('Failed!'); }
		});
	});
	
	$('#city').on('update', function() {
		if($('#city').val().length) {
			$('#city').parent().addClass('is-dirty');
		}
	});	
}

function showSnackBar(message) {
	(function() {
	  'use strict';
	  var snackbarContainer = $('#snackbar')[0];
	  var handler = function(event) {
	  };
	  $(window).load(function() {
	    'use strict';
	    message = $('<textarea />').html(message).text();
	    try {
    		var jsonMessage = $.parseJSON(message);
    	    if(typeof jsonMessage == 'object')
    	    {
    	    	message = '';
    	    	$.each( jsonMessage, function( key, value ) {
    	    		message += value + ' ';
	    		});
    	    }
    	}
    	catch (err) {
    	}
	    var data = {
	      message: message,
	      timeout: 5000,
//		       actionHandler: handler,
	      actionText: 'Undo'
	    };
	    snackbarContainer.MaterialSnackbar.showSnackbar(data);
	  });
	}());
}


function getApplicationUrl() {
	return $('meta[name="base-url"]').attr('content');
}

function url(url) {
	return getApplicationUrl() + '/' + url;
}