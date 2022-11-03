<title> Member Verification || GJEPC INDIA</title>
<?php 
include 'include/header.php';
//header('Location: india_gold_and_jewellery_summit_2019.php');
?>

<style>
.verified,
#chkregisuser{display: inline-block;}
</style>


<div class="container loginform">	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="title">
		    <h4>Member verification</h4>
		</div>
	</div>
	
	<form class="cmxform" method="POST" name="regisForm" id="regisForm" action="india_gems_summit.php">
	  <div class="col-md-3  col-sm-6 col-xs-12 minibuffer text-center">			
			<!--<label for="member">Select Member Type:</label>-->
			<select name="verifyMember" id="verifyMember" class="form-control">
				<option value="">Select Member Type</option>
				<option value="M">MEMBER</option>
				<option value="NM">NONMEMBER</option>
				<option value="IN">INTERNATIONAL</option>
			</select>
	  </div>
	
	  <div class="col-md-3 col-sm-2 col-xs-2 minibuffer text-center" id="chkGcode" style="display: none">
		<!--<label id="refnumlabel" for="next">BP Number : </label> -->
			
		
		<input type="text" id="gcode" name="gcode" Placeholder="Enter BP Number" class="form-control"  autocomplete="off" autofocus>
        <div class="verified" id="neel" style="display: none"><img src="admin/images/active.png" ></div>
			<div class="verified" id="gupta" style="display: none"><img src="admin/images/delete.gif" ></div>
        <div id="chkregisuser"></div>
	  </div>
	  
	  <div class="col-md-1 col-sm-1 col-xs-2 minibuffer text-center">
	  <!--<label id="refnumlabel" for="gcode" style="display:block;">&nbsp;</label>-->
	  <button type="submit" style="display: none" id="registration_submit" class="btn btn-default">Proceed to Next</button>
	  </div>
	</form>
</div>

<style>
.loginform {background:none;}
.form-control {font-size:14px; height:40px;}
.btn {height:40px; font-size:14px;}
</style>
<?php include 'include/footer.php'; ?>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	$("#verifyMember").change(function () {
            if ($(this).val() == "M") {
                $("#chkGcode").show();
				$("#registration_submit").hide();
            } else if($(this).val() == "NM" ||$(this).val()=="IN"){
                $("#chkGcode").hide();
				$("#registration_submit").show();
            }else
			{
				$("#chkGcode").hide();
				$("#registration_submit").hide();
			}
        });
});
</script>

<script>
$(document).ready(function(){
  $("#gcode").keyup(function(){
	var gcode=$("#gcode").val();
	//if($("#gcode").val().length>=6){
		
				$.ajax({
					type: 'POST',
					url: 'getGcodeajax.php',
					data: "actiontype=chkGcode&gcode="+gcode,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
					
					if($.trim(data)=='Verified')
					{
							jQuery('#registration_submit').show();
							jQuery('.verified').hide();
							jQuery('#neel').show();													
					} else {
							jQuery('#registration_submit').hide();
							jQuery('.verified').hide();
							jQuery('#gupta').show();
					}
							     //alert(data);
							    $("#chkregisuser").html(data);  
					}
		});	
	//}
 });  
});
</script>