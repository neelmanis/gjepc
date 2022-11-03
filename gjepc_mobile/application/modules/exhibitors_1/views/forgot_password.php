<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Lifefeed</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>

<style>

@import 'https://fonts.googleapis.com/css?family=Roboto';

*{font-family: 'Roboto', sans-serif;}

.top-buffer{margin-top:50px;text-align:center;}

.form_wrp {
    border: 1px solid #ddd;
    padding: 10px;
    box-shadow: 1px 3px 5px 0px;
}
.form_error{
color:#FF0000;
}
</style>

<h1 class="top-buffer">  Set New Password  </h1>


<div class="col-md-offset-4 col-md-4 col-sm-offset-4 col-sm-4 col-xs-12">
	
    <div class="form_wrp">

    <img src="http://digitalagencymumbai.com/lifefeed/logo.png"  class="img-responsive center-block"/>
	<form id="forgot" >
    <div style="display: none;" class="form_error"></div>
    <div style="display: none;color:#1CC134" class="form_success"></div>
	<div class="form-group row" style="margin-top:10px;">
    	<div class="col-md-6"> <label for="new_pass" class="form-label" >New Password </label></div>
        <div class="col-md-6"> <input class="form-control" name="new_pass" type="password" placeholder="New Password"/> </div>
    </div>
    
    <div class="form-group row">
    	<div class="col-md-6"> <label for="confirm_pass" class="form-label" >Confirm Password </label> </div>
        <div class="col-md-6"> <input name="confirm_pass" type="password" class="form-control" placeholder="Confirm Password"/> </div>
        <input type="hidden" name="id" value="<?php echo $user_id; ?>">
    </div>
    
    <div class="form-group row">
    	<div class="col-md-12 text-center"> <input name="submit" type="submit" value="Save" class="btn btn-primary" /> </div>
    </div>

	</form>
    </div>

</div>



<div class="clear"> </div> 
<script src="http://digitalagencymumbai.com/uno/assets/js/jquery-1.8.3.js" type="text/javascript"></script>
<script src="http://digitalagencymumbai.com/lifefeed/assets/js/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="http://digitalagencymumbai.com/lifefeed/assets/css/rcmc.validation.css"/>
          
<script type="text/javascript">
$(function ()
{
    $("#forgot").validate({
           
                rules: {
                new_pass:"required",
				confirm_pass:"required"
            },
        messages: {
           new_pass: "Please enter new password",
		   confirm_pass: "Please enter confirm password"
        },
    
		
        submitHandler: function (form)
        {
		  
		   var formdata = jQuery("#forgot").serialize();
      	jQuery.ajax({
				type :"POST",
				data :formdata,
				url :"http://digitalagencymumbai.com/lifefeed/index.php/users/updatePassword",
				success : function(result){ 
                                      if(result == 1)
									   {  
						                 $(".form_success").css("display","block");
							             $(".form_success").text("Your Password updated successfully.").delay(1000).fadeOut(2000);
									     //$();
									   }
									   else
									   {
									    $(".form_error").css("display","block");
							             $(".form_error").text(result).delay(10000).fadeOut(20000);
									   }	
				}
			})

        }
    });
});
</script>