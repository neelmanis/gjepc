<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID=$_SESSION['curruser_login_id'];

function getCompanyNonMemBPNO($registration_id,$conn)
{
	$sql="SELECT NM_bp_number FROM registration_master where id='$registration_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();	 		
	return $row['NM_bp_number'];
}

if(!empty($_POST)) 
{
	$lastSalesOrder = trim($_POST['so_number']);
	$registration_id = trim($_POST['registration_id']);
	$utr_no = trim($_POST['utr_no']);
	
	if(isset($registration_id) && $registration_id!=""){
		
	//$soapRenewalUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_PADV_PRD:CC_PADV_PRD"; // Development
	$soapRenewalUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_PADV_PRD:CC_PADV_PRD"; // LIVE
	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password
	
	$show = "IIJS SIGNATURE 2023";
	
	$eventData ="select wbs from exh_event_master where eventDescription='$show' ";
	$eventResult =$conn ->query($eventData);
	$fetch_Eventdata = $eventResult->fetch_assoc();
	 $wbs = $fetch_Eventdata['wbs'];
	
	/* Start Sales Order */
	$query="select a.id,a.uid,a.bp_number,a.billing_address_id,a.company_name,a.contact_person,a.region,a.city,a.country,a.created_date,a.get_billing_bp_number,b.gid,b.last_yr_participant,b.section,b.category,b.selected_area,b.selected_premium_type,b.options,c.cheque_dd_no,c.cheque_tds_gross_amount,c.net_payable_amount,c.payment_status,c.document_status,c.application_status from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid where a.event_for='$show' and a.uid='".$registration_id."' ";
	$getChallanResult =  $conn ->query($query);
	$challanResult = $getChallanResult->fetch_assoc();
	$total_amount = $challanResult['cheque_tds_gross_amount'];
	$net_payable_amount = $challanResult['net_payable_amount'];
	$renewDate = date("Ymd", strtotime($challanResult['post_date']));
	$city = trim($challanResult['city']);
	$country = trim($challanResult['country']);
	$billing_bp = trim($challanResult['get_billing_bp_number']);
	$nonmemberBP = getCompanyNonMemBPNO($registration_id,$conn);
	if($billing_bp==''){ $billing_bp = $nonmemberBP; }
	
	if($country=="IN"){
		$currency="INR";
		$bank_acnt_no="255241";  /*................. Domestic Account ....................*/
	} else {
		$currency="USD";
		$bank_acnt_no="255351"; /*................. International Account ...............*/
	}
	
	/* UTR Data */
	$getUTR = "SELECT * FROM `utr_history` where registration_id='$registration_id' AND `show`='$show' AND payment_made_for='ALLOTMENT' AND utr_number='$utr_no' AND payment_status='captured' limit 1";
	$utrResult =  $conn ->query($getUTR);
	$utrResultrows = $utrResult->fetch_assoc();
	$utr_number = $utrResultrows['utr_number'];
	$payment_date = $utrResultrows['payment_date']; 
	$getUtr_Date = date("Ymd", strtotime($payment_date));
	$amountPaid = $utrResultrows['amountPaid'];	
	
	$Date = date('Ymd');
	
	$xml_exhibition_string = '<?xml version="1.0" encoding="utf-8"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="https://GJEPC_PARTIAL_ADVANCE.com">
	<soapenv:Header/>
	    <soapenv:Body>
			<gjep:MT_PADV_IN>
			 <SO_Advance>
				<Doc_date>'.$Date.'</Doc_date>
				<Posting_date>'.$getUtr_Date.'</Posting_date>
				<Company_code>1000</Company_code>
				<Currency>'.$currency.'</Currency>
				<customer_no>'.$billing_bp.'</customer_no>
				<event_type>D</event_type>
				<wbs_element>'.$wbs.'</wbs_element>
				<Sp_gl_indicator>A</Sp_gl_indicator>
				<Doc_Type>DZ</Doc_Type>
				<Doc_text>'.$utr_number.'</Doc_text>
				<Bank_Acc_No>'.$bank_acnt_no.'</Bank_Acc_No>
				<Bus_area>1111</Bus_area>
				<Amount>'.$amountPaid.'</Amount>
				<Profit_centre>1110</Profit_centre>
				<cheque_No>'.$utr_number.'</cheque_No>
				<Assignment>'.$lastSalesOrder.'</Assignment>
				<Sales_Doc></Sales_Doc>
				<Line_item>10</Line_item>
			 </SO_Advance>
		    </gjep:MT_PADV_IN>
	    </soapenv:Body>
	</soapenv:Envelope>';
				
	//  header ("Content-Type:text/xml");
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
			//echo $respons; exit;
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
					$sqlx = "UPDATE `utr_history` SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`part_sales_order_no`='$sales_order_no',`part_salesorder_status`='1' WHERE `utr_number`='$utr_no' AND `registration_id`='$registration_id' AND `show` ='$show' AND payment_made_for='ALLOTMENT'"; 
					$result = $conn ->query($sqlx);
					}
			}
			echo $flag;	
	}
}
?>