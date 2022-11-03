<?php 
session_start(); 
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
include('../db.inc.php');
//include('../functions.php');
?>
<?php  
function getStateName($id,$conn)
{
	$query_sel = "SELECT state_name FROM  state_master  where state_code='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
		return $row['state_name'];		
}

function getRegionName($id,$conn)
{
	$query_sel = "SELECT region FROM state_master where state_code='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
		return $row['region'];
}

function getVisitorDesignationID($id,$conn)
{
	$query_sel = "SELECT type_of_designation FROM visitor_designation_master where id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();  		
		return $row['type_of_designation'];
}

function CheckMembership($registration_id,$conn)
{
	$sql = "SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' and issue_membership_certificate_expire_status='Y'";
	$result = $conn ->query($sql);
	$num_rows = $result->num_rows;
	if($num_rows>0)
	{
		return 'M';
	} else {
		return 'NM';
	}
}
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['pan_no']="";
  $_SESSION['mobile_no']="";
  $_SESSION['location']="";   
  $_SESSION['company_name']=""; 
  header("Location: manage_self_covid_report.php?action=view");
} else {
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['pan_no']=filter($_REQUEST['pan_no']);
	$_SESSION['location']=filter($_REQUEST['location']);
	$_SESSION['mobile_no']=filter($_REQUEST['mobile_no']);
	$_SESSION['company_name']=filter($_REQUEST['company_name']);
	
	}
}
?>

<?php
if(isset($_POST['export']))
{

	
$table = $display = "";	
//if($_SESSION["region"]!='') { $pRegion=$_SESSION["region"]; } else { $pRegion="all"; }

$fn = "visitors_self_covid_report_".$pRegion. date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Created Date</td>
<td>Company Name</td>
<td>Visitor Name</td>
<td>Visitor PAN</td>
<td>Mobile</td>
<td>Self Declaration</td>
<td>Status</td>

</tr>';

	$sql="SELECT v.visitor_id,l.create_date, l.pan_no,r.id,r.company_name,l.mobile_no,l.lab_name,l.location,l.status,v.name,l.self_declaration
	from visitor_lab_info l 
	left join registration_master r on l.registration_id=r.id 
	left join visitor_directory v on l.visitor_id=v.visitor_id where l.status='1' AND via='self' ";
	

	if($_SESSION['company_name']!="")
	{
		$sql.=" and r.`company_name` like '%".$_SESSION['company_name']."%'";
	}
	if($_SESSION['pan_no']!="")
	{
		$sql.=" and l.`pan_no` ='".$_SESSION['pan_no']."'";
	}
	
	if($_SESSION['mobile_no']!="")
	{
		$sql.=" and l.`mobile_no` ='".$_SESSION['mobile_no']."'";
	}
	$attach=" order by l.create_date desc"; 
	$sql.= "  ".$attach." "; 
	//echo $sql; exit;
	$result = $conn ->query($sql);
	$rCount = $result->num_rows;
	while($row = $result->fetch_assoc())
	{ 
		$registration_id=$row['id'];
	
		$company_name=$row['company_name'];
	
		$table .= '<tr>
		<td>'.$row['create_date'].'</td>
		<td>'.$row['company_name'].'</td>
		<td>'.$row['name'].'</td>
		<td>'.$row['pan_no'].'</td>
		<td>'.$row['mobile_no'].'</td>
	
		<td>'.$row['self_declaration'].'</td>
		<td>'.$row['status'].'</td>
				
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
<title>Manage Visitor || GJEPC ||</title>
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

</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>
<div class="clear"></div>
<!--<div class="breadcome_wrap"><div class="breadcome"><a href="admin.php">Home</a> > Manage Visitor</div></div>-->

<div id="main">
	<div class="content">
    <!--<div class="content_head">Manage Visitor &nbsp; &nbsp;
    <?php if($_REQUEST['action']=='view_details'){ ?>
    <div style="float:right; padding-right:10px; font-size:12px;"><a href="manage_self_covid_report.php?action=view">Back to Visitor</a></div>
    <?php } ?>
    </div>-->
<div class="content_details1">
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>

<form name="search" action="" method="POST"> 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Search Options</td>
</tr>
<tr>


<tr>
    <td width="19%"><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" autocomplete="off"/></td>
</tr>     
<tr>
  <td><strong>Visitor PAN Number</strong></td>
  <td><input type="text" name="pan_no" id="pan_no" maxlength="10" class="input_txt" value="<?php echo $_SESSION['pan_no'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>Mobile Number</strong></td>
  <td><input type="text" name="mobile_no" id="mobile_no" class="input_txt" value="<?php echo $_SESSION['mobile_no'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>Location</strong></td>
  <td><input type="text" name="location" id="location" class="input_txt" value="<?php echo $_SESSION['location'];?>" autocomplete="off"/></td>
</tr>

<td>&nbsp;</td>
<td>
<input type="submit" name="Submit" value="Search" class="input_submit"/>
<input type="submit" name="Reset" value="Reset" class="input_submit" />
<input type="submit" name="export" value="Export" class="input_submit" />
</td>
</tr>	
</table>
</form>      
</div>

<?php  if($_REQUEST['action']=='view') {
	   $_SESSION['submit'] = $_POST['Submit'];
	//   if(isset($_SESSION['submit'])){ ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
    <td>Created Date</td>
	<td>Company Name</td>
	<td>Visitor Name</td>	
	<td>Pan Number</td>
	<td>Mobile Number</td>
	<td>Self Declaration</td>    
   
	</tr>
    
    <?php 	
 	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
	
    $i=1;
     $sql="SELECT v.visitor_id,l.create_date, l.pan_no,r.id,r.company_name,l.mobile_no,l.lab_name,l.location,l.status,v.name,l.self_declaration
		from visitor_lab_info l 
		left join registration_master r on l.registration_id=r.id 
		left join visitor_directory v on l.visitor_id=v.visitor_id where l.status='1' AND via='self' ";
	

	if($_SESSION['company_name']!="")
	{
		$sql.=" and r.`company_name` like '%".$_SESSION['company_name']."%'";
	}
	if($_SESSION['pan_no']!="")
	{
		$sql.=" and l.`pan_no` ='".$_SESSION['pan_no']."'";
	}
	if($_SESSION['location']!="")
	{
		$sql.=" and l.`location` ='".$_SESSION['location']."'";
	}
	if($_SESSION['mobile_no']!="")
	{
		$sql.=" and l.`mobile_no` ='".$_SESSION['mobile_no']."'";
	}
	
	$attach=" order by l.create_date desc"; 
	$sql.= "  ".$attach." "; 
	//echo $sql; exit;

	$result1=$conn ->query($sql);
	$rCount= $result1->num_rows;	
	$sql1= $sql." limit $start, $limit";
	$result=$conn ->query($sql1);

    if($rCount>0)
    {	
	while($rows = $result->fetch_assoc())
	{	
    ?>  
	
 	<tr>
	<td><?php echo filter($rows['create_date']);?></td>
    <td><?php echo strtoupper($rows['company_name']);?></td>
    <td><?php echo strtoupper($rows['name']);?></td>
	<td><?php echo filter($rows['pan_no']);?></td>
    <td><?php echo filter($rows['mobile_no']);?></td>
    <td><?php echo filter($rows['self_declaration']);?></td>
   
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
<?php //} ?> 
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
<div class="pages_1">Total number of Participant: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'manage_self_covid_report.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>