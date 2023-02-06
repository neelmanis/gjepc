<?php
include 'include-new/header.php';
include 'db.inc.php';
include 'functions.php';

//$ckAppliedForparichay = isApplied_for_parichay($_SESSION['USERID'],$conn); 

$via = filter($_GET['via']);
$uid = $_GET['uid'];
//if($uid==''){ header("Location: person-verification.php"); }
//if(!intval($_GET['uid'])) { header("Location: person-verification.php"); }


if($via!="links" && $via!="person"){ header("Location: person-verification.php"); }
if($via=="links"){ $via_parichay_type = "links"; } else { $via_parichay_type = "person"; }

$action = trim($_REQUEST['action']);
if($action=="save")
{ 

	//echo "<pre>";print_r($_POST);exit;
	//validate Token
	//if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	//	echo '<pre>'; print_r($_POST); exit;
	$registration_id = intval(filter($_REQUEST['registration_id']));
	$fname	=	strtoupper(filter($_REQUEST['fname']));
	$mname	=	strtoupper(filter($_REQUEST['mname']));
	$surname =	strtoupper(filter($_REQUEST['surname']));

	$date_of_birth	=	date('Y-m-d',strtotime($_REQUEST['date_of_birth']));
	$gender			=	strtoupper(filter($_REQUEST['gender']));
	$blood_group	=	$_REQUEST['blood_group'];
	$education	=	filter($_REQUEST['education']);
	$mobile1	=	filter($_REQUEST['mobile1']);
	$mobile2	=	filter($_REQUEST['mobile2']);
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
	$otpVerified = filter($_POST['verified']);
	
	$skills_other_input = array(filter($_REQUEST['skills_other_input']));
	$applicable_skills   = $_REQUEST['applicable_skills'];

	if(isset($_REQUEST['applicable_skills_other']) && $_REQUEST['applicable_skills_other'] =="other"){
	
        $applicable_skills = array_merge($applicable_skills,$skills_other_input);
        
        $applicable_skills= implode(",",$applicable_skills) ;

	}else{
		$applicable_skills  = implode(",",$applicable_skills) ;
		
	}	
	
	if(isset($_REQUEST['isPremium'])){
		$isPremium	=	filter($_REQUEST['isPremium']);
	}else{
		$isPremium	=	"no";
	}
	
	$swasthya_kosh_option	=	filter($_REQUEST['swasthya_kosh_option']);
	if($_REQUEST['swasthya_kosh_option']=="Y"){ $swasthya_kosh_option	=	$_REQUEST['swasthya_kosh_option']; } else {  $swasthya_kosh_option	= "N"; }
	$spouse_name			=	strtoupper(filter($_REQUEST['spouse_name']));
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
		$registration_id = $_REQUEST['registration_id'];
		$target_path = "";
		$file_name = str_replace(" ","_",$file_name);
		$file_name = str_replace(".php","",$file_name);
		$file_name = str_replace("'","",$file_name);
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
		$registration_id = $_REQUEST['registration_id'];
		$target_path = "";
		$file_name = str_replace(" ","_",$file_name);
		$file_name = str_replace(".php","",$file_name);
		$file_name = str_replace("'","",$file_name);
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
$sqlx1="SELECT email FROM parichay_person_details WHERE email='$email'";
$resultsqlx1 = $conn->query($sqlx1);
$mysqlrow = $resultsqlx1->fetch_array();
if($mysqlrow[0] == $email)
{ ?>
	<script> alert("Email Id Already Exist"); </script>
	
<?php echo '<meta http-equiv="refresh" content="0">'; exit; } 
}

if(empty($registration_id))
{ $signup_error = "Company / Assocation required."; }
else if(empty($fname))
{ $signup_error = "First Name required."; }
else if(empty($surname))
{ $signup_error = "SurName required."; }
else if(empty($date_of_birth))
{ $signup_error = "Date Of Birth required."; } 
else if(empty($gender))
{ $signup_error = "Gender required."; }
else if(empty($blood_group))
{ $signup_error = "Blood Group required."; }

elseif(empty($mobile1))
{ $signup_error = "Please Enter Mobile No 1";}
elseif(is_numeric($mobile1) == false)
{ $signup_error = "Please Enter Valid Mobile No 1";}
elseif(strlen($mobile1)>10 || strlen($mobile1)<10)
{ $signup_error = "Mobile Number should be 10 digits.";}

elseif(empty($p_address1))
{ $signup_error = "Address 1 required."; }
elseif(empty($p_address2))
{ $signup_error = "Address 2 required."; }
elseif(empty($p_city))
{ $signup_error = "City required."; }
elseif(empty($p_state) && $p_state==0)
{ $signup_error = "State required."; }
elseif(empty($c_pin_code) || strlen($c_pin_code)<6)
{ $signup_error="Please Enter correct Pincode"; }

