<?php
//============================================================+
// File name   : challan_form.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 003 for TCPDF class
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
            $this->SetY(15);
            $this->SetX(10);
            $this->SetFont('helvetica', 'B', 11);
    		$this->Cell(0, 10, 'THE GEM & JEWELLERY EXPORT PROMOTION COUNCIL', 0, false, 'C', 0, '', 0, false, 'T', 'M');
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

// get G Code/ erp code
/**
$erpcode = db_result(db_query("SELECT erp_code FROM {temp_iec_member} WHERE uid=%d", $uid));
if ($erpcode) {
 $erp_code = ' / ' . $erpcode;
}
**/
$q_membership=mysql_query("SELECT refer_membership_id FROM communication_details_master where registration_id='$registration_id'");$r_membership=mysql_fetch_array($q_membership); 
$mem_id=$r_membership['refer_membership_id'];
// get membership code for user
if ($mem_id) {
 $mem_id_explode = explode('/', $mem_id); // explode membership id
 $erp_code = ' / ' . $mem_id_explode[2]; // get erp code (G Code)
} // end of if ($mem_id).

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


$import_cut_polished_diamonds=$info_data['import_cut_polished_diamonds'];
$import_findings_mountings = $info_data['import_findings_mountings'];
$import_false_pearls = $info_data['import_false_pearls'];
$import_rough_imitation_stones = $info_data['import_rough_imitation_stones'];
$import_silver = $info_data['import_silver'];
$import_raw_pearls = $info_data['import_raw_pearls'];
$import_cut_polished_gemstones = $info_data['import_cut_polished_gemstones'];
$import_rough_gemstones = $info_data['import_rough_gemstones'];
$import_gold = $info_data['import_gold'];
$import_rough_diamonds= $info_data['import_rough_diamonds'];
$import_synthetic_stones= $info_data['import_synthetic_stones'];
$import_cif_value = $info_data['import_cif_value'];
$export_fob_value=$info_data['export_fob_value'];
$import_cif_value= $info_data['import_cif_value'];


$finfo_data =mysql_fetch_array(mysql_query("select * from  payment_master where registration_id = '$registration_id' AND challan_financial_year ='$cur_fin_yr'"));

		$payment_mode = $finfo_data['payment_mode'];
		if ($payment_mode == 'Cheque') {
		$challan_payment_mode_label = 'Cheque';
		}
		elseif ($payment_mode == 'DD') {
		$challan_payment_mode_label = 'DD';
		}
		else {
		$challan_payment_mode_label = 'Cash';
		}
		$membership_fees = $finfo_data['membership_fees'];
		$admission_fees = $finfo_data['admission_fees'];
		$total=$finfo_data['total'];
		$total_payable=$finfo_data['total_payable'];
		$bank_name = $finfo_data['bank_name'];
		$branch_name = $finfo_data['branch_name'];
		$branch_city = $finfo_data['branch_city'];
		$branch_postal_code = $finfo_data['branch_postal_code'];
		$cheque_no = $finfo_data['cheque_no'];
		$cheque_date = $finfo_data['cheque_date'];
		$challan_financial_year = $finfo_data['challan_financial_year'];
		$total_payable = $finfo_data['total_payable'];
		$declaration = $finfo_data['declaration'];
	   $cheque_dd_dt_array =  explode("-",$cheque_date);

		$cheque_dd_dt_formatted =  $cheque_dd_dt_array[2]."-". $cheque_dd_dt_array[1]."-". $cheque_dd_dt_array[0] ;
		$challan_financial_year_plus_1 = ($challan_financial_year + 1);
		$challan_financial_year_min_1 = ($challan_financial_year - 1);
		
		
	$qregion_default =mysql_query("SELECT region_name,region_full_name,region_address, region_bank, region_bank_acct_no, region_bank_address, region_bank_logo FROM region_master WHERE region_name='$region_id'");
