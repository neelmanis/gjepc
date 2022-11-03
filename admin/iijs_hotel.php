<?php 
session_start(); 
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
if($_SESSION['curruser_login_id'] !== '86' && $_SESSION['curruser_login_id'] !=='1'  && $_SESSION['curruser_login_id'] !=='154' ) { header("location:index.php"); exit; }

include('../db.inc.php');
include('../functions.php');
?>
<?php
function getHotelName($hotel_id,$conn)
{
	$query_sel = "SELECT hotel_name FROM  iijs_hotel_master  where hotel_id='$hotel_id'";	
	$result_sel = $conn ->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['hotel_name'];
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hotel Registration</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});
});
function showDate(date) {
	alert('The date chosen is ' + date);}
</script>

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
<!-- lightbox Thum -->


<link rel="stylesheet" type="text/css" href="css/jquery.fancybox.css" media="screen" />
	
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("div.fancyDemo a").fancybox();
		});
	</script>
<!-- lightbox Thum -->
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div></div>
<div class="clear"></div>
<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> >Hotel Registration</div>
</div>

<div id="main">
	<div class="content">
    <div class="content_head">Hotel Registration
    	  <!-- <div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_export_hotel_exh.php">Download Excel Manual</a></div> -->
    	  <div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_export_hotel_web.php">&nbsp;Download Report</a></div>
    	  <!--<div style="float:right; padding-right:10px; font-size:12px;"><a href="iijs_export_hotel_enquiries.php">&nbsp;Download Hotel Enquiry Report</a></div>-->
    </div>	
    <div class="clear"></div>
	
<div class="content_details1">

<?php 
	$sql6 = "SELECT b.hotel_name,count(a.hotel_id) as 'total' FROM gjepclivedatabase.iijs_hotel_registration_details a ,gjepclivedatabase.iijs_hotel_master b where a.hotel_id=b.hotel_id group by b.hotel_id";
	$result6 = $conn ->query($sql6);
?>
	  <table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
		<tr class="orange1">
		  <td colspan="11">Report Summary (Hotel Wise)</td>
		</tr>
		<tr>
		<?php while($rows6 = $result6->fetch_assoc()){ ?>
		  <td><strong><?php echo $rows6['hotel_name'];?> - <?php echo $rows6['total']?></strong></td>
		<?php }?>
		</tr>
	</table>
<?php 
	//$sql5 = "SELECT  a.Company_Type,count(Company_Type) as 'total' FROM vis_hotel_registration_company_master a ,iijs_hotel_registration_details b where a.Company_Pan=b.company_pan group by a.Company_Type";
	$sql5 ="SELECT  a.Company_Type,COUNT(DISTINCT a.company_pan) as 'total' FROM vis_hotel_registration_company_master a ,iijs_hotel_registration_details b where a.Company_Pan=b.company_pan group by a.Company_Type order by total ASC";
	$result5 = $conn ->query($sql5);
?>
	  <table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
		<tr class="orange1">
		  <td colspan="11">Report Summary (Category Wise)</td>
		</tr>
		<tr>
		<?php while($rows5 = $result5->fetch_assoc()){ ?>
		  <td><strong>Total <?php echo $rows5['Company_Type'];?> - <?php echo $rows5['total']?></strong></td>
		<?php }?>
		</tr>
	</table>
	
</div>

<div class="content_details1">
<form name="form1" action="" method="post"> 
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td width="14%" height="30">Name</td>
    <td width="18%">Company Name</td>
    <td width="14%">Email ID</td>
    <td width="13%">Mobile No</td>
    <td width="16%">Hotel Name</td>
    <td width="11%">Booking Date</td>
    <td width="11%">Guest Name 1</td>
    <td width="11%">Guest Name 2</td>
    <td width="11%">Guest Mob 1</td>
    <td width="11%">Guest Mob 2</td>

  </tr>
    <?php  
	$page=1;//Default page
	$limit=50;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
  
	$sql="SELECT * FROM `iijs_hotel_registration_details` WHERE 1 ";
 	$sql.=" order by post_date desc";
	$result=$conn ->query($sql);
	$rCount=$result->num_rows;
	$sql1= $sql."  limit $start, $limit";
	$result1=$conn ->query($sql1);
	
  if($rCount>0)
  {	
  while($rows=$result1->fetch_assoc())
  { 
  ?>
  <tr >
    <td><?php echo filter($rows['applicant_name']);?></td>
    <td><?php echo filter($rows['applicant_company_name']);?></td>
    <td><?php echo filter($rows['applicant_email_id']);?></td>
    <td><?php echo filter($rows['applicant_mobile_no']);?></td>
    <td><?php echo filter(getHotelName($rows['hotel_id'],$conn));?></td>
    <td><?php echo date("d-m-Y",strtotime($rows['post_date']));?></td>
	 <td><?php echo filter($rows['guest_1_name']);?></td>
	 <td><?php echo filter($rows['guest_2_name']);?></td>
	 <td><?php echo filter($rows['Guest1_Mobile']);?></td>
	 <td><?php echo filter($rows['Guest2_Mobile']);?></td>
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
<div class="pages_1">Total number of Registration: <?php echo $rCount;?>
<?php echo pagination($limit,$page,'iijs_hotel.php?action=view&page=',$rCount); //call function to show pagination?>
</div>        
      
	</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>