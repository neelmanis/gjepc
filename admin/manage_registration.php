<?php 
session_start();
if(!isset($_SESSION['curruser_contact_name'])){ header('Location: index.php'); exit; } 
if(!isset($_SESSION['curruser_login_id'])){	header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
$adminID = intval(filter($_SESSION['curruser_login_id']));
?>
<?php /*
if(($_REQUEST['action']=='ResetPass') && ($_REQUEST['id']!=''))
{
	$sql = "select * from registration_master where id='".$_REQUEST['id']."'" ;  
	$query = $conn ->query($sql);
	$result =  $result->fetch_assoc();
	$email_id = filter($result['email_id']);
	$password = filter($result['company_secret']);
	$first_name = filter($result['first_name']);
	$last_name  = filter($result['last_name']);
	
	$num = $query->num_rows;;
	if($num>0){
	
   $message ='<table cellpadding="10" width="65%" style="margin:0px auto;font-family: Roboto; background-color:#eeee;padding:30px; border-collapse:collapse;">
  <tr><td style="background-color:#744F9E;padding:3px;"></td></tr>
  <tr><td align="left"><img src="https://www.gjepc.org/images/gjepc_logo.png"></td></tr>
  <tr style="background-color:#eeee;padding:30px;">
  <td><h4 style="margin:0;">Your Password. </h4></td></tr>
  <tr style="background-color:#eeee;padding:30px; padding-bottom:0; padding-top:0;"><td style="padding-bottom:0; padding-top:0;"><strong>User Name :</strong> '. $email_id .'</td></tr>
  <tr style="background-color:#eeee;padding:30px; padding-bottom:0; padding-top:0;"><td style="padding-bottom:0; padding-top:0;"><strong>Password  :</strong> '. $password .'</td></tr>
   <tr><td>       
      <p>Kind Regards,<br>
      <b>GJEPC Web Team,</b>
      </p>
    </td>
  </tr>
</table>';
	
	$to =$email_id;
	$subject = "Password of GJEPC Member"; 
	$headers  = 'MIME-Version: 1.0'."\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1'."\n"; 
	$headers .= 'From: admin@gjepc.org';			
    @mail($to, $subject, $message, $headers);

	$_SESSION['succ_msg']="Your password has been sent";
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_registration.php?action=view\">";
} */

if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql = "delete from registration_master where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("i", $_REQUEST['id']);
	if($stmt->execute()) {
	echo "<meta http-equiv=refresh content=\"0;url=manage_registration.php?action=view\">";
	} else {
	die ("Mysql Delete Error: " . $conn->error);
	}
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter(intval($_REQUEST['id']));
	$sql="update registration_master set status=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("si", $status,$id);
	if($stmt->execute()) {
	echo"<meta http-equiv=refresh content=\"0;url=manage_registration.php?action=view\">";
	} else {
	die ("Mysql Update Error: " . $conn->error);
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$email_id=filter($_REQUEST['email_id']);
	$company_pan_no=filter($_REQUEST['company_pan_no']);
	$company_name=filter($_REQUEST['company_name']);
	$password=filter($_REQUEST['password']);	
	$city=filter($_REQUEST['city']);
	$state=filter($_REQUEST['state']);
	$pin_code=filter($_REQUEST['pin_code']);	
	
	$id=$_REQUEST['id'];	
	$payment_defaulter=filter($_REQUEST['payment_defaulter']);
	if($payment_defaulter=='Y')
	{
	$payment_defaulter_reason=filter($_REQUEST['payment_defaulter_reason']);
	}else
	{
	$payment_defaulter_reason="";
	}
	if(isset($payment_defaulter)){
	$sqlxy="INSERT INTO outstanding_log (post_date,admin_id,registration_id,payment_defaulter) VALUES (NOW(),'$adminID','$id','$payment_defaulter')";
	$result = $conn ->query($sqlxy);
	}
	$sql.="select * from registration_master where (company_pan_no='$company_pan_no' || email_id='$email_id')";	
	$result = $conn ->query($sql);
	$row = $result->fetch_assoc();
    $num=$result->num_rows;;
	if($num>0)
	{
		echo '<script language="javascript">';
		echo 'alert("Pan no or Email id is not Updated because already exists and other information has been updated")';
		echo '</script>';
		
		if($row['company_pan_no']!=$company_pan_no)
		$sql = $conn ->query("update registration_master set company_name='$company_name',company_pan_no='$company_pan_no',payment_defaulter='$payment_defaulter',payment_defaulter_reason='$payment_defaulter_reason' where id='$id'");
		elseif($row['email_id']!=$email_id)
		$sql = $conn ->query("update registration_master set company_name='$company_name',email_id='$email_id',payment_defaulter='$payment_defaulter',payment_defaulter_reason='$payment_defaulter_reason' where id='$id'");
		if(!$sql) die ($conn->error);
		 
	$sql = $conn ->query("update registration_master set company_name='$company_name',city='$city',state='$state',pin_code='$pin_code',payment_defaulter='$payment_defaulter',payment_defaulter_reason='$payment_defaulter_reason' where id='$id'");
	echo"<meta http-equiv=refresh content=\"0;url=manage_registration.php?action=view\">";
	exit;
	} else {	
	$sql = $conn ->query("update registration_master set company_name='$company_name',email_id='$email_id',company_pan_no='$company_pan_no',city='$city',state='$state',pin_code='$pin_code',payment_defaulter='$payment_defaulter',payment_defaulter_reason='$payment_defaulter_reason' where id='$id'");
	if(!$sql) die ($conn->error);
		
	$sql = $conn ->query("update information_master set email_id='$email_id' where registration_id='$id'");
	echo"<meta http-equiv=refresh content=\"0;url=manage_registration.php?action=view\">";
	exit;
	}
}
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['name']="";
  $_SESSION['company_name']="";
  $_SESSION['email_id']="";
  $_SESSION['gcode']="";
  $_SESSION['pvrcode']="";
  $_SESSION['company_pan_no']="";
  
  header("Location: manage_registration.php?action=view");
}else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
		$_SESSION['name']=filter($_REQUEST['name']);
		$_SESSION['company_name']=filter($_REQUEST['company_name']);
		$_SESSION['email_id']=filter($_REQUEST['email_id']);
		$_SESSION['gcode']=filter($_REQUEST['gcode']);
		$_SESSION['company_pan_no']=filter($_REQUEST['company_pan_no']);
	}
}
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Registration ||GJEPC||</title>
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
<!--navigation end-->

