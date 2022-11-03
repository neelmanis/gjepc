<?php 
ob_start();
//============================================================+
// File name   : Certificate
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Communication Form for TCPDF class
//               Custom Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Custom Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */
 
// Include the main TCPDF library (search for installation path). 
session_start();   
require_once('tcpdf_include.php');     
require_once('../db.inc.php');
require_once('../functions.php');
if(isset($_REQUEST['registration_id'])){$registration_id=$_REQUEST['registration_id'];}
else{$registration_id=$_SESSION['USERID'];}


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		//right Logo
    		$left_image_file =  K_PATH_IMAGES.'logo_gjepc.png';
    		$this->Image($left_image_file, 165, 10, '', 20, 'PNG', '', 'T', false, 72, '', false, false, 0, false, false, false);
    		//left Logo
    		//$right_image_file =  K_PATH_IMAGES.'logo_in.png';
    		//$this->Image($right_image_file, 10, 10, '', 20, 'PNG', '', 'T', false, 72, '', false, false, 0, false, false, false);
            //$this->SetLineStyle(1);
            $this->Rect(8,8,193,275);
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
    		$this->SetY(-15);
			
    		// Set font
    		$this->SetFont('helvetica', 'I', 8);
    		// Page number
    		$this->Cell(40, 10, 'RCMC Certificate - Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			$this->Cell(62, 10, date("d/m/Y h:i a"), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			$this->Cell(-90, 20, 'This certificate is digitally signed and does not require physical signature. ', 0, false, 'C', 0, '', 0, false, 'T', 'M');
			//$this->Cell(-90, 20, 'This certificate is digitally signed and does not require physical signature. ', 0, 0, 'C', 0, '', 0, false, 'T', 'M');
	}
}
$getAuthPerson = mysql_query("SELECT designation FROM communication_address_master where registration_id='$registration_id' AND type_of_address='13'");


$getDesignation= mysql_fetch_array($getAuthPerson);
$designation = strtoupper($getDesignation['designation']);

$query = mysql_query("SELECT * FROM information_master where registration_id='$registration_id'");
$default= mysql_fetch_array($query);
    
$company_name1 = strtoupper($default['company_name']);
$company_name2 = $default['company_name2'];
$company_name=$company_name1.$company_name2;
$member_type_id = strtoupper($default['member_type_id']);
if($member_type_id=="5"){$member_type_id="MERCHANT EXPORTER";}else{$member_type_id="MANUFACTURER EXPORTER";}

$type_of_firm = strtoupper($default['type_of_firm']);
$iec_no = strtoupper($default['iec_no']);
$iec_issue_date = strtoupper($default['iec_issue_date']);
$im_registration_no = strtoupper($default['im_registration_no']);
$im_pin_code = strtoupper($default['im_pin_code']);
$ssi_registration_no = strtoupper($default['ssi_registration_no']);
$ssi_issue_date = strtoupper($default['ssi_issue_date']);
$ssi_pin_code = strtoupper($default['ssi_pin_code']);
$issuing_industrial_liecence = strtoupper($default['issuing_industrial_liecence']);
$authority = strtoupper($default['authority']);
$eh_th_certification_no = strtoupper($default['eh_th_certification_no']);
$eh_th_issue_date = strtoupper($default['eh_th_issue_date']);
$eh_th_valid_date = strtoupper($default['eh_th_valid_date']);
$region_id = strtoupper($default['region_id']);
$region_real_name=getRegionRealName($region_id);
$year_of_starting_bussiness = date('d-m-Y',strtotime($default['year_of_starting_bussiness']));
$contact_name = strtoupper($default['name']);
//$designation = strtoupper($default['designation']);
$info_email_id = strtolower($default['email_id']);
$pan_no = strtoupper($default['pan_no']);
$tan_no = strtoupper($default['tan_no']);
$address1 = strtoupper($default['address1']);
$address2 = strtoupper($default['address2']);
$address3 = strtoupper($default['address3']);
$pin_code = strtoupper($default['pin_code']);
$city = strtoupper($default['city']);
$country = strtoupper($default['country']);
$land_line_no = strtoupper($default['land_line_no']);
$info_mobile_no = strtoupper($default['mobile_no']);
$joining_date = strtoupper($default['joining_date']);
$retirement_date = strtoupper($default['retirement_date']);
$date = date('d-m-Y');

$information_region_array =  mysql_fetch_array(mysql_query("SELECT `region_full_name` FROM `region_master` WHERE `region_name` = '$region_id'"));
 $information_region_name =  strtoupper($information_region_array["region_full_name"]);


//Head Office  or    Registered Office

if ($type_of_firm == "13" || $type_of_firm == "12")
{
    $head_register_office = "6";
}
else
{
    $head_register_office = "2";
}


 $head_reg= mysql_query("SELECT name, father_name, address1, address2, address3, country, state, city, pincode, landline_no1, mobile_no, fax_no1, fax_no2, email_id FROM communication_address_master  WHERE registration_id = '$registration_id'  and type_of_address='$head_register_office' limit 0,1");
$head_reg_office=mysql_fetch_array($head_reg);
$hname = strtoupper($head_reg_office['name']);
$hfather_name = strtoupper($head_reg_office['father_name']);

$haddress1 = strtoupper($head_reg_office['address1']);
if($haddress1!=""){$haddress1=$haddress1;}else{$haddress1="";}

$haddress2 = strtoupper($head_reg_office['address2']);
if($haddress2!=""){$haddress2=",".$haddress2;}else{$haddress2="";}

$haddress3 = strtoupper($head_reg_office['address3']);
if($haddress3!=""){$haddress3=",".$haddress3;}else{$haddress3="";}
$hcountry = strtoupper(getFullCountryeName($head_reg_office['country']));
if($hcountry!=""){$hcountry=",".$hcountry;}else{$hcountry="";}
$hstate = strtoupper(getFullStateName($head_reg_office['state']));
if($hstate!=""){$hstate=",".$hstate;}else{$hstate="";}
$hcity = strtoupper($head_reg_office['city']);
if($hcity!=""){$hcity=",".$hcity;}else{$hcity="";}
$hpincode = strtoupper($head_reg_office['pincode']);
if($hpincode!=""){$hpincode=",".$hpincode;}else{$hpincode="";}
$hlandline_no1 = strtoupper($head_reg_office['landline_no1']);
if($hlandline_no1!=""){$hlandline_no1=",".$hlandline_no1;}else{$hlandline_no1="";}
$hmobile_no = strtoupper($head_reg_office['mobile_no']);
if($hmobile_no!=""){$hmobile_no=",".$hmobile_no;}else{$hmobile_no="";}
$hfax_no1 = strtoupper($head_reg_office['fax_no1']);
if($hfax_no1!=""){$hfax_no1=",".$hfax_no1;}else{$hfax_no1="";}
$hfax_no2 = strtoupper($head_reg_office['fax_no2']);
if($hfax_no2!=""){$hfax_no2=",".$hfax_no2;}else{$hfax_no2="";}
$hemail_id = strtoupper($head_reg_office['email_id']);
if($hemail_id!=""){$hemail_id=",".$hemail_id;}else{$hemail_id="";}
$head_reg_office_print = "$haddress1 $haddress2 $haddress3 $hcity $hstate $hcountry $hpincode";

