<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit;}
include('../db.inc.php');
include('../functions.php'); 
?>
<?php
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from import_export_quarter_year_master where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("i", intval($_REQUEST['id']));
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=import_export_quarter_year_master.php?action=view\">"; }
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = intval(filter($_REQUEST['id']));
	$sql  =	"update import_export_quarter_year_master set status=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("si", $status,$id);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=import_export_quarter_year_master.php?action=view\">"; }
}

if($_REQUEST['action']=='save')
{
	$quarter_year=trim($_REQUEST['quarter_year']);
	$status=$_REQUEST['status'];
    $post_date = date("Y-m-d H:i:s");    
   
	$sql="INSERT INTO import_export_quarter_year_master (quarter_year,status,post_date) VALUES ('$quarter_year','$status','$post_date')";
	$result = $conn ->query($sql);   
    if(!$result) die ($conn->error);
	echo "<meta http-equiv=refresh content=\"0;url=import_export_quarter_year_master.php?action=view\">";
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$quarter_year=trim($_REQUEST['quarter_year']);	
	$status = filter($_REQUEST['status']);
	$id = filter($_REQUEST['id']);
	$sql = "update import_export_quarter_year_master set quarter_year='$quarter_year',status='$status' where id='$id'";
	$result = $conn ->query($sql);   
    if(!$result) die ($conn->error);
	echo "<meta http-equiv=refresh content=\"0;url=import_export_quarter_year_master.php?action=view\">";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Import Export Year Master ||GJEPC||</title>

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
	quarter_year=document.getElementById('quarter_year').value;
	if(quarter_year=="")
	{
		alert("Please enter Quarter Year.");
		document.getElementById('quarter_year').focus();
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
    	<div class="content_head"><a href="import_export_quarter_year_master.php?action=add"><div class="content_head_button">Add New</div></a>  
        <?php if($_REQUEST['action']=='view_details' || $_REQUEST['action']=='edit'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="import_export_quarter_year_master.php?action=view">Back to Import Export Quarter Year  Master</a></div>
        <?php }?>
        </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>     
        <td >Quarter Year</td>
        <td>Created at</td>
        <td>status</td>        
        <td colspan="4" align="center">Action</td>
    </tr>
    
    <?php 
   /* $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'financial_year';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";*/
    
    $i=1;
	$result =  $conn ->query("SELECT * FROM import_export_quarter_year_master  ");
    $rCount=0;
    $rCount = $result->num_rows;	
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>     
        <td><?php echo $row['quarter_year'];?></td>       
        <td><?php echo $row['post_date']; ?></td>       
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="import_export_quarter_year_master.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="import_export_quarter_year_master.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="import_export_quarter_year_master.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/view.png" title="View" border="0" /></a></td>
        <td ><a href="import_export_quarter_year_master.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.gif" alt="Edit" width="15" height="15" border="0" /></a></td>
        <td ><a href="import_export_quarter_year_master.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$result2 = $conn ->query("SELECT * FROM import_export_quarter_year_master where id='$_REQUEST[id]'");
		if($row2 = $result2->fetch_assoc())
		{			
			$quarter_year=$row2['quarter_year'];
			$status=$row2['status'];			
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add Import export Quarter Year</td>
    </tr>
    
     <tr>
      <td valign="middle" class="content_txt">Quarter year<span class="star">*</span></td>
      <td>
     
      <input name="quarter_year" id="quarter_year" class="show-tooltip input_txt" title="Please enter Quarter Year" value="<?php echo $quarter_year;?>"></input></td>
    </tr>
     
    <tr>
      <td valign="middle" class="content_txt">Status<span class="star">*</span></td>     
      <td>
	  <select type="text" name="status" id="status" title="Please enter Commodities Type" class="show-tooltip input_txt" value="<?php echo $status;?>">
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

		$result3 = $conn ->query("SELECT * FROM import_export_quarter_year_master where id='$_REQUEST[id]'");
		if($row2 = $result3->fetch_assoc())
		{
			$quarter_year=stripslashes($row2['quarter_year']);
			$created_at=stripslashes($row2['post_date']);
			$status=stripslashes($row2['status']);		
		}
?>
 <div class="content_details1">
   <table width="100%" border="0" cellspacing="5" cellpadding="5"  >
     <tr class="orange1">
       <td colspan="2">&nbsp;View Details</td>
     </tr>  
     <tr>
       <td class="content_txt">Quarter Year</td>
       <td class="text6"><?php echo $quarter_year; ?></td>
     </tr>     
     <tr>
       <td class="content_txt">created at </td>
       <td class="text6"><?php echo $post_date; ?></td>
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