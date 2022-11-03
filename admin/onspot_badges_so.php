<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
/*ini_set('display_errors', 1); 
error_reporting(E_ALL); */
include('../db.inc.php');
session_start();
$adminID=$_SESSION['curruser_login_id'];
//echo '<pre>'; print_r($_SESSION); exit;

function getSap_material_no($event)
{
	$query_sel = "SELECT sap_material_no FROM visitor_sap_material_master where event='$event' AND status='1'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['sap_material_no'];
	}
}

function getVisitorBPNo($id)
{
	$query_sel = "SELECT `bp_number` FROM `visitor_directory` WHERE `visitor_id` ='$id'";
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['bp_number'];
	}
}

function getBillingBPNO($id)
{
	$query_sel = "SELECT c_bp_number FROM `communication_address_master` WHERE `id`='$id'";
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['c_bp_number'];
	}
}
//if(true) 
if(!empty($_POST)) 
{	//echo "><pre>"; print_r($_POST);exit;
	
	$registration_id = trim($_POST['registration_id']);
	$order_id = trim($_POST['order_id']);
	$ho_bp_number = trim($_POST['bpno']); 
	
	/*$registration_id = "600869942";
	$order_id = "visOnSpot15";
	$ho_bp_number = "7000020309"; */
	
	
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
	//$ho_bp_number = trim($bpRows['c_bp_number']); /* Pass Parent BP Number From communication_address_master Table*/
	$city = trim($bpRows['city']);
	if(empty($city))  {
		if(empty($addRows['city']))  {	$city = $hocity; } else {$city = $addRows['city']; }
	}
	
	$query="SELECT * FROM `visitor_order_detail` WHERE regId='".$registration_id."' AND orderId='".$order_id."' AND payment_status='Y' AND payment_type='offline'";
	$getChallanResult = mysql_query($query);
	$challanResult = mysql_fetch_array($getChallanResult);

	$amountPaid = $challanResult['total_payable'];
	$txnID = $challanResult['orderId'];
	$txnDate = $challanResult['tpsl_txn_time'];
	$trans_date = str_replace('/', '-', $txnDate);
	$getTxnDate = date("Ymd", strtotime($trans_date));
	
	$payment_mode = $challanResult['payment_mode'];
	
	if($payment_mode=="CARD"){
		$bank_acnt_no = "0255804";
		$gl_indicator = "A";
	} else {
		$bank_acnt_no = "0255805";
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
            <order_Reason>114</order_Reason>
            <Incoterms>CFR</Incoterms>
            <Incoterm_Loc>'.$city.'</Incoterm_Loc>
        </SOAD_Header>';
	
/*.................................. Visitor Loop ........................................*/
	$visitor_query = "SELECT * FROM `visitor_order_history` WHERE `registration_id`= '$registration_id' AND `orderId`='".$order_id."' AND payment_status='Y' AND paymentThrough='offline'";
	$visitor_result = mysql_query($visitor_query);
	$countx = mysql_num_rows($visitor_result);
	$counter = "10";
	if($countx > 0){
	while($visitor_row=mysql_fetch_array($visitor_result)){
	$visitor_id = $visitor_row['visitor_id'];
	$amount = $visitor_row['amount'];
	$event = $visitor_row['payment_made_for'];
	$event_material = getSap_material_no(str_replace(' ', '', $visitor_row['payment_made_for']));
	
	if($visitor_id!=''){
		$visitorBP_id = getVisitorBPNo($visitor_id);
		if($visitorBP_id!=''){ $visitorBP_id = getVisitorBPNo($visitor_id); } else { echo 'N'; exit; }
	}	else { echo 'Visitor not Found'; exit;  }
	//$visitorBP_id = getVisitorBPNo($visitor_id);
	if($amount!=0){
	$xml_exhibition_string .= '
		<SOAD_Item>
            <Item>00'.$counter.'</Item>
            <Material>'.$event_material.'</Material>
            <Order_Qty>1</Order_Qty>
            <Plant>1110</Plant>
            <Item_Category>TAD</Item_Category>
            <WBS>DE-017</WBS>
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
        </SOAD_Item>';
		$counter=$counter+10;
	}
	}
	}
		
	$xml_exhibition_string .= '
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
            <Amount>'.$amountPaid.'</Amount>
            <Profit_centre>1110</Profit_centre>
            <Assignment></Assignment>
            <Sales_Doc></Sales_Doc>
            <Line_item>10</Line_item>
        </SO_Advance>
      </gjep:MT_Visitor_IN>
   </soapenv:Body>
</soapenv:Envelope>';
				
	 /*header ("Content-Type:text/xml");
	echo $xml_exhibition_string; exit;*/ 
	
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
			//echo $respons;exit;
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
						$sqlx = "UPDATE `visitor_order_detail` SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`sales_order_no`='$sales_order_no',`sap_sale_order_create_status`='1' WHERE `regId`='$registration_id' AND payment_type='offline' AND orderId='".$order_id."'";
						$result = mysql_query($sqlx);
					}
			}
			echo $flag;	
}
?>