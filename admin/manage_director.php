<?php session_start(); ?>
<?php if(!isset($_SESSION['curruser_contact_name'])) header("location:index.php"); ?>
<?php
include('../db.inc.php');
include('../functions.php');
$adminID = $_SESSION['curruser_login_id'];

/*if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from master_director where id='$_REQUEST[id]'";	
	if(!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_director.php?action=view\">";
} */

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
		$status=$_REQUEST['status'];	
		$id=$_REQUEST['id'];
		$sql="update master_director set status='$status',adminId='$adminID',modified_date=NOW() where id='$id'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=manage_director.php?action=view\">";
}

if($_REQUEST['action']=='save')
{
	$name=filter($_REQUEST['name']);
	$designation=filter($_REQUEST['designation']);
	$email_id=filter($_REQUEST['email_id']);
	$contact=filter($_REQUEST['contact']);
	$address=filter($_REQUEST['address']);
	$role=filter($_REQUEST['role']);
	
	if($name == "" || $designation == "" || $email_id == "" || $contact == "" || $role == "") {
        echo "<script langauge=\"javascript\">alert(\"All Fields Required\");location.href='manage_director.php?action=view';</script>";
    } else {
	$result = @mysql_query("select * from master_director where email_id='$email_id'");
	$cnt = mysql_num_rows($result);
	if($cnt > 0)
	{
		echo "<script langauge=\"javascript\">alert(\"Email ID is already in use\");location.href='manage_director.php?action=view';</script>";
	}
	else
	{
	$sql="INSERT INTO `master_director`(`id`, `post_date`, `adminId`,`name`, `email_id`, `designation`, `contact_no`, `address`, `status`) VALUES ('',now(),'$adminID','$name','$email_id','$designation','$contact','$address','$role')";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=manage_director.php?action=view\">";
	}
	}
}
if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$name=filter($_REQUEST['name']);
	$designation=filter($_REQUEST['designation']);
	$email_id=filter($_REQUEST['email_id']);
	$contact=filter($_REQUEST['contact']);
	$address=filter($_REQUEST['address']);
	$status=filter($_REQUEST['role']);
	$id=$_REQUEST['id'];	
	
	if($name == "" || $designation == "" || $email_id == "" || $contact == "" || $role == "") {
        echo "<script langauge=\"javascript\">alert(\"All Fields Required\");location.href='manage_director.php?action=view';</script>";
    } else {
	$sql="UPDATE `master_director` SET `modified_date`=now(),`name`='$name',`email_id`='$email_id',`designation`='$designation',`contact_no`='$contact',`address`='$address',`status`='$status',modified_date=NOW(),adminId='$adminID' WHERE id='$id'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_director.php?action=view\">";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Director</title>
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

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Director</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">
		<!--<a href="manage_director.php?action=add"><div class="content_head_button">Add Director</div></a>-->
		<a href="manage_director.php?action=view"><div class="content_head_button">View Director</div></a>
		</div>

<?php if($_REQUEST['action']=='view') {?>  
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td width="5%"><a href="#">Sr. No.</a></td>
        <td width="20%">Name</td>
		<td width="20%">Designation</td>
        <td width="15%">Email ID</td>
        <td width="10%">Contact</td>
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
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'master_director.post_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
    $sql="SELECT * FROM `master_director` WHERE 1";	
	$sql.= "  ".$attach." ";
	
	$result1=mysql_query($sql);
	$rCount=mysql_num_rows($result1);
	
	$sql1= $sql." limit $start, $limit ";
	$result=mysql_query($sql1);
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo strtoupper($row['name']); ?></td>
		<td><?php echo strtoupper($row['designation']); ?></td>
        <td align="left"><?php echo $row['email_id']; ?></td>
       	<td align="left"><?php echo $row['contact_no']; ?></td>
  		<td align="left"><?php echo date("d-m-Y",strtotime($row['post_date'])); ?></td>	

        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_director.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_director.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td align="left"><a href="manage_director.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/view.png" title="View" border="0" /></a></td>
        <td align="left"><a href="manage_director.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.gif" title="Edit" border="0" /></a></td>
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
 <!--<div class="pages_1">Total number of Director: <?php echo $rCount;?> 
 <?php echo pagination($limit,$page,'manage_director.php?action=view&page=',$rCount); //call function to show pagination?>
</div>-->
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT *  FROM master_director  where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{			
			$name=stripslashes($row2['name']);
			$designation=stripslashes($row2['designation']);
			$email_id=stripslashes($row2['email_id']);
			$contact=stripslashes($row2['contact_no']);
			$address=stripslashes($row2['address']);
			$role=stripslashes($row2['status']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp; Director</td>
    </tr>

    <tr>
    <td class="content_txt">Name</td>
    <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $name; ?>" /></td>
    </tr>
    
    <tr>
      <td class="content_txt">Designation</td>
      <td><input type="text" name="designation" id="designation" class="input_txt" value="<?php echo $designation; ?>" /></td>
    </tr>
    <tr>
    <td class="content_txt">Email ID <span class="star">*</span></td>
    <td><input type="text" name="email_id" id="email_id" class="input_txt" value="<?php echo $email_id; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Contact <span class="star">*</span></td>
    <td><input type="text" name="contact" id="contact" class="input_txt" value="<?php echo $contact; ?>" /></td>
    </tr>
    
    <tr>
      <td class="content_txt">Address</td>
      <td><textarea name="address" cols="50" rows="5"><?php echo $address;?></textarea></td>
    </tr>
	
	<tr>
    <td class="content_txt">Status <span class="star">*</span></td>
    <td>
    <select name="role" id="role" class="input_txt">
    <option value="">Select Status</option>
    <option value="1" <?php if($role=="1"){echo "selected='selected'";} ?>>Active</option>
    <option value="0" <?php if($role=="0"){echo "selected='selected'";} ?>>Inactive</option>
    </select></td>
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

		$result2 = mysql_query("SELECT *  FROM master_director  where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			
			$name=stripslashes($row2['name']);
			$designation=stripslashes($row2['designation']);
			$email_id=stripslashes($row2['email_id']);
			$contact=stripslashes($row2['contact_no']);
			$address=stripslashes($row2['address']);
			$status=stripslashes($row2['status']);
			
		}
?>
 <div class="content_details1">
   <table width="100%" border="0" cellspacing="5" cellpadding="5"  >
     <tr class="orange1">
       <td colspan="2">&nbsp;View Details</td>
     </tr>
     <tr>
       <td class="content_txt" width="15%">Name </td>
       <td class="text6"><?php echo $name; ?></td>
     </tr>
	 
	 <tr>
       <td class="content_txt">Designation </td>
       <td class="text6"><?php echo $designation; ?></td>
     </tr>
     
      <tr>
       <td class="content_txt">Contact </td>
       <td class="text6"><?php echo $contact; ?></td>
     </tr>
     
     <tr>
       <td class="content_txt">Email ID </td>
       <td class="text6"><?php echo $email_id; ?></td>
     </tr>
     
     <tr>
       <td class="content_txt">Address </td>
       <td class="text6"><?php echo $address; ?></td>
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