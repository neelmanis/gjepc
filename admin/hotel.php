<?php 
session_start(); 
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>

<?php
if($_REQUEST['action']=='save')
{

if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$Company_Pan = strtoupper(filter($_REQUEST['Company_Pan']));
	$Company_Name = filter($_REQUEST['Company_Name']);
	$Company_Type = filter($_REQUEST['Company_Type']);
	$Quota_Count = filter($_REQUEST['Quota_Count']);
	$Status = $_REQUEST['Status'];

	$sqlx = "INSERT INTO `vis_hotel_registration_company_master` (`Company_Pan`, `Company_Name`, `Company_Type`, `Quota_Count`, `Status`) VALUES ('$Company_Pan', '$Company_Name', '$Company_Type', '$Quota_Count', '$Status')";
	$result = $conn ->query($sqlx);	
	if($result){
	echo "<script langauge=\"javascript\">alert(\"Successfully Added Data\");location.href='hotel.php?action=view';</script>";	exit;
	}			
				
	} else {
		echo "<script langauge=\"javascript\">alert(\"Invalid Token Error.\");</script>";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
		
	$Company_Pan = strtoupper(filter($_REQUEST['Company_Pan']));
	$Company_Name = filter($_REQUEST['Company_Name']);
	$Company_Type = filter($_REQUEST['Company_Type']);
	$Quota_Count = filter($_REQUEST['Quota_Count']);
	$Status = $_REQUEST['Status'];

	$sqlx = "UPDATE `vis_hotel_registration_company_master` SET `Company_Name` = '$Company_Pan',Company_Name='$Company_Name',Company_Type='$Company_Type',Quota_Count='$Quota_Count',Status='$Status' WHERE `id` = ".$_REQUEST['id']."";
	$result = $conn ->query($sqlx);	
	if($result){
	echo "<script langauge=\"javascript\">alert(\"Successfully Update Data\");location.href='hotel.php?action=view';</script>";	exit;
	}			
				
	} else {
		echo "<script langauge=\"javascript\">alert(\"Invalid Token Error.\");</script>";
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

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="hotel.php?action=view">Home</a> > Hotel Registration</div>
</div>

<div id="main">
	<div class="content">    
    	<!--<div class="content_head">Hotel Registration<div style="float:right; padding-right:10px; font-size:12px;"><a href="export_hotel_exh.php">Download Excel Manual</a></div><div style="float:right; padding-right:10px; font-size:12px;"><a href="export_hotel_web.php">&nbsp;Download Excel Website</a></div></div>--> 
		<div class="content_head">Hotel Registration<div style="float:right; padding-right:10px; font-size:12px;"><a href="hotel.php?action=view">Home</a></div>
		<div class="content_head"><div style="float:right; padding-right:10px; font-size:12px;"><a href="hotel.php?action=add">Add NEW Company </a></div>
		</div>
      <div class="clear"></div>
	  
<?php if($_REQUEST['action']=='view') {?>  
<div class="content_details1">
<form name="form1" action="" method="POST"/> 
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td width="18%">Company PAN</td>
    <td width="18%">Company NAME</td>
    <td width="13%">TYPE</td>
    <td width="16%">Quota</td>
    <td width="14%">Status</td>
	 <td colspan="4" align="center">Action</td>
  </tr>
	<?php  
	$page=1;//Default page
	$limit=50;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
  
	$sql="SELECT * FROM `vis_hotel_registration_company_master` order by id desc";
	$result=$conn ->query($sql);
	$rCount=$result->num_rows;
	$sql1= $sql."  limit $start, $limit";
	$result1=$conn ->query($sql1);
	
  if($rCount>0)
  {	
   while($rows=$result1->fetch_assoc())
  {
  ?>
  <tr>
    <td><?php echo filter($rows['Company_Pan']);?></td>
    <td><?php echo filter($rows['Company_Name']);?></td>
    <td><?php echo filter($rows['Company_Type']);?></td>
    <td><?php echo filter($rows['Quota_Count']);?></td>
    <td>
		<?php if($rows['Status'] == '1') { 
        echo "<span style='color:green'>Active</span>";
        }else if($rows['status'] == '0') 
        {
        echo "<span style='color:red'>Deactive</span>";
        } 
        ?>
        </td>
	<td><a href="hotel.php?action=edit&id=<?php echo $rows['id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
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
  <?php  }  ?>
</table>
</form>
</div>  
<?php } ?>    

<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$sql3 = "SELECT * FROM vis_hotel_registration_company_master where id=".$_REQUEST['id']."";
		$result=$conn ->query($sql3);

		if($row2 = $result->fetch_assoc())
		{
			$Company_Pan=stripslashes($row2['Company_Pan']);
			$Company_Name=stripslashes($row2['Company_Name']);
			$Company_Type=stripslashes($row2['Company_Type']);
			$Quota_Count=stripslashes($row2['Quota_Count']);
			$Status=stripslashes($row2['Status']);
		}

  }
?>
 
<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add/Edit Hotel</td>
    </tr>
	<tr>
      <td class="content_txt">Company Name <span class="star">*</span></td>
      <td><input type="text" name="Company_Name" id="Company_Name" class="input_txt" value="<?php echo $Company_Name; ?>" autocomplete="off" /></td>
    </tr>
	<tr>
      <td class="content_txt">Company Pan <span class="star">*</span></td>
      <td><input type="text" name="Company_Pan" id="Company_Pan" class="input_txt" value="<?php echo $Company_Pan; ?>" autocomplete="off" /></td>
    </tr>

    <tr>
      <td class="content_txt">Company Type <span class="star">*</span></td>
      <td>
      	<select name="Company_Type" id="Company_Type" class="input_txt">
      		<option value="">Select Type</option>
      		<option <?php if($Company_Type =="VIP"){echo "selected";}?> value="VIP">VIP</option>
      		<option <?php if($Company_Type =="VVIP"){echo "selected";}?> value="VVIP">VVIP</option>
      		<option <?php if($Company_Type =="ELITPaid"){echo "selected";}?> value="ELITPaid">ELITPaid</option>
      		<option <?php if($Company_Type =="EliteUnpaid"){echo "selected";}?> value="EliteUnpaid">EliteUnpaid</option>
      		<option <?php if($Company_Type =="Unique"){echo "selected";}?> value="Unique">Unique</option>
      		<option <?php if($Company_Type =="Unique2Night"){echo "selected";}?> value="Unique2Night">Unique2Night</option>
      	</select>
    </tr>

    <tr>
      <td class="content_txt">Quota <span class="star">*</span></td>
      <td><input type="text" name="Quota_Count" id="Quota_Count" class="input_txt" value="<?php echo $Quota_Count; ?>" autocomplete="off" /></td>
    </tr>
   
	<tr>
    <td class="content_txt">Status <span class="star">*</span></td>
    <td>
    <select name="Status" id="Status" class="input_txt">
    <option value="">Select Status</option>
    <option value="1" <?php if($Status=="1"){echo "selected='selected'";} ?>>Active</option>
    <option value="0" <?php if($Status=="0"){echo "selected='selected'";} ?>>Inactive</option>
    </select></td>
    </tr>
    
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />    </td>
    </tr>
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
<div class="pages_1">Total number of Hotel: <?php echo $rCount;?>
<?php echo pagination($limit,$page,'hotel.php?action=view&page=',$rCount); //call function to show pagination?>
</div>        
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>