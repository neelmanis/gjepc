<?php
session_start(); ob_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$curruser_region_id=$_SESSION['curruser_region_id'];
?>

<?php
$action=$_POST['action'];
if($action=='regionwise')
{
	
	function reportLogs($category,$report_name,$conn)
	{
	$adminID = intval($_SESSION['curruser_login_id']);
	$adminName = strtoupper($_SESSION['curruser_contact_name']);
	$ip = get_client_ip();
	$query = "INSERT INTO report_logs SET post_date=NOW(),admin_id='$adminID',admin_name='$adminName',category='$category',report_name='$report_name',ip='$ip'";
	$result = $conn->query($query);
	if($result)
	{
		return "TRUE";
	} else {
		return "FALSE";
	}
	}

$category = 'TRADE PERMISSION';
$report_name = 'DOWNLOAD REGION-WISE APPLICATION';
$logs = reportLogs($category,$report_name,$conn);


//	print_r($_POST);
$region_id=$_POST['region_id'];
//echo "SELECT * FROM `trade_general_info` WHERE `region_code`='$region_id'"; exit;
	$date=date("d_m_Y");
  function cleanData(&$str)
  {
    if($str == 't') $str = 'TRUE';
    if($str == 'f') $str = 'FALSE';
    if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
      $str = "'$str";
    }
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
  }

  // filename for download
  $filename = "RegionWise" . date('Ymd') . ".csv";

  header("Content-Disposition: attachment; filename=\"$filename\"");
  header("Content-Type: text/csv;");

  $out = fopen("php://output", 'w');

  $flag = false;
  $result = $conn ->query("SELECT * FROM `trade_general_info` WHERE `region_code`='$region_id'") or die('Query failed!');
  while($row = $result->fetch_assoc()) {
    if(!$flag) {
      // display field/column names as first row
      fputcsv($out, array_keys($row), ',', '"');
      $flag = true;
    }
    array_walk($row, 'cleanData');
    fputcsv($out, array_values($row), ',', '"');
  }

  fclose($out);
  exit; 

}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to GJEPC</title>

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

<!--navigation end-->
<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#popupDatepicker').datepick({dateFormat:'yyyy-mm-dd'});
	$('#inlineDatepicker').datepick({onSelect: showDate});
	$('#popupDatepicker1').datepick({dateFormat:'yyyy-mm-dd'});
	$('#inlineDatepicker1').datepick({onSelect: showDate});
});
function showDate(date) {
	alert('The date chosen is ' + date);}
</script>
 
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>
<div id="nav_wrapper"><div class="nav"><?php include("include/menu.php");?></div></div>
<div class="clear"></div>
<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Manage Trade permission</div>
</div>

<div id="main">
<div class="content">
<div class="content_details1">

<form name="search" action="" method="post" > 
<input type="hidden" name="action" id="search_type" value="regionwise" />        	
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
<td colspan="11" >Download Region Wise Application</td>
</tr>
<tr>
<td><strong>Region Wise</strong></td>
<td>
<select name="region_id" id="region_id" class="input_txt" >
    <option value="">Select Region</option>
    <?php
	$sql="select * from region_master where status=1";
	$result=$conn ->query($sql);
	while($rows= $result->fetch_assoc())
	{
	if($rows['region_name']==$region_id)
	{
	echo "<option selected='selected' value='$rows[region_name]'>$rows[region_name]</option>";
	}else{
	echo "<option value='$rows[region_name]'>$rows[region_name]</option>";
	}	}
	?>
</select>
</td>
</tr>	
<tr >
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Download"  class="input_submit" /> </td>
</tr>	
</table>
</form>      
</div>
</div>
</div>
<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>