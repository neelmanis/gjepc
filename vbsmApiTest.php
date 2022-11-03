<?php 

    //$soapRenewalUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_Exhibition:CC_Exhibition_Sender"; // Developement
    $soapRenewalUrl = "https://webdisp.gjepcindia.com:50201/XISOAPAdapter/MessageServlet?channel=:BC_Exhibition:CC_Exhibition_Sender"; // Quality

	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password


	$xml_exhibition_string = '<?xml version="1.0" encoding="utf-8"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="http://gjepcexhibition.com">
    <soapenv:Header/>
    <soapenv:Body>
      <gjep:MT_Exhibition_IN>
        <SOAD_Header>
            <Sales_Doc>ZEVT</Sales_Doc>
            <SOrg>1000</SOrg>
            <Dis_channel>30</Dis_channel>
	        <Division>20</Division>
            <sold_cust>7000036703</sold_cust>
            <ship_cust>7000036703</ship_cust>
            <po_ref>GGDG45554878</po_ref>
            <Pay_term>0001</Pay_term>
            <order_Reason>113</order_Reason>
            <Incoterms>CFR</Incoterms>
            <Incoterm_Loc>Mumbai</Incoterm_Loc>
         	<Event_Type>D</Event_Type>
        </SOAD_Header>
        <SOAD_Item>
            <Item>0010</Item>
            <Material>4000007000</Material>
	        <Order_Qty>1</Order_Qty>
            <Plant>1110</Plant>
            <Item_Category>ZTAD</Item_Category>
            <cond1_Lebel>ZREG</cond1_Lebel>
	        <Cond1_Val></Cond1_Val>
            <Cond2_Lebel></Cond2_Lebel>
            <Cond2_Val></Cond2_Val>			
            <Cond3_Lebel></Cond3_Lebel>
            <Cond3_val></Cond3_val>			
            <Cond4_Lebel></Cond4_Lebel>
            <Cond4_Val></Cond4_Val>
            <Cond5_Lebel></Cond5_Lebel>
            <Cond5_Val></Cond5_Val>
            <Cond6_Lebel></Cond6_Lebel>
            <Cond6_Val></Cond6_Val>
            <Batch></Batch>
            <WBS>DE-043</WBS>
            <Incoterms>CFR</Incoterms>
            <Incoterms_Loc>Mumbai</Incoterms_Loc>
            <Net_weight>1</Net_weight>
            <Gross_Weight>1</Gross_Weight>
        </SOAD_Item>
     	<SOAD_Advance>
            <Doc_date>20210408</Doc_date>
            <Posting_date>20210421</Posting_date>
            <Company_code>1000</Company_code>
            <Currency>INR</Currency>
            <WBS>DE-043</WBS>
            <Account>7000036703</Account>
            <Sp_gl_indicator>A</Sp_gl_indicator>
            <Doc_text>SK</Doc_text>
            <Bank_Acc_No>255301</Bank_Acc_No>
            <Bus_area>1112</Bus_area>
            <Amount>50000</Amount>
            <Profit_centre>1110</Profit_centre>
            <Assignment></Assignment>
            <Sales_Doc></Sales_Doc>
            <Line_item>10</Line_item>
        </SOAD_Advance>
          </gjep:MT_Exhibition_IN>
            </soapenv:Body>
          </soapenv:Envelope>';
		// header ("Content-Type:text/xml");
		// echo $xml_exhibition_string; exit; 
	
	$headers1 = array(
        "Content-type: text/xml;charset=\"utf-8\"",
        "Accept: text/xml",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
        //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
        "Content-length: ".strlen($xml_exhibition_string),
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
    curl_setopt($ch1, CURLOPT_POSTFIELDS, $xml_exhibition_string); // the SOAP request
    curl_setopt($ch1, CURLOPT_HTTPHEADER, $headers1);
    // converting
    $respons = curl_exec($ch1); 
	// $respons; 
    if(curl_errno($ch1))
		print curl_error($ch1);
	else
		curl_close($ch1);
	// print to get response print_r($response);
	var_dump($respons); exit;			
	$xmlstr="<?xml version='1.0' encoding='UTF-8'?>".$respons; 
    print_r($xmstr);exit;  

    ?>