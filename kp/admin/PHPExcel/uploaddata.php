<?php session_start(); 
      error_reporting(E_ALL);
      include('../db.inc.php');
	  require_once('PHPExcel/IOFactory.php');
 ?>


<?php

if(isset($_POST["submit"]) && !empty($_FILES['upload_file']['name']))
{

$namearr = explode(".",$_FILES['upload_file']['name']); 
if(end($namearr) != 'xls' && end($namearr) != 'xlsx')
{
echo '<p> Invalid File </p>';
$invalid = 1;
}

if($invalid != 1)
{
$target_dir = "upload/";
$target_file = $target_dir . basename($_FILES["upload_file"]["name"]); 

$response = move_uploaded_file($_FILES['upload_file']['tmp_name'],$target_file); // Upload the file to the current folder
if($response)
{
try {
$objPHPExcel = PHPExcel_IOFactory::load($target_file); 

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
} catch(Exception $e) {
die('Error : Unable to load the file : "'.pathinfo($_FILES['upload_file']['name'],PATHINFO_BASENAME).'": '.$e->getMessage());
}
$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true); 
//print_r($allDataInSheet); exit;
$arrayCount = count($allDataInSheet); // Total Number of rows in the uploaded EXCEL file

$string = "INSERT INTO kp_admin_erpweb(kpno,postingdate,issuedate,carat,amount,importername,importeraddress,exportername,exporteraddress,region,membershipstatus,applicationtype,approved_by_bank,approved_by_custom) values";

for($i=2;$i<=$arrayCount;$i++){

                $kpno = $allDataInSheet[$i][A]; 
			  // $postingdate = date('Y-m-d',excelDateToDate($allDataInSheet[$i][B])); 
			  //echo  $postingdate = $allDataInSheet[$i][B]; 
			   $postingdate =date('Y-m-d',strtotime($allDataInSheet[$i][B])); 
				$issuedate = date('Y-m-d',strtotime($allDataInSheet[$i][C]));
				$carat = $allDataInSheet[$i][D];
				$amount = $allDataInSheet[$i][E];
				$importername = mysql_real_escape_string($allDataInSheet[$i][F]);
				$importeraddress = $allDataInSheet[$i][G];
				$exportername = $allDataInSheet[$i][H];
				$exporteraddress = $allDataInSheet[$i][I];
				$region = $allDataInSheet[$i][J];
				$membershipstatus = $allDataInSheet[$i][K];
				$applicationtype = $allDataInSheet[$i][L];
				$approved_by_bank = $allDataInSheet[$i][M];
				$approved_by_custom = $allDataInSheet[$i][N];

$string .= "( '".$kpno."','".$postingdate."','".$issuedate."','".$carat."','".$amount."','".$importername."','".$importeraddress."','".$exportername."','".$exporteraddress."','".$region."','".$membershipstatus."','".$applicationtype."','0','0' ),";
}

$string = substr($string,0,-1);
//echo $string; exit;

//mysql_query($string); // Insert all the data into one query
if (!mysql_query($string))
												{
													die('Error: ' . mysql_error());
												}
}
}// End Invalid Condition
                        
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

<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
-->
</style>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>


<div id="nav_wrapper">


	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="uploaddata.php">Home</a> > ERP TO WEB </div>
</div>
<form method="post" action="" enctype="multipart/form-data" />
<table width="50%" border="2" />
<th>
UPLOAD ERP TO WEB
</th>
<tr>
<td><input type="file" name="upload_file" id="upload_file"/></td>
</tr>
<tr>
<td><input type="submit" name="submit" value="Submit" /></td>
 </tr>
 </table>
 </form>
</body>
</html><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
</body>
</html>
