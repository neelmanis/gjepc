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
    		$this->Cell(80, 10, 'Challan Form - Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			$this->Cell(-80, 10, date("d/m/Y h:i a"), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
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

$qho = $conn ->query("SELECT pan_no,gst_no,c_bp_number FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2' limit 1");
$rho = $qho->fetch_assoc();
$pan_no = strtoupper($rho['pan_no']);
$ho_bp_number=strtoupper($rho['c_bp_number']);
//$gst_no=strtoupper($rho['gst_no']);

$queryinfo = $conn ->query("SELECT * FROM information_master where registration_id='$registration_id'");
$default= $queryinfo->fetch_assoc();
    
$company_name = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $default['company_name']));
$member_type_id = $default['member_type_id'];
$gcode=$default['gcode'];
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

/*$info_email_id = strtolower($default['email_id']);
$pan_no = strtoupper($default['pan_no']); */
$tan_no = strtoupper($default['tan_no']);
$gst_no = strtoupper($default['gst_no']);

$joining_date = strtoupper($default['joining_date']);
$retirement_date = strtoupper($default['retirement_date']);
$date = date('d-m-Y');

$q_approval = $conn ->query("SELECT membership_issued_dt FROM approval_master where registration_id='$registration_id'");
$r_approval = $q_approval->fetch_assoc();

// get G Code/ erp code
/**
$erpcode = db_result(db_query("SELECT erp_code FROM {temp_iec_member} WHERE uid=%d", $uid));
if ($erpcode) {
 $erp_code = ' / ' . $erpcode;
}
**/
$q_membership = $conn ->query("SELECT refer_membership_id FROM communication_details_master where registration_id='$registration_id'");
$r_membership = $q_membership->fetch_assoc();
$mem_id=$r_membership['refer_membership_id'];
// get membership code for user
if ($mem_id) {
 $mem_id_explode = explode('/', $mem_id); // explode membership id
 $erp_code = ' / ' . $mem_id_explode[2]; // get erp code (G Code)
} // end of if ($mem_id).

//Head Office  or  Registered Office

if($type_of_firm == 13 || $type_of_firm == 12)
{
    $register_office = "6";
	$head_register_office="REGISTERED OFFICE";
} else {
    $register_office = "2";
	$head_register_office="HEAD OFFICE";
}

$head_reg = $conn ->query("SELECT name, father_name, address1, address2, address3, country, state, city, pincode, landline_no1, mobile_no, fax_no1, fax_no2, email_id FROM communication_address_master  WHERE registration_id = '$registration_id'  and type_of_address='$register_office' limit 0,1");
$head_reg_office =  $head_reg->fetch_assoc();

$hname = strtoupper($head_reg_office['name']);
$hfather_name = strtoupper($head_reg_office['father_name']);
$haddress1 = strtoupper($head_reg_office['address1']);
if($haddress1!=""){$haddress1=$haddress1;}else{$haddress1="";}
$haddress2 = strtoupper($head_reg_office['address2']);
if($haddress2!=""){$haddress2=",".$haddress2;}else{$haddress2="";}
$haddress3 = strtoupper($head_reg_office['address3']);
if($haddress3!=""){$haddress3=",".$haddress3;}else{$haddress3="";}
$hcountry = strtoupper(getFullCountryeName($head_reg_office['country'],$conn));
if($hcountry!=""){ $hcountry=",".$hcountry; } else { $hcountry="";}
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

$head_reg_office_print = "$haddress1 $haddress2 $haddress3 $hcity $hstate $hcountry $hpincode";

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

$getInfo =  $conn ->query("select * from  challan_master where registration_id = '$registration_id' AND challan_financial_year ='$cur_fin_yr' order by id desc");
$info_data = $getInfo->fetch_assoc();

