<?php
include 'include-new/header.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';
$registration_id = intval(filter($_SESSION['USERID']));

/* Check Association Application Details */
$getAllParichayData = "SELECT * from parichay_card where registration_id='$registration_id' AND parichay_type!='association' LIMIT 1";
$getData = $conn->query($getAllParichayData);
$countxx = $getData->num_rows;
$getAllRowsData = $getData->fetch_assoc();
$parichay_status = $getAllRowsData['parichay_status'];
$disapprove_reason = $getAllRowsData['disapprove_reason'];
$parichay_card_id = $getAllRowsData['parichay_card_id'];

/*if($countxx>0){
if($parichay_status=="P"){ echo "<script>alert('Please wait.. Status is Pending from Admin'); window.location = 'my_account.php';</script>";}
} else { 
  echo "<script>alert('Access Denied, You do not have permission to access this Page'); window.location = 'my_account.php';</script>"; 
} */

	$association_request_letter		=	$getAllRowsData['association_request_letter'];
	$association_registration_certificate	=	$getAllRowsData['association_registration_certificate'];
	$association_head_visiting_card	=	$getAllRowsData['association_head_visiting_card'];
	$association_office_address		=	$getAllRowsData['association_office_address'];
	
	$association_registration_no	=	strtoupper(filter($getAllRowsData['association_registration_no']));
	$association_head_name			=	strtoupper(filter($getAllRowsData['association_head_name']));
	$association_head_designation	=	strtoupper(filter($getAllRowsData['association_head_designation']));
	$association_head_mobile_no1	=	filter($getAllRowsData['association_head_mobile_no1']);
	$association_head_mobile_no2	=	filter($getAllRowsData['association_head_mobile_no2']);
	$total_member					=	filter($getAllRowsData['total_member']);

	$getAllParichayRegisData = "SELECT * from registration_master where id='$registration_id' and parichay_type!='association' LIMIT 1";
	$getRegisData = $conn->query($getAllParichayRegisData);
	$getRowsRegisData = $getRegisData->fetch_assoc();
	
	$company_name 					= 	strtoupper(str_replace('&amp;', '&', $getRowsRegisData['company_name']));
	$head_email_id					=	$getRowsRegisData['email_id'];
	$company_type					=	$getRowsRegisData['company_type'];
	$address_line1					=	$getRowsRegisData['address_line1'];
	$address_line2					=	$getRowsRegisData['address_line2'];
	$city							=	$getRowsRegisData['city'];
	$state							=	$getRowsRegisData['state'];
	$pin_code						=   $getRowsRegisData['pin_code'];	
	$nature_of_buisness   			=   $getRowsRegisData['nature_of_buisness'];
	
	$no_of_parichay_card 			=   filter($getAllRowsData['no_of_parichay_card']);
	
	$authorised_person			=	strtoupper(filter($getAllRowsData['authorised_person']));
	$authorised_designation		=	strtoupper(filter($getAllRowsData['authorised_designation']));
	$authorised_mobile1			=	filter($getAllRowsData['authorised_mobile1']);
	$authorised_mobile2			=	filter($getAllRowsData['authorised_mobile2']);
	$authorised_email			=	filter($getAllRowsData['authorised_email']);


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

$sqlxy = "SELECT authorised_email FROM parichay_card WHERE parichay_card_id!='$parichay_card_id'";
$resultxy = $conn ->query($sqlxy);
$match_registration_no = array();
$match_authorised_email= array();
while($mysqlrow = $resultxy->fetch_array())
{
//echo '<pre>'; print_r($mysqlrow); 
$val_authorised_email = $mysqlrow['authorised_email'];

$match_registration_no[]  = $val_registration_no;
$match_authorised_email[] = $val_authorised_email;
}

if(empty($company_name))
{ $signup_error = "Association Name required."; }

elseif(empty($association_head_name))
{ $signup_error = "Association Head Name required."; }
elseif(empty($association_head_designation))
{ $signup_error = "Association Head Designation required."; }

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

