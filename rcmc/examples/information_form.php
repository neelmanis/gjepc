<?php
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
require_once('db.inc.php');
$registration_id=$_SESSION['USERID'];
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
    		$this->Cell(0, 10, 'Information Form - Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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
$year_of_starting_bussiness = strtoupper($default['year_of_starting_bussiness']);
$contact_name = strtoupper($default['name']);
$designation = strtoupper($default['designation']);
$info_email_id = strtoupper($default['email_id']);
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
$haddress2 = strtoupper($head_reg_office['address2']);
$haddress3 = strtoupper($head_reg_office['address3']);
$hcountry = strtoupper($head_reg_office['country']);
$hstate = strtoupper($head_reg_office['state']);
$hcity = strtoupper($head_reg_office['city']);
$hpincode = strtoupper($head_reg_office['pincode']);
$hlandline_no1 = strtoupper($head_reg_office['landline_no1']);
$hmobile_no = strtoupper($head_reg_office['mobile_no']);
$hfax_no1 = strtoupper($head_reg_office['fax_no1']);
$hfax_no2 = strtoupper($head_reg_office['fax_no2']);
$hemail_id = strtoupper($head_reg_office['email_id']);

$head_reg_office_print = "$haddress1, $haddress2, $haddress3, $hcity, $hstate, $hcountry, $hpincode";

//Branch Office
$branch_office_print = "";
$branch_count = 0;


$branch_office = mysql_query("SELECT name, father_name, address1, address2, address3, country, state, city, pincode, landline_no1, mobile_no, fax_no1, fax_no2, email_id FROM communication_address_master  WHERE registration_id = '$registration_id'  and type_of_address='3'");

while($branch_office_result = mysql_fetch_array($branch_office)) {

$bname = strtoupper($branch_office_result['name']);
$bfather_name = strtoupper($branch_office_result['father_name']);
$baddress1 = strtoupper($branch_office_result['address1']);
$baddress2 = strtoupper($branch_office_result['address2']);
$baddress3 = strtoupper($branch_office_result['address3']);
$bcountry = strtoupper($branch_office_result['country']);
$bstate = strtoupper($branch_office_result['state']);
$bcity = strtoupper($branch_office_result['city']);
$bpincode = strtoupper($branch_office_result['pincode']);
$blandline_no1 = strtoupper($branch_office_result['landline_no1']);
$bmobile_no = strtoupper($branch_office_result['mobile_no']);
$bfax_no1 = strtoupper($branch_office_result['fax_no1']);
$bfax_no2 = strtoupper($branch_office_result['fax_no2']);
$bemail_id = strtoupper($branch_office_result['email_id']);
$branch_count++;

$branch_office_print =  $branch_office_print . $branch_count . ". " . "$baddress1, $baddress2, $baddress3, $bcity, $bstate, $bcountry, $bpincode <br>";

}
//Factory Address
$factory_office_print = "";
$factory_count = 0;
$factory_office = mysql_query("SELECT name, father_name, address1, address2, address3, country, state, city, pincode, landline_no1, mobile_no, fax_no1, fax_no2, email_id FROM communication_address_master  WHERE registration_id = '$registration_id'  and type_of_address='4'");

while($factory_office_result = mysql_fetch_array($factory_office)) {
$fname = strtoupper($factory_office_result['name']);
$ffather_name = strtoupper($factory_office_result['father_name']);
$faddress1 = strtoupper($factory_office_result['address1']);
$faddress2 = strtoupper($factory_office_result['address2']);
$faddress3 = strtoupper($factory_office_result['address3']);
$fcountry = strtoupper($factory_office_result['country']);
$fstate = strtoupper($factory_office_result['state']);
$fcity = strtoupper($factory_office_result['city']);
$fpincode = strtoupper($factory_office_result['pincode']);
$flandline_no1 = strtoupper($factory_office_result['landline_no1']);
$fmobile_no = strtoupper($factory_office_result['mobile_no']);
$ffax_no1 = strtoupper($factory_office_result['fax_no1']);
$ffax_no2 = strtoupper($factory_office_result['fax_no2']);
$femail_id = strtoupper($factory_office_result['email_id']);
$factory_count++;

$factory_office_print =  $factory_office_print . $factory_count . ". " . "$faddress1, $faddress2, $faddress3, $fcity, $fstate, $fcountry, $fpincode <br>";

}

if ($factory_office_print == "")
{
    $factory_office_print = "NA<br>";
}


$qcom_default = mysql_query("SELECT * FROM communication_details_master WHERE registration_id = '$registration_id'");
$com_default=mysql_fetch_array($qcom_default);
$panel_name = $com_default['panel_name'];
$refer_membership_id = $com_default['refer_membership_id'];
$refer_firm_name = $com_default['refer_firm_name'];
$authority_firm_name = $com_default['authority_firm_name'];
$authority_firm_registration_no = $com_default['authority_firm_registration_no'];
$authority_registration_date = $com_default['authority_registration_date'];
$authority_registration_valid_upto = $com_default['authority_registration_valid_upto'];
$export_product_name =$com_default['export_product_name'];


if ($type_of_firm == "Private Ltd" || $type_of_firm == "Public Ltd")
{
    $details_person_office = "7";
}
else if($type_of_firm == "Partnership")
{
    $details_person_office = "5";
}
else if ($type_of_firm == "Proprietory" || $type_of_firm == "Proprietory HUF")
{
    $details_person_office = "1";
}
else if($type_of_firm == "Indiviudal")
{
    $details_person_office = "8";
}
else if($type_of_firm == "Trustees")
{
    $details_person_office = "9";
}
else if($type_of_firm == "Co-Op Society")
{
    $details_person_office = "10";
}
else if($type_of_firm == "Others")
{
    $details_person_office = "7";
    //$details_person_office = "Director', 'Partner', 'Proprietor', 'Individual', 'Trustees', 'Co-op Society Member', 'Others'";
}

$person_count = 0;
$person_office_print = '<tr>
        <td height="25" align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">';
   
$person_office = mysql_query("SELECT name, father_name, address1, address2, address3, country, state, city, pincode, landline_no1, mobile_no, fax_no1, fax_no2, email_id FROM communication_address_master  WHERE registration_id = '$registration_id'  and type_of_address='$details_person_office'");

    

while($person_office_result = mysql_fetch_array($person_office)) {

$pname = strtoupper($person_office_result['name']);
$pfather_name = strtoupper($person_office_result['father_name']);
$paddress1 = strtoupper($person_office_result['address1']);
$paddress2 = strtoupper($person_office_result['address2']);
$paddress3 = strtoupper($person_office_result['address3']);
$pcountry = strtoupper($person_office_result['country']);
$pstate = strtoupper($person_office_result['state']);
$pcity = strtoupper($person_office_result['city']);
$ppincode = strtoupper($person_office_result['pincode']);
$plandline_no1 = strtoupper($person_office_result['landline_no1']);
$pmobile_no = strtoupper($person_office_result['mobile_no']);
$pfax_no1 = strtoupper($person_office_result['fax_no1']);
$pfax_no2 = strtoupper($person_office_result['fax_no2']);
$pemail_id = strtoupper($person_office_result['email_id']);
$person_count++;

$person_office_print =  $person_office_print . "<tr>
            <td height='23' align='left' valign='top'>(a) Name: $pname</td>
          </tr>
          <tr>
            <td height='23' align='left' valign='top'>(b) Father's Name: $pfather_name</td>
          </tr>
          <tr>
            <td height='23' align='left' valign='top'>(c) Residential address : $paddress1, $paddress2, $paddress3, $pcity, $pstate, $pcountry, $ppincode</td>
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
     <tr>
            <td height="23" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
       </table></td>
      </tr>';
if ($person_office_print == "")
{
    $person_office_print = "NA<br>";
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

    if ($region_value = "HO-MUM (M)")
    {
        $edto = "The Executive Director";
    }
    else
    {
        $edto = "The Regional Director";
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
// set some text to print
$txt = <<<EOD
<table width="637" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="25" align="center" valign="top"><strong>FORM OF APPLICATON FOR REGISTRATION CUM MEMBERSHIP WITH <br />
    EXPORT PROMOTION COUNCIL</strong></td>
  </tr>
  <tr>
    <td height="10" align="center" valign="top"></td>
  </tr>
  <tr>
    <td height="25" align="center" valign="top"><strong>FOR OFFICE USE ONLY</strong></td>
  </tr>
  
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="500">File No.</td>
        <td width="137">Date: </td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td height="10" align="center" valign="top"></td>
  </tr>
   <tr>
    <td height="11" align="center" valign="top" style="border-top:1px solid #cccccc;"></td>
  </tr>
<tr></tr>
<tr>
  <td height="25" align="center" valign="top"><strong>FOR APPLICANT</strong></td>
</tr>
  <tr>
    <td height="25" valign="top">To,<br />
      $edto,<br />
      <strong>THE GEMS & JEWELLERY EXPORT PROMOTION COUNCIL</strong><br />
      $region_address<br />
      </td>
  </tr>
  <tr>
    <td height="25" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" valign="top">Dear Sir/Madam,<br />
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
        <td width="620" align="left" valign="top">Name of the applicant firm : <strong>$company_name</strong></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">2.</td>
        <td align="left" valign="top">Address of the applicant : <strong>$head_reg_office_print<br /></strong>(Registered Office in case of limited companies, and the head office for others)</td>
      </tr>
      <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">3. </td>
        <td align="left" valign="top">Name and address of the branches if any : <strong><br>$branch_office_print</strong></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">4. </td>
        <td align="left" valign="top">Name and address of the factory : <strong><br>$factory_office_print</strong></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">5.</td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="320" height="25" valign="top">IEC No. : <strong>$iec_no</strong></td>
            <td width="300" valign="top">Date of Issue : <strong>$iec_issue_date</strong></td>
          </tr>
          <tr>
            <td height="25" valign="top">Issuing Authority : <strong>Directorate General of Foreign Trade</strong></td>
            <td valign="top"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">6.</td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="320" height="25" valign="top">(A) PAN NO.: <strong>$pan_no</strong></td>
            <td width="300" valign="top">Date of Issue :</td>
          </tr>
          
        </table></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">7. </td>
        <td align="left" valign="top">If the registration is required as a Manufacturer Exporter give No. <strong>$ssi_registration_no</strong> &amp; Date of SSI Registration <strong>$ssi_issue_date</strong> / issuing Industrial Licence / IEM Authority : <strong>$im_registration_no</strong> Others (specity)</td>
      </tr>
      <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">8.</td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="320" height="25" valign="top">EH/TH/STH/SSTH Certificate No. : <strong>$eh_th_certification_no</strong> </td>
            <td width="300" valign="top">Date of Issue : <strong>$eh_th_issue_date</strong></td>
          </tr>
          <tr>
            <td height="25" valign="top">Valid upto : <strong>$eh_th_valid_date</strong></td>
            <td valign="top">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">9.</td>
        <td align="left" valign="top">Details of Directors/Partners/Proprietor/Karta to be given in the following manner : <b>$details_person_office</b> </td>
      </tr>
      $person_office_print
      <tr>
        <td height="25" align="left" valign="top">10.</td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="350" align="left" valign="top">Name of export product(s) for which registration is required:</td>
            <td width="270" align="left" valign="top">$export_product_name</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">11.</td>
        <td align="left" valign="top">I/We hereby solemnly declare that the above stated information is true and correct. I/We undertake, without any reservation, to</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">&nbsp;</td>
        <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20" height="23" align="left" valign="top">(a)</td>
            <td width="600" align="left" valign="top">abide by the terms of the registration certificate granted to us on all our exports.</td>
          </tr>
          <tr>
            <td height="23" align="left" valign="top">(b)</td>
            <td align="left" valign="top">agree to abide by any code of condust that may be prescribed</td>
          </tr>
          <tr>
            <td height="23" align="left" valign="top">(c)</td>
            <td align="left" valign="top">furnish without fail quarterly returns of exports including nil returns to the Registering authority by 15th day of the months following the quarters.</td>
          </tr>
          
          
        </table></td>
      </tr>
      <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">12.</td>
        <td align="left" valign="top">we further understand that our registration is liable to be cancelled in the event of breach of any of the undertakings mentioned above.</td>
      </tr>
      <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25" align="right" valign="top">Yours faithfully<br />
    <br />
    Signature</td>
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
    <td height="11" align="center" valign="top" style="border-top:1px solid #cccccc;"></td>
  </tr>
  <tr>
    <td height="25" valign="top">Documents to be enclosed with the application form:<br>
1.  A self certified copy of the IEC Number issued by the licensing authority concerned.</td>
  </tr>
</table>
EOD;
// print a block of text using Write()

$pdf->writeHTML($txt, true, false, true, false, '');
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Information.pdf', 'I');

