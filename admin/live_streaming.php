<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php 
$adminID=$_SESSION['curruser_login_id'];
$id = $_REQUEST['id'];

if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from live_streaming where id='$_REQUEST[id]'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=live_streaming.php?action=view\">";
}

if (($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
		$status=$_REQUEST['status'];	
		$id=$_REQUEST['id'];
		$sql="update live_streaming set status='$status' where id='$id'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=live_streaming.php?action=view\">";
}

if ($_REQUEST['action']=='save')
{	
	$status =  $_REQUEST['status'];
	$events =  mysql_real_escape_string(strip_tags($_REQUEST['events']));
	$iframe_url =  mysql_real_escape_string(strip_tags($_REQUEST['iframe_url']));	
	$post_date = mysql_real_escape_string(date("Y-m-d",strtotime($_REQUEST['post_date'])));
	
  $sql="INSERT INTO live_streaming set adminId='$adminID', events='$events', iframe_url='$iframe_url',post_date=NOW(), status='$status'";			
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=live_streaming.php?action=view\">";

}
if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{	
	$status = $_REQUEST['status'];
	$events =  mysql_real_escape_string(strip_tags($_REQUEST['events']));
	$iframe_url =  mysql_real_escape_string(strip_tags($_REQUEST['iframe_url']));
	$post_date = mysql_real_escape_string(date("Y-m-d",strtotime($_REQUEST['post_date'])));

	//------------------------------------   ----------------------------------------------------------		
	$sql="update live_streaming set adminId='$adminID', events='$events', iframe_url='$iframe_url', modified_date=NOW(),status='$status' where id='$id'";
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=live_streaming.php?action=view\">";
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

<link href="../css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#post_date').datepick();

});
</script><style type="text/css">
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
	if(document.getElementById('events').value == '')
	{
		alert("Please Enter Events Name.");
		document.getElementById('name').focus();
		return false;
	}

	<?php
	if($_REQUEST['action']!='edit')
	{
	?>
	
	if(document.getElementById('events').value == '')
	{
		alert("Please Enter Events.");
		document.getElementById('events').focus();
		return false;
	}
	if(document.getElementById('iframe_url').value == '')
	{
		alert("Please Enter Embeded Code.");
		document.getElementById('iframe_url').focus();
		return false;
	}
<?php } ?>

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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Live Streaming</div>
</div>

<div id="main">
	<div class="content">
    	<!--<div class="content_head"><a href="live_streaming.php?action=add"><div class="content_head_button">Add Gold Rate</div></a> <a href="live_streaming.php?action=view"><div class="content_head_button">View Gold Rate</div></a> </div>-->

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Events</td>
        <td>URL</td>
		<td>Post Date</td>
        <td>Status</td>
        <td colspan="4" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'asc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = mysql_query("SELECT * FROM live_streaming where 1".$attach." ");
    $rCount=0;
    $rCount = @mysql_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
	    <td><?php echo strip_tags($row['events']); ?></td>
        <td><?php echo strip_tags($row['iframe_url']); ?></td>			
		<td><?php echo strip_tags(date("d-m-Y",strtotime($row['post_date']))); ?></td>
		<td><?php echo strip_tags($row['status']); ?></td>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="live_streaming.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="live_streaming.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="live_streaming.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="live_streaming.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$result2 = mysql_query("SELECT * FROM live_streaming where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			$id=stripslashes($row2['id']);
			$events=stripslashes($row2['events']);	
			$iframe_url=stripslashes($row2['iframe_url']);
			$status=stripslashes($row2['status']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Video</td>
    </tr>  	
    <tr>
      <td class="content_txt">Events :<span class="star">*</span></td>
      <td><input type="text" name="events" id="events" class="input_txt" value="<?php echo $events; ?>"/></td>
    </tr>    
    <tr>
    <td class="content_txt">Iframe Code<span class="star">*</span></td>
    <td><input type="text" name="iframe_url" id="iframe_url" class="input_txt" value="<?php echo $iframe_url; ?>"/></td>
    </tr>   
	<tr>
    <td class="content_txt">Status <span class="star">*</span></td>
    <td>
    <select name="status" id="status" class="input_txt">
    <option value="">Select Status</option>
    <option value="1" <?php if($status=="1"){echo "selected='selected'";} ?>>Active</option>
    <option value="0" <?php if($status=="0"){echo "selected='selected'";} ?>>Inactive</option>
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

</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>