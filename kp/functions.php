<?php
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
		  
  if($points!=""){$result=$result.$points . " PAISE";}
  echo $result;
 }
function getPAYMENTMSTID($conn,$EXPORT_APP_ID){
	$query_sel = "SELECT PAYMENT_MST_ID FROM kp_payment_details where EXPORT_APP_ID='$EXPORT_APP_ID' limit 0,1";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['PAYMENT_MST_ID'];
	}
}

// Fetch Resign Name 
function getRegionName($conn,$id)
{
	$query_sel = "SELECT LOCATION_NAME FROM  kp_location_master  where LOCATION_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['LOCATION_NAME'];
	}
}

function getKP_CERT($conn,$id)
{
	$query_sel = "SELECT KP_CERT_NO FROM  kp_export_application_master  where EXPORT_APP_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['KP_CERT_NO'];
	}
}

function getKP_BATCH_NO($conn,$id)
{
	$query_sel = "SELECT KP_BATCH_NO FROM  kp_export_application_master  where EXPORT_APP_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['KP_BATCH_NO'];
	}
}
function getCountryDestination($conn,$id)
{
	$query_sel = "SELECT COUNTRY_DEST_ID FROM  kp_export_application_master  where EXPORT_APP_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['COUNTRY_DEST_ID'];
	}
}

function getFORM_TYPE($conn,$id)
{
	$query_sel = "SELECT FORM_TYPE FROM  kp_export_application_master  where EXPORT_APP_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['FORM_TYPE'];
	}
}

function getLookupName($conn,$id)
{
	$query_sel = "SELECT LOOKUP_VALUE_NAME FROM  kp_lookup_details  where LOOKUP_VALUE_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['LOOKUP_VALUE_NAME'];
	}
}

function getAgentName($conn,$id)
{
	$query_sel = "SELECT AGENT_NAME FROM  kp_agent_master  where AGENT_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['AGENT_NAME'];
	}
}

function getAgentAdd1($conn,$id)
{
	$query_sel = "SELECT ADDRESS1 FROM  kp_agent_master  where AGENT_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['ADDRESS1'];
	}
}

function getAgentAdd2($conn,$id)
{
	$query_sel = "SELECT ADDRESS2 FROM  kp_agent_master  where AGENT_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['ADDRESS2'];
	}
}

function getAgentAdd3($conn,$id)
{
	$query_sel = "SELECT ADDRESS3 FROM  kp_agent_master  where AGENT_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['ADDRESS3'];
	}
}

function getAgentPhone($conn,$id)
{
	$query_sel = "SELECT MOBILE FROM  kp_agent_master  where AGENT_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['MOBILE'];
	}
}

function getAgentEmail($conn,$id)
{
	$query_sel = "SELECT EMAIL FROM  kp_agent_master  where AGENT_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['EMAIL'];
	}
}
function getAgentState($conn,$id)
{
	$query_sel = "SELECT STATE FROM  kp_agent_master  where AGENT_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['STATE'];
	}
}
function getAgentCity($conn,$id)
{
	$query_sel = "SELECT CITY FROM  kp_agent_master  where AGENT_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['CITY'];
	}
}
function getAgentPincode($conn,$id)
{
	$query_sel = "SELECT PINCODE FROM  kp_agent_master  where AGENT_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['PINCODE'];
	}
}
function getAgentGstn($conn,$id)
{
	$query_sel = "SELECT AGENT_GSTN FROM  kp_agent_master  where AGENT_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['AGENT_GSTN'];
	}
}

