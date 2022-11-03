<?php include 'include/header_aid_relief.php'; ?>
<?php
include 'db.inc.php';
include 'functions.php';
//echo $_SESSION['getMobile_no'];
if(isset($_SESSION['getMobile_no'])){  $getMobile_no = $_SESSION['getMobile_no'];   } else { header('location:relief-aid-applications-form.php'); }

$action=$_REQUEST['action'];
if($action=="save")
{
	function uploadReliefImage($file_name,$file_temp,$file_type,$file_size,$getMobile_no,$attach)
	{
		$upload_image = '';
		$target_folder = 'relief/'.$attach.'/';
		$target_path = "";
		$file_name = str_replace(" ","_",$file_name);
		
		if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
		echo "Sorry something error while uploading..."; exit;
		}
		else if($file_name != '')
		{
			if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf")) && $file_size < 2097152)
			{
				$random_name = rand();
				$target_path = $target_folder.$getMobile_no.'_'.$attach.'_'.$random_name.$file_name;
				if(@move_uploaded_file($file_temp, $target_path))
				{
					$upload_image = $getMobile_no.'_'.$attach.'_'.$random_name.$file_name;
				} else	{
					echo "Sorry error while uploading";
				}
			} else
			{
				echo "Invalid file";
			}	
		}		
		return $upload_image;
	}
	
	$uid = base64_decode($_POST['uid']);
	$getMobile_no = $_SESSION['getMobile_no'];
	$bank_name   = strtoupper(filter($_REQUEST['bank_name']));
	$bank_branch = strtoupper(filter($_REQUEST['bank_branch']));
	$bank_ifsc   = strtoupper(filter($_REQUEST['bank_ifsc']));
	$bank_account_no = filter($_REQUEST['bank_account_no']);
	
	if(isset($_FILES['upload_bank_passbook']) && $_FILES['upload_bank_passbook']['name']!="")
	{
		/* Passbook picture */
		$photo_name=$_FILES['upload_bank_passbook']['name'];
		$photo_temp=$_FILES['upload_bank_passbook']['tmp_name'];
		$photo_type=$_FILES['upload_bank_passbook']['type'];
		$photo_size=$_FILES['upload_bank_passbook']['size'];
		$attach="passbook";
		if($photo_name!="")
		{
			$create_photo = 'relief/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			$passbook=uploadReliefImage($photo_name,$photo_temp,$photo_type,$photo_size,$getMobile_no,$attach);
		}
	}
	
	if(isset($_FILES['statement_1']) && $_FILES['statement_1']['name']!="")
	{
		/* statement_1 picture */
		$photo_name=$_FILES['statement_1']['name'];
		$photo_temp=$_FILES['statement_1']['tmp_name'];
		$photo_type=$_FILES['statement_1']['type'];
		$photo_size=$_FILES['statement_1']['size'];
		$attach="statement_1";
		if($photo_name!="")
		{
			$create_photo = 'relief/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			$statement_1 = uploadReliefImage($photo_name,$photo_temp,$photo_type,$photo_size,$getMobile_no,$attach);
		}
	}
	
	if(isset($_FILES['statement_2']) && $_FILES['statement_2']['name']!="")
	{
		/* statement_2 picture */
		$photo_name=$_FILES['statement_2']['name'];
		$photo_temp=$_FILES['statement_2']['tmp_name'];
		$photo_type=$_FILES['statement_2']['type'];
		$photo_size=$_FILES['statement_2']['size'];
		$attach="statement_2";
		if($photo_name!="")
		{
			$create_photo = 'relief/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			$statement_2 = uploadReliefImage($photo_name,$photo_temp,$photo_type,$photo_size,$getMobile_no,$attach);
		}
	}
	
	if(isset($_FILES['statement_3']) && $_FILES['statement_3']['name']!="")
	{
		/* statement_3 picture */
		$photo_name=$_FILES['statement_3']['name'];
		$photo_temp=$_FILES['statement_3']['tmp_name'];
		$photo_type=$_FILES['statement_3']['type'];
		$photo_size=$_FILES['statement_3']['size'];
		$attach="statement_3";
		if($photo_name!="")
		{
			$create_photo = 'relief/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			$statement_3 = uploadReliefImage($photo_name,$photo_temp,$photo_type,$photo_size,$getMobile_no,$attach);
		}
	}
	
