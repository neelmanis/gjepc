<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit;}
include('../db.inc.php');
include('../functions.php'); 
?>
<?php
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from statistics_master where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("i", intval($_REQUEST['id']));
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=import_export_master.php?action=view\">"; }
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = intval(filter($_REQUEST['id']));
	$sql  =	"update statistics_master set status=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("si", $status,$id);
	if($stmt->execute()){		echo"<meta http-equiv=refresh content=\"0;url=import_export_master.php?action=view\">"; }
}

if($_REQUEST['action']=='save')
{
	$commodities_type=$_REQUEST['commodities_type'];
	$commodities_code=$_REQUEST['commodities_code'];
	$commodities_name=$_REQUEST['commodities_name'];
	$status=$_REQUEST['status'];
   
	$sql="INSERT INTO statistics_master (commodities_code,commodities_name,status) VALUES ('$commodities_code','$commodities_name','$status')";
	$result = $conn ->query($sql);   
    if(!$result) die ($conn->error);
	echo"<meta http-equiv=refresh content=\"0;url=import_export_master.php?action=view\">";
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$commodities_type=$_REQUEST['commodities_type'];
	$commodities_code=$_REQUEST['commodities_code'];
	$commodities_name=$_REQUEST['commodities_name'];
	$status=$_REQUEST['status'];
	$id=$_REQUEST['id'];

	$sql="update statistics_master set commodities_code='$commodities_code',commodities_name='$commodities_name',status='$status' where id='$id'";
	$result = $conn ->query($sql);   
    if(!$result) die ($conn->error);
	echo"<meta http-equiv=refresh content=\"0;url=import_export_master.php?action=view\">";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Import Export Master ||GJEPC||</title>

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
	commodities_type=document.getElementById('commodities_type').value;
	if( commodities_type=="")
	{
		alert("Please enter commodities type");
		document.getElementById('commodities_type').focus();
		return false;
	}
	commodities_code=document.getElementById('commodities_code').value;
	if(commodities_code=="")
	{
		alert("Please enter export commodities code.");
		document.getElementById('commodities_code').focus();
		return false;
	}

	commodities_name=document.getElementById('commodities_name').value;
	if( commodities_name=="")
	{
		alert("Please enter export commodities name");
		document.getElementById('commodities_name').focus();
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Registration</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><a href="statistics_master.php?action=add"><div class="content_head_button">Add New</div></a>  
        <?php if($_REQUEST['action']=='view_details' || $_REQUEST['action']=='edit'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="statistics_master.php?action=view">Back to Import Export Master</a></div>
        <?php }?>
        </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>     
        <td>Commodities Code</td>
        <td>commodities Name</td>    
        <td>Created at</td>
        <td>status</td>        
        <td colspan="4" align="center">Action</td>
    </tr>
    
    <?php 
   /* $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'financial_year';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";*/
    
    $i=1;
	$result =  $conn ->query("SELECT * FROM statistics_master ");
    $rCount=0;
    $rCount = $result->num_rows;		
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>     
        <td><?php echo $row['hs_code'];?></td>
        <td><?php echo $row['product_name']; ?></td>        
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="statistics_master.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="statistics_master.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="statistics_master.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/view.png" title="View" border="0" /></a></td>
        <td ><a href="statistics_master.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.gif" alt="Edit" width="15" height="15" border="0" /></a></td>
        <td ><a href="statistics_master.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$sql3 = "SELECT * FROM statistics_master where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", intval($_REQUEST['id']));
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$commodities_type=$row2['commodities_type'];
			$commodities_code=$row2['commodities_code'];
			$commodities_name=$row2['commodities_name'];
			$status=$row2['status'];			
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add Import export master</td>
    </tr>
    
    <tr>
    <td valign="middle" class="content_txt">Commodities  Code<span class="star">*</span></td>
    <td>     
    <input name="commodities_code" id="commodities_code" class="show-tooltip input_txt" title="Please enter Commodities Code" value="<?php echo $commodities_code;?>"></input></td>
    </tr>
    
    <tr>
    <td class="content_txt">Commodities Name <span class="star">*</span></td>
    <td><input type="text" name="commodities_name" id="commodities_name" title="Please enter Commodities name" class="show-tooltip input_txt" value="<?php echo $commodities_name;?>" />    </td>
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

		$sql2 = "SELECT * FROM statistics_master where id=?";
		$query = $conn -> prepare($sql2);
		$query -> bind_param("i", intval($_REQUEST['id']));
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{			
			$commodities_code=stripslashes($row2['commodities_code']);
			$commodities_name=stripslashes($row2['commodities_name']);
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
       <td class="content_txt">Commodities Code</td>
       <td class="text6"><?php echo $commodities_code; ?></td>
     </tr>
     
      <tr>
       <td class="content_txt">Commodities Name</td>
       <td class="text6"><?php echo $commodities_name; ?></td>
     </tr>
         
     <tr>
       <td class="content_txt">created at </td>
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