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
	
	function showSnackBarWindowLoaded(message) {
		(function() {
		  'use strict';
		  var snackbarContainer = $('#snackbar')[0];
		    var data = {
		      message: message,
		      timeout: 5000
		    };
		    $('#snackbar')[0].MaterialSnackbar.showSnackbar(data);
		}());
	}

	var tirePositionDetail = [];
	var tirePositionFilled = '<i class="material-icons">gps_fixed</i>';
	var tirePositionEmpty = '<i class="material-icons">gps_not_fixed</i>';
	var tireStorageDetail = [];
	if($("#tires_fillable").length > 0) {
		var tireFillable = JSON.parse($("#tires_fillable").val());
	}
	
	$(".tire-position-fillable").click(function(event){
	    event.preventDefault();
	    if($(this).html().indexOf('gps_off') > 0) {
			tireFillable[$(this).attr('id').replace('pos', '')] = 0;
			$('#tires_fillable').val(JSON.stringify(tireFillable)); 
	    	$(this).html(tirePositionEmpty);
		} else {
			tireFillable[$(this).attr('id').replace('pos', '')] = 1;
			$('#tires_fillable').val(JSON.stringify(tireFillable)); 
	    	$(this).html('<i class="material-icons">gps_off</i>');
		}
	});
	
	$(".tires-empty, .tires-filled").click(function() {
		
		$("#tire-position-focus-id").val($(this).attr('id'));
		
		if($("#tire-position-swap-flag").val() == 1) {
			var data = {
		        "position1"	: $('.tires-selected-focus').attr('id').replace('pos', ''),
		        "position2"	: $(this).attr('id').replace('pos', ''),
		        "vehicle_id" : $('#vehicle-id').val()
		    };

			var selectedTire = this;
		    $.post(url('tires/position/swap'), data, function(retorno) {
				if($(selectedTire).hasClass("tires-empty")) {
					$(".tires-selected-focus").addClass("tires-empty");
			    	$(".tires-selected-focus").html(tirePositionEmpty);
					$(".tires-selected-focus").removeClass("tires-filled");
					$(".tires-selected-focus").removeClass("tires-selected-focus");
					$(selectedTire).addClass("tires-filled");
			    	$(selectedTire).html(tirePositionFilled);
					$(selectedTire).removeClass("tires-empty");
				} else {
					$(".tires-selected-focus").removeClass("tires-selected-focus");
					$(selectedTire).addClass("tires-selected-focus");
				}
				$(selectedTire).addClass("tires-selected-focus");
				$("#tire-position-swap-flag").val(0); 
				var tirePositionDetailTemp = tirePositionDetail[data.position1];
				tirePositionDetail[data.position1] = tirePositionDetail[data.position2];
				tirePositionDetail[data.position2] = tirePositionDetailTemp;
				setTireSelectedFocusData();
		    });
		} else {
			if($('.tires-selected').length > 0) {
				$(".tires-selected").removeClass("tires-selected");
			}
			if($('.tires-selected-focus').length > 0) {
				$(".tires-selected-focus").addClass("tires-selected");
				$(".tires-selected-focus").removeClass("tires-selected-focus");
			}
			$(this).addClass("tires-selected-focus");
			
			setTireSelectedFocusData();
		}
	});

	$("#tire-position-swap").click(function(event){
	    event.preventDefault();
	    $("#tire-position-swap-flag").val(1);
	});
	
	$("#tire-position-remove").click(function(event){
	    event.preventDefault();
	    
	    var data = {
	        "position"	: $('.tires-selected-focus').attr('id').replace('pos', ''),
	        "vehicle_id" : $('#vehicle-id').val()
	    };

	    $.post(url('tires/position/remove'), data, function(retorno) {
	    	$(".tires-selected-focus").addClass("tires-empty");
	    	$(".tires-selected-focus").removeClass("tires-filled");
	    	$(".tires-selected-focus").html(tirePositionEmpty);
	    	$("#tire-storage-data").load(url('tires/updateStorage/'+data.vehicle_id),function(data){
	    	    if(data.search('<td>') >= 0) {
	    	    	$("#tire-position-add").show();
	    	    } else {
	    	    	$("#tire-position-add").hide();
	    	    }
	    	});
	    			
	    	setTireSelectedFocusData();
	    });
	    
	});
	
	if($(".mdl-dialog").length > 0) {
		var dialog = document.querySelector('dialog');
		var dialogAddButton = "";
		var showDialogButton = document.querySelector('#show-dialog');
		if (! dialog.showModal) {
			dialogPolyfill.registerDialog(dialog);
		}
		
		if($(".create-tire").length > 0) {
			dialog.querySelector('.create-tire').addEventListener('click', function() {
				var dataTire = {
				    "part_type_id" : $('#part-type-id').val(),
			        "part_model_id" : $('#part_model_id').val(),
			        "number" : $('#part_number').val(),
			        "miliage" : $('#part_miliage').val(),
			        "lifecycle" : $('#part_lifecycle').val(),
			        "vehicle_id" : $('#vehicle-id').val()
			    };
		
			    $.post(url('parts/create'), dataTire, function(retorno) {
			    	$("#tire-storage-data").load(url('tires/updateStorage/'+dataTire.vehicle_id),function(data){
			    	    if(data.search('<td>') >= 0) {
			    	    	$("#tire-position-add").show();
			    	    } else {
			    	    	$("#tire-position-add").hide();
			    	    }
			    	});
			        $('#part_model_id').val($("#part_model_id option:first").val());
			        $('#part_number').val('');
			        $('#part_miliage').val('');
			        $('#part_lifecycle').val('');
			    	dialog.close();
			    });
			});
		}
		
		if($(".create-model").length > 0) {
			dialog.querySelector('.create-model').addEventListener('click', function() {
				var dataModel = {
				    "model_type_id" : $('#modeldialog_model_type_id').val(),
			        "vendor_id" : $('#modeldialog_vendor_id').val(),
			        "name" : $('#modeldialog_name').val()
			    };
		
				$.post(url('models/create'), dataModel, function(retorno) {
			    	if(retorno.id != undefined) {
			    		dialogAddButton.prev().append($('<option>', {
		    				value: retorno.id,
		    				text: $('#modeldialog_name').val()
		    			}));
			    		
			    		dialogAddButton.prev().val(retorno.id);
			    	}

			    	$('#modeldialog_model_type_id').val($("#modeldialog_model_type_id option:first").val());
			    	$('#modeldialog_vendor_id').val($("#modeldialog_vendor_id option:first").val());
			        $('#modeldialog_name').val('');
			    	dialog.close();
			    });
			});
		}
		
		if($(".create-type").length > 0) {
			dialog.querySelector('.create-type').addEventListener('click', function() {
				var dataType = {
				    "name" : $('#typedialog_name').val(),
			        "entity_key" : $('#typedialog_entity_key').val()
			    };
		
			    $.post(url('types/create'), dataType, function(retorno) {
			    	if(retorno.id != undefined) {
			    		dialogAddButton.prev().append($('<option>', {
		    				value: retorno.id,
		    				text: $('#typedialog_name').val()
		    			}));
			    		
			    		dialogAddButton.prev().val(retorno.id);
			    	}
			    	$('#typedialog_name').val('');
			        $('#typedialog_entity_key').val('');	
			    	dialog.close();
			    });
			});
		}

		if($(".close").length > 0) {
			dialog.querySelector('.close').addEventListener('click', function() {
				dialog.close();
			});
		}
	}
	
	$("#tire-add, #type-add, #model-add").click(function(event){
		event.preventDefault();
		dialogAddButton = $(this);
	    dialog.showModal();
	});

	$("#tire-position-add").click(function(event){
	    event.preventDefault();

	    if($("input[name=tire-storage-id]:checked").val() == undefined) {
	    	showSnackBarWindowLoaded(jstrans_selectTire);
	    	return;
	    } else if($('.tires-selected-focus').length == 0) {
	    	showSnackBarWindowLoaded(jstrans_selectPosition);
	    	return;
	    }
	    
	    var data = {
	        "part_id"	: $("input[name=tire-storage-id]:checked").val(),
	        "position"	: $('.tires-selected-focus').attr('id').replace('pos', ''),
	        "vehicle_id" : $('#vehicle-id').val()
	    };

	    $.post(url('tires/position/add'), data, function(retorno) {
	    	$(".tires-selected-focus").addClass("tires-filled");
	    	$(".tires-selected-focus").removeClass("tires-empty");
	    	$(".tires-selected-focus").html(tirePositionFilled);
	    	$("#tire-storage-data").load(url('tires/updateStorage/'+data.vehicle_id),function(data){
	    	    if(data.search('<td>') >= 0) {
	    	    	$("#tire-position-add").show();
	    	    } else {
	    	    	$("#tire-position-add").hide();
	    	    }
	    	});
	    	tirePositionDetail[data.position] = tireStorageDetail[data.part_id];
	    	setTireSelectedFocusData();
	    });
	    
	});
	
	function setTireSelectedFocusData() {

		if($("#"+$("#tire-position-focus-id").val()).hasClass("tires-filled")) {
			
			var data = {
		        "position"	: $('.tires-selected-focus').attr('id').replace('pos', ''),
		        "vehicle_id" : $('#vehicle-id').val()
		    };
	
			var positionData = jstrans_position+': '+data.position+'<br>';
			if(tirePositionDetail[data.position] == undefined || tirePositionDetail[data.position] == '') {
				$.post(url('tires/details'), data, function(retorno) {
					
					var positionDetailData = jstrans_number+': '+retorno[0].number+'<br>';
					positionDetailData += jstrans_model+': '+retorno[0].tire_model+'<br>';
					positionDetailData += jstrans_lifecycle+': '+retorno[0].lifecycle+'<br>';
					positionDetailData += jstrans_mileage+': '+retorno[0].miliage+'<br>';
					
					$('#tire-position-detail-data').html(positionData + positionDetailData);
					
					tirePositionDetail[data.position] = positionDetailData;
				});
			} else {
				$('#tire-position-detail-data').html(positionData + tirePositionDetail[data.position]);
			}
			
			if($(".tires-selected-focus.tires-empty").length > 0) {
				$(".tire-position-detail-button").hide();
			} else {
				$(".tire-position-detail-button").show();
			}
		} else {
			tirePositionDetail[$('.tires-selected-focus').attr('id').replace('pos', '')] = undefined;
			$(".tire-position-detail-button").hide();
			$('#tire-position-detail-data').html("");
		}
	}
	
	$("input[name=tire-storage-id]").change(function(){
		
		var data = {
	        "part_id"	: $('input[name=tire-storage-id]:checked').val(),
	        "vehicle_id" : $('#vehicle-id').val()
	    };

		if(tirePositionDetail[data.position] == undefined || tirePositionDetail[data.position] == '') {
			$.post(url('tires/details'), data, function(retorno) {
		    	
		    	var storageDetailData = jstrans_number+': '+retorno[0].number+'<br>';
		    	storageDetailData += jstrans_model+': '+retorno[0].tire_model+'<br>';
		    	storageDetailData += jstrans_lifecycle+': '+retorno[0].lifecycle+'<br>';
		    	storageDetailData += jstrans_mileage+': '+retorno[0].miliage+'<br>';
		    	
		    	$('#tire-storage-detail-data').html(storageDetailData);
		    	$("#tire-position-add").show();
		    	tireStorageDetail[data.part_id] = storageDetailData;
		    	
			});
		} else {
			$('#tire-storage-detail-data').html(tireStorageDetail[data.part_id]);
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