<?php session_start(); ob_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
$action=$_REQUEST['action'];
if($action=='UPDATE')
{	
	$id=$_REQUEST['id'];
	$registration_id=$_REQUEST['registration_id'];
	$photo_approval=$_REQUEST['photo_approval'];
		if($photo_approval=='Y')
		{
		$photo_reason="";	
		}else
		{
		$photo_reason=$_REQUEST['photo_reason'];
		}
	
	$valid_passport_copy_approval=$_REQUEST['valid_passport_copy_approval'];
		if($valid_passport_copy_approval=='Y')
		{
		$valid_passport_copy_reason="";	
		}else
		{
		$valid_passport_copy_reason=$_REQUEST['valid_passport_copy_reason'];
		}
	
	$visiting_card_approval=$_REQUEST['visiting_card_approval'];
		if($visiting_card_approval=='Y')
		{
		$visiting_card_reason="";	
		}else
		{
		$visiting_card_reason=$_REQUEST['visiting_card_reason'];
		}
	$nri_photo_approval=$_REQUEST['nri_photo_approval'];
		if($nri_photo_approval=='Y')
		{
		$nri_photo_reason="";	
		}else
		{
		$nri_photo_reason=$_REQUEST['nri_photo_reason'];
		}

	
	//------------------------------------  Update photograph ----------------------------------------------------
		$photograph_fid = '';
		$target_folder = '/var/www/html/registration.gjepc.org/images/ivr_image/photograph/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if($_FILES['photograph_fid']['name'] != '')
		{
		  //Unlink the previuos image
		   $qpreviousimg=$conn ->query("select photograph_fid from ivr_registration_details where eid='$id'");
		   $rpreviousimg=$qpreviousimg->fetch_assoc();
		   $filename="/var/www/html/registration.gjepc.org/images/ivr_image/photograph/".$rpreviousimg['photograph_fid'];
		   //unlink($filename);
			
			$target_path = $target_folder.$temp_code.'_'.$_FILES['photograph_fid']['name'];
			if(@move_uploaded_file($_FILES['photograph_fid']['tmp_name'], $target_path))
			{
				$photograph_fid = $temp_code.'_'.$_FILES['photograph_fid']['name'];
				$sql="update ivr_registration_details set photograph_fid='$photograph_fid' where eid='$id'";
				$result=$conn ->query($sql);
			}
			else
			{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this photo.\");location.href='photo_form_IVR_virtual.php?id=$id&registration_id=$registration_id';</script>";
				return;
			}			
		}
		
		//------------------------------------  Update passport ----------------------------------------------------
		$passport_fid = '';
		$target_folder = '/var/www/html/registration.gjepc.org/images/ivr_image/passport/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if($_FILES['passport_fid']['name'] != '')
		{
		  //Unlink the previuos image
		   $qpreviousimg=$conn ->query("select passport_fid from ivr_registration_details where eid='$id'");
		   $rpreviousimg=$qpreviousimg->fetch_assoc();
		   $filename="/var/www/html/registration.gjepc.org/images/ivr_image/passport/".$rpreviousimg['passport_fid'];
		   //unlink($filename);

			$target_path = $target_folder.$temp_code.'_'.$_FILES['passport_fid']['name'];
			if(@move_uploaded_file($_FILES['passport_fid']['tmp_name'], $target_path))
			{
				$passport_fid = $temp_code.'_'.$_FILES['passport_fid']['name'];
				$sql="update ivr_registration_details set passport_fid='$passport_fid' where eid='$id'";
				$result=$conn ->query($sql);
			}
			else
			{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this photo.\");location.href='photo_form_IVR_virtual.php?id=$id&registration_id=$registration_id';</script>";
				return;
			}
			
		}
		
		//------------------------------------  Update visiting card ----------------------------------------------------
		$visit_card_fid = '';
		//$target_folder = 'C:/xampp/htdocs_vhosts/iijs/images/ivr_image/visiting_card/';
		$target_folder = '/var/www/html/registration.gjepc.org/images/ivr_image/visiting_card/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if($_FILES['visit_card_fid']['name'] != '')
		{
		  //Unlink the previuos image
		   $qpreviousimg=$conn ->query("select visit_card_fid from ivr_registration_details where eid='$id'");
		   $rpreviousimg=$qpreviousimg->fetch_assoc();
		   $filename="/var/www/html/registration.gjepc.org/images/ivr_image/visiting_card/".$rpreviousimg['visit_card_fid'];
		   //unlink($filename);

			$target_path = $target_folder.$temp_code.'_'.$_FILES['visit_card_fid']['name'];
			if(@move_uploaded_file($_FILES['visit_card_fid']['tmp_name'], $target_path))
			{
				$visit_card_fid = $temp_code.'_'.$_FILES['visit_card_fid']['name'];
				$sql="update ivr_registration_details set visit_card_fid='$visit_card_fid' where eid='$id'";
				$result=$conn ->query($sql);
			}
			else
			{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this photo.\");location.href='photo_form_IVR_virtual.php?id=$id&registration_id=$registration_id';</script>";
				return;
			}			
		}
		
		//------------------------------------  Update nri ----------------------------------------------------
		$nri_fid = '';
		$target_folder = '/var/www/html/registration.gjepc.org/images/ivr_image/nri/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if($_FILES['nri_fid']['name'] != '')
		{
		  //Unlink the previuos image
		   $qpreviousimg=$conn ->query("select nri_fid from ivr_registration_details where eid='$id'");
		   $rpreviousimg=$qpreviousimg->fetch_assoc();
		   $filename="/var/www/html/registration.gjepc.org/images/ivr_image/nri/".$rpreviousimg['nri_fid'];
		   //unlink($filename);
			
			$target_path = $target_folder.$temp_code.'_'.$_FILES['nri_fid']['name'];
			if(@move_uploaded_file($_FILES['nri_fid']['tmp_name'], $target_path))
			{
				$nri_fid = $temp_code.'_'.$_FILES['nri_fid']['name'];
				$sql="update ivr_registration_details set nri_fid='$nri_fid' where eid='$id'";
				$result=$conn ->query($sql);
			}
			else
			{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this photo.\");location.href='photo_form_IVR_virtual.php?id=$id&registration_id=$registration_id';</script>";
				return;
			}			
		}
		
	$updatequery="update ivr_registration_details set photo_approval='".$photo_approval."',photo_reason='".$photo_reason."',valid_passport_copy_approval='".$valid_passport_copy_approval."',valid_passport_copy_reason='".$valid_passport_copy_reason."',visiting_card_approval='".$visiting_card_approval."',visiting_card_reason='".$visiting_card_reason."',nri_photo_approval='".$nri_photo_approval."',nri_photo_reason='".$nri_photo_reason."' where eid='$id' and uid='$registration_id'"; 
	$update_result = $conn ->query($updatequery);
	if(!$update_result){
		echo "Error: ".mysqli_error();	
	}
		
	$sql1="SELECT * FROM `ivr_registration_details` WHERE 1 and eid='$id' and uid='$registration_id'";
	$result1=$conn ->query($sql1);
	$rows1=$result1->fetch_assoc();
	$email_id=$rows1['email'];
	
	if($rows1['personal_info_approval']=='Y' && $rows1['photo_approval']=='Y' && $rows1['valid_passport_copy_approval']=='Y' && $rows1['visiting_card_approval']== 'Y' && $rows1['nri_photo_approval']=='Y')
	{
	$approval = $conn ->query("update `ivr_registration_details` set application_approved='Y' WHERE 1 and eid='$id' and uid='$registration_id'");	
	
	/*Global Table Start */
	
	$name = strtoupper($rows1['first_name'].' '.$rows1['last_name']);
	$mobile = $rows1['mob_no'];
	$designation = strtoupper($rows1['designation']); 
	$company = strtoupper($rows1['company_name']);

	$photo_url = "https://registration.gjepc.org/images/ivr_image/photograph/".$rows1['photograph_fid'];

			$digits = 9;	
			$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
			$checkUniqueIdentifier = $conn->query("SELECT * FROM globalExhibition WHERE `uniqueIdentifier`='$uniqueIdentifier'");
			$countUniqueIdentifier = $checkUniqueIdentifier->num_rows;
			while($countUniqueIdentifier > 0) {
			$uniqueIdentifier = rand(pow(10, $digits-1), pow(10, $digits)-1);
			} 
			
	$check = "SELECT * FROM gjepclivedatabase.globalExhibition where email='$email_id' AND participant_Type='INTL'";
	$getResult = $conn ->query($check);
	$countx = $getResult->num_rows;
	if($countx>0){
		$global = "UPDATE gjepclivedatabase.globalExhibition SET registration_id='$registration_id',visitor_id='$id',fname='$name',designation='$designation',company='$company',photo_url='$photo_url',days_allow='all' where mobile='$mobile' AND email='$email_id' AND participant_Type='INTL'";
		$globalQuery = $conn ->query($global);
		if(!$globalQuery) die ($conn->error);
	} else { 
		$global = "INSERT INTO gjepclivedatabase.globalExhibition SET `uniqueIdentifier`='$uniqueIdentifier',registration_id='$registration_id',visitor_id='$id',fname='$name',mobile='$mobile',email='$email_id',designation='$designation',company='$company',photo_url='$photo_url',participant_Type='INTL',days_allow='all'";
		$globalQuery = $conn ->query($global);
		if(!$globalQuery) die ($conn->error);
	}
	/*Global Table End */

	$message ='<table width="800px" bgcolor="#fff" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">
	
	<tr>
	<td style="padding:30px;">	
	<table width="100%" border="0px" background="#fff" cellpadding="0px" cellspacing="0px">	
	<tr>
    <td align="left"><img src="https://gjepc.org/images/gjepc_logon.png"/></td>
    <td align="right" valign="top"><img src="https://gjepc.org/iijs-signature/assets/images/logo.png"/></td>
    </tr>
	
	<tr>
	<td> </td>
	<td align="right"></td>
	</tr>	
	<tr><td align="right" colspan="3" height="30px"><hr /></td></tr>	
	<tr><td align="right" colspan="3" height="10px"></td></tr>	
	<tr>
	<td colspan="3" style="font-size:13px; line-height:22px;">
	
	<p> Dear '.$rows1['title'].' '.$rows1['first_name'].' '.$rows1['last_name'].',</p>
	
	<p>Your Application for the International Visitor Registration form have been APPROVED by IIJS SIGNATURE Admin.</p>
	
	<p>Request you to kindly login at our website and verify the same. Kindly keep the print of this confirmation e-mail to be produced at venue.</p>
	
	<p>Following are your login credentials:</p>
	<p><strong>Name : </strong>'.$rows1['title'].' '.$rows1['first_name'].' '.$rows1['last_name'].'</p>
	<p><strong>Email ID : </strong>'.getUserEmail($registration_id,$conn).'</p>
	
	<p>Please <a href="https://iijs.org/login.php" style="color:#751b53; text-decoration:none; font-weight:bold;">click here</a> to login to www.iijs.org.</p>
	
	<p>Warm Regards,</br>
	Team IIJS SIGNATURE </p>
	</td>
	</tr>
	<td colspan="4" align="right" ><hr /></td>
	</tr>
	</table>
	</td>
	</tr>	
	</table>
	</body>
</html>';	
		
	//$to =$rows1['email'].',overseas@gjepcindia.com';
	//$to = 'ameya.chitnis@gjepcindia.com,neelmani@kwebmaker.com,santosh@kwebmaker.com';
	$subject = "IIJS SIGNATURE 2021 : Your Information for International Visitor Registration has been approved by the Administrator"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .='From: IIJS SIGNATURE 2021<admin@gjepc.org>';		
	mail($to, $subject, $message, $headers);	
	
	} else
	{
	
	if($rows1['personal_info_approval']=='Y')
	{
	$info_status="Approved";
	}else if($rows1['personal_info_approval']=='N')
	{
	$info_status="Disapproved";
	}else if($rows1['personal_info_approval']=='P')
	{
	$info_status="Pending";
	}	
	
	if($rows1['photo_approval']=='Y')
	{
	$photo_status="Approved";
	}else if($rows1['photo_approval']=='N')
	{
	$photo_status="Disapproved";
	}else if($rows1['photo_approval']=='P')
	{
	$photo_status="Pending";
	}
	
	if($rows1['valid_passport_copy_approval']=='Y')
	{
	$passport_status="Approved";
	}else if($rows1['valid_passport_copy_approval']=='N')
	{
	$passport_status="Disapproved";
	}else if($rows1['valid_passport_copy_approval']=='P')
	{
	$passport_status="Pending";
	}
	
	if($rows1['visiting_card_approval']=='Y')
	{
	$visiting_status="Approved";
	}else if($rows1['visiting_card_approval']=='N')
	{
	$visiting_status="Disapproved";
	}else if($rows1['visiting_card_approval']=='P')
	{
	$visiting_status="Pending";
	}
	
	if($rows1['nri_photo_approval']=='Y')
	{
	$nri_status="Approved";
	}else if($rows1['nri_photo_approval']=='N')
	{
	$nri_status="Disapproved";
	}else if($rows1['nri_photo_approval']=='P')
	{
	$nri_status="Pending";
	}
	
	$conn ->query("update `ivr_registration_details` set application_approved='N' WHERE 1 and eid='$id' and uid='$registration_id'");
	
	$message ='<table width="800px" bgcolor="#fff" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">

<tr>
<td style="padding:30px;">
    <table width="100%" border="0px" background="#fff" cellpadding="0px" cellspacing="0px">    
	<tr>
    <td align="left"><img src="https://gjepc.org/images/gjepc_logon.png"/></td>
    <td align="right" valign="top"><img src="https://registration.gjepc.org/images/iijslogo-2020.png"/></td>
    </tr>
    
    <tr><td> </td>
    <td align="right"></td>
    </tr>    
    <tr><td align="right" colspan="3" height="30px"><hr /></td></tr>
	<tr><td align="right" colspan="3" height="10px"></td></tr>    
    <tr>
    <td colspan="3" style="font-size:13px; line-height:22px;">
    
   <p> Dear '.$rows1['title'].' '.$rows1['first_name'].' '.$rows1['last_name'].',</p>

<p>The below details for your International Visitor Registration form have been DISAPPROVED by the IIJS SIGNATURE 2021 Admin.</p>

<table width="500" border="0" cellspacing="0" cellpadding="0" >
  <tr style="height:20px; border:1px solid  #FF0000; background:#751b53; color:#FFFFFF;">
    <td style="border:1px solid  #cccccc; padding:5px;" ><strong>Details</strong></td>
    <td style="border:1px solid  #cccccc; padding:5px;"><strong>Status</strong></td>
    <td style="border:1px solid  #cccccc; padding:5px;"><strong>Reason for  Disapproval </strong></td>
  </tr>
  <tr style="height:20px; border:1px solid  #FF0000;">
    <td style="border:1px solid  #cccccc; padding:5px;" >Personal Information</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$info_status.'</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$rows1['personal_info_reason'].' </td>
  </tr>
  <tr style="height:20px; border:1px solid  #FF0000;">
    <td style="border:1px solid  #cccccc; padding:5px;" >Photo</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$photo_status.'</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$rows1['photo_reason'].'</td>
  </tr>
  <tr style="height:20px; border:1px solid  #FF0000;">
    <td style="border:1px solid  #cccccc; padding:5px;" >Passport Copy</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$passport_status.'</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$rows1['valid_passport_copy_reason'].'</td>
  </tr>
  <tr style="height:20px; border:1px solid  #FF0000;">
    <td style="border:1px solid  #cccccc; padding:5px;" >Visiting/Businees Card</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$visiting_status.'</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$rows1['visiting_card_reason'].'</td>
  </tr>
  <tr style="height:20px; border:1px solid  #FF0000;">
    <td style="border:1px solid  #cccccc; padding:5px;" >NRI Status Proof</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$nri_status.'</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$rows1['nri_photo_reason'].'</td>
  </tr>
</table>

<p>Request you to kindly login at our website and verify the same. </p>
	<p>Following are your login credentials:</p>
	<p><strong>Name : </strong>'.$rows1['title'].' '.$rows1['first_name'].' '.$rows1['last_name'].'</p>
	<p><strong>Email ID : </strong>'.getUserEmail($registration_id,$conn).'</p>


<p>In case you have forgotten your password, <a href="https://registration.gjepc.org/forgot_password.php" style="color:#751b53; text-decoration:none; font-weight:bold;">click here</a>.</p>

<p>Warm Regards,</br></br>
Team IIJS SIGNATURE 2021</p>
    </td>
    </tr>
    <td colspan="4" align="right" ><hr /></td>
	</tr>
	
    </table>
</td>
</tr>

</table>';	
		
	// $to =$email_id.',overseas@gjepcindia.com';
	// $to = 'ameya.chitnis@gjepcindia.com,neelmani@kwebmaker.com,santosh@kwebmaker.com';
	 $subject = "Your International Visitor Registration Application Status"; 
	 $headers  = 'MIME-Version: 1.0' . "\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	 $headers .='From: IIJS SIGNATURE 2021 <admin@gjepc.org>';	
	 mail($to, $subject, $message, $headers);
	}
$_SESSION['succ_msg']="Application updated successfully";
header("Location: iijs_signature_ivr.php");
}
?>

