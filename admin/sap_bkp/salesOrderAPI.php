<?php
include('../db.inc.php');
	$registration_id = 600856853;
	$soapUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_SOAD:CC_SOAD_Sender"; // asmx URL of WSDL
	$soapUser = "pi_admin";  //  username
    $soapPassword = "Deloitte@123"; // password
	
	$query="select * from challan_master where registration_id='$registration_id' and challan_financial_year='2018'";
	$getChallanResult = mysql_query($query);
	$challanResult = mysql_fetch_array($getChallanResult);
	$export_total = $challanResult['export_total'];
	$import_total = $challanResult['import_total'];
	$export_fob_value = $challanResult['export_fob_value'];
	$import_cif_value = $challanResult['import_cif_value'];
	$cheque_no = $challanResult['cheque_no'];
	$challan_region = $challanResult['challan_region_name'];
	$total_payable = $challanResult['total_payable'];
	$admission_fees = $challanResult['admission_fees'];
	$gjepc_account_no = $challanResult['gjepc_account_no'];
	$Date = date('Ymd');
	
    $xml_post_string = '
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="http://gjepcsoad.com">
	<soapenv:Header/>
	<soapenv:Body>
	<gjep:MT_SOAD_IN>
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
		<Plant>'.$challan_region.'</Plant>
		<Item_Category>TAD</Item_Category>
		<cond1_Lebel>ZMEM</cond1_Lebel>
		<Cond1_Val>'.$total_payable.'</Cond1_Val>
		<Cond2_Lebel>ZADM</Cond2_Lebel>
		<Cond2_Val>'.$admission_fees.'</Cond2_Val>
		<Incoterms>CFR</Incoterms>
		<Incoterms_Loc>Mumbai</Incoterms_Loc>
	</SOAD_Item>
	<SO_Advance>
		<Doc_date>'.$Date.'</Doc_date>
		<Posting_date>'.$Date.'</Posting_date>
		<Company_code>1000</Company_code>
		<Currency>INR</Currency>
		<Account>6000000</Account>
		<Sp_gl_indicator>A</Sp_gl_indicator>
		<Doc_text>SK</Doc_text>
		<Bank_Acc_No>255029</Bank_Acc_No>
		<Bus_area>1000</Bus_area>
		<Amount>'.$total_payable.'</Amount>
		<Profit_centre>1010</Profit_centre>
		<Assignment>?</Assignment>
		<Sales_Doc>?</Sales_Doc>
		<Line_item>10</Line_item>
	</SO_Advance>
		  </gjep:MT_SOAD_IN>
	   </soapenv:Body>
	</soapenv:Envelope>';   // data from the form, e.g. some ID number

/* header ("Content-Type:text/xml");
echo $xml_post_string; exit; */
           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
                        "Content-length: ".strlen($xml_post_string),
                    ); //SOAPAction: your op URL

            $url = $soapUrl;

            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting
            $response = curl_exec($ch); 
			//echo $response;
            if(curl_errno($ch))
				print curl_error($ch);
			else
				curl_close($ch);

			// print to get response print_r($response);
			var_dump($response); exit;
            
?>