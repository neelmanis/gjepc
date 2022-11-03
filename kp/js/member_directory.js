$(function() { 
	$(document).ready(function () {
		$item_description = '';
		$("#edit-item-description option:selected").each(function () {
				if ($(this).text() == "Any Other")
				{
					$('#item-description-other-id').show("slow");
					$item_description = $(this).text();
				}
				else
				{
					$('#item-description-other-id').hide("slow");
				}
        });
		if($item_description != "Any Other") {
				$('#edit-item-description-other').val("");
		}

		$wa_jewellery = '';
		$("#edit-wa-jewellery option:selected").each(function () {
				if ($(this).text() == "Any Other")
				{
					$('#wa-jewellery-other-id').show("slow");
					$wa_jewellery = $(this).text();
				}
				else
				{
					$('#wa-jewellery-other-id').hide("slow");
				}
        });
		if($wa_jewellery != "Any Other") {
				$('#edit-wa-jewellery-other').val("");
		}

		$wa_machinery = '';
	  	$("#edit-wa-machinery option:selected").each(function () {
				if ($(this).text() == "Any Other")
				{
					$('#wa-machinery-other-id').show("slow");
					$wa_machinery = $(this).text();
				}
				else
				{
					$('#wa-machinery-other-id').hide("slow");
				}
        });
		if($wa_machinery != "Any Other") {
				$('#edit-wa-machinery-other').val("");
		}
	
		$wa_other = '';
	  	$("#edit-wa-other option:selected").each(function () {
				if ($(this).text() == "Any Other")
				{
					$('#wa-other-other-id').show("slow");
					$wa_other = $(this).text();
				}
				else
				{
					$('#wa-other-other-id').hide("slow");
				}
        });
		if($wa_other != "Any Other") {
				$('#edit-wa-other-other').val("");
		}

		// sub form diamond requirement and colorgemsones
		var jewellery = new Array();
		var i = 0;
		$("#edit-pd-jewellery option:selected").each(function () {
			jewellery[i] = $(this).text();
			i++;
		});
		product_dealing_in(jewellery);

		$pd_machinery = '';
	  	$("#edit-pd-machinery option:selected").each(function () {
				if ($(this).text() == "Any Other")
				{
					$('#pd-machinery-other-id').show("slow");
					$pd_machinery = $(this).text();
				}
				else
				{
					$('#pd-machinery-other-id').hide("slow");
				}
        });
		if($pd_machinery != "Any Other") {
				$('#edit-pd-machinery-other').val("");
		}

		$objective_other = '';
	  	$("#edit-objective option:selected").each(function () {
				if ($(this).text() == "Any Other")
				{
					$('#objective-other-id').show("slow");
					$objective_other = $(this).text();
				}
				else
				{
					$('#objective-other-id').hide("slow");
				}
        });
		if($objective_other != "Any Other") {
				$('#edit-objective-other').val("");
		}

		$import_from = '';
	  	$("#edit-import-from option:selected").each(function () {
				if ($(this).text() == "Any Other")
				{
					$('#import-from-other-id').show("slow");
					$import_from = $(this).text();
				}
				else
				{
					$('#import-from-other-id').hide("slow");
				}
        });
		if($import_from != "Any Other") {
				$('#edit-import-from-other').val("");
		}

		// sub form diamond requirement and colorgemsones
		var item_interest = new Array();
		var i = 0;
		$("#edit-item-interest option:selected").each(function () {
			item_interest[i] = $(this).text();
			i++;
		});
		items_interested_in(item_interest);
	});

	$('#edit-item-description').change( function() {
		$item_description = '';
		$("#edit-item-description option:selected").each(function () {
				if ($(this).text() == "Any Other")
				{
					$('#item-description-other-id').show("slow");
					$item_description = $(this).text();
				}
				else
				{
					$('#item-description-other-id').hide("slow");
				}
        });
		if($item_description != "Any Other") {
				$('#edit-item-description-other').val("");
		}
	}); 

	$('#edit-wa-jewellery').change( function() {
		$wa_jewellery = '';
		$("#edit-wa-jewellery option:selected").each(function () {
				if ($(this).text() == "Any Other")
				{
					$('#wa-jewellery-other-id').show("slow");
					$wa_jewellery = $(this).text();
				}
				else
				{
					$('#wa-jewellery-other-id').hide("slow");
				}
        });
		if($wa_jewellery != "Any Other") {
				$('#edit-wa-jewellery-other').val("");
		}
	}); 

	$('#edit-wa-machinery').change( function() {
		$wa_machinery = '';
	  	$("#edit-wa-machinery option:selected").each(function () {
				if ($(this).text() == "Any Other")
				{
					$('#wa-machinery-other-id').show("slow");
					$wa_machinery = $(this).text();
				}
				else
				{
					$('#wa-machinery-other-id').hide("slow");
				}
        });
		if($wa_machinery != "Any Other") {
				$('#edit-wa-machinery-other').val("");
		}
	});
	
	$('#edit-wa-other').change( function() {
		$wa_other = '';
	  	$("#edit-wa-other option:selected").each(function () {
				if ($(this).text() == "Any Other")
				{
					$('#wa-other-other-id').show("slow");
					$wa_other = $(this).text();
				}
				else
				{
					$('#wa-other-other-id').hide("slow");
				}
        });
		if($wa_other != "Any Other") {
				$('#edit-wa-other-other').val("");
		}
	});

	$('#edit-pd-jewellery').change( function() {
		var jewellery = new Array();
		var i = 0;
		$("#edit-pd-jewellery option:selected").each(function () {
			jewellery[i] = $(this).text();
			i++;
		});
		product_dealing_in(jewellery);
	});

	$('#edit-pd-machinery').change( function() {
		$pd_machinery = '';
	  	$("#edit-pd-machinery option:selected").each(function () {
				if ($(this).text() == "Any Other")
				{
					$('#pd-machinery-other-id').show("slow");
					$pd_machinery = $(this).text();
				}
				else
				{
					$('#pd-machinery-other-id').hide("slow");
				}
        });
		if($pd_machinery != "Any Other") {
				$('#edit-pd-machinery-other').val("");
		}
	});

	$('#edit-objective').change( function() {
		$objective_other = '';
	  	$("#edit-objective option:selected").each(function () {
				if ($(this).text() == "Any Other")
				{
					$('#objective-other-id').show("slow");
					$objective_other = $(this).text();
				}
				else
				{
					$('#objective-other-id').hide("slow");
				}
        });
		if($objective_other != "Any Other") {
				$('#edit-objective-other').val("");
		}
	});

	$('#edit-import-from').change( function() {
		$import_from = '';
	  	$("#edit-import-from option:selected").each(function () {
				if ($(this).text() == "Any Other")
				{
					$('#import-from-other-id').show("slow");
					$import_from = $(this).text();
				}
				else
				{
					$('#import-from-other-id').hide("slow");
				}
        });
		if($import_from != "Any Other") {
				$('#edit-import-from-other').val("");
		}
	});

	$('#edit-item-interest').change( function() {
		var item_interest = new Array();
		var i = 0;
		$("#edit-item-interest option:selected").each(function () {
			item_interest[i] = $(this).text();
			i++;
		});
		items_interested_in(item_interest);
	});
});

