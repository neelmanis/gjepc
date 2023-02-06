<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; } 
$adminID = intval($_SESSION['curruser_login_id']);
/*if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from admin_master where id='$_REQUEST[id]'";	
	if(!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">";
}*/

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter(intval($_REQUEST['id']));
	$sql = "update admin_master set status=?,adminId=?,modified_date=NOW() where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("sii", $status,$adminID,$id);
	if($stmt->execute()) {
	echo"<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">";
	} else {
	die ("Mysql Update Error: " . $conn->error);
	}
}

if ($_REQUEST['action']=='save')
{
	$post_date = date('Y-m-d');
	$contact_name=filter($_REQUEST['contact_name']);
	$address=filter($_REQUEST['address']);
	$mobile_no=filter($_REQUEST['mobile_no']);
	$email_id=filter($_REQUEST['email_id']);
	$password = md5($_REQUEST['password']);
	$role=filter($_REQUEST['role']);
	if($role!="Super Admin")
	{
		$admin_access=$_REQUEST['admin_access'];
		foreach($admin_access as $val)
		{
		$admin_access_new.=$val.",";
		}
		
		$region_access=$_REQUEST['region_access'];
		foreach($region_access as $rval)
		{
		$region_access_new.=$rval.",";
		}
	} 
	$region_id=filter($_REQUEST['region_id']);
	
	$sqlx = "select * from admin_master where email_id=? and secret_key=?";
	$query = $conn -> prepare($sqlx);
	$query -> bind_param("ss", $email_id, $password);
	$query->execute();			
	$row = $query->get_result();
    $cnt = $row->num_rows;
	if($cnt > 0)
	{
		echo "<script langauge=\"javascript\">alert(\"Email ID or Password already in use\");location.href='manage_admin.php?action=view';</script>";
	}
	else
	{
		$sql="INSERT INTO admin_master (contact_name, address,mobile_no,email_id,secret_key,role,admin_access,region_id,status,post_date,adminId,region_access) VALUES ('$contact_name', '$address','$mobile_no','$email_id','$password','$role','$admin_access_new','$region_id','1','$post_date','$adminID','$admin_access_new')";	
		$resultx = $conn -> query($sql);	  
	    if($resultx) {
		echo "<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">";
		} else {
		die ("Mysql Insert Error: " . $conn->error);
		}
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$contact_name=filter($_REQUEST['contact_name']);
	$address=filter($_REQUEST['address']);
	$mobile_no=filter($_REQUEST['mobile_no']);
	$email_id=filter($_REQUEST['email_id']);
	$password=md5($_REQUEST['password']);
	$role=filter($_REQUEST['role']);
	if($role!="Super Admin")
	{
		$admin_access=$_REQUEST['admin_access'];
		foreach($admin_access as $val)
		{
		$admin_access_new.=$val.",";
		}
		
		$region_access=$_REQUEST['region_access'];
		foreach($region_access as $rval)
		{
		$region_access_new.=$rval.",";
		}
	}
	
	$reports_access = $_REQUEST['reports_access'];
	foreach($reports_access as $rval)
	{
		$reports_access_new.=$rval.",";
	}
	
	$reports_category = $_REQUEST['reports_category'];
	foreach($reports_category as $rcat)
	{
		$reports_cat_new.=$rcat.",";
	}
		
	$region_id = filter($_REQUEST['region_id']);
	$id		   = intval($_REQUEST['id']);

	$sql="update admin_master set contact_name='$contact_name',address='$address', mobile_no='$mobile_no',email_id='$email_id',role='$role',admin_access='$admin_access_new',region_id='$region_id',modified_date=NOW(),adminId='$adminID',region_access='$region_access_new',reports_access='$reports_access_new',reports_category='$reports_cat_new' where id='$id'";	
	$resultx = $conn -> query($sql);
	if($resultx) {
	echo "<meta http-equiv=refresh content=\"0;url=manage_admin.php?action=view\">";
	} else {
	die ("Mysql Update Error: " . $conn->error);
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to GJEPC</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> 
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

<script>
$(document).ready(function() {
  $('.child').on('change', ':checkbox', function() {
    if ($(this).is(':checked')) {
      var currentRow = $(this).closest('tr');
      var targetedRow = currentRow.prevAll('.parent').first();
      var targetedCheckbox = targetedRow.find(':checkbox');
      targetedCheckbox.prop('checked', true).trigger('change');
    }
  });
  
  $(".parent-category").on("click", function(){
    $(this).parent().find(":checkbox").prop('checked', true);
  });
});
</script>
<script language="javascript">
function checkdata()
{
	if(document.getElementById('contact_name').value == '')
	{
		alert("Please Enter Name");
		document.getElementById('contact_name').focus();
		return false;
	}
	if(!IsCharacter(document.getElementById('contact_name').value))
	{
		alert("Please Enter Valid Name");
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
	/*if(document.getElementById('password').value == '')
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
	} */
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
function IsCharacter(strString)
{
   var strValidChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ abcdefghijklmnopqrstuvwxyz0123456789_";
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

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
		$("#region_access_div").hide();
	}else
	{
		$("#admin_access_div").show();
		$("#region_access_div").show();
	}
	
 });
});
</script>

</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div></div>
<div class="clear"></div>
<div class="breadcome_wrap"><div class="breadcome"><a href="admin.php">Home</a> > Manage Admin</div></div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="manage_admin.php?action=add"><div class="content_head_button">Add Admin</div></a> <a href="manage_admin.php?action=view"><div class="content_head_button">View Admin</div></a> </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
        <td >Name</td>
        <td >Email ID</td>
        <td >Mobile No.</td>
       <?php /*if($adminID==1){ ?> <td>Password</td><?php }*/ ?>
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
	$result =  $conn ->query("SELECT * FROM admin_master where 1".$attach." ");
    $rCount=0;
    $rCount = $result->num_rows;;		
    if($rCount>0)
    {	
	while($row =  $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo filter($row['contact_name']); ?></td>
        <td><?php echo filter($row['email_id']); ?></td>
        <td><?php echo $row['mobile_no']; ?></td>
        <?php /*if($adminID==1){ ?><td><?php echo $row['password'];?></td><?php } */?>
        <td><?php echo $row['region_id']; ?></td>
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
		$sql3 = "SELECT * FROM admin_master where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", $_REQUEST['id']);
		$query->execute();			
		$result2 = $query->get_result();
		while($row2 = $result2->fetch_assoc())	
		{			
			$contact_name=stripslashes($row2['contact_name']);
			$address=stripslashes($row2['address']);
			$mobile_no=stripslashes($row2['mobile_no']);
			$email_id=stripslashes($row2['email_id']);
			$password=stripslashes($row2['password']);
			$role=stripslashes($row2['role']);
			$admin_access=$row2['admin_access'];
			$region_access=$row2['region_access'];
			$region_id=stripslashes($row2['region_id']);
			$adminaccessArr = explode(",", $admin_access);
			
			$reports_access = $row2['reports_access'];
			$adminReportAccess = explode(",", $reports_access);
			$reports_category = $row2['reports_category'];
			$adminReports_category = explode(",", $reports_category);
			
			
		}
  }
?>
 
<div class="content_details1">
<form method="POST" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr class="orange1">
    <td colspan="2">&nbsp; Add New Admin</td>
    </tr>
    <tr>
    <td class="content_txt">Name <span class="star">*</span></td>
    <td><input type="text" name="contact_name" id="contact_name" title="Please enter your name" class="show-tooltip input_txt" value="<?php echo $contact_name; ?>"/></td>
    </tr>  
    <tr>
    <td valign="top" class="content_txt">Address</td>
    <td><label><textarea name="address" id="address" rows="5" class="input_txt" ><?php echo $address; ?></textarea></label></td>
    </tr>
    <tr>
    <td class="content_txt">Mobile No. <span class="star">*</span></td>
    <td><input type="text" name="mobile_no" id="mobile_no" class="input_txt" value="<?php echo $mobile_no; ?>" />
    <label id="lblMsg" style="display:none;">Please enter your contact No.</label>    </td>
    </tr>    
    <tr>
    <td class="content_txt">Email ID <span class="star">*</span></td>
    <td><input type="text" name="email_id" id="email_id" class="input_txt" value="<?php echo $email_id; ?>" /></td>
    </tr>   
	<?php  if($adminID==1){ ?> 
    <tr>
    <td class="content_txt">Password <span class="star">*</span></td>
    <td><input type="password" name="password" id="password" class="input_txt"  /></td>
    </tr> <?php } ?>  
    <tr>
    <td class="content_txt">Role <span class="star">*</span></td>
    <td>
    <select name="role" id="role" class="input_txt">
    <option value="">Select Role</option>
    <option value="Admin" <?php if($role=="Admin"){echo "selected='selected'";} ?>>Admin</option>
    <option value="Super Admin" <?php if($role=="Super Admin"){echo "selected='selected'";} ?>>Super Admin</option>
    </select>
	</td>
    </tr>    
    <tr>
    <td class="content_txt">Region <span class="star">*</span></td>
    <td>
		<select name="region_id" id="region_id" class="input_txt" >
		<option value="">Select Region</option>
		<?php
		$sql3="SELECT * FROM `region_master` WHERE `status`='1'";
		$query = $conn -> prepare($sql3);
		$query->execute();			
		$row = $query->get_result();
		while($rows3 = $row->fetch_assoc())							  
		{
		  if($rows3['region_name']==$region_id)
		  {
		  echo "<option selected='selected' value='$rows3[region_name]'>$rows3[region_full_name]</option>";
		  } else  {
		  echo "<option value='$rows3[region_name]'>$rows3[region_full_name]</option>";
		  }  
		}	
		?>
		</select>
	</td>
    </tr>
	<tbody <?php if($role=='Super Admin' || $role==''){?> style="display:none" <?php }?> id="admin_access_div">
    <tr>
    <td valign="top" bgcolor="#FFFFFF" class="text_content">Admin Access</td>
    <td bgcolor="#FFFFFF" class="text_content">
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="A"  <?php if(preg_match('/A/',$admin_access)){ echo ' checked="checked"'; } ?> />Create Admin
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="B"  <?php if(preg_match('/B/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Registration
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="C"  <?php if(preg_match('/C/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Master
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="D"  <?php if(preg_match('/D/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Membership
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="E" <?php if(preg_match('/E/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Pages
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="F"  <?php if(preg_match('/F/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Banner
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="G"  <?php if(preg_match('/G/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage DataPort
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="H"  <?php if(preg_match('/H/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Helpdesk
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="I"  <?php if(preg_match('/I/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage IVR
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="J"  <?php if(preg_match('/J/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Visitor
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="K"  <?php if(preg_match('/K/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Hotel
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="L"  <?php if(preg_match('/L/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Exhibitor Registration
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="M"  <?php if(preg_match('/M/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Trade Permission 
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="N"  <?php if(preg_match('/N/',$admin_access)){ echo ' checked="checked"'; } ?> />Manage Signature Authority
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="GS"  <?php if(preg_match('/GS/',$admin_access)){ echo ' checked="checked"'; } ?> />Member GST
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="finance"  <?php if(preg_match('/finance/',$admin_access)){ echo ' checked="checked"'; } ?> />Finance
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="legal"  <?php if(preg_match('/legal/',$admin_access)){ echo ' checked="checked"'; } ?> />Legal
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="functional"  <?php if(preg_match('/functional/',$admin_access)){ echo ' checked="checked"'; } ?> />functional
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="Q"  <?php if(preg_match('/Q/',$admin_access)){ echo ' checked="checked"'; } ?> />Vendor Empanelment
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="R"  <?php if(preg_match('/R/',$admin_access)){ echo ' checked="checked"'; } ?> />Account Vendor Empanelment
<!--<input type="checkbox" name="admin_access[]" id="admin_access[]" value="O" <?php if(preg_match('/O/',$admin_access)){ echo 'checked="checked"'; } ?> />Account Exhibitor Registration-->
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="O" <?php if(preg_match('/O/',$admin_access)){ echo 'checked="checked"'; } ?> />Manage Relief Fund
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="X" <?php if(preg_match('/X/',$admin_access)){ echo 'checked="checked"'; } ?> />Manage Parichay Card
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="W" <?php if(preg_match('/W/',$admin_access)){ echo 'checked="checked"'; } ?> />Webinar
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="IGJA" <?php if(preg_match('/S/',$admin_access)){ echo 'checked="checked"'; } ?> />IGJA Awards

<input type="checkbox" name="admin_access[]" id="admin_access[]" value="promo" <?php if(in_array('promo',$admin_access)){ echo 'checked="checked"'; } ?> />promo video
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="lab" <?php if(in_array('lab',$admin_access)){ echo 'checked="checked"'; } ?> />lab
<input type="checkbox" name="admin_access[]" id="admin_access[]" value="covid" <?php if(in_array('covid',$admin_access)){ echo 'checked="checked"'; } ?> />Covid report

</td>
</tr>
</tbody>

<tbody <?php if($role=='Super Admin' || $role==''){?> style="display:none" <?php }?> id="region_access_div">
<tr>
    <td valign="top" bgcolor="#FFFFFF" class="text_content">Region Access </td>
	<td bgcolor="#FFFFFF" class="text_content">
	<?php 
	$region = explode(',',$region_access);
	?>
	<input type="checkbox" name="region_access[]" id="region_access[]" value="HO-MUM (M)" <?php if(in_array('HO-MUM (M)',$region)){ echo 'checked="checked"'; } ?>>&nbsp;HO-MUM (M)			
	<input type="checkbox" name="region_access[]" id="region_access[]" value="RO-CHE" <?php if(in_array('RO-CHE',$region)){ echo 'checked="checked"'; } ?> >&nbsp;RO-CHE			
	<input type="checkbox" name="region_access[]" id="region_access[]" value="RO-DEL" <?php if(in_array('RO-DEL',$region)){ echo 'checked="checked"'; } ?>>&nbsp;RO-DEL			
	<input type="checkbox" name="region_access[]" id="region_access[]" value="RO-JAI" <?php if(in_array('RO-JAI',$region)){ echo 'checked="checked"'; } ?>>&nbsp;RO-JAI			
	<input type="checkbox" name="region_access[]" id="region_access[]" value="RO-KOL" <?php if(in_array('RO-KOL',$region)){ echo 'checked="checked"'; } ?>>&nbsp;RO-KOL			
	<input type="checkbox" name="region_access[]" id="region_access[]" value="RO-SRT" <?php if(in_array('RO-SRT',$region)){ echo 'checked="checked"'; } ?>>&nbsp;RO-SRT	
	</td>
</tr>
</tbody>

	<?php if($adminID==1){ ?>
	<tbody>
	<tr>
        <td class="content_txt">Permission</td>
        <td>
        <?php
		$result=$conn->query("SELECT distinct(category) FROM report_master");
		while($row=$result->fetch_assoc()){
			$category = $row['category'];
        ?>
        <fieldset class="scheduler-border">
        <legend class="scheduler-border"> 
		<input type="checkbox" name="reports_category[]" value="<?php echo $row['category'];?>" <?php if(in_array($row['category'], $adminReports_category)){ echo "checked='checked'";}?> class="parent-category"> &nbsp; <?php echo $row['category'];?> &nbsp;
		</legend>
        <?php 
		$result1=$conn->query("SELECT * FROM report_master where status='1' AND category='$category'");
		$i = 0;
		while($row1=$result1->fetch_assoc()){ 
		if ($i % 2 == 0)
        echo '<br>'; ?>
        <input type="checkbox" name="reports_access[]" value="<?php echo $row1['slug'];?>" <?php if(in_array($row1['slug'], $adminReportAccess)){ echo "checked='checked'";}?> class="child-category">&nbsp; <?php echo $row1['title'];?>&nbsp;
        <?php $i++; } ?>
        </fieldset>
        <?php } ?>        
		</td>
    </tr>
	</tbody>
	<?php } ?>
	
    <tr>
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
    </div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>