/* Authorised Person Email Check */
elseif(empty($authorised_email))
{ $signup_error = "Authorised Person Email required"; }
elseif(!ninjaxMailCheck($authorised_email))
{ $signup_error = $authorised_email. " is Invalid Email Id"; }
elseif(in_array($authorised_email, $match_authorised_email))
{ $signup_error = "Authorised Person Email Already Exist"; }

 elseif(empty($association_request_letter) || empty($association_registration_certificate))
{ $signup_error="Please Upload the required Document"; }
else
{
		 
	if($registration_id!=''){
	$sql1 = "UPDATE `parichay_card` SET `mod_date`=NOW(),`association_registration_no`='$association_registration_no'";
	if(isset($association_request_letter) && $association_request_letter!='')
		$sql1.=",`association_request_letter`='$association_request_letter'";
	if(isset($association_registration_certificate) && $association_registration_certificate!='')
		$sql1.=",`association_registration_certificate`='$association_registration_certificate'";
	if(isset($association_head_visiting_card) && $association_head_visiting_card!='')
		$sql1.=",`association_head_visiting_card`='$association_head_visiting_card'";
	if(isset($association_office_address) && $association_office_address!='')
		$sql1.=",`association_office_address`='$association_office_address'";
	$sql1.=",`association_head_name`='$association_head_name',`association_head_designation`='$association_head_designation',`association_head_mobile_no2`='$association_head_mobile_no2',`total_member`='$total_member',`no_of_parichay_card`='$no_of_parichay_card',`authorised_person`='$authorised_person',`authorised_designation`='$authorised_designation',`authorised_mobile2`='$authorised_mobile2',`authorised_email`='$authorised_email' WHERE registration_id='$registration_id'";	
//	echo $sql1;
	$resultx = $conn ->query($sql1);
	if($resultx){
	 echo "<script langauge=\"javascript\">alert(\"Detail has been updated successfully.\");location.href='company-profile-details.php';</script>";
	} else { $_SESSION['err_msg']="Something Missing"; }
	}
}
} else { $_SESSION['err_msg']="Invalid Token Error"; }
}
?>

<?php
if($_SESSION['err_msg']!=""){
echo "<div class='text-center'><span style='color: red;'>".$_SESSION['err_msg']."</span></div>";
$_SESSION['err_msg']="";
}
?>

