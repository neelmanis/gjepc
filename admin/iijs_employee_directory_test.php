<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
		$adminID = intval(filter($_SESSION['curruser_login_id']));
$registration_id = intval(filter($_REQUEST['regid']));
		$orderId = filter($_REQUEST['orderId']);
			 $id = intval(filter($_REQUEST['id']));
			 
			$admin_name = getAdminName($adminID,$conn);
?>

<?php /* Upload Company Documents */
if($_REQUEST['company_action']=='save_document')
{
		$upload_company_document = '';
		$file_name = $_FILES['upload_company_document']['name'];
		$target_folder = 'company_document_visitor/';
		$target_path = "";
		$file_name = str_replace(" ","_",$file_name);
		$temp_code = rand();
		
		if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name) || preg_match("/.Php/i", $file_name)) 
		{
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='iijs_employee_directory_test.php?action=view';</script>";
			exit;
		}
		elseif($file_name != '')
		{
			if($_FILES["upload_company_document"]["type"] == "application/pdf" || $_FILES["upload_company_document"]["type"] == "application/PDF")
			{
				$target_path = $target_folder.$registration_id.'_'.$temp_code.'_'.$file_name;
				if(@move_uploaded_file($_FILES['upload_company_document']['tmp_name'], $target_path))
				{
				$upload_company_document = $registration_id.'_'.$temp_code.'_'.$file_name;
				$sql = "UPDATE `registration_master` SET company_document=? WHERE id=?";
				$stmt = $conn -> prepare($sql);
				$stmt->bind_param("si", $upload_company_document,$registration_id);
				$stmt->execute();
				echo"<meta http-equiv=refresh content=\"0;url=iijs_employee_directory_test.php?action=view\">";
				}
				else
				{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this  file.\");location.href='iijs_employee_directory_test.php?actions=companyedit&regid=$registration_id';</script>";
				return;
				}
			} else
			{
			 echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='iijs_employee_directory_test.php?actions=companyedit&regid=$registration_id';</script>";
			}		
		}
}
?>

