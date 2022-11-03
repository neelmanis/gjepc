<?php
session_start(); 
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
$registration_id = @$_REQUEST['regid'];
$orderId = filter($_REQUEST['orderId']);

function gotRegionID($region_name,$conn)
{
	$query_sel = "SELECT state_code FROM state_master where region_name ='$region_name'";
	$result_sel = $conn->query($query_sel);
	$movies_id = array();
	while($row = $result_sel->fetch_assoc())		 	
	{ 
	    $visitor_approval = $row['state_code'];
	    $movies_id[] = $visitor_approval;   
	}
	$Array = $movies_id;
	return $List = implode(', ', $Array); 
}


$getMUMRegion = gotRegionID("HO-MUM (M)",$conn);
$getSURATRegion = gotRegionID("RO-SRT",$conn);
$getJAIPURRegion = gotRegionID("RO-JAI",$conn);
$getDELHIRegion = gotRegionID("RO-DEL",$conn);
$getKOLKATARegion = gotRegionID("RO-KOL",$conn);
$getCHENNAIRegion = gotRegionID("RO-CHE",$conn);

function getTotalRegionwiseData($getRegionIds,$conn)
{
	$query_sel = "SELECT rm . * , oh . * 
	FROM  visitor_order_history oh
	INNER JOIN  registration_master rm ON oh.registration_id=rm.id
	WHERE oh.payment_status='Y' and oh.status = '1' and oh.show='vbsm2' and oh.year='2021' AND rm.state IN($getRegionIds)";
	$result_sel = $conn->query($query_sel);
	$total_region= $result_sel->num_rows;
	return $total_region; 
}

function getTotalRegionwiseCurrentDate($getRegionIds,$conn)
{	
	$curr_date_start=date("Y-m-d")." 00:00:00";
	$curr_date_end=date("Y-m-d")." 23:59:59";
		
	$query_sel = "SELECT rm . * , oh . * 
	FROM  visitor_order_history oh
	INNER JOIN  registration_master rm ON oh.registration_id=rm.id
	WHERE oh.payment_status='Y' and oh.status = '1' and oh.show='vbsm2' and oh.year='2021' AND rm.state IN($getRegionIds) AND 
	oh.create_date BETWEEN '$curr_date_start' AND '$curr_date_end'";
	$result_sel = $conn->query($query_sel);
	$total_data= $result_sel->num_rows;
	return $total_data; 
}

function getRegionwiseCategoryApplication($category,$getRegionIds,$conn)
{	
	$query_sel = "SELECT rm.state,rm.company_name, oh.orderId ,vd.visitor_id 
	FROM  visitor_order_history oh
	INNER JOIN registration_master rm ON oh.registration_id=rm.id
	INNER JOIN visitor_directory vd on oh.visitor_id=vd.visitor_id 
	WHERE oh.payment_status='Y' and oh.show='vbsm2' and oh.year='2021' AND vd.category='$category' AND rm.state IN($getRegionIds) 
	group by oh.orderId";	
	$result_sel = $conn->query($query_sel);
	$total_data= $result_sel->num_rows;
	return $total_data; 
}

function getRegionwiseCategoryCompany($category,$getRegionIds,$conn)
{	
	$query_sel = "SELECT rm.state,rm.company_name, oh.orderId ,vd.visitor_id 
	FROM  visitor_order_history oh
	INNER JOIN registration_master rm ON oh.registration_id=rm.id
	INNER JOIN visitor_directory vd on oh.visitor_id=vd.visitor_id 
	WHERE oh.payment_status='Y' and oh.show='vbsm2' and oh.year='2021' AND vd.category='$category' AND rm.state IN($getRegionIds) 
	group by vd.registration_id";
	$result_sel = $conn->query($query_sel);
	$total_data= $result_sel->num_rows;
	return $total_data; 
}

