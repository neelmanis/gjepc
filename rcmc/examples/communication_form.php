<?php 
//============================================================+
// File name   : Communication Form
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
    		$this->Cell(0, 10, 'Signature Form - Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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
    $register_office = "6";
	$head_register_office="REGISTERED OFFICE";
}
else
{
    $register_office = "2";
	$head_register_office="HEAD OFFICE";
}


 $head_reg= mysql_query("SELECT name, father_name, address1, address2, address3, country, state, city, pincode, landline_no1, mobile_no, fax_no1, fax_no2, email_id FROM communication_address_master  WHERE registration_id = '$registration_id'  and type_of_address='$register_office' limit 0,1");
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

 // current challan yr calculation
    $cur_year = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $cur_year-1;
	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
    else {
     $cur_fin_yr = $cur_year;
 	 $cur_finyr  = $cur_fin_yr . '-' . ($cur_fin_yr+1);
	 $last_finyr = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
    }
	
  // dynamic fee structure table
  $fee_data_query = mysql_query("SELECT * FROM export_amount_master WHERE financial_year='$cur_fin_yr' order by id");
  while ($fee_data_array = mysql_fetch_array($fee_data_query)) {
   $fee_data[] = $fee_data_array;
  }

foreach ($fee_data as $k => $v) {

    $export_performance_desc         = $v['export_performance_desc'];
    $membership_fee                  = $v['membership_fee'];
    $service_tax_on_membership_fee   = $v['service_tax_on_membership_fee'];
    $membership_fee_incl_service_tax = $v['membership_fee_incl_service_tax'];
    $admission_fee                   = $v['admission_fee'];
    $service_tax_on_admission_fee    = $v['service_tax_on_admission_fee'];
    $admission_fee_incl_service_tax  = $v['admission_fee_incl_service_tax'];

   if ($export_performance_desc) { // export_performance_desc
    $dynac_fee_label = '<tr>
                     <td width="297" height="50"><strong>Export Performance of Gem &amp; Jewellery<br />
                during the year ' . $last_finyr . '</strong></td>
                     <td align="center" width="160"><strong>Membership fee<br />for ' . $cur_finyr . '</strong></td>	     
                     <td align="center" width="80"><strong>Service Tax<br />
                @12.36%</strong></td>
                     <td align="center" width="80"><strong>Total Fees<br />
                Payable</strong></td>
                    </tr>';

    $dynac_fee_content .= '<tr>
                      <td height="25">' . $export_performance_desc . '</td>
                      <td align="center">' . $membership_fee . '/-</td>
                      <td align="center">' . $service_tax_on_membership_fee . '/-</td>
                      <td align="center">' . $membership_fee_incl_service_tax . '/-</td>
                     </tr>';
   }
   elseif ($import_performance_desc) { // import_performance_desc
    $dynac_fee_label = '<tr>
                     <td width="297" height="50"><strong>Import Performance of Gem &amp; Jewellery<br />
                during the year ' . $last_finyr . '</strong></td>
                     <td align="center" width="160"><strong>Membership fee<br />for ' . $cur_finyr . '</strong></td>	     
                    <td align="center" width="80"><strong>Service Tax<br />
                @12.36%</strong></td>
                     <td align="center" width="80"><strong>Total Fees<br />
                Payable</strong></td>
                    </tr>';

    $dynac_fee_content .= '<tr>
                      <td align="center">' . $membership_fee . '/-</td>
                      <td align="center">' . $service_tax_on_membership_fee . '/-</td>
                      <td align="center">' . $membership_fee_incl_service_tax . '/-</td>
                     </tr>';
   }
 } 

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

    if ($region_value = "HO-MUM (M)")
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

$finfo_data =mysql_fetch_array(mysql_query("select * from  payment_master where registration_id = '$registration_id' AND challan_financial_year ='$cur_fin_yr'"));

		$payment_mode = $finfo_data['payment_mode'];
		$membership_fees = $finfo_data['membership_fees'];
		$admission_fees = $finfo_data['admission_fees'];
		$bank_name = $finfo_data['bank_name'];
		$branch_name = $finfo_data['branch_name'];
		$branch_city = $finfo_data['branch_city'];
		$branch_postal_code = $finfo_data['branch_postal_code'];
		$cheque_no = $finfo_data['cheque_no'];
		$cheque_date = $finfo_data['cheque_date'];
		$challan_financial_year = $finfo_data['challan_financial_year'];
		$total_payable = $finfo_data['total_payable'];
		$declaration = $finfo_data['declaration'];
		