elseif(empty($photo) || empty($id_proof))
{ $signup_error="Please Upload the required Document"; }
else
{	
	//if($otpVerified=="verify"){
	$sqlCheck = "SELECT mobile1 FROM `parichay_person_details` WHERE `mobile1`='$mobile1' LIMIT 1";
    $resultCheck = $conn ->query($sqlCheck);
    $countCheck = $resultCheck->num_rows;
    if($countCheck>0)
	{
		$_SESSION['err_msg']="Already registered with this Mobile No ";
	} else {
		 
	if($registration_id!=''){
    $sql_parichay_type = "SELECT parichay_type,parichay_series FROM registration_master WHERE id='$registration_id'";
    $result_parichay_type = $conn->query($sql_parichay_type);
    $row_parichay_type  = $result_parichay_type->fetch_assoc();
    $parichay_type =  $row_parichay_type['parichay_type'];
    if($parichay_type =="association"){
    $sql_series = "SELECT  MAX(p.person_series) FROM parichay_person_details p join registration_master r on p.registration_id=r.id WHERE r.parichay_type='association'";

	$result_series = $conn->query($sql_series);
	$row_series = $result_series->fetch_array();
	if($row_series[0] == "0" ){
		$person_series = "5000001";
	}else{

		$person_series = $row_series[0]+1;
	}
    }else{

    $sql_series = "SELECT  MAX(p.person_series) FROM parichay_person_details p join registration_master r on p.registration_id=r.id WHERE r.parichay_type!='association'";
    	$result_series = $conn->query($sql_series);
	 $row_series = $result_series->fetch_array();

	  
	if($row_series[0] == "0" ){
		 $person_series = "1000001";
	}else{

		 $person_series = $row_series[0]+1;
	}

    }


	 $sql1 = "INSERT INTO `parichay_person_details`(`post_date`, `registration_id`, `fname`, `mname`, `surname`, `photo`, `date_of_birth`, `gender`, `blood_group`, `education`, `id_proof`, `mobile1`, `mobile2`, `email`, `same_address`, `p_address1`, `p_address2`, `p_state`, `p_city`, `p_pin_code`, `c_address1`, `c_address2`, `c_state`, `c_city`, `c_pin_code`, `bank`, `account_no`, `ifsc`, `upload_bank_documents`, `employment_status`, `work_experience`, `applicable_industry`, `applicable_skills`, `skills_other`, `swasthya_kosh_option`, `isPremium`,`spouse_name`, `spouse_gender`, `spouse_dob`, `spouse_age`, `child1`, `child1_gender`, `child1_dob`, `child1_age`, `child2`, `child2_gender`, `child2_dob`, `child2_age`, `parichay_type`,`person_series`, `parichay_status`, `otpVerified`) VALUES (NOW(),'$registration_id','$fname','$mname','$surname','$photo','$date_of_birth','$gender','$blood_group','$education','$id_proof','$mobile1','$mobile2','$email','$same_address','$p_address1','$p_address2','$p_state','$p_city','$p_pin_code','$c_address1','$c_address2','$c_state','$c_city','$c_pin_code','$bank','$account_no','$ifsc','$upload_bank_documents','$employment_status','$work_experience','$applicable_industry','$applicable_skills','$skills_other','$swasthya_kosh_option','$isPremium','$spouse_name','$spouse_gender','$spouse_dob','$spouse_age','$child1','$child1_gender','$child1_dob','$child1_age','$child2','$child2_gender','$child2_dob','$child2_age','$via_parichay_type','$person_series','P','1')";
//	echo $sql1; exit;
	$resultx = $conn ->query($sql1);
	if($resultx){
	 echo "<script langauge=\"javascript\">alert(\"Detail has been added successfully.\");location.href='parichay-landing.php';</script>";
	} else { $_SESSION['err_msg']="Something Missing"; }
	}
	}
	//} else { $_SESSION['err_msg']="OTP Not Verified"; }
}
//} else { $_SESSION['err_msg']="Invalid Token Error"; }
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
			<div class="d-block"><img src="assets/images/gold_star.png"></div>Parichay Card Application Form</div>                    
        </div>     

          <div class="langBtn d-table mx-auto" style="position:relative; top:auto">
            <div class="d-flex justify-content-center mb-3 lang_switcher">
                <div><button onclick="location.href = 'add-karigar-person.php';" class="lang active">English</button></div>
                <div><button onclick="location.href = 'add-karigar-person-hindi.php?via=person';" class="lang">Hindi</button></div>
            </div>
        </div>         	           
     </div>       
                
            <div class="container">				
                <div class="row justify-content-center">                
                <div class="col-lg col-md-12"> 
				
                <form class="cmxform box-shadow mb-5" action="" method="post" name="regisForm" id="regisForm" enctype="multipart/form-data" autocomplete="off"/>
				<input type="hidden" name="action" value="save"/>	
				<?php //token(); ?>	
				<?php if(isset($signup_error)){ echo '<div class="alert alert-danger" role="alert">'.$signup_error.'</div>';} ?>
				<?php if(isset($signup_success)){ echo '<div class="alert alert-success" role="alert">'.$signup_success.'</div>';} ?>
				<?php if(isset($signup_aadhar)){ echo '<div class="alert alert-danger" role="alert">'.$signup_aadhar.'</div>';} ?>
								
                        <div class="row"> 
                         <div class="col-12 mb-3">
                          	<ul class="inner_under_listing">Note:
                          	<li>(Allowed file types:jpeg,png,pdf & File upload max size 2 MB)</li>                          
                            </ul> 
                        </div>    
                       
							<?php if($via=="links"){ ?>
							<div class="form-group col-sm-6 col-md-4">
                            <label for="company"></label>
							<b><?php echo getNameCompany($uid,$conn); ?></b>
							<input type="hidden" name="registration_id" value="<?php echo $uid;?>">								
                            </div>
							<?php } ?>
							
							<?php if($via=="person"){ ?>
							<div class="form-group col-12 mb-4">
                            <p class="blue tr" key="enroll"> &nbsp;&nbsp;<span id="chkregisuser"></span><br><span id="chkpanuser"></span></p>
							</div>  
							<div class="form-group col-sm-6">
								<label for="Company"><input type="radio" name="valueType" id="companyType" value="companyType" class="mr-2">
                                Company<span>*</span></label>
                                <label class="d-inline-block mr-4"></label>
                               <label for="Association"><input type="radio" name="valueType" id="associationType" value="associationType" class="mr-2">Association<span>*</span></label>                              
                            </div>
														
							<div class="col-12 mb-2" id="specific-company" <?php if(isset($_REQUEST['valueType']) && $_REQUEST['valueType']=="companyType"){?> <?php } else { ?> style="display: none" <?php } ?>>
							<div class="row">                        
							<div class="col-8">
							<div class="row">
								<div class="form-group col-sm-6">
								<label class="form-label" for="member">
								<input type="radio" name="type_member" value="M" class="mr-2" <?php if($_REQUEST['type_member']=="M"){ echo "checked"; }?>/>
								Member Company</label>
								</div>
							<!--<div class="form-group col-sm-6">
								<label class="form-label" for="nonmember">
								<input type="radio" name="type_member" value="NM" class="mr-2" <?php if($_REQUEST['type_member']=="NM"){ echo "checked"; }?>/>
								Non Member Company</label>
								</div>-->
							</div>						  
							</div>						
							</div>
							</div>
						
							<div class="col-12 mb-2" id="company-wise" style="display: none"<?php /* if($_REQUEST['type_member']=="M" || $_REQUEST['type_member']=="NM"){ ?> <?php } else { ?> style="display: none" <?php } */?>>
							<div class="row">
							<div class="col-8">
							<div class="row">
								<div class="form-group col-sm-6" id="companyData"></div>
							</div>						  
							</div>
							</div>
							</div>
							<?php } ?>
							
                        	<div class="form-group col-12">
                                <p class="blue">Personal Details</p>
                            </div>
														
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
                            <input type="file" id="photo" name="photo" class="form-control" autocomplete="off">
							</div>
							
                            <div class="form-group col-sm-6">
								<label class="form-label" for="date_of_birth">Date of Birth <span>*</span></label>
								<input type="text" class="form-control" value="<?php echo $date_of_birth;?>" name="date_of_birth" id="date_of_birth" placeholder="YYYY-MM-DD" autocomplete="off" readonly>
							</div>
                            
                            <div class="form-group col-sm-6">
								<label class="form-label" for="gender"><strong>Gender</strong><span>*</span></label>
                                <div class="d-flex mt-2">                                
                                    <div class="mr-3">
                                    <label for="Male"><input type="radio" id="gender" name="gender" value="Male"> Male</label>
									</div>                                    
                                    <div class="mr-3">
                                    <label for="Female"><input type="radio" id="gender" name="gender" value="Female"> Female</label>
									</div>                                    
                                    <div>
                                    <label for="LGBTQ"><input type="radio" id="gender" name="gender" value="LGBTQ"> LGBTQ</label>
									</div>
                                </div>
							</div>
                                                        
                            <div class="form-group col-sm-6">
                                <label for="blood_group">Blood Group <span>*</span></label>
                                <select class="form-control" id="blood_group" name="blood_group">
                                	<option value="">-- Select Blood Group --</option>
                                    <option value="A+">A Positive</option>
                                    <option value="A-">A Negative</option>
                                    <option value="A">A Unknown</option>
                                    <option value="B+">B Positive</option>
                                    <option value="B-">B Negative</option>
                                    <option value="B">B Unknown</option>
                                    <option value="AB+">AB Positive</option>
                                    <option value="AB-">AB Negative</option>
                                    <option value="AB">AB Unknown</option>
                                    <option value="O+">O Positive</option>
                                    <option value="O-">O Negative</option>
                                    <option value="O">O Unknown</option>
                                    <option value="unknown">Unknown</option>
								</select>			
                            </div>
                            
                            <div class="form-group col-sm-6">
								<label class="form-label" for="education"><strong>Education</strong><span>*</span></label>
                                <div class="d-flex mt-2"> 
                                <div class="mr-3">
                                    <label for="Yes"><input type="radio" id="education" name="education" value="Below 10"> Below 10th</label>		</div>                                    
                                    <div class="mr-3">
                                    <label for="Yes"><input type="radio" id="education" name="education" value="10"> 10th</label>		</div>
                                                                   
                                    <div class="mr-3">
                                    <label for="No"><input type="radio" id="education" name="education" value="12"> 12th</label>		</div>                                    
                                    <div class="mr-3">
                                    <label for="No"><input type="radio" id="education" name="education" value="graduate"> Graduate</label>	</div>                                    
                                    <div>
                                    <label for="No"><input type="radio" id="education" name="education" value="p_graduate"> Post Graduate</label>				
                                    </div>
                                </div>
							</div>
                            
                            <div class="form-group col-sm-6">
                            <label class="form-label" for="id_proof">Upload ID Proof <span>*</span></label>
                            <input type="file" id="id_proof" name="id_proof" class="form-control" autocomplete="off">
                             <i>(Aadhar card/Voter Id / Driving lisence)</i>
							</div>
							
                            <div class="form-group col-12">
                            <p class="blue">Contact Details </p>
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-4">
                            <label for="mobile1">Mobile 1<span>*</span></label>
							
                            <input type="text" class="form-control numeric" id="mobile1" name="mobile1" value="<?php echo $mobile1;?>" maxlength="10" minlength="10" autocomplete="off">
                            <label id="chkMob1"></label>
                            <!--<div id='imgLoading1' style='display:none'><img src="https://registration.gjepc.org/images/loader.gif" alt="Uploading...."/></div>

							<a href="javascript:void(0)" id='send_otp' class="cta fade_anim" style="display:none;"><strong>Send OTP</strong></a>-->
							<!--<input type="submit" name="send_otp" id="send_otp" value="Send OTP" class="cta fade_anim " style="display:none;">-->
							</div>
                            <!--
							<div class="form-group col-sm-4">
                            <label for="enter_otp">Enter OTP <span>*</span></label><div id="error" style="color:#FF0000;padding-left:50px;"></div>
                            <input type="text" class="form-control numeric" placeholder="Enter OTP" name="otp" id="otp" maxlength="4" autofocus>
							<img src="https://gjepc.org/admin/images/active.png" class="tick" style="display:none;"/>
                            </div> -->
							
                            <div class="form-group col-sm-6 col-md-4">
                            <label for="mobile2">Mobile 2</label>
                            <input type="text" class="form-control numeric" id="mobile2" name="mobile2" value="<?php echo $mobile2;?>" maxlength="10" minlength="10" autocomplete="off">
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-12">
                            <label for="authorised_person">Email ID</label>
                            <input type="text" class="form-control" id="email_id" name="email_id" value="<?php echo $email_id;?>" autocomplete="off" maxlength="50">
                            </div>
                            
							<div class="form-group col-12">
                            <p class="blue">Permanent Address </p>
                            </div>
                            <div class="form-group col-6">
                            <label for="p_address1"> Address Line 1<span>*</span></label>
                            <input type="text" class="form-control" id="p_address1" name="p_address1" value="<?php echo $p_address1;?>" autocomplete="off" maxlength="30">
                            </div>
							
							<div class="form-group col-6">
                            <label for="p_address2"> Address Line 2<span>*</span></label>
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
                            	
                                	<div class="d-block"><label for="Current Address">Current Address<span>*</span></label></div>
                                	<div class="row">
                                	<div class="col-6">
                                    <label for="Yes" style="font-size:13px; font-style:italic;">
                                     <input type="radio" name="address" value="YES" onclick="data_copy()";> Please tick if current and permanent address is same</label>		
									</div>
									<div class="col-6">
                                    <label for="Yes" style="font-size:13px; font-style:italic;">
                                 <input type="hidden" name="address" value="NO" onclick="data_copy()";> </label>		
									</div>
									<div class="col-12">
										<label for="address" generated="true" class="error d-none">This is required.</label>
									</div>
									</div>

                                </div>
                            
                            <div class="form-group col-6">
                            <label for="c_address1"> Address Line 1<span>*</span></label>
                            <input type="text" class="form-control" id="c_address1" name="c_address1" value="<?php echo $c_address1;?>" autocomplete="off" maxlength="30">
                            </div>
							
							<div class="form-group col-6">
                            <label for="c_address2"> Address Line 2<span>*</span></label>
                            <input type="text" class="form-control" id="c_address2" name="c_address2" value="<?php echo $c_address2;?>" autocomplete="off" maxlength="30">
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-4">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="c_city" name="c_city" value="<?php echo $c_city;?>" maxlength="20" autocomplete="off">			
                            </div>
                            
                            <div class="form-group col-sm-6 col-md-4">
                            <label for="state">State</label>
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
                                    <option value="<?php echo $bresult['bank_name'];?>" <?php if($bresult['bank_name']==$result['bank_name']){?> selected="selected" <?php }?>><?php echo strtoupper($bresult['bank_name']);?></option>
                                    <?php }?>
                                </select>			
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="account_no">Account No.</label>
                                <input type="text" class="form-control numeric" id="account_no" name="account_no" maxlength="20" autocomplete="off">		
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="ifsc">IFSC Code</label>
                                <input type="text" class="form-control" id="ifsc" name="ifsc" maxlength="30" autocomplete="off">		
                            </div>
                            
                            <div class="form-group col-sm-6">
                            	<label class="form-label" for="upload_bank_documents">Upload bank details</label>
                            	<input type="file" id="upload_bank_documents" name="upload_bank_documents" class="form-control" autocomplete="off"><i>Upload bank details (Front page of passbook / ATM slip / Screenshot of net banking)</i></div>
                                
                           	<div class="form-group col-12">
                                <p class="blue">Work Profile </p>
                            </div>
                            
                            <div class="form-group col-sm-6">
								<label class="form-label" for="employment_status"><strong>Current Employment status</strong><span>*</span></label>
                                <div class="d-flex mt-2">
                                
                                    <div class="mr-3">
                                        <label for="Yes">
                                        <input type="radio" id="employment_status" value="Permanent" name="employment_status"> Permanent </label>				
                                    </div>                                    
                                    <div class="mr-3">
                                        <label for="No">
                                        <input type="radio" id="employment_status" value="Contracted" name="employment_status"> Contracted</label>					
                                    </div>                                    
                                    <div>
                                        <label for="No">
                                        <input type="radio" id="employment_status" value="Unemployed" name="employment_status"> Unemployed</label>					
                                    </div>
                                </div>
                                <label for="employment_status" generated="true" class="error d-none">This field is required.</label>
							</div>
                            
                            <div class="form-group col-sm-6">
                            <label for="authorised_mobile1">Work experience in G&J industry (in years) </label>
                            <input type="number" class="form-control" id="work_experience" name="work_experience" maxlength="2" autocomplete="off">		
                            </div>
                            
                            <div class="form-group col-sm-6">
								<label class="form-label" for="applicable_industry"><strong>Applicable Industry</strong><span>*</span></label>
                                <div class="d-flex mt-2">
                                
                                    <div class="mr-3">
                                        <label for="Yes">
                                        <input type="radio" id="applicable_industry" value="Diamond" name="applicable_industry"> Diamond </label>						
                                    </div>                                    
                                    <div class="mr-3">
                                        <label for="No">
                                        <input type="radio" id="applicable_industry" value="Gemstones" name="applicable_industry"> Gemstones</label>					
                                    </div>                                    
                                    <div>
                                        <label for="No">
                                        <input type="radio" id="applicable_industry" value="Jewellery" name="applicable_industry"> Jewellery</label>					
                                    </div>                                    
                                </div>
                                <label for="applicable_industry" generated="true" class="error d-none">This field is required.</label>
							</div>
                            
                            <div class="form-group col-12">
								<label class="form-label" for="applicable_skill"><strong>Tick Applicable Skills</strong> (Select All that apply)</label>
                                <div class="row mt-2">
                                
                                    <div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="applicable_skills" value="mould" name="applicable_skills[]"> Model & mould making </label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="applicable_skills" value="finishing" name="applicable_skills[]"> Finishing / Polishing </label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="applicable_skills" value="retail" name="applicable_skills[]"> Retail Sales </label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="applicable_skills" value="waxing" name="applicable_skills[]"> Waxing </label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="applicable_skills" value="grading" name="applicable_skills[]"> Grading </label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="applicable_skills" value="grinding" name="applicable_skills[]"> Grinding & Assembly</label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="applicable_skills" value="procurement" name="applicable_skills[]"> Procurement </label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="applicable_skills" value="casting" name="applicable_skills[]"> Casting</label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="applicable_skills" value="trading" name="applicable_skills[]"> Trading</label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                    <label for="Yes">
                                    <input type="checkbox" id="applicable_skills" value="assortment" name="applicable_skills[]"> Assortment & Planning</label>			
                                    </div>                                    
                                    <div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="applicable_skills" value="admin" name="applicable_skills[]"> Admin/HR/Finance </label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="applicable_skills" value="handcrafting" name="applicable_skills[]"> Handcrafting </label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                        <label for="Yes"> <input type="checkbox" id="applicable_skills" value="setting" name="applicable_skills[]"> Setting </label>						
                                    </div>                                    
                                    <div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="applicable_skills" value="designing" name="applicable_skills[]"> Designing </label>					
                                    </div> 
									<div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="applicable_skills" value="cutting" name="applicable_skills[]"> Cutting / Polishing / Faceting </label>					
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
                                      <div class="col-md-4">
                                        <label for="Yes">
                                        <input type="checkbox" id="applicable_skills_other" value="other" name="applicable_skills_other"> Others Please Specify</label><input type="text" name="skills_other_input" id="skills_other_input" class="form-control">					
                                    </div>                              
                                </div>
                                <label for="applicable_skills" class="error"></label>
							</div>
                            <div id="kosh">
                            <div class="form-group col-12">
                            <!--    <p class="blue"><label> <input type="checkbox" id="swasthya_kosh_option" class="mr-3" value="Y" name="swasthya_kosh_option">Please tick (√) if you want to opt for a Health Insurance Plan - Swasthya Kosh (only for contractual employee)</label> </p>-->
							<p class="blue"><label>All Parichay card holders will receive a Free health insurance of Sum Assured Rs. 25,000 (Subject to availability of funds in Swasthya Kosh). Please select any of the below 2 options if you want to opt for additional 1 lakh sum assured Health Insurance Plan, the premium for which will be paid by the Parichay card holder:</label> </p>
                            <!--<p class="blue">Note: Self and Spouse below 80 year and Children below 25 years only</p>-->
                            </div>
                            
							<div class="form-group col-12" id="premiumDiv">
                               <div class="d-flex mt-2">
									<div class="mr-3">                                        
                                        <input type="radio" id="isPremiumFamilyNone" value="no" name="isPremium" checked> <label for="isPremiumFamilyNone">None</label>					
                                    </div> 
                                    <div class="mr-3">                                       
                                        <input type="radio" id="isPremiumSelf" value="self" name="isPremium"> <label for="isPremiumSelf"> Self Only (Premium: Rs 1400)  </label>				
                                    </div>                                    
                                    <div class="mr-3">                                        
                                        <input type="radio" id="isPremiumFamily" value="family" name="isPremium"> <label for="isPremiumFamily">Self & Family (Premium: Rs. 2200)</label>					
                                    </div> 
                                </div>                                  
                                <div><label for="isPremium" generated="true" class="error d-none">This is required</label></div>  
                            </div>
							
                            <div class="form-group col-12" >
                                <table class="responsive_table category_table" id="family_table">
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
                                   <!--  <tbody>
                                        <tr>
                                            <td data-column="Particular">01</td>
                                            <td data-column="Full Name"><input type="text" name="spouse_name" id="spouse_name" class="form-control" value=""></td>
                                            <td data-column="Relation">Spouse</td>
                                            <td data-column="Gender">
											<select class="form-control">
											<option selected>Female</option>
											</select>
											</td>										
                                            <td data-column="DOB"><input type="text" name="spouse_dob" id="spouse_dob" class="form-control" value=""></td>										
                                            <td data-column="Age"><input type="text" name="spouse_age" class="form-control numeric" value=""></td>
                                        </tr>
                                         
                                        <tr>
                                            <td data-column="Particular">02</td>
                                            <td data-column="Full Name"><input type="text" name="child1" id="child1" class="form-control" value=""></td>
                                            <td data-column="Relation">Child 1</td>
                                            <td data-column="Gender">
											<select class="form-control" id="child1_gender" name="child1_gender">
											<option value="M">Male</option>
											<option value="F">Female</option>
											</select>
											</td>										
                                            <td data-column="DOB"><input type="text" name="child1_dob" id="child1_dob" class="form-control" value="" readonly></td>										
                                            <td data-column="Age"><input type="text" name="child1_age" class="form-control numeric" value=""></td>
                                        </tr>                                        
                                        <tr>
                                            <td data-column="Particular">03</td>
                                            <td data-column="Full Name"><input type="text" name="child2" id="child2" class="form-control" value=""></td>
                                            <td data-column="Relation">Child 2</td>
                                            <td data-column="Gender">
											<select class="form-control" id="child2_gender" name="child2_gender">
											<option value="M">Male</option>
											<option value="F">Female</option>
											</select>
											</td>										
                                            <td data-column="DOB"><input type="text" name="child2_dob" id="child2_dob" class="form-control" value="" readonly></td>										
                                            <td data-column="Age"><input type="text" name="child2_age" class="form-control numeric" value=""></td>
                                        </tr>
                                    </tbody>                              -->
                                     <tbody>
                                        <tr>
                                            <td data-column="Particular">01</td>
                                            <td data-column="Full Name"><input type="text" name="spouse_name" id="spouse_name" class="form-control" value=""></td>
                                            <td data-column="Relation">Spouse</td>
                                            <td data-column="Gender">
											<select class="form-control" name="spouse_gender" id="spouse_gender">
											<option value=""> Select</option>
											<option value="M">Male</option>
											<option value="F">Female</option>
											</select>
											</td>										
                                            <td data-column="DOB"><input type="text" name="spouse_dob" id="spouse_dob" class="form-control" value="" readonly></td>										
                                            <td data-column="Age"><input type="text" name="spouse_age" id="spouse_age" class="form-control numeric" value=""></td>
                                        </tr>
                                         
                                        <tr>
                                            <td data-column="Particular">02</td>
                                            <td data-column="Full Name"><input type="text" name="child1" id="child1" class="form-control" value=""></td>
                                            <td data-column="Relation">Child 1</td>
                                            <td data-column="Gender">
											<select class="form-control" id="child1_gender" name="child1_gender">
											<option value="">Select</option>
											<option value="M">Male</option>
											<option value="F">Female</option>
											</select>
											</td>										
                                            <td data-column="DOB"><input type="text" name="child1_dob" id="child1_dob" class="form-control" value="" readonly></td>										
                                            <td data-column="Age"><input type="text" name="child1_age" id="child1_age" class="form-control numeric" value=""></td>
                                        </tr>                                        
                                        <tr>
                                            <td data-column="Particular">03</td>
                                            <td data-column="Full Name"><input type="text" name="child2" id="child2" class="form-control" value=""></td>
                                            <td data-column="Relation">Child 2</td>
                                            <td data-column="Gender">
											<select class="form-control" id="child2_gender" name="child2_gender">
												<option value="">Select</option>
											<option value="M">Male</option>
											<option value="F">Female</option>
											</select>
											</td>										
                                            <td data-column="DOB"><input type="text" name="child2_dob" id="child2_dob" class="form-control" value="" readonly></td>										
                                            <td data-column="Age"><input type="text" name="child2_age" id="child2_age" class="form-control numeric" value=""></td>
                                        </tr>
                                    </tbody>                                   
                                </table>
                            </div>
                            </div>
                              <div class="form-group col-12">
                        	<label><input type="checkbox" name="agree_terms" value="yes" id="agree_terms"> Accept Terms And Condition</label>
                        	<a href="https://gjepc.org/terms-conditions-applicant.php" target="_blank" style="color: blue">Click Here to view</a>
                        	<label for="agree_terms" generated="true" class="error d-none">Accept Terms And Conditions</label>
                        </div>  
                            
							<input type="hidden" name="verified" id="verified" readonly/>
                            </div>	
							<div class="form-group">
                      		<button type="submit" id='submit' class="cta fade_anim">Submit</button>
							<span class="otp-messages" style='color: green;'></span>
                        </div>
                        </div>
                    </form> 
                </div> 
                </div>                            
            </div>    
           