$export_sales_to_foreign_tourists = $info_data['export_sales_to_foreign_tourists'];
$export_synthetic_stones = $info_data['export_synthetic_stones'];
$export_costume_jewellery = $info_data['export_costume_jewellery'];
$export_other_precious_metal_jewellery = $info_data['export_other_precious_metal_jewellery'];
$export_pearls = $info_data['export_pearls'];
$export_coloured_gemstones = $info_data['export_coloured_gemstones'];
$export_gold_jewellery = $info_data['export_gold_jewellery'];
$export_studded_gold_jewellery = $info_data['export_studded_gold_jewellery'];
$export_silver_jewellery = $info_data['export_silver_jewellery'];
$export_studded_silver_jewellery = $info_data['export_studded_silver_jewellery'];
$export_rough_diamonds = $info_data['export_rough_diamonds'];
$export_cut_polished_diamonds = $info_data['export_cut_polished_diamonds'];
$export_rough_lgd = $info_data['export_rough_lgd'];
$export_cut_polished_lgd = $info_data['export_cut_polished_lgd'];
$export_other_items = $info_data['export_other_items'];
$export_total = $info_data['export_total'];
$export_imitation_jewellery = $info_data['export_imitation_jewellery'];

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
$import_gold_jewellery = $info_data['import_gold_jewellery'];
$import_silver_jewellery = $info_data['import_silver_jewellery'];
$import_rough_lgd = $info_data['import_rough_lgd'];
$import_cut_polished_lgd = $info_data['import_cut_polished_lgd'];
$import_imitation_jewellery = $info_data['import_imitation_jewellery'];
$import_other_items = $info_data['import_other_items'];
$export_fob_value=$info_data['export_fob_value'];
$import_cif_value= $info_data['import_cif_value'];
$challan_region_no=$info_data['challan_region_no'];
$post_date=$info_data['post_date'];

$membership_issued_dt=$r_approval['membership_issued_dt'];

$membership_issued_date = date('Y-m-d', strtotime($membership_issued_dt));

	   $payment_mode = $info_data['payment_mode'];
		if ($payment_mode == '3') {
		$challan_payment_mode_label = 'Net Banking';
		}
		elseif ($payment_mode == '4') {
		$challan_payment_mode_label = 'Debit Card';
		}
		elseif ($payment_mode == '5') {
		$challan_payment_mode_label = 'Credit Card';
		}
		else if($payment_mode == '2'){
		$challan_payment_mode_label = 'RTGS/NEFT';
		}
		else if($payment_mode == '1'){
		$challan_payment_mode_label = 'Cheque';
		}
		$challan_payment_mode_label;
		$membership_fees = $info_data['membership_fees'];
		$admission_fees = $info_data['admission_fees'];
		$total=$info_data['total'];
		$service_tax=$info_data['service_tax'];
		$total_payable=$info_data['total_payable'];
		$bank_name = $info_data['bank_name'];
		$branch_name = $info_data['branch_name'];
		$branch_city = $info_data['branch_city'];
		$branch_postal_code = $info_data['branch_postal_code'];
		$cheque_no = $info_data['cheque_no'];
		$cheque_date = $info_data['cheque_date'];
		//echo '---->'.$info_data['Transaction_Date']; exit;
			if($info_data['Transaction_Date']!=''){
				if($info_data['Transaction_Date']=="1970-01-01"){
					$Transaction_Date = '';
				} else { 
					$Transaction_Date = date('Y-m-d',strtotime($info_data['Transaction_Date'])); 
				}			
			} else {
					$Transaction_Date = '';
			}
		
		$ReferenceNo = $info_data['ReferenceNo'];
		$Unique_Ref_Number = $info_data['Unique_Ref_Number'];
		$challan_financial_year = $info_data['challan_financial_year'];
		$total_payable = $info_data['total_payable'];
		$declaration = $info_data['declaration'];
	    $cheque_dd_dt_array =  explode("-",$cheque_date);

		$cheque_dd_dt_formatted =  $cheque_dd_dt_array[2]."-". $cheque_dd_dt_array[1]."-". $cheque_dd_dt_array[0] ;
		$challan_financial_year_plus_1 = ($challan_financial_year + 1);
		$challan_financial_year_min_1 = ($challan_financial_year - 1);
		$service_text="GST (18%)";
		
	$qregion_default = $conn ->query("SELECT region_name,region_full_name,region_address, region_bank, region_bank_acct_no, region_bank_address, region_bank_logo FROM region_master WHERE region_name='HO-MUM (M)'");
	$region_default = $qregion_default->fetch_assoc();

    $region_name = strtoupper($region_default['region_name']);
    $region_full_name = strtoupper($region_default['region_full_name']);
    $region_address = strtoupper($region_default['region_address']);
    $region_bank = strtoupper($region_default['region_bank']);
    $region_bank_acct_no = strtoupper($region_default['region_bank_acct_no']);
    $region_bank_address = strtoupper($region_default['region_bank_address']);
    $region_bank_logo = strtoupper($region_default['region_bank_logo']);
  
 // dynamic fee structure table
  $fee_data_query = $conn ->query("SELECT * FROM export_amount_master WHERE financial_year='$cur_fin_yr' order by id");
  while ($fee_data_array = $fee_data_query->fetch_assoc()) {
   $fee_data[] = $fee_data_array;
  }

