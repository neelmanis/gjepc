<?php
session_start(); 
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit; }
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
	WHERE oh.payment_status='Y' and oh.status = '1' and oh.show='signature22' and oh.year='2022' AND rm.state IN($getRegionIds)";
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
	WHERE oh.payment_status='Y' and oh.status = '1' and oh.show='signature22' and oh.year='2022' AND rm.state IN($getRegionIds) AND 
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
	WHERE oh.payment_status='Y' and oh.show='signature22' and oh.year='2022' AND vd.category='$category' AND rm.state IN($getRegionIds) ";	
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
	WHERE oh.payment_status='Y' and oh.show='signature22' and oh.year='2022' AND vd.category='$category' AND rm.state IN($getRegionIds) 
	group by vd.registration_id";
	$result_sel = $conn->query($query_sel);
	$total_data= $result_sel->num_rows;
	return $total_data; 
}

function getTotalCompanyRegionwise($getRegionIds,$conn)
{	
	$query_sel = "select oh.create_date, rm.id,rm.company_name,rm.state, vd.name,vd.lname,vd.pan_no,vd.email,vd.category, oh.orderId, oh.amount as 'Amount', oh.payment_status as 'payment_status',vo.regId,vo.payment_type 
	from visitor_order_history oh 
	inner join registration_master rm on oh.registration_id=rm.id 
	inner join visitor_directory vd on oh.visitor_id=vd.visitor_id 
	inner join visitor_order_detail vo on vo.regId=vd.registration_id
	where vo.orderId=oh.orderId AND oh.payment_status='Y' and oh.status = '1' and oh.show='signature22' and oh.year='2022' AND rm.state IN($getRegionIds)
	group by rm.id";
	$result_sel = $conn->query($query_sel);
	$total_data= $result_sel->num_rows;
	return $total_data; 
}
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['orderId']="";
  header("Location: manage_visitor_report_all.php?action=view");
} else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{
	$_SESSION['orderId']= filter($_REQUEST['orderId']);
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
<style>
.detail_txt { line-height: 15px; } 
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Visitor Order</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head">		
		<?php if($_REQUEST['action']=='view') { ?>
        Manage Visitor Order 
		<?php } elseif($_REQUEST['action']=='orderHistory') { ?><div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;">
        <a href="manage_visitor_report_all.php?action=view">Back</a></div> <?php } ?>
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
		$sql5 = "select * from visitor_order_history where `show`='signature22'";
		$result5 = $conn ->query($sql5);
		$total_application= $result5->num_rows;
		
		$sqlCompany = "select oh.create_date, rm.id,rm.company_name,rm.state, vd.name,vd.lname,vd.pan_no,vd.email,vd.category, oh.orderId, oh.amount as 'Amount', oh.payment_status as 'payment_status' from visitor_order_history oh inner join registration_master rm on oh.registration_id=rm.id inner join visitor_directory vd on oh.visitor_id=vd.visitor_id where oh.payment_status='Y' and oh.status = '1' and oh.show='signature22' and oh.year='2022' group by rm.id ";
		$resultCompany = $conn ->query($sqlCompany);
		$total_company = $resultCompany->num_rows;
		
		$curr_date_start=date("Y-m-d")." 00:00:00";
		$curr_date_end=date("Y-m-d")." 23:59:59";
		$sql6 = "select * from visitor_order_history where create_date BETWEEN '$curr_date_start' AND '$curr_date_end'";
		$result6 = $conn ->query($sql6);
		$total_application_on_date= $result6->num_rows;	
		
		$categoryVIP = "SELECT a . category , b . * FROM visitor_directory a LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='signature22' AND a.category='VIP'";
		$resultVIP = $conn ->query($categoryVIP);
		$total_VIP_application= $resultVIP->num_rows;
		
		$categoryVIPCom = "SELECT a . category , b . * FROM visitor_directory a LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='signature22' AND a.category='VIP' group by b.registration_id";
		$resultVIPCom = $conn ->query($categoryVIPCom);
		$total_VIP_company = $resultVIPCom->num_rows;
		
		$categoryVVIP = "SELECT a . category , b . * FROM visitor_directory a LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='signature22' AND a.category='VVIP'";
		$resultVVIP = $conn ->query($categoryVVIP);
		$total_VVIP_application = $resultVVIP->num_rows;
		
		$categoryVVIPCom = "SELECT a . category , b . * FROM visitor_directory a LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='signature22' AND a.category='VVIP' group by b.registration_id";
		$resultVVIPCom = $conn ->query($categoryVVIPCom);
		$total_VVIP_company = $resultVVIPCom->num_rows;
		
		$categoryElite = "SELECT a . category , b . * FROM visitor_directory a	LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='signature22' AND a.category='ELITE'";
		$resultElite = $conn ->query($categoryElite);
		$total_Elite_application= $resultElite->num_rows;
		
		$categoryEliteCom = "SELECT a . category , b . * FROM visitor_directory a	LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='signature22' AND a.category='ELITE' group by b.registration_id";
		$resultEliteCom = $conn ->query($categoryEliteCom);
		$total_Elite_company= $resultEliteCom->num_rows;
	?>
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">Report Summary</td></tr>
	<tr>
	  <td><strong>Grand <br/>Total Application</strong></td>
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
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="2">Visitor Reports</td></tr>
	<tr>
	  <td width="30%"><strong>Visitor Order Report</strong></td>
	  <td><strong><a href="https://gjepc.org/admin/manage_visitor_order_test.php?action=view">Click here</a></strong> </td>
	  
	</tr>
	<tr>
	  <td width="30%"><strong>Visitor Badge Report</strong></td>
	  <td><strong><a href="https://gjepc.org/admin/manage_visitor_badge_status_reports.php?action=view">Click here</a></strong> </td>
	  
	</tr>
	<tr>
	  <td width="30%"><strong>Covid Report</strong></td>
	  <td><strong><a href="https://gjepc.org/admin/manage_covid_report_test.php?action=view">Click here</a></strong> </td>
	  
	</tr>
	<tr>
	  <td width="30%"><strong>Visitor directory Report</strong></td>
	  <td><strong><a href="https://gjepc.org/admin/iijs_employee_directory_test.php?action=view">Click here</a></strong> </td>
	  
	</tr>
</table>

</div>

<div>
	
</div>


<?php } ?> 

<!----------------------------- ORDER HISTORY ---------------------------------->

    </div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>

</body>
</html>