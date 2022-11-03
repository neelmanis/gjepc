<?php session_start(); ?>
<?php if(!isset($_SESSION['curruser_contact_name']))
	header("location:index.php");
?>
<?php 
$hostname = "localhost";
$uname = "appadmin";
$pwd = "#21SAq109@65%n";
$database = "gjepc_all_data";

$dbconn = @mysql_connect($hostname,$uname,$pwd);
@mysql_select_db($database);
?>
<?php include('../functions.php');?>
<?php 

if (($_REQUEST['action']=='ResetPass') && ($_REQUEST['id']!=''))
{
	
	$query1=mysql_query("update registration_master set password='password' where id='".$_REQUEST['id']."'");
	   
	$query=mysql_query("select * from registration_master where id='".$_REQUEST['id']."'");
	$result=mysql_fetch_array($query);
	$email_id=$result['email_id'];
	$password=$result['password'];
	$first_name=$result['first_name'];
	$last_name=$result['last_name'];
	
	$num=mysql_num_rows($query);
	if($num>0){
	/*.......................................Send mail to users mail id...............................................*/
   $message ='<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:"Lucida Sans"; font-size:14px; color:#333333; text-align:justify; ">
  <tr>
    <td colspan="2"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
         <td width="150" align="left"><img src="http://www.gjepc.org/images/logo_gjepc.png" width="150" height="91" /></td>
          <td width="85%" align="right"><img src="http://www.gjepc.org/images/logo_in.png" width="105" height="91" /></td>
        </tr>
      </table>
	 </td>
  </tr>
  
  <tr>
    <td height="10" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; color:#990000; border-bottom: solid thin #666666;">&nbsp;</td>
  </tr>
  
  <tr>
    <td height="30" colspan="2" align="left" style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Dear '. $first_name.' '.$last_name.',</td>
  </tr>
  
	<tr>
		<td>&nbsp; </td>
	</tr>
	
  <tr>
  <td align="left"  style="text-align:justify;">Your Password is successfully Reset.<br/>  </td>
  </tr>
  
  <tr>
    <td align="left"  style="text-align:justify;"><strong>User Name :</strong> '. $email_id .' </td>
  </tr>
  
  <tr>
    <td align="left"  style="text-align:justify;"><strong>Password :</strong> '. $password .'</td>
  </tr>
  
  <tr>
    <td>&nbsp; </td>
  </tr>
  
  <tr>
    <td>&nbsp; </td>
  </tr>
  
  <tr>
    <td height="22" align="left"  style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,</td>
  </tr>
  <tr>
    <td align="left"><strong>GJEPC Web Team,</strong></td>
  </tr>
 </table>';
	
	 $to =$email_id;
	 $subject = "Reset Password of GJEPC Member"; 
	 $headers  = 'MIME-Version: 1.0'."\n\r"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1'."\n\r"; 
	 $headers .= 'From: admin@gjepc.org';			
     mail($to, $subject, $message, $headers);

	 $_SESSION['succ_msg']="Your password has been reset";
	 }

	echo"<meta http-equiv=refresh content=\"0;url=manage_registration_old_data.php?action=view\">";
}


if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from registration_master where id='$_REQUEST[id]'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_registration_old_data.php?action=view\">";
}