$com_default = mysql_fetch_array(mysql_query("SELECT * FROM communication_details_master WHERE registration_id = '$registration_id'"));

$panel_name = $com_default['panel_name'];
$export_product_name =$com_default['export_product_name'];
$authority_firm_name = $com_default['authority_firm_name'];
$authority_firm_registration_no = $com_default['authority_firm_registration_no'];
$authority_registration_date = $com_default['authority_registration_date'];
$authority_registration_valid_upto = $com_default['authority_registration_valid_upto'];
$registration_required = str_replace(",,", ",", $export_product_name);
$registration_required1=$export_product_name;

	if(preg_match('/Polished & Processed Pearls/',$registration_required1))
	{
	
	  //$polished_and_processed_pearls = 'Yes';
	  $polished_and_processed_pearls = '<img src="images/true.gif" width="12" height="12" vspace="3" />';
	}
	else
	{
	   $polished_and_processed_pearls = '-';
	}

	if(preg_match('/Cut & Polished Diamonds/',$registration_required1))
	{
		//$cut_and_polished_diamonds = 'Yes';
		$cut_and_polished_diamonds = '<img src="images/true.gif" width="12" height="12" vspace="3" />';
	}
	else
	{
		$cut_and_polished_diamonds = '-';
	}
	
	if(preg_match('/Cut & Polished Synthetic stone/',$registration_required1))
	{
		//$cut_and_polished_synthetic_stone = 'Yes';
		$cut_and_polished_synthetic_stone = '<img src="images/true.gif" width="12" height="12" vspace="3" />';
	}
	else
	{
		$cut_and_polished_synthetic_stone = '-';
	}

    if(preg_match('/Costume Fashion Jewellery/',$registration_required1))
    {
	   //$costume_fashion_jewllery = 'Yes';
	   $costume_fashion_jewllery = '<img src="images/true.gif" width="12" height="12" vspace="3" />';
    }
    else
    {
       $costume_fashion_jewllery = '-';
    }
	
	if(preg_match('/Cut & Polished Coloured Gemstones/',$registration_required1))
    {
	   //$cut_and_polished_color_gemstones = 'Yes';
	   $cut_and_polished_color_gemstones = '<img src="images/true.gif" width="12" height="12" vspace="3" />';
    }
    else
    {
       $cut_and_polished_color_gemstones = '-';
    }
	
    if(preg_match('/Silver Jewellery & Silver Filligree/',$registration_required1))
    {
	   //$silver_jewellery_silver_filligree = 'Yes';
	   $silver_jewellery_silver_filligree = '<img src="images/true.gif" width="12" height="12" vspace="3" />';
    }
    else
    {
       $silver_jewellery_silver_filligree = '-';
    }
	
	if(preg_match('/Jewellery containing gold/',$registration_required1))
    {
	   //$jewellery_containing_gold = 'Yes';
	   $jewellery_containing_gold = '<img src="images/true.gif" width="12" height="12" vspace="3" />';
    }
    else
    {
       $jewellery_containing_gold = '-';
    }

    if(preg_match('/Rough Diamonds/',$registration_required1))
    {
	   //$rough_diamonds = 'Yes';
	   $rough_diamonds = '<img src="images/true.gif" width="12" height="12" vspace="3" />';
    }
    else
    {
       $rough_diamonds = '-';
    }
    


$qregion_default =mysql_query("SELECT region_name,region_full_name,region_address, region_bank, region_bank_acct_no, region_bank_address, region_bank_logo FROM region_master WHERE region_name='$region_id'");
$region_default=mysql_fetch_array($qregion_default);

    $region_name = strtoupper($region_default['region_name']);
    $region_full_name = strtoupper($region_default['region_full_name']);
    $region_address = strtoupper($region_default['region_address']);
    $region_bank = strtoupper($region_default['region_bank']);
    $region_bank_acct_no = strtoupper($region_default['region_bank_acct_no']);
    $region_bank_address = strtoupper($region_default['region_bank_address']);
    $region_bank_logo = strtoupper($region_default['region_bank_logo']);

    if ($region_value == "HO-MUM (M)")
    {
        $edto = "The Executive Director";
    }
    else
    {
        $edto = "The Regional Director";
    }


$info_data =mysql_fetch_array(mysql_query("select * from  challan_master where registration_id = '$registration_id' AND challan_financial_year ='$cur_fin_yr'"));
$export_sales_to_foreign_tourists = $info_data['export_sales_to_foreign_tourists'];
$export_synthetic_stones = $info_data['export_synthetic_stones'];
$export_costume_jewellery = $info_data['export_costume_jewellery'];
$export_other_precious_metal_jewellery = $info_data['export_other_precious_metal_jewellery'];
$export_pearls = $info_data['export_pearls'];
$export_coloured_gemstones = $info_data['export_coloured_gemstones'];
$export_gold_jewellery = $info_data['export_gold_jewellery'];
$export_rough_diamonds = $info_data['export_rough_diamonds'];
$export_cut_polished_diamonds = $info_data['export_cut_polished_diamonds'];
$export_total = $info_data['export_total'];
$import_findings_mountings = $info_data['import_findings_mountings'];
$import_false_pearls = $info_data['import_false_pearls'];
$import_rough_imitation_stones = $info_data['import_rough_imitation_stones'];
$import_silver = $info_data['import_silver'];
$import_raw_pearls = $info_data['import_raw_pearls'];
$import_cut_polished_gemstones = $info_data['import_cut_polished_gemstones'];
$import_rough_gemstones = $info_data['import_rough_gemstones'];
$import_gold = $info_data['import_gold'];
$import_cif_value = $info_data['import_cif_value'];

$payment_mode = $info_data['payment_mode'];
$membership_fees = $info_data['membership_fees'];
$admission_fees = $info_data['admission_fees'];
$bank_name = $info_data['bank_name'];
$branch_name = $info_data['branch_name'];
$branch_city = $info_data['branch_city'];
$branch_postal_code = $info_data['branch_postal_code'];
$cheque_no = $info_data['cheque_no'];
$cheque_date = $info_data['cheque_date'];
$challan_financial_year = $info_data['challan_financial_year'];
$total_payable = $info_data['total_payable'];
$declaration = $info_data['declaration'];
		
