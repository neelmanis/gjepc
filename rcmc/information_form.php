<?php
ob_start();
//============================================================+
// File name   : Information Form
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Information Form for TCPDF class
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

$registration_id = intval(filter($_SESSION['USERID'])); 

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	public function Header() {
		
		    //right Logo
    		$left_image_file =  K_PATH_IMAGES.'logo.png';
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
    		$this->Cell(80, 10, 'Information Form - Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			$this->Cell(-80, 10, date("d/m/Y h:i a"), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

$cur_year = (int)date('y');
$curyear  = (int)date('Y');
$cur_month = (int)date('m');
if($cur_month < 4) {
 $cur_fin_yr = $curyear-1;
 $cur_fin_yr1= $cur_year-1;
 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
 $last_finyr= ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
} else {
 $cur_fin_yr = $curyear;
 $cur_fin_yr1= $cur_year;
 $cur_finyr  = $cur_fin_yr1 . '-' . ($cur_fin_yr1+1);
 $last_finyr = ($cur_fin_yr1-1) . '-' . $cur_fin_yr1;
}

$getAuthPerson = $conn ->query("SELECT * FROM communication_address_master where registration_id='$registration_id' AND type_of_address='13'");
$getresult= $getAuthPerson->fetch_assoc();
$designation = strtoupper($getresult['designation']);
$contact_name = strtoupper($getresult['name']);
$address1 = strtoupper($getresult['address1']);
$address2 = strtoupper($getresult['address2']);
$address3 = strtoupper($getresult['address3']);
$pin_code = strtoupper($getresult['pincode']);
$city = strtoupper($getresult['city']);
$land_line_no = strtoupper($getresult['landline_no1']);
$info_mobile_no = strtoupper($getresult['mobile_no']);
$info_email_id = strtolower($getresult['email_id']);

$qho = $conn ->query("SELECT pan_no,gst_no FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2' limit 1");
$rho = $qho->fetch_assoc();
$pan_no = strtoupper($rho['pan_no']);
$gst_no = strtoupper($rho['gst_no']);

$queryInfo = $conn ->query("SELECT * FROM information_master where registration_id='$registration_id'");
$default= $queryInfo->fetch_assoc(); 
$company_name = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $default['company_name']));

$member_type_id = $default['member_type_id'];
if($member_type_id==5){ $member_type_id = "Merchant"; } else { $member_type_id = "Manufacturer"; }
$type_of_firm = $default['type_of_firm'];
$iec_no = strtoupper($default['iec_no']);
$iec_issue_date = strtoupper($default['iec_issue_date']);
$im_registration_no = strtoupper($default['im_registration_no']);
$im_pin_code = strtoupper($default['im_pin_code']);
$ssi_registration_no = strtoupper($default['ssi_registration_no']);
$ssi_issue_date = strtoupper($default['ssi_issue_date']);
if($ssi_issue_date=="0000-00-00"){$ssi_issue_date="NA";}
$ssi_pin_code = strtoupper($default['ssi_pin_code']);
$issuing_industrial_liecence = strtoupper($default['issuing_industrial_liecence']);
$authority = strtoupper($default['authority']);
$eh_th_certification_no = strtoupper($default['eh_th_certification_no']);
if($eh_th_certification_no=="0"){$eh_th_certification_no="NA";}
$eh_th_issue_date = strtoupper($default['eh_th_issue_date']);
if($eh_th_issue_date=="0000-00-00"){$eh_th_issue_date="NA";}
$eh_th_valid_date = strtoupper($default['eh_th_valid_date']);
if($eh_th_valid_date=="0000-00-00"){$eh_th_valid_date="NA";}
$region_id = strtoupper($default['region_id']);
$year_of_starting_bussiness = strtoupper($default['year_of_starting_bussiness']);
$tan_no = strtoupper($default['tan_no']);

$joining_date = strtoupper($default['joining_date']);
$retirement_date = strtoupper($default['retirement_date']);
$date = date('d-m-Y');

//Head Office  or    Registered Office
if($type_of_firm == "13" || $type_of_firm == "12")
{
    $head_register_office = "6";
} else {
    $head_register_office = "2";
}

$head_reg = $conn ->query("SELECT name, father_name, address1, address2, address3, country, state, city, pincode, landline_no1, mobile_no, fax_no1, fax_no2, email_id FROM communication_address_master  WHERE registration_id = '$registration_id'  and type_of_address='$head_register_office' limit 0,1");
$head_reg_office = $head_reg->fetch_assoc();

