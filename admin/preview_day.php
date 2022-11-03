<?php 
session_start(); 
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php');exit;}
include('../db.inc.php');
include('../functions.php');
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['name']="";
  $_SESSION['company']="";
  $_SESSION['gcode']="";
  $_SESSION['orderid']="";
  $_SESSION['ismember']="";
  
  header("Location: preview_day.php?action=view");
} else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['name']=mysql_real_escape_string($_REQUEST['name']);
	$_SESSION['company']=mysql_real_escape_string($_REQUEST['company']);
	$_SESSION['gcode']=mysql_real_escape_string($_REQUEST['gcode']);
	$_SESSION['orderid']=mysql_real_escape_string($_REQUEST['orderid']);
	$_SESSION['ismember']=mysql_real_escape_string($_REQUEST['ismember']);
	}
}
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Preview Day Application ||GJEPC||</title>

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

</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>


<div id="main">
	<div class="content">
    	<div class="content_head">Manage Participant &nbsp;&nbsp;
        <?php if($_REQUEST['action']=='view_details'){?>
        <div style="float:right; padding-right:10px; font-size:12px;"><a href="preview_day.php?action=view">Back to Participant</a></div>
        <?php }?>
        <a href="preview_day_export.php">Export Participant List</a>&nbsp;&nbsp;
        <a href="preview_day_showroom_export.php">Export Showrooms List</a>&nbsp;&nbsp;
        </div>
<div class="content_details1">
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
    <td width="81%"><input type="text" name="company" id="company" class="input_txt" value="<?php echo $_SESSION['company'];?>" autocomplete="off"/></td>
</tr>     
<tr>
  <td><strong>Name</strong></td>
  <td><input type="text" name="name" id="name" class="input_txt" value="<?php echo $_SESSION['name'];?>" autocomplete="off"/></td>
</tr>
<!--<tr>
  <td><strong>Order No</strong></td>
  <td><input type="text" name="orderid" id="orderid" class="input_txt" value="<?php echo $_SESSION['orderid'];?>" autocomplete="off"/></td>
</tr>-->
<tr>
  <td><strong>GCode</strong></td>
  <td><input type="text" name="gcode" id="gcode" class="input_txt" value="<?php echo $_SESSION['gcode'];?>" autocomplete="off"/></td>
</tr>
<tr>
  <td><strong>IsMember</strong></td>  
  <td width="81%">
        <select name="ismember" id="ismember" class="input_txt">
        <option value="">Please Select</option>	
        <option value="M" <?php if($_SESSION['isMember']=="M"){echo "selected='selected'";}?>>Member</option>
        <option value="NM" <?php if($_SESSION['isMember']=="NM"){echo "selected='selected'";}?>>NonMember</option>
        <option value="IN" <?php if($_SESSION['isMember']=="IN"){echo "selected='selected'";}?>>International</option>	
        </select>  
    </td>