<?php
$regsql = "select company_name,email_id from registration_master where id = '$registration_id'";
$regquery = $conn ->query($regsql);
while($regrow = $regquery->fetch_assoc())
{
$companyname = filter($regrow['company_name']);
   $email_id = filter($regrow['email_id']);
}
?>
<?php
if($_REQUEST['action']=='vaccineUploadAction')
{    
		function uploadSingleVIsitorCovid($file_name,$file_temp,$file_type,$file_size,$mobile,$name,$certificate,$registration_id)
		{
			$upload_image = '';	
			$target_folder = '/var/www/html/registration.gjepc.org/images/covid/vis/'.$registration_id.'/'.$name.'/';
			$target_path = "";
			$user_id = $registration_id;
			$file_name = str_replace(" ","_",$file_name);
			
			if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
		    echo "Sorry something error while uploading..."; exit;
			}
			else if($file_name != '')
			{
				if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf")) && $file_size < 2097152)
				{
					$random_name = rand();
					 $target_path = $target_folder.$certificate.'_'.$mobile."_".$file_name;
					if(@move_uploaded_file($file_temp, $target_path))
					{
						  $upload_image = $certificate."_".$mobile."_".$file_name;
					}
					else
					{
						 $upload_image = "fail";
					}
				}
				else
				{
					 $upload_image = "invalid";
				}	
			}			
			return $upload_image;
		}

        $registration_id = $_POST['registration_id'];
	    $visitor_id = $_POST['visitor_id'];
        $certificate = $_POST['valueType'];
        $via="self";
	    
		/*=======================GET Details OF VISITOR===========================*/
         
         $resultMobileSql =$conn->query("SELECT * FROM `visitor_directory` WHERE `visitor_id`='$visitor_id'");
         $getMobileRow = 	 $resultMobileSql->fetch_assoc();
         $isSecondary = $getMobileRow['isSecondary'];
         if($isSecondary =="Y"){
         	$mobile_no = $getMobileRow['secondary_mobile'];
         }else{
         	$mobile_no = $getMobileRow['mobile'];
         }
        $visitor_email = $getMobileRow['email'];
		$CompanyName = getCompanyName($registration_id,$conn); 
	    $visitorName = $getMobileRow['name']." ".$getMobileRow['lname'];
        $pan_no = $getMobileRow['pan_no'];


		/*=======================GET Details OF VISITOR===========================*/

		/*==================GET VISITOR SELECTED SHOW=============*/
		$category_for = getVisitorSelectedShow($visitor_id,$conn);
	
		if($category_for =="igjme22"){
	    $category_for = "IGJME";
		}else{
	    $category_for ="VIS";
		}
		/*===============GET VISITOR SELECTED SHOW================*/

		$create_directory = 'images/covid/vis/'.$registration_id ;
		if(!file_exists($create_directory)) {
		mkdir($create_directory, 0777);
	    }

	    if(isset($_FILES['vaccine_certificate']) && $_FILES['vaccine_certificate']['name']!=""){
		
		$vaccine_certificate_name=$_FILES['vaccine_certificate']['name'];
		$vaccine_certificate_temp=$_FILES['vaccine_certificate']['tmp_name'];
		$vaccine_certificate_type=$_FILES['vaccine_certificate']['type'];
		$vaccine_certificate_size=$_FILES['vaccine_certificate']['size'];

		$attach="vaccine_certificate";
		if($vaccine_certificate_name!="")
		{
		    $create_vaccine_certificate = 'images/covid/vis/'.$registration_id.'/'.$attach;
			if (!file_exists($create_vaccine_certificate)) {
			mkdir($create_vaccine_certificate, 0777);
			}
			  $vaccine_certificate=uploadSingleVIsitorCovid($vaccine_certificate_name,$vaccine_certificate_temp,$vaccine_certificate_type,$vaccine_certificate_size,$mobile_no,$attach,$certificate,$registration_id);
			 if ($vaccine_certificate =="fail") {
			 	echo "<script> alert('Sorry, report uploading has been failed on server. Please contact administrator');</script>";
			 	
			 }elseif ($vaccine_certificate =="invalid") {
			 
			  		 	echo "<script> alert('Please Select valid file type');</script>";
			  		 	 echo "<meta http-equiv=refresh content=\"0;url=iijs_employee_directory_test.php?action=uploadVaccineCertificate&visitor_id=$visitor_id&registration_id=$registration_id\">"; exit;
			 }
		}else{
			
			echo "<script> alert('Please Select covid vaccination certificate');</script>";
			 echo "<meta http-equiv=refresh content=\"0;url=iijs_employee_directory_test.php?action=uploadVaccineCertificate&visitor_id=$visitor_id&registration_id=$registration_id\">"; exit;
		}
		}else{
	
			echo "<script> alert('Please Select covid vaccination certificate');</script>";
			 echo "<meta http-equiv=refresh content=\"0;url=iijs_employee_directory_test.php?action=uploadVaccineCertificate&visitor_id=$visitor_id&registration_id=$registration_id\">"; exit;
		}

	$checkData = "SELECT * FROM visitor_lab_info WHERE registration_id='$registration_id' AND visitor_id='$visitor_id'" ;
	$resultData =$conn->query($checkData);
	$countData =  $resultData->num_rows;
 
	$datetime = date("Y-m-d H:i:s");
	
	/*======================= SEND SMS AFTER UPLOAD CERTIFICATE  ===================*/
	$cert = "Vaccination Certificate";
	$website = "IIJS PREMIERE 2022";
    //$smsContent ="Your ".$cert." has been uploaded successfully. We will notify you on approval/disapproval of the document. Regards, GJEPC"; 
    $smsContent ="Your ".$cert." has been uploaded successfully for ".$website." .We will notify you on approval/disapproval. Regards, GJEPC";
    //get_data($smsContent,$mobile_no);
   // send_sms($smsContent,$mobile_no);
    /*==============================SHOW MESSAGE AFTER UPLOAD CERTIFICATE=============================*/

    if($certificate =='dose1'){
    	$messagev = "It is compulsory to carry Covid-19 Negative Report (RT PCR Test) done before 72 hrs before your first visit at IIJS Signature 2022";
    }else{
    	$messagev = "We will update you on Vaccination Certificate approval soon";
    }
    
	if($countData > 0){
		if($certificate =='dose1'){

            $updateData =  $conn->query("UPDATE visitor_lab_info SET `dose1`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`dose1_status`='U',`modified_at`='$datetime' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND `category_for`='$category_for'");

		} else {

             $updateData =  $conn->query("UPDATE visitor_lab_info SET `dose2`='$vaccine_certificate',`certificate`='$certificate',`approval_status`='U',`dose2_status`='U',`modified_at`='$datetime' WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND `category_for`='$category_for'");
		} 
		$ansData = $conn ->query($updateData);
       
       echo "<script> alert('Uploaded successfully');</script>";
        echo "<meta http-equiv=refresh content=\"0;url=iijs_employee_directory_test.php?action=uploadVaccineCertificate&visitor_id=$visitor_id&registration_id=$registration_id\">"; exit;
        
	}else{

		if($certificate =='dose1'){

        $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`,`certificate`,`dose1`, `status`,`approval_status`,`dose1_status`,`category_for`) VALUES ('$registration_id', '$visitor_id', '$pan_no', '$mobile_no', '$via','$certificate','$vaccine_certificate','1','P','P','$category_for')";

		}else{

        $sqlx = "INSERT INTO `visitor_lab_info` (`registration_id`, `visitor_id`, `pan_no`, `mobile_no`, `via`,`certificate`,`dose2`, `status`,`approval_status`,`dose1_status`,`category_for`) VALUES ('$registration_id', '$visitor_id', '$pan_no', '$mobile_no', '$via','$certificate','$vaccine_certificate','1','P','P','$category_for')";

		}
	    $ansData = $conn ->query($sqlx);	     
	    
	    echo "<script> alert('Uploaded successfully');</script>";
	    echo "<meta http-equiv=refresh content=\"0;url=iijs_employee_directory_test.php?action=uploadVaccineCertificate&visitor_id=$visitor_id&registration_id=$registration_id\">"; exit;
	    
	}
}
?>
<?php
if($_REQUEST['action']=='old_to_part')
{
		$get = "SELECT * FROM  `visitor_order_detail` WHERE  `sales_order_no` = 'old-to part' AND `sap_sale_order_create_status` =  '1'";
		$result_query = $conn ->query($get);
		$getCount = $result_query->num_rows;
		if($getCount >0){
		$sql="UPDATE `visitor_order_detail` SET `sap_sale_order_create_status` = '0', `sales_order_no` ='' WHERE `sales_order_no` ='old-to part' AND `sap_sale_order_create_status` = '1'";
		$result = $conn ->query($sql);   
        if(!$result) die ($conn->error);
		echo "<meta http-equiv=refresh content=\"0;url=iijs_employee_directory_test.php?action=view\">";
		} else { 
		echo "<script> alert('No old To Part Found');</script>";
		echo "<meta http-equiv=refresh content=\"0;url=iijs_employee_directory_test.php?action=view\">";
		}		
}
?>
<?php
if(($_REQUEST['action']=='delVisitor') && ($_REQUEST['visitor_id']!='') && ($_REQUEST['registration_id']!=''))
{ 
	//echo '<pre>'; print_r($_REQUEST); exit;
	$visitor_id = filter($_REQUEST['visitor_id']);	
	$registration_id  = filter(intval($_REQUEST['registration_id']));
	
	$sqlPaymentCheck = "SELECT * FROM visitor_order_history WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND status='1' AND payment_status='Y' AND (`show`='combo23' || `show`='igjme22' || `show`='iijstritiya23' || `show`='iijs22' || `show`='signature23')";
    $resultPaymentCheck = $conn->query($sqlPaymentCheck);
    $countPaymentCheck = $resultPaymentCheck->num_rows;
    if($countPaymentCheck > 0 ){
	echo "<script> alert('Visitor is Already Registered for Current Show');</script>";
	echo "<meta http-equiv=refresh content=\"0;url=iijs_employee_directory_test.php?action=viewReg&regid=$registration_id\">"; exit;
	} else {
    $ssx = "INSERT INTO visitor_directory_deleted
		SELECT * FROM  visitor_directory WHERE visitor_id = $visitor_id AND `registration_id`='$registration_id'";
	$queryData = $conn->query($ssx);
	
	$ssy = "INSERT INTO visitor_lab_info_log SELECT * FROM visitor_lab_info WHERE visitor_id = '$visitor_id' AND `registration_id`='$registration_id'";
	$queryDatas = $conn->query($ssy);
	if($queryDatas){
	$deletxy = "DELETE FROM `visitor_lab_info` WHERE visitor_id = $visitor_id AND `registration_id`='$registration_id' limit 1";
	$resultxy = $conn->query($deletxy);
	}
	
	if($queryData){
	$deletx = "DELETE FROM `visitor_directory` WHERE `registration_id`='$registration_id' AND `visitor_id` ='$visitor_id' limit 1"; 
	$resultx = $conn->query($deletx);
	if($resultx){
	$updatx = "UPDATE `visitor_directory_deleted` SET `admin_delete_id` = '$adminID' WHERE `registration_id`='$registration_id' AND `visitor_id` ='$visitor_id' limit 1"; 
	$updatx = $conn->query($updatx);
	echo "<script> alert('Deleted from Visitor directory');</script>";
	echo "<meta http-equiv=refresh content=\"0;url=iijs_employee_directory_test.php?action=viewReg&regid=$registration_id\">"; exit;
	}
	} else { die ($conn->error); }	
	}
}
?>
<?php
if(($_REQUEST['action']=='global') && ($_REQUEST['visitor_id']!='') && ($_REQUEST['registration_id']!=''))
{ 
	//echo '<pre>'; print_r($_REQUEST); exit;
	$visitor_id = filter($_REQUEST['visitor_id']);	
	$registration_id  = filter(intval($_REQUEST['registration_id']));
	$shortcode = $_REQUEST['show'];
	/*Global Table Start */
		
		$name = VisitorName($visitor_id,$conn);
		$visitorPAN = getVisitorPAN($visitor_id,$conn);
		$visitorMobile = getVisitorMobile($visitor_id,$conn);
		$designation = getVisitorSDesignation($visitor_id,$conn);
		$visitorDesignation =  getVisitorDesignation($designation,$conn); 
		$visitorPhoto =  getVisitorPhoto($visitor_id,$conn); 		 
		$photo_url = "https://registration.gjepc.org/images/employee_directory/".$registration_id."/photo/".$visitorPhoto;
		
		$getCompany_name = trim(getCompanyNameFromregistration($registration_id,$conn));
		$company_name = str_replace('&amp;', '&', $getCompany_name);
		$company_name = str_replace ("'","\'",$company_name);
        $visitoSecondaryMobile = getVisitorSecondaryMobile($visitor_id,$conn);
		$isSecondary = getVisitorSecondaryMobileStatus($visitor_id,$conn);
		$digits = 9;	
	    $uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		
	    $checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
	    $countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
		while($countUniqueIdentifier > 0) {
		$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
		} 
						
		$checkGlobalRecord = "SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='VIS' AND `event`='$shortcode'";
		$globalResult = $conn->query($checkGlobalRecord);
        $checkGlobalCount = $globalResult->num_rows;
	    if($checkGlobalCount>0){
		$updateGlobal = "UPDATE globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`fname`='$name',`mobile`='$visitorMobile',`secondary_mobile`='$visitoSecondaryMobile',`isSecondary`='$isSecondary',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`covid_report_status`='pending',`status`='P' WHERE `registration_id`='$registration_id' AND `visitor_id`='$visitor_id' AND `pan_no`='$visitorPAN' AND participant_Type='VIS' AND `event`='$shortcode'";
	//	$updateGlobalResult = $conn->query($updateGlobal);
		} else { 
		$insertGlobal = "INSERT INTO globalExhibition  SET `uniqueIdentifier`='$uniqueIdentifier',`registration_id`='$registration_id',`visitor_id`='$visitor_id',`fname`='$name',`mobile`='$visitorMobile',`secondary_mobile`='$visitoSecondaryMobile',`isSecondary`='$isSecondary',`pan_no`='$visitorPAN',`designation`='$visitorDesignation',`company`='$company_name',`photo_url`='$photo_url',`participant_type`='VIS',`covid_report_status`='pending',`status`='P', `event`='$shortcode'";
		$insertGlobalResult = $conn->query($insertGlobal);
		if (!$insertGlobalResult) die ($conn->error);
		}
		/*Global Table End */
	
}
?>
<?php
if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{	

	function compressImage($source, $destination, $quality) 
	{
	    $imgInfo = getimagesize($source); 
	    $mime = $imgInfo['mime']; 
	    switch($mime){ 
	        case 'image/jpeg': 
	            $image = imagecreatefromjpeg($source); 
	            break; 
	        case 'image/png': 
	            $image = imagecreatefrompng($source); 
	            break; 
	        case 'image/jpg': 
	            $image = imagecreatefromgif($source); 
	            break; 
	        default: 
	            $image = imagecreatefromjpeg($source); 
	    } 
	    // Save image 
	    imagejpeg($image, $destination, $quality); 
	    // Return compressed image 
	    return $destination; 
	}

	function uploadVisitorPhoto($file_name,$file_temp,$file_type,$file_size,$id,$name,$registration_id)
	{
		$upload_image = '';
		$target_folder = '/var/www/html/registration.gjepc.org/images/employee_directory/'.$registration_id.'/'.$name.'/';
		//$filename="images/employee_directory/".$_SESSION['USERID'];
		$target_path = "";
		$user_id = $registration_id;
		$file_name = str_replace(" ","_",$file_name);
		$file_name = str_replace(".php","",$file_name);
		$file_name = str_replace("'","",$file_name);
		
		if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name)) {
	    echo "Sorry something error while uploading..."; exit;
		}
		else if($file_name != '')
		{
			if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") ) && $file_size < 5242880)
			{
				$random_name = rand();
				$target_path = $target_folder.$user_id.'_'.$id.'_'.$name.'_'.$random_name.$file_name;
				//if(@move_uploaded_file($file_temp, $target_path))
				$compressedImage = compressImage($file_temp, $target_path, 75); 
				if($compressedImage)
				{
					  $upload_image = $user_id.'_'.$id.'_'.$name.'_'.$random_name.$file_name;
				}
				else
				{
					 $upload_image = "fail";
				}
			}
			else
			{
				 $upload_image = "invalid";
			}	
		}
		return $upload_image;
	}

	$event_name = "GJEPC INDIA";
	$id    = intval(filter($_REQUEST['id']));
	$name  = filter(strtoupper($_REQUEST['name']));
	$lname = filter(strtoupper($_REQUEST['lname']));
	$email = filter($_REQUEST['email']);
	$aadhar_no  = filter($_REQUEST['aadhar_no']);
	$sendMobile = filter($_REQUEST['mobile']);
	$category = filter($_REQUEST['category']);
	$approval   = filter($_REQUEST['approval']);
	$disapprove_reason = filter($_REQUEST['disapprove_reason']);
	$result_visitor = $conn->query("SELECT * FROM visitor_directory WHERE visitor_id='$id' AND registration_id='$registration_id'");
	$row_visitor = $result_visitor ->fetch_assoc();
	$old_photo = $row_visitor['photo'];
	$pan_no = $row_visitor['pan_no'];

	$face_isApplied = filter($row_visitor['face_isApplied']);
	$face_status = filter($row_visitor['face_status']);

   $registration_id=filter($_GET['regid']);
	if(isset($_FILES['photo']) && $_FILES['photo']['name']!="")
	{

		/* passport picture */
		$photo_name=$_FILES['photo']['name'];
		$photo_temp=$_FILES['photo']['tmp_name'];
		$photo_type=$_FILES['photo']['type'];
		$photo_size=$_FILES['photo']['size'];
		/*$id = $_SESSION['visitor_id'];*/
		$attach="photo";
		if($photo_name!="")
		{
		 //     $create_photo = '/var/www/html/registration.gjepc.org/images/employee_directory/'.$registration_id.'/'.$attach;
			// if (!file_exists($create_photo)) {
			// mkdir($create_photo, 0777);
			// }
			//echo "----------------";exit;
			  $photo = uploadVisitorPhoto($photo_name,$photo_temp,$photo_type,$photo_size,$visitor_id,$attach,$registration_id);
			
		}
	}else{
	 $photo = getVisitorPhoto($id,$conn);
		
	}
		
   if($approval == "Y"){ $disapprove_reason = ""; }
	else if($approval == "P"){ $disapprove_reason = ""; }
	else{$approval = "D";}

	if($face_isApplied =="Y"){
		$sqlx = "UPDATE `visitor_directory` SET `mod_date`=NOW(), name='$name', lname='$lname', aadhar_no='$aadhar_no', `visitor_approval`='$approval', `disapprove_reason`='$disapprove_reason',category='$category',photo='$photo',old_photo='$old_photo',adminID='$adminID',face_status='$approval',face_disapprove_reason='$disapprove_reason',face_modify=NOW() WHERE visitor_id='$id' and registration_id='$registration_id'";

		$photo_log = $conn->query(" INSERT INTO visitor_photo_log SET visitor_id='$id',registration_id='$registration_id',pan_no='$pan_no', old_photo='$old_photo',new_photo='$photo',admin_id='$adminID',created_at=NOW(),modified_at=NOW() ");

	  $checkEntry = $conn->query("SELECT * FROM globalExhibition WHERE `registration_id`='$registration_id' AND `visitor_id`='$id' AND (`participant_Type`='VIS' OR `participant_Type`='IGJME' )");
     $checkCount = $checkEntry->num_rows;
     $checkEntryRow = $checkEntry->fetch_assoc();

    if($checkCount >0){
         
        $photo_url= 'https://registration.gjepc.org/images/employee_directory/'.$registration_id.'/photo/'.$photo;
          $updateGlobal = "UPDATE globalExhibition SET photo_url='$photo_url',isDataPosted='N' WHERE `registration_id`='$registration_id' AND `visitor_id`='$id' AND (`participant_Type`='VIS' OR `participant_Type`='IGJME' ) ";
        $resultStatusUpdate = $conn->query($updateGlobal);
     }


	}else{
		$sqlx = "UPDATE `visitor_directory` SET `mod_date`=NOW(), name='$name', lname='$lname', aadhar_no='$aadhar_no', `visitor_approval`='$approval', `disapprove_reason`='$disapprove_reason',category='$category',photo='$photo',adminID='$adminID' WHERE visitor_id='$id' and registration_id='$registration_id'";
	}
	
	$resultx = $conn ->query($sqlx);
	
	$sqlLogs = "INSERT INTO visitor_approval_logs SET post_date=NOW(), registration_id='$registration_id',visitor_id='$id',admin_id='$adminID',admin_name='$admin_name',type='visitor_approval',action='$approval',reason='$disapprove_reason'"; 
	$resultLogs = $conn ->query($sqlLogs);
	
if($resultx)
{	
		/*.......................Send mail For Approved........................*/
if($approval=='Y')
{
	$website = "IIJS PREMIERE 2022";
	$url = "https://registration.gjepc.org/single_visitor.php";
	//$message = "Dear ".$name.", your data for visitor badge has been approved, Kindly proceed for visitor registration of IIJS PREMIERE 2022 SHOW.Please visit https://gjepc.org/iijs-signature/";
	
	//$message ="Dear ".$name.", your documents have been approved, kindly proceed for the payment for IIJS Signature 2022, click on https://registration.gjepc.org/single_visitor.php, In case of any further query please contact 1800-103-4353. Regards, GJEPC.";
	
	$message = "Dear ".$name.", your documents have been approved, kindly proceed for the payment for $website, click on https://registration.gjepc.org/single_visitor.php, In case of any further query please contact 1800-103-4353. Regards, GJEPC.";
	send_sms($message,$sendMobile);
	
	/* WhastApp Msg */
	$msgurl = single_visitor_approval($sendMobile,$name,$website,$url);
	$getResults = json_decode($msgurl,true);

$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
       <td align="left"><img src="https://gjepc.org/assets/images/logo.png"/></td>
       <td></td>
       <td></td>
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>PARTICIPANT PRE-REGISTRATION APPLICATION FOR THE SHOW</u></strong></td></tr>
	<tr>
    <td align="left"  style="text-align:justify;"><strong>Company Name :</strong> '. $companyname .' </td>
    </tr>
	<tr>
    <td align="left"  style="text-align:justify;"><strong>Email Id :</strong> '. $email_id .' </td>
    </tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table width="100%" style="border: 1px solid #ccc; border-collapse: separate; margin: 0; padding: 0; background: white; width: 100%; text-align:center; table-layout: fixed;">                
                <thead>
                  <tr style="background: #f8f8f8; border: 1px solid #ddd; padding:.35em;">
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54; height: 43px;">Name of Visitor</th>
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54; height: 43px;">Status </th>                                       
                  </tr>
                </thead>
                <tbody>
                  <tr style="background: #f8f8f8; border: 1px solid #ddd; padding: .35em;">
                    <td data-label="Pattern Name" style="padding: .625em; text-align: center; padding: 10px 20px;">'.$name.' '.$lname.'</td>
                    <td data-label="SIZE" style="padding: .625em; text-align: center; padding: 10px 20px;">Approved</td>                                       
                  </tr>
                </tbody>
              </table>
    </tr>
    <tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <p>
                <b>THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</b><br>
                D2B, D-Tower, West Core Wing, Bharat Dimaond Bourse, Bandra Kurla Complex, Bandra (E) - 400 051 <br> <b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br> Website: <a href="https://gjepc.org">https://gjepc.org</a>
            </p>
        </td>
    </tr>       
</tbody>
</table>';

	$to =$email_id.',pvr@gjepcindia.com';	
	$subject = "YOUR DATA FOR VISITOR BADGE FOR THE SHOW APPROVED"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 		
	$headers .= 'From: GJEPC INDIA <admin@gjepc.org>';	
	mail($to, $subject, $message, $headers);
}
else if($approval=='D') //Send mail For DisApproved
{
	$url = "https://registration.gjepc.org/single_visitor.php";
	
	//$message = "Dear ".$name.", your data for visitor badge has been disapproved, Due to $disapprove_reason kindly update your record at IIJS PREMIERE 2022 SHOW";
	$message = "Dear ".$name.", your documents have been disapproved, due to $disapprove_reason, Kindly re upload your valid documents on https://registration.gjepc.org/single_visitor.php. In case of further assistance please contact 1800-103-4353.Regards, GJEPC";
	send_sms($message,$sendMobile); 
	
	/* WhastApp Msg */
/*	$msgurl = single_visitor_disapproval($sendMobile,$name,$disapprove_reason,$url);
	$getResults = json_decode($msgurl,true);
*/
	
$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
       <td align="left"><img src="https://gjepc.org/assets/images/logo.png"/></td>
       <td></td>
       <td></td>
	  
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>PARTICIPANT PRE-REGISTRATION APPLICATION FOR THE SHOW</u></strong></td></tr>
	<tr>
    <td align="left"  style="text-align:justify;"><strong>Company Name :</strong> '. $companyname .' </td>
    </tr>
	<tr>
    <td align="left"  style="text-align:justify;"><strong>Email Id :</strong> '. $email_id .' </td>
    </tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table style="border: 1px solid #ccc; border-collapse: separate; margin: 0; padding: 0; background: white; width: 100%; text-align:center; table-layout: fixed;">                
                <thead>
                  <tr style="background: #f8f8f8;border: 1px solid #ddd;padding: .35em;">
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">Name of Visitor</th>
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">Status </th>
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">Reason for Disapproval  </th>                                       
                  </tr>
                </thead>
                <tbody>
                  <tr style="background: #f8f8f8;border: 1px solid #ddd; padding: .35em;">
                    <td data-label="Pattern Name" style="padding: .625em;text-align: center; padding: 10px 20px;">'.$name.' '.$lname.'</td>
                    <td data-label="SIZE" style="padding: .625em;text-align: center; padding: 10px 20px;">Disapproved</td>
                    <td data-label="Star Rating" style="padding: .625em;text-align: center; padding: 10px 20px;">'.$disapprove_reason.'</td>                    
                  </tr>
                </tbody>
              </table>
    </tr>
    <tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <p>
                <b>THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</b><br>
                D2B, D-Tower, West Core Wing, Bharat Dimaond Bourse, Bandra Kurla Complex, Bandra (E) - 400 051 <br> <b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br> Website: <a href="https://gjepc.org">https://gjepc.org</a>
            </p>
        </td>
    </tr>       
</tbody>
</table>';

	$to =$email_id.',pvr@gjepcindia.com';
	$subject = "YOUR DATA FOR VISITOR BADGE FOR THE SHOW DISAPPROVED"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .= 'From: GJEPC INDIA <admin@gjepc.org>';			
	mail($to, $subject, $message, $headers);
}
/***  Emailer End **/
echo"<meta http-equiv=refresh content=\"0;url=iijs_employee_directory_test.php?action=viewReg&regid=$registration_id\">";
}
}
?>

<?php
if(($_REQUEST['actions']=='compupdate')&&($_REQUEST['regid']!=''))
{	
	$comp_name = filter($_REQUEST['comp_name']);
	$emailid   = filter($_REQUEST['emailid']);
	$approval_status = filter($_REQUEST['approval_status']);
	$disapprove	=	filter($_REQUEST['disapprove']);
	$company_pan_no = str_replace(' ','',strtoupper(filter($_REQUEST['company_pan_no'])));
	$company_gstn   = str_replace(' ','',strtoupper(filter($_REQUEST['company_gstn'])));
	$mobile_no = filter($_REQUEST['mobile_no']);
	$company_type = filter($_REQUEST['comp_type']);
	$state = filter($_REQUEST['state']);
	$city = filter($_REQUEST['city']);
	$pin_code = filter($_REQUEST['pin_code']);
		
		 if($approval_status == "Y"){ $disapprove = ""; }
	else if($approval_status == "P"){ $disapprove = ""; }
	else if($approval_status == ""){ $disapprove = ""; }
	else { $approval_status = "D";}
	
	/*$sqlreg = "UPDATE `registration_master` SET company_name='$comp_name', email_id='$emailid', company_pan_no='$company_pan_no', company_gstn='$company_gstn', mobile_no='$mobile_no', `approval_status`='$approval_status', `disapprove`='$disapprove' WHERE id='$registration_id'"; */
	
	$query = $conn ->query("select * from registration_master where company_pan_no='$company_pan_no' AND id!=$registration_id");
    $num   = $query->num_rows;
	if($num>0)
	{
		echo '<script language="javascript">';
		echo 'alert("PAN No Not Updated because already exists")';
		echo '</script>';		
	echo "<meta http-equiv=refresh content=\"0;url=iijs_employee_directory_test.php?action=view\">"; exit;
	}
	
	$sqlreg = "UPDATE `registration_master` SET company_pan_no='$company_pan_no', company_gstn='$company_gstn',company_type='$company_type', state='$state',city='$city',pin_code='$pin_code', `approval_status`='$approval_status', `disapprove`='$disapprove' WHERE id='$registration_id'";
	$resultreg = $conn ->query($sqlreg);
	
	$sqlLogs = "INSERT INTO visitor_approval_logs SET post_date=NOW(), registration_id='$registration_id',admin_id='$adminID',admin_name='$admin_name',type='company_approval',action='$approval_status',reason='$disapprove'";
	$resultLogs = $conn ->query($sqlLogs);
	
if($resultreg)
{	
		/*.......................Send mail For Approved........................*/
if($approval_status=='Y')
{
$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
       <td align="left"><img src="https://gjepc.org/assets/images/logo.png"/></td>
       <td></td>
       <td></td>
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>PARTICIPANT PRE-REGISTRATION APPLICATION FOR THE SHOW</u></strong></td></tr>
	<tr>
    <td align="left"  style="text-align:justify;"><strong>Company Name :</strong> '. $comp_name .' </td>
    </tr>
	<tr>
    <td align="left"  style="text-align:justify;"><strong>Email Id :</strong> '. $emailid .' </td>
    </tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table width="100%" style="border: 1px solid #ccc; border-collapse: separate; margin: 0; padding: 0; background: white; width: 100%; text-align:center; table-layout: fixed;">                
                <thead>
                  <tr style="background: #f8f8f8;border: 1px solid #ddd;padding: .35em;">
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54; height: 43px;">Company Name</th>
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54; height: 43px;">Status </th>                                       
                  </tr>
                </thead>
                <tbody>
                  <tr style="background: #f8f8f8; border: 1px solid #ddd; padding: .35em;">
                    <td data-label="Pattern Name" style="padding: .625em; text-align: center; padding: 10px 20px;">'.$comp_name.'</td>
                    <td data-label="SIZE" style="padding: .625em; text-align: center; padding: 10px 20px;">Approved</td>                                       
                  </tr>
                </tbody>
    </table>
    </tr>
    
    <tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <p>
                <b>THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</b><br>
                D2B, D-Tower, West Core Wing, Bharat Dimaond Bourse, Bandra Kurla Complex, Bandra (E) - 400 051 <br> <b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br> Website: <a href="https://gjepc.org">https://gjepc.org</a>
            </p>
        </td>
    </tr>       
</tbody>
</table>';

//	$to =$email_id.',pvr@gjepcindia.com';
	$subject = "YOUR GST And PAN No FOR THE SHOW Approved"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .= 'From: GJEPC INDIA <admin@gjepc.org>';				
	mail($to, $subject, $message, $headers);
}
else if($approval_status=='D') //Send mail For DisApproved
{
$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
       <td align="left"><img src="https://gjepc.org/assets/images/logo.png"/></td>
       <td></td>
       <td></td>
	  
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>PARTICIPANT PRE-REGISTRATION APPLICATION FOR THE SHOW</u></strong></td></tr>
	<tr>
    <td align="left" style="text-align:justify;"><strong>Company Name :</strong> '. $comp_name .' </td>
    </tr>
	<tr>
    <td align="left" style="text-align:justify;"><strong>Email Id :</strong> '. $emailid .' </td>
    </tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table style="border: 1px solid #ccc; border-collapse: separate; margin: 0; padding: 0; background: white; width: 100%; text-align:center; table-layout: fixed;">                
                <thead>
                  <tr style="background: #f8f8f8;border: 1px solid #ddd;padding: .35em;">
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">Company Name</th>
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">Status </th>
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">Reason for Disapproval  </th>                                       
                  </tr>
                </thead>
                <tbody>
                  <tr style="background: #f8f8f8;border: 1px solid #ddd;padding: .35em;">
                    <td data-label="Pattern Name" style="padding: .625em;text-align: center; padding: 10px 20px;">'.$comp_name.'</td>
                    <td data-label="SIZE" style="padding: .625em;text-align: center; padding: 10px 20px;">Disapproved</td>
                    <td data-label="Star Rating" style="padding: .625em;text-align: center; padding: 10px 20px;">'.$disapprove.'</td>                    
                  </tr>
                </tbody>
              </table>
    </tr>
     <tr>
	<td colspan="2"><br/>
	<p>Disapproved application can process for the participation through following link:
    <a href="https://gjepc.org/iijs-premiere/" target="_blank">https://gjepc.org/iijs-premiere/</a></p>
	</td>
	</tr>
    <tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <p>
                <b>THE GEM JEWELLERY EXPORT PROMOTION COUNCIL</b><br>
                D2B, D-Tower, West Core Wing, Bharat Dimaond Bourse, Bandra Kurla Complex, Bandra (E) - 400 051 <br> <b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br> Website: <a href="https://gjepc.org">https://gjepc.org</a>
            </p>
        </td>
    </tr>       
</tbody>
</table>';

	$to =$email_id.',pvr@gjepcindia.com';
	$subject = "YOUR GST and PAN No FOR THE SHOW Disapproved"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .= 'From: GJEPC INDIA <admin@gjepc.org>';		
	mail($to, $subject, $message, $headers);
}
/***  Emailer End **/
echo"<meta http-equiv=refresh content=\"0;url=iijs_employee_directory_test.php?action=view\">";
}
}
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['company_name']="";
  $_SESSION['pan_no']="";
  $_SESSION['mobile']="";
  $_SESSION['visitor_approval']="";
 
  $_SESSION['face_status']='';
  
  header("Location: iijs_employee_directory_test.php?action=view");
} else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['company_name']=	filter($_REQUEST['company_name']);
	$_SESSION['pan_no']		 = 	filter($_REQUEST['pan_no']);
	$_SESSION['mobile']		 =  filter($_REQUEST['mobile']);
	$_SESSION['visitor_approval'] = $_REQUEST['visitor_approval'];
	
	$_SESSION['face_status'] = $_REQUEST['face_status'];
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS PREMIERE 2022</title>
<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="fancybox/fancybox_css.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="https://gjepc.org/assets-new/js/jquery.min.js?v=<?php echo $version;?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
<script type="text/javascript" src="fancybox/fancybox_js.js"></script>

<!-- CROPPER JS START-->
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
<script src="https://unpkg.com/dropzone"></script>
<script src="https://unpkg.com/cropperjs"></script>
<!-- CROPPER JS END -->    

<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<script src="https://gjepc.org/iijs-signature/assets/js/bootstrap.min.js"></script>
<!--navigation end-->
<!-- lightbox Thum -->
<script type="text/javascript">		
$("div.fancyDemo a").fancybox();
</script> 
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<!-- lightbox Thum -->

<script>
$(document).ready(function(){
$('#disapproval').hide();

$('#disapprove').click(function(){
//alert('disapprove');
		$('#disapproval').show();
      });
	  $('#approve').click(function(){
//alert('disapprove');
		$('#disapproval').hide();
      });
});
</script>

<?php
$sql3 = "SELECT * FROM visitor_directory where visitor_id='$id'";
$result3 = $conn ->query($sql3);
if($row3 = $result3->fetch_assoc())
{
$approved = filter($row3['visitor_approval']);
}
?>
<script>
var approv = '<?php echo $approved; ?>';
$(document).ready(function(){
 if(approv == 'D' || approv == 'U')
 {
 $('#disapproval').show();
 }
});
</script>

<script>
$(document).ready(function(){
$('#reg_disapprove').hide();
$('#regdisapprove').click(function(){
		$('#reg_disapprove').show();
});
$('#regapprove').click(function(){
		$('#reg_disapprove').hide();
});
});
</script>
<script>
    function imageAppear(id) { 
    document.getElementById(id).style.visibility = "visible";
	document.getElementById(id).style.height = "200px";
	document.getElementById(id).style.width = "auto";
	}
    function imageDisappear(id) { 
    document.getElementById(id).style.visibility = "hidden";}
</script>
<?php
$sqlreg1 = "SELECT * FROM registration_master where id='$registration_id'";
$res = $conn ->query($sqlreg1);
if($vals = $res->fetch_assoc())
{
$reg_approved = $vals['approval_status'];
}
?>
<script>
var reg_approv = '<?php echo $reg_approved; ?>';
$(document).ready(function(){
 if(reg_approv == 'D')
 {
 $('#reg_disapprove').show();
 }
});
</script>
<script>
	// ==============================XXXXXXXXXXXXXXXXXXXXXXXXXXXX CROPPING & PREVIEW START XXXXXXXXXXXXXXXXXXXXXXXXXXXXX===============================//
	   var $modal = $('#myModal');
        $(document).ready(function(){
        var $modal = $('#myModal');
        var image = document.getElementById('crop_image');
        var cropper;
        var input = document.getElementById('photo');
         $(".blah_photo").click(function(){

          	let imgsrc = $(this).attr("src");
          	
          	$("#crop").val("photo");
          
            convertImgToBase64(imgsrc, function(base64Img){
	          	image.src = base64Img;
	           	displayImage(base64Img,"photo");
	           	addToInput(base64Img,"photo");
	            $modal.modal('show');

         	});
          });
        $(".preview_crop").change(function(event){
            let ref = $(this).data('ref');
            let isCrop = $(this).data("crop");
           
            $("#crop").val(ref);
            var files = event.target.files;
            if(files && files.length > 0)
            {
                reader = new FileReader();
                reader.onload = function(event)
                {
                    image.src = reader.result;
                    
                    displayImage(reader.result,ref);
                    addToInput(reader.result,ref);
                    if(isCrop =="1"){
                        $modal.modal('show');
                    }else{
                        $modal.modal('hide');
                    }
                    
                   
                
                };
                reader.readAsDataURL(files[0]);
            }
        });

        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: "NAN",
                viewMode: 3,
                preview:'.preview'
            });

        }).on('hidden.bs.modal', function(){
            cropper.destroy();
            cropper = null;
        });
         
        
        $(document).on("click","#crop",function(event){
            let ref = $(this).val();
        
            canvas = cropper.getCroppedCanvas({
                width:400,
                height:400
            });
            canvas.toBlob(function(blob){
                url = URL.createObjectURL(blob);
                readImage(blob, function(dataUrl) {
                  displayImage(dataUrl,ref);
                  addToInput(dataUrl,ref);
                   $modal.modal('hide');
                });

            });
        });

        $("#rotate").on("click",function(e){
		     	e.preventDefault();
		      cropper.rotate(90);
        });

        
        function dataURLtoFile(dataurl, filename) {
     
            var arr = dataurl.split(','),
                mime = arr[0].match(/:(.*?);/)[1],
                bstr = atob(arr[1]), 
                n = bstr.length, 
                u8arr = new Uint8Array(n);
                
            while(n--){
                u8arr[n] = bstr.charCodeAt(n);
            }
            
            return new File([u8arr], filename, {type:mime});
        }

        function readImage(file, callback) {
          var reader = new FileReader();
          reader.onload = function() {
            callback(reader.result);
          }
          reader.readAsDataURL(file);
        }

        function displayImage(dataUrl,ref) {
           $('#blah_'+ref).attr('src', dataUrl);
        }

        function addToInput(dataUrl,ref) {
          var file = dataURLtoFile(dataUrl,ref+'.jpg');
          let container = new DataTransfer(); 
          container.items.add(file);
          document.querySelector('#'+ref).files = container.files;
        }
			function convertImgToBase64(url, callback, outputFormat){
				var canvas = document.createElement('CANVAS');
				var ctx = canvas.getContext('2d');
				var img = new Image;
				img.crossOrigin = 'Anonymous';
				img.onload = function(){
					canvas.height = img.height;
					canvas.width = img.width;
				  	ctx.drawImage(img,0,0);
				  	var dataURL = canvas.toDataURL(outputFormat || 'image/png');
				  	callback.call(this, dataURL);
			        // Clean up
				  	canvas = null; 
				};
				img.src = url;
			}
        });
        
		
   
		 

       // ==============================XXXXXXXXXXXXXXXXXXXXXXXXXXXX CROPPING & PREVIEW END XXXXXXXXXXXXXXXXXXXXXXXXXXXXX===============================//
</script>
<style type="text/css">
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
<?php if($_REQUEST['action']=='view') { ?>
#search{display:block;}
#page_ids{display:block;}
<?php  } else { ?>
#search{display:none;}
#page_ids{display:none;}
<?php } ?>

.img_e{
    width: 100px;
    height: 100px;
}
-->
.fancybox-button--zoom,.fancybox-button--play,.fancybox-button--thumbs,.fancybox-button--arrow_left,.fancybox-button--arrow_right,.fancybox-infobar{display:none!important;}
</style>
<style type="text/css">

.inner {/*  border: 1px solid #ccc;
*/
    border: 1px solid #ccc;
    border-collapse: separate;
    margin: 0;
    padding: 0;
    background: white;
    width: 50%;
    table-layout: fixed;
}
.inner tr {
background: #f8f8f8;
border: 1px solid #ddd;
padding: .35em;
}
.inner th,
.inner td {padding: .625em;text-align: left;padding: 10px 20px;}
.inner th {font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;}

</style>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a>
    <?php if($_REQUEST['actions']=='companyedit'){ ?> Company details
    <?php } else { ?> Employee Directory <?php } ?></div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head">
		<?php if($_REQUEST['actions']!='companyedit'){ ?>
		<?php echo strtoupper(getNameCompany($_REQUEST['regid'],$conn)); echo "&nbsp;"; echo getFirmType(getCompanyType($_REQUEST['regid'],$conn),$conn);?>&nbsp; | <?php echo getCompanyPan($_REQUEST['regid'],$conn);?> |
		<?php } ?>
        <?php if($_REQUEST['action']=='orderDetails') { ?>
        Order Details <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_employee_directory_test.php?action=view">Back</a></div>
		<?php } elseif($_REQUEST['action']=='orderHistory') { ?><div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;">
        <a href="iijs_employee_directory_test.php?action=orderDetails&regid=<?php echo $registration_id; ?>">Back</a></div>
        Payment Details
        <?php } elseif($_REQUEST['action']=='viewReg'){ ?>Employee Directory 
        <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_employee_directory_test.php?action=view">Employee Directory</a></div>
        <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_employee_directory_test.php?action=view">Back</a></div> 
        <?php } elseif($_REQUEST['action']=='edit'){ ?>
        Employee Directory  <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;">
        <a href="iijs_employee_directory_test.php?action=viewReg&regid=<?php echo $registration_id; ?>">Back</a></div>
        <?php } elseif($_REQUEST['actions']=='companyedit'){ ?>
        Company Details  <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;">
        <a href="iijs_employee_directory_test.php?action=view">Back</a></div> 
        <?php } else { ?>	Employee Directory
        <div style="float:right; padding-right:10px; font-size:12px;">
        <a href="visitor_FR_report.php">&nbsp;Download FR Data</a>
		</div>
		<div style="float:right; padding-right:10px; font-size:12px;">
        <a href="iijs_export_approve_emp_dir.php">&nbsp;Download Approved Data</a>
		</div>
		
		<div style="float:right; padding-right:10px; font-size:10px;">
        <a href="visitor_approve_emp_date.php">&nbsp;Download Approved Data 1May</a>
		</div>
        <div style="float:right; padding-right:10px; font-size:12px;">
        <a href="iijs_export_disapprove_emp_dir.php">&nbsp;Download DisApproved Data</a></div>
        <div style="float:right; padding-right:10px; font-size:12px;">
        <a href="iijs_export_pending_emp_dir.php">&nbsp;Download Pending Data</a></div>
        <div style="float:right; padding-right:10px; font-size:12px;">
        <a href="iijs_export_emp_directory.php">&nbsp;Download All Data</a>
        </div>
		
        <!--<div style="float:right; padding-right:10px; font-size:12px;">
        <a href="iijs_export_visitor_order_history.php">&nbsp;Download Order History</a>
        </div>-->
        <div style="float:right; padding-right:10px; font-size:12px;">
        <a href="iijs_export_visitordelivery.php">&nbsp;Download OrderID with Delivery</a>
        </div>
		
        <div style="float:right; padding-right:10px; font-size:12px;">
        <a href="export_domestic_pending_vaccination_report.php">&nbsp;Download Pending VC Report</a>
        </div>
		<!--<div style="float:right; padding-right:10px; font-size:12px;">
        <a href="iijs_export_visitor-refund.php">&nbsp;Download Refund</a>
        </div>-->
		<!--<div style="float:right; padding-right:10px; font-size:12px;">
        <a href="domestic_hotel_quota_report.php">&nbsp;Download Hotel Report</a>
        </div>-->
        </div>
	   <div class="clear">
        <?php } ?>		
		<?php
		if($_SESSION['curruser_login_id']=='44' || $_SESSION['curruser_login_id']=='1'){ ?>
		<a href="iijs_employee_directory_test.php?action=old_to_part" onClick="return(window.confirm('Are you sure you want to Clear Old to Part Data'));" >Clear Old to Part Data</a>	
		<?php }	?>
		</div>
        
<?php if($_REQUEST['action']=='view') { ?>
<div class="content_details1">
<?php 
	$sql5 = "select visitor_approval from visitor_directory where isApplied='Y' AND registration_id!='0' AND visitor_approval!='O'";
	$result5 = $conn ->query($sql5);
	$total_application= $result5->num_rows;
	
	$total_approve=0;
	$total_pending=0;
	$total_disapprove=0;
	$total_updated =0;
	while($rows5 = $result5->fetch_assoc())
	{
		if($rows5['visitor_approval']=='Y')
		{
			$total_approve=$total_approve+1;
		}else if($rows5['visitor_approval']=='P')
		{
			$total_pending=$total_pending+1;
		}else if($rows5['visitor_approval']=='D')
		{
			$total_disapprove=$total_disapprove+1;
		}else if($rows5['visitor_approval']=='U')
		{
			$total_updated=$total_updated+1;
		}
	}

?>
   	      <table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
   	        <tr class="orange1">
   	          <td colspan="11">Report Summary</td>
            </tr>
   	        <tr>
   	          <td><strong>Total Application</strong></td>
   	          <td><strong>Approve Application</strong></td>
   	          <td><strong>Disapprove Application</strong></td>
   	          <td><strong>Pending Application</strong></td>
   	          <td><strong>Updated Application</strong></td>
               </tr>
   	        <tr>
   	          <td><?php echo $total_application;?></td>
   	          <td><?php echo $total_approve;?></td>
   	          <td><?php echo $total_disapprove;?></td>
   	          <td><?php echo $total_pending;?></td>
   	          <td><?php echo $total_updated;?></td>
            </tr>
        </table>
      </div>
<?php } ?>

<div class="content_details1" id="search">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Search Options</td>
</tr>
<tr>
    <td width="19%"><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" autocomplete="off"/></td>
</tr>     
<tr>
  <td><strong>PAN Number</strong></td>
  <td><input type="text" name="pan_no" id="pan_no" maxlength="10" class="input_txt" value="<?php echo $_SESSION['pan_no'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>Mobile Number</strong></td>
  <td><input type="text" name="mobile" id="mobile" class="input_txt" value="<?php echo $_SESSION['mobile'];?>" autocomplete="off"/></td>
</tr>
<tr>
<td><strong>Visitor Status</strong></td>        
    <td>
        <select name="visitor_approval" class="input_txt-select">
        <option value="">Select Status</option>
        <option value="P" <?php if($_SESSION['visitor_approval']=='P'){echo "selected='selected'";}?>>Pending</option>
        <option value="Y" <?php if($_SESSION['visitor_approval']=='Y'){echo "selected='selected'";}?>>Approved</option>
        <option value="D" <?php if($_SESSION['visitor_approval']=='D'){echo "selected='selected'";}?>>Disapproved</option>
        <option value="U" <?php if($_SESSION['visitor_approval']=='U'){echo "selected='selected'";}?>>Updated</option>
        </select>
    </td>
</tr>

<tr>
<td><strong>Visitor Face Status</strong></td>        
   <td>
        <select name="face_status" class="input_txt-select">
        <option value="">Select Status</option>
        <option value="Y" <?php if($_SESSION['face_status']=='Y'){echo "selected='selected'";}?>>Approved</option>
        <option value="D" <?php if($_SESSION['face_status']=='D'){echo "selected='selected'";}?>>Disapproved</option>
        <option value="P" <?php if($_SESSION['face_status']=='P'){echo "selected='selected'";}?>>Pending</option>
        <option value="U" <?php if($_SESSION['face_status']=='U'){echo "selected='selected'";}?>>Updated</option>
        

        
        </select>
   </td>
</tr>
    <td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Search" class="input_submit"/> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<!------------------------------- ORDER DIRECTORY ---------------------------------->

<?php if($_REQUEST['action']=='view') { ?>  
<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Company Name</td>
	<td>BP Number</td>
    <td>Pan Number</td>
    <td>GST Number</td>
    <td>Email</td>
    <td>Company</td>
	<td>Co Status</td>
    <td>View Details</td>
    <td colspan="2">Create BP</td>
    <td>Directory Status</td>
    <td>FR Status</td>
  </tr>
	<?php  
	$page=1;//Default page
	$limit=25;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
  
  $sql="SELECT DISTINCT rm.id, rm.company_name, rm.company_pan_no, rm.mobile_no, rm.company_gstn, rm.email_id,rm.approval_status,rm.pan_no_copy,rm.gst_copy FROM registration_master rm inner join visitor_directory vd on rm.id=vd.registration_id AND vd.isApplied='Y' AND vd.visitor_approval!='O'";
  
 /*  $sql="SELECT 
DISTINCT rm.id, rm.company_name, rm.company_pan_no, rm.mobile_no, rm.company_gstn, rm.email_id,rm.approval_status FROM registration_master rm
inner join visitor_directory vd on rm.id=vd.registration_id 
inner join visitor_order_detail vo on vo.regId=vd.registration_id
AND vd.isApplied='Y' AND vd.visitor_approval!='O' AND vo.payment_type='online'"; */
 	
	if($_SESSION['company_name']!="")
	{
	$sql.=" and rm.company_name like '%".$_SESSION['company_name']."%'";
	}
	if($_SESSION['pan_no']!="")
	{
	$sql.=" and rm.company_pan_no like '%".$_SESSION['pan_no']."%'";
	}
	if($_SESSION['mobile']!="")
	{
	$sql.=" and rm.mobile_no like '%".$_SESSION['mobile']."%'";
	}

	if($_SESSION['visitor_approval']!="")
    { 
		$sql.=" GROUP BY  vd.registration_id, vd.visitor_approval HAVING vd.visitor_approval = '".$_SESSION['visitor_approval']."'";
    }

    if($_SESSION['face_status']!="")
    { 
		$sql.=" GROUP BY  vd.registration_id, vd.face_status HAVING vd.face_status = '".$_SESSION['face_status']."'";
    }

  //   if($_SESSION['face_isApplied']!="")
  //   { 
		// $sql.=" GROUP BY  vd.registration_id, vd.face_isApplied HAVING vd.face_isApplied = '".$_SESSION['face_isApplied']."'";
  //   }
	//echo $sql;
	$result = $conn ->query($sql);

	$rCount = $result->num_rows;
	$sql1= $sql."  limit $start, $limit";
	$result1= $conn ->query($sql1);
		
  if($rCount>0)
  {	
  while($rows = $result1->fetch_assoc())
  {
  ?>
  <?php 
  $checkMember = CheckMembership($rows['id'],$conn);
  if($checkMember=="M")
  {
	 $memberBP = getBPNO($rows['id'],$conn);
  } else {
		$memberBP = getBPNO($rows['id'],$conn);
	 if($memberBP !=''){
		$memberBP = getBPNO($rows['id'],$conn);
	 } else {
	 $memberBP = getCompanyNonMemBPNO($rows['id'],$conn);
	 }
  }
  ?>
  <tr>
    <td><?php echo strtoupper($rows['company_name']);?></td>
	<td><?php echo $memberBP;?></td>
	<td><?php echo filter($rows['company_pan_no']);?></td>
    <td><?php echo filter($rows['company_gstn']);?></td>   
    <td><?php echo filter($rows['email_id']);?></td>
    <td align="center" valign="middle"><a href="iijs_employee_directory_test.php?actions=companyedit&regid=<?php echo $rows['id'];?>">
    <img class="icons" src="images/view.png" title="Company Details" border="0" /></a></td>
	<td>
	<?php
	if($rows['approval_status']=="") 
        		echo "<img src='images/notification-exclamation.gif' border='0' />";	
			elseif($rows['approval_status']=="Y")
				echo "<img src='images/yes.gif' border='0' />";	
			elseif($rows['approval_status']=="D")
				echo "<img src='images/no.gif' border='0' />";
			elseif($rows['approval_status']=="U")
				echo "Updated";
	?>
	</td>
    <td align="left" valign="middle">  
    <a href="iijs_employee_directory_test.php?action=viewReg&regid=<?php echo $rows['id'];?>">Employee Details</a> / <a href="iijs_employee_directory_test.php?action=orderDetails&regid=<?php echo $rows['id'];?>">Order Details</a>
    </td>

    <!--..................... Create Company BP Start ------------>
	<?php //echo $rows['visitor_approval'];
	if($checkMember=="NM") {
	if($memberBP=="" || $memberBP==0) { ?>
	<td class="comp" data-url="<?php echo $rows['id'];?>"><img src="images/reply.png" title="PUSH" border="0" style=""/></td>
	<?php } else { ?>
	<td><a onclick="return(window.confirm('BP Already Created'));"><img src="images/active.png"/></a></td>
	<?php } } else { ?>
	<td><a onclick="return(window.confirm('BP Already Created'));"><img src="images/active.png"/></a></td>
	<?php } ?>
    <td class="Vdelta" data-url="<?php echo $rows['id'];?>"><img src="images/reply.png" title="PUSH" border="0" style=""/></td>
    <!--..................... Create Company BP Stop ------------>
    <td align="left" valign="middle"><?php echo checkApproval_status($rows['id'],$conn);?></td>
    <td align="left" valign="middle">
    	<?php if($_SESSION['face_status'] !==""){
    				if($_SESSION['face_status'] =="U"){ 
    					echo "Updated";
    				}else if($_SESSION['face_status'] =="P"){
    					echo "Pending";
    				}else if($_SESSION['face_status'] =="Y"){
    					echo "Approved";
    				} else if($_SESSION['face_status'] =="D"){
    					echo "Disapproved";
    				}
 				}else{
    					echo  checkFaceApproval_status($rows['id'],$conn);
				} ?>
 						
 	 </td>
  </tr>
  <?php
   $i++;
   } 
}
   else
   {
   ?>
  <tr>
    <td colspan="8">Records Not Found</td>
  </tr>
  <?php  }  	?>
</table>
</form>
</div>
<?php } ?>  
<?php
function pagination($per_page = 10, $page = 1, $url = '', $total){ 

$adjacents = "2";

$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$lastpage = ceil($total/$per_page);
$lpm1 = $lastpage - 1;

$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<ul class='pagination'>";
$pagination .= "<li class='details'>Page $page of $lastpage</li>";
if ($lastpage < 7 + ($adjacents * 2))
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2))
{
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>...</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>..</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
else
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>..</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
}

if ($page < $counter - 1){
$pagination.= "<li><a href='{$url}$next'>Next</a></li>";
// $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
}else{
//$pagination.= "<li><a class='current'>Next</a></li>";
// $pagination.= "<li><a class='current'>Last</a></li>";
}
$pagination.= "</ul>\n"; 
} 
return $pagination;
}
?>	
<div class="pages_1" id="page_ids">Total Number Company : <?php echo $rCount;?>
<?php echo pagination($limit,$page,'iijs_employee_directory_test.php?action=view&page=',$rCount); //call function to show pagination?>
</div>  

<!------------------------------- VIEW REGISTRATION ---------------------------------->
      
<?php if($_REQUEST['action']=='viewReg') { ?>  
<div class="content_details1">
<form name="form1" action="" method="POST" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td width="8%">Date</td>
    <td>Name</td>
	<td>BP Number</td>
    <td>Designation Type</td>
    <td>Designation</td>
    <td>Mobile Number</td>
    <td>Pan No.</td>
    <td>Aadhar Number</td>
	<td colspan="2">Create BP</td>
    <td>Status</td>
    <td>Face Status</td>
    <td>View Details</td>
	<?php if($adminID==1 || $adminID==44 || $adminID==131 || $adminID==123 || $adminID==91 || $adminID==109 || $adminID==97 || $adminID==32 || $adminID==110 || $adminID==34 || $adminID==31 || $adminID==195 || $adminID==55 || $adminID==28 || $adminID==197){?><td>Delete</td><?php } ?>
  </tr>
    <?php  
	$page=1;//Default page
	$limit=400;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
  
    //$sql="SELECT * FROM visitor_directory where registration_id = '$registration_id' AND isApplied='Y' AND visitor_approval!='O' order by degn_type, name asc"; 	 
    $sql="SELECT * FROM visitor_directory where registration_id = '$registration_id'  AND visitor_approval!='O' order by degn_type, name asc"; 	 
	$result = $conn ->query($sql);
	$rCount =  $result->num_rows;
	$sql1= $sql."  limit $start, $limit";
	$result1=$conn ->query($sql1);
	
  if($rCount>0)
  {	
  while($rows = $result1->fetch_assoc())
  { 
	$visitor_approval = $rows['visitor_approval'];
	$visitor_face_approval = $rows['face_status'];
	if($visitor_approval == "Y"){ $visitor_approval= "<span style='color:green'>Approved</span>"; $v_date = date("d-m-Y",strtotime($rows['post_date'])); } 
	if($visitor_approval == "P"){ $visitor_approval= "<span style='color:blue'>Pending</span>";   $v_date = date("d-m-Y",strtotime($rows['post_date']));}
	if($visitor_approval == "D"){ $visitor_approval= "<span style='color:red'>Disapproved</span>"; $v_date = date("d-m-Y",strtotime($rows['mod_date']));}
	if($visitor_approval == "U"){ $visitor_approval= "<span style='color:green'>Updated</span>";  $v_date = date("d-m-Y",strtotime($rows['mod_date']));}

	if($visitor_face_approval == "Y"){ $visitor_face_approval= "<span style='color:green'>Approved</span>";  } 
	if($visitor_face_approval == "P"){ $visitor_face_approval= "<span style='color:blue'>Pending</span>";   }
	if($visitor_face_approval == "D"){ $visitor_face_approval= "<span style='color:red'>Disapproved</span>"; }
	if($visitor_face_approval == "U"){ $visitor_face_approval= "<span style='color:green'>Updated</span>";  }

  ?>
  <tr>
    <td><?php echo $v_date;?></td>
    <td><?php echo strtoupper(filter($rows['name']).' '.filter($rows['lname']));?></td>
	<td><?php echo strtoupper(filter($rows['bp_number']));?></td>
    <td><?php echo $rows['degn_type'];?></td> 
    <td><?php echo getVisitorDesignation($rows['designation'],$conn);?></td> 
    <td><?php echo filter($rows['mobile']);?></td> 
    <td><?php echo filter($rows['pan_no']);?></td>  
    <td><?php echo filter($rows['aadhar_no']);?></td> 
    <!--..................... Create Person BP Start ------------>
	<?php
	if($rows['visitor_approval'] == "Y"){
	/*	echo checkMobPan($rows['mobile']); For checking same mobile no have how many BP Created*/
	if($rows['bp_number']=="" || $rows['bp_number']==0) { ?>
	<td class="sap" data-url="<?php echo $rows['visitor_id'];?> <?php echo $rows['registration_id'];?>"><img src="images/reply.png" title="CREATE BP" border="0" style=""/></td>
	<?php } else { ?>
	<td><a onclick="return(window.confirm('BP Already Created'));"><img src="images/active.png"/></a></td>
	<?php } } else { ?>
	<td></td>
	<?php } ?>	
    <td class="delta" data-url="<?php echo $registration_id." ".$rows['visitor_id'];?>"><img src="images/reply.png" title="PUSH DELTA BP" border="0" style=""/></td>
    <!--.....................Create BP API STOP ------------>
    <td><?php echo $visitor_approval;?></td>   
     <td><?php echo $visitor_face_approval;?></td>   
    <td align="left" valign="middle"><a href="iijs_employee_directory_test.php?action=edit&id=<?php echo $rows['visitor_id'];?>&regid=<?php echo $rows['registration_id'];?>">
    <img src="images/edit.gif" title="Edit" border="0"/></a></td>
	
	<?php if($adminID==1 || $adminID==44 || $adminID==131 || $adminID==123 || $adminID==91 || $adminID==109 || $adminID==97 || $adminID==32 || $adminID==110 || $adminID==34 || $adminID==31 || $adminID==195 || $adminID==55 || $adminID==28 || $adminID==197){ ?>
	<td><a style="text-decoration:none;" href="iijs_employee_directory_test.php?action=delVisitor&visitor_id=<?php echo $rows['visitor_id'];?>&registration_id=<?php echo $registration_id;?>" onClick="return(window.confirm('Are you sure you want to Delete.'));"><img src="images/no.gif" border="0" title="Delete"/></a></td>
	<?php } ?>
  </tr>
  <?php
   $i++;
   }  
   }
   else
   {
   ?>
  <tr>
    <td colspan="8">Records Not Found</td>
  </tr>
  <?php  }  ?>
</table>
</form>
</div>
<?php } ?>  

<!------------------------------- ORDER DETAILS ---------------------------------->

<?php if($_REQUEST['action']=='orderDetails') { ?>  
<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Company Name</td>
    <td>Date</td>
    <td>Payment Type</td>
    <td>Transaction Msg</td>
    <td>Amount</td>
    <td>Order Id</td>
	<td>View Order</td>
    <td>Sales Order</td>
	<td>Create SO</td>
  </tr>
  <?php
  
	$page=1;//Default page
	$limit=500;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
  
    $sql="SELECT * FROM visitor_order_detail where regId = '$registration_id' and payment_status = 'Y'"; 	 
	$result=$conn ->query($sql);

	$rCount= $result->num_rows;
	$sql1= $sql."  limit $start, $limit";
	$result1=$conn ->query($sql1);	
	
  if($rCount>0)
  {	
  while($rows = $result1->fetch_assoc())
  {
  ?>
  <?php 
  $checkMember = CheckMembership($rows['regId'],$conn);
  if($checkMember=="M")
  {
	 $memberBP = getBPNO($rows['regId'],$conn);
  } else {
	$memberBP = getBPNO($rows['regId'],$conn);
	 if($memberBP !=''){
	$memberBP = getBPNO($rows['regId'],$conn);
	} else {
	$memberBP = getCompanyNonMemBPNO($rows['regId'],$conn);
	}
  }
  ?>
  <tr >
    <td><?php echo getNameCompany($rows['regId'],$conn);?></td>
    <td><?php echo date("d-m-Y",strtotime($rows['tpsl_txn_time']));?></td>
    <td><?php echo $rows['payment_type'];?></td> 
    <td><?php echo $rows['txn_msg'];?></td> 
    <td><?php echo $rows['total_payable'];?></td> 
    <td><?php echo filter($rows['orderId']);?></td> 
	<td align="left" valign="middle"><a href="iijs_employee_directory_test.php?action=orderHistory&orderId=<?php echo $rows['orderId'];?>&regid=<?php echo $rows['regId'];?>" style="color:#000000">VIEW</a></td>
	<td><?php echo $rows['sales_order_no'];?></td>
	<!--.....................Sales Order Create API------------>
    <?php if($rows['sap_sale_order_create_status'] == 0) { ?>
	<?php if($memberBP!=''){
	if($rows['total_payable']>0 && $rows['txn_status']=='0300'){ ?>
	<td class="so" data-url="<?php echo $memberBP;?> <?php echo $rows['regId'];?> <?php echo $rows['orderId'];?> <?php echo csrf_sap_token();?>">CREATE SO</td>
	<?php } else { ?><td>Free</td> <?php } 
	} else { echo '<td>BP Missing</td>'; }?>
    <?php } else { ?>
    <td><a onclick="return(window.confirm('Sales Order Already Created'));"><img src="images/active.png"/></a></td>
    <?php } ?>
	<!--..................... End Sales Order Create API------------>
  </tr>
  <?php
   $i++;
   }  
}
   else
   {
   ?>
  <tr>
    <td colspan="8">Records Not Found</td>
  </tr>
  <?php  }  	?>
</table>
</form>
</div>
<?php } ?> 

<!----------------------------- ORDER HISTORY ---------------------------------->

<?php if($_REQUEST['action']=='orderHistory') {?>  
<div class="content_details1">
<form name="form1" action="" method="POST"/> 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Visitor Name</td>
    <td>Payment Made For</td>
    <td>Amount</td>
    <td>Shows</td>
    <td>Year</td>
    <td>Payment Status</td>
	<?php if($adminID==1){?><td>Global</td><?php } ?>
	<td>Vaccine Upload</td>

  </tr>
    <?php  
	$page=1;//Default page
	$limit=200;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
  
    $sql="SELECT * FROM visitor_order_history where orderId = '$orderId' and registration_id = '$registration_id'"; 	 
	$result= $conn ->query($sql);
	$rCount=$result->num_rows;
	$sql1= $sql."  limit $start, $limit";
	$result1= $conn ->query($sql1);
		
  if($rCount>0)
  {	
  while($rows = $result1->fetch_assoc())
  {
  $payment_status = $rows['payment_status'];
  if($payment_status == 'Y'){
	$Pstatus = "Success";} 
	else if($payment_status == 'R'){
	$Pstatus = "Refund";}	else { 
	$Pstatus = "Fail";}	
  ?>
  <tr>
    <td><?php echo VisitorFLName($rows['visitor_id'],$conn);?></td> 
    <td><?php echo filter($rows['payment_made_for']);?></td> 
    <td><?php echo $rows['amount'];?></td>   
    <td><?php echo filter($rows['show']);?></td>
    <td><?php echo filter($rows['year']);?></td> 
    <td><?php echo $Pstatus;?></td>
	<!--..................... Send to Global Table ------------>
	<?php if($adminID==1){ if($rows['show'] == "iijs22" || $rows['show'] == "signature23" || $rows['show'] == "iijstritiya23" || $rows['show'] == "combo23"){ ?>
	<td><a style="text-decoration:none;" href="iijs_employee_directory_test.php?action=global&visitor_id=<?php echo $rows['visitor_id'];?>&registration_id=<?php echo $registration_id;?>&show=<?php echo $rows['show'];?>" onClick="return(window.confirm('Are you sure you want to Send.'));"><img src="images/active.png" border="0" title="send"/></a></td>
	  
	<?php } } ?>
	<?php  if($rows['show'] == "iijs22"){ ?>
	<td><a style="text-decoration:none; padding: 5px auto;height: auto;" class="content_head_button" href="iijs_employee_directory_test.php?action=uploadVaccineCertificate&visitor_id=<?php echo $rows['visitor_id'];?>&registration_id=<?php echo $registration_id;?>" > Upload  </a></td>
	<?php }else{?>
			<td></td>
	<?php }  ?>

	<!--..................... Send to Global Table ------------>
  </tr>
  <?php
   $i++;
   }  
}
   else
   {
   ?>
  <tr>
    <td colspan="8">Records Not Found</td>
  </tr>
  <?php  }  	?>
</table>
</form>
</div>
<?php } ?> 
<!--------------------------- VIEW HOTEL BOOKING FOR KEY PERSONS----------------------------------- -->

<!------------------------- UPLOAD VACCINE CERTIFICATE FOR EMPLOYEE ----------------------------------------->

<?php if($_REQUEST['action']=='uploadVaccineCertificate') {?>  

	<?php 
	$visitor_id = $_REQUEST["visitor_id"];
	$registration_id = $_REQUEST["registration_id"];
    $labInfo ="SELECT * FROM `visitor_lab_info` WHERE `visitor_id`='$visitor_id' AND registration_id='$registration_id'";
    $resultLabInfo = $conn->query($labInfo);
    $countLabInfo = $resultLabInfo->num_rows;
    if($countLabInfo >0){
    	$rowLabInfo =  $resultLabInfo->fetch_assoc();
    	$certificate =$rowLabInfo['certificate'];
    	$dose1 =$rowLabInfo['dose1'];
    	$dose2 =$rowLabInfo['dose2'];
    	$approval_status = $rowLabInfo['approval_status'];
    }else{
    	$certificate = "";
    	$dose1 = "";
    	$dose2 = "";
    	$approval_status  = "";
    }
	?>
<div class="content_details1">
<form name="details" action="" method="post" enctype="multipart/form-data" >        	
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1">
     <td colspan="11">Employee Directory</td>
  </tr>
  <tr>
    <td ><strong>Select Dose</strong></td>
    <td>
    	<label><input type="radio" <?php if($certificate =="dose1"){echo "checked";}?> name="valueType" id="dose1" value="dose1"> Dose 1</label>
        <label><input type="radio" <?php if($certificate =="dose2"){echo "checked";}?> name="valueType" id="dose2" value="dose2"> Dose 2</label>
    </td>
  </tr>
  
  <tr >
    <td ><strong>Vaccine Certificate</strong></td>
    <td><input type="file" name="vaccine_certificate" id="vaccine_certificate" class="input_txt"  /></td>
  </tr>

  <tr>
    <td ><strong>Uploaded Vaccine Certificates </strong></td>
    <td>
    	<?php if($dose1 !=""){?>
			<a target="_blank" href="https://registration.gjepc.org/images/covid/vis/<?php echo $registration_id;?>/vaccine_certificate/<?php echo $dose1;?>">Dose 1 Certificate</a>
    	<?php }?>
  
    	&nbsp;&nbsp;&nbsp;
    	<?php if($dose2 !=""){?>
    	<a target="_blank" href="https://registration.gjepc.org/images/covid/vis/<?php echo $registration_id;?>/vaccine_certificate/<?php echo $dose2;?>">Dose 2 Certificate</a>
    	<?php }?>
    </td>
  </tr>
  
  <?php if($approval_status =="Y"){?>
  	<tr >
    <td colspan="2">Vacccine is approved already</td>
   
  </tr>
  <?php }else{?>
<tr >
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="vaccineUploadAction" />
    <input type="hidden" name="visitor_id" id="visitor_id"  value="<?php echo $_REQUEST['visitor_id'];?>" />
    <input type="hidden" name="registration_id" id="registration_id"  value="<?php echo $_REQUEST['registration_id'];?>" />
    </td>
  </tr>
  <?php } ?>
  
</table>
</form> 
</div>
<?php }?>

<!------------------------ UPDATE FOR EMPLOYEE DIRECTORY --------------------------------------------------->
  
<?php    
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = $conn ->query("SELECT * FROM visitor_directory where visitor_id='$id'");
		if($row2 = $result2->fetch_assoc())
		{			
			$post_date=stripslashes($row2['post_date']);
			$degn_type=filter($row2['degn_type']);
			$gender	=	filter($row2['gender']);
			$name	=	strtoupper(filter($row2['name']));
			$lname	=	strtoupper(filter($row2['lname']));
			$mobile	=	filter($row2['mobile']);
			$secondary_mobile	=	filter($row2['secondary_mobile']);
			$email	=	filter($row2['email']);
			$aadhar_no = filter($row2['aadhar_no']);
			$designation = filter($row2['designation']);
			$pan_no	=	strtoupper(filter($row2['pan_no']));
			$photo	=	stripslashes($row2['photo']);
			$salary_slip_copy=stripslashes($row2['salary_slip_copy']);
			$pan_copy=stripslashes($row2['pan_copy']);
			$partner=stripslashes($row2['partner']);
			$approval=filter($row2['visitor_approval']);
			$disapprove_reason=filter($row2['disapprove_reason']);
			$companyId=filter($row2['registration_id']);
			$category=filter($row2['category']);
			$face_isApplied = filter($row2['face_isApplied']);
			$face_status = filter($row2['face_status']);
			$face_photo = filter($row2['face_photo']);
			$old_photo = filter($row2['old_photo']);

			if($gender == "M"){
			$gen = "Male"; }
			elseif($gender == "F"){
			$gen = "Female"; }
			else{
			$gen = "Trans-Gender"; }
		}
	}
?>   
<div class="content_details1">
<form name="details" action="" method="post" enctype="multipart/form-data" >        	
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1">
     <td colspan="11">Employee Directory</td>
  </tr>
  <tr>
    <td ><strong>Name</strong></td>
    <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" maxlength="14" /></td>
  </tr>
  <tr>
    <td ><strong>Last Name</strong></td>
    <td><input type="text" name="lname" id="lname" class="input_txt" value="<?php echo $lname; ?>" maxlength="14" /></td>
  </tr>
  <tr>
    <td ><strong>Gender</strong></td>
    <td><input type="text" name="gender" id="gender" class="input_txt" value="<?php echo $gen; ?>" readonly/></td>
  </tr>
  <tr >
    <td ><strong>Designation Type</strong></td>
    <td><input type="text" name="degn_type" id="degn_type" class="input_txt" value="<?php echo $degn_type; ?>" readonly/></td>
  </tr>
   <tr >
    <td ><strong>Designation</strong></td>
    <td><input type="text" name="designation" id="designation" class="input_txt" value="<?php echo getVisitorDesignation($row2['designation'],$conn); ?>" readonly/></td>
  </tr>
  <tr>
    <td ><strong>Primary Mobile Number</strong></td>
    <td><input type="text" name="mobile" id="mobile" class="input_txt" value="<?php echo $mobile; ?>" maxlength="10"/></td>
  </tr>
  <tr>
    <td ><strong>Secondary Mobile Number</strong></td>
    <td><input type="text" name="secondary_mobile" id="secondary_mobile" class="input_txt" value="<?php echo $secondary_mobile; ?>" maxlength="10"/></td>
  </tr>
  <tr >
    <td ><strong>Email Id</strong></td>
    <td><input type="text" name="email" id="email" class="input_txt" value="<?php echo $email; ?>" /></td>
  </tr>
  <tr >
    <td ><strong>Aadhar Number</strong></td>
    <td><input type="text" name="aadhar_no" id="aadhar_no" class="input_txt" value="<?php echo $aadhar_no; ?>" /></td>
  </tr>
  <tr >
    <td ><strong>PAN Number</strong></td>
    <td><input type="text" name="pan_no" id="pan_no" class="input_txt" value="<?php echo $pan_no; ?>" maxlength="10" /></td>
  </tr>
  <tr >
    <td ><strong>Photo</strong></td>
    <td>  
    	 <div id="myModal" class="modal fade"   tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
               
                    <div class="modal-dialog modal-lg " role="document">
                        <div class="modal-content ">
                             <div class="modal-content">
                                <div class="modal-header">
                              <button type="button" class="close d-inline" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center p-0  border-0">
                               <div class="img-container">
                                <div class="row">
                                    <div class="col-md-8">
                                        <img src="" id="crop_image" class="img-fluid h-100 w-100" />
                                    </div>
                                    <div class="col-md-4">
                                        <div class="preview"></div>
                                    </div>
                                    
                                </div>
                            </div>
                            </div>
                            <div class="modal-footer">
                            	<button type="button" id="rotate" class="btn btn-secondary">Rotate</button>
                            <button type="button" id="crop" class="btn btn-secondary" value=""  >Crop & continue </button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Continue without cropping</button>
                            </div>
                            </div>
                        </div>
                    </div>
               
            </div>
    <?php
    $photo_ext =  pathinfo($photo, PATHINFO_EXTENSION);
        
    if($photo_ext == "pdf" ||  $photo_ext == "PDF"){?>
    <a href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $photo; ?>" target="_blank">
	<img src="images/pdf_icon.png" title="<?php echo $name;?>"/></a>
	<?php } else { ?>
   <!--  <a data-fancybox="gallery" href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $photo; ?>"> 
    <img class="img_e" src="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $photo; ?>" title="<?php echo $name;?>" /></a> 	 -->

    <div class="row">
    	<div class="col-12 mb-2">
    		<input type="file" name="photo" id="photo" class=" preview_crop" autocomplete="off" data-ref='photo'    data-crop="1"  accept=".jpg,.jpeg,.png" data-toggle="tooltip" data-placement="top" title="Photo Passport size with white background" />
    	</div>
    </div>
   
    <div class="row">
    	<div class="col-6">
    		<p   style="margin-bottom: 5px;"><strong>Current Photo</strong> </p>
    		<div class="blah">
    			<a data-fancybox="gallery" href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $photo; ?>"> 
    <img class="img_e" id="blah_photo" src="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $photo; ?>" title="<?php echo $name;?>" /></a> 
    			<!-- <img class="img-fluid  " id="blah_photo" src="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $photo; ?>" alt="your image" style="display: block;"/> -->
    		</div>
    		
    	</div>
   
    </div>
   
    <?php } ?>

    <?php 

    ?>

    <table style="width: 100%; " border="0" cellspacing="2" cellpadding="2">
      	<thead>
      		<tr>
               <?php if($old_photo  !=="" ){?> 
	      			<th> Old Photo</th>
	      		<?php }else{?>
	      		<th> Photo</th>
	      		 <?php } ?>
	      		
					<?php if($face_isApplied =="Y"){?> 
	      			<th>Face recognition Photo</th>
	      		<?php } ?>
      		</tr>
      	</thead>
      	<tbody>
      		<tr>
      			 <?php if($old_photo  !=="" ){?> 
	      		<td>
	      
	      			 <div class="blah">
      
    	<img class="img-fluid blah_photo " src="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $old_photo; ?>" alt="your image" style="display: block;"/>

	  </div>
					
	      		</td>
	      	<?php }else{ ?> 
<td>
	      
	      			 <div class="blah">
      
    	<img class="img-fluid blah_photo " src="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $photo; ?>" alt="your image" style="display: block;"/>

	  </div>
					
	      		</td>
	      	<?php } ?>

	      		<?php if($face_isApplied =="Y"){?> 
	      		<td>  <div class="blah">
      
    	<img class="img-fluid blah_photo " src="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $face_photo; ?>" alt="your image" style="display: block;"/>

	  </div></td>
	      		<?php } ?>
      		</tr>
      	</tbody>
      	
      </table>

    

    </td>
  </tr>
 
  <tr>
    <td><strong>PAN Card Copy</strong></td>
    <td>
    <?php $pan_copy_ext =  pathinfo($pan_copy, PATHINFO_EXTENSION); ?>
    <?php if($pan_copy_ext == "pdf" || $pan_copy_ext == "PDF"){?>
    <a href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/pan_copy/<?php echo $pan_copy; ?>" target="_blank">
    <img src="images/pdf_icon.png"></a>
   <?php } else { ?>
	<a data-fancybox="gallery" href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/pan_copy/<?php echo $pan_copy; ?>">
    <img class="blah" src="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/pan_copy/<?php echo $pan_copy; ?>" title="<?php echo $pan_no; ?>"/>
    </a> 
	<?php } ?>
    </td>
  </tr>
  <?php if($degn_type == 'Employee') { ?>
  <tr>
    <td ><strong>Salary Slip / Bank Statment</strong></td>
    <td>
    <?php $salary_slip_copy_ext =  pathinfo($salary_slip_copy, PATHINFO_EXTENSION); ?>
   	<?php if($salary_slip_copy_ext =="pdf" || $salary_slip_copy =="PDF"){?>
    <a href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/salary/<?php echo $salary_slip_copy; ?>" target="_blank">
    <img src="images/pdf_icon.png" />
   	<?php } else { ?>
    <a data-fancybox="gallery" href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/salary/<?php echo $salary_slip_copy; ?>">
    <img class="blah" src="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/salary/<?php echo $salary_slip_copy; ?>" alt="your image"/></a> 
	<?php } ?>
    </td>
  </tr>
  <?php } else { ?>
  <tr>
    <td><strong>Partnership Deed</strong></td>
    <td>
    <?php $partner_ext =  pathinfo($partner, PATHINFO_EXTENSION); ?>
   	<?php if($partner_ext =="pdf" || $partner_ext=="PDF"){ ?>
	<a href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/partner/<?php echo $partner; ?>" target="_blank">
    <img src="images/pdf_icon.png"/>
    <?php } else { ?>
    <a data-fancybox="gallery" href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/partner/<?php echo $partner;?>">
    <img class="blah" src="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/partner/<?php echo $partner; ?>" alt="your image" /></a><?php } ?>
    </td>
  </tr>
  <?php } ?>
  <tr>
  <td><strong>Visitor Status</strong></td>        
    <td>
        <select name="category" class="input_txt">
		  <option value="">Select Category</option>
		  <option value="VIP" <?php if($category=='VIP'){echo "selected='selected'";}?>>VIP</option>
		  <option value="VVIP" <?php if($category=='VVIP'){echo "selected='selected'";}?>>VVIP</option>   
		  <option value="ELITE" <?php if($category=='ELITE'){echo "selected='selected'";}?>>ELITE</option>  
		</select>
    </td>
  </tr>
  <tr>
  	<?php $companyStatus= getcompanyStatus($companyId,$conn);?>
    <td><strong>Application Approval Status </strong></td>
    <td>
    <input type='radio' name='approval' id='approve' value='Y' <?php if($approval=='Y'){ echo "checked='checked'"; }?> <?php if($companyStatus==""|| $companyStatus=="D" ||  $companyStatus=="U" ){ echo "disabled"; } ?>/>Approve
	<input type='radio' name='approval' id='disapprove' value='D' <?php if($approval=='D'){ echo "checked='checked'"; }?>/>Disapprove
    </td>
  </tr>
  <tr id="disapproval">
    <td><strong>Disapprove Reason</strong></td>
    <td>
    <textarea name="disapprove_reason" id="disapprove_reason" cols="25"><?php echo $disapprove_reason;?></textarea>
    </td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />
    </td>
  </tr>
</table>
</form> 
</div>
<?php } ?>     

<!----------------------- Company Edits ---------------------------->
<?php 
  if($_REQUEST['actions']=='companyedit') {
  
  if(($_REQUEST['regid']!='') || ($_REQUEST['actions']=='companyedit'))
  {
  		$actions='compupdate';
		$result3 = $conn ->query("SELECT * FROM registration_master where id='$registration_id'");
		if($row3 = $result3->fetch_assoc())
		{			
			$company_names=filter($row3['company_name']);
			$company_pan_no=filter($row3['company_pan_no']);
			$company_type=filter($row3['company_type']);
			$company_gstn=filter($row3['company_gstn']);
			$company_document=filter($row3['company_document']);
			$mobile_no=filter($row3['mobile_no']);
			$emailid = filter($row3['email_id']);
			$gst_copy = filter($row3['gst_copy']);
			$pan_no_copy = filter($row3['pan_no_copy']);
			$approval_status=$row3['approval_status'];
			$disapprove = filter($row3['disapprove']);
			$comp_type  = filter($row3['company_type']);
			$city  = filter($row3['city']);
			$pin_code  = filter($row3['pin_code']);
			$state  = filter(getState($row3['state'],$conn));
		}
	}
?>
<div class="content_details1">
<form name="company" action="" method="POST" >        	
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1"><td colspan="11">Company Details</td></tr>
  <tr>
    <td><strong>Company Name</strong></td>
    <td><input type="text" name="comp_name" id="comp_name" class="input_txt" value="<?php echo $company_names; ?>" /></td>
  </tr>
  <tr>
    <td ><strong>Company Type</strong></td>
	<td><input type="radio" name="comp_type" id="comp_type" value="14" <?php if($comp_type=='propritory' || $comp_type==14){ echo "checked"; }?>>Proprietary
      <input type="radio" name="comp_type" id="comp_type" value="11" <?php if($comp_type=='partnership' || $comp_type==11){ echo "checked"; }?>>Partnership
      <input type="radio" name="comp_type" id="comp_type" value="13" <?php if($comp_type=='pvt' || $comp_type==13){ echo "checked"; }?>>Private Ltd.
      <input type="radio" name="comp_type" id="comp_type" value="12" <?php if($comp_type=='public' || $comp_type==12){ echo "checked"; }?>>Public Ltd.
      <input type="radio" name="comp_type" id="comp_type" value="19" <?php if($comp_type=='llp' || $comp_type==19){ echo "checked"; }?>>LLP
      <input type="radio" name="comp_type" id="comp_type" value="15" <?php if($comp_type=='huf' || $comp_type==15){ echo "checked"; }?>>HUF
      </td>
  </tr>
  <tr>
    <td><strong>Company PAN No</strong></td>
    <td><input type="text" name="company_pan_no" id="company_pan_no" class="input_txt" value="<?php echo $company_pan_no; ?>" maxlength="10"/></td>
  </tr>
  <tr>
    <td ><strong>Company GST</strong></td>
    <td><input type="text" name="company_gstn" id="company_gstn" class="input_txt" value="<?php echo $company_gstn; ?>" maxlength="15" required/></td>
  </tr>
   <tr>
    <td ><strong>Mobile No</strong></td>
    <td><input type="text" name="mobile_no" id="mobile_no" class="input_txt" value="<?php echo $mobile_no; ?>" maxlength="10"/></td>
  </tr>
  <tr>
    <td ><strong>Email ID</strong></td>
    <td><input type="text" name="emailid" id="emailid" class="input_txt" value="<?php echo $emailid; ?>" /></td>
  </tr>
  <tr>
    <td ><strong>City</strong></td>
    <td><input type="text" name="city" id="city" class="input_txt" value="<?php echo $city; ?>"  required/></td>
  </tr>
  <tr>
	  <td class="content_txt"><strong>State</strong> </td>
	  <td> <select name="state" id="state" class="input_txt_new">
		<option value="">-- Select State --</option>
		<?php 
		$query = $conn ->query("SELECT * from state_master WHERE country_code = 'IN'");
		while($result= $query->fetch_assoc()){ ?>
		<option value="<?php echo $result['state_code'];?>"  <?php if($result['state_code']==$row3['state']){?> selected="selected" <?php }?>><?php echo $result['state_name'];?></option>
		<?php }?>
	   </select>
	  </td>
	</tr>  
	
	<tr>
    <td class="content_txt"><strong>Pincode</strong> </td>
    <td><input type="text" name="pin_code" id="pin_code" class="input_txt" value="<?php echo $pin_code; ?>" maxlength='6' minlength='6' required/></td>
    </tr>
	
  <tr>
  	<?php 
  	$gst_copy_ext =  pathinfo($gst_copy, PATHINFO_EXTENSION); 
  	$pan_no_copy_ext =  pathinfo($pan_no_copy, PATHINFO_EXTENSION); 
  	?>   
    <td><strong>GST Photo</strong></td>
    <td>  
    <?php if($gst_copy_ext == "pdf" || $gst_copy_ext =="PDF" ){ ?>
    <a href="https://registration.gjepc.org/images/gst_copy/<?php echo $gst_copy; ?>" target="_blank"> 
    <img  src="images/pdf_icon.png" /></a><?php } else { ?>
    <a data-fancybox="gallery" href="https://registration.gjepc.org/images/gst_copy/<?php echo $gst_copy; ?>"> 
    <img class="blah" src="https://registration.gjepc.org/images/gst_copy/<?php echo $gst_copy; ?>" title="<?php echo $company_gstn; ?>"/></a>
	<?php } ?>
    </td>
  </tr>
  <tr>
    <td><strong>PAN Card Copy</strong></td>
    <td>
    <?php if($pan_no_copy_ext == "pdf" || $pan_no_copy_ext == "PDF"){ ?>
    <a href="https://registration.gjepc.org/images/pan_no_copy/<?php echo $pan_no_copy; ?>" target="_blank">
    <img src="images/pdf_icon.png" /></a> 
    <?php }	else { ?>
	<a data-fancybox="gallery" href="https://registration.gjepc.org/images/pan_no_copy/<?php echo $pan_no_copy; ?>">
    <img class="blah" src="https://registration.gjepc.org/images/pan_no_copy/<?php echo $pan_no_copy; ?>" title="<?php echo $company_pan_no; ?>"/></a>
    <?php } ?>
    </td>
  </tr>
  <tr>
    <td><strong>Application Approval Status</strong></td>
    <td>
    <input type='radio' name='approval_status' id='regapprove' value='Y' <?php if($approval_status=='Y'){ echo "checked='checked'"; }?>/>Approve
	<input type='radio' name='approval_status' id='regdisapprove' value='D' <?php if($approval_status=='D'){ echo "checked='checked'"; }?>/>Disapprove
	<input type='radio' name='approval_status' id='allow' value='' <?php if($approval_status==''){ echo "checked='checked'"; }?>/>Allow GST & PAN Upload
    </td>
  </tr>
  <tr id="reg_disapprove">
    <td><strong>Disapprove Reason</strong></td>
    <td>
    <textarea name="disapprove" id="disapprove" cols="25"><?php echo $disapprove;?></textarea>
    </td>
  </tr>
  <tr >
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="actions" id="actions" value="<?php echo $actions;?>" />
    <input type="hidden" name="regid" id="regid"  value="<?php echo $_REQUEST['regid'];?>" />
    </td>
  </tr>
</table>
</form> 

<form name="company_document" action="" method="POST" enctype="multipart/form-data"/>        	
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr>
    <td><strong>NATURE OF BUSINESS Document</td>
    <td><input name="upload_company_document" type="file"/></td> 
	<?php if($company_document!=''){ echo "<td><a href='company_document_visitor/$company_document' target='_blank'>view</a></td>"; }?>
	<td><input type="submit" value="submit" class="input_submit"/>
	<input type="hidden" name="company_action" value="save_document"/>
    <input type="hidden" name="regid" id="regid" value="<?php echo $_REQUEST['regid'];?>" />
    </td>
  </tr>
</table>
</form> 

</div> 
<?php } ?>
 
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>

<script type="text/javascript">
/* Company BP Creation */
$(".comp").click(function() {
	var values = $(this).data('url');
	var registration_id=values;
	//alert(registration_id);
	
	if (confirm("Are you sure you want to Create Company BP")) {
		$.ajax({
		url: "create_company_nm_visitor_bp_api.php",
		method:"POST",
		data:{registration_id:registration_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			console.log(data); //exit;
			if($.trim(data)==1){
				alert("BP successfully Created..");
				window.location.reload(true);
			}else{
				alert("Sorry There is some problem with SAP response");
				window.location.reload(true);		
			}
			console.log(data);
		},
		});
	}	  
});
/* Visitor BP Creation */
$(".sap").click(function() { 
	var values = $(this).data('url').split(" ");
	var visitor_id=values[0];
	var registration_id=values[1];
	//alert(registration_id);
	
	if (confirm("Are you sure you want to PUSH this record")) {
		$.ajax({
		url: "create_nm_visitor_bp_api.php",
		method:"POST",
		data:{visitor_id:visitor_id,registration_id:registration_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{ 
			//console.log(data); exit;
			if($.trim(data)=='Y'){
				alert("BP Already Created..");
				window.location.reload(true);
			}
			else if($.trim(data)==1){
				alert("BP successfully Created..");
				window.location.reload(true);
			}else{
				alert("Sorry There is some problem with SAP response");
				window.location.reload(true);		
			}
			console.log(data);
		},
		});
	}	  
});

$(".so").click(function() {
	var values = $(this).data('url').split(" ");
	var bpno=values[0];
	var registration_id=values[1];
	var order_id=values[2];
	var csrf_sap_token=values[3];
	
	if (confirm("Are you sure you want to Create Sales Order")) {
		$.ajax({
		url: "create_iijs_visitor_so_api.php",
		method: "POST",
		data: { bpno:bpno,registration_id:registration_id,order_id:order_id,csrf_sap_token:csrf_sap_token },
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			//console.log(data); exit;
			if($.trim(data)=='N'){
				alert("Plz Create Employee BP First");
				window.location.reload(true);
			}
			else if($.trim(data)==1){
				alert("Sales Order successfully Created..");
				window.location.reload(true);
			} else {
				alert("Sorry There is some problem with SAP response");
				window.location.reload(true);			
			}
			console.log(data);
		},
		});
	}	  
});


/*.......................Visitor Address Update..............................*/
$(".delta").click(function() {
	values = $(this).data('url');
	x = values.split(' ');	
	var registration_id=x[0];// alert(registration_id);
	var visitor_id=x[1];

	
	if (confirm("Are you sure you want to update this address with Delta API")) {
		$.ajax({
		url: "visitor_address_delta_api.php",
		method:"POST",
		data:{registration_id:registration_id,visitor_id:visitor_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			//console.log(data);return false;
			if($.trim(data)==1){
				alert("Visitor Details Updated successfully..");; 
				window.location.href = "iijs_employee_directory_test.php?action=viewReg&regid="+registration_id;
			}else{
				alert("Sorry There is some problem with SAP response"); 
				window.location.href = "iijs_employee_directory_test.php?action=viewReg&regid="+registration_id;
			
			}
		},
		});
	}	  
});

/*.......................Visitor Company Address Update..............................*/
$(".Vdelta").click(function() {
	registration_id = $(this).data('url');
	
	if (confirm("Are you sure you want to update this address with Delta API")) {
		$.ajax({
		url: "visitor_company_address_delta_api.php",
		method:"POST",
		data:{registration_id:registration_id},
		type: "POST",
		beforeSend: function() {
        	$("#overlay").show();
    	},
		success:function(data)
		{
			//console.log(data);return false; exit;
			if($.trim(data)==1){
				alert("Visitor Company Details Updated successfully..");; 
				window.location.href = "iijs_employee_directory_test.php?action=view";
			}else{
				alert("Sorry There is some problem with SAP response"); 
				window.location.href = "iijs_employee_directory_test.php?action=view";
			
			}
		},
		});
	}	  
});
</script>
<div id="overlay"></div>
<style>
#overlay {
    position: fixed;
    display: none; 
    width: 100%; 
    height: 100%; 
    top: 0; 
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.8);
z-index:999;}  	
</style>

<style>
/*.modal {
    display: none; 
    position: fixed; 
    z-index: 1; 
    padding-top: 100px; 
    left: 0;
    top: 0;
    width: 100%; 
    height: 100%; 
    overflow: auto; 
    background-color: rgb(0,0,0); 
    background-color: rgba(0,0,0,0.4);    
}
@keyframes modalFade {
  from {transform: translateY(-50%);opacity: 0;}
  to {transform: translateY(0);opacity: 1;}
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
     animation-name: modalFade;
  animation-duration: .6s;
}
.modal_inner_content{margin: 20px 10px;}

.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}*/
.form-horizontal{border: 1px solid #ccc;padding: 25px;margin-top: 10px;}
.form-control{width: 100%;margin-bottom: 15px;}
.form-control label{width: 150px;display: inline-block;}
.form-control input{width: auto;}
</style>
<style type="text/css">
.blah{

border: 1px solid #ccc;
width: 110px;
height: 100px;
background: #ccc;
display: flex;
justify-content: center;
cursor: pointer;
}
.blah img{
max-height: 100%;
}


        
.preview {
            overflow: hidden;
            width: 160px; 
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }
       

     
        .overlay {
          position: absolute;
          bottom: 10px;
          left: 0;
          right: 0;
          background-color: rgba(255, 255, 255, 0.5);
          overflow: hidden;
          height: 0;
          transition: .5s ease;
          width: 100%;
        }

        .image_area:hover .overlay {
          height: 50%;
          cursor: pointer;
        }

        .text {
          color: #333;
          font-size: 20px;
          position: absolute;
          top: 50%;
          left: 50%;
          -webkit-transform: translate(-50%, -50%);
          -ms-transform: translate(-50%, -50%);
          transform: translate(-50%, -50%);
          text-align: center;
        }
        ul.pagination 
			{

			height: 28px;

			}

</style>
</body>
</html>