<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
?>
<?php 
$adminID = intval($_SESSION['curruser_login_id']);
/*
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from event_floorplan where Exhibition_Id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("i", $_REQUEST['id']);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=floor_plan_master.php?action=view\">"; }
} */

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter($_REQUEST['id']);
	$mod_date = date("Y-m-d");
	$sql = "update event_floorplan set status=? where BoothID=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("si", $status,$id);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=floor_plan_master.php?action=view\">"; }
}

if ($_REQUEST['action']=='save')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$ExhId = trim($_REQUEST['ExhId']);
	$BoothNo = filter($_REQUEST['BoothNo']);	
	$Hall = trim($_REQUEST['hall']);
	$CategoryId = trim($_REQUEST['CategoryId']);
	$BTypeId = trim($_REQUEST['BTypeId']);
	$ExhibitorName = filter($_REQUEST['ExhibitorName']);

	$sql="INSERT INTO `event_floorplan`(`ExhId`, `BoothNo`, `Hall`, `CategoryId`, `BTypeId`, `ExhibitorName`, `status`) VALUES ('$ExhId','$BoothNo','$Hall','$CategoryId','$BTypeId','$ExhibitorName','1')";	
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=floor_plan_master.php?action=view\">"; } else {
	die ("Mysql Insert Error: " . $conn->error); }
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='floor_plan_master.php?action=view';</script>";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{ 
	$ExhId = trim($_REQUEST['ExhId']);
	$BoothNo = filter($_REQUEST['BoothNo']);	
	$Hall = trim($_REQUEST['Hall']);
	$CategoryId = trim($_REQUEST['CategoryId']);
	$BTypeId = trim($_REQUEST['BTypeId']);
	$ExhibitorName = filter($_REQUEST['ExhibitorName']);
	$status = filter($_REQUEST['status']);
	$id = intval(filter($_REQUEST['id']));	

	$sql="UPDATE `event_floorplan` SET `ExhId`='$ExhId',`BoothNo`='$BoothNo',`Hall`='$Hall',`CategoryId`='$CategoryId',`BTypeId`='$BTypeId',`ExhibitorName`='$ExhibitorName',status='1' WHERE BoothID='$id'";	
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){ echo"<meta http-equiv=refresh content=\"0;url=floor_plan_master.php?action=view\">"; } else {
	die ("Mysql Update Error: " . $conn->error); }
}
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['ExhibitorName']="";  
  $_SESSION['BoothNo']="";
  $_SESSION['Hall']="";
  header("Location: floor_plan_master.php?action=view");
}else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['ExhibitorName'] = filter($_REQUEST['ExhibitorName']);
	$_SESSION['BoothNo'] = $_REQUEST['BoothNo'];
	$_SESSION['Hall'] = $_REQUEST['Hall'];
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Trade Exhibition Master</title>

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
<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css" />

<!--navigation end-->
<link href="../css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#post_date').datepick({dateFormat: "dd-mm-yyyy"});
	$('#to_date').datepick({dateFormat: "dd-mm-yyyy"});
	$('#from_date').datepick({dateFormat: "dd-mm-yyyy"});

});
</script>

<script language="javascript">
function checkdata()
{
	if(document.getElementById('exhname').value == '')
	{
		alert("Please Enter Exhibition Name.");
		document.getElementById('exhname').focus();
		return false;
	}
	if(document.getElementById('cat_id').value == '')
	{
		alert("Please Select Country Code");
		document.getElementById('cat_id').focus();
		return false;
	}	
	
			var to_date =  $("#to_date").val();
			var from_date =  $("#from_date").val();
			//alert(from_date);
			//alert(to_date);
			
			from_date = from_date.split('-');
			to_date = to_date.split('-');
				
			from_date = new Date(from_date[2], from_date[1], from_date[0]);
			to_date = new Date(to_date[2], to_date[1], to_date[0]);
			date1_unixtime = parseInt(from_date.getTime() / 1000);
			date2_unixtime = parseInt(to_date.getTime() / 1000);
			
			var timeDifference = date2_unixtime - date1_unixtime;
			var timeDifferenceInHours = timeDifference / 60 / 60;
			var timeDifferenceInDays = timeDifferenceInHours  / 24;
			//alert(timeDifferenceInDays);
			//if(timeDifferenceInDays>45) 27-NOV-2017
			if(timeDifferenceInDays>47)
			{
				alert("The from date and to date should not exceed 45 days...");
				$("#from_date").focus();
				return false;
			}
}
</script>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper">
<div class="nav"><?php include("include/menu.php");?></div>
</div>
<div class="clear"></div>
<div class="breadcome_wrap">
<div class="breadcome"><a href="admin.php">Home</a> > Manage trade_exhibition_master</div>
</div>

