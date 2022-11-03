<?php
function getanswer($q_id,$conn)
{
	$sql="select * from poll_master where id=$q_id";
	$result=$conn->query($sql);
	$row=$result->fetch_assoc();
	if($row['c_answer']=='1')
	{
		$c_answer=$row['opt1'];
	}
	else if($row['c_answer']=='2')
	{
		$c_answer=$row['opt2'];
	}
	else if($row['c_answer']=='3')
	{
		$c_answer=$row['opt3'];
	}
	else if($row['c_answer']=='4')
	{
		$c_answer=$row['opt4'];
	}
	
	return $c_answer;
}

function chk_msme($uid,$conn)
{
	$query_sel = "SELECT msme_ssi_status FROM `information_master` WHERE `registration_id`='$uid'";
	$result_sel = $conn->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['msme_ssi_status'];
	}
}

function isMember($uid,$conn)
{
	$query = "SELECT * FROM `approval_master` WHERE 1 and `registration_id`='$uid' and issue_membership_certificate_expire_status='Y'";
	$result_sel = $conn->query($query);	
	$num = $result_sel->num_rows;
	return $num;
}

function cal($count,$total)
{
	$per = $count/$total*100;
		return $per;
}
function getSchemeDescription($scheme,$conn)
{
	$query_sel = "SELECT  scheme_desc FROM iijs_scheme_master  where scheme='$scheme'";	
	$result_sel = $conn->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['scheme_desc'];
	}
}

function getSchemeDescription_signature($scheme,$conn)
{
	$query_sel = "SELECT  scheme_desc FROM  signature_scheme_master  where scheme='$scheme'";	
	$result_sel = $conn->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['scheme_desc'];
	}
}

function getSection_desc($section,$conn)
{
	$query_sel = "SELECT section_desc FROM signature_section_master where section='$section'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
	return $row['section_desc'];
}

function getAdminName($id,$conn)
{
	$query_sel = "SELECT `contact_name` FROM `admin_master` WHERE id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['contact_name'];
}

function getGcode($uid)
{
	$query_sel = "SELECT gcode FROM registration_master where id='$uid'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['gcode'];
	}
}
function getRgis($gcode)
{
	$query_sel = "SELECT registration_id FROM approval_master where gcode='$gcode'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['registration_id'];
	}
}

function getBPNO($registration_id,$conn)
{
	$query_sel = "SELECT c_bp_number FROM communication_address_master where registration_id='$registration_id' and type_of_address='2'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	return $row['c_bp_number'];
}
function getPanNo($registration_id,$conn)
{
	$query_sel = "SELECT pan_no FROM communication_address_master where registration_id='$registration_id' and type_of_address='2'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	return $row['pan_no'];
}

function getCompanyGSTNO($registration_id,$conn)
{
	$query_sel = "SELECT gst_no FROM communication_address_master where registration_id='$registration_id' and type_of_address='2'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	return $row['gst_no'];
}

function getContactPerson($registration_id,$conn)
{
	$query_sel = "SELECT name FROM communication_address_master where registration_id='$registration_id' and type_of_address='13'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	return strtoupper($row['name']);
}

function getContactPersonMobile($registration_id,$conn)
{
	$query_sel = "SELECT mobile_no FROM communication_address_master where registration_id='$registration_id' and type_of_address='13'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	return $row['mobile_no'];
}

function getCompanyPan($registration_id,$conn)
{
	$query_sel = "SELECT company_pan_no FROM registration_master where id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();			
	return $row['company_pan_no'];
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

function CheckMembershipStatusApi($registration_id,$conn)
{
	$sql="SELECT admin_issue_membership_certificate FROM `approval_master` WHERE 1 and `registration_id`='".$registration_id."' AND admin_issue_membership_certificate='Y'";
	$result = $conn->query($sql);
	$num_rows=  $result->num_rows;
	if($num_rows>0)
	{
		return "TRUE";
	} else {
		return "FALSE";
	}
}

function getCompanyNonMemBPNO($registration_id,$conn)
{
	$sql="SELECT NM_bp_number FROM registration_master where id='$registration_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();	 		
	return $row['NM_bp_number'];
}

function getBillingBPNO($id,$conn)
{
	$query_sel = "SELECT c_bp_number FROM `communication_address_master` WHERE `id`='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();		
		return $row['c_bp_number'];
}

function getVendorAreaName($id,$conn)
{
	$query_sel = "SELECT area FROM vendor_area_master  where id='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
		return $row['area'];
}

function getDocumentName($id,$conn)
{
	$sql = "SELECT name FROM vendor_documents where id='$id'";	
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();		
		return $row['name'];
}

function getVendorCompanyName($id,$conn)
{
	$sql = "SELECT company_name FROM vendor_registration where id='$id'";	
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();	 		
		return $row['company_name'];
}

function getNameCompany($registration_id,$conn)
{
	$sql="SELECT company_name FROM registration_master where id='$registration_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();			
	return strtoupper($row['company_name']);
}

function getCompanyType($registration_id,$conn)
{
	$sql="SELECT company_type FROM registration_master where id='$registration_id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();			
	return strtoupper($row['company_type']);
}

function getCompanyAddress($registration_id)
{
	$sql="SELECT address_line1,address_line2,address_line3,city,pin_code FROM registration_master where id='$registration_id'";
	$result=mysql_query($sql);
	if($row = mysql_fetch_array($result))		 	
	{ 		
		return $row['address_line1'].", ".$row['address_line2'].", ".$row['address_line3'].", ".$row['city'].",".$row['pin_code'];
	}
}

function moneyFormatIndia($num){
    $explrestunits = "" ;
    if(strlen($num)>3){
        $lastthree = substr($num, strlen($num)-3, strlen($num));
        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
        $expunit = str_split($restunits, 2);
        for($i=0; $i<sizeof($expunit); $i++){
            // creates each of the 2's group and adds a comma to the end
            if($i==0)
            {
                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
            }else{
                $explrestunits .= $expunit[$i].",";
            }
        }
        $thecash = $explrestunits.$lastthree;
    } else {
        $thecash = $num;
    }
    return $thecash; // writes the final format where $currency is the currency symbol.
}

// Fetch Page Name 
function getPageName($id,$conn)
{
	$query_sel = "SELECT page_name FROM  page_master  where id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();				
	return $row['page_name'];
}

function getCountryName($countrycode,$conn)
{
	$query_sel = "SELECT country_name FROM  country_master  where country_code='$countrycode'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();		
	return $row['country_name'];
}

function getStateName($id,$conn)
{
	$query_sel = "SELECT state_name FROM  state_master  where id='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	
	return $row['state_name'];		
	
}

function getState($address,$conn)
{
	$query_sel = "SELECT state_name FROM  state_master where state_code='$address'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['state_name'];	
}

function gotStatesName($adminRegion,$conn)
{
	$query_sel = "SELECT state_code FROM state_master where region_name='$adminRegion'";
	$result_sel = $conn->query($query_sel);
	$movies_id = array();
	while($row = $result_sel->fetch_assoc())		 	
	{ 
	    $visitor_approval = $row['state_code'];
	    $movies_id[] = $visitor_approval;   
	}
	$Array = $movies_id;
	return $List = implode(', ', $Array); 
}

function gotRegionwiseAccess($adminRegionWiseAccess,$conn)
{
	$result_string = "'" . str_replace(",", "','", $adminRegionWiseAccess) . "'";
	$query_sel = "SELECT state_code FROM state_master where region_name IN ($result_string)";
	$result_sel = $conn->query($query_sel);
	$movies_id = array();
	while($row = $result_sel->fetch_assoc())		 	
	{ 
	    $visitor_approval = $row['state_code'];
	    $movies_id[] = $visitor_approval;   
	}
	$Array = $movies_id;
	return $List = implode(', ', $Array); 
}

function gotStateRegionName($statecode,$conn)
{
	$query_sel = "SELECT region FROM state_master where state_code='$statecode'";
	$result_sel = $conn->query($query_sel);							
	$row = $result_sel->fetch_assoc();	 		
		return $row['region'];		
}

function getCityName($id,$conn)
{
	$query_sel = "SELECT city_name FROM  city_master  where id='$id'";
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();			
		return $row['city_name'];
}

function getUserName($id,$conn)
{
	$query_sel = "SELECT first_name,last_name FROM  registration_master where id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 	
	$full_name=	$row['first_name'].' '.$row['last_name'];
	return $full_name;
}

function getUserEmail($id,$conn)
{
	$query_sel = "SELECT email_id FROM  registration_master where id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();		
	return $row['email_id'];
}

function getUserPassword($id)
{
	$query_sel = "SELECT password FROM  registration_master  where id='$id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['password'];
	}
}

function getUserMobile($id,$conn)
{
	$query_sel = "SELECT mobile_no FROM registration_master where id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
		return trim($row['mobile_no']);
}
function getUserCombo($id)
{
	$query_sel = "SELECT combo FROM  registration_master  where id='$id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['combo'];
	}
}

function getRegionName($id,$conn)
{
	$query_sel = "SELECT region_name FROM region_master where id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	return $row['region_name'];
}
function getRegionNameFromState($state_code,$conn)
{
	$query_sel = "SELECT region_name FROM state_master where state_code='$state_code'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	return $row['region_name'];
}

function getRegionEmail($region_code,$conn)
{
	$query_sel = "SELECT region_tradeemail FROM  region_master  where region_name='$region_code'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();				
	return $row['region_tradeemail'];
}

function getMembershipId($registration_id,$conn)
{
	$query_sel = "SELECT membership_id FROM  approval_master  where registration_id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	return $row['membership_id'];
}

function eligible_for_renewal($registration_id,$conn)
{
	$query_sel = "SELECT eligible_for_renewal FROM approval_master where registration_id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	 return $row['eligible_for_renewal'];
}

function getaddresstype($id,$conn)
{
	$query_sel = "SELECT type_of_comaddress_name FROM type_of_comaddress_master  where id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();
	return $row['type_of_comaddress_name'];
}

function getTypeofFirm($id,$conn)
{
	$query_sel = "SELECT type_of_firm FROM  information_master  where registration_id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();		
	return $row['type_of_firm'];
}

function getFirmType($id,$conn) //SAP
{
	$query_sel = "SELECT type_of_firm_name FROM  type_of_firm_master  where sap_value='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
		return $row['type_of_firm_name'];
}

function getMemberTypeMaster($id,$conn) //SAP
{
	$query_sel = "SELECT member_type_name FROM member_type_master where sap_value='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	
	return $row['member_type_name'];
}

/*.......................Registration Id using Email Id................................*/
function getid($email_id)
{
	$query_sel = "SELECT id FROM  registration_master  where email_id='$email_id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['id'];
	}
}
/*.......................Registration Id using IEC Number................................*/

function getRegid($iec_no,$conn)
{
	$query_sel = "SELECT * FROM `information_master` WHERE `iec_no`='$iec_no'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();			
		return $row['registration_id'];
}
function getRegidBP($c_bp_number,$conn)
{
	$query_sel = "SELECT registration_id FROM `communication_address_master` WHERE `c_bp_number`='$c_bp_number'";
	$result = $conn->query($query_sel);							
	$row = $result->fetch_assoc();	 		
	return $row['registration_id'];
}

function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }
    return $result;
}

function getMemberType($registration_id,$conn)
{
	$query_sel = "SELECT member_type_id FROM  information_master  where registration_id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['member_type_id'];
}

function getRegion($registration_id,$conn)
{
	$query_sel = "SELECT region_id FROM  information_master  where registration_id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();			
	return $row['region_id'];
}

function getcompanyStatus($registration_id,$conn)
{
	$query_sel = "SELECT approval_status FROM  registration_master  where id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
		return $row['approval_status'];
}
function getCompanyName($registration_id,$conn)
{
	$query_sel = "SELECT company_name FROM  information_master  where registration_id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['company_name'];
}

function getCompanyNameFromregistration($registration_id,$conn)
{
	$query_sel = "SELECT company_name FROM  registration_master  where id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['company_name'];
}

function getMemberCompany($registration_id)
{
	$query_sel = "SELECT company_name FROM  member_directory  where registration_id='$registration_id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['company_name'];
	}
}

function getMemberContact($registration_id)
{
	$query_sel = "SELECT contact_person FROM  member_directory  where registration_id='$registration_id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['contact_person'];
	}
}

function getRegionAccNo($region_id,$conn)
{
	$query_sel = "SELECT region_bank_acct_no FROM  region_master  where region_name='$region_id'";
	$result = $conn->query($query_sel);
	if($row = $result->fetch_assoc())		 	
	{	
			if($region_id=="HO-MUM (M)")
			{
				return substr($row['region_bank_acct_no'],3);
			}
			else if($region_id=="RO-DEL")
			{
				return substr($row['region_bank_acct_no'],4);
			} 
			else if($region_id=="RO-CHE")
			{
				return "00".$row['region_bank_acct_no'];
			}
			else if($region_id=="RO-KOL")
			{
				return substr($row['region_bank_acct_no'],8);
			}
			else
			{
				return $row['region_bank_acct_no'];
			}
	}
}

