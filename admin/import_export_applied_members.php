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
	  header("Location: import_export_applied_members.php");
	} else {
  	$search_type=$_REQUEST['search_type'];
  	
  	if($search_type=="SEARCH")
	{
		
		
		$_SESSION['financial_year']=$_REQUEST['financial_year'];
		$_SESSION['quarter_year']=$_REQUEST['quarter_year'];
		$_SESSION['region']=$_REQUEST['region'];
		if($_SESSION['region']=="")
		{
			$_SESSION['error_msg']="Please select Region";
		} else if($_SESSION['financial_year']=="")
		{
			$_SESSION['error_msg']="Please select Financial Year";
		}else if($_SESSION['quarter_year']=="")
		{
			$_SESSION['error_msg']="Please select Quarter";
		} else {
		
		$region  = $_REQUEST['region'];
		$financial_year = $_REQUEST['financial_year'];	
		$quarter_year = $_REQUEST['quarter_year'];	 
		
			$table = $display = "";	

			$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
			
			<tr>			
			<td colspan="4" style="color:blue;font-weight:600; text-align:center;font-size:24px">Applied Members Data Gem And Jewellery '.$financial_year.'-'.$quarter_year.'</td>			
			</tr>
			<tr>
			
				<td>Company Name</td>
				<td>Company Pan </td>
				<td>Company region</td>
				<td>Contact</td>
			</tr>';
			
			
			
			$sqlx = "SELECT id,registration_id,region,company_name,company_pan FROM statistics  ";			
		
			if($region!="")
			{
					$sqlx.= " WHERE region='".$region."'";
			}
			
			if($financial_year!="")
			{
					$sqlx.= " AND financial_year='".$financial_year."'";
			}
			if($quarter_year!="")
			{
					$sqlx.= " AND quarter_year='".$quarter_year."'";
			}
			//$sqlx.= " ";		
			$sqlx.= " group by registration_id order by region ";			
			
			
			$stmt = $conn ->query($sqlx);
			$i=1;
			while($getRows = $stmt->fetch_assoc())
			{
		
				$contact=getUserMobile($getRows['registration_id'],$conn);
                $company_region=$getRows['region'];
                $company_name=$getRows['company_name'];
                $company_pan=$getRows['company_pan'];
		
				$table .= '<tr>
				
				<td>'. $company_name.'</td>
				<td>'.$company_pan.'</td>
                <td>'.$company_region.'</td>
                <td>'.$contact.'</td>
				
				</tr>';		
				$i++;					
			}			

		$table .= $display;
		$table .= '</table>';
		
		header("Content-type: application/x-msdownload"); 
		
		 header("Content-Disposition: attachment; filename=applied-members-data.xls");
		
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
<title>Import/Export Applied Members Form ||GJEPC||</title>
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
	<div class="breadcome"><a href="admin.php">Home</a> > Applied Mmeber Data Import/Export</div>
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
    <td width="19%"><strong>Select Quaeter </strong></td>
    <td width="81%">
    <select class="form-control" name="quarter_year" id="quarter_year">
    <option value="">Select Quarter </option>	
    <option value='Q1' <?php if($_SESSION['quarter_year']=='Q1'){echo "selected='selected'";}?>>Quarter 1</option>
    <option value='Q2' <?php if($_SESSION['quarter_year']=='Q2'){echo "selected='selected'";}?>>Quarter 2</option>
    <option value='Q3' <?php if($_SESSION['quarter_year']=='Q3'){echo "selected='selected'";}?>>Quarter 3</option>
    <option value='Q4' <?php if($_SESSION['quarter_year']=='Q4'){echo "selected='selected'";}?>>Quarter 4</option>
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