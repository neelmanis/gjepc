<?php session_start(); ob_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
$action=$_REQUEST['action'];
if($action=='UPDATE')
{
	$id=mysql_real_escape_string($_REQUEST['id']);
	$registration_id=mysql_real_escape_string($_REQUEST['registration_id']);
	
	//------------------------------------  Update Photo Image ----------------------------------------------------
		$photo_image = '';
		$target_folder = 'C:/xampp/htdocs_vhosts/iijs/images/pvr_image/photo/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if($_FILES['photo_image']['name'] != '')
		{
		  //Unlink the previuos image
		   $qpreviousimg=mysql_query("select photo_image from pvr_registration_details where id='$id'");
		   $rpreviousimg=mysql_fetch_array($qpreviousimg);
		   $filename="C:/xampp/htdocs_vhosts/iijs/images/pvr_image/photo/".$rpreviousimg['photo_image'];
		   unlink($filename);

			
			$target_path = $target_folder.$temp_code.'_'.$_FILES['photo_image']['name'];
			if(@move_uploaded_file($_FILES['photo_image']['tmp_name'], $target_path))
			{
				$photo_image = $temp_code.'_'.$_FILES['photo_image']['name'];
				$sql="update pvr_registration_details set photo_image='$photo_image',photo_approval='P',photo_reson='' where id='$id'";
				$result=mysql_query($sql);
			}
			else
			{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this photo.\");location.href='change_photo_form_pvr.php?id=$id&registration_id=$registration_id';</script>";
				return;
			}
			
		}	
		
		
		//------------------------------------  Update ID proof ----------------------------------------------------
		$id_proof = '';
		$target_folder = 'C:/xampp/htdocs_vhosts/iijs/images/pvr_image/passport/';
		$path_parts = "";
		$ext="";
		$target_path = "";
		$filetoupload="";
		$temp_code = rand();
		if($_FILES['id_proof']['name'] != '')
		{
		  //Unlink the previuos image
		   $qpreviousimg=mysql_query("select id_proof from pvr_registration_details where id='$id'");
		   $rpreviousimg=mysql_fetch_array($qpreviousimg);
		   $filename="C:/xampp/htdocs_vhosts/iijs/images/pvr_image/passport/".$rpreviousimg['id_proof'];
		   unlink($filename);

			
			$target_path = $target_folder.$temp_code.'_'.$_FILES['id_proof']['name'];
			if(@move_uploaded_file($_FILES['id_proof']['tmp_name'], $target_path))
			{
				$id_proof = $temp_code.'_'.$_FILES['id_proof']['name'];
				$sql="update pvr_registration_details set id_proof='$id_proof',identy_proof_approval='P',identy_proof_reson='' where id='$id'";
				$result=mysql_query($sql);
			}
			else
			{
				echo "<script langauge=\"javascript\">alert(\"Sorry you can not upload this photo.\");location.href='change_photo_form_pvr.php?id=$id&registration_id=$registration_id';</script>";
				return;
			}
			
		}
	
		$photo_approval=mysql_real_escape_string($_REQUEST['photo_approval']);
		if($photo_approval=='Y')
		{
		$photo_reson="";
		}else
		{
		$photo_reson=mysql_real_escape_string($_REQUEST['photo_reson']);
		}
		
		$identy_proof_approval=mysql_real_escape_string($_REQUEST['identy_proof_approval']);
		if($identy_proof_approval=='Y')
		{
		$identy_proof_reson="";
		}else
		{
		$identy_proof_reson=mysql_real_escape_string($_REQUEST['identy_proof_reson']);
		}
		
		$updatequery="update pvr_registration_details set photo_approval='".$photo_approval."',photo_reson='".$photo_reson."',identy_proof_approval='".$identy_proof_approval."',identy_proof_reson='".$identy_proof_reson."',modified_dt=NOW() where id='$id' and uid='$registration_id'"; 

		$update_result = mysql_query($updatequery);
		if(!$update_result){
		echo "Error: ".mysql_error();	
		}
		
		$sql1="SELECT * FROM `pvr_registration_details` WHERE 1 and id='$id' and uid='$registration_id'";
	$result1=mysql_query($sql1);
	$rows1=mysql_fetch_array($result1);
	$email_id=$rows1['email'];
	$information_approve=$rows1['information_approve'];
	$payment_approve=$rows1['payment_approve'];
	
	if($photo_approval=='Y' && $identy_proof_approval=='Y' && $information_approve=='Y' && $payment_approve=='Y')
	{
	//echo '--->'.$photo_approval.''.$identy_proof_approval.''.$information_approve.''.$payment_approve; 
	
	$message ='<table width="800px;" bgcolor="#fbfbfb" style="margin: 0px auto;padding: 10px;border-radius: 10px; border:solid 1px #ddd; box-shadow: 10px 11px 28px -11px rgba(0,0,0,0.75);" >
	
	<tr>
	<td style="padding:30px;">
	
	<table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
	
	<tr>
	<td align="left"> <img src="http://www.gjepc.org/emailer_gjepc/Mailer/logos/iijs.png" width="190px"> </td>
		<td align="center"> <img src="http://www.gjepc.org/emailer_gjepc/Mailer/logos/signature.png" width=""> </td>
		<td align="right"> <img src="http://www.gjepc.org/emailer_gjepc/Mailer/logos/igjme.png" width="190px"> </td>
	</tr>
	
	<tr>
	<td> </td>
	<td align="right"></td>
	</tr>
	
	<tr>
	<td align="right" colspan="3" height="30px"><hr /></td>
	</tr>
	
	<tr>
	<td align="right" colspan="3" height="10px"></td>
	</tr>
	
	<tr>
	<td colspan="3" style="font-size:13px; line-height:22px;">
	
	<p> Dear '.$rows1['contact_person'].'</p>
	<p><strong>Greetings from The Gem & Jewellery Export Promotion Council</strong><p>
	
	<p>Your Application for the National Visitor Registration for IIJS 2016 has been approved by IIJS Team.<p>
	
	<p>Request you to kindly login to our website to download the acknowledgement receipt for future reference.Click here to login <a href= "http://iijs.org/pvr.php" target="_blank">http://iijs.org/pvr.php</a></p>
	
	<p>You can also check the status of your application at <a href= "http://iijs.org/pvr.php" target="_blank">http://iijs.org/pvr.php</a>. </p>
	<p>Following are your login credentials:</p>
	<p><strong>Name : </strong>'.$rows1['contact_person'].' </p>
	<p><strong>Email ID : </strong>'.getUserEmail($registration_id).'</p>	
	
	<p>Your Badge will be couriered to you by India Post. In-case, if you don\'t receive your badge by courier, then you can write to us at     <a data-cke-saved-href="visitors@iijs.org" href="mailto:visitors@iijs.org">visitors@iijs.org</a> or you can collect it from the venue by submitting the copy of the confirmation e-mail.</p>
	
	<!--<p>To avail exclusive hotel packages <a href="http://iijs.org/official_hotels.php" style="color:#751b53; text-decoration:none; font-weight:bold;" target="_blank">click here</a>.</p>-->
	<p>Warm Regards,<br />
	IIJS Team</p>
	</td>
	</tr>
	<tr>
		<td colspan="3" align="right" ><hr /></td>
	</tr>
	<tr>
		<td colspan="3"><img src="http://www.gjepc.org/emailer_gjepc/Mailer/logos/foot.jpg"></td>
	</tr>
	</table>
	</td>
	</tr>
	
	</table>';
		
	$to =$rows1['email'];
	//$to='ninad.mundhe@gjepcindia.com';
	$subject = "IIJS 2016 : Your Information for National Visitor Registration has been approved by the Administrator"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .= 'From: IIJS 2016 <admin@gjepc.org>';			
	mail($to, $subject, $message, $headers);
	
	
	}else{
	
	if($rows1['information_approve']=='Y')
	{
	$info_status="Approved";
	}else if($rows1['information_approve']=='N')
	{
	$info_status="Disapproved";
	}else if($rows1['information_approve']=='P')
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
	
	if($rows1['identy_proof_approval']=='Y')
	{
	$passport_status="Approved";
	}else if($rows1['identy_proof_approval']=='N')
	{
	$passport_status="Disapproved";
	}else if($rows1['identy_proof_approval']=='P')
	{
	$passport_status="Pending";
	}
	
	if($rows1['payment_approve']=='Y')
	{
	$payment_status="Approved";
	}else if($rows1['payment_approve']=='N')
	{
	$payment_status="Disapproved";
	}else if($rows1['payment_approve']=='P')
	{
	$payment_status="Pending";
	}
	
	/*$sqlx="update `pvr_registration_details` set application_approved='N' WHERE 1 and id='$id' and uid='$registration_id'";	
	$result=mysql_query($sqlx);*/

 $message ='<table width="800px;" bgcolor="#fbfbfb" style="margin: 0px auto;padding: 10px;border-radius: 10px; border:solid 1px #ddd; box-shadow: 10px 11px 28px -11px rgba(0,0,0,0.75);" >

<tr>
<td style="padding:30px;">

    <table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
    
	<tr>
   	<td align="left"> <img src="http://www.gjepc.org/emailer_gjepc/Mailer/logos/iijs.png" width="190px"> </td>
		<td align="center"> <img src="http://www.gjepc.org/emailer_gjepc/Mailer/logos/signature.png" width=""> </td>
		<td align="right"> <img src="http://www.gjepc.org/emailer_gjepc/Mailer/logos/igjme.png" width="190px"> </td>
    </tr>
    
    <tr>
    <td> </td>
    <td align="right"></td>
    </tr>
    <tr>
    <td align="right" colspan="3" height="30px"><hr /></td>
    </tr>

	<tr>
    <td align="right" colspan="3" height="10px"></td>
    </tr>
    
    <tr>
    <td colspan="3" style="font-size:13px; line-height:22px;">
    
   <p> Dear '.$rows1['contact_person'].',</p>

<p>The below details of your National Visitor Registration form have been disapproved for IIJS 2016 by the IIJS team.</p>

<table width="500" border="0" cellspacing="0" cellpadding="0" >
  <tr style="height:20px; border:1px solid  #FF0000; background:#751b53; color:#FFFFFF;">
    <td style="border:1px solid  #cccccc; padding:5px;" ><strong>Details</strong></td>
    <td style="border:1px solid  #cccccc; padding:5px;"><strong>Status</strong></td>
    <td style="border:1px solid  #cccccc; padding:5px;"><strong>Reason for  Disapproval </strong></td>
  </tr>
  <tr style="height:20px; border:1px solid  #FF0000;">
    <td style="border:1px solid  #cccccc; padding:5px;" >Personal Information</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$info_status.'</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$rows1['information_reason'].' </td>
  </tr>
  <tr style="height:20px; border:1px solid  #FF0000;">
    <td style="border:1px solid  #cccccc; padding:5px;" >ID Proof</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$photo_status.'</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$rows1['photo_reson'].'</td>
  </tr>
  <tr style="height:20px; border:1px solid  #FF0000;">
    <td style="border:1px solid  #cccccc; padding:5px;" >Passport Copy</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$passport_status.'</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$rows1['identy_proof_reson'].'</td>
  </tr>
  <tr style="height:20px; border:1px solid  #FF0000;">
    <td style="border:1px solid  #cccccc; padding:5px;" >Payment </td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$payment_status.'</td>
    <td style="border:1px solid  #cccccc; padding:5px;">'.$rows1['payment_reason'].'</td>
  </tr>
</table>


<p>Request you to kindly login to our website and update your disapproved details. </p>
	<p>Following are your login credentials:</p>
	<p><strong>Name : </strong>'.$rows1['contact_person'].'</p>
	<p><strong>Email ID : </strong>'.getUserEmail($registration_id).'</p>
<p>Please <a href="http://iijs.org/login.php" style="color:#751b53; text-decoration:none; font-weight:bold;" target="_blank">click here</a> to login to iijs.org.</p>


<p>In case, If  you have forgotten your password, <a href="http://iijs.org/forgot_password.php" style="color:#751b53; text-decoration:none; font-weight:bold;" target="_blank">click here</a>.</p>


<!--<p>To avail exclusive hotel packages <a href="http://iijs.org/official_hotels.php" style="color:#751b53; text-decoration:none; font-weight:bold;" target="_blank">click here</a>.</p>-->
<p>Warm Regards,<br />
IIJS Team</p>
    </td>
    </tr>
	<tr>
		<td colspan="3" align="right" ><hr /></td>
	</tr>
	<tr>
		<td colspan="3"><img src="http://www.gjepc.org/emailer_gjepc/Mailer/logos/foot.jpg"></td>
	</tr>
   </table>
</td>
</tr>

</table>';
		
	$to =$rows1['email'];
	//$to='ninad.mundhe@gjepcindia.com';
	 $subject = "Your National Visitor Registration Application Status"; 
	 $headers  = 'MIME-Version: 1.0' . "\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	 $headers .= 'From: IIJS 2016 <admin@gjepc.org>';			
	 //mail($to, $subject, $message, $headers);
	}
		
$_SESSION['succ_msg']="Application updated successfully";
header("Location:iijs_pvr.php?id=$id&registration_id=$registration_id");

}

