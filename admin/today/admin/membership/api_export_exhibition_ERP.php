<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');

function getIec($id)
{
	$query_sel = "SELECT iec_no FROM `information_master` WHERE `registration_id`='$id'";
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['iec_no'];
	}
}

if(!empty($_POST))  
{	//echo "><pre>"; print_r($_POST);exit;
	
	$registration_id = trim($_POST['registration_id']);
	$iec = getIec($registration_id); 
/*	if(!empty($iec))
	{ */
	
	$apiurl="http://api.mykycbank.com/Service.svc/44402aeb2e5c4eef8a7100f048b97d84/iec/".$iec;
	$getResponse = file_get_contents($apiurl);
	$getResult = json_decode($getResponse,true);
	$apiResponse = json_decode($getResult,true);
	//echo "<pre>"; print_r($apiResponse);
	$status = $apiResponse['status'];
	$Message = $apiResponse['Message'];
	$KycProfileId = $apiResponse['KycProfileId'];
	$BPId = $apiResponse['BPId'];
		
	/*if(!empty($BPId)){ */
		
	$soapRenewalUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_Exhibition:CC_Exhibition_Sender"; // Exhibition URL of WSDL
	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password
	
	$show = "IIJS Signature 2019";
	
	/* Start Sales Order */
	$bpinfo = "SELECT c_bp_number,city FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2' limit 1";
	$bpInfoResult = mysql_query($bpinfo);
	$bpRows = mysql_fetch_array($bpInfoResult);
	$p_bp_number = trim($bpRows['c_bp_number']); /* Pass Parent BP Number From communication_address_master Table*/
	$city = trim($bpRows['city']); 
	$Date = date('Ymd');
	
	$query="select a.id,a.uid,a.company_name,a.contact_person,a.region,a.created_date,b.last_yr_participant,
	b.section,b.selected_area,b.selected_premium_type,b.options,c.cheque_dd_no,c.cheque_tds_gross_amount,c.payment_status,c.document_status,c.application_status 
	from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid
	where a.event_for='$show' and a.uid='".$registration_id."' ";

	$getChallanResult = mysql_query($query);
	$challanResult = mysql_fetch_array($getChallanResult);
	$total_amount = $challanResult['cheque_tds_gross_amount'];
	$renewDate = date("Ymd", strtotime($challanResult['post_date']));
	$cheque_no = $challanResult['cheque_dd_no'];
	$region = $challanResult['region'];
	$Date = date('Ymd');
	$cur_year = (int)date('Y'); // Current Year
	$next_year  = $cur_year+1;
	$next_finyr = $next_year."0331"; // Next Financial year
	
	$xml_exhibition_string = '<?xml version="1.0" encoding="utf-8"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="http://gjepcexhibition.com">
    <soapenv:Header/>
    <soapenv:Body>
      <gjep:MT_Exhibition_IN>
        <SOAD_Header>
            <Sales_Doc>ZEVT</Sales_Doc>
            <SOrg>1000</SOrg>
            <Dis_channel>30</Dis_channel>
            <Division>10</Division>
            <sold_cust>'.$p_bp_number.'</sold_cust>
            <ship_cust>'.$p_bp_number.'</ship_cust>
            <po_ref>'.$cheque_no.'</po_ref>
            <Pay_term>0001</Pay_term>
            <order_Reason>111</order_Reason>
            <Incoterms>CFR</Incoterms>
            <Incoterm_Loc>'.$city.'</Incoterm_Loc>
        </SOAD_Header>
        <SOAD_Item>
            <Item>0010</Item>
            <Material>2000021</Material>
            <Order_Qty>1</Order_Qty>
            <Plant>'.$region.'</Plant>
            <Item_Category>TAN</Item_Category>
            <cond1_Lebel>ZSTL</cond1_Lebel>
            <Cond1_Val>5000</Cond1_Val>
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
            <WBS>DE-007</WBS>
            <Incoterms>CFR</Incoterms>
            <Incoterms_Loc>'.$city.'</Incoterms_Loc>
            <Net_weight>1</Net_weight>
            <Gross_Weight>1</Gross_Weight>
         </SOAD_Item>
         <SOAD_Advance>
            <Doc_date>'.$Date.'</Doc_date>
            <Posting_date>'.$Date.'</Posting_date>
            <Company_code>1000</Company_code>
            <Currency>INR</Currency>
            <Account>'.$p_bp_number.'</Account>
            <Sp_gl_indicator>A</Sp_gl_indicator>
            <Doc_text>SK</Doc_text>
            <Bank_Acc_No>255029</Bank_Acc_No>
            <Bus_area>1000</Bus_area>
            <Amount>'.$total_amount.'</Amount>
            <Profit_centre>'.$region.'</Profit_centre>
            <Assignment></Assignment>
            <Sales_Doc></Sales_Doc>
            <Line_item>10</Line_item>
         </SOAD_Advance>
      </gjep:MT_Exhibition_IN>
   </soapenv:Body>
</soapenv:Envelope>';
				
/*	header ("Content-Type:text/xml");
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
			//echo $response;
            if(curl_errno($ch1))
				print curl_error($ch1);
			else
				curl_close($ch1);

			// print to get response print_r($response);
			var_dump($respons); exit;			
	/*}
	        
	}  else {  echo "IEC No. Not Found"; } exit; */
	
}	
?>