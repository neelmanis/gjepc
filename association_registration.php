<?php
include 'include-new/header.php';
include 'db.inc.php';
include 'functions.php';
$action = trim($_REQUEST['action']);

if($action=="save")
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	
		$company_name	=	strtoupper(filter($_REQUEST['company_name']));
		$association_registration_no	=	strtoupper(filter($_REQUEST['association_registration_no']));
		$association_head_name			=	strtoupper(filter($_REQUEST['association_head_name']));
		$association_head_designation	=	strtoupper(filter($_REQUEST['association_head_designation']));
		$association_head_mobile_no1	=	filter($_REQUEST['association_head_mobile_no1']);
		$association_head_mobile_no2	=	filter($_REQUEST['association_head_mobile_no2']);
		$head_email_id					=	filter($_REQUEST['head_email_id']);
		$total_member					=	filter($_REQUEST['total_member']);
	
	$nature_of_buisness   = $_REQUEST['nature_of_buisness'];	
	foreach($nature_of_buisness as $val)
	{
		if($val=="other")
		{
			$nature_of_buisness_other=$_REQUEST['nature_of_buisness_other'];
			$nature_of_buisness_new.=$nature_of_buisness_other.",";
		} else	{
			$nature_of_buisness_new.=$val.",";	
		}
	}
	
	$address_line1					=	filter($_REQUEST['address_line1']);
	$address_line2					=	filter($_REQUEST['address_line2']);
	$city							=	filter($_REQUEST['city']);
	$state							=	filter($_REQUEST['state']);
	$pin_code						=	filter($_REQUEST['pin_code']);	
	$no_of_parichay_card 			=   filter($_REQUEST['no_of_parichay_card']);
	
	$authorised_person			=	strtoupper(filter($_REQUEST['authorised_person']));
	$authorised_designation		=	strtoupper(filter($_REQUEST['authorised_designation']));
	$authorised_mobile1			=	filter($_REQUEST['authorised_mobile1']);
	$authorised_mobile2			=	filter($_REQUEST['authorised_mobile2']);
	$authorised_email			=	filter($_REQUEST['authorised_email']);
		
	$parichay_type = "association"; // registration table
	$website = "parichay"; // registration table
	$ip = $_SERVER['REMOTE_ADDR'];
	$dt = date('Y-m-d');
	
	$hash = md5(rand(0,1000));
	$pass		= generatePassword();
	$password   = md5($pass);
	$otpVerified = filter($_POST['verified']);
		
	function parichay_documents($file_name,$file_temp,$file_type,$file_size,$association_head_mobile_no1,$attach)
	{
		$upload_image = '';
		$target_folder = 'images/parichay_card/'.$attach.'/';
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
				$target_path = $target_folder.$association_head_mobile_no1.'_'.$attach.'_'.$random_name.$file_name;
				if(@move_uploaded_file($file_temp, $target_path))
				{
					$upload_image = $association_head_mobile_no1.'_'.$attach.'_'.$random_name.$file_name;
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
		
	if(isset($_FILES['association_request_letter']) && $_FILES['association_request_letter']['name']!="")
	{
		/* Association Request Letter picture */
		$photo_name=$_FILES['association_request_letter']['name'];
		$photo_temp=$_FILES['association_request_letter']['tmp_name'];
		$photo_type=$_FILES['association_request_letter']['type'];
		$photo_size=$_FILES['association_request_letter']['size'];
		$attach="association_request_letter";
		if($photo_name!="")
		{
			$create_photo = 'images/parichay_card/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			$association_request_letter=parichay_documents($photo_name,$photo_temp,$photo_type,$photo_size,$association_head_mobile_no1,$attach);
		}
	}
	
	if(isset($_FILES['association_registration_certificate']) && $_FILES['association_registration_certificate']['name']!="")
	{
		/* association_registration_certificate picture */
		$photo_name=$_FILES['association_registration_certificate']['name'];
		$photo_temp=$_FILES['association_registration_certificate']['tmp_name'];
		$photo_type=$_FILES['association_registration_certificate']['type'];
		$photo_size=$_FILES['association_registration_certificate']['size'];
		$attach="association_registration_certificate";
		if($photo_name!="")
		{
			$create_photo = 'images/parichay_card/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			$association_registration_certificate = parichay_documents($photo_name,$photo_temp,$photo_type,$photo_size,$association_head_mobile_no1,$attach);
		}
	}
	
	if(isset($_FILES['association_head_visiting_card']) && $_FILES['association_head_visiting_card']['name']!="")
	{
		/* association_head_visiting_card picture */
		$photo_name=$_FILES['association_head_visiting_card']['name'];
		$photo_temp=$_FILES['association_head_visiting_card']['tmp_name'];
		$photo_type=$_FILES['association_head_visiting_card']['type'];
		$photo_size=$_FILES['association_head_visiting_card']['size'];
		$attach="association_head_visiting_card";
		if($photo_name!="")
		{
			$create_photo = 'images/parichay_card/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			$association_head_visiting_card = parichay_documents($photo_name,$photo_temp,$photo_type,$photo_size,$association_head_mobile_no1,$attach);
		}
	}
	
	if(isset($_FILES['association_office_address']) && $_FILES['association_office_address']['name']!="")
	{
		/* association_office_address picture */
		$photo_name=$_FILES['association_office_address']['name'];
		$photo_temp=$_FILES['association_office_address']['tmp_name'];
		$photo_type=$_FILES['association_office_address']['type'];
		$photo_size=$_FILES['association_office_address']['size'];
		$attach="association_office_address";
		if($photo_name!="")
		{
			$create_photo = 'images/parichay_card/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			$association_office_address = parichay_documents($photo_name,$photo_temp,$photo_type,$photo_size,$association_head_mobile_no1,$attach);
		}
	}	

$sqlx="SELECT association_registration_no,association_head_mobile_no1,authorised_mobile1,authorised_email FROM parichay_card WHERE association_registration_no='$association_registration_no' OR association_head_mobile_no1='$association_head_mobile_no1' OR authorised_mobile1='$authorised_mobile1' OR authorised_email='$authorised_email'";
$result = $conn ->query($sqlx);
$mysqlrow = $result->fetch_array();
//echo '<pre>'; print_r($mysqlrow); 	
//echo '----'.$mysqlrow[1]; exit;

if(empty($company_name))
{ $signup_error = "Association Name required."; }
/* Association Regi No Check */
elseif(empty($association_registration_no))
{ $signup_error = "Association Registration No required."; }
elseif($mysqlrow[0] == $association_registration_no)
{ $signup_error = "Association Registration No Already Exist"; }

elseif(empty($association_head_name))
{ $signup_error = "Association Head Name required."; }
elseif(empty($association_head_designation))
{ $signup_error = "Association Head Designation required."; }

/* Head Mobile No Check */
elseif(empty($association_head_mobile_no1))
{ $signup_error = "Association Head Mobile No required."; }
elseif($mysqlrow[1] == $association_head_mobile_no1)
{$signup_error="Association Head Mobile No Already Exist";}
elseif(is_numeric($association_head_mobile_no1) == false)
{ $signup_error = "Please Enter Valid Mobile No";}
elseif(strlen($association_head_mobile_no1)>10 || strlen($association_head_mobile_no1)<10)
{ $signup_error = "Mobile Number should be 10 digits.";}
elseif(!preg_match("/^[6-9]\d{9}$/",$association_head_mobile_no1))
{ $signup_error = "Please Enter Valid Mobile No"; }

/* Head Email Check */
elseif(empty($head_email_id))
{ $signup_error = "Association Head Email ID required."; }
elseif(!ninjaxMailCheck($head_email_id))
{ $signup_error = $head_email_id. " is Invalid Email Id"; }

elseif(empty($address_line1))
{ $signup_error = "Address required."; }
elseif(empty($city))
{ $signup_error = "City required."; }
elseif(empty($state) && $state==0)
{ $signup_error = "State required."; }
elseif(empty($pin_code) || strlen($pin_code)<6)
{ $signup_error="Please Enter correct Pincode"; }

elseif(empty($authorised_person))
{ $signup_error = "Authorised Person Name required."; }
elseif(empty($authorised_designation))
{ $signup_error = "Authorised Designation required."; }

/* Authorised Person Mobile Check */
elseif(empty($authorised_mobile1))
{ $signup_error = "Please Enter Mobile No";}
elseif($mysqlrow[2] == $authorised_mobile1)
{$signup_error="Authorised Person Mobile No Already Exist";}
elseif(is_numeric($authorised_mobile1) == false)
{ $signup_error = "Please Enter Valid Mobile No";}
elseif(strlen($authorised_mobile1)>10 || strlen($authorised_mobile1)<10)
{ $signup_error = "Mobile Number should be 10 digits.";}
elseif(!preg_match("/^[6-9]\d{9}$/",$authorised_mobile1))
{ $signup_error = "Please Enter Valid Mobile No"; }

/* Authorised Person Email Check */
elseif(empty($authorised_email))
{ $signup_error = "Authorised Person Email required"; }
elseif($mysqlrow[3] == $authorised_email)
{ $signup_error="Authorised Person Email Already Exist"; }

elseif(empty($association_request_letter) || empty($association_registration_certificate))
{ $signup_error="Please Upload the required Document"; }
else
{
	if($otpVerified=="verify"){
	$sqlCheck = "SELECT email_id FROM `registration_master` WHERE `email_id`='$head_email_id' LIMIT 1";
    $resultCheck = $conn ->query($sqlCheck);
	$getRowx = $resultCheck->fetch_assoc();
    $countCheck = $resultCheck->num_rows;
    if($countCheck>0){
		$signup_error = "Email ID of the Association Head Already Registered";
	} else {

	$sql_series = "SELECT MAX(parichay_series) FROM registration_master WHERE parichay_type='$parichay_type'";
	$result_series = $conn->query($sql_series);
	$row_series = $result_series->fetch_array();
	if($row_series[0] =="" || is_null($row_series[0])){
		$parichay_series = "001";
	}else{
		$parichay_series = $row_series[0]+1;
	}	
	
	$region = getRegionNameFromState($state,$conn);

	if($region=='HO-MUM (M)'){ $to_admin='sheetal.kesarkar@gjepcindia.com'; }
	if($region=='RO-CHE'){     $to_admin='p.anand@gjepcindia.com'; }
	if($region=='RO-DEL'){     $to_admin='gunjan.lunia@gjepcindia.com'; }
	if($region=='RO-JAI'){     $to_admin='anindhya.panwar@gjepcindia.com'; }
	if($region=='RO-KOL'){     $to_admin='partha.kajli@gjepcindia.com';}
	if($region=='RO-SRT'){     $to_admin='Kishan.detroja@gjepcindia.com'; }

	$sqlRegis ="insert into registration_master set email_id='$head_email_id',old_pass='$pass',company_secret='$password',company_name='$company_name',address_line1='$address_line1',address_line2='$address_line2',pin_code='$pin_code',city='$city',country='IN',state='$state',nature_of_buisness='$nature_of_buisness_new',status='0',website='$website',parichay_type='$parichay_type',parichay_series='$parichay_series',post_date='$dt',ip='$ip',hash='$hash'";
	$query  = $conn->query($sqlRegis);
	$registration_id = mysqli_insert_id($conn);
	
	if($query){
	
	/*.......................................Send mail to Association Head Email id...............................................*/
	$message ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
<tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
  <tr><td align="left"><img src="https://www.gjepc.org/assets/images/logo.png"> </td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td><h4 style="margin:0;">Thank you for registering at Gems and Jewellery Export Promotion Council (GJEPC).</h4></td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td>Your account has been created, Please click The following link For verifying and activation of your account</td></tr>
  <tr>
    <td align="left" style="text-align:justify;"><strong>Association :</strong> '. $company_name .' </td>
    </tr>
	<tr>
    <td align="left" style="text-align:justify;"><strong>Password :</strong> '. $pass .' </td>
    </tr>
  <tr>
    <td align="left"  style="text-align:justify;">Please click this link to activate your account:<br/>
    https://gjepc.org/verify.php?email='.$head_email_id.'&hash='.$hash.'</td>
  </tr>
   <tr><td>       
      <p>Kind Regards,<br>
      <b>GJEPC Web Team,</b>
      </p>
	  <p> For Any Queries : </p>
    </td>
  </tr>
  <tr><td><b>Toll Free Number :</b> 1800-103-4353 <br/>
<b>Missed Call Number :</b> +91-7208048100
 </td></tr> 
</table>';
  
	 $to = $head_email_id.",".$to_admin;
	 $subject = "New Association Registration"; 
	/* $headers  = 'MIME-Version: 1.0' . "\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	 $headers .= 'From: GJEPC <admin@gjepc.org>';
	 mail($to, $subject, $message, $headers); */
	 
	$cc = "";
	$email_array = explode(",",$to);
	send_mailArray($email_array,$subject,$message,$cc);
		 
	if($registration_id!=''){
			
	$sql1="INSERT INTO `parichay_card`(`post_date`, `registration_id`, `association_request_letter`, `association_registration_certificate`, `association_head_visiting_card`, `association_registration_no`, `association_head_name`, `association_head_designation`, `association_head_mobile_no1`, `association_head_mobile_no2`, `total_member`, `association_office_address`, `no_of_parichay_card`, `authorised_person`, `authorised_designation`, `authorised_mobile1`, `authorised_mobile2`, `authorised_email`, `parichay_status`,`parichay_type`,`otpVerified`) VALUES (NOW(),'$registration_id','$association_request_letter','$association_registration_certificate','$association_head_visiting_card','$association_registration_no','$association_head_name','$association_head_designation','$association_head_mobile_no1','$association_head_mobile_no2','$total_member','$association_office_address','$no_of_parichay_card','$authorised_person','$authorised_designation','$authorised_mobile1','$authorised_mobile2','$authorised_email','P','association','1')";
	$resultx = $conn ->query($sql1);
	if($resultx){
	$_SESSION['succ_msg']="Request for application of Parichay Card from your Association has been successfully submitted. GJEPC team is reviewing your application and will update the same within 2 working days, we will get in touch with you in case of any discrepancies. Once your application is approved by GJEPC you will receive a verification link on your registered email id for activation of your request.";	
	} else { $_SESSION['err_msg']="Something Missing"; }
	} 
	} else { $_SESSION['err_msg']="Kindly Contact Admin"; }
	
	}
	} else { $_SESSION['err_msg']="OTP Not Verified"; }
	}
	
	} else {
	 $_SESSION['err_msg']="Invalid Token Error";
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
}
else{
?>

<section class="py-5">	
    <div class="container-fluid inner_container">
		<div class="row justify-content-center grey_title_bg">           	
            <div class="bold_font text-center"> 
			<div class="d-block"><img src="assets/images/gold_star.png"></div>Association Registration 
            </div>                    
        </div>
                    
            <div class="container">
            	
                <div class="col-12">
               
                            <div class="d-flex justify-content-center mb-3 lang_switcher">
                			<div><button onclick="location.href = 'association_registration.php';" class="lang active">English</button></div>
                			<div><button onclick="location.href = 'association_registration-hindi.php';" class="lang">Hindi</button></div>
            			</div>
                        </div>
            				
                <div class="row justify-content-center">
                        
                <form class="cmxform col-12 box-shadow mb-5" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="regisForm" id="regisForm" enctype="multipart/form-data" autocomplete="off"/>
				<input type="hidden" name="action" value="save"/>	
				<?php token(); ?>	
				<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>';} ?>
				<?php if(isset($signup_success)){ echo '<div class="alert alert-success" role="alert">'.$signup_success.'</div>';} ?>
				<?php if(isset($signup_aadhar)){ echo '<div class="alert alert-danger" role="alert">'.$signup_aadhar.'</div>';} ?>
				
			<!-- 	<div class="row mb-5 ab_none justify-content-between align-items-center">
                	<div class="col-12 col-md mb-3"><p class="mt-2 text-left">
					<strong></strong></p></div>
                </div> -->

                    <div class="row mb-4">                    
                                            
                        <div class="form-group col-12 mb-4">
                            <p class="blue tr" key="enroll">Association Enrolment Process &nbsp;&nbsp;<span id="chkregisuser"></span><br><span id="chkpanuser"></span></p>
                        </div>     
                           
                          <div class="col-12 mb-3">
                          	<ul class="inner_under_listing">Note:
                          	<li>(Allowed file types:jpeg,png,pdf & File upload max size 2 MB)</li>
                          	<li><a href="http://gjepc.org/pdf/Request-Letter-Format-Associaiton-Parichay-Card.pdf" target="_blank" style="color: blue">Download Request Letter Format &nbsp;<i class="fa fa-arrow"></i></a></li>
                          </ul> 
                          </div>   
                          <hr>
                            <!--<div class="form-group col-sm-6 language_wrp"> 
                            <label for="fname">Select Language <span>*</span></label>
							<div id="google_translate_element" class="language"></div> 
							</div>-->
                            <div class="form-group col-sm-6">
                            <label for="association_request_letter">Please upload the request letter of your association on official letter head along with stamp and signature of the authorised signatory of the association <span>*</span></label>
                            <!-- <button class="btn btn-outline-dark" id="association_request_letter_label">Download Request Letter Format <i class="fa fa-upload"></i></button> -->
                            <!-- <span id="filename" class="d-block"></span> -->
                            <input type="file" id="association_request_letter"  name="association_request_letter" class="form-control" autocomplete="off">
                            </div>
							
                            <div class="form-group col-sm-6">
							<label for="company_name">Full Name of Association<span>*</span></label>
							<input type="text" class="form-control mt-5" id="company_name" name="company_name" value="<?php echo $company_name;?>" autocomplete="off" maxlength="100">
							</div>                    
                        
							<div class="form-group col-sm-6">
							<label for="association_registration_no">Registration no. of Association<span>*</span></label>
							<p id="chkRegisNo"></p>						
							<input type="text" class="form-control" id="association_registration_no" name="association_registration_no" value="<?php echo $association_registration_no;?>" autocomplete="off" maxlength="30">
							</div>
							
							<div class="form-group col-sm-6">
								<p></p>
                            <label for="association_registration_certificate">Please upload the scanned copy of registration certificate of association<span>*</span></label>
                            <input type="file" id="association_registration_certificate" name="association_registration_certificate" class="form-control" autocomplete="off">
                            </div>
							
							<div class="form-group col-sm-6">
							<label for="association_head_name">Full Name of Association head<span>*</span></label>
							<input type="text" class="form-control" id="association_head_name" name="association_head_name" value="<?php echo $association_head_name;?>" autocomplete="off" maxlength="80">
							</div>
							
							<div class="form-group col-sm-6">
                            <label for="association_head_visiting_card">Please upload the scanned copy of visiting card of the association Head</label>
                            <input type="file" id="association_head_visiting_card" name="association_head_visiting_card" class="form-control" autocomplete="off">
                            </div>
                        
							<div class="form-group col-sm-6">
							<label for="association_head_designation">Designation of Association Head<span>*</span></label>
							<p></p>
							<input type="text" class="form-control" id="association_head_designation" name="association_head_designation" value="<?php echo $association_head_designation;?>" autocomplete="off" maxlength="30">
							</div>
							
							<div class="form-group col-sm-6">
							<label for="association_head_mobile_no1">Mobile No 1 of the Association Head<span>*</span></label>
							<p id="chkHeadregisMob1"></p>							
							<input type="text" class="form-control numeric" id="association_head_mobile_no1" name="association_head_mobile_no1" value="<?php echo $association_head_mobile_no1;?>" maxlength="10" minlength="10" autocomplete="off">
							</div> 
							
							<div class="form-group col-sm-6">
								<p></p>
							<label for="association_head_mobile_no2">Mobile No 2 of the Association Head</label>
							<input type="text" class="form-control numeric" id="association_head_mobile_no2" name="association_head_mobile_no2" value="<?php echo $association_head_mobile_no2;?>" maxlength="10" minlength="10" autocomplete="off">
							</div> 
							
							<div class="form-group col-sm-6">
							<label for="head_email_id">Email ID of the Association Head<span>*</span></label>
							<p id="chkheadregisuser" style="color:#FF0000; display:block;"></p>
							<input type="text" class="form-control" id="head_email_id" name="head_email_id" value="<?php echo $head_email_id;?>" autocomplete="off" maxlength="60">
							</div>
							
							<div class="form-group col-md-6">
							<label for="total_member">Total No. of Members in Association as on date<span>*</span></label>
							<input type="text" class="form-control numeric" id="total_member" name="total_member" autocomplete="off" maxlength="10" onkeypress="if(this.value.length==10) return false;">
							</div> 
							
							<div class="form-group col-md-6">
                            <div class="d-block"><label for="nature_of_business" class="tr" key="Business">Profile of Members in your association (Tick all applicable options)<span>*</span></label></div>
							<div class="mt-2">
							
                                    <label for="Exporters" class="mr-3">
                                    <input type="checkbox" name="nature_of_buisness[]" id="Exporters" class="mr-2" value="Exporters">Exporters 
                                    </label>
                                    <label for="Manufacturer" class="mr-3">
                                    <input type="checkbox" name="nature_of_buisness[]" id="Manufacturer" class="mr-2" value="Manufacturer">Manufacturer
                                    </label>
                                    <label for="Retailers" class="mr-3">
                                    <input type="checkbox" name="nature_of_buisness[]" id="Retailers"  class="mr-2" value="Retailers">Retailers
                                    </label>
                                    <label for="Brokers" class="mr-3">
                                    <input type="checkbox" name="nature_of_buisness[]" id="Brokers"  class="mr-2" value="Brokers">Brokers
                                    </label>                          
                                    <label for="Karigars">
                                    <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" class="mr-2" value="Karigars">Karigars
                                    </label>
                                     <label for="other">
                                    <input type="checkbox" name="nature_of_buisness[]" id="other"  class="mr-2" value="other">Other
                                    </label>
                                    <div id="nature_of_buisness_other">
                                    <label>Others please specify</label><input type="text" class="form-control" name="nature_of_buisness[]" id="other" autocomplete="off">
                                    </div>                                   
                                    <label for="company_type" generated="true" style="display: none;" class="error">Please Select Business Nature</label>
                                </div>
                                <label for="nature_of_buisness[]" generated="true" class="error d-none">This field is required.</label>
                       
							</div>
												
						<div class="form-group col-12 mb-4">
                          <p class="blue">Official Address of the Association</p>                                
                        </div>
						
						<div class="form-group col-6">
                            <label for="address_line1">Address 1<span>*</span></label>
                            <input type="text" class="form-control" id="address_line1" name="address_line1" value="<?php echo $address_line1;?>" autocomplete="off">
                        </div>
						
						<div class="form-group col-6">
                            <label for="address_line2">Address 2<span>*</span></label>
                            <input type="text" class="form-control" id="address_line2" name="address_line2" value="<?php echo $address_line2;?>" autocomplete="off">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="city">City <span>*</span></label>
                            <input type="text" class="form-control" id="city" name="city" value="<?php echo $city;?>" maxlength="20" autocomplete="off">
                        </div>
                        
                        <div class="form-group col-md-4">
                            <label for="mobile_no">State <span>*</span></label>
                            <select name="state" id="state" class="form-control">
                            <option value="">--- Select State ---</option>
                            <?php 
                            $stat = $conn ->query("SELECT * from state_master WHERE country_code = 'IN'");
                            while($result = $stat->fetch_assoc()){ ?>
							<option value="<?php echo filter($result['state_code']);?>" <?php if($result['state_code']==$state){?> selected="selected" <?php }?>><?php echo strtoupper(filter($result['state_name']));?></option>
                            <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group col-md-4">
                        <label for="pin_code">Pincode <span>*</span></label>
                        <input type="text" class="form-control numeric" id="pin_code" name="pin_code" value="<?php echo $pin_code;?>" autocomplete="off" maxlength="6" onkeypress="if(this.value.length==6) return false;">
                        </div>
						
						<div class="form-group col-sm-6">
                        <label for="association_office_address">Please upload scanned proof of address of association office (Electricity Bill, Phone Bill etc. not older than 3 months)</label>
                        <input type="file" id="association_office_address" name="association_office_address" class="form-control" autocomplete="off">
                        </div>
						
						<div class="form-group col-md-6">
                        <label for="no_of_parichay_card">No. of Parichay Cards required by your association<span>*</span></label>
                        <input type="text" class="form-control numeric mt-4" id="no_of_parichay_card" name="no_of_parichay_card" autocomplete="off" maxlength="10" onkeypress="if(this.value.length==10) return false;">
                        </div>
						
						<div class="form-group col-12 mb-4">
                        <p class="blue">Details of Authorised person from association for coordination and verification of information:</p> </div> 
							                                
					</div>
              
                        <div class="row mb-4"> 
                            <div class="form-group col-sm-6">
                                <label for="authorised_person">Full Name<span>*</span></label>
                                <input type="text" class="form-control" id="authorised_person" name="authorised_person" value="<?php echo $authorised_person;?>" maxlength="50" autocomplete="off">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="authorised_designation">Designation<span>*</span></label>
                                <input type="text" class="form-control" id="authorised_designation" name="authorised_designation" value="<?php echo $authorised_designation;?>" autocomplete="off">
                            </div>
                                                        
                            <div class="form-group col-sm-4">
                            <label for="authorised_mobile1">Mobile 1 (OTP Verification will send on this No)<span>*</span></label>
							
                            <input type="text" class="form-control numeric" id="authorised_mobile1" name="authorised_mobile1" value="<?php echo $authorised_mobile1;?>" maxlength="10" minlength="10" autocomplete="off">
							<div class="mt-1"></div>
							<a href="javascript:void(0)" id='send_otp' class="cta fade_anim mt-2" style="display:none;"><strong>Send OTP</strong></a>
							<p id="chkAuthoMob1"></p> 
							<div id='imgLoading1' style='display:none'><img src="https://registration.gjepc.org/images/loader.gif" alt="Uploading...."/></div>
                            </div>
							
							<input type="hidden" name="verified" id="verified" readonly/>
							
							<div class="form-group col-sm-4">
                                <label for="enter_otp">Enter OTP <span>*</span></label><div id="error" style="color:#FF0000;padding-left:50px;"></div>
                                <input type="text" class="form-control numeric" placeholder="Enter OTP" name="otp" id="otp" maxlength="4">
								<img src="https://gjepc.org/admin/images/active.png" class="tick" style="display:none;"/>
                            </div> 
							
							<div class="form-group col-sm-4">
                                <label for="authorised_mobile2">Mobile 2</label>
                                <input type="text" class="form-control numeric" id="authorised_mobile2" name="authorised_mobile2" value="<?php echo $authorised_mobile2;?>" maxlength="10" minlength="10" autocomplete="off">
                            </div> 
                                                    
                        	<div class="form-group col-sm-6">
                                <label for="authorised_email">Email <span>*</span></label><p id="chkAuthEmail"></p>
                                <input type="text" class="form-control" id="authorised_email" name="authorised_email" value="<?php echo $authorised_email;?>" autocomplete="off">
                            </div> 
                            <div class="form-group col-12">
                        	<label><input type="checkbox" name="agree_terms" value="yes" id="agree_terms"> Accept Terms And Condition</label>
                        	<a href="https://gjepc.org/terms-conditions-association.php" target="_blank" style="color: blue">Click Here to view</a>
                        	<label for="agree_terms" generated="true" class="error d-none">Accept Terms And Conditions</label>
							</div>                                                	
                        </div>
                            
              			<div class="form-group">
                      		<button type="submit" id='submit' class="cta fade_anim">Submit</button>
							<span class="otp-messages" style='color: green;'></span>
                        </div>     
					
                    </form>                                    
                </div>                            
            </div>    
	</div>    
    </div>
</section> 
<?php } ?>
</div>
<?php include 'include-new/footer_export.php'; ?>
<script>
$(document).ready(function(){
	$("#nature_of_buisness_other").hide();
	$("input[name='nature_of_buisness[]']").click(function(){
    var value =$('[name="nature_of_buisness[]"]:checked').val();
    if(value =="other"){
    	$("#nature_of_buisness_other").slideDown();
    }else{
        $("#nature_of_buisness_other").slideUp();
    }
	});
	/* Head Email Check */
	$("#head_email_id").change(function(){
	email_id=$("#head_email_id").val();
			$.ajax({
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkregisuser&email_id="+email_id,
					dataType:'html',
					beforeSend: function(){
						$('#preloader').show();
						$("#status").show();
					},
					success: function(data){						
							     //alert(data);
								$('#preloader').hide();
								$("#status").hide(); 
								 if(data==0){
								 	$('#submit').attr('disabled' , true);
									$("#chkheadregisuser").html("Already registered with this email id").css("color", "red"); 
								 }else{
								 	$("#chkheadregisuser").html("");
								 	$('#submit').removeAttr("disabled");
								 }
							}
		});
	});

	/* Head Mob 1 Check */
	$("#association_head_mobile_no1").change(function(){
	association_head_mobile_no1=$("#association_head_mobile_no1").val();
			$.ajax({
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkHeadeMob1&association_head_mobile_no1="+association_head_mobile_no1,
					dataType:'html',
					beforeSend: function(){
						$('#preloader').show();
						$("#status").show();
					},
					success: function(data){						
							    // alert(data);
								$('#preloader').hide();
								$("#status").hide(); 
								if($.trim(data)==0){
								 	$('#submit').attr('disabled', true);
									$("#chkHeadregisMob1").html("Already registered with this Mobile No").css("color", "red"); 
								} else {
								 	$("#chkHeadregisMob1").html("");
								 	$('#submit').removeAttr("disabled");
								}
							}
		});
	});
	
	/* Association Registration No Check */
	$("#association_registration_no").change(function(){
	association_registration_no=$("#association_registration_no").val();
			$.ajax({
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkAssocRegisNo&association_registration_no="+association_registration_no,
					dataType:'html',
					beforeSend: function(){
						$('#preloader').show();
						$("#status").show();
					},
					success: function(data){						
							    // alert(data);
								$('#preloader').hide();
								$("#status").hide(); 
								if($.trim(data)==0){
								 	$('#submit').attr('disabled', true);
									$("#chkRegisNo").html("Registration No Already Exist").css("color", "red"); 
								} else {
								 	$("#chkRegisNo").html("");
								 	$('#submit').removeAttr("disabled");
								}
							}
		});
	});
	
	/* Authorised Mob No1 Check */
	$("#authorised_mobile1").change(function(){
	authorised_mobile1=$("#authorised_mobile1").val();
			$.ajax({
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkAuthMobNo&authorised_mobile1="+authorised_mobile1,
					dataType:'html',
					beforeSend: function(){
						$('#preloader').show();
						$("#status").show();
					},
					success: function(data){						
							    // alert(data);
								$('#preloader').hide();
								$("#status").hide(); 
								if($.trim(data)==0){
								 	$('#submit').attr('disabled', true);
									$("#chkAuthoMob1").html("Mobile No Already Exist").css("color", "red"); 
								} else if($.trim(data)==2){
								 	$('#submit').attr('disabled', true);
									$("#chkAuthoMob1").html("Please Enter Mobile No").css("color", "red"); 
								} else {
									$('#send_otp').show();
								 	$("#chkAuthoMob1").html("");
								 	$('#submit').removeAttr("disabled");
								}
							}
		});
	});
	
	/*.............................Send OTP.......................................*/
	$('#send_otp').click(function(){
	authorised_mobile1=$('#authorised_mobile1').val();
			$.ajax({
				type:'POST',
				data:"actionType=sendOTP&authorised_mobile1="+authorised_mobile1,
				url:'ajax.php',
				dataType:'html',
				beforeSend: function(){
				/*$('#preloader').show();
				$("#status").show(); */
				$('#imgLoading1').show();	
				$('#send_otp').hide();
				},
			success: function(data){
				//alert(data);
				/*$('#preloader').hide();
				$("#status").hide(); */
				$('#imgLoading1').hide();
				$('#send_otp').show();
				//$('#send_otp').text('Resend OTP');	
			}
		});
	});
	
	/*.............................OTP Checking.......................................*/
	$('#otp').keyup(function(){
	mobile_no = $('#authorised_mobile1').val();
	otp = $('#otp').val();
	if(otp.length==4){
	$.ajax({
				type:'POST',
				data:"actionType=verifyOTP&mobile_no="+mobile_no+"&otp="+otp,
				url:'ajax.php',
				dataType:'html',
				beforeSend: function(){
				$('#preloader').show();
				$("#status").show();
				},
			success: function(data){
					$('#preloader').hide();
					$("#status").hide();
					if($.trim(data)=="verify"){
						$('.tick').show();
						$('#submit').removeAttr("disabled");
						$('#error').hide();
						$("#verified").val($.trim(data));
						$('#send_otp').hide();
						$('#authorised_mobile1').attr('readonly', true);
						$('#otp').attr('disabled', true);
					}
					else if($.trim(data)=="verified")
					{
						$('.tick').hide();
						$('#error').show()
						$('#error').html("This otp is already used");
						$('#submit').attr('disabled', true);
					}
					else if($.trim(data)=="invalid")
					{
						$('.tick').hide();
						$('#error').show()
						$('#error').html("Invalid OTP!. Please Enter Valid OTP");
						$('#submit').attr('disabled', true);
					}
					else
					{
						$('.tick').hide();
						$('#error').show()
						$('#error').html("This OTP is Already Used");
						$('#submit').attr('disabled', true);
					}
			}
		});
	}
	});
	
	/* Authorised Email Check */
	$("#authorised_email").change(function(){
	authorised_email=$("#authorised_email").val();
			$.ajax({
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkAuthEmail&authorised_email="+authorised_email,
					dataType:'html',
					beforeSend: function(){
						$('#preloader').show();
						$("#status").show();
					},
					success: function(data){						
							    // alert(data);
								$('#preloader').hide();
								$("#status").hide(); 
								if($.trim(data)==0){
								 	$('#submit').attr('disabled', true);
									$("#chkAuthEmail").html("Email ID Already Exist").css("color", "red"); 
								} else {
								 	$("#chkAuthEmail").html("");
								 	$('#submit').removeAttr("disabled");
								}
							}
		});
	});
	
});
</script>
<script>
$('.numeric').keypress(function (event) {
  var keycode = event.which;
  if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) 
  {
    event.preventDefault();
  }
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
			association_request_letter: {
				required: true,
			},
			company_name: {
				required: true,				
				specialChrs: true
			},
			association_registration_no: {
				required: true,
			}, 
			association_registration_certificate: {
				required: true,
			}, 
			association_head_name: { 
				required: true,
			},
			association_head_designation: { 
				required: true,
			}, 
			association_head_mobile_no1: {
				required: true,
				number:true,
				minlength:10,
				maxlength:10
			},
			head_email_id: {
				required: true,
				email:true
			},
			/*"nature_of_buisness[]":{
				required: true,
			},*/
			total_member: {
				required: true,
			}, 
			address_line1: {
				required: true,
			},
			address_line2: {
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
			no_of_parichay_card:{
				required:true
			},
			authorised_person:{
				required:true
			},
			authorised_designation:{
				required: true,
			},
			authorised_mobile1:{
				required:true,
				number:true,
				minlength:10,
				maxlength:10
			},
			otp: {
				required: true,
				number:true
			},	
			authorised_email:{
				required: true,
				email:true
			},
			agree_terms:{
				required:true
			}
			
		},
		messages: {
			association_request_letter: {
				required: "This is required.",
			},
			company_name: {
				required: "This is required.",
			},
			association_registration_no: {
				required: "This is required.",
			},
			association_registration_certificate: {
				required: "This is required.",
			},
			association_head_name: {
				required: "This is required.",
			},
			association_head_designation: {
				required: "This is required.",
			},
			association_head_mobile_no1: {
				required: "This is required.",
				number:"Please Enter numbers only",
				minlength:"Please Enter not less than 10 numbers",
				maxlength:"Please Enter not more than 10 numbers"				
			},
			head_email_id: {
				required: "This is required.",
			},
			/*"nature_of_buisness[]":{
				required: "This is required.",
			},*/
			total_member: {
				required: "This is required.",
			},
			address_line1: {
				required: "This is required.",
			},
			address_line2: {
				required: "This is required.",
			},
			city: {
				required: "This is required.",
			},
			state: {
				required: "This is required.",
			}, 
			pin_code: {
				required: "This is required.",
				number:"Please Enter numbers only",
				minlength:"Please Enter not less than 6 numbers",
				maxlength:"Please Enter not more than 6 numbers"				
			},
			no_of_parichay_card:{
				required: "This is required.",
			},
			authorised_person:{
				required: "This is required.",
			},
			authorised_designation:{
				required: "This is required.",
			},
			authorised_mobile1: {
				required: "This is required.",
				number:"Please Enter numbers only",
				minlength:"Please Enter not less than 10 numbers",
				maxlength:"Please Enter not more than 10 numbers"	
			},
			otp: {
				required:"Please Enter OTP",
				number:"Please Enter Valid OTP only"
			},
			authorised_email: {
				required: "This is required.",
			},
			agree_terms:{
				required:"Accept Terms And Conditions"
			}
	 }
	});
	
		$('#regisForm input').on('keyup blur', function () {
        if ($('#regisForm').valid()) {
			$("#regisForm").on("submit",function(e){
				$(".otp-messages").text("Please wait your data is submitting.....").show();
				$("#submit").hide();
			})
        }
    });
});

// language
function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage:'en',includedLanguages:'hi,en,gu,mr,bn,ml,ta,te,kn',layout:google.translate.TranslateElement.InlineLayout.SIMPLE },'google_translate_element');}
$(window).bind("load",function(){$("span:first",".goog-te-menu-value").text('English');})
</script>
<script type="text/javascript">
// $(document).ready(function () {
//     //Disable cut copy paste
//     $('body').bind('cut copy paste', function (e) {
//         e.preventDefault();
//     });
   
//     //Disable mouse right click
//     $("body").on("contextmenu",function(e){
//         return false;
//     });
    
// });
</script>
<!--<script type="text/javascript">
	$("#regisForm").on("submit",function(e){
	$("#preloader").fadeIn();
	$("#status").fadeIn();
	})
</script>-->
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
.terms_condition_div{ height: 100px; background: #eaeaea; overflow-y: scroll; border:1px solid #a59459; }
</style>