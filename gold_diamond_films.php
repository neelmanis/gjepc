<?php include 'include/header.php'; ?>
<?php
include 'db.inc.php';
$video=$_REQUEST['video'];
$action=$_REQUEST['action'];
if($action=="save")
{
	$video=$_POST['video'];
	$name=$_POST['name'];
	$designation=$_POST['designation'];
	$company_name=$_POST['company_name'];
	$address=$_POST['address'];
	$city=$_POST['city'];
	$email=$_POST['email'];
	$select_video_usages=$_POST['select_video_usages'];
	$other=$_POST['other'];
	$mobile=$_POST['mobile'];
	$post_date=date('Y-m-d');
	
	if(mysql_query("insert into gjepclivedatabase.gdfilm_enquiry set name='$name',designation='$designation',company_name='$company_name',address='$address',city='$city',email='$email',select_video_usages='$select_video_usages',other='$other',mobile='$mobile',post_date='$post_date'")){
		$_SESSION['succ_msg']="Thank you for downloading the video";
	}else{
		$_SESSION['err_msg']="There is some technical problem";
	}
}
?>
<?php 
if($_SESSION['err_msg']!=""){
echo "<div class='text-center'><span style='color: red;'>".$_SESSION['err_msg']."</span></div>";
$_SESSION['err_msg']="";
}
if($_SESSION['succ_msg']!=""){
	echo "<div class='text-center py-5'><span style='color: green;'>".$_SESSION['succ_msg']."</span></div>";
	$_SESSION['succ_msg']="";
?>	
<script type="text/javascript">
	var x = "<?php echo"$video"?>";
	window.open("https://gjepc.org/assets/images/video/films/"+x, "_blank");
</script>
 <?php }?>
<section>
    <div class="container-fluid inner_container">
    
        <div class="row justify-content-center grey_title_bg">
            	<div class="innerpg_title_center">
                	<h1> Gold & Diamond Films</h1>
                </div>
         </div>
         
        
        <div class="container p-0">
        <div class="loaderWrapper" style="display:none;">
            	<div class="formLoader"> <img src="images/formloader.gif" alt=""> <p> Please Wait....</p> </div>
            </div>
        	<div class="row justify-content-center mb-5">
            	
                <!--<form action="" method="post" name="loginproject" id="regisForm" class="col-lg-10 box-shadow">-->
                <form class="cmxform col-lg-10 box-shadow" method="post" name="regisForm" id="regisForm" autocomplete="off">
                <input type="hidden" name="action" value="save"/>
                <input type="hidden" name="video" id="video" value="<?php echo $video;?>"/>                
                	<div class="row">
                        <div class="form-group col-md-4">
							<input type="text" class="form-control" name="name" id="name" placeholder="Name" autocomplete="off">
						</div>
						<div class="form-group col-md-4">
							<input type="text" class="form-control" name="designation" id="designation" autocomplete="off" placeholder="Designation">
						</div>
                        
						<div class="form-group col-md-4">
							<input type="text" class="form-control" name="company_name" id="company_name" autocomplete="off" placeholder="Company name">
						</div>
                        
                        <div class="form-group col-md-6">
							<input type="text" class="form-control" name="address" id="address" autocomplete="off" placeholder="Address">
						</div>
                        
                        <div class="form-group col-md-6">
							<input type="text" class="form-control" name="city" id="city" autocomplete="off" placeholder="City">
						</div>
                        
                        <div class="form-group col-md-6">
							<input type="text" class="form-control" name="email" id="email" autocomplete="off" placeholder="Email ID">
						</div>
                        
                        <div class="form-group col-md-6">
							<select class="form-control" id="select_video_usages" name="select_video_usages">
                            	<option value="">--Select Video usage--</option>
                                <option value="Social media">Social media</option>
                                <option value="In-store promotion">In-store promotion </option>
                                <option value="In cinema promotion">In cinema promotion </option>
                                <option value="TV advertisement">TV advertisement</option>
                                <option value="WhatsApp circulation"> WhatsApp circulation</option>
                                <option value="other">other</option>
                            </select>
						</div>
                         
                         <div class="form-group col-md-6">
							<input type="text" class="form-control" name="other" id="other" autocomplete="off" placeholder="Other">
						</div>
                        
						<div class="form-group col-md-6">
                        	<div class="d-flex">
							<input type="text" class="form-control" name="mobile" id="mobile" autocomplete="off" placeholder="Mobile No" style="margin-right:10px;" maxlength="10">
                            <label style="white-space: nowrap; cursor: pointer; background: #f1f1f1; font-size: 13px; padding: 0 10px; height: 40px; line-height: 40px;" id="generate_otp">Generate OTP</label>
                            
                            </div>
						</div>
                        
                        
                        <div class="form-group col-md-6 " >
                        <div class="d-flex">
						<input type="text" class="form-control" name="otp_number" id="otp_number" autocomplete="off" placeholder="Enter OTP" style="margin-right:10px;">
                        <label style="white-space: nowrap; cursor: pointer; background: #f1f1f1; font-size: 13px; padding: 0 10px; height: 40px; line-height: 40px;" id="verify_otp">Verify OTP</label>
                        </div>
						</div>
                        
                        <div class="form-group col-12">
                        <div style="font-size:12px; font-style:italic;">
                        <p><strong> Disclaimer : </strong> Please note the copyrights including the intellectual property rights and ownership of these videos solely and exclusively belongs to GJEPC. Users are ONLY authorized to personalize the last slide of these videos with their company name and /or logo along with their details. Nothing else apart from this in the videos as downloaded by the authorized Users can be modified under any circumstances. Any unauthorized use or sharing of these videos will result into breach of this disclaimer and further will be considered as infringement of the copyrights and other intellectual property rights under the provisions of the relevant statute. GJEPC will be constrained to take legal action against such users both civil and criminal, at your entire risk, costs and consequences.</p>
                        
                        <p><strong> FOR ANY QUERY Contact – </strong> <a href="mailto:ajay.kumar@gjepcindia.com">ajay.kumar@gjepcindia.com</a> </p>
                        </div>
                        </div>
                         
                        
                        <div class="form-group col-12">
   							<div style="margin-left:20px;">
    						<input type="checkbox" class="form-check-input" id="tandc" name="tandc">
    						<label class="form-check-label" for="exampleCheck1">I agree</label>
                            </div>
  						</div>
                        
                        <div class="form-group col-12">				
							<button type="submit" class="cta fade_anim" value="Submit" name="submit" id="submit" >Submit</button>
						</div>
                        </div>
                    </form> 
            </div>
        </div>
        </div>
    </div>
