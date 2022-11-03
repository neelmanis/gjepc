<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');

if(!empty($_POST))  
{ 	//echo "><pre>"; print_r($_POST);exit;
	$iec = trim($_POST['iec']);
	$registration_id = trim($_POST['registration_id']);
	
	$apiurl="http://api.mykycbank.com/Service.svc/44402aeb2e5c4eef8a7100f048b97d84/iec/".$iec;
	$getResponse = file_get_contents($apiurl);
	$getResult = json_decode($getResponse,true);
	$apiResponse = json_decode($getResult,true);
	//echo "<pre>"; print_r($apiResponse);
	$status = $apiResponse['status'];
	$Message = $apiResponse['Message'];
	$KycProfileId = $apiResponse['KycProfileId'];
	$BPId = $apiResponse['BPId'];
		
	if(!empty($BPId))
	{
		$soapRenewalUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_RENEW:CC_RENEW_BP"; // Renew URL of WSDL
		$soapUser = "pi_admin";  //  username
		$soapPassword = "Deloitte@123"; // password
	
	$query="select * from challan_master where registration_id='$registration_id' and challan_financial_year='2018'";
	$getChallanResult = mysql_query($query);
	$challanResult = mysql_fetch_array($getChallanResult);
	$export_total = $challanResult['export_total'];
	$import_total = $challanResult['import_total'];
	$export_fob_value = $challanResult['export_fob_value'];
	$import_cif_value = $challanResult['import_cif_value'];
	$challan_region = $challanResult['challan_region_name'];
	$total_payable = $challanResult['total_payable'];
	$admission_fees = $challanResult['admission_fees'];
	$renewDate = date("Ymd", strtotime($challanResult['post_date']));
	$gjepc_account_no = $challanResult['gjepc_account_no'];
	$cheque_no = $challanResult['cheque_no'];
	$Date = date('Ymd');
	$cur_year = (int)date('Y'); // Current Year
	$next_year  = $cur_year+1;
	$next_finyr = $next_year."0331"; // Next Financial year
	
	$xml_renewal_string = '<?xml version="1.0" encoding="utf-8"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="https://gjepcrenew.com">
    <soapenv:Header/>
    <soapenv:Body>
      <gjep:MT_RENEW_IN>
         <renew_header>
            <BP_No>6000000</BP_No>
            <Role_name>ZASSOC</Role_name>
            <Start_date>'.$Date.'</Start_date>
            <End_Date>'.$next_finyr.'</End_Date>
            <Year>'.$cur_year.'</Year>
            <LOB>SK</LOB>
            <Export_val>'.$export_total.'</Export_val>
            <Import_val>'.$import_total.'</Import_val>
            <Avg_export>'.$export_fob_value.'</Avg_export>
            <Avg_import>'.$import_cif_value.'</Avg_import>
            <Renew_date>'.$renewDate.'</Renew_date>
         </renew_header>
         <SOAD_Header>
            <Sales_Doc>ZMEM</Sales_Doc>
            <SOrg>1000</SOrg>
            <Dis_channel>10</Dis_channel>
            <Division>20</Division>
            <sold_cust>6000000</sold_cust>
            <ship_cust>6000000</ship_cust>
            <po_ref>'.$cheque_no.'</po_ref>
            <Pay_term>0001</Pay_term>
            <order_Reason>106</order_Reason>
            <Incoterms>CFR</Incoterms>
            <Incoterm_Loc>Mumbai</Incoterm_Loc>
         </SOAD_Header>
         <SOAD_Item>
            <Item>000010</Item>
            <Material>1000000</Material>
            <Order_Qty>1</Order_Qty>
            <Plant>1010</Plant>
            <Item_Category>TAD</Item_Category>
            <cond1_Lebel>ZMEM</cond1_Lebel>			
			<Cond1_Val>'.$total_payable.'</Cond1_Val>
			<Cond2_Lebel>ZADM</Cond2_Lebel>
			<Cond2_Val>'.$admission_fees.'</Cond2_Val>
            <Cond3_Lebel></Cond3_Lebel>
            <Cond3_val></Cond3_val>
            <Cond4_Lebel></Cond4_Lebel>
            <Cond4_Val></Cond4_Val>
            <Incoterms>CFR</Incoterms>
            <Incoterms_Loc>Mumbai</Incoterms_Loc>
         </SOAD_Item>          
         <SOAD_Advance>
            <Doc_date>'.$Date.'</Doc_date>
            <Posting_date>'.$Date.'</Posting_date>
            <Company_code>1000</Company_code>
            <Currency>INR</Currency>
            <Account>6000000</Account>
            <Sp_gl_indicator>A</Sp_gl_indicator>
            <Doc_text>AK</Doc_text>
            <Bank_Acc_No>255029</Bank_Acc_No>
            <Bus_area>1000</Bus_area>
            <Amount>'.$total_payable.'</Amount>
            <Profit_centre>1010</Profit_centre>
            <Assignment></Assignment>
            <Sales_Doc></Sales_Doc>
            <Line_item>10</Line_item>
         </SOAD_Advance>
      </gjep:MT_RENEW_IN>
   </soapenv:Body>
</soapenv:Envelope>';
				
/*	header ("Content-Type:text/xml");
	echo $xml_renewal_string; exit; */
	
			$headers1 = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
                        "Content-length: ".strlen($xml_renewal_string),
                    ); //SOAPAction: your op URL

            $urls = $soapRenewalUrl;

            // PHP cURL  for https connection with auth
            $ch1 = curl_init();
            curl_setopt($ch1, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch1, CURLOPT_URL, $urls);
            curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch1, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch1, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
           // curl_setopt($ch1, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch1, CURLOPT_POST, true);
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $xml_renewal_string); // the SOAP request
            curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);

            // converting
            $respons = curl_exec($ch1); 
			//echo $response;
            if(curl_errno($ch1))
				print curl_error($ch1);
			else
				curl_close($ch1);

			// print to get response print_r($response);
			var_dump($respons); exit;		
			echo "UPDATE API"; exit;
	} else {
            echo "Not found";
	}	
}	
?>