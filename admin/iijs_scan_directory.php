<?php 
session_start(); 
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
	$_SESSION['company_name']="";
	$_SESSION['unique_id']="";
	$_SESSION['email']="";
	$_SESSION['pan_no']="";

    header("Location: iijs_scan_directory.php?action=view");
  
}else
{ 
  	$search_type=$_REQUEST['search_type'];
  	if($search_type=="SEARCH")
	{ 
	  $_SESSION['company_name']=$_REQUEST['company_name'];
	  $_SESSION['unique_id']=$_REQUEST['unique_id'];
	  $_SESSION['email']=$_REQUEST['email'];
	  $_SESSION['pan_no']=$_REQUEST['pan_no'];
	}
	if($search_type=='SEARCH')
	{
		if($_SESSION['company_name']=="" && $_SESSION['unique_id']=="" && $_SESSION['email']=="Form" && $_SESSION['pan_no']=="To" )
		{
			$_SESSION['error_msg']="Please fill atleast one field to search";
		}
	}
}
?>  

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IGJME Exhibitor List</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />

<!--navigation-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>      
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>

<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
	$('#popupDatepicker').datepick();
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick();
	$('#inlineDatepicker1').datepick({onSelect: showDate});

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
<script type="text/javascript" src="js/jquery.fancybox-1.2.1.js"></script>
<script type="text/javascript">
	$("div.fancyDemo a").fancybox();
</script>
<!-- lightbox Thum -->
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>
<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> >IGJME Exhibitor</div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head"><a href="igjme_exhibitor_rgistration.php">
    	<div class="content_head_button">IGJME Exhibitor Scan List</div></a>
		<?php if(!empty($adminID)){?>
		<!-- <div style="float:right; padding-right:10px; font-size:12px;">
        <a href="export_utr_igjme_exhibitor_rgistration.php">&nbsp;Download Payment Data</a>
		<a href="export_approve_igjme_exhibitor_registration.php">&nbsp;Download All Data</a>
		</div> --><?php } ?>
		</div>
    
<div class="clear"></div>
<div class="content_details1">

<form name="search" action="" method="POST"> 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />        	
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<?php if($_REQUEST['action']=='view') { ?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt">
  <tr class="orange1"><td colspan="11">Search Options</td></tr>
  <tr>
    <td><strong>Name</strong></td>
    <td><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>"/></td>
  </tr>
  <tr>
    <td><strong>Email ID</strong></td>
    <td><input type="text" name="email" id="email" class="input_txt" value="<?php echo $_SESSION['email'];?>"/></td>
  </tr>
  <tr>
    <td><strong>Pan No </strong></td>
    <td><input type="text" name="pan_no" id="pan_no" class="input_txt" value="<?php echo $_SESSION['pan_no'];?>"/></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" />
      <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
  </tr>
</table>
</form>      
</div>

<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" /> 

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td width="7%" height="30">ID</td>
    <td width="14%">Exhibitor Name</td>
    <td width="10%">Exhibitor Email</td>
    <td width="10%">Exhibitor Pan No</td>
    <td width="10%">Exhibitor Mobile No</td>
	  <td width="15%">Visitor Name.</td>
    <td width="10%">Visitor Email</td>
    <td width="10%">Visitor PanNo</td>
    <td width="7%">Visitor Mobile</td>
    <td width="7%">View</td>
    <td width="23%">Creatd Date</td>
  </tr>
  <?php
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
  ?>

	<?php if(isset($_GET['page']) && $_GET['page']!=''){
	  $page=$_GET['page'];
	}
	$start=($page-1)*$limit;
    if($_SESSION['curruser_role']=="Super Admin")
    {
        $sql="SELECT * FROM `contact_details_scan_log` as c where c.user_name != '' GROUP BY c.userUniqueId ";
    } 
  if($_SESSION['company_name']!="")
  {
  		$sql.=" and client_name like '%".$_SESSION['company_name']."%' or user_name like '%".$_SESSION['company_name']."%' ";
  }
     
  if($_SESSION['email']!="")
  {
  		$sql.=" and client_name like '%".trim($_SESSION['email'])."%' or user_name like '%".trim($_SESSION['email'])."%'";
  }
  
  if($_SESSION['pan_no']!="")
  {
  		$sql.=" and client_panno like '%".trim($_SESSION['pan_no'])."%' or user_panno like '%".trim($_SESSION['pan_no'])."%' ";
  }
  
 	$sql.=" order by c.created_at desc "; 
	//$result=$conn->query($sql);

	$sql1= $sql."  limit $start, $limit";
  //echo $sql1;
	$result1=$conn->query($sql1);	
	$rCount=$result1->num_rows;
  if($rCount>0)
  {	$i=1;
  while($rows=$result1->fetch_assoc())
  {
  	
  ?>
  <tr>
  	<td><?php echo $i//$rows['id'];?></td>
    <td><?php echo strtoupper(filter($rows['user_name']));?></td>
    <td><?php echo $rows['user_email']; ?></td>
    <td><?php echo $rows['user_panno']; ?></td>
    <td><?php echo $rows['user_mobile']; ?></td>
    <td><?php echo strtoupper(filter($rows['client_name']));?></td>
    <td><?php echo $rows['client_email'];?></td>
    <td><?php echo $rows['client_panno'];?></td>
    <td><?php echo $rows['client_mobile'];?></td>
	  <td><a href="iijs_scan_directory.php?action=viewVisitors&exhUniqueId=<?php echo $rows['userUniqueId']?>">View</a></td>
    <td><?php echo $rows['created_at']; ?></td>

    
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
   <?php  } ?>  
</table>

</form>
</div>  
<?php
function pagination($per_page = 10, $page = 1, $url = '', $total){ 
    $per_page = 10;
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
$pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
}else{
$pagination.= "<li><a class='current'>Next</a></li>";
$pagination.= "<li><a class='current'>Last</a></li>";
}
$pagination.= "</ul>\n"; 
} 

return $pagination;
} 
?>	
<div class="pages_1">Total Number of Application: <?php echo $rCount;?>
<?php echo pagination($limit,$page,'iijs_scan_directory.php?page=',$rCount); //call function to show pagination?>