/*
function getTotalVIPRegionwise($getRegionIds,$conn)
{	
	$query_sel = "SELECT rm . * , oh . * 
	FROM  visitor_order_history oh
	INNER JOIN registration_master rm ON oh.registration_id=rm.id
	INNER JOIN visitor_directory vd on oh.visitor_id=vd.visitor_id 
	WHERE oh.payment_status='Y' and oh.status = '1' and oh.show='vbsm2' and oh.year='2021' AND rm.state IN($getRegionIds) 
	AND vd.category='VIP'";
	$result_sel = $conn->query($query_sel);
	$total_data= $result_sel->num_rows;
	return $total_data; 
}

function getTotalVVIPRegionwise($getRegionIds,$conn)
{	
	$query_sel = "SELECT rm . * , oh . * 
	FROM  visitor_order_history oh
	INNER JOIN registration_master rm ON oh.registration_id=rm.id
	INNER JOIN visitor_directory vd on oh.visitor_id=vd.visitor_id 
	WHERE oh.payment_status='Y' and oh.status = '1' and oh.show='vbsm2' and oh.year='2021' AND rm.state IN($getRegionIds) 
	AND vd.category='VVIP'";
	$result_sel = $conn->query($query_sel);
	$total_data= $result_sel->num_rows;
	return $total_data; 
}

function getTotalELITERegionwise($getRegionIds,$conn)
{	
	$query_sel = "SELECT rm . * , oh . * 
	FROM  visitor_order_history oh
	INNER JOIN registration_master rm ON oh.registration_id=rm.id
	INNER JOIN visitor_directory vd on oh.visitor_id=vd.visitor_id 
	WHERE oh.payment_status='Y' and oh.status = '1' and oh.show='vbsm2' and oh.year='2021' AND rm.state IN($getRegionIds) 
	AND vd.category='ELITE'";
	$result_sel = $conn->query($query_sel);
	$total_data= $result_sel->num_rows;
	return $total_data; 
} */

function getTotalCompanyRegionwise($getRegionIds,$conn)
{	
	$query_sel = "select oh.create_date, rm.id,rm.company_name,rm.state, vd.name,vd.lname,vd.pan_no,vd.email,vd.category, oh.orderId, oh.amount as 'Amount', oh.payment_status as 'payment_status',vo.regId,vo.payment_type 
	from visitor_order_history oh 
	inner join registration_master rm on oh.registration_id=rm.id 
	inner join visitor_directory vd on oh.visitor_id=vd.visitor_id 
	inner join visitor_order_detail vo on vo.regId=vd.registration_id
	where vo.orderId=oh.orderId AND oh.payment_status='Y' and oh.status = '1' and oh.show='vbsm2' and oh.year='2021' AND rm.state IN($getRegionIds)
	group by rm.id";
	$result_sel = $conn->query($query_sel);
	$total_data= $result_sel->num_rows;
	return $total_data; 
}

