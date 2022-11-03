<?php 
session_start();
ob_start();
include('../db.inc.php');
include('../functions.php');
?>
<?php
		 $location=$_SESSION['location'];
		 $type=$_SESSION['type'];
		 $filter=$_SESSION['filter'];
		$from_date=date("Y-m-d",strtotime($_SESSION['from_date']));
		$to_date=date("Y-m-d",strtotime($_SESSION['to_date']));
		if($location!="" || isset($location))
		{
			if($type==1)
			{
				if($filter==1)
				{
				 $sql="SELECT 
if(ie.FORM_TYPE='I','import','export') as `Application Type`,
a.MFCODE as `Agent No.`, 
SUBSTRING(a.AGENT_NAME,1,30) as `Agent Name`,
SUBSTRING(a.AGENT_NAME,31) as `Agent Name2`,
ie.EXPORT_APP_ID as `Web Application No.`,
if(ld.LOOKUP_VALUE_NAME='member',m.MFCODE,nm.MFCODE) as `Applicant N0.`,
if(ld.LOOKUP_VALUE_NAME='member',SUBSTRING(m.MEMBER_CO_NAME,1,50),SUBSTRING(nm.NON_MEMBER_NAME,1,50)) as `Applicant name`,
if(ld.LOOKUP_VALUE_NAME='member',SUBSTRING(m.MEMBER_CO_NAME,51),SUBSTRING(nm.NON_MEMBER_NAME,51)) as `Applicant name2`,
if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_ADDRESS1,nm.ADDRESS1) as `Applicant Address`,
if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_ADDRESS2,nm.ADDRESS2) as `Applicant Address2`,
if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_ADDRESS3,nm.ADDRESS3) as `Applicant Address3`,
if(ld.LOOKUP_VALUE_NAME='member',m.PINCODE,nm.PINCODE) as `Applicant Post Code`,
if(ld.LOOKUP_VALUE_NAME='member',m.CITY,nm.CITY) as `Applicant City`,
SUBSTRING(ie.M_STATE,1,3) as `Applicant State`,
ie.M_COUNTRY as `Applicant Country`,
if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_TEL1,nm.TELEPHONE1) as `Applicant Phone No.`,
if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_TEL2,nm.TELEPHONE2) as `Applicant Phone No.2`,
if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_TEL3,nm.MOBILE) as `Applicant Mobile No.`,
if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_FAX1,nm.FAX) as `Applicant Telex No.`,
if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_FAX2,nm.FAX2) as `Applicant Telex No.2`,
if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_CO_EMAIL,nm.EMAIL) as `Applicant Email`,
if(ld.LOOKUP_VALUE_NAME='member',m.HOME_PAGE,nm.HOME_PAGE) as `Applicant Home Page`,
ld.LOOKUP_VALUE_NAME as `Applicant Type`,
lc.LOCATION_ADDRESS as `Region Code`,
ie.KP_CERT_NO as `Certificate No.`,
DATE(ie.EXP_APP_DATE) as `Application Date`,
ie.NUMBER_OF_PARCELS as `No. Of Parcel`,
ie.FEES_AMOUNT as `Certificate Charges`,
ie.KP_OTH_CHG as `Other Charges`,
ie.TOTAL_AMOUNT as `Total Charges`,
if(pm.CHEQUE_NO !='','','') as `Cheque No./Bank Trans No.`,
if(pm.CHEQUE_DATE !='','','') as `Cheque Date`,
ad.LOOKUP_VALUE_NAME as `Payment Mode`,
fo.MFCODE as `Exporter/Importer's No.`,
SUBSTRING(ie.IE_PARTY_NAME,1,20) as `Exporter/Importer's Name`,
SUBSTRING(ie.IE_PARTY_NAME,21) as `Exporter/Importer's Name2`,
SUBSTRING(ie.IE_ADDRESS1,1,30) as `Exporter/Importer's Address`,
SUBSTRING(ie.IE_ADDRESS2,1,30) as `Exporter/Importer's Address 2`,
ie.IE_ADDRESS3 as `Exporter/Importer's Address 3`,
ie.IE_CITY as `Exporter/Importer's City`,
ie.IE_STATE as `Exporter/Importer's State`,
c.MFCODE as `Exporter/Importer's Country`,
ie.IE_PIN as `Exporter/Importer's Post Code`,
ie.IE_ADD_TYPE as `Exporter/Importer Add Type`,
c.MFCODE as `Country of Destination`,
ie.INVOICE_NO as `Invoice No.`,
DATE(ie.INVOICE_DATE) as `Invoice date`,
ie.KP_REMARKS as `Remarks`,
if(ld.LOOKUP_VALUE_NAME='member',m.IEC_NO, nm.IEC_NO) as `IEC Code`,
if(pm.PAYEE_BRANCH_CODE!='','','') as `Bank Branch Code`,
if(pm.PAYEE_BRANCH!='','','') as `Bank Branch Name`    
   
