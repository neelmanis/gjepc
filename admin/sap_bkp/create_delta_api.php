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
//!empty($_POST)
if(true)
{ 
	//$iec = trim($_POST['iec']);
	//$registration_id = trim($_POST['registration_id']);
	$registration_id = "600714127";
	
	//$soapUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_SOAP_Proxy_BP_PRD:CC_Soap_Proxy_BP_PRD"; // Production
	$soapUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_DELTABP:CC_DELTABP_sender"; // Development	
	$soapUser = "pi_admin";  //  username
    $soapPassword = "Deloitte@123"; // password
	
	/*............................Get PAN and GST of HO.............................*/
	$qho=mysql_query("SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2' limit 1");
	$rho = mysql_fetch_array($qho);
	$hopanno=strtoupper($rho['pan_no']);
	$hogstno=strtoupper($rho['gst_no']);
	$hoBPno=$rho['c_bp_number'];
		
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
	$iec = $rows['iec_no'];
	
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

	$commAddress = "SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' AND new_bp_check='Y' ORDER BY `type_of_address_sap` ASC";
	$result = mysql_query($commAddress);
		
	$xml_post_string = '<?xml version="1.0" encoding="utf-8"?>

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="http://GJEPCDELTABP.com">
   <soapenv:Header/>
   <soapenv:Body>
    <gjep:MT_BPDELTA_IN>';
	  
while($row = mysql_fetch_array($result)){ //print_r($row);
	//$BP_Type = 2; /* If organization pass "2" else person "1" */
	//$Parent_Chalid = $row['type_of_address_sap']; /* Get Head,Branch office Parent Child From communication_address_master table */
	
	$Name2_org = getaddresstype($row['type_of_address']); /* Get Type of Communication Address From communication_address_master table */
	$type_of_address = $row['type_of_address']; /* Get Head Office,Branch office If HO (organization) pass "2" else person "1"  - From communication_address_master table */
		
	$addressIdentity = $row['address_identity'];
	if($row['designation']=="")
		$designation="ABCD";
	else 
		$designation = trim($row['designation']);
		
	if($addressIdentity=="CTC"){ $Parent_Chalid = $row['type_of_address_sap']; } else { $Parent_Chalid = ""; }
	if($addressIdentity=="CTC"){ $BP_Type = 2; } else { $BP_Type = 1; }
	if($type_of_address==2){ $Parent_bp_no = "A"; } else { $Parent_bp_no = ""; }
	
	$BP_roles = getroles($row['type_of_address']);
	$id = trim($row['id']);
	$aadhar_no = $rows['aadhar_no'];
	$aadhar_no = $rows['aadhar_no'];
	$passport_no = $rows['passport_no'];
	$address1 = trim(htmlspecialchars($row['address1']));
	$address2 = trim(htmlspecialchars($row['address2']));
	$address3 = trim(htmlspecialchars($row['address3']));
	$city = trim($row['city']);
	$pincode = str_replace(' ', '', $row['pincode']);
	$country = trim($row['country']);
	$state = $row['state']; /* Get State From communication_address_master table */
	$tel1 = trim($row['landline_no1']);
	$mobile = trim($row['mobile_no']);
	$fax = trim($row['fax_no1']);
	$email_id = trim($row['email_id']);
	$din_no = trim($row['din_no']);
	if($addressIdentity=="CTC"){
	$pan_no = $hopanno;
	} else {
	$pan_no = strtoupper($row['pan_no']);
	}
	$gst_no = strtoupper($row['gst_no']);
	$cDate = date('dmY');
	$cur_year = (int)date('Y'); // Current Year
	$next_year  = $cur_year+1;
	$next_finyr = "3103".$next_year; // Next Financial year 31032018
	
	if($row['address_identity']=="CTP")
		$company_name1=trim(htmlspecialchars($row['name']));
	else
		$company_name1=trim(htmlspecialchars($company_name));
		
	$xml_post_string .= '
		<BP_Header>
			<BP_Type>'.$BP_Type.'</BP_Type>
			<BP_role>'.$BP_roles.'</BP_role>
			<Parent_Chalid>'.$Parent_Chalid.'</Parent_Chalid>
			<BP_NO>'.$hoBPno.'</BP_NO>
			<Start_of_Validity>'.$cDate.'</Start_of_Validity>
			<End_of_Validity>'.$next_finyr.'</End_of_Validity>
			<Name1_org>'.$company_name1.'</Name1_org>
			<Name2_org>'.$designation.'</Name2_org>
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
			<start_of_validity>'.$cDate.'</start_of_validity>
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
    </BP_item1>";
	
    $xml_post_string .= "
	<BP_Table>
        <WEB_REF></WEB_REF>
		<GSTIN>$hogstno</GSTIN>
		<PAN>$hopanno</PAN>
		<IE_CODE>$iec</IE_CODE>
		<PANEL>$panel_name</PANEL>
		<BP_NO></BP_NO>
        <ZYEAR>$cur_year</ZYEAR>
        <LOB></LOB>
        <IMPORT_VAL></IMPORT_VAL>
		<EXPORT_VAL></EXPORT_VAL>
		<AVERAGE_EXPORT></AVERAGE_EXPORT>
		<AVERAGE_IMPORT></AVERAGE_IMPORT>
        <REGISTRATION_NUMBER></REGISTRATION_NUMBER>
        <REGISTRATION_DATE></REGISTRATION_DATE>
        <REGISTERED></REGISTERED>
        <RENEWAL_DATE></RENEWAL_DATE>
        <MEM_CER_ISSU></MEM_CER_ISSU>
        <REGISTRATION_START_YEAR></REGISTRATION_START_YEAR>
        <REGISTRATION_END_YEAR></REGISTRATION_END_YEAR>
        <MEMBER_ID_CARD_NUMBER></MEMBER_ID_CARD_NUMBER>
        <AWARD_DETAILS></AWARD_DETAILS>
        <ZEVENT_PARTICIPATED></ZEVENT_PARTICIPATED>
        <NAME1_ORG></NAME1_ORG>
        <NAME2_ORG></NAME2_ORG>
        <IMP_EXP_CERTIFICATE></IMP_EXP_CERTIFICATE>
        <ZPART_DEED_DOC></ZPART_DEED_DOC>
        <ZMEMORANDUM_ASSOCIATION></ZMEMORANDUM_ASSOCIATION>
        <DATE_REC_APPLI></DATE_REC_APPLI>
        <ZMYKYC_STATUS></ZMYKYC_STATUS>
        <ZSTAR_GROUP></ZSTAR_GROUP>
        <ZEXTERNAL_BP></ZEXTERNAL_BP>
        <NAME></NAME>
		<CELL_NUMBER></CELL_NUMBER>
		<EMAIL_ADDRESS></EMAIL_ADDRESS>
		<NAME1></NAME1>
		<CELL_NUMBER1></CELL_NUMBER1>
		<EMAIL_ADDRESS1></EMAIL_ADDRESS1>
		<NAME2></NAME2>
		<CELL_NUMBER2></CELL_NUMBER2>
		<EMAIL_ADDRESS2></EMAIL_ADDRESS2>
		<NAME3></NAME3>
		<CELL_NUMBER3></CELL_NUMBER3>
		<EMAIL_ADDRESS3></EMAIL_ADDRESS3>
     </BP_Table>";
		
	$commAddress2 = "SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' AND address_identity='CTP' AND new_bp_check='Y' ORDER BY `type_of_address_sap` ASC";
	$result2 = mysql_query($commAddress2);
	$countCTP = mysql_num_rows($result2);
	if($countCTP>0){
	while($row = mysql_fetch_array($result2))
	{
		$addressIdentity = $row['address_identity'];
		$child_bp_number = $row['c_bp_number'];
		
		$cDate = date('dmY');
		$cur_year = (int)date('Y'); // Current Year
		$next_year  = $cur_year+1;
		$next_finyr = "3103".$next_year; // Next Financial year 31032018
	
	$xml_post_string .= '
		<BP_relationship>
            <BP_number_1>HEADER BP </BP_number_1>
            <BP_number_2>'.$child_bp_number.'</BP_number_2>
            <RelationType>BUR001</RelationType>
            <StartDate>'.$cDate.'</StartDate>
            <EndDate>'.$next_finyr.'</EndDate>
            <relationshipcategory>BUR001</relationshipcategory>
        </BP_relationship>';
	} } else {
	$xml_post_string .= '
		<BP_relationship>
            <BP_number_1></BP_number_1>
            <BP_number_2></BP_number_2>
            <RelationType>BUR001</RelationType>
            <StartDate>'.$cDate.'</StartDate>
            <EndDate>'.$next_finyr.'</EndDate>
            <relationshipcategory>BUR001</relationshipcategory>
        </BP_relationship>';
	}
	
	$cToCAddress = "SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' AND address_identity='CTC' AND new_bp_check='Y' ORDER BY `type_of_address_sap` ASC";
	$resultcTc = mysql_query($cToCAddress);
	$countCTC = mysql_num_rows($resultcTc);
	if($countCTC>0){
	while($rowcTc = mysql_fetch_array($resultcTc))
	{
		$addressIdentity = $rowcTc['address_identity'];
		$child_bp_number = $rowcTc['c_bp_number'];
		
		$cDate = date('dmY');
		$cur_year = (int)date('Y'); // Current Year
		$next_year  = $cur_year+1;
		$next_finyr = "3103".$next_year; // Next Financial year 31032018
	
	$xml_post_string .= '
		<BP_Heirarchy>
            <Parent_BP_Number>'.$hoBPno.'</Parent_BP_Number>
            <Sales_org_Parent>1000</Sales_org_Parent>
            <DistrChannel_Parent>10</DistrChannel_Parent>
            <Divis_Parent>20</Divis_Parent>
            <child_BP_Number>'.$child_bp_number.'</child_BP_Number>
            <Sales_org_child>1000</Sales_org_child>
            <DistrChannel_child>10</DistrChannel_child>
            <Divis_child>20</Divis_child>
            <CUSTHITYP>A</CUSTHITYP>
            <from_date>'.$cDate.'</from_date>
            <Valid_to_date>'.$next_finyr.'</Valid_to_date>
        </BP_Heirarchy>';
	} } else {
	$xml_post_string .= '
		<BP_Heirarchy>
            <Parent_BP_Number>'.$hoBPno.'</Parent_BP_Number>
            <Sales_org_Parent>1000</Sales_org_Parent>
            <DistrChannel_Parent>10</DistrChannel_Parent>
            <Divis_Parent>20</Divis_Parent>
            <child_BP_Number></child_BP_Number>
            <Sales_org_child>1000</Sales_org_child>
            <DistrChannel_child>10</DistrChannel_child>
            <Divis_child>20</Divis_child>
            <CUSTHITYP>A</CUSTHITYP>
            <from_date>'.$cDate.'</from_date>
            <Valid_to_date>'.$next_finyr.'</Valid_to_date>
        </BP_Heirarchy>';	
	}
	
	$xml_post_string .= "
		</gjep:MT_BPDELTA_IN>
	  </soapenv:Body>
</soapenv:Envelope>";

 header ("Content-Type:text/xml");
  echo $xml_post_string; exit;
  
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
						//$result = mysql_query($sqlx);	
					}
				}
			}
			echo $flag;
		}
?>