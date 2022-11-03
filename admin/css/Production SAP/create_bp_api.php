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

function getroles($id)
{
	$query_sel = "SELECT role_type FROM  type_of_comaddress_master  where id='$id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['role_type'];
	}
}

if(!empty($_POST))  
{ 
	$iec = trim($_POST['iec']);
	$registration_id = trim($_POST['registration_id']);
	
	/*$apiurl="http://api.mykycbank.com/Service.svc/44402aeb2e5c4eef8a7100f048b97d84/iec/".$iec;
	$getResponse = file_get_contents($apiurl);
	$getResult = json_decode($getResponse,true);
	$apiResponse = json_decode($getResult,true);
	$status = $apiResponse['status'];
	$Message = $apiResponse['Message'];
	$KycProfileId = $apiResponse['KycProfileId'];
	$BPId = $apiResponse['BPId'];*/



	$soapUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_SOAP_Proxy_BP:CC_Soap_Proxy_BP"; // asmx URL of WSDL
	$soapUser = "pi_admin";  //  username
    $soapPassword = "Deloitte@123"; // password

	
	/*............................Get PAN and GST of HO.............................*/
	$qho=mysql_query("SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2' limit 1");
	$rho = mysql_fetch_array($qho);
	$hopanno=strtoupper($rho['pan_no']);
	$hogstno=strtoupper($rho['gst_no']);
	
	
	
	$info = "SELECT * FROM `information_master` WHERE `registration_id` = '$registration_id'";
	$infoResult = mysql_query($info);
	$rows = mysql_fetch_array($infoResult);	
	//$BP_role = $rows['designation']; /* Get Designation From Information table */
	$company_name = $rows['company_name']; /* Get Company Name From  information_master table */
	//$region = $rows['region_id']; /* Get Company Name From  information_master table */
	if($rows['region_id']=='HO-MUM (M)'){ $region=1010;}
	if($rows['region_id']=='RO-JAI'){ $region=1020;}
	if($rows['region_id']=='RO-SRT'){ $region=1030;}
	if($rows['region_id']=='RO-CHE'){ $region=1040;}
	if($rows['region_id']=='RO-DEL'){ $region=1050;}
	if($rows['region_id']=='RO-KOL'){ $region=1060;}
	
	$sez_member = $rows['sez_member']; /* If sez_Member is YES pass 1 otherwise 0 */
	if($sez_member=="Yes") { $sez_value=1; } else { $sez_value=0; }
	
	$iec_issue_date = date("dmY", strtotime($rows['iec_issue_date']));
	$IM_reg_no = $rows['im_registration_no'];
	$uan_reg_no = $rows['uin'];
	$ssi_registration_no = $rows['ssi_registration_no'];
	$cin_no = $rows['cin_no'];
	$bp_type = $rows['member_type_id'];
	if($bp_type==5){$legalForm = '10'; } else { $legalForm = '09'; } /* If Merchant 10 if Manufacture 9 */
	$legal_Entity = $rows['type_of_firm'];
	$star_status = $rows['status_holder_eh'];
	
		
	$regis = "SELECT * FROM `approval_master` where `registration_id` = '$registration_id' limit 1";
	$registerResult = mysql_query($regis);
	$rowy = mysql_fetch_array($registerResult);	
	//$Start_of_Validity = date('dmY'); /* Get Registration Date From Registration table */
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
	
	$commAddress = "SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' ORDER BY `type_of_address_sap` ASC";
	$result = mysql_query($commAddress);
		
	$xml_post_string = '<?xml version="1.0" encoding="utf-8"?>

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="https://gjepcinterfaces.com">
  <soapenv:Header/>
  <soapenv:Body>
    <gjep:MT_BP_IN>';
	  
while($row = mysql_fetch_array($result)){ //print_r($row);
	//$BP_Type = 2; /* If organization pass "2" else person "1" */
	//$Parent_Chalid = $row['type_of_address_sap']; /* Get Head,Branch office Parent Child From communication_address_master table */
	
	$Name2_org = getaddresstype($row['type_of_address']); /* Get Type of Communication Address From communication_address_master table */
	$type_of_address = $row['type_of_address']; /* Get Head Office,Branch office If HO (organization) pass "2" else person "1"  - From communication_address_master table */
	//if(!empty($type_of_address)) { if($type_of_address==2) { $BP_Type=2; } else { $BP_Type=1; } }
	
	$addressIdentity = $row['address_identity'];
	if($addressIdentity=="CTC"){ $Parent_Chalid = $row['type_of_address_sap']; } else { $Parent_Chalid = ""; }
	if($addressIdentity=="CTC"){ $BP_Type = 2; } else { $BP_Type = 1; }
	if($type_of_address==2){ $Parent_bp_no = "A"; } else { $Parent_bp_no = ""; }
	
	$BP_roles = getroles($row['type_of_address']);
	$id = trim($row['id']);
	$aadhar_no = $rows['aadhar_no'];
	$passport_no = $rows['passport_no'];
	$address1 = trim($row['address1']);
	$address2 = trim($row['address2']);
	$address3 = trim($row['address3']);
	$city = trim($row['city']);
	$pincode = str_replace(' ', '', $row['pincode']);
	$country = trim($row['country']);
	//$state = getState($row['state']); /* Get State From communication_address_master table */
	$state = $row['state']; /* Get State From communication_address_master table */
	$tel1 = trim($row['landline_no1']);
	$mobile = trim($row['mobile_no']);
	$fax = trim($row['fax_no1']);
	$email_id = trim($row['email_id']);
	$din_no = trim($row['din_no']);
	$pan_no = strtoupper($row['pan_no']);
	$gst_no = strtoupper($row['gst_no']);
	$cDate = date('dmY');
	$cur_year = (int)date('Y'); // Current Year
	$next_year  = $cur_year+1;
	$next_finyr = "3103".$next_year; // Next Financial year 31032018
	
	$xml_post_string .= '
		<BP_Header>
			<BP_Type>'.$BP_Type.'</BP_Type>
			<BP_role>'.$BP_roles.'</BP_role>
			<Parent_Chalid>'.$Parent_Chalid.'</Parent_Chalid>
			<Start_of_Validity>'.$cDate.'</Start_of_Validity>
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
			<din_no>'.$din_no.'</din_no>
			<my_kyc>'.$status.'</my_kyc>
			<bp_type>00'.$bp_type.'</bp_type>
			<Legal_Entity>'.$legal_Entity.'</Legal_Entity>
			<Date_Founded>'.$cDate.'</Date_Founded>
			<External_ref>'.$id.'</External_ref>
			<star_status>'.$star_status.'</star_status>
			<GSTIN>'.$gst_no.'</GSTIN>
			<Legal_Form>'.$legalForm.'</Legal_Form>
			<Parent_bp_no>'.$Parent_bp_no.'</Parent_bp_no>
			<start_of_validity>'.$cDate.'</start_of_validity>
			<BP2></BP2>
			<Relation_type></Relation_type>
			<start_validaity></start_validaity>
			<end_valid></end_valid>
			<web_ref></web_ref>
			<gstin1></gstin1>
			<PAN1></PAN1>
			<IE_Code1></IE_Code1>
			<year></year>
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
        <r_ac_gl>0000250000</r_ac_gl>
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
        <deliver_plant>$region</deliver_plant>
        <acc_ass_grp>01</acc_ass_grp>
		<CGST>0</CGST>
        <SGST>0</SGST>
        <IGST>0</IGST>
      </BP_item1>";
	
	$result = mysql_query("SELECT `export_sales_to_foreign_tourists`, `export_synthetic_stones`, `export_costume_jewellery`, `export_other_precious_metal_jewellery`, `export_pearls`, `export_coloured_gemstones`, `export_gold_jewellery`, `export_studded_gold_jewellery`, `export_silver_jewellery`, `export_studded_silver_jewellery`, `export_rough_diamonds`, `export_cut_polished_diamonds`, `export_other_items`,`import_findings_mountings`, `import_false_pearls`, `import_rough_imitation_stones`, `import_silver`, `import_raw_pearls`, `import_cut_polished_gemstones`, `import_rough_gemstones`, `import_gold`, `import_cut_polished_diamonds`, `import_rough_diamonds`, `import_synthetic_stones`, `import_gold_jewellery`, `import_silver_jewellery`, `import_other_items` FROM `challan_master` WHERE `challan_financial_year`='2018' and registration_id='$registration_id'");
	$row=mysql_fetch_array($result);
	
	$result1 = mysql_query("SELECT export_fob_value,import_cif_value,cheque_no,challan_region_name,total_payable,admission_fees,gjepc_account_no,membership_fees FROM `challan_master` WHERE `challan_financial_year`='2018' and registration_id='$registration_id'");
	$row1=mysql_fetch_array($result1);
	$cheque_no = $row1['cheque_no'];
	$challan_region = $row1['challan_region_name'];
	$total_payable = $row1['total_payable'];
	$admission_fees = $row1['admission_fees'];
	$membership_fees = $row1['membership_fees'];
	$gjepc_account_no = $row1['gjepc_account_no'];

	$export_fob_value = $row1['export_fob_value'];
	$import_cif_value = $row1['import_cif_value'];
	
	$i = 0;
while ($i < mysql_num_fields($result)) {
    $meta = mysql_fetch_field($result, $i);
	$field_name=$meta->name;
	$value=$row[$meta->name];
	$item_type=str_split($field_name,6);
	$export_total="";
	$import_total="";
	
	if($value!='0'){
	
	if($item_type[0]=="export"){
		$export_total=$value;
	}
	if($item_type[0]=="import"){
		$import_total=$value;
	}
	
    $xml_post_string .= "
	<BP_Table>
        <WEB_REF>String 205</WEB_REF>
		<GSTIN>$hogstno</GSTIN>
		<PAN>$hopanno</PAN>
		<ie_code>$iec</ie_code>
		<PANEL>$panel_name</PANEL>
		<BP_NO>$BPId</BP_NO>
        <ZYEAR>2018</ZYEAR>
        <LOB>$meta->name</LOB>
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
     </BP_Table>";
	}
    $i++;
	}

	 $commAddress2 = "SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' ORDER BY `type_of_address_sap` ASC";
	 $result2 = mysql_query($commAddress2);
	 while($row = mysql_fetch_array($result2)){
		$addressIdentity = $row['address_identity'];
		if($addressIdentity=="CTC"){ 
			$pan_phone = $hopanno; 
		} else { 
			$pan_phone = $row['landline_no1']; 
		}
			
		$tel1 = trim($row['landline_no1']);
		$cDate = date('dmY');
		$cur_year = (int)date('Y'); // Current Year
		$next_year  = $cur_year+1;
		$next_finyr = "3103".$next_year; // Next Financial year 31032018
	
	 $xml_post_string .= '
	 <BP_Relationship>
            <Pan_Phone>'.$pan_phone.'</Pan_Phone>			
			<Relation_type>BUR001</Relation_type>
			<start_of_validity>'.$cDate.'</start_of_validity>
			<end_of_validity>'.$next_finyr.'</end_of_validity>
     </BP_Relationship>';
	 }		
	$xml_post_string .= "
		</gjep:MT_BP_IN>
	  </soapenv:Body>

</soapenv:Envelope>";
 /*header ("Content-Type:text/xml");
    echo $xml_post_string;*/
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
			//echo $xmlstr;
			
			$xml = simplexml_load_string($xmlstr, NULL, NULL, "http://schemas.xmlsoap.org/soap/envelope/");
			$xml->registerXPathNamespace('soapenv', 'http://schemas.xmlsoap.org/soap/envelope/');
			$flag=0;			
			foreach($xml->xpath('//soapenv:Body') as $header)
			{
					$arr = $header->xpath('//bp_number'); // Should output 'something'.
					$leadid = $arr[0];
					$strings = $leadid;
					
					if(!empty($strings))
					{
					$tmp = explode(",:,", $strings);				
					foreach ($tmp as $value) {
						$tmp = explode(",", $value);
						$flag=1;
						$sqlx = "UPDATE `communication_address_master` SET `c_bp_number`='$tmp[3]' WHERE id='$tmp[1]'";
						$result = mysql_query($sqlx);	
					}
				}
			}
			echo $flag;
		}
?>