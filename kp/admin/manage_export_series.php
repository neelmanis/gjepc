<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 
if (($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status=$_REQUEST['status'];	
	$id=$_REQUEST['id'];
	$sql="update kp_export_batch_serial set status='$status' where id='$id'";
	if (!mysqli_query($conn,$sql))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_export_series.php?action=view\">";
}

if ($_REQUEST['action']=='save')
{
	$post_date = date('Y-m-d');
	$last_serial_no=$_REQUEST['last_serial_no'];
	$processing_location=$_REQUEST['PROCES_CNTR'];
	$remarks=$_REQUEST['remarks'];
	
	$result = @mysqli_query($conn,"select * from kp_export_batch_serial where last_serial_no='$last_serial_no'");
	$cnt = mysqli_num_rows($result);
	if($cnt > 0)
	{
		echo "<script langauge=\"javascript\">alert(\"Series is already in use\");location.href='manage_export_series.php?action=view';</script>";
	}
	else
	{
		$sql="INSERT INTO kp_export_batch_serial (last_serial_no,processing_location,remarks,status) VALUES ('$last_serial_no','$processing_location','$remarks','1')";	
		if (!mysqli_query($conn,$sql))
		{
			die('Error: ' . mysqli_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=manage_export_series.php?action=view\">";
	}
}
if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$last_serial_no=addslashes($_REQUEST['last_serial_no']);
	$processing_location=$_REQUEST['PROCES_CNTR'];
	$remarks=$_REQUEST['remarks'];
	$id=$_REQUEST['id'];	

	$sql="update kp_export_batch_serial set last_serial_no='$last_serial_no',processing_location='$processing_location',remarks='$remarks' where id='$id'";
	
	if (!mysqli_query($conn,$sql))
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=manage_export_series.php?action=view\">";
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
	if(document.getElementById('last_serial_no').value == '')
	{
		alert("Please Enter Latest Series");
		document.getElementById('last_serial_no').focus();
		return false;
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Export Applicaiton Certificate Series</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">
            <a href="manage_export_series.php?action=add"><div class="content_head_button">Add New Series</div></a>
            <a href="manage_export_series.php?action=view"><div class="content_head_button">View Series</div></a>
        </div>
<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
        <td>Latest KP certificate Series</td>
        <td>Location</td>
        <td>Remarks</td>
        <td>Status</td>
        <td colspan="2" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";

    $i=1;
	
	$result = mysqli_query($conn,"SELECT * FROM kp_export_batch_serial where 1".$attach." ");
    $rCount=0;
    $rCount = @mysqli_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysqli_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['last_serial_no']; ?></td>
        <td><?php echo getRegionName($conn,$row['processing_location']); ?></td>
        <td><?php echo $row['remarks']; ?></td>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_export_series.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_export_series.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        <td ><a href="manage_export_series.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
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
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysqli_query($conn,"SELECT *  FROM kp_export_batch_serial  where id='$_REQUEST[id]'");
		if($row2 = mysqli_fetch_array($result2))
		{
			$last_serial_no=stripslashes($row2['last_serial_no']);
			$processing_location=stripslashes($row2['processing_location']);
			$remarks=stripslashes($row2['remarks']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Series</td>
    </tr>
    
    <tr>
    <td class="content_txt">Processing Location<span class="star">*</span></td>
    <td>
    <select  class="show-tooltip input_txt" name="PROCES_CNTR" id="PROCES_CNTR">
    <option value="">--Select--</option>
    <?php 
    $sql="select * from  kp_location_master order by LOCATION_NAME asc";
    $result=mysqli_query($conn,$sql);
    while($rows=mysqli_fetch_array($result))
    {
		if($rows[LOCATION_ID]==$processing_location)
		{
			echo "<option  value='$rows[LOCATION_ID]' selected='selected'>$rows[LOCATION_NAME]</option>";
		}
		else
		{
			echo "<option  value='$rows[LOCATION_ID]'>$rows[LOCATION_NAME]</option>";
		}
    }
    ?>
    </select>
    </td>
    </tr>  
    <tr>
        <td class="content_txt">Latest Series<span class="star">*</span></td>
        <td><input type="text" name="last_serial_no" id="last_serial_no" title="" class="show-tooltip input_txt" value="<?php echo $last_serial_no; ?>" />    </td>
    </tr> 
     
    <tr>
    	<td class="content_txt">Remarks<span class="star">*</span></td>
        <td><textarea name="remarks" id="remarks" class="show-tooltip input_txt"><?php echo $remarks; ?></textarea></td>
    <td>
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
