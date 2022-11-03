<?php 
session_start(); 
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
$adminID = intval($_SESSION['curruser_login_id']);
include('../db.inc.php');
//include('../functions.php');
?>
<?php 
function gotStatesName($adminRegion,$conn)
{
	$query_sel = "SELECT state_code FROM state_master where region_name='$adminRegion'";
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
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['category']="";
  $_SESSION['visited_show']="";
  $_SESSION['designation']="";
  $_SESSION['state']="";
  $_SESSION['region']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
  $_SESSION['firm_type']="";
  $_SESSION['member_type']="";  
  $_SESSION['company_name']="";
  $_SESSION['company_pan_no']="";
  $_SESSION['fname']="";
  $_SESSION['lname']="";
  $_SESSION['email_id']="";
  $_SESSION['city']="";
  $_SESSION['order_id']="";
  $_SESSION['visitor_approval']="";    
  header("Location: manage_visitor_reports.php?action=view");
} else {
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['category']=filter($_REQUEST['category']);
	$_SESSION['visited_show']=filter($_REQUEST['visited_show']);
	$_SESSION['designation']=filter($_REQUEST['designation']);
	$_SESSION['state']=filter($_REQUEST['state']);
	$_SESSION['region']=filter($_REQUEST['region']);
	$_SESSION['from_date']=$_REQUEST['from_date'];
	$_SESSION['to_date']=$_REQUEST['to_date'];
	$_SESSION['firm_type']=$_REQUEST['firm_type'];
	$_SESSION['member_type']=$_REQUEST['member_type'];	
	$_SESSION['company_name']=filter($_REQUEST['company_name']);
	$_SESSION['company_pan_no']=filter($_REQUEST['company_pan_no']);
	$_SESSION['fname']=filter($_REQUEST['fname']);
	$_SESSION['lname']=filter($_REQUEST['lname']);
	$_SESSION['email_id']=filter($_REQUEST['email_id']);
	$_SESSION['city']=filter($_REQUEST['city']);
	$_SESSION['order_id']=filter($_REQUEST['order_id']);	
	$_SESSION['visitor_approval']  =	$_REQUEST['visitor_approval'];
	}
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
    <div style="float:right; padding-right:10px; font-size:12px;"><a href="manage_visitor_reports.php?action=view">Back to Visitor</a></div>
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
    <td><strong>Category</strong></td>        
    <td>
	<select name="category" class="input_txt">
      <option value="">Select Category</option>
      <option value="VIP" <?php if($_SESSION['category']=='VIP'){echo "selected";}?>>VIP</option>
      <option value="VVIP" <?php if($_SESSION['category']=='VVIP'){echo "selected";}?>>VVIP</option>   
      <option value="Elite" <?php if($_SESSION['category']=='Elite'){echo "selected";}?>>ELITE</option>   
      <option value="visitor" <?php if($_SESSION['category']=='visitor'){echo "selected";}?> selected>Registered Visitors</option>   
    </select>
	</td>
</tr>
<tr>
    <td><strong>Show Visited </strong></td>        
    <td>
	<select name="visited_show" class="input_txt">
      <option value="">Select Show</option>
      <!--<option value="iijs-2019" <?php if($_SESSION['visited_show']=='iijs-2019'){echo "selected";}?>>IIJS 2019</option>
      <option value="signature-2019" <?php if($_SESSION['visited_show']=='signature-2019'){echo "selected";}?>>SIGNATURE 2019</option>
      <option value="vbsm-2020" <?php if($_SESSION['visited_show']=='vbsm-2020'){echo "selected";}?>>IIJS Virtual 2020</option>
      <option value="vbsm2-2021" <?php if($_SESSION['visited_show']=='vbsm2-2021'){echo "selected";}?>>IIJS Virtual 2021</option>
      <option value="signature2-2021" <?php if($_SESSION['visited_show']=='signature2-2021'){echo "selected";}?>>IIJS SIGNATURE 2021</option>-->
      <!--<option value="signature22" <?php if($_SESSION['visited_show']=='signature22'){echo "selected";}?> selected>IIJS SIGNATURE 2022</option>
      <option value="igjme22" <?php if($_SESSION['visited_show']=='igjme22'){echo "selected";}?> >IIJS MACHINERY 2022</option>-->
    <!--<option value="iijstritiya22" <?php if($_SESSION['visited_show']=='iijstritiya22'){echo "selected";}?> selected>Tritiya</option>-->
	
	<option value="iijs22" <?php if($_SESSION['visited_show']=='iijs22'){echo "selected";}?> selected>IIJS PREMIERE 2022</option>
	<option value="signature23" <?php if($_SESSION['visited_show']=='signature23'){echo "selected";}?> >IIJS SIGNATURE 2023</option>
	<option value="iijstritiya23" <?php if($_SESSION['visited_show']=='iijstritiya23'){echo "selected";}?> >IIJS TRITIYA 2023</option>
	<option value="combo23" <?php if($_SESSION['visited_show']=='combo23'){echo "selected";}?> >IIJS PREMIERE 22 &  IIJS SIGNATURE 23 & IIJS TRITIYA 23</option>
    </select>
	</td>
