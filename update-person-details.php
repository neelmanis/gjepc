<?php
include 'include-new/header.php';
if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; }
include 'db.inc.php';
include 'functions.php';
$registration_id = intval(filter($_SESSION['USERID']));

$encrypted_id = $_GET['person_id'];
$person_id = base64_decode($encrypted_id);

if(!isset($person_id)){ header('location:person-list.php'); }
$parichay_type = isApplied_for_parichay($registration_id,$conn);
/* Check Person Application Details */
/* if($parichay_status=="P"){ echo "<script>alert('Please wait.. Status is Pending from Admin'); window.location = 'my_account.php';</script>";
} else if($parichay_status=="D"){ echo "<script>alert('Please wait.. Status is DisApprove from Admin'); window.location = 'my_account.php';</script>"; 
} */
	$getAllParichayData = "SELECT * from parichay_person_details where registration_id='$registration_id' AND person_id='$person_id' LIMIT 1";
	$getData = $conn->query($getAllParichayData);
	$countxx = $getData->num_rows;
	$getAllRowsData = $getData->fetch_assoc();
	
	$parichay_status = $getAllRowsData['parichay_status'];

	$photo	=	$getAllRowsData['photo'];
	$id_proof	=	$getAllRowsData['id_proof'];
	$upload_bank_documents	=	$getAllRowsData['upload_bank_documents'];
	
	$fname	=	strtoupper(filter($getAllRowsData['fname']));
	$mname	=	strtoupper(filter($getAllRowsData['mname']));
	$surname =	strtoupper(filter($getAllRowsData['surname']));
	$date_of_birth	=	date('Y-m-d',strtotime($getAllRowsData['date_of_birth']));
	$gender			=	strtoupper(filter($getAllRowsData['gender']));
	$blood_group	=	$getAllRowsData['blood_group'];
	$education	=	filter($getAllRowsData['education']);
	$mobile1	=	filter($getAllRowsData['mobile1']);
	$mobile2	=	filter($getAllRowsData['mobile2']);
	$email_id	=	filter($getAllRowsData['email']);
	$p_address1	= strtoupper(filter($getAllRowsData['p_address1']));
	$p_address2	= strtoupper(filter($getAllRowsData['p_address2']));
	$p_city	= strtoupper(filter($getAllRowsData['p_city']));
	$p_state	= strtoupper(filter($getAllRowsData['p_state']));
	$p_pin_code	= strtoupper(filter($getAllRowsData['p_pin_code']));
	
	$same_address = $getAllRowsData['same_address'];	
    
	$c_address1 = strtoupper(filter($getAllRowsData['c_address1']));
	$c_address2 = strtoupper(filter($getAllRowsData['c_address2']));
	$c_city = strtoupper(filter($getAllRowsData['c_city']));
	$c_state = filter($getAllRowsData['c_state']);
	$c_pin_code = filter($getAllRowsData['c_pin_code']);
	$c_address1 = strtoupper(filter($getAllRowsData['c_address1']));
		
	$bank			=	filter($getAllRowsData['bank']);
	$account_no		=	filter($getAllRowsData['account_no']);
	$ifsc			=	filter($getAllRowsData['ifsc']);
	$employment_status	=	filter($getAllRowsData['employment_status']);
	$work_experience	=	filter($getAllRowsData['work_experience']);
	$applicable_industry =	filter($getAllRowsData['applicable_industry']);
		
	$applicable_skills   = $getAllRowsData['applicable_skills'];	
	foreach($applicable_skills as $val)
	{
		if($val=="other")
		{
			$skills_other=$getAllRowsData['skills_other'];
			$applicable_skills_new.=$skills_other.",";
		} else	{
			$applicable_skills_new.=$val.",";	
		}
	}
	
	$swasthya_kosh_option	=	filter($getAllRowsData['swasthya_kosh_option']);
	if($getAllRowsData['swasthya_kosh_option']=="Y"){ $swasthya_kosh_option	=	$getAllRowsData['swasthya_kosh_option']; } else {  $swasthya_kosh_option	= "N"; }

	$spouse_name			=	strtoupper(filter($getAllRowsData['spouse_name']));
	$isPremium			=	strtoupper(filter($getAllRowsData['isPremium']));
	$spouse_gender			=	strtoupper(filter($getAllRowsData['spouse_gender']));
	if($getAllRowsData['spouse_dob'] !==""){
		$spouse_dob			=	date('Y-m-d',strtotime($getAllRowsData['spouse_dob']));
	}else{
	    $spouse_dob	 ="";	
	}

	$spouse_age			=	filter($getAllRowsData['spouse_age']);
	$child1				=	strtoupper(filter($getAllRowsData['child1']));
	$child1_gender		=	filter($getAllRowsData['child1_gender']);
	if($getAllRowsData['child1_dob'] !=""){
		$child1_dob			=	date('Y-m-d',strtotime($getAllRowsData['child1_dob'])); 
	}else{
		$child1_dob ="";
	}
	$child1_age			=	filter($getAllRowsData['child1_age']);
	$child2				=	strtoupper(filter($getAllRowsData['child2']));
	$child2_gender		=	filter($getAllRowsData['child2_gender']);
	if($getAllRowsData['child2_dob']!=""){
		$child2_dob			=	date('Y-m-d',strtotime($getAllRowsData['child2_dob'])); 
	}else{
		$child2_dob ="";
	}
	$child2_age			=	filter($getAllRowsData['child2_age']);
	

