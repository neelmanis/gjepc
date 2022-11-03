<?php
session_start(); 
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit; }
$registration_id = @$_REQUEST['regid'];
$orderId = filter($_REQUEST['orderId']);

$show = $_REQUEST['event'];
if($_REQUEST['event']==''){ $show = "iijs22"; }
	
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

function getTotalRegionwiseData($getRegionIds,$show,$conn)
{
	$query_sel = "SELECT rm . * , oh . * 
	FROM  visitor_order_history oh
	INNER JOIN  registration_master rm ON oh.registration_id=rm.id
	WHERE oh.payment_status='Y' and oh.status = '1' and oh.show='$show' AND rm.state IN($getRegionIds)";
	$result_sel = $conn->query($query_sel);
	$total_region= $result_sel->num_rows;
	return $total_region; 
}

function getTotalRegionwiseCurrentDate($getRegionIds,$show,$conn)
{	
	$curr_date_start=date("Y-m-d")." 00:00:00";
	$curr_date_end=date("Y-m-d")." 23:59:59";
		
	$query_sel = "SELECT rm . * , oh . * 
	FROM  visitor_order_history oh
	INNER JOIN  registration_master rm ON oh.registration_id=rm.id
	WHERE oh.payment_status='Y' and oh.status = '1' and oh.show='$show' and oh.year='2022' AND rm.state IN($getRegionIds) AND 
	oh.create_date BETWEEN '$curr_date_start' AND '$curr_date_end'";
	$result_sel = $conn->query($query_sel);
	$total_data= $result_sel->num_rows;
	return $total_data; 
}

function getRegionwiseCategoryApplication($category,$getRegionIds,$show,$conn)
{	
	$query_sel = "SELECT rm.state,rm.company_name, oh.orderId ,vd.visitor_id 
	FROM  visitor_order_history oh
	INNER JOIN registration_master rm ON oh.registration_id=rm.id
	INNER JOIN visitor_directory vd on oh.visitor_id=vd.visitor_id 
	WHERE oh.payment_status='Y' and oh.show='$show' AND vd.category='$category' AND rm.state IN($getRegionIds) ";	
	$result_sel = $conn->query($query_sel);
	$total_data= $result_sel->num_rows;
	return $total_data; 
}

function getRegionwiseCategoryCompany($category,$getRegionIds,$show,$conn)
{	
	$query_sel = "SELECT rm.state,rm.company_name, oh.orderId ,vd.visitor_id 
	FROM  visitor_order_history oh
	INNER JOIN registration_master rm ON oh.registration_id=rm.id
	INNER JOIN visitor_directory vd on oh.visitor_id=vd.visitor_id 
	WHERE oh.payment_status='Y' and oh.show='$show' AND vd.category='$category' AND rm.state IN($getRegionIds) 
	group by vd.registration_id";
	$result_sel = $conn->query($query_sel);
	$total_data= $result_sel->num_rows;
	return $total_data; 
}

function getTotalCompanyRegionwise($getRegionIds,$show,$conn)
{	
	$query_sel = "select oh.create_date, rm.id,rm.company_name,rm.state, vd.name,vd.lname,vd.pan_no,vd.email,vd.category, oh.orderId, oh.amount as 'Amount', oh.payment_status as 'payment_status',vo.regId,vo.payment_type 
	from visitor_order_history oh 
	inner join registration_master rm on oh.registration_id=rm.id 
	inner join visitor_directory vd on oh.visitor_id=vd.visitor_id 
	inner join visitor_order_detail vo on vo.regId=vd.registration_id
	where vo.orderId=oh.orderId AND oh.payment_status='Y' and oh.status = '1' and oh.show='$show' AND rm.state IN($getRegionIds)
	group by rm.id";
	$result_sel = $conn->query($query_sel);
	$total_data= $result_sel->num_rows;
	return $total_data; 
}