/*
function getRegionAccNo($region_id)
{
	//$query_sel = "SELECT region_bank_acct_no FROM  region_master  where region_name='$region_id'";	
	$query_sel = "SELECT region_bank_acct_no FROM  region_master  where sap_value='$region_id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
		{ 		
			if($region_id==1010)
			{
				return substr($row['region_bank_acct_no'],3);
			}
			else if($region_id==1050)
			{
				return substr($row['region_bank_acct_no'],4);
			} 
			else if($region_id==1040)
			{
				return "00".$row['region_bank_acct_no'];
			}
			else if($region_id==1060)
			{
				return substr($row['region_bank_acct_no'],8);
			}
			else
			{
				return $row['region_bank_acct_no'];
			}
	}
} */

function getRegionBankName($region_id)
{
	$query_sel = "SELECT region_bank FROM region_master where region_name='$region_id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['region_bank'];
	}
}


function getCustomerBankName($bank_name)
{
	$query_sel = "SELECT code FROM customer_bank_code where bank_name='$bank_name'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['code'];
	}
}

function getFullStateName($state_code,$conn)
{
	$query_sel = "SELECT state_name FROM state_master  where state_code='$state_code'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	return $row['state_name'];
}

function getFullCountryeName($country_code,$conn)
{
	$query_sel = "SELECT country_name FROM country_master where country_code='$country_code'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['country_name'];
}

function getRegionRealName($region_name,$conn)
{
	$query_sel = "SELECT region_real_name FROM region_master where region_name='$region_name'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();				
	return $row['region_real_name'];
}

function getCommunicationAddress($addflag)
{
	if($addflag==1){
	 return $query_sel = "SELECT * FROM type_of_comaddress_master where id in (1,2,3,4,13,14)";	
	}
	if($addflag==2){
	 return $query_sel = "SELECT * FROM type_of_comaddress_master where id in (2,3,5,4,13,14)";	
	}
	if($addflag==3){
	 return $query_sel = "SELECT * FROM type_of_comaddress_master where id in (2,3,6,7,4,13,14)";	
	}
	if($addflag==4){
	 return $query_sel = "SELECT * FROM type_of_comaddress_master where id in (2,3,6,7,4,13,14)";	
	}
	if($addflag==5){
	 return $query_sel = "SELECT * FROM type_of_comaddress_master where id in (1,2,3,4,13,14)";	
	}
	if($addflag==6){
	 return $query_sel = "SELECT * FROM type_of_comaddress_master where id in (2,3,4,8,13,14)";	
	}
	if($addflag==7){
	 return $query_sel = "SELECT * FROM type_of_comaddress_master where id in (2,3,4,9,13,14)";	
	}
	if($addflag==8){
	 return $query_sel = "SELECT * FROM type_of_comaddress_master where id in (2,3,4,10,13,14)";	
	}
	if($addflag==9){
	 return $query_sel = "SELECT * FROM type_of_comaddress_master where status=1";	
	}
}

function getPanelCode($panel_name)
{
	$query_sel = "SELECT code FROM panel_master where description='$panel_name'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['code'];
	}
}


function delhiAdd()
{
	return '<tr>
    	<td align="left"  style="text-align:justify;"> For any further queries regarding the same please contact regional office:- G-42 to G-63, Second Floor, Flatted Factories Complex, Jhandewalan, New Delhi-110 055</td>
  		</tr>
   		<tr>
    		<td>&nbsp; </td>
    	</tr>
	  <tr>
		<td align="left"   style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,<br /></td>
	  </tr>
  <tr>
    <td align="left"><strong>GJEPC Web Team,</strong><br />
      <strong>Email:</strong> <a href="mailto:madaan@gjepcindia.com">madaan@gjepcindia.com</a><br />
<strong>Telephone: </strong> +91 (11) 46266920 to 926</td>
  </tr>';
}

function mumAdd()
{
	return '<tr>
    	<td align="left"  style="text-align:justify;"> For any further queries regarding the same please contact regional office:- Office No. AW 1010, Tower A, G Block, Bharat Diamond Bourse, Next to ICICI Bank, Bandra-Kurla Complex, 
Bandra - East</td>
  		</tr>
   		<tr>
    		<td>&nbsp; </td>
    	</tr>
	  <tr>
		<td align="left"   style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,<br /></td>
	  </tr>
  <tr>
    <td align="left"><strong>GJEPC Web Team,</strong><br />
      <strong>Email:</strong> <a href="mailto:membership@gjepcindia.com">membership@gjepcindia.com</a> 
	  <br />
<strong>Telephone: </strong>+91 22 26544600</td>
  </tr>';

}
function cheAdd()
{
	return '<tr>
    	<td align="left"  style="text-align:justify;"> For any further queries regarding the same please contact regional office:- Ankur Plaza III Floor, 113 (Old No 52) G.N. Chetty Road, T. Nagar Chennai - 17.</td>
  		</tr>
   		<tr>
    		<td>&nbsp; </td>
    	</tr>
	  <tr>
		<td align="left"   style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,<br /></td>
	  </tr>
  <tr>
    <td align="left"><strong>GJEPC Web Team,</strong><br />
      <strong>Email:</strong> <a href="mailto:bhanu.prasad@gjepcindia.com">bhanu.prasad@gjepcindia.com</a><br />
<strong>Telephone: </strong>0091-44-2815 5180</td>
  </tr>';

}

function jaiAdd()
{
	return '<tr>
    	<td align="left"  style="text-align:justify;"> For any further queries regarding the same please contact regional office:- Rajasthan Chamber Bhawan, 3rd Floor, Mirza Ismail Road, Jaipur - 302 003.</td>
  		</tr>
   		<tr>
    		<td>&nbsp; </td>
    	</tr>
	  <tr>
		<td align="left"   style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,<br /></td>
	  </tr>
  <tr>
    <td align="left"><strong>GJEPC Web Team,</strong><br />
      <strong>Email:</strong> 
	  						<a href="mailto:;sasi@gjepcindia.com">;sasi@gjepcindia.com</a> |
	  						<a href="mailto:anilkumar@gjepcindia.com">anilkumar@gjepcindia.com</a><br />
<strong>Telephone: </strong>0091-141-256 8029 | 257 4074</td>
  </tr>';

}
function kolAdd()
{
	return '<tr>
    	<td align="left"  style="text-align:justify;"> For any further queries regarding the same please contact regional office:- Vanijya Bhavan, 6th Flr, Left Wing, 1/1, Wood Street, Kolkata: 700 016.</td>
  		</tr>
   		<tr>
    		<td>&nbsp; </td>
    	</tr>
	  <tr>
		<td align="left"   style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,<br /></td>
	  </tr>
  <tr>
    <td align="left"><strong>GJEPC Web Team,</strong><br />
      <strong>Email:</strong> <a href="mailto:salim@gjepcindia.com">salim@gjepcindia.com</a><br />
<strong>Telephone: </strong>0091-33-2282 3630 | 2282 3629</td>
  </tr>';

}
function suratAdd()
{
	return '<tr>
    	<td align="left"  style="text-align:justify;"> For any further queries regarding the same please contact regional office:- 401/A, International Commercial Centre, Near Kadiwala School, Ring Road, Surat 395002</td>
  		</tr>
   		<tr>
    		<td>&nbsp; </td>
    	</tr>
	  <tr>
		<td align="left"   style="font-family:"Lucida Sans"; font-size:14px; font-weight:bold; color:#990000;">Kind Regards,<br /></td>
	  </tr>
  <tr>
    <td align="left"><strong>GJEPC Web Team,</strong><br />
      <strong>Email:</strong> <a href="mailto:ccjacob@gjepcindia.com">ccjacob@gjepcindia.com</a><br />
<strong>Telephone: </strong>+ 91 261 220 9000 / 220 9017
<strong>Fax: </strong>+ 91 261 2209040
</td>
  </tr>';

}

function getIec($id,$conn)
{
	$query_sel = "SELECT iec_no FROM `information_master` WHERE `registration_id`='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	return $row['iec_no'];
}

function getPanelName($id,$conn)
{
	$query_sel = "SELECT panel_name FROM `communication_details_master` WHERE `registration_id`='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();		
	return $row['panel_name'];
}

function uploadImage($file_name,$file_temp,$file_type,$file_size,$attach,$loc)
{	
	$upload_image = '';
	$target_folder = "images/PhotoID/$loc/";
	$target_path = "";
	$file_name = str_replace(" ","_",$file_name);
	$file_name = str_replace(".php","",$file_name);
	
	if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png")) && $file_size < 2097152 )
		{
			$target_path = $target_folder.$attach.'_'.$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				$upload_image = $attach.'_'.$file_name;
			}
			else
			{
				echo "Sorry error while uploading";
			}
		}
		else
		{
			echo "Invalid file";
		}	
	}	
	return $upload_image;
}

function fetch($sql)
{
	global $conn;
	$sql;
	$data = array();
	$query_data = $conn ->query($sql);
	while($row = $query_data -> fetch_assoc())
	{
	$data[] = $row; 
	}
	return $data;
/*
global $conn;
$sql;
$data = array();
$query_data = $conn -> prepare($sql);
$query_data -> execute();			
$rowx = $query_data->get_result();
while($row = $rowx -> fetch_assoc())
{
$data[] = $row ; 
}
return $data ;*/
}

function number_word($number)
{
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'ONE', '2' => 'TWO',
    '3' => 'THREE', '4' => 'FOUR', '5' => 'FIVE', '6' => 'SIX',
    '7' => 'SEVEN', '8' => 'EIGHT', '9' => 'NINE',
    '10' => 'TEN', '11' => 'ELEVEN', '12' => 'TWELVE',
    '13' => 'THIRTEEN', '14' => 'FOURTEEN',
    '15' => 'FIFTEEN', '16' => 'SIXTEEN', '17' => 'SEVENTEEN',
    '18' => 'EIGHTTEEN', '19' =>'NINETEEN', '20' => 'TWENTY',
    '30' => 'THIRTY', '40' => 'FOURTY', '50' => 'FIFTY',
    '60' => 'SIXTY', '70' => 'SEVENTY',
    '80' => 'EIGHTY', '90' => 'NINETY');
   $digits = array('', 'HUNDRED', 'THOUSAND', 'LAKH', 'CRORE');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? '' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' AND ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
		  
  $result = "RUPEES " .$result ."ONLY";
  //if($points!=""){$result=$result.$points . " PAISE";}
  echo $result;
  
 }
 
 
function uploadtradeImage($file_name,$file_temp,$file_type,$file_size,$attach,$loc)
{	
	$upload_image = '';
	$target_folder = "images/Tradephoto/$loc/";
	$target_path = "";
	$file_name = str_replace(" ","_",$file_name);
	$file_name = str_replace(".php","",$file_name);
	$file_name = str_replace("'","",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name) || preg_match("/.PhP/i", $file_name)) {
    	echo "invalidfile";
	}else if($file_name != '')
	{	
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf")) && $file_size < 2097152)
		{
			$target_path = $target_folder.$attach.'_'.$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				$upload_image = $attach.'_'.$file_name;
			}
			else
			{
				echo "Sorry error while uploading";
			}
		} else
		{
			echo "invalidfile";
		}
	}
	return $upload_image;
}