$hname = strtoupper($head_reg_office['name']);
$hfather_name = strtoupper($head_reg_office['father_name']);
$haddress1 = strtoupper($head_reg_office['address1']);
if($haddress1!=""){$haddress1=$haddress1;}else{$haddress1="";}
$haddress2 = strtoupper($head_reg_office['address2']);
if($haddress2!=""){$haddress2=",".$haddress2;}else{$haddress2="";}
$haddress3 = strtoupper($head_reg_office['address3']);
if($haddress3!=""){$haddress3=",".$haddress3;}else{$haddress3="";}
$hcountry = strtoupper(getFullCountryeName($head_reg_office['country'],$conn));
if($hcountry!=""){$hcountry=",".$hcountry;}else{$hcountry="";}
$hstate = strtoupper(getFullStateName($head_reg_office['state'],$conn));
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
//Branch Office
$branch_office_print = "";
$branch_count = 0;

$branch_office = $conn ->query("SELECT name, father_name, address1, address2, address3, country, state, city, pincode, landline_no1, mobile_no, fax_no1, fax_no2, email_id FROM communication_address_master  WHERE registration_id = '$registration_id'  and type_of_address='3'");

while($branch_office_result = $branch_office->fetch_assoc()) {

$bname = strtoupper($branch_office_result['name']);
$bfather_name = strtoupper($branch_office_result['father_name']);
$baddress1 = strtoupper($branch_office_result['address1']);
if($baddress1!=""){$baddress1=$baddress1;}else{$baddress1="";}
$baddress2 = strtoupper($branch_office_result['address2']);
if($baddress2!=""){$baddress2=",".$baddress2;}else{$baddress2="";}
$baddress3 = strtoupper($branch_office_result['address3']);
if($baddress3!=""){$baddress3=",".$baddress3;}else{$baddress3="";}
$bcountry = strtoupper(getFullCountryeName($branch_office_result['country'],$conn));
if($bcountry!=""){$bcountry=",".$bcountry;}else{$bcountry="";}
$bstate = strtoupper(getFullStateName($branch_office_result['state'],$conn));
if($bstate!=""){$bstate=",.$bstate";}else{$bstate="";}
$bcity = strtoupper($branch_office_result['city']);
if($bcity!=""){$bcity=",".$bcity;}else{$bcity="";}
$bpincode = strtoupper($branch_office_result['pincode']);
if($bpincode!=""){$bpincode=",".$bpincode;}else{$bpincode="";}
$blandline_no1 = strtoupper($branch_office_result['landline_no1']);
if($blandline_no1!=""){$blandline_no1=",".$blandline_no1;}else{$blandline_no1="";}
$bmobile_no = strtoupper($branch_office_result['mobile_no']);
if($bmobile_no!=""){$bmobile_no=",".$bmobile_no;}else{$bmobile_no="";}
$bfax_no1 = strtoupper($branch_office_result['fax_no1']);
if($bfax_no1!=""){$bfax_no1=",".$bfax_no1;}else{$bfax_no1="";}
$bfax_no2 = strtoupper($branch_office_result['fax_no2']);
if($bfax_no2!=""){$bfax_no2=",".$bfax_no2;}else{$bfax_no2="";}
$bemail_id = strtoupper($branch_office_result['email_id']);
if($bemail_id!=""){$bemail_id=",".$bemail_id;}else{$bemail_id="";}
$branch_count++;

$branch_office_print =  $branch_office_print . $branch_count . ". " . "$baddress1 $baddress2 $baddress3 $bcity $bstate $bcountry $bpincode <br>";

}
if ($branch_office_print == "")
{
    $branch_office_print = "NA<br>";
}