if(empty($bank_name))
{ $signup_error = "Please Enter Bank Name";}
elseif(empty($bank_branch))
{ $signup_error = "Please Enter Bank Branch";}
elseif(empty($bank_ifsc))
{ $signup_error = "Please Enter Bank IFSC code";}
elseif(empty($bank_account_no))
{ $signup_error = "Please Enter Bank Account No";}
elseif(empty($passbook) || empty($statement_1))
{ $signup_error="Please Upload the required Document";}
else
{
	$sqlCheck = "SELECT * FROM `relief_aid` WHERE `mobile_no`='$getMobile_no' LIMIT 1";
    $resultCheck = $conn ->query($sqlCheck);
    $countCheck = $resultCheck->num_rows;
    if($countCheck>0)
	{
		$sql1="UPDATE `relief_aid` SET `mod_date`=NOW(),`bank_name`='$bank_name',`bank_branch`='$bank_branch',`bank_ifsc`='$bank_ifsc',`bank_account_no`='$bank_account_no',`upload_bank_passbook`='$passbook',statement_1='$statement_1',isApplied='N'";
		if(isset($statement_2) && $statement_2!='')
		$sql1.=",`statement_2`='$statement_2'";
		if(isset($statement_3) && $statement_3!='')
		$sql1.=",`statement_3`='$statement_3'";
		$sql1.=" WHERE mobile_no='$getMobile_no' limit 1"; 
		$resultx = $conn ->query($sql1);
		if($resultx){
			unset($_SESSION['getMobile_no']); 
			$signup_success = "Your applicaiton has been updated successfully"; 
			header("Refresh: 3; url=https://gjepc.org/relief-aid-applications-form.php");
		} else { $_SESSION['err_msg']="Something went wrong"; }
	} else {
		$_SESSION['err_msg'] = "Something went wrong Contact Admin !!!";
	}
}
}
?>
			<?php
			$smx = "SELECT * FROM relief_aid where mobile_no=$getMobile_no";
			$result2 = $conn ->query($smx);
			$row2 = $result2->fetch_assoc();
	
			$uid=filter($row2['id']);
			$worker_type=filter($row2['worker_type']);
			$fname=filter($row2['fname']);
			$father_name=filter($row2['father_name']);
			$gender=filter($row2['gender']);
			$birth_date=filter($row2['birthdate']);
			$address=filter($row2['address']);
			$city=filter($row2['city']);
			$state=filter($row2['state']);
			$pincode=filter($row2['pincode']);

			$mobile_no=filter($row2['mobile_no']);
			$otpVerified=filter($row2['otpVerified']);
			$email=filter($row2['email']);	
			$owner_name1=filter($row2['owner_name1']);
			$owner_mobile1=filter($row2['owner_mobile1']);					
			$owner_name2=filter($row2['owner_name2']);			
			$owner_mobile2=filter($row2['owner_mobile2']);
			
			$industry_type=filter($row2['industry_type']);
			$nature_work=$row2['nature_work'];
			
			$member_of_any_other_organisation=filter($row2['member_of_any_other_organisation']);
			$name_of_organisation=filter($row2['name_of_organisation']);
			$bank_name=filter($row2['bank_name']);
			$bank_branch=filter($row2['bank_branch']);
			$bank_ifsc=filter($row2['bank_ifsc']);
			$bank_account_no=filter($row2['bank_account_no']);
			$aadhar_no=filter($row2['aadhar_no']);
			$parichay_card_no=filter($row2['parichay_card_no']);	
			?>
<?php
if($_SESSION['err_msg']!=""){
echo "<div class='text-center'><span style='color: red;'>".$_SESSION['err_msg']."</span></div>";
$_SESSION['err_msg']="";
}
?>