</div>        
</div>
</div>
<?php } ?>

<?php if($_REQUEST['action']=='viewVisitors') {?>   
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt">
  <tr class="orange1"><td colspan="11">Search Options</td></tr>
  <tr>
    <td><strong>Name</strong></td>
    <td><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>"/></td>
  </tr>
 
  <tr>
    <td><strong>Pan No </strong></td>
    <td><input type="text" name="pan_no" id="pan_no" class="input_txt" value="<?php echo $_SESSION['pan_no'];?>"/></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" />
      <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
  </tr>
</table>
<?php $exhUniqueId = filter($_REQUEST['exhUniqueId']);  ?>
<div class="content_details1">
    <form  method="POST" name="form1" id="form1">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
      <tr class="orange1">
        <td width="7%" height="30">ID</td>
        <td width="15%">Visitor Name</td>
        <td width="10%">Visitor PanNo</td>
        <td width="7%">Visitor Mobile</td>
        <td width="23%">Creatd Date</td>
      </tr>
    
    <?php
 
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'modifiedDate';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
    $sql = "SELECT * FROM `contact_details_scan_log` as c where c.userUniqueId = $exhUniqueId  ";
	

	 if($_SESSION['company_name']!="")
    {
    $sql.=" and c.client_name like '%".$_SESSION['company_name']."%'";
    }
    if($_SESSION['pan_no']!="")
    {
    $sql.=" and c.client_panno like '%".$_SESSION['pan_no']."%'";
    }
     $sql = $sql.$attatch;
     //echo $sql;
    $result =  $conn ->query($sql);

    
    $rCount=0;
    $rCount = $result->num_rows;;		
    if($rCount>0)
    {	
    while($row =  $result->fetch_assoc())
    {	
    ?>  
      <tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
          <td><?php echo $i;?></td>
          <td><?php echo filter($row['client_name']); ?></td>
          <td><?php echo filter($row['client_panno']); ?></td>
          <td><?php echo $row['client_mobile']; ?></td>
          <td><?php echo $row['created_at']; ?></td>
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
</form>
</div>
<?php } ?> 
<div id="footer_wrap"><?php include("include/footer.php");?></div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>


<div id="overlay"></div>
<style>
#overlay {
    position: fixed;
    display: none; 
    width: 100%; 
    height: 100%; 
    top: 0; 
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.8);
z-index:999;}  	
</style>
</body>
</html> 