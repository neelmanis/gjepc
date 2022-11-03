$(function() { 
	$(document).ready(function () {
		/* show other-wa-jewellery on check */
		$("#other-wa-jewellery").click(function () {
			if($(this).attr("checked"))
				$('.wa-jewellery-other-id').show("slow");
			else
				$('.wa-jewellery-other-id').hide("slow");
		});
		if($("#other-wa-jewellery").attr("checked"))
			$('.wa-jewellery-other-id').show("slow");
		/* end other-wa-jewellery */
		
		/* selection of obmp_profile_pvr */
		$('input[name="wa_jewellery[]"]').click(function(){
			if( $('input[name="wa_jewellery[]"]:checked').length != 0)
			{
				$("#wa_error").text("");
			}
		});
		
		$('input[name="pd_jewellery[]"]').click(function(){
			if( $('input[name="pd_jewellery[]"]:checked').length != 0)
			{
				$("#pd_error").text("");
			}
		});
			
		$('input[name="obj_of_visit[]"]').click(function(){	
			if( $('input[name="obj_of_visit[]"]:checked').length != 0)
			{
				$("#obj_of_visit_error").text("");
			}
		});
		
		$('input[name="import_frm[]"]').click(function(){	
			if( $('input[name="import_frm_error[]"]:checked').length != 0)
			{
				$("#import_frm_error").text("");
			}
		});
		
		$('input[name="items_interested[]"]').click(function(){	
			if( $('input[name="items_interested[]"]:checked').length != 0)
			{
				$("#items_interested_error").text("");
			}
		});
		
		$('input[name="how_you_learn_abt_iijs[]"]').click(function(){	
			if( $('input[name="how_you_learn_abt_iijs[]"]:checked').length != 0)
			{
				$("#how_you_learn_abt_iijs_error").text("");
			}
		});
		
		$('input[name="send_info_abt[]"]').click(function(){	
			if( $('input[name="send_info_abt[]"]:checked').length != 0)
			{
				$("#send_info_abt_error").text("");
			}
		});
		/* end selection of obmp */
		
		/* show other-pd-jewellery on check */
		$("#other-pd-jewellery").click(function () {
			if($(this).attr("checked"))
				$('.pd-jewellery-other-id').show("slow");
			else
				$('.pd-jewellery-other-id').hide("slow");
		});
		if($("#other-pd-jewellery").attr("checked"))
			$('.pd-jewellery-other-id').show("slow");
		/* end other-pd-jewellery */
		
		/* show other-obj-of-visit on check */
		$("#other-obj-of-visit").click(function () {
			if($(this).attr("checked"))
				$('.obj-of-visit-other-id').show("slow");
			else
				$('.obj-of-visit-other-id').hide("slow");
		});
		if($("#other-obj-of-visit").attr("checked"))
			$('.obj-of-visit-other-id').show("slow");
		/* end other-obj-of-visit */
		
		
		/* show other-import-frm on check */
		$("#other-import-frm").click(function () {
			if($(this).attr("checked"))
				$('.import-frm-other-id').show("slow");
			else
				$('.import-frm-other-id').hide("slow");
		});
		if($("#other-import-frm").attr("checked"))
			$('.import-frm-other-id').show("slow");
		/* end other-import-frm */
		
		/* show items_interested_other on check */
		$("#items_interested_other").click(function () {
			if($(this).attr("checked"))
				$('.items_interested_other_id').show("slow");
			else
				$('.items_interested_other_id').hide("slow");
		});
		if($("#items_interested_other").attr("checked"))
			$('.items_interested_other_id').show("slow");
		/* end items_interested_other */
		
		/* show color gems on check */
		$("#color_gems").click(function () {
			if($(this).attr("checked"))
				$('#color_gems_view').show("slow");
			else
				$('#color_gems_view').hide("slow");
		});
		if($("#color_gems").attr("checked"))
			$('#color_gems_view').show("slow");
		/* end color gems */
		
		/* show loose diamonds on check */
		$("#loose_diamonds").click(function () {
			if($(this).attr("checked"))
				$('.loose_diamonds_view').show("slow");
			else
				$('.loose_diamonds_view').hide("slow");
		});
		if($("#loose_diamonds").attr("checked"))
			$('.loose_diamonds_view').show("slow");
		/* end loose diamonds */
		
		/* show how_you_learn_abt_iijs_other on check */
		$("#how_you_learn_abt_iijs_other").click(function () {
			if($(this).attr("checked"))
				$('.how_you_learn_abt_iijs_other_id').show("slow");
			else
				$('.how_you_learn_abt_iijs_other_id').hide("slow");
		});
		if($("#how_you_learn_abt_iijs_other").attr("checked"))
			$('.how_you_learn_abt_iijs_other_id').show("slow");
		/* end how_you_learn_abt_iijs_other */
		
		/* show tours on check */
		$("#tours").click(function () {
			if($(this).attr("checked"))
				$('.send_info_abt_other_id').show("slow");
			else
				$('.send_info_abt_other_id').hide("slow");
		});
		if($("#tours").attr("checked"))
			$('.send_info_abt_other_id').show("slow");
		/* end tours */
		
	});
});

