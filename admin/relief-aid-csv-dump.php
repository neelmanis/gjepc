	<?php
      session_start(); 
      //error_reporting(E_ALL);
	  if(!isset($_SESSION['curruser_login_id'])){ header('Location: index.php'); exit; }
      include('../db.inc.php');

    if(isset($_POST["submit"]))
	{
            $filename=$_FILES["upload_file"]["tmp_name"];
    		if($_FILES["upload_file"]["size"] > 0)
    		{
     
    		  	$file = fopen($filename, "r");
    	        $temapData = fgetcsv($file); // Skip the first line
				 
				 while(($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
						{				
						//	echo '<pre>'; print_r($emapData); exit;
						    $relief_mode = $emapData[0]; 
						    $m_amount_transfered = $emapData[1]; 
						    $m_bank_name = $emapData[2]; 	
							
							$m_transefer_date = $emapData[3]; 							 
							$m_transefer_date = str_replace('/', '-', $m_transefer_date);
							$m_transeferDate  = date('y-m-d',strtotime($m_transefer_date));
							if(empty($m_transefer_date)) { $m_transeferDate = "0000-00-00"; } 
							$m_bank_ref_no  = filter($emapData[4]); 
							$g_good_details = filter($emapData[5]);	
							
							$g_delivery_date = $emapData[6]; 							 
							$g_delivery_date = str_replace('/', '-', $g_delivery_date); 
							$g_deliveryDate = date('y-m-d',strtotime($g_delivery_date));
							if(empty($g_delivery_date)) { $g_deliveryDate = "0000-00-00"; } 
							
							$g_delivered_by    = filter($emapData[7]);  
							$relief_mode_admin = $emapData[8]; 						 
							$mobile = filter($emapData[9]);					 
							
							$sqlx = "SELECT * FROM relief_aid WHERE mobile_no ='$mobile' ";
							$result = $conn ->query($sqlx);
							$countx =  $result->num_rows;
							
							if( $countx > 0) 
							{						
							$updateQuery = "UPDATE relief_aid SET relief_mode_upload_date =NOW(), relief_mode_status='1', relief_mode='".$relief_mode."' , m_amount_transfered='".$m_amount_transfered."',m_bank_name='".$m_bank_name."',m_transefer_date='".$m_transeferDate."',m_bank_ref_no='".$m_bank_ref_no."',g_good_details='".$g_good_details."',g_delivery_date='".$g_deliveryDate."',g_delivered_by='".$g_delivered_by."',relief_mode_admin='".$relief_mode_admin."' where mobile_no='".$mobile."'";
							$updateResultx = $conn ->query($updateQuery);							
							}
							else
							{
							 echo 'details Not matched';						
							}	
							
						}
						fclose($file);
									
			echo "<script type=\"text/javascript\">alert(\"File has been successfully Imported.\");</script>";		
    		} else { echo "<script type=\"text/javascript\">alert(\"Please Upload CSV file only\");</script>";		 }
    }	 
?>	

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Import Form ||GJEPC||</title>

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
	<div class="breadcome"><a href="admin.php">Home</a> > Import </div>
</div>

<div id="main">
	<div class="content">
    	
<div class="clear"></div>
<div class="content_details1">
<div class="content_head">

<form method="post" action="" enctype="multipart/form-data">
<th>UPLOAD CSV Data into Database</th>
<tr><td><input type="file" name="upload_file" id="upload_file"/></td></tr>
<tr><td><input type="submit" name="submit" value="Submit" /></td></tr>
</form>

</div>  
</div>  
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>
</body>
</html>