function uploadreportImage($file_name,$file_temp,$file_type,$file_size,$attach,$loc){
	$upload_image = '';
	$target_folder = "images/Tradephoto/$loc/";
	$target_path = "";
	$file_name = str_replace(" ","_",$file_name);
	$file_name = str_replace(".php","",$file_name);
	$file_name = str_replace("'","",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name) || preg_match("/.PhP/i", $file_name)) {
    	echo "invalidfile";
	}
	else if($file_name != '')
	{
		if((($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png") || ($file_type == "application/pdf")) && $file_size < 2097152)
		{
			$target_path = $target_folder.$attach.'_'.$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				$upload_image = $attach.'_'.$file_name;
			}
			else
			{
				echo "Sorry error while uploading";
			}
		} else
		{
			echo "invalidfile";
		}
	}	
	return $upload_image;
}

function get_data($message,$number) {
	$message=str_replace(" ","%20",$message);
	//$url = 'http://products.tecogis.com/gjepcsmsengine/smsapi/sendsms.asmx/erpapi?action=send&Message='.$message.'&Phone='.$number;
	$url = 'http://products.tecogis.com/gjepcsmsengine/smsapi/sendsms.asmx/smsapi?action=send&Message='.$message.'&Phone='.$number.'&SenderID=GJEPCI';
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;	
}

/* Annu SMS API*/
function send_sms($message,$mobile_no) {
	$message=str_replace(" ","%20",$message);
	$url = 'http://sms.gjepc.org/submitsms.jsp?user=TheGem&key=f2474d18afXX&mobile='.$mobile_no.'&message='.$message.'&senderid=GJECPT&accusage=1';
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function getPremiumName($premium,$conn)
{
	$query_sel = "SELECT premium_desc FROM igjme_premium_master where premium='$premium'";	
	$result_sel = $conn->query($query_sel);								
	if($row = $result_sel->fetch_assoc())		 	
	{ 		
		return $row['premium_desc'];
	}
}
function getExhibitionType($app_id,$conn)
{
	$query_sel = "SELECT permission_type FROM trade_general_info where app_id='$app_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();				
	return $row['permission_type'];
}
function getCommEmail($app_id,$conn)
{
	$query_sel = "SELECT commemail FROM trade_general_info where app_id='$app_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['commemail'];
}
function getMemberName($app_id,$conn)
{
	$query_sel = "SELECT member_name FROM trade_general_info where app_id='$app_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();		
	return $row['member_name'];
}
function getMemberEmail($app_id,$conn)
{
	$query_sel = "SELECT email FROM trade_general_info where app_id='$app_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();		
		return $row['email'];
}
function getPermissionType($app_id,$conn)
{
	$query_sel = "SELECT permission_type FROM trade_general_info where app_id='$app_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();		
	return $row['permission_type'];
}

function number_word_usd($number)
{
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'ONE', '2' => 'TWO',
    '3' => 'THREE', '4' => 'FOUR', '5' => 'FIVE', '6' => 'SIX',
    '7' => 'SEVEN', '8' => 'EIGHT', '9' => 'NINE',
    '10' => 'TEN', '11' => 'ELEVEN', '12' => 'TWELVE',
    '13' => 'THIRTEEN', '14' => 'FOURTEEN',
    '15' => 'FIFTEEN', '16' => 'SIXTEEN', '17' => 'SEVENTEEN',
    '18' => 'EIGHTTEEN', '19' =>'NINETEEN', '20' => 'TWENTY',
    '30' => 'THIRTY', '40' => 'FOURTY', '50' => 'FIFTY',
    '60' => 'SIXTY', '70' => 'SEVENTY',
    '80' => 'EIGHTY', '90' => 'NINETY');
   $digits = array('', 'HUNDRED', 'THOUSAND', 'LAKH', 'CRORE');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? '' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' AND ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
		  
 // $result = " USD ".$result;
  $result = " US$ ".$result;
  if($points!=""){$result=$result.$points . " CENTS";}
  echo $result;
 }
 //For Remove .00 in Invoice
 function containsDecimal( $value ) {
    if ( strpos( $value, "." ) !== false ) {
        return true;
    }
    return false;
}
 
 function getPurposeName($purpose_name)
{
	$query_sel = "SELECT name_brief FROM  purpose_master  where name='$purpose_name'";
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['name_brief'];
		
	}
}

function upload_cheque_dd_scan($file_name,$file_temp,$file_type,$file_size,$attach,$loc){	
	$upload_image = '';
	$target_folder = "images/$loc/";
	$target_path = "";
	$file_name = str_replace(" ","_",$file_name);
	
	if(preg_match("/.php/i", $file_name) || preg_match("/shell/i", $file_name) || preg_match("/.Php/i", $file_name) || preg_match("/.PhP/i", $file_name)){
    		echo "<script langauge=\"javascript\">alert(\"Sorry you have select Invalid file.\");location.href='careers.php';</script>";
			exit;
		}
	else if($file_name != '')
	{
		if((($file_type == "image/JPG") || ($file_type == "image/jpg") || ($file_type == "image/jpeg") || ($file_type == "image/png")) && $file_size < 2097152)
		{
			$target_path = $target_folder.$attach.'_'.$file_name;
			if(@move_uploaded_file($file_temp, $target_path))
			{
				$upload_image = $attach.'_'.$file_name;
			}
			else
			{
				echo "Sorry error while uploading";
			}
		}
		else
		{
			echo "Invalid file";
		}	
	}	
	return $upload_image;
}

function getVisitorDesignation($id,$conn)
{
	$query_sel = "SELECT type_of_designation FROM visitor_designation_master where id='$id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
		return $row['type_of_designation'];
}

function companyName($id,$conn)
{
	$query_comp = "SELECT name FROM `visitor_directory` WHERE `registration_id`='$id'";
	$result = $conn->query($query_comp);
	$row = $result->fetch_assoc();		
		return $row['name'];
}

function VisitorName($id,$conn)
{
	$query_visitor = "SELECT name,lname FROM `visitor_directory` WHERE `visitor_id`='$id'";
	$result = $conn->query($query_visitor);
	$row = $result->fetch_assoc(); 		
		return $row['name']." ".$row['lname'];
}
function VisitorEmail($id,$conn)
{
	$query_visitor = "SELECT email FROM `visitor_directory` WHERE `visitor_id`='$id'";
	$result = $conn->query($query_visitor);
	$row = $result->fetch_assoc(); 		
	return $row['email'];
}
function intlVisitorName($id,$conn)
{
	$query_visitor = "SELECT first_name,last_name FROM `ivr_registration_details` WHERE `eid`='$id'";
	$result = $conn->query($query_visitor);
	$row = $result->fetch_assoc(); 		
		return $row['first_name']." ".$row['last_name'];
}
function intlVisitorEmail($id,$conn)
{
	$query_visitor = "SELECT email FROM `ivr_registration_details` WHERE `eid`='$id'";
	$result = $conn->query($query_visitor);
	$row = $result->fetch_assoc(); 		
		return $row['email'];
}
function intlVisitorMobile($id,$conn)
{
	$query_visitor = "SELECT mob_no FROM `ivr_registration_details` WHERE `eid`='$id'";
	$result = $conn->query($query_visitor);
	$row = $result->fetch_assoc(); 		
		return $row['mob_no'];
}

function getAgencyVisitorName($id,$conn){
		$query_visitor = "SELECT person_name FROM `visitor_agency_registration` WHERE `id`='$id'";
		$result = $conn->query($query_visitor);
		$row = $result->fetch_assoc(); 		
		return $row['person_name'];
}


function VisitorFLName($id,$conn)
{
	$query_visitor = "SELECT name,lname FROM `visitor_directory` WHERE `visitor_id`='$id'";
	$result = $conn->query($query_visitor);
	$row = $result->fetch_assoc();  		
		$full_name=	$row['name'].' '.$row['lname'];
		return $full_name;
}

function getVisitorMobile($id,$conn)
{
	$query_sel = "SELECT mobile FROM visitor_directory where visitor_id='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['mobile'];
}

function getVisitorSDesignation($id,$conn)
{
	$query_sel = "SELECT designation FROM visitor_directory where visitor_id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		 	
		return $row['designation'];
}

function getVisitorPhoto($id,$conn)
{
	$query_sel = "SELECT photo FROM visitor_directory where visitor_id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	 		
	return $row['photo'];
}

function getVisitorId($pan,$conn)
{
	$query_sel = "SELECT visitor_id FROM visitor_directory where pan_no='$pan'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	 		
	return $row['visitor_id'];
}

function getVisitorSecondaryMobile($id,$conn)
{
	$query_sel = "SELECT secondary_mobile FROM visitor_directory where visitor_id='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['secondary_mobile'];
}
function getVisitorSecondaryMobileStatus($id,$conn)
{
	$query_sel = "SELECT isSecondary FROM visitor_directory where visitor_id='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['isSecondary'];
}

function getVisitorPAN($id,$conn)
{
	$query_sel = "SELECT pan_no FROM visitor_directory where visitor_id='$id' ";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();		
	return $row['pan_no'];
}

function aadharNo($regid,$conn)
{
	$query_aadhar = "SELECT aadhar_no FROM `visitor_directory` WHERE `registration_id`='$regid'";
	$result = $conn->query($query_aadhar);
	$row = $result->fetch_assoc(); 		
		return $row['aadhar_no'];
}
/* Approval Status */
function checkApproval_status($regid,$conn)
{
	$query_status = "SELECT visitor_approval FROM `visitor_directory` WHERE `registration_id`='$regid' AND isApplied='Y' AND visitor_approval!='O'";
	$result_status =  $conn ->query($query_status);	
	$movies_id = array();
	while($row = $result_status->fetch_assoc())		 	
	{ 		
		$visitor_approval = $row['visitor_approval'];
		$movies_id[] = $visitor_approval;
		
		/*if($visitor_approval == 'P' ){ $approval_msg = "Pending";}		
		elseif($visitor_approval == 'D' ){ $approval_msg = "Disapproved";}
		elseif($visitor_approval == 'Y' ){ $approval_msg = "Approved";}
		return $approval_msg;*/
	}
	//print_r($movies_id);
	if(in_array("P", $movies_id)) {
		return "Pending";
	}elseif(in_array("D", $movies_id)){
		return "Disapproved";
	}elseif(in_array("U", $movies_id)){
		return "Updated";
	}else{
		return "Approved";
	}
}

/* FACE Approval Status */
function checkFaceApproval_status($regid,$conn)
{
	$query_status = "SELECT face_status FROM `visitor_directory` WHERE `registration_id`='$regid' AND face_isApplied='Y' AND visitor_approval!='O'";
	$result_status =  $conn ->query($query_status);	
	$movies_id = array();
	while($row = $result_status->fetch_assoc())		 	
	{ 		
		$visitor_approval = $row['face_status'];
		$movies_id[] = $visitor_approval;
		
		/*if($visitor_approval == 'P' ){ $approval_msg = "Pending";}		
		elseif($visitor_approval == 'D' ){ $approval_msg = "Disapproved";}
		elseif($visitor_approval == 'Y' ){ $approval_msg = "Approved";}
		return $approval_msg;*/
	}
	//print_r($movies_id);
	if(in_array("P", $movies_id)) {
		return "Pending";
	}elseif(in_array("D", $movies_id)){
		return "Disapproved";
	}elseif(in_array("U", $movies_id)){
		return "Updated";
	}elseif(in_array("Y", $movies_id)){
		return "Approved";
	}else{
		return "Pending";
	}
}


/* Approval Status */

function approve_status($regid,$conn)
{
	$query_status = "SELECT visitor_approval FROM `visitor_directory` WHERE `registration_id`='$regid'";
	$result_status = $conn ->query($query_status);								
	if($row = $result_status->fetch_assoc())		 	
	{ 		
		$approve = $row['visitor_approval'];
		if($approve == 'D' ){ $approve_msg = "Disapproved";}
		elseif($approve == 'P' ){ $approve_msg = "Pending";}
		else{ $approve_msg = "Approved";}
		return $approve_msg;
	}
}

function aes128Encrypt($str,$key){
$block = mcrypt_get_block_size('rijndael_128', 'ecb');
$pad = $block - (strlen($str) % $block);
$str .= str_repeat(chr($pad), $pad);
return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB));
}

function getEventName($orderId,$conn)
{
	$query_show = "SELECT show FROM `visitor_order_history` WHERE `orderId`='$orderId'";
	$result = $conn->query($query_show);
	$row = $result->fetch_assoc(); 		
		return $row['show'];
}