<?php
$id= $_REQUEST['id'];
$registration_id=$_REQUEST['registration_id'];
$sql="SELECT * FROM `ivr_registration_details` WHERE 1 and eid='$id' and uid='$registration_id'";
$result=$conn ->query($sql);
$rows=$result->fetch_assoc();

$photograph_fid=$rows['photograph_fid'];
$passport_fid=$rows['passport_fid'];
$visit_card_fid=$rows['visit_card_fid'];
$nri_fid=$rows['nri_fid'];
$photo_approval=$rows['photo_approval'];
$photo_reason=$rows['photo_reason'];
if($photo_reason==""){$photo_reason="Kindly upload Passport Size Colour Photograph";}

$valid_passport_copy_approval=$rows['valid_passport_copy_approval'];
$valid_passport_copy_reason=$rows['valid_passport_copy_reason'];
if($valid_passport_copy_reason==""){$valid_passport_copy_reason="Kindly upload Passport Copy, pg with Photograph & validity";}

$visiting_card_approval=$rows['visiting_card_approval'];
$visiting_card_reason=$rows['visiting_card_reason'];
if($visiting_card_reason==""){$visiting_card_reason="Kindly upload your business card with your name printed on it.";}

$nri_photo_approval=$rows['nri_photo_approval'];
$nri_photo_reason=$rows['nri_photo_reason'];
if($nri_photo_reason==""){$nri_photo_reason="Kindly upload NRI Proof is required only if you have Indian passport (* Residential proof/card/Green card/Driving license/ work permit)";}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta https-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IVR VIRTAL > Photo</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/formAdmin.css"/>
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});
});
function showDate(date) {
	alert('The date chosen is ' + date);}
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
<!--navigation end-->

