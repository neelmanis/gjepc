<?php
      session_start(); 
      //error_reporting(E_ALL);
     include('../db.inc.php');
    if(isset($_POST["submit"]))
	{
             $filename=$_FILES["upload_file"]["tmp_name"];
    		 if($_FILES["upload_file"]["size"] > 0)
    		 {
     
    		  	$file = fopen($filename, "r");
    	         $temapData = fgetcsv($file);
				 
				 while (($emapData = fgetcsv($file, 100000, ",")) !== FALSE)
						 {
							$kpno = $emapData[0]; 
							$pdate = $emapData[1]; 							 
							$pdate = str_replace('/', '-', $pdate);
							$postingdate = date('y-m-d',strtotime($pdate));
							$idate = $emapData[2];  
							$idate = str_replace('/', '-', $idate);
							$issuedate = date('y-m-d',strtotime($idate));
				
							// exit;
							 //date_format($date, ‘d-m-Y H:i:s’);
							//$issuedate =   STR_TO_DATE( '$emapData[2]', '%Y/%m/%d %h:%i:%s' );
							$carat = $emapData[3]; 
							$amount = $emapData[4]; 
							$importername = mysql_real_escape_string($emapData[5]);
							$importeraddress = mysql_real_escape_string($emapData[6]);
							$country = $emapData[7];  
							$exportername =  mysql_real_escape_string($emapData[8]); 
							$exporteraddress =  mysql_real_escape_string($emapData[9]); 
							$region = $emapData[10]; 
							$membershipstatus = $emapData[11]; 
							$applicationtype = $emapData[12]; 
							$approved_by_bank = $emapData[13]; 
							$approved_by_custom = $emapData[14]; 
						 
						 $result = mysql_query("SELECT * FROM kp_admin_erpweb WHERE kpno ='$kpno' ");
							
							if( mysql_num_rows($result) > 0) 
							{
				//echo "UPDATE kp_admin_erpweb SET postingdate ='".$postingdate."', issuedate='".$issuedate."' , carat='".$carat."' , amount='".$amount."',importername='".$importername."',importeraddress='".$importeraddress."',country='".$country."',exportername='".$exportername."',exporteraddress='".$exporteraddress."',region='".$region."',membershipstatus='".$membershipstatus."',applicationtype='".$applicationtype."',approved_by_bank='".$approved_by_bank."',approved_by_custom='".$approved_by_custom."' where kpno='".$kpno."'"  ;		
				
							mysql_query("UPDATE kp_admin_erpweb SET postingdate ='".$postingdate."', issuedate='".$issuedate."' , carat='".$carat."' , amount='".$amount."',importername='".$importername."',importeraddress='".$importeraddress."',country='".$country."',exportername='".$exportername."',exporteraddress='".$exporteraddress."',region='".$region."',membershipstatus='".$membershipstatus."',applicationtype='".$applicationtype."',approved_by_bank='".$approved_by_bank."',approved_by_custom='".$approved_by_custom."' where kpno='".$kpno."'" );
							}
							else
							{
							  mysql_query("INSERT INTO kp_admin_erpweb(kpno,postingdate,issuedate,carat,amount,importername,importeraddress,country,exportername,exporteraddress,region,membershipstatus,applicationtype,approved_by_bank,approved_by_custom) values('".$kpno."','".$postingdate."','".$issuedate."','".$carat."','".$amount."','".$importername."','".$importeraddress."','".$country."','".$exportername."','".$exporteraddress."','".$region."','".$membershipstatus."','".$applicationtype."','0','0') ");
						
							//echo "INSERT INTO kp_admin_erpweb(kpno,postingdate,issuedate,carat,amount,importername,importeraddress,country,exportername,exporteraddress,region,membershipstatus,applicationtype,approved_by_bank,approved_by_custom) values('".$kpno."','".$postingdate."','".$issuedate."','".$carat."','".$amount."','".$importername."','".$importeraddress."','".$country."','".$exportername."','".$exporteraddress."','".$region."','".$membershipstatus."','".$applicationtype."','0','0') "; 
								
						
							}
								
						}
						fclose($file);
						echo "<script type=\"text/javascript\">alert(\"File has been successfully Imported.\");</script>";		
    		 }
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
	