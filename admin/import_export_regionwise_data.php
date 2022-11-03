<?php
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
$adminID = intval($_SESSION['curruser_login_id']);

	if($_REQUEST['Reset']=="Reset")
	{
	  $_SESSION['export_import_type']=""; 
	  $_SESSION['financial_year']="";
	  $_SESSION['region']="";  
	  $_SESSION['quarter_year']="";  
	  header("Location: import_export_regionwise_data.php");
	} else {
  	$search_type=$_REQUEST['search_type'];
  	
  	if($search_type=="SEARCH")
	{
		//print_r($_POST);
		$_SESSION['export_import_type']=$_REQUEST['export_import_type'];
		$_SESSION['financial_year']=$_REQUEST['financial_year'];
		$_SESSION['region']=$_REQUEST['region'];
		$_SESSION['quarter_year']=$_REQUEST['quarter_year'];
		
		if($_SESSION['export_import_type']=="")
		{
			$_SESSION['error_msg']="Please select Export/Import";
		} else if($_SESSION['financial_year']=="")
		{
			$_SESSION['error_msg']="Please select Financial Year";
		} else {
		
		$export_import_type = $_REQUEST['export_import_type'];
		$financial_year = $_REQUEST['financial_year'];	
		$region  = $_REQUEST['region'];
		$quarter_year = $_REQUEST['quarter_year'];				
		
		if($quarter_year == "Q1") { $quarter_type = "Quarter 1"; } 
		elseif($quarter_year == "Q2") { $quarter_type = "Quarter 2"; } 
		elseif($quarter_year == "Q3"){ $quarter_type = "Quarter 3"; } 
		elseif($quarter_year == "Q4"){ $quarter_type = "Quarter 4"; } 
		
		if($export_import_type == "export") { $report_type = "export"; } 
		elseif($export_import_type == "import") { $report_type = "import"; } 
		
			$table = $display = "";	

			$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
			<tr>
			
			<td colspan="7" style="color:blue;font-weight:600; text-align:center;font-size:24px">Region-Wise Gem And Jewellery '.$report_type.' - '.$quarter_type.' '.$financial_year.'</td>
			
			</tr>
			<tr>
			<td>Regions</td>
			<td>HS Code at 8 Digit Level</td>
			<td>Commodity Description</td>
			<td>No. of Members (count)</td>
			<td>Quantity (Carat)</td>
			<td>Quantity (Grams)</td>
			<td>Gross '.$report_type.'(Dollar)</td>
			<td>Gross '.$report_type.'(Euro)</td>
			</tr>';
			
			if($export_import_type == "export"){
			//$sql1=",e.appId,e.hs_code,e.products,count(e.registration_id) as `memberCount`,sum(e.qty) AS QTY,sum(e.value) AS VALUE"; 
			$sql1=",e.appId,e.hs_code,e.products,count(e.registration_id) as `memberCount`,sum(if(e.currency = 'EUR',value,0)) as TotalEuroCurrency,sum(if(e.unit = 'carat',qty,0)) as TotalCaratUnit,sum(if(e.currency = 'USD',value,0)) as TotalUSDCurrency,sum(if(e.unit = 'grams',qty,0)) as TotalGramsUnit"; 
			$attach =  " group by e.hs_code";
			}
			if($export_import_type == "import"){
			//$sql1=",i.appId,i.hs_code,i.products,count(i.registration_id) as `memberCount`,sum(i.qty) AS QTY,sum(i.value) AS VALUE"; 
			$sql1=",i.appId,i.hs_code,i.products,count(i.registration_id) as `memberCount`,sum(if(i.currency = 'EUR',value,0)) as TotalEuroCurrency,sum(if(i.unit = 'carat',qty,0)) as TotalCaratUnit,sum(if(i.currency = 'USD',value,0)) as TotalUSDCurrency,sum(if(i.unit = 'grams',qty,0)) as TotalGramsUnit";  
			$attach =  " group by i.hs_code";
			}
			
			$sqlx = "SELECT s.id,s.quarter_year,s.region,s.financial_year,count(s.registration_id) AS MemberCount ".$sql1." FROM statistics s";			
			
			if($export_import_type != "")
			{
				if($export_import_type == "export" && $region=="")
				{   
					$sqlx.= " inner join statistics_exports e where e.appId=s.id";
				}
				if($export_import_type == "export" && $region!="")
				{   
					$sqlx.= " inner join statistics_exports e where s.region='$region' AND e.appId=s.id";
				}
				if($export_import_type == "import" && $region=="")
				{   
					$sqlx.= " inner join statistics_imports i where i.appId=s.id";
				}
				if($export_import_type == "import" && $region!="")
				{   
					$sqlx.= " inner join statistics_imports i where s.region='$region' AND i.appId=s.id";
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
			$sqlx.= "  ".$attach." ";			
			$sqlx.= ",s.region order by s.region";			
			//echo $sqlx; exit;
			
			$stmt = $conn ->query($sqlx);
			$i=1;
			while($getRows = $stmt->fetch_assoc())
			{				
					$region = $getRows['region'];
					$export_hs_code = $getRows['hs_code'];
					$export_products = $getRows['products'];
					$MemberCount = $getRows['MemberCount'];
					$export_currency = $getRows['currency'];
					$export_qty = $getRows['QTY'];
					$export_value = $getRows['VALUE'];
					
					$TotalCaratUnit = $getRows['TotalCaratUnit'];
					$TotalGramsUnit = $getRows['TotalGramsUnit'];
					$TotalUSDCurrency = $getRows['TotalUSDCurrency'];
					$TotalEuroCurrency = $getRows['TotalEuroCurrency'];
					
					$table .= '<tr>
					<td>'.$region.'</td>
					<td>'.$export_hs_code.'</td>
					<td>'.$export_products.'</td>
					<td>'.$MemberCount.'</td>
					<td>'.$TotalCaratUnit.'</td>
					<td>'.$TotalGramsUnit.'</td>
					<td>'.$TotalUSDCurrency.'</td>
					<td>'.$TotalEuroCurrency.'</td>
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
		}elseif($export_import_type == 'all') {
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

<?php 
if($_SESSION['error_msg']!=""){
echo "<span class='notification n-error'>".$_SESSION['error_msg']."</span>";
$_SESSION['error_msg']="";
}
?>
<form name="search" action="" method="POST"/> 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />        	

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
    <td><b>Region</b></td>
    <td>
    <select name="region">
        <option value="">Select Region</option>
    	<?php 
		$region_query = "select * from region_master";
		$execute_region = $conn ->query($region_query);
		while($show_region = $execute_region->fetch_assoc()){
		?>
    	<option value="<?php echo $show_region["region_name"]; ?>" <?php if($_SESSION["region"]==$show_region["region_name"]) echo "selected"; ?>><?php echo $show_region["region_name"]; ?></option>
    	<?php	}	?>
    </select>
    </td>
</tr>
<tr>
    <td width="19%"><strong>Select Quarter Year</strong></td>
    <td width="81%">
    <select class="form-control" name="quarter_year" id="quarter_year">
    <option value="">Select Quarter Year</option>	
    <?php 
	$sql="select * from statistics_import_export_quarter_master where status='1'";
	$result=$conn ->query($sql);
	while($rows =  $result->fetch_assoc())
	{
	if($_SESSION['quarter_year']==$rows['quarter_year'])
	{
	echo "<option value='$rows[quarter_year]' selected='selected'>$rows[description]</option>";
	}else
	{
	echo "<option value='$rows[quarter_year]'>$rows[description]</option>";
	}
	}
	?>    
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