<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');

session_start();
$adminID=$_SESSION['curruser_login_id'];

if(true)  
{ 
	$soapSalesUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_Exhibition:CC_Exhibition_Sender"; 
	
	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password

	$xml_sales_order_string = '<?xml version="1.0" encoding="utf-8"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="http://gjepcexhibition.com">
    <soapenv:Header/>
    <soapenv:Body>
      <gjep:MT_Exhibition_IN>
    <SOAD_Header>
          <Sales_Doc>ZEVT</Sales_Doc>
          <SOrg>1000</SOrg>
          <Dis_channel>30</Dis_channel>
          <Division>10</Division>
          <sold_cust>6000000</sold_cust>
          <ship_cust>6000000</ship_cust>
          <po_ref>ADITYA123TEST</po_ref>
          <Pay_term>0001</Pay_term>
          <order_Reason>113</order_Reason>
          <Incoterms>CFR</Incoterms>
          <Incoterm_Loc>MUMBAI</Incoterm_Loc>
          <Event_Type>I</Event_Type>
    </SOAD_Header>
    <SOAD_Item>
          <Item>0010</Item>
          <Material>1000189</Material>
          <Order_Qty>1</Order_Qty>
          <Plant>1110</Plant>
          <Item_Category>TAN</Item_Category>
          <cond1_Lebel>ZADV</cond1_Lebel>
          <Cond1_Val>100000</Cond1_Val>
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
          <WBS>IE-011</WBS>
          <Incoterms>CFR</Incoterms>
          <Incoterms_Loc>MUMBAI</Incoterms_Loc>
          <Net_weight>1</Net_weight>
          <Gross_Weight>1</Gross_Weight>
 </SOAD_Item>
 <SOAD_Advance>
          <Doc_date>20191217</Doc_date> 
          <Posting_date>20191217</Posting_date>
          <Company_code>1000</Company_code>
		  <WBS>IE-011</WBS>
          <Currency>INR</Currency>
          <Account>6000000</Account>
          <Sp_gl_indicator>A</Sp_gl_indicator>
          <Doc_text>TEST</Doc_text>
          <Bank_Acc_No>255301</Bank_Acc_No>
          <Bus_area>1112</Bus_area>
          <Amount>1000.45</Amount>
          <Profit_centre>1110</Profit_centre>
          <Assignment>3300000179</Assignment>
          <Sales_Doc>3300000179</Sales_Doc>
          <Line_item>10</Line_item>
 </SOAD_Advance>
          </gjep:MT_Exhibition_IN>
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
		echo $response; exit;
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
					
				}
		}
		echo $flag;
 }	
?>