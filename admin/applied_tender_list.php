<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit;}
include('../db.inc.php');
include('../functions.php'); 
?>
<?php 
function getTenderName($id)
{
	global $conn;
	$query_sel = "SELECT name FROM tender_master where id=?";	
	$query = $conn -> prepare($query_sel);
	$query -> bind_param("i", $id);
	$query -> execute();	
	$rowx = $query -> get_result();
	if($row = $rowx -> fetch_assoc())
	{		
		return $row['name'];
	}
}
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['tender_id']=""; 
  header("Location: applied_tender_list.php");
}else
{ 
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
		$_SESSION['tender_id']=$_REQUEST['tender_id'];
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

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Applied tender List</div>
</div>

<div id="main">
	<div class="content">
<?php if($_REQUEST['action']=='view') {?>
<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
<tr >
    <td width="19%" ><strong>Tender List</strong></td>
    <td width="81%">
    <select name="tender_id" id="tender_id">
    <option value="">--Select Tender--</option>
    <?php 
	$sql1="select * from tender_master where 1";
	$query = $conn -> prepare($sql1);
	$query->execute();			
	$row = $query->get_result();
	while($result = $row->fetch_assoc()){ ?>
    <option value="<?php echo filter($result['id']);?>" <?php if($_SESSION['tender_id']==$result['id']){?> selected="selected"<?php }?>><?php echo filter($result['name']);?></option>
    <?php } ?>
    </select>
    </td>
</tr>    
<tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>
</table>
</form>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
    <tr class="orange1">
      <td><a href="#">Sr. No.</a></td>
      <td>Tender Name</td>
      <td>Name</td>
      <td>Company Name</td>
      <td>Email</td>
      <td>Address</td>
      <td>Mobile</td>
    </tr>
    <?php 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	$sql="SELECT * FROM tender_download_info where 1";
	if($_SESSION['tender_id'])
	{
		$sql.=" and tender_id='".$_SESSION['tender_id']."'";
	}
	$query = $conn -> prepare($sql);
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
      <td><?php echo getTenderName(stripslashes($row['tender_id'])); ?></td>
      <td><?php echo stripslashes($row['name']); ?></td>
      <td><?php echo stripslashes($row['company_name']); ?></td>
      <td><?php echo stripslashes($row['email']); ?></td>
      <td><?php echo $row['address'] ?></td>
      <td><?php echo $row['mobile']; ?></td>
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
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>

</body>
</html>