function send_mail($to, $subject, $message,$cc="")
{
	/*Start Config*/
	$account="donotreply@gjepcindia.com";
	$password="kngtnsnqthmysqmp";
	$from="donotreply@gjepcindia.com";
	//$from_name="gjepc.org";
	$from_name="GJEPC INDIA";
	//$cc="";
    /*End Config*/
	
	include("phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';
	$mail->Host = "smtp.office365.com";
	$mail->SMTPAuth= true;
	$mail->Port = 587;
	$mail->Username= $account;
	$mail->Password= $password;
	$mail->SMTPSecure = 'tls';
	$mail->From = $from;
	$mail->FromName= $from_name;
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $message;
	$mail->addAddress($to);
	if($cc!=''){ $mail->AddCC($cc); } 	
	if(!$mail->send()){
	 //return false;
	} else {
	 //return true;
	}
}
//send_mail("mukesh@kwebmaker.com","hi","This is test mail");

function send_mailArray($to, $subject, $message,$cc)
{ 
	/*Start Config*/
	$account="donotreply@gjepcindia.com";
	$password="kngtnsnqthmysqmp";
	$from="donotreply@gjepcindia.com";
	$from_name="GJEPC INDIA";
	// $cc="";
    /*End Config*/
	
	include("phpmailer/class.phpmailer.php");
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->CharSet = 'UTF-8';
	//$mail->Host = "smtp.live.com";
	$mail->Host = "smtp.office365.com";
	$mail->SMTPAuth= true;
	$mail->Port = 587;
	$mail->Username= $account;
	$mail->Password= $password;
	$mail->SMTPSecure = 'tls';
	$mail->From = $from;
	$mail->FromName= $from_name;
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $message;
	foreach($to as $email_to){ $mail->addAddress($email_to); }
	if($cc!=''){ $mail->AddCC($cc); } 	
	if(!$mail->send()){
	 //return false;
	} else {
	 //return true;
	}
}

function getQuarterYear($year,$conn)
{
	$query_aadhar = "SELECT quarter_year FROM `statistics_import_export_quarter_master` WHERE `status`='1' AND quarter_year='$year'";
	$result = $conn->query($query_aadhar);
	$row = $result->fetch_assoc();		
    return $row['quarter_year'];
}

function getQuarterDescription($year,$conn)
{
	$query_aadhar = "SELECT description FROM `statistics_import_export_quarter_master` WHERE `status`='1' AND quarter_year='$year'";
	$result = $conn->query($query_aadhar);
	$row = $result->fetch_assoc();		
    return $row['description'];
}

/* Export */
function getCommodityDescription($hs_code,$conn)
{
    $query_aadhar = "select commodity_description from statistics_integration_hscode_master where hs_code='$hs_code' AND status='1'";
	$result = $conn->query($query_aadhar);
	$row = $result->fetch_assoc();		
    return $row['commodity_description'];
}

function getTariffCommodityDescription($hs_code,$conn)
{
    $query_aadhar = "select commodity_description from statistics_tariff_structure where hs_code='$hs_code'";
	$result = $conn->query($query_aadhar);
	$row = $result->fetch_assoc();		
    return $row['commodity_description'];
}

function getCountryRegion($port,$conn)
{ 
    $query_aadhar = "SELECT regions FROM statistics_integration_country_master where status ='1' AND region_code='$port'";
	$result = $conn->query($query_aadhar);
	$row = $result->fetch_assoc();		
    return $row['regions'];
}

/* Region wise All Commodity */
function getCurrentregionwiseAllINR($finyr,$region,$hs_code,$conn)
{
//$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%'  AND trade_type='Export' ";
$query_inr = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(a.inr_value, ',', '')) as total_inr,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.financial_year='$finyr' AND a.trade_type='Export' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code ";
	$result = $conn->query($query_inr); 
	$row = $result->fetch_assoc();		
    if($row['total_inr']!='')
	{
		$answer = $row['total_inr'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getCurrentregionwiseAllUSD($finyr,$region,$hs_code,$conn)
{
 $query_inr = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(a.dollar_value, ',', '')) as total_usd,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.financial_year='$finyr' AND a.trade_type='Export' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getLastYearRegionINR($last_finyr,$region,$hs_code,$sameYear,$currentMonth,$conn)
{
//	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and hs_code_id like '$hs_code%'  AND trade_type='Export'";
	if($sameYear!='YES'){
	$query_inr = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(inr_value, ',', '')) as total_inr,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.financial_year='$last_finyr' AND a.trade_type='Export' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(inr_value, ',', '')) as total_inr,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND a.trade_type='Export' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code";
	*/
	/* FOR FY */
	$query_inr = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(inr_value, ',', '')) as total_inr,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.financial_year='$last_finyr' AND a.trade_type='Export' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code";
	
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();
	if($row['total_inr']!='')
	{
		$answer = $row['total_inr'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getLastYearRegionUSD($last_finyr,$region,$hs_code,$sameYear,$currentMonth,$conn)
{
//	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and hs_code_id like '$hs_code%' AND trade_type='Export'";
	if($sameYear!='YES'){
	$query_usd = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(dollar_value, ',', '')) as total_usd,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.financial_year='$last_finyr' AND a.trade_type='Export' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(dollar_value, ',', '')) as total_usd,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND a.trade_type='Export' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code";
	*/
	/* FOR FY */
	$query_usd = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(dollar_value, ',', '')) as total_usd,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.financial_year='$last_finyr' AND a.trade_type='Export' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}
/* Region-wise-all-commodity*/
function getLastRegionwisecommodityINR($finyr,$commodity_category,$region,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT a.*,b.*,c.*,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a , statistics_integration_country_master b,statistics_integration_hscode_master c WHERE 1 and a.financial_year='$finyr' and a.trade_type='Export' and a.country_id=b.country_name and a.hs_code_id=c.hs_code and c.level='8' and b.region_code='$region' AND c.commodity_category='$commodity_category'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT a.*,b.*,c.*,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a , statistics_integration_country_master b,statistics_integration_hscode_master c WHERE 1 and a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Export' and a.country_id=b.country_name and a.hs_code_id=c.hs_code and c.level='8' and b.region_code='$region' AND c.commodity_category='$commodity_category'";
	*/
	/* FY */
	$query_inr = "SELECT a.*,b.*,c.*,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a , statistics_integration_country_master b,statistics_integration_hscode_master c WHERE 1 and a.financial_year='$finyr' and a.trade_type='Export' and a.country_id=b.country_name and a.hs_code_id=c.hs_code and c.level='8' and b.region_code='$region' AND c.commodity_category='$commodity_category'";
	
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getLastRegionwisecommodityUSD($finyr,$commodity_category,$region,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT a.*,b.*,c.*,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a , statistics_integration_country_master b,statistics_integration_hscode_master c WHERE 1 and a.financial_year='$finyr' and a.trade_type='Export' and a.country_id=b.country_name and a.hs_code_id=c.hs_code and c.level='8' and b.region_code='$region' AND c.commodity_category='$commodity_category'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT a.*,b.*,c.*,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a , statistics_integration_country_master b,statistics_integration_hscode_master c WHERE 1 and a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Export' and a.country_id=b.country_name and a.hs_code_id=c.hs_code and c.level='8' and b.region_code='$region' AND c.commodity_category='$commodity_category'";
	*/
	/* FOR FY*/
	$query_usd = "SELECT a.*,b.*,c.*,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a , statistics_integration_country_master b,statistics_integration_hscode_master c WHERE 1 and a.financial_year='$finyr' and a.trade_type='Export' and a.country_id=b.country_name and a.hs_code_id=c.hs_code and c.level='8' and b.region_code='$region' AND c.commodity_category='$commodity_category'";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    return $row['total_usd'];
	
}
/* End Region-wise-all-commodity */
function getPreviousRegioncommoditywiseINR($finyr,$commodity_category,$region,$conn)
{
	$query_inr = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Export' AND  a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviousRegioncommoditywiseUSD($finyr,$commodity_category,$region,$conn)
{
	$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Export' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    return $row['total_usd'];
	
}

/* Region wise All Commodity */
/* Country wise All Commodity */
function getCurrentcountrywiseAllINR($finyr,$country,$hs_code,$conn)
{
 $query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Export' ";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    if($row['total_inr']!='')
	{
		$answer = $row['total_inr'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getCurrentcountrywiseAllUSD($finyr,$country,$hs_code,$conn)
{
 $query_inr = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Export'";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getPreviousCountrywiseINR($finyr,$country,$hs_code,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Export' ";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Export'";
	
	/* FOR FY*/
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Export' ";
	
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    if($row['total_inr']!='')
	{
		$answer = $row['total_inr'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getPreviousCountrywiseUSD($finyr,$country,$hs_code,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Export'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Export'";
	*/
	/* FOR FY */
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Export'";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

/* Country wise All Commodity */
function getPreviousCountrycommoditywiseINR($finyr,$commodity_category,$country,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Export' AND a.country_id='$country' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Export' AND a.country_id='$country' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	*/
	/* FOR FY */
	$query_inr = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Export' AND a.country_id='$country' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviousCountrycommoditywiseUSD($finyr,$commodity_category,$country,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Export' AND a.country_id='$country' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Export' AND a.country_id='$country' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	*/
	/* FOR FY */
	$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Export' AND a.country_id='$country' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    return $row['total_usd'];
}
/* Country wise All Commodity */
/* commodity-vs-country  */
function getPreviousFinancialYearCountryINR($last_finyr,$country,$hs_code,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND $hs_code AND country_id='$country' AND trade_type='Export'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND $hs_code AND country_id='$country' AND trade_type='Export'";
	*/
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND $hs_code AND country_id='$country' AND trade_type='Export'";
	
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();
	if($row['total_inr']!='')
	{
		$answer = $row['total_inr'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getPreviousFinancialYearCountryUSD($last_finyr,$country,$hs_code,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND $hs_code and country_id ='$country' AND trade_type='Export'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND $hs_code and country_id ='$country' AND trade_type='Export'";
	*/
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND $hs_code and country_id ='$country' AND trade_type='Export'";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();	 	
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else {
		$answer = 0;
	}
    return $answer;
}
/* commodity-vs-country */
/* End Country wise All Commodity */
/* level Commodity */
function getCurrentcommoditywiseINR($finyr,$hs_code,$conn)
{
 $query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND trade_type='Export' ";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getCurrentcommoditywiseUSD($finyr,$hs_code,$conn)
{
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND trade_type='Export'";
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();
	if($row['total_usd']!='')
	{
		$answer=$row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}
/* level Commodity */
function getPreviouscommoditywiseINR($finyr,$hs_code,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT SUM(ROUND(REPLACE(inr_value, ',', ''))) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND trade_type='Export' ";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT SUM(ROUND(REPLACE(inr_value, ',', ''))) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and hs_code_id like '$hs_code%' AND trade_type='Export' ";
	*/
	$query_inr = "SELECT SUM(ROUND(REPLACE(inr_value, ',', ''))) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND trade_type='Export' ";
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}
/* Start Last Year Specific Commodity */
function getPreviousSpecificcommoditywiseINR($finyr,$commodity_category,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Export' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
		
	$query_inr = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Export' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
	return $row['total_inr'];	
	*/
	
	$query_inr = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Export' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category"; 
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr']; 
	
	}
}

function getPreviousSpecificcommoditywiseUSD($finyr,$commodity_category,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
		$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Export' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
		$result = $conn->query($query_usd);
		$row = $result->fetch_assoc();		
		return $row['total_usd'];	
	} else {
	/*	Sept Code 29/09/2021 25/10/2021
		$arr_string = explode("-",$finyr); 
		$startYear = $arr_string[0];
		$endYear = $arr_string[1];
		$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Export' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
		$result = $conn->query($query_usd);
		$row = $result->fetch_assoc();		
		return $row['total_usd']; 
	*/	
		$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Export' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
		$result = $conn->query($query_usd);
		$row = $result->fetch_assoc();		
		return $row['total_usd'];
	
	}	
}

/* End Last Year Specific Commodity */
function getPreviouscommoditywiseUSD($finyr,$hs_code,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND trade_type='Export'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and hs_code_id like '$hs_code%' AND trade_type='Export'";	
	*/
	$query_usd = "SELECT SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND trade_type='Export'"; 
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();
	if($row['total_usd']!='')
	{
		$answer=$row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

//function getPreviousFinancialYear($last_finyr,$hs_code,$currency,$orderBy,$display_records,$conn){
function getPreviousFinancialYearINR($last_finyr,$hs_code,$conn)
{
  $query_inr = "SELECT SUM(ROUND(REPLACE(inr_value, ',', ''))) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and hs_code_id ='$hs_code' AND trade_type='Export' AND status='1' group by hs_code_id order by inr_value ";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviousFinancialYearUSD($last_finyr,$hs_code,$conn)
{
	$query_usd = "SELECT SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and hs_code_id ='$hs_code' AND trade_type='Export' AND status='1' group by hs_code_id order by dollar_value";
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();
	if($row['total_usd']!='')
	{
		$answer=$row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

/* Country-wise Export */

function getcountrywiseINR($last_finyr,$result_string,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND country_id='$result_string' AND trade_type='Export' AND status='1' group by country_id";
	} else {
	/*	Sept Code 29/09/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND country_id='$result_string' AND trade_type='Export' AND status='1' group by country_id";
	*/
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND country_id='$result_string' AND trade_type='Export' AND status='1' group by country_id";
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();
	if($row['total_inr']!='')
	{
		$answer = $row['total_inr'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getcountrywiseUSD($last_finyr,$result_string,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and country_id ='$result_string' AND trade_type='Export' AND status='1' group by country_id";
	} else {
	/*	Sept Code 29/09/2021
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1]; 
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and country_id ='$result_string' AND trade_type='Export' AND status='1' group by country_id";
	*/
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and country_id ='$result_string' AND trade_type='Export' AND status='1' group by country_id";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}
/* Country-wise Export */
/* Region-wise Export */
function getPreviousFinancialYearRegionINR($last_finyr,$regions,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT SUM(REPLACE(a.inr_value, ',', '')) as total_inr,b.* FROM `statistics_integration_data` a , statistics_integration_country_master b WHERE 1 and a.financial_year='$last_finyr' and a.trade_type='Export' and a.country_id=b.country_name and b.region_code='".$regions."'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT SUM(REPLACE(a.inr_value, ',', '')) as total_inr,b.* FROM `statistics_integration_data` a , statistics_integration_country_master b WHERE 1 and a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Export' and a.country_id=b.country_name and b.region_code='".$regions."'";	
	*/
	/* FOr FY */
	$query_inr = "SELECT SUM(REPLACE(a.inr_value, ',', '')) as total_inr,b.* FROM `statistics_integration_data` a , statistics_integration_country_master b WHERE 1 and a.financial_year='$last_finyr' and a.trade_type='Export' and a.country_id=b.country_name and b.region_code='".$regions."'";
	
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviousFinancialYearRegionUSD($last_finyr,$regions,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(a.dollar_value, ',', '')) as total_usd,b.* FROM `statistics_integration_data` a , statistics_integration_country_master b WHERE 1 and a.financial_year='$last_finyr' and a.trade_type='Export' and a.country_id=b.country_name and b.region_code='".$regions."'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT SUM(REPLACE(a.dollar_value, ',', '')) as total_usd,b.* FROM `statistics_integration_data` a , statistics_integration_country_master b WHERE 1 and a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Export' and a.country_id=b.country_name and b.region_code='".$regions."'";
	*/
	/* FOR FY */
	$query_usd = "SELECT SUM(REPLACE(a.dollar_value, ',', '')) as total_usd,b.* FROM `statistics_integration_data` a , statistics_integration_country_master b WHERE 1 and a.financial_year='$last_finyr' and a.trade_type='Export' and a.country_id=b.country_name and b.region_code='".$regions."'";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

/* Region-wise All Export */
function getLastYearSingleRegionCountryUSD($last_finyr,$country,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and country_id ='$country' AND trade_type='Export'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and country_id ='$country' AND trade_type='Export'";	
	*/
	/* FOR FY */
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and country_id ='$country' AND trade_type='Export'";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getLastYearSingleRegionCountryINR($last_finyr,$country,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND country_id ='$country' AND trade_type='Export'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND country_id ='$country' AND trade_type='Export'";
	*/
	/* FOR FY */
	$query_usd = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and country_id ='$country' AND trade_type='Export'";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_inr']!='')
	{
		$answer = $row['total_inr'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}
/* Region-wise Country End Export */
/* selected region */

function getPreviousSelectedRegionINR($last_finyr,$country,$conn)
{
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND country_id ='$country' AND trade_type='Export'";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr']; 
}

function getPreviousSelectedRegionUSD($last_finyr,$country,$conn)
{
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and country_id ='$country' AND trade_type='Export'";
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}


function getPreviousFinancialYearCRegionINR($last_finyr,$result_string,$conn)
{
	$query_inr = "SELECT SUM(ROUND(REPLACE(inr_value, ',', ''))) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND country_id='$result_string' AND trade_type='Export' AND status='1' group by country_id order by inr_value ";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviousFinancialYearCRegionUSD($last_finyr,$result_string,$conn)
{
	$query_usd = "SELECT SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and country_id ='$result_string' AND trade_type='Export' AND status='1' group by country_id order by dollar_value";
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getPreviousFinancialYearExportValueINR($lastCompairYear,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$lastCompairYear' AND trade_type='Export' AND status='1' group by financial_year order by inr_value";
	} else {
	$arr_string = explode("-",$lastCompairYear); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	/* 2019-2020
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2019-$currentMonth-30' AND trade_type='Export'"; */
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND trade_type='Export'"; 
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviousFinancialYearExportValueUSD($lastCompairYear,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$lastCompairYear' AND trade_type='Export' AND status='1' group by financial_year order by dollar_value";
	} else {
	$arr_string = explode("-",$lastCompairYear); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	/* 2019-2020
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2019-$currentMonth-30' AND trade_type='Export'"; */
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND trade_type='Export'";
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getLastMonthExportValueINR($lastCompairYear,$lastCompairMonths,$conn)
{
   $query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr,DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE 1 AND year='$lastCompairYear' AND MONTH(post_date)='$lastCompairMonths' AND trade_type='Export' AND status='1' group by entry_month";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getLastMonthExportValueUSD($last_finyr,$lastCompairMonths,$conn)
{
   //$query_inr = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd,DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE 1 AND year='$lastCompairYear' AND MONTH(post_date)='$lastCompairMonths' AND trade_type='Export' AND status='1' group by entry_month"; // Comment on 23/05/2022
   $query_inr = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd,DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND MONTH(post_date)='$lastCompairMonths' AND trade_type='Export' AND status='1' group by entry_month";
   $result = $conn->query($query_inr);
   $row = $result->fetch_assoc();		
   if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}
/* Month wise */
function getLastMonthCalendarExportValueINR($calendar_year,$lastCompairMonths,$conn)
{
   $query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$calendar_year-$lastCompairMonths-01' AND '$calendar_year-$lastCompairMonths-31' AND trade_type='Export'";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getLastMonthCalendarExportValueUSD($calendar_year,$lastCompairMonths,$conn)
{
	//SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '2018-01-01' AND '2018-01-31'  AND trade_type='Export' 
	
   $query_inr = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$calendar_year-$lastCompairMonths-01' AND '$calendar_year-$lastCompairMonths-31' AND trade_type='Export'";
   $result = $conn->query($query_inr);
   $row = $result->fetch_assoc();		
   if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}
/* Month wise */
/* Year wise */
function getLastMonthYearExportValueINR($year_calendar_year,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
    $query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$year_calendar_year-01-01' AND '$year_calendar_year-12-31' AND trade_type='Export'";
    } else {
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$year_calendar_year-01-01' AND '$year_calendar_year-$currentMonth-30' AND trade_type='Export'";
    }
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getLastMonthYearExportValueUSD($year_calendar_year,$sameYear,$currentMonth,$conn)
{
   if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$year_calendar_year-01-01' AND '$year_calendar_year-12-31' AND trade_type='Export'";
	} else {
    $query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$year_calendar_year-01-01' AND '$year_calendar_year-$currentMonth-30' AND trade_type='Export'";
	}   
   $result = $conn->query($query_usd);
   $row = $result->fetch_assoc();		
   if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}
/* Year wise */

function getLastFinancialYear($year)
{
			if($year=='2008-2009')
			{
				$c_answer = '2007-2008';
			}
			else if($year=='2009-2010')
			{
				$c_answer = '2008-2009';
			}
			else if($year=='2010-2011')
			{
				$c_answer = '2009-2010';
			}
			else if($year=='2011-2012')
			{
				$c_answer = '2010-2011';
			}
			else if($year=='2012-2013')
			{
				$c_answer = '2011-2012';
			}
			else if($year=='2013-2014')
			{
				$c_answer = '2012-2013';
			}
			else if($year=='2014-2015')
			{
				$c_answer = '2013-2014';
			}
			else if($year=='2015-2016')
			{
				$c_answer = '2014-2015';
			}		
			else if($year=='2016-2017')
			{
				$c_answer = '2015-2016';
			}
			else if($year=='2017-2018')
			{
				$c_answer = '2016-2017';
			}
			else if($year=='2018-2019')
			{
				$c_answer = '2017-2018';
			}
			else if($year=='2019-2020')
			{
				$c_answer = '2018-2019';
			}
			else if($year=='2020-2021')
			{
				$c_answer = '2019-2020';
			}
			else if($year=='2021-2022')
			{
				$c_answer = '2020-2021';
			}
			return $c_answer;
}

function getLastMonths($year)
{			
			if($year=='2008')
			{
				$c_answer = '2007';
			}
			else if($year=='2009')
			{
				$c_answer = '2008';
			}
			else if($year=='2010')
			{
				$c_answer = '2009';
			}
			else if($year=='2011')
			{
				$c_answer = '2010';
			}
			else if($year=='2012')
			{
				$c_answer = '2011';
			}
			else if($year=='2013')
			{
				$c_answer = '2012';
			}
			else if($year=='2014')
			{
				$c_answer = '2013';
			}
			else if($year=='2015')
			{
				$c_answer = '2014';
			}	
			else if($year=='2016')
			{
				$c_answer = '2015';
			}
			else if($year=='2017')
			{
				$c_answer = '2016';
			}
			else if($year=='2018')
			{
				$c_answer = '2017';
			}
			else if($year=='2019')
			{
				$c_answer = '2018';
			}
			else if($year=='2020')
			{
				$c_answer = '2019';
			}
			else if($year=='2021')
			{
				$c_answer = '2020';
			}
			else if($year=='2022')
			{
				$c_answer = '2021';
			}
			return $c_answer;
}

function getCommodityUnit($hs_code,$conn)
{
	$query_aadhar = "select unit from statistics_integration_hscode_master where hs_code='$hs_code' AND status='1'";
	$result = $conn->query($query_aadhar);
	$row = $result->fetch_assoc();		
    return $row['unit'];
}

function getINRCurrencyType($values)
{
	if($values=='100000')
	{
		$c_answer = 'INR Lakhs';
	}
	else if($values=='10000000')
	{
		$c_answer = 'INR Crores';
	}			
	return $c_answer;
}

function getUSDCurrencyType($values)
{
	if($values=='1000')
	{
		$c_answer = 'US $ Thousand';
	}
	else if($values=='1000000')
	{
		$c_answer = 'US $ Million';
	}
	else if($values=='1000000000')
	{
		$c_answer = 'US $ Billion';
	}			
	return $c_answer;
}

/* Export */







/* Import */
function getPreviousFinancialYearImportINR($last_finyr,$hs_code,$conn)
{
  $query_inr = "SELECT SUM(ROUND(REPLACE(inr_value, ',', ''))) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and hs_code_id ='$hs_code' AND trade_type='Import' AND status='1' group by hs_code_id order by inr_value ";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviousFinancialYearImportUSD($last_finyr,$hs_code,$conn)
{
	$query_usd = "SELECT SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and hs_code_id ='$hs_code' AND trade_type='Import' AND status='1' group by hs_code_id order by dollar_value";
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();
	if($row['total_usd']!='')
	{
		$answer=$row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getPreviousFinancialYearCountryImportINR($last_finyr,$result_string,$hs_code,$conn)
{
	$query_inr = "SELECT SUM(ROUND(REPLACE(inr_value, ',', ''))) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and hs_code_id ='$hs_code' AND country_id='$result_string' AND trade_type='Import' AND status='1' group by country_id order by inr_value ";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviousFinancialYearCountryImportUSD($last_finyr,$result_string,$hs_code,$conn)
{
	$query_usd = "SELECT SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and hs_code_id ='$hs_code' and country_id ='$result_string' AND trade_type='Import' AND status='1' group by country_id order by dollar_value";
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getPreviousFinancialYearRegionImportINR($last_finyr,$port_id,$conn)
{
	$query_inr = "SELECT SUM(ROUND(REPLACE(inr_value, ',', ''))) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and port_id ='$port_id' AND trade_type='Import' AND status='1' group by port_id order by inr_value ";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviousFinancialYearRegionImportUSD($last_finyr,$port_id,$conn)
{
	$query_usd = "SELECT SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and port_id ='$port_id' AND trade_type='Import' AND status='1' group by port_id order by dollar_value";
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getPreviousFinancialYearCRegionImportINR($last_finyr,$result_string,$conn)
{
	$query_inr = "SELECT SUM(ROUND(REPLACE(inr_value, ',', ''))) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND country_id='$result_string' AND trade_type='Import' AND status='1' group by country_id order by inr_value ";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviousFinancialYearCRegionImportUSD($last_finyr,$result_string,$conn)
{
	$query_usd = "SELECT SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and country_id ='$result_string' AND trade_type='Import' AND status='1' group by country_id order by dollar_value";
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

/* Value wise Import */
function getPreviousFinancialYearImportValueINR_i($lastCompairYear,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$lastCompairYear' AND trade_type='Import' AND status='1' group by financial_year order by inr_value";
	} else {
	$arr_string = explode("-",$lastCompairYear); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	/* 2019-2020
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2019-$currentMonth-30' AND trade_type='Import' AND status='1' group by financial_year order by inr_value";
	*/
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND trade_type='Import' AND status='1' group by financial_year order by inr_value";
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviousFinancialYearImportValueUSD_i($lastCompairYear,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$lastCompairYear' AND trade_type='Import' AND status='1' group by financial_year order by dollar_value";
	} else {
	$arr_string = explode("-",$lastCompairYear); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	/* 2019-2020
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2019-$currentMonth-30' AND trade_type='Import' AND status='1' group by financial_year order by dollar_value"; */
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND trade_type='Import' AND status='1' group by financial_year order by dollar_value";
	}	
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

/* Year wise */
function getLastMonthYearImportValueINR_i($year_calendar_year,$sameYear,$currentMonth,$conn)
{
   if($sameYear!='YES'){
    $query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$year_calendar_year-01-01' AND '$year_calendar_year-12-31' AND trade_type='Import'";
	} else {
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$year_calendar_year-01-01' AND '$year_calendar_year-$currentMonth-30' AND trade_type='Import'";   
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getLastMonthYearImportValueUSD_i($year_calendar_year,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$year_calendar_year-01-01' AND '$year_calendar_year-12-31' AND trade_type='Import'";
	} else {
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$year_calendar_year-01-01' AND '$year_calendar_year-$currentMonth-30' AND trade_type='Import'";
	}
   $result = $conn->query($query_usd);
   $row = $result->fetch_assoc();		
   if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}
/* Year wise */

function getLastMonthImportValueINR_i($lastCompairYear,$lastCompairMonths,$conn)
{
   $query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr,DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE 1 AND year='$lastCompairYear' AND MONTH(post_date)='$lastCompairMonths' AND trade_type='Import' AND status='1' group by entry_month";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getLastMonthImportValueUSD_i($last_finyr,$lastCompairMonths,$conn)
{
   //$query_inr = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd,DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE 1 AND year='$lastCompairYear' AND MONTH(post_date)='$lastCompairMonths' AND trade_type='Import' AND status='1' group by entry_month";
   $query_inr = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd,DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND MONTH(post_date)='$lastCompairMonths' AND trade_type='Import' AND status='1' group by entry_month";
   $result = $conn->query($query_inr);
   $row = $result->fetch_assoc();		
   if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

/* level Commodity */
function getCurrentcommoditywiseINR_i($finyr,$hs_code,$conn)
{
 $query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND trade_type='Import' ";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getCurrentcommoditywiseUSD_i($finyr,$hs_code,$conn)
{
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND trade_type='Import'";
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();
	if($row['total_usd']!='')
	{
		$answer=$row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getPreviouscommoditywiseINR_i($finyr,$hs_code,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT SUM(ROUND(REPLACE(inr_value, ',', ''))) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND trade_type='Import' ";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT SUM(ROUND(REPLACE(inr_value, ',', ''))) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and hs_code_id like '$hs_code%' AND trade_type='Import' ";
	*/
	$query_inr = "SELECT SUM(ROUND(REPLACE(inr_value, ',', ''))) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND trade_type='Import'"; 
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviouscommoditywiseUSD_i($finyr,$hs_code,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND trade_type='Import'";
	} else {
	/*	Sept Code 29/09/2021 251/10/2021
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and hs_code_id like '$hs_code%' AND trade_type='Import'";
	*/
	$query_usd = "SELECT SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND trade_type='Import'"; 
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();
	if($row['total_usd']!='')
	{
		$answer=$row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

/* Start Last Year Specific Commodity */
function getPreviousSpecificcommoditywiseINR_i($finyr,$commodity_category,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Import' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Import' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";	
	*/
	$query_inr = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Import' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviousSpecificcommoditywiseUSD_i($finyr,$commodity_category,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Import' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Import' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	*/
	$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Import' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    return $row['total_usd'];
}
/* End Last Year Specific Commodity */

/* commodity-vs-country */
function getPreviousFinancialYearCountryINR_i($last_finyr,$country,$hs_code,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND $hs_code AND country_id='$country' AND trade_type='Import'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND $hs_code AND country_id='$country' AND trade_type='Import'";
	*/
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND $hs_code AND country_id='$country' AND trade_type='Import'";
	
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();
	if($row['total_inr']!='')
	{
		$answer = $row['total_inr'];
	} else {
		$answer = 0;
	}
    return $answer;
}

function getPreviousFinancialYearCountryUSD_i($last_finyr,$country,$hs_code,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND $hs_code and country_id ='$country' AND trade_type='Import'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND $hs_code and country_id ='$country' AND trade_type='Import'";
	*/
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND $hs_code and country_id ='$country' AND trade_type='Import'";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else {
		$answer = 0;
	}
    return $answer;
}
/* commodity-vs-country */

/* Country wise Import */
function getcountrywiseINR_i($last_finyr,$result_string,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND country_id='$result_string' AND trade_type='Import' AND status='1' group by country_id";
	} else {
	/*	Sept Code 29/09/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND country_id='$result_string' AND trade_type='Import' AND status='1' group by country_id";
	*/
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND country_id='$result_string' AND trade_type='Import' AND status='1' group by country_id";
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();
	if($row['total_inr']!='')
	{
		$answer = $row['total_inr'];
	} else {
		$answer = 0;
	}
    return $answer;
}

function getcountrywiseUSD_i($last_finyr,$result_string,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and country_id ='$result_string' AND trade_type='Import' AND status='1' group by country_id";
	} else {
	/*	Sept Code 29/09/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and country_id ='$result_string' AND trade_type='Import' AND status='1' group by country_id";	
	*/
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and country_id ='$result_string' AND trade_type='Import' AND status='1' group by country_id";
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else {
		$answer = 0;
	}
    return $answer;
}

/* Country wise All Commodity Import */
function getCurrentcountrywiseAllINR_i($finyr,$country,$hs_code,$conn)
{
 $query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Import' ";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    if($row['total_inr']!='')
	{
		$answer = $row['total_inr'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getCurrentcountrywiseAllUSD_i($finyr,$country,$hs_code,$conn)
{
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Import'";
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getPreviousCountrywiseINR_i($finyr,$country,$hs_code,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Import' ";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Import' ";
	*/
	/* FOR FY */
	$query_inr = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Import' ";
	
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    if($row['total_inr']!='')
	{
		$answer = $row['total_inr'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getPreviousCountrywiseUSD_i($finyr,$country,$hs_code,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Import'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Import'";
	*/
	/* FOR FY */
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$finyr' and hs_code_id like '$hs_code%' AND country_id='$country' AND trade_type='Import'";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}
/* Country wise All Commodity */

/* Country wise All Commodity */
function getPreviousCountrycommoditywiseINR_i($finyr,$commodity_category,$country,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Import' AND a.country_id='$country' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Import' AND a.country_id='$country' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	*/
	/* FOR FY */
	$query_inr = "SELECT a.*,b.commodity_category,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Import' AND a.country_id='$country' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviousCountrycommoditywiseUSD_i($finyr,$commodity_category,$country,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Import' AND a.country_id='$country' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Import' AND a.country_id='$country' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	*/
	/* FOR FY */
	$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='Import' AND a.country_id='$country' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    return $row['total_usd'];
}
/* Country wise All Commodity */

/* Region-wise Import */
function getPreviousFinancialYearRegionINR_i($last_finyr,$regions,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT SUM(REPLACE(a.inr_value, ',', '')) as total_inr,b.* FROM `statistics_integration_data` a , statistics_integration_country_master b WHERE 1 and a.financial_year='$last_finyr' and a.trade_type='Import' and a.country_id=b.country_name and b.region_code='".$regions."'";
	} else {
	/*	Sept Code 29/09/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT SUM(REPLACE(a.inr_value, ',', '')) as total_inr,b.* FROM `statistics_integration_data` a , statistics_integration_country_master b WHERE 1 and a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Import' and a.country_id=b.country_name and b.region_code='".$regions."'";
	*/
	/* FOR FY */
	$query_inr = "SELECT SUM(REPLACE(a.inr_value, ',', '')) as total_inr,b.* FROM `statistics_integration_data` a , statistics_integration_country_master b WHERE 1 and a.financial_year='$last_finyr' and a.trade_type='Import' and a.country_id=b.country_name and b.region_code='".$regions."'";
	
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getPreviousFinancialYearRegionUSD_i($last_finyr,$regions,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(a.dollar_value, ',', '')) as total_usd,b.* FROM `statistics_integration_data` a , statistics_integration_country_master b WHERE 1 and a.financial_year='$last_finyr' and a.trade_type='Import' and a.country_id=b.country_name and b.region_code='".$regions."'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT SUM(REPLACE(a.dollar_value, ',', '')) as total_usd,b.* FROM `statistics_integration_data` a , statistics_integration_country_master b WHERE 1 and a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Import' and a.country_id=b.country_name and b.region_code='".$regions."'";
	*/
	/* FOR FY */
	$query_usd = "SELECT SUM(REPLACE(a.dollar_value, ',', '')) as total_usd,b.* FROM `statistics_integration_data` a , statistics_integration_country_master b WHERE 1 and a.financial_year='$last_finyr' and a.trade_type='Import' and a.country_id=b.country_name and b.region_code='".$regions."'";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else {
		$answer = 0;
	}
    return $answer;
}
/* Region-wise All Import */
function getLastYearSingleRegionCountryUSD_i($last_finyr,$country,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' AND country_id ='$country' AND trade_type='Import'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND country_id ='$country' AND trade_type='Import'";
	*/
	/* FOR FY */
	$query_usd = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and country_id ='$country' AND trade_type='Import'";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else {
		$answer = 0;
	}
    return $answer;
}

function getLastYearSingleRegionCountryINR_i($last_finyr,$country,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and country_id ='$country' AND trade_type='Import'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and country_id ='$country' AND trade_type='Import'";
	*/
	$query_usd = "SELECT SUM(REPLACE(inr_value, ',', '')) as total_inr FROM `statistics_integration_data` WHERE 1 AND financial_year='$last_finyr' and country_id ='$country' AND trade_type='Import'";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_inr']!='')
	{
		$answer = $row['total_inr'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}
/* Region-wise Country End Import */

/* Region wise All Commodity */
function getCurrentregionwiseAllINR_i($finyr,$region,$hs_code,$conn)
{
$query_inr = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(a.inr_value, ',', '')) as total_inr,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.financial_year='$finyr' AND a.trade_type='Import' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code ";
	$result = $conn->query($query_inr); 
	$row = $result->fetch_assoc();		
    if($row['total_inr']!='')
	{
		$answer = $row['total_inr'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getCurrentregionwiseAllUSD_i($finyr,$region,$hs_code,$conn)
{
 $query_inr = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(a.dollar_value, ',', '')) as total_usd,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.financial_year='$finyr' AND a.trade_type='Import' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code";
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getLastYearRegionINR_i($last_finyr,$region,$hs_code,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(inr_value, ',', '')) as total_inr,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.financial_year='$last_finyr' AND a.trade_type='Import' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021*/
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(inr_value, ',', '')) as total_inr,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND a.trade_type='Import' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code";
	/* FY 
	$query_inr = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(inr_value, ',', '')) as total_inr,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.financial_year='$last_finyr' AND a.trade_type='Import' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code";
	*/
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();
	if($row['total_inr']!='')
	{
		$answer = $row['total_inr'];
	} else {
		$answer = 0;
	}
    return $answer;
}

function getLastYearRegionUSD_i($last_finyr,$region,$hs_code,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(dollar_value, ',', '')) as total_usd,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.financial_year='$last_finyr' AND a.trade_type='Import' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$last_finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(dollar_value, ',', '')) as total_usd,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' AND a.trade_type='Import' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code";
	*/
	/* FOR FY */
	$query_usd = "SELECT a.`financial_year`, a.`country_id`,a.`hs_code_id`, SUM(REPLACE(dollar_value, ',', '')) as total_usd,b.*,c.`hs_code`,c.`level` FROM `statistics_integration_data` a ,statistics_integration_country_master b ,statistics_integration_hscode_master c WHERE 1 AND a.financial_year='$last_finyr' AND a.trade_type='Import' AND ( a.hs_code_id like '$hs_code%' ) and a.country_id=b.country_name and b.region_code='$region' and a.hs_code_id=c.hs_code";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else {
		$answer = 0;
	}
    return $answer;
}
/* Region-wise-all-commodity*/

/* Region-wise-all-commodity*/
function getLastRegionwisecommodityINR_i($finyr,$commodity_category,$region,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_inr = "SELECT a.*,b.*,c.*,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a , statistics_integration_country_master b,statistics_integration_hscode_master c WHERE 1 and a.financial_year='$finyr' and a.trade_type='Import' and a.country_id=b.country_name and a.hs_code_id=c.hs_code and c.level='8' and b.region_code='$region' AND c.commodity_category='$commodity_category'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_inr = "SELECT a.*,b.*,c.*,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a , statistics_integration_country_master b,statistics_integration_hscode_master c WHERE 1 and a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Import' and a.country_id=b.country_name and a.hs_code_id=c.hs_code and c.level='8' and b.region_code='$region' AND c.commodity_category='$commodity_category'";
	*/
	/* FOR FY */
	$query_inr = "SELECT a.*,b.*,c.*,sum(REPLACE(a.inr_value, ',', '')) as `total_inr` FROM `statistics_integration_data` a , statistics_integration_country_master b,statistics_integration_hscode_master c WHERE 1 and a.financial_year='$finyr' and a.trade_type='Import' and a.country_id=b.country_name and a.hs_code_id=c.hs_code and c.level='8' and b.region_code='$region' AND c.commodity_category='$commodity_category'";
	
	}
	$result = $conn->query($query_inr);
	$row = $result->fetch_assoc();		
    return $row['total_inr'];
}

function getLastRegionwisecommodityUSD_i($finyr,$commodity_category,$region,$sameYear,$currentMonth,$conn)
{
	if($sameYear!='YES'){
	$query_usd = "SELECT a.*,b.*,c.*,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a , statistics_integration_country_master b,statistics_integration_hscode_master c WHERE 1 and a.financial_year='$finyr' and a.trade_type='Import' and a.country_id=b.country_name and a.hs_code_id=c.hs_code and c.level='8' and b.region_code='$region' AND c.commodity_category='$commodity_category'";
	} else {
	/*	Sept Code 29/09/2021 25/10/2021 
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	$query_usd = "SELECT a.*,b.*,c.*,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a , statistics_integration_country_master b,statistics_integration_hscode_master c WHERE 1 and a.post_date BETWEEN '$startYear-04-01' AND '2020-$currentMonth-30' and a.trade_type='Import' and a.country_id=b.country_name and a.hs_code_id=c.hs_code and c.level='8' and b.region_code='$region' AND c.commodity_category='$commodity_category'";
	*/
	/* FOR FY */
	$query_usd = "SELECT a.*,b.*,c.*,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a , statistics_integration_country_master b,statistics_integration_hscode_master c WHERE 1 and a.financial_year='$finyr' and a.trade_type='Import' and a.country_id=b.country_name and a.hs_code_id=c.hs_code and c.level='8' and b.region_code='$region' AND c.commodity_category='$commodity_category'";
	
	}
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    return $row['total_usd'];
}

/* Import */ 
/* Mini Dashboard */
function getMiniLastMonthExportValueUSD($lastCompairYear,$lastCompairMonths,$conn)
{
   $query_inr = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd,DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE 1 AND year='$lastCompairYear' AND MONTH(post_date)='$lastCompairMonths' AND trade_type='Export' AND status='1' group by entry_month";
   $result = $conn->query($query_inr);
   $row = $result->fetch_assoc();		
   if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getMiniLastMonthImportValueUSD($lastCompairYear,$lastCompairMonths,$conn)
{
   $query_inr = "SELECT SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd,DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE 1 AND year='$lastCompairYear' AND MONTH(post_date)='$lastCompairMonths' AND trade_type='Import' AND status='1' group by entry_month";
   $result = $conn->query($query_inr);
   $row = $result->fetch_assoc();		
   if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getMiniLastFYExportValueUSD($lastCompairYear,$month,$conn)
{	
	$lastYear = date("Y")-1;
	$lastYearMothDate = date("Y-m-d", strtotime("-1 years")); //Getting last year’s date
//	$sqlFYExport = "SELECT `financial_year`, SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE financial_year='$lastCompairYear' AND post_date BETWEEN '$lastYear-04-01' AND '$lastYear-$month-30' AND trade_type='Export' group by financial_year";
// Commented for last sept wala ye tha 29/09/2021
//	$sqlFYExport = "SELECT `financial_year`, SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE financial_year='$lastCompairYear' AND post_date BETWEEN '2019-04-01' AND '2019-$month-30' AND trade_type='Export' group by financial_year";
// 19/05/2022	$sqlFYExport = "SELECT `financial_year`, SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE financial_year='$lastCompairYear' AND post_date BETWEEN '2020-04-01' AND '2020-$month-30' AND trade_type='Export' group by financial_year";
	$sqlFYExport = "SELECT `financial_year`, SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE financial_year='$lastCompairYear' AND post_date BETWEEN '2020-04-01' AND '2021-$month-31' AND trade_type='Export' group by financial_year";
   $result = $conn->query($sqlFYExport);
   $row = $result->fetch_assoc();		
   if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getMiniLastFYImportValueUSD($lastCompairYear,$month,$conn)
{	
	$lastYear = date("Y")-1;
	$lastYearMothDate = date("Y-m-d", strtotime("-1 years")); //Getting last year’s date
//	$sqlFYExport = "SELECT `financial_year`, SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE financial_year='$lastCompairYear' AND post_date BETWEEN '$lastYear-04-01' AND '$lastYear-$month-30' AND trade_type='Import' group by financial_year";
// Commented for last sept wala ye tha 29/09/2021
// $sqlFYExport = "SELECT `financial_year`, SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE financial_year='$lastCompairYear' AND post_date BETWEEN '2019-04-01' AND '2019-$month-30' AND trade_type='Import' group by financial_year";
// 19/05/2022	$sqlFYExport = "SELECT `financial_year`, SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE financial_year='$lastCompairYear' AND post_date BETWEEN '2020-04-01' AND '2020-$month-30' AND trade_type='Import' group by financial_year";
	$sqlFYExport = "SELECT `financial_year`, SUM(ROUND(REPLACE(dollar_value, ',', ''))) as total_usd FROM `statistics_integration_data` WHERE financial_year='$lastCompairYear' AND post_date BETWEEN '2020-04-01' AND '2021-$month-31' AND trade_type='Import' group by financial_year";
   $result = $conn->query($sqlFYExport);
   $row = $result->fetch_assoc();		
   if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getMiniLastMonthExportValueUSDxx($lastCompairYear,$lastCompairMonths,$conn)
{
   $query_inr = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd,DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE 1 AND year='$lastCompairYear' AND MONTH(post_date)='$lastCompairMonths' AND trade_type='Export' group by entry_month";
   $result = $conn->query($query_inr);
   $row = $result->fetch_assoc();		
   if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getMiniLastMonthChartExportValueUSD($lastCompairYear,$lastCompairMonths,$type,$conn)
{
	$query_inr = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd,DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE 1 AND year='$lastCompairYear' AND MONTH(post_date)='$lastCompairMonths' AND trade_type='$type' group by entry_month";
// $query_inr = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd,DATE_FORMAT(post_date,'%M') as entry_month FROM `statistics_integration_data` WHERE 1 AND (post_date BETWEEN '2018-03-01' AND '2019-03-31' AND financial_year='2018-2019') AND MONTH(post_date)='$lastCompairMonths' AND trade_type='Export' group by entry_month";
   $result = $conn->query($query_inr);
   $row = $result->fetch_assoc();		
   if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	} else 
	{
		$answer = 0;
	}
    return $answer;
}

function getMiniLastMonthImportValueUSDxx($lastCompairYear,$lastCompairMonths,$conn)
{
   $query_inr = "SELECT SUM(REPLACE(dollar_value, ',', '')) as total_usd,DATE_FORMAT(post_date,'%Y-%m') as entry_month FROM `statistics_integration_data` WHERE 1 AND year='$lastCompairYear' AND MONTH(post_date)='$lastCompairMonths' AND trade_type='Import' group by entry_month";
   $result = $conn->query($query_inr);
   $row = $result->fetch_assoc();		
   if($row['total_usd']!='')
	{
		$answer = $row['total_usd'];
	}  else 
	{
		$answer = 0;
	}
    return $answer;
}

function getMiniPreviouscommoditywiseUSD($finyr,$commodity_category,$type,$conn)
{
	$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' and a.trade_type='$type' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    return $row['total_usd'];
}

function getMiniPreviouscommodityMonthwiseUSD($finyr,$commodity_category,$type,$month,$conn)
{
	$arr_string = explode("-",$finyr); 
	$startYear = $arr_string[0];
	$endYear = $arr_string[1];
	/* 25-10-2021	2019-2020
	$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' AND a.post_date BETWEEN '$startYear-04-01' AND '2019-$month-30' and a.trade_type='$type' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category"; */
	
	$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' AND a.post_date BETWEEN '$startYear-04-01' AND '2020-$month-30' and a.trade_type='$type' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    return $row['total_usd'];
}

function getMiniPreviouscommoditySingleMonthUSD($finyr,$commodity_category,$type,$month,$conn)
{
	$query_usd = "SELECT a.*,b.commodity_category,sum(REPLACE(a.dollar_value, ',', '')) as `total_usd` FROM `statistics_integration_data` a,statistics_integration_hscode_master b WHERE 1 AND a.financial_year='$finyr' AND MONTH(a.post_date)='$month' and a.trade_type='$type' and a.hs_code_id=b.hs_code and b.commodity_category='$commodity_category' and b.level='8' group by b.commodity_category";
	$result = $conn->query($query_usd);
	$row = $result->fetch_assoc();		
    return $row['total_usd'];
} 

function getFinancialYear($conn)
{
	/* 25-10-2021 $query_finYear = "SELECT financial_year FROM statistics_integration_data where financial_year='2020-2021' order by post_date desc limit 1"; */
	$query_finYear = "SELECT financial_year FROM statistics_integration_data where financial_year='2021-2022' order by post_date desc limit 1";
	$result = $conn->query($query_finYear);
	$row = $result->fetch_assoc();							
	return $row['financial_year'];
}

function getCurrentMonth($conn)
{
	/* 25-10-2021 $query_month = "SELECT DATE_FORMAT(post_date,'%m') as month FROM statistics_integration_data where financial_year='2020-2021' order by post_date desc limit 1"; */
	$query_month = "SELECT DATE_FORMAT(post_date,'%m') as month FROM statistics_integration_data where financial_year='2021-2022' order by post_date desc limit 1";
	$result = $conn->query($query_month);
	$row = $result->fetch_assoc();							
	return $row['month'];
}

function getCurrentMonthName($conn)
{
	/*25-10-2021 $query_month = "SELECT DATE_FORMAT(post_date,'%M') as month FROM statistics_integration_data where financial_year='2020-2021' order by post_date desc limit 1"; */
	$query_month = "SELECT DATE_FORMAT(post_date,'%M') as month FROM statistics_integration_data where financial_year='2021-2022' order by post_date desc limit 1";
	$result = $conn->query($query_month);
	$row = $result->fetch_assoc();
	$month = getMonthShortName($row['month']);
	return $month;
}

function getMonthShortName($month)
{
	if($month=='January'){	$c_answer = 'JAN'; }
	else if($month=='February'){ $c_answer = 'FEB'; }
	else if($month=='March'){ $c_answer = 'MAR';	}			
	else if($month=='April'){ $c_answer = 'APR';	}			
	else if($month=='May'){ $c_answer = 'MAY';	}			
	else if($month=='June'){ $c_answer = 'JUNE';	}			
	else if($month=='July'){ $c_answer = 'JULY';	}			
	else if($month=='August'){ $c_answer = 'AUG';	}			
	else if($month=='September'){ $c_answer = 'SEPT';	}			
	else if($month=='October'){ $c_answer = 'OCT';	}			
	else if($month=='November'){ $c_answer = 'NOV';	}			
	else if($month=='December'){ $c_answer = 'DEC';	}			
	return $c_answer;
}

function ninjaxMailCheck($email){
   if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $mailParts = explode('@', $email);
     
    if(checkdnsrr(array_pop($mailParts), 'MX')){ return true;}
        else{return false;}
    }
   else{return false;}    
}

function getExportValue($registration_id,$conn)
{
	$query_aadhar = "SELECT export_total FROM `challan_master` WHERE `registration_id`='$registration_id' AND challan_financial_year='2021'";
	$result = $conn->query($query_aadhar);
	$row = $result->fetch_assoc();							
	return $row['export_total'];
}

function getTotal_Value($registration_id,$conn)
{
	$query_Total = "SELECT total_payable FROM `challan_master` WHERE `registration_id`='$registration_id' AND challan_financial_year='2021'";
	$result = $conn->query($query_Total);
	$row = $result->fetch_assoc();							
	return $row['total_payable'];
}

function getNewsIdBySection($section,$conn)
{
	$query_Total = "SELECT id FROM `news_master` WHERE `section`='$section' AND status='1'";
	$result = $conn->query($query_Total);
	$row = $result->fetch_assoc();							
	return $row['id'];
}

function isApplied_for_parichay($registration_id,$conn)
{
	$query_Total = "select parichay_type from registration_master where id='$registration_id' AND website='parichay' LIMIT 1";
	$result = $conn->query($query_Total);
	$row = $result->fetch_assoc();
	/*if($row['parichay_type']=='association')
	{
		$type = $row['parichay_type'];
	}
	else if($row['parichay_type']=='company')
	{
		$type = $row['parichay_type'];
	} */
	return $row['parichay_type'];
}

function getParichay_status($registration_id,$conn)
{
	$query_Total = "select parichay_status from parichay_card where registration_id='$registration_id' LIMIT 1";
	$result = $conn->query($query_Total);
	$row = $result->fetch_assoc();
	return $row['parichay_status'];
}

function no_of_parichay_card($registration_id,$conn)
{
	$query_Total = "select no_of_parichay_card from parichay_card where registration_id='$registration_id' LIMIT 1";
	$result = $conn->query($query_Total);
	$row = $result->fetch_assoc();
	return $row['no_of_parichay_card'];
}

function association_head_mobile_no1($registration_id,$conn)
{
	$query_Total = "select association_head_mobile_no1 from parichay_card where registration_id='$registration_id' LIMIT 1";
	$result = $conn->query($query_Total);
	$row = $result->fetch_assoc();
	return $row['association_head_mobile_no1'];
}

function createSlug($table,$field,$title,$conn){
    $slug = '';    
    $slug = preg_replace('/[^a-z0-9]+/i', '-', trim(strtolower($title)));
     
      $query = "SELECT ".$field." FROM ".$table." WHERE ".$field." LIKE '$slug%'";
    $query_result = $conn->query($query);
       $count =   $query_result->num_rows;
    if($count > 0){
        while($row_slug = $query_result->fetch_assoc() ){
              $data[] = $row_slug[$field];
        }
      
        if(in_array($slug, $data))
           {
            $countslug = 0;
            while( in_array( ($slug . '-' . ++$countslug ), $data) );
            $slug = $slug . '-' . $count;
        }
    }
    return $slug; 
}

/* WhatsApp Integration Functions */

/*** SEND OPTIN API whatsapp */

function sendOPTIN($mobile)
{
	$mobile = trim($mobile);
	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=OPT_IN&format=json&userid=2000193706&password=dCtjkxnX&phone_number=".$mobile;
	
/*Dev	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=OPT_IN&format=json&userid=2000193705&password=S%23FgLwhc&phone_number=".$mobile; */
	$url.="&v=1.1&auth_scheme=plain&channel=WHATSAPP";
	
	//$headers = array("Content-Type: application/json");
				 
    $curl = curl_init();
    $timeout = 5;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	
    $response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
		//header('Content-type: application/json');
		return $response;
	// echo $response;
	}
}

/*** SEND New Membership Templates API whatsapp */
function sendNewMembership($mobile)
{
	$mobile = trim($mobile);

	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=SendMessage&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$mobile."&v=1.1&auth_scheme=plain&msg_type=TEXT";
	$url.="&msg=Dear%20Sir%2C%20we%20have%20received%20your%20application%20for%20new%20membership%2C%20your%20application%20will%20be%20processed%20shortly%2C%20if%20any%20deficiency%20found%20during%20scrutiny%20of%20membership%20application%2C%20team%20will%20revert%20to%20you%20shortly.";
	//$url.="&isTemplate=true&buttonUrlParam=abcdxyz";

	//$headers = array("Content-Type: application/json");
				 
    $curl = curl_init();
    $timeout = 5;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	
    $response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
		//header('Content-type: application/json');
		return $response;
	// echo $response;
	}
}

/*** SEND Renewal Membership Templates API whatsapp */
function sendRenewalMembership($mobile)
{
	$mobile = trim($mobile);

	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=SendMessage&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$mobile."&v=1.1&auth_scheme=plain&msg_type=TEXT";
	$url.="&msg=Dear%20member%20we%20have%20received%20your%20payment%20for%20renewal%20of%20membership%2C%20you%20will%20receive%20your%20membership%20certificate%20on%20your%20dashboard%20within%20next%20four%20working%20days%20after%20confirmation%20of%20payment%20in%20bank.%20You%20are%20requested%20to%20kindly%20get%20your%20MY%20KYC%20registration%20done%20if%20not%20completed%20till%20date.";
	//$url.="&isTemplate=true&buttonUrlParam=abcdxyz";

	$headers = array("Content-Type: application/json");
				 
    $curl = curl_init();
    $timeout = 5;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	
    $response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
		//header('Content-type: application/json');
		return $response;
	// echo $response;
	}
}

/*** Visitor Registration Template API for whatsApp */
/*
function visitor_Individual_Directory_Approval($visitorMobiles,$name)
{ 
	$visitorMobiles = trim($visitorMobiles);
	$name = trim($name);

	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=SendMessage&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$visitorMobiles."&v=1.1&auth_scheme=plain&msg_type=TEXT";
	$url.="&msg=Dear%20".$name."%2C%20your%20data%20for%20visitor%20badge%20has%20been%20approved%2C%20Kindly%20proceed%20for%20visitor%20registration%20and%20payment%20at%20IIJS%20SIGNATURE";
	//$url.="&isTemplate=true&buttonUrlParam=abcdxyz";
		 
    $curl = curl_init();
    $timeout = 5;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	
    $response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
		//header('Content-type: application/json');
		return $response;
	// echo $response;
	}
}

function visitor_Individual_Directory_Disapproval($visitorMobile,$name,$disapprove_reason)
{ 
	$visitorMobiles = trim($visitorMobile);
	$name = trim($name);
	$disapprove_reason = rawurlencode($disapprove_reason);

	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=SendMessage&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$visitorMobiles."&v=1.1&auth_scheme=plain&msg_type=TEXT";
	$url.="&msg=Dear%20".$name."%2C%20your%20data%20for%20visitor%20badge%20has%20been%20disapproved%2C%20Due%20to%20".$disapprove_reason."%20kindly%20update%20your%20record%20at%20IIJS%20SIGNATURE";
	//echo $url ; exit;
	//$url.="&isTemplate=true&buttonUrlParam=abcdxyz";
		 
    $curl = curl_init();
    $timeout = 5;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	
    $response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
		//header('Content-type: application/json');
		return $response;
	 echo $response;
	}
}
*/

function single_visitor_approval($visitorMobiles,$name,$website,$Posturl)
{ 
	if(strlen($visitorMobiles)==10){  $mobile = '91'.$visitorMobiles; } else {  $mobile = $visitorMobiles;  }
	$mobile = trim($mobile);
	$name = trim($name);

	$url = "https://app.yellowmessenger.com/api/engagements/notifications/v2/push?bot=x1652181273571";

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'
	{
    "userDetails": {
        "number": "'.$mobile.'"
	},

   "notification": {
       "templateId": "single_visitor_approval", 
       "params": { 
           "name" : "'.$name.'",
           "website" : "'.$website.'",
           "websiteLink" : "'.$Posturl.'"
          },
       "type": "whatsapp", 
       "sender": "919619500999",
       "language": "en",
       "namespace": "f6d069b8_cb39_4d42_a8e1_045b5ea5d255"
	}
	}',
  CURLOPT_HTTPHEADER => array(
    'x-api-key: w_I8aJAEmNQz36y3i1QaZMHQrydyEj-I2GZ8_ySG',
    'Content-Type: application/json'
  ),
));
	//print_r($curl);
	$response = curl_exec($curl);	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
	//	header('Content-type: application/json');
		return $response;	 
	}
}

function single_visitor_disapproval($visitorMobiles,$name,$disapprove_reason,$Posturl)
{ 
	if(strlen($visitorMobiles)==10){  $mobile = '91'.$visitorMobiles; } else {  $mobile = $visitorMobiles;  }
	$mobile = trim($mobile);
	$name = trim($name);

	$url = "https://app.yellowmessenger.com/api/engagements/notifications/v2/push?bot=x1652181273571";

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'
	{
    "userDetails": {
        "number": "'.$mobile.'"
	},

   "notification": {
       "templateId": "single_visitor_disapproval", 
       "params": { 
           "name" : "'.$name.'",
           "disapprove_reason" : "'.$disapprove_reason.'",
           "websiteLink" : "'.$Posturl.'"
          },
       "type": "whatsapp", 
       "sender": "919619500999",
       "language": "en",
       "namespace": "f6d069b8_cb39_4d42_a8e1_045b5ea5d255"
	}
	}',
  CURLOPT_HTTPHEADER => array(
    'x-api-key: w_I8aJAEmNQz36y3i1QaZMHQrydyEj-I2GZ8_ySG',
    'Content-Type: application/json'
  ),
));
	//print_r($curl);
	$response = curl_exec($curl);	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
	//	header('Content-type: application/json');
		return $response;	 
	}
}

function getAgencyName($registration_id,$conn)
{
	$query_sel = "SELECT agency_name FROM  visitor_agency_master  where id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['agency_name'];
}
function getAgencyCat($agency_id,$conn)
{
	$query_sel = "SELECT category FROM  visitor_agency_master  where id='$agency_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['category'];
}
function getVisitorAgencyCategory($id,$conn)
{
	$query_sel = "SELECT cat_name FROM  visitor_vendor_category  where id='$id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
		return $row['cat_name'];
}

function getKycUrl($bp_number,$pan_number,$company_name)
{
	$ENV = "LIVE"; //TEST OR LIVE ENVIRONMENT
	$secretKey = "Tasya Te Pavitra-Pate mantra";
	$kycUrl ="";
	if($ENV =="TEST"){
		$kycUrl .= "http://test.mykycbank.com/sso.aspx";
	}else if($ENV = "LIVE"){
		$kycUrl .= "https://www.mykycbank.com/sso.aspx";
	}
	$k =  MD5(MD5($bp_number.$pan_number.$company_name).$secretKey);
	$kycUrl .='?b='.$bp_number.'&p='.$pan_number.'&c='.$company_name.'&k='.$k.'';
	return $kycUrl;
}
function getVisitorSelectedShow($id,$conn)
{
	$query_sel = "select payment_made_for from visitor_order_history where visitor_id='$id' and `show`='iijs21'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['payment_made_for'];
}

function get_browser_name($user_agent){
    $t = strtolower($user_agent);
    $t = " " . $t;
    if     (strpos($t, 'opera'     ) || strpos($t, 'opr/')     ) return 'Opera'            ;   
    elseif (strpos($t, 'edge'      )                           ) return 'Edge'             ;   
    elseif (strpos($t, 'chrome'    )                           ) return 'Chrome'           ;   
    elseif (strpos($t, 'safari'    )                           ) return 'Safari'           ;   
    elseif (strpos($t, 'firefox'   )                           ) return 'Firefox'          ;   
    elseif (strpos($t, 'msie'      ) || strpos($t, 'trident/7')) return 'Internet Explorer';
    return 'Unknown';
}
function getExhRoi_desc($event_values,$conn)
{
	$query_sel = "select eventDescription from exh_event_master where event_values='$event_values'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['eventDescription'];
}
function getVisEventName($event_values,$conn){
	$query_sel = "select `event_name` from visitor_event_master where shortcode='$event_values'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['event_name'];
}
function getVisitorHotelQuota($registration_id,$conn){
	$query_sel = "select `quota` from registration_master where id='$registration_id'";	
	$result_sel = $conn->query($query_sel);								
	$row = $result_sel->fetch_assoc();	
    return $row['quota'];
}
function getAuthPersonMobile($registration_id,$conn)
{
	$query_sel = "SELECT mobile_no FROM communication_address_master where registration_id='$registration_id' and type_of_address='13' and address_identity='CTP' ";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	return $row['mobile_no'];
}
function getTotalBadgesAppliedBycompany($registration_id,$type,$conn)
{

	$query_Total = "SELECT COUNT(*) as total FROM globalExhibition WHERE registration_id='$registration_id' and participant_Type='$type'";
	$result = $conn->query($query_Total);
	$row = $result->fetch_assoc();							
	return $row['total'];
}

function intlVisitorPhoto($id,$conn)
{
	$query_visitor = "SELECT photograph_fid FROM `ivr_registration_details` WHERE `eid`='$id'";
	$result = $conn->query($query_visitor);
	$row = $result->fetch_assoc(); 		
	return $row['photograph_fid'];
}

function checkIvrApproval_status($regid,$conn)
{
	$query_status = "SELECT  personal_info_approval,photo_approval,valid_passport_copy_approval,visiting_card_approval,nri_photo_approval,application_approved FROM `ivr_registration_details` WHERE `uid`='$regid' order by eid desc";
	$result_status =  $conn ->query($query_status);	
	$movies_id = array();
	while($row = $result_status->fetch_assoc())		 	
	{ 		
		$visitor_approval = $row['application_approved'];
		$movies_id[] = $visitor_approval;
		
		/*if($visitor_approval == 'P' ){ $approval_msg = "Pending";}		
		elseif($visitor_approval == 'D' ){ $approval_msg = "Disapproved";}
		elseif($visitor_approval == 'Y' ){ $approval_msg = "Approved";}
		return $approval_msg;*/
	}
	//print_r($movies_id);
	// if($visitor_approval == "P") {
	// 	return "Pending";
	// }elseif($visitor_approval == "N"){
	// 	return "Disapproved";
	// }elseif($visitor_approval =="Y", $movies_id)){
	// 	return "Approved";
	// }else{
	// 	return "Approved";
	// }
	if(in_array("P", $movies_id)) {
		return "Pending";
	}elseif(in_array("N", $movies_id)){
		return "Disapproved";
	}elseif(in_array("Y", $movies_id)){
		return "Approved";
	}else{
		return "Approved";
	}


}

?>

<?php
	function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
       $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
	}
?>
