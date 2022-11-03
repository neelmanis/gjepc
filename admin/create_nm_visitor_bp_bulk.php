<?php 
/*
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');

session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = intval($_SESSION['curruser_login_id']);

function getaddresstype($id,$conn)
{
	$query_sel = "SELECT type_of_comaddress_name FROM  type_of_comaddress_master  where id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();   		
		return $row['type_of_comaddress_name'];
}

function getStateName($id,$conn)
{
	$query_sel = "SELECT state_name FROM  state_master  where state_code='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();  		
		return $row['state_name'];		
}

function getRegionName($id,$conn)
{
	$query_sel = "SELECT region FROM state_master where state_code='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();  		
		return $row['region'];		
}

function getroles($id,$conn)
{
	$query_sel = "SELECT role_type FROM type_of_comaddress_master  where id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();  		
		return $row['role_type'];
}

function CheckMembership($registration_id,$conn)
{
	$sql="SELECT * FROM `approval_master` WHERE 1 and `registration_id`='".$registration_id."' AND issue_membership_certificate_expire_status='Y'";
	$result = $conn->query($sql);
	$num_rows=  $result->num_rows;
	if($num_rows>0)
	{
		return 'M';
	} else {
		return 'NM';
	}
}

function getBPNO($registration_id,$conn)
{
	$query_sel = "SELECT c_bp_number FROM communication_address_master where registration_id='$registration_id' and type_of_address='2'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	return $row['c_bp_number'];
}

function getCompanyNonMemBPNO($registration_id,$conn)
{
	$sql="SELECT NM_bp_number FROM registration_master where id='$registration_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();	 		
	return $row['NM_bp_number'];
}

function getVisitorDesignation($id,$conn)
{
	$query_sel = "SELECT role_type FROM visitor_designation_master where id='$id'";        
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();                             
		return $row['role_type'];
}

function getVisitorDesignationDesc($id,$conn)
{
	$query_sel = "SELECT type_of_designation FROM visitor_designation_master where id='$id'";        
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();                              
		return $row['type_of_designation'];
}

/**************************************  Company BP Creation  ***********************************

	$soapUrl = "https://webdisp.gjepcindia.com:44306/XISOAPAdapter/MessageServlet?channel=:BC_SOAP_Proxy_BP_PRD:CC_Soap_Proxy_BP_PRD"; // Production
	$soapUser = "pi_admin";  //  username
    $soapPassword = "Deloitte@123"; // password
	
	$values = "SELECT * FROM `visitor_order_detail` WHERE 1 AND payment_status='Y' AND year='2022' AND event='iijs22' AND payment_type!='free' AND txn_status='0300' AND sap_sale_order_create_status='0' AND sales_order_no IS NULL group by regId order by tpsl_txn_time";
	$sqlx = $conn ->query($values);
	$countx = $sqlx->num_rows;
	if($countx > 0)
	{
		while($challanResult = $sqlx->fetch_assoc())
		{
		//echo 	$registration_id = $challanResult['regId']; echo '<br/>';
			$registration_id = $challanResult['regId']; 
			$type_of_member  = $challanResult['type_of_member'];
			
			$checkMember = CheckMembership($registration_id,$conn);
			if($checkMember=="M")
				$ho_bp_number = getBPNO($registration_id,$conn);
			else
				$ho_bp_number = getCompanyNonMemBPNO($registration_id,$conn);
			
			if(isset($registration_id) && $registration_id!=""){
				
				$addflag = "SELECT * FROM `n_m_billing_address` WHERE `registration_id`='$registration_id' limit 1";
				$deliveryQuery = $conn ->query($addflag);
				$deliveryResult = $deliveryQuery->fetch_assoc();
				$d_address1=strtoupper($deliveryResult['address1']); 
				$d_address2=strtoupper($deliveryResult['address2']); 
				$d_city=strtoupper($deliveryResult['city']);		 
				$d_region=strtoupper(getRegionName($deliveryResult['state'],$conn));
				$d_state = $deliveryResult['state']; 
				$d_pincode=$deliveryResult['pin_code'];
				
				/*............................Get PAN and GST of HO.............................
				$query= $conn ->query("SELECT * FROM `registration_master` WHERE `id` = '$registration_id' limit 1");	
				$result = $query->fetch_assoc();	
				$id	=	$result['id'];
				$email_id	=	filter($result['email_id']);
				$pan_no		=	strtoupper(filter($result['company_pan_no']));	
				$gst_no		=	strtoupper(filter($result['company_gstn']));
				
				if($result['company_type']=='propritory'  || $result['company_type']==14){ $legal_Entity=14; }
				if($result['company_type']=='partnership' || $result['company_type']==11){ $legal_Entity=11; }
				if($result['company_type']=='pvt' || $result['company_type']==13){ $legal_Entity=13;}
				if($result['company_type']=='llp' || $result['company_type']==19){ $legal_Entity=19;}
				if($result['company_type']=='public' || $result['company_type']==12){ $legal_Entity=12;}
				if($result['company_type']=='huf' || $result['company_type']==15){ $legal_Entity=15;}	
				if($result['company_type']==''){ $legal_Entity=11; }
				
				$company_name = strtoupper(trim(htmlspecialchars($result['company_name'])));
				$company_name = str_replace('&', '&amp;', $result['company_name']);
				
				$address1 = strtoupper(trim(htmlspecialchars($result['address_line1'])));
				$address1 = str_replace('&', '&amp;', $address1);
				if($address1==""){ $address1 = $d_address1; }
				$address2 = strtoupper(trim(htmlspecialchars($result['address_line2'])));
				$address2 = str_replace('&', '&amp;', $address2);
				if($address2==""){ $address2 = $d_address2; }
				$address3 = strtoupper(filter($result['address_line3']));
				$city	  = strtoupper(filter($result['city']));
				if($city==""){ $city = $d_city; }
				$country  = strtoupper($result['country']);
				$state    = strtoupper(filter($result['state']));
				if($state==""){ $state = $d_state; }
				
				if($result['pin_code']=="")
					$pincode=$d_pincode;
				else 
					$pincode = trim($result['pin_code']);
				
				$mobile_no = filter($result['mobile_no']);
				$tel1	   = filter($result['land_line_no']);
				
				/* Check Membership 
				$schk_membership="SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$registration_id' AND issue_membership_certificate_expire_status='Y'";	$qchk_membership= $conn ->query($schk_membership);
				$nchk_membership= $qchk_membership->num_rows;
				if($nchk_membership>0)
				{
					$price_grp = '01';
				} else {
					$price_grp = '02'; 
				}
				
				$cDate = date('dmY');
				$cur_year = (int)date('Y'); // Current Year
				$next_year  = $cur_year+1;
				$next_finyr = "3103".$next_year; // Next Financial year 31032018
				
$xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:gjep="https://gjepcinterfaces.com">
  <soapenv:Header/>
  <soapenv:Body>
    <gjep:MT_BP_IN>';
	/*..................................Person Header........................................
	$visitor_query = "SELECT * FROM `visitor_directory` WHERE 1 AND registration_id='$registration_id' AND isApplied='Y' AND visitor_approval!='O' AND visitor_approval='Y' AND bp_number IS NULL ORDER BY `visitor_id` ASC";
	$visitor_result = $conn ->query($visitor_query);	
	$visitor_row=  $visitor_result->fetch_assoc();
	
	$BP_roles = getVisitorDesignation($visitor_row['designation'],$conn);
	$designation = getVisitorDesignationDesc($visitor_row['designation'],$conn); 
	$visitor_id=$visitor_row['visitor_id']; 
	$name=$visitor_row['name']; 
	$lname=$visitor_row['lname']; 
	$v_email=$visitor_row['email']; 
	$v_pan_no=$visitor_row['pan_no']; 
	$v_mobile=$visitor_row['mobile']; 
	
		$xml_post_string .= '
		<BP_Header>
			<BP_Type>1</BP_Type>
			<BP_role>'.$BP_roles.'</BP_role>
			<Parent_Chalid>C</Parent_Chalid>
			<Start_of_Validity>'.$cDate.'</Start_of_Validity>
			<End_of_Validity>'.$next_finyr.'</End_of_Validity>
			<Name1_org>'.$name.' '.$lname.'</Name1_org>
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
			<Tel1>'.$v_mobile.'</Tel1>
			<tel2>'.$v_mobile.'</tel2>
			<fax></fax>
			<Email1>'.$v_email.'</Email1>
			<Email2>'.$v_email.'</Email2>
			<Delivering_Plant></Delivering_Plant>
			<CGST></CGST>
			<SGST></SGST>
			<IGST></IGST>
			<PAN>'.$v_pan_no.'</PAN>
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
			<External_ref>'.$visitor_id.'</External_ref>
			<star_status></star_status>
			<GSTIN>'.$gst_no.'</GSTIN>
			<Legal_Form>'.$legalForm.'</Legal_Form>
			<Parent_bp_no></Parent_bp_no>
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
		</BP_Table>";
		
	/*..................................Company To Person Relationship........................................
	$visitor_query_CTP = "SELECT * FROM `visitor_directory` WHERE `registration_id` = '$registration_id' AND isApplied='Y' AND visitor_approval!='O' AND visitor_approval='Y' ORDER BY `visitor_id` ASC";
	$visitor_result_CTP = $conn ->query($visitor_query_CTP);		
	$visitor_row_CTP = $visitor_result_CTP->fetch_assoc();
		$mobile = $visitor_row_CTP['mobile']; 
		$cDate = date('dmY');
		$cur_year = (int)date('Y'); // Current Year
		$next_year  = $cur_year+1;
		$next_finyr = "3103".$next_year; // Next Financial year 31032018
	
	$xml_post_string .= '
		<BP_Relationship>
			<Pan_Phone>'.$mobile.'</Pan_Phone>			
			<Relation_type>BUR001</Relation_type>
			<start_of_validity>'.$cDate.'</start_of_validity>
			<end_of_validity>'.$next_finyr.'</end_of_validity>
		</BP_Relationship>';
	
	$xml_post_string .= "
		</gjep:MT_BP_IN>
	  </soapenv:Body>
	</soapenv:Envelope>";

	/* header ("Content-Type:text/xml");
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
			//echo $response; exit;
            if(curl_errno($ch))
				print curl_error($ch);
			else
				curl_close($ch);

			// print to get response print_r($response);
			  //var_dump(response);
			$xmlstr="<?xml version='1.0' encoding='UTF-8'?>".$response;
			//echo $xmlstr; exit;
			
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
					$sqlx = "UPDATE `visitor_directory` SET `bp_number`='$tmp[3]',bp_create_date=NOW() WHERE visitor_id='$tmp[1]' AND registration_id='$registration_id'";
					$result = $conn ->query($sqlx);	
					}
				}
			}
			echo $flag;
				
			}
		}
	}
	*/
?>