function getTotalCityRegionwise($getRegionIds,$show,$conn)
{	
	$query_sel = "select rm.id,rm.city,rm.state,vd.category, oh.orderId, oh.payment_status as 'payment_status',vo.regId,vo.payment_type 
	from visitor_order_history oh 
	inner join registration_master rm on oh.registration_id=rm.id 
	inner join visitor_directory vd on oh.visitor_id=vd.visitor_id 
	inner join visitor_order_detail vo on vo.regId=vd.registration_id
	where vo.orderId=oh.orderId AND oh.payment_status='Y' and oh.status = '1' and oh.show='$show' AND rm.state IN($getRegionIds)
	group by rm.city";
	$result_sel = $conn->query($query_sel);
	$total_data= $result_sel->num_rows;
	return $total_data; 
}
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['orderId']="";
  header("Location: manage_visitor_order.php?action=view");
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
<title>Exhibitor Dashboard</title>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script>
$(document).ready(function(){
 $(".websiteRadio").change(function() {    
	//alert($('.websiteRadio').val());
    window.location = $('.websiteRadio').val();
 });
});
</script>
	
<script type="text/javascript">
	$(window).load(function() {
		$(".loader").fadeOut("slow");
	});
</script>
<style>
select {
  -webkit-appearance: none;
    -moz-appearance: none;
    -ms-appearance: none;
    appearance: none;
    outline: 0;
    box-shadow: none;
    border: 0!important;
    
    background: #f67d5c;
    background-image: none;
    padding: 10px 20px!important;
    flex: 1;
    padding: 0 0.5em;
    color: #fff;
    cursor: pointer;
    font-size: 1em;
    font-family: 'Open Sans', sans-serif;
}
select::-ms-expand {
   display: none;
}
.select {
   position: relative;
   display: flex;
   width: 20em;
   height: 3em;
   line-height: 3;
   background: #5c6664;
   overflow: hidden;
   border-radius: .25em;
   margin: 0 auto;
}
.select::after {
      content: '\25BC';
    position: absolute;
    top: 0px;
    right: 0;
    padding: 0 1em;
    background: #000000;
    cursor: pointer;
     
    pointer-events: none;
    transition: .25s all ease;
}
.select:hover::after {
   color: #23b499;
}
</style>
</head>

<body>
<div class="loader"><p>Manual loading please wait....</p></div>

<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Dashboard</div>
</div>

<div id="main">
	<div class="content">
		 
    	<div class="content_head"></div>
		<?php if($_REQUEST['action']=='view') { ?>
		<div class="manage-shows" style="text-align:center;">
		<label style="display: block;margin-bottom: 10px;font-size: 18px;">Select Show</label>
			<div class="select">
			<select name="data" id="data" class='websiteRadio'>
				<option value="https://gjepc.org/admin/manage_visitor_order.php?action=view&event=signature23" <?php if($show=="signature23"){?> selected <?php }?>>IIJS SIGNATURE 2023</option>
				<option value="https://gjepc.org/admin/manage_visitor_order.php?action=view&event=iijstritiya23" <?php if($show=="iijstritiya23"){?> selected <?php }?>>IIJS TRITIYA 2023</option>
				<!--<option value="https://gjepc.org/admin/manage_visitor_order.php?action=view&event=combo23" <?php if($show=="combo23"){?> selected <?php }?>>IIJS PREMIERE 22 &amp;  IIJS SIGNATURE 23 &amp; IIJS TRITIYA 23</option>-->
			</select>
			</div>
		</div>	
		<?php } ?>

