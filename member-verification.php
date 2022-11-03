<?php 
include 'include-new/header.php';
?>
<section>	
    <div class="container inner_container">

	<div class="col-12 bold_font text-center d-block"> <div class="d-block"><img src="assets/images/gold_star.png"></div>Firm/Company Verification </div>
    <div class="row">
	<form class="cmxform form-export-import col-12 box-shadow mb-4" method="POST" name="regisForm" id="regisForm" >
		<div class="form-group col-12 mb-4">
            <p class="blue tr" key="enroll">Firm/Company Verification &nbsp;&nbsp;<span id="chkregisuser"></span><br><span id="chkpanuser"></span></p>
        </div>
	  <div class="col-md-4 col-12 col-xs-2 minibuffer mt-2" id="show_m" style="">
	  	<label>Enter BP Number</label>
		<input type="text" id="bpno" name="bpno" Placeholder="Enter BP Number" class="form-control" maxlength="15" autocomplete="off" autofocus>
        <div class="verified" id="neel" style="display: none"><img src="admin/images/active.png"></div>
		<div class="verified" id="gupta" style="display: none"><img src="admin/images/delete.gif"></div>
        <div id="chkregisuser"></div>
	  </div>
	   <p id="parichay_type"></p>
	   
	  <div class="col-md-1 col-sm-1 col-xs-2 minibuffer text-center">
	  <button type="submit"  id="registration_submit" class="cta fade_anim mr-2	">Verify</button>
	  </div>
	</form>
</div>
</div>

</section>
<style>
.verified,
#chkregisuser{display: inline-block;}
</style>

<?php include 'include-new/footer_export.php'; ?>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>

<script>
$(document).ready(function(){
  $('#regisForm').on('submit', function(e){
	e.preventDefault();
	var verifyMember = $("#verifyMember").val();
	var bpno = $("#bpno").val();
	
	var actionType = "verify_membership";	
				$.ajax({
					type: 'POST',
					url: 'ajax.php',
					// data: "actiontype=chkBPNO&bpno="+bpno,
					data: {actionType:actionType,bpno:bpno},
					dataType: "json",
					beforeSend: function(){
						$('#preloader').show();
						$("#status").show();					
					},
					success: function(data){ //alert(data.status);
						$('#preloader').hide();
						$("#status").hide(); 
						if(data.status=="member")
						{
							window.location = "parichay_company_registration.php";												
						} else if(data.status=="nonMember")
						{
							alert("You Are Non Member Company");												
						} else if(data.status=="alreadyApplied")
						{		
							alert("You Have Already Registered. Kindly Login");
							window.location = "login.php";
						}  else if(data.status=="bp_blank")
						{		
							alert("Please Enter BP no");
						}else if(data.status=="pan_email_blank"){
                            alert("Please Enter Email/PAN of your Company");
						}else if(data.status=="exist")
						{	
							window.location = "parichay_company_registration.php";
						} else if(data.status=="notExist")
						{		
							alert("Your Email/PAN Not Found. Kindly Register your Company");
							window.location = "parichay_company_registration.php";	// Redirect on NonMember Company Page
						} 					
					}
		});	
	});  
	
	
	/* NONMEMBER Check */	
	// $("#email_id").blur(function(){
	// 	email_id = $('#email_id').val();
	// 	$.ajax({
	// 			type:'POST',
	// 			data:"actiontype=checkDetails&email_id="+email_id,
	// 			url:'ajax.php',
	// 			dataType: "json",
	// 			beforeSend: function(){
	// 				$('#preloader').show();
	// 				$("#status").show();					
	// 			},
	// 		success: function(data){ //alert(data);
	// 			$('#preloader').hide();
	// 			$("#status").hide();
	// 			if(data.status=="exist")
	// 			{	
	// 				window.location = "parichay_company_registration.php";
	// 			} else if(data.status=="notExist")
	// 			{		
	// 				alert("Your Email/PAN Not Found. Kindly Register your Company");
	// 				window.location = "parichay_company_registration.php";	// Redirect on NonMember Company Page
	// 			} else if(data.status=="alreadyApplied")
	// 			{		
	// 				alert("You Have Already Applied. Kindly Login");
	// 				window.location = "login.php";
	// 			} else if(data.status=="blank")
	// 			{		
	// 				alert("Please Enter Email/PAN of your Company");
	// 			} 	
	// 		}
	// 	});
	// });
});
</script>