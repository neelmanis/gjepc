<?php
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
?>
<?php 
$adminID = intval($_SESSION['curruser_login_id']);
if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$sql="delete from trade_exhibition_master where Exhibition_Id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("i", $_REQUEST['id']);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=trade_exhibition_master.php?action=view\">"; }
}

if(($_REQUEST['action']=='active') && ($_REQUEST['id']!=''))
{
	$status = filter($_REQUEST['status']);	
	$id     = filter($_REQUEST['id']);
	$mod_date = date("Y-m-d");
	$sql="update trade_exhibition_master set status=?,adminId=?,modified_date=? where Exhibition_Id=?";
	$stmt = $conn -> prepare($sql);
	$stmt->bind_param("sisi", $status,$adminID,$mod_date,$id);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=trade_exhibition_master.php?action=view\">"; }
}

if ($_REQUEST['action']=='save')
{
	//validate Token
	if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {
	$name = trim($_REQUEST['name']);
	$cat_id = filter($_REQUEST['cat_id']);	
	$org_add = trim($_REQUEST['org_add']);
	$to_date = trim($_REQUEST['to_date']);
	$from_date = trim($_REQUEST['from_date']);
	$venue = filter($_REQUEST['venue']);

	$sql="INSERT INTO `trade_exhibition_master`(`Exhibition_Name`, `Country`, `From_Date`, `To_Date`, `Organizer_Address`, `Venue_Address`, `status`,`post_date`,`adminId`) VALUES ('$name','$cat_id','$from_date','$to_date','$org_add','$venue','1',NOW(),'$adminID')";	
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){	echo"<meta http-equiv=refresh content=\"0;url=trade_exhibition_master.php?action=view\">"; } else {
	die ("Mysql Insert Error: " . $conn->error); }
	} else {
		echo "<script langauge=\"javascript\">alert(\"Sorry Invalid Token Error.\");location.href='trade_exhibition_master.php?action=view';</script>";
	}
}

