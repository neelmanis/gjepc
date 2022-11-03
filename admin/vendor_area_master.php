<?php 
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit; }
?>

<?php 
date_default_timezone_set('Asia/Kolkata'); 
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$request_id = $_REQUEST['id'];
	$sql="delete from vendor_area_master where id=$request_id";
	$stmtd = $conn -> query($sql);

	if(	$stmtd ){	echo"<meta http-equiv=refresh content=\"0;url=vendor_area_master.php?action=view\">"; }
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter(intval($_REQUEST['id']));
	$sql="update vendor_area_master set status=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("si", $status,$id);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=vendor_area_master.php?action=view\">"; }
}

if($_REQUEST['action']=='save')
{
  if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$area=filter($_REQUEST['area']);
	$description=filter($_REQUEST['description']);	
	$status=filter($_REQUEST['status']);
	$datetime = date("Y-m-d H:i:s");      
   
	$sql="INSERT INTO vendor_area_master (area,description,status,created_at) VALUES ('$area','$description','$status','$datetime')";
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){ echo"<meta http-equiv=refresh content=\"0;url=vendor_area_master.php?action=view\">"; }
	} else {
    echo "<script langauge=\"javascript\">alert(\"Invalid Token Error.\");</script>";
  }
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
  if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$area=filter($_REQUEST['area']);
	$description=filter($_REQUEST['description']);
	$status=filter($_REQUEST['status']);
	$datetime = date("Y-m-d H:i:s"); 
	$id=filter($_REQUEST['id']);

	$sql="update vendor_area_master set area='$area',description='$description',status='$status',created_at='$datetime' where id='$id'";
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=vendor_area_master.php?action=view\">"; }
	} else{
    echo "<script langauge=\"javascript\">alert(\"Invalid Token Error.\");</script>";
  }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Vendor Area Master||GJEPC||</title>

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
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
</style>
<script language="javascript">
function checkdata()
{
	area=document.getElementById('area').value;
	if( area=="")
	{
		alert("Please insert Area");
		document.getElementById('area').focus();
		return false;
	}
	description=document.getElementById('description').value;
	if(description=="")
	{
		alert("Please insert description.");
		document.getElementById('description').focus();
		return false;
	}
	status=document.getElementById('status').value;
	if( status=="")
	{
		alert("Please Select Status");
		document.getElementById('status').focus();
		return false;
	}
}
</script>
<script>
function getexportdata()
{
	ad_valorem=document.getElementById('ad_valorem').value;
	if(isNaN(ad_valorem))
	{
		alert("Please enter numeric value only")
		document.getElementById('ad_valorem').focus();
		return false;
	}
	var membership_fee=document.getElementById("membership_fee").value;
	var admission_fee=document.getElementById("admission_fee").value;
	var export_start_amount=document.getElementById("export_start_amount").value;
	var export_end_amount=document.getElementById("export_end_amount").value;
	var tot_examount=parseInt(admission_fee)+parseInt(membership_fee)+parseInt(admission_fee)+parseInt(export_start_amount)+parseInt(export_end_amount)
	document.getElementById("total_amount").value = tot_examount;
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Vendors Area</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="vendor_area_master.php?action=add"><div class="content_head_button">Add New</div></a>  
        <?php if($_REQUEST['action']=='view_details' || $_REQUEST['action']=='edit'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="vendor_area_master.php?action=view">Back to Page</a></div>
        <?php }?>
        </div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
        <td >Area</td>
        <td >Description</td>    
        <td>Created at</td>
        <td>status</td>        
        <td colspan="4" align="center">Action</td>
    </tr>
    
    <?php 
    $i=1;
	$sqlx1 = "SELECT * FROM vendor_area_master";
    $query = $conn -> prepare($sqlx1);
	$query->execute();			
	$result = $query->get_result();
    $rCount=0;
    $rCount=$result->num_rows;			
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        
        <td><?php echo $row['area'];?></td>
        <td><?php echo $row['description']; ?></td>        
        <td><?php echo $row['created_at']; ?></td>       
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="vendor_area_master.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="vendor_area_master.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="vendor_area_master.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/view.png" title="View" border="0" /></a></td>
        <td ><a href="vendor_area_master.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.gif" alt="Edit" width="15" height="15" border="0" /></a></td>
        <td ><a href="vendor_area_master.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$request_id  = $_REQUEST['id'];
		$sql3 = "SELECT * FROM vendor_area_master where  id=$request_id";
		$result2 = $conn->query($sql3);
		
		if($row2 = $result2->fetch_assoc())
		{
			$area=$row2['area'];
			$description=$row2['description'];		
			$status=$row2['status'];			
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add Vendors Area </td>
    </tr>
    <?php token(); ?>    
   <tr>
      <td valign="middle" class="content_txt">Area<span class="star">*</span></td>
      <td><input name="area" id="area" class="show-tooltip input_txt" title="Please enter Area" value="<?php echo $area;?>"></input></td>
    </tr>
     <tr>
      <td valign="middle" class="content_txt">Description<span class="star">*</span></td>
      <td><textarea  name="description" id="description" class="show-tooltip input_txt" title="Please enter Area" rows="10" ><?php echo $description;?></textarea></td>
    </tr> 
     <tr>
      <td valign="middle" class="content_txt">Status<span class="star">*</span></td>     
      <td>
	  <select type="text" name="status" id="status" title="Status Type" class="show-tooltip input_txt" value="<?php echo $status;?>">
      	<option value="<?php echo $status;?>"><?php if($status=="0"){echo "Inactive";}else if($status=="1"){echo "Active";}else{echo "Select Status";} ?></option>
      	<option value="1">Active</option>
      	<option value="0">Inactive</option>
      </select>
	  </td>
    </tr>    
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
 
<?php 
if($_REQUEST['action']=='view_details'){

		$sql3 = "SELECT * FROM vendor_area_master  where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", intval($_REQUEST['id']));
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$area=stripslashes($row2['area']);
			$description=stripslashes($row2['description']);	
			$created_at=stripslashes($row2['created_at']);
			$status=stripslashes($row2['status']);		
		}
?>
 <div class="content_details1">
   <table width="100%" border="0" cellspacing="5" cellpadding="5"  >
     <tr class="orange1">
       <td colspan="2">&nbsp;View Details</td>
     </tr>        
     <tr>
       <td class="content_txt">Area</td>
       <td class="text6"><?php echo $area; ?></td>
     </tr>     
      <tr>
       <td class="content_txt">Description</td>
       <td class="text6"><?php echo $description; ?></td>
     </tr>    
     <tr>
       <td class="content_txt">Created at </td>
       <td class="text6"><?php echo $created_at; ?></td>
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
 <?php } ?>
    </div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>