if ($panel_name == "Coloured Gemstones")
    {
       $panel_coloured_gemstones = '<img src="'.K_PATH_IMAGES.'/true.gif" width="12" height="12" vspace="3" />';
    }
    else
    {
       $panel_coloured_gemstones = '-';
    }



    if ($panel_name == "Costume/Fashion Jewellery")
    {
       $panel_costume_fashion_jewellerys = '<img src="'.K_PATH_IMAGES.'/true.gif" width="12" height="12" vspace="3" />';
    }
    else
    {
       $panel_costume_fashion_jewellerys = '-';
    }



    if ($panel_name == "Diamonds")
    {
       $panel_diamonds = '<img src="'.K_PATH_IMAGES.'/true.gif" width="12" height="12" vspace="3" />';
    }
    else
    {
       $panel_diamonds = '-';
    }



    if ($panel_name == "Gold Jewellery")
    {
       $panel_gold_jewellery = '<img src="'.K_PATH_IMAGES.'/true.gif" width="12" height="12" vspace="3" />';
    }
    else
    {
       $panel_gold_jewellery = '-';
    }
    if ($panel_name == "Other Precious Metal Jewellery")
    {
       $panel_other_precious_metal_jewellery = '<img src="'.K_PATH_IMAGES.'/true.gif" width="12" height="12" vspace="3" />';
    }
    else
    {
       $panel_other_precious_metal_jewellery = '-';
    }
    if ($panel_name == "Pearls")
    {
       $panel_pearls = '<img src="'.K_PATH_IMAGES.'/true.gif" width="12" height="12" vspace="3" />';
    }
    else
    {
       $panel_pearls = '-';
    }



    if ($panel_name == "Sales to Foreign Tourists")
    {
       $panel_sales_to_foreign_tourists = '<img src="'.K_PATH_IMAGES.'/true.gif" width="12" height="12" vspace="3" />';
    }
    else
    {
       $panel_sales_to_foreign_tourists = '-';
    }




    if ($panel_name == "Synthetic Stones")
    {
       $panel_synthetic_stones = '<img src="'.K_PATH_IMAGES.'/true.gif" width="12" height="12" vspace="3" />';
    }
    else
    {
       $panel_synthetic_stones = '-';
    }
    if ($panel_name == "Not Indicated")
    {
       $panel_not_indicated = '<img src="'.K_PATH_IMAGES.'/true.gif" width="12" height="12" vspace="3" />';
    }
    else
    {
       $panel_not_indicated = '-';
    }


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
$person_office_print = '';

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

