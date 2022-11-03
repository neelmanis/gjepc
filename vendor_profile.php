<?php 
include 'include-new/header_vendor.php';
if(!isset($_SESSION['vendorId'])){ header('location:vendor_login.php'); }
include 'db.inc.php';
?>

<style>
	.info_table{border:1px solid #dcd1d1;border-top: 0px solid #000;position:relative;}
	.info_table table{margin-bottom: 0px;}
	.edit_panel{position: absolute;
top: -14px;
right: 37px;
z-index: 999;
background: #fff;cursor: pointer}
.fa-pencil-square-o{font-size: 35px;color: #86265f}
.info_table table tbody tr th:first-child{border-right:1px solid#ddd;font-size: 15px; font-weight: bold;}
.info_table table tbody tr th{padding:14px 14px;}
.mt-5{margin-top: 50px;}
.mt-4{margin-top: 40px;}
.mt-3{margin-top: 30px;}
.mt-2{margin-top: 20px;}
.mb-4{margin-bottom: 40px;}
.edit_profile{border: 1px solid #dcd1d1;padding: 14px; display: none;}
.form-control{border-radius: 0px;}
.btn-submit{background: #9c1658;color: #fff; font-weight: 400;font-size: 15px;}
.btn-submit:hover{color: #fff}
.error{color:#e62323!important; font-size: 14px!important;}
</style>
<div class=" container-fluid">
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="title">
				<h4> Dashboard </h4>
				<!-- <h4><?php echo $_SESSION['vendorId'];?> Dashboard </h4> -->
			</div>
		</div>
	</div>
	<div class="row mb-5 mt-3">
		<div class="col-md-4 col-sm-4 col-xs-12 wrapper selectedSpeaker">
			<?php include 'include/vendor_menu.php'; ?>
		</div>
		<div class="col-md-8 col-sm-8 col-xs-12 speakerSelector">
	<div class="panel_info" id="panel_info">
		<a class="edit_panel" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
		<div class="info_table">
			<?php 
    $vendorId = $_SESSION['vendorId'];
    $vendorData= $conn ->query("SELECT * FROM vendor_registration WHERE id='$vendorId'");  
    $row = $vendorData->fetch_assoc();
    $company_name = filter($row['company_name']);
	$address = filter($row['address']);
	$company_pan = $row['company_pan'];
	$gst = $row['gst'];
	$contact_number = $row['contact_number'];
	$contact_email = $row['contact_email'];	
	$isMsme = $row['isMsme'];	
	$msme_no = $row['msme_no'];	
	?>
			<table class="table ">
				
				<tbody>
					<tr>
						<th>Company Name</th>
						<th><?php echo $company_name;?></th>							
						</tr>
						<tr>
							<th>Address</th>
							<th><?php echo $address;?></th>									
						</tr>
						<tr>
							<th>Company Pan No</th>
							<th><?php echo $company_pan;?></th>
						</tr>
						<tr>
						<th>GST  No</th>
						<th><?php echo $gst;?></th>
						</tr>
						<tr>
						<th>Contact Number</th>
						<th><?php echo $contact_number;?></th>
						</tr>
						<tr>
						<th>MSME Number</th>
						<th><?php echo $msme_no;?></th>
						</tr>
						<tr>
						<th>Contact Email</th>
						<th><a href="mailto:<?php echo $contact_email;?>"><?php echo $contact_email;?></a></th>
						</tr>
						</tbody>
						</table>
						</div>
						</div>


								<div class="edit_profile">
									<div class="text-right"><a class="view_profile btn cta text-light ">View Details</a></div>
									<form class="form-horizontal" id="profile_update">
										<div class="form-group mt-3">
											
												<div class="col-md-6">
												<label >Company Name:</label>

												</div>
												<div class="col-md-6">
													<input type="text" name="company_name" readonly class="form-control" value="<?php echo $company_name;?>">

												</div>
												<div class="clearfix"></div>
											
										</div>
										<div class="form-group mt-3">
											
												<div class="col-md-6">
												<label >Address:</label>

												</div>
												<div class="col-md-6">
													<textarea class="form-control" name="address" id="address" rows="6"><?php echo $address;?></textarea>

												</div>
												<div class="clearfix"></div>
											
										</div>
										<div class="form-group mt-3">
											
												<div class="col-md-6">
												<label >Company Pan No:</label>

												</div>
												<div class="col-md-6">
													<input type="text" name="company_pan" readonly id="company_pan" class="form-control" maxlength="10" value="<?php echo $company_pan;?>">

												</div>
												<div class="clearfix"></div>
											
										</div>
										<div class="form-group mt-3">
											
												<div class="col-md-6">
												<label >Is your company MSME:</label>

												</div>
												<div class="col-md-6">
													<label><input type="radio" class="isMsme" <?php if($isMsme =="yes"){ echo "checked"; }?> name="isMsme" readonly id="isMsme1"  value="yes" value="<?php echo $isMsme;?>">Yes</label>
													<label><input type="radio" class="isMsme" <?php if($isMsme =="no"){ echo "checked"; }?> name="isMsme" readonly id="isMsme1" value="no"  value="<?php echo $isMsme;?>">No</label>

												</div>
												<div class="col-md-6">
													<label for="isMsme" generated="true" class="error" style="display: none;">Select yes if MSME approved</label>
												</div>
												<div class="clearfix"></div>
											
										</div>
										<div class="form-group mt-3" id="msme_no_div">
											
												<div class="col-md-6">
												<label >MSME No:</label>

												</div>
												<div class="col-md-6">
													<input type="text" name="msme_no" id="msme_no"  class="form-control" maxlength="15" value="<?php echo $msme_no;?>">

												</div>
												<div class="clearfix"></div>
											
										</div>
										<div class="form-group mt-3">
											
												<div class="col-md-6">
												<label >GST No:</label>

												</div>
												<div class="col-md-6">
													<input type="text" name="gst" id="gst" readonly class="form-control" maxlength="15" value="<?php echo $gst;?>">

												</div>
												<div class="clearfix"></div>
											
										</div>
										
										<div class="form-group mt-3">
											
												<div class="col-md-6">
												<label >Contact No:</label>

												</div>
												<div class="col-md-6">
													<input type="text" name="contact_number" id="contact_number" class="form-control Number" maxlength="10" value="<?php echo $contact_number;?>">

												</div>
												<div class="clearfix"></div>
											
										</div>
										<div class="form-group mt-3">
											
												<div class="col-md-6">
												<label >Contact Email:</label>

												</div>
												<div class="col-md-6">
													<input type="text" name="contact_email" id="contact_email" class="form-control" value="<?php echo $contact_email;?>">

												</div>
												<div class="clearfix"></div>
											
										</div>
										<div class="form-group mt-3">
											
												<div class="col-md-6">
													<input type="submit" name="submit" value="update" class="btn btn-submit">
													<input type="reset" name="reset" value="reset" class="btn btn-primary">
		      				                        <input type="hidden" name="action" value="profile_update" />
		      				                        <input type="hidden" name="vendorId" value="<?php echo $vendorId;?>" />

												</div>
												<div class="clearfix"></div>
											
										</div>
									</form>
								</div>
							</div>
	</div>
</div>





							
				<?php include 'include-new/footer.php'; ?>
		        <script>
		            function redirectProfile() {
                    setTimeout(function(){
                     window.location = "vendor_profile.php"; 
                 }, 1000);
				}
					function ajaxUpdate(){
		
					var formdata = $('#profile_update').serialize();
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
						text: " Your Profile  Updated"
					});
					redirectProfile();		                 
						
			                }
						}
					});
				}
				$(document).ready(function(){

					$(".isMsme").on("click", function(){
						let isMsme = $(this).val();
						if(isMsme =="yes"){
                         $("#msme_no_div").slideDown();
                         $("#msme_no").attr("disabled",false);
						}else{
                         $("#msme_no_div").slideUp();
                         $("#msme_no").attr("disabled",true);

						}
					});
				$('.fa-pencil-square-o').on("click", function() {
				$(this).fadeOut();
				$(".panel_info").fadeOut();
				$(".edit_profile").fadeIn();
				
				});
				$('.view_profile').on("click", function() {
				$(".edit_profile").fadeOut();
				$(".panel_info").fadeIn();
				$('.fa-pencil-square-o').fadeIn();
			
				
				});
				$('.Number').keypress(function (event) {
    var keycode = event.which;
    if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
        event.preventDefault();
    }
});
				
				});
				</script>
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
	$("#profile_update").validate({
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
			isMsme:
			{
				required:true,
			},
			msme_no:
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
				required:true,
			    gstno:true,
				minlength: 15,
				maxlength:15
			},*/
		
			contact_number:
			{
				required:true,
			},
			contact_email:
			{
				required:true,
				email: true
			}

		},
		messages: {		
			company_name:{
			required: "Company name is required",
			},
			address:{
			required: "Please provide Address",
			},
			isMsme:
			{
				required:"Select yes if MSME approved",
			},
			msme_no:
			{
				required:"Enter MSME number",
			},
			company_pan:{
			required: "Company PAN Number is required ",
			},		
			contact_number:{
			required: "Contact number is required",
			},
			contact_email:{
			required: "contact email is required",
			}	
		},
		    submitHandler: ajaxUpdate        
	});
	
});
</script>