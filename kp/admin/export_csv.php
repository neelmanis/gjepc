<?php
session_start();
ob_start();
?>
<?php include('../db.inc.php');?>
<?php include('../functions.php');?>

<?php
 
 
 if(isset($_REQUEST['Download']) || $_REQUEST['Download']=="Download")
 {
 	if($_REQUEST['action']=="search")
	{
		 $location=$_REQUEST['location_id'];
		 $type=$_REQUEST['doc_type'];
		 $filter=$_REQUEST['filter'];
		$from_date=date("Y-m-d",strtotime($_REQUEST['from_date']));
		$to_date=date("Y-m-d",strtotime($_REQUEST['to_date']));
		if($location!="" || isset($location))
		{
			if($type==1)
			{
				if($filter==1)
				{
				 $sql="SELECT if(ie.FORM_TYPE='I','import','export') as `Application Type`,a.MFCODE as `Agent No`
, a.AGENT_NAME as `Agent Name`
,ie.EXPORT_APP_ID as `Application No`,if(ld.LOOKUP_VALUE_NAME='member',m.MFCODE,nm.MFCODE) as `Applicant Number`,if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_CO_NAME,nm.NON_MEMBER_NAME) as `Applicant name`,if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_ADDRESS1,nm.ADDRESS1) as `Applicant Address`,if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_ADDRESS2,nm.ADDRESS2) as `Applicant Address2`,if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_ADDRESS3,nm.ADDRESS3) as `Applicant Address3`,if(ld.LOOKUP_VALUE_NAME='member',m.PINCODE,nm.PINCODE) as `Applicant Post Code`,if(ld.LOOKUP_VALUE_NAME='member',m.CITY,nm.CITY) as `Applicant City`,ie.M_STATE as `Applicant State`,ie.M_COUNTRY as `Applicant Country`,if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_TEL1,nm.TELEPHONE1) as `Applicant Phone No`,if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_TEL2,nm.TELEPHONE2) as `Applicant Phone No2`,if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_FAX1,nm.FAX) as `Applicant Telex No`,if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_CO_EMAIL,nm.EMAIL) as `Applicant Email`,ld.LOOKUP_VALUE_NAME as `Applicant Type`,lc.LOCATION_NAME as `Region Code`,ie.KP_CERT_NO as `Certificate No`,ie.EXP_APP_DATE as `Application Date`,ie.NUMBER_OF_PARCELS as `No Of Parcel`,ie.FEES_AMOUNT as `Certificate Charges`,ie.KP_OTH_CHG as `Other Charges`,ie.TOTAL_AMOUNT as `Total Charges`,pm.CHEQUE_NO as `Cheque No/Bank Trans No`,pm.CHEQUE_DATE as `Cheque Date`,ie.PAYMENT_MODE as `PAYMENT_MODE`,ie.IE_PARTY_ID as `Exporter/Importers No`,ie.IE_PARTY_NAME as `Exporter/Importers Name`,ie.IE_ADDRESS1 as `Exporter/Importers Address`, ie.IE_ADDRESS2 as `Exporter/Importers Address 2`, ie.IE_ADDRESS3 as `Exporter/Importers Address 3`,ie.IE_CITY as `Exporter/Importers City`,ie.IE_COUNTRY as `Exporter/Importers Country`,ie.IE_PIN as `Exporter/Importers Post Code`,c.LCDESC as `Country of Destination`,ie.INVOICE_NO as `Invoice nos`, ie.INVOICE_DATE as `Invoice date`,ie.KP_REMARKS as `Remarks`,if(ld.LOOKUP_VALUE_NAME='member',m.IEC_NO, nm.IEC_NO) as `IEC Code`,pm.PAYEE_BRANCH as `Bank Branch Name`,pm.PAYEE_BANK as `Bank Name`   
FROM
 kp_export_application_master ie left join kp_agent_master a on a.AGENT_ID = ie.AGENT_ID left join  kp_payment_master pm on pm.PAYMENT_MST_ID = ie.KP_PAYMENT_ID left join kp_country_master c on c.LCMINOR = ie.COUNTRY_DEST_ID left join  kp_member_master m on m.MEMBER_ID = ie.MEMBER_ID left join kp_non_member_master nm on nm.NON_MEMBER_ID = ie.NON_MEMBER_ID left join kp_lookup_details ld on ld.LOOKUP_VALUE_ID =ie.MEMBER_TYPE_ID left join kp_location_master lc on lc.LOCATION_ID=ie.PROCES_CNTR where ie.PROCES_CNTR=$location and ie.DOWNLOAD_STATUS=0";
 			//exit;
				}
				else
				{
				 $sql="SELECT if(ie.FORM_TYPE='I','import','export') as `Application Type`,a.MFCODE as `Agent No`
, a.AGENT_NAME as `Agent Name`
,ie.EXPORT_APP_ID as `Application No`,if(ld.LOOKUP_VALUE_NAME='member',m.MFCODE,nm.MFCODE) as `Applicant Number`,if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_CO_NAME,nm.NON_MEMBER_NAME) as `Applicant name`,if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_ADDRESS1,nm.ADDRESS1) as `Applicant Address`,if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_ADDRESS2,nm.ADDRESS2) as `Applicant Address2`,if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_ADDRESS3,nm.ADDRESS3) as `Applicant Address3`,if(ld.LOOKUP_VALUE_NAME='member',m.PINCODE,nm.PINCODE) as `Applicant Post Code`,if(ld.LOOKUP_VALUE_NAME='member',m.CITY,nm.CITY) as `Applicant City`,ie.M_STATE as `Applicant State`,ie.M_COUNTRY as `Applicant Country`,if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_TEL1,nm.TELEPHONE1) as `Applicant Phone No`,if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_TEL2,nm.TELEPHONE2) as `Applicant Phone No2`,if(ld.LOOKUP_VALUE_NAME='member' ,m.MEMBER_CO_FAX1,nm.FAX) as `Applicant Telex No`,if(ld.LOOKUP_VALUE_NAME='member',m.MEMBER_CO_EMAIL,nm.EMAIL) as `Applicant Email`,ld.LOOKUP_VALUE_NAME as `Applicant Type`,lc.LOCATION_NAME as `Region Code`,ie.KP_CERT_NO as `Certificate No`,ie.EXP_APP_DATE as `Application Date`,ie.NUMBER_OF_PARCELS as `No Of Parcel`,ie.FEES_AMOUNT as `Certificate Charges`,ie.KP_OTH_CHG as `Other Charges`,ie.TOTAL_AMOUNT as `Total Charges`,pm.CHEQUE_NO as `Cheque No/Bank Trans No`,pm.CHEQUE_DATE as `Cheque Date`,ie.PAYMENT_MODE as `PAYMENT_MODE`,ie.IE_PARTY_ID as `Exporter/Importers No`,ie.IE_PARTY_NAME as `Exporter/Importers Name`,ie.IE_ADDRESS1 as `Exporter/Importers Address`, ie.IE_ADDRESS2 as `Exporter/Importers Address 2`, ie.IE_ADDRESS3 as `Exporter/Importers Address 3`,ie.IE_CITY as `Exporter/Importers City`,ie.IE_COUNTRY as `Exporter/Importers Country`,ie.IE_PIN as `Exporter/Importers Post Code`,c.LCDESC as `Country of Destination`,ie.INVOICE_NO as `Invoice nos`, ie.INVOICE_DATE as `Invoice date`,ie.KP_REMARKS as `Remarks`,if(ld.LOOKUP_VALUE_NAME='member',m.IEC_NO, nm.IEC_NO) as `IEC Code`,pm.PAYEE_BRANCH as `Bank Branch Name`,pm.PAYEE_BANK as `Bank Name`   
FROM
 kp_export_application_master ie left join kp_agent_master a on a.AGENT_ID = ie.AGENT_ID left join  kp_payment_master pm on pm.PAYMENT_MST_ID = ie.KP_PAYMENT_ID left join kp_country_master c on c.LCMINOR = ie.COUNTRY_DEST_ID left join  kp_member_master m on m.MEMBER_ID = ie.MEMBER_ID left join kp_non_member_master nm on nm.NON_MEMBER_ID = ie.NON_MEMBER_ID left join kp_lookup_details ld on ld.LOOKUP_VALUE_ID =ie.MEMBER_TYPE_ID left join kp_location_master lc on lc.LOCATION_ID=ie.PROCES_CNTR where ie.PROCES_CNTR=$location and ie.DOWNLOAD_STATUS=1 and EXP_APP_DATE>='$from_date' and EXP_APP_DATE<='$to_date'";
 
				}
				
				$output="";
 			$result=mysql_query($sql);
 /*while($row=mysql_fetch_array($result))
 {
 	echo "<pre>";
 	print_r($row);
	echo "</pre>";
 }
 exit;*/
 $columns_total = mysql_num_fields($result);