$region_default=mysql_fetch_array($qregion_default);

    $region_name = strtoupper($region_default['region_name']);
    $region_full_name = strtoupper($region_default['region_full_name']);
    $region_address = strtoupper($region_default['region_address']);
    $region_bank = strtoupper($region_default['region_bank']);
    $region_bank_acct_no = strtoupper($region_default['region_bank_acct_no']);
    $region_bank_address = strtoupper($region_default['region_bank_address']);
    $region_bank_logo = strtoupper($region_default['region_bank_logo']);
	
	
	
  
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
		
		

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mukesh Singh');
$pdf->SetTitle('Challan Form');
$pdf->SetSubject('TCPDF Tutorial');
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
if ($region_name == "RO-JAI")
{
    $page_title = "Current Account No. : ";
}
else
{
    $page_title = "Credit Special Saving Account No. : ";
}
//$pdf->Image($bankimage,160, 40, '', 20, 'JPG', '', 'T', false, 50, '', false, false, 0, false, false, false);

$pdf->SetY(20);
$pdf->SetX(0);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 10, $page_title.' '.$region_bank_acct_no , 0, false, 'C', 0, '', 0, false, 'T', 'M');
$pdf->SetY(35);
$pdf->SetX(15);
$pdf->SetFont('helvetica', 'B', 14);
$pdf->SetFillColor(255, 255, 255);
$pdf->SetFont('helvetica', '', 8);
// set some text to print
$txt = <<<EOD
<table width="637" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td height="15" valign="top"><table width="637" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="305" valign="top"><strong>Name of branch: </strong><br />
            $region_bank<br />
          $region_bank_address</td>
        <td width="20" valign="top">&nbsp;</td>
        <td width="320" align="right" valign="top">Challan No. <strong><b>$challan_region_challan_no</b></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="10" valign="top"></td>
  </tr>
  <tr>
    <td height="15" valign="top">Received to the credit of: <strong>THE GEM & JEWELLERY EXPORT PROMOTION COUNCIL</strong></td>
  </tr>

  <tr>
    <td height="15" valign="top">Name of the Member M/s : <b>$company_name $erp_code</b></td>
  </tr>
  <tr>
    <td height="15" valign="top"><table width="637" border="0" cellpadding="0" cellspacing="0" bordercolor="#F0F0F0">
      <tr>
        <td width="60" valign="top">Address :</td>
        <td width="577" valign="top"><b>$head_reg_office_print</b></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="10" valign="top"></td>
  </tr>

  <tr>
    <td height="15" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="315" align="center"><strong>Associate / Ordinary Membership</strong></td>
      </tr>
      <tr>



        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="top"><table width="317" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="15" height="15" valign="top"><strong>1.</strong></td>
                <td width="140" valign="top"><strong>Date of Deposit</strong></td>
                <td width="10" valign="top">:</td>
                <td width="152" valign="top">..........................</td>
              </tr>
              <tr>
                <td height="15" valign="top"><strong>2.</strong></td>
                <td valign="top"><strong>Account No.</strong></td>
                <td valign="top">:</td>
                <td valign="top"><b>$region_bank_acct_no</b></td>
              </tr>
              <tr>
                <td height="15" valign="top"><strong>3.</strong></td>
                <td colspan="3" valign="top"><table width="305" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="186" height="15" valign="top"><strong>Membership Fee for the Year of</strong></td>
                    <td width="10" valign="top">:</td>
                    <td width="109" valign="top"><b>$challan_financial_year - $challan_financial_year_plus_1</b></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="15" valign="top"><strong>4.</strong></td>
                <td valign="top"><strong>Membership Fees</strong></td>
                <td width="10" valign="top">:</td>
                <td valign="top"><b>Rs. $membership_fee</b></td>
              </tr>
              <tr>
                <td height="15" valign="top"><strong>5.</strong></td>
                <td valign="top"><strong>Admission Fees</strong></td>
                <td valign="top">:</td>
                <td valign="top"><b>Rs. $admission_fee</b></td>
              </tr>
              <tr>
                <td height="15" valign="top"><strong>6.</strong></td>
                <td valign="top"><strong>Total</strong></td>
                <td valign="top">:</td>
                <td valign="top"><b>Rs. $total</b></td>
              </tr>
              <tr>
                <td height="15" valign="top"><strong>7.</strong></td>
                <td valign="top"><strong>Service Tax (12.36%)</strong></td>
                <td width="10" valign="top">:</td>
                <td valign="top"><b>Rs. $service_tax</b></td>
              </tr>
              <tr>
                <td height="15" valign="top"><strong>8.</strong></td>
                <td valign="top"><strong>Balance etc.</strong></td>
                <td valign="top">:</td>
                <td valign="top"><b>Rs. $challan_balance</b></td>
              </tr>
              <tr>
                <td height="15" valign="top"><strong>9.</strong></td>
                <td valign="top"><strong>Total amount (in Rupees)</strong></td>
                <td width="10" valign="top">:</td>
                <td valign="top"><b>Rs. $total_payable</b></td>
              </tr>

            </table></td>
            <td width="200" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="15" height="15" valign="top"><strong>10.</strong></td>
                <td width="140" valign="top"><strong>$challan_payment_mode_label No. : <b>$cheque_no</b></strong></td>
                <td width="10" valign="top"></td>
                <td width="152" valign="top"><strong>Date : <b>$cheque_date</b></strong></td>
              </tr>
              <tr>
                <td height="15" >&nbsp;</td>
                <td valign="top">Drawn on Bank</td>
                <td valign="top">:</td>
                <td valign="top"><b>$bank_name</b></td>
              </tr>
              <tr>
                <td height="15" >&nbsp;</td>
                <td valign="top">Branch</td>
                <td valign="top">:</td>
                <td valign="top"><b>$branch_name</b></td>
              </tr>
              <tr>
                <td height="15" >&nbsp;</td>
                <td valign="top">City</td>
                <td valign="top">:</td>
                <td valign="top"><b>$city</b></td>
              </tr>
              <tr>
                <td height="15" >&nbsp;</td>
                <td valign="top">Postal Code</td>
                <td valign="top">:</td>
                <td valign="top"><b>$branch_postal_code</b></td>
              </tr>
              <!-- Signature part shifted to RHS as per councils request -->
              <tr>
                <td height="15" >&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td height="15" >&nbsp;</td>
                <td valign="top">Signature/stamp</td>
                <td valign="top">&nbsp;</td>
                <td valign="top">Signature of Depositor</td>
              </tr>
              <tr>
                <td height="15" >&nbsp;</td>
                <td valign="top"><b>$region_bank</b></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td height="20" valign="middle"></td>
  </tr>
  <tr>
    <td height="15" align="center" valign="middle"><strong>(NO OUTSTATION CHEQUE WILL BE ACCEPTED)</strong></td>
  </tr>
  <tr>
    <td height="15" valign="middle">N.B. Member/Applicant may please see page 2 for subscription fee payable etc. Valid subject to realization of cheque.</td>
  </tr>
    <tr>
    <td height="15" valign="middle">Cheque/ DD should be drawn in favour of <b>"The Gem &amp; Jewellery Export Promotion Council"</b>. Please write the <b>account no. $region_bank_acct_no </b> and mobile number on the back of the cheque/ DD.</td>
  </tr>
  <tr>
    <td height="10" valign="middle"></td>
  </tr>
  <tr>
    <td height="11" valign="middle" style="border-top:1px solid #cccccc;"></td>
  </tr>
  <tr>
    <td height="15" align="center" valign="middle"><strong>DECLARATION</strong></td>
  </tr>
  <tr>
    <td height="15" valign="top" style="text-align:justify"><strong>I/We hereby solemnly affirm and declare that our export of gem and jewellery items during the year $challan_financial_year_min_1 - $challan_financial_year (April-March), amounted in value of Rs. $export_fob_value (f.o.b.)(exports) and imports of gem and jewellery items amounted Rs. $import_cif_value. (c.i.f.)(imports), respectively. The details are as under : (Please refer to the Renewal Membership Circular)</strong></td>
  </tr>

  <tr>
    <td height="10" valign="middle"></td>
  </tr>