FROM
 (kp_export_application_master ie left join kp_agent_master a on a.AGENT_ID = ie.AGENT_ID left join  kp_payment_master pm on pm.PAYMENT_MST_ID = ie.KP_PAYMENT_ID left join kp_country_master c on c.LCMINOR = ie.COUNTRY_DEST_ID left join  kp_member_master m on m.MEMBER_ID = ie.MEMBER_ID left join kp_non_member_master nm on nm.NON_MEMBER_ID = ie.NON_MEMBER_ID left join kp_lookup_details ld on ld.LOOKUP_VALUE_ID =ie.MEMBER_TYPE_ID left join kp_lookup_details ad on ad.LOOKUP_VALUE_ID =pm.PAYMENT_TYPE left join kp_location_master lc on lc.LOCATION_ID=ie.PROCES_CNTR left join kp_foreign_imp_master fo on fo.PARTY_ID=ie.IE_PARTY_ID)  where ie.PROCES_CNTR=$location and ie.payment_made_status='Y' and ie.DOWNLOAD_STATUS=0";
 			//exit;
				}
				else
				{
				 $sql="SELECT 
if(ie.FORM_TYPE='I','import','export') as `Application Type`,
a.MFCODE as `Agent No.`, 
SUBSTRING(a.AGENT_NAME,1,30) as `Agent Name`,
SUBSTRING(a.AGENT_NAME,31) as `Agent Name2`,
ie.EXPORT_APP_ID as `Web Application No.`,
if(ld.LOOKUP_VALUE_NAME='member',m.MFCODE,nm.MFCODE) as `Applicant N0.`,
if(ld.LOOKUP_VALUE_NAME='member',SUBSTRING(m.MEMBER_CO_NAME,1,50),SUBSTRING(nm.NON_MEMBER_NAME,1,50)) as `Applicant name`,
if(ld.LOOKUP_VALUE_NAME='member',SUBSTRING(m.MEMBER_CO_NAME,51),SUBSTRING(nm.NON_MEMBER_NAME,51)) as `Applicant name2`,
if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_ADDRESS1,nm.ADDRESS1) as `Applicant Address`,
if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_ADDRESS2,nm.ADDRESS2) as `Applicant Address2`,
if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_ADDRESS3,nm.ADDRESS3) as `Applicant Address3`,
if(ld.LOOKUP_VALUE_NAME='member',m.PINCODE,nm.PINCODE) as `Applicant Post Code`,
if(ld.LOOKUP_VALUE_NAME='member',m.CITY,nm.CITY) as `Applicant City`,
SUBSTRING(ie.M_STATE,1,3) as `Applicant State`,
ie.M_COUNTRY as `Applicant Country`,
if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_TEL1,nm.TELEPHONE1) as `Applicant Phone No.`,
if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_TEL2,nm.TELEPHONE2) as `Applicant Phone No.2`,
if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_TEL3,nm.MOBILE) as `Applicant Mobile No.`,
if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_FAX1,nm.FAX) as `Applicant Telex No.`,
if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_FAX2,nm.FAX2) as `Applicant Telex No.2`,
if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_CO_EMAIL,nm.EMAIL) as `Applicant Email`,
if(ld.LOOKUP_VALUE_NAME='member',m.HOME_PAGE,nm.HOME_PAGE) as `Applicant Home Page`,
ld.LOOKUP_VALUE_NAME as `Applicant Type`,
lc.LOCATION_ADDRESS as `Region Code`,
ie.KP_CERT_NO as `Certificate No.`,
DATE(ie.EXP_APP_DATE) as `Application Date`,
ie.NUMBER_OF_PARCELS as `No. Of Parcel`,
ie.FEES_AMOUNT as `Certificate Charges`,
ie.KP_OTH_CHG as `Other Charges`,
ie.TOTAL_AMOUNT as `Total Charges`,
if(pm.CHEQUE_NO !='','','') as `Cheque No./Bank Trans No.`,
if(pm.CHEQUE_DATE !='','','') as `Cheque Date`,
ad.LOOKUP_VALUE_NAME as `Payment Mode`,
fo.MFCODE as `Exporter/Importer's No.`,
SUBSTRING(ie.IE_PARTY_NAME,1,20) as `Exporter/Importer's Name`,
SUBSTRING(ie.IE_PARTY_NAME,21) as `Exporter/Importer's Name2`,
SUBSTRING(ie.IE_ADDRESS1,1,30) as `Exporter/Importer's Address`,
SUBSTRING(ie.IE_ADDRESS2,1,30) as `Exporter/Importer's Address 2`,
ie.IE_ADDRESS3 as `Exporter/Importer's Address 3`,
ie.IE_CITY as `Exporter/Importer's City`,
ie.IE_STATE as `Exporter/Importer's State`,
c.MFCODE as `Exporter/Importer's Country`,
ie.IE_PIN as `Exporter/Importer's Post Code`,
ie.IE_ADD_TYPE as `Exporter/Importer Add Type`,
c.MFCODE as `Country of Destination`,
ie.INVOICE_NO as `Invoice No.`,
DATE(ie.INVOICE_DATE) as `Invoice date`,
ie.KP_REMARKS as `Remarks`,
if(ld.LOOKUP_VALUE_NAME='member',m.IEC_NO, nm.IEC_NO) as `IEC Code`,
if(pm.PAYEE_BRANCH_CODE!='','','') as `Bank Branch Code`,
if(pm.PAYEE_BRANCH!='','','') as `Bank Branch Name`   
FROM
 (kp_export_application_master ie left join kp_agent_master a on a.AGENT_ID = ie.AGENT_ID left join  kp_payment_master pm on pm.PAYMENT_MST_ID = ie.KP_PAYMENT_ID left join kp_country_master c on c.LCMINOR = ie.COUNTRY_DEST_ID left join  kp_member_master m on m.MEMBER_ID = ie.MEMBER_ID left join kp_non_member_master nm on nm.NON_MEMBER_ID = ie.NON_MEMBER_ID left join kp_lookup_details ld on ld.LOOKUP_VALUE_ID =ie.MEMBER_TYPE_ID left join kp_lookup_details ad on ad.LOOKUP_VALUE_ID =pm.PAYMENT_TYPE left join kp_location_master lc on lc.LOCATION_ID=ie.PROCES_CNTR left join kp_foreign_imp_master fo on fo.PARTY_ID=ie.IE_PARTY_ID)  where ie.PROCES_CNTR=$location and ie.payment_made_status='Y' and ie.DOWNLOAD_STATUS=1 and EXP_APP_DATE>='$from_date 00:00:00' and EXP_APP_DATE<='$to_date 23:59:00'";

				}
				
	/*function cleanData(&$str)
  	{
		if($str == 't') $str = 'TRUE';
		if($str == 'f') $str = 'FALSE';
		if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
		  $str = "'$str";
		}
		if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	  }*/
	  
	  
	  
	 /* while($row=mysql_fetch_array($result))
		{
				echo "<pre>";
				print_r($row);
				echo "</pre>";
		}
		exit;*/
	
	  // filename for download
	  $filename = "New_ERP_" . date('Ymd') . ".csv";
	
	  header("Content-Disposition: attachment; filename=\"$filename\"");
	  header("Content-Type: Application/csv;");
	
	  $out = fopen("php://output", 'w');
	
	  $flag = false;
	  
		$result = mysql_query($sql) or die('Query failed!');
		
	  while(false !== ($row = mysql_fetch_assoc($result))) {
		if(!$flag) {
		  // display field/column names as first row
		  fputcsv($out, array_keys($row), ',', '"');
		  $flag = true;
		}
		array_walk($row, 'cleanData');
		fputcsv($out, array_values($row), ',', '"');
	  }
	
	  fclose($out);
	  	$_SESSION['location']="";  
		 $_SESSION['type']=""; 
		 $_SESSION['filter']=""; 
		 $_SESSION['from_date']="";  
		 $_SESSION['to_date']="";  
	  exit;
					
		
			}
			else
			{
				if($filter==1)
				{
				echo $sql="SELECT * FROM kp_export_application_master where PROCES_CNTR=$location and ATTACH_DOWNLOAD_STATUS=0";
 			//exit;
				}
				else
				{
				echo $sql="SELECT * FROM kp_export_application_master where PROCES_CNTR=$location and ATTACH_DOWNLOAD_STATUS=1 and EXP_APP_DATE>='$from_date 00:00:00' and EXP_APP_DATE<='$to_date 23:59:00'";
 
				}
				
						function zipFilesAndDownload($file_names,$archive_file_name,$file_path)
						{
							$zip = new ZipArchive();
							//create the file and throw the error if unsuccessful
							if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
								exit("cannot open <$archive_file_name>\n");
							}
							//add each files of $file_name array to archive
							foreach($file_names as $files)
							{	
								
										if(file_exists($file_path.$files))
										{
								  		//$zip->addFile($file_path.$files,$files);
								  		$zip->addFromString(basename($file_path.$files),file_get_contents($file_path.$files));
										 //echo $file_path.$files,$files."<br>";
										 }
									
							}
							//exit;
							$zip->close();
							//then send the headers to foce download the zip file
							header("Content-type: application/zip"); 
							header("Content-Disposition: attachment; filename=$archive_file_name"); 
							header("Pragma: no-cache"); 
							header("Expires: 0"); 
							readfile("$archive_file_name");
							exit;
						}
						
						$file_names = array();
				
				
 			$result=mysql_query($sql);
			while($row=mysql_fetch_array($result))
			{
				$app_id=$row['EXPORT_APP_ID'];
				$sql_update="update kp_export_application_master set ATTACH_DOWNLOAD_STATUS=1 where EXPORT_APP_ID=$app_id";
				mysql_query($sql_update);
				$sql_attach="select * from kp_export_attachment_master where EXPORT_APP_ID=$app_id";
				$result_attach=mysql_query($sql_attach);
				while($row_attach=mysql_fetch_array($result_attach))
				{
					$file_names[]= $row_attach['ATTACHMENT_PATH'];
					/*echo "<pre>";
					print_r($row_attach);
					echo "</pre>";*/
					
					
				}
			}	
				//exit;		//Archive name
				$archive_file_name='Attach'.date('ymd').'.zip';
				
				//Download Files path
				$file_path='../export_attachment/';
				
				//cal the function
				zipFilesAndDownload($file_names,$archive_file_name,$file_path);
						
				
				unset($_SESSION['location']); 
				unset($_SESSION['type']); 
				unset($_SESSION['filter']); 
				unset($_SESSION['from_date']);  
				unset($_SESSION['to_date']);  
			}	
		
		
		}
		
?>