<script language="javascript">
function checkdata()
{
	if(document.getElementById('contact_name').value == '')
	{
		alert("Please Enter Name");
		document.getElementById('contact_name').focus();
		return false;
	}
	
	if(document.getElementById('mobile_no').value == '')
	{
		alert("Please Enter Mobile No.");
		document.getElementById('mobile_no').focus();
		return false;
	}
	if(!IsNumeric(document.getElementById('mobile_no').value))
	{
		alert("Please enter valid Mobile No.")
		document.getElementById('mobile_no').focus();
		return false;
	}
	if(document.getElementById('mobile_no').value.length < 10)
	{
		alert("Please enter 10 digit Mobile No.");
		document.getElementById('mobile_no').focus();
		return false;
	}

	if(document.getElementById('email_id').value == '')
	{
		alert("Please enter Email ID.");
		document.getElementById('email_id').focus();
		return false;
	}
	if(echeck(document.getElementById('email_id').value)==false)
	{
		document.getElementById('email_id').focus();
		return false;
	}
	if(document.getElementById('password').value == '')
	{
		alert("Please Enter Password");
		document.getElementById('password').focus();
		return false;
	}
	if(document.getElementById('password').value.length < 5)
	{
		alert("password must be at least 5 characters long");
		document.getElementById('password').focus();
		return false;
	}
	if(document.getElementById('role').value == '')
	{
		alert("Please Select Role");
		document.getElementById('role').focus();
		return false;
	}
	if(document.getElementById('region_id').value == '')
	{
		alert("Please Select Region");
		document.getElementById('region_id').focus();
		return false;
	}		
}

function echeck(str) 
{
	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	if (str.indexOf(at)==-1){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		alert("Invalid E-mail ID")
		return false
	}
	 if (str.indexOf(at,(lat+1))!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(dot,(lat+2))==-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(" ")!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 return true					
}

function IsNumeric(strString)
{
   var strValidChars = "0123456789,\. /-";
   var strChar;
   var blnResult = true;

   //if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
   {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
			blnResult = false;
         }
   }
   return blnResult;
}