if (($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{

		$status=$_REQUEST['status'];	
		$id=$_REQUEST['id'];
		$sql="update registration_master set status='$status' where id='$id'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=manage_registration_old_data.php?action=view\">";
}

if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$email_id=mysql_real_escape_string($_REQUEST['email_id']);
	$password=mysql_real_escape_string($_REQUEST['password']);
	$id=$_REQUEST['id'];	
	$payment_defaulter=mysql_real_escape_string($_REQUEST['payment_defaulter']);
	if($payment_defaulter=='Y')
	{
	$payment_defaulter_reason=mysql_real_escape_string($_REQUEST['payment_defaulter_reason']);
	}else
	{
	$payment_defaulter_reason="";
	}
	
	$query=mysql_query("select * from registration_master where email_id='$email_id'");
    $num=mysql_num_rows($query);
	if($num>0)
	{
		echo '<script language="javascript">';
		echo 'alert("Email ID not Updated because already exists and other information has been updated")';
		echo '</script>';
		
		$sql="update registration_master set password='$password',payment_defaulter='$payment_defaulter',payment_defaulter_reason='$payment_defaulter_reason' where id='$id'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		
	echo"<meta http-equiv=refresh content=\"0;url=manage_registration_old_data.php?action=view\">";
	exit;
	}else{	
	$sql="update registration_master set email_id='$email_id',password='$password',payment_defaulter='$payment_defaulter',payment_defaulter_reason='$payment_defaulter_reason' where id='$id'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		
	mysql_query("update information_master set email_id='$email_id' where registration_id='$id'");
	echo"<meta http-equiv=refresh content=\"0;url=manage_registration_old_data.php?action=view\">";
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
  $_SESSION['iec_no']="";
  
  header("Location: manage_registration_old_data.php");
}else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['name']=mysql_real_escape_string($_REQUEST['name']);
	$_SESSION['company_name']=mysql_real_escape_string($_REQUEST['company_name']);
	$_SESSION['email_id']=mysql_real_escape_string($_REQUEST['email_id']);
	$_SESSION['gcode']=mysql_real_escape_string($_REQUEST['gcode']);
	$_SESSION['pvrcode']=mysql_real_escape_string($_REQUEST['pvrcode']);
	$_SESSION['iec_no']=mysql_real_escape_string($_REQUEST['iec_no']);
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

<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
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


<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Registration</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Manage Registration
        <?php if($_REQUEST['action']=='view_details'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="manage_registration_old_data.php?action=view">Back to Registration</a></div>
        <?php }?>
        <a href="export_member_list.php">Export Member List</a>
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
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>

<tr >
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
<tr >
  <td><strong>GCode</strong></td>
  <td><input type="text" name="gcode" id="gcode" class="input_txt" value="<?php echo $_SESSION['gcode'];?>" /></td>
  </tr>
<tr >
  <td><strong>PVR Code</strong></td>
  <td><input type="text" name="pvrcode" id="pvrcode" class="input_txt" value="<?php echo $_SESSION['pvrcode'];?>" /></td>
  </tr>

<tr >
  <td><strong>IEC NO.</strong></td>
  <td><input type="text" name="iec_no" id="iec_no" class="input_txt" value="<?php echo $_SESSION['iec_no'];?>" /></td>
</tr>
<tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td width="5%"><a href="#">Sr. No.</a></td>
        <td width="5%">GCode</td>
        <td width="25%">Company Name</td>
        <td width="20%">Name</td>
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
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'post_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
    $sql="SELECT * FROM registration_master where 1";
	if($_SESSION['name']!="")
	{
	$sql.=" and first_name like '%".$_SESSION['name']."%'";
	}
	
	if($_SESSION['company_name']!="")
	{
	$sql.=" and company_name like '%".$_SESSION['company_name']."%'";
	}
	
	if($_SESSION['email_id']!="")
	{
	$sql.=" and email_id like '%".$_SESSION['email_id']."%'";
	}

	if($_SESSION['gcode']!="")
	{
	$sql.=" and gcode ='".$_SESSION['gcode']."'";
	}
	//$sql.= "  ".$attach." ";
	
	$result1=mysql_query($sql);
	$rCount=mysql_num_rows($result1);
	
	$sql1= $sql." limit $start, $limit ";
	$result=mysql_query($sql1);
	echo $sql1;
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['gcode']; ?></td>
        <td><?php echo strtoupper(strip_tags($row['company_name'])); ?></td>
        <td><?php echo strtoupper(strip_tags($row['first_name']))." ".strtoupper(strip_tags($row['last_name'])); ?> <br /> <?php if($row['pvrcode']!=''){ echo "(".$row['pvrcode'].")";}?></td>
        <td align="left"><?php echo $row['email_id']; ?></td>
       	<td align="left"><?php echo $row['password']; ?></td>
  		<td align="left"><?php echo date("d-m-Y",strtotime($row['post_date'])); ?></td>	

        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_registration_old_data.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_registration_old_data.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td align="left"><a href="manage_registration_old_data.php?action=ResetPass&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to reset password?'));"><img src="images/reset_password.png" title="Reset Password" border="0" /></a></td>
        <td align="left"><a href="manage_registration_old_data.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/view.png" title="View" border="0" /></a></td>
        <td align="left"><a href="manage_registration_old_data.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.gif" title="Edit" border="0" /></a></td>
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
 
<!--<div class="pages">
    <ul>
        <a href="#"><li style="border-right:none;">Prev </li></a>
        <a href="#"><li>1 </li></a>
        <a href="#"><li>2 </li></a>
        <a href="#"> <li>3 </li> </a>
         <a href="#"><li>4 </li></a>
        <a href="#"><li style="border-right:none;">5 </li></a>
        <a href="#"><li style="border-right:none;">Next</li></a>	           
    </ul>
</div>-->
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
 <?php echo pagination($limit,$page,'manage_registration_old_data.php?action=view&page=',$rCount); //call function to show pagination?>

</div>
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT *  FROM registration_master  where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			
			$first_name=stripslashes($row2['first_name']);
			$last_name=stripslashes($row2['last_name']);
			$company_name=stripslashes($row2['company_name']);
			$email_id=stripslashes($row2['email_id']);
			$password=stripslashes($row2['password']);
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
    <td class="content_txt">Name</td>
    <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $first_name ." ".$last_name; ?>" readonly="readonly" /></td>
    </tr>
    
    <tr>
      <td class="content_txt">Company Name</td>
      <td><input type="text" name="emacompany_nameil_id" id="company_name" class="input_txt" value="<?php echo $company_name; ?>" readonly="readonly" /></td>
    </tr>
    <tr>
    <td class="content_txt">Email ID <span class="star">*</span></td>
    <td><input type="text" name="email_id" id="email_id" class="input_txt" value="<?php echo $email_id; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Password <span class="star">*</span></td>
    <td><input type="password" name="password" id="password" class="input_txt" value="<?php echo $password; ?>" /></td>
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

		$result2 = mysql_query("SELECT *  FROM registration_master  where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			
			$email_id=stripslashes($row2['email_id']);
			$password=stripslashes($row2['password']);
			$designation=stripslashes($row2['designation']);
			$first_name=stripslashes($row2['first_name']);
			$last_name=stripslashes($row2['last_name']);
			$company_name=stripslashes($row2['company_name']);
			$address_line1=stripslashes($row2['address_line1']);
			$address_line2=stripslashes($row2['address_line2']);
			$address_line3=stripslashes($row2['address_line3']);
			$city=stripslashes($row2['city']);
			$country=stripslashes($row2['country']);
			$state=stripslashes($row2['state']);
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
       <td class="content_txt" width="15%">First Name </td>
       <td class="text6"><?php echo $first_name; ?></td>
     </tr>
     
     <tr>
       <td class="content_txt">Last Name </td>
       <td class="text6"><?php echo $last_name; ?></td>
     </tr>
     
      <tr>
       <td class="content_txt">Company Name </td>
       <td class="text6"><?php echo $company_name; ?></td>
     </tr>
     
     <tr>
       <td class="content_txt">Designation </td>
       <td class="text6"><?php echo $designation; ?></td>
     </tr>
     
     <tr>
       <td class="content_txt">Email ID </td>
       <td class="text6"><?php echo $email_id; ?></td>
     </tr>
     
     <tr>
       <td class="content_txt">Password </td>
       <td class="text6"><?php echo $password; ?></td>
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
       <td class="text6"><?php echo getCountryName($country); ?></td>
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
       <td class="content_txt">Land Line No </td>
       <td class="text6"><?php echo $land_line_no; ?></td>
     </tr>
     
     <tr>
       <td class="content_txt">Mobile No </td>
       <td class="text6"><?php echo $mobile_no; ?></td>
     </tr>
     
     <tr>
       <td class="content_txt">Status </td>
       <td class="text6">
	    <?php if($status == '1') 
        { 
        echo "<span style='color:green'>Active</span>";
        }else if($status == '0') 
        {
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