<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
	
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("div.fancyDemo a").fancybox();
		});
	</script>
<!-- lightbox Thum -->

<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}

-->
</style>
<script> 
function check_disable2(){
    if ($('input[name=\'photo_approval\']:checked').val() == "N"){
        $("#photo_reason_text").show();
    }
    else{
        $("#photo_reason_text").hide();
    }	
}

function check_disable3(){
    if ($('input[name=\'valid_passport_copy_approval\']:checked').val() == "N"){
        $("#valid_passport_copy_reason_text").show();
    }
    else{
        $("#valid_passport_copy_reason_text").hide();
    }	
}

function check_disable4(){
    if ($('input[name=\'visiting_card_approval\']:checked').val() == "N"){
        $("#visiting_card_reason_text").show();
    }
    else{
        $("#visiting_card_reason_text").hide();
    }	
}

function check_disable5(){
    if ($('input[name=\'nri_photo_approval\']:checked').val() == "N"){
        $("#nri_photo_reason_text").show();
    }
    else{
        $("#nri_photo_reason_text").hide();
    }	
}
</script>

<script type="text/javascript">
function validation()
{
	
	if($('input[name="photo_approval"]:checked').length == 0)
		{
			alert("Please Select Photo Approval option.");
			document.getElementById('photo_approval').focus();
			return false;
		}

	if($('input[name=\'photo_approval\']:checked').val() == "N")
	{
		if(document.getElementById('photo_reason').value=="")
		{
			alert("Please Enter Photo Disapprove Reason");
			document.getElementById('photo_reason').focus();
			return false;
		}
	}
	
	if($('input[name="valid_passport_copy_approval"]:checked').length == 0)
		{
			alert("Please Select Passport Approval option.");
			document.getElementById('valid_passport_copy_approval').focus();
			return false;
		}

	if($('input[name=\'valid_passport_copy_approval\']:checked').val() == "N")
	{
		if(document.getElementById('valid_passport_copy_reason').value=="")
		{
			alert("Please Enter Passport Disapprove Reason");
			document.getElementById('valid_passport_copy_reason').focus();
			return false;
		}
	}
	
	if($('input[name="visiting_card_approval"]:checked').length == 0)
		{
			alert("Please Select Visiting Card Approval option.");
			document.getElementById('visiting_card_approval').focus();
			return false;
		}

	if($('input[name=\'visiting_card_approval\']:checked').val() == "N")
	{
		if(document.getElementById('visiting_card_reason').value=="")
		{
			alert("Please Enter Visiting Card Disapprove Reason");
			document.getElementById('visiting_card_reason').focus();
			return false;
		}
	}
	
	if($('input[name="nri_photo_approval"]:checked').length == 0)
		{
			alert("Please Select NRI Photo Approval option.");
			document.getElementById('nri_photo_approval').focus();
			return false;
		}

	if($('input[name=\'nri_photo_approval\']:checked').val() == "N")
	{
		if(document.getElementById('nri_photo_reason').value=="")
		{
			alert("Please Enter NRI Photo Disapprove Reason");
			document.getElementById('nri_photo_reason').focus();
			return false;
		}
	}
}