<div id="main">
<div class="content">
<div class="content_head">
<a href="floor_plan_master.php?action=add"><div class="content_head_button">Add </div></a> 
<a href="floor_plan_master.php?action=view"><div class="content_head_button">View </div></a> </div>

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
<td width="19%" ><strong>Exhibition Name</strong></td>
<td width="81%"><input type="text" name="ExhibitorName" id="" class="input_txt" value="<?php echo $_SESSION['ExhibitorName'];?>" /></td>
</tr>
<tr>
<td width="19%" ><strong>Booth No</strong></td>
<td width="81%"><input type="text" name="BoothNo" id="" class="input_txt" value="<?php echo $_SESSION['BoothNo'];?>" /></td>
</tr>
<tr>
    <td width="19%" ><strong>Hall </strong></td>
  	<td width="81%">
      <select name="Hall" id="Hall" class="input_txt">		
		<option value="" >Select Hall</option>
		<option value="1" <?php if($_SESSION['Hall']=="1") echo 'selected="selected"'; ?>>1</option>
		<option value="2" <?php if($_SESSION['Hall']=="2") echo 'selected="selected"'; ?>>2</option>
		<option value="6" <?php if($_SESSION['Hall']=="6") echo 'selected="selected"'; ?>>6</option>
		<option value="7" <?php if($_SESSION['Hall']=="7") echo 'selected="selected"'; ?>>7</option>
      </select>
	  </td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Search"  class="input_submit" /> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>    
  
</div>