function items_interested_in(item_interest){
	if (item_interest.indexOf('Any Other') > -1) 
	{
		$('#item-interest-other-id').show("slow");
	}
	else 
	{
		$('#item-interest-other-id').hide("slow");
		$('#edit-item-interest-other').val("");
	}

	if ($('#edit-user-type').val() == 'NM')
	{
		if (item_interest.indexOf('Loose Diamonds') > -1) 
		{
			$('#diamond-requirement-id').show("slow");
		}
		else 
		{
			$('#diamond-requirement-id').hide("slow");
			$('#edit-d-pp-from').val("");
			$('#edit-d-pp-to').val("");
			
			$("#edit-d-size option:selected").each(function () {
				$(this).attr('selected',false);
			});

			$("#edit-d-clarity option:selected").each(function () {
				$(this).attr('selected',false);
			});

			$("#edit-d-color-shade option:selected").each(function () {
				$(this).attr('selected',false);
			});
		}

		if (item_interest.indexOf('Coloured Gemstones') > -1) 
		{
			$('#coloured-gem-stone-requirement-id').show("slow");
		}
		else 
		{
			$('#coloured-gem-stone-requirement-id').hide("slow");
			$('#edit-cgs-shade').val("");
			$('#edit-cgs-shape').val("");
			$('#edit-cgs-quantity').val("");
			$('#edit-cgs-pp-from').val("");
			$('#edit-cgs-pp-to').val("");
			
			$("#edit-cgs-stone option:selected").each(function () {
				$(this).attr('selected',false);
			});
		}
	}
}

function product_dealing_in(jewellery){
	if (jewellery.indexOf('Any Other') > -1)
	{
		$('#pd-jewellery-other-id').show("slow");
	}
	else
	{
		$('#pd-jewellery-other-id').hide("slow");
		$('#edit-pd-jewellery-other').val("");
	}

	if ($('#edit-user-type').val() == 'M')
	{
		if (jewellery.indexOf('Loose Diamonds') > -1) 
		{
			$('#diamond-requirement-id').show("slow");
		}
		else 
		{
			$('#diamond-requirement-id').hide("slow");
			$('#edit-d-pp-from').val("");
			$('#edit-d-pp-to').val("");
			
			$("#edit-d-size option:selected").each(function () {
				$(this).attr('selected',false);
			});

			$("#edit-d-clarity option:selected").each(function () {
				$(this).attr('selected',false);
			});

			$("#edit-d-color-shade option:selected").each(function () {
				$(this).attr('selected',false);
			});
		}

		if (jewellery.indexOf('Coloured Gemstones') > -1) 
		{
			$('#coloured-gem-stone-requirement-id').show("slow");
		}
		else 
		{
			$('#coloured-gem-stone-requirement-id').hide("slow");
			$('#edit-cgs-shade').val("");
			$('#edit-cgs-shape').val("");
			$('#edit-cgs-quantity').val("");
			$('#edit-cgs-pp-from').val("");
			$('#edit-cgs-pp-to').val("");
			
			$("#edit-cgs-stone option:selected").each(function () {
				$(this).attr('selected',false);
			});
		}
	}
}