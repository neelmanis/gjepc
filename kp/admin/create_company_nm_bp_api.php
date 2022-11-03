<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);

/**********************************************************  Company BP Creation  *********************************************************************/
//if(true)
if(!empty($_POST))
{
	$registration_id = trim(intval($_POST['registration_id']));
	//$registration_id = "1533";
	
	if(isset($registration_id) && $registration_id!=""){	

	$soapUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_SOAP_Proxy_BP_PRD:CC_Soap_Proxy_BP_PRD"; // Production
	//$soapUrl = "https://webdisp.gjepcindia.com:44303/XISOAPAdapter/MessageServlet?channel=:BC_SOAP_Proxy_BP:CC_Soap_Proxy_BP"; // Development
	$soapUser = "pi_admin";  //  username
    $soapPassword = "Deloitte@123"; // password	 
		
	/*............................Get PAN and GST of HO.............................*/
	
	$query  = mysqli_query($conn,"SELECT * FROM `kp_non_member_master` WHERE `NON_MEMBER_ID` = '$registration_id' limit 1");	
	$result = mysqli_fetch_array($query);	
	$id	    = $result['NON_MEMBER_ID'];
	$email_id	=	filter($result['EMAIL']);
	$pan_no	=	strtoupper(filter($result['company_pan_no']));	
	$gst_no		=	strtoupper(filter($result['company_gstn'])); 
	
	if($result['company_type']=='propritory'  || $result['company_type']==14){ $legal_Entity=14; }
	if($result['company_type']=='partnership' || $result['company_type']==11){ $legal_Entity=11; }
	if($result['company_type']=='pvt' || $result['company_type']==13){ $legal_Entity=13;}
	if($result['company_type']=='llp' || $result['company_type']==19){ $legal_Entity=19;}
	if($result['company_type']=='public' || $result['company_type']==12){ $legal_Entity=12;}
	if($result['company_type']=='huf' || $result['company_type']==15){ $legal_Entity=15;}	
	if($result['company_type']==''){ $legal_Entity=11; }
	
	$company_name = strtoupper(trim($result['NON_MEMBER_NAME']));
	$company_name = str_replace('&', '&amp;', $result['NON_MEMBER_NAME']);
	
	$address1 = strtoupper(trim($result['ADDRESS1']));
	$address1 = str_replace('&', '&amp;', $address1);
	$address2 = strtoupper(trim($result['ADDRESS2']));
	$address2 = str_replace('&', '&amp;', $address2);
	$address3 = strtoupper(filter($result['ADDRESS3']));
	$city	  = strtoupper(filter($result['CITY']));
	$country  = strtoupper($result['COUNTRY_ID']);
	$state    = strtoupper(filter($result['STATE_ID']));
	$pincode  = trim($result['PINCODE']);
	
	$mobile_no = filter($result['TELEPHONE1']);
	$tel1	   = filter($result['MOBILE']);
	
	$price_grp = '02'; 
	
	$cDate = date('dmY');
	$cur_year = (int)date('Y'); // Current Year
	$next_year  = $cur_year+1;
	$next_finyr = "3103".$next_year; // Next Financial year 31032018
		
	$xml_post_string = '<?xml version="1.0" encoding="utf-8"?>

<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="https://gjepcinterfaces.com">
  <soapenv:Header/>
  <soapenv:Body>
    <gjep:MT_BP_IN>';	  
	/*..................................Company Header........................................*/
	$xml_post_string .= '
		<BP_Header>
			<BP_Type>2</BP_Type>
			<BP_role>ZNONMB</BP_role>
			<Parent_Chalid>P</Parent_Chalid>
			<Start_of_Validity>'.$cDate.'</Start_of_Validity>
			<End_of_Validity>'.$next_finyr.'</End_of_Validity>
			<Name1_org>'.$company_name.'</Name1_org>
			<Name2_org>'.$company_name.'</Name2_org>
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
			<tel2>'.$mobile_no.'</tel2>
			<fax></fax>
			<Email1>'.$email_id.'</Email1>
			<Email2>'.$email_id.'</Email2>
			<Delivering_Plant>'.$state.'</Delivering_Plant>
			<CGST></CGST>
			<SGST></SGST>
			<IGST></IGST>
			<PAN>'.$pan_no.'</PAN>
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
			<Legal_Entity>'.$legal_Entity.'</Legal_Entity>
			<Date_Founded>'.$cDate.'</Date_Founded>
			<External_ref>'.$id.'</External_ref>
			<star_status></star_status>
			<GSTIN>'.$gst_no.'</GSTIN>
			<Legal_Form></Legal_Form>
			<Parent_bp_no>A</Parent_bp_no>
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
			<dis_channel>30</dis_channel>
			<division>20</division>
			<sales_dis>00001</sales_dis>
			<curr>INR</curr>
			<price_grp>$price_grp</price_grp>
			<cust_price_pro>$price_grp</cust_price_pro>
			<deliver_plant>$region</deliver_plant>
			<acc_ass_grp>$price_grp</acc_ass_grp>
			<CGST>0</CGST>
			<SGST>0</SGST>
			<IGST>0</IGST>
		</BP_item1>";
		
	$xml_post_string .= "
		<BP_Table>
			<WEB_REF></WEB_REF>
			<GSTIN></GSTIN>
			<PAN></PAN>
			<ie_code></ie_code>
			<PANEL></PANEL>
			<BP_NO></BP_NO>
			<ZYEAR></ZYEAR>
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
		</BP_Table>
		<BP_Relationship>
			<Pan_Phone></Pan_Phone>			
			<Relation_type>BUR001</Relation_type>
			<start_of_validity>$cDate</start_of_validity>
			<end_of_validity>$next_finyr</end_of_validity>
		</BP_Relationship>
		</gjep:MT_BP_IN>
	  </soapenv:Body>

</soapenv:Envelope>";
 
   /*header ("Content-Type:text/xml");
  echo $xml_post_string; exit;*/
  
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
						$sqlx = "UPDATE `kp_non_member_master` SET `NON_MEMBER_BP_NO`='$tmp[3]' WHERE NON_MEMBER_ID='$tmp[1]'";
						$result = mysqli_query($conn,$sqlx);	
					}
				}
			}
			echo $flag;
	}
}
?>