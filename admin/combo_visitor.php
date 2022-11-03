<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');
$registration_id = $_REQUEST['regid'];
$orderId = $_REQUEST['orderId'];
$id = $_REQUEST['id'];
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['company_name']="";
  $_SESSION['pan_no']="";
  $_SESSION['mobile']="";
  $_SESSION['visitor_approval']="";
  
  header("Location: combo_visitor.php?action=view");
} else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['company_name']=mysql_real_escape_string($_REQUEST['company_name']);
	$_SESSION['pan_no']=mysql_real_escape_string($_REQUEST['pan_no']);
	$_SESSION['mobile']=mysql_real_escape_string($_REQUEST['mobile']);
	$_SESSION['visitor_approval']=$_REQUEST['visitor_approval'];
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IIJS Signature 2019</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="fancybox/jquery-3.3.1.js"></script>      
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
<link rel="stylesheet" type="text/css" href="fancybox/fancybox_css.css" media="screen" />
	<!--<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>-->
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="fancybox/fancybox_js.js"></script>
<script type="text/javascript">
		$(document).ready(function() {
			$("div.fancyDemo a").fancybox();
		});
	</script>
<!-- lightbox Thum -->

<script>
$(document).ready(function(){
$('#disapproval').hide();

$('#disapprove').click(function(){
//alert('disapprove');
		$('#disapproval').show();
      });
	  $('#approve').click(function(){
//alert('disapprove');
		$('#disapproval').hide();
      });
});
</script>

<?php
$sql3 = "SELECT * FROM visitor_directory where visitor_id='$id'";
$result3 = mysql_query($sql3);
if($row3 = mysql_fetch_array($result3))
{
$approved = $row3['visitor_approval'];
}
?>
<script>
var approv = '<?php echo $approved; ?>';
$(document).ready(function(){
 if(approv == 'D')
 {
 $('#disapproval').show();
 }
});
</script>

<style type="text/css">
.fancybox-button--zoom,.fancybox-button--play,.fancybox-button--thumbs,.fancybox-button--arrow_left,.fancybox-button--arrow_right,.fancybox-infobar{display:none!important;}
</style>
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
	<div class="breadcome"><a href="admin.php">Home</a>
    <?php if($_REQUEST['actions']=='companyedit'){ ?> Company details
    <?php } else { ?> Employee Directory <?php } ?></div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head">
		<a href="combo_visitor.php?action=view" target="_blank">COMBO Visitors</a>
		<a href="employee_directory.php?action=view" target="_blank">Employee Directory</a>
        </div>
<?php if($_REQUEST['action']=='view') { ?>
<div class="content_details1">
<?php 
$sql5="select * from visitor_directory where visitor_approval='O'";

	$result5=mysql_query($sql5);
	$total_application=mysql_num_rows($result5);
	
	$total_approve=0;
	$total_pending=0;
	$total_disapprove=0;
	while($rows5=mysql_fetch_array($result5))
	{
		if($rows5['visitor_approval']=='Y')
		{
			$total_approve=$total_approve+1;
		}else if($rows5['visitor_approval']=='P')
		{
			$total_pending=$total_pending+1;
		}else if($rows5['visitor_approval']=='D')
		{
			$total_disapprove=$total_disapprove+1;
		}
	}
	
?>
   	      <table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
   	        <tr class="orange1">
   	          <td colspan="11" >Report Summary</td>
            </tr>
   	        <tr>
   	          <td><strong>Total Application</strong></td>
   	          <td><strong></strong></td>
   	          <td><strong></strong></td>
   	          <td><strong></strong></td>
            </tr>
   	        <tr>
   	          <td><?php echo $total_application;?></td>
   	          <td><?php //echo $total_approve;?></td>
   	          <td><?php //echo $total_disapprove;?></td>
   	          <td><?php //echo $total_pending;?></td>
            </tr>
        </table>
      </div>
<?php } ?>
<div class="content_details1" id="search">
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
    <td width="19%" ><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" autocomplete="off"/></td>
</tr>     
<tr>
  <td><strong>Pan Number</strong></td>
  <td><input type="text" name="pan_no" id="pan_no" class="input_txt" value="<?php echo $_SESSION['pan_no'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>Mobile Number</strong></td>
  <td><input type="text" name="mobile" id="mobile" class="input_txt" value="<?php echo $_SESSION['mobile'];?>" autocomplete="off"/></td>
</tr>
<!--<tr>
<td><strong>Visitor Status</strong></td>        
    <td>
        <select name="visitor_approval" class="input_txt-select" >
        <option value="">Select Status</option>
        <option value="P" <?php if($_SESSION['visitor_approval']=='P'){echo "selected='selected'";;}?>>Pending</option>
        <option value="Y" <?php if($_SESSION['visitor_approval']=='Y'){echo "selected='selected'";;}?>>Approved</option>
        <option value="D" <?php if($_SESSION['visitor_approval']=='D'){echo "selected='selected'";;}?>>Disapproved</option>
        <option value="U" <?php if($_SESSION['visitor_approval']=='U'){echo "selected='selected'";;}?>>Upadate</option>
        </select>
    </td>
