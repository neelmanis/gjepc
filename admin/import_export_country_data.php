<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
$adminID = intval($_SESSION['curruser_login_id']);

	function getCName($country,$conn)
	{
		$array=explode(',',$country);
		$country_name;
		for($i=0;$i<=count($array);$i++){
			$query_sel = "SELECT country_name FROM country_master where country_code='".$array[$i]."'";
			$result = $conn->query($query_sel);
			if($row = $result->fetch_assoc()) 	
			{ 		
				$country_name.=$row['country_name'].",";				
			}
		}
		return $country_name;
	}
		
	if($_REQUEST['Reset']=="Reset")
	{
	  $_SESSION['export_import_type']=""; 
	  $_SESSION['financial_year']="";  
	  header("Location: import_export_country_data.php");
	} else {
  	$search_type=$_REQUEST['search_type'];
  	
  	if($search_type=="SEARCH")
	{
		
		$_SESSION['export_import_type']=$_REQUEST['export_import_type'];
		$_SESSION['financial_year']=$_REQUEST['financial_year'];
		$_SESSION['quarter_year']=$_REQUEST['quarter_year'];
		if($_SESSION['export_import_type']=="")
		{
			$_SESSION['error_msg']="Please select Export/Import";
		} else if($_SESSION['financial_year']=="")
		{
			$_SESSION['error_msg']="Please select Financial Year";
		}else if($_SESSION['quarter_year']=="")
		{
			$_SESSION['error_msg']="Please select Quarter";
		} else {
		
		$export_import_type = $_REQUEST['export_import_type'];
		$financial_year = $_REQUEST['financial_year'];	
		$quarter_year = $_REQUEST['quarter_year'];	

				
		if($export_import_type == "export") { $report_type = "export"; } 
		elseif($export_import_type == "import") { $report_type = "import"; } 
		
			$table = $display = "";	

			$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
			
			<tr>			
			<td colspan="7" style="color:blue;font-weight:600; text-align:center;font-size:24px">Country Data Gem And Jewellery '.$report_type.'-'.$financial_year.'-'.$quarter_year.'-</td>			
			</tr>
			<tr>
				<td>Region</td>
				<td>Company Name</td>
				<td>Email</td>
				<td>Contact No</td>
				<td>HS Code at 8 Digit Level</td>
				<td>Commodity Description</td>
				<td>Country</td>
				<td>Value</td>
				<td>Currency</td>
				<td>Quantity</td>
				<td>Unit</td>
				<td>Quarter</td>
			</tr>';
			
			if($export_import_type == "export"){
				$sql1=",e.hs_code,e.products,e.country,e.value,e.currency,e.qty,e.unit"; 
			}
			if($export_import_type == "import"){
				$sql1=",i.hs_code,i.products,i.country,i.value,i.currency,i.qty,i.unit";
			}
			
			$sqlx = "SELECT s.id,s.registration_id,s.region,s.quarter_year ".$sql1." FROM statistics s";			
		
			if($export_import_type != "")
			{
				if($export_import_type == "export" && $region=="")
				{   
					$sqlx.= " inner join statistics_exports e where e.appId=s.id";
				}
				if($export_import_type == "import" && $region=="")
				{   
					$sqlx.= " inner join statistics_imports i where i.appId=s.id";
				}
			}
			
			if($financial_year!="")
			{
					$sqlx.= " AND s.financial_year='".$financial_year."'";
			}
			if($quarter_year!="")
			{
					$sqlx.= " AND s.quarter_year='".$quarter_year."'";
			}
			//$sqlx.= " ";		
			$sqlx.= " order by s.region";			
			// echo $sqlx; exit;
			
			$stmt = $conn ->query($sqlx);
			$i=1;
			while($getRows = $stmt->fetch_assoc())
			{
				$region = $getRows['region'];
				$registration_id = $getRows['registration_id'];
				$export_hs_code = $getRows['hs_code'];
				$export_products = $getRows['products'];
				$country = $getRows['country'];
				$value = $getRows['value'];
				$currency = $getRows['currency'];
				$qty = $getRows['qty'];
				$unit = $getRows['unit'];
				$quarter_yearR = $getRows['quarter_year'];
				$table .= '<tr>
				<td>'.$region.'</td>
				<td>'.getNameCompany($registration_id,$conn).'</td>
				<td>'.getUserEmail($registration_id,$conn).'</td>
				<td>'.getUserMobile($registration_id,$conn).'</td>
				<td>'.$export_hs_code.'</td>
				<td>'.$export_products.'</td>
				<td>'.getCName($country,$conn).'</td>
				<td>'.$value.'</td>
				<td>'.$currency.'</td>
				<td>'.$qty.'</td>
				<td>'.$unit.'</td>
				<td>'.$quarter_yearR.'</td>
				</tr>';		
				$i++;					
			}			

		$table .= $display;
		$table .= '</table>';
		
		header("Content-type: application/x-msdownload"); 
		if($export_import_type == "import") {
		 header("Content-Disposition: attachment; filename=$report_type.xls");
		}elseif($export_import_type == "export") {
		  header("Content-Disposition: attachment; filename=$report_type.xls");
		}
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
		exit;
	}
	}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Import/Export Region-Wise Form ||GJEPC||</title>
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
<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a> > Region wise Import/Export</div>
</div>

<div id="main">
	<div class="content">
    	
<div class="clear"></div>
<div class="content_details1">

<form name="search" action="" method="POST"/> 

<input type="hidden" name="search_type" id="search_type" value="SEARCH" />        	
<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt">
<tr class="orange1"><td colspan="11">Search Options</td></tr> 
<tr>
    <td width="19%"><strong>Select Export/Import</strong></td>
    <td width="81%">
    <select class="form-control" name="export_import_type" id="export_import_type">
	<option value=""> Select Select Export/Import</option>
	<option value="export" <?php if($_SESSION['export_import_type']=="export"){   echo "selected='selected'";}?>>Export</option>
	<option value="import" <?php if($_SESSION['export_import_type']=="import"){ echo "selected='selected'";}?>>Import</option>
	</select>
    </td>
</tr>
<tr>
    <td width="19%"><strong>Select Financial Year</strong></td>
    <td width="81%">
    <select class="form-control" name="financial_year" id="financial_year">
    <option value="">Select Financial Year</option>	
    <option value='2019-2020' <?php if($_SESSION['financial_year']=='2019-2020'){echo "selected='selected'";}?>>2019-2020</option>
	<option value='2020-2021' <?php if($_SESSION['financial_year']=='2020-2021'){echo "selected='selected'";}?>>2020-2021</option>
    </select>
    </td>
</tr>
<tr>
    <td width="19%"><strong>Select Quaeter </strong></td>
    <td width="81%">
    <select class="form-control" name="quarter_year" id="quarter_year">
    <option value="">Select Quarter </option>	
    <option value='Q1' <?php if($_SESSION['quarter_year']=='Q1'){echo "selected='selected'";}?>>Apr- June (Q1)</option>
    <option value='Q2' <?php if($_SESSION['quarter_year']=='Q2'){echo "selected='selected'";}?>>July- Sept (Q2)</option>
    <option value='Q3' <?php if($_SESSION['quarter_year']=='Q3'){echo "selected='selected'";}?>>Oct- Dec (Q3)</option>
    <option value='Q4' <?php if($_SESSION['quarter_year']=='Q4'){echo "selected='selected'";}?>>Jan- March (Q4)</option>
    </select>
    </td>
</tr>

<tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Download Report" class="input_submit" /> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	

</table>
</form>      
</div>

<div class="content_details1">

</div> 
  
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>