</tr>
<!--<tr>
    <td><strong>Designation</strong></td>        
    <td>
	<select name="designation" class="input_txt">
      <option value="">Select Designation</option>
      <option value="19" <?php if($_SESSION['designation']=='19'){echo "selected";}?>>Partners</option>
      <option value="18" <?php if($_SESSION['designation']=='18'){echo "selected";}?>>Properitor</option>
      <option value="23" <?php if($_SESSION['designation']=='23'){echo "selected";}?>>CEO</option>
	  <option value="26" <?php if($_SESSION['designation']=='26'){echo "selected";}?>>MD</option>
      <option value="20" <?php if($_SESSION['designation']=='20'){echo "selected";}?>>Director</option>
      <option value="21" <?php if($_SESSION['designation']=='21'){echo "selected";}?>>Chairman</option>     
    </select>
	</td>
</tr> --> 
<tr>
    <td><b>Region</b></td>
    <td>
    <select name="region" id="region" class="input_txt">
        <option value="">--- Select Region ---</option>
    	<?php 
		$region_query = "select * from region_master";
		$execute_region = $conn ->query($region_query);
		while($show_region = $execute_region->fetch_assoc()){?>
    	<option value="<?php echo $show_region["region_name"]; ?>" <?php if($_SESSION["region"]==$show_region["region_name"]) echo "selected"; ?>><?php echo $show_region["region_name"]; ?></option>
    	<?php } ?>
    </select>
    </td>
</tr>
<tr>
<tr>
    <td><strong>State</strong></td>        
    <td>
	<select name="state" id="state" class="input_txt">
		<option value="">--- Select State ---</option>
		<?php 
		$query = $conn ->query("SELECT * from state_master WHERE country_code = 'IN'");
		while($result= $query->fetch_assoc()){ ?>
		<option value="<?php echo $result['state_code'];?>"  <?php if($_SESSION['state']==$result['state_code']){?> selected="selected" <?php }?>><?php echo $result['state_name'];?></option>
		<?php } ?>
	</select> 
	</td>
</tr>
<!--<tr>
    <td><strong>City</strong></td>        
    <td><input type="text" name="city" value="<?php echo $_SESSION['city'];?>" >	</td>
</tr>-->
    <td><strong>Date</strong></td>
    <td>
	<input type="text" name="from_date" id="popupDatepicker" value="<?php if($_SESSION['from_date']==""){echo "From";}else{echo $_SESSION['from_date'];}?>"  class="input_date" readonly/>
    <input type="text" name="to_date" id="popupDatepicker1" value="<?php if($_SESSION['to_date']==""){echo "To";}else{echo $_SESSION['to_date'];}?>" class="input_date" readonly/></td>
</tr>
<!--<tr>
    <td><strong>Firm Type</strong></td>
    <td>
    <select name="firm_type" id="firm_type" class="input_txt">
    <option value="">Please Select Firm Type</option>	
    <?php 
	$sqlF="select * from type_of_firm_master where status='1'";
	$result = $conn ->query($sqlF);
	while($rows = $result->fetch_assoc())
	{
	if($_SESSION['sap_value']==$rows['type_of_firm_name'])
	{
	echo "<option value='$rows[sap_value]' selected='selected'>$rows[type_of_firm_name]</option>";
	}else
	{
	echo "<option value='$rows[sap_value]'>$rows[type_of_firm_name]</option>";
	}
	}
	?>    
    </select>
    </td>