?>


<?php
$purl="http://iijs.org/";
$id=mysql_real_escape_string($_REQUEST['id']);
$registration_id=mysql_real_escape_string($_REQUEST['registration_id']);
	$sql="SELECT * FROM `pvr_registration_details` WHERE 1 and id='$id' and uid='$registration_id'";
	$result=mysql_query($sql);
	$rows=mysql_fetch_array($result);
	
	$photo_image=$rows['photo_image'];
	$id_proof=$rows['id_proof'];
	$photo_approval=$rows['photo_approval'];
	$photo_reson=$rows['photo_reson'];
	$identy_proof_approval=$rows['identy_proof_approval'];
	$identy_proof_reson=$rows['identy_proof_reson'];

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS &gt; PVR &gt;&gt; Change Photo</title>
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
function check_disable(){
    if ($('input[name=\'photo_approval\']:checked').val() == "N"){
        $("#photo_reason_text").show();
    }
    else{
        $("#photo_reason_text").hide();
    }	
}
function check_disable2(){
    if ($('input[name=\'identy_proof_approval\']:checked').val() == "N"){
        $("#identy_proof_text").show();
    }
    else{
        $("#identy_proof_text").hide();
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
	<div class="breadcome"><a href="admin.php">Home</a> > PVR > Change Photo</div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head">PVR > Change Photo
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_pvr.php">Back to Search</a></div>
        </div>
    	
		<div class="clear"></div>
<div class="content_details1">

<form name="search" action="" method="post" enctype="multipart/form-data" > 
<div id="formAdmin">

<div id="formContainer">
<div id="form">
    <ul id="tabs" class="tab_1">
    <li id=""><a href="#"><strong>Step 1 Information</strong></a></li>
    <li id=""><a href="#"><strong>Step 2 OBMP Info</strong></a></li>  
    <li id=""><a href="#"><strong>Step 3 Payment</strong></a></li>
    <li id=""><a href="#"  class="lastBg active"><strong>Step 4 Photo</strong></a></li>   
    <div class="clear"></div>
</ul>
<div class="clear bottomSpace"></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt pvr bottomSpace" >
<tr class="orange1">
    <td colspan="11">Photograph</td>
</tr>

<tr>
    <td colspan="11" >
    <div class="field bottomSpace">
         <div class="userPic">
         <?php 
		 if($photo_image=="")
		 {
		    echo "<img src='images/user_pic.jpg' width='100' height='100' />";
		 }else
		 {
		 ?>
		  <div class="fancyDemo"> <a rel="group" href="<?php echo $purl; ?>images/pvr_image/<?php echo $photo_image;?>"><img src='<?php echo $purl; ?>images/pvr_image/photo/<?php echo $photo_image;?>' width='100' height='100' /></a></div>
		 <?php
         }
		 ?>
         </div>
         <div class="leftFile">
             <div class="midTitle">Please browse to attach your photograph : <sup>*</sup> </div>
             <p><strong>Filename</strong></p>
             <input name="photo_image" type="file" class="textField" id="photo_image" style="margin-bottom:10px; background:#fff;" />
		 </div>
         
         <div class="rightFile">
             <div class="midTitle"><strong>Photo Approval </strong></div>
             <p><input type="radio" name="photo_approval" id="photo_approval" value="Y" onchange="check_disable()" <?php if($photo_approval=="Y"){?> checked="checked" <?php }?> /> Approved
                <input type="radio" name="photo_approval" id="photo_approval" value="N" onchange="check_disable()"  <?php if($photo_approval=="N"){?> checked="checked" <?php }?> /> Dispproved
             </p>
             <p id="photo_reason_text" <?php if($photo_approval=="Y"){?> style="display:none;" <?php }?>>
             <textarea name="photo_reson" cols="40" rows="6" id="photo_reson"  ><?php echo $photo_reson;?></textarea>
		 	 </p>
		 </div>
         
            <div class="clear"></div>
	        <div class="note">Note: Kindly upload passport size colour photograph. (Maximum upload file size is 2 MB)</div>
            <div class="clear"></div>
            </div>

    <div class="field bottomSpace">
         <div class="userPic">
          <?php 
			 if($id_proof=="")
			 {
				echo "<img src='images/user_pic.jpg' width='100' height='100' />";
			 }else
			 {
			 ?>
			<div class="fancyDemo"> <a rel="group" href="<?php echo $purl; ?>images/pvr_image/passport/<?php echo $id_proof;?>"><img src='<?php echo $purl; ?>images/pvr_image/passport/<?php echo $id_proof;?>' width='100' height='100' /></a></div>
			 <?php
			 }
			 ?>
		 
         </div>
         <div class="leftFile">
             <div class="midTitle">Please browse to attach your identity proof : <sup>*</sup> </div>
             <p><strong>Filename</strong></p>
             <input name="id_proof" type="file" id="id_proof" class="textField" style="margin-bottom:10px; background:#fff;" />
		</div>
        <div class="rightFile">
             <div class="midTitle"><strong>Identity Proof Approval </strong></div>
             <p><input type="radio" name="identy_proof_approval" id="identy_proof_approval" value="Y" onchange="check_disable2()" <?php if($identy_proof_approval=="Y"){?> checked="checked" <?php }?> /> Approved
                <input type="radio" name="identy_proof_approval" id="identy_proof_approval" value="N" onchange="check_disable2()"  <?php if($identy_proof_approval=="N"){?> checked="checked" <?php }?> /> Dispproved
             </p>
             <p id="identy_proof_text" <?php if($photo_approval=="Y"){?> style="display:none;" <?php }?>>
             <textarea name="identy_proof_reson" cols="40" rows="6" id="identy_proof_reson"  ><?php echo $identy_proof_reson;?></textarea>
		 	 </p>
		 </div>
        	<div class="clear"></div>
	        <div class="note">Note: You can upload pan card,passport,driving license etc. For any queries contact exhibitions@gjepcindia.com (Maximum upload file size is 2 MB)</div>
              <div class="clear"></div>
              <div class="clear"></div>
         </div>
    
    <!--<div class="field bottomSpace">
    <label><strong>Application Approval Status :</strong> </label>
    
    <input type="radio" name="approval" id="approval" value="Y" onchange="check_disable()" <?php if($approval=="Y"){?> checked="checked" <?php }?> /> Approve 
    <input type="radio" name="approval" id="approval" value="N" onchange="check_disable()"  <?php if($approval=="N"){?> checked="checked" <?php }?> /> Disapprove
    <p id="admin_comment_text" <?php if($approval=="Y"){?> style="display:none;" <?php }?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <textarea name="admin_comment" cols="40" rows="6" id="admin_comment"  ><?php echo $admin_comment;?></textarea>
    </p>

	</div>-->
    </td>
</tr>
</table>


</div>
</div>
<div style="padding-left:250px; margin-top:5px;">
<input type="hidden" name="action" id="action" value="UPDATE" />
<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
<input type="hidden" name="registration_id" id="registration_id" value="<?php echo $registration_id;?>" />    	
<input type="submit" value="Submit" class="input_submit"/>
<!--<a href="iijs_participation_&_payment_details_pvr.php?id=<?php //echo $id;?>&registration_id=<?php //echo $registration_id;?>">
<div class="button">Previous</div></a>
<a href="iijs_approval_form_pvr.php?id=<?php //echo $id;?>&registration_id=<?php //echo $registration_id;?>">
<div class="button">Next</div></a>
--></div>
</div>
</form>      
</div>

</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
