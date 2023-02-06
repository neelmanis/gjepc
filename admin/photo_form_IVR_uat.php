<?php session_start(); ob_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
$action=$_REQUEST['action'];


$id = intval(filter($_REQUEST['id']));
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
	
	$vaccination_id_approval=$_REQUEST['vaccination_id_approval'];
		if($vaccination_id_approval=='Y')
		{
		$vaccination_id_reason="";	
		}else
		{
		$vaccination_id_reason=$_REQUEST['vaccination_id_reason'];
		}
	
		//------------------------------------  Update photograph ----------------------------------------------------
		$photograph_fid = '';
		$target_folder = '/var/www/html/registration.gjepc.org/images/ivr_image/photograph/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		
		if($_FILES['photo']['name'] != '')
		{
		  //Unlink the previuos image
		   $qpreviousimg=$conn ->query("select photograph_fid from ivr_registration_details where eid='$id'");
		   $rpreviousimg=$qpreviousimg->fetch_assoc();
		   $filename="/var/www/html/registration.gjepc.org/images/ivr_image/photograph/".$rpreviousimg['photograph_fid'];
		   //unlink($filename);
			
			$target_path = $target_folder.$temp_code.'_'.$_FILES['photo']['name'];
			if(@move_uploaded_file($_FILES['photo']['tmp_name'], $target_path))
			{
				$photograph_fid = $temp_code.'_'.$_FILES['photo']['name'];

				$photo_url= "http://registration.gjepc.org/images/ivr_image/photograph/".$photograph_fid;

				$sql="update ivr_registration_details set photograph_fid='$photograph_fid' where eid='$id'";
				$result=$conn ->query($sql);
				if($result){	
					$updateGlobal = "UPDATE globalExhibition SET photo_url='$photo_url',isDataPosted='N',`face_status`='P' WHERE `registration_id`='$registration_id' AND `visitor_id`='$id' AND (`participant_Type`='INTL' ) ";
					$result=$conn ->query($updateGlobal);
				}
				
			}
			else
			{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this photo.\");location.href='photo_form_IVR.php?id=$id&registration_id=$registration_id';</script>";
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
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this photo.\");location.href='photo_form_IVR.php?id=$id&registration_id=$registration_id';</script>";
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
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this photo.\");location.href='photo_form_IVR.php?id=$id&registration_id=$registration_id';</script>";
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
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this photo.\");location.href='photo_form_IVR.php?id=$id&registration_id=$registration_id';</script>";
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
	
	//if($rows1['personal_info_approval']=='Y' && $rows1['photo_approval']=='Y' && $rows1['valid_passport_copy_approval']=='Y' && $rows1['visiting_card_approval']== 'Y' && $rows1['nri_photo_approval']=='Y' && $rows1['vaccination_id_approval']=='Y')
	if($rows1['personal_info_approval']=='Y' && $rows1['photo_approval']=='Y' && $rows1['valid_passport_copy_approval']=='Y' && $rows1['visiting_card_approval']== 'Y' && $rows1['nri_photo_approval']=='Y')
	{
	$approval = $conn ->query("update `ivr_registration_details` set application_approved='Y' WHERE 1 and eid='$id' and uid='$registration_id'");
	}
	$_SESSION['succ_msg']="Application updated successfully";
	header("Location: iijs_ivr.php?action=view");
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
} else {
	$photo = getVisitorPhoto($id,$conn);	
	$photo_ext =  pathinfo($photo, PATHINFO_EXTENSION);	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta https-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IVR > Photo</title>
<link rel="stylesheet" type="text/css" href="https://gjepc.org/assets-new/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="fancybox/fancybox_css.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/formAdmin.css"/>
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<script type="text/javascript" src="https://gjepc.org/assets-new/js/jquery.min.js?v=<?php echo $version;?>"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" ></script>
<script type="text/javascript" src="fancybox/fancybox_js.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script src="https://gjepc.org/iijs-signature/assets/js/bootstrap.min.js"></script>

<!-- CROPPER JS START-->
<link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
<script src="https://unpkg.com/dropzone"></script>
<script src="https://unpkg.com/cropperjs"></script>
<!-- CROPPER JS END -->   

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

/* .style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
} */


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
	<div class="breadcome"><a href="admin.php">Home</a> > IVR > Photo </div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head">IVR >> Photo
       	<div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_ivr.php?action=view">Back to Search</a></div> 
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
			<div class="fancyDemo"><a rel="group" href="http://registration.gjepc.org/images/ivr_image/photograph/<?php echo $photograph_fid;?>"><img src='http://registration.gjepc.org/images/ivr_image/photograph/<?php echo $photograph_fid;?>' width='100' height='100' /></a></div>
			<?php
			}
			?>
         </div>
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
		 	//$photo_ext =  pathinfo($photo, PATHINFO_EXTENSION);
        
			if($photo_ext == "pdf" ||  $photo_ext == "PDF"){ ?>
				<a href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $photo; ?>" target="_blank">
				<img src="images/pdf_icon.png" title="<?php echo $name;?>"/></a>
				<div class="row">
					<div class="col-12 mb-2">
						<input type="file" name="photo" id="photo" class=" preview_crop" autocomplete="off" data-ref="photo" data-crop="1" accept=".jpg,.jpeg,.png" data-toggle="tooltip" data-placement="top" title="Photo Passport size with white background">
						
					</div>
				</div>
			<?php } else { ?>
				<!--  <a data-fancybox="gallery" href="https://registration.gjepc.org/images/employee_directory/<?php //echo $registration_id; ?>/photo/<?php //echo $photo; ?>"> 
				<img class="img_e" src="https://registration.gjepc.org/images/employee_directory/<?php //echo $registration_id; ?>/photo/<?php //echo $photo; ?>" title="<?php //echo $name;?>" /></a> 	 -->

				<div class="row">
					<div class="col-12 mb-2">
						<input type="file" name="photo" id="photo" class=" preview_crop" autocomplete="off" data-ref="photo" data-crop="1" accept=".jpg,.jpeg,.png" data-toggle="tooltip" data-placement="top" title="Photo Passport size with white background">
						
					</div>
				</div>
		
				<div class="row">
						<div class="leftFile">
						<p   style="margin-bottom: 5px;"><strong>Current Photo</strong> </p>
						<div class="blah midTitle">
							<a data-fancybox="gallery" href="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $photo; ?>"> 
							<img class="img_e" id="blah_photo" src="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $photo; ?>" title="<?php echo $name;?>" /></a> 
							<!-- <img class="img-fluid  " id="blah_photo" src="https://registration.gjepc.org/images/employee_directory/<?php echo $registration_id; ?>/photo/<?php echo $photo; ?>" alt="your image" style="display: block;"/> -->
						</div>
				
					</div>
	
				</div>
   
    		<?php } ?>

			<!-- <div class="leftFile">
				<div class="midTitle">Please browse to attach your photograph : <sup>*</sup> </div>
				<p><strong>Filename</strong></p>
				 <input name="photograph_fid" id="photograph_fid" type="file" class="input_txt" style="margin-bottom:10px; background:#fff;" />
				
			</div> -->
         
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
		 <div class="fancyDemo"> <a rel="group" href="http://registration.gjepc.org/images/ivr_image/passport/<?php echo $passport_fid;?>"><img src='http://registration.gjepc.org/images/ivr_image/passport/<?php echo $passport_fid;?>' width='100' height='100' /></a></div>
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
		 <div class="fancyDemo"><a rel="group" href="http://registration.gjepc.org/images/ivr_image/visiting_card/<?php echo $visit_card_fid;?>"><a rel="group" href="http://registration.gjepc.org/images/ivr_image/visiting_card/<?php echo $visit_card_fid;?>"><img src='http://registration.gjepc.org/images/ivr_image/visiting_card/<?php echo $visit_card_fid;?>' width='100' height='100' /></a></div>
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
       // ==============================XXXXXXXXXXXXXXXXXXXXXXXXXXXX CROPPING & PREVIEW END XXXXXXXXXXXXXXXXXXXXXXXXXXXXX========//
</script>
</body>
</html>
