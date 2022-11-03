<?php session_start(); 
ob_start();?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
		//echo "hello";
		 $location=$_SESSION['location'];  
		  $type=$_SESSION['type']; 
		  $filter=$_SESSION['filter']; 
		  $from_date=$_SESSION['from_date']; 
		  $to_date=$_SESSION['to_date'];  
		//exit;
//print_r($_POST['location_id']);

	if($location!="" || isset($location))
		{
			if($type==1)
			{
				if($filter==1)
				{
				 $sql="SELECT * FROM kp_export_application_master where PROCES_CNTR=$location and payment_made_status='Y' and DOWNLOAD_STATUS=0";
 			//exit;
				}
				else
				{
				 $sql="SELECT * FROM kp_export_application_master where PROCES_CNTR=$location and  payment_made_status='Y' and DOWNLOAD_STATUS=1 and EXP_APP_DATE>='$from_date 00:00:00' and EXP_APP_DATE<='$to_date 23:59:00'";
 
				}
				
				$output_hs="";
 			$result=mysql_query($sql);
 
 

// Get Records from the table
		$filename = "New_ERP_HS_".date('d_m_Y').".csv";
		header('Content-type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$filename);
		header("Pragma: no-cache");  
		header("Expires: 0"); 
		$output = fopen("php://output", 'w');
	
			$flag = false;
	while ($row = mysql_fetch_array($result)) {
			
			/*echo "<pre>";
		print_r($row);
		echo "</pre>";
		exit;*/
			$app_id=$row['EXPORT_APP_ID'];
			 $up_sql="update kp_export_application_master set DOWNLOAD_STATUS=1 where EXPORT_APP_ID=$app_id";
			$up_result=mysql_query($up_sql);
			
			 $sql_hs="select if(ie.FORM_TYPE='I','Import','Export') as `Application Type`,tr.EXPORT_APP_ID as `Web Application No.`,hs.HS_CODE as `H.S.Code`,tr.WEIGHT as `Carat Weight`,tr.AMOUNT as `Value in U.S.D.($)`,c.MFCODE as `Country of Origin` from kp_expimp_tran_detail tr left join kp_hs_code_master hs on tr.HS_CODE_ID=hs.LOOKUP_VALUE_ID left join kp_country_master c on tr.COUNTRY_ID=c.LCMINOR left join kp_export_application_master ie on tr.EXPORT_APP_ID=ie.EXPORT_APP_ID where tr.EXPORT_APP_ID=$app_id";
			
			
  $result_hs = mysql_query($sql_hs) or die('Query failed!');
			
				$row_hs = mysql_fetch_assoc($result_hs);
				if(!$flag) {
      				// display field/column names as first row
     				 fputcsv($output, array_keys($row_hs), ',', '"');
      				 $flag = true;
    				}
					
					array_walk($row_hs, 'cleanData');
   				 fputcsv($output, array_values($row_hs), ',', '"');
 			//$result_hs=mysql_query($sql_hs);
 
 		//$columns_total1 = mysql_num_fields($result_hs);
			
			//$cnt_hs=mysql_num_rows($result_hs);
		
		/*if($cnt_hs>0)
		{
		$row_hs = mysql_fetch_array($result_hs);
		echo "<pre>";
		print_r($row_hs);
		echo "</pre>";
		
		for ($j = 0; $j < $columns_total1; $j++) {
		$output1 .='"'.$row_hs["$j"].'",';
		}
		$output1 .="\n";
		}*/
				
//echo $output1;

}
fclose($output);
unset($_SESSION['location']); 
unset($_SESSION['type']); 
unset($_SESSION['filter']); 
unset($_SESSION['from_date']);  
unset($_SESSION['to_date']);  
  exit;

 //Download the file
 

//echo $output1;



			}
			else
			{
				header("location:download_application.php");
			}
		}
 
?>