// Get The Field Name

for ($i = 0; $i < $columns_total; $i++) {
	$heading	=	mysql_field_name($result, $i);
	$output		.= '"'.$heading.'",';
}
$output .="\n";

// Get Records from the table

while ($row = mysql_fetch_array($result)) {
			 $app_id=$row['Application No'];
			 /*$up_sql="update kp_export_application_master set DOWNLOAD_STATUS=1 where EXPORT_APP_ID=$app_id";
			
			$up_result=mysql_query($up_sql);*/
			
for ($i = 0; $i < $columns_total; $i++) {
$output .='"'.$row["$i"].'",';
}
$output .="\n";

				


}

// Download the file
$filename = "New_ERP_".date('d_m_Y').".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);


echo $output;


			
			}
			else
			{
				if($filter==1)
				{
					
					
				}
				else
				{
					
					
				}
			}	
		
		
		
		
		
		
		}
		
	}
 }
 
 if(isset($_REQUEST['hs_Download'])|| $_REQUEST['hs_Download']=="Download_HS" )
 {
		 if($_REQUEST['action']=="search")
	{
		 $location=$_REQUEST['location_id'];
		 $type=$_REQUEST['doc_type'];
		 $filter=$_REQUEST['filter'];
		$from_date=date("Y-m-d",strtotime($_REQUEST['from_date']));
		$to_date=date("Y-m-d",strtotime($_REQUEST['to_date']));
		if($location!="" || isset($location))
		{
			if($type==1)
			{
				if($filter==1)
				{
				 $sql="SELECT * FROM kp_export_application_master where PROCES_CNTR=$location and DOWNLOAD_STATUS=0";
 			//exit;
				}
				else
				{
				 $sql="SELECT * FROM kp_export_application_master where PROCES_CNTR=$location and DOWNLOAD_STATUS=1 and EXP_APP_DATE>='$from_date' and EXP_APP_DATE<='$to_date'";
 
				}
				
				$output_hs="";
 			$result=mysql_query($sql);
 
 //$columns_total_hs = mysql_num_fields($result_hs);

// Get The Field Name

/*for ($i = 0; $i < $columns_total; $i++) {
	$heading	=	mysql_field_name($result, $i);
	$output		.= '"'.$heading.'",';
}
$output .="\n";*/

// Get Records from the table
	$output1="";
			$output1		.= "Application Type,Application No,HS Code,Carat Weight,Value in USD,Country of origin";
			$output1 .="\n";
	while ($row = mysql_fetch_array($result)) {
			
			/*echo "<pre>";
		print_r($row);
		echo "</pre>";
		exit;*/
			$app_id=$row['EXPORT_APP_ID'];
			 $up_sql="update kp_export_application_master set DOWNLOAD_STATUS=1 where EXPORT_APP_ID=$app_id";
			$up_result=mysql_query($up_sql);
			
			 $sql_hs="select if(ie.FORM_TYPE='I','Import','Export') as `Application Type`,tr.EXPORT_APP_ID as `Application No`,hs.HS_CODE as `HS Code`,tr.WEIGHT as `Carat Weight`,tr.AMOUNT as `Value in USD`,c.LCDESC as `Country of Origin` from kp_expimp_tran_detail tr left join kp_hs_code_master hs on tr.HS_CODE_ID=hs.LOOKUP_VALUE_ID left join kp_country_master c on tr.COUNTRY_ID=c.LCMINOR left join kp_export_application_master ie on tr.EXPORT_APP_ID=ie.EXPORT_APP_ID where tr.EXPORT_APP_ID=$app_id";
			
				
 			$result_hs=mysql_query($sql_hs);
 
 		$columns_total1 = mysql_num_fields($result_hs);
			
			$cnt_hs=mysql_num_rows($result_hs);
		
		if($cnt_hs>0)
		{
		$row_hs = mysql_fetch_array($result_hs);
		/*echo "<pre>";
		print_r($row_hs);
		echo "</pre>";*/
		
		for ($j = 0; $j < $columns_total1; $j++) {
		$output1 .='"'.$row_hs["$j"].'",';
		}
		$output1 .="\n";
		}
				
//echo $output1;

}

 //Download the file
$filename = "New_ERP_HS_".date('d_m_Y').".csv";
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);


echo $output1;



			}
			}
			}
 }

?>