</script>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div></div>
<div class="clear"></div>

<div class="breadcome_wrap"><div class="breadcome"><a href="#">Home</a> > Manage Registration</div></div>

<div id="main">
	<div class="content">
    	<div class="content_head">Manage Registration
        <?php if($_REQUEST['action']=='view_details'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="manage_registration.php?action=view">Back to Registration</a></div>
        <?php }?>
        <!--<a href="export_member_list.php">Export Member List</a>-->
        </div>
<div class="content_details1">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1"><td colspan="11">Search Options</td></tr>
<tr>
    <td width="19%" ><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" /></td>
</tr>     
<tr >
  <td><strong>Name</strong></td>
  <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $_SESSION['name'];?>" /></td>
</tr>
<tr >
  <td><strong>Email ID</strong></td>
  <td><input type="text" name="email_id" id="email_id" class="input_txt" value="<?php echo $_SESSION['email_id'];?>" /></td>
</tr>
<!--<tr>
  <td><strong>GCode</strong></td>
  <td><input type="text" name="gcode" id="gcode" class="input_txt" value="<?php echo $_SESSION['gcode'];?>" /></td>
</tr>-->
<tr >
  <td><strong>Pan No.</strong></td>
  <td><input type="text" name="company_pan_no" id="company_pan_no" class="input_txt" value="<?php echo $_SESSION['company_pan_no'];?>" /></td>
</tr>
<tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> 
	<input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td width="5%"><a href="#">Sr. No.</a></td>
        <td width="5%">BP No</td>
        <td width="25%">Company Name</td>
        <td width="25%">PAN No </td>
        <td width="25%">GSTIN No </td>
        <td width="15%">Email ID</td>
        <td width="10%">Password</td>
        <td width="10%">Date</td>
        <td colspan="4" width="10%">Action</td>
    </tr>
    
    <?php 
 	$page=1;//Default page
	$limit=50;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'registration_master.post_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
    //$sql="SELECT registration_master.id,registration_master.gcode,registration_master.email_id,registration_master.password,registration_master.company_name,registration_master.status,registration_master.post_date,registration_master.company_pan_no,information_master.iec_no FROM registration_master LEFT JOIN information_master ON registration_master.id=information_master.registration_id where registration_master.status=1";
    $sql="SELECT registration_master.id,registration_master.gcode,registration_master.email_id,registration_master.old_pass,registration_master.company_name,registration_master.status,registration_master.post_date,registration_master.company_pan_no,registration_master.company_gstn,information_master.iec_no FROM registration_master LEFT JOIN information_master ON registration_master.id=information_master.registration_id where 1";
	if($_SESSION['name']!="")
	{
	$sql.=" and registration_master.first_name like '%".$_SESSION['name']."%'";
	}
	
	if($_SESSION['company_name']!="")
	{
	$sql.=" and registration_master.company_name like '%".$_SESSION['company_name']."%'";
	}
	
	if($_SESSION['email_id']!="")
	{
	$sql.=" and registration_master.email_id like '%".$_SESSION['email_id']."%'";
	}

	/*if($_SESSION['gcode']!="")
	{
	$sql.=" and registration_master.gcode ='".$_SESSION['gcode']."'";
	}*/
	
	if($_SESSION['company_pan_no']!="")
	{
	$sql.=" and registration_master.company_pan_no ='".trim($_SESSION['company_pan_no'])."'";
	}
	
	$sql.= "  ".$attach." ";

	$result1 = $conn ->query($sql);
	$rCount  = $result1->num_rows;
	
	$sql1= $sql." limit $start, $limit ";
	$result = $conn ->query($sql1);
	
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{
    ?>
	 <?php 
	  $checkMember = CheckMembership($row['id'],$conn);
	  if($checkMember=="M")
	  {
		 $memberBP = getBPNO($row['id'],$conn);
	  } else {
		  $memberBP = getCompanyNonMemBPNO($row['id'],$conn);
	  }
	  ?>	
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $memberBP; ?></td>
        <td><?php echo strtoupper(str_replace('&amp;', '&', $row['company_name'])); ?></td>
        <td><?php echo strtoupper(filter($row['company_pan_no'])); ?></td>
        <td><?php echo strtoupper(filter($row['company_gstn'])); ?></td>
        <td align="left"><?php echo $row['email_id']; ?></td>
		<td align="left"><?php echo $row['old_pass']; ?></td>
  		<td align="left"><?php echo date("d-m-Y",strtotime($row['post_date'])); ?></td>	

        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_registration.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_registration.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } ?></td>
        
        <!--<td align="left"><a href="manage_registration.php?action=ResetPass&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to send password?'));"><img src="images/reset_password.png" title="Send Password" border="0" /></a></td>-->
        <td align="left"><a href="manage_registration.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/view.png" title="View" border="0" /></a></td>
        <td align="left"><a href="manage_registration.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.gif" title="Edit" border="0" /></a></td>
 	</tr>

	<?php
	$i++;
	   }
	 }
	 else
	 {
	 ?>
    <tr>
        <td colspan="10">Records Not Found</td>
    </tr>
    <?php  }  	?>
