<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
?>
<?php 
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['s_gcode']="";
  $_SESSION['from_date']="";
  $_SESSION['to_date']="";
  header("Location: manage_update_panel.php?action=view"); 
} else {
  	$search_type=$_REQUEST['search_type'];
  	if($search_type=="SEARCH")
	{ 
	$_SESSION['s_gcode']=$_REQUEST['s_gcode'];
	if($_REQUEST['from_date']!='' && $_REQUEST['to_date']!='')
	{
	$_SESSION['from_date']=date('Y-m-d',strtotime($_REQUEST['from_date']));
	$_SESSION['to_date']=date('Y-m-d',strtotime($_REQUEST['to_date']));
	}
	 $_SESSION['status']=$_REQUEST['status'];
	}
if($search_type=='SEARCH')
{
	if($_SESSION['s_gcode']=="" && $_SESSION['from_date']=="" && $_SESSION['to_date']=="")
	{
	$_SESSION['error_msg']="Please select atleast one field to search";
	}
	else if($_SESSION['from_date']=="Form" && $_SESSION['to_date'] !="To")
{
$_SESSION['error_msg']="Please enter form date";
}else if($_SESSION['from_date']!="Form" && $_SESSION['to_date']=="To")
{
$_SESSION['error_msg']="Please enter to date";
}
}
}

if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from registration_master where id=?";	
	$stmtd = $conn -> prepare($sql);
	$stmtd->bind_param("i", intval($_REQUEST['id']));
	if($stmtd->execute()){	echo"<meta http-equiv=refresh content=\"0;url=manage_update_panel.php?action=view\">"; }
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{
	$membership_number  = filter($_REQUEST['gcode']);
	$type_of_membership = filter($_REQUEST['type_membership']);
	$current_panel	=	$_REQUEST['current_panel'];
	$new_panel	=	$_REQUEST['new_panel'];
	$status	=	filter($_REQUEST['status']);
	if($status==''){ $status='P'; }
	$id=$_REQUEST['id'];	
	$mod_date = date('Y-m-d');
	
	$sql = "update update_panel set membership_number=?,application_status=?,type_of_membership=?,current_panel=?,new_panel=?,modified_date=? where id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("ssssssi", $membership_number,$status,$type_of_membership,$current_panel,$new_panel,$mod_date,$id);
	if($stmt->execute()){	header('location:manage_update_panel.php?action=view');	exit;	} else { die ("Mysql Update Error: " . $conn->error); }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Update Panel ||GJEPC||</title>
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
<!--navigation end-->
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Update Panel</div>
</div>

<div id="main">
	<div class="content">
<?php if($_REQUEST['action']=='view') { ?>   
<div class="content_details1">

<form name="search" action="" method="POST" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />        	
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
<tr>
    <td><strong>Enter GCODE</strong></td>
    <td><input type="text" name="s_gcode" id="s_gcode" class="input_txt" value="<?php echo $_SESSION['s_gcode'];?>" /></td></td>
</tr>	
<tr>
    <td><strong>Date</strong></td>
    <td><input type="text" name="from_date" id="popupDatepicker" class="input_date" placeholder="From" autocomplete="off"/>
     <input type="text" name="to_date" id="popupDatepicker1" class="input_date" placeholder="To" autocomplete="off"/></td>
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
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td width="5%"><a href="#">Sr. No.</a></td>
        <td width="5%">MEMBERSHIP NO(GCode)</td>
        <td width="25%">TYPE OF MEMBERSHIP</td>
        <td width="20%">CURRENT PANEL</td>
        <td width="15%">NEW PANEL</td>
		<td width="15%">STATUS</td>
        <td width="10%">Date</td>
        <td colspan="4" width="10%">Action</td>
    </tr>
    
    <?php	
 	$page=1;//Default page
	$limit=50;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'registration_master.post_date';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
	$sql="SELECT * FROM update_panel where ";
	$sql.="region_id='".$_SESSION['curruser_region_id']."'";
	
	 if($_SESSION['s_gcode']!="" )
	{
		$sql.=" and membership_number='".$_SESSION['s_gcode']."'";
	}
    
	if($_SESSION['from_date']!=""  && $_SESSION['to_date']!="" && $_SESSION['from_date']!="Form" && $_SESSION['to_date']!="To" && $_SESSION['from_date']!="1970-01-01" && $_SESSION['to_date']!="1970-01-01")
    {
     $sql.=" and modified_date between '".$_SESSION['from_date']."' and '".$_SESSION['to_date']."'";
    }
	
	$result1 = $conn ->query($sql);
	$rCount =  $result1->num_rows;
	
	$sql1= $sql." order by application_status  REGEXP '^[P]' desc limit $start, $limit ";
	$result=$conn ->query($sql1);	
    if($rCount>0)
    {	
	while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){ echo "bgcolor='#CCCCCC'";} ?>>
        <td><?php echo $i;?></td>
        <td><?php echo filter($row['membership_number']); ?></td>
        <td><?php echo filter(strtoupper($row['type_of_membership'])); ?></td>
        <td><?php echo filter(strtoupper($row['current_panel']))?></td>
       
       	<td align="left"><?php if($row['new_panel']=='Silver') { echo 'SILVER JEWELLERY'; } else { echo strtoupper($row['new_panel']); } ?></td>
		<td align="left">
		<?php  if($row['application_status']=='P'){ echo 'PENDING';  } 
		else { if($row['application_status']=='Y'){ echo 'APPROVED'; }
		else {	echo 'DISAPPROVED';}
		}?>
		</td>
  		<td align="left"><?php echo date("d-m-Y",strtotime($row['modified_date'])); ?></td>
        <td align="left"><a href="manage_update_panel.php?action=edit&id=<?php echo $row['id']?>"><img src="images/edit.gif" title="Edit" border="0" /></a></td>
 	</tr>

	<?php
	$i++;
	   }
	 }
	 else
	 {
	 ?>
    <tr><td colspan="10">Records Not Found</td></tr>
    <?php  }  	?>