foreach ($fee_data as $k => $v) {

    $export_performance_desc         = $v['export_performance_desc'];
    $membership_fee                  = $v['membership_fee'];
    $service_tax_on_membership_fee   = $v['service_tax_on_membership_fee'];    
    $membership_fee_incl_service_tax = $v['membership_fee_incl_service_tax'];
	$gst_on_membership_fee   		 = $v['gst_on_membership_fee'];
    $membership_fee_incl_gst         = $v['membership_fee_incl_gst'];
    $admission_fee                   = $v['admission_fee'];
    $service_tax_on_admission_fee    = $v['service_tax_on_admission_fee'];
    $admission_fee_incl_service_tax  = $v['admission_fee_incl_service_tax'];
	$swachh_bharat_cess	= $v['swachh_bharat_cess'];
	$krishi_cess	= $v['krishi_cess'];

   if ($export_performance_desc) { // export_performance_desc
   /* Check GST Start */
  /* if(($membership_issued_date < $lastDate) || ($membership_issued_date == $lastDate))
   {
    $dynac_fee_label = '<tr>
                        <td width="210" height="50"><strong>Export Performance of Gem &amp; Jewellery<br />
                         during the year ' . $last_finyr . '</strong></td>
                        <td align="center" width="150"><strong>Membership fee<br />for ' . $cur_finyr . '</strong></td>	     
                        <td align="center" width="70"><strong>'.$service_text.'</strong></td>
						<!--<td align="center" width="70"><strong>Swachh Bharat Cess<br/>@0.5%</strong></td>
						<td align="center" width="70"><strong>Krishi Cess<br/>@0.5%</strong></td>
						<td align="center" width="70"><strong>Total Fees<br/>Payable</strong></td>-->
                    </tr>';

    $dynac_fee_content .= '<tr>
                      <td height="25">' . $export_performance_desc . '</td>
                      <td align="center">' . $membership_fee . '/-</td>
                      <td align="center">' . $gst_on_membership_fee . '/-</td>
					  <!--<td align="center">' . $swachh_bharat_cess . '/-</td>
					  <td align="center">' . $krishi_cess . '/-</td>
                      <td align="center">' . $membership_fee_incl_service_tax . '/-</td>-->
                     </tr>';
		} else { */
	   
	   $dynac_fee_label = '<tr>
                        <td width="210" height="50"><strong>Export Performance of Gem &amp; Jewellery<br />
                         during the year ' . $last_finyr . '</strong></td>
                        <td align="center" width="150"><strong>Membership fee<br />for ' . $cur_finyr . '</strong></td>	     
                        <td align="center" width="70"><strong>'.$service_text.'</strong></td>
						<td align="center" width="70"><strong>Total Fees Payable</strong></td>
                    </tr>';

    $dynac_fee_content .= '<tr>
                      <td height="25">' . $export_performance_desc . '</td>
                      <td align="center">' . $membership_fee . '/-</td>
                      <td align="center">' . $gst_on_membership_fee . '/-</td>
                      <td align="center">' . $membership_fee_incl_gst . '/-</td>
                     </tr>';
	  // } /* GST OVER */
   
   }
   elseif ($import_performance_desc) { // import_performance_desc
    $dynac_fee_label = '<tr>
                     <td width="297" height="50"><strong>Import Performance of Gem &amp; Jewellery<br />
                during the year ' . $last_finyr . '</strong></td>
                     <td align="center" width="160"><strong>Membership fee<br />for ' . $cur_finyr . '</strong></td>	     
                    <td align="center" width="80"><strong>Service Tax<br />
                @14%</strong></td>
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
            $rtgsDetails
          $region_bank_address</td>
        <td width="20" valign="top">&nbsp;</td>
        <td width="320" align="right" valign="top">Challan No. <strong><b>$challan_region_no</b></strong></td>
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
    <td height="15" valign="top">Name of the Member M/s : <b>$company_name &nbsp;&nbsp;/&nbsp;&nbsp;<span style="font-size:12px;">$ho_bp_number</span></b></td>
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
                <td valign="top"><b>Rs. $membership_fees</b></td>
              </tr>
              <tr>
                <td height="15" valign="top"><strong>5.</strong></td>
                <td valign="top"><strong>Admission Fees</strong></td>
                <td valign="top">:</td>
                <td valign="top"><b>Rs. $admission_fees</b></td>
              </tr>			  
			  <tr>
                <td height="15" valign="top"><strong>6.</strong></td>
                <td valign="top"><strong>Total</strong></td>
                <td valign="top">:</td>
                <td valign="top"><b>Rs. $total</b></td>
              </tr>
              <tr>
                <td height="15" valign="top"><strong>7.</strong></td>				
                <td valign="top"><strong>$service_text</strong></td>
                <td width="10" valign="top">:</td>
                <td valign="top"><b>Rs. $service_tax</b></td>
              </tr>
              <tr>
                <td height="15" valign="top"><strong>8.</strong></td>
                <td valign="top"><strong>Balance etc.</strong></td>
                <td valign="top">:</td>
                <td valign="top"><b>Rs. 0</b></td>
              </tr>
              <tr>
                <td height="15" valign="top"><strong>9.</strong></td>
                <td valign="top"><strong>Total Amount (in Rupees)</strong></td>
                <td width="10" valign="top">:</td>
                <td valign="top"><b>Rs. $total_payable</b></td>
              </tr>
            </table></td>
            <td width="200" align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="15" height="15" valign="top"><strong>10.</strong></td>
                <td width="140" valign="top"><strong>$challan_payment_mode_label</strong></td>
                <td width="10" valign="top"></td>
                <td width="152" valign="top"><strong>Transaction Date : <b>$Transaction_Date</b></strong></td>
              </tr>
			  <tr>
                <td height="15" >&nbsp;</td>
                <td valign="top">Challan Date</td>
                <td valign="top">:</td>
                <td valign="top"><b>$post_date</b></td>
              </tr>
              <tr>
                <td height="15" >&nbsp;</td>
                <td valign="top">Reference No</td>
                <td valign="top">:</td>
                <td valign="top"><b>$ReferenceNo</b></td>
              </tr>
              <tr>
                <td height="15" >&nbsp;</td>
                <td valign="top">Transaction ID</td>
                <td valign="top">:</td>
                <td valign="top"><b>$Unique_Ref_Number</b></td>
              </tr>
			  <tr>
                <td height="15" valign="top"><strong>11.</strong></td>
                <td valign="top"><strong>PAN No.</strong></td>
                <td width="10" valign="top">:</td>
                <td valign="top"><b>$pan_no</b></td>
              </tr>
			  <tr>
                <td height="15" valign="top"><strong>12.</strong></td>
                <td valign="top"><strong>GSTIN No.</strong></td>
                <td width="10" valign="top">:</td>
                <td valign="top"><b>$gst_no</b></td>
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
    <td height="15" align="center" valign="middle"><strong>DECLARATION</strong></td>
  </tr>
  <tr>
    <td height="15" valign="top" style="text-align:justify"><strong>I/We hereby solemnly affirm and declare that our export of Gem and Jewellery items during the year $challan_financial_year_min_1 - $challan_financial_year (April-March), amounted in value of Rs. $export_fob_value (f.o.b.)(exports) and imports of gem and Jewellery items amounted Rs. $import_cif_value. (c.i.f.)(imports), respectively. The details are as under : (Please refer to the Renewal Membership Circular)</strong></td>
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
              <td height="15" valign="top">Plain Gold Jewellery</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_gold_jewellery</b></td>
            </tr>
			<tr>
              <td height="15" valign="top">Studded Gold Jewellery</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_studded_gold_jewellery</b></td>
            </tr>
			<tr>
              <td height="15" valign="top">Plain Silver Jewellery</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_silver_jewellery</b></td>
            </tr>
			<tr>
              <td height="15" valign="top">Studded Silver Jewellery</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_studded_silver_jewellery</b></td>
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
              <td height="15" valign="top">Rough Lab Grown Diamond</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_rough_lgd</b></td>
            </tr>
			<tr>
              <td height="15" valign="top">Cut & Polished Lab Grown Diamond</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_cut_polished_lgd</b></td>
            </tr>
			<tr>
              <td height="15" valign="top">Sales to Foreign Tourists</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_sales_to_foreign_tourists</b></td>
            </tr>
			<tr>
              <td height="15" valign="top">Imitation Jewellery</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_imitation_jewellery</b></td>
            </tr>
			<tr>
              <td height="15" valign="top">Other Items</td>
              <td valign="top">:</td>
              <td valign="top"><b>$export_other_items</b></td>
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
            <td height="15" valign="top">Gold Bar</td>
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
            <td height="15" valign="top">Rough Imitation Stones, Glass Beads/ Glass Chattons</td>
            <td width="10" valign="top">:</td>
            <td valign="top"><b>$import_rough_imitation_stones</b></td>
          </tr>
          <tr>
            <td height="15" valign="top">Processed & Finished Pearls</td>
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
            <td height="15" valign="top">Gold Jewellery</td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_gold_jewellery</b></td>
          </tr>
		  <tr>
            <td height="15" valign="top">Silver Jewellery</td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_silver_jewellery</b></td>
          </tr>
		   <tr>
            <td height="15" valign="top">Rough Lab Grown Diamond</td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_rough_lgd</b></td>
          </tr>
		   <tr>
            <td height="15" valign="top">Cut & Polished Lab Grown Diamond</td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_cut_polished_lgd</b></td>
          </tr>
		  <tr>
            <td height="15" valign="top">Imitation Jewellery</td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_imitation_jewellery</b></td>
          </tr>
		  <tr>
            <td height="15" valign="top">Other Items </td>
            <td valign="top">:</td>
            <td valign="top"><b>$import_other_items</b></td>
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
    <td height="25" valign="top"><strong>Admission fee payable in case of New Member/Late Renewal Rs. $admission_fee/-  + $service_text</strong></td>
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
        <td valign="top"><strong>Rs. 5000/- will be deducted as processing charges in the event of request of refund of membership. Tax amount will not be refunded.</strong></td>
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
              <td height="30" valign="top"><strong>d.</strong></td>
              <td valign="top"><strong>A self certified copy of Partnership Deed/Memorandum & Articles of Association of the applicant firm (as applicable).</strong></td>
            </tr>
			<tr>
              <td height="45" valign="top"><strong>e.</strong></td>
              <td valign="top"><strong>A self certified copy of each of Partnership dissolution deed and New Partnership deed in case of change in constitution of Partnership Firm or self certified copy of relevant Resolution of Board effecting change in Constitution of Ltd. Companies.</strong></td>
            </tr>
			<tr>
              <td height="30" valign="top"><strong>f.</strong></td>
              <td valign="top"><strong>A self certified copy of SSI/DIC Registration Certificate/SIA Letter issued for export products for which Registration is sought as "Manufacturer Exporter". This is applicable for  Manufacturer Exporters only.</strong></td>
            </tr>
            <tr>
              <td height="22" valign="top"><strong>g.</strong></td>
              <td valign="top"><strong>Submit all documents along with a covering letter on your letter head to Councils office.</strong></td>
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
ob_clean();
//Close and output PDF document
$pdf->Output('example_003.pdf', 'I');

