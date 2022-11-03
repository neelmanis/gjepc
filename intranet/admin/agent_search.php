<?php session_start(); ?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>
<?php
 
if($_REQUEST['Reset']=="Reset")
{
  $action="";
  $_SESSION['category_type']="";
  $_SESSION['name']="";
  $_SESSION['agent_code']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
  $_SESSION['status']="";
  header("Location: agent_search.php?action=view");
}else if($_REQUEST['action']=="search")
{ 
  $action=$_REQUEST['action'];
  $_SESSION['category_type']=$_REQUEST['category_type'];
  $_SESSION['name']=$_REQUEST['name'];
  $_SESSION['agent_code']=$_REQUEST['agent_code'];
  $_SESSION['from_date']=$_REQUEST['from_date'];
  $_SESSION['to_date']=$_REQUEST['to_date'];
  $_SESSION['status']=$_REQUEST['status'];
  if($action=='search')
  {
  	if($_SESSION['category_type']=="")
	{
	$_SESSION['error_msg']="Please select category";
	}
	
  }
}
?>  


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Agent Search || KP ||</title>

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

<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}


-->
</style>

</head>

<body>


<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Agent Search</div>
</div>

<div id="main">
	<div class="content">
    	<div class="content_head"><div class="content_head_button">Agent Search</div></div>
    	
      
<div class="content_details1">
<form name="search" action="" method="post" > 
<input type="hidden" name="action" value="search" />        	
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11" >Search Options</td>
</tr>
      
<tr >
    <td ><strong>Name</strong></td>
    <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $_SESSION['name'];?>" /></td>
</tr>	
    
    
<tr >
  <td><strong>Code</strong></td>
  <td><input type="text" name="agent_code" id="agent_code" class="input_txt" value="<?php echo $_SESSION['agent_code'];?>" /></td>
</tr>

<tr >
    <td width="19%"><strong>Type</strong></td>
    <td width="81%">
        <select name="category_type" id="category_type" class="input_txt">
        <option value="">Please Select Type</option>	
        <option value="Non Member" <?php if($_SESSION['category_type']=="Non Member"){echo "selected='selected'";}?>>Non Member</option>
        <option value="Member" <?php if($_SESSION['category_type']=="Member"){echo "selected='selected'";}?>>Member</option>	
        </select>    </td>
</tr>

<tr >
    <td><strong>Date</strong></td>
    <td><input type="text" name="from_date" id="popupDatepicker" value="<?php if($_SESSION['from_date']==""){echo "Form";}else{echo $_SESSION['from_date'];}?>"  class="input_date"/>
     <input type="text" name="to_date" id="popupDatepicker1" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="input_date"/></td>
</tr>

<tr  >
    <td><strong>Status</strong></td>
    <td>
    <select name="status" id="status" class="input_txt">
    <option value="">Please Select Status</option>	
    <option value="21" <?php if($_SESSION['status']=="21"){echo "selected='selected'";}?>>Pending</option>
    <option value="22" <?php if($_SESSION['status']=="22"){echo "selected='selected'";}?>>Approved</option>
    <option value="23" <?php if($_SESSION['status']=="23"){echo "selected='selected'";}?>>Rejected</option>	
    </select>    </td>
</tr>    
    