$action = trim($_REQUEST['action']);
if($action=="save")
{ 
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$person_id = base64_decode($_REQUEST['person_id']);
	
					$fname	=	strtoupper(filter($_REQUEST['fname']));
					$mname	=	strtoupper(filter($_REQUEST['mname']));
					$surname =	strtoupper(filter($_REQUEST['surname']));
			$date_of_birth	=	date('Y-m-d',strtotime($_REQUEST['date_of_birth']));
	$gender			=	strtoupper(filter($_REQUEST['gender']));
	$blood_group	=	$_REQUEST['blood_group'];
	$education	=	filter($_REQUEST['education']);
	$mobile_no2	=	filter($_REQUEST['mobile2']);
	$email	=	filter($_REQUEST['email_id']);
	$p_address1	= strtoupper(filter($_REQUEST['p_address1']));
	$p_address2	= strtoupper(filter($_REQUEST['p_address2']));
	$p_city	= strtoupper(filter($_REQUEST['p_city']));
	$p_state	= strtoupper(filter($_REQUEST['p_state']));
	$p_pin_code	= strtoupper(filter($_REQUEST['p_pin_code']));
	
	$same_address = $_REQUEST['address'];	
    if($same_address == 'YES')
    {	
		$p_address1 = strtoupper(filter($_REQUEST['p_address1']));
		$p_address2 = strtoupper(filter($_REQUEST['p_address2']));
		$p_city = strtoupper(filter($_REQUEST['p_city']));
		$p_state = strtoupper(filter($_REQUEST['p_state']));
		$p_pin_code = strtoupper(filter($_REQUEST['p_pin_code']));
		$p_address1 = strtoupper(filter($_REQUEST['p_address1']));
		
		$c_address1 = strtoupper(filter($_REQUEST['c_address1']));
		$c_address2 = strtoupper(filter($_REQUEST['c_address2']));
		$c_city = strtoupper(filter($_REQUEST['c_city']));
		$c_state = strtoupper(filter($_REQUEST['c_state']));
		$c_pin_code = strtoupper(filter($_REQUEST['c_pin_code']));
		$c_address1 = strtoupper(filter($_REQUEST['c_address1']));
	}
	else
	{
		$p_address1 = strtoupper(filter($_REQUEST['p_address1']));
		$p_address2 = strtoupper(filter($_REQUEST['p_address2']));
		$p_city = strtoupper(filter($_REQUEST['p_city']));
		$p_state = strtoupper(filter($_REQUEST['p_state']));
		$p_pin_code = strtoupper(filter($_REQUEST['p_pin_code']));
		$p_address1 = strtoupper(filter($_REQUEST['p_address1']));
		
		$c_address1 = strtoupper(filter($_REQUEST['c_address1']));
		$c_address2 = strtoupper(filter($_REQUEST['c_address2']));
		$c_city = strtoupper(filter($_REQUEST['c_city']));
		$c_state = strtoupper(filter($_REQUEST['c_state']));
		$c_pin_code = strtoupper(filter($_REQUEST['c_pin_code']));
		$c_address1 = strtoupper(filter($_REQUEST['c_address1']));
	}
	
	$bank			=	filter($_REQUEST['bank']);
	$account_no		=	filter($_REQUEST['account_no']);
	$ifsc			=	filter($_REQUEST['ifsc']);
	$employment_status	=	filter($_REQUEST['employment_status']);
	$work_experience	=	filter($_REQUEST['work_experience']);
	$applicable_industry =	filter($_REQUEST['applicable_industry']);
	$swasthya_kosh_option	=	filter($_REQUEST['swasthya_kosh_option']);
	if($_REQUEST['swasthya_kosh_option']=="Y"){ $swasthya_kosh_option	=	$_REQUEST['swasthya_kosh_option']; } else {  $swasthya_kosh_option	= "N"; }
	
	if(isset($_REQUEST['isPremium'])){
		$isPremium	=	filter($_REQUEST['isPremium']);
	}else{
		$isPremium	=	"no";
	}

	$applicable_skills   = $_REQUEST['applicable_skills'];	
	foreach($applicable_skills as $val)
	{
		if($val=="other")
		{
			$skills_other=$_REQUEST['skills_other'];
			$applicable_skills_new.=$skills_other.",";
		} else	{
			$applicable_skills_new.=$val.",";	
		}
	}
	
	$spouse_name		=	strtoupper(filter($_REQUEST['spouse_name']));
	$spouse_gender			=	strtoupper(filter($_REQUEST['spouse_gender']));

	if($spouse_dob!=""){
		$spouse_dob			=	date('Y-m-d',strtotime($_REQUEST['spouse_dob']));
	}else{
		$spouse_dob	 = $_REQUEST['spouse_dob'];
	}
	$spouse_age			=	filter($_REQUEST['spouse_age']);
	$child1				=	strtoupper(filter($_REQUEST['child1']));
	$child1_gender		=	filter($_REQUEST['child1_gender']);
	if($child1_dob !=""){
       $child1_dob		=	date('Y-m-d',strtotime($_REQUEST['child1_dob'])); 
	}else{
	   $child1_dob		=	$_REQUEST['child1_dob']; 
	}
	$child1_age			=	filter($_REQUEST['child1_age']);
	
	$child2				=	strtoupper(filter($_REQUEST['child2']));
	$child2_gender		=	filter($_REQUEST['child2_gender']);
	if($child2_dob !=""){
		$child2_dob		=	date('Y-m-d',strtotime($_REQUEST['child2_dob'])); 
	}else{
        $child2_dob		=	$_REQUEST['child2_dob']; 
	} 
	$child2_age			=	filter($_REQUEST['child2_age']);
	
	function person_photos($file_name,$file_temp,$file_type,$file_size,$registration_id,$attach)
	{
		$upload_image = '';
		$target_folder = 'images/parichay_card/person/'.$attach.'/'; 
		$registration_id = $_SESSION['USERID'];
		$target_path = "";
		$file_name = str_replace(" ","_",$file_name);
		$file_name = filter($file_name);
		
		if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
		echo "Sorry something error while uploading..."; exit;
		}
		else if($file_name != '')
		{
			if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png")) && $file_size < 2097152)
			{
				$random_name = rand();
				$target_path = $target_folder.$registration_id.'_'.$attach.'_'.$random_name.$file_name;
				if(@move_uploaded_file($file_temp, $target_path))
				{
					$upload_image = $registration_id.'_'.$attach.'_'.$random_name.$file_name;
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
	
	function person_documents($file_name,$file_temp,$file_type,$file_size,$registration_id,$attach)
	{
		$upload_image = '';
		$target_folder = 'images/parichay_card/person/'.$attach.'/'; 
		$registration_id = $_SESSION['USERID'];
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
				$target_path = $target_folder.$registration_id.'_'.$attach.'_'.$random_name.$file_name;
				if(@move_uploaded_file($file_temp, $target_path))
				{
					$upload_image = $registration_id.'_'.$attach.'_'.$random_name.$file_name;
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
		
	if(isset($_FILES['photo']) && $_FILES['photo']['name']!="")
	{
		/* Person picture */
		$photo_name=$_FILES['photo']['name'];
		$photo_temp=$_FILES['photo']['tmp_name'];
		$photo_type=$_FILES['photo']['type'];
		$photo_size=$_FILES['photo']['size'];
		$attach="photo";
		if($photo_name!="")
		{
			$create_photo = 'images/parichay_card/person/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			$photo=person_photos($photo_name,$photo_temp,$photo_type,$photo_size,$mobile1,$attach);
		}
	}
	
	if(isset($_FILES['id_proof']) && $_FILES['id_proof']['name']!="")
	{
		/* id_proof  */
		$photo_name=$_FILES['id_proof']['name'];
		$photo_temp=$_FILES['id_proof']['tmp_name'];
		$photo_type=$_FILES['id_proof']['type'];
		$photo_size=$_FILES['id_proof']['size'];
		$attach="id_proof";
		if($photo_name!="")
		{
			$create_photo = 'images/parichay_card/person/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			$id_proof = person_documents($photo_name,$photo_temp,$photo_type,$photo_size,$mobile1,$attach);
		}
	}
	
	if(isset($_FILES['upload_bank_documents']) && $_FILES['upload_bank_documents']['name']!="")
	{
		/* upload_bank_documents  */
		$photo_name=$_FILES['upload_bank_documents']['name'];
		$photo_temp=$_FILES['upload_bank_documents']['tmp_name'];
		$photo_type=$_FILES['upload_bank_documents']['type'];
		$photo_size=$_FILES['upload_bank_documents']['size'];
		$attach="upload_bank_documents";
		if($photo_name!="")
		{
			$create_photo = 'images/parichay_card/person/'.$attach;
			if (!file_exists($create_photo)) {
			mkdir($create_photo, 0777);
			}
			$upload_bank_documents = person_documents($photo_name,$photo_temp,$photo_type,$photo_size,$mobile1,$attach);
		}
	}

if(!empty($email)){
	$sqlx1="SELECT email FROM parichay_person_details WHERE email='$email' AND person_id!='$person_id'"; 
	$resultsqlx1 = $conn->query($sqlx1);
	$mysqlrow = $resultsqlx1->fetch_array();
	if($mysqlrow[0] == $email)
	{
		echo '<script language="javascript">';	echo 'alert("Email Id Already Exist")';	echo '</script>'; 
		echo "<meta http-equiv=refresh content=\"0;url=person-list.php\">";
		exit;  
	}
}

if(empty($fname))
{ $signup_error = "First Name required."; }
else if(empty($surname))
{ $signup_error = "SurName required."; }
else if(empty($date_of_birth))
{ $signup_error = "Date Of Birth required."; }
else if(empty($gender))
{ $signup_error = "Gender required."; }

elseif(empty($p_address1))
{ $signup_error = "Address 1 required."; }
elseif(empty($p_address2))
{ $signup_error = "Address 2 required."; }
elseif(empty($p_city))
{ $signup_error = "City required."; }
elseif(empty($p_state) && $p_state==0)
{ $signup_error = "State required."; }
elseif(empty($p_pin_code) || strlen($p_pin_code)<6)
{ $signup_error="Please Enter correct Pincode"; }

elseif(empty($photo) || empty($id_proof))
{ $signup_error="Please Upload the required Document"; }
else
{ 
		
	if($registration_id!=''){
	$sql1 = "UPDATE `parichay_person_details` SET `mod_date`=NOW(),`fname`='$fname',`mname`='$mname',`surname`='$surname'";
	if(isset($photo) && $photo!='')
		$sql1.=",`photo`='$photo'";
	if(isset($id_proof) && $id_proof!='')
		$sql1.=",`id_proof`='$id_proof'";
	if(isset($upload_bank_documents) && $upload_bank_documents!='')
		$sql1.=",`upload_bank_documents`='$upload_bank_documents'";
	$sql1.=",`date_of_birth`='$date_of_birth',`gender`='$gender',`blood_group`='$blood_group',`education`='$education',`mobile2`='$mobile_no2',`email`='$email',`same_address`='$same_address',`p_address1`='$p_address1',`p_address2`='$p_address2',`p_state`='$p_state',`p_city`='$p_city',`p_pin_code`='$p_pin_code',`c_address1`='$c_address1',`c_address2`='$c_address2',`c_state`='$c_state',`c_city`='$c_city',`c_pin_code`='$c_pin_code',`bank`='$bank',`account_no`='$account_no',`ifsc`='$ifsc',`employment_status`='$employment_status',
	`work_experience`='$work_experience',`applicable_industry`='$applicable_industry',`applicable_skills`='$applicable_skills_new',`skills_other`='$skills_other',`swasthya_kosh_option`='$swasthya_kosh_option',`isPremium`='$isPremium',`spouse_name`='$spouse_name',`spouse_gender`='$spouse_gender',`spouse_dob`='$spouse_dob',`spouse_age`='$spouse_age',`child1`='$child1',`child1_gender`='$child1_gender',`child1_dob`='$child1_dob',`child1_age`='$child1_age',
	`child2`='$child2',`child2_gender`='$child2_gender',`child2_dob`='$child2_dob',company_approval='P',agency_approval='P' WHERE person_id='$person_id' AND registration_id='$registration_id'";
	//echo $sql1; exit;
	$resultx = $conn ->query($sql1);
	if($resultx){
	 echo "<script langauge=\"javascript\">alert(\"Detail has been updated successfully.\");location.href='person-list.php';</script>";
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
			<div class="d-block"><img src="assets/images/gold_star.png"></div>Parichay Card Application Form </div>                    
        </div>              	           
     </div>       
                
            <div class="container">				
                <div class="row justify-content-center">
                <div class="col-lg-auto order-lg-12 col-md-12" data-sticky_parent>
				<?php include 'include/regMenu.php'; ?>
				</div>
				
				<?php //if($parichay_status=="Y"){ ?>
                <div class="col-lg col-md-12"> 
				
                <form class="cmxform box-shadow mb-5" action="" method="post" name="regisForm" id="regisForm" enctype="multipart/form-data" autocomplete="off">
				<input type="hidden" name="action" value="save"/>	
				<?php token(); ?>	
				<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>';} ?>
				<?php if(isset($signup_success)){ echo '<div class="alert alert-success" role="alert">'.$signup_success.'</div>';} ?>
				<?php if(isset($signup_aadhar)){ echo '<div class="alert alert-danger" role="alert">'.$signup_aadhar.'</div>';} ?>
								
                        <div class="row">                         
                        	<div class="form-group col-12"><p class="blue">Personal Details</p></div>
                        
                            <div class="form-group col-sm-4">
                                <label for="fname">First Name<span>*</span></label>
                                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $fname;?>" maxlength="50" autocomplete="off">
                            </div>
							
							<div class="form-group col-sm-4">
                                <label for="mname">Middle Name</label>
                                <input type="text" class="form-control" id="mname" name="mname" value="<?php echo $mname;?>" maxlength="50" autocomplete="off">
                            </div>
							
							<div class="form-group col-sm-4">
                                <label for="surname">Surname<span>*</span></label>
                                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $surname;?>" maxlength="50" autocomplete="off">
                            </div>
                            
							<div class="form-group col-sm-6">
                            <label class="form-label" for="photo">Upload Passport size Photo (Only jpg,jpeg,png)</label>
							<div class="row align-items-center">                                	
                            <div class="col">
                            <input type="file" id="photo" name="photo" class="form-control" autocomplete="off" value="">
							</div>
							<?php if(!empty($photo)){ ?>
                                <div class="col-auto pl-0">
                                <a href="images/parichay_card/person/photo/<?php echo $photo;?>" target="_blank" class="gold_clr"> <strong> View </strong></a>
                                </div>
							<?php } ?> 
							</div>
							</div>
							
                            <div class="form-group col-sm-6">
								<label class="form-label" for="date_of_birth">Date of Birth </label>
								<input type="text" class="form-control" value="<?php echo $date_of_birth;?>" name="date_of_birth" id="date_of_birth" placeholder="DD-MM-YYYY" autocomplete="off" readonly>
							</div>
                            
                            <div class="form-group col-sm-6">
								<label class="form-label" for="gender"><strong>Gender</strong></label>
                                <div class="d-flex mt-2">                                
                                    <div class="mr-3">
                                    <label for="Male"><input type="radio" id="gender" name="gender" value="Male" <?php if($gender=='MALE'){ echo 'checked="checked"'; } ?>> Male</label>
									</div>                                    
                                    <div class="mr-3">
                                    <label for="Female"><input type="radio" id="gender" name="gender" value="Female" <?php if($gender=='FEMALE'){ echo 'checked="checked"'; } ?>> Female</label>
									</div>                                    
                                    <div>
                                    <label for="LGBTQ"><input type="radio" id="gender" name="gender" value="LGBTQ" <?php if($gender=='LGBTQ'){ echo 'checked="checked"'; } ?>> LGBTQ</label>
									</div>
                                </div>
							</div>
                                                        
                            <div class="form-group col-sm-6">
                                <label for="blood_group">Blood Group </label>
                                <select class="form-control" id="blood_group" name="blood_group">
                                	<option value="">-- Select Blood Group --</option>
                                    <option value="A+" <?php if($blood_group=="A+") echo 'selected="selected"';?>>A Positive</option>
                                    <option value="A-" <?php if($blood_group=="A-") echo 'selected="selected"';?>>A Negative</option>
                                    <option value="A" <?php if($blood_group=="A") echo 'selected="selected"';?>>A Unknown</option>
                                    <option value="B+" <?php if($blood_group=="B+") echo 'selected="selected"';?>>B Positive</option>
                                    <option value="B-" <?php if($blood_group=="B-") echo 'selected="selected"';?>>B Negative</option>
                                    <option value="B" <?php if($blood_group=="B") echo 'selected="selected"';?>>B Unknown</option>
                                    <option value="AB+" <?php if($blood_group=="AB+") echo 'selected="selected"';?>>AB Positive</option>
                                    <option value="AB-" <?php if($blood_group=="AB-") echo 'selected="selected"';?>>AB Negative</option>
                                    <option value="AB" <?php if($blood_group=="AB") echo 'selected="selected"';?>>AB Unknown</option>
                                    <option value="O+" <?php if($blood_group=="O+") echo 'selected="selected"';?>>O Positive</option>
                                    <option value="O-" <?php if($blood_group=="O-") echo 'selected="selected"';?>>O Negative</option>
                                    <option value="O" <?php if($blood_group=="O") echo 'selected="selected"';?>>O Unknown</option>
                                    <option value="unknown" <?php if($blood_group=="unknown") echo 'selected="selected"';?>>Unknown</option>
								</select>			
                            </div>
                            
                            <div class="form-group col-sm-6">
								<label class="form-label" for="education"><strong>Education</strong></label>
                                <div class="d-flex mt-2">  
									<div class="mr-3">
                                    <label for="Yes"><input type="radio" id="education" name="education" value="Below 10" <?php if($education=='Below 10'){ echo 'checked="checked"'; } ?>> Below 10th</label></div>
                                    <div class="mr-3">
                                    <label for="Yes"><input type="radio" id="education" name="education" value="10" <?php if($education=='10'){ echo 'checked="checked"'; } ?>> 10th</label></div>                                    
                                    <div class="mr-3">
                                    <label for="No"><input type="radio" id="education" name="education" value="12" <?php if($education=='12'){ echo 'checked="checked"'; } ?>> 12th</label></div>                                    
                                    <div class="mr-3">
                                    <label for="No"><input type="radio" id="education" name="education" value="graduate" <?php if($education=='graduate'){ echo 'checked="checked"'; } ?>> Graduate</label></div>                                    
                                    <div>
                                    <label for="No"><input type="radio" id="education" name="education" value="p_graduate" <?php if($education=='p_graduate'){ echo 'checked="checked"'; } ?>> Post Graduate</label>				
                                    </div>
                                </div>
							</div>
                            							
                            <div class="form-group col-sm-6">
                            <label class="form-label" for="id_proof">Upload ID Proof </label>
							<div class="row align-items-center">                                	
                            <div class="col">
                            <input type="file" id="id_proof" name="id_proof" class="form-control" value="" autocomplete="off">
							</div>
							<?php if(!empty($id_proof)){ ?>
                            <div class="col-auto pl-0">
                            <a href="images/parichay_card/person/id_proof/<?php echo $id_proof;?>" target="_blank" class="gold_clr"> <strong> View </strong></a>
                            </div>
							<?php } ?>							
							</div>
							</div>
							
                            <div class="form-group col-12">
                            <p class="blue">Contact Details </p>
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-6">
                            <label for="mobile1">Mobile 1<span>*</span></label>
                            <input type="text" class="form-control numeric" id="mobile1" name="mobile1" value="<?php echo $mobile1;?>" maxlength="10" minlength="10" autocomplete="off" disabled>
                            </div>
                            							
                            <div class="form-group col-sm-6 col-md-6">
                            <label for="mobile2">Mobile 2</label>
                            <input type="text" class="form-control numeric" id="mobile2" name="mobile2" value="<?php echo $mobile2;?>" maxlength="10" minlength="10" autocomplete="off">
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-12">
                            <label for="authorised_person">Email ID</label>
                            <input type="text" class="form-control" id="email_id" name="email_id" value="<?php echo $email_id;?>" autocomplete="off" maxlength="30">
                            </div>
                            
                            <div class="form-group col-6">
                            <label for="p_address1">Address Line 1<span>*</span></label>
                            <input type="text" class="form-control" id="p_address1" name="p_address1" value="<?php echo $p_address1;?>" autocomplete="off" maxlength="30">
                            </div>
							
							<div class="form-group col-6">
                            <label for="p_address2">Address Line 2<span>*</span></label>
                            <input type="text" class="form-control" id="p_address2" name="p_address2" value="<?php echo $p_address2;?>" autocomplete="off" maxlength="30">
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-4">
                            <label for="city">City <span>*</span></label>
                            <input type="text" class="form-control" id="p_city" name="p_city" value="<?php echo $p_city;?>" maxlength="20" autocomplete="off">			
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-4">
                            <label for="state">State <span>*</span></label>
                            <select name="p_state" id="p_state" class="form-control">
                            <option value="">--- Select State ---</option>
                            <?php 
                            $stat = $conn ->query("SELECT * from state_master WHERE country_code = 'IN'");
                            while($result = $stat->fetch_assoc()){ ?>
							<option value="<?php echo filter($result['state_code']);?>" <?php if($result['state_code']==$p_state){?> selected="selected" <?php }?>><?php echo strtoupper(filter($result['state_name']));?></option>
                            <?php } ?>
                            </select>		
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-4">
                            <label for="authorised_mobile1">Pincode <span>*</span></label>
                            <input type="text" class="form-control numeric" id="p_pin_code" name="p_pin_code" value="<?php echo $p_pin_code;?>" autocomplete="off" maxlength="6" onkeypress="if(this.value.length==6) return false;">		
                            </div>
                            
                            <div class="form-group col-12">
                            	<div class="d-flex">
                                	<div><label for="authorised_person">Current Address<span>*</span></label></div>
                                	<div class="col">
                                    <label for="Yes" style="font-size:13px; font-style:italic;">
                                    YES <input type="radio" name="address" value="YES" <?php if($same_address=="YES"){ echo "checked=checked";}?> onclick="data_copy()";> Please tick Yes same as permanent address</label>		
									</div>
									<div class="col">
                                    <label for="Yes" style="font-size:13px; font-style:italic;">
                                    NO <input type="radio" name="address" value="NO" <?php if($same_address=="NO"){ echo "checked=checked";}?> onclick="data_copy()";> </label>		
									</div>
                                </div>
                            </div>
                            
                            <div class="form-group col-6">
                            <label for="c_address1">Address Line 1<span>*</span></label>
                            <input type="text" class="form-control" id="c_address1" name="c_address1" value="<?php echo $c_address1;?>" autocomplete="off" maxlength="30">
                            </div>
							
							<div class="form-group col-6">
                            <label for="c_address2">Address Line 2<span>*</span></label>
                            <input type="text" class="form-control" id="c_address2" name="c_address2" value="<?php echo $c_address2;?>" autocomplete="off" maxlength="30">
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-4">
                            <label for="authorised_mobile1">City</label>
                            <input type="text" class="form-control" id="c_city" name="c_city" value="<?php echo $c_city;?>" maxlength="20" autocomplete="off">			
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-4">
                            <label for="authorised_mobile1">State</label>
                            <select name="c_state" id="c_state" class="form-control">
                            <option value="">--- Select State ---</option>
                            <?php 
                            $stat = $conn ->query("SELECT * from state_master WHERE country_code = 'IN'");
                            while($result = $stat->fetch_assoc()){ ?>
							<option value="<?php echo filter($result['state_code']);?>" <?php if($result['state_code']==$c_state){?> selected="selected" <?php }?>><?php echo strtoupper(filter($result['state_name']));?></option>
                            <?php } ?>
                            </select>		
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-4">
                            <label for="authorised_mobile1">Pincode</label>
                            <input type="text" class="form-control numeric" id="c_pin_code" name="c_pin_code" value="<?php echo $c_pin_code;?>" autocomplete="off" maxlength="6" onkeypress="if(this.value.length==6) return false;">		
                            </div>
                            
                            <div class="form-group col-12">
                                <p class="blue">Bank Details Section</p>
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="authorised_mobile1">Bank Name </label>
                                <select name="bank" id="bank" class="form-control">
                                    <option value="">-- Select Bank --</option>
                                    <?php 
                                    $bquery =  $conn ->query("select bank_name from bank_master where status='1' order by bank_name asc");
                                    while($bresult = $bquery->fetch_assoc()){
                                    ?>
                                    <option value="<?php echo $bresult['bank_name'];?>" <?php if($bresult['bank_name']==$bank){?> selected="selected" <?php }?>><?php echo strtoupper($bresult['bank_name']);?></option>
                                    <?php } ?>
                                </select>			
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="account_no">Account No.</label>
                                <input type="text" class="form-control numeric" id="account_no" name="account_no" value="<?php echo $account_no;?>" maxlength="20" autocomplete="off">		
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="ifsc">IFSC Code</label>
                                <input type="text" class="form-control" id="ifsc" name="ifsc" maxlength="30" value="<?php echo $ifsc;?>" autocomplete="off">		
                            </div>
                            							
                            <div class="form-group col-sm-6">
                            <label class="form-label" for="upload_bank_documents">Upload bank details</label>
							<div class="row align-items-center">                                	
                            <div class="col">
                            <input type="file" id="upload_bank_documents" name="upload_bank_documents" class="form-control" autocomplete="off" value="<?php echo $upload_bank_documents;?>">
							</div>
							<?php if(!empty($upload_bank_documents)){ ?>
                            <div class="col-auto pl-0">
                            <a href="images/parichay_card/person/upload_bank_documents/<?php echo $upload_bank_documents;?>" target="_blank" class="gold_clr"> <strong> View </strong></a>
                            </div>
							<?php } ?>
							</div>
							</div>
                                
                           	<div class="form-group col-12">
                            <p class="blue">Work Profile </p>
                            </div>
                            
                            <div class="form-group col-sm-6">
								<label class="form-label" for="employment_status"><strong>Current Employment status</strong></label>
                                <div class="d-flex mt-2">
                                
                                    <div class="mr-3">
                                        <label for="Yes">
                                        <input type="radio" id="employment_status" value="Permanent" name="employment_status" <?php if($employment_status=='Permanent'){ echo 'checked="checked"'; } ?>> Permanent </label>				
                                    </div>                                    
                                    <div class="mr-3">
                                        <label for="No">
                                        <input type="radio" id="employment_status" value="Contracted" name="employment_status" <?php if($employment_status=='Contracted'){ echo 'checked="checked"'; } ?>> Contracted</label>					
                                    </div>                                    
                                    <div>
                                        <label for="No">
                                        <input type="radio" id="employment_status" value="Unemployed" name="employment_status" <?php if($employment_status=='Unemployed'){ echo 'checked="checked"'; } ?>> Unemployed</label>					
                                    </div>
                                </div>
							</div>
                            
                            <div class="form-group col-sm-6">
                            <label for="authorised_mobile1">Work experience in G&J industry (in years) </label>
                            <input type="text numeric" class="form-control" id="work_experience" name="work_experience" maxlength="2" value="<?php echo $work_experience;?>" autocomplete="off">		
                            </div>
                            
                            <div class="form-group col-sm-6">
								<label class="form-label" for="applicable_industry"><strong>Applicable Industry</strong></label>
                                <div class="d-flex mt-2">
                                
                                    <div class="mr-3">
                                        <label for="Yes">
                                        <input type="radio" id="applicable_industry" value="Diamond" name="applicable_industry" <?php if($applicable_industry=='Diamond'){ echo 'checked="checked"'; } ?>> Diamond </label>						
                                    </div>                                    
                                    <div class="mr-3">
                                        <label for="No">
                                        <input type="radio" id="applicable_industry" value="Gemstones" name="applicable_industry" <?php if($applicable_industry=='Gemstones'){ echo 'checked="checked"'; } ?>> Gemstones</label>					
                                    </div>                                    
                                    <div>
                                        <label for="No">
                                        <input type="radio" id="applicable_industry" value="Jewellery" name="applicable_industry" <?php if($applicable_industry=='Jewellery'){ echo 'checked="checked"'; } ?>> Jewellery</label>					
                                    </div>                                    
                                </div>
							</div>
                            
                            <div class="form-group col-12">
								<label class="form-label" for="applicable_skills"><strong>Tick Applicable Skills</strong> (Select All that apply)</label>
                                <div class="row mt-2">
                                
                                    <div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="mould" name="applicable_skills[]" <?php if(preg_match('/mould/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Model & mould making </label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="finishing" name="applicable_skills[]" <?php if(preg_match('/finishing/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Finishing / Polishing </label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="retail" name="applicable_skills[]" <?php if(preg_match('/retail/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Retail Sales </label>
									</div>                                    
                                    <div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="waxing" name="applicable_skills[]" <?php if(preg_match('/waxing/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Waxing </label>
                                    </div>                                    
                                    <div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="grading" name="applicable_skills[]" <?php if(preg_match('/grading/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Grading </label>
                                    </div>                                    
                                    <div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="grinding" name="applicable_skills[]" <?php if(preg_match('/grinding/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Grinding & Assembly</label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="procurement" name="applicable_skills[]" <?php if(preg_match('/procurement/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Procurement </label>
                                    </div>                                    
                                    <div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="casting" name="applicable_skills[]" <?php if(preg_match('/casting/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Casting</label>
                                    </div>                                    
                                    <div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="trading" name="applicable_skills[]" <?php if(preg_match('/trading/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Trading</label>
                                    </div>                                    
                                    <div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="assortment" name="applicable_skills[]" <?php if(preg_match('/assortment/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Assortment & Planning</label>			
                                    </div>                                    
                                    <div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="admin" name="applicable_skills[]" <?php if(preg_match('/admin/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Admin/HR/Finance </label>
                                    </div>                                    
                                    <div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="handcrafting" name="applicable_skills[]" <?php if(preg_match('/handcrafting/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Handcrafting </label>
                                    </div>                                    
                                    <div class="col-md-4">
                                    <label for="Yes"> 
									<input type="checkbox" id="applicable_skills" value="setting" name="applicable_skills[]" <?php if(preg_match('/setting/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Setting </label>
                                    </div>                                    
                                    <div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="designing" name="applicable_skills[]" <?php if(preg_match('/designing/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Designing </label>
                                    </div>
									<div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="cutting" name="applicable_skills[]" <?php if(preg_match('/cutting/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Cutting / Polishing / Faceting </label>
                                    </div> 
									<div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="melting" name="applicable_skills[]" <?php if(preg_match('/melting/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Melting</label>
                                    </div> 
									<div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="wire" name="applicable_skills[]" <?php if(preg_match('/wire/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Wire or strip drawing</label>
                                    </div> 
									<div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="die" name="applicable_skills[]" <?php if(preg_match('/die/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Die cutting</label>
                                    </div> 
									<div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="soldering" name="applicable_skills[]" <?php if(preg_match('/soldering/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Soldering</label>
                                    </div> 
									<div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="mina" name="applicable_skills[]" <?php if(preg_match('/mina/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Mina work </label>
                                    </div> 
									<div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="electroplating" name="applicable_skills[]" <?php if(preg_match('/electroplating/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Electroplating</label>
                                    </div> 
									<div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="packaging" name="applicable_skills[]" <?php if(preg_match('/packaging/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Packaging</label>
                                    </div> 
									<div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="chains" name="applicable_skills[]" <?php if(preg_match('/chains/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Chains Manufacturing (by machines)</label>
                                    </div> 
                                    <!--<div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="skills_other" value="other" name="skills_other"> Others Please Specify</label>						
                                    </div>-->                              
                                </div>
							</div>
                            <?php if($parichay_type =="association"){ ?>
                            <div class="form-group col-12">
                            <p class="blue">Swasthya Kosh <input type="checkbox" id="swasthya_kosh_option" value="Y" name="swasthya_kosh_option" <?php if(preg_match('/Y/',$swasthya_kosh_option)){ echo 'checked="checked"'; } ?>></p>
                            </div>
                             <div class="form-group col-12 " id="premiumDiv">
                               <div class="d-flex mt-2">
                                
                                    <div class="mr-3">
                                       
                                        <input type="radio" tj="<?php echo $isPremium; ?>" id="isPremiumSelf" value="self"  name="isPremium" <?php echo ( strtolower($isPremium)=="self" ? "checked":"");?>  > <label for="isPremiumSelf"> Self Only (Premium: Rs 1400)  </label>				
                                    </div>                                    
                                    <div class="mr-3">
                                        
                                        <input type="radio" id="isPremiumFamily" value="family" name="isPremium"  <?php echo (strtolower($isPremium)=="family" ? "checked":"");?>> <label for="isPremiumFamily">Self & Family (Premium: Rs. 2200)</label>					
                                    </div>                                    
                                   	
                                </div>
                                  
                                <div><label for="isPremium" generated="true" class="error d-none">This is required</label></div>  
                            </div>
                            
                            <div class="form-group col-12">
                                <table class="responsive_table category_table" id="family_table" style="<?php echo ($isPremium=="SELF" ? "display: none" :""); ?>">
                                    <thead>
                                        <tr>
                                            <th>Particular</th>
                                            <th>Full Name</th>
                                            <th>Relation</th>
                                            <th>Gender</th>
                                            <th>DOB</th>
                                            <th>Age</th>
                                        </tr>
                                    </thead>                           
                                    <tbody>
                                        <tr>
                                            <td data-column="Particular">01</td>
                                            <td data-column="Full Name"><input type="text" name="spouse_name" id="spouse_name" class="form-control" value="<?php echo $spouse_name;?>"></td>
                                            <td data-column="Relation">Spouse</td>
                                            <td data-column="Gender">
											<select class="form-control" name="spouse_gender">
											<option value="">Select</option>
											<option <?php if($spouse_gender =="M"){echo "selected";}?> value="M">Male</option>
											<option  <?php if($spouse_gender =="F"){echo "selected";}?>  value="F">Female</option>
											</select>
											</td>										
                                            <td data-column="DOB"><input type="text" name="spouse_dob" id="spouse_dob" class="form-control" value="<?php echo $spouse_dob;?>" readonly></td>										
                                            <td data-column="Age"><input type="text" name="spouse_age" id="spouse_age" class="form-control numeric" value="<?php echo $spouse_age;?>"></td>
                                        </tr>
                                         
                                        <tr>
                                            <td data-column="Particular">02</td>
                                            <td data-column="Full Name"><input type="text" name="child1" id="child1" class="form-control" value="<?php echo $child1;?>"></td>
                                            <td data-column="Relation">Child 1</td>
                                            <td data-column="Gender">
											<select class="form-control" id="child1_gender" name="child1_gender">
											<option value="">Select</option>
											<option value="M" <?php if($child1_gender=="M") echo 'selected="selected"';?>>Male</option>
											<option value="F" <?php if($child1_gender=="F") echo 'selected="selected"';?>>Female</option>
											</select>
											</td>										
                                            <td data-column="DOB"><input type="text" name="child1_dob" id="child1_dob" class="form-control" value="<?php echo $child1_dob;?>" readonly></td>										
                                            <td data-column="Age"><input type="text" name="child1_age" id="child1_age" class="form-control numeric" value="<?php echo $child1_age;?>"></td>
                                        </tr>                                        
                                        <tr>
                                            <td data-column="Particular">03</td>
                                            <td data-column="Full Name"><input type="text" name="child2" id="child2" class="form-control" value="<?php echo $child2;?>"></td>
                                            <td data-column="Relation">Child 2</td>
                                            <td data-column="Gender">

											<select class="form-control" id="child2_gender" name="child2_gender">
												<option value="">Select</option>
											<option value="M" <?php if($child2_gender=="M") echo 'selected="selected"';?>>Male</option>
											<option value="F" <?php if($child2_gender=="F") echo 'selected="selected"';?>>Female</option>
											</select>
											</td>										
                                            <td data-column="DOB"><input type="text" name="child2_dob" id="child2_dob" class="form-control" value="<?php echo $child2_dob;?>" readonly></td>										
                                            <td data-column="Age"><input type="text" name="child2_age" id="child2_age" class="form-control numeric" value="<?php echo $child2_age;?>"></td>
                                        </tr>
                                    </tbody>                                        
                                </table>
                            </div>
							<?php } ?>
							<input type="hidden" name="person_id" id="person_id" value="<?php echo $encrypted_id;?>"/>
                            </div>	
							<div class="form-group">
                      		<button type="submit" id='submit' class="cta fade_anim">UPDATE</button>
							<span class="otp-messages" style='color: green;'></span>
                        </div>
                        
                    </form> 
					</div>
					<?php //} ?>
                </div>   
				
                </div>                            
            </div>    
           
</section> 
</div>
<?php include 'include-new/footer_export.php'; ?>
<script type="text/javascript">
function data_copy()
{
if(document.getElementById("regisForm").address[0].checked){
document.getElementById("c_address1").value=document.getElementById("p_address1").value;
document.getElementById("c_address2").value=document.getElementById("p_address2").value;
document.getElementById("c_city").value=document.getElementById("p_city").value;
document.getElementById("c_state").value=document.getElementById("p_state").value;
document.getElementById("c_pin_code").value=document.getElementById("p_pin_code").value;
} else {
document.getElementById("c_address1").value="";
document.getElementById("c_address2").value="";
document.getElementById("c_city").value="";
document.getElementById("c_state").value="";
document.getElementById("c_pin_code").value="";
}
}
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
			fname: {
				required: true,				
				specialChrs: true
			},
			surname: {
				required: true,				
				specialChrs: true
			},
			date_of_birth: {
				required: true,
			}, 			
			gender: { 
				required: true,
			},
			education: { 
				required: true,
			},
			mobile_no1: {
				required: true,
				number:true,
				minlength:10,
				maxlength:10
			},			
			p_address1: {
				required: true,
			},
			p_address2: {
				required: true,
			},
			p_city: {
				required: true,
				},
			p_state: {
				required: true,
				},
			p_pin_code: {
				required: true,
				number:true,
				minlength:6,
				maxlength:6
			},			
			address:{
				required:true
			},
		    isPremium:{
				required:true
			}
			
		},
		messages: {
			fname: {
				required: "This is required.",
			},			
			surname: {
				required: "This is required.",
			},
			date_of_birth: {
				required: "This is required.",
			},
			gender: {
				required: "This is required.",
			},
			education: {
				required: "This is required.",
			},
			mobile_no1: {
				required: "This is required.",
				number:"Please Enter numbers only",
				minlength:"Please Enter not less than 10 numbers",
				maxlength:"Please Enter not more than 10 numbers"				
			},			
			p_address1: {
				required: "This is required.",
			},
			p_address2: {
				required: "This is required.",
			},
			p_city: {
				required: "This is required.",
			},
			p_state: {
				required: "This is required.",
			}, 
			p_pin_code: {
				required: "This is required.",
				number:"Please Enter numbers only",
				minlength:"Please Enter not less than 6 numbers",
				maxlength:"Please Enter not more than 6 numbers"				
			},
			address:{
				required: "This is required.",
			},
			isPremium:{
				required:"This is Required"
			}
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

<script>
$(document).ready(function () {
	// $(document).on("click","#swasthya_kosh_option",function(){
	// 	if($(this).is(":checked")){
	// 		$("#premiumDiv").slideDown();
	// 		$("input[name='isPremium']").removeAttr('disabled'); //enable.
	// 		return true;
	// 	}else{
	// 		$("#premiumDiv").slideUp();
	// 		$("input[name='isPremium']").attr('disabled','disabled'); //disable.
	// 		return true
	// 	}
	// });
	$(document).on("click","input[name='isPremium']",function(){
		let value = $(this).val();
		if(value =="self"){
			$("#family_table").slideUp();
		}else{
			$("#family_table").slideDown();
		}
	});
	var today = new Date();

		$("#date_of_birth").datepicker({           
        format: "yyyy-mm-dd"
        }); 
		$("#spouse_dob").datepicker({         
         format: "yyyy-mm-dd"
        });
		$("#child1_dob").datepicker({         
         format: "yyyy-mm-dd"
        });
		$("#child2_dob").datepicker({         
         format: "yyyy-mm-dd"
        });
		
		$("#spouse_dob").change(function(){	

    	var spouse_dob = new Date($(this).val());		
		var spouse_age = Math.floor((today-spouse_dob) / (365.25 * 24 * 60 * 60 * 1000));			
		$('#spouse_age').val(spouse_age);
		});
		$("#child1_dob").change(function(){    	
    	var child1_dob = new Date($(this).val());		
		var child1_age = Math.floor((today-child1_dob) / (365.25 * 24 * 60 * 60 * 1000));			
		$('#child1_age').val(child1_age);
		});
		$("#child2_dob").change(function(){    	
    	var child2_dob = new Date($(this).val());	
		var child2_age = Math.floor((today-child2_dob) / (365.25 * 24 * 60 * 60 * 1000));	
		$('#child2_age').val(child2_age);
		});
	});    		
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