</tr>

<tr>
  <td><strong>Member Type</strong></td>
  <td>
    <select name="member_type" class="input_txt">
    <option value="">Please Select Member Type</option>
	<option value="M" <?php if($_SESSION['member_type']=='M'){echo "selected";}?>>Member</option>
    <option value="NM" <?php if($_SESSION['member_type']=='NM'){echo "selected";}?>>NonMember</option> 	  
	</select>
  </td>
</tr>-->

<!--<tr>
    <td><strong>Application Status</strong></td>        
    <td>
	<select name="visitor_approval" class="input_txt">
      <option value="">Select Status</option>
      <option value="Y" <?php if($_SESSION['visitor_approval']=='Y'){echo "selected";}?>>Application Approved</option>
	  <option value="P" <?php if($_SESSION['visitor_approval']=='P'){echo "selected";}?>>Application Pending</option>
      <option value="D" <?php if($_SESSION['visitor_approval']=='D'){echo "selected";}?>>Application Disapproved</option>      
    </select>
	</td>
</tr> -->
<!--
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
  <td><strong>Last Name</strong></td>
  <td><input type="text" name="lname" id="lname" class="input_txt" value="<?php echo $_SESSION['lname'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>Company Email</strong></td>
  <td><input type="text" name="email_id" id="email_id" class="input_txt" value="<?php echo $_SESSION['email_id'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>Order ID</strong></td>
  <td><input type="text" name="order_id" id="order_id" class="input_txt" value="<?php echo $_SESSION['order_id'];?>" autocomplete="off"/></td>
</tr>-->
<td>&nbsp;</td>
<td>
<input type="submit" name="Submit" value="Search" class="input_submit"/>
<input type="submit" name="Reset" value="Reset" class="input_submit" />
<?php /* if(isset($_POST['Submit'])){?><input type="submit" name="export" value="Export" class="input_submit" /><?php } */?>
</td>
</tr>	
</table>
</form>      
</div>