function getMemberName($conn,$MEMBERTYPE,$APPLICANT_ID)
{
	if($MEMBERTYPE=='Agent')
		$query_sel = "SELECT AGENT_NAME as `MEMBER_NAME` FROM  kp_agent_master  where AGENT_ID='$APPLICANT_ID'";
	else if($MEMBERTYPE=='Member')
		$query_sel = "SELECT MEMBER_CO_NAME as `MEMBER_NAME` FROM  kp_member_master where MEMBER_ID='$APPLICANT_ID'";
	elseif($MEMBERTYPE=='NonMember')
		$query_sel = "SELECT NON_MEMBER_NAME as `MEMBER_NAME` FROM  kp_non_member_master  where NON_MEMBER_ID='$APPLICANT_ID'";
		
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['MEMBER_NAME'];
	}
}
function getMemberIec($conn,$MEMBER_ID)
{
	$query_sel = "SELECT IEC_NO  FROM  kp_member_master  where MEMBER_ID='$MEMBER_ID'";
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['IEC_NO'];
	}
}
function getMemberAdd($conn,$MEMBER_ID,$M_ADD_SR_NO){
	$query_sel = "SELECT * FROM  kp_member_address_details  where MEMBER_ID='$MEMBER_ID' and MEMBER_ADD_ID='$M_ADD_SR_NO'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['MEMBER_ADDRESS1']."<br/>".$row['MEMBER_ADDRESS2']."<br/>".$row['MEMBER_ADDRESS3']."<br/>".getOrginStateName($conn,$row['STATE'])."<br/>".$row['CITY']."<br/>".$row['PINCODE'];
	}
}
function getMemberAdd1($conn,$id)
{
	$query_sel = "SELECT MEMBER_ADDRESS1 FROM  kp_member_master  where MEMBER_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['MEMBER_ADDRESS1'];
	}
}
function getMemberAdd2($conn,$id)
{
	$query_sel = "SELECT MEMBER_ADDRESS2 FROM  kp_member_master  where MEMBER_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['MEMBER_ADDRESS2'];
	}
}
function getMemberAdd3($conn,$id)
{
	$query_sel = "SELECT MEMBER_ADDRESS3 FROM  kp_member_master  where MEMBER_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['MEMBER_ADDRESS3'];
	}
}
function getMemberPhone($conn,$id)
{
	$query_sel = "SELECT MEMBER_CO_TEL1 FROM  kp_member_master  where MEMBER_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['MEMBER_CO_TEL1'];
	}
}
function getMemberEmail($conn,$id)
{
	$query_sel = "SELECT MEMBER_CO_EMAIL FROM  kp_member_master  where MEMBER_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['MEMBER_CO_EMAIL'];
	}
}
function getNonMemberName($conn,$id)
{
	$query_sel = "SELECT NON_MEMBER_NAME FROM  kp_non_member_master  where NON_MEMBER_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['NON_MEMBER_NAME'];
	}
}
function getNonMemberAdd($conn,$NON_MEMBER_ID){
	$query_sel = "SELECT * FROM  kp_non_member_master  where NON_MEMBER_ID='$NON_MEMBER_ID'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['ADDRESS1']."<br/>".$row['ADDRESS2']."<br/>".$row['ADDRESS3']."<br/>".getOrginStateName($conn,$row['STATE_ID'])."<br/>".$row['CITY']."<br/>".$row['PINCODE']."<br/>".$row['COUNTRY'];
	}
}

function getNonMemberAdd1($conn,$id)
{
	$query_sel = "SELECT ADDRESS1 FROM  kp_non_member_master  where NON_MEMBER_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['ADDRESS1'];
	}
}
function getNonMemberAdd2($conn,$id)
{
	$query_sel = "SELECT ADDRESS2 FROM  kp_non_member_master  where NON_MEMBER_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['ADDRESS2'];
	}
}
function getNonMemberAdd3($conn,$id)
{
	$query_sel = "SELECT ADDRESS3 FROM  kp_non_member_master  where NON_MEMBER_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['ADDRESS3'];
	}
}
function getNonMemberPhone($conn,$id)
{
	$query_sel = "SELECT MOBILE FROM  kp_non_member_master  where NON_MEMBER_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['MOBILE'];
	}
}
function getNonMemberEmail($conn,$id)
{
	$query_sel = "SELECT EMAIL FROM  kp_non_member_master  where NON_MEMBER_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['EMAIL'];
	}
}

function getHSCode($conn,$id)
{
	$query_sel = "SELECT HS_CODE FROM  kp_hs_code_master  where LOOKUP_VALUE_ID='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['HS_CODE'];
	}
}

function getOrginCountryName($conn,$country_code)
{
	$query_sel = "SELECT country_name FROM  kp_country_master  where country_code='$country_code'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['country_name'];
	}
}

function getOrginStateName($conn,$state_code)
{
	$query_sel = "SELECT state_name FROM  kp_state_master  where state_code='$state_code'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return  strtoupper($row['state_name']);
	}
}
function getForeignBp($conn,$IE_PARTY_ID)
{
	$query_sel = "SELECT BP_NUMBER FROM  kp_foreign_imp_master  where PARTY_ID='$IE_PARTY_ID'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['BP_NUMBER'];
	}
}
function getForeignPartyName($conn,$IE_PARTY_ID)
{
	$query_sel = "SELECT LONGNAME FROM  kp_foreign_imp_master  where PARTY_ID='$IE_PARTY_ID'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['LONGNAME'];
	}
}

function getOrginCityName($conn,$id)
{
	$query_sel = "SELECT LCDESC FROM  kp_city_master  where LCMINOR='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['LCDESC'];
	}
}
function getAdminName($conn,$id)
{ 
	$query_sel = "SELECT CONTACT_NAME FROM  kp_admin_master  where id='$id'";	
	$result_sel = mysqli_query($conn,$query_sel);	
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['CONTACT_NAME'];
	}
}