if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{ 
	$name = trim($_REQUEST['name']);
	$cat_id = filter($_REQUEST['cat_id']);	
	$org_add = trim($_REQUEST['org_add']);
	$to_date = trim($_REQUEST['to_date']);
	$from_date = trim($_REQUEST['from_date']);
	$venue = filter($_REQUEST['venue']);
	$id = intval(filter($_REQUEST['id']));	

	$sql="UPDATE `trade_exhibition_master` SET `Exhibition_Name`='$name',`Country`='$cat_id',`From_Date`='$from_date',`To_Date`='$to_date',`Organizer_Address`='$org_add',`Venue_Address`='$venue',modified_date=NOW(),adminId='$adminID' WHERE Exhibition_Id='$id'";	
	$stmt = $conn -> prepare($sql);
	if($stmt->execute()){ echo"<meta http-equiv=refresh content=\"0;url=trade_exhibition_master.php?action=view\">"; } else {
	die ("Mysql Update Error: " . $conn->error); }
}
?>
<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['name']="";  
  header("Location: trade_exhibition_master.php");
}else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['name']=mysql_real_escape_string($_REQUEST['name']);
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
<a href="trade_exhibition_master.php?action=add"><div class="content_head_button">Add Trade Exhibition</div></a> 
<a href="trade_exhibition_master.php?action=view"><div class="content_head_button">View Trade Exhibition</div></a> </div>

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
<td width="81%"><input type="text" name="exhname" id="" class="input_txt" value="<?php echo $_SESSION['name'];?>" /></td>
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
       	<td>Exhibition Name</td>		
		<td>From</td>
		<td>To</td>
		<td>Organizer Address</td>
		<td>Venue</td>
		<td>Status</td>
        <td colspan="3" align="center">Action</td>
    </tr>
    
    <?php 
	$page=1;//Default page
	$limit=50;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];
	
	}
	$start=($page-1)*$limit;
	
    $order_by = isset($_REQUEST['order_by'])?$_REQUEST['order_by']:'Exhibition_Id';
    $asc_desc = isset($_REQUEST['asc_desc'])?$_REQUEST['asc_desc']:'desc';
    $attach = " order by ".$order_by." ".$asc_desc." ";
    
    $i=1;
	
	$sql="SELECT * FROM trade_exhibition_master where 1";
	
	if($_SESSION['name']!="")
	{
	$sql.=" and Exhibition_Name like '%".$_SESSION['name']."%'";
	}
	$sql.= "  ".$attach." ";
	
	$query = $conn -> prepare($sql);
	$query->execute();			
	$result = $query->get_result();	
    $rCount=0;
	$rCount=$result->num_rows;	
    if($rCount>0)
    {
	 while($row = $result->fetch_assoc())
	{	
    ?>  
 	<tr <?php if($i%2==0){echo "bgcolor='#CCCCCC'";}?>>
        <td><?php echo $i;?></td>
	    <td><?php echo filter($row['Exhibition_Name']); ?></td>        
		<td><?php echo $row['From_Date']; ?></td>
		<td><?php echo $row['To_Date']; ?></td>
		<td><?php echo filter($row['Organizer_Address']); ?></td>
		<td><?php echo filter($row['Venue_Address']); ?></td>        
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
        <td><?php if($row['status'] == 1) { ?> <a style="text-decoration:none;" href="trade_exhibition_master.php?id=<?php echo $row['Exhibition_Id']; ?>&status=0&action=active" onClick="return(window.confirm('Are you sure you want to Deactivate.'));"><img src="images/inactive.png" border="0" title="Inactive"/></a><?php } else { ?><a style="text-decoration:none;" href="trade_exhibition_master.php?id=<?php echo $row['Exhibition_Id']; ?>&status=1&action=active" onClick="return(window.confirm('Are you sure you want to Activate.'));"><img src="images/active.png" border="0" title="Active"/></a><?php } ?></td>
        
        <td ><a href="trade_exhibition_master.php?action=edit&id=<?php echo $row['Exhibition_Id']?>"><img src="images/edit.png" title="Edit" border="0" /></a></td>
        <td ><a href="trade_exhibition_master.php?action=del&id=<?php echo $row['Exhibition_Id']?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></td>
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
 <?php echo pagination($limit,$page,'trade_exhibition_master.php?action=view&page=',$rCount); //call function to show pagination?>

</div>

<?php 
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
  $action='save';
  if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
  {
		$action='update';
		$sql3 = "SELECT * FROM trade_exhibition_master where Exhibition_Id=?";
		$query = $conn -> prepare($sql3);
		$query -> bind_param("i", $_REQUEST['id']);
		$query->execute();			
		$result2 = $query->get_result();
		if($row2 = $result2->fetch_assoc())
		{
			$Exhibition_Id=stripslashes($row2['Exhibition_Id']);
			$name=stripslashes($row2['Exhibition_Name']);
			$country=stripslashes($row2['Country']);
			$from_date=stripslashes($row2['From_Date']);
			$to_date=stripslashes($row2['To_Date']);
			$org_add=stripslashes($row2['Organizer_Address']);
			$venue=stripslashes($row2['Venue_Address']);
		}
  }
?>
 
<div class="content_details1 ">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" name="form1" id="form1" onsubmit="return checkdata()" enctype="multipart/form-data">
<?php token(); ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  	<tr class="orange1">
    <td colspan="2"> &nbsp;Add New Trade Exhibition</td>
    </tr>
	<tr>
      <td class="content_txt"> Exhibition Name <span class="star">*</span></td>
      <td><input type="text" name="name" id="exhname" class="input_txt" value="<?php echo $name; ?>" /></td>
    </tr>
  	<tr>
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
	  </tr>    
     <tr>
      <td>From Date <span class="star">*</span></td>
      <td><input type="text" name="from_date" id="from_date" class="input_txt" value="<?php echo $from_date;?>" autocomplete="off"/></td>
    </tr>
	<tr>
      <td>To Date <span class="star">*</span></td>
      <td><input type="text" name="to_date" id="to_date" class="input_txt" value="<?php echo $to_date;?>" autocomplete="off"/></td>
    </tr>
	<tr>
      <td class="content_txt">Organizer Address <span class="star">*</span></td>
      <td><input type="text" name="org_add" id="org_add" class="input_txt" value="<?php echo $org_add; ?>" /></td>
    </tr>
	<tr>
      <td class="content_txt">Venue Address <span class="star">*</span></td>
      <td><input type="text" name="venue" id="venue" class="input_txt" value="<?php echo $venue; ?>" /></td>
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
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>