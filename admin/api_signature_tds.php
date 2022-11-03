<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);

if(!empty($_POST)) 
{	
	$ho_bp_number = filter($_POST['bpno']);
	$lastSalesOrder = trim($_POST['so_number']);
	$registration_id = intval($_POST['registration_id']);
	$utr_no = trim($_POST['utr_no']);
	
	if(isset($registration_id) && $registration_id!=""){
		
	$soapRenewalUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_TDS:CC_TDS_Sender"; // Development
	//$soapRenewalUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_TDS:CC_TDS_Sender"; // LIVE
	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password
	
	$show = "IIJS Signature 2019";
	
	/* Start Sales Order */
	$query="select a.id,a.uid,a.bp_number,a.billing_address_id,a.company_name,a.contact_person,a.region,a.city,a.created_date,b.gid,b.last_yr_participant,
	b.section,b.category, b.selected_area,b.selected_premium_type,b.options,c.cheque_dd_no,c.cheque_tds_gross_amount,c.net_payable_amount,c.payment_status,c.document_status,
	c.application_status from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid
	where a.event_for='$show' and a.uid='".$registration_id."' ";
	$getChallanResult = mysql_query($query);
	$challanResult = mysql_fetch_array($getChallanResult);
	$total_amount = $challanResult['cheque_tds_gross_amount'];
	$net_payable_amount = $challanResult['net_payable_amount'];
	//$renewDate = date("Ymd", strtotime($challanResult['post_date']));
	
	/* UTR Data */
	$getUTR = "SELECT * FROM `utr_history` where registration_id='$registration_id' AND utr_approved='Y' AND utr_number='$utr_no' limit 1";
	$utrResult = mysql_query($getUTR);
	$utrResultrows = mysql_fetch_array($utrResult);
	$utr_number = $utrResultrows['utr_number'];
	$utr_date = $utrResultrows['utr_date']; 
	$getUtr_Date = date("Ymd", strtotime($utr_date));
	$amountPaid = $utrResultrows['amountPaid'];	
	$tdsAmount = $utrResultrows['tdsAmount'];	
	
	$Date = date('Ymd');
	
	$xml_exhibition_string = '<?xml version="1.0" encoding="utf-8"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="http://gjepctds.com">
	<soapenv:Header/>
	<soapenv:Body>
        <gjep:MT_TDS_IN>
        <SO_Advance>
            <Doc_date>'.$Date.'</Doc_date>
            <Posting_date>'.$getUtr_Date.'</Posting_date>
            <Company_code>1000</Company_code>
            <Currency>INR</Currency>
            <Customer_no>8000010</Customer_no>
            <Doc_type>DZ</Doc_type>
            <Doc_text>'.$utr_number.'</Doc_text>
            <Tds_gl>230034</Tds_gl>
            <Bus_area>1000</Bus_area>
            <Amount>'.$tdsAmount.'</Amount>
            <Profit_centre>1010</Profit_centre>
            <Assignment>'.$lastSalesOrder.'</Assignment>
            <Line_Item>10</Line_Item>
        </SO_Advance>
        </gjep:MT_TDS_IN>
	</soapenv:Body>
	</soapenv:Envelope>';
				
	header ("Content-Type:text/xml");
	echo $xml_exhibition_string; exit; 
	
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
						$sqlx = "UPDATE `utr_history` SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`tds_sales_order_no`='$sales_order_no',`tds_salesorder_status`='1' WHERE `utr_number`='$utr_no' AND `registration_id`='$registration_id' AND tdsAmount='$tdsAmount' AND `show` ='$show'";
						//$result = mysql_query($sqlx);
					}
			}
			echo $flag;
	}
}
?>