if ($panel_name == "Coloured Gemstones"){$panel_coloured_gemstones = 'Yes';}
else{$panel_coloured_gemstones = '-';}
if ($panel_name == "Costume/Fashion Jewellery"){ $panel_costume_fashion_jewellerys = 'Yes';}
else{ $panel_costume_fashion_jewellerys = '-';}
if ($panel_name == "Diamonds"){$panel_diamonds = 'Yes';}
else{$panel_diamonds = '-';}
if ($panel_name == "Gold Jewellery"){$panel_gold_jewellery = 'yes';}
else{$panel_gold_jewellery = '-';}
if ($panel_name == "Other Precious Metal Jewellery"){$panel_other_precious_metal_jewellery = 'yes';}
else{$panel_other_precious_metal_jewellery = '-';}
if ($panel_name == "Pearls"){$panel_pearls = 'Yes';}
else{$panel_pearls = '-';}
if ($panel_name == "Sales to Foreign Tourists"){$panel_sales_to_foreign_tourists = 'yes';}
else{$panel_sales_to_foreign_tourists = '-';}
if ($panel_name == "Synthetic Stones"){$panel_synthetic_stones = 'yes';}
else{$panel_synthetic_stones = '-';}
if ($panel_name == "Not Indicated"){$panel_not_indicated = 'yes';}
else{$panel_not_indicated = '-';}

if ($type_of_firm == "13" || $type_of_firm == "12"){$details_person_office = "7";}
else if($type_of_firm == "11"){$details_person_office = "5";}
else if ($type_of_firm == "14" || $type_of_firm == "15"){$details_person_office = "1";}
else if($type_of_firm == "18"){$details_person_office = "8";}
else if($type_of_firm == "17"){$details_person_office = "9";}
else if($type_of_firm == "16"){$details_person_office = "10";}
else if($type_of_firm == "19"){$details_person_office = "7";}

$person_count = 0;
$person_office_print = '';
//echo "SELECT *  FROM communication_address_master WHERE registration_id = '$registration_id'  and type_of_address='$details_person_office'";exit;
$person_office = mysql_query("SELECT *  FROM communication_address_master WHERE registration_id = '$registration_id'  and type_of_address='$details_person_office'");
while($person_office_result = mysql_fetch_array($person_office)) {
$person_name = strtoupper($person_office_result['name']);
$father_name = strtoupper($person_office_result['father_name']);
$paddress1 = strtoupper($person_office_result['address1']);
$paddress2 = strtoupper($person_office_result['address2']);
$paddress3 = strtoupper($person_office_result['address3']);
$pcountry = strtoupper($person_office_result['country']);
$pstate = strtoupper($person_office_result['state']);
$pcity = strtoupper($person_office_result['city']);
$ppincode = strtoupper($person_office_result['pincode']);
$plandline1 = strtoupper($person_office_result['landline_no1']);
$pmobile = strtoupper($person_office_result['mobile_no']);
$pfax1 = strtoupper($person_office_result['fax_no1']);
$pfax2 = strtoupper($person_office_result['fax_no2']);
$pemail = strtoupper($person_office_result['email_id']);


$person_office_print[$person_count] = ($person_count +1) .'. '.$person_name.'<br/>' ;
$person_count++;
//$person_count . ". " . "$address1, $address2, $address3, $city, $state, $country, $pincode <br>";
}


//$person_office_print =  $person_office_print . '<br>';

$person_office_table_print = '<table width="637" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="middle">'.$person_office_print[0].'&nbsp;</td>
    <td align="left" valign="middle">'.$person_office_print[1].'&nbsp;</td>
    <td align="left" valign="middle">'.$person_office_print[2].'&nbsp;</td>
  </tr>';
  if($person_office_print[3]!=""){
  $person_office_table_print.='<tr>
    <td align="left" valign="middle">'.$person_office_print[3].'&nbsp;</td>
    <td align="left" valign="middle">'.$person_office_print[4].'&nbsp;</td>
    <td align="left" valign="middle">'.$person_office_print[5].'&nbsp;</td>
  </tr>';
  }

  if($person_office_print[6]!=""){
  $person_office_table_print.='<tr>
    <td align="left" valign="middle">'.$person_office_print[6].'&nbsp;</td>
    <td align="left" valign="middle">'.$person_office_print[7].'&nbsp;</td>
    <td align="left" valign="middle">'.$person_office_print[8].'&nbsp;</td>
  </tr>';
  }
  if($person_office_print[9]!=""){
  $person_office_table_print.='<tr>
    <td align="left" valign="middle">'.$person_office_print[9].'&nbsp;</td>
    <td align="left" valign="middle">'.$person_office_print[10].'&nbsp;</td>
    <td align="left" valign="middle">'.$person_office_print[11].'&nbsp;</td>
  </tr>';
  }
  if($person_office_print[12]!=""){
  $person_office_table_print.='<tr>
    <td align="left" valign="middle">'.$person_office_print[12].'&nbsp;</td>
    <td align="left" valign="middle">'.$person_office_print[13].'&nbsp;</td>
    <td align="left" valign="middle">'.$person_office_print[14].'&nbsp;</td>
  </tr>';
  }
  if($person_office_print[15]!=""){
  $person_office_table_print.='<tr>
    <td align="left" valign="middle">'.$person_office_print[15].'&nbsp;</td>
    <td align="left" valign="middle">'.$person_office_print[16].'&nbsp;</td>
    <td align="left" valign="middle">'.$person_office_print[17].'&nbsp;</td>
  </tr>';
  }
  if($person_office_print[18]!=""){
  $person_office_table_print.='<tr>
    <td align="left" valign="middle">'.$person_office_print[18].'&nbsp;</td>
    <td align="left" valign="middle">'.$person_office_print[19].'&nbsp;</td>
    <td align="left" valign="middle">'.$person_office_print[20].'&nbsp;</td>
  </tr>';
  }
  $person_office_table_print.='</table>';

$certificate_renewal_data = mysql_fetch_array(mysql_query("SELECT * FROM approval_master WHERE registration_id='$registration_id'"));
$applied_for_rcmc_certificate =	strtoupper($certificate_renewal_data['rcmc_certificate_apply']);
$membership_category =	strtoupper(getMemberType($certificate_renewal_data['registration_id']));
$certificate_issued_dt1=$certificate_renewal_data['rcmc_certificate_issue_date'];
$certificate_issued_dt=date("d-m-Y",strtotime($certificate_issued_dt1));
$membership_renewal_dt=date("d-m-Y",strtotime($certificate_renewal_data['membership_renewal_dt']));


$rcmc_amendment_modification=$certificate_renewal_data['rcmc_amendment_modification'];
$rcmc_amendment_modification_reason=$certificate_renewal_data['rcmc_amendment_modification_reason'];


if($rcmc_amendment_modification_reason!=""){
$amendment_msg="<tr>
	<td><b>Amended RCMC:</b>$rcmc_amendment_modification_reason</td>    
    </tr>";
}else
	$amendment_msg="";

