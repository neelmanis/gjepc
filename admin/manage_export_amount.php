<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit;}
include('../db.inc.php');
include('../functions.php'); 
?>
<?php 
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from export_amount_master where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("i", intval($_REQUEST['id']));
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=manage_export_amount.php?action=view\">"; }
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = intval(filter($_REQUEST['id']));
	$sql="update export_amount_master set status=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("si", $status,$id);
	if($stmt->execute()){		echo"<meta http-equiv=refresh content=\"0;url=manage_export_amount.php?action=view\">"; }
}

if($_REQUEST['action']=='save')
{
	$financial_year=$_REQUEST['financial_year'];
	$export_performance_desc=$_REQUEST['export_performance_desc'];
	$export_start_amount=addslashes($_REQUEST['export_start_amount']);
	$export_end_amount=addslashes($_REQUEST['export_end_amount']);
	$membership_fee=addslashes($_REQUEST['membership_fee']);
	$admission_fee=addslashes($_REQUEST['admission_fee']);
	$ad_valorem=$_REQUEST['ad_valorem'];
	$total_amount=addslashes($_REQUEST['total_amount']);

$sql="INSERT INTO export_amount_master (financial_year,export_performance_desc,export_start_amount,export_end_amount,membership_fee,admission_fee,ad_valorem,total_amount) VALUES ('$financial_year','$export_performance_desc','$export_start_amount','$export_end_amount','$membership_fee','$admission_fee','$ad_valorem','$total_amount')";	
$result = $conn ->query($sql);   
if (!$result) die ($conn->error);
echo"<meta http-equiv=refresh content=\"0;url=manage_export_amount.php?action=view\">";
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$financial_year=$_REQUEST['financial_year'];
	$export_performance_desc=$_REQUEST['export_performance_desc'];
	$export_start_amount=addslashes($_REQUEST['export_start_amount']);
	$export_end_amount=addslashes($_REQUEST['export_end_amount']);
	$membership_fee=addslashes($_REQUEST['membership_fee']);
	$admission_fee=addslashes($_REQUEST['admission_fee']);
	$ad_valorem=$_REQUEST['ad_valorem'];
	$total_amount=addslashes($_REQUEST['total_amount']);
	$id=$_REQUEST['id'];	

	$sql="update export_amount_master set financial_year='$financial_year',export_performance_desc='$export_performance_desc',export_start_amount='$export_start_amount',export_end_amount='$export_end_amount', membership_fee='$membership_fee',admission_fee='$admission_fee',ad_valorem='$ad_valorem',total_amount='$total_amount' where id='$id'";
	$result = $conn ->query($sql);   
	if (!$result) die ($conn->error);
	echo"<meta http-equiv=refresh content=\"0;url=manage_export_amount.php?action=view\">";
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Export Amount ||GJEPC||</title>

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
	financial_year=document.getElementById('financial_year').value;
	if(isNaN(financial_year) || financial_year=="")
	{
		alert("Please enter financial year");
		document.getElementById('financial_year').focus();
		return false;
	}
	export_performance_desc=document.getElementById('export_performance_desc').value;
	if(export_performance_desc=="")
	{
		alert("Please enter export performance desc.");
		document.getElementById('export_performance_desc').focus();
		return false;
	}

	export_start_amount=document.getElementById('export_start_amount').value;
	if(isNaN(export_start_amount) || export_start_amount=="")
	{
		alert("Please enter export start amount");
		document.getElementById('export_start_amount').focus();
		return false;
	}
	export_end_amount=document.getElementById('export_end_amount').value;
	if(isNaN(export_end_amount) || export_end_amount=="")
	{
		alert("Please enter export end amount");
		document.getElementById('export_end_amount').focus();
		return false;
	}
	membership_fee=document.getElementById('membership_fee').value;
	if(isNaN(membership_fee) || membership_fee=="")
	{
		alert("Please enter membership fees")
		document.getElementById('membership_fee').focus();
		return false;
	} 
	admission_fee=document.getElementById('admission_fee').value;
	if(isNaN(admission_fee) || admission_fee=="")
	{
		alert("Please enter admission fees")
		document.getElementById('admission_fee').focus();
		return false;
	}
	ad_valorem=document.getElementById('ad_valorem').value;
	if(isNaN(ad_valorem) || ad_valorem=="")
	{
		alert("Please enter Ad Valorem fees")
		document.getElementById('ad_valorem').focus();
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Export Amount</div>
</div>

<div id="main">
	<div class="content">
    <div class="content_head"><a href="manage_export_amount.php?action=add"><div class="content_head_button">Add New</div></a>  <a href="manage_export_amount.php?action=view"><div class="content_head_button">Manage Export Amount</div> </a>
    <?php if($_REQUEST['action']=='view_details' || $_REQUEST['action']=='edit'){?>
    <div style="float:right; padding-right:10px; font-size:12px;"><a href="manage_export_amount.php?action=view">Back to Export Amount</a></div>
    <?php } ?>
    </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
        <td >Financial year</td>
        <td >Export Start Amount</td>
        <td >Export End Amount</td>
        <td>Membership Fees</td>
        <td>Ad Valorem</td>
        <td >Total Amount</td>
        <td>Status</td>
        <td colspan="4" align="center">Action</td>
    </tr>
    
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'financial_year';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$result = $conn ->query("SELECT * FROM export_amount_master where 1".$attach." ");
    $rCount=0;
    $rCount = $result->num_rows;		
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo filter($row['financial_year']);?></td>
        <td><?php echo $row['export_start_amount'];?></td>
        <td><?php echo $row['export_end_amount']; ?></td>
        <td><?php echo $row['membership_fee']; ?></td>
        <td><?php echo $row['ad_valorem']; ?></td>
        <td><?php echo $row['total_amount']; ?></td>
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="manage_export_amount.php?id=<?php echo $row['id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="manage_export_amount.php?id=<?php echo $row['id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="manage_export_amount.php?action=view_details&id=<?php echo $row['id']?>"><img src="images/view.png" title="View" border="0" /></a></td>
        <td ><a href="manage_export_amount.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.gif" alt="Edit" width="15" height="15" border="0" /></a></td>
        <td ><a href="manage_export_amount.php?action=del&id=<?php echo $row['id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
		$sql3 = "SELECT * FROM export_amount_master where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", intval($_REQUEST['id']));
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$financial_year = filter($row2['financial_year']);
			$export_performance_desc=$row2['export_performance_desc'];
			$export_start_amount=$row2['export_start_amount'];
			$export_end_amount=$row2['export_end_amount'];
			$membership_fee=$row2['membership_fee'];
			$admission_fee=$row2['admission_fee'];
			$ad_valorem=$row2['ad_valorem'];
			$total_amount=$row2['total_amount'];
			$status=$row2['status'];			
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Export Amount</td>
    </tr>
    
   <tr>
      <td valign="top" class="content_txt">Financial Year<span class="star">*</span></td>
      <td><input type="text" name="financial_year" id="financial_year" title="Please enter financial year" class="show-tooltip input_txt" value="<?php echo $financial_year; ?>" /></td>
    </tr>
        
     <tr>
      <td valign="top" class="content_txt">Export Performance Desc<span class="star">*</span></td>
      <td>
      <textarea  name="export_performance_desc" id="export_performance_desc" class="show-tooltip input_txt"><?php echo $export_performance_desc; ?></textarea>
      
     <!-- <input type="text" title="Please enter export performance description" class="show-tooltip input_txt" value="" />--></td>
    </tr>
    
    <tr>
    <td class="content_txt">Export Start Amount<span class="star">*</span></td>
    <td><input type="text" name="export_start_amount" id="export_start_amount" title="Please enter your name" class="show-tooltip input_txt" value="<?php echo $export_start_amount; ?>" />    </td>
    </tr>
   
    <tr>
      <td valign="top" class="content_txt">Export End Amount<span class="star">*</span></td>
      <td><input type="text" name="export_end_amount" id="export_end_amount" title="Please enter your name" class="show-tooltip input_txt" value="<?php echo $export_end_amount; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Membership Fees<span class="star">*</span></td>
    <td><input type="text" name="membership_fee" id="membership_fee" class="input_txt" value="<?php echo $membership_fee; ?>" /></td>
    </tr>    
    
    <tr>
    <td class="content_txt">Admission Fees<span class="star">*</span></td>
    <td><input type="text" name="admission_fee" id="admission_fee" class="input_txt" value="<?php echo $admission_fee; ?>" /></td>
    </tr>
    
    <tr>
    <td class="content_txt">Ad Valorem<span class="star">*</span></td>
    <td><input type="text" name="ad_valorem" id="ad_valorem" class="input_txt" value="<?php echo $ad_valorem; ?>" onkeyup="getexportdata()" /></td>
    </tr>

    <tr>
    <td class="content_txt">Total Amount</td>
    <td><input type="text" name="total_amount" id="total_amount" class="input_txt" value="<?php echo $total_amount; ?>" readonly="readonly" /></td>
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

		$sql4 = "SELECT * FROM export_amount_master where id=?";
		$query = $conn -> prepare($sql4);
		$query -> bind_param("i", intval($_REQUEST['id']));
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$financial_year=stripslashes($row2['financial_year']);
			$export_start_amount=stripslashes($row2['export_start_amount']);
			$export_end_amount=stripslashes($row2['export_end_amount']);
			$membership_fee=stripslashes($row2['membership_fee']);
			$admission_fee=stripslashes($row2['admission_fee']);
			$ad_valorem=$row2['ad_valorem'];
			$total_amount=stripslashes($row2['total_amount']);
			$status=stripslashes($row2['status']);
		}
?>
 <div class="content_details1">
   <table width="100%" border="0" cellspacing="5" cellpadding="5"  >
     <tr class="orange1">
       <td colspan="2">&nbsp;View Details</td>
     </tr>
     <tr>
       <td class="content_txt" width="15%">Export Start Amount </td>
       <td class="text6"><?php echo $export_start_amount; ?></td>
     </tr>
     
     <tr>
       <td class="content_txt">Export End Amount</td>
       <td class="text6"><?php echo $export_end_amount; ?></td>
     </tr>
     
      <tr>
       <td class="content_txt">Membership Fees</td>
       <td class="text6"><?php echo $membership_fee; ?></td>
     </tr>
     
     <tr>
       <td class="content_txt">Ad Valorem </td>
       <td class="text6"><?php echo $ad_valorem; ?></td>
     </tr>
     <tr>
       <td class="content_txt">Admission Fees </td>
       <td class="text6"><?php echo $admission_fee; ?></td>
     </tr>
     <tr>
       <td class="content_txt">Total Amount </td>
       <td class="text6"><?php echo $total_amount; ?></td>
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