</table>
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
       
<div class="pages_1">Total number of Memberships: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'manage_registration.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = $conn ->query("SELECT * FROM registration_master where id='$_REQUEST[id]'");
		if($row2 = $result2->fetch_assoc())
		{			
			$company_name= strtoupper(str_replace('&amp;', '&', $row2['company_name']));;
			$email_id=filter($row2['email_id']);
			$company_pan_no=filter($row2['company_pan_no']);
			$password=filter($row2['password']);
			$city=filter($row2['city']);
			$state=filter($row2['state']);
			$pin_code=filter($row2['pin_code']);
			$payment_defaulter=$row2['payment_defaulter'];
			$payment_defaulter_reason=$row2['payment_defaulter_reason'];
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Edit Registration</td>
    </tr>
    <tr>
    <td class="content_txt">Company Name</td>
    <td><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $company_name; ?>" /></td>
    </tr>    
    <tr>
    <td class="content_txt">Company PAN no.</td>
    <td><input type="text" name="company_pan_no" id="company_pan_no" maxlength="10" class="input_txt" value="<?php echo $company_pan_no; ?>"/></td>
    </tr>
    
    <tr>
    <td class="content_txt">Email ID <span class="star">*</span></td>
    <td><input type="text" name="email_id" id="email_id" class="input_txt" value="<?php echo $email_id; ?>"  /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Password <span class="star">*</span></td>
    <td><input type="password" name="password" id="password" class="input_txt" value="<?php echo $password; ?>" /></td>
    </tr>
	
	<tr>
    <td class="content_txt">City </td>
    <td><input type="text" name="city" id="city" class="input_txt" value="<?php echo $city; ?>" /></td>
    </tr>
	
	<tr>
	  <td class="content_txt">State </td>
	  <td> <select name="state" id="state" class="input_txt_new">
		<option value="">-- Select State --</option>
		<?php 
		$query = $conn ->query("SELECT * from state_master WHERE country_code = 'IN'");
		while($result= $query->fetch_assoc()){ ?>
		<option value="<?php echo $result['state_code'];?>"  <?php if($result['state_code']==$state){?> selected="selected" <?php }?>><?php echo $result['state_name'];?></option>
		<?php }?>
	   </select>
	  </td>
	</tr>     
	<tr>
    <td class="content_txt">Pincode </td>
    <td><input type="text" name="pin_code" id="pin_code" class="input_txt" value="<?php echo $pin_code; ?>" maxlength='6' /></td>
    </tr>
	
    <tr>
      <td class="content_txt">Payment Defaulter </td>
      <td><input name="payment_defaulter" type="radio" value="Y" <?php if($payment_defaulter=='Y'){echo "checked='checked'";}?>/>Yes <input name="payment_defaulter" type="radio" value="N" <?php if($payment_defaulter=='N'){echo "checked='checked'";}?>/>No</td>
    </tr>
    <tr>
      <td class="content_txt">Payment Defaulter Reason</td>
      <td><textarea name="payment_defaulter_reason" cols="50" rows="5"><?php echo $payment_defaulter_reason;?></textarea></td>
    </tr>
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />    </td>
    </tr>
</table>
</form>
</div>       
<?php } ?>    
 