if($certificate_renewal_data['rcmc_certificate_issue_date']!="0000-00-00"){
$reg_start_year =date("Y",strtotime($certificate_renewal_data['rcmc_certificate_issue_date']));
$reg_start_year="31-03-".$reg_start_year;
}else{$reg_start_year="NA";}

if(date("m",strtotime($certificate_renewal_data['rcmc_certificate_issue_date']))<4)
{
	$wef_yr=date("Y",strtotime($certificate_renewal_data['rcmc_certificate_issue_date']))-1;
}else
{
	$wef_yr=date("Y",strtotime($certificate_renewal_data['rcmc_certificate_issue_date']));
}
$reg_start_year1="01-04-".$wef_yr;


if($certificate_renewal_data['rcmc_certificate_expire_date']!="0000-00-00"){
$reg_end_year =date("d-m-Y",strtotime($certificate_renewal_data['rcmc_certificate_expire_date']));
}else{$reg_start_year="NA";}


$merchant_reg_no 	=	strtoupper($certificate_renewal_data['merchant_certificate_no']);
$manufacturer_reg_no =	strtoupper($certificate_renewal_data['manufacturer_certificate_no']);
//$certificate_issued_dt 	=	$certificate_renewal_data['rcmc_certificate_issue_date'];
$membership_id=$certificate_renewal_data['membership_id'];

if($member_type_id=="MERCHANT EXPORTER" || $member_type_id=="5"){
	$rcmc_regnos=$merchant_reg_no;
	/*$hocode1 = [1010,1020,1030,1040,1050,1060];
	$ho1   = ['HO-MUM (M)','RO-JAI','RO-SRT', 'RO-CHE', 'RO-DEL','RO-KOL']; */
	$hocode1 = ['/1010/','/1020/','/1030/', '/1040/', '/1050/','/1060/'];
	$ho1   = ['/HO-MUM (M)/','/RO-JAI/','/RO-SRT/', '/RO-CHE/', '/RO-DEL/','/RO-KOL/'];
	$rcmc_regno = str_replace($hocode1, $ho1, $rcmc_regnos);
	}else{
	$rcmc_regnos=$manufacturer_reg_no;
	/*$hocode1 = [1010,1020,1030,1040,1050,1060];
	$ho1   = ['HO-MUM (M)','RO-JAI','RO-SRT', 'RO-CHE', 'RO-DEL','RO-KOL']; */
	$hocode1 = ['/1010/','/1020/','/1030/', '/1040/', '/1050/','/1060/'];
	$ho1   = ['/HO-MUM (M)/','/RO-JAI/','/RO-SRT/', '/RO-CHE/', '/RO-DEL/','/RO-KOL/'];
	$rcmc_regno = str_replace($hocode1, $ho1, $rcmc_regnos);
	}

	
	
//$rcmc_regno=$membership_id;
if($certificate_issued_dt=="0000-00-00"){$certificate_issued_dt="NA";}

//Head Office
$head_office_print = "";
$head_office_result = mysql_query("SELECT name, father_name, address1, address2, address3, country, state, city, pincode, landline_no1, mobile_no, fax_no1, fax_no2, email_id FROM communication_address_master  WHERE registration_id = '$registration_id'  and type_of_address='2' limit 0,2");
$person_count = 0;
while($head_office_result1 = mysql_fetch_array($head_office_result)) {
$person_name = strtoupper($head_office_result1['name']);
$fathers_name = strtoupper($head_office_result1['father_name']);
$haddress1 = strtoupper($head_office_result1['address1']);
$haddress2 = strtoupper($head_office_result1['address2']);
$haddress3 = strtoupper($head_office_result1['address3']);
$hcountry = strtoupper(getFullCountryeName($head_office_result1['country']));
$hstate = strtoupper(getFullStateName($head_office_result1['state']));
$hcity = strtoupper($head_office_result1['city']);
$hpincode = strtoupper($head_office_result1['pincode']);
$hlandline1 = strtoupper($head_office_result1['landline_no1']);
$hmobile = strtoupper($head_office_result1['mobile_no']);
$hfax1 = strtoupper($head_office_result1['fax_no1']);
$hfax2 = strtoupper($head_office_result1['fax_no2']);
$hemail = strtoupper($head_office_result1['email_id']);
$person_count++;
//$person_office_print =  $person_office_print . $person_count.'. '.$person_name.', '. $address1.', '.$address2.', '. $address3.', '.$city.', '.$state.', '.$country.', '.$pincode.'<br/><br/>';
if ($head_office_print != "")
{
    $head_office_print = $head_office_print ."<br>";
}
$head_office_print = $head_office_print . $haddress1.' '.$haddress2.' '. $haddress3.' '.$hcity.' '.$hstate.' '.$hcountry.' '.$hpincode.'<br/>' ;
//$person_count . ". " . "$address1, $address2, $address3, $city, $state, $country, $pincode <br>";
}

if ($person_count == 1)
{
	 $head_office_print = $head_office_print ."<br>";
}

//$head_office_print =  $head_office_print . '<br>';
if ($head_office_print == "")
{
   $head_office_print = "NA<br>";
}


//Extra Head Office
$ext_head_office_print = "";
$ext_head_office_result = mysql_query("SELECT name, father_name, address1, address2, address3, country, state, city, pincode, landline_no1, mobile_no, fax_no1, fax_no2, email_id FROM communication_address_master  WHERE registration_id = '$registration_id'  and type_of_address='2' limit 2,20");
$ext_head_office_count = 0;
while($ext_head_office_result1 = mysql_fetch_array($ext_head_office_result)) {
$person_name = strtoupper($ext_head_office_result1['name']);
$fathers_name = strtoupper($ext_head_office_result1['father_name']);
$ext_haddress1 = strtoupper($ext_head_office_result1['address1']);
$ext_haddress2 = strtoupper($ext_head_office_result1['address2']);
$ext_haddress3 = strtoupper($ext_head_office_result1['address3']);
$ext_hcountry = strtoupper(getFullCountryeName($ext_head_office_result1['country']));
$ext_hstate = strtoupper(getFullStateName($ext_head_office_result1['state']));
$ext_hcity = strtoupper($ext_head_office_result1['city']);
$ext_hpincode = strtoupper($ext_head_office_result1['pincode']);
$ext_hlandline1 = strtoupper($ext_head_office_result1['landline_no1']);
$ext_hmobile = strtoupper($ext_head_office_result1['mobile_no']);
$ext_hfax1 = strtoupper($ext_head_office_result1['fax_no1']);
$ext_hfax2 = strtoupper($ext_head_office_result1['fax_no2']);
$ext_hemail = strtoupper($ext_head_office_result1['email_id']);
$ext_head_office_count++;
//$person_office_print =  $person_office_print . $person_count.'. '.$person_name.', '. $address1.', '.$address2.', '. $address3.', '.$city.', '.$state.', '.$country.', '.$pincode.'<br/><br/>';
if ($ext_head_office_print != "")
{
    $ext_head_office_print = $ext_head_office_print ."<br>";
}
$ext_head_office_print = $ext_head_office_print . $ext_haddress1.' '.$ext_haddress2.' '. $ext_haddress3.' '.$ext_hcity.' '.$ext_hstate.' '.$ext_hcountry.' '.$ext_hpincode.'<br/>' ;
//$person_count . ". " . "$address1, $address2, $address3, $city, $state, $country, $pincode <br>";
}