//Factory Address
$factory_office_print = "";
$factory_count = 0;
$factory_office = $conn ->query("SELECT name, father_name, address1, address2, address3, country, state, city, pincode, landline_no1, mobile_no, fax_no1, fax_no2, email_id FROM communication_address_master  WHERE registration_id = '$registration_id'  and type_of_address='4'");
while($factory_office_result = $factory_office->fetch_assoc()) {
$fname = strtoupper($factory_office_result['name']);
$ffather_name = strtoupper($factory_office_result['father_name']);
$faddress1 = strtoupper($factory_office_result['address1']);
if($faddress1!=""){$faddress1=$faddress1;}else{$faddress1="";}
$faddress2 = strtoupper($factory_office_result['address2']);
if($faddress2!=""){$faddress2=",".$faddress2;}else{$faddress2="";}
$faddress3 = strtoupper($factory_office_result['address3']);
if($faddress3!=""){$faddress3=",".$faddress3;}else{$faddress3="";}
$fcountry = strtoupper(getFullCountryeName($factory_office_result['country'],$conn));
if($fcountry!=""){$fcountry=",".$fcountry;}else{$fcountry="";}
$fstate = strtoupper(getFullStateName($factory_office_result['state'],$conn));
if($fstate!=""){$fstate=",".$fstate;}else{$fstate="";}
$fcity = strtoupper($factory_office_result['city']);
if($fcity!=""){$fcity=",".$fcity;}else{$fcity="";}
$fpincode = strtoupper($factory_office_result['pincode']);
if($fpincode!=""){$fpincode=",".$fpincode;}else{$fpincode="";}
$flandline_no1 = strtoupper($factory_office_result['landline_no1']);
if($flandline_no1!=""){$flandline_no1=",".$flandline_no1;}else{$flandline_no1="";}
$fmobile_no = strtoupper($factory_office_result['mobile_no']);
if($fmobile_no!=""){$fmobile_no.=",";}else{$fmobile_no="";}
$ffax_no1 = strtoupper($factory_office_result['fax_no1']);
if($ffax_no1!=""){$ffax_no1=",".$ffax_no1;}else{$ffax_no1="";}
$ffax_no2 = strtoupper($factory_office_result['fax_no2']);
if($ffax_no2!=""){$ffax_no2=",".$ffax_no2;}else{$ffax_no2="";}
$femail_id = strtoupper($factory_office_result['email_id']);
if($femail_id!=""){$femail_id=",".$femail_id;}else{$femail_id="";}
$factory_count++;

$factory_office_print =  $factory_office_print . $factory_count . ". " . "$faddress1 $faddress2 $faddress3 $fcity $fstate $fcountry $fpincode <br>";

}

if ($factory_office_print == "")
{
    $factory_office_print = "NA<br>";
}

$qcom_default = $conn ->query("SELECT * FROM communication_details_master WHERE registration_id = '$registration_id'");
$com_default = $qcom_default->fetch_assoc();
$panel_name = $com_default['panel_name'];
$refer_membership_id = $com_default['refer_membership_id'];
$refer_firm_name = $com_default['refer_firm_name'];
$authority_firm_name = $com_default['authority_firm_name'];
$authority_firm_registration_no = $com_default['authority_firm_registration_no'];
$authority_registration_date = $com_default['authority_registration_date'];
$authority_registration_valid_upto = $com_default['authority_registration_valid_upto'];
$export_product_name =strtoupper($com_default['export_product_name']);


if ($type_of_firm == "13" || $type_of_firm == "12")
{
    $details_person_office = "Director";
	$person_office="7";
}
else if($type_of_firm == "11")
{
    $details_person_office = "Partner";
	$person_office="5";
}
else if ($type_of_firm == 14 || $type_of_firm == 15)
{
    $details_person_office = "Proprietor";
	$person_office="1";
}
else if($type_of_firm == "18")
{
    $details_person_office = "Individual";
	$person_office="8";
}
else if($type_of_firm == "17")
{
    $details_person_office = "Trustees";
	$person_office="9";
}
else if($type_of_firm == "16")
{
    $details_person_office = "Co-op Society Member";
	$person_office="10";
}
else if($type_of_firm == "19")
{
    $details_person_office = "Director";
	$person_office="7";
    //$details_person_office = "Director', 'Partner', 'Proprietor', 'Individual', 'Trustees', 'Co-op Society Member', 'Others'";
}

$person_count = 0;
$person_office_print = '<tr>
        <td height="25" align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">';
   
$person_office1 = $conn ->query("SELECT name, father_name, address1, address2, address3, country, state, city, pincode, landline_no1, mobile_no, fax_no1, fax_no2, email_id FROM communication_address_master  WHERE registration_id = '$registration_id'  and type_of_address='$person_office'");