</tr>-->
    <td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Search" class="input_submit"/> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<!------------------------------- ORDER DIRECTORY ---------------------------------->

<?php if($_REQUEST['action']=='view') {?>  
<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Company Name</td>
    <td>Pan Number</td>
    <td>GST Number</td>
    <td>Email</td>
    <td>Company</td>
	<td>Combo</td>
  </tr>
  <?php
  
	$page=1;//Default page
	$limit=25;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
  
  $sql="SELECT DISTINCT rm.id, rm.company_name, rm.company_pan_no, rm.mobile_no, rm.company_gstn, rm.email_id FROM registration_master rm inner join visitor_directory vd on rm.id=vd.registration_id AND vd.visitor_approval='O'";
 	
	if($_SESSION['company_name']!="")
	{
	$sql.=" and rm.company_name like '%".$_SESSION['company_name']."%'";
	}
	if($_SESSION['pan_no']!="")
	{
	$sql.=" and rm.company_pan_no like '%".$_SESSION['pan_no']."%'";
	}
	if($_SESSION['mobile']!="")
	{
	$sql.=" and rm.mobile_no like '%".$_SESSION['mobile']."%'";
	}
	 
	$result=mysql_query($sql);

	$rCount=mysql_num_rows($result);
	$sql1= $sql."  limit $start, $limit";
	$result1=mysql_query($sql1);
	
	
  if($rCount>0)
  {	
  while($rows=mysql_fetch_array($result1))
  {
  ?>
  <tr >
    <td><?php echo strtoupper($rows['company_name']);?></td>
    <td><?php echo $rows['company_pan_no'];?></td> 
    <td><?php echo $rows['company_gstn'];?></td>   
    <td><?php echo $rows['email_id'];?></td>
    <td align="center" valign="middle"><a href="employee_directory.php?actions=companyedit&regid=<?php echo $rows['id'];?>">
    <img class="icons" src="images/view.png" title="Company Details" border="0" /></a></td>
	<td align="left" valign="middle"><a href="check_combo.php?regid=<?php echo $rows['id'];?>" target="_blank">VIEW</a></td>
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
<div class="pages_1" id="page_ids">Total number of Combo Visitor: <?php echo $rCount;?>
<?php echo pagination($limit,$page,'combo_visitor.php?action=view&page=',$rCount); //call function to show pagination?>
</div>  

<!------------------------------- VIEW DREGISTRATION ---------------------------------->
      
<?php if($_REQUEST['action']=='viewReg') {?>  
<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <!--<td height="30">Company Name</td>-->
    <td>Name</td>
    <td>Designation Type</td>
    <td>Mobile Number</td>
    <td>Pan No.</td>
    <td>Aadhar Number</td>
    <td>Status</td>
    <td>View Details</td>
  </tr>
  <?php
  
	$page=1;//Default page
	$limit=25;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
  
    $sql="SELECT * FROM visitor_directory where registration_id = '$registration_id'"; 	 
	$result=mysql_query($sql);
	$rCount=mysql_num_rows($result);
	$sql1= $sql."  limit $start, $limit";
	$result1=mysql_query($sql1);
	
  if($rCount>0)
  {	
  while($rows=mysql_fetch_array($result1))
  { 
	$visitor_approval = $rows['visitor_approval'];
	if($visitor_approval == "Y"){ $visitor_approval= "<span style='color:green'>Approved</span>";} 
	if($visitor_approval == "P"){ $visitor_approval= "<span style='color:blue'>Pending</span>";}
	if($visitor_approval == "D"){ $visitor_approval= "<span style='color:red'>Disapproved</span>";}
	if($visitor_approval == "O"){ $visitor_approval= "<span style='color:green'>COMBO</span>";}
  ?>
  <tr >
    <td><?php echo strtoupper($rows['name']);?></td>
    <td><?php echo $rows['degn_type'];?></td> 
    <td><?php echo $rows['mobile'];?></td> 
    <td><?php echo $rows['pan_no'];?></td>  
    <td><?php echo $rows['aadhar_no'];?></td>   
    <td><?php echo $visitor_approval;?></td>   
    <td align="left" valign="middle"><a href="employee_directory.php?action=edit&id=<?php echo $rows['visitor_id'];?>&regid=<?php echo $rows['registration_id'];?>">
    <img src="images/edit.gif" title="Edit" border="0" /></a></td>
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

<!------------------------------- ORDER DETAILS ----------------------------------> 
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>