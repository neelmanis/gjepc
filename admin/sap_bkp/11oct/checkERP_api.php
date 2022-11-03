<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');

function getaddresstype($id)
{
	$query_sel = "SELECT type_of_comaddress_name FROM  type_of_comaddress_master  where id='$id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['type_of_comaddress_name'];
	}
}

function getState($address)
{
	$query_sel = "SELECT state_name FROM  state_master  where state_code='$address'";
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['state_name'];		
	}
}

if(!empty($_POST))  
{ 	//echo "><pre>"; print_r($_POST);exit;
	$iec = trim($_POST['iec']);
	$registration_id = trim($_POST['registration_id']);
	
	$apiurl="http://api.mykycbank.com/Service.svc/44402aeb2e5c4eef8a7100f048b97d84/iec/".$iec;
	$getResponse = file_get_contents($apiurl);
	$getResult = json_decode($getResponse,true);
	$apiResponse = json_decode($getResult,true);
	//echo "<pre>"; print_r($apiResponse);
	$status = $apiResponse['status'];
	$Message = $apiResponse['Message'];
	$KycProfileId = $apiResponse['KycProfileId'];
	$BPId = $apiResponse['BPId'];
		
	if(!empty($BPId))
	{
		
		$soapRenewalUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_RENEW:CC_RENEW_BP"; // Renew URL of WSDL
		$soapUser = "pi_admin";  //  username
		$soapPassword = "Deloitte@123"; // password
	
	$query="select * from challan_master where registration_id='$registration_id' and challan_financial_year='2018'";
	$getChallanResult = mysql_query($query);
	$challanResult = mysql_fetch_array($getChallanResult);
	$export_total = $challanResult['export_total'];
	$import_total = $challanResult['import_total'];
	$export_fob_value = $challanResult['export_fob_value'];
	$import_cif_value = $challanResult['import_cif_value'];
	$challan_region = $challanResult['challan_region_name'];
	$total_payable = $challanResult['total_payable'];
	$admission_fees = $challanResult['admission_fees'];
	$membership_fees = $challanResult['membership_fees'];
	$renewDate = date("Ymd", strtotime($challanResult['post_date']));
	$gjepc_account_no = $challanResult['gjepc_account_no'];
	$cheque_no = $challanResult['cheque_no'];
	$Date = date('Ymd');
	$cur_year = (int)date('Y'); // Current Year
	$next_year  = $cur_year+1;
	$next_finyr = $next_year."0331"; // Next Financial year
	
	$xml_renewal_string = '<?xml version="1.0" encoding="utf-8"?>
	<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="https://gjepcrenew.com">
    <soapenv:Header/>
    <soapenv:Body>
      <gjep:MT_RENEW_IN>
         <renew_header>
            <BP_No>6000000</BP_No>
            <Role_name>ZASSOC</Role_name>
            <Start_date>'.$Date.'</Start_date>
            <End_Date>'.$next_finyr.'</End_Date>
            <Year>'.$cur_year.'</Year>
            <LOB>SK</LOB>
            <Export_val>'.$export_total.'</Export_val>
            <Import_val>'.$import_total.'</Import_val>
            <Avg_export>'.$export_fob_value.'</Avg_export>
            <Avg_import>'.$import_cif_value.'</Avg_import>
            <Renew_date>'.$renewDate.'</Renew_date>
         </renew_header>
         <SOAD_Header>
            <Sales_Doc>ZMEM</Sales_Doc>
            <SOrg>1000</SOrg>
            <Dis_channel>10</Dis_channel>
            <Division>20</Division>
            <sold_cust>6000000</sold_cust>
            <ship_cust>6000000</ship_cust>
            <po_ref>'.$cheque_no.'</po_ref>
            <Pay_term>0001</Pay_term>
            <order_Reason>106</order_Reason>
            <Incoterms>CFR</Incoterms>
            <Incoterm_Loc>Mumbai</Incoterm_Loc>
         </SOAD_Header>
         <SOAD_Item>
            <Item>000010</Item>
            <Material>1000000</Material>
            <Order_Qty>1</Order_Qty>
            <Plant>1010</Plant>
            <Item_Category>TAD</Item_Category>
            <cond1_Lebel>ZMEM</cond1_Lebel>			
			<Cond1_Val>'.$total_payable.'</Cond1_Val>
			<Cond2_Lebel>ZADM</Cond2_Lebel>
			<Cond2_Val>'.$admission_fees.'</Cond2_Val>
            <Cond3_Lebel></Cond3_Lebel>
            <Cond3_val></Cond3_val>
            <Cond4_Lebel></Cond4_Lebel>
            <Cond4_Val></Cond4_Val>
            <Incoterms>CFR</Incoterms>
            <Incoterms_Loc>Mumbai</Incoterms_Loc>
         </SOAD_Item>          
         <SOAD_Advance>
            <Doc_date>'.$Date.'</Doc_date>
            <Posting_date>'.$Date.'</Posting_date>
            <Company_code>1000</Company_code>
            <Currency>INR</Currency>
            <Account>6000000</Account>
            <Sp_gl_indicator>A</Sp_gl_indicator>
            <Doc_text>AK</Doc_text>
            <Bank_Acc_No>255029</Bank_Acc_No>
            <Bus_area>1000</Bus_area>
            <Amount>'.$total_payable.'</Amount>
            <Profit_centre>1010</Profit_centre>
            <Assignment></Assignment>
            <Sales_Doc></Sales_Doc>
            <Line_item>10</Line_item>
         </SOAD_Advance>
      </gjep:MT_RENEW_IN>
   </soapenv:Body>
</soapenv:Envelope>';
				
/*	header ("Content-Type:text/xml");
	echo $xml_renewal_string; exit; */
	
			$headers1 = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
                        "Content-length: ".strlen($xml_renewal_string),
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
            curl_setopt($ch1, CURLOPT_POSTFIELDS, $xml_renewal_string); // the SOAP request
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
			echo "UPDATE API"; exit;
			
	} else {
	
	$soapUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_SOAP_Proxy_BP:CC_Soap_Proxy_BP"; // asmx URL of WSDL
	$soapUser = "pi_admin";  //  username
    $soapPassword = "Deloitte@123"; // password
	
	$commAddress = "SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' ORDER BY `type_of_address_sap` ASC";
	$result = mysql_query($commAddress);
	
	
	$info = "SELECT * FROM `information_master` WHERE `registration_id` = '$registration_id'";
	$infoResult = mysql_query($info);
	$rows = mysql_fetch_array($infoResult);	
	$BP_role = $rows['designation']; /* Get Designation From Information table */
	$company_name = $rows['company_name']; /* Get Company Name From  information_master table */
	$region = $rows['region_id']; /* Get Company Name From  information_master table */
	$sez_member = $rows['sez_member']; /* If sez_Member is YES pass 1 otherwise 0 */
	if($sez_member=="Yes") { $sez_value=1; } else { $sez_value=0; }
	
	$iec_issue_date = date("dmY", strtotime($rows['iec_issue_date']));
	$IM_reg_no = $rows['im_registration_no'];
	$uan_reg_no = $rows['uin'];
	$ssi_registration_no = $rows['ssi_registration_no'];
	$aadhar_no = $rows['aadhar_no'];
	$passport_no = $rows['passport_no'];
	$cin_no = $rows['cin_no'];
	$bp_type = $rows['member_type_id'];
	$legal_Entity = $rows['type_of_firm'];
	$star_status = $rows['status_holder_eh'];
	$pan_nos = $rows['pan_no'];
	$gst_nos = $rows['gst_no'];
	
	$address1 = trim($rows['address1']);
	$address2 = trim($rows['address2']);
	$address3 = trim($rows['address3']);
	$city = trim($rows['city']);
	$pincode = trim($rows['pin_code']);
	$country = trim($rows['country']);
	$state = $rows['state']; /* Get State From communication_address_master table */
	$tel1 = trim($rows['land_line_no']);
	$mobile = trim($rows['mobile_no']);
	$fax = trim($rows['fax_no']);
	$email_id = trim($rows['email_id']);
	$din_no = trim($rows['din_no']);
	
		
	$regis = "SELECT * FROM `registration_master` where `id` = '$registration_id' and status='1'";
	$registerResult = mysql_query($regis);
	$rowy = mysql_fetch_array($registerResult);	
	$Start_of_Validity = date("dmY", strtotime($rowy['post_date'])); /* Get Registration Date From Registration table */
	$gcode = $rowy['gcode']; /* Get Registration Date From Registration table */
	
	$get_dir="SELECT * FROM `other_contact_detail` where `registration_id`='$registration_id'";
	$dir_result=mysql_query($get_dir);
	$countx = mysql_num_rows($dir_result);
	$other_detail='';
	while($getValue=mysql_fetch_array($dir_result)){
	$otherName = $getValue['other_name'];
	$otherEmail = $getValue['other_email'];
	$otherPhone = $getValue['other_phone'];
	$participant_detail.=$otherName.'-'.$otherEmail.'-'.$otherPhone.'-';
	}
	//echo $participant_detail;
	$str_explode=explode("-",$participant_detail); //print_r($str_explode);
	$string = $str_explode[0];  $string1 = $str_explode[1];	$string2 = $str_explode[2];
	$string3 = $str_explode[3]; $string4 = $str_explode[4];	$string5 = $str_explode[5];
	$string6 = $str_explode[6]; $string7 = $str_explode[7];	$string8 = $str_explode[8];
	$string9 = $str_explode[9]; $string10 = $str_explode[10]; $string11 = $str_explode[11];
	
	$panelsql="SELECT panel_name FROM `communication_details_master` WHERE 1 and registration_id=$registration_id";
	$panelresult=mysql_query($panelsql);
	$panelrows=mysql_fetch_array($panelresult);
	$panel_name=ucwords(strtolower($panelrows['panel_name']));

	$query="select * from challan_master where registration_id='$registration_id' and challan_financial_year='2018'";
	$getChallanResult = mysql_query($query);
	$challanResult = mysql_fetch_array($getChallanResult);
	$export_total = $challanResult['export_total'];
	$import_total = $challanResult['import_total'];
	$export_fob_value = $challanResult['export_fob_value'];
	$import_cif_value = $challanResult['import_cif_value'];
	$cheque_no = $challanResult['cheque_no'];
	$challan_region = $challanResult['challan_region_name'];
	$total_payable = $challanResult['total_payable'];
	$admission_fees = $challanResult['admission_fees'];
	$gjepc_account_no = $challanResult['gjepc_account_no'];
	$Date = date('Ymd');
	
	$xml_post_string = '<?xml version="1.0" encoding="utf-8"?>

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="https://gjepcinterfaces.com">
  <soapenv:Header/>
  <soapenv:Body>
    <gjep:MT_BP_IN>';
	  
while($row = mysql_fetch_array($result)){ //print_r($row);
	//$BP_Type = 2; /* If organization pass "2" else person "1" */
	$Parent_Chalid = $row['type_of_address_sap']; /* Get Head,Branch office Parent Child From communication_address_master table */
	$Name2_org = getaddresstype($row['type_of_address']); /* Get Type of Communication Address From communication_address_master table */
	$type_of_address = $row['type_of_address']; /* Get Head Office,Branch office If HO (organization) pass "2" else person "1"  - From communication_address_master table */
	if(!empty($type_of_address)) { if($type_of_address==2) { $BP_Type=2; } else { $BP_Type=1; } }
	
	$address1 = trim($row['address1']);
	$address2 = trim($row['address2']);
	$address3 = trim($row['address3']);
	$city = trim($row['city']);
	$pincode = trim($row['pincode']);
	$country = trim($row['country']);
	//$state = getState($row['state']); /* Get State From communication_address_master table */
	$state = $row['state']; /* Get State From communication_address_master table */
	$tel1 = trim($row['landline_no1']);
	$mobile = trim($row['mobile_no']);
	$fax = trim($row['fax_no1']);
	$email_id = trim($row['email_id']);
	$din_no = trim($row['$din_no']);
	$pan_no = $row['pan_no'];
	$gst_no = $row['gst_no'];
	$cDate = date('dmY');
	$cur_year = (int)date('Y'); // Current Year
	$next_year  = $cur_year+1;
	$next_finyr = "3103".$next_year; // Next Financial year 31032018
	
	$xml_post_string .= '
		<BP_Header>
			<BP_Type>'.$BP_Type.'</BP_Type>
			<BP_role>'.$BP_role.'</BP_role>
			<Parent_Chalid>'.$Parent_Chalid.'</Parent_Chalid>
			<Start_of_Validity>'.$Start_of_Validity.'</Start_of_Validity>
			<End_of_Validity>'.$next_finyr.'</End_of_Validity>
			<Name1_org>'.$company_name.'</Name1_org>
			<Name2_org>'.$Name2_org.'</Name2_org>
			<Street1>'.$address1.'</Street1>
			<Street2>'.$address2.'</Street2>
			<Street3>'.$address3.'</Street3>
			<Street4></Street4>
			<Street5></Street5>
			<District>'.$city.'</District>
			<Postal_Code>'.$pincode.'</Postal_Code>
			<Language>EN</Language>
			<City>'.$city.'</City>
			<Country_Key>'.$country.'</Country_Key>
			<Region>'.$state.'</Region>
			<Tel1>'.$tel1.'</Tel1>
			<tel2>'.$mobile.'</tel2>
			<fax>'.$fax.'</fax>
			<Email1>'.$email_id.'</Email1>
			<Email2>'.$email_id.'</Email2>
			<Delivering_Plant>'.$region.'</Delivering_Plant>
			<CGST>'.$sez_value.'</CGST>
			<SGST>'.$sez_value.'</SGST>
			<IGST>'.$sez_value.'</IGST>
			<PAN>'.$pan_no.'</PAN>
			<IE_Code>'.$iec.'</IE_Code>
			<Date_issue>'.$iec_issue_date.'</Date_issue>
			<IM_reg_no>'.$IM_reg_no.'</IM_reg_no>
			<uan_reg_no>'.$uan_reg_no.'</uan_reg_no>
			<ssi_reg_no>'.$ssi_registration_no.'</ssi_reg_no>
			<AAdhar_no>'.$aadhar_no.'</AAdhar_no>
			<Pass_No>'.$passport_no.'</Pass_No>
			<CIN_no>'.$cin_no.'</CIN_no>
			<din_no>din_no</din_no>
			<my_kyc>'.$status.'</my_kyc>
			<bp_type>00'.$bp_type.'</bp_type>
			<Legal_Entity>10</Legal_Entity>
			<Date_Founded>'.$cDate.'</Date_Founded>
			<External_ref>'.$gcode.'</External_ref>
			<star_status>'.$star_status.'</star_status>
			<GSTIN>'.$gst_no.'</GSTIN>
			<Parent_bp_no>A</Parent_bp_no>
			<start_of_validity>'.$cDate.'</start_of_validity>
			<BP2>12345</BP2>
			<Relation_type>BUR001</Relation_type>
			<start_validaity>'.$cDate.'</start_validaity>
			<end_valid>'.$next_finyr.'</end_valid>
			<web_ref>23</web_ref>
			<gstin1>'.$gst_no.'</gstin1>
			<PAN1>'.$pan_no.'</PAN1>
			<IE_Code1>'.$iec.'</IE_Code1>
			<year>'.$cur_year.'</year>
			<lob></lob>
			<Export_Value></Export_Value>
			<Import_Value></Import_Value>
			<org1></org1>
			<org2></org2>
		</BP_Header>';
		}
		
$xml_post_string .= "
      <BP_Item>
        <bus_role>FLCU00</bus_role>
        <par_child></par_child>
        <start_val>$cDate</start_val>
        <end_val>$next_finyr</end_val>
        <BP_grp>Z001</BP_grp>
        <comp_code>1000</comp_code>
        <r_ac_gl>25000</r_ac_gl>
      </BP_Item>
	  
      <BP_item1>
        <bus_role1>FLCU01</bus_role1>
        <par_child1></par_child1>
        <start_val>$cDate</start_val>
        <end_val>$next_finyr</end_val>
        <bp_grp1>Z001</bp_grp1>
        <pay_term>10000</pay_term>
        <sales_org>1000</sales_org>
        <dis_channel>10</dis_channel>
        <division>20</division>
        <sales_dis>00001</sales_dis>
        <curr>INR</curr>
        <price_grp>01</price_grp>
        <cust_price_pro>1</cust_price_pro>
        <deliver_plant>1001</deliver_plant>
        <acc_ass_grp>01</acc_ass_grp>
      </BP_item1>";

    $xml_post_string .= "
	<BP_Table>
        <WEB_REF>String 205</WEB_REF>
		<GSTIN>$gst_nos</GSTIN>
		<PAN>$pan_nos</PAN>
		<IE_CODE>$iec</IE_CODE>
		<PANEL>$panel_name</PANEL>
		<BP_NO>$BPId</BP_NO>
        <ZYEAR>2018</ZYEAR>
        <LOB>String 211</LOB>
        <IMPORT_VAL>$import_total</IMPORT_VAL>
		<EXPORT_VAL>$export_total</EXPORT_VAL>
		<AVERAGE_EXPORT>$export_fob_value</AVERAGE_EXPORT>
		<AVERAGE_IMPORT>$import_cif_value</AVERAGE_IMPORT>
        <REGISTRATION_NUMBER>String 216</REGISTRATION_NUMBER>
        <REGISTRATION_DATE>String 217</REGISTRATION_DATE>
        <REGISTERED>String 218</REGISTERED>
        <RENEWAL_DATE>String 219</RENEWAL_DATE>
        <MEM_CER_ISSU>String 220</MEM_CER_ISSU>
        <REGISTRATION_START_YEAR>String 221</REGISTRATION_START_YEAR>
        <REGISTRATION_END_YEAR>String 222</REGISTRATION_END_YEAR>
        <MEMBER_ID_CARD_NUMBER>String 223</MEMBER_ID_CARD_NUMBER>
        <AWARD_DETAILS>String 224</AWARD_DETAILS>
        <ZEVENT_PARTICIPATED>String 225</ZEVENT_PARTICIPATED>
        <NAME1_ORG>String 226</NAME1_ORG>
        <NAME2_ORG>String 227</NAME2_ORG>
        <IMP_EXP_CERTIFICATE>String 228</IMP_EXP_CERTIFICATE>
        <ZPART_DEED_DOC>String 229</ZPART_DEED_DOC>
        <ZMEMORANDUM_ASSOCIATION>String 230</ZMEMORANDUM_ASSOCIATION>
        <DATE_REC_APPLI>String 231</DATE_REC_APPLI>
        <ZMYKYC_STATUS>String 232</ZMYKYC_STATUS>
        <ZSTAR_GROUP>String 233</ZSTAR_GROUP>
        <ZEXTERNAL_BP>String 234</ZEXTERNAL_BP>
        <NAME>$string</NAME>
		<CELL_NUMBER>$string2</CELL_NUMBER>
		<EMAIL_ADDRESS>$string1</EMAIL_ADDRESS>
		<NAME1>$string3</NAME1>
		<CELL_NUMBER1>$string5</CELL_NUMBER1>
		<EMAIL_ADDRESS1>$string4</EMAIL_ADDRESS1>
		<NAME2>$string6</NAME2>
		<CELL_NUMBER2>$string8</CELL_NUMBER2>
		<EMAIL_ADDRESS2>$string7</EMAIL_ADDRESS2>
		<NAME3>$string9</NAME3>
		<CELL_NUMBER3>$string11</CELL_NUMBER3>
		<EMAIL_ADDRESS3>$string10</EMAIL_ADDRESS3>
     </BP_Table>
    </gjep:MT_BP_IN>
  </soapenv:Body>

</soapenv:Envelope>";
 /*header ("Content-Type:text/xml");
    echo $xml_post_string; exit; */
           $headers = array(
                        "Content-type: text/xml;charset=\"utf-8\"",
                        "Accept: text/xml",
                        "Cache-Control: no-cache",
                        "Pragma: no-cache",
                        //"SOAPAction: http://connecting.website.com/WSDL_Service/GetPrice", 
                        "Content-length: ".strlen($xml_post_string),
                    ); //SOAPAction: your op URL

            $url = $soapUrl;

            // PHP cURL  for https connection with auth
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            //curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // converting
            $response = curl_exec($ch); 
			//echo $response;
            if(curl_errno($ch))
				print curl_error($ch);
			else
				curl_close($ch);

			// print to get response print_r($response);
			  //var_dump(response);
			 $xmlstr="<?xml version='1.0' encoding='UTF-8'?>".$response;
			echo $xmlstr;
			
			$xml = simplexml_load_string($xmlstr, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");
			$xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');			
			foreach($xml->xpath('//soapenv:Body') as $header)
			{
				$arr = $header->xpath('//bp_number'); // Should output 'something'.
				$leadid = $arr[0];
				$strings = $leadid;
				
				if(!empty($strings))
				{
				$tmp = explode(",", $strings);
				while ($tmp) {
					$output[] = implode(',', array_splice($tmp, 0, 3));
				};
				$count =0;
				foreach ($output as $value) {

				$string = $value;
				$tmp = explode(",", $string);
				//echo("<br>");

					if ($count==0) {
						//echo $sqlx = "INSERT INTO `split`(`id`, `iec`, `pan`, `bp`) VALUES ('','$tmp[0]','$tmp[1]','$tmp[2]')";
						$sqlx = "UPDATE `information_master` SET `p_bp_number`='$tmp[2]' WHERE `iec_no`='$tmp[0]' and registration_id='$registration_id'";
						$result = mysql_query($sqlx);
					} else {
						//echo $sqlx2 = "INSERT INTO `split2`(`id`, `iec`, `pan`, `bp`) VALUES ('','$tmp[0]','$tmp[1]','$tmp[2]')";
						$sqlx = "UPDATE `communication_address_master` SET `c_bp_number`='$tmp[2]' WHERE registration_id='$registration_id' and pan_no='$tmp[1]'";
						$result = mysql_query($sqlx);
					}
					$count++;
				}
				}
			}
				//	exit;	
			
	/* Start Sales Order */
	$bpinfo = "SELECT * FROM `information_master` WHERE `registration_id` = '$registration_id'";
	$bpInfoResult = mysql_query($bpinfo);
	$bpRows = mysql_fetch_array($bpInfoResult);
	$p_bp_number = trim($bpRows['p_bp_number']); /* Pass Parent BP Number From Information Form*/
	
	$soapSalesUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_SOAD:CC_SOAD_Sender"; // asmx URL of WSDL
		
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
		<order_Reason>106</order_Reason>
		<Incoterms>CFR</Incoterms>
		<Incoterm_Loc>Mumbai</Incoterm_Loc>
	</SOAD_Header>
	<SOAD_Item>
		<Item>000010</Item>
		<Material>1000000</Material>
		<Order_Qty>1</Order_Qty>
		<Plant>1010</Plant>
		<Item_Category>TAD</Item_Category>
		<cond1_Lebel>ZMEM</cond1_Lebel>
		<Cond1_Val>'.$membership_fees.'</Cond1_Val>
		<Cond2_Lebel>ZADM</Cond2_Lebel>
		<Cond2_Val>'.$admission_fees.'</Cond2_Val>
		<Incoterms>CFR</Incoterms>
		<Incoterms_Loc>Mumbai</Incoterms_Loc>
	</SOAD_Item>
	<SO_Advance>
		<Doc_date>'.$Date.'</Doc_date>
		<Posting_date>'.$Date.'</Posting_date>
		<Company_code>1000</Company_code>
		<Currency>INR</Currency>
		<Account>6000000</Account>
		<Sp_gl_indicator>A</Sp_gl_indicator>
		<Doc_text>SK</Doc_text>
		<Bank_Acc_No>255029</Bank_Acc_No>
		<Bus_area>1000</Bus_area>
		<Amount>'.$total_payable.'</Amount>
		<Profit_centre>1010</Profit_centre>
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
            $respons = curl_exec($ch1); 
			//echo $response;
            if(curl_errno($ch1))
				print curl_error($ch1);
			else
				curl_close($ch1);

			// print to get response print_r($response);
			var_dump($respons); exit;
            
		}
	
	
}	
?>