<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');

function geCompanyName($registration_id,$conn)
{
	$query_sel = "SELECT company_name FROM registration_master  where id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();  		
	return $row['company_name'];
}

function getCompanyLandLine($registration_id,$conn)
{
	$query_sel = "SELECT land_line_no FROM registration_master  where id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();  		
	return $row['land_line_no'];
}

function getCompanyNonMemBPNO($registration_id,$conn)
{
	$query_sel="SELECT NM_bp_number FROM registration_master where id='$registration_id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['NM_bp_number'];
}

function getCompanyNonMemPan($registration_id,$conn)
{
	$query_sel="SELECT company_pan_no FROM registration_master where id='$registration_id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();  		
		return $row['company_pan_no'];
}

function getUserEmail($id,$conn)
{
	$query_sel = "SELECT email_id FROM  registration_master  where id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['email_id'];
}

function getUserMobile($id,$conn)
{
	$query_sel = "SELECT mobile_no FROM  registration_master  where id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();		
	return $row['mobile_no'];
}

//if(true)
if(!empty($_POST))
{
	$registration_id = trim($_POST['registration_id']);
	//$registration_id = "600888360";
	
	$soapUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_DELTABP:CC_DELTABP_sender";
	//$soapUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_DELTABP:CC_DELTABP_sender"; // Development	
	$soapUser = "pi_admin";  //  username
    $soapPassword = "Deloitte@123"; // password

	/* Check Membership Status */
	$schk_membership="SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' AND issue_membership_certificate_expire_status='Y'";	
	$qchk_membership = $conn ->query($schk_membership);
	$nchk_membership = $qchk_membership->num_rows;
	if($nchk_membership>0)
	{
		$price_grp = '01';
		$query  = $conn ->query("SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2' limit 1");
		$result = $query->fetch_assoc();
		
		$BPno=$result['c_bp_number'];
		$company_name = strtoupper(trim(htmlspecialchars(geCompanyName($registration_id,$conn))));
		$company_name = str_replace('&', '&amp;', $company_name);
		$company_email= getUserEmail($registration_id,$conn);
		$company_pan=$result['company_pan_no'];
		$mobile_no=$result['mobile_no'];
		
		
		$address1 = trim(htmlspecialchars($result['address1']));
		$address2 = trim(htmlspecialchars($result['address2']));
		$address3 = trim(htmlspecialchars($result['address3']));
		$city=strtoupper($result['city']);
		$country=strtoupper($result['country']);
		$state=$result['state'];
		$tel=$result['landline_no1'];
		$gst_no=strtoupper($result['gst_no']);
		if($result['pincode']=="")
			$pincode=123456;
		else 
			$pincode = trim($result['pincode']);
	 } else {
		$price_grp = '02'; 
		$queryR = $conn ->query("SELECT * FROM `registration_master` WHERE `id` = '$registration_id' limit 1");	
		$result = $queryR->fetch_assoc();	
		
		$BPno=$result['NM_bp_number'];	
		$company_pan=strtoupper($result['company_pan_no']);
		$gst_no=strtoupper($result['company_gstn']);
		$legal_Entity=$result['company_type'];
		$company_name = strtoupper(trim(htmlspecialchars($result['company_name'])));
		$company_name = str_replace('&', '&amp;', $result['company_name']);
		$company_email = $result['email_id'];
		$mobile_no = $result['mobile_no'];
		
		$address1 = trim(htmlspecialchars($result['address_line1']));
		$address2 = trim(htmlspecialchars($result['address_line2']));
		$address3 = trim(htmlspecialchars($result['address_line3']));
		
		$city=strtoupper($result['city']);
		$country=strtoupper($result['country']);
		//$state=getState($result['state']);
		$state=$result['state'];
		if($result['pin_code']=="")
			$pincode=123456;
		else 
			$pincode = trim($result['pin_code']);
		$tel=$result['land_line_no'];
	/*
	$query = $conn ->query("SELECT * FROM n_m_billing_address WHERE `registration_id` = '$registration_id' limit 1");	
		$result = $query->fetch_assoc();	
		
		$BPno = getCompanyNonMemBPNO($registration_id,$conn);
		$company_pan = getCompanyNonMemPan($registration_id,$conn);
		$gst_no=$result['gst_number'];
		$legal_Entity="";
		$company_name = strtoupper(trim(htmlspecialchars(geCompanyName($registration_id,$conn))));
		$company_name = str_replace('&', '&amp;', $company_name);
		$company_email = getUserEmail($registration_id,$conn);
		$mobile_no = getUserMobile($registration_id,$conn);
		
		$address1 = trim(htmlspecialchars($result['address1']));
		$address2 = trim(htmlspecialchars($result['address2']));
		$address3 = "";
		
		$city=strtoupper($result['city']);
		$country=strtoupper($result['country']);
		$state=$result['state'];
		if($result['pin_code']=="")
			$pincode=123456;
		else 
			$pincode = trim($result['pin_code']);
		$tel = getCompanyLandLine($registration_id,$conn);
	*/
	}
	$cDate = date('dmY');
	$cur_year = (int)date('Y'); // Current Year
	$next_year  = $cur_year+1;
	$next_finyr = "3103".$next_year; // Next Financial year 31032018
	
	$xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="http://GJEPCDELTABP.com">
   <soapenv:Header/>
   <soapenv:Body>
    <gjep:MT_BPDELTA_IN>';
		
	$xml_post_string .= '
		<BP_Header>
			<BP_Type>2</BP_Type>
			<BP_role>ZASSOC</BP_role>
			<Parent_Chalid>P</Parent_Chalid>
			<BP_NO>'.$BPno.'</BP_NO>
			<Start_of_Validity>'.$cDate.'</Start_of_Validity>
			<End_of_Validity>'.$next_finyr.'</End_of_Validity>
			<Name1_org>'.$company_name.'</Name1_org>
			<Name2_org>ABCD</Name2_org>
			<Street1>'.$address1.'</Street1>
			<Street2>'.$address2.'</Street2>
			<Street3>'.$address3.'</Street3>
			<Street4></Street4>
			<Street5></Street5>
			<District>'.$city.'</District>
			<Postal_Code>'.$pincode.'</Postal_Code>
			<Language>EN</Language>
			<City>'.$city.'</City>
			<Country_Key>IN</Country_Key>
			<Region>'.$state.'</Region>
			<Tel1>'.$mobile_no.'</Tel1>
			<tel2>'.$tel.'</tel2>
			<fax></fax>
			<Email1>'.$company_email.'</Email1>
			<Email2>'.$company_email.'</Email2>
			<Delivering_Plant>'.$state.'</Delivering_Plant>
			<CGST></CGST>
			<SGST></SGST>
			<IGST></IGST>
			<PAN>'.$company_pan.'</PAN>
			<IE_Code></IE_Code>
			<Date_issue></Date_issue>
			<IM_reg_no></IM_reg_no>
			<uan_reg_no></uan_reg_no>
			<ssi_reg_no></ssi_reg_no>
			<AAdhar_no></AAdhar_no>
			<Pass_No></Pass_No>
			<CIN_no></CIN_no>
			<din_no></din_no>
			<my_kyc></my_kyc>
			<bp_type></bp_type>
			<Legal_Entity>'.$legal_Entity.'</Legal_Entity>';
		
		$xml_post_string .= '
			<Date_Founded>'.$cDate.'</Date_Founded>
			<External_ref></External_ref>
			<star_status></star_status>
			<GSTIN>'.$gst_no.'</GSTIN>
			<start_of_validity>'.$cDate.'</start_of_validity>
		</BP_Header>';
	
		
$xml_post_string .= "
    <BP_Item>
        <bus_role></bus_role>
        <par_child></par_child>
        <start_val></start_val>
        <end_val></end_val>
        <BP_grp></BP_grp>
        <comp_code></comp_code>
        <r_ac_gl></r_ac_gl>
    </BP_Item>	  
    <BP_item1>
        <bus_role1></bus_role1>
        <par_child1></par_child1>
        <start_val></start_val>
        <end_val></end_val>
        <bp_grp1></bp_grp1>
        <pay_term></pay_term>
        <sales_org></sales_org>
        <dis_channel></dis_channel>
        <division></division>
        <sales_dis></sales_dis>
        <curr>INR</curr>
        <price_grp></price_grp>
        <cust_price_pro></cust_price_pro>
        <deliver_plant></deliver_plant>
        <acc_ass_grp></acc_ass_grp>		
    </BP_item1>";
	
    $xml_post_string .= "
	<BP_Table>
        <WEB_REF></WEB_REF>
		<GSTIN>".$gst_no."</GSTIN>
		<PAN>".$company_pan."</PAN>
		<IE_CODE></IE_CODE>
		<PANEL></PANEL>
		<BP_NO></BP_NO>
        <ZYEAR>".$cur_year."</ZYEAR>
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
		
	$xml_post_string .= '
		<BP_relationship>
            <BP_number_1></BP_number_1>
            <BP_number_2></BP_number_2>
            <RelationType></RelationType>
            <StartDate></StartDate>
            <EndDate></EndDate>
            <relationshipcategory></relationshipcategory>
        </BP_relationship>';

	$xml_post_string .= '
		<BP_Heirarchy>
            <Parent_BP_Number></Parent_BP_Number>
            <Sales_org_Parent></Sales_org_Parent>
            <DistrChannel_Parent></DistrChannel_Parent>
            <Divis_Parent></Divis_Parent>
            <child_BP_Number></child_BP_Number>
            <Sales_org_child></Sales_org_child>
            <DistrChannel_child></DistrChannel_child>
            <Divis_child></Divis_child>
            <CUSTHITYP></CUSTHITYP>
            <from_date></from_date>
            <Valid_to_date></Valid_to_date>
        </BP_Heirarchy>';	

	$xml_post_string .= "
		</gjep:MT_BPDELTA_IN>
	  </soapenv:Body>
</soapenv:Envelope>";

	/* header ("Content-Type:text/xml");
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
			//echo $response; exit;
            if(curl_errno($ch))
				print curl_error($ch);
			else
				curl_close($ch);

			// print to get response print_r($response);
			  //echo $response;exit;
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
					$tmp = explode(",", str_replace("@","",$strings));		
					foreach ($tmp as $value) {
						$flag=1;	
					}
				}
			}
			echo $flag;
		}
?>