</tr>
    <td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Search" class="input_submit"/> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<?php if($_REQUEST['action']=='view') {?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td width="5%"><a href="#">No.</a></td>
		<td width="10%">Date</td>
		<td width="15%">Retailer Name</td>
        <td width="15%">Retailer Address</td>
		<td width="5%">Owner Name</td>
        <td width="5%">Owner Mobile</td>
        <td width="10%">Owner Email</td>
        <td width="10%">Action</td>		
    </tr>
    
    <?php 	
 	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'post_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
    $sql="SELECT * FROM `invitation_preview_day` WHERE 1";
	
	if($_SESSION['name']!="")
	{
	$sql.=" and name_of_owner like '%".$_SESSION['name']."%'";
	}
	
	if($_SESSION['company']!="")
	{
	$sql.=" and name_of_retail_showroom like '%".$_SESSION['company']."%'";
	}
	
	if($_SESSION['gcode']!="")
	{
	$sql.=" and gcode ='".$_SESSION['gcode']."'";
	}
	if($_SESSION['ismember']!="")
	{
	$sql.=" and ismember ='".$_SESSION['ismember']."'";
	}
	
	echo $sql.= "  ".$attach." ";
	$result1=mysql_query($sql);
	$rCount=mysql_num_rows($result1);	
	$sql1= $sql." limit $start, $limit";
	$result=mysql_query($sql1);

    if($rCount>0)
    {	
	while($row = mysql_fetch_array($result))
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
		<td align="left"><?php echo date("d-m-Y",strtotime($row['post_date'])); ?></td>	
        <td><?php echo $row['name_of_retail_showroom']; ?></td>
        <td><?php echo $row['owner_showroom_address']; ?></td>
        <td><?php echo $row['name_of_owner']; ?></td>
        <td><?php echo $row['owner_mobile_no'];?></td>
        <td><?php echo $row['owner_email_id'];?></td>
        <td><a href="preview_day.php?action=edit&invitation_id=<?php echo $row['invitation_id']?>"><img src="images/edit.gif" title="Edit" border="0" /></a></td>
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
<?php echo pagination($limit,$page,'preview_day.php?action=view&page=',$rCount); //call function to show pagination?>
</div>
 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$result2 = mysql_query("SELECT * FROM  invitation_preview_day where invitation_id='$_REQUEST[invitation_id]'");
		if($row2 = mysql_fetch_array($result2))
		{	
			$name_of_retail_showroom=stripslashes($row2['name_of_retail_showroom']);
			$name_of_owner=stripslashes($row2['name_of_owner']);
			$owner_showroom_address=stripslashes($row2['owner_showroom_address']);
			$owner_mobile_no=stripslashes($row2['owner_mobile_no']);
			$owner_email_id=htmlentities(strip_tags($row2['owner_email_id']));
			$secretariat_name=htmlentities(strip_tags($row2['secretariat_name']));
			$secretariat_designation=htmlentities(strip_tags($row2['secretariat_designation']));
			$secretariat_mobile_no=htmlentities(strip_tags($row2['	secretariat_mobile_no']));
			$secretariat_email_id=stripslashes($row2['secretariat_email_id']);
			$company_gst=stripslashes($row2['company_gst']);
			$company_pan=htmlentities(strip_tags($row2['company_pan']));			
			$store_frontage_picture=htmlentities(strip_tags($row2['store_frontage_picture']));			
			$promotional_add=htmlentities(strip_tags($row2['promotional_add']));
		}
  }
?>
 