<section>	
    <div class="container-fluid inner_container">
		<div class="row justify-content-center grey_title_bg">           	
            	<div class="innerpg_title_center">
                	<h1>GJEPC- Relief Aid Applications Form  </h1>
                </div>            
         </div>
                    
            <div class="container">				
                <div class="row justify-content-center">
                            
                <form class="cmxform col-12 box-shadow mb-5" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="regisForm" id="regisForm" enctype="multipart/form-data" autocomplete="off" >
				<input type="hidden" name="action" value="save"/>	
				<?php token(); ?>	
				<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>';} ?>
				<?php if(isset($signup_success)){ echo '<div class="alert alert-success" role="alert">'.$signup_success.'</div>';} ?>
				
				<div class="d-md-flex justify-content-between mb-5">
                <div><p class="mt-2"><strong>*Benefits only applicable to Daily Wage Worker whose monthly income is Rs. 15,000 or below</strong></p></div>
                </div>
                    <div class="row mb-4">                    
                                            
                        <div class="form-group col-sm-6">
                            <label for="company_name">Are You Daily Wages Worker? </label><b> : <?php echo $worker_type;?></b>
                        </div>            
                                                        
                        <div class="form-group col-sm-6">
							<label for="fname">Full Name</label> <b> : <?php echo $fname; ?></b>
                        </div>                            
                            
                        <div class="form-group col-sm-6">
                            <label for="father_name">Fathers Name or Son of / Daughter of </label> <b> : <?php echo $father_name; ?></b>
						</div>
                        
                        <div class="form-group col-sm-6">
                            <label for="gender">Gender</label> <b> : <?php if($gender=='M'){ echo 'Male'; } else { echo 'Female'; } ?> </b>
                        </div>                        
                        
                        <div class="form-group col-sm-6">
                            <label for="date">Birth Date </label> <b> : <?php echo $birth_date; ?></b>
                        </div>                               
                        
                        <div class="form-group col-sm-6">
                        <label for="mobile_no">Mobile No </label> <b> : <?php echo $mobile_no; ?></b>
                        </div>  
                        
                        <div class="form-group col-sm-6">
                        <label for="email_id">Email ID </label> <b> : <?php echo $email;?> </b>
                        </div> 
                        <div class="form-group col-12">
                        <label for="city">Address </label> <b> : <?php echo $address; ?> <?php echo $city; ?> <?php echo filter(strtoupper(getState($state,$conn)));?> - <?php echo $pincode; ?></b>
                        </div>         
              </div>
              
                        <div class="row mb-4">     
                        
                        	<div class="form-group col-12 mb-4">
                            	<p class="blue">Industry Reference and Association Details</p>
                        	</div>                                
                            <div class="form-group col-sm-6">
                                <label for="owner_name1">Owner / Contractor / Head Karigar Name-1 </label> <b> : <?php echo $owner_name1;?></b>
                            </div>                            
                            <div class="form-group col-sm-6">
                                <label for="owner_mobile1">Owner / Contractor / Head Karigar Mobile-1 </label> <b> : <?php echo $owner_mobile1;?></b>
                            </div>  						
                            <div class="form-group col-sm-6">
                                <label for="owner_name2">Owner / Contractor / Head Karigar Name-2 (Optional)</label> <b> : <?php echo $owner_name2;?></b>
                            </div>                            
                            <div class="form-group col-sm-6">
                                <label for="owner_mobile2">Owner / Contractor / Head Karigar Mobile-2 (optional)</label> <b> : <?php echo $owner_mobile2;?></b>
                            </div> 
                            
                            <div class="form-group col-sm-6">
                                <label for="company_name">Industry Type </label> <b> : <?php if($industry_type=="Diamonds"){ echo "Diamonds"; } if($industry_type=="Gemstone"){ echo "Gemstone"; } if($industry_type=="Jewellery"){ echo "Jewellery"; } ?> </b>
                            </div>
                        
                        	<div class="form-group col-sm-6">
                                <label for="nature_work">Nature / Type of Work </label> <b> : <?php echo $nature_work;?></b>
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="company_name">Member of Any Registered Association</label>
								 <b> : <?php if($member_of_any_other_organisation=='YES'){ echo "Yes"; } else  { echo 'No'; } ?> </b>
                            </div>
                                              
                     		<div class="form-group col-sm-6" id="organisation_name">
                                <label for="name_of_organisation">Name of Registered Association</label><b> : <?php echo $name_of_organisation;?> </b>
                            </div>
                     	
                        </div>
                        
                        <div class="row mb-4">     
                        
                        	<div class="form-group col-12 mb-4">
                            	<p class="blue">Bank Details of Beneficiary (Worker/Karigar) </p>                               
                        	</div>               
                                
                            <div class="form-group col-sm-6">
                            <label for="bank_name">Bank Name <span>*</span></label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name" value="<?php echo $bank_name;?>" maxlength="40" autocomplete="off" >
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="bank_branch">Bank Branch Address <span>*</span></label>
                                <input type="text" class="form-control" id="bank_branch" name="bank_branch" value="<?php echo $bank_branch;?>" maxlength="40" autocomplete="off">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="bank_ifsc">IFSC Code <span>*</span></label>
                                <input type="text" class="form-control ifsc" id="bank_ifsc" name="bank_ifsc" value="<?php echo $bank_ifsc;?>" maxlength="40" autocomplete="off">
                            </div>                        
                        	
                            <div class="form-group col-sm-6">
                            <label for="bank_account_no">Bank Account Number <span>*</span></label>
                            <input type="text" class="form-control numeric" id="bank_account_no" name="bank_account_no" value="<?php echo $bank_account_no;?>" maxlength="40" autocomplete="off" >
                            </div>
                            
                            <div class="form-group col-sm-6">
                            <label for="Passbook">Upload Photo of Passbook (from 1st September 2019 till 28 Feb 2020) <span>*</span>(Upload only .jpeg,.jpg,.pdf format files)</label>
                            <input type="file" id="upload_bank_passbook" name="upload_bank_passbook" class="form-control" autocomplete="off">
                            </div>
							
							<div class="form-group col-sm-6">
                            <label for="Passbook">Upload Photo of Passbook Statement 1 <span>*</span>(Upload only .jpeg,.jpg,.pdf format files)</label>
                            <input type="file" id="statement_1" name="statement_1" class="form-control" autocomplete="off">
                            </div>
							
							<div class="form-group col-sm-6">
                            <label for="Passbook">Upload Photo of Passbook Statement 2 (Upload only .jpeg,.jpg,.pdf format files)</label>
                            <input type="file" id="statement_2" name="statement_2" class="form-control" autocomplete="off">
                            </div>
							
							<div class="form-group col-sm-6">
                            <label for="Passbook">Upload Photo of Passbook Statement 3 (Upload only .jpeg,.jpg,.pdf format files)</label>
                            <input type="file" id="statement_3" name="statement_3" class="form-control" autocomplete="off">
                            </div>
                            
                        </div>
                        
                        <div class="row">                        
                        	<div class="form-group col-12 mb-4"><p class="blue">Identity Details of Karagir</p></div>                                
                            <div class="form-group col-sm-6">
                            <label for="aadhar_no">Aadhar Card Number </label> <b> : <?php echo $aadhar_no;?></b>
                            </div>                   			
                            <div class="form-group col-sm-6">
                            <label for="parichay_card_no">GJEPC Parichay Card Number</label> <b> : <?php echo $parichay_card_no;?></b>
                            </div>                       	
                        </div>                        
              
              			<div class="form-group">
							<input type="hidden" id="uid" name="uid" value="<?php echo base64_encode($uid);?>">
                      		<button type="submit" id='submit' class="cta fade_anim">Submit</button>
							<span class="otp-messages" style='color: green;'></span>
                        </div>     
					
                    </form>
                                    
                </div>  
                          
            </div>    
	</div>    
    </div>
