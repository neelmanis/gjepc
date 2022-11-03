<?php 
session_start();
if(!isset($_SESSION['curruser_contact_name'])){ header('Location: index.php'); exit; } 
if(!isset($_SESSION['curruser_login_id'])){	header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['company_name']="";
  $_SESSION['financial_year']="";
  $_SESSION['iec_no']="";
  header("Location: manage_history_certificate.php?action=view");
}else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
		$_SESSION['company_name']=filter($_REQUEST['company_name']);
		$_SESSION['financial_year']=filter($_REQUEST['financial_year']);
		$_SESSION['iec_no']=filter($_REQUEST['iec_no']);
	}
}
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage History Certificate ||GJEPC||</title>
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


</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div></div>
<div class="clear"></div>

<div class="breadcome_wrap"><div class="breadcome"><a href="#">Home</a> > Manage History Certificate</div></div>

<div id="main">
	<div class="content">
    	<div class="content_head">Manage History Certificate</div>
<div class="content_details1">
<?php 
if($_SESSION['succ_msg']!=""){
	echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
	$_SESSION['succ_msg']="";
}
?>
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1"><td colspan="11">Search Options</td></tr>
<tr>
    <td width="19%" ><strong>Select Financial Year</strong></td>
    <td width="81%">
		<select name="financial_year" id="financial_year">
		    <option value="">--Select Financial Year--</option>
			<option value="20-21" <?php if($_SESSION['financial_year']=="20-21"){?> selected="selected" <?php }?>>2020-2021</option>
			<option value="21-22" <?php if($_SESSION['financial_year']=="21-22"){?> selected="selected" <?php }?>>2021-2022</option>
		</select>			
	</td>
</tr> 
<tr>
    <td width="19%" ><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" /></td>
</tr>     
<tr >
  <td><strong>IEC No.</strong></td>
  <td><input type="text" name="iec_no" id="iec_no" class="input_txt" value="<?php echo $_SESSION['iec_no'];?>" /></td>
</tr>
<tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> 
	<input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<?php if($_REQUEST['search_type']=='SEARCH') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td width="5%"><a href="#">Sr. No.</a></td>
        <td width="25%">Company Name</td>
        <td width="25%">IEC No.</td>
		<td width="25%" colspan='3'>Action</td>
    </tr>   
    <?php     
    $sql="SELECT a.id as `RegID`,a.company_name,b.iec_no,c.* FROM registration_master a, information_master b,membership_certificate_history c where a.id=b.registration_id and a.id=c.registration_id";
	
	if($_SESSION['company_name']!="")
	{
		$sql.=" and a.company_name like '%".$_SESSION['company_name']."%'";
	}
	if($_SESSION['financial_year']!="")
	{
		$sql.=" and c.financial_year like '%".$_SESSION['financial_year']."%'";
	}
	if($_SESSION['iec_no']!="")
	{
		$sql.=" and b.iec_no like '%".$_SESSION['iec_no']."%'";
	}
	//echo $sql;
	$result = $conn ->query($sql);
	$rCount  = $result->num_rows;	
    if($rCount>0)
    {	
	$i=1;
	while($row = $result->fetch_assoc())
	{ 
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['company_name']; ?></td>
		<td width="5%"><?php echo $row['iec_no']; ?></td>
		<?php if($row['financial_year']=="20-21"){ ?>
        <td width="20%"><a href='../rcmc/membership_history.php?registration_id=<?php echo $row['RegID'];?>' target='_blank'>Download Membership certificate</a></td>
		<td width="15%"><a href='../rcmc/print_certificate_history.php?registration_id=<?php echo $row['RegID'];?>' target='_blank'> Download RCMC</a></td>
        <td width="15%"><a href='../rcmc/invoice_history.php?registration_id=<?php echo $row['RegID'];?>' target='_blank'> Download Invoice</a></td>
		<?php } else { ?>
		<td width="20%"><a href='../rcmc/membership_historyfy.php?registration_id=<?php echo $row['RegID'];?>&fy=<?php echo $row['financial_year'];?>' target='_blank'>Download Membership certificate</a></td>
		<td width="15%"><a href='../rcmc/print_certificate_history.php?registration_id=<?php echo $row['RegID'];?>' target='_blank'> Download RCMC</a></td>
        <td width="15%"><a href='../rcmc/invoice_historyfy.php?registration_id=<?php echo $row['RegID'];?>&fy=<?php echo $row['financial_year'];?>' target='_blank'> Download Invoice</a></td>
		<?php } ?>
        
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
    <?php  }  ?>
</table>
</div>
<?php } ?> 
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>