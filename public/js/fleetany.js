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
	var tireStorageDetail = [];
	if($("#tires_fillable").length > 0) {
		var tireFillable = JSON.parse($("#tires_fillable").val());
	}
	
	$(".tire-position-fillable").click(function(event){
	    event.preventDefault();
	    if($(this).hasClass("mdl-color--green")) {
			tireFillable[$(this).attr('id').replace('pos', '')] = 0;
			$('#tires_fillable').val(JSON.stringify(tireFillable)); 
			$(this).addClass("mdl-color--grey");
	    	$(this).removeClass("mdl-color--green");
	    	$(this).removeClass("mdl-color--yellow");
	    	$(this).removeClass("mdl-color--red");
		} else {
			tireFillable[$(this).attr('id').replace('pos', '')] = 1;
			$('#tires_fillable').val(JSON.stringify(tireFillable)); 
			$(this).addClass("mdl-color--green");
			$(this).removeClass("mdl-color--grey");
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
					$(".tires-selected-focus").addClass("mdl-color--grey");
					$(".tires-selected-focus").removeClass("mdl-color--green");
					$(".tires-selected-focus").removeClass("tires-filled");
					$(".tires-selected-focus").removeClass("tires-selected-focus");
					$(selectedTire).addClass("tires-filled");
					$(selectedTire).addClass("mdl-color--green");
					$(selectedTire).removeClass("mdl-color--grey");
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
		
		if($(this).hasClass("tires-empty")) {
			$("#tire-position-add").show();
		} else {
			$("#tire-position-add").hide();
		}
	});

	$(".tires-show").click(function() {
		
		$("#tire-position-focus-id").val($(this).attr('id'));
		
		if($('.tires-selected').length > 0) {
			$(".tires-selected").removeClass("tires-selected");
		}
		if($('.tires-selected-focus').length > 0) {
			$(".tires-selected-focus").addClass("tires-selected");
			$(".tires-selected-focus").removeClass("tires-selected-focus");
		}
		$(this).addClass("tires-selected-focus");
		
		setInterval(function () {
	        setTireAndSensorSelectedFocusData();
	    },180000);
		
		setTireAndSensorSelectedFocusData();
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
	    	$(".tires-selected-focus").addClass("mdl-color--grey");
	    	$(".tires-selected-focus").removeClass("mdl-color--green");
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

	if($("#fleet-dashboard").length > 0 || $("#vehicle-dashboard").length > 0) {
		setInterval(function () {

			var urlAddress = url('vehicle/fleet/dashboard/' + $("#updateDatetime").val());
			
			if($("#vehicle-dashboard").length > 0) {
				urlAddress += '/' + $("#vehicle-id").val();
			}
			
			$.ajax({
			    url: urlAddress,
			    type: 'GET',
			    success: function(results) {

			    	$("#updateDatetime").val(results.updateDatetime);
			    	
			    	$.each(results.tires, function (vehicle_id, tires) {
						$.each(tires, function (position, tire) {
							$("#pos"+position+"_"+vehicle_id+", #pos"+position).removeClass("mdl-color--green");
							$("#pos"+position+"_"+vehicle_id+", #pos"+position).removeClass("mdl-color--yellow");
							$("#pos"+position+"_"+vehicle_id+", #pos"+position).removeClass("mdl-color--red");
							$("#pos"+position+"_"+vehicle_id+", #pos"+position).addClass("mdl-color--" + tire.color);
							$("#tireData"+position+"_"+vehicle_id).show();
							$("#tireData"+position+"_"+vehicle_id).html(
								jstrans_pressure + ": " + tire.pressure + 
								' - ' + jstrans_temperature + ": " + tire.temperature
							)
						});
						
						if(tires.isTireSensorOldData) {
					    	$("#vehicleMap"+vehicle_id).addClass("mdl-color--grey-400");
					    	$("#vehicleMap"+vehicle_id).removeClass("mdl-color--white");
					    	$("#lastDatetimeDataMessage"+vehicle_id).css({ color: "#F00" });
						} else {
					    	$("#vehicleMap"+vehicle_id).addClass("mdl-color--white");
					    	$("#vehicleMap"+vehicle_id).removeClass("mdl-color--grey-400");
					    	$("#lastDatetimeDataMessage"+vehicle_id).css({ color: "" });
						}
						
						$("#lastDatetimeDataMessage"+vehicle_id).html(jstrans_lastData+': '+tires.lastDatetimeData);
					});
			    	
			    	$.each(results.gps, function (vehicle_id, gps) {
						$("#gpsData"+vehicle_id).show();
						$("#gpsData"+vehicle_id).html(
							jstrans_latitude + ": " + gps.latitude + 
							' - ' + jstrans_longitude + ": " + gps.longitude
						)
					});
			    },
			    error: function() { console.log('Failed!'); }
			});
	    },30000);
	}

	if($("#vehicle-detail-data").length > 0) {
		setInterval(function () {
	        setVehicleAndLocalizationSelectedFocusData();
	    },60000);
	}
	
	if($(".mdl-dialog").length > 0) {
		
		$(document).keypress(function(e) {
			if(e.which == 13) {
				e.preventDefault();
				if($(".create-model").is(":visible")) {
					$(".create-model").trigger("click");
				} else if($(".create-tire").is(":visible")) {
					$(".create-tire").trigger("click");
				} else if($(".create-type").is(":visible")) {
					$(".create-type").trigger("click");
				} 
			}
		});

		if($("#modelcreate-dialog").length > 0) {
			var dialogModelCreate = document.querySelector('#modelcreate-dialog');
			var dialogModelCreateAddButton = "";
			if (! dialogModelCreate.showModal) {
				dialogPolyfill.registerDialog(dialogModelCreate);
			}
		}

		if($("#tirecreate-dialog").length > 0) {
			var dialogTireCreate = document.querySelector('#tirecreate-dialog');
			var dialogTireCreateAddButton = "";
			if (! dialogTireCreate.showModal) {
				dialogPolyfill.registerDialog(dialogTireCreate);
			}
		}

		if($("#typecreate-dialog").length > 0) {
			var dialogTypeCreate = document.querySelector('#typecreate-dialog');
			var dialogTypeCreateAddButton = "";
			if (! dialogTypeCreate.showModal) {
				dialogPolyfill.registerDialog(dialogTypeCreate);
			}
		}

		if($(".create-tire").length > 0) {
			dialogTireCreate.querySelector('.create-tire').addEventListener('click', function() {
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
			        dialogTireCreate.close();
			    });
			});
		}
		
		if($(".create-model").length > 0) {
			dialogModelCreate.querySelector('.create-model').addEventListener('click', function() {
				var dataModel = {
				    "model_type_id" : $('#modeldialog_model_type_id').val(),
			        "vendor_id" : $('#modeldialog_vendor_id').val(),
			        "name" : $('#modeldialog_name').val()
			    };
		
				$.post(url('models/create'), dataModel, function(retorno) {
			    	if(retorno.id != undefined) {
			    		dialogModelCreateAddButton.prev().append($('<option>', {
		    				value: retorno.id,
		    				text: $('#modeldialog_name').val()
		    			}));
			    		
			    		dialogModelCreateAddButton.prev().val(retorno.id);
			    	}

			    	$('#modeldialog_model_type_id').val($("#modeldialog_model_type_id option:first").val());
			    	$('#modeldialog_vendor_id').val($("#modeldialog_vendor_id option:first").val());
			        $('#modeldialog_name').val('');
			        dialogModelCreate.close();
			    });
			});
		}
		
		if($(".create-type").length > 0) {
			dialogTypeCreate.querySelector('.create-type').addEventListener('click', function() {
				var dataType = {
				    "name" : $('#typedialog_name').val(),
			        "entity_key" : $('#typedialog_entity_key').val()
			    };
		
			    $.post(url('types/create'), dataType, function(retorno) {
			    	if(retorno.id != undefined) {
			    		dialogTypeCreateAddButton.prev().append($('<option>', {
		    				value: retorno.id,
		    				text: $('#typedialog_name').val()
		    			}));
			    		
			    		dialogTypeCreateAddButton.prev().val(retorno.id);
			    	}
			    	$('#typedialog_name').val('');
			        $('#typedialog_entity_key').val('');	
			    	dialogTypeCreate.close();
			    });
			});
		}
	}
	
	$("#model-add").click(function(event){
		event.preventDefault();
		dialogModelCreateAddButton = $(this);
		dialogModelCreate.showModal();
	});

	$("#tire-add").click(function(event){
		event.preventDefault();
		dialogTireCreateAddButton = $(this);
	    dialogTireCreate.showModal();
	});
	
	$("#type-add").click(function(event){
		event.preventDefault();
		dialogTypeCreateAddButton = $(this);
	    dialogTypeCreate.showModal();
	});
	
    $('.close-model').click(function() {
    	dialogModelCreate.close();
    });
	
    $('.close-tire').click(function() {
    	dialogTireCreate.close();
    });
	
    $('.close-type').click(function() {
    	dialogTypeCreate.close();
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
	    	$(".tires-selected-focus").addClass("mdl-color--green");
	    	$(".tires-selected-focus").removeClass("mdl-color--grey");
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
	

			var positionDetailData = {};
			positionDetailData.position = data.position;
			if(tirePositionDetail[data.position] == undefined || tirePositionDetail[data.position] == '') {
				$.post(url('tires/details'), data, function(retorno) {
					
					positionDetailData.fire_number = retorno[0].number;
					positionDetailData.Model = retorno[0].tire_model;
					positionDetailData.lifecycle = retorno[0].lifecycle;
					positionDetailData.miliage = retorno[0].miliage;
			    		
					$("#tire-position-detail-data").load(url('vehicle/map/updateDetail'), positionDetailData);
					tirePositionDetail[data.position] = positionDetailData;
				});
			} else {
				$("#tire-position-detail-data").load(url('vehicle/map/updateDetail'), tirePositionDetail[data.position]);
			}
			
			if($(".tires-selected-focus.tires-empty").length > 0) {
				$(".tire-position-detail-button").hide();
			} else {
				$(".tire-position-detail-button").show();
			}
		} else {
			tirePositionDetail[$('.tires-selected-focus').attr('id').replace('pos', '')] = undefined;
			$(".tire-position-detail-button").hide();
			$("#tire-position-detail-data").load(url('vehicle/map/updateDetail'), {});
		}
	}
	
	function setVehicleAndLocalizationSelectedFocusData() {

		var data = {
	        "vehicle_id" : $('#vehicle-id').val()
	    };

		$.post(url('vehicle/dashboard/localization'), data, function(retorno) {

			if(retorno.latitude == null) {
				retorno.latitude = "";
			}
			if(retorno.longitude == null) {
				retorno.longitude = "";
			}
			if(retorno.speed == null) {
				retorno.speed = "";
			}

			var positionDetailData = {};
			positionDetailData.latitude = retorno.longitude;
			positionDetailData.longitude = retorno.longitude;
			positionDetailData.speed = retorno.speed;
	    		
			$("#vehicle-detail-refresh-data").load(url('vehicle/map/updateDetail'), positionDetailData);
			
		});
	}
	
	function setTireAndSensorSelectedFocusData() {

		var data = {
	        "position"	: $('.tires-selected-focus').attr('id').replace('pos', ''),
	        "vehicle_id" : $('#vehicle-id').val()
	    };

		var positionDetailData = {};
		positionDetailData.position = data.position;
		if(!$("#"+$("#tire-position-focus-id").val()).hasClass("mdl-color--gray")) {
			$.post(url('vehicle/dashboard/tires'), data, function(retorno) {
				
				positionDetailData.fire_number = retorno.number;
				positionDetailData.Model = retorno.model;
				positionDetailData.lifecycle = retorno.lifecycle;
				positionDetailData.miliage = retorno.miliage;
				
				positionDetailData.temperature = retorno.temperature;
				positionDetailData.pressure = retorno.pressure;
				positionDetailData.battery = retorno.battery;
				positionDetailData.sensorNumber = retorno.sensorNumber;
			    
				$("#tire-detail-data").load(url('vehicle/map/updateDetail'), positionDetailData);
			});
		} else {
			$("#tire-detail-data").load(url('vehicle/map/updateDetail'), positionDetailData);
		}
	}
	
	$("input[name=tire-storage-id]").change(function(){
		
		var data = {
	        "part_id"	: $('input[name=tire-storage-id]:checked').val(),
	        "vehicle_id" : $('#vehicle-id').val()
	    };

		if(tirePositionDetail[data.position] == undefined || tirePositionDetail[data.position] == '') {
			$.post(url('tires/details'), data, function(retorno) {
		    	
		    	var storageDetailData = {};
		    	storageDetailData.fire_number = retorno[0].number;
		    	storageDetailData.Model = retorno[0].tire_model;
		    	storageDetailData.lifecycle = retorno[0].lifecycle;
		    	storageDetailData.miliage = retorno[0].miliage;
		    		
				$("#tire-storage-detail-data").load(url('vehicle/map/updateDetail'), storageDetailData);
		    	$("#tire-position-add").show();
		    	tireStorageDetail[data.part_id] = storageDetailData;
		    	
			});
		} else {
			$("#tire-storage-detail-data").load(url('vehicle/map/updateDetail'), tireStorageDetail[data.part_id]);
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
	
    $('#HkhZcTBbWFADje7t2').click(function(event) {
        event.preventDefault();
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