<?php  //if($_REQUEST['action']=='view') {
	   $_SESSION['submit'] = $_POST['Submit'];
	   if(isset($_SESSION['submit'])){ ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<!--<tr class="orange1">
    <td>Company PAN</td>
	<td>Company Name</td>
	<td>Email</td>	
	<td>Person Name</td>
	<td>Person PAN</td>
	<td>Person Mobile</td>    
	</tr>-->
	<tr class="orange1">
    <td>City</td>
	<td></td>  
	</tr>
    
    <?php 	
 	$page=1;//Default page
	$limit=300;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
	
    $i=1;
	$sql="SELECT count(*) as cityCount,oh.visitor_id, oh.create_date as 'create_date',oh.orderId, rm.id,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.state,rm.city,rm.pin_code,rm.email_id,rm.company_type,    vd.bp_number,vd.name,vd.lname,vd.designation,vd.pan_no,vd.gender,vd.mobile,vd.email,vd.category,vd.visitor_approval, 
	oh.payment_made_for, oh.amount as 'Amount', oh.payment_status as 'payment_status',oh.`show`, oh.year
	from visitor_order_history oh 
	inner join registration_master rm on oh.registration_id=rm.id 
	inner join visitor_directory vd on oh.visitor_id=vd.visitor_id where 1 AND oh.`payment_status` ='Y'";
	
	if($_SESSION['category']!="")
	{
		if($_SESSION['category']=="visitor"){
		$sql.=" ";
		} else {
		$sql.=" and vd.category ='".$_SESSION['category']."'";
		}
	}
	
	if($_SESSION['visited_show']!="")
	{
		$arr_string = explode("-",$_SESSION['visited_show']); 
		$show = $arr_string[0];
		$year = $arr_string[1];
	$sql.=" and oh.`show` ='".$show."'";
	}
	/*$sql.=" and oh.`show` ='".$show."' AND oh.year='".$year."'";
	} else { 
	$sql.=" and oh.`show` ='vbsm2' AND oh.year='2021'";
	} 
	
	if($_SESSION['designation']!="")
	{
		$sql.=" and vd.`designation` ='".$_SESSION['designation']."'";
	}
	*/
	
	if($_SESSION['state']!="")
	{
		$sql.=" and rm.state ='".$_SESSION['state']."'";
	}
	
	if($_SESSION["region"]!="")
	{ 
	$getRegion = $_SESSION["region"];
	$myRegion = gotStatesName($getRegion,$conn);
	$sql.=" and rm.state IN (".$myRegion.")";
	}
	
	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="From" && $_SESSION['to_date']!="To")
	{
	$sql.=" and oh.create_date BETWEEN '".date("Y-m-d",strtotime($_SESSION['from_date']))." 00:00:00' AND '".date("Y-m-d",strtotime($_SESSION['to_date']))." 23:59:59'";
	} 

	if($_SESSION['company_name']!="")
	{
	$sql.=" and rm.company_name like '%".$_SESSION['company_name']."%'";
	}
	
	if($_SESSION['company_pan_no']!="")
	{
	$sql.=" and rm.company_pan_no ='".$_SESSION['company_pan_no']."'";
	}
	
	if($_SESSION['city']!="")
	{
	$sql.=" and rm.city like '%".$_SESSION['city']."%'";
	}
	
	/*
	if($_SESSION['firm_type']!="")
	{
		$sql.=" and rm.company_type ='".$_SESSION['firm_type']."'";
	}
	
	if($_SESSION['fname']!="")
	{
	$sql.=" and vd.name like '%".$_SESSION['fname']."%'";
	}
	
	if($_SESSION['lname']!="")
	{
	$sql.=" and vd.lname like '%".$_SESSION['lname']."%'";
	}
	
	if($_SESSION['email_id']!="")
	{
	$sql.=" and rm.email_id like '%".$_SESSION['email_id']."%'";
	}
	
	if($_SESSION['order_id']!="")
	{
	$sql.=" and orderId ='".$_SESSION['order_id']."'";
	}
	
	if($_SESSION['visitor_approval']!="")
	{ 
		if($_SESSION['visitor_approval']=='Y')
		{
		$sql.=" and vd.visitor_approval='Y' ";
		} else if($_SESSION['visitor_approval']=='P')
		{
			$sql.=" and vd.visitor_approval='P' ";
		} else {
			$sql.=" and vd.visitor_approval='D' ";
		}
	}	*/

	$getTotalResult = $conn ->query($sql);
	$totalCount= $getTotalResult->num_rows;
	
	$attach=" group by rm.city order by rm.city asc"; 
	$sql.= "  ".$attach." "; 
	//echo $sql; 

	$result1=$conn ->query($sql);	
	$rCount= $result1->num_rows;
	
	$sql1= $sql." limit $start, $limit";
	$result=$conn ->query($sql1);

    if($rCount>0)
    {	
	$sub_total = 0;
	while($rows = $result->fetch_assoc())
	{	
$sub_total += $rows['cityCount'];  
    ?>  
	<tr>
	<td><?php echo strtoupper($rows['city']);?></td>
	<td><?php echo $rows['cityCount'];?></td>
	</tr>
 	<!--<tr>
	<td><?php echo filter($rows['company_pan_no']);?></td>
    <td><?php echo strtoupper($rows['company_name']);?></td>
	<td><?php echo filter($rows['email_id']);?></td>
    <td><?php echo $rows['name'].' '. $rows['lname'];?></td> 
    <td><?php echo filter($rows['pan_no']);?></td>
    <td><?php echo filter($rows['mobile']);?></td>
	</tr>-->
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
    <?php  }  ?>
</table>
</div>

<?php } ?> 
<?php //} ?> 
<?php /*
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
*/
?>  
<?php if(isset($_POST['Submit'])){ ?>     
<div class="pages_1">Total number of City <?php if($_SESSION["state"]!=""){ echo getStateName($_SESSION["state"],$conn); }?>: <?php echo $rCount; echo " Total Application : ".$sub_total;?> 
<?php //echo pagination($limit,$page,'manage_visitor_reports.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
<?php } ?>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>