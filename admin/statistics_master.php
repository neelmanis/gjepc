<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');
$admin_id = $_SESSION['curruser_login_id'];
//print_r($_SESSION);exit;
if (($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from statistics_master where id='$_REQUEST[id]'";
	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=statistics_master.php?action=view\">";
}

if (($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{

		$status=$_REQUEST['status'];	
		$id=$_REQUEST['id'];
		$sql="update statistics_master set status='$status' where id='$id'";
		if (!mysql_query($sql,$dbconn))
		{
			die('Error: ' . mysql_error());
		}
		echo"<meta http-equiv=refresh content=\"0;url=statistics_master.php?action=view\">";
}

if ($_REQUEST['action']=='save')
{
//print_r($_POST);exit;
	$hs_code=$_REQUEST['hs_code'];
	$product_name=$_REQUEST['product_name'];
	$unit=$_REQUEST['unit'];
	$status=$_REQUEST['status'];
	$created_by=$admin_id;
        
   
    $sql="INSERT INTO statistics_master (hs_code,product_name,unit,status,created_by) VALUES ('$hs_code','$product_name','$unit','$status','$created_by')";
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
echo"<meta http-equiv=refresh content=\"0;url=statistics_master.php?action=view\">";
	
}
if (($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$hs_code=$_REQUEST['hs_code'];
	$product_name=$_REQUEST['product_name'];
	$unit=$_REQUEST['unit'];
	$status=$_REQUEST['status'];
	$created_by=$admin_id;
	$id=$_REQUEST['id'];
/*	print_r($_POST);exit;*/	

	$sql="update statistics_master set hs_code='$hs_code',product_name='$product_name',unit='$unit',created_by='$created_by' where id='$id'";

	
	if (!mysql_query($sql,$dbconn))
	{
		die('Error: ' . mysql_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=statistics_master.php?action=view\">";
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

.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}

</style>
<script language="javascript">
function checkdata()
{
	hs_code=document.getElementById('hs_code').value;
	if( hs_code=="")
	{
		alert("Please enter Hs Code");
		document.getElementById('hs_code').focus();
		return false;
	}
	product_name=document.getElementById('product_name').value;
	if(product_name=="")
	{
		alert("Please enter  Product Name.");
		document.getElementById('product_name').focus();
		return false;
	}

	unit=document.getElementById('unit').value;
	if( unit=="")
	{
		alert("Please Select Unit");
		document.getElementById('unit').focus();
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
    	<div class="content_head"><a href="statistics_master.php?action=add"><div class="content_head_button">Add New</div></a>  
        <?php if($_REQUEST['action']=='view_details' || $_REQUEST['action']=='edit'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="statistics_master.php?action=view">Back to Import Export Master</a></div>
        <?php }?>
        </div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td ><a href="#">Sr. No.</a></td>
     
        <td >Hs Code </td>
        <td >Product  Name</td>
        <td >Unit </td>
    
        <td>Created By</td>
         <td>status</td>
        
        <td colspan="4" align="center">Action</td>
    </tr>
    
    <?php 
   /* $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'financial_year';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";*/
    
    $i=1;
	$result = mysql_query("SELECT * FROM statistics_master");
    $rCount=0;
    $rCount = @mysql_num_rows($result);		
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
     
        <td><?php echo $row['hs_code'];?></td>
        <td><?php echo $row['product_name']; ?></td>
        <td><?php echo $row['unit']; ?></td>
        
        <td><?php echo $row['created_by']; ?></td>
       
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
		$result2 = mysql_query("SELECT *  FROM statistics_master  where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			$hs_code=$row2['hs_code'];
			$product_name=$row2['product_name'];
			$unit=$row2['unit'];
			$status=$row2['status'];
			
			
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add Import export/Statisics master</td>
    </tr>
    

    
    
     <tr>
      <td valign="middle" class="content_txt">HS Code<span class="star">*</span></td>
      <td>
     
      <input name="hs_code" id="hs_code" class="show-tooltip input_txt" title="Please enter Hs Code" value="<?php echo $hs_code;?>"></input></td>
    </tr>
    
    <tr>
    <td class="content_txt">Product Name <span class="star">*</span></td>
    <td><input type="text" name="product_name" id="product_name" title="Please enter Product name" class="show-tooltip input_txt" value="<?php echo $product_name;?>" />    </td>
    </tr>
         <tr>
      <td valign="middle" class="content_txt">Unit<span class="star">*</span></td>
     
      <td><select type="text" name="unit" id="unit" title="Please enter Unit" class="show-tooltip input_txt" value="<?php echo $unit;?>">
      	<option value="<?php echo $unit;?>"><?php if($unit=="carat"){echo "Carat";}else if($unit=="grams"){echo "Grams";}else{echo "Select unit";} ?></option>
      	<option value="carat">Carat</option>
      	<option value="grams">Grams</option>

      </select></td>
    </tr>
 
     <tr>
      <td valign="middle" class="content_txt">Status<span class="star">*</span></td>
     
      <td><select type="text" name="status" id="status" title="Please enter Commodities Type" class="show-tooltip input_txt" value="<?php echo $status;?>">
      	<option value="<?php echo $status;?>"><?php if($status=="0"){echo "Inactive";}else if($status=="1"){echo "Active";}else{echo "Select Status";} ?></option>
      	<option value="1">Active</option>
      	<option value="0">Inactive</option>

      </select></td>
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

		$result2 = mysql_query("SELECT *  FROM statistics_master  where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{
			
			$hs_code=stripslashes($row2['hs_code']);
			$product_name=stripslashes($row2['product_name']);
			$unit=stripslashes($row2['unit']);
			$created_at=stripslashes($row2['created_at']);
			$created_by=stripslashes($row2['created_by']);
			$status=stripslashes($row2['status']);
		
		}
?>
 <div class="content_details1">
   <table width="100%" border="0" cellspacing="5" cellpadding="5"  >
     <tr class="orange1">
       <td colspan="2">&nbsp;View Details</td>
     </tr>
  
     
     <tr>
       <td class="content_txt">Hs Code</td>
       <td class="text6"><?php echo $hs_code; ?></td>
     </tr>
     
      <tr>
       <td class="content_txt">Product Name</td>
       <td class="text6"><?php echo $product_name; ?></td>
     </tr>
     
     <tr>
       <td class="content_txt">Unit  </td>
       <td class="text6"><?php echo $unit; ?></td>
     </tr> 
     <tr>
       <td class="content_txt">created at </td>
       <td class="text6"><?php echo $created_at; ?></td>
     </tr>
     <tr>
       <td class="content_txt">created By </td>
       <td class="text6"><?php echo $created_by; ?></td>
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