</script>

</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > IVR VIRTUAL > Photo</div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head">IVR VIRTUAL >> Photo
       	<div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_signature_ivr.php">Back to Search</a></div> 
        </div>
	    <div class="clear"></div>

<div class="content_details1">
<form name="search" action="" method="post" enctype="multipart/form-data" onsubmit="return validation()"> 
<?php 
/*if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}*/
?>
<div id="formAdmin">
	<ul id="tabs" class="tab_1">
    <li id=""><a href="#"><strong>Step 1 Information</strong></a></li>
    <li id=""><a href="#"><strong>Step 2 OBMP Info</strong></a></li>  
    <li id=""><a href="#" class="lastBg active"><strong>Step 3 Photo</strong></a></li>   
    <div class="clear"></div>
	</ul>

<div id="formContainer">
<div id="form">
<div class="clear bottomSpace"></div>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt bottomSpace" >
<tr class="orange1">
    <td colspan="10" >Photograph <sup class="white">*</sup></td>
</tr>
<tr>
  <td class="maroon"><strong>Please browse to attach your photograph:</strong></td>
</tr>
<tr>
    <td>
    <div class="field bottomSpace">
         <div class="userPic">
         <?php 
		 if($photograph_fid=="")
		 {
		    echo "<img src='images/user_pic.jpg' width='100' height='100' />";
		 }else
		 {
		 ?>
		 <div class="fancyDemo"><a rel="group" href="https://registration.gjepc.org/images/ivr_image/photograph/<?php echo $photograph_fid;?>"><img src='https://registration.gjepc.org/images/ivr_image/photograph/<?php echo $photograph_fid;?>' width='100' height='100' /></a></div>
		 <?php
         }
		 ?>
         </div>
         <div class="leftFile">
             <div class="midTitle">Please browse to attach your photograph : <sup>*</sup> </div>
             <p><strong>Filename</strong></p>
             <input name="photograph_fid" id="photograph_fid" type="file" class="input_txt" style="margin-bottom:10px; background:#fff;" />
         </div>
         
         <div class="rightFile">
             <div class="midTitle"><strong>Photo Approval </strong></div>
             <p>
               <input type="radio" name="photo_approval" id="photo_approval" value="Y" onchange="check_disable2()" <?php if($photo_approval=="Y"){?> checked="checked" <?php }?> /> 
               Approved
                <input type="radio" name="photo_approval" id="photo_approval" value="N" onchange="check_disable2()"  <?php if($photo_approval=="N"){?> checked="checked" <?php }?> /> Dispproved
             </p>
             <p id="photo_reason_text" <?php if($photo_approval=="Y"){?> style="display:none;" <?php }?>>
             <textarea name="photo_reason" cols="40" rows="6" id="photo_reason"  ><?php echo $photo_reason;?></textarea>
		 	 </p>
		 </div>
         
        <div class="clear"></div>
        <div class="note">
            Only JPEG, PNG and GIF images are allowed. <br />
            <strong>The maximum upload size is 2MB.</strong><br />
            Changes made are not permanent until you save this form.
        </div>
        <div class="clear"></div>
    </div>
    </td>
    </tr>
