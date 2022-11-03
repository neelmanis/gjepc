<?php include 'include-new/header.php'; ?>
<?php
header("Location: https://gjepc.org/");
include 'db.inc.php';
include 'functions.php';
$action=$_REQUEST['action'];
if($action=="save")
{
	//validate Token
//	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	function uploadReliefImage($file_name,$file_temp,$file_type,$file_size,$mobile,$attach)
	{
		$upload_image = '';
		$target_folder = 'relief/'.$attach.'/';
		$target_path = "";
		$file_name = str_replace(" ","_",$file_name);
		$file_name = filter($file_name);
		
		if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
		echo "Sorry something error while uploading..."; exit;
		}
		else if($file_name != '')
		{
			if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf")) && $file_size < 2097152)
			{
				$random_name = rand();
				$target_path = $target_folder.$mobile.'_'.$attach.'_'.$random_name.$file_name;
				if(@move_uploaded_file($file_temp, $target_path))
				{
					$upload_image = $mobile.'_'.$attach.'_'.$random_name.$file_name;
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
	
	$worker_type	=	filter($_REQUEST['worker_type']);	
	$fname			=	strtoupper(filter($_REQUEST['fname']));
	$father_name	=	strtoupper($_REQUEST['father_name']);
	$gender			=	strtoupper(filter($_REQUEST['gender']));
	$birth_date		=	filter($_REQUEST['birth_date']);
	$address		=	strtoupper(filter($_REQUEST['address']));
	$city			=	strtoupper(filter($_REQUEST['city']));
	$state			=	filter($_REQUEST['state']);
	$pin_code		=	filter($_REQUEST['pin_code']);
	
	$mobile 		=   filter($_REQUEST['mobile_no']);
	$email_id		=	filter($_REQUEST['email_id']);
	
	$owner_name1		=	htmlspecialchars($_REQUEST['owner_name1']);
	$owner_mobile1		=	filter($_REQUEST['owner_mobile1']);
	$owner_name2		=	filter($_REQUEST['owner_name2']);
	$owner_mobile2		=	filter($_REQUEST['owner_mobile2']);
	
	$industry_type		=	filter($_REQUEST['industry_type']);
	$nature_work		=	filter($_REQUEST['nature_work']);
	$member_of_any_other_organisation=$_REQUEST['member_of_any_other_organisation'];
	$name_of_organisation = strtoupper(filter($_REQUEST['name_of_organisation']));
	$bank_name   = strtoupper(filter($_REQUEST['bank_name']));
	$bank_branch = strtoupper(filter($_REQUEST['bank_branch']));
	$bank_ifsc   = strtoupper(filter($_REQUEST['bank_ifsc']));
	$bank_account_no = filter($_REQUEST['bank_account_no']);
	$aadhar_no = filter($_REQUEST['aadhar_no']);
	$parichay_card_no = filter($_REQUEST['parichay_card_no']);
	$ip = $_SERVER['REMOTE_ADDR'];
	$dt=date('Y-m-d');
	
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
			$passbook=uploadReliefImage($photo_name,$photo_temp,$photo_type,$photo_size,$mobile,$attach);
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
			$statement_1 = uploadReliefImage($photo_name,$photo_temp,$photo_type,$photo_size,$mobile,$attach);
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
			$statement_2 = uploadReliefImage($photo_name,$photo_temp,$photo_type,$photo_size,$mobile,$attach);
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
			$statement_3 = uploadReliefImage($photo_name,$photo_temp,$photo_type,$photo_size,$mobile,$attach);
		}
	}
	
	if(isset($_FILES['id_scan_copy']) && $_FILES['id_scan_copy']['name']!="")
	{
		/* Scan Copy picture */
		$photo_name=$_FILES['id_scan_copy']['name'];
		$photo_temp=$_FILES['id_scan_copy']['tmp_name'];
		$photo_type=$_FILES['id_scan_copy']['type'];
		$photo_size=$_FILES['id_scan_copy']['size'];
		$attach="scan_copy";
		if($photo_name!="")
		{
			$create_photo = 'relief/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			$aadhar_copy=uploadReliefImage($photo_name,$photo_temp,$photo_type,$photo_size,$mobile,$attach);
		}
	}
	
if(empty($worker_type))
{ $signup_error = "This is required."; }
elseif(empty($fname))
{ $signup_error = "Full Name is required."; }
elseif(empty($father_name))
{ $signup_error = "Father Name is required."; }
elseif(empty($gender))
{ $signup_error = "Gender is required."; }
elseif(empty($birth_date))
{ $signup_error = "Birth Date is required."; }
elseif(empty($address))
{ $signup_error = "Address is required."; }
elseif(empty($city))
{ $signup_error = "City is required."; }
elseif(empty($state) && $state==0)
{ $signup_error = "State is required."; }
elseif(empty($pin_code) || strlen($pin_code)<6)
{ $signup_error="Please Enter correct Pincode"; }
elseif(empty($mobile))
{ $signup_error = "Please Enter Mobile No";}
elseif(is_numeric($mobile) == false)
{ $signup_error = "Please Enter Valid Mobile No";}
elseif(strlen($mobile)>10 || strlen($mobile)<10)
{ $signup_error = "Mobile Number should be 10 digits.";}
elseif(!preg_match("/^[6-9]\d{9}$/",$mobile))
{ $signup_error = "Please Enter Valid Mobile No"; }
elseif(empty($owner_name1))
{ $signup_error = "Please Enter Owner Name 1";}
elseif(empty($owner_mobile1))
{ $signup_error = "Please Enter Owner Mobile 1";}
elseif(is_numeric($owner_mobile1) == false)
{ $signup_error = "Please Enter Owner Valid Mobile No 1";}
elseif(strlen($owner_mobile1)>10 || strlen($owner_mobile1)<10)
{ $signup_error = "Mobile Number should be 10 digits.";}
elseif(empty($industry_type))
{ $signup_error = "Please Select Industry Type";}
elseif(empty($member_of_any_other_organisation))
{ $signup_error = "Please Select Member of Any other Organization";}
elseif(empty($bank_name))
{ $signup_error = "Please Enter Bank Name";}
elseif(empty($bank_branch))
{ $signup_error = "Please Enter Bank Branch";}
elseif(empty($bank_ifsc))
{ $signup_error = "Please Enter Bank IFSC code";}
elseif(empty($bank_account_no))
{ $signup_error = "Please Enter Bank Account No";}
elseif(empty($aadhar_no))
{ $signup_error = "Please Enter Aadhar No";}
elseif(strlen($aadhar_no)>12 || strlen($aadhar_no)<12)
{ $signup_error = "Aadhar Number should be 12 digits.";}
elseif(empty($passbook) || empty($statement_1) || empty($aadhar_copy))
{ $signup_error="Please Upload the required Document";}
else
{
	$sqlCheck = "SELECT * FROM `relief_aid` WHERE (`mobile_no`='$mobile' || `aadhar_no`='$aadhar_no') LIMIT 1";
    $resultCheck = $conn ->query($sqlCheck);
	$getRowx = $resultCheck->fetch_assoc();
    $countCheck = $resultCheck->num_rows;
    if($countCheck>0){
		
	if($getRowx['otpVerified']==1){ $signup_success = "Mobile No is Already Verified"; }
	if($getRowx['aadhar_no']==$aadhar_no){ $signup_aadhar = "Sorry- Aadhar Number already registered, you can not proceed the registration"; }
	
	elseif($getRowx['otpVerified']==0){
		$otpVerified=0;
		$otp = rand(10000,99999);
		$message = 'One Time Password for mobile verification is '.$otp;
		$isSent =get_data($message,$mobile);
		if($isSent ==TRUE){
			$sql1="UPDATE `relief_aid` SET `mod_date`=NOW(),`parichay_card_no`='$parichay_card_no',`worker_type`='$worker_type',`fname`='$fname',`father_name`='$father_name',`gender`='$gender',`birthdate`='$birth_date',`address`='$address',`city`='$city',`state`='$state',`pincode`='$pin_code',`mobile_no`='$mobile',`otp`='$otp',`otpVerified`='$otpVerified',`email`='$email_id',`owner_name1`='$owner_name1',`owner_mobile1`='$owner_mobile1',`owner_name2`='$owner_name2',`owner_mobile2`='$owner_mobile2',`industry_type`='$industry_type',`nature_work`='$nature_work',`member_of_any_other_organisation`='$member_of_any_other_organisation',`name_of_organisation`='$name_of_organisation',`aadhar_no`='$aadhar_no',`bank_name`='$bank_name',`bank_branch`='$bank_branch',`bank_ifsc`='$bank_ifsc',`bank_account_no`='$bank_account_no',`upload_bank_passbook`='$passbook',`id_scan_copy`='$aadhar_copy',`status_approval`='U',`disapprove_reason`='',`isApplied`='Y',`ip`='$ip',statement_1='$statement_1',statement_2='$statement_2',statement_3='$statement_3' WHERE mobile_no='$mobile'";
			$resultx = $conn ->query($sql1);
			if($resultx){
			$_SESSION['mobile_no']=$mobile;
			header('location:verifyOTP.php'); 
			} else { $_SESSION['err_msg']="Something went wrong"; }
		}
	}
	
	} else {
		
	$otpVerified=0;
	$otp = rand(10000,99999);
	$message = 'One Time Password for mobile verification is '.$otp;
    $isSent =get_data($message,$mobile);
    if($isSent ==TRUE){

	$sql1="INSERT INTO `relief_aid`(`post_date`, `parichay_card_no`, `worker_type`, `fname`, `father_name`, `gender`, `birthdate`, `address`, `city`, `state`, `pincode`, `mobile_no`, `otp`, `otpVerified`, `email`, `owner_name1`, `owner_mobile1`,  `owner_name2`, `owner_mobile2`, `industry_type`, `nature_work`, `member_of_any_other_organisation`, `name_of_organisation`, `aadhar_no`, `bank_name`, `bank_branch`, `bank_ifsc`, `bank_account_no`, `upload_bank_passbook`, `id_scan_copy`, `status_approval`, `disapprove_reason`, `isApplied`, `adminId`,`ip`,`statement_1`,`statement_2`,`statement_3`) VALUES (NOW(),'$parichay_card_no','$worker_type','$fname','$father_name','$gender','$birth_date','$address','$city','$state','$pin_code','$mobile','$otp','$otpVerified','$email_id','$owner_name1','$owner_mobile1','$owner_name2','$owner_mobile2','$industry_type','$nature_work','$member_of_any_other_organisation','$name_of_organisation','$aadhar_no','$bank_name','$bank_branch','$bank_ifsc','$bank_account_no','$passbook','$aadhar_copy','P','','Y','0','$ip','$statement_1','$statement_2','$statement_3')";
	$resultx = $conn ->query($sql1);
	if($resultx){	
	$_SESSION['mobile_no']=$mobile;
	header('location:verifyOTP.php'); 
	} else { $_SESSION['err_msg']="Something Missing"; }
	
	} else { $_SESSION['err_msg']="OTP not sent"; exit; }
	
	}	
} 
	
	/*} else {
	 $_SESSION['err_msg']="Invalid Token Error";
	} */
}
?>

<?php
if($_SESSION['err_msg']!=""){
echo "<div class='text-center'><span style='color: red;'>".$_SESSION['err_msg']."</span></div>";
$_SESSION['err_msg']="";
}
?>

<section class="py-5">	
    <div class="container-fluid inner_container">
		<div class="row justify-content-center grey_title_bg">           	
            	           
                <div class="bold_font text-center"> <div class="d-block"><img src="assets/images/gold_star.png"></div>GJEPC- Relief Aid Applications Form </div>
                
                
         </div>
                    
            <div class="container">				
                <div class="row justify-content-center">
                            
                <form class="cmxform col-12 box-shadow mb-5" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="regisForm" id="regisForm" enctype="multipart/form-data" autocomplete="off" >
				<input type="hidden" name="action" value="save"/>	
				<?php token(); ?>	
				<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>';} ?>
				<?php if(isset($signup_success)){ echo '<div class="alert alert-success" role="alert">'.$signup_success.'</div>';} ?>
				<?php if(isset($signup_aadhar)){ echo '<div class="alert alert-danger" role="alert">'.$signup_aadhar.'</div>';} ?>
				
				<div class="row mb-5 ab_none justify-content-between align-items-center">
                	<div class="col-12 col-md mb-3"><p class="mt-2 text-left"><strong>*Benefits only applicable to Daily Wage Worker whose monthly income is Rs. 15,000 or below</strong></p></div>
                    <div class="col-12 col-md-auto">
                    <a href="pdf/GJEPC-AID-FORM-PDF.pdf" target="_blank" class="cta mt-2 mr-3"><i class="fa fa-download" aria-hidden="true"></i>
</a> <a href="relief-aid-update.php" class="cta mt-2">Update Your Information</a></div>
                   
                    </div>
                        <div class="row mb-4">                    
                                                   
                            <div class="form-group col-sm-6 language_wrp"> 
                            <label for="fname">Select Language <span>*</span></label>
							<div id="google_translate_element" class="language"></div> 
							</div>
                                                      
                            <div class="form-group col-sm-6">
                                <label for="company_name">Are You Daily Wage Worker? <span>*</span></label>
                                <div class="mt-2">                                       
                                    <label for="Propritory" class="mr-3">
                                    <input type="radio" id="worker_type" name="worker_type" value="YES" class="mr-2">Yes 
                                    </label>
                                    <label for="Partnership" class="mr-3">
                                    <input type="radio" id="worker_type" name="worker_type" value="NO" class="mr-2">No
                                    </label><label for="worker_type" generated="true" style="display: none;" class="error"></label>
                                </div>
                            </div>            
                                                        
                        <div class="form-group col-sm-6">
                        <label for="fname">Full Name <span>*</span></label>
                        <input type="text" class="form-control" id="fname" name="fname" autocomplete="off" maxlength="30">
                        </div>                            
                            
                        <div class="form-group col-sm-6">
                            <label for="father_name">Fathers Name or Son of / Daughter of <span>*</span></label>
                            <input type="text" class="form-control" id="father_name" name="father_name" autocomplete="off" maxlength="30">
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label for="gender">Gender (M/F) <span>*</span></label>
                            <div class="mt-2">                            
                            <label for="Yes" class="mr-3">
                            <input type="radio" name="gender" value="M" class="mr-2">Male </label>            
                            <label for="No" class="mr-3">
                            <input type="radio" name="gender" value="F" class="mr-2">Female </label>
							<label for="gender" generated="true" style="display: none;" class="error"></label>
                            </div>
                        </div>                        
                        
                        <div class="form-group col-sm-6">
                            <label for="date">Birth Date <span>*</span></label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" autocomplete="off"/>
                        </div>                               
                        
                        <div class="form-group col-12">
                            <label for="city">Address <span>*</span></label>
                            <input type="text" class="form-control" id="address" name="address" autocomplete="off">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="city">City <span>*</span></label>
                            <input type="text" class="form-control" id="city" name="city" maxlength="20" autocomplete="off">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="mobile_no">State <span>*</span></label>
                            <select name="state" id="state" class="form-control">
                            <option value="">--- Select State ---</option>
                            <?php 
                            $stat = $conn ->query("SELECT * from state_master WHERE country_code = 'IN'");
                            while($result = $stat->fetch_assoc()){?>
                            <option value="<?php echo $result['state_code'];?>"><?php echo $result['state_name'];?></option>
                            <?php }?>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-4">
                        <label for="pin_code">Pincode  <span>*</span></label>
                        <input type="text" class="form-control numeric" id="pin_code" name="pin_code" autocomplete="off" maxlength="6" onkeypress="if(this.value.length==6) return false;">
                        </div>  
                        
                        <div class="form-group col-sm-6">
                        <label for="mobile_no">Mobile No (Enter valid Mobile No - OTP Code Verification will send on this number)<span>*</span></label>
                        <input type="text" class="form-control numeric" id="mobile_no" name="mobile_no" maxlength="10" minlength="10" autocomplete="off">
                        </div>  
                        
                        <div class="form-group col-sm-6">
                        <label for="email_id">Email ID </label>
                        <input type="text" class="form-control" id="email_id" name="email_id" autocomplete="off" >
                        </div>  
                                          
              </div>
              
                        <div class="row mb-4">     
                        
                        	<div class="form-group col-12 mb-4">
                            	<p class="blue">Industry Reference and Association Details</p>
                                <p>Industry Reference with whom you have worked in last 6 months (2 references, At least one is mandatory) and Association Details</p>
                        	</div>               
                                
                            <!--<div class="form-group col-md-4 col-sm-6">
                            <label for="ref_company1">Reference Company Name-1</label>
                            <input type="text" class="form-control" id="ref_company1" name="ref_company1" autocomplete="off" >
                            </div>-->
                            
                            <div class="form-group col-sm-6">
                                <label for="owner_name1">Owner / Contractor / Head Karigar Name-1 <span>*</span></label>
                                <input type="text" class="form-control" id="owner_name1" name="owner_name1" autocomplete="off">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="owner_mobile1">Owner / Contractor / Head Karigar Mobile-1 <span>*</span></label>
                                <input type="text" class="form-control numeric" id="owner_mobile1" name="owner_mobile1" maxlength="10" autocomplete="off">
                            </div>                        
                        	
                           <!-- <div class="form-group col-md-4 col-sm-6">
                            <label for="ref_company2">Reference Company Name-2 (Optional)</label>
                            <input type="text" class="form-control" id="ref_company2" name="ref_company2" autocomplete="off" >
                            </div>-->
                            
                            <div class="form-group col-sm-6">
                                <label for="owner_name2">Owner / Contractor / Head Karigar Name-2 (Optional)</label>
                                <input type="text" class="form-control" id="owner_name2" name="owner_name2" autocomplete="off">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="owner_mobile2">Owner / Contractor / Head Karigar Mobile-2 (optional)</label>
                                <input type="text" class="form-control" id="owner_mobile2" name="owner_mobile2" maxlength="10" autocomplete="off">
                            </div> 
                            
                            <div class="form-group col-sm-6">
                                <label for="company_name">Industry Type <span>*</span></label>
                                <div class="mt-2">
                                       
                                    <label for="industry_type" class="mr-3">
                                    <input type="radio" id="industry_type" name="industry_type" value="Diamonds" class="mr-2">Diamonds 
                                    </label>
                                    <label for="industry_type" class="mr-3">
                                    <input type="radio" id="industry_type" name="industry_type" value="Gemstone" class="mr-2">Gemstone
                                    </label>                                    
                                    <label for="industry_type" class="mr-3">
                                    <input type="radio" id="industry_type" name="industry_type" value="Jewellery" class="mr-2">Jewellery
                                    </label>                                                            
                                    
                                </div>
                            </div>
                        
                        	<div class="form-group col-sm-6">
                                <label for="nature_work">Nature / Type of Work </label>
                                <input type="text" class="form-control" id="nature_work" name="nature_work" autocomplete="off">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="company_name">Member of Any Registered Association</label>
                                <div class="mt-2">                                       
                                    <label for="Propritory" class="mr-3">
                                    <input type="radio" id="member_of_any_other_organisation" name="member_of_any_other_organisation" value="YES" class="mr-2">Yes 
                                    </label>
                                    <label for="Partnership">
                                    <input type="radio" id="member_of_any_other_organisation" name="member_of_any_other_organisation" value="NO" class="mr-2">No
                                    </label>                                    
                                </div>
                            </div>
                                              
                     		<div class="form-group col-sm-6" id="organisation_name">
                                <label for="name_of_organisation">Name of Registered Association</label>
                                <input type="text" class="form-control" id="name_of_organisation" name="name_of_organisation" autocomplete="off">
                            </div>
                     	
                        </div>
                        
                        <div class="row mb-4">     
                        
                        	<div class="form-group col-12 mb-4">
                            	<p class="blue">Bank Details of Beneficiary (Worker/Karigar) </p>                               
                        	</div>               
                                
                            <div class="form-group col-sm-6">
                            <label for="bank_name">Bank Name <span>*</span></label>
                            <input type="text" class="form-control" id="bank_name" name="bank_name" maxlength="40" autocomplete="off" >
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="bank_branch">Bank Branch Address <span>*</span></label>
                                <input type="text" class="form-control" id="bank_branch" name="bank_branch" maxlength="40" autocomplete="off">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="bank_ifsc">IFSC Code <span>*</span></label>
                                <input type="text" class="form-control ifsc" id="bank_ifsc" name="bank_ifsc" maxlength="40" autocomplete="off">
                            </div>                        
                        	
                            <div class="form-group col-sm-6">
                            <label for="bank_account_no">Bank Account Number <span>*</span></label>
                            <input type="text" class="form-control numeric" id="bank_account_no" name="bank_account_no" maxlength="40" autocomplete="off" >
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
                        
                        	<div class="form-group col-12 mb-4">
                            	<p class="blue">Identity Details of Karigar</p>
                            </div>               
                                
                            <div class="form-group col-sm-6">
                            <label for="aadhar_no">Aadhar Card Number <span>*</span></label>
                            <input type="text" class="form-control numeric" id="aadhar_no" name="aadhar_no" maxlength="12" autocomplete="off" >
                            </div>
                   			
                            <div class="form-group col-sm-6">
                            <label for="address_line1">Upload Photo of Aadhar Card <span>*</span>(Upload only .jpeg,.jpg,.pdf format files)</label>
                            <input type="file" id="id_scan_copy" name="id_scan_copy" class="form-control" autocomplete="off">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="parichay_card_no">GJEPC Parichay Card Number</label>
                                <input type="text" class="form-control" id="parichay_card_no" name="parichay_card_no" maxlength="40" autocomplete="off">
                            </div>                       
                        	
                        </div>                        
              
              			<div class="form-group">
                      		<button type="submit" id='submit' class="cta fade_anim">Submit</button>
							<span class="otp-messages" style='color: green;'></span>
							<div><p class="mt-2">* After Click on Submit button Please Verify OTP</p></div>
                        </div>     
					
                    </form>
                                    
                </div>  
                          
            </div>    
	</div>    
    </div>
</section> 

</div>
<?php include 'include-new/footer.php'; ?>


<script>
$(document).ready(function(){
  $("input[name=member_of_any_other_organisation]").change(function(){
	if($(this).val()=="YES")
		$("#organisation_name").show();
	else
		$("#organisation_name").hide();	
 });
});

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
			worker_type: {
				required: true,
			},
			fname: {
				required: true,				
				specialChrs: true
			}, 
			father_name: {
				required: true,				
				specialChrs: true
			},
			gender: {
				required: true,
			}, 
			birth_date: {
				required: true,
			},
			address: {
				required: true,
				},
			city: {
				required: true,
				},
			state: {
				required: true,
				},
			pin_code: {
				required: true,
				number:true,
				minlength:6,
				maxlength:6
			},
			mobile_no: {
				required: true,
				number:true
			},			
			owner_name1:{
				required:true
			},			
			owner_mobile1:{
				required:true,
				number:true
			},
			industry_type:{
				required: true,
			},
			member_of_any_other_organisation:{
				required: true,
			},
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
			},
			aadhar_no:{
				required: true,
				number:true,
				minlength:12,
				maxlength:12
			},
			id_scan_copy:{
				required: true,
			},
			
		},
		messages: {
			worker_type: {
				required: "This is required.",
			},
			fname: {
				required: "This is required.",
			},
			father_name: {
				required: "This is required.",
			},
			gender: {
				required: "This is required.",
			},
			birth_date: {
				required: "This is required.",
			},
			address: {
				required: "This is required.",
			},
			city: {
				required: "This is required.",
			},
			state: {
				required: "This is required.",
			}, 
			pin_code: {
				required: "Please Enter your pin code",
				number:"Please Enter numbers only",
				minlength:"Please Enter not less than 6 characters",
				maxlength:"Please Enter not more than 6 characters"				
			},
			mobile_no: {
				required:"This is required.",
				number:"Please Enter Numbers only"
			},
			owner_name1:{
				required: "This is required.",
			},
			owner_mobile1:{
				required: "This is required.",
				number:"Please Enter Numbers only"
			},			   
			industry_type: {
				required: "This is required.",
			},
			member_of_any_other_organisation: {
				required: "This is required.",
			},
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
			},
			aadhar_no: {
				required: "This is required.",
				number:"Please Enter Numbers only",
				minlength:"Please Enter not less than 12",
				maxlength:"Please Enter not more than 12"
			},
			id_scan_copy: {
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
<style>
.language {height: 40px;
    border: 1px solid #ccc!important;
	padding:0 15px;
	line-height:40px;
    color: #6c757d;
    transition: all 0.3s ease-in-out;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -o-transition: all 0.3s ease-in-out;
    border-radius: 0;
	position:relative;
}
#google_translate_element .goog-te-gadget-simple>span, #google_translate_element .goog-te-gadget-simple {width:100%;}

.form-group label span {color:#f00; font-size:18px;}
</style>