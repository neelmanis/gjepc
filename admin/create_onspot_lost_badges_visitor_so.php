<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);

function getSap_material_no($event)
{
	$query_sel = "SELECT sap_material_no FROM visitor_sap_material_master where event='$event' AND status='1'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['sap_material_no'];
	}
}

if(!empty($_POST)) 
{	//echo "<pre>"; print_r($_POST);exit;
	
	$registration_id = trim($_POST['registration_id']);
	$order_id = trim($_POST['order_id']);
	$ho_bp_number = trim($_POST['bpno']); 
	
	if(isset($registration_id) && $registration_id!=""){
		
	$soapRenewalUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_Visitor:CC_Visitor_Sender"; // LIVE
	//$soapRenewalUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_Visitor:CC_Visitor_Sender"; // Development
	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password
	
	/*............................Get CITY PINCODE of HO.............................*/
	$qho=mysql_query("SELECT city,state,pincode FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2' limit 1");
	$rho = mysql_fetch_array($qho);
	$hocity=strtoupper($rho['city']);
	
	$add = "SELECT city FROM `n_m_billing_address` WHERE registration_id='$registration_id'";
	$addResult = mysql_query($add);
	$addRows = mysql_fetch_array($addResult);
	
	/* Start Sales Order */
	$bpinfo = "SELECT * FROM `registration_master` WHERE `id` = '$registration_id' limit 1";
	$bpInfoResult = mysql_query($bpinfo);
	$bpRows = mysql_fetch_array($bpInfoResult);
	$city = trim($bpRows['city']);
	if(empty($city))  {
		if(empty($addRows['city']))  {	$city = strtoupper($hocity); } else { $city = strtoupper($addRows['city']); }
	}
	
	$query="SELECT * FROM `dump_lost_visitor_badge` WHERE company_bp_number='".$ho_bp_number."' AND orderId='".$order_id."'";
	$getChallanResult = mysql_query($query);
	$challanResult = mysql_fetch_array($getChallanResult);
	
	$amount = $challanResult['amount'];
	$payment_mode = $challanResult['payment_mode'];
	$visitorBP_id = trim($challanResult['person_bp_number']);
	$event_material = getSap_material_no(str_replace(' ', '', $challanResult['shows']));
	
	$txnID = $challanResult['orderId'];
	$txnDate = $challanResult['payment_date'];
	$trans_date = str_replace('/', '-', $txnDate);
	$getTxnDate = date("Ymd", strtotime($trans_date));
	//$getTxnDate = 20190211;
	
	if($payment_mode=="CARD"){
		$bank_acnt_no = "255804";
		$gl_indicator = "A";
	} else {
		$bank_acnt_no = "255805";
		$gl_indicator = "K";
	}
	
	$xml_exhibition_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="http://gjepcvisitorreg.com">
    <soapenv:Header/>
    <soapenv:Body>
      <gjep:MT_Visitor_IN>
        <SOAD_Header>
            <Sales_Doc>ZVIS</Sales_Doc>
            <SOrg>1000</SOrg>
            <Dis_channel>30</Dis_channel>
            <Division>20</Division>
            <sold_cust>'.$ho_bp_number.'</sold_cust>
            <ship_cust>'.$ho_bp_number.'</ship_cust>
            <po_ref>'.$txnID.'</po_ref>
            <Pay_term>0001</Pay_term>
            <order_Reason>121</order_Reason>
            <Incoterms>CFR</Incoterms>
            <Incoterm_Loc>'.$city.'</Incoterm_Loc>
        </SOAD_Header>
		<SOAD_Item>
            <Item>0010</Item>
            <Material>'.$event_material.'</Material>
            <Order_Qty>1</Order_Qty>
            <Plant>1110</Plant>
            <Item_Category>TAD</Item_Category>
            <WBS>DE-018</WBS>
			<cond1_Lebel>ZVIS</cond1_Lebel>
            <Cond1_Val>'.$amount.'</Cond1_Val>
            <Cond2_Lebel></Cond2_Lebel>
            <Cond2_Val></Cond2_Val>
            <cond3_Lebel></cond3_Lebel>
            <Cond3_Val></Cond3_Val>
            <cond4_Lebel></cond4_Lebel>
            <Cond4_Val></Cond4_Val>
            <Partner_Fun>'.$visitorBP_id.'</Partner_Fun>
            <Incoterms>CFR</Incoterms>
            <Incoterms_Loc>'.$city.'</Incoterms_Loc>
        </SOAD_Item>
		<SO_Advance>
            <Doc_date>'.$getTxnDate.'</Doc_date>
            <Posting_date>'.$getTxnDate.'</Posting_date>
            <Company_code>1000</Company_code>
            <Currency>INR</Currency>
            <Account>'.$ho_bp_number.'</Account>
            <Sp_gl_indicator>'.$gl_indicator.'</Sp_gl_indicator>
            <Doc_text>'.$order_id.'</Doc_text>
            <Bank_Acc_No>'.$bank_acnt_no.'</Bank_Acc_No>
            <Bus_area>1111</Bus_area>
            <Amount>'.$amount.'</Amount>
            <Profit_centre>1110</Profit_centre>
            <Assignment></Assignment>
            <Sales_Doc></Sales_Doc>
            <Line_item>10</Line_item>
        </SO_Advance>
      </gjep:MT_Visitor_IN>
   </soapenv:Body>
</soapenv:Envelope>';
				
	/*header ("Content-Type:text/xml");
	echo $xml_exhibition_string; exit; */
	
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
			//echo $respons; exit;
			//echo $respons;
            if(curl_errno($ch1))
				print curl_error($ch1);
			else
				curl_close($ch1);

			// print to get response print_r($response);
			//var_dump($respons); exit;			
			$xmlstr="<?xml version='1.0' encoding='UTF-8'?>".$respons;
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
						$sqlx = "UPDATE `dump_lost_visitor_badge` SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`sales_order_no`='$sales_order_no',`sap_sale_order_create_status`='1' WHERE orderId='".$order_id."'";
						$result = mysql_query($sqlx);
					}
			}
			echo $flag;
	}
}
?>