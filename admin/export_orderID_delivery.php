<?php 
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
?>
<?php 
function getStateName($id)
{
	$query_sel = "SELECT state_name FROM  state_master  where state_code='$id'";
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['state_name'];
		
	}
}
?>

<?php
if(isset($_POST['export']))
{ //echo $_SESSION['event_name']; print_r($_POST); exit;
$table = $display = "";	
$fn = "report";

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>ID</td>
<td>Company Name</td>
<td>Company PAN</td>
<td>Company GST</td>
<td>Order ID</td>
<td>Payment Date</td>
<td>Payment Status</td>
<td>Visitor Name</td>
<td>address1</td>
<td>address2</td>
<td>State</td>
<td>City</td>
<td>Pincode</td>
</tr>';

$sql="select oh.create_date as 'create_date', rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn, oh.orderId, vd.name as 'visitor_name', oh.payment_made_for as 'Payment', oh.amount as 'Amount', oh.payment_status as 'payment_status' from visitor_order_history oh inner join registration_master rm on oh.registration_id=rm.id inner join visitor_directory vd on oh.visitor_id=vd.visitor_id where oh.payment_status='Y' and oh.status = '1'";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{	
$registration_id=$row['id'];
$company_name=$row['company_name'];
$company_pan_no=$row['company_pan_no'];
$company_gstn=$row['company_gstn'];
$orderid=$row['orderId'];
$visitor_name=$row['visitor_name'];
$payment_status=$row['payment_status'];
$payment_date = date("d-m-Y", strtotime($row['create_date']));

		$getAddress ="SELECT * FROM `registration_master` WHERE `id` = '$registration_id'";
		$getAddressResult = mysql_query($getAddress);
		$getAddressRow = mysql_fetch_array($getAddressResult);
		$address_line1=strtoupper($getAddressRow['address_line1']);
		$address_line2=strtoupper($getAddressRow['address_line2']);
		$city=strtoupper($getAddressRow['city']);
		$country=strtoupper($getAddressRow['country']);
		$state=strtoupper(getStateName($getAddressRow['state']));
		$pincode=$getAddressRow['pin_code'];
		
		$getapplication ="SELECT * FROM `visitor_order_detail` WHERE `regId` = '$registration_id' AND orderId='$orderid' AND payment_status='$payment_status'";
		$getApplicationResult = mysql_query($getapplication);
		$getApplicationRow=mysql_fetch_array($getApplicationResult);
		$type_of_member = $getApplicationRow['type_of_member'];
		$delivery_id = $getApplicationRow['delivery_id'];

		if($type_of_member == "M"){
		$addflag = "SELECT * FROM `communication_address_master` WHERE `address_identity`='CTC' and `registration_id`='$registration_id' AND id='$delivery_id'";
		$deliveryQuery = mysql_query($addflag);
		$deliveryResult = mysql_fetch_array($deliveryQuery);
		$d_address1=strtoupper($deliveryResult['address1']);
		$d_address2=strtoupper($deliveryResult['address2']);
		$d_city=strtoupper($deliveryResult['city']);
		$d_country=strtoupper($deliveryResult['country']);
		$d_state=strtoupper(getStateName($deliveryResult['state']));
		$d_pincode=$deliveryResult['pincode'];
		} else {
		$addflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id' AND id='$delivery_id'";
		$deliveryQuery = mysql_query($addflag);
		$deliveryResult = mysql_fetch_array($deliveryQuery);
		$d_address1=strtoupper($deliveryResult['address1']); if($d_address1==""){ $d_address1=$address_line1; } else { $d_address1; } 
		$d_address2=strtoupper($deliveryResult['address2']); if($d_address2==""){ $d_address2=$address_line2; } else { $d_address2; } 
		$d_city=strtoupper($deliveryResult['city']);		 if($d_city==""){ $d_city=$city; } else { $d_city; } 
		$d_country=strtoupper($deliveryResult['country']);	 if($d_country==""){ $d_country=$country; } else { $d_country; } 
		$d_state=strtoupper(getStateName($deliveryResult['state'])); if($d_state==""){ $d_state=$state; } else { $d_state; } 
		$d_pincode=$deliveryResult['pin_code'];				 if($d_pincode==""){ $d_pincode=$pincode; } else { $d_pincode; } 
		}
	
$table .= '<tr>
<td>'.$registration_id.'</td>
<td>'.$company_name.'</td>
<td>'.$company_pan_no.'</td>
<td>'.$company_gstn.'</td>
<td>'.$orderid.'</td>
<td>'.$payment_date.'</td>
<td>'.$payment_status.'</td>
<td>'.$visitor_name.'</td>
<td>'.$d_address1.'</td>
<td>'.$d_address2.'</td>
<td>'.$d_state.'</td>
<td>'.$d_city.'</td>
<td>'.$d_pincode.'</td>
</tr>';
	
}
$table .= $display;
$table .= '</table>';

		header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=$fn.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
exit;	
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Registration ||GJEPC||</title>

<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>  
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

<style type="text/css">

.content_details1 table td a,a.add_button2{ margin-top:10px; margin-left:10px;vertical-align: text-bottom;color:#FF0000}

.trade_lable {
    width: 138px;
    height: 20px;
    float: left;
    margin-right: 0px;
    font-family: "Lucida Sans";
    font-size: 11px;
    color: #666666;
    padding-top: 3px;
    font-weight: normal;
}
</style>
<!--navigation end-->
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Export MAI Event wise Report</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">Export MAI Event wise Report
        <?php if($_REQUEST['action']=='view_details'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="export_mai_report.php?action=view">Back to Application Form</a></div>
        <?php }?>
        <!--<a href="export_member_list.php">Export Member List</a>-->
        </div>
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
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
 
<tr>
  <td><strong>Event Name</strong></td>
  <td>
  <select name="event_name" id="event_name" class="input_txt">
    <option value="">Please Select Event</option>	
    <?php 
	$sql="select * from mia_event where status=1";
	$result=mysql_query($sql);
	while($rows=mysql_fetch_array($result))
	{
	if($_SESSION['event_name']==$rows['event_name'])
	{
	echo "<option value='$rows[event_name]' selected='selected'>$rows[event_name]</option>";
	}else
	{
	echo "<option value='$rows[event_name]'>$rows[event_name]</option>";
	}
	}
	?>    
    </select>
  </td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" />
	<input type="submit" name="Reset" value="Reset"  class="input_submit" />
	<td><input type="submit" name="export" value="Export" class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td width="5%"><a href="#">Sr. No.</a></td>
        <td width="25%">Event Name</td>
        <td width="25%">Partcipating Company</td>
        <td width="10%">Type of Company</td>
        <td width="15%">Email ID</td>
		<td width="10%">Application Status</td>
    </tr>
    
    <?php 
	
 	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'mia_application_form.post_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
    $sql="SELECT * FROM `mia_application_form` WHERE 1";
	
	if($_SESSION['event_name']!="")
	{
	$sql.=" and mia_application_form.event_name like '%".$_SESSION['event_name']."%'";
	}
	
	if($_SESSION['participant_company_name']!="")
	{
	$sql.=" and mia_application_form.participant_company_name like '%".$_SESSION['participant_company_name']."%'";
	}
	
	if($_SESSION['company_type']!="")
	{
	$sql.=" and mia_application_form.company_type like '%".$_SESSION['company_type']."%'";
	}
	
	if($_SESSION['email_id']!="")
	{
	$sql.=" and mia_application_form.email_id like '%".$_SESSION['email_id']."%'";
	}
	
	$sql.= "  ".$attach." ";
	
	$result1=mysql_query($sql);
	$rCount=mysql_num_rows($result1);
	
	$sql1= $sql." limit $start, $limit ";
	$result=mysql_query($sql1);
	
    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
        <td><?php echo $row['event_name']; ?></td>
        <td><?php echo strtoupper($row['participant_company_name']); ?></td>
        <td><?php echo $row['company_type']; ?></td>
        <td align="left"><?php echo $row['email_id']; ?></td>		
		<td align="left">
		<?php if($row['approval']=='N') { echo 'PENDING';
			  }elseif($row['approval']=='Y'){ echo '<span style="color:green">APPROVED</span>';}else {echo "Disapprove";} ?>
		</td>
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
function pagination($per_page = 10, $page = 1, $url = '', $total){ 

$adjacents = "2";

$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$lastpage = ceil($total/$per_page);
$lpm1 = $lastpage - 1;

$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<ul class='pagination'>";
$pagination .= "<li class='details'>Page $page of $lastpage</li>";
if ($lastpage < 7 + ($adjacents * 2))
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2))
{
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>...</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>..</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
else
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>..</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
}

if ($page < $counter - 1){
$pagination.= "<li><a href='{$url}$next'>Next</a></li>";
// $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
}else{
//$pagination.= "<li><a class='current'>Next</a></li>";
// $pagination.= "<li><a class='current'>Last</a></li>";
}
$pagination.= "</ul>\n"; 
} 
return $pagination;
} 

?>       
 <div class="pages_1">Total number of Application: <?php echo $rCount;?> 
 <?php echo pagination($limit,$page,'export_mai_report.php?action=view&page=',$rCount); //call function to show pagination?>

</div>
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>
