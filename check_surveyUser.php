<?php
include 'include/header.php';

$survey_id = $_POST['survey_id'];
$_SESSION['survey_id'] = $survey_id;
?>
<script>
$(document).ready(function(){
  $("#regisForm").on('submit', function(e){
  	e.preventDefault();

	var formdata = $(this).serialize();
				$.ajax({
					type:'POST',
                    data:formdata,
					url: 'survey_check.php',
					dataType: "json",
					success: function(data){			
					if(data.status=="success")
					{
						window.location.href="survey.php";							
																			
					} else if(data.status=="fail"){
						$('label[for="email_id"]').text("Invalid Response");	
							
					} else if(data.status=="exist"){
						$('label[for="email_id"]').text("already survey");	
							
					}else if(data.status=="invalidEmail"){
						$('label[for="email_id"]').text("Please enter valid Email id");	
							
					}
					}
		});	
	//}
 });  
});
</script>

<div class="container loginform">	
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="title"><h4>Survey verification</h4></div>
	</div>
	
	<form class="cmxform" method="POST" name="regisForm" id="regisForm">	 
	<input type="hidden" name="survey_id" id="survey_id" value="<?php echo $_SESSION['survey_id'];?>">
	  <div class="col-md-3 col-md-offset-2 col-sm-2 col-xs-2 minibuffer text-center">			
		<input type="text" id="email_id" name="email_id" Placeholder="Enter Email" class="form-control" autocomplete="off" autofocus="on">
		<label generated="true" class="error" for="email_id" ></label>
	  </div>	  
	  <div class="col-md-2 col-sm-2 col-xs-2 minibuffer text-center">
      <input type="hidden" name="actiontype" value="chkEmail">
	  <input type="submit" class="btn btn-default submit" value="Start Survey">
	  </div>
	</form>
</div>