while($person_office_result = $person_office1->fetch_assoc()) {

$pname = strtoupper($person_office_result['name']);
$pfather_name = strtoupper($person_office_result['father_name']);
$paddress1 = strtoupper($person_office_result['address1']);
if($paddress1!=""){$paddress1=$paddress1;}else{$paddress1="";}
$paddress2 = strtoupper($person_office_result['address2']);
if($paddress2!=""){$paddress2=",".$paddress2;}else{$paddress2="";}
$paddress3 = strtoupper($person_office_result['address3']);
if($paddress3!=""){$paddress3=",".$paddress3;}else{$paddress3="";}
$pcountry = strtoupper(getFullCountryeName($person_office_result['country'],$conn));
if($pcountry!=""){$pcountry=",".$pcountry;}else{$pcountry="";}
$pstate = strtoupper(getFullStateName($person_office_result['state'],$conn));
if($pstate!=""){$pstate=",".$pstate;}else{$pstate="";}
$pcity = strtoupper($person_office_result['city']);
if($pcity!=""){$pcity=",".$pcity;}else{$pcity="";}
$ppincode = strtoupper($person_office_result['pincode']);
if($ppincode!=""){$ppincode=",".$ppincode;}else{$ppincode="";}
$plandline_no1 = strtoupper($person_office_result['landline_no1']);
if($plandline_no1!=""){$plandline_no1=",".$plandline_no1;}else{$plandline_no1="";}
$pmobile_no = strtoupper($person_office_result['mobile_no']);
if($pmobile_no!=""){$pmobile_no=",".$pmobile_no;}else{$pmobile_no="";}
$pfax_no1 = strtoupper($person_office_result['fax_no1']);
if($pfax_no1!=""){$pfax_no1=",".$pfax_no1;}else{$pfax_no1="";}
$pfax_no2 = strtoupper($person_office_result['fax_no2']);
if($pfax_no2!=""){$pfax_no2=",".$pfax_no2;}else{$pfax_no2="";}
$pemail_id = strtoupper($person_office_result['email_id']);
if($pemail_id!=""){$pemail_id=",".$pemail_id;}else{$pemail_id="";}
$person_count++;

$person_office_print =  $person_office_print . "<tr>
            <td height='23' align='left' valign='top'>(a) Name : $pname</td>
          </tr>
          <tr>
            <td height='23' align='left' valign='top'>(b) Father's Name : $pfather_name</td>
          </tr>
          <tr>
            <td height='23' align='left' valign='top'>(c) Residential address : $paddress1 $paddress2 $paddress3 $pcity $pstate $pcountry $ppincode</td>
          </tr>
          <tr>
            <td height='23' align='left' valign='top'>(d)Tel No.: $plandline_no1</td>
          </tr>
          <tr>
            <td height='23' align='left' valign='top'>&nbsp;</td>
          </tr>";
                        //$person_count . ". " . "$address1, $address2, $address3, $city, $state, $country, $pincode <br>";
}

$person_office_print =  $person_office_print . '
       </table></td>
      </tr>';
if ($person_office_print == "")
{
    $person_office_print = "NA<br>";
}
$qregion_default = $conn ->query("SELECT region_name,region_full_name,region_address, region_bank, region_bank_acct_no, region_bank_address, region_bank_logo FROM region_master WHERE region_name='$region_id'");
$region_default = $qregion_default->fetch_assoc();

    $region_name = strtoupper($region_default['region_name']);
    $region_full_name = strtoupper($region_default['region_full_name']);
    $region_address = strtoupper($region_default['region_address']);
    $region_bank = strtoupper($region_default['region_bank']);
    $region_bank_acct_no = strtoupper($region_default['region_bank_acct_no']);
    $region_bank_address = strtoupper($region_default['region_bank_address']);
    $region_bank_logo = strtoupper($region_default['region_bank_logo']);

    if ($region_name == "HO-MUM (M)")
    {
        $edto = "The Executive Director";
    }
    else
    {
        $edto = "The Regional Director";
    }

