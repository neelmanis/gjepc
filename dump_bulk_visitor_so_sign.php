<?php
date_default_timezone_set('Asia/Calcutta');
error_reporting(0);

$hostname = "192.168.40.107";
$uname = "gjepcliveuserdb";
$pwd = "KGj&6(pcvmLk5";
$database = "gjepclivedatabase";

// Create connection
$conn = new mysqli($hostname, $uname, $pwd, $database);
// Check connection
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getwbs($event,$conn)
{
	$query_sel = "SELECT wbs FROM visitor_event_master where shortcode='$event'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['wbs'];
}

function getBPNO($registration_id,$conn)
{
	$query_sel = "SELECT c_bp_number FROM communication_address_master where registration_id='$registration_id' and type_of_address='2'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	return $row['c_bp_number'];
}

function getCompanyNonMemBPNO($registration_id,$conn)
{
	$sql="SELECT NM_bp_number FROM registration_master where id='$registration_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();	 		
	return $row['NM_bp_number'];
}

function getSap_material_no($event,$conn)
{
	$query_sel = "SELECT material_no FROM visitor_event_master where shortcode='$event'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['material_no'];
}

function getVisitorBPNo($id,$conn)
{
	$query_sel = "SELECT `bp_number` FROM `visitor_directory` WHERE `visitor_id` ='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 	 		
		return $row['bp_number'];
}

function CheckMembership($registration_id,$conn)
{
	$sql="SELECT * FROM `approval_master` WHERE 1 and `registration_id`='".$registration_id."' AND issue_membership_certificate_expire_status='Y'";
	$result = $conn->query($sql);
	$num_rows=  $result->num_rows;
	if($num_rows>0)
	{
		return 'M';
	} else {
		return 'NM';
	}
}

$soapRenewalUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_Visitor:CC_Visitor_Sender"; // LIVE
$soapUser = "pi_admin";  //  username
$soapPassword = "Deloitte@123"; // password
	
//$values = "SELECT * FROM `visitor_order_detail` WHERE 1 AND payment_status='Y' AND year='2023' AND event='signature23' AND payment_type!='free' AND txn_status='0300' AND sap_sale_order_create_status='0' AND sales_order_no='pecify eith' order by tpsl_txn_time asc";  

$values = "SELECT * FROM `visitor_order_detail` WHERE 1 AND payment_status='Y' AND year='2023' AND event='signature23' AND payment_type!='free' AND txn_status='0300' AND sap_sale_order_create_status='0' AND sales_order_no IS NULL order by tpsl_txn_time asc";

//$values = "SELECT * FROM `visitor_order_detail` WHERE 1 AND payment_status='Y' AND year='2022' AND event='iijs22' AND payment_type!='free' AND txn_status='0300' AND sap_sale_order_create_status='0' AND regId='600905790' AND sales_order_no IS NULL limit 1";
$sqlx = $conn ->query($values);
$countx = $sqlx->num_rows;
if($countx > 0) 
{
	while($challanResult = $sqlx->fetch_assoc())
	{
	//echo 	$registration_id = $challanResult['regId']; echo '<br/>';
	 	$registration_id = $challanResult['regId']; 
		$type_of_member  = $challanResult['type_of_member'];
		
		$checkMember = CheckMembership($registration_id,$conn);
		if($checkMember=="M")
		{
			$ho_bp_number = getBPNO($registration_id,$conn);
		} else {
			$ho_bp_number = getBPNO($registration_id,$conn);
			if($ho_bp_number !=''){
			$ho_bp_number = getBPNO($registration_id,$conn);
			} else {
			$ho_bp_number = getCompanyNonMemBPNO($registration_id,$conn);
			}
		}
		
		$order_id = $challanResult['orderId'];
		$amountPaid = $challanResult['total_payable'];
		$txnID = $challanResult['tpsl_txn_id'];
		$txnDate = $challanResult['tpsl_txn_time'];
		$getTxnDate = date("Ymd", strtotime($txnDate));
		
		$bpinfo = "SELECT city FROM `registration_master` WHERE `id` = '$registration_id' limit 1";
		$bpInfoResult = $conn ->query($bpinfo);
		$bpRows = $bpInfoResult->fetch_assoc();
		$city = $bpRows['city'];
			
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
			<Event_Type>D</Event_Type>
        </SOAD_Header>';
	 
	$visitor_query = "SELECT * FROM `visitor_order_history` WHERE `registration_id`= '$registration_id' AND `orderId`='".$order_id."' AND payment_status='Y' AND year='2023' AND `show`='signature23'";

	$visitor_result = $conn ->query($visitor_query);
	$countx = $visitor_result->num_rows;
	$counter = "10";
	if($countx > 0){
	while($visitor_row = $visitor_result->fetch_assoc()){
	$visitor_id = $visitor_row['visitor_id'];
	$amount = $visitor_row['amount'];
	$event = $visitor_row['payment_made_for'];
	$event_material = getSap_material_no($visitor_row['payment_made_for'],$conn);
	$event_wbs = getwbs($visitor_row['payment_made_for'],$conn);
	if($visitor_id!=''){
		$visitorBP_id = getVisitorBPNo($visitor_id,$conn);
		if($visitorBP_id!=''){ $visitorBP_id = getVisitorBPNo($visitor_id,$conn); } else { echo $registration_id.' <br/> N'; exit; }
	}	else { echo 'Visitor not Found'; exit;  }

	if($amount!=0){
	$xml_exhibition_string .= '
		<SOAD_Item>
            <Item>00'.$counter.'</Item>
            <Material>'.$event_material.'</Material>
            <Order_Qty>1</Order_Qty>
            <Plant>1110</Plant>
            <Item_Category>TAD</Item_Category>
            <WBS>'.$event_wbs.'</WBS>
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
			<WBS>'.$event_wbs.'</WBS>
            <Account>'.$ho_bp_number.'</Account>
            <Sp_gl_indicator>K</Sp_gl_indicator>
            <Doc_text>'.$order_id.'</Doc_text>
            <Bank_Acc_No>0255801</Bank_Acc_No>
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
	
	/* header("Content-Type:text/xml");
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
						$sales_order_no = trim(substr($strings, strpos($strings, "@ ")+1,11));
					$sqlx = "UPDATE `visitor_order_detail` SET `sap_push_date`=NOW(),`sap_push_admin`='1',`sales_order_no`='$sales_order_no',`sap_sale_order_create_status`='1',delivery_id='dump' WHERE `regId`='$registration_id' AND orderId='".$order_id."' AND year='2023' AND event='signature23'";
					$result = $conn ->query($sqlx);
					if($result){ header("Location: https://gjepc.org/dump_bulk_visitor_so_sign.php"); }
					}
			}
			echo $flag;
	}
}
?>