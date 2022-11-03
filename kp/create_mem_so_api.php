<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');

session_start();
$adminID=$_SESSION['curruser_login_id'];

if(!empty($_POST))  
{ //echo "><pre>"; print_r($_POST);exit;

	$bpno = trim($_POST['bpno']);
	$registration_id = trim($_POST['registration_id']);
	$renew_check = trim($_POST['renew_check']);
	
	$financial_year = 2019;
	
	if($renew_check=='N') // New Member 
	{
	$soapSalesUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_SOAD_PRD:CC_SOAD_Sender"; // Live
	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password
	
	/*function getRegionGLAccNo($region_id)
	{
	$query_sel = "SELECT region_gl_acct_no FROM region_master where region_name='$region_id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
		{	
				if($region_id=="HO-MUM (M)")
				{
					return $row['region_gl_acct_no'];
				}
				else if($region_id=="RO-DEL")
				{
					return $row['region_gl_acct_no'];
				} 
				else if($region_id=="RO-CHE")
				{
					return $row['region_gl_acct_no'];
				}
				else if($region_id=="RO-KOL")
				{
					return $row['region_gl_acct_no'];
				}
				else if($region_id=="RO-SRT")
				{
					return $row['region_gl_acct_no'];
				}
				else if($region_id=="RO-JAI")
				{
					return $row['region_gl_acct_no'];
				}
		}
	} */
	
	$info = "SELECT * FROM `information_master` WHERE `registration_id` = '$registration_id'";
	$infoResult = mysql_query($info);
	$rows = mysql_fetch_array($infoResult);
	if($rows['region_id']=='HO-MUM (M)'){ $region=1010;}
	if($rows['region_id']=='RO-JAI'){ $region=1020;}
	if($rows['region_id']=='RO-SRT'){ $region=1030;}
	if($rows['region_id']=='RO-CHE'){ $region=1040;}
	if($rows['region_id']=='RO-DEL'){ $region=1050;}
	if($rows['region_id']=='RO-KOL'){ $region=1060;}
	
	//$gjepc_gl_account_no = getRegionGLAccNo($rows['region_id']);
	if($rows['region_id']=='HO-MUM (M)'){ $businessArea = 1013; } else { $businessArea = 1000; }
	
	$result1 = mysql_query("SELECT export_fob_value,import_cif_value,ReferenceNo,sap_push_date,challan_region_name,total_payable,admission_fees,gjepc_account_no,membership_fees,Transaction_Date FROM `challan_master` WHERE `challan_financial_year`='$financial_year' and registration_id='$registration_id'");
	$row1=mysql_fetch_array($result1);
	$reference_no = $row1['ReferenceNo'];
	$sap_push_date = $row1['sap_push_date'];
	$sapPostDate = date("Ymd", strtotime($sap_push_date));
	$gettransaction_Date = $row1['Transaction_Date'];
	$trans_date = str_replace('/', '-', $gettransaction_Date);
	$transaction_date = date("Ymd", strtotime($trans_date));
	$challan_region = $row1['challan_region_name'];
	$total_payable = $row1['total_payable'];
	$admission_fees = $row1['admission_fees'];
	$membership_fees = $row1['membership_fees'];
	$gjepc_account_no = $row1['gjepc_account_no'];
	
	/* Start Sales Order */
	$bpinfo = "SELECT c_bp_number,city FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2'";
	$bpInfoResult = mysql_query($bpinfo);
	$bpRows = mysql_fetch_array($bpInfoResult);
	$p_bp_number = trim($bpRows['c_bp_number']); /* Pass Parent BP Number From communication_address_master Table*/
	$city = trim($bpRows['city']);
	$Date = date('Ymd');

	$xml_sales_order_string = '<?xml version="1.0" encoding="utf-8"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="http://gjepcsoad.com">
	<soapenv:Header/>
	<soapenv:Body>
	<gjep:MT_SOAD_IN>
	<SOAD_Header>
		<Sales_Doc>ZMEM</Sales_Doc>
		<SOrg>1000</SOrg>
		<Dis_channel>10</Dis_channel>
		<Division>20</Division>
		<sold_cust>'.$p_bp_number.'</sold_cust>
		<ship_cust>'.$p_bp_number.'</ship_cust>
		<po_ref>'.$reference_no.'</po_ref>
		<Pay_term>0001</Pay_term>
		<order_Reason>106</order_Reason>
		<Incoterms>CFR</Incoterms>
		<Incoterm_Loc>'.$city.'</Incoterm_Loc>
	</SOAD_Header>
	<SOAD_Item>
		<Item>000010</Item>
		<Material>5000000000</Material>
		<Order_Qty>1</Order_Qty>
		<Plant>'.$region.'</Plant>
		<Item_Category>TAD</Item_Category>
		<cond1_Lebel>ZMEM</cond1_Lebel>
		<Cond1_Val>'.$membership_fees.'</Cond1_Val>
		<Cond2_Lebel>ZADM</Cond2_Lebel>
		<Cond2_Val>'.$admission_fees.'</Cond2_Val>
		<Incoterms>CFR</Incoterms>
		<Incoterms_Loc>'.$city.'</Incoterms_Loc>
	</SOAD_Item>
	<SO_Advance>
		<Doc_date>'.$transaction_date.'</Doc_date>
		<Posting_date>'.$transaction_date.'</Posting_date>
		<Company_code>1000</Company_code>
		<Currency>INR</Currency>
		<Account>'.$p_bp_number.'</Account>
		<Sp_gl_indicator>A</Sp_gl_indicator>
		<Doc_text>SK</Doc_text>
		<Bank_Acc_No>255251</Bank_Acc_No>
		<Bus_area>'.$businessArea.'</Bus_area>
		<Amount>'.$total_payable.'</Amount>
		<Profit_centre>'.$region.'</Profit_centre>
		<Assignment></Assignment>
		<Sales_Doc></Sales_Doc>
		<Line_item>10</Line_item>
	</SO_Advance>
	</gjep:MT_SOAD_IN>
	</soapenv:Body>
	</soapenv:Envelope>';
				
/*	header ("Content-Type:text/xml");
	echo $xml_sales_order_string; exit; */
	
			$headers1 = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
                        "Content-length: ".strlen($xml_sales_order_string),
                    ); //SOAPAction: your op URL

            $urls = $soapSalesUrl;

            // PHP cURL  for https connection with auth
            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch1, CURLOPT_URL, $urls);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch1, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch1, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
           // curl_setopt($ch1, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch1, CURLOPT_POST, true);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $xml_sales_order_string); // the SOAP request
            curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);

            // converting
            $response = curl_exec($ch1); 
			//echo $response; exit;
            if(curl_errno($ch1))
				print curl_error($ch1);
			else
				curl_close($ch1);
				
			$xmlstr="<?xml version='1.0' encoding='UTF-8'?>".$response;
			//echo $xmlstr;
			
			$xml = simplexml_load_string($xmlstr, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");
			$xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
			$flag=0;			
			foreach($xml->xpath('//soapenv:Body') as $header)
			{
					$arr = $header->xpath('//msg_val'); // Should output 'something'.
					$leadid = $arr[0];
					$strings = $leadid;
					if(!empty($strings))
					{	$flag=1;
						$sales_order_no=substr($strings, strpos($strings, "@ ")+1,11);
						
						mysql_query("UPDATE `challan_master` SET `sales_order_no`='$sales_order_no' WHERE registration_id='$registration_id' and challan_financial_year='$financial_year'");
						mysql_query("UPDATE `approval_master` SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`sap_sale_order_create_status`='1' WHERE registration_id='$registration_id'");
					}
			}
			echo $flag;
	}
	
	if($renew_check=='Y') // Renewal
	{
		//$soapSalesUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_RENEW:CC_RENEW_BP"; // DEVELOPMENT
		$soapSalesUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_RENEW:CC_RENEW_BP"; // LIVE
		$soapUser = "pi_admin";  //  username
		$soapPassword = "Deloitte@123"; // password
	
	function getroles($id)
	{
		$query_sel = "SELECT role_type FROM type_of_comaddress_master where id='$id'";	
		$result_sel = mysql_query($query_sel);								
		if($row = mysql_fetch_array($result_sel))		 	
		{ 		
			return $row['role_type'];
		}
	}
	
	/*function getRegionGLAccNo($region_id)
	{
	$query_sel = "SELECT region_gl_acct_no FROM region_master where region_name='$region_id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
		{	
				if($region_id=="HO-MUM (M)")
				{
					return $row['region_gl_acct_no'];
				}
				else if($region_id=="RO-DEL")
				{
					return $row['region_gl_acct_no'];
				} 
				else if($region_id=="RO-CHE")
				{
					return $row['region_gl_acct_no'];
				}
				else if($region_id=="RO-KOL")
				{
					return $row['region_gl_acct_no'];
				}
				else if($region_id=="RO-SRT")
				{
					return $row['region_gl_acct_no'];
				}
				else if($region_id=="RO-JAI")
				{
					return $row['region_gl_acct_no'];
				}
		}
	} */
	
	$info = "SELECT * FROM `information_master` WHERE `registration_id` = '$registration_id'";
	$infoResult = mysql_query($info);
	$rows = mysql_fetch_array($infoResult);
	if($rows['region_id']=='HO-MUM (M)'){ $region=1010;}
	if($rows['region_id']=='RO-JAI'){ $region=1020;}
	if($rows['region_id']=='RO-SRT'){ $region=1030;}
	if($rows['region_id']=='RO-CHE'){ $region=1040;}
	if($rows['region_id']=='RO-DEL'){ $region=1050;}
	if($rows['region_id']=='RO-KOL'){ $region=1060;}
	$iec = $rows['iec_no'];
	
	if($rows['region_id']=='HO-MUM (M)'){ $businessArea = 1013; } else { $businessArea = 1000; }	
	//$gjepc_gl_account_no = getRegionGLAccNo($rows['region_id']);
	
	/*............................Get PAN and GST of HO.............................*/
	$qho=mysql_query("SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2' limit 1");
	$rho = mysql_fetch_array($qho);
	$hopanno=strtoupper($rho['pan_no']);
	$hogstno=strtoupper($rho['gst_no']);
	
	$panelsql="SELECT panel_name FROM `communication_details_master` WHERE 1 and registration_id=$registration_id";
	$panelresult=mysql_query($panelsql);
	$panelrows=mysql_fetch_array($panelresult);
	$panel_name=ucwords(strtoupper($panelrows['panel_name']));
	
	/* Start Sales Order */
	$bpinfo = "SELECT c_bp_number,city,type_of_address FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2'";
	$bpInfoResult = mysql_query($bpinfo);
	$bpRows = mysql_fetch_array($bpInfoResult);
	$BP_roles = getroles($bpRows['type_of_address']); /* Pass Parent BP Number From communication_address_master Table*/
	$p_bp_number = trim($bpRows['c_bp_number']); /* Pass Parent BP Number From communication_address_master Table*/
	$city = trim($bpRows['city']);
	$Date = date('Ymd');
	$cur_year = (int)date('Y'); // Current Year
	$next_year  = $cur_year+1;
	$next_finyr = $next_year."0331"; // Next Financial year 31032018
	
	$xml_sales_order_string = '<?xml version="1.0" encoding="utf-8"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="https://gjepcrenew.com">
   <soapenv:Header/>
   <soapenv:Body>
      <gjep:MT_RENEW_IN>
		<renew_header>
            <BP_No>'.$p_bp_number.'</BP_No>
            <Role_name></Role_name>
            <Start_date></Start_date>
            <End_Date></End_Date>
            <Year>'.$cur_year.'</Year>
            <LOB></LOB>
            <Export_val></Export_val>
            <Import_val></Import_val>
            <Avg_export></Avg_export>
            <Avg_import></Avg_import>
            <Renew_date></Renew_date>
        </renew_header>';
		
	$result = mysql_query("SELECT `export_sales_to_foreign_tourists`, `export_synthetic_stones`, `export_costume_jewellery`, `export_other_precious_metal_jewellery`, `export_pearls`, `export_coloured_gemstones`, `export_gold_jewellery`, `export_studded_gold_jewellery`, `export_silver_jewellery`, `export_studded_silver_jewellery`, `export_rough_diamonds`, `export_cut_polished_diamonds`, `export_other_items`,`import_findings_mountings`, `import_false_pearls`, `import_rough_imitation_stones`, `import_silver`, `import_raw_pearls`, `import_cut_polished_gemstones`, `import_rough_gemstones`, `import_gold`, `import_cut_polished_diamonds`, `import_rough_diamonds`, `import_synthetic_stones`, `import_gold_jewellery`, `import_silver_jewellery`, `import_other_items` FROM `challan_master` WHERE `challan_financial_year`='$financial_year' and registration_id='$registration_id'");
	$row=mysql_fetch_array($result);
	
	$result1 = mysql_query("SELECT export_fob_value,import_cif_value,ReferenceNo,sap_push_date,challan_region_name,total_payable,admission_fees,gjepc_account_no,membership_fees,Transaction_Date FROM `challan_master` WHERE `challan_financial_year`='$financial_year' and registration_id='$registration_id'");
	$row1=mysql_fetch_array($result1);
	$reference_no = $row1['ReferenceNo'];
	$sap_push_date = $row1['sap_push_date'];
	$sapPostDate = date("Ymd", strtotime($sap_push_date));
	
	$gettransaction_Date = $row1['Transaction_Date'];
	$trans_date = str_replace('/', '-', $gettransaction_Date);	
	$transaction_date = date("Ymd", strtotime($trans_date));
	$challan_region = $row1['challan_region_name'];
	$total_payable = $row1['total_payable'];
	$admission_fees = $row1['admission_fees'];
	$membership_fees = $row1['membership_fees'];
	$gjepc_account_no = $row1['gjepc_account_no'];

	$export_fob_value = $row1['export_fob_value'];
	$import_cif_value = $row1['import_cif_value'];
	
		$xml_sales_order_string .= '
		<SOAD_Header>
            <Sales_Doc>ZMEM</Sales_Doc>
            <SOrg>1000</SOrg>
            <Dis_channel>10</Dis_channel>
            <Division>20</Division>
            <sold_cust>'.$p_bp_number.'</sold_cust>
            <ship_cust>'.$p_bp_number.'</ship_cust>
            <po_ref>'.$reference_no.'</po_ref>
            <Pay_term>0001</Pay_term>
            <order_Reason>107</order_Reason>
            <Incoterms>CFR</Incoterms>
			<Incoterm_Loc>'.$city.'</Incoterm_Loc>
         </SOAD_Header>
         <SOAD_Item>
            <Item>000010</Item>
            <Material>5000000010</Material>
            <Order_Qty>1</Order_Qty>
            <Plant>'.$region.'</Plant>
            <Item_Category>TAD</Item_Category>
			<cond1_Lebel>ZMEM</cond1_Lebel>
            <Cond1_Val>'.$membership_fees.'</Cond1_Val>
            <Cond2_Lebel>ZADM</Cond2_Lebel>
            <Cond2_Val>'.$admission_fees.'</Cond2_Val>
            <Cond3_Lebel></Cond3_Lebel>
            <Cond3_val></Cond3_val>
            <Cond4_Lebel></Cond4_Lebel>
            <Cond4_Val></Cond4_Val>
            <Incoterms>CFR</Incoterms>
			<Incoterms_Loc>'.$city.'</Incoterms_Loc>
        </SOAD_Item>
		<SOAD_Advance>
            <Doc_date>'.$transaction_date.'</Doc_date>
			<Posting_date>'.$transaction_date.'</Posting_date>
            <Company_code>1000</Company_code>
			<Currency>INR</Currency>
			<Account>'.$p_bp_number.'</Account>
			<Sp_gl_indicator>A</Sp_gl_indicator>
			<Doc_text>SK</Doc_text>
			<Bank_Acc_No>255251</Bank_Acc_No>
			<Bus_area>'.$businessArea.'</Bus_area>
			<Amount>'.$total_payable.'</Amount>
			<Profit_centre>'.$region.'</Profit_centre>
			<Assignment>'.$reference_no.'</Assignment>
			<Sales_Doc></Sales_Doc>
			<Line_item>10</Line_item>
         </SOAD_Advance>';
	
	$i = 0;
	$flag=0;
while ($i < mysql_num_fields($result)) {
    $meta = mysql_fetch_field($result, $i);
	$field_name=$meta->name;
	$value=$row[$meta->name];
	$item_type=str_split($field_name,6);
	$export_total="";
	$import_total="";
	
	if($value!='0'){
	$flag=1;
	
	if($item_type[0]=="export"){
		$export_total=$value;
	}
	if($item_type[0]=="import"){
		$import_total=$value;
	}	
    
	$xml_sales_order_string .= "
	<BP_Table>
        <WEB_REF></WEB_REF>
		<GSTIN>$hogstno</GSTIN>
		<PAN>$hopanno</PAN>
		<ie_code>$iec</ie_code>
		<PANEL>$panel_name</PANEL>
		<BP_NO>$p_bp_number</BP_NO>
        <ZYEAR>$financial_year</ZYEAR>
        <LOB>$meta->name</LOB>
        <IMPORT_VAL>$import_total</IMPORT_VAL>
		<EXPORT_VAL>$export_total</EXPORT_VAL>
		<AVERAGE_EXPORT>$export_fob_value</AVERAGE_EXPORT>
		<AVERAGE_IMPORT>$import_cif_value</AVERAGE_IMPORT>
        <REGISTRATION_NUMBER></REGISTRATION_NUMBER>
        <REGISTRATION_DATE></REGISTRATION_DATE>
        <REGISTERED></REGISTERED>
        <RENEWAL_DATE></RENEWAL_DATE>
        <MEM_CER_ISSU></MEM_CER_ISSU>
        <REGISTRATION_START_YEAR></REGISTRATION_START_YEAR>
        <REGISTRATION_END_YEAR></REGISTRATION_END_YEAR>
        <MEMBER_ID_CARD_NUMBER></MEMBER_ID_CARD_NUMBER>
        <AWARD_DETAILS></AWARD_DETAILS>
        <ZEVENT_PARTICIPATED></ZEVENT_PARTICIPATED>
        <NAME1_ORG></NAME1_ORG>
        <NAME2_ORG></NAME2_ORG>
        <IMP_EXP_CERTIFICATE></IMP_EXP_CERTIFICATE>
        <ZPART_DEED_DOC></ZPART_DEED_DOC>
        <ZMEMORANDUM_ASSOCIATION></ZMEMORANDUM_ASSOCIATION>
        <DATE_REC_APPLI></DATE_REC_APPLI>
        <ZMYKYC_STATUS></ZMYKYC_STATUS>
        <ZSTAR_GROUP></ZSTAR_GROUP>
        <ZEXTERNAL_BP></ZEXTERNAL_BP>
        <NAME></NAME>
		<CELL_NUMBER></CELL_NUMBER>
		<EMAIL_ADDRESS></EMAIL_ADDRESS>
		<NAME1></NAME1>
		<CELL_NUMBER1></CELL_NUMBER1>
		<EMAIL_ADDRESS1></EMAIL_ADDRESS1>
		<NAME2></NAME2>
		<CELL_NUMBER2></CELL_NUMBER2>
		<EMAIL_ADDRESS2></EMAIL_ADDRESS2>
		<NAME3></NAME3>
		<CELL_NUMBER3></CELL_NUMBER3>
		<EMAIL_ADDRESS3></EMAIL_ADDRESS3>
    </BP_Table>";
		}
		$i++;
		}
		
	if($flag==0){
	$xml_sales_order_string .= "
		<BP_Table>
        <WEB_REF></WEB_REF>
		<GSTIN>$hogstno</GSTIN>
		<PAN>$hopanno</PAN>
		<ie_code>$iec</ie_code>
		<PANEL>$panel_name</PANEL>
		<BP_NO>$p_bp_number</BP_NO>
        <ZYEAR>$financial_year</ZYEAR>
        <LOB>0</LOB>
        <IMPORT_VAL>0</IMPORT_VAL>
		<EXPORT_VAL>0</EXPORT_VAL>
		<AVERAGE_EXPORT>0</AVERAGE_EXPORT>
		<AVERAGE_IMPORT>0</AVERAGE_IMPORT>
        <REGISTRATION_NUMBER></REGISTRATION_NUMBER>
        <REGISTRATION_DATE></REGISTRATION_DATE>
        <REGISTERED></REGISTERED>
        <RENEWAL_DATE></RENEWAL_DATE>
        <MEM_CER_ISSU></MEM_CER_ISSU>
        <REGISTRATION_START_YEAR></REGISTRATION_START_YEAR>
        <REGISTRATION_END_YEAR></REGISTRATION_END_YEAR>
        <MEMBER_ID_CARD_NUMBER></MEMBER_ID_CARD_NUMBER>
        <AWARD_DETAILS></AWARD_DETAILS>
        <ZEVENT_PARTICIPATED></ZEVENT_PARTICIPATED>
        <NAME1_ORG></NAME1_ORG>
        <NAME2_ORG></NAME2_ORG>
        <IMP_EXP_CERTIFICATE></IMP_EXP_CERTIFICATE>
        <ZPART_DEED_DOC></ZPART_DEED_DOC>
        <ZMEMORANDUM_ASSOCIATION></ZMEMORANDUM_ASSOCIATION>
        <DATE_REC_APPLI></DATE_REC_APPLI>
        <ZMYKYC_STATUS></ZMYKYC_STATUS>
        <ZSTAR_GROUP></ZSTAR_GROUP>
        <ZEXTERNAL_BP></ZEXTERNAL_BP>
        <NAME></NAME>
		<CELL_NUMBER></CELL_NUMBER>
		<EMAIL_ADDRESS></EMAIL_ADDRESS>
		<NAME1></NAME1>
		<CELL_NUMBER1></CELL_NUMBER1>
		<EMAIL_ADDRESS1></EMAIL_ADDRESS1>
		<NAME2></NAME2>
		<CELL_NUMBER2></CELL_NUMBER2>
		<EMAIL_ADDRESS2></EMAIL_ADDRESS2>
		<NAME3></NAME3>
		<CELL_NUMBER3></CELL_NUMBER3>
		<EMAIL_ADDRESS3></EMAIL_ADDRESS3>
     </BP_Table>";	
		}
		
     $xml_sales_order_string .= '
	 </gjep:MT_RENEW_IN>
   </soapenv:Body>
</soapenv:Envelope>';
				
	/*header ("Content-Type:text/xml");
	echo $xml_sales_order_string; exit; */
	
			$headers1 = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
                        "Content-length: ".strlen($xml_sales_order_string),
                    ); //SOAPAction: your op URL

            $urls = $soapSalesUrl;

            // PHP cURL  for https connection with auth
            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch1, CURLOPT_URL, $urls);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch1, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch1, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
           // curl_setopt($ch1, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch1, CURLOPT_POST, true);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $xml_sales_order_string); // the SOAP request
            curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);

            // converting
            $response = curl_exec($ch1); 
		//	echo $response; exit;
            if(curl_errno($ch1))
				print curl_error($ch1);
			else
				curl_close($ch1);
				
			$xmlstr="<?xml version='1.0' encoding='UTF-8'?>".$response;
			//echo $xmlstr;
			
			$xml = simplexml_load_string($xmlstr, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");
			$xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
			$flag=0;			
			foreach($xml->xpath('//soapenv:Body') as $header)
			{
					$arr = $header->xpath('//msg_val'); // Should output 'something'.
					$leadid = $arr[0];
					$strings = $leadid;
					if(!empty($strings))
					{	$flag=1;
						$sales_order_no=substr($strings, strpos($strings, "@ ")+1,11);
						mysql_query("UPDATE `challan_master` SET `sales_order_no`='$sales_order_no' WHERE registration_id='$registration_id' and challan_financial_year='$financial_year'");
						mysql_query("UPDATE `approval_master` SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`sap_sale_order_create_status`='1' WHERE registration_id='$registration_id'");
					}
			}
			echo $flag;
	}
}	
?>