<?php 
if(($_REQUEST['id']!='') && ($_REQUEST['action']=='view_details'))
{
		$result2 = $conn ->query("SELECT *  FROM registration_master  where id='$_REQUEST[id]'");
		if($row2 = $result2->fetch_assoc())
		{		
			$email_id=stripslashes($row2['email_id']);
			$password=stripslashes($row2['password']);
			$designation=stripslashes($row2['designation']);
			$company_name=stripslashes($row2['company_name']);
			$address_line1=stripslashes($row2['address_line1']);
			$address_line2=stripslashes($row2['address_line2']);
			$address_line3=stripslashes($row2['address_line3']);
			$company_pan_no=stripslashes($row2['company_pan_no']);
			$company_gstn=stripslashes($row2['company_gstn']);
			$pan_no_copy=stripslashes($row2['pan_no_copy']);
			$gst_copy=stripslashes($row2['gst_copy']);
			$city=stripslashes($row2['city']);
			$pincode=stripslashes($row2['pin_code']);
			$country=stripslashes($row2['country']);
			$state=stripslashes(getState($row2['state'],$conn));
			$land_line_no=stripslashes($row2['land_line_no']);
			$mobile_no=stripslashes($row2['mobile_no']);
			$status=stripslashes($row2['status']);
			$post_date=stripslashes($row2['post_date']);
			$payment_defaulter=$row2['payment_defaulter'];
			$payment_defaulter_reason=$row2['payment_defaulter_reason'];
			
		}
?>
 <div class="content_details1">
   <table width="100%" border="0" cellspacing="5" cellpadding="5"  >
     <tr class="orange1">
       <td colspan="2">&nbsp;View Details</td>
     </tr>     
      <tr>
       <td class="content_txt">Company Name </td>
       <td class="text6"><?php echo $company_name; ?></td>
     </tr>

     <tr>
       <td class="content_txt">Email ID </td>
       <td class="text6"><?php echo $email_id; ?></td>
     </tr>
     
     <!--<tr>
       <td class="text6"><?php echo $row2['old_pass']; ?></td>
     </tr>-->
     <tr>
       <td class="content_txt">PAN </td>
       <td class="text6"><?php echo $company_pan_no; ?> &nbsp; &nbsp; <?php if($pan_no_copy!=''){?><a href="https://registration.gjepc.org/images/pan_no_copy/<?php echo $pan_no_copy;?>" target="_blank">View</a><?php }?></td>
     </tr>
     <tr>
       <td class="content_txt">GST</td>
       <td class="text6"><?php echo $company_gstn; ?>  &nbsp; &nbsp; <?php if($gst_copy!=''){?><a href="https://registration.gjepc.org/images/gst_copy/<?php echo $gst_copy;?>" target="_blank">View</a><?php }?></td>
     </tr> 
	 <tr>
       <td class="content_txt">Address Line1 </td>
       <td class="text6"><?php echo $address_line1; ?></td>
     </tr> 
     <tr>
       <td class="content_txt">Address Line2 </td>
       <td class="text6"><?php echo $address_line2; ?></td>
     </tr>     
     <tr>
       <td class="content_txt">Address Line3 </td>
       <td class="text6"><?php echo $address_line3; ?></td>
     </tr>     
     <tr>
       <td class="content_txt">Country </td>
       <td class="text6"><?php echo getCountryName($country,$conn); ?></td>
     </tr>     
     <tr>
       <td class="content_txt">State </td>
       <td class="text6"><?php echo $state; ?></td>
     </tr>     
     <tr>
       <td class="content_txt">City </td>
       <td class="text6"><?php echo $city; ?></td>
     </tr> 
	 <tr>
       <td class="content_txt">Pin Code </td>
       <td class="text6"><?php echo $pincode; ?></td>
     </tr> 	 
     <tr>
       <td class="content_txt">Land Line No </td>
       <td class="text6"><?php echo $land_line_no; ?></td>
     </tr>     
     <tr>
       <td class="content_txt">Mobile No. </td>
       <td class="text6"><?php echo $mobile_no; ?></td>
     </tr>     
     <tr>
       <td class="content_txt">Status </td>
       <td class="text6">
	    <?php 
		if($status == '1') { 
        echo "<span style='color:green; font-weight:bold'>Active</span>";
        } else if($status == '0') {
        echo "<span style='color:red'>Deactive</span>";
        } 
        ?></td>
     </tr>
     <tr>
       <td class="content_txt">Post Date </td>
       <td class="text6"><?php echo date("d-m-Y",strtotime($post_date)); ?></td>
     </tr>
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