<?php if($_REQUEST['action']=='view') { ?>    	
<div class="content_details1">
        	
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  	<tr class="orange1">
        <td><a href="#">Sr. No.</a></td>
       	<td>Exhibitor ID</td>		
       	<td>Exhibitor Name</td>		
		<td>Booth No</td>
		<td>Hall</td>
		<td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
	$page=1;//Default page
	$limit=10;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'BoothNo';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
	$sql="SELECT * FROM event_floorplan where 1";
	
	if($_SESSION['ExhibitorName']!="")
	{
	$sql.=" and ExhibitorName like '%".$_SESSION['ExhibitorName']."%'";
	}
	if($_SESSION['BoothNo']!="")
	{
	$sql.=" and BoothNo like '%".$_SESSION['BoothNo']."%'";
	}
	
	if($_SESSION['Hall']!="")
	{
	$sql.=" and Hall like '%".$_SESSION['Hall']."%'";
	}
	
	$sql.= "  ".$attach." ";
//	echo $sql;	
	$result1 = $conn ->query($sql);
	$rCount  = $result1->num_rows;
	
	$sql1= $sql." limit $start, $limit ";
	$result = $conn ->query($sql1);
	
    if($rCount>0)
    {
	 while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
	    <td><?php echo filter($row['ExhId']); ?></td>        
	    <td><?php echo filter($row['ExhibitorName']); ?></td>        
		<td><?php echo $row['BoothNo']; ?></td>
		<td><?php echo $row['Hall']; ?></td>  
        <td>
		<?php if($row['status'] == '1') 
        { 
        echo "<span style='color:green'>Active</span>";
        }else if($row['status'] == '0') 
        {
        echo "<span style='color:red'>Deactive</span>";
        } 
        ?>
        </td>
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="floor_plan_master.php?id=<?php echo $row['BoothID']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } else { ?><a style="text-decoration:none;" href="floor_plan_master.php?id=<?php echo $row['BoothID']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/inactive.png" border="0" title="InActive"/></a><?php } ?></td>
        
        <td><a href="floor_plan_master.php?action=edit&id=<?php echo $row['BoothID']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="floor_plan_master.php?action=del&id=<?php echo $row['BoothID']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
  
<div class="pages_1">Total number: <?php echo $rCount;?> 
<?php echo pagination($limit,$page,'floor_plan_master.php?action=view&page=',$rCount); //call function to show pagination?>
</div>

<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$sql3 = "SELECT * FROM event_floorplan where BoothID=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", $_REQUEST['id']);
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$BoothID=stripslashes($row2['BoothID']);
			$ExhId=stripslashes($row2['ExhId']);
			$ExhibitorName=stripslashes($row2['ExhibitorName']);
			$BoothNo=stripslashes($row2['BoothNo']);
			$Hall=stripslashes($row2['Hall']);
			$CategoryId=stripslashes($row2['CategoryId']);
			$BTypeId=stripslashes($row2['BTypeId']);
			$status=stripslashes($row2['status']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New </td>
    </tr>
	<tr>
      <td class="content_txt"> Exhibitor Name <span class="star">*</span></td>
      <td><input type="text" name="ExhibitorName" id="ExhibitorName" class="input_txt" value="<?php echo $ExhibitorName; ?>" /></td>
    </tr>
	<tr>
      <td class="content_txt"> Booth No <span class="star">*</span></td>
      <td><input type="text" name="BoothNo" id="BoothNo" class="input_txt" value="<?php echo $BoothNo; ?>"/></td>
    </tr>
	<tr>
      <td class="content_txt">Hall <span class="star">*</span></td>
  	  <td>
      <select name="Hall" id="Hall" class="input_txt">		
		<option value="0" >Select Hall</option>
		<option value="1" <?php if($Hall=="1") echo 'selected="selected"'; ?>>1</option>
		<option value="2" <?php if($Hall=="2") echo 'selected="selected"'; ?>>2</option>
		<option value="6" <?php if($Hall=="6") echo 'selected="selected"'; ?>>6</option>
		<option value="7" <?php if($Hall=="7") echo 'selected="selected"'; ?>>7</option>
      </select>
	  </td>
	</tr>
	<tr>
      <td class="content_txt"> Exhibitor ID </td>
      <td><input type="text" name="ExhId" id="ExhId" class="input_txt" value="<?php echo $ExhId; ?>" /></td>
    </tr>	
	<tr>
      <td class="content_txt"> Category </td>
      <td><input type="text" name="CategoryId" id="CategoryId" class="input_txt" value="<?php echo $CategoryId; ?>" /></td>
    </tr>
	<tr>
      <td class="content_txt"> BTypeId </td>
      <td><input type="text" name="BTypeId" id="BTypeId" class="input_txt" value="<?php echo $BTypeId; ?>" /></td>
    </tr>
	<tr>
    <td><strong>Booster Dose Certificate</strong></td>
    <td>  
        <select name="status" class="input_txt" id="status" >   
          <option value="">Select Booster Dose Status</option>
          <option value="1" <?php if($status=='1'){echo "selected='selected'";}?>>Active</option>
          <option value="0" <?php if($status=='0'){echo "selected='selected'";}?>>DeActive</option>  
        </select>
    </td>
	</tr>
  	<!--<tr>
      <td class="content_txt">Select Country</td>
  	  <td>
      <select name="cat_id" id="cat_id" class="input_txt">		
		<option value="1" ><?php echo $country;?></option>
		<?php
        $sql="SELECT `id`, `country_code`, `country_name` FROM `country_master` WHERE 1";
        $query = $conn -> prepare($sql);
		$query->execute();			
		$result2 = $query->get_result();
		while($rows = $result2->fetch_assoc())
        {       
        echo "<option value='$rows[country_code]'>$rows[country_name]</option>";
        }               
        ?>
      </select></td>
	</tr>-->    
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
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>