$chl = $conn ->query("SELECT total_payable FROM challan_master where registration_id='$registration_id' and challan_financial_year='2022'");
$payment_result  =  $chl->fetch_assoc();
$payment_details = $payment_result['total_payable'];

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
// set some text to print
$txt = <<<EOD
<table width="637" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="25" align="center" valign="top"><strong>APPLICATION FORM FOR REGISTRATION CUM MEMBERSHIP CERTIFICATE (RCMC)</strong></td>
  </tr>
  <tr>
    <td height="10" align="center" valign="top"></td>
  </tr>
  
  <tr>
    <td height="25" valign="top">To,<br />
      $edto,<br />
      <strong>THE GEM & JEWELLERY EXPORT PROMOTION COUNCIL</strong><br />
      $region_address<br />
      </td>
  </tr>
  <tr>
    <td height="25" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" valign="top">Dear Sir,<br />
    <br />
    Kindly register us as  $member_type_id of the export product(s) mentioned below:</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="17" height="25" align="left" valign="top">1.</td>
        <td width="620" align="left" valign="top">Name of the applicant : <strong>$company_name</strong></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">2(i)</td>
        <td align="left" valign="top">Address of the applicant : <strong>$head_reg_office_print<br /></strong>(Registered Office in case of limited companies, and the head office for others)</td>
      </tr>
      <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" width="25" align="left" valign="top" >(ii)</td>
        <td align="left" valign="top">Name and address of the branches if any : <strong><br>$branch_office_print</strong></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top" >(iii)</td>
        <td align="left" valign="top">Name and address of the factory : <strong><br>$factory_office_print</strong></td>
      </tr>
	  
	  
	  <tr>
        <td height="25" align="left" valign="top">3(i)</td>
        <td width="320" height="25" valign="top">IEC No. : <strong>$iec_no</strong></td>
      </tr>
	  <tr>
	  	 <td height="25" align="left" valign="top">(ii)</td>
         <td width="320" valign="top">Date of Issue : <strong>$iec_issue_date</strong></td>
       </tr>
	   <tr>
	  	 <td height="25" align="left" valign="top">(iii)</td>
         <td height="25" valign="top">Issuing Authority : <strong>Directorate General of Foreign Trade</strong></td>
       </tr>
	   <tr>
	  	 <td height="25" align="left" valign="top">(iv)</td>
         <td height="25" valign="top">PAN NO.: <strong>$pan_no</strong></td>
       </tr>
	   
	   <tr>
	  	 <td height="25" align="left" valign="top">4.</td>
         <td height="25" valign="top">Payment details (for the year $cur_finyr) : <strong>$payment_details</strong></td>
       </tr>
	    
	   <tr>
        <td height="1" align="left" valign="top">5(a).</td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="350" align="left" valign="top">If the registration is required as a Manufacturer Exporter </td>
            <td width="270" align="left" valign="top">No&nbsp;&nbsp;<strong>$ssi_registration_no</strong></td>
          </tr>
        </table></td>
      </tr>
	  
	  <tr>
        <td height="1" align="left" valign="top"></td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="350" align="left" valign="top">&nbsp;</td>
            <td width="270" align="left" valign="top">Date&nbsp;&nbsp;<strong>$ssi_issue_date</strong></td>
          </tr>
        </table></td>
      </tr>
	  
	  <tr>
        <td height="1" align="left" valign="top"></td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="350" align="left" valign="top">(SSI Registration/ Industrial Licence/IEM )</td>
            <td width="270" align="left" valign="top">Issuing Authority: <strong>$im_registration_no</strong></td>
          </tr>
        </table></td>
      </tr>
	  
	  <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
	  
	  <tr>
        <td height="1" align="left" valign="top">(b)</td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="350" align="left" valign="top">Others (specify)</td>
            <td width="270" align="left" valign="top">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
	  
	  <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
	  
	  <tr>
        <td height="1" align="left" valign="top">(c)</td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
		  	<td width="350" align="left" valign="top">EH/TH/STH/SSTH/SHE/ISEH/ISSEH/ISSEH certificate number :<strong>$eh_th_certification_no</strong></td>
            <td width="270" align="left" valign="top">Valid upto : <strong>$eh_th_valid_date</strong></td>
          </tr>
        </table></td>
      </tr>
	
      <tr>
        <td height="10" align="left" valign="top">6.</td>
			<td width="450" align="left" valign="top">Details of Directors/Partners/Proprietor/Karta to be given in the following manner :</td>
        	<td width="150" align="left" valign="top"><strong>$details_person_office</strong></td>
      </tr>
      $person_office_print
	  
	  <tr>
        <td height="10" align="left" valign="top">7.</td>
			<td width="450" align="left" valign="top">If Status Holder : (category)certificate number: ____________________</td>
      </tr>
	  <tr>
        <td height="20" align="left" valign="top"></td>
		<td width="450" align="left" valign="top">Valid upto __________________</td>
		<td width="150" align="left" valign="top"></td>
      </tr>
	 
      <tr>
        <td height="1" align="left" valign="top">8(a)</td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="400" align="left" valign="top">Name of export product(s) or its category for which registration is required:</td>
           <td width="250" align="left" valign="top">$export_product_name</td>
          </tr>
        </table></td>
      </tr>
	  
	  <tr>
        <td height="1" align="left" valign="top">(b)</td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="400" align="left" valign="top">Main line of business of applicant :</td>
            <td width="250" align="left" valign="top"><strong>$panel_name</strong></td>
          </tr>
        </table></td>
      </tr>
	  
      <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
	  
	  <tr>
        <td height="25" align="left" valign="top">9.</td>
        <td align="left" valign="top" width="100%">I hereby solemnly declare that the above stated information is true and correct and I undertake to abide by the FT (D&R) Act, 1992 and the provisions under FTP</td>
      </tr>
	  
	  <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
	  
      <tr>
        <td height="25" align="left" valign="top">10.</td>
        <td align="left" valign="top">I/We hereby solemnly declare that the above stated information is true and correct. I/We undertake, without any reservation, to:</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20" height="23" align="left" valign="top">(a)</td>
            <td width="600" align="left" valign="top">abide by the terms of the registration certificate granted to us on all our exports;</td>
          </tr>
          <tr>
            <td height="23" align="left" valign="top">(b)</td>
            <td align="left" valign="top">agree to abide by any code of conduct that may be prescribed;</td>
          </tr>
		  <tr>
            <td height="23" align="left" valign="top">(c)</td>
            <td align="left" valign="top">agree to abide by export floor price condition that may be stipulated by the Registering Authority;</td>
          </tr>
          <tr>
            <td height="23" align="left" valign="top">(d)</td>
            <td align="left" valign="top">Furnish without fail monthly returns of exports including NIL returns to the Registering authority by 15th day of the months following the quarter.</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">11.</td>
        <td align="left" valign="top">We further understand that our registration is liable to be cancelled in the event of breach of any of the undertakings mentioned above.</td>
      </tr>
      <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
	  <tr>
        <td height="25" align="left" valign="top">12.</td>
        <td align="left" valign="top">I solemnly declare that I have applied to the Export Promotion Council which pertains to our main line of business. In case I have applied to any other council, the application has been made within the purview of the provisions of Para 2.94 of the Handbook of Procedures.</td>
      </tr>
    </table></td>
  </tr>
	
  <tr>
    <td height="25" align="right" valign="top">Yours faithfully<br />
    <br />
    <strong>(Signature)</strong></td>
  </tr>
  <tr>
    <td height="25" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" valign="top"><table width="637" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="237" valign="top">&nbsp;</td>
        <td width="140" height="24" valign="top">Name</td>
        <td width="10" valign="top">:</td>
        <td width="250" valign="top"><strong>$contact_name</strong></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td height="24" valign="top">Designation</td>
        <td valign="top">:</td>
        <td valign="top"><strong>$designation</strong></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td height="24" valign="top">Address</td>
        <td valign="top">:</td>
        <td valign="top"><strong>$address1 $address2 $address3 $city $country $pin_code</strong></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td height="24" valign="top">Tel. No.</td>
        <td valign="top">:</td>
        <td valign="top"><strong>$land_line_no</strong></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td height="24" valign="top">Mobile No.</td>
        <td valign="top">:</td>
        <td valign="top"><strong>$info_mobile_no</strong></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td height="24" valign="top">E-mail</td>
        <td valign="top">:</td>
        <td valign="top"><strong>$info_email_id</strong></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td height="24" valign="top">Place</td>
        <td valign="top">:</td>
        <td valign="top"><strong>$region_full_name</strong></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td height="24" valign="top">Date</td>
        <td valign="top">:</td>
        <td valign="top"><strong>$date</strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="10" align="center" valign="top"></td>
  </tr>
  <tr>
    <td height="25" valign="top">Documents to be enclosed with the application form::<br>
	1.	A self certified copy of the IEC issued by the licensing authority concerned.<br>
	2.	A self certified copy of the partnership deed or copy of Memorandum and Articles of Association (As the case may be)<br>
	3.  A self certified copy of Small Scale Industry (SSI) registration / Industrial Enterpreneur Memorandum (IEM) issued by the Director of Industries for Manufacturer Exporter.
</td>
  </tr>
</table>

EOD;
// print a block of text using Write()

$pdf->writeHTML($txt, true, false, true, false, '');
// ---------------------------------------------------------
ob_clean();
//Close and output PDF document
$pdf->Output('Information.pdf', 'I');