<?php if($_REQUEST['action']=='view'){ ?>

	<div class="content_details1">
	<?php 
		$sql5 = "select id from visitor_order_history where `show`='$show' AND payment_status='Y'";
		$result5 = $conn ->query($sql5);
		$total_application= $result5->num_rows;
		
		$sqlCompany = "select oh.create_date, rm.id,rm.company_name,rm.state, vd.name,vd.lname,vd.pan_no,vd.email,vd.category, oh.orderId, oh.amount as 'Amount', oh.payment_status as 'payment_status' from visitor_order_history oh inner join registration_master rm on oh.registration_id=rm.id inner join visitor_directory vd on oh.visitor_id=vd.visitor_id where oh.payment_status='Y' and oh.status = '1' and oh.show='$show' group by rm.id ";
		$resultCompany = $conn ->query($sqlCompany);
		$total_company = $resultCompany->num_rows;
		
		$curr_date_start=date("Y-m-d")." 00:00:00";
		$curr_date_end=date("Y-m-d")." 23:59:59";
		$sql6 = "select * from visitor_order_history where `show`='$show' and  create_date BETWEEN '$curr_date_start' AND '$curr_date_end'";
		$result6 = $conn ->query($sql6);
		$total_application_on_date= $result6->num_rows;	
		
		$categoryVIP = "SELECT a . category , b . * FROM visitor_directory a LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='$show' AND a.category='VIP'";
		$resultVIP = $conn ->query($categoryVIP);
		$total_VIP_application= $resultVIP->num_rows;
		
		$categoryVIPCom = "SELECT a . category , b . * FROM visitor_directory a LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='$show' AND a.category='VIP' group by b.registration_id";
		$resultVIPCom = $conn ->query($categoryVIPCom);
		$total_VIP_company = $resultVIPCom->num_rows;
		
		$categoryVVIP = "SELECT a . category , b . * FROM visitor_directory a LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='$show' AND a.category='VVIP'";
		$resultVVIP = $conn ->query($categoryVVIP);
		$total_VVIP_application = $resultVVIP->num_rows;
		
		$categoryVVIPCom = "SELECT a . category , b . * FROM visitor_directory a LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.`show`='$show' AND a.category='VVIP' group by b.registration_id";
		$resultVVIPCom = $conn ->query($categoryVVIPCom);
		$total_VVIP_company = $resultVVIPCom->num_rows;
		
		$categoryElite = "SELECT a . category , b . * FROM visitor_directory a	LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.payment_status='Y' AND b.`show`='$show' AND a.category='ELITE'";
		$resultElite = $conn ->query($categoryElite);
		$total_Elite_application= $resultElite->num_rows;
		
		$categoryEliteCom = "SELECT a . category , b . * FROM visitor_directory a LEFT JOIN visitor_order_history b ON a.visitor_id = b.visitor_id WHERE a.visitor_approval = 'Y' AND b.payment_status='Y' AND b.`show`='$show' AND a.category='ELITE' group by b.registration_id";
		$resultEliteCom = $conn ->query($categoryEliteCom);
		$total_Elite_company= $resultEliteCom->num_rows;
		
		$sqlCity = "SELECT oh.visitor_id, oh.create_date as 'create_date',oh.orderId, rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.state,rm.city,rm.land_line_no,rm.mobile_no,rm.email_id,rm.company_type, vd.bp_number,vd.name,vd.lname,vd.designation,vd.pan_no,vd.gender,vd.mobile,vd.email,vd.photo,vd.category,vd.visitor_approval, oh.payment_made_for, oh.amount as 'Amount', oh.payment_status as 'payment_status',oh.`show`, oh.year from visitor_order_history oh inner join registration_master rm on oh.registration_id=rm.id inner join visitor_directory vd on oh.visitor_id=vd.visitor_id where 1 and oh.`show` ='$show' group by rm.city";
		$resultCity = $conn ->query($sqlCity);
		$total_city = $resultCity->num_rows;	
	?>
	<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">Report Summary</td></tr>
	<tr>
	  <td><strong>Grand <br/>Total Application</strong></td>
	  <td><strong>Total Company</strong></td>
	  <td><strong>Total City</strong></td>
	  <td><strong>Total Application On Date (<?php echo date('Y-m-d');?>)</strong></td>	  
	  <td colspan="2" align="center"><strong>Total VIP</strong></td>
	  <td colspan="2" align="center"><strong>Total VVIP</strong></td>
	  <td colspan="2" align="center"><strong>Total ELITE</strong></td>
	</tr>
	<tr>	  
	  <td rowspan="2"><?php echo $total_application;?></td>
	  <td rowspan="2"><?php echo $total_company;?></td>
	  <td rowspan="2"><?php echo $total_city;?></td>
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
	  <td rowspan="2"><?php echo getTotalRegionwiseData($getMUMRegion,$show,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalCompanyRegionwise($getMUMRegion,$show,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalRegionwiseCurrentDate($getMUMRegion,$show,$conn);?></td>	 
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	</tr>	
	<tr>
	  <td><?php echo getRegionwiseCategoryApplication('VIP',$getMUMRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VIP',$getMUMRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('VVIP',$getMUMRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VVIP',$getMUMRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('ELITE',$getMUMRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('ELITE',$getMUMRegion,$show,$conn);?></td>
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
	  <td rowspan="2"><?php echo getTotalRegionwiseData($getSURATRegion,$show,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalCompanyRegionwise($getSURATRegion,$show,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalRegionwiseCurrentDate($getSURATRegion,$show,$conn);?></td>	  
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	</tr>	
	<tr>
	  <td><?php echo getRegionwiseCategoryApplication('VIP',$getSURATRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VIP',$getSURATRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('VVIP',$getSURATRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VVIP',$getSURATRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('ELITE',$getSURATRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('ELITE',$getSURATRegion,$show,$conn);?></td>
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
	  <td rowspan="2"><?php echo getTotalRegionwiseData($getJAIPURRegion,$show,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalCompanyRegionwise($getJAIPURRegion,$show,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalRegionwiseCurrentDate($getJAIPURRegion,$show,$conn);?></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	</tr>	
	<tr>
	  <td><?php echo getRegionwiseCategoryApplication('VIP',$getJAIPURRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VIP',$getJAIPURRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('VVIP',$getJAIPURRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VVIP',$getJAIPURRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('ELITE',$getJAIPURRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('ELITE',$getJAIPURRegion,$show,$conn);?></td>
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
	  <td rowspan="2"><?php echo getTotalRegionwiseData($getDELHIRegion,$show,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalCompanyRegionwise($getDELHIRegion,$show,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalRegionwiseCurrentDate($getDELHIRegion,$show,$conn);?></td>	  
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	</tr>	
	<tr>
	  <td><?php echo getRegionwiseCategoryApplication('VIP',$getDELHIRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VIP',$getDELHIRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('VVIP',$getDELHIRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VVIP',$getDELHIRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('ELITE',$getDELHIRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('ELITE',$getDELHIRegion,$show,$conn);?></td>
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
	  <td rowspan="2"><?php echo getTotalRegionwiseData($getKOLKATARegion,$show,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalCompanyRegionwise($getKOLKATARegion,$show,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalRegionwiseCurrentDate($getKOLKATARegion,$show,$conn);?></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	</tr>
	<tr>
	  <td><?php echo getRegionwiseCategoryApplication('VIP',$getKOLKATARegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VIP',$getKOLKATARegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('VVIP',$getKOLKATARegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VVIP',$getKOLKATARegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('ELITE',$getKOLKATARegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('ELITE',$getKOLKATARegion,$show,$conn);?></td>
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
	  <td rowspan="2"><?php echo getTotalRegionwiseData($getCHENNAIRegion,$show,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalCompanyRegionwise($getCHENNAIRegion,$show,$conn);?></td>
	  <td rowspan="2"><?php echo getTotalRegionwiseCurrentDate($getCHENNAIRegion,$show,$conn);?></td>	 
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	  <td><strong>No. Of Applications</strong></td>
	  <td><strong>No. Of Companies</strong></td>
	</tr>	
	<tr>
	  <td><?php echo getRegionwiseCategoryApplication('VIP',$getCHENNAIRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VIP',$getCHENNAIRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('VVIP',$getCHENNAIRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('VVIP',$getCHENNAIRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryApplication('ELITE',$getCHENNAIRegion,$show,$conn);?></td>
	  <td><?php echo getRegionwiseCategoryCompany('ELITE',$getCHENNAIRegion,$show,$conn);?></td>
	</tr>
	</table>
</div>

<?php } ?>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>