</table>          
         
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt bottomSpace" >
<tr class="orange1">
    <td colspan="10" >Valid Passport Copy *</td>
</tr>
<tr>
  <td class="maroon"><strong>Please browse to attach your passport copy :</strong></td>
  </tr>
<tr>
    <td>
    <div class="field bottomSpace">
    <div class="userPic">
    	 <?php 
		 if($passport_fid=="")
		 {
		    echo "<img src='images/user_pic.jpg' width='100' height='100' />";
		 }else
		 {
		 ?>
		 <div class="fancyDemo"> <a rel="group" href="https://registration.gjepc.org/images/ivr_image/passport/<?php echo $passport_fid;?>"><img src='https://registration.gjepc.org/images/ivr_image/passport/<?php echo $passport_fid;?>' width='100' height='100' /></a></div>
		 <?php
		 }
		 ?>
	</div>
    <div class="leftFile">
		<div class="midTitle">Please browse to attach your passport copy: <sup>*</sup> </div>
   		<p><strong>Filename</strong></p>
        <input name="passport_fid" type="file" class="input_txt" style="margin-bottom:10px; background:#fff;" id="passport_fid" />
        </div>
       
            <div class="rightFile">
             <div class="midTitle"><strong>Passport Approval </strong></div>
             <p><input type="radio" name="valid_passport_copy_approval" id="valid_passport_copy_approval" value="Y" onchange="check_disable3()" <?php if($valid_passport_copy_approval=="Y"){?> checked="checked" <?php }?> /> Approved
                <input type="radio" name="valid_passport_copy_approval" id="valid_passport_copy_approval" value="N" onchange="check_disable3()"  <?php if($valid_passport_copy_approval=="N"){?> checked="checked" <?php }?> /> Dispproved
             </p>
             <p id="valid_passport_copy_reason_text" <?php if($valid_passport_copy_approval=="Y"){?> style="display:none;" <?php }?>>
             <textarea name="valid_passport_copy_reason" cols="40" rows="6" id="valid_passport_copy_reason"  ><?php echo $valid_passport_copy_reason;?></textarea>
		 	 </p>	
         </div>
            
        <div class="clear"></div>
        <div class="note">
            Only JPEG, PNG and GIF images are allowed. <br />
            <strong>The maximum upload size is 2MB.</strong><br />
            Changes made are not permanent until you save this form.
        </div>
        <div class="clear"></div>
    </div>
    </td>
    </tr>
