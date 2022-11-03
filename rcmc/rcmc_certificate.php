<?php
ob_start(); 
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
require_once('../db.inc.php');
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
    		$this->Cell(80, 10, 'Signature Form - Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			$this->Cell(-80, 10, date("d/m/Y h:i a"), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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
$hemail_id = strtolower($head_reg_office['email_id']);

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
$challan_region_no=$info_data['challan_region_no'];


$finfo_data =mysql_fetch_array(mysql_query("select * from  payment_master where registration_id = '$registration_id' AND challan_financial_year ='$cur_fin_yr'"));

		$payment_mode = $finfo_data['payment_mode'];
		if ($payment_mode == 'Check') {
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
		$service_tax=$finfo_data['service_tax'];
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
// set certificate file

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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="left" ><strong> Ref No :</strong> GJC/P/FRM/2011-2012 </td>
<td align="right"><strong> Date :</strong> $date </td>
</tr>
</table>
<table width="620" border="0" cellpadding="0" cellspacing="0">
<tr><td>&nbsp;</td></tr>
<tr>
<td>$company_name<br />
9/A, 1ST FLR, WARDEN COURT BLD<br />
NR. GOWALIA TANK JAIN MANDIR<br />
A.K. MARG<br />
$city - $pincode<br />
<br />
Dear Sirs,<br />
<br />
<strong style="text-align:center;">$title</strong><br />
<br />
<span style="text-align:center;">Sub : $subject</span><br />
<br />
$content
Yours truly,<br />
<br />
($signatory_arr[0])<br />
$signatory_arr[1]<br />
<br />
Encl. : Challan<br /></td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
<tr>
<td>&nbsp;</td>
</tr>
</table>
EOD;

$pdf->writeHTML($html, true, false, true, false, '');

$pdf->Output('membership_certificate.pdf', 'I');

function rcmc_print_membership_certificate_content($membership_type, $membership_renewal_dt) {

   if($membership_type == "Associate") {
    // New Associate Member
	if($membership_renewal_dt == '') {
	   $content = <<<EOD
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td align="left" ><strong> Ref No :</strong> GJC/P/FRM/2011-2012 </td>
		<td align="right"><strong> Date :</strong> 30/08/11 </td>
		</tr>
		</table>
		<table width="620" border="0" cellpadding="0" cellspacing="0">
		<tr><td>&nbsp;</td></tr>
		<tr>
		<td>RAYS DIAM<br />
		9/A, 1ST FLR, WARDEN COURT BLD<br />
		NR. GOWALIA TANK JAIN MANDIR<br />
		A.K. MARG<br />
		MUMBAI - 400036<br />
		Maharashtra<br />
		<br />
		Dear Sirs,<br />
		<br />
		<strong style="text-align:center;">ASSOCIATE MEMBERSHIP CERTIFICATE</strong><br />
		<br />
		<span style="text-align:center;">Sub : Enrollment as an Associate Member for the year 2011-2012.</span><br />
		<br />
		We acknowledge receipt of your application dated 16/08/11 for Enrollment as an Associate Member for	the year 2011-2012.<br /><br />
		We have pleasure to inform you that your membership has been enrolled as an Associate Member of the Council for the year 2011-2012.<br /><br />
		Your Associate Membership Number is GJEPC/HO-MUM (M)/G25459/AM/I.<br /><br />
		Your membership has been enrolled under the DIAMONDS Panel.<br />
		<br />
		Yours truly,<br />
		<br />
		(P. HARISANKARAN)<br />
		SR MANAGER M &amp; R.<br />
		<br />
		Encl. : Challan<br /></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>

		</table>
EOD;
	}
    // Associate Member
    else {
	   $content = <<<EOD
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
		<td align="left" ><strong> Ref No :</strong> GJC/P/FRM/2011-2012 </td>
		<td align="right"><strong> Date :</strong> 30/08/11 </td>
		</tr>
		</table>
		<table width="620" border="0" cellpadding="0" cellspacing="0">
		<tr><td>&nbsp;</td></tr>
		<tr>
		<td>$company_name<br />
		9/A, 1ST FLR, WARDEN COURT BLD<br />
		NR. GOWALIA TANK JAIN MANDIR<br />
		A.K. MARG<br />
		$city - $pincode<br />
		Maharashtra<br />
		<br />
		Dear Sirs,<br />
		<br />
		<strong style="text-align:center;">ASSOCIATE MEMBERSHIP CERTIFICATE</strong><br />
		<br />
		<span style="text-align:center;">Sub : Renewal as an Associate Member for the year 2011-2012.</span><br />
		<br />
		We acknowledge receipt of your application dated 27/07/11 for Renewal as an Associate Member for
		the year 2011-2012.<br /><br />
		We have pleasure to inform you that your membership has been renewed as an Associate Member of the
		Council for the year 2011-2012.<br /><br />
		Your Associate Membership Number is GJEPC/HO-MUM (M)/G02615/AM/I.<br /><br />
		Your membership has been renewed under the COLOURED GEMSTONES Panel.<br />
		<br />
		Yours truly,<br />
		<br />
		(P. HARISANKARAN)<br />
		SR MANAGER M &amp; R.<br />
		<br />
		Encl. : Challan<br /></td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		<tr>
		<td>&nbsp;</td>
		</tr>
		</table>
EOD;
// print a block of text using Write()

$pdf->writeHTML($txt, true, false, true, false, '');  
// ---------------------------------------------------------
ob_clean();
//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

