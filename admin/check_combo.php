<?php 
session_start(); 
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit;}
include('../db.inc.php');
include('../functions.php');
?>
<?php
$adminID=$_SESSION['curruser_login_id'];
if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{	
	$email_id=addslashes($_REQUEST['email']);
	$id=$_REQUEST['id'];

	$approval=addslashes($_REQUEST['approval']);
	$disapprove_reason=addslashes($_REQUEST['disapprove_reason']);
	$card_type=addslashes($_REQUEST['card_type']);
	$holder_name=addslashes($_REQUEST['holder_name']);
	$card_number=addslashes($_REQUEST['card_number']);
	$expiry_month=addslashes($_REQUEST['expiry_month']);
	$expiry_year=addslashes($_REQUEST['expiry_year']);
	
		 if($approval == "Y"){ $disapprove_reason = ""; }
	else if($approval == "P"){ $disapprove_reason = ""; }
	else if($approval == "C"){ $disapprove_reason = ""; }
	else{$approval = "D";}
	
	$sqlx = "UPDATE `igjs_summit_registration` SET `modified_date`=NOW(), adminId='$adminID', `approval`='$approval', `disapprove_reason`='$disapprove_reason', `card_type`='$card_type', `holder_name`='$holder_name', `card_number`='$card_number', `expiry_month`='$expiry_month', `expiry_year`='$expiry_year' WHERE id='$id'";
	$resultx = mysql_query($sqlx);
	
if($resultx)
{	
		/*.......................Send mail For Approved........................*/
if($approval=='Y')
{
$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
       <td width="150" align="left"><img src="https://gjepc.org/images/gjepc_logo.png" width="150" height="120" /></td>
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>PARTICIPANT PRE-REGISTRATION APPLICATION FOR THE India Gold Jewellery Summit 2018</u></strong></td></tr>
		
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table width="100%" style="font-family: Arial, sans-serif; background-color: rgb(251, 251, 251);">
	<tbody>
	<tr>
	<td align="left" style="text-align: justify;">
	Your Participation Application form for  <strong> THE India Gold Jewellery Summit 2018 </strong> has been Approved.</td>
	</tr>
	<tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
	</tbody>
	</table>	
    </tr>
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <p>
                <b>The Gem &amp; Jewellery Export Promotion Council</b><br>
                Unit G2-A, Trade Center, Opp. BKC Telephone Exchange, Bandra Kurla Complex, Bandra (E) Mumbai 400 051 <br> Tel + 9122 43541800 Fax +9122 26524769 <br> Website: <a href="http://www.gjepc.org/">http://www.gjepc.org/</a>
            </p>
        </td>
    </tr>       
</tbody>
</table>';

	$to =$email_id;	
	$subject = "YOUR APPLICATION FOR THE India Gold Jewellery Summit 2018 Approved"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .= 'From:admin@gjepc.org';			
	mail($to, $subject, $message, $headers);
}
else if($approval=='D') //Send mail For DisApproved
{
$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
        <td width="150" align="left"><img src="https://gjepc.org/images/gjepc_logo.png" width="150" height="120" /></td>
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>PARTICIPANT PRE-REGISTRATION APPLICATION FOR THE India Gold Jewellery Summit 2018</u></strong></td></tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table width="100%" style="font-family: Arial, sans-serif; background-color: rgb(251, 251, 251);">
	<tbody>
	<tr>
	<td align="left" style="text-align: justify;">
	Your Participation Application form for <strong> THE India Gold Jewellery Summit 2018 </strong> has been Disapproved.</td>
	</tr>
	<tr>
	<td colspan="2"><br/>
	<strong>Reason :</strong> '.$disapprove_reason.'.</td>
	</tr>
	<tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
	</tbody>
	</table>	
    </tr>
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <p>
                <b>The Gem &amp; Jewellery Export Promotion Council</b><br>
                Unit G2-A, Trade Center, Opp. BKC Telephone Exchange, Bandra Kurla Complex, Bandra (E) Mumbai 400 051 <br> Tel + 9122 43541800 Fax +9122 26524769 <br> Website: <a href="http://www.gjepc.org/">http://www.gjepc.org/</a>
            </p>
        </td>
    </tr>       
</tbody>
</table>';

	$to =$email_id;
	$subject = "YOUR APPLICATION FOR THE India Gold Jewellery Summit 2018 Disapproved"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .= 'From:admin@gjepc.org';			
	mail($to, $subject, $message, $headers);
}
else if($approval=='C') //Send mail For Cancellation
{
$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
        <td width="150" align="left"><img src="https://gjepc.org/images/gjepc_logo.png" width="150" height="120" /></td>
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>PARTICIPANT PRE-REGISTRATION APPLICATION FOR THE India Gold Jewellery Summit 2018</u></strong></td></tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table width="100%" style="font-family: Arial, sans-serif; background-color: rgb(251, 251, 251);">
	<tbody>
	<tr>
	<td align="left" style="text-align: justify;">
	Your Participation Application form for <strong> THE India Gold Jewellery Summit 2018 </strong> has been Cancelled.</td>
	</tr>
	<tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
	</tbody>
	</table>	
    </tr>
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <p>
                <b>The Gem &amp; Jewellery Export Promotion Council</b><br>
                Unit G2-A, Trade Center, Opp. BKC Telephone Exchange, Bandra Kurla Complex, Bandra (E) Mumbai 400 051 <br> Tel + 9122 43541800 Fax +9122 26524769 <br> Website: <a href="http://www.gjepc.org/">http://www.gjepc.org/</a>
            </p>
        </td>
    </tr>       
</tbody>
</table>';

	$to =$email_id;
	$subject = "YOUR APPLICATION FOR THE India Gold Jewellery Summit 2018 Canceled"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .= 'From:admin@gjepc.org';			
	mail($to, $subject, $message, $headers);
}
/***  Emailer End **/
echo"<meta http-equiv=refresh content=\"0;url=igjs.php?action=view\">";
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage COMBO ||GJEPC||</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage COMBO Registration</div>
</div>

<div id="main">
	<div class="content">
	<div class="content_details1"><a href="employee_directory.php?action=view">BACK </a>
   <table width="100%" border="0" cellspacing="5" cellpadding="5"  >
     <tr class="orange1">
       <td colspan="8">COMBO Details </td>
     </tr>
	 <tr class="orange1">
    <td>Name</td>
	<td>Email</td>
	<td>Designation</td>
	<td>Mobile</td>
    <td>Pan</td>
    <td>Photo</td>
	</tr>
<?php 
if(($_REQUEST['regid']!=''))
{
		$sqlx= "SELECT * FROM `visitor_directory` WHERE `visitor_approval`='O' AND registration_id='$_REQUEST[regid]'";
		$result2 = mysql_query($sqlx);
		$countx = mysql_num_rows($result2);
		if($countx>0){
		while($row2 = mysql_fetch_array($result2))
		{			
			$post_date=stripslashes($row2['post_date']);
			$degn_type=stripslashes($row2['degn_type']);
			$gender=stripslashes($row2['gender']);
			$name=stripslashes($row2['name']);
			$mobile=stripslashes($row2['mobile']);
			$email=stripslashes($row2['email']);
			$aadhar_no=stripslashes($row2['aadhar_no']);
			$designation=stripslashes($row2['designation']);
			$pan_no=stripslashes($row2['pan_no']);
			$photo=stripslashes($row2['photo']);
			$salary_slip_copy=stripslashes($row2['salary_slip_copy']);
			$pan_copy=stripslashes($row2['pan_copy']);
			$partner=stripslashes($row2['partner']);
			$approval=stripslashes($row2['visitor_approval']);
			$disapprove_reason=stripslashes($row2['disapprove_reason']);
			
			if($gender == "M"){
			$gen = "Male"; }
			elseif($gender == "F"){
			$gen = "Female"; }
			else{
			$gen = "Trans-Gender"; }		
		?>
		<tr>
       <td class="text6"><?php echo $name;?></td>
       <td class="text6"><?php echo $email;?></td>
       <td class="text6"><?php echo getVisitorDesignation($row2['designation']); ?></td>
       <td class="text6"><?php echo $mobile; ?></td>
       <td class="text6"><?php echo $pan_no;?></td>
	   <td>
		<div class="fancyDemo"> <a rel="group" href="https://iijs-signature.org/images/employee_directory/oldphoto/<?php echo $photo; ?>">
		<img src='https://iijs-signature.org/images/employee_directory/oldphoto/<?php echo $photo; ?>' width='100' height='100' /></a></div>
        </td>
       </tr>
		<?php }
		} else { echo 'not found';}
?>
   
     <!--<tr>
       <td class="content_txt">Company Name </td>
       <td class="text6"><?php echo $company; ?></td>
     </tr> --> 
   </table>
 </div>
 <?php 
} 
?>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>