</table>
           
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt bottomSpace" >
<tr class="orange1">
    <td colspan="10" >Business / Visiting Card *</td>
</tr>
<tr>
  <td class="maroon"><strong>Please browse to attach your Business / Visiting Card :</strong></td>
</tr>
<tr>
    <td>
    <div class="field bottomSpace">
    <div class="userPic">
    <?php 
		 if($visit_card_fid=="")
		 {
		    echo "<img src='images/user_pic.jpg' width='100' height='100' />";
		 }else
		 {
		 ?>
		 <div class="fancyDemo"><a rel="group" href="https://registration.gjepc.org/images/ivr_image/visiting_card/<?php echo $visit_card_fid;?>"><a rel="group" href="https://registration.gjepc.org/images/ivr_image/visiting_card/<?php echo $visit_card_fid;?>"><img src='https://registration.gjepc.org/images/ivr_image/visiting_card/<?php echo $visit_card_fid;?>' width='100' height='100' /></a></div>
		 <?php
		 }
	?>
    </div>
    <div class="leftFile">
        <div class="midTitle">Please browse to attach your Business/ Visiting card: <sup>*</sup> </div>
        <p><strong>Filename</strong></p>
         <input name="visit_card_fid" id="visit_card_fid" type="file" class="input_txt" style="margin-bottom:10px; background:#fff;" />
	</div>
     	
        
        <div class="rightFile">
            <div class="midTitle"><strong>Visiting Card Approval </strong></div>
            <p><input type="radio" name="visiting_card_approval" id="visiting_card_approval" value="Y" onchange="check_disable4()" <?php if($visiting_card_approval=="Y"){?> checked="checked" <?php }?> /> Approved
            <input type="radio" name="visiting_card_approval" id="visiting_card_approval" value="N" onchange="check_disable4()"  <?php if($visiting_card_approval=="N"){?> checked="checked" <?php }?> /> Dispproved
            </p>
            <p  id="visiting_card_reason_text" <?php if($visiting_card_approval=="Y"){?> style="display:none;" <?php }?>>
            <textarea name="visiting_card_reason" cols="40" rows="6" id="visiting_card_reason"  ><?php echo $visiting_card_reason;?></textarea>
		 	 </p>	
         </div>	
    <div class="clear"></div>
    <div class="note">
        Only JPEG, PNG and GIF images are allowed. <br />
        <strong>The maximum upload size is 2MB.</strong><br />
        Changes made are not permanent until you save this form.
    </div>
    <div class="clear"></div>
	</div>
    </td>
    </tr>