<div class="content_details1">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()">
<table width="100%" border="0" cellspacing="0" cellpadding="0"/>
  	<tr class="orange1">
    <td colspan="2"></td>
    </tr>
	 <tr>
       <td class="content_txt" width="15%">Name of Retail Showroom </td>
       <td><?php echo $name_of_retail_showroom; ?></td>
     </tr>     
     <tr>
       <td class="content_txt">Name of Owner/ Partner / Director</td>
       <td><?php echo $name_of_owner; ?></td>
     </tr>     
      <tr>
       <td class="content_txt">Showroom Address</td>
       <td><?php echo $owner_showroom_address; ?></td>
     </tr>
	 <tr>
       <td class="content_txt">Mobile No of Owner/ Partner / Director </td>
       <td><?php echo $owner_mobile_no; ?></td>
     </tr>
     <tr>
       <td class="content_txt">Email Id</td>
       <td><?php echo $owner_email_id; ?></td>
     </tr>     
     <tr>
       <td class="content_txt">Name of Secretariat Person </td>
       <td><?php echo $secretariat_name; ?></td>
     </tr>
	 <tr>
       <td class="content_txt">Designation</td>
       <td><?php echo $secretariat_designation; ?></td>
     </tr>
	 <tr>
       <td class="content_txt">Mobile No</td>
       <td><?php echo $secretariat_mobile_no; ?></td>
     </tr>
     <tr>
       <td class="content_txt">Email ID </td>
       <td><?php echo $secretariat_email_id; ?></td>
     </tr>     
     <tr>
       <td class="content_txt">Company GST / Trade License  </td>
       <td><a href="https://iijs.org/preview_day/<?php echo $company_gst; ?>" target="_blank"><img src="https://iijs.org/preview_day/<?php echo $company_gst; ?>" width="50px" height="50px"/></a></td>
     </tr>
     <tr>
       <td class="content_txt">Company Pan Card  </td>
       <td><a href="https://iijs.org/preview_day/<?php echo $company_pan; ?>" target="_blank"><img src="https://iijs.org/preview_day/<?php echo $company_pan; ?>" width="50px" height="50px"/></a></td>
     </tr>
     <tr>
       <td class="content_txt">Picture of Store Frontage </td>
       <td><a href="https://iijs.org/preview_day/<?php echo $store_frontage_picture; ?>" target="_blank"><img src="https://iijs.org/preview_day/<?php echo $store_frontage_picture; ?>" width="50px" height="50px"/></a></td>
     </tr>
     <tr>
       <td class="content_txt">Picture of Any Types Of Promotional Activity  </td>
       <td><a href="https://iijs.org/preview_day/<?php echo $promotional_add; ?>" target="_blank"><img src="https://iijs.org/preview_day/<?php echo $promotional_add; ?>" width="50px" height="50px"/></a></td>
     </tr>
</table>
</form>
        </div>
        
<?php } ?>    
 