function getBank($conn,$id){
 $query_sel="SELECT a.contact_name FROM  kp_admin_master a, kp_admin_erpweb b ON a.id = b.approved_by_bank WHERE a.id=$id";
$result_sel=mysqli_query($conn,$query_sel);
while($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['contact_name'];
	}
}

function getNonMemberBankid($conn,$id)
{
	$query_sel = "SELECT bank_id FROM  kp_admin_master  where id='$id'";

	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['bank_id'];
	}
}

function getamount($conn,$erp_id)
{
	$query_sel = "SELECT amount FROM  kp_admin_erpweb  where id='$erp_id'";

	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['amount'];
	}
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
 
function getBpNumber($conn,$MEMBERTYPE,$APPLICANT_ID)
{
	if($MEMBERTYPE=='Agent')
		$query_sel = "SELECT AGENT_BP_NO as `BPNUMBER` FROM  kp_agent_master  where AGENT_ID='$APPLICANT_ID'";
	else if($MEMBERTYPE=='Member')
		$query_sel = "SELECT BP_NUMBER as `BPNUMBER` FROM  kp_member_user_details where MEMBER_ID='$APPLICANT_ID'";
	elseif($MEMBERTYPE=='NonMember')
		$query_sel = "SELECT NON_MEMBER_BP_NO as `BPNUMBER` FROM  kp_non_member_master  where NON_MEMBER_ID='$APPLICANT_ID'";

	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['BPNUMBER'];
	}
}

function getPartnerBp($conn,$MEMBERTYPE,$APPLICANT_ID,$M_ADD_SR_NO)
{
	if($MEMBERTYPE=='Member')
		$query_sel = "SELECT MEMBER_BP_NO as `BPNUMBER` FROM  kp_member_address_details where MEMBER_ID='$APPLICANT_ID' and MEMBER_ADD_ID='$M_ADD_SR_NO'";
	elseif($MEMBERTYPE=='NonMember')
		$query_sel = "SELECT NON_MEMBER_BP_NO as `BPNUMBER` FROM  kp_non_member_master  where NON_MEMBER_ID='$APPLICANT_ID'";

	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['BPNUMBER'];
	}
}

function getMembershipStatus($MEMBER_ID)
{
	$conn1 = mysqli_connect("localhost","gjepcliveuserdb","KGj&6(pcvmLk5","gjepclivedatabase");
	$query_sel = "SELECT admin_issue_membership_certificate,eligible_for_renewal FROM gjepclivedatabase.approval_master where 1 and registration_id='$MEMBER_ID'";
	$result_sel = mysqli_query($conn1,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['eligible_for_renewal'];
	}
}
function KP_INVOICE_STATUS($conn,$PAYMENT_MST_ID)
{
	$query_sel = "SELECT KP_INVOICE_STATUS FROM kp_payment_master where 1 and PAYMENT_MST_ID='$PAYMENT_MST_ID'";
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['KP_INVOICE_STATUS'];
	}
}
function KP_DELIVERY_STATUS($conn,$PAYMENT_MST_ID)
{
	$query_sel = "SELECT DELIVERY_STATUS FROM kp_payment_master where 1 and PAYMENT_MST_ID='$PAYMENT_MST_ID'";
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['DELIVERY_STATUS'];
	}
}

function getAdvol_Exchange_rate($conn,$PAYMENT_MST_ID){
	$query_sel = "SELECT advol_exchange_rate FROM kp_payment_master where PAYMENT_MST_ID='$PAYMENT_MST_ID' limit 0,1";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['advol_exchange_rate'];
	}
}

function getAdvol_Amount($conn,$PAYMENT_MST_ID){
	$query_sel = "SELECT advol_amount FROM kp_payment_master where PAYMENT_MST_ID='$PAYMENT_MST_ID' limit 0,1";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['advol_amount'];
	}
}

function getAdvol_Response($conn,$PAYMENT_MST_ID){
	$query_sel = "SELECT advol_RESPONSE_CODE FROM kp_payment_master where PAYMENT_MST_ID='$PAYMENT_MST_ID' limit 0,1";	
	$result_sel = mysqli_query($conn,$query_sel);								
	if($row = mysqli_fetch_array($result_sel))		 	
	{ 		
		return $row['advol_RESPONSE_CODE'];
	}
}

function aes128Encrypt($str,$key){
$block = mcrypt_get_block_size('rijndael_128', 'ecb');
$pad = $block - (strlen($str) % $block);
$str .= str_repeat(chr($pad), $pad);
return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB));
}

