<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID=$_SESSION['curruser_login_id'];

if(!empty($_POST)) 
{	
	$ho_bp_number = trim($_POST['bpno']);
	$lastSalesOrder = trim($_POST['so_number']);
	$registration_id = trim($_POST['registration_id']);
	$utr_no = trim($_POST['utr_no']);
	$event_name  = "iijstritiya22";
	
	if(isset($registration_id) && $registration_id!=""){
		
	//$soapRenewalUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_PADV_PRD:CC_PADV_PRD"; // Development
	$soapRenewalUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_PADV_PRD:CC_PADV_PRD"; // LIVE
	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password
	
	$show = "IIJS Tritiya 2022";
	
	/* Start Sales Order */
	$bpinfo = "SELECT c_bp_number,city FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2' limit 1";
	$bpInfoResult = $conn ->query($bpinfo);
	$bpRows = $bpInfoResult->fetch_assoc();
	
	$city = filter($bpRows['city']);
	if($city=='')
		$city = filter($rcity);
	else 
		$city = filter($city); 
	
	$query = $conn ->query("SELECT * FROM roi_space_registration where registration_id='$registration_id' and  event_name='".$event_name."'");
	$result = $query->fetch_assoc();
	$tot_space_cost_rate = $result['tot_space_cost_rate'];
	$govt_service_tax = $result['govt_service_tax'];
	$grand_total = trim($result['grand_total']);
	
	
	/* UTR Data */
	$getUTR = "SELECT * FROM `utr_history` where registration_id='$registration_id' AND utr_approved='Y' AND utr_number='$utr_no' limit 1";
	$utrResult =  $conn ->query($getUTR);
	$utrResultrows = $utrResult->fetch_assoc();
	$utr_number = $utrResultrows['utr_number'];
	$utr_date = $utrResultrows['utr_date']; 
	$getUtr_Date = date("Ymd", strtotime($utr_date));
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
				<Currency>INR</Currency>
				<customer_no>'.$ho_bp_number.'</customer_no>
				<event_type>D</event_type>
				<wbs_element>DE-067</wbs_element>
				<Sp_gl_indicator>A</Sp_gl_indicator>
				<Doc_Type>DZ</Doc_Type>
				<Doc_text>'.$utr_number.'</Doc_text>
				<Bank_Acc_No>255241</Bank_Acc_No>
				<Bus_area>1111</Bus_area>
				<Amount>'.$amountPaid.'</Amount>
				<Profit_centre>1110</Profit_centre>
				<cheque_No></cheque_No>
				<Assignment>'.$lastSalesOrder.'</Assignment>
				<Sales_Doc></Sales_Doc>
				<Line_item>10</Line_item>
			 </SO_Advance>
		    </gjep:MT_PADV_IN>
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
						$sqlx = "UPDATE `utr_history` SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`part_sales_order_no`='$sales_order_no',`part_salesorder_status`='1' ,IsDone='1' WHERE `utr_number`='$utr_no' AND `registration_id`='$registration_id' AND `show` ='$show'";
						$result = $conn ->query($sqlx);
					}
			}
			echo $flag;
	}
}
?>