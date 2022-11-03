<?php
session_start(); 
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit; }
$registration_id = @$_REQUEST['regid'];
$orderId = filter($_REQUEST['orderId']);

//$show = "iijs22";
$show = $_REQUEST['event'];
if($_REQUEST['event']==''){ $show = "signature23"; }
	
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
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Visitor Order</div>
</div>

<div id="main">
	<div class="content">
		 
    	<div class="content_head">	
			Manage Visitor Orders
		</div>
		<?php if($_REQUEST['action']=='view') { ?>
		<div class="manage-shows" style="text-align:center;">
		<label style="display: block;margin-bottom: 10px;font-size: 18px;">Select show wise order detail</label>
			<div class="select">
			<select name="data" id="data" class='websiteRadio'>
				<!--<option value="https://gjepc.org/admin/manage_visitor_order.php?action=view&event=iijs22" <?php if($show=="iijs22"){?> selected <?php }?>>IIJS PREMIERE 2022</option>-->
				<option value="https://gjepc.org/admin/manage_visitor_order.php?action=view&event=signature23" <?php if($show=="signature23"){?> selected <?php }?>>IIJS SIGNATURE 2023</option>
				<option value="https://gjepc.org/admin/manage_visitor_order.php?action=view&event=iijstritiya23" <?php if($show=="iijstritiya23"){?> selected <?php }?>>IIJS TRITIYA 2023</option>
				<option value="https://gjepc.org/admin/manage_visitor_order.php?action=view&event=combo23" <?php if($show=="combo23"){?> selected <?php }?>>IIJS PREMIERE 22 &amp;  IIJS SIGNATURE 23 &amp; IIJS TRITIYA 23</option>
			</select>
			</div>
		</div>	
		<?php } elseif($_REQUEST['action']=='orderHistory') { ?><div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;">
        <a href="manage_visitor_order.php?action=view">Back</a></div> <?php } ?>

<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>

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

<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Search Options</td>
</tr>
<tr>
    <td width="19%"><strong>Order Id</strong></td>
    <td width="81%"><input type="text" name="orderId" id="orderId" class="input_txt" value="<?php echo $_SESSION['orderId'];?>" /></td>
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
    <td>Order Id</td>
    <td>Amount</td>
	<td>Transaction Date</td>    
	<td>Transaction Msg</td>    
	<td>Transaction Status</td>  
	<td>View Order</td>  
	<td>Sales Order</td>  
	<!--<td>Create SO</td>  -->
    </tr>
    <?php	
 	$page=1;//Default page
	$limit=50;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'tpsl_txn_time';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
    $sql = "SELECT * FROM `visitor_order_detail` WHERE event ='$show' AND payment_status = 'Y'";
	if($_SESSION['orderId']!="")
	{
	$sql.=" and orderId like '%".$_SESSION['orderId']."%'";
	}	
	$sql.= "  ".$attach." ";
	
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
	  <td><?php echo filter($row['orderId']); ?></td>      
	  <td><?php echo $row['total_payable']; ?></td>      
	  <td><?php echo $row['tpsl_txn_time']; ?></td>      
      <td align="left"><?php echo $row['txn_msg']; ?></td>
      <td align="left"><?php echo $row['txn_status']; ?></td>
      <td align="left"><a href="manage_visitor_order.php?action=orderHistory&orderId=<?php echo $row['orderId'];?>&regid=<?php echo $row['regId'];?>" style="color:#000000">VIEW</a></td>
      <!--.....................Sales Order Create API------------>
	  <td><?php echo $row['sales_order_no'];?></td>      
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
<div class="pages_1">Total number of Order: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'manage_visitor_order.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
    </div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>

</body>
</html>