/*
echo "HO-MUM (M)". getTotalRegionwiseData($getMUMRegion,$conn); 
echo "Today".getTotalRegionwiseCurrentDate($getMUMRegion,$conn);
echo "VIP".getTotalVIPRegionwise($getMUMRegion,$conn);
echo "VVIP".getTotalVVIPRegionwise($getMUMRegion,$conn);
echo "ELITE".getTotalELITERegionwise($getMUMRegion,$conn);


echo "RO-SRT". getTotalRegionwiseData($getSURATRegion,$conn);
echo "RO-JAI". getTotalRegionwiseData($getJAIPURRegion,$conn);
echo "RO-DEL". getTotalRegionwiseData($getDELHIRegion,$conn);
echo "RO-KOL". getTotalRegionwiseData($getKOLKATARegion,$conn);
echo "RO-CHENNAI". getTotalRegionwiseData($getCHENNAIRegion,$conn);
*/
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['company_name']="";
  $_SESSION['company_pan_no']="";
  $_SESSION['orderId']="";
  $_SESSION['fname']="";
  $_SESSION['city']="";
  header("Location: manage_virtual_visitor_order.php?action=view");
} else {
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{
	$_SESSION['orderId'] = filter($_REQUEST['orderId']);
	$_SESSION['company_name'] = filter($_REQUEST['company_name']);
	$_SESSION['company_pan_no'] = filter($_REQUEST['company_pan_no']);
	$_SESSION['fname'] = filter($_REQUEST['fname']);
	$_SESSION['city'] = filter($_REQUEST['city']);
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Order || GJEPC ||</title>
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Visitor Order</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">		
		<?php if($_REQUEST['action']=='view') { ?>
        Manage Visitor Order <a href="virtual_export_visitordelivery.php">Download Report </a>
		<?php } elseif($_REQUEST['action']=='orderHistory') { ?><div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;">
        <a href="manage_virtual_visitor_order.php?action=view">Back</a></div> <?php } ?>
		</div>

<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>

<?php if($_REQUEST['action']=='view') { ?>

<div class="content_details1">
	<?php 
		$sql5 = "select * from visitor_order_history where `show`='vbsm2'";
		$result5 = $conn ->query($sql5);
		$total_application= $result5->num_rows;
		
		$sqlCompany = "select oh.create_date, rm.id,rm.company_name,rm.state, vd.name,vd.lname,vd.pan_no,vd.email,vd.category, oh.orderId, oh.amount as 'Amount', oh.payment_status as 'payment_status' from visitor_order_history oh inner join registration_master rm on oh.registration_id=rm.id inner join visitor_directory vd on oh.visitor_id=vd.visitor_id where oh.payment_status='Y' and oh.status = '1' and oh.show='vbsm2' and oh.year='2021' group by rm.id ";
		$resultCompany = $conn ->query($sqlCompany);
		$total_company = $resultCompany->num_rows;
		
		$curr_date_start=date("Y-m-d")." 00:00:00";
		$curr_date_end=date("Y-m-d")." 23:59:59";
		$sql6 = "select * from visitor_order_history where create_date BETWEEN '$curr_date_start' AND '$curr_date_end'";
		$result6 = $conn ->query($sql6);
		$total_application_on_date= $result6->num_rows;	
		
		$categoryVIP = "SELECT a . category , b . * FROM visitor_directory a LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='vbsm2' AND a.category='VIP'";
		$resultVIP = $conn ->query($categoryVIP);
		$total_VIP_application= $resultVIP->num_rows;
		
		$categoryVIPCom = "SELECT a . category , b . * FROM visitor_directory a LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='vbsm2' AND a.category='VIP' group by b.registration_id";
		$resultVIPCom = $conn ->query($categoryVIPCom);
		$total_VIP_company = $resultVIPCom->num_rows;
		
		$categoryVVIP = "SELECT a . category , b . * FROM visitor_directory a LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='vbsm2' AND a.category='VVIP'";
		$resultVVIP = $conn ->query($categoryVVIP);
		$total_VVIP_application = $resultVVIP->num_rows;
		
		$categoryVVIPCom = "SELECT a . category , b . * FROM visitor_directory a LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='vbsm2' AND a.category='VVIP' group by b.registration_id";
		$resultVVIPCom = $conn ->query($categoryVVIPCom);
		$total_VVIP_company = $resultVVIPCom->num_rows;
		
		$categoryElite = "SELECT a . category , b . * FROM visitor_directory a	LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='vbsm2' AND a.category='ELITE'";
		$resultElite = $conn ->query($categoryElite);
		$total_Elite_application= $resultElite->num_rows;
		
		$categoryEliteCom = "SELECT a . category , b . * FROM visitor_directory a	LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='vbsm2' AND a.category='ELITE' group by b.registration_id";
		$resultEliteCom = $conn ->query($categoryEliteCom);
		$total_Elite_company= $resultEliteCom->num_rows;
	?>

	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">Report Summary</td></tr>
	<tr>
	  <td><strong>Grand Total Application</strong></td>
	  <td><strong>Total Company</strong></td>
	  <td><strong>Total Application On Date (<?php echo date('Y-m-d');?>)</strong></td>	  
	  <td colspan="2" align="center"><strong>Total VIP</strong></td>
	  <td colspan="2" align="center"><strong>Total VVIP</strong></td>
	  <td colspan="2" align="center"><strong>Total ELITE</strong></td>
	</tr>
	<tr>	  
	  <td rowspan="2"><?php echo $total_application;?></td>
	  <td rowspan="2"><?php echo $total_company;?></td>
	  <td rowspan="2"><?php echo $total_application_on_date;?></td>	
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	</tr>	
	<tr>	 
	  <td><?php echo $total_VIP_application;?></td>
	  <td><?php echo $total_VIP_company;?></td>
	  <td><?php echo $total_VVIP_application;?></td>
	  <td><?php echo $total_VVIP_company;?></td>
	  <td><?php echo $total_Elite_application;?></td>
	  <td><?php echo $total_Elite_company;?></td>
	</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">HO-MUM Report Summary</td></tr>
	<tr>
	  <td><strong>Total Application</strong></td>
	  <td><strong>Total Company</strong></td>
	  <td><strong>Total Application On Date- (<?php echo date('Y-m-d');?>)</strong></td>	  
	  <td colspan="2" align="center"><strong>Total VIP</strong></td>
	  <td colspan="2" align="center"><strong>Total VVIP</strong></td> 
	  <td colspan="2" align="center"><strong>Total ELITE</strong></td>
	</tr>
	<tr>
	  <td rowspan="2"><?php echo getTotalRegionwiseData($getMUMRegion,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalCompanyRegionwise($getMUMRegion,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalRegionwiseCurrentDate($getMUMRegion,$conn);?></td>	 
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	</tr>	
	<tr>
	  <td><?php echo getRegionwiseCategoryApplication('VIP',$getMUMRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VIP',$getMUMRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('VVIP',$getMUMRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VVIP',$getMUMRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('ELITE',$getMUMRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('ELITE',$getMUMRegion,$conn);?></td>
	</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">RO-SURAT Report Summary</td></tr>
	<tr>
	  <td><strong>Total Application</strong></td>
	  <td><strong>Total Company</strong></td>
	  <td><strong>Total Application On Date- (<?php echo date('Y-m-d');?>)</strong></td>	  
	  <td colspan="2" align="center"><strong>Total VIP</strong></td>
	  <td colspan="2" align="center"><strong>Total VVIP</strong></td> 
	  <td colspan="2" align="center"><strong>Total ELITE</strong></td>
	</tr>
	<tr>
	  <td rowspan="2"><?php echo getTotalRegionwiseData($getSURATRegion,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalCompanyRegionwise($getSURATRegion,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalRegionwiseCurrentDate($getSURATRegion,$conn);?></td>	  
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	</tr>	
	<tr>
	  <td><?php echo getRegionwiseCategoryApplication('VIP',$getSURATRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VIP',$getSURATRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('VVIP',$getSURATRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VVIP',$getSURATRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('ELITE',$getSURATRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('ELITE',$getSURATRegion,$conn);?></td>
	</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">RO-JAIPUR Report Summary</td></tr>
	<tr>
	  <td><strong>Total Application</strong></td>
	  <td><strong>Total Company</strong></td>
	  <td><strong>Total Application On Date- (<?php echo date('Y-m-d');?>)</strong></td>	  
	  <td colspan="2" align="center"><strong>Total VIP</strong></td>
	  <td colspan="2" align="center"><strong>Total VVIP</strong></td> 
	  <td colspan="2" align="center"><strong>Total ELITE</strong></td>
	</tr>
	<tr>
	  <td rowspan="2"><?php echo getTotalRegionwiseData($getJAIPURRegion,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalCompanyRegionwise($getJAIPURRegion,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalRegionwiseCurrentDate($getJAIPURRegion,$conn);?></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	</tr>	
	<tr>
	  <td><?php echo getRegionwiseCategoryApplication('VIP',$getJAIPURRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VIP',$getJAIPURRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('VVIP',$getJAIPURRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VVIP',$getJAIPURRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('ELITE',$getJAIPURRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('ELITE',$getJAIPURRegion,$conn);?></td>
	</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">RO-DELHI Report Summary</td></tr>
	<tr>
	  <td><strong>Total Application</strong></td>
	  <td><strong>Total Company</strong></td>
	  <td><strong>Total Application On Date- (<?php echo date('Y-m-d');?>)</strong></td>	  
	  <td colspan="2" align="center"><strong>Total VIP</strong></td>
	  <td colspan="2" align="center"><strong>Total VVIP</strong></td> 
	  <td colspan="2" align="center"><strong>Total ELITE</strong></td>
	</tr>
	<tr>
	  <td rowspan="2"><?php echo getTotalRegionwiseData($getDELHIRegion,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalCompanyRegionwise($getDELHIRegion,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalRegionwiseCurrentDate($getDELHIRegion,$conn);?></td>	  
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	</tr>	
	<tr>
	  <td><?php echo getRegionwiseCategoryApplication('VIP',$getDELHIRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VIP',$getDELHIRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('VVIP',$getDELHIRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VVIP',$getDELHIRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('ELITE',$getDELHIRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('ELITE',$getDELHIRegion,$conn);?></td>
	</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">RO-KOLKATA Report Summary</td></tr>
	<tr>
	  <td><strong>Total Application</strong></td>
	  <td><strong>Total Company</strong></td>
	  <td><strong>Total Application On Date- (<?php echo date('Y-m-d');?>)</strong></td>	   
	  <td colspan="2" align="center"><strong>Total VIP</strong></td>
	  <td colspan="2" align="center"><strong>Total VVIP</strong></td> 
	  <td colspan="2" align="center"><strong>Total ELITE</strong></td>
	</tr>
	<tr>
	  <td rowspan="2"><?php echo getTotalRegionwiseData($getKOLKATARegion,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalCompanyRegionwise($getKOLKATARegion,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalRegionwiseCurrentDate($getKOLKATARegion,$conn);?></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	</tr>
	<tr>
	  <td><?php echo getRegionwiseCategoryApplication('VIP',$getKOLKATARegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VIP',$getKOLKATARegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('VVIP',$getKOLKATARegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VVIP',$getKOLKATARegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('ELITE',$getKOLKATARegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('ELITE',$getKOLKATARegion,$conn);?></td>
	</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">RO-CHENNAI Report Summary</td></tr>
	<tr>
	  <td><strong>Total Application</strong></td>
	  <td><strong>Total Company</strong></td>
	  <td><strong>Total Application On Date (<?php echo date('Y-m-d');?>)</strong></td>	  
	  <td colspan="2" align="center"><strong>Total VIP</strong></td>
	  <td colspan="2" align="center"><strong>Total VVIP</strong></td> 
	  <td colspan="2" align="center"><strong>Total ELITE</strong></td>
	</tr>
	<tr>
	  <td rowspan="2"><?php echo getTotalRegionwiseData($getCHENNAIRegion,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalCompanyRegionwise($getCHENNAIRegion,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalRegionwiseCurrentDate($getCHENNAIRegion,$conn);?></td>	 
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	</tr>	
	<tr>
	  <td><?php echo getRegionwiseCategoryApplication('VIP',$getCHENNAIRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VIP',$getCHENNAIRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('VVIP',$getCHENNAIRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VVIP',$getCHENNAIRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('ELITE',$getCHENNAIRegion,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('ELITE',$getCHENNAIRegion,$conn);?></td>
	</tr>
	</table>
	
	<!--<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">HO-MUM Report Summary</td></tr>
	<tr>
	  <td><strong>Total Application</strong></td>
	  <td><strong>Total Company</strong></td>
	  <td><strong>Total Application On Date- (<?php echo date('Y-m-d');?>)</strong></td>	  
	  <td><strong>Total VIP</strong></td><td><strong>Total VVIP</strong></td><td><strong>Total ELITE</strong></td>
	</tr>
	<tr>
	  <td><?php echo getTotalRegionwiseData($getMUMRegion,$conn);?></td>
	  <td><?php echo getTotalCompanyRegionwise($getMUMRegion,$conn);?></td>
	  <td><?php echo getTotalRegionwiseCurrentDate($getMUMRegion,$conn);?></td>	 
	  <td><?php echo getTotalVIPRegionwise($getMUMRegion,$conn);?></td><td><?php echo getTotalVVIPRegionwise($getMUMRegion,$conn);?></td>
	  <td><?php echo getTotalELITERegionwise($getMUMRegion,$conn);?></td>
	</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">RO-SURAT Report Summary</td></tr>
	<tr>
	  <td><strong>Total Application</strong></td>
	  <td><strong>Total Company</strong></td>
	  <td><strong>Total Application On Date- (<?php echo date('Y-m-d');?>)</strong></td>	  
	  <td><strong>Total VIP</strong></td><td><strong>Total VVIP</strong></td><td><strong>Total ELITE</strong></td>
	</tr>
	<tr>
	  <td><?php echo getTotalRegionwiseData($getSURATRegion,$conn);?></td>
	  <td><?php echo getTotalCompanyRegionwise($getSURATRegion,$conn);?></td>
	  <td><?php echo getTotalRegionwiseCurrentDate($getSURATRegion,$conn);?></td>	  
	  <td><?php echo getTotalVIPRegionwise($getSURATRegion,$conn);?></td><td><?php echo getTotalVVIPRegionwise($getSURATRegion,$conn);?></td>
	  <td><?php echo getTotalELITERegionwise($getSURATRegion,$conn);?></td>
	</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">RO-JAIPUR Report Summary</td></tr>
	<tr>
	  <td><strong>Total Application</strong></td>
	  <td><strong>Total Company</strong></td>
	  <td><strong>Total Application On Date- (<?php echo date('Y-m-d');?>)</strong></td>	  
	  <td><strong>Total VIP</strong></td><td><strong>Total VVIP</strong></td><td><strong>Total ELITE</strong></td>
	</tr>
	<tr>
	  <td><?php echo getTotalRegionwiseData($getJAIPURRegion,$conn);?></td>
	  <td><?php echo getTotalCompanyRegionwise($getJAIPURRegion,$conn);?></td>
	  <td><?php echo getTotalRegionwiseCurrentDate($getJAIPURRegion,$conn);?></td>
	  <td><?php echo getTotalVIPRegionwise($getJAIPURRegion,$conn);?></td><td><?php echo getTotalVVIPRegionwise($getJAIPURRegion,$conn);?></td><td><?php echo getTotalELITERegionwise($getJAIPURRegion,$conn);?></td>
	</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">RO-DELHI Report Summary</td></tr>
	<tr>
	  <td><strong>Total Application</strong></td>
	  <td><strong>Total Company</strong></td>
	  <td><strong>Total Application On Date- (<?php echo date('Y-m-d');?>)</strong></td>	  
	  <td><strong>Total VIP</strong></td><td><strong>Total VVIP</strong></td><td><strong>Total ELITE</strong></td>
	</tr>
	<tr>
	  <td><?php echo getTotalRegionwiseData($getDELHIRegion,$conn);?></td>
	  <td><?php echo getTotalCompanyRegionwise($getDELHIRegion,$conn);?></td>
	  <td><?php echo getTotalRegionwiseCurrentDate($getDELHIRegion,$conn);?></td>	  
	  <td><?php echo getTotalVIPRegionwise($getDELHIRegion,$conn);?></td><td><?php echo getTotalVVIPRegionwise($getDELHIRegion,$conn);?></td>
	  <td><?php echo getTotalELITERegionwise($getDELHIRegion,$conn);?></td>
	</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">RO-KOLKATA Report Summary</td></tr>
	<tr>
	  <td><strong>Total Application</strong></td>
	  <td><strong>Total Company</strong></td>
	  <td><strong>Total Application On Date- (<?php echo date('Y-m-d');?>)</strong></td>	   
	  <td><strong>Total VIP</strong></td><td><strong>Total VVIP</strong></td><td><strong>Total ELITE</strong></td>
	</tr>
	<tr>
	  <td><?php echo getTotalRegionwiseData($getKOLKATARegion,$conn);?></td>
	  <td><?php echo getTotalCompanyRegionwise($getKOLKATARegion,$conn);?></td>
	  <td><?php echo getTotalRegionwiseCurrentDate($getKOLKATARegion,$conn);?></td>	 
	  <td><?php echo getTotalVIPRegionwise($getKOLKATARegion,$conn);?></td><td><?php echo getTotalVVIPRegionwise($getKOLKATARegion,$conn);?></td><td><?php echo getTotalELITERegionwise($getKOLKATARegion,$conn);?></td>
	</tr>
	</table>
	
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">RO-CHENNAI Report Summary</td></tr>
	<tr>
	  <td><strong>Total Application</strong></td>
	  <td><strong>Total Company</strong></td>
	  <td><strong>Total Application On Date- (<?php echo date('Y-m-d');?>)</strong></td>	  
	  <td><strong>Total VIP</strong></td><td><strong>Total VVIP</strong></td><td><strong>Total ELITE</strong></td>
	</tr>
	<tr>
	  <td><?php echo getTotalRegionwiseData($getCHENNAIRegion,$conn);?></td>
	  <td><?php echo getTotalCompanyRegionwise($getCHENNAIRegion,$conn);?></td>
	  <td><?php echo getTotalRegionwiseCurrentDate($getCHENNAIRegion,$conn);?></td>	 
	  <td><?php echo getTotalVIPRegionwise($getCHENNAIRegion,$conn);?></td><td><?php echo getTotalVVIPRegionwise($getCHENNAIRegion,$conn);?></td><td><?php echo getTotalELITERegionwise($getCHENNAIRegion,$conn);?></td>
	</tr>
	</table>-->
</div>


<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Search Options</td>
</tr>
<tr>
    <td width="19%"><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" autocomplete="off"/></td>
</tr>     
<tr>
  <td><strong>Company PAN Number</strong></td>
  <td><input type="text" name="company_pan_no" id="company_pan_no" maxlength="10" class="input_txt" value="<?php echo $_SESSION['company_pan_no'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>First Name</strong></td>
  <td><input type="text" name="fname" id="fname" class="input_txt" value="<?php echo $_SESSION['fname'];?>" autocomplete="off"/></td>
</tr>
<tr>
    <td width="19%"><strong>Order Id</strong></td>
    <td width="81%"><input type="text" name="orderId" id="orderId" class="input_txt" value="<?php echo $_SESSION['orderId'];?>" autocomplete="off"/></td>
</tr>
<tr>
    <td width="19%"><strong>City</strong></td>
    <td width="81%"><input type="text" name="city" id="city" class="input_txt" value="<?php echo $_SESSION['city'];?>" autocomplete="off"/></td>
</tr>   
<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search" class="input_submit" /> 
	<input type="submit" name="Reset" value="Reset" class="input_submit" /></td>
</tr>	
</table>
</form> 
</div>
<div class="content_details1">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
    <tr class="orange1">
	<td>Company Name</td>
	<td>Company PAN</td>
    <td>Order Id</td>
    <td>Amount</td>
	<td>Application Date</td>      
	<td>View Order</td>  
    </tr>
    <?php	
 	$page=1;//Default page
	$limit=50;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'oh.create_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
    //$sql = "SELECT * FROM `visitor_order_detail` WHERE payment_status = 'Y' and event='vbsm2'";

	$sql = "select oh.create_date as 'create_date', rm.id,rm.company_name,rm.company_pan_no,rm.email_id,rm.city, 
	 vd.name,vd.lname,vd.pan_no,vd.email,vd.category,
	 oh.orderId, oh.amount as 'Amount', oh.payment_status as 'payment_status',vo.regId,vo.payment_type
	from visitor_order_history oh 
	inner join registration_master rm on oh.registration_id=rm.id 
	inner join visitor_directory vd on oh.visitor_id=vd.visitor_id 
	inner join visitor_order_detail vo on vo.regId=vd.registration_id
	where vo.orderId=oh.orderId AND oh.payment_status='Y' and vo.event='vbsm2' ";
	
	if($_SESSION['company_name']!="")
	{
	$sql.=" and rm.company_name like '%".$_SESSION['company_name']."%'";
	}

	if($_SESSION['company_pan_no']!="")
	{
	$sql.=" and rm.company_pan_no ='".$_SESSION['company_pan_no']."'";
	}
	
	if($_SESSION['orderId']!="")
	{
	$sql.=" and vo.orderId like '%".$_SESSION['orderId']."%'";
	}
	
	if($_SESSION['fname']!="")
	{
	$sql.=" and vd.name like '%".$_SESSION['fname']."%'";
	}
	
	if($_SESSION['city']!="")
	{
	$sql.=" and rm.city like '%".$_SESSION['city']."%'";
	}
	
	$sql.= "  group by vo.orderId".$attach." ";
	
	//echo $sql;
	$result1= $conn ->query($sql);
	$rCount = $result1->num_rows;
	
	$sql1= $sql." limit $start, $limit ";
	$result=$conn ->query($sql1);
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{
    ?>
	<?php 
	$checkMember = CheckMembership($row['regId'],$conn);
	if($checkMember=="M")
	{
	 $memberBP = getBPNO($row['regId'],$conn);
	} else {
	 $memberBP = getCompanyNonMemBPNO($row['regId'],$conn);
	}
	?>
    <tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
      <td><?php echo strtoupper(getNameCompany($row['regId'],$conn)); ?></td>
      <td><?php echo strtoupper($row['company_pan_no']); ?></td>
	  <td><?php echo filter($row['orderId']); ?></td>      
	  <td><?php echo $row['total_payable']; ?></td>      
	  <td><?php echo $row['create_date']; ?></td>      
      <td align="left"><a href="manage_virtual_visitor_order.php?action=orderHistory&orderId=<?php echo $row['orderId'];?>&regid=<?php echo $row['regId'];?>" style="color:#000000">VIEW</a></td>  
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

<!----------------------------- ORDER HISTORY ---------------------------------->

<?php if($_REQUEST['action']=='orderHistory') {?>  
<div class="content_details1">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Visitor Name</td>
    <td>Payment Made For</td>
    <td>Amount</td>
    <td>Shows</td>
    <td>Year</td>
    <td>Payment Status</td>
  </tr>
    <?php  
	$page=1;//Default page
	$limit=100;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
  
    $sql="SELECT * FROM visitor_order_history where orderId = '$orderId' and registration_id = '$registration_id'"; 	 
	$result=$conn ->query($sql);
	$rCount= $result->num_rows;
	$sql1= $sql."  limit $start, $limit";
	$result1=$conn ->query($sql1);
		
  if($rCount>0)
  {	
  while($rows= $result1->fetch_assoc())
  {
  $payment_status = $rows['payment_status'];
  if($payment_status == 'Y'){
	$Pstatus = "Success";} else { 
	$Pstatus = "Fail";}	
  ?>
  <tr >
    <td><?php echo VisitorFLName($rows['visitor_id'],$conn);?></td> 
    <td><?php echo filter($rows['payment_made_for']);?></td> 
    <td><?php echo $rows['amount'];?></td>   
    <td><?php echo filter($rows['show']);?></td>
    <td><?php echo filter($rows['year']);?></td> 
    <td><?php echo $Pstatus;?></td> 
  </tr>
  <?php
   $i++;
   }  
}
   else
   {
   ?>
  <tr>
    <td colspan="8">Records Not Found</td>
  </tr>
  <?php  }  	?>
</table>
</form>
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
<div class="pages_1">Total number of Company: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'manage_virtual_visitor_order.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
    </div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>

</body>
</html>