<tr></tr>
  <tr>
    <td height="15" valign="top"><table width="637" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="315" height="20" align="center"><strong>Exports</strong></td>
        <td width="7" style="border-left:1px solid #cccccc;">&nbsp;</td>
        <td width="315" align="center"><strong>Imports</strong></td>
      </tr>
      <tr>
        <td><table width="315" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="205" height="15" valign="top"><strong>Items</strong></td>
              <td width="10" valign="top">&nbsp;</td>
              <td width="100" valign="top"><strong>Value (Rs.)</strong></td>
            </tr>
            <tr>
              <td height="15" valign="top">Cut &amp; Polished Diamonds</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_cut_polished_diamonds</b></td>
            </tr>

            <tr>
              <td height="15" valign="top">Rough Diamond</td>
              <td width="10" valign="top">:</td>
              <td valign="top"><b>$export_rough_diamonds</b></td>
            </tr>
            <tr>
              <td height="15" valign="top">Gold Jewellery</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_gold_jewellery</b></td>
            </tr>
            <tr>
              <td height="15" valign="top">Coloured Gemstones</td>
              <td width="10" valign="top">:</td>
              <td valign="top"><b>$export_coloured_gemstones</b></td>
            </tr>
            <tr>
              <td height="15" valign="top">Pearls</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_pearls</b></td>
            </tr>
            <tr>
              <td height="15" valign="top">Other Precious Metal Jewellery</td>
              <td width="10" valign="top">:</td>
              <td valign="top"><b>$export_other_precious_metal_jewellery</b></td>
            </tr>
            <tr>
              <td height="15" valign="top">Costume/Fashion Jewellery</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_costume_jewellery</b></td>
            </tr>
            <tr>
              <td height="15" valign="top">Synthetic Stones</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_synthetic_stones</b></td>
            </tr>
            <tr>
              <td height="15" valign="top">Sales to Foreign Tourists</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_sales_to_foreign_tourists</b></td>
            </tr>
            <tr>
              <td height="15" valign="top">Total</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_fob_value</b></td>
            </tr>

        </table></td>
        <td style="border-left:1px solid #cccccc;">&nbsp;</td>
        <td><table width="315" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="205" height="15" valign="top"><strong>Items</strong></td>
            <td width="10" valign="top">&nbsp;</td>
            <td width="100" valign="top"><strong>Value (Rs.)</strong></td>
          </tr>
          <tr>
            <td height="15" valign="top">Cut &amp; Polished Diamonds</td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_cut_polished_diamonds</b></td>
          </tr>
          <tr>
            <td height="15" valign="top">Rough Diamonds</td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_rough_diamonds</b></td>
          </tr>
          <tr>
            <td height="15" valign="top">Gold</td>
            <td width="10" valign="top">:</td>
            <td valign="top"><b>$import_gold</b></td>
          </tr>
          <tr>
            <td height="15" valign="top">Cut &amp; Polished Gemstones</td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_cut_polished_gemstones</b></td>
          </tr>
          <tr>
            <td height="15" valign="top">Rough Gemstones</td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_rough_gemstones</b></td>
          </tr>
          <tr>
            <td height="15" valign="top">Raw Pearls</td>
            <td width="10" valign="top">:</td>
            <td valign="top"><b>$import_raw_pearls</b></td>
          </tr>
          <tr>
            <td height="15" valign="top">Silver, Platinum, Palladium</td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_silver</b></td>
          </tr>
          <tr>
            <td height="15" valign="top">Rough Imitation Stones, Glass <br />
              Bead Chattons</td>
            <td width="10" valign="top">:</td>
            <td valign="top"><b>$import_rough_imitation_stones</b></td>
          </tr>
          <tr>
            <td height="15" valign="top">False Pearls</td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_false_pearls</b></td>
          </tr>
          <tr>
            <td height="15" valign="top">Finding &amp; Mountings</td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_findings_mountings</b></td>
          </tr>

          <tr>
            <td height="15" valign="top">Synthetic Stones</td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_synthetic_stones</b></td>
          </tr>

          <tr>
            <td height="15" valign="top">Total</td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_cif_value</b></td>
          </tr>

        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="15" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="15" valign="top">Signature &amp; Seal:</td>
  </tr>
  <tr>
    <td height="15" valign="top">Name: <strong><b>$contact_name</b></strong></td>
  </tr>
  <tr>
    <td height="15" valign="top">Designation of Signatory Proprietor/Partner/Director: <strong><b>$designation</b></strong></td>
  </tr>
  <tr>
    <td height="15" valign="top">Full address of the member: <strong><b>$head_reg_office_print</b></strong></td>
  </tr>
  <tr>
    <td height="15" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="15" valign="top"><table width="637" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100" height="15" >Tel No. :</td>
        <td width="200"><b>$land_line_no</b></td>
        <td width="100">Mobile :</td>
        <td width="237"><b>$info_mobile_no</b></td>
      </tr>
      <tr>
        <td height="15" >E-mail:</td>
        <td><b>$info_email_id</b></td>
        <td>website:</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="35" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="15" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="15" valign="top"><table width="637" border="0" cellspacing="0" cellpadding="0">
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
        <td><table width="650" border="0" cellspacing="0" cellpadding="0">
            
             $dynac_fee_label
            $dynac_fee_content
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
    <td height="15" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="25" valign="top"><strong>Admission fee payable in case of New Member/Late Renewal Rs. $admission_fee/-  + Service Tax (12.36%)</strong></td>
  </tr>
  <tr>
    <td height="15" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="15" valign="top"><table width="637" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="40" valign="top"><strong>Note:</strong></td>
        <td width="30" height="35" valign="top"><strong>1.</strong></td>
        <td width="567" valign="top" style="text-align:justify;"><strong>Annual membership fee is payable on the basis of export of gem &amp; jewellery effected during the preceding financial year.</strong></td>
      </tr>
   
      <tr>
        <td valign="top">&nbsp;</td>
        <td height="35" valign="top"><strong>2.</strong></td>
        <td valign="top"><strong>Rs. 5000/- will be deducted as processing charges in the event of request of refund of membership. Service tax amount will not be refunded.</strong></td>
      </tr>
	  <tr>
        <td valign="top">&nbsp;</td>
        <td height="35" valign="top"><strong>3.</strong></td>
        <td valign="top"><strong>Make sure to submit a copy of the duly acknowledged Challan (after making the payment in the Bank) along with Renewal Membership Application form duly stamped &amp; signed by Proprietor/Partner/Director as the case may be.</strong></td>
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
              <td height="30" valign="top"><strong>e.</strong></td>
              <td valign="top"><strong>A self certified copy of Partnership Deed/Memorandum & Articles of Association of the applicant firm (as applicable).</strong></td>
            </tr>
			<tr>
              <td height="45" valign="top"><strong>f.</strong></td>
              <td valign="top"><strong>A self certified copy of each of Partnership dissolution deed and New Partnership deed in case of change in constitution of   Partnership Firm or self certified copy of relevant Resolution of Board effecting change in Constitution of Ltd. Companies.</strong></td>
            </tr>
			<tr>
              <td height="30" valign="top"><strong>g.</strong></td>
              <td valign="top"><strong>A self certified copy of SSI/DIC Registration Certificate/SIA Letter issued for export products for which Registration is sought as "Manufacturer Exporter". This is applicable for  Manufacturer Exporters only.</strong></td>
            </tr>
            <tr>
              <td height="22" valign="top"><strong>h.</strong></td>
              <td valign="top"><strong>Submit all documents along with a covering letter on your letter head to Council's office.</strong></td>
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
    <td height="15" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td height="15" valign="top">&nbsp;</td>
  </tr>
</table>
EOD;
// print a block of text using Write()

$pdf->writeHTML($txt, true, false, true, false, '');  
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