</section>


<?php include 'include/footer.php'; ?>

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	jQuery.validator.addMethod("specialChrs", function (value, element) {
		if (/[^a-zA-Z 0-9\-]+$/i.test(value)) {
			return false;
		} else {
			return true;
		};
	},"Special Characters Not Allowed");
	
	$("#regisForm").validate({
		rules: {  
			name: {
				required: true,
				specialChrs: true
			},
			designation: {
				required: true,
				specialChrs: true
			},
			company_name: {
				required: true,
				specialChrs: true
			},
			address: {
				required: true,
			},
			city: {
				required: true,
				specialChrs: true
			},
			email: {
				required: true,
				email:true
			},
			select_video_usages: {
				required: true,
			},  
			mobile: {
				required: true,
				number:true,
				minlength: 10,
				maxlength:10
				},
			otp_number:{
				required:true,
				number:true
			},
			tandc: {
				required: true,
				},
		},
		messages: {
			name: {
				required: "Please enter your name",
			},
			designation: {
				required: "Please enter your designaiton",
			},    
			company_name: {
				required: "Please enter company name",
			}, 
			address: {
				required: "Enter your address",
			},  
			city: "Please enter your city name",
			email: {
				required: "Please enter a valid email id",
			},
			select_video_usages:"Required",
			mobile: {
				required:"Please enter mobile number",
				number:"Please enter numbers only",
				minlength:"Please enter at least {10} digit.",
				maxlength:"Please enter no more than {0} digit."
			},
			otp_number:{
				required:"Please enter otp",
				number:"Otp should be numebr only"
			},
			tandc: {
				required: "Please Select",
			} 
	 }
	});
	
	/*.............................Send Otp.................................*/
	  $('#generate_otp').click(function(){
			var mobile_no=$('#mobile').val();
				$.ajax({
					type:'POST',
					data:'actiontype=send_otp&mobile_no='+mobile_no,
					url:'ajax_gdfilm.php',
					dataType: 'json',
				beforeSend: function(){
					$('.loaderWrapper').show();
				},
				success:function(data){
					$('.loaderWrapper').hide();
					if(data['status']=="success"){
						$('#submit').attr( disabled, disabled );
						alert("Verified");
					}			
				}
			  });
	  });
	  
	  /*.............................Verify Otp.................................*/
	  $('#verify_otp').click(function(){
		var mobile_no=$('#mobile').val();
		var otp_number=$('#otp_number').val();
				$.ajax({
					type:'POST',
					data:'actiontype=verify_otp&otp_number='+otp_number+'&mobile_no='+mobile_no,
					url:'ajax_gdfilm.php',
					dataType: 'json',
				beforeSend: function(){
					$('.loaderWrapper').show();
				},
				success:function(data){
					$('.loaderWrapper').hide();
					if(data['status']=="success"){
						$('#verify_otp').hide();
						$('#submit').removeAttr("disabled", "disabled");
					}			
				}
			});
	  });
	  
 });
</script>