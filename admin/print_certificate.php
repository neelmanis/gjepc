<?php 
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
require_once('../rcmc/tcpdf_include.php');    
require_once('../db.inc.php');
require_once('../functions.php');

$registration_id=$_REQUEST['registration_id'];

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		//right Logo
    		$left_image_file =  K_PATH_IMAGES.'logo_gjepc.png';
    		$this->Image($left_image_file, 165, 10, '', 20, 'PNG', '', 'T', false, 72, '', false, false, 0, false, false, false);
    		//left Logo
    		$right_image_file =  K_PATH_IMAGES.'logo_in.png';
    		$this->Image($right_image_file, 10, 10, '', 20, 'PNG', '', 'T', false, 72, '', false, false, 0, false, false, false);
            $this->SetLineStyle(1);
            $this->Rect(8,8,193,275);
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
    		$this->SetY(-15);
    		// Set font
    		$this->SetFont('helvetica', 'I', 8);
    		// Page number
    		$this->Cell(80, 10, 'RCMC Certificate- Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			$this->Cell(-80, 10, date("m/d/Y h:i a"), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

$query = mysql_query("SELECT * FROM information_master where registration_id='$registration_id'");
$default= mysql_fetch_array($query);
    
$company_name1 = strtoupper($default['company_name']);
$company_name2 = $default['company_name2'];
$company_name=$company_name1.$company_name2;
$member_type_id = $default['member_type_id'];
$type_of_firm = $default['type_of_firm'];
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
$year_of_starting_bussiness = strtoupper($default['year_of_starting_bussiness']);
$contact_name = strtoupper($default['name']);
$designation = strtoupper($default['designation']);
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

if ($type_of_firm == "Private Ltd" || $type_of_firm == "Public Ltd")
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

$head_reg_office_print = "$haddress1 $haddress2 $haddress3 $hcity $hstate $hcountry";



$com_default = mysql_fetch_array(mysql_query("SELECT * FROM communication_details_master WHERE registration_id = '$registration_id'"));

$panel_name = $com_default['panel_name'];
$export_product_name =$com_default['export_product_name'];
$authority_firm_name = $com_default['authority_firm_name'];
$authority_firm_registration_no = $com_default['authority_firm_registration_no'];
$authority_registration_date = $com_default['authority_registration_date'];
$authority_registration_valid_upto = $com_default['authority_registration_valid_upto'];
$registration_required = $export_product_name;



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
if ($type_of_firm == "Private Ltd" || $type_of_firm == "Public Ltd"){$details_person_office = "7";}
else if($type_of_firm == "Partnership"){$details_person_office = "5";}
else if ($type_of_firm == "Proprietory" || $type_of_firm == "Proprietory HUF"){$details_person_office = "1";}
else if($type_of_firm == "Indiviudal"){$details_person_office = "8";}
else if($type_of_firm == "Trustees"){$details_person_office = "9";}
else if($type_of_firm == "Co-Op Society"){$details_person_office = "10";}
else if($type_of_firm == "Others"){$details_person_office = "7";}


$person_count = 0;
$person_office_print = '';
$person_office = mysql_query("SELECT *  FROM communication_address_master WHERE registration_id = '$registration_id'  and type_of_address='$details_person_office'");
while($person_office_result = mysql_fetch_array($person_office)) {
$person_name = strtoupper($person_office_result['name']);
$father_name = strtoupper($person_office_result['father_name']);
$address1 = strtoupper($person_office_result['address1']);
$address2 = strtoupper($person_office_result['address2']);
$address3 = strtoupper($person_office_result['address3']);
$country = strtoupper($person_office_result['country']);
$state = strtoupper($person_office_result['state']);
$city = strtoupper($person_office_result['city']);
$pincode = strtoupper($person_office_result['pincode']);
$landline1 = strtoupper($person_office_result['landline_no1']);
$mobile = strtoupper($person_office_result['mobile_no']);
$fax1 = strtoupper($person_office_result['fax_no1']);
$fax2 = strtoupper($person_office_result['fax_no2']);
$email = strtoupper($person_office_result['email_id']);


$person_office_print[$person_count] = ($person_count +1) .'. '.$person_name.'<br/>' ;
$person_count++;
//$person_count . ". " . "$address1, $address2, $address3, $city, $state, $country, $pincode <br>";
}


//$person_office_print =  $person_office_print . '<br>';

$person_office_table_print = '<table width="637" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="25" align="left" valign="middle">'.$person_office_print[0].'&nbsp;</td>
    <td height="25" align="left" valign="middle">'.$person_office_print[1].'&nbsp;</td>
    <td height="25" align="left" valign="middle">'.$person_office_print[2].'&nbsp;</td>
  </tr>
  <tr>
    <td height="25" align="left" valign="middle">'.$person_office_print[3].'&nbsp;</td>
    <td height="25" align="left" valign="middle">'.$person_office_print[4].'&nbsp;</td>
    <td height="25" align="left" valign="middle">'.$person_office_print[5].'&nbsp;</td>
  </tr>
  <tr>
    <td height="25" align="left" valign="middle">'.$person_office_print[6].'&nbsp;</td>
    <td height="25" align="left" valign="middle">'.$person_office_print[7].'&nbsp;</td>
    <td height="25" align="left" valign="middle">'.$person_office_print[8].'&nbsp;</td>
  </tr>
  <tr>
    <td height="25" align="left" valign="middle">'.$person_office_print[9].'&nbsp;</td>
    <td height="25" align="left" valign="middle">'.$person_office_print[10].'&nbsp;</td>
    <td height="25" align="left" valign="middle">'.$person_office_print[11].'&nbsp;</td>
  </tr>
</table>';


$certificate_renewal_data = mysql_fetch_array(mysql_query("SELECT * FROM approval_master WHERE registration_id='$registration_id'"));
$applied_for_rcmc_certificate =	strtoupper($certificate_renewal_data['rcmc_certificate_apply']);
$membership_category =	strtoupper(getMemberType($certificate_renewal_data['registration_id']));
$reg_start_year_merchant 	=	strtoupper($certificate_renewal_data['rcmc_certificate_issue_date']);
$reg_end_year_merchant 	=	strtoupper($certificate_renewal_data['rcmc_certificate_expire_date']);
$reg_start_year_manufacturer =	strtoupper($certificate_renewal_data['rcmc_certificate_issue_date']);
$reg_end_year_manufacturer =	strtoupper($certificate_renewal_data['rcmc_certificate_expire_date']);
$merchant_reg_no 	=	strtoupper($certificate_renewal_data['merchant_certificate_no']);
$manufacturer_reg_no =	strtoupper($certificate_renewal_data['manufacturer_certificate_no']);
$certificate_issued_dt 	=	$certificate_renewal_data['rcmc_certificate_issue_date'];


if ($membership_category == strtoupper("Merchant"))
{
	$rcmc_regno = $merchant_reg_no;
	$reg_start_year = $reg_start_year_merchant;
	$reg_end_year = $reg_end_year_merchant ;

}
elseif($membership_category == "")
{

$rcmc_regno = "NA";
}
else
{
	$rcmc_regno = $manufacturer_reg_no;
	$reg_start_year = $reg_start_year_manufacturer;
	$reg_end_year = $reg_end_year_manufacturer ;
}

//Head Office
$head_office_print = "";
$head_office_result = mysql_query("SELECT name, father_name, address1, address2, address3, country, state, city, pincode, landline_no1, mobile_no, fax_no1, fax_no2, email_id FROM communication_address_master  WHERE registration_id = '$registration_id'  and type_of_address='2' limit 0,2");
$person_count = 0;
while($head_office_result1 = mysql_fetch_array($head_office_result)) {
$person_name = strtoupper($head_office_result1['name']);
$fathers_name = strtoupper($head_office_result1['father_name']);
$address1 = strtoupper($head_office_result1['address1']);
$address2 = strtoupper($head_office_result1['address2']);
$address3 = strtoupper($head_office_result1['address3']);
$country = strtoupper($head_office_result1['country']);
$state = strtoupper($head_office_result1['state']);
$city = strtoupper($head_office_result1['city']);
$pincode = strtoupper($head_office_result1['pincode']);
$landline1 = strtoupper($head_office_result1['landline_no1']);
$mobile = strtoupper($head_office_result1['mobile_no']);
$fax1 = strtoupper($head_office_result1['fax_no1']);
$fax2 = strtoupper($head_office_result1['fax_no2']);
$email = strtoupper($head_office_result1['email_id']);
$person_count++;
//$person_office_print =  $person_office_print . $person_count.'. '.$person_name.', '. $address1.', '.$address2.', '. $address3.', '.$city.', '.$state.', '.$country.', '.$pincode.'<br/><br/>';
if ($head_office_print != "")
{
    $head_office_print = $head_office_print ."<br>";
}
$head_office_print = $head_office_print . $address1.' '.$address2.' '. $address3.' '.$city.' '.$state.' '.$country.' '.$pincode.'<br/>' ;
//$person_count . ". " . "$address1, $address2, $address3, $city, $state, $country, $pincode <br>";
}

if ($person_count == 1)
{
	 $head_office_print = $head_office_print ."<br><br><br>";
}

//$head_office_print =  $head_office_print . '<br>';
if ($head_office_print == "")
{
   $head_office_print = "NA<br><br><br><br><br>";
}





// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mukesh Singh');
$pdf->SetTitle('Information Form');
$pdf->SetSubject('Information Form');
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
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('helvetica', '', 9);

$txt = <<<EOD
<table width="637" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="25" align="center" valign="top"><strong><font size="+5">THE GEM &amp; JEWELLERY EXPORT PROMOTION COUNCIL</font></strong></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="top"><strong>$region_real_name</strong></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="top"><strong>FORM OF REGISTRATION CUM MEMBERSHIP CERTIFICATE</strong></td>
  </tr>
  
  <tr>
    <td height="25" align="center" valign="top"><strong>PART I<br />
    </strong>(To be filled in by the applicant)</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td valign="top"><table width="637" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="16" height="25" valign="top">1.</td>
        <td width="295" valign="top">Name and address of the applicant</td>
        <td width="15" valign="top">:</td>
        <td width="311" valign="top"><strong>$company_name
          </strong><br />
          $head_reg_office_print</td>
      </tr>
      <tr>
        <td height="10" valign="top"></td>
        <td height="10" valign="top"></td>
        <td height="10" valign="top"></td>
        <td height="10" valign="top"></td>
      </tr>
      <tr>
        <td height="25" valign="top">2.</td>
        <td valign="top">IEC Number &amp; Date</td>
        <td valign="top">:</td>
        <td valign="top">0$iec_no - $iec_issue_date</td>
      </tr>
      <tr>
        <td valign="top">3.</td>
        <td valign="top">Address of the Head Office</td>
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
        <td valign="top">(ii) Address of the Branch(s)</td>
        <td valign="top">:</td>
        <td valign="top">$branch_office_print</td>
      </tr>
    
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">(iii) Address of the Factory(s)</td>
        <td valign="top">:</td>
        <td valign="top">$factor_office_print</td>
      </tr>
    
      <tr>
        <td height="25" valign="top">4.</td>
        <td valign="top">Year of Establishment</td>
        <td valign="top">:</td>
        <td valign="top">$year_of_starting_bussiness</td>
      </tr>
      
      <tr>
        <td height="25" valign="top">5.</td>
        <td valign="top">Description of export products for which registration is sought</td>
        <td valign="top">:</td>
        <td valign="top">$registration_required</td>
      </tr>
     
      <tr>
        <td height="25" valign="top">6.</td>
        <td valign="top">Whether registration is required as merchant exporter or manufacturer exporter</td>
        <td valign="top">:</td>
        <td valign="top">$member_type_id</td>
      </tr>
	 <tr>
        <td height="10" valign="top"></td>
        <td height="10" valign="top"></td>
        <td height="10" valign="top"></td>
        <td height="10" valign="top"></td>
      </tr>
      <tr>
        <td height="15" valign="top">7.</td>
        <td valign="top">Name of the Proprietor / Partners / Directors / karta of HUF</td>
        <td valign="top">:</td>
        <td valign="top">$type_of_firm</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>$person_office_table_print</td>
  </tr>
  <tr>
    <td valign="top">I/We hereby declare that the above information is correct to the best of my/our knowledge and belief. I/We also undertake to abide by the conditions subject to which registration / membership is granted</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
 <tr>
        <td height="10" valign="top"></td>
        <td height="10" valign="top"></td>
        <td height="10" valign="top"></td>
        <td height="10" valign="top"></td>
 </tr>
  <tr>
    <td valign="top"><table width="637" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="38" valign="top">&nbsp;</td>
        <td width="10" height="25" valign="top">&nbsp;</td>
        <td width="240" valign="top">&nbsp;</td>
        <td width="129" valign="top">Signature</td>
        <td width="10" valign="top">:</td>
        <td width="210" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td height="25" valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top">Name in block letters</td>
        <td valign="top">:</td>
        <td valign="top">$contact_name</td>
      </tr>
      <tr>
        <td valign="top">Place</td>
        <td height="25" valign="top">:</td>
        <td valign="top"> $information_region_name</td>
        <td width="129" valign="top">Designation</td>
        <td valign="top">:</td>
        <td valign="top">$designation</td>
      </tr>
      <tr>
        <td valign="top">Date</td>
        <td height="25" valign="top">:</td>
        <td valign="top">$certificate_issued_dt</td>
        <td valign="top">Resi. Address</td>
        <td valign="top">:</td>
        <td valign="top">$address1 $address2 $address3 $city $country $pin_code</td>
      </tr>
      
    </table></td>
  </tr>
</table>
EOD;

// print a block of text using Write()
$pdf->writeHTML($txt, true, false, true, false, '');
$pdf->Output('communication_form.pdf', 'I');
