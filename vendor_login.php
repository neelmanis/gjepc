<?php include 'include-new/header_vendor.php'; include 'db.inc.php';?>
<style>
	 #tender .modal-header .close {
    margin-top: -2px;
    position: absolute;
    right: 9px;
    top: -4px;
    border: none;
    background: transparent;
    font-size: 2em;
}
#tender .modal-header{
	border-bottom: none;
}
#tender .modal-content{
   background: #fff;
}
.form-block{transition: none;background: #fff}
.form-block:hover{box-shadow: none;}
.table_box{margin-left: 50%;transform: translate(-50%);padding: 15px;background: #fff;-webkit-box-shadow: 10px 10px 5px -9px rgba(0,0,0,0.65);
-moz-box-shadow: 10px 10px 5px -9px rgba(0,0,0,0.65);
box-shadow: 10px 10px 5px -9px rgba(0,0,0,0.65);}
.top_info {text-align: center;}

.top_info h3{font-size: 28px;font-weight: 700;color: #000;text-transform: uppercase;}

.table_parkinfo{position: relative; margin-left: 50%;transform: translate(-50%); /*border:1px solid #ccc;*/padding: 10px;padding: 20px;/*-webkit-box-shadow: 0px 0px 17px -5px rgba(0,0,0,0.68);
-moz-box-shadow: 0px 0px 17px -5px rgba(0,0,0,0.68);
box-shadow: 0px 0px 17px -5px rgba(0,0,0,0.68);*/} 

.mt-5{margin-top: 50px;}
.mt-4{margin-top: 40px;}
.mt-3{margin-top: 30px;}
.mt-2{margin-top: 20px;}
.mb-4{margin-bottom: 40px;}
.title_bar h3{display: inline-block; background: #9c1658;padding: 5px 20px 5px 10px; min-width: 150px;color: #fff;position: relative;}


.title_bar h3:before{position: absolute;
    content: "";
    width: 0;
    height: 0;
    border-style: solid;
    border-width: 14.5px 0 15.5px 26px;
    border-color: transparent transparent transparent #9c1658;
    right: -25px;
    top: 0px;
}
::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  color: #ccc;
  opacity: 1; /* Firefox */
  font-weight: 400;
  font-size: 14px;
}
.table_parkinfo .form-control{border:1px solid #a7a2a2;color: #2d3e52;font-size: 17px;font-weight: 100}	
.btn-submit{background: #9c1658;color: #fff; font-weight: 400;font-size: 15px;padding: 6px 30px;}
.table_parkinfo  label{color: #2d3e52;font-size: 16px;}
.table_parkinfo:before{content: "";position: absolute;top: 0; left: 0;border-top: 1px solid #9c1658;width: 80px; border-left: 1px solid#9c1658;  height: 80px}
.table_parkinfo:after{content: "";position: absolute;bottom: 0; right: 0;border-bottom: 1px solid #9c1658;width: 80px; border-right: 1px solid#9c1658;  height: 80px}

.cust_border:before{position:absolute;content: "";top: 0;right: 0;border-right: 1px solid#9c1658; height: 80px;border-top:1px solid #9c1658; width: 80px;}
.cust_border:after{position:absolute;content: "";bottom: 0;left: 0;border-left: 1px solid#9c1658; height: 80px;border-bottom:1px solid #9c1658; width: 80px;}
.error{color:#e62323!important; font-size: 14px!important;}
.color_red{color: red!important}
.btn_registration{background: #e4e4e4;color:#000;padding: 6px 30px;cursor: pointer;}
#recover_password{display: none;}
</style>

<section class="py-5">
	
    <div class="container-fluid inner_container">
		
        <div class="row justify-content-center grey_title_bg">
       		
            
            <div class="innerpg_title_center d-flex mb-3">
                	<img src="assets/images/gold_star.png" class="icon-title mr-4"><h1 class="title d-inline-block form_title align-items-center"> Vendor LogIn </h1><img src="assets/images/gold_star.png" class="icon-title ml-4">
                </div>
		</div>
         
		<div class="container p-0">
			
            <div class="row justify-content-center">
            		
		    	<form class="form-horizontal col-lg-5 box-shadow mb-5" id="vendor_login">
		      	
		      		<div class="form-group">
		      			<input type="text" name="email_id" id="email_id" class="form-control" placeholder="Login ID">
		      		</div>
		      		
		      		<div class="form-group">
		      			<input type="password" name="password" id="password" class="form-control" placeholder="Password">
		      			<div class="text-left "><label for="uname_pass" class="color_red" generated="true"></label></div>
					</div>
                                        	
		      		<div class="form-group">
		      			<?php $_SESSION["token"] = md5(uniqid(mt_rand(), true)); ?>
		      			<input type="hidden" name="csrfToken" id="csrfToken" value="<?php echo $_SESSION["token"];?>">
		      			<button type="submit" name="submit" value="login" class="cta w-100">Submit</button>
		      			<input type="hidden" name="action" value="vendor_login">		      			
		      		</div>
                    <p class="text-center"><a href="JavaScript:Void(0);" id="forgot_pass">Forgot Password ?</a></p>
		      	    <p class="text-center"><a href="vendor_registration.php"> Register For Vendor Emapanelmanet</a></p>		
                   
              	</form>
              
		       	<form class="form-horizontal col-lg-5 box-shadow mb-5" id="recover_password">		      		
                     <div class="form-group mb-4"><p class="blue">Forgot Password</p></div>
                    
                    <div class="form-group">
		      			<input type="text" name="v_email_id" id="v_email_id" class="form-control" placeholder="Email ID">
		      		</div>
		 			
                    <div class="form-group">
		      			<button type="submit" name="submit" value="Send Email" class="cta w-100">Submit</button>
		      			<input type="hidden" name="action" value="recover_password">		      			
		      		</div>                    
					<p><a href="vendor_registration.php" class="">Register For Vendor Emapanelmanet</a> </p>     
                </form>                
			</div>            
		</div>	
    </div>    
</section>

<?php include 'include-new/footer.php'; ?>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
	$("#vendor_login").validate({
			//var member_id=$("#member_type_id").val();
		rules: {
			
			email_id:
			{
				required:true,
			},
			password:
			{
				required:true,
			}
		},
		messages: {		
			email_id:{
			required: "Please Enter Email-Id",
			},
			password:{
			required: " Please Enter Password",
			}	
		},
		    submitHandler: ajaxLogin
        
	});
		$("#recover_password").validate({
			//var member_id=$("#member_type_id").val();
		rules: {
			
			v_email_id:
			{
				required:true,
				email:true,
			}
		},
		messages: {		
			v_email_id:{
			required: "Please Enter Email-Id",
			}	
		},
		submitHandler: ajaxRecoverPassword        
	});	
	});
</script>

<script>
	   function redirectDashboard() {
                    setTimeout(function(){
                     window.location = "vendor_profile.php"; 
                 }, 1000);
               }
		function ajaxLogin(){
		/*alert("dfgfh");return false;*/
		var formdata = $('#vendor_login').serialize();
		/*var data = $("#formenquiry").serialize();*/
		$.ajax({
			type:'POST',
			data:formdata,
			url:"vendorAction.php",
			dataType: "json",
			
			success:function(result){
				
				if(result['status'] == "success"){
	
				  swal({
						title: "success",
						icon: "success",
						text: "Login Succssfull"
					});
				    redirectDashboard();

                }else if(result['status'] == "invalid"){
                   $("label[for='uname_pass']").text("Username And Password Are Not Matched");
                }
                else if(result['status'] == "invalidToken"){
                   $("label[for='uname_pass']").text("Invalid Request");
                }
                
			}
		});
	}
			function ajaxRecoverPassword(){
		/*alert("dfgfh");return false;*/
		var formdata = $('#recover_password').serialize();
		/*var data = $("#formenquiry").serialize();*/
		
		$.ajax({
			type:'POST',
			data:formdata,
			url:"vendorAction.php",
			dataType: "json",
			
			success:function(result){
					if(result['status'] == "emailSuccess"){
	
				  swal({
						title: "success",
						icon: "success",
						text: "Information Sent On Registered Email"
					});
			      $('#recover_password')[0].reset();
			      $("#recover_password").fadeOut();
                  $("#vendor_login").fadeIn();

                }else if(result['status'] == "emailFail"){
	
				  swal({
						title: "error",
						icon: "error",
						text: "Server Error"
					});			

                }else if(result['status'] == "notExist"){
	
				  swal({
						title: "Warning",
						icon: "warning",
						text: "Email Id not Exist"
					});	
                } 				
			}
		});
	}
	$('#forgot_pass').on("click", function() {
$("#recover_password").fadeIn();
$("#vendor_login").fadeOut();
});

</script>