if ($ext_head_office_count == 1)
{
	 $ext_head_office_print = $ext_head_office_print ."<br>";
}

//$head_office_print =  $head_office_print . '<br>';
if ($ext_head_office_print == "")
{
   $ext_head_office_print = "NA<br>";
}


//Registered Office

$registered_office_print = "";

$registered_office_result = mysql_query("SELECT * FROM communication_address_master WHERE registration_id = '$registration_id'  and type_of_address='6' limit 0,2");
$regis_count = 0;
while($registered_office_result1 = mysql_fetch_array($registered_office_result)) {
$rname = strtoupper($registered_office_result1['name']);
$rfather_name = strtoupper($registered_office_result1['father_name']);
$raddress1 = strtoupper($registered_office_result1['address1']);
$raddress2 = strtoupper($registered_office_result1['address2']);
$raddress3 = strtoupper($registered_office_result1['address3']);
$rcountry = strtoupper($registered_office_result1['country']);
$rstate = strtoupper(getState($registered_office_result1['state']));
$rcity = strtoupper($registered_office_result1['city']);
$rpincode = strtoupper($registered_office_result1['pincode']);
$rlandline_no1 = strtoupper($registered_office_result1['landline_no1']);
$rmobile_no = strtoupper($registered_office_result1['mobile_no']);
$rfax_no1 = strtoupper($registered_office_result1['fax_no1']);
$rfax_no2 = strtoupper($registered_office_result1['fax_no2']);
$remail_id = strtoupper($registered_office_result1['email_id']);
$regis_count++;
if ($registered_office_print != "")
{
    $registered_office_print = $registered_office_print ."<br>";
}
$registered_office_print .= $regis_count.'.' . $raddress1.' '.$raddress2.' '. $raddress3.' '.$rcity.' '.$rstate.' '.$rcountry.' '.$rpincode.'<br/>' ;
}

if ($regis_count == 1)
{
	 $registered_office_print = $registered_office_print ."<br>";
}

if ($registered_office_print == "")
{
   $registered_office_print = "NA<br/><br/><br/>";
}


//Extra Registered Office

$ext_registered_office_print = "";
$ext_registered_office_result = mysql_query("SELECT * FROM communication_address_master WHERE registration_id = '$registration_id'  and type_of_address='6' limit 2,20");
$ext_registered_office_count = 0;
while($ext_registered_office_result1 = mysql_fetch_array($ext_registered_office_result)) {
$ext_rname = strtoupper($ext_registered_office_result1['name']);
$ext_rfather_name = strtoupper($ext_registered_office_result1['father_name']);
$ext_raddress1 = strtoupper($ext_registered_office_result1['address1']);
$ext_raddress2 = strtoupper($ext_registered_office_result1['address2']);
$ext_raddress3 = strtoupper($ext_registered_office_result1['address3']);
$ext_rcountry = strtoupper($ext_registered_office_result1['country']);
$ext_rstate = strtoupper(getState($ext_registered_office_result1['state']));
$ext_rcity = strtoupper($ext_registered_office_result1['city']);
$ext_rpincode = strtoupper($ext_registered_office_result1['pincode']);
$ext_rlandline_no1 = strtoupper($ext_registered_office_result1['landline_no1']);
$ext_rmobile_no = strtoupper($ext_registered_office_result1['mobile_no']);
$ext_rfax_no1 = strtoupper($ext_registered_office_result1['fax_no1']);
$ext_rfax_no2 = strtoupper($ext_registered_office_result1['fax_no2']);
$ext_remail_id = strtoupper($ext_registered_office_result1['email_id']);
$ext_registered_office_count++;
if ($ext_registered_office_print != "")
{
    $ext_registered_office_print = $ext_registered_office_print ."<br>";
}
$registered_office_print .= ext_registered_office_count.'.' . $ext_raddress1.' '.$ext_raddress2.' '. $ext_raddress3.' '.$ext_rcity.' '.$ext_rstate.' '.$ext_rcountry.' '.$ext_rpincode.'<br/>' ;
}

if ($ext_registered_office_count == 1)
{
	 $ext_registered_office_print = $ext_registered_office_print ."<br>";
}

if ($ext_registered_office_print == "")
{
   $ext_registered_office_print = "NA<br>";
}


//Branch Office

$branch_office_print = "";
$branch_office_result = mysql_query("SELECT * FROM  communication_address_master WHERE registration_id = '$registration_id'  and type_of_address='3' limit 0,2");
$brach_count = 0;
while($branch_office_result1 = mysql_fetch_array($branch_office_result)) {
$bname = strtoupper($branch_office_result1['name']);
$bfather_name = strtoupper($branch_office_result1['father_name']);
$baddress1 = strtoupper($branch_office_result1['address1']);
$baddress2 = strtoupper($branch_office_result1['address2']);
$baddress3 = strtoupper($branch_office_result1['address3']);
$bcountry = strtoupper($branch_office_result1['country']);
$bstate = strtoupper(getState($branch_office_result1['state']));
$bcity = strtoupper($branch_office_result1['city']);
$bpincode = strtoupper($branch_office_result1['pincode']);
$blandline_no1 = strtoupper($branch_office_result1['landline_no1']);
$bmobile_no = strtoupper($branch_office_result1['mobile_no']);
$bfax_no1 = strtoupper($branch_office_result1['fax_no1']);
$bfax_no2 = strtoupper($branch_office_result1['fax_no2']);
$bemail_id = strtoupper($branch_office_result1['email_id']);
$brach_count++;

if ($branch_office_print != "")
{
    $branch_office_print = $branch_office_print ."<br>";
}

$branch_office_print .= $brach_count.'.'. $baddress1.' '.$baddress2.' '. $baddress3.' '.$bcity.' '.$bstate.' '.$bcountry.' '.$bpincode.'<br/>' ;
//$person_count . ". " . "$address1, $address2, $address3, $city, $state, $country, $pincode <br>";
}

if ($brach_count == 1)
{
	 $branch_office_print = $branch_office_print ."<br>";
}

//$branch_office_print =  $branch_office_print . '<br>';
if ($branch_office_print == "")
{
   $branch_office_print = "NA<br/><br/><br/>";
}