$person_office_print =  $person_office_print . $person_count.'. '.$pname.', '. $paddress1.', '.$paddress2.', '. $paddress3.', '.$pcity.', '.$pstate.', '.$pcountry.', '.$ppincode.'<br/><br/>';
//$person_count . ". " . "$address1, $address2, $address3, $city, $state, $country, $pincode <br>";
}
$person_office_print =  $person_office_print . '<br>';
if ($person_office_print == "")
{
    $person_office_print = "NA<br>";
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mukesh Singh');
$pdf->SetTitle('Communication Form');
$pdf->SetSubject('Communication Form');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------
// add a page
$pdf->AddPage();
$pdf->SetFont('helvetica', 'B', 14);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('helvetica', '', 9);
// set some text to print
$txt = <<<EOD
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="25" align="center" valign="top"><strong>THE GEM &amp; JEWELLERY EXPORT PROMOTION COUNCIL<br />
  MUMBAI<br />
    ASSOCIATE MEMBERSHIP APPLICATON FORM</strong></td>
  </tr>
  <tr>
    <td height="25" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" valign="top">To,<br />
       $edto,<br />
      <strong>THE GEM & JEWELLERY EXPORT PROMOTION COUNCIL</strong><br />
      $region_address<br /></td>
  </tr>
  
  <tr>
    <td height="15" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" valign="top">Dear Sir,<br />
    <br />
    I/We desire to enrol myself/yourself as an Associate Member of <strong>THE GEMS & JEWELLERY EXPORT PROMOTION COUNCIL</strong> and am/are sending herewith the annual membership fee of <strong>Rs. $membership_fees/-</strong> for financial year <strong>$cur_finyr</strong> and <strong>Rs. $admission_fees/-</strong> as admission fee.<br />
    <br />
    I/We agree to abide by the Memorandum and Articles of Association of the Council and such other rules and regulation as may be in force fo the time being.</td>
  </tr>
  <tr>
    <td height="10" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" valign="top"><table width="637" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="437">Date : $date</td>
        <td width="200" align="right">Signature</td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td height="10" valign="top">&nbsp;</td>
  </tr>
  
  <tr>
    <td style="border-top:1px dashed #cccccc;" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" valign="top"><strong>PARTICULARS TO BE FILLED IN BY THE APPLICANT (IN BLOCK LETTERS)</strong></td>
  </tr>
  
  <tr>
    <td height="25" valign="top"><table width="637" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20" height="30" valign="top">1.</td>
        <td width="620" valign="top">Name under which membership is sought:</td>
      </tr>
      <tr>
        <td height="30" valign="top">&nbsp;</td>
        <td valign="top">( Name of the Firm ) <strong>$company_name</strong></td>
      </tr>
      <tr>
        <td height="30" valign="top">&nbsp;</td>
        <td valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20" height="30" align="center">&raquo;</td>
            <td width="600">Address of the $head_register_office with Tel./Fax. Nos &amp; E-mail id</td>
          </tr>
          <tr>
            <td height="30" align="center">&nbsp;</td>
            <td><strong>$head_reg_office_print<br /></strong></td>
          </tr>
          <tr>
            <td height="30" align="center">&nbsp;</td>
            <td><table width="600" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="30">Tel.</td>
                <td width="75"><strong>$hlandline_no1</strong></td>
                <td width="60">Mobile No.</td>
                <td width="75"><strong>$hmobile_no</strong></td>
                <td width="75">Email Id</td>
                <td width="285"><strong>$hemail_id</strong></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="22" valign="top">&nbsp;</td>
        <td height="22" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="30" valign="top">2.</td>
        <td valign="top">Whether a Properietary / Partnership / Private or Public Limited Co.: <strong>$type_of_firm</strong></td>
      </tr>
    <tr>
        <td style="border-top:1px dashed #cccccc;" valign="top">&nbsp;</td>
        <td style="border-top:1px dashed #cccccc;" valign="top">&nbsp;</td>
    </tr>
    <tr>
        <td height="30" valign="top">3.</td>
        <td valign="top">Name and Residential Address of the Properietor / Partners / Directors of the Company :</td>
    </tr>
      <tr>
        <td height="30" valign="top">&nbsp;</td>
        <td valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20" height="22" align="left" valign="top"></td>
            <td width="600" valign="middle"><strong>$person_office_print</strong></td>
          </tr>
          
        </table></td>
      </tr>
     <tr>
        <td style="border-top:1px dashed #cccccc;" valign="top">&nbsp;</td>
        <td style="border-top:1px dashed #cccccc;" valign="top">&nbsp;</td>
    </tr>
      <tr>
        <td height="30" valign="top">4.</td>
        <td valign="top">Importer Exporter Code No. <strong>$iec_no</strong> &amp; Date : <strong>$iec_issue_date<br />
        </strong>(self certified true copy to be enclosed)</td>
      </tr>
       <tr>
        <td height="22" valign="top">&nbsp;</td>
        <td height="22" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td style="border-top:1px dashed #cccccc;" valign="top">&nbsp;</td>
        <td style="border-top:1px dashed #cccccc;" valign="top">&nbsp;</td>
    </tr>
      <tr>
        <td height="30" valign="top">5.</td>
        <td valign="top">Year of starting business : <strong>$year_of_starting_bussiness</strong></td>
      </tr>
      <tr>
        <td style="border-top:1px dashed #cccccc;" valign="top">&nbsp;</td>
        <td style="border-top:1px dashed #cccccc;" valign="top">&nbsp;</td>
    </tr>
	
	<tr>
	<td height="80" valign="top"></td>
	</tr>
	
      <tr>
        <td height="30" valign="top">6.</td>
        <td valign="top">Indicate one item of export form the following under which you wish to enroll yourself as a member</td>
      </tr>
      <tr>
        <td height="30" valign="top">&nbsp;</td>
        <td valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20" height="30" align="left" valign="top">1.</td>
            <td width="500" align="left" valign="top">Coloured Gemstones</td>
            <td width="100" align="center" valign="top">$panel_coloured_gemstones</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="top">2.</td>
            <td align="left" valign="top">Costume/Fashion Jewellery</td>
            <td align="center" valign="top">$panel_costume_fashion_jewellerys</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="top">3.</td>
            <td align="left" valign="top">Diamonds</td>
            <td align="center" valign="top">$panel_diamonds</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="top">4.</td>
            <td align="left" valign="top">Gold Jewellery</td>
            <td align="center" valign="top">$panel_gold_jewellery</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="top">5.</td>
            <td align="left" valign="top">Other Precious Metal Jewellery</td>
            <td align="center" valign="top">$panel_other_precious_metal_jewellery</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="top">6.</td>
            <td align="left" valign="top">Pearls</td>
            <td align="center" valign="top">$panel_pearls</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="top">7.</td>
            <td align="left" valign="top">Sales to Foreign Tourists</td>
            <td align="center" valign="top">$panel_sales_to_foreign_tourists</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="top">8.</td>
            <td align="left" valign="top">Synthetic Stones</td>
            <td align="center" valign="top">$panel_synthetic_stones</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="top">9.</td>
            <td align="left" valign="top">Not Indicated</td>
            <td align="center" valign="top">$panel_not_indicated</td>
          </tr>

        </table></td>
      </tr>
      <tr>
        <td height="22" valign="top">&nbsp;</td>
        <td height="22" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="45" valign="top">7.</td>
        <td valign="top">Name of any other authority (i.e., other Export Promotion Council, FIEO etc.) with whom the firm register, with details of :</td>
      </tr>
      <tr>
        <td height="30" valign="top">&nbsp;</td>
        <td valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="120" height="27">Registration No.</td>
            <td width="250">&nbsp;</td>
            <td width="100">Date</td>
            <td width="150">&nbsp;</td>
          </tr>
          <tr>
            <td height="27">Validity etc.</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td align="center" valign="top"><strong>DECLARATION</strong></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="30" valign="top">8.</td>
        <td valign="top">I/We hereby solemnly affirm and declare that our exports of Gem and Jewellery items including raw materials of gems &amp; jewellery during the year <strong>$prev_finyr</strong> (Please state the figure of exports for the immediate preceding financial year (April - March), amounted to Rs. <strong>$challan_fob_of_export_values</strong> (fob). Details as per Proforma given at the bottom in case of export of gold jewellery.</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td height="30" valign="top">&nbsp;</td>
        <td valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="120" height="30" align="left" valign="top">Signature :</td>
            <td width="500" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td height="30" align="left" valign="top">Name :</td>
            <td valign="top"><strong>$contact_name</strong></td>
          </tr>
          <tr>
            <td height="30" align="left" valign="top">Designation :</td>
            <td valign="top"><strong>$designation</strong></td>
          </tr>
          <tr>
            <td height="30" align="left" valign="top">Address :</td>
            <td valign="top"><strong>$address1 $address2 $address3 $city $country $pin_code</strong></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td align="center" valign="top"><strong>PROPOSER</strong></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
      </tr>
      
      <tr>
        <td height="30" valign="top">9(i)</td>
        <td valign="top">Signature of Proposer<br />
          <br />
          (Name of Prop./Partner/Director Registere as Authorised Representative)<br />
          <br />
          Name of the Proposer Firm : $communication_proposer_name ($communication_proposer_code)<br /></td>
      </tr>
      <tr>
        <td height="30" valign="top">&nbsp;</td>
        <td valign="middle"><table width="620" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="320" valign="middle">Regn. No.</td>
            <td width="300" valign="middle">Membership No.</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" valign="top" style="border:1px solid #cccccc;"><table width="637" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="10">&nbsp;</td>
        <td width="617">&nbsp;</td>
        <td width="10">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Membership fee subscription payable is shown below:</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><table width="617" border="0" cellspacing="0" cellpadding="0">
          $dynac_fee_label<!--dynamic table label-->
		  $dynac_fee_content<!--dynamic table content-->  	  
        </table></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="15" valign="top"><strong>Admission fee payable in case of New Member/Late Renewal Rs. $admission_fee + Service Tax </strong></td>
  </tr>
  <tr>
    <td height="10" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" valign="top"><table width="637" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="40" valign="top"><strong>Note:</strong></td>
        <td width="30" height="35" valign="top"><strong>1.</strong></td>
        <td width="567" valign="top" style="text-align:justify;"><strong>Annual membership fee is payable on the basis of export of gems &amp; jewellery including exports of Gems &amp; Jewellery raw materials effected during the proceding financial year.</strong></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td height="35" valign="top"><strong>2.</strong></td>
        <td valign="top"><strong>Rs. 5000/- will be deducted as processing charges in the event of request of refund of membership. Service tax amount will not be refunded.</strong></td>
      </tr>
	  <tr>
        <td valign="top">&nbsp;</td>
        <td height="35" valign="top"><strong>3.</strong></td>
        <td valign="top"><strong>Make sure to submit a copy of the duly acknowledged Challan (after making the payment in the Bank) along with Application form duly stamped &amp; signed, by Proprietor/Partner/Director as the case may be.</strong></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td height="25" valign="top"><strong>4.</strong></td>
        <td valign="top"><strong>Documents to be enclosed with the application form (For new Members):</strong></td>
      </tr>
      <tr>
        <td valign="top">&nbsp;</td>
        <td valign="top">&nbsp;</td>
        <td valign="top"><table width="567" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="17" height="22" valign="top"><strong>a.</strong></td>
              <td width="550" valign="top"><strong>A self certified true copy of the IEC Number issued by the licensing authority concerned.</strong></td>
            </tr>
            <tr>
              <td height="22" valign="top"><strong>b.</strong></td>
              <td valign="top"><strong>E-mail ID mandatory.</strong></td>
            </tr>
            <tr>
              <td height="22" valign="top"><strong>c.</strong></td>
              <td valign="top"><strong> Signature slip duly filled on and signed and attested by your bank.</strong></td>
            </tr>
            <tr>
              <td height="22" valign="top"><strong>d.</strong></td>
              <td valign="top"><strong>Against column no 9. Proposer Signature(Existing Member) is mandatory.</strong></td>
            </tr>
			<tr>
              <td height="35" valign="top"><strong>e.</strong></td>
              <td valign="top"><strong>A self certified copy of Partnership Deed/Memorandum & Articles of Association of the applicant firm (as applicable).</strong></td>
            </tr>
			<tr>
              <td height="50" valign="top"><strong>f.</strong></td>
              <td valign="top"><strong>A self certified copy of each of Partnership dissolution deed and New Partnership deed in case of change in constitution of   Partnership Firm or self certified copy of relevant Resolution of Board effecting change in Constitution of Ltd. Companies.</strong></td>
            </tr>
			<tr>
              <td height="35" valign="top"><strong>g.</strong></td>
              <td valign="top"><strong>A self certified copy of SSI/DIC Registration Certificate/SIA Letter issued for export products for which Registration is sought as "Manufacturer Exporter". This is applicable for  Manufacturer Exporters only.</strong></td>
            </tr>
            <tr>
              <td height="22" valign="top"><strong>h.</strong></td>
              <td valign="top"><strong>Submit all documents along with a covering letter on your letter head to Council&#039;s office.</strong></td>
            </tr>            
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="25" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" valign="top">&nbsp;</td>
  </tr>
</table>
EOD;

// print a block of text using Write()
$pdf->writeHTML($txt, true, false, true, false, '');
$pdf->Output('communication_form.pdf', 'I');