</table>
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
 <div class="pages_1">Total number of panels: <?php echo $rCount;?> 
 <?php echo pagination($limit,$page,'manage_update_panel.php?action=view&page=',$rCount); //call function to show pagination?>

</div>
 <?php } ?> 
<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$sql3 = "SELECT * FROM update_panel where id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", intval($_REQUEST['id']));
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$membership_number=filter($row2['membership_number']);
			$type_of_membership=filter($row2['type_of_membership']);
			$current_panel=filter($row2['current_panel']);
			$new_panel=filter($row2['new_panel']);
			$modified_date=filter($row2['modified_date']);
			$submited_date=$row2['submited_date'];
			$status = $row2['application_status'];
			$region_id=$row2['region_id'];
		}
  }
?>
	<div class="content_details1 ">
<form action="" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
    <tr>
    <td class="content_txt">MEMBERSHIP No(GCODE)</td>
    <td><input type="text" name="gcode" id="gcode" class="input_txt" value="<?php echo $membership_number; ?>" /></td>
    </tr>
    <tr>
      <td class="content_txt">TYPE OF MEMBERSHIP</td>
      <td>
	  <select name="type_membership" id="type_membership" class="form_text_text">
		<option value="">----- TYPE OF MEMBERSHIP -----</option>
		<option value="ZASSOC" <?php if($type_of_membership=='ZASSOC' || $type_of_membership=='Associate') { echo 'selected="selected"'; }?>>Associate</option>
		<option value="ZORDIN" <?php if($type_of_membership=='ZORDIN' || $type_of_membership=='Ordinary') { echo 'selected="selected"'; }?>>Ordinary</option>
	  </select>
	  </td>
    </tr>
    <tr>
    <td class="content_txt">CURRENT PANEL </td>
    <td><input type="text" name="current_panel" id="current_panel" class="input_txt" value="<?php echo $current_panel; ?>" /></td>
    </tr>  
	<tr>
    <td class="content_txt">NEW PANEL </td>
    <td>
	<select name="new_panel" id="new_panel" class="form_text_text">
    <option value="">----- Select -----</option>
    <option value="Coloured Gemstones" <?php if($new_panel=='Coloured Gemstones') { echo 'selected="selected"'; }?>>Coloured Gemstones</option>
    <option value="Pearls" <?php if($new_panel=='Pearls') { echo 'selected="selected"'; }?>>Pearls</option>
    <option value="Costume/Fashion Jewellery" <?php if($new_panel=='Costume/Fashion Jewellery') { echo 'selected="selected"'; }?>>Costume/Fashion Jewellery</option>
    <option value="Sales To Foreign Tourists" <?php if($new_panel=='Sales To Foreign Tourists') { echo 'selected="selected"'; }?>>Sales To Foreign Tourists</option>
    <option value="Diamonds" <?php if($new_panel=='Diamonds') { echo 'selected="selected"'; }?>>Diamonds</option>
    <option value="Synthetic Stones" <?php if($new_panel=='Synthetic Stones') { echo 'selected="selected"'; }?>>Synthetic Stones</option>
    <option value="Gold Jewellery" <?php if($new_panel=='Gold Jewellery') { echo 'selected="selected"'; }?>>Gold Jewellery</option>
    <option value="Not Indicated" <?php if($new_panel=='Not Indicated') { echo 'selected="selected"'; }?> >Not Indicated</option>
    <option value="Other Precious Metal Jewellery" <?php if($new_panel=='Other Precious Metal Jewellery') { echo 'selected="selected"'; }?>>Other Precious Metal Jewellery</option>
    <option value="Silver" <?php if($new_panel=='Silver') { echo 'selected="selected"'; }?>>Silver Jewellery</option>
    <option value="Lab Grown Diamond" <?php if($new_panel=='Lab Grown Diamond') { echo 'selected="selected"'; }?>>Lab Grown Diamond</option>
    </select>
	</td>
	</tr>
    <tr>
    <td class="content_txt">Status</td>
    <td>
        <input type='radio' name='status' id='status' value='Y' <?php if($status=='Y'){ echo "checked='checked'"; }?> />Approve
        <input type='radio' name='status' id='status' value='N' <?php if($status=='N'){ echo "checked='checked'"; }?>/>Disapprove
    </td>
	</tr>
    
    <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="region" id="region"  value="<?php echo $region_id;?>" />    </td>
	<input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />    </td>
    </tr>
</table>
</form>
</div>
<?php } ?>    
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>