//Extra Branch Office
//echo "SELECT * FROM  communication_address_master WHERE registration_id = '$registration_id'  and type_of_address='3' limit 2,20";
$ext_branch_office_print = "";
$ext_branch_office_result = mysql_query("SELECT * FROM  communication_address_master WHERE registration_id = '$registration_id'  and type_of_address='3' limit 2,20");
$ext_branch_office_count = 0;
while($ext_branch_office_result1 = mysql_fetch_array($ext_branch_office_result)) {
$ext_bname = strtoupper($ext_branch_office_result1['name']);
$ext_bfather_name = strtoupper($ext_branch_office_result1['father_name']);
$ext_baddress1 = strtoupper($ext_branch_office_result1['address1']);
$ext_baddress2 = strtoupper($ext_branch_office_result1['address2']);
$ext_baddress3 = strtoupper($ext_branch_office_result1['address3']);
$ext_bcountry = strtoupper($ext_branch_office_result1['country']);
$ext_bstate = strtoupper(getState($ext_branch_office_result1['state']));
$ext_bcity = strtoupper($ext_branch_office_result1['city']);
$ext_bpincode = strtoupper($ext_branch_office_result1['pincode']);
$ext_blandline_no1 = strtoupper($ext_branch_office_result1['landline_no1']);
$ext_bmobile_no = strtoupper($ext_branch_office_result1['mobile_no']);
$ext_bfax_no1 = strtoupper($ext_branch_office_result1['fax_no1']);
$ext_bfax_no2 = strtoupper($ext_branch_office_result1['fax_no2']);
$ext_bemail_id = strtoupper($ext_branch_office_result1['email_id']);
$ext_branch_office_count++;

if ($ext_branch_office_print != "")
{
    $ext_branch_office_print = $ext_branch_office_print ."<br>";
}

$ext_branch_office_print .= $ext_branch_office_count.'.'. $ext_baddress1.' '.$ext_baddress2.' '. $ext_baddress3.' '.$ext_bcity.' '.$ext_bstate.' '.$ext_bcountry.' '.$ext_bpincode.'<br/>' ;
//$person_count . ". " . "$address1, $address2, $address3, $city, $state, $country, $pincode <br>";
}
if ($ext_branch_office_count == 1)
{
	 $ext_branch_office_print = $ext_branch_office_print ."<br>";
}

//$branch_office_print =  $branch_office_print . '<br>';
if ($ext_branch_office_print == "")
{
   $ext_branch_office_print = "NA<br>";
}


//Factory Address

$factor_office_print = "";
//$factor_office_result = mysql_query("SELECT * FROM  communication_address_master WHERE registration_id = '$registration_id'  and type_of_address='4' limit 0,3"); // 12Jul18
$factor_office_result = mysql_query("SELECT * FROM  communication_address_master WHERE registration_id = '$registration_id'  and type_of_address='4' limit 0,5");
$factory_count = 0;
while($factor_office_result1 = mysql_fetch_array($factor_office_result)) {
$fname = strtoupper($factor_office_result1['name']);
$ffather_name = strtoupper($factor_office_result1['father_name']);
$faddress1 = strtoupper($factor_office_result1['address1']);
$faddress2 = strtoupper($factor_office_result1['address2']);
$faddress3 = strtoupper($factor_office_result1['address3']);
$fcountry = strtoupper($factor_office_result1['country']);
$fstate = strtoupper(getState($factor_office_result1['state']));
$fcity = strtoupper($factor_office_result1['city']);
$fpincode = strtoupper($factor_office_result1['pincode']);
$flandline_no1 = strtoupper($factor_office_result1['landline_no1']);
$fmobile_no = strtoupper($factor_office_result1['mobile_no']);
$ffax_no1 = strtoupper($factor_office_result1['fax_no1']);
$ffax_no2 = strtoupper($factor_office_result1['fax_no2']);
$femail_id = strtoupper($factor_office_result1['email_id']);
$factory_count++;

if ($factor_office_print != "")
{
    $factor_office_print = $factor_office_print ."<br>";
}
$factor_office_print .= $factory_count.". ".  $faddress1.' '.$faddress2.' '. $faddress3.' '.$fcity.' '.$fstate.' '.$fcountry.' '.$fpincode.'<br/>' ;
//$person_count . ". " . "$address1, $address2, $address3, $city, $state, $country, $pincode <br>";
}

if ($factory_count == 1)
{
	 $factor_office_print = $factor_office_print ."<br>";
}
//$factor_office_print =  $factor_office_print . '<br>';
if ($factor_office_print == "")
{
   $factor_office_print = "NA<br/><br/><br/>";
}
 
 
//Extra Factory Address

$ext_factor_office_print = "";
$ext_factor_office = mysql_query("SELECT * FROM  communication_address_master WHERE registration_id = '$registration_id'  and type_of_address='4' limit 4,20");/* 01June 2018*/
/*$ext_factor_office = mysql_query("SELECT * FROM  communication_address_master WHERE registration_id = '$registration_id'  and type_of_address='4' limit 2,20"); */
$ext_factor_office_count = 0;
while($ext_factor_office_result1 = mysql_fetch_array($ext_factor_office)) {
$ext_fname = strtoupper($ext_factor_office_result1['name']);
$ext_ffather_name = strtoupper($ext_factor_office_result1['father_name']);
$ext_faddress1 = strtoupper($ext_factor_office_result1['address1']);
$ext_faddress2 = strtoupper($ext_factor_office_result1['address2']);
$ext_faddress3 = strtoupper($ext_factor_office_result1['address3']);
$ext_fcountry = strtoupper($ext_factor_office_result1['country']);
$ext_fstate = strtoupper($ext_factor_office_result1['state']);
$ext_fcity = strtoupper($ext_factor_office_result1['city']);
$ext_fpincode = strtoupper($ext_factor_office_result1['pincode']);
$ext_flandline_no1 = strtoupper($ext_factor_office_result1['landline_no1']);
$ext_fmobile_no = strtoupper($ext_factor_office_result1['mobile_no']);
$ext_ffax_no1 = strtoupper($ext_factor_office_result1['fax_no1']);
$ext_ffax_no2 = strtoupper($ext_factor_office_result1['fax_no2']);
$ext_femail_id = strtoupper($ext_factor_office_result1['email_id']);
$ext_factor_office_count++;

if ($ext_factor_office_print != "")
{
    $ext_factor_office_print = $ext_factor_office_print ."<br>";
}
$ext_factor_office_print .= $ext_factor_office_count.". ".  $ext_faddress1.' '.$ext_faddress2.' '. $ext_faddress3.' '.$ext_fcity.' '.$ext_fstate.' '.$ext_fcountry.' '.$ext_fpincode.'<br/>' ;
//$person_count . ". " . "$address1, $address2, $address3, $city, $state, $country, $pincode <br>";
}