<section class="py-5">	
    <div class="container inner_container">
	
		<div class="row justify-content-center grey_title_bg">           	
            <div class="bold_font text-center"> 
			<div class="d-block"><img src="assets/images/gold_star.png"></div>Company Profile </div>                    
        </div>
              	           
     </div>       
                
            <div class="container">				
                <div class="row justify-content-between ">
                 <div class=" col-md-12">  
				<?php if($parichay_status=="D" || $parichay_status=="P"){ ?><a href="#" class="cta fade_anim mb-3 d-inline-block">Add your Karigar here</a> <?php } else { ?> <a class="cta fade_anim mb-3 d-inline-block" href="person-list.php">Add your Karigar here</a><?php } ?>
			    </div>
                <div class="col-lg-auto order-lg-12 col-md-4" data-sticky_parent>
				<?php include 'include/regMenu.php'; ?>
				</div>
				
				<?php if($parichay_status=="D" || $parichay_status=="P"){ ?>
                <div class="col-md-8">   
				
                <form class="cmxform box-shadow mb-5" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" name="regisForm" id="regisForm" enctype="multipart/form-data" autocomplete="off"/>
				<input type="hidden" name="action" value="save"/>	
				<?php token(); ?>	
				<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>';} ?>
				<?php if(isset($signup_success)){ echo '<div class="alert alert-success" role="alert">'.$signup_success.'</div>';} ?>
				<?php if(isset($signup_aadhar)){ echo '<div class="alert alert-danger" role="alert">'.$signup_aadhar.'</div>';} ?>
				
			
                    <div class="row mb-4">                    
                    <div class="form-group col-12 mb-4">
                        <p class="blue">Company Enrolment Process</p> 
                    </div>
                            <div class="form-group col-12">
                            <label for="association_request_letter">Company letter head<span>*</span></label>
                            
                            <div class="row align-items-center">
                                <div class="col-6"><input type="file" id="association_request_letter" name="association_request_letter" class="form-control" autocomplete="off"></div>									
                                <?php if(!empty($association_request_letter)){ ?>
                                <div class="col-6">
                                <a href="images/parichay_card/association_request_letter/<?php echo $association_request_letter;?>"   target="_blank" class="cta fade_anim"> View</a>
                                </div>
								<?php } ?>
                            </div>
                            </div>
							
                            <div class="form-group col-sm-6">
							<label for="company_name">Company Name<span>*</span></label>
							<input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $company_name;?>" autocomplete="off" maxlength="40" readonly>
							</div>                    
                        
							<div class="form-group col-sm-6">
							<label for="company_type">Company Registration Type<span>*</span></label>
							<div class="mt-2">                                       
                                    <label for="Propritory" class="mr-3">
                                    <input type="radio" id="company_type" name="company_type" value="14" <?php if($company_type==14){ echo 'checked="checked"'; } ?>> Propritory
                                    </label>
                                    <label for="Partnership" class="mr-3">
                                    <input type="radio" id="company_type" name="company_type" value="11" <?php if($company_type==11){ echo 'checked="checked"'; } ?>> Partnership
                                    </label>
                                    <label for="Private" class="mr-3">
                                    <input type="radio" id="company_type" name="company_type" value="13" <?php if($company_type==13){ echo 'checked="checked"'; } ?>> Private Ltd.
                                    </label>                          
                                    <label for="Public">
                                    <input type="radio" id="company_type" name="company_type" value="12" <?php if($company_type==12){ echo 'checked="checked"'; } ?>> Public Ltd.
                                    </label>
                                    <label for="company_type" generated="true" style="display: none;" class="error">Please Select Company type</label>
                                </div>
							</div>
														
							<div class="form-group col-sm-6">                            	
                            <label for="association_registration_certificate">Scanned copy of company registration details<span>*</span></label>
                            
                            	<div class="row align-items-center">                                	
                                    <div class="col">
                                    	<input type="file" id="association_registration_certificate" name="association_registration_certificate" class="form-control" autocomplete="off">
                                    </div>
                                    
                                    <?php if(!empty($association_registration_certificate)){ ?>
                                    <div class="col-auto pl-0">
                                    <a href="images/parichay_card/association_registration_certificate/<?php echo $association_registration_certificate;?>"   target="_blank" class="cta fade_anim"> View </a>
                                    </div>
									<?php } ?>                                                                   
                                </div>
                            </div>
							
							<div class="form-group col-sm-6">
							<label for="association_head_name">Full Name of Company head<span>*</span></label>
							<input type="text" class="form-control mt-4" id="association_head_name" name="association_head_name" value="<?php echo $association_head_name;?>" autocomplete="off" maxlength="30">
							</div>
							
							<div class="form-group col-sm-6">
                            <label for="association_head_visiting_card">Scanned copy of visiting card</label>
                            
                            <div class="row align-items-center">                                	
                                    <div class="col">
                                    	 <input type="file" id="association_head_visiting_card" name="association_head_visiting_card" class="form-control" autocomplete="off">
                                    </div>
                                    
                                   <?php if(!empty($association_head_visiting_card)){ ?>
                                    <div class="col-auto pl-0">
                                    <a href="images/parichay_card/association_head_visiting_card/<?php echo $association_head_visiting_card;?>" target="_blank" class="cta fade_anim">  View </a>
                                    </div>
									<?php } ?>
                            </div>  
                            </div>
                        
							<div class="form-group col-sm-6">
							<label for="association_head_designation">Designation of Company Head<span>*</span></label>
							<input type="text" class="form-control" id="association_head_designation" name="association_head_designation" value="<?php echo $association_head_designation;?>" autocomplete="off" maxlength="30">
							</div>
							
							<div class="form-group col-sm-6">
							<label for="association_head_mobile_no1">Mobile No 1 of the Company Head<span>*</span></label>
														
							<input type="text" class="form-control numeric" id="association_head_mobile_no1" name="association_head_mobile_no1" value="<?php echo $association_head_mobile_no1;?>" maxlength="10" minlength="10" autocomplete="off" readonly>
							<p id="chkHeadregisMob1"></p>
							</div> 
							
							<div class="form-group col-sm-6">
							<label for="association_head_mobile_no2">Mobile No 2 of the Company Head</label>
							<input type="text" class="form-control numeric" id="association_head_mobile_no2" name="association_head_mobile_no2" value="<?php echo $association_head_mobile_no2;?>" maxlength="10" minlength="10" autocomplete="off">
							</div> 
							
							<div class="form-group col-sm-6">
							<label for="head_email_id">Email ID of the Company Head<span>*</span></label>
							
							<input type="text" class="form-control" id="head_email_id" name="head_email_id" value="<?php echo $head_email_id;?>" autocomplete="off" maxlength="30" readonly>
							<p id="chkheadregisuser" style="color:#FF0000; display:block;"></p>
							</div>
							
							<div class="form-group col-sm-6">
							<label for="total_member">Total No. of Members in Company as on date </label>
							<input type="text" class="form-control numeric" id="total_member" name="total_member" value="<?php echo $total_member;?>" autocomplete="off" maxlength="5" onkeypress="if(this.value.length==5) return false;">
							</div> 
							
							<div class="form-group col-12">
                            <div class="d-block"><label for="nature_of_business" class="tr" key="Business"><strong>Business Nature</strong></label></div>						
                            
                            <div class="row">
                            
                            <div class="col-md-3 px-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Jewellery" <?php if(preg_match('/Jewellery/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>
							<span class="tr" key="Jewellery"> Jewellery</span>	
                            </div>						
                            
                            <div class="col-md-3 px-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Diamond" <?php if(preg_match('/Diamond/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>
							<span class="tr" key="Diamond"> Diamond</span>
                            </div>
							
                            <div class="col-md-3 px-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Coloured_Gemstone" <?php if(preg_match('/Coloured_Gemstone/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>
							<span class="tr" key="Coloured_Gemstone"> Coloured Gemstone </span>
                            </div>
							
                            <div class="col-md-3 px-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Retailer" <?php if(preg_match('/Retailer/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>
							<span class="tr" key="Retailer"> Retailer</span>
                            </div>
							
                            <div class="col-md-3 px-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Job_work" <?php if(preg_match('/Job_work/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>
							<span class="tr" key="Job_work"> Job work</span>
                            </div>
							
							<div class="col-md-6 px-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Laboratory_Grown_Diamonds" <?php if(preg_match('/Laboratory_Grown_Diamonds/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>
							<span class="tr" key="Laboratory_Grown_Diamonds"> Laboratory Grown Diamonds</span>
                            </div>
                            
                            <!--<div>                            
							<span class="tr" key="Other">Others please specify</span>
							<div><input type="text" name="nature_of_buisness[]" id="other" class="form-control" style="width:100px; height:30px;"  autocomplete="off">
                            </div>                            
                            </div> -->                           
							</div>
							
							</div>			
						<div class="form-group col-12">
                          <p class="blue">Registered Address of the Company</p>                                
                        </div>
						
						<div class="form-group col-sm-6">
                            <label for="address_line1">Address 1<span>*</span></label>
                            <input type="text" class="form-control" id="address_line1" name="address_line1" value="<?php echo $address_line1;?>" autocomplete="off">
                        </div>
						
						<div class="form-group col-sm-6">
                            <label for="address_line2">Address 2<span>*</span></label>
                            <input type="text" class="form-control" id="address_line2" name="address_line2" value="<?php echo $address_line2;?>" autocomplete="off">
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label for="city">City <span>*</span></label>
                            <input type="text" class="form-control" id="city" name="city" value="<?php echo $city;?>" maxlength="20" autocomplete="off">
                        </div>
                        
                        <div class="form-group col-sm-6">
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
                        
                        <div class="form-group col-sm-6">
                        <label for="pin_code">Pincode <span>*</span></label>
                        <input type="text" class="form-control numeric" id="pin_code" name="pin_code" value="<?php echo $pin_code;?>" autocomplete="off" maxlength="6" onkeypress="if(this.value.length==6) return false;">
                        </div>
						
						<div class="form-group col-sm-6">
                        <label for="no_of_parichay_card">No. of Parichay Cards required by your company</label>
                        <input type="text" class="form-control numeric" id="no_of_parichay_card" name="no_of_parichay_card" value="<?php echo $no_of_parichay_card;?>" autocomplete="off" maxlength="3" onkeypress="if(this.value.length==3) return false;">
                        </div>
						
						<div class="form-group col-12">
                        <label for="association_office_address">Please upload scanned proof of address of company office (Electricity Bill, Phone Bill etc.)</label>	
                        
                        <div class="row align-items-center">                        	
                            <div class="col-6">
                        		<input type="file" id="association_office_address" name="association_office_address" class="form-control" autocomplete="off">
                            </div>
                            
                            	<?php if(!empty($association_office_address)){ ?>
                                   <div class="col-6">
                                    <a href="images/parichay_card/association_office_address/<?php echo $association_office_address;?>" target="_blank" class="cta fade_anim">View </a>
                                    </div>
									<?php } ?>
                                                                
                        </div>
                        </div>
						
						
						
						<div class="form-group col-12 mb-4">
                        <p class="blue">Details of Authorised person from company for coordination and verification of information:</p> </div> 
							                                
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
                                                        
                            <div class="form-group col-sm-6">
                                <label for="authorised_mobile1">Mobile 1</label> 
                                <input type="text" class="form-control numeric" id="authorised_mobile1" name="authorised_mobile1" value="<?php echo $authorised_mobile1;?>" maxlength="10" minlength="10" autocomplete="off" readonly>	
                                <label id="chkAuthoMob1"></label>			
                            </div>
							
							<div class="form-group col-sm-6">
                                <label for="authorised_mobile2">Mobile 2</label>
                                <input type="text" class="form-control numeric" id="authorised_mobile2" name="authorised_mobile2" value="<?php echo $authorised_mobile2;?>" maxlength="10" minlength="10" autocomplete="off">
                            </div> 
                                                    
                        	<div class="form-group col-sm-6">
                                <label for="authorised_email">Email <span>*</span></label><p id="chkAuthEmail"></p>
                                <input type="text" class="form-control" id="authorised_email" name="authorised_email" value="<?php echo $authorised_email;?>" autocomplete="off">
                            </div>                                                 	
                        </div>
                        <?php if($parichay_status=="D"){ ?>   
              			<div class="form-group">
						<input type="hidden" name="parichay_card_id" id="parichay_card_id" value="<?php echo $parichay_card_id;?>">
                      		<button type="submit" id='submit' class="cta fade_anim">Modify</button>
                        </div>     
						<?php } ?>
				<p>Status : <?php if($parichay_status=="D"){ echo "Disapproved"; } else { echo "Pending"; }?></p>				
				<?php if($parichay_status=="D"){ ?> <p>Reason of disapprove : <?php echo $disapprove_reason;?></p><?php } ?>
                
				</form> 
                </div>   
				<?php } ?>
				<?php if($parichay_status=="Y"){ ?>
				<div class="col-lg col-md-12"> 			
                <form class="cmxform box-shadow mb-5" action="" method="post" autocomplete="off"/>
				
				<div class="row ab_none justify-content-between align-items-center">
                	<div class="col-12 mb-3"><p class="mt-2 text-left">
					<strong>Company Enrolment Process</strong></p></div>
                </div>
                    <div class="row mb-4">                    
                                     
                            <div class="form-group col-12">
                            <label for="association_request_letter">Company letter head</label>                                                          								
                                <?php if(!empty($association_request_letter)){ ?>
                                <div class="col-6">
                                <a href="images/parichay_card/association_request_letter/<?php echo $association_request_letter;?>"   target="_blank" class="cta fade_anim"> View </a>
                                </div>
								<?php } ?>
                            </div>
                           
							
                            <div class="form-group col-sm-6">
							<label for="company_name">Company Name<span>*</span></label>
							<input type="text" class="form-control" id="company_name" name="company_name" value="<?php echo $company_name;?>" autocomplete="off" maxlength="40" readonly>
							</div>                    
                        
							<div class="form-group col-sm-6">
							<label for="company_type">Company Registration Type<span>*</span></label>
							<div class="mt-2">                                       
                                    <label for="Propritory" class="mr-3">
                                    <input type="radio" id="company_type" name="company_type" value="14" <?php if($company_type==14){ echo 'checked="checked"'; } ?>> Propritory
                                    </label>
                                    <label for="Partnership" class="mr-3">
                                    <input type="radio" id="company_type" name="company_type" value="11" <?php if($company_type==11){ echo 'checked="checked"'; } ?>> Partnership
                                    </label>
                                    <label for="Private" class="mr-3">
                                    <input type="radio" id="company_type" name="company_type" value="13" <?php if($company_type==13){ echo 'checked="checked"'; } ?>> Private Ltd.
                                    </label>                          
                                    <label for="Public">
                                    <input type="radio" id="company_type" name="company_type" value="12" <?php if($company_type==12){ echo 'checked="checked"'; } ?>> Public Ltd.
                                    </label>
                                    <label for="company_type" generated="true" style="display: none;" class="error">Please Select Company type</label>
                                </div>
							</div>
							
							<div class="form-group col-sm-6">                            	
                            <label for="association_registration_certificate">Scanned copy of company registration<span>*</span></label>
                            
                            	<div class="row align-items-center">                              	
                                   
                                    <?php if(!empty($association_registration_certificate)){ ?>
                                    <div class="col-auto pl-0">
                                    <a href="images/parichay_card/association_registration_certificate/<?php echo $association_registration_certificate;?>"   target="_blank" class="cta fade_anim"> View </a>
                                    </div>
									<?php } ?>                                                                   
                                </div>
                            </div>
							
							<div class="form-group col-sm-6">
							<label for="association_head_name">Full Name of Company head<span>*</span></label>
							<input type="text" class="form-control" id="association_head_name" name="association_head_name" value="<?php echo $association_head_name;?>" autocomplete="off" maxlength="30" readonly>
							</div>
							
							<div class="form-group col-sm-6">
                            <label for="association_head_visiting_card">Scanned copy of visiting card</label>
                            
                            <div class="row align-items-center">                               	
                                                                     
                                   <?php if(!empty($association_head_visiting_card)){ ?>
                                    <div class="col-auto pl-0">
                                    <a href="images/parichay_card/association_head_visiting_card/<?php echo $association_head_visiting_card;?>" target="_blank" class="cta fade_anim">  View </a>
                                    </div>
									<?php } ?>
                            </div>  
                            </div>
                        
							<div class="form-group col-sm-6">
							<label for="association_head_designation">Designation of Company Head<span>*</span></label>
							<input type="text" class="form-control" id="association_head_designation" name="association_head_designation" value="<?php echo $association_head_designation;?>" autocomplete="off" maxlength="30" readonly>
							</div>
							
							<div class="form-group col-sm-6">
							<label for="association_head_mobile_no1">Mobile No 1 of the Company Head<span>*</span></label>
							<p id="chkHeadregisMob1"></p>							
							<input type="text" class="form-control numeric" id="association_head_mobile_no1" name="association_head_mobile_no1" value="<?php echo $association_head_mobile_no1;?>" maxlength="10" minlength="10" autocomplete="off" readonly>
							</div> 
							
							<div class="form-group col-sm-6">
							<label for="association_head_mobile_no2">Mobile No 2 of the Company Head</label>
							<input type="text" class="form-control numeric" id="association_head_mobile_no2" name="association_head_mobile_no2" value="<?php echo $association_head_mobile_no2;?>" maxlength="10" minlength="10" autocomplete="off" readonly>
							</div> 
							
							<div class="form-group col-sm-6">
							<label for="head_email_id">Email ID of the Company Head<span>*</span></label>
							<p id="chkheadregisuser" style="color:#FF0000; display:block;"></p>
							<input type="text" class="form-control" id="head_email_id" name="head_email_id" value="<?php echo $head_email_id;?>" autocomplete="off" maxlength="30" readonly>
							</div>
							
							<div class="form-group col-sm-6">
							<label for="total_member">Total No. of Members in Company as on date </label>
							<input type="text" class="form-control numeric" id="total_member" name="total_member" value="<?php echo $total_member;?>" autocomplete="off" maxlength="5" onkeypress="if(this.value.length==5) return false;" readonly>
							</div> 
							
							<div class="form-group col-12">
                            <div class="d-block"><label for="nature_of_business" class="tr" key="Business"><strong>Business Nature</strong></label></div>						
                            
                            <div class="d-flex align-items-center">
                            
                            <div class="col-auto px-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Jewellery" <?php if(preg_match('/Jewellery/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>
							<span class="tr" key="Jewellery"> Jewellery</span>	
                            </div>						
                            
                            <div class="col-auto px-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Diamond" <?php if(preg_match('/Diamond/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>
							<span class="tr" key="Diamond"> Diamond</span>
                            </div>
							
                            <div class="col-auto px-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Coloured_Gemstone" <?php if(preg_match('/Coloured_Gemstone/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>
							<span class="tr" key="Coloured_Gemstone"> Coloured Gemstone </span>
                            </div>
							
                            <div class="col-auto px-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Retailer" <?php if(preg_match('/Retailer/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>
							<span class="tr" key="Retailer"> Retailer</span>
                            </div>
							
                            <div class="col-auto px-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Job_work" <?php if(preg_match('/Job_work/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>
							<span class="tr" key="Job_work"> Job work</span>
                            </div>
							
							<div class="col-auto px-2">
                            <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Laboratory_Grown_Diamonds" <?php if(preg_match('/Laboratory_Grown_Diamonds/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>
							<span class="tr" key="Laboratory_Grown_Diamonds"> Laboratory Grown Diamonds</span>
                            </div>
                            
                            <!--<div>                            
							<span class="tr" key="Other">Others please specify</span>
							<div><input type="text" name="nature_of_buisness[]" id="other" class="form-control" style="width:100px; height:30px;"  autocomplete="off">
                            </div>                            
                            </div> -->                           
							</div>
							
							</div>			
						<div class="form-group col-12">
                          <p class="blue">Official Address of the Company</p>                                
                        </div>
						
						<div class="form-group col-sm-6">
                            <label for="address_line1">Address 1<span>*</span></label>
                            <input type="text" class="form-control" id="address_line1" name="address_line1" value="<?php echo $address_line1;?>" autocomplete="off" readonly>
                        </div>
						
						<div class="form-group col-sm-6">
                            <label for="address_line2">Address 2<span>*</span></label>
                            <input type="text" class="form-control" id="address_line2" name="address_line2" value="<?php echo $address_line2;?>" autocomplete="off" readonly>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label for="city">City <span>*</span></label>
                            <input type="text" class="form-control" id="city" name="city" value="<?php echo $city;?>" maxlength="20" autocomplete="off" readonly>
                        </div>
                        
                        <div class="form-group col-sm-6">
                            <label for="mobile_no">State <span>*</span></label>
                            <select name="state" id="state" class="form-control" disabled>
                            <option value="">--- Select State ---</option>
                            <?php 
                            $stat = $conn ->query("SELECT * from state_master WHERE country_code = 'IN'");
                            while($result = $stat->fetch_assoc()){ ?>
							<option value="<?php echo filter($result['state_code']);?>" <?php if($result['state_code']==$state){?> selected="selected" <?php }?>><?php echo strtoupper(filter($result['state_name']));?></option>
                            <?php } ?>
                            </select>
                        </div>
                        
                        <div class="form-group col-sm-6">
                        <label for="pin_code">Pincode <span>*</span></label>
                        <input type="text" class="form-control numeric" id="pin_code" name="pin_code" value="<?php echo $pin_code;?>" autocomplete="off" maxlength="6" onkeypress="if(this.value.length==6) return false;" readonly>
                        </div>
						
						<div class="form-group col-sm-6">
                        <label for="no_of_parichay_card">No. of Parichay Cards required by your Company</label>
                        <input type="text" class="form-control numeric" id="no_of_parichay_card" name="no_of_parichay_card" value="<?php echo $no_of_parichay_card;?>" autocomplete="off" maxlength="3" onkeypress="if(this.value.length==3) return false;" readonly>
                        </div>
						
						<div class="form-group col-12">
                        <label for="association_office_address">Please upload scanned proof of address of company office (Electricity Bill, Phone Bill etc.)</label>	
                        
                        <div class="row align-items-center">                              
                            <?php if(!empty($association_office_address)){ ?>
                            <div class="col-6">
                            <a href="images/parichay_card/association_office_address/<?php echo $association_office_address;?>" target="_blank" class="cta fade_anim"> View </a>
                            </div>
							<?php } ?>                       
                        </div>
                        </div>
												
						<div class="form-group col-12 mb-4">
                        <p class="blue">Details of Authorised person from company for coordination and verification of information:</p> </div> 
							                                
					</div>
              
                        <div class="row mb-4"> 
                            <div class="form-group col-sm-6">
                                <label for="authorised_person">Full Name<span>*</span></label>
                                <input type="text" class="form-control" id="authorised_person" name="authorised_person" value="<?php echo $authorised_person;?>" maxlength="50" autocomplete="off" readonly>
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="authorised_designation">Designation<span>*</span></label>
                                <input type="text" class="form-control" id="authorised_designation" name="authorised_designation" value="<?php echo $authorised_designation;?>" autocomplete="off" readonly>
                            </div>
                                                        
                            <div class="form-group col-sm-6">
                                <label for="authorised_mobile1">Mobile 1</label>
                                <input type="text" class="form-control numeric" id="authorised_mobile1" name="authorised_mobile1" value="<?php echo $authorised_mobile1;?>" maxlength="10" minlength="10" autocomplete="off" readonly>	
                                <label id="chkAuthoMob1"></label> 			
                            </div>
							
							<div class="form-group col-sm-6">
                                <label for="authorised_mobile2">Mobile 2</label>
                                <input type="text" class="form-control numeric" id="authorised_mobile2" name="authorised_mobile2" value="<?php echo $authorised_mobile2;?>" maxlength="10" minlength="10" autocomplete="off" readonly>
                            </div> 
                                                    
                        	<div class="form-group col-sm-6">
                                <label for="authorised_email">Email <span>*</span></label><p id="chkAuthEmail"></p>
                                <input type="text" class="form-control" id="authorised_email" name="authorised_email" value="<?php echo $authorised_email;?>" autocomplete="off" readonly>
                            </div>                                                 	
                        </div>
					
                    </form> 
                </div>
				<?php } ?>
                </div>                            
            </div>    
           
</section> 
</div>
<?php include 'include-new/footer_export.php'; ?>
<script>
$(document).ready(function(){
	
	/* Association Registration No Check */
	$("#association_registration_no").change(function(){
	association_registration_no=$("#association_registration_no").val();
	var parichay_card_id=$("#parichay_card_id").val(); 
			$.ajax({
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkAssocRegisNo&association_registration_no="+association_registration_no+"&parichay_card_id="+parichay_card_id,
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
	
	/* Authorised Email Check */
	$("#authorised_email").change(function(){
	authorised_email=$("#authorised_email").val();
	var parichay_card_id=$("#parichay_card_id").val(); 
			$.ajax({
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkAuthEmail&authorised_email="+authorised_email+"&parichay_card_id="+parichay_card_id,
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
			company_name: {
				required: true,				
				specialChrs: true
			},
			association_registration_no: {
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
			/*'nature_of_buisness[]': {
				required: true,
			}, */
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
			
		},
		messages: {
			company_name: {
				required: "This is required.",
			},
			association_registration_no: {
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
			/*'nature_of_buisness: {
				required: "This is required.",
			},*/
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
	 }
	});
	
		/*$('#regisForm input').on('keyup blur', function () {
        if ($('#regisForm').valid()) {
			$("#regisForm").on("submit",function(e){
				$(".otp-messages").text("Please wait your data is submitting.....").show();
				$("#submit").hide();
			})
        }
		}); */
});

// language
function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage:'en',includedLanguages:'hi,en,gu,mr,bn,ml,ta,te,kn',layout:google.translate.TranslateElement.InlineLayout.SIMPLE },'google_translate_element');}
$(window).bind("load",function(){$("span:first",".goog-te-menu-value").text('English');})
</script>
<!--<script type="text/javascript">
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
</script>-->
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
</style>