<tr >
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Search"  class="input_submit" /> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>
<?php if($_SESSION['category_type']!=""){?>

<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action" value="UPDATE_STATUS" /> 

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Agent Name</td>
    <td>Agent Contact Person</td>
    <td>Application Date</td>
    <td>Member Name</td>
    <td>Member Contact Person</td>
    <td>Status</td>
  </tr>
  <?php
  
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;
  
  
  	if($_SESSION['category_type']=='Non Member')
	{
	$sql="SELECT a.`AGENT_ID`,a.`AGENT_NO`,a.`AGENT_NAME`,a.`CONTACT_PERSON1`,b.MEMBER_ID,b.NON_MEMBER_ID,b.ENTERED_ON,b.STATUS,c.NON_MEMBER_NAME,c.CONTACT_PERSON1 FROM `kp_agent_master` a,kp_agent_member_link b,kp_non_member_master c WHERE 1 and a.`AGENT_ID`=b.AGENT_ID and b.NON_MEMBER_ID=c.NON_MEMBER_ID ";
		
		
	}else if($_SESSION['category_type']=='Member')
	{
	$sql="SELECT a.`AGENT_ID`,a.`AGENT_NO`,a.`AGENT_NAME`,a.`CONTACT_PERSON1`,b.MEMBER_ID,b.NON_MEMBER_ID,b.ENTERED_ON,b.STATUS,c.MEMBER_CO_NAME,c.CONTACT_PER_NAME FROM `kp_agent_master` a,kp_agent_member_link b,kp_member_master c WHERE 1 and a.`AGENT_ID`=b.AGENT_ID and b.MEMBER_ID=c.MEMBER_ID ";
		
	}
	
	if($_SESSION['name']!="")
	{
	$sql.=" and a.`AGENT_NAME` like '%".$_SESSION['name']."%' ";
	}
	
	if($_SESSION['agent_code']!="")
	{
	$sql.=" and a.`AGENT_NO` like '%".$_SESSION['agent_code']."%' ";
	}
	
	if($_SESSION['status']!="")
	{
	$sql.=" and b.STATUS='".$_SESSION['status']."' ";
	}

	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To")
	{
	$sql.=" and b.ENTERED_ON between '".date("Y-m-d",strtotime($_SESSION['from_date']))."' and '".date("Y-m-d",strtotime($_SESSION['to_date']))."'";
	}
	
	if($_SESSION['category_type']=='Non Member')
	{
	$sql.=" order by c.NON_MEMBER_NAME ";		
	}else if($_SESSION['category_type']=='Member')
	{
	$sql.=" order by c.MEMBER_CO_NAME ";
	}
	
	
 	$result=mysql_query($sql);
	$rCount=mysql_num_rows($result);	

	$sql1=$sql." limit $start, $limit"; 
	$result1=mysql_query($sql1);
		
  if($rCount>0)
  {	
  while($rows=mysql_fetch_array($result1))
  {
  ?>
  <tr	>
    <td><?php echo $rows['AGENT_NAME'];?></td>
    <td>
    <?php 
	if($_SESSION['category_type']=="Non Member")
	{
	echo $rows['CONTACT_PERSON1'];
	}else if($_SESSION['category_type']=="Member")
	{
	echo $rows['CONTACT_PERSON1'];
	}
	?>
   
	</td>
    <td><?php if($rows['ENTERED_ON']!=""){echo date("d-m-Y",strtotime($rows['ENTERED_ON']));}?></td>
    <td>
    <?php
	if($_SESSION['category_type']=="Non Member")
	{
	echo $rows['NON_MEMBER_NAME'];
	}else if($_SESSION['category_type']=="Member")
	{
	echo $rows['MEMBER_CO_NAME'];
	}
	?>
   
	</td>
    <td>
	<?php 
	if($_SESSION['category_type']=="Non Member")
	{
	echo $rows['CONTACT_PERSON1'];
	}else if($_SESSION['category_type']=="Member")
	{
	echo $rows['CONTACT_PER_NAME'];
	}
	?>
    </td>
    <td valign="middle">
	<?php 
	if($rows['STATUS']=="21")
	{
	echo "Pending";
	}else if($rows['STATUS']=="22")
	{
	echo "Approved";
	}else if($rows['STATUS']=="23")
	{
	echo "Rejected";
	}
	?></td>
    

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
   <tr>
     <td colspan="5">&nbsp;</td>
     <td colspan="3"></td>
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
<div class="pages_1">Total number of Memberships: <?php echo $rCount;?><?php echo pagination($limit,$page,'agent_search.php?action=view&page=',$rCount); //call function to show pagination?></div>        

<?php } ?>      
	</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>


</body>
</html>