if ($ext_factor_office_count == 1)
{
	 $ext_factor_office_print = $ext_factor_office_print ."<br>";
}
//$factor_office_print =  $factor_office_print . '<br>';
if ($ext_factor_office_print == "")
{
   $ext_factor_office_print = "NA<br>";
}
 
 
if ($ext_registered_office_count > 0){
$extra_regis='<tr>
       <td style="border-top:1px solid #666"></td>
       </tr>
		<tr>
        <td valign="top"><strong>Address of the Registered Office</strong><br><br></td>
       </tr>
       <tr>
        <td valign="top">'.$ext_registered_office_print.'</td>
      </tr>';
}
if ($ext_branch_office_count > 0){	  
$extra_branch=' <tr>
       <td style="border-top:1px solid #666"></td>
      </tr>
	   
      <tr>
        <td valign="top"><strong>Address of the Branch(s)</strong><br><br></td>
      </tr>
	  
       <tr>
       <td valign="top">'.$ext_branch_office_print.'</td>
      </tr>';
}
if ($ext_factor_office_count > 0){
 $extra_factory='<tr>
       <td style="border-top:1px solid #666"></td>
       </tr>
      <tr>
        <td valign="top"><strong>Address of the Factory(s)</strong><br><br></td>
      </tr>
      <tr>
       <td valign="top">'.$ext_factor_office_print.'</td>
      </tr>';
}
if ($ext_head_office_count > 0){	  
$extra_head='<tr>
       <td style="border-top:1px solid #666"></td>
       </tr>
      <tr>
        <td valign="top"><strong>Address of the Head Office</strong><br><br></td>
      </tr>
      <tr>
       <td valign="top">'.$ext_head_office_print.'</td>
      </tr>';
} 
 
 
// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mukesh Singh');
$pdf->SetTitle('Certificate');
$pdf->SetSubject('Certificate');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');



// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetTopMargin(35);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);
// ---------------------------------------------------------
$certificate = 'file://'.realpath('sslcertificate.crt');
$info = array(
    'Name' => 'Mithilesh Pandey',
    'Location' => 'Mumbai',
    'Reason' => 'digital signature for rcmc',
    'ContactInfo' => 'http://www.gjepc.org',
    );

// set document signature
$pdf->setSignature($certificate, $certificate, 'kwebmaker', '', 2, $info);




$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('helvetica', '', 9);
$pdf->SetXY(18,20);
$txt = <<<EOD
<table width="580" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="2" align="center" valign="top"><strong><font size="+2">THE GEM &amp; JEWELLERY EXPORT PROMOTION COUNCIL</font></strong></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="top"><strong>$region_real_name</strong></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="top"><strong>REGISTRATION CUM MEMBERSHIP CERTIFICATE</strong></td>
  </tr>
  
  <tr>
    <td height="25" align="center" valign="top"><strong>PART I<br />
    </strong>(Based on information filled in by the applicant)</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><table width="637" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="16" height="20" valign="top">1.</td>
        <td width="295" valign="top">Name of the exporter</td>
        <td width="15" valign="top">:</td>
        <td width="311" valign="top"><strong>$company_name</strong></td>
      </tr>
      <tr>
        <td height="10" valign="top"></td>
        <td height="10" valign="top"></td>
        <td height="10" valign="top"></td>
        <td height="10" valign="top"></td>
      </tr>
      <tr>
        <td height="20" valign="top">2.</td>
        <td valign="top">IEC Number</td>
        <td valign="top">:</td>
        <td valign="top">$iec_no</td>
      </tr>
      <tr>
        <td valign="top">3.</td>
        <td valign="top">Address of the Registered / Head Office</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">$head_office_print</td>
      </tr>
	
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">(i) Address of the Registered Office</td>
        <td valign="top">:</td>
        <td valign="top">$registered_office_print</td>
      </tr>
	
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">(ii) Address of the Branch</td>
        <td valign="top">:</td>
        <td valign="top">$branch_office_print</td>
      </tr>
    
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">(iii) Address of the Factory</td>
        <td valign="top">:</td>
        <td valign="top">$factor_office_print</td>
      </tr>
    
      <tr>
        <td valign="top" height="25">4.</td>
        <td valign="top">Date of Establishment</td>
        <td valign="top">:</td>
        <td valign="top">$year_of_starting_bussiness</td>
      </tr>
      
      <tr>
        <td valign="top" height="25">5.</td>
        <td valign="top">Description of goods/ services for which registered</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" valign="top">&nbsp;</td>
        <td valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20" height="24" align="left" valign="top">(i)</td>
            <td width="500" align="left" valign="top">Polished &amp; Processed pearls (real or cultured)</td>
            <td width="100" align="center" valign="top">$polished_and_processed_pearls</td>
          </tr>
          <tr>
            <td height="22" align="left" valign="top">(ii)</td>
            <td align="left" valign="top">Cut &amp; Polished Diamonds</td>
            <td align="center" valign="top">$cut_and_polished_diamonds</td>
          </tr>
          <tr>
            <td height="22" align="left" valign="top">(iii)</td>
            <td align="left" valign="top">Cut &amp; Polished Coloured Gemstones</td>
            <td align="center" valign="top">$cut_and_polished_color_gemstones</td>
          </tr>
          <tr>
            <td height="22" align="left" valign="top">(iv)</td>
            <td valign="top" style="text-align:justify">Jewellery containing gold, silver, platinum or palladium and studded with diamonds, coloured gemstones, real or cultured pearls or synthetic / limitation stones as per description in the Export and Import Policy Book 2015-2020.</td>
            <td align="center" valign="top">$jewellery_containing_gold</td>
          </tr>
          <tr>
            <td height="10" align="left" valign="top">&nbsp;</td>
            <td height="10" align="left" valign="top">&nbsp;</td>
            <td height="10" align="center" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td height="22" align="left" valign="top">(v)</td>
            <td align="left" valign="top">Cut and Polished Synthetic Stones</td>
            <td align="center" valign="top">$cut_and_polished_synthetic_stone</td>
          </tr>
          <tr>
            <td height="22" align="left" valign="top">(vi)</td>
            <td align="left" valign="top">Costume/Fashion Jewellery as per description given in Export-Import Policy Book 2015-2020</td>
            <td align="center" valign="top">$costume_fashion_jewllery</td>
          </tr>
          <tr>
            <td height="22" align="left" valign="top" width="25">(vii)</td>
            <td align="left" valign="top">Silver Filligree Jewellery, Silver Filligree & Silver Articles.</td>
            <td align="center" valign="top">$silver_jewellery_silver_filligree</td>
          </tr>
          <tr>
            <td height="22" align="left" valign="top" width="25">(viii)</td>
            <td align="left" valign="top">Rough Diamonds</td>
            <td align="center" valign="top">$rough_diamonds</td>
          </tr>
          
        </table></td>
      </tr>
      
      <tr><td>&nbsp;</td></tr>
      <tr>
        <td valign="top" height="25">6.</td>
        <td valign="top">Registration Number</td>
        <td valign="top">:</td>
        <td valign="top" style="font-size:12px;"><b>$rcmc_regno</b></td>
      </tr>

     <tr><td>&nbsp;</td></tr>
      <tr>
        <td valign="top" height="25">7.</td>
        <td valign="top">Registered as</td>
        <td valign="top">:</td>
        <td valign="top"><b>$member_type_id</b></td>
      </tr>
	 <tr><td>&nbsp;</td></tr>
      <tr>       
        <td valign="top">8.</td>
        <td valign="top">Name of the Proprietor/Partner(s)/Director(s)/karta of HUF</td>
        <td valign="top">:</td>
        <td valign="top">$designation</td>
      </tr>
	  <tr>
	  <td height="30"></td>
	  </tr>
      <tr>
        <td>$person_office_table_print</td>
      </tr>
		<tr>
	  		<td height="10"></td>
	  	</tr>
      <tr>
        <td colspan="4" >This certificate is issued as per the details of our records and is subject to the conditions laid down in the relevant scheme of registration of this Council.</td>
    </tr>
	<tr><td>&nbsp;</td></tr>
    </table></td>
  </tr>