</section> 

</div>
<?php include 'include/footer_aid_relief.php'; ?>

<style>
@media (max-width:600px) {
header, footer {display:none;}
}
.custom-file-label::after {height:38px; padding:0; line-height:38px; width:60px; text-align:center;}
</style>
<script>
$('.numeric').keypress(function (event) {
  var keycode = event.which;
  if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
  {
    event.preventDefault();
  }
});

$(function(){
    $(".ifsc").bind('keypress',function(e){
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) return true;
        e.preventDefault();
        return false;
    });
});
</script>
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready(function() {
	jQuery.validator.addMethod("specialChrs", function (value, element) {
	if (/[^a-zA-Z 0-9\-]+$/i.test(value)) {
        return false;
    } else {
        return true;
   };
   },	"Special Characters Not Allowed");
   
	$("#regisForm").validate({
		rules: {			
			bank_name:{
				required: true,
			},
			bank_branch:{
				required: true,
			},
			bank_ifsc:{
				required: true,
			},
			bank_account_no:{
				required: true,
			},
			upload_bank_passbook:{
				required: true,
			},
			statement_1:{
				required: true,
			}			
		},
		messages: {			
			bank_name: {
				required: "This is required.",
			},
			bank_branch: {
				required: "This is required.",
			},
			bank_ifsc: {
				required: "This is required.",
			},
			bank_account_no: {
				required: "This is required.",
			},
			upload_bank_passbook: {
				required: "This is required.",
			},
			statement_1: {
				required: "This is required.",
			}
		}
	});
	
		$('#regisForm input').on('keyup blur', function () {
        if ($('#regisForm').valid()) {
		//	$(".loading").show();
			$("#regisForm").on("submit",function(e){
				$(".otp-messages").text("Please wait your data is submitting.....").show();
				$("#submit").hide();
			})
		//	$(".loading").delay(1000).fadeOut("slow");
         //  $("#button1").removeClass("submit");
           //TRIGGER FORM 
         //$('#regisForm').submit();
        }
    });
});


// language
function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage:'en',includedLanguages:'hi,en,gu,mr,bn,ml,ta,te,kn',layout:google.translate.TranslateElement.InlineLayout.SIMPLE },'google_translate_element');}
$(window).bind("load",function(){$("span:first",".goog-te-menu-value").text('English');})
</script>
<script type="text/javascript">
$(document).ready(function () {
    //Disable cut copy paste
    $('body').bind('cut copy paste', function (e) {
        e.preventDefault();
    });
   
    //Disable mouse right click
    $("body").on("contextmenu",function(e){
        return false;
    });
});
</script>