</table>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt bottomSpace" >
<tr class="orange1">
    <td colspan="10" >NRI Status Proof</td>
</tr>
<tr>
  <td class="maroon"><strong>Please browse to attach your NRI Status Proof :</strong></td>
</tr>
<tr>
    <td>
    <div class="field bottomSpace">
        <div class="userPic">
        <?php 
		 if($nri_fid=="")
		 {
		    echo "<img src='images/user_pic.jpg' width='100' height='100' />";
		 }else
		 {
		 ?>
		 <div class="fancyDemo"> <a rel="group" href="https://registration.gjepc.org/images/ivr_image/nri/<?php echo $nri_fid;?>"><img src='https://registration.gjepc.org/images/ivr_image/nri/<?php echo $nri_fid;?>' width='100' height='100' /></a></div>
		 <?php
		 }
		 ?>
        </div>
        <div class="leftFile">
             <div class="midTitle">Please browse to attach your NRI proof : <sup>*</sup> </div>
             <p><strong>Filename</strong></p>
             <input name="nri_fid" id="nri_fid" type="file" class="input_txt" style="margin-bottom:10px; background:#fff;" />
        </div>
        
        <div class="rightFile">
             <div class="midTitle"><strong>NRI Approval </strong></div>
             <p><input type="radio" name="nri_photo_approval" id="nri_photo_approval" value="Y" onchange="check_disable5()" <?php if($nri_photo_approval=="Y"){?> checked="checked" <?php }?>/> Approved
               <input type="radio" name="nri_photo_approval" id="nri_photo_approval" value="N" onchange="check_disable5()"<?php if($nri_photo_approval=="N"){?> checked="checked" <?php }?>/> Dispproved
             
             </p>
             <p id="nri_photo_reason_text" <?php if($nri_photo_approval=="Y"){?> style="display:none;" <?php }?>>
             <textarea name="nri_photo_reason" cols="40" rows="6" id="nri_photo_reason" ><?php echo $nri_photo_reason;?></textarea></p>
		 </div>
        
        <div class="clear"></div>
        <div class="note">
            Only JPEG, PNG and GIF images are allowed. <br />
            <strong>The maximum upload size is 2MB.</strong><br />
            Changes made are not permanent until you save this form.
        </div>
		<div class="clear"></div>
        </div>
        </td>
    </tr>
</table>
       


</div>
</div>
</div>
<div style="padding-left:250px; margin-top:5px;">
<input type="hidden" name="action" id="action" value="UPDATE" />
<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />    	
<input type="submit" value="Submit" class="input_submit"/>

</div>
</form>      
</div>
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