<tr>
	<td valign="top" height="50">&nbsp;</td>
</tr>
  
  
  <tr>
    <td valign="top"><table width="637" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="350" valign="top">This Registration is valid for 5 years w.e.f. .<strong>$reg_start_year1</strong><br/> Subject to renewal of membership every year before 30th April</td>
        <!--<td width="320" valign="top" align="left"></td>-->
		<td colspan="2" width="280" valign="top" align="right">(Signature of the competent officer of the E.P. Council)</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" valign="top">Valid/renewed</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="22" valign="top">upto: <strong> $reg_end_year</strong></td>
        <td valign="top"></td>
      </tr>
      <tr>
        <td height="22" valign="top">Date of Issue: <strong>$certificate_issued_dt</strong></td>
        <td valign="top"></td>
      </tr>
      <tr>
        <td height="22" valign="top">&nbsp;</td>
        <td valign="top"></td>
      </tr>
    </table></td>
  </tr>
  
  
  
  <tr>
  <td height="20">&nbsp;</td>
  </tr>
	<tr>
		<td valign="top" height="40">&nbsp;</td>
	</tr>
  <tr>
        <td colspan="2"><b>Note :</b> This import certificate is not a substitute for import Licence in respect of the items mentioned restricted under ITC(HS) and an import licence, in addition to this Certificate, will have to obtained wherever required for such items.</td>
    </tr>
	<tr>
	 <td>&nbsp;&nbsp;</td>
	</tr>
		
	$amendment_msg
	
<tr>
	<td valign="top" height="20">&nbsp;</td>
</tr>
</table>
EOD;
$office_html = <<<EOD
      <br><br><br>
  <table width="637" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td valign="top">Head Office / Registered Office / Branch / Factory list annexed to <strong>$information_company_name</strong>
       <br><br>IEC Number : <strong>$iec_no</strong>
	   </td>
   </tr>	  
       $extra_head
	   $extra_regis
	   $extra_branch
       $extra_factory
       <tr>
       <td style="border-top:1px solid #666"></td>
       </tr>
     </table>
EOD;

if($region_id=="HO-MUM (M)")
{	
	$certificate = 'file://'.realpath('sslcertificate.crt');
	$info = array(
		'Name' => 'Mithilesh Pandey',
		'Location' => 'Mumbai',
		'Reason' => 'digital signature for rcmc',
		'ContactInfo' => 'mithilesh@gjepcindia.com',
		);
	$signature = 'images/ms.jpg';
}
elseif($region_id=="RO-DEL")
{
		
	$certificate = 'file://'.realpath('delhi.crt');
	$info = array(
		'Name' => 'K.K. Duggal',
		'Location' => 'New Delhi',
		'Reason' => 'digital signature for rcmc',
		'ContactInfo' => 'kkduggal@gjepcindia.com',
		);
	$signature = 'images/kkduggalRCMC.jpg';
}
elseif($region_id=="RO-SRT")
{
		
	$certificate = 'file://'.realpath('surat.crt');
	$info = array(
		'Name' => 'Jilpa Sheth',
		'Location' => 'Surat',
		'Reason' => 'digital signature for rcmc',
		'ContactInfo' => 'jilpa.sheth@gjepcindia.com',
		);
	$signature = 'images/jilpa.jpg';
}
elseif($region_id=="RO-JAI")
{
		
	$certificate = 'file://'.realpath('jaipur.crt');
	$info = array(
		'Name' => 'Sanjay Singh',
		'Location' => 'Jaipur',
		'Reason' => 'digital signature for rcmc',
		'ContactInfo' => 'sanjaysingh@gjepcindia.com',
		);
	$signature = 'images/sanjay.jpg';
}
elseif($region_id=="RO-KOL")
{		
	$certificate = 'file://'.realpath('kol.crt');
	$info = array(
		'Name' => 'Shri Sanjay Singh',
		'Location' => 'Kolkata',
		'Reason' => 'digital signature for rcmc',
		'ContactInfo' => 'sanjaysingh@gjepcindia.com',
		);
	$signature = 'images/sanjay_kol.jpg';
}
elseif($region_id=="RO-CHE")
{	
	$certificate = 'file://'.realpath('sslcertificate.crt');
	$info = array(
		'Name' => 'Shri R. Surya Narayanan',
		'Location' => 'Chennai',
		'Reason' => 'digital signature for rcmc',
		'ContactInfo' => 'mithilesh@gjepcindia.com',
		);
	$signature = 'images/surya.jpg';
}

// print a block of text using Write()
$pdf->writeHTML($txt, true, false, true, false, '');

//$pdf->Image($signature, 120, 62, 65, 14, 'JPG');
$pdf->Image($signature, 120, 70, 65, 25, 'JPG');
//$pdf->Image($signature, 15, 165, 65, 14, 'JPG');
// define active area for signature appearance

//$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('helvetica', '', 9);
$pdf->SetXY(17,20);
//$pdf->writeHTML($html_page2, true, false, true, false, '');

if ($ext_head_office_count > 0 || $ext_factor_office_count > 0 || $ext_registered_office_count > 0 || $ext_branch_office_count > 0 )
{
    $pdf->AddPage();
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->SetFont('helvetica', '', 9);
    $pdf->writeHTML($office_html, true, false, true, false, '');
}

ob_clean();
$pdf->Output('rcmc_certificate.pdf', 'I');