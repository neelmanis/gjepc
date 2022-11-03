<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
		$adminID = intval(filter($_SESSION['curruser_login_id']));
$registration_id = intval(filter($_REQUEST['regid']));
			 $id = intval(filter($_REQUEST['id']));
?>

<?php
$regsql = "select * from registration_master where id = '$registration_id'";
$regquery = $conn ->query($regsql);
while($regrow = $regquery->fetch_assoc())
{
$companyname = filter($regrow['company_name']);
   $email_id = filter($regrow['email_id']);
}
?>

<?php
if(($_REQUEST['action']=='delVisitor') && ($_REQUEST['visitor_id']!='') && ($_REQUEST['registration_id']!=''))
{ 
	//echo '<pre>'; print_r($_REQUEST); exit;
	$visitor_id = filter($_REQUEST['visitor_id']);	
	$registration_id  = filter(intval($_REQUEST['registration_id']));
	
	$sqlPaymentCheck = "SELECT * FROM visitor_order_history WHERE registration_id='$registration_id' AND visitor_id='$visitor_id' AND status='1' AND payment_status='Y' AND `show`='signature22' AND year='2022'";
    $resultPaymentCheck = $conn->query($sqlPaymentCheck);
    $countPaymentCheck = $resultPaymentCheck->num_rows;
    if($countPaymentCheck > 0 ){
	echo "<script> alert('Visitor is Already Registered for Current Show');</script>";
	echo "<meta http-equiv=refresh content=\"0;url=employee_directory_delete.php?action=view\">"; exit;
	} else {
    $ssx = "INSERT INTO visitor_directory_deleted
		SELECT * FROM  visitor_directory WHERE visitor_id = $visitor_id AND `registration_id`='$registration_id'";
	$queryData = $conn->query($ssx);
	if($queryData){
	$deletx = "DELETE FROM `visitor_directory` WHERE `registration_id`='$registration_id' AND `visitor_id` ='$visitor_id' limit 1"; 
	$resultx = $conn->query($deletx);
	if($resultx){
	$updatx = "UPDATE `visitor_directory_deleted` SET `admin_delete_id` = '$adminID' WHERE `registration_id`='$registration_id' AND `visitor_id` ='$visitor_id' limit 1"; 
	$updatx = $conn->query($updatx);
	echo "<script> alert('Deleted from Visitor directory');</script>";
	echo "<meta http-equiv=refresh content=\"0;url=employee_directory_delete.php?action=view\">"; exit;
	}
	} else { die ($conn->error); }	
	}
}
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['company_name']="";
  $_SESSION['pan_no']="";
  $_SESSION['mobile']="";
  $_SESSION['visitor_approval']="";
  
  header("Location: employee_directory_delete.php?action=view");
} else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['company_name']=	filter($_REQUEST['company_name']);
	$_SESSION['pan_no']		 = 	filter($_REQUEST['pan_no']);
	$_SESSION['mobile']		 =  filter($_REQUEST['mobile']);
	$_SESSION['visitor_approval'] = $_REQUEST['visitor_approval'];
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Employee Directory Delete Request</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="fancybox/jquery-3.3.1.js"></script> 
<script type="text/javascript" src="fancybox/fancybox_js.js"></script>
<script type="text/javascript">		
$("div.fancyDemo a").fancybox();
</script>     
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<!--navigation end-->
<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="fancybox/fancybox_css.css" media="screen" />
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<!-- lightbox Thum -->

<style type="text/css">
.inner {/*  border: 1px solid #ccc;
*/
    border: 1px solid #ccc;
    border-collapse: separate;
    margin: 0;
    padding: 0;
    background: white;
    width: 50%;
    table-layout: fixed;
}
.inner tr {
background: #f8f8f8;
border: 1px solid #ddd;
padding: .35em;
}
.inner th,
.inner td {padding: .625em;text-align: left;padding: 10px 20px;}
.inner th {font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;}
</style>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> Employee Directory </div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head">
		 <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;">
        <a href="iijs_employee_directory.php?action=view">Back to Directory</a></div>
        </div>

<!------------------------------- ORDER DIRECTORY ---------------------------------->

<?php if($_REQUEST['action']=='view') { ?>  
<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Company Name</td>
    <td>Company PAN</td>
    <td>Name</td>
    <td>Mobile</td>
	<td>PAN</td>
    <td>Delete</td>
  </tr>
	<?php  
	$page=1;//Default page
	$limit=25;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
  
	$sql="SELECT  rm.id, rm.company_name, rm.company_pan_no, rm.mobile_no, rm.company_gstn, rm.email_id,rm.approval_status,vd.* FROM registration_master rm inner join visitor_directory vd on rm.id=vd.registration_id AND vd.agree_delete='Y'";
	$result = $conn ->query($sql);

	$rCount = $result->num_rows;
	$sql1= $sql."  limit $start, $limit";
	$result1= $conn ->query($sql1);
		
  if($rCount>0)
  {	
  while($rows = $result1->fetch_assoc())
  {
  ?>
  <tr>
    <td><?php echo strtoupper($rows['company_name']);?></td>
	<td><?php echo filter($rows['company_pan_no']);?></td> 
	<td><?php echo $rows['name'].''.$rows['lname'];?></td> 
	<td><?php echo filter($rows['mobile']);?></td> 
	<td><?php echo filter($rows['pan_no']);?></td> 
	<td><a style="text-decoration:none;" href="employee_directory_delete.php?action=delVisitor&visitor_id=<?php echo $rows['visitor_id'];?>&registration_id=<?php echo $rows['id'];?>" onClick="return(window.confirm('Are you sure you want to Delete.'));"><img src="images/no.gif" border="0" title="Delete"/></a></td>
   
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
<div class="pages_1" id="page_ids">Total Number Visitor : <?php echo $rCount;?>
<?php echo pagination($limit,$page,'employee_directory_delete.php?action=view&page=',$rCount); //call function to show pagination?>
</div>  

</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>

</body>
</html>