<?php 
if(($_REQUEST['id']!='') && ($_REQUEST['action']=='view_details'))
{

		$result2 = mysql_query("SELECT * FROM  invitation_preview_day where id='$_REQUEST[id]'");
		if($row2 = mysql_fetch_array($result2))
		{			
			$post_date=stripslashes($row2['post_date']);
			$gcode=stripslashes($row2['gcode']);
			$ismember=stripslashes($row2['ismember']);
			$title=stripslashes($row2['title']);
			$name=stripslashes($row2['name']);
			$designation=stripslashes($row2['designation']);
			$company=stripslashes($row2['company']);
			$address=stripslashes($row2['address']);
			$land_line_no=stripslashes($row2['land_line_no']);
			$mobile_no=stripslashes($row2['mobile_no']);
			$fax=stripslashes($row2['fax']);
			$gst_no=stripslashes($row2['gst_no']);
			$email=stripslashes($row2['email']);			
			$website=$row2['website'];
			$business_nature=$row2['business_nature'];
			$other_business=$row2['business_nature_other'];
			$photo=$row2['photo'];
			$fees=$row2['fees'];
			$payment_mode=$row2['payment_mode'];			
		}
?>
 <div class="content_details1">
   <table width="100%" border="0" cellspacing="5" cellpadding="5"  >
     <tr class="orange1">
       <td colspan="2">&nbsp;View Details <?php if($ismember=='M') { $isMember = 'Member';}elseif($ismember=='NM') { $isMember = 'NonMember';}else{ $isMember = 'international';}	echo strtoupper($isMember);?></td>
     </tr>
     <tr>
       <td class="content_txt" width="15%">Name </td>
       <td class="text6"><?php echo $title.' '. $name; ?></td>
     </tr>     
     <tr>
       <td class="content_txt">Designation</td>
       <td class="text6"><?php echo $designation; ?></td>
     </tr>     
      <tr>
       <td class="content_txt">Company Name </td>
       <td class="text6"><?php echo $company; ?></td>
     </tr>
	 <tr>
       <td class="content_txt">Office Address </td>
       <td class="text6"><?php echo $address;?></td>
     </tr>
     <tr>
       <td class="content_txt">Tel. No. </td>
       <td class="text6"><?php echo $land_line_no; ?></td>
     </tr>     
     <tr>
       <td class="content_txt">Mobile No </td>
       <td class="text6"><?php echo $mobile_no; ?></td>
     </tr>
	 <tr>
       <td class="content_txt">Fax No </td>
       <td class="text6"><?php echo $fax; ?></td>
     </tr>
	 
	 <tr>
       <td class="content_txt">GST No </td>
       <td class="text6"><?php echo $gst_no;?></td>
     </tr>
     <tr>
       <td class="content_txt">Email ID </td>
       <td class="text6"><?php echo $email;?></td>
     </tr>     
     <tr>
       <td class="content_txt">Website </td>
       <td class="text6"><?php echo $website;?></td>
     </tr>
     <tr>
    <td colspan="11">
    
<div class="field bottomSpace">
<div class="leftTitle" style="padding-top:0px;">Nature of Business :</div>
<div class="rightContent">
    <ul class="matterText">    
    <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Gold Jewellery Manufacturer" <?php if(preg_match('/Gold Jewellery Manufacturer/',$business_nature)){ echo 'checked="checked"'; }?>>Gold Jewellery Manufacturer</li>    
    <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Gold Jewellery Retailer" <?php if(preg_match('/Gold Jewellery Retailer/',$business_nature)){ echo 'checked="checked"'; }?>>Gold Jewellery Retailer</li>
     <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Machinery" <?php if(preg_match('/Machinery/',$business_nature)){ echo 'checked="checked"'; }?>>Machinery</li>    
     <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Software" <?php if(preg_match('/Software/',$business_nature)){ echo 'checked="checked"'; }?>>Software</li>    
    <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Publication" <?php if(preg_match('/Publication/',$business_nature)){ echo 'checked="checked"'; }?>>Publication</li>    
    <li><input type="checkbox" name="business_nature[]" id="business_nature" value="Service Provider" <?php if(preg_match('/Service Provider/',$business_nature)){ echo 'checked="checked"'; }?>>Service Provider</li>
	<li><input type="checkbox" name="business_nature[]" id="business_nature" value="Educational Institution Association" <?php if(preg_match('/Educational Institution Association/',$business_nature)){ echo 'checked="checked"'; }?>>Educational Institution Association</li>
	<li><input type="checkbox" name="business_nature[]" id="business_nature" value="Banks" <?php if(preg_match('/Banks/',$business_nature)){ echo 'checked="checked"'; }?>>Banks</li>
	<li><input type="checkbox" name="business_nature[]" value="Any Other" id="other_business_id" <?php if(preg_match('/Any Other/',$business_nature)){ echo 'checked="checked"'; } ?>>Any Other</li>
    </ul>    
</div>
<div class="clear" style="margin-bottom:8px;"></div>
 
<div id="wa-jewellery-other-id">
  <label style="min-width:179px;">Any Other, please specify :</label>
  <input name="other_business" type="text" class="textField" value="<?php echo $other_business; ?>" />
</div>
</div>
    
</td>
</tr>
	 <tr>
       <td class="content_txt">Photo </td>      
       <td><?php 
		 if($photo=="")
		 {
		    echo "<img src='images/user_pic.jpg' width='100' height='100' />";
		 }else
		 {
		 ?>
		 <div class="fancyDemo"> <a rel="group" href="../photo/<?php echo $photo;?>">
		 <img src='../photo/<?php echo $photo;?>' width='100' height='100' /></a></div>
		 <?php
         }
		 ?>
         </td>
	 </tr>
	  <tr>
       <td class="content_txt">Fee</td>
       <td class="text6"><?php echo $fees; ?></td>
     </tr>
	 <tr>
       <td class="content_txt">Payment Mode</td>
       <td class="text6"><?php echo $payment_mode; ?></td>
     </tr>
     <tr>
       <td class="content_txt">Post Date </td>
       <td class="text6"><?php echo date("d-m-Y",strtotime($post_date)); ?></td>
     </tr>
   </table>
 </div>
 <?php 
} 
?>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>