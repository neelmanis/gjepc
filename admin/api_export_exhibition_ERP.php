<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
session_start();
$adminID = $_SESSION['curruser_login_id'];
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
/*
function getBillingBPNO($id)
{
	$query_sel = "SELECT c_bp_number FROM `communication_address_master` WHERE `id`='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
		return $row['c_bp_number'];
}

function getMembershipType($registration_id)
{
	$query_sel = "SELECT membership_certificate_type FROM approval_master where registration_id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
		return $row['membership_certificate_type'];
}

function chkMsmeStatus($registration_id)
{
	$query_sel = "SELECT msme_ssi_status FROM `information_master` WHERE `registration_id`='$registration_id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
		return $row['msme_ssi_status'];
} */

if(!empty($_POST)) 
{		
	$registration_id = filter($_POST['registration_id']);
	$bpno 			 = filter($_POST['bpno']);
	
	//$soapRenewalUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_Exhibition:CC_Exhibition_Sender"; // Development
	$soapRenewalUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_Exhibition:CC_Exhibition_Sender"; // LIVE
	$soapUser = "pi_admin";  //  username
	$soapPassword = "Deloitte@123"; // password
	
	/*................................Get Country Code.....................................*/
	$q = $conn ->query("select * from registration_master where `id` = '$registration_id' limit 1");
	$r = $q->fetch_assoc();
	$country_code = $r['country'];
		   $rcity = $r['city'];
	
	$info = "SELECT * FROM `information_master` WHERE `registration_id` = '$registration_id'";
	$infoResult = $conn ->query($info);
	$rows = $infoResult->fetch_assoc();
	if($rows['region_id']=='HO-MUM (M)'){ $region=1010;}
	if($rows['region_id']=='RO-JAI'){ $region=1020;}
	if($rows['region_id']=='RO-SRT'){ $region=1030;}
	if($rows['region_id']=='RO-CHE'){ $region=1040;}
	if($rows['region_id']=='RO-DEL'){ $region=1050;}
	if($rows['region_id']=='RO-KOL'){ $region=1060;}
	
	$show = "IIJS SIGNATURE 2022";
	
	/* Start Sales Order */
	$bpinfo = "SELECT c_bp_number,city FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2' limit 1";
	$bpInfoResult = $conn ->query($bpinfo);
	$bpRows = $bpInfoResult->fetch_assoc();
	$ho_bp_number = trim($bpRows['c_bp_number']); /* Pass Parent BP Number From communication_address_master Table*/
	/*$city = filter($bpRows['city']);
	if($city=='')
		$city = filter($rcity);
	else 
		$city = filter($city); */
		
	$query="select a.id,a.uid,a.bp_number,a.billing_address_id,a.city,a.get_billing_bp_number,a.company_name,a.contact_person,a.region,a.created_date,b.gid,b.last_yr_participant,	b.section,b.category,b.selected_area,b.selected_premium_type,b.options,c.cheque_dd_no,c.cheque_tds_gross_amount,c.net_payable_amount,c.payment_status,c.document_status,c.application_status from exh_reg_general_info a inner join exh_registration b on a.id=b.gid inner join exh_reg_payment_details c on a.id=c.gid	where a.event_for='$show' and a.uid='".$registration_id."' ";
	$getChallanResult = $conn ->query($query);
	$challanResult = $getChallanResult->fetch_assoc();
	$total_amount = $challanResult['cheque_tds_gross_amount'];
	$net_payable_amount = $challanResult['net_payable_amount'];
	$renewDate = date("Ymd", strtotime($challanResult['post_date']));
	$last_yr_participant = strtoupper($challanResult['last_yr_participant']);
	
	$billing_address_id = $challanResult['billing_address_id']; //Getting id from communication_address_master & send to exh_reg_general_info table billing_address_id
	$billing_bp_number = $challanResult['get_billing_bp_number'];
	if($billing_bp_number==''){ $billing_bp_number = $bpno; }
	if($ho_bp_number=='')     { $ho_bp_number=$bpno;}
	
	$section  = filter($challanResult['section']);
	$category = filter($challanResult['category']);
	$area 	  = filter($challanResult['selected_area']);
	$selected_premium_type = filter($challanResult['selected_premium_type']);
	
	/*$membership_certificate_type = getMembershipType($registration_id);
	$msme_ssi_status = strtoupper(chkMsmeStatus($registration_id));
	
	if($last_yr_participant == "YES")
	{
	if($membership_certificate_type!=''){
		if($membership_certificate_type == 'ZASSOC') {	$tot_space_cost_discount = 5; }
		if($membership_certificate_type == 'ZASSOC' && $msme_ssi_status == "YES") {	$tot_space_cost_discount = 10;	}
		if($membership_certificate_type=='ZORDIN') {	$tot_space_cost_discount = 15; }
	 }
	} */
	
	$city = trim($challanResult['city']);
	if($city=='')
		$city = trim($rcity);
	else 
		$city = trim($city);
	
	if($tot_space_cost_discount==''){ $tot_space_cost_discount =0;} 
		
	if($section=="plain_gold"){				$charge="23500"; }
	else if($section=="loose_stones") {		$charge="23500"; }
	else if($section=="signature_club"){ 	$charge="30500"; }
	else if($section=="studded_jewellery"){	$charge="23500"; }
	else if($section=="lab_edu"){ 			$charge="23500"; }
	else if($section=="allied")	{ 			$charge="23500"; }
	else if($section=="synthetics") { 		$charge="23500"; }
	else if($section=="silver_jewellery_artifacts") { 		$charge="23500"; }
	else if($section=="International Jewellery") { $charge="450"; }
	else if($section=="International Loose"){ 	   $charge="450"; }
	
	if($category=="normal"){ 			$categoryPer='0';	}
	else if($category=="corner_2side"){	$categoryPer='5';	}
	else if($category=="corner_3side"){	$categoryPer='10';	}
	else if($category=="island_4side"){	$categoryPer='15';	}
	
	/*if($selected_premium_type=="normal")	  { $selected_premiumRate='0';	}
	else if($selected_premium_type=="premium"){	$selected_premiumRate='5';	}
	*/
	/* signature_sap_dummy_stall */
	//$dummy_stall = "SELECT * FROM `signature_sap_dummy_stall` WHERE section='$section' AND category='$category' AND selected_premium_type='$selected_premium_type' AND status='1'";
	$dummy_stall = "SELECT * FROM `signature_sap_dummy_stall` WHERE section='$section' AND category='$category' AND status='1'";
	$dummy_stallResult = $conn ->query($dummy_stall);
	$stallrows = $dummy_stallResult->fetch_assoc();
	$materialNo = $stallrows['material_no'];
	/* signature_sap_dummy_stall */
	
	if($country_code=="IN"){		
		$bank_acnt_no="255241";  /*... Domestic Account ...*/
	} else {		
		$bank_acnt_no="255351"; /*... International Account ...*/
	}
	
	/* UTR Data */
	$getUTR = "SELECT * FROM `utr_history` where registration_id='$registration_id' AND utr_approved='Y' AND `show` ='$show' AND event_selected='signature22' order by `utr_date` asc limit 1";
	$utrResult = $conn ->query($getUTR);
	$utrResultrows = $utrResult->fetch_assoc();
	$utr_id = $utrResultrows['id'];
	$utr_number = filter($utrResultrows['utr_number']);
	$utr_date = $utrResultrows['utr_date']; 
	$getUtr_Date = date("Ymd", strtotime($utr_date));
	$amountPaid = $utrResultrows['amountPaid'];	
	
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
            <sold_cust>'.$billing_bp_number.'</sold_cust>
            <ship_cust>'.$ho_bp_number.'</ship_cust>
            <po_ref>'.$utr_number.'</po_ref>
            <Pay_term>0001</Pay_term>
            <order_Reason>111</order_Reason>
            <Incoterms>CFR</Incoterms>
            <Incoterm_Loc>'.$city.'</Incoterm_Loc>
			<Event_Type>D</Event_Type>
        </SOAD_Header>
        <SOAD_Item>
            <Item>0010</Item>
            <Material>'.$materialNo.'</Material>
            <Order_Qty>'.$area.'</Order_Qty>
            <Plant>1110</Plant>
            <Item_Category>TAN</Item_Category>
            <cond1_Lebel>ZST1</cond1_Lebel>
            <Cond1_Val>'.$charge.'</Cond1_Val>			
            <Cond2_Lebel>ZDIS</Cond2_Lebel>
            <Cond2_Val>'.$tot_space_cost_discount.'</Cond2_Val>			
            <Cond3_Lebel>ZBS1</Cond3_Lebel>
            <Cond3_val>'.$categoryPer.'</Cond3_val>			
            <Cond4_Lebel>ZPR1</Cond4_Lebel>
            <Cond4_Val>'.$selected_premiumRate.'</Cond4_Val>
            <Cond5_Lebel>ZBL1</Cond5_Lebel>
            <Cond5_Val>0</Cond5_Val>
            <Cond6_Lebel>ZDI2</Cond6_Lebel>
            <Cond6_Val></Cond6_Val>
            <Batch></Batch>
            <WBS>DE-056</WBS>
            <Incoterms>CFR</Incoterms>
            <Incoterms_Loc>'.$city.'</Incoterms_Loc>
            <Net_weight>1</Net_weight>
            <Gross_Weight>1</Gross_Weight>
         </SOAD_Item>
         <SOAD_Advance>
            <Doc_date>'.$Date.'</Doc_date>
            <Posting_date>'.$getUtr_Date.'</Posting_date>
            <Company_code>1000</Company_code>
            <Currency>INR</Currency>
			<WBS>DE-056</WBS>
            <Account>'.$billing_bp_number.'</Account>
            <Sp_gl_indicator>A</Sp_gl_indicator>
            <Doc_text>SK</Doc_text>
            <Bank_Acc_No>'.$bank_acnt_no.'</Bank_Acc_No>
            <Bus_area>1111</Bus_area>
            <Amount>'.$amountPaid.'</Amount>
            <Profit_centre>1110</Profit_centre>
            <Assignment></Assignment>
            <Sales_Doc></Sales_Doc>
            <Line_item>10</Line_item>
         </SOAD_Advance>
      </gjep:MT_Exhibition_IN>
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
			//echo $respons;exit;
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
						$advance_doc = trim(substr($strings, strpos($strings, "# ")+1,11));
						$sqlx = "UPDATE `exh_reg_payment_details` SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`sales_order_no`='$sales_order_no',`sap_sale_order_create_status`='1' WHERE `uid`='$registration_id' AND `show` ='$show' AND event_selected='signature'";
						$result = $conn ->query($sqlx);
						$sqly = "UPDATE `utr_history` SET `sap_push_date`=NOW(),`sap_push_admin`='$adminID',`first_sales_order_no`='$sales_order_no',`sap_so_status`='1',`IsDone`='1',`advance_doc`='$advance_doc' WHERE `registration_id`='$registration_id' AND id='$utr_id' AND `show` ='$show' AND event_selected='signature22'";
						$resulty = $conn ->query($sqly);
					}
			}
			echo $flag;	
}
?>