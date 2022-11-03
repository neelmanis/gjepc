<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
//!empty($_POST)
if(!empty($_POST))  
{ //echo "><pre>"; print_r($_POST);exit;
	$bpno = trim($_POST['bpno']);
	$registration_id = trim($_POST['registration_id']);
	$renew_check = trim($_POST['renew_check']);
	exit;
	//$p_bp_number = "7000019096";
	//$registration_id = "600864090";
	
	/*$apiurl="http://api.mykycbank.com/Service.svc/44402aeb2e5c4eef8a7100f048b97d84/iec/".$iec;
	$getResponse = file_get_contents($apiurl);
	$getResult = json_decode($getResponse,true);
	$apiResponse = json_decode($getResult,true);
	//echo "<pre>"; print_r($apiResponse);
	$status = $apiResponse['status'];
	$Message = $apiResponse['Message'];
	$KycProfileId = $apiResponse['KycProfileId'];
	$BPId = $apiResponse['BPId'];
	*/
	if($renew_check=='N') 
	{
	$soapSalesUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_SOAD_PRD:CC_SOAD_Sender"; // Live
	}
	if($renew_check=='R') 
	{
	$soapSalesUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_RENEW:CC_RENEW_BP"; // Live
	}
	//$soapUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_SOAD:CC_SOAD_Sender"; // Development
	
	$soapUser = "pi_admin";  //  username
    $soapPassword = "Deloitte@123"; // password
	
	/* Check New or Renewal */
	if($renew_check=='N') 
	{
	$material ="5000000000"; //New Member
	$order_Reason = "106";
	}
	else {
	$material ="5000000010"; //Renewal
	$order_Reason = "107";
	}
	
	$info = "SELECT * FROM `information_master` WHERE `registration_id` = '$registration_id'";
	$infoResult = mysql_query($info);
	$rows = mysql_fetch_array($infoResult);
	if($rows['region_id']=='HO-MUM (M)'){ $region=1010;}
	if($rows['region_id']=='RO-JAI'){ $region=1020;}
	if($rows['region_id']=='RO-SRT'){ $region=1030;}
	if($rows['region_id']=='RO-CHE'){ $region=1040;}
	if($rows['region_id']=='RO-DEL'){ $region=1050;}
	if($rows['region_id']=='RO-KOL'){ $region=1060;}
	
	$result1 = mysql_query("SELECT export_fob_value,import_cif_value,cheque_no,challan_region_name,total_payable,admission_fees,gjepc_account_no,membership_fees FROM `challan_master` WHERE `challan_financial_year`='2018' and registration_id='$registration_id'");
	$row1=mysql_fetch_array($result1);
	$cheque_no = $row1['cheque_no'];
	$challan_region = $row1['challan_region_name'];
	$total_payable = $row1['total_payable'];
	if($renew_check=='N') 
	{
	$admission_fees = $row1['admission_fees'];
	} else { 
	$admission_fees = '';
	}
	$membership_fees = $row1['membership_fees'];
	$gjepc_account_no = $row1['gjepc_account_no'];
	
	/* Start Sales Order */
	$bpinfo = "SELECT c_bp_number,city FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2'";
	$bpInfoResult = mysql_query($bpinfo);
	$bpRows = mysql_fetch_array($bpInfoResult);
	$p_bp_number = trim($bpRows['c_bp_number']); /* Pass Parent BP Number From communication_address_master Table*/
	$city = trim($bpRows['city']);
	$Date = date('Ymd');
		
	$xml_sales_order_string = '<?xml version="1.0" encoding="utf-8"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="http://gjepcsoad.com">
	<soapenv:Header/>
	<soapenv:Body>
	<gjep:MT_SOAD_IN>
	<SOAD_Header>
		<Sales_Doc>ZMEM</Sales_Doc>
		<SOrg>1000</SOrg>
		<Dis_channel>10</Dis_channel>
		<Division>20</Division>
		<sold_cust>'.$p_bp_number.'</sold_cust>
		<ship_cust>'.$p_bp_number.'</ship_cust>
		<po_ref>'.$cheque_no.'</po_ref>
		<Pay_term>0001</Pay_term>
		<order_Reason>'.$order_Reason.'</order_Reason>
		<Incoterms>CFR</Incoterms>
		<Incoterm_Loc>'.$city.'</Incoterm_Loc>
	</SOAD_Header>
	<SOAD_Item>
		<Item>000010</Item>
		<Material>'.$material.'</Material>
		<Order_Qty>1</Order_Qty>
		<Plant>'.$region.'</Plant>
		<Item_Category>TAD</Item_Category>
		<cond1_Lebel>ZMEM</cond1_Lebel>
		<Cond1_Val>'.$membership_fees.'</Cond1_Val>
		<Cond2_Lebel>ZADM</Cond2_Lebel>
		<Cond2_Val>'.$admission_fees.'</Cond2_Val>
		<Incoterms>CFR</Incoterms>
		<Incoterms_Loc>'.$city.'</Incoterms_Loc>
	</SOAD_Item>
	<SO_Advance>
		<Doc_date>'.$Date.'</Doc_date>
		<Posting_date>'.$Date.'</Posting_date>
		<Company_code>1000</Company_code>
		<Currency>INR</Currency>
		<Account>'.$p_bp_number.'</Account>
		<Sp_gl_indicator>A</Sp_gl_indicator>
		<Doc_text>SK</Doc_text>
		<Bank_Acc_No>255221</Bank_Acc_No>
		<Bus_area>1000</Bus_area>
		<Amount>'.$total_payable.'</Amount>
		<Profit_centre>'.$region.'</Profit_centre>
		<Assignment>?</Assignment>
		<Sales_Doc>?</Sales_Doc>
		<Line_item>10</Line_item>
	</SO_Advance>
	</gjep:MT_SOAD_IN>
	</soapenv:Body>
	</soapenv:Envelope>';
				
/*	header ("Content-Type:text/xml");
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
			//echo $response;
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
						mysql_query("UPDATE `challan_master` SET `sales_order_no`='$sales_order_no' WHERE registration_id='$registration_id'");
						mysql_query("UPDATE `approval_master` SET `sap_sale_order_create_status`='1' WHERE registration_id='$registration_id'");
					}
			}
			echo $flag;
		}	
?>