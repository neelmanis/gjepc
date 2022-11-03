<?php include 'include-new/header_vendor.php';
include 'db.inc.php';
session_start(); ob_start();
include 'functions.php';
?>
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

.top_info h3{font-size: 32px;font-weight: 700;color: #000}

.table_parkinfo{position: relative; margin-left: 50%;transform: translate(-50%); /*border:1px solid #ccc;*/padding: 10px;padding: 20px;/*-webkit-box-shadow: 0px 0px 17px -5px rgba(0,0,0,0.68);
-moz-box-shadow: 0px 0px 17px -5px rgba(0,0,0,0.68);
box-shadow: 0px 0px 17px -5px rgba(0,0,0,0.68);*/} 

.mt-5{margin-top: 50px;}
.mt-4{margin-top: 40px;}
.mt-3{margin-top: 30px;}
.mt-2{margin-top: 20px;}
.mb-1{margin-bottom: 10px;}
.mb-4{margin-bottom: 40px;}
.mb-3{margin-bottom: 30px;}
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
.fa-spin{margin-right: 10px }
.table_parkinfo .form-control{border:1px solid #a7a2a2;color: #2d3e52;font-size: 17px;font-weight: 100}	
.btn-submit{background: #9c1658;color: #fff; font-weight: 400;font-size: 15px; cursor: pointer!important;webkit-cursor:pointer;}
.table_parkinfo  label{color: #2d3e52;font-size: 16px;}
.table_parkinfo:before{content: "";position: absolute;top: 0; left: 0;border-top: 1px solid #9c1658;width: 120px; border-left: 1px solid#9c1658;  height: 120px}
.table_parkinfo:after{content: "";position: absolute;bottom: 0; right: 0;border-bottom: 1px solid #9c1658;width: 120px; border-right: 1px solid#9c1658;  height: 120px}

.cust_border:before{position:absolute;content: "";top: 0;right: 0;border-right: 1px solid#9c1658; height: 120px;border-top:1px solid #9c1658; width: 120px;}
.cust_border:after{position:absolute;content: "";bottom: 0;left: 0;border-left: 1px solid#9c1658; height: 120px;border-bottom:1px solid #9c1658; width: 120px;}
.star{position: relative;}
.star:after{position:absolute;content: "*";font-size: 14px;top: 0;right: -10px;color: red}
.error{color:#e62323!important; font-size: 14px!important;}
.otp_error h3{display: inline-block;}
.resend{margin-left: 15px;padding: 5px 10px;background: #000;border:none;color: #fff}
.resend:hover{background: #000;text-decoration-line: none;color: #fff}
.resend:focus{border:none;text-decoration-line: none;color: #fff}
.text-uppercase{text-transform: uppercase;}
label[for='otp_number']{color: red;font-size: 14px;}
.resend_email{display: none}
/*#vendor_reg{display: none;}*/
#otp_form{display: none;}
input[type="submit"]:disabled {background: #ccc;color:#000;}

</style>
<?php 
 $action=$_GET['action'];

if($action == "resend_otp"){
	$email = base64_decode($_GET['param']);
    $sql = "SELECT contact_email from vendor_registration where contact_email='$email'";
    $row=$conn->query($sql);

    $to = $email;
    if($row->num_rows > 0){
    $result = $row->fetch_assoc();
   $message =  '<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>GJEPC INDIA  | Email Verification</title>
</head>
<style></style>
<body>
<div style="margin:0 auto; max-width:700px; width:700px; position:relative; line-height:18px;">
  <table  cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; color:#292b29; width:100%; border:1px solid #619855; border-bottom:4px solid #0aa360; font-size:14px; border-collapse:collapse;">
  <tr>
    <td colspan="2" style="background:#ba4c59; height:20px;"></td>
  </tr>

  <tr style="background:#fdfdfd;">
    <td style="width:150px; padding-left:30px;" valign="top">
     
    </td>
    <td style="padding:30px 50px 30px 0px;">
        <p style=""><strong>Dear Sir / Madam,</strong></p>
        <p>Your OTP for Email verification is <strong>'.$result['otp_number'].'</strong></p>
        <div style="border-top:1px solid #ccc;">
        <p>Regards,<br>
        <strong>GJEPC INDIA</strong> </p>
    </td>
  </tr>
  </table>
</div>
</body>
</html>';
   $subject = "GJEPC INDIA Vendor Account Activation OTP."; 
  
   
    $mail_result = send_mail($to, $subject, $message, "");
    $_SESSION['success_msg'] = "OTP has been sent successfully";
    header("Refresh:0; url=vendor_registration.php");
    }else{
    	header("Refresh:0; url=vendor_registration.php");
    }
}
?>
<section>
	
    <div class="container-fluid inner_container">
        
		<div class="row justify-content-center grey_title_bg">
        	<div class="innerpg_title_center text-bold">
            	<h3> Vendor Registration </h3>
            </div>
		</div>
            
		<div class="container p-0">
        	
            <div class="row justify-content-center">
            
		   		<form class="form-horizontal col-12 box-shadow mb-5" id="vendor_reg">
		      		
                    <div class="row">
                    	
                        <div class="form-group col-12 mb-4">
                            <p class="blue">Company Details</p>
                        </div>
                        
                        <div class="form-group col-md-4 col-sm-6">
                            <input type="text" name="company_name" id="company_name" class="form-control" placeholder="Company Name (As per GST/PAN No):">
                        </div>
                        
                        <div class="form-group col-md-4 col-sm-6">
                            <input type="text" name="company_pan" id="company_pan"maxlength="10" class="form-control" placeholder="Company PAN Number">
                        </div>
                    
                        <div class="form-group col-md-4 col-sm-6">
                            <input type="text" name="gst" id="gst" class="form-control" maxlength="15" placeholder="GST Number">
                        </div>
                        
                        <div class="form-group col-12">
                            <textarea class="form-control" name="address" id="address" placeholder="Address"></textarea>
                        </div>
             
		      		</div>
                    
                    <div class="row">			      			
                        <div class="form-group col-12 mb-4">
                            <p class="blue">Personal Details</p>
                        </div>                        
		      			<div class="form-group col-md-4">
		      				<input type="text" name="contact_name" id="contact_name" onKeyPress="return ValidateAlpha(event);" class="form-control mb-1" placeholder="Contact Name">
		      			</div>                        
                        <div class="form-group col-md-4">
		      				<input type="text" name="contact_number" id="contact_number" maxlength="10" minlength="10" class="form-control Number" placeholder="Contact Number">
						</div>                        
                        <div class="form-group col-md-4">
		      				<input type="text" name="contact_email" id="contact_email" class="form-control" placeholder="Email Id">
		      				<p class="error" id="email"></p>
		      			</div>                        
		      		</div>
		     		
                    <div class="row">                     	
                        <div class="form-group col-12 mb-4">
                            <p class="blue">Password</p>
                        </div>
                        
		      			<div class="form-group col-md-6">
		      				<input type="text" name="password" id="password" class="form-control" placeholder="Password">
						</div>                        
                        <div class="form-group col-md-6">
		      				<input type="text" name="c_password" id="c_password" class="form-control mb-1" placeholder="Confirm Password">
						</div>
                        
		      		</div>
                    
		     		<div class="row">                    
		      			<div class="form-group col-12">
		      				<input type="submit" name="submit" id="submit_btn" value="Register" class="cta fade_anim">
		      				<input type="hidden" name="action" value="vendorReg" />
		      			</div>		      			
		      		</div>		      
		      	</form>
              
		       	<form class="form-horizontal col-12 box-shadow mb-5" id="otp_form">
		      		
                    <div class="row">
                    	 <div class="col-12">
                        	<div class="title_bar mb-3"><h3>Verify OTP Number</h3></div>
                        </div>
                    	<div class="col-12">
                    		<?php if($_SESSION['success_msg'] !==""){ ?>
							<p class="text-success"><?php echo $_SESSION['success_msg']; ?> </p>
                    	<?php } ?>
                    	</div>
                    	
                       
                    	

		      			<!-- <p class="otp_error d-block">Please Check Your email to For OTP Number</p> -->
                        
		      			<div class="form-group col-12">
		      				<div class="resend_email">
		      					<input type="text" name="c_email" id="c_email" class="form-control mb-1" placeholder="Enter Valid Email Id">
		      				</div>
		      			</div>
                        
		      			<div class="form-group otp_number col-12">		      				
                            <input type="text" name="otp_number" id="otp_number" class="form-control mb-1" placeholder="Enter OTP Number">
		      				<p id="otpSend" style="color: green"></p>
		      				<label for="otp_number" generated="true"></label>		      		
		      			</div>
		      			
                        <div class="form-group col-12" >
		      				<input type="submit" name="submit" value="Verify OTP" class="cta d-inline-block " >
		      				<a href="https://gjepc.org/vendor_registration.php?action=resend_otp&param=<?php echo base64_encode($_SESSION['contact_email']);?>" class="cta d-inline-block">Resend OTP</a>
		      				<input type="hidden" name="action" value="otp_form" />
		      			</div>		      		
                    </div>                     
		      </form>              
			</div>            
		</div>        
	</div>    
</section>

<?php include 'include-new/footer.php'; ?>

<?php if($_SESSION['company_name']!="" && $_SESSION['contact_email']!="" ){?>
	<script>
		$("#vendor_reg").fadeOut();
	    $("#otp_form").fadeIn();
	</script>
<?php }else{?>
       <script>
		$("#vendor_reg").fadeIn();
	    $("#otp_form").fadeOut();
	</script>
<?php }?>

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {

		jQuery.validator.addMethod("panno", function (value, element) {
	var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
		if (value.match(regExp) ) {
			return true;
		} else {
			return false;
		};
		},"Please Enter valid PAN No.");
		
	$.validator.addMethod("gstno", function(value, element) {
		var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');
		if (gstinformat.test(value)) {
			return true;
		} else {
			return false;
		}
	},"Please Enter Valid GST Number");
	$("#vendor_reg").validate({
			//var member_id=$("#member_type_id").val();
		rules: {
			
			company_name:
			{
				required:true,
			},
			address:
			{
				required:true,
			},
			company_pan:
			{
				required:true,
				panno: true,
				minlength: 10,
				maxlength:10
			},
			/*gst:
			{
				required:false,
				gstno:true,
				minlength: 15,
				maxlength:15
			},*/
			contact_name:
			{
				required:true,
			},
			contact_number:
			{
				required:true,
			},
			contact_email:
			{
				required:true,
				email: true
			},
			password:
			{
				required:true,
			},
			c_password:
			{
				required:true,
			}	

		},
		messages: {
		
			company_name:{
			required: "Company name is required",
			},
			address:{
			required: "Please provide Address",
			},
			company_pan:{
			required: "Company PAN Number is required ",
			},
			/*gst:{
			required: false,
			},*/
			contact_name:{
			required: "Contact name is required",
			},
			contact_number:{
			required: "Contact number is required",
			},
			contact_email:{
			required: "contact email is required",
			},
			password:{
			required: "Please enter password",
			},
			c_password:{
			required: "Please enter password again",
			}
	
		},
		    submitHandler: ajaxSubmit
        
	});
	$("#otp_form").validate({
			//var member_id=$("#member_type_id").val();
		rules: {
          otp_number:
			{
				required:true,
			},	
			c_email:
			{				
				email:true,
			}	

		},
		messages: {
		
			otp_number:{
			required: "OTP Number is Required",
			},
			c_email:{
				
			email: "Please Enter valid email Address",
			}			
		},
		    submitHandler: ajaxVerifyOTP        
	});
	
});
</script>
<script>
	
	function ajaxSubmit(){
     /*alert("dfgfh");return false;*/
		var formdata = $('#vendor_reg').serialize();
		/*var data = $("#formenquiry").serialize();*/
		$.ajax({
			type:'POST',
			data:formdata,
			url:"vendorAction.php",
			dataType: "json",
			beforeSend:function(){
				$(".customLoader").delay(800).fadeIn();
				$(".loader_wrapper").fadeIn();
			},
			success:function(result){
				
				if(result['status'] == "success"){
					
				  $('#vendor_reg')[0].reset();
                    $("#vendor_reg").fadeOut();
				     $("#otp_form").fadeIn();
                }else if(result['status'] == "notmatch"){
                    swal({
						title: "error",
						icon: "error",
						text: "Passwords are not matched"
					});
                }else if(result['status'] == "emailExist"){
                    swal({
						title: "error",
						icon: "error",
						text: "Email already exist"
					});
                }else if(result['status'] == "panExist"){
                    swal({
						title: "error",
						icon: "error",
						text: "PAN Number already exist"
					});
                }
			}
		});
	}

	function ajaxVerifyOTP(){
		/*alert("dfgfh");return false;*/
		var formdata = $('#otp_form').serialize();
		/*var data = $("#formenquiry").serialize();*/
		$.ajax({
			type:'POST',
			data:formdata,
			url:"vendorAction.php",
			dataType: "json",
			
			success:function(result){
				
				if(result['status'] == "success"){

					$('#otp_form')[0].reset();
                	$("label[for='otp_numbererror']").text("");
					
				  swal({
						title: "success",
						icon: "success",
						text: "OTP MAtched"
					}).then(function() {
                    window.location = "vendor_login.php";
                    });
                   
                }
                else {
                	$("label[for='otp_number']").text("Please Enter valid OTP Number");
                }
			}
		});
	}
/*$(window).load(function() {
     var companyName = $_SESSION['company_name'];
     var contactEmail = $_SESSION['contact_email'];
     alert("Hii");
    });*/
	$(document).ready(function(){
	
      $(document).on("click",".resend",function() {
         $(".resend_email").fadeIn();
         $(".otp_number").fadeOut();
    });
      var companyName = $_SESSION['company_name'];
     var contactEmail = $_SESSION['contact_email'];
     
     $(document).on("blur","#c_email",function() {
      
      
      var email = $("#c_email").val();

       		$.ajax({
			type:'POST',
			data:{email : email},
			url:"vendorAction.php",
			dataType: "json",
			
			success:function(result){
				
				if(result['status'] == "emailSuccess"){

				 /*$("#otpSend").text("OTP Send On Your Email Id Please Check").delay(3000).fadeOut();*/
             
                 $(".otp_number").fadeIn();  
                }else if(result['status'] == "emailFail"){
                	$("#otpSend").text("Please Enter valid email Id").delay(3000).fadeOut();
                }
			}
		});

    });

	
	$('.Number').keypress(function (event) {
    var keycode = event.which;
    if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
        event.preventDefault();
    }
});
});
</script>
<script type="text/javascript">

	function ValidateAlpha(evt)
    {
        var keyCode = (evt.which) ? evt.which : evt.keyCode
        if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)
         
        return false;
            return true;
    }

</script>