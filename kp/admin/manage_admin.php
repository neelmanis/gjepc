<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
/*	$sql="delete from kp_admin_master where id='$_REQUEST[id]'";	
	if (!mysqli_query($conn,$sql,$dbconn))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">";
	*/
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
		$status=$_REQUEST['status'];	
		$id=$_REQUEST['id'];
		$sql="update kp_admin_master set status='$status' where id='$id'";
		if (!mysqli_query($conn,$sql))
		{
			die('Error: ' . mysqli_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">";
}

if($_REQUEST['action']=='save')
{
	$post_date = date('Y-m-d');
	$contact_name=addslashes($_REQUEST['contact_name']);
	$address=addslashes($_REQUEST['address']);
	$mobile_no=addslashes($_REQUEST['mobile_no']);
	$email_id=addslashes($_REQUEST['email_id']);
	$password=addslashes($_REQUEST['password']);
	$pass=md5($_REQUEST['password']);
	$role=addslashes($_REQUEST['role']);
	if($role!="Super Admin")
		{
		$admin_access=$_REQUEST['admin_access'];
		foreach($admin_access as $val)
		{
		$admin_access_new.=$val.",";
		}
		} 
	$region_id=addslashes($_REQUEST['region_id']);	
	
	$result = @mysqli_query($conn,"select * from kp_admin_master where email_id='$email_id' and secret_key='$pass' limit 1");
	$cnt = mysqli_num_rows($result);
	if($cnt > 0)
	{
		echo "<script langauge=\"javascript\">alert(\"Email ID or Password already in use\");location.href='manage_admin.php?action=view';</script>";
	}
	else
	{
		$sql="INSERT INTO kp_admin_master (contact_name, address,mobile_no,email_id,password,secret_key,role,admin_access,region_id,status,post_date) VALUES ('$contact_name', '$address','$mobile_no','$email_id','$password','$pass','$role','$admin_access_new','$region_id','1','$post_date')";	
		if (!mysqli_query($conn,$sql))
		{
			die('Error: ' . mysqli_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">";
	}
}
if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$contact_name=addslashes($_REQUEST['contact_name']);
	$address=addslashes($_REQUEST['address']);
	$mobile_no=addslashes($_REQUEST['mobile_no']);
	$email_id=addslashes($_REQUEST['email_id']);
	$password=addslashes($_REQUEST['password']);
	$pass=md5($_REQUEST['password']);
	$role=addslashes($_REQUEST['role']);
	if($role!="Super Admin")
		{
		$admin_access=$_REQUEST['admin_access'];
		foreach($admin_access as $val)
		{
		$admin_access_new.=$val.",";
		} 
		}
	$region_id=addslashes($_REQUEST['region_id']);
	$id=$_REQUEST['id'];	

	$sql="update kp_admin_master set contact_name='$contact_name',address='$address', mobile_no='$mobile_no',email_id='$email_id',password='$password',secret_key='$pass',role='$role',admin_access='$admin_access_new',region_id='$region_id' where id='$id'";
	
	if (!mysqli_query($conn,$sql))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to GJEPC</title>
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
	
	/*var x=document.getElementById('mobile_no').value;
	
	if (x.charAt(0)!="9" && x.charAt(0)!="8" && x.charAt(0)!="7")
   	{
		alert("It should start with 9 or 8 or 7");
		document.getElementById('mobile_no').focus();
		return false;
   	}*/
	
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
<script language="javascript">
$(document).ready(function(){
 $("#role").change(function () {
	var role=$(this).val();
	if(role=="Super Admin")
	{
		$("#admin_access_div").hide();
	}else
	{
		$("#admin_access_div").show();
	}
	
 });
});
</script>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Admin</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="manage_admin.php?action=add"><div class="content_head_button">Add Admin</div></a> <a href="manage_admin.php?action=view"><div class="content_head_button">View Admin</div></a> </div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
        <td>Name</td>
        <td>Email ID</td>
        <td>Mobile No.</td>
        <td>Region</td>
        <td>Role</td>
        <td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
	$result = mysqli_query($conn,"SELECT * FROM kp_admin_master where 1".$attach." ");
    $rCount=0;
    $rCount = @mysqli_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysqli_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['contact_name']; ?></td>
        <td><?php echo $row['email_id']; ?></td>
        <td><?php echo $row['mobile_no']; ?></td>
        <td><?php echo getRegionName($conn,$row['region_id']); ?></td>
        <td><?php echo $row['role']; ?></td>
        <td>
		<?php if($row['status'] == '1') 
        { 
        echo "<span style='color:green'>Active</span>";
        }else if($row['status'] == '0') 
        {
        echo "<span style='color:red'>Deactive</span>";
        } 
        ?>
        </td>
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_admin.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_admin.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="manage_admin.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="manage_admin.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
	$action='save';
	if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
	{
		$action='update';
		$result2 = mysqli_query($conn,"SELECT * FROM kp_admin_master where id='$_REQUEST[id]'");
		if($row2 = mysqli_fetch_array($result2))
		{
			$contact_name=stripslashes($row2['contact_name']);
			$address=stripslashes($row2['address']);
			$mobile_no=stripslashes($row2['mobile_no']);
			$email_id=stripslashes($row2['email_id']);
			$password=stripslashes($row2['password']);
			$role=stripslashes($row2['role']);
			$admin_access=$row2['admin_access'];
			$region_id=stripslashes($row2['region_id']);
		}
	}
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Admin</td>
    </tr>

    <tr>
    <td class="content_txt">Name <span class="star">*</span></td>
    <td><input type="text" name="contact_name" id="contact_name" title="Please enter your name" class="show-tooltip input_txt" value="<?php echo $contact_name; ?>" />    </td>
    </tr>
  
    <tr>
      <td valign="top" class="content_txt">Address</td>
      <td><label>
        <textarea name="address" id="address" rows="5" class="input_txt" ><?php echo $address; ?></textarea>
      </label></td>
    </tr>
    <tr>
    <td class="content_txt">Mobile No. <span class="star">*</span></td>
    <td><input type="text" name="mobile_no" id="mobile_no" class="input_txt" value="<?php echo $mobile_no; ?>" />
        <label id="lblMsg" style="display:none;">Please enter your contact no.</label>    </td>
    </tr>
    
    <tr>
    <td class="content_txt">Email ID <span class="star">*</span></td>
    <td><input type="text" name="email_id" id="email_id" class="input_txt" value="<?php echo $email_id; ?>" /></td>
    </tr>
    
    <!--<tr>
    <td class="content_txt">Password <span class="star">*</span></td>
    <td><input type="password" name="password" id="password" class="input_txt" value="<?php echo $password; ?>" /></td>
    </tr>-->
    
    <tr>
    <td class="content_txt">Role <span class="star">*</span></td>
    <td>
    <select name="role" id="role" class="input_txt">
    <option value="">Select Role</option>
    <option value="Admin" <?php if($role=="Admin"){echo "selected='selected'";} ?>>Admin</option>
    <option value="Super Admin" <?php if($role=="Super Admin"){ echo "selected='selected'"; } ?>>Super Admin</option>
    </select></td>
    </tr>
    
    <tr>
    <td class="content_txt">Region <span class="star">*</span></td>
    <td>
    <select name="region_id" id="region_id" class="input_txt" >
    <option value="">Select Region</option>
    <?php
	$sql="select * from kp_location_master";
	$result=mysqli_query($conn,$sql);
	while($rows=mysqli_fetch_array($result))
	{
	if($rows['LOCATION_ID']==$region_id)
	{
	echo "<option selected='selected' value='$rows[LOCATION_ID]'>$rows[LOCATION_NAME]</option>";
	}
	else
	{
	echo "<option value='$rows[LOCATION_ID]'>$rows[LOCATION_NAME]</option>";
	}
	}
	
	?>
    </select></td>
    </tr>
        
        <tbody <?php if($role=='Super Admin' || $role==''){?> style="display:none" <?php }?> id="admin_access_div">
        <tr>
        <td valign="top" bgcolor="#FFFFFF" class="text_content">Admin Access</td>
        <td bgcolor="#FFFFFF" class="text_content">
        <input type="checkbox" name="admin_access[]" id="admin_access[]" value="1"  <?php if(preg_match('/1/',$admin_access)){ echo ' checked="checked"'; } ?> />Create Admin
        <input type="checkbox" name="admin_access[]" id="admin_access[]" value="2"  <?php if(preg_match('/2/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Kimberley Members
        <input type="checkbox" name="admin_access[]" id="admin_access[]" value="3"  <?php if(preg_match('/3/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Master
        <input type="checkbox" name="admin_access[]" id="admin_access[]" value="4"  <?php if(preg_match('/4/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Applications
        <input type="checkbox" name="admin_access[]" id="admin_access[]" value="5"  <?php if(preg_match('/5/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Banner
        </td>
        </tr>
        </tbody>
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
    
    </div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>