</section> 
</div>
<?php include 'include-new/footer_export.php'; ?>
<script type="text/javascript">
// $('input[name="valueType"]').on("change",function(){

//         var valueType = $(this).val();

//         if(valueType =="companyType"){
// 	        
//         }else if(valueType="associationType"){
//         	$("#companyData").show();
// 		    $("#specific-company").slideUp();

//         }
//     });
		    
			$('input[name="valueType"]').click(function(){
		    var valueType = $('[name="valueType"]:checked').val();
		    if(valueType =="associationType"){
		    	$("#specific-company").slideUp();
		    	$("#kosh").show();
		    	
		    //	 alert(valueType);
            $.ajax({
                    type: 'POST',
                    url: 'ajax.php',
                    data: "valueType=associationType",
                    dataType:'html',
                    beforeSend: function(){
                    $('#preloader').show();
					$('#status').show();
                    },
                    success: function(data)
                    {              
					//alert(data);
					$('#preloader').hide();
					$('#status').hide();

                    $("#company-wise").show();
                    $("#companyData").show();
                    $("#companyData").html(data);
                    }
                    });
				} else { 
		    	$("#specific-company").slideDown();
		    	$("#companyData").html();
				 $("#company-wise").hide();
				 $("#kosh").hide();
				}
               });
         		
    $('input[name="type_member"]').click(function(){
    var type_member = $('[name="type_member"]:checked').val();
   // alert(type_member);
            $.ajax({
                    type: 'POST',
                    url: 'ajax.php',
                    data: "actiontype=checkType_member&type_member="+type_member,
                    dataType:'html',
                    beforeSend: function(){
                    $('#preloader').show();
					$('#status').show();
                    },
                    success: function(data)
                    {              
					//alert(data);
					$('#preloader').hide();
					$('#status').hide();
					$("#company-wise").show();
                    $("#companyData").html(data);
                    }
                    });
                    });
		
</script>
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
$(document).ready(function(){
	
	/* Person Mob No1 Check */
	$("#mobile1").change(function(){
	mobile1=$("#mobile1").val();
			$.ajax({
					type: 'POST',
					url: 'ajax.php',
					data: "actiontype=chkPersonMobNo&mobile1="+mobile1,
					dataType:'html',
					beforeSend: function(){
						$('#preloader').show();
						$("#status").show();
					},
					success: function(data){						
							    // alert(data);
								$('#preloader').hide();
								$("#status").hide(); 
								if($.trim(data)==1){
								 	$('#submit').attr('disabled', true);
									$("#chkMob1").html("Mobile No Already Exist").css("color", "red"); 
								} else if($.trim(data)==2){
								 	$('#submit').attr('disabled', true);
									$("#chkMob1").html("Please Enter Mobile No").css("color", "red");
									$('#send_otp').hide();
								} else {
									$('#send_otp').show();
								 	$("#chkMob1").html("");
								 	$('#submit').removeAttr("disabled");
								}
							}
		});
	});
	
	/*.............................Send OTP.......................................*/
	$('#send_otp').click(function(){
	mobile1=$('#mobile1').val();
			$.ajax({
				type:'POST',
				data:"actionType=sendPersonOTP&mobile1="+mobile1,
				url:'ajax.php',
				dataType:'html',
				beforeSend: function(){
		/*		$('#preloader').show();
				$("#status").show();  */				
				$('#imgLoading1').show();				
				$('#send_otp').hide();
				},
			success: function(data){
				//alert(data);
				$('#imgLoading1').hide();
			/*	$('#preloader').hide();
				$("#status").hide(); */
				$('#send_otp').show();
				$('#send_otp').text('Resend OTP');	
			}
		});
	});
	
	/*.............................OTP Checking.......................................*/
	/*$('#otp').keyup(function(){
	mobile_no = $('#mobile1').val();
	otp = $('#otp').val();
	if(otp.length==4){
	$.ajax({
				type:'POST',
				data:"actionType=verifyPersonOTP&mobile_no="+mobile_no+"&otp="+otp,
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
						$('#mobile1').attr('readonly', true);
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
	}); */
	$("#skills_other_input").hide();
	$("#applicable_skills_other").on("change", function(){
      if($(this).prop("checked") == true){
      	$("#skills_other_input").slideDown();
      }else{
      	$("#skills_other_input").slideUp();

      }
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
			valueType: {
				required: true,	
			},
			registration_id: {
				required: true,	
			},
			fname: {
				required: true,				
				specialChrs: true
			},
			surname: {
				required: true,				
				specialChrs: true
			},
			photo: {
				required: true,	
			},
			date_of_birth: {
				required: true,
				//date: true
			}, 			
			gender: { 
				required: true,
			},
			blood_group: {
				required: true,
			},
			education: { 
				required: true,
			},
			id_proof: { 
				required: true,
			}, 
			mobile1: {
				required: true,
				number:true,
				minlength:10,
				maxlength:10
			},
			/*email_id: {
				required: true,
				email:true
			},	*/	
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
			/*address:{
				required:true
			},
			otp:{
				required:true,
				number:true,
				minlength:4,
				maxlength:4
			},*/
			employment_status:{
				required:true
			},
			work_experience:{
				required:true
			},
			applicable_industry:{
				required:true
			},
			/*isPremium:{
				required:true
			}*/
			
		},
		messages: { 
			valueType: {
				required: "This is required.",
			},
			registration_id: {
				required: "This is required.",
			},
			fname: {
				required: "This is required.",
			},
			surname: {
				required: "This is required.",
			},
			photo: {
				required: "This is required.",
			},
			date_of_birth: {
				required: "This is required.",
			},
			gender: {
				required: "This is required.",
			},
			blood_group: {
				required: "This is required.",
			},
			education: {
				required: "This is required.",
			},
			id_proof: {
				required: "This is required.",
			},
			mobile1: {
				required: "This is required.",
				number:"Please Enter numbers only",
				minlength:"Please Enter not less than 10 numbers",
				maxlength:"Please Enter not more than 10 numbers"				
			},	
			/*email_id: {
				required: "This is required.",
			}, */
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
			/*address:{
				required: "This is required.",
			},
			otp: {
				required:"Please Enter OTP",
				number:"Please Enter Valid OTP only"
			},*/
			/*isPremium:{
				required:"This is Required"
			} */
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
		$("label[for='applicable_skills']").hide();
		$("input[name='employment_status']").click(function(){
		var value = $(this).val();
		if(value =="Permanent" || value=="Contracted" || value=="Unemployed"){
			$("label[for='applicable_skills']").show().html("This field is Required");
		}else{
			$("label[for='applicable_skills']").hide();
		}
		});
});

// language
function googleTranslateElementInit() {new google.translate.TranslateElement({pageLanguage:'en',includedLanguages:'hi,en,gu,mr,bn,ml,ta,te,kn',layout:google.translate.TranslateElement.InlineLayout.SIMPLE },'google_translate_element');}
$(window).bind("load",function(){$("span:first",".goog-te-menu-value").text('English');})
</script>

<script>
$(document).ready(function () {
	$("#family_table").hide();

	$(document).on("click","input[name='isPremium']",function(){
		let value = $(this).val();
		if(value =="self" || value =="no"){
			$("#family_table").slideUp();
		}else{
			$("#family_table").slideDown();
		}
	});
	
$("#date_of_birth").datepicker({
format: "yyyy-mm-dd"
});
$("#spouse_dob").datepicker({
format: "yyyy-mm-dd"
});
$("#child1_dob").datepicker({
format: "yyyy/mm/dd"
});
$("#child2_dob").datepicker({
format: "yyyy-mm-dd"
});

        $("#spouse_dob").change(function(){
        var today1 = new Date();    	
    	var spouse_dob = new Date($(this).val());		
		var spouse_age = Math.floor((today1-spouse_dob) / (365.25 * 24 * 60 * 60 * 1000));			
		$('#spouse_age').val(spouse_age);
    });
    $("#child1_dob").change(function(){
    	var today2 = new Date();    	
    	var child1_dob = new Date($(this).val());		
		var child1_age = Math.floor((today2-child1_dob) / (365.25 * 24 * 60 * 60 * 1000));		
		
		$('#child1_age').val(child1_age);
    });
    $("#child2_dob").change(function(){
    	var today3 = new Date();    	
    	var child2_dob = new Date($(this).val());	
		var child2_age = Math.floor((today3-child2_dob) / (365.25 * 24 * 60 * 60 * 1000));		
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