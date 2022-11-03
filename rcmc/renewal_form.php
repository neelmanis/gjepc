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
require_once('../db.inc.php');
require_once('../functions.php');
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
    		$this->Cell(80, 10, 'Renewal Form - Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			$this->Cell(-80, 10, date("m/d/Y h:i a"), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

// current financial yr calculation
 $cur_year = (int)date('Y');
 $cur_month = (int)date('m');
 if ($cur_month < 4) {
  $cur_fin_yr  = $cur_year-1;
  $prev_finyr  = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
  $cur_finyr   = $cur_fin_yr . '-' . ($cur_fin_yr+1);
  $laststartyr = ($cur_fin_yr-2) . '-04-01';
  $lastendyr   = ($cur_fin_yr-1) . '-03-31';
 }
 else {
  $cur_fin_yr  = $cur_year;
  $prev_finyr  = ($cur_fin_yr-1) . '-' . $cur_fin_yr;
  $cur_finyr   = $cur_fin_yr . '-' . ($cur_fin_yr+1);
  $laststartyr = ($cur_fin_yr-1) . '-04-01';
  $lastendyr   = $cur_fin_yr . '-03-31';
 }
$query=mysql_query("select membership_id from approval_master where registration_id='$registration_id' AND ((membership_issued_dt BETWEEN '$laststartyr' AND '$lastendyr') OR (membership_renewal_dt BETWEEN '$laststartyr' AND '$lastendyr')) limit 1");
$lastyr_membership_details=mysql_fetch_array($query);

$lastyr_membership_id = $lastyr_membership_details['membership_id'];
if($lastyr_membership_id==""){$lastyr_membership_id="NA";}
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
if($ssi_issue_date==""){$ssi_issue_date="NA";}
$ssi_pin_code = strtoupper($default['ssi_pin_code']);
$issuing_industrial_liecence = strtoupper($default['issuing_industrial_liecence']);
$authority = strtoupper($default['authority']);
$eh_th_certification_no = strtoupper($default['eh_th_certification_no']);
if($eh_th_certification_no==""){$eh_th_certification_no="NA";}
$eh_th_issue_date = strtoupper($default['eh_th_issue_date']);
if($eh_th_issue_date==""){$eh_th_issue_date="NA";}
$eh_th_valid_date = strtoupper($default['eh_th_valid_date']);
if($eh_th_valid_date==""){$eh_th_valid_date="NA";}
$region_id = strtoupper($default['region_id']);
$year_of_starting_bussiness = strtoupper($default['year_of_starting_bussiness']);
$contact_name = strtoupper($default['name']);
$designation = strtoupper($default['designation']);
$info_email_id =strtolower($default['email_id']);
$pan_no = strtoupper($default['pan_no']);
$tan_no = strtoupper($default['tan_no']);
$address1 = strtoupper($default['address1']);
$address2 = strtoupper($default['address2']);
$address3 = strtoupper($default['address3']);
$pin_code = strtoupper($default['pin_code']);
$city = strtoupper($default['city']);
$country = strtoupper(getFullCountryeName($default['country']));
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


$info_data = mysql_fetch_array(mysql_query("select *  from  challan_master where registration_id='$registration_id' AND challan_financial_year='$cur_fin_yr'"));

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
$import_cut_polished_diamonds = $info_data['import_cut_polished_diamonds'];
$import_rough_diamonds = $info_data['import_rough_diamonds'];
$import_synthetic_stones = $info_data['import_synthetic_stones'];
$import_total = $info_data['import_total'];


$bank_name = $info_data['bank_name'];
$branch_name = $info_data['branch_name'];
$branch_city = $info_data['branch_city'];
$branch_postal_code = $info_data['branch_postal_code'];
$cheque_no = $info_data['cheque_no'];
$cheque_date = $info_data['cheque_date'];
$challan_financial_year = $info_data['challan_financial_year'];

$membership_fees = $info_data['membership_fees'];
$admission_fees = $info_data['admission_fees'];
$service_tax = $info_data['service_tax'];
$total_payable = $info_data['total_payable'];
$declaration = $info_data['declaration'];
$totalmembership = $membership_fees + $admission_fees ;

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

    if ($region_name == "HO-MUM (M)")
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
$pdf->SetTitle('Renewal Form');
$pdf->SetSubject('Renewal Form');
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
    <td height="25" valign="top">To,<br />
      $edto,<br />
      <strong>THE GEM & JEWELLERY EXPORT PROMOTION COUNCIL</strong><br />
      $region_address<br /></td>
  </tr>
  <tr>
    <td height="25" valign="top">&nbsp;</td>
  </tr>
  
  <tr>
    <td height="25" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="17" height="25" align="left" valign="top">1.</td>
        <td width="620" align="left" valign="top">Name of the applicant : <b>$company_name</b></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">2.</td>
        <td align="left" valign="top">Membership No. for $prev_finyr : $lastyr_membership_id</td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">3. </td>
        <td align="left" valign="top">Full Address of the Firm : $head_reg_office_print</td>
      </tr>
      <tr>
        <td height="10" align="left" valign="top">&nbsp;</td>
        <td height="10" align="left" valign="top">&nbsp;</td>
      </tr>
      
         <tr>
           <td height="25" align="left" valign="top"></td>
           <td align="left" valign="top">City: <b>$hcity</b> Pin Code: <b>$hpincode</b></td>
        </tr>
         <tr>
           <td height="25" align="left" valign="top">4.</td>
           <td align="left" valign="top">Telephone No.(with Area Code) : $land_line_no</td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top">5.</td>
           <td align="left" valign="top">Fax  No.: (with Area Code) :</td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top">6.</td>
           <td align="left" valign="top">E-mail : <b>$info_email_id</b></td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top"></td>
           <td align="left" valign="top">(Application will be deemed to be incomplete if e-mail address is improperly mentioned. Please note that all official communication by and on behalf of the Council will be preferably done only on the e-mail address provided herein. You may also provide any alternative e-mail address for smooth communication. The will not be responsible in any manner whatsoever for miscommunication on account of wrong e-mail mentioned herein or due to any technical error or snag.)</td>
         </tr>
         <tr>
           <td height="10" align="left" valign="top">&nbsp;</td>
           <td height="10" align="left" valign="top">&nbsp;</td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top">7.</td>
           <td align="left" valign="top">Website :</td>
         </tr>
         
         <tr>
           <td height="10" align="left" valign="top">&nbsp;</td>
           <td height="10" align="left" valign="top">&nbsp;</td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top">8.</td>
           <td align="left" valign="top">We enclose herewith a copy of the  challan No. <b>$challan_region_challan_no</b> duly stamped and receipted by <b>$region_bank, $region_bank_address</b>  as a proof of payment of </td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top"></td>
           <td align="left" valign="top">( i) Membership fees : <b>Rs. $totalmembership</b> <br />
             (ii) Service Tax @ 12.36% : <b>Rs. $service_tax</b></td>
         </tr>
         <tr>
           <td height="10" align="left" valign="top">&nbsp;</td>
           <td height="10" align="left" valign="top">&nbsp;</td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top">9.</td>
           <td align="left" valign="top">I/We declare that I/We:</td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top"></td>
           <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td width="30" height="23" align="left" valign="top">(a)</td>
               <td width="590" align="left" valign="top">Agree to abide by the rules & regulations as stated overleaf which are as per  the Memorandum & Articles of  Association of the Council, or any modification or amendment thereof for the time being in force.</td>
             </tr>
             <tr>
               <td height="5" align="left" valign="top"></td>
               <td height="5" align="left" valign="top"></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top">(b)</td>
               <td align="left" valign="top">Also agree to abide by the decisions and resolutions of the Committee of Administration and their sub-committee of the Council as stated overleaf and taken from time to time during the tenure of my membership with the Council.</td>
             </tr>
             
             
             <tr>
               <td height="5" align="left" valign="top"></td>
               <td height="5" align="left" valign="top"></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top">(c)</td>
               <td align="left" valign="top">Do not have any outstanding amount payable to the Council by me / us as on the date of this Application and undertake to make timely payments in future, failing which the Committee of Administration of the Council reserves the right to decide about my membership status and about any &amp; all facilities /services extended by the Council to the members. In this context, I undertake to bring to the Councils notice any discrepancies / disputes with respect to the invoiced amount raised by the Council within 30 (thirty) days from date of the invoice, failing which any and all decision of the Council in this behalf shall be final and binding on me / us.</td>
           </tr>
             <tr>
               <td height="5" align="left" valign="top"></td>
               <td height="5" align="left" valign="top"></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top">(d)</td>
               <td align="left" valign="top">Any and  all declaration given by me / us in the membership renewal application form and  / or Challans and / or any Annexure thereto is true, valid and correct as on  the date of such declaration. I / we hereby undertake to indemnify and keep the  Council indemnified, safe and harmless, at all times, from and against any and  all claims, losses, damage to which the Council may be subjected as a result of  its reliance on such declaration.</td>
             </tr>
             <tr>
               <td height="5" align="left" valign="top"></td>
               <td height="5" align="left" valign="top"></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top">(e)</td>
               <td align="left" valign="top">Read and understood the above all the rules and regulations as stated overleaf.</td>
             </tr>
             
           </table></td>
         </tr>
         
         <tr>
           <td height="25" align="left" valign="top"></td>
           <td align="left" valign="top">&nbsp;</td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top"></td>
           <td align="left" valign="top"><strong>Signature of the Proprietor/Partner/Director of the Company with Rubber Stamp</strong></td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top"></td>
           <td align="left" valign="top"><div align="center"><strong>GENERAL RULES &amp; REGULATIONS</strong></div></td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top"></td>
           <td align="left" valign="top"><strong>CLAUSES OF MEMORANDUM &amp; ARTICLES OF ASSOCIATION REGARDING MEMBERSHIP RULES&nbsp; </strong></td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top"><strong>3.</strong></td>
           <td align="left" valign="top"><strong>CATEGORIES OF  MEMBERS, AND ELIGIBILITY FOR MEMBERSHIP </strong></td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top"></td>
           <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td width="30" height="23" align="left" valign="top"><strong>3.1</strong></td>
               <td width="590" align="left" valign="top"><strong>Categories of members of the council</strong></td>
             </tr>
             
             <tr>
               <td height="23" align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">The  Council shall have the following categories of members, namely:<br />
                 (A)   Associate Members:<br />
                 (b)&nbsp;Ordinary Members:</td>
             </tr>
             <tr>
               <td height="5" align="left" valign="top"></td>
               <td height="5" align="left" valign="top"></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top"><strong>3.2</strong></td>
               <td align="left" valign="top"><strong>Associate Member</strong></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">A  person shall be eligible for admission to the Council as an Associate Member,  on receiving the Import-Export Code Number from the Director General of Foreign  Trade, Government of India, in respect of the product with which the Council is  concerned.</td>
             </tr>
             
             <tr>
               <td height="5" align="left" valign="top"></td>
               <td height="5" align="left" valign="top"></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top"><strong>3.3</strong></td>
               <td align="left" valign="top"><strong>Ordinary Membership</strong></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">In  order to be eligible for ordinary membership of the Council, a person must  satisfy the following requirements, namely:<br />
(a)  He, or the entity represented by him, must have been an Associate Member of the  Council for at least three years.<br />
(b) He, or the entity represented by him, must have, to his or its credit, during  the three financial years immediately preceding,<br />
(c) Average exports in respect of the product, of not less than the amount  mentioned below:<br />
(i)  Small scale industries&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rs. 10  lakhs<br />
(ii)  Others&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rs. 25 lakhs</td>
             </tr>
             
             <tr>
               <td height="5" align="left" valign="top"></td>
               <td height="5" align="left" valign="top"></td>
             </tr>
             
           </table></td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top"><strong>8.</strong></td>
           <td align="left" valign="top"><strong>DISQUALIFICATIONS FOR MEMBERSHIP OF COUNCIL</strong></td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top"></td>
           <td align="left" valign="top"><table width="620" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td width="30" height="23" align="left" valign="top"><strong>8.1</strong></td>
               <td width="590" align="left" valign="top"><strong>Disqualification</strong></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">A  person shall be disqualified for being, or for continuing, as a member of the  Council if<br />
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20" height="20" valign="top">a.</td>
    <td width="570" valign="top">He is found to be of unsound mind by a competent court;</td>
  </tr>
  <tr>
    <td height="20" valign="top">b.</td>
    <td valign="top">He applies to be adjudicated as, or is adjudicated as, an insolvent;</td>
  </tr>
  <tr>
    <td height="20" valign="top">c.</td>
    <td valign="top">He is convicted by a court of an offence involving moral turpitude and is  sentenced, an such conviction, to imprisonment for not less than six months;</td>
  </tr>
  
  <tr>
    <td height="20" valign="top">d.</td>
    <td valign="top">He, or any firm in which he is a partner, or any private company of which he is  a Director, commits a violation of section 295 or section 299 of the Act;</td>
  </tr>
 
  <tr>
    <td height="20" valign="top">e.</td>
    <td valign="top">He, becomes disqualified by an order of the court under section 203 of the Act;</td>
  </tr>
  <tr>
    <td height="20" valign="top">f.</td>
    <td valign="top">He ceases to be a member of the entity which he represents or such entity  ceases to be a member of the Council; or</td>
  </tr>
 
  <tr>
    <td height="20" valign="top">g.</td>
    <td valign="top">his name is removed from the register of members under article 8.2</td>
  </tr>
</table></td>
             </tr>
             
             
             
            <tr>
               <td width="30" height="23" align="left" valign="top"><strong>8.2</strong></td>
               <td width="590" align="left" valign="top"><strong>Removal by the Committee</strong></td>
             </tr>
             
             <tr>
               <td align="left" valign="top"></td>
               <td align="left" valign="top">The Committee may, after giving a member reasonable opportunity of hearing, remove the name of that member from the Register of Members, either for a specified period or indefinitely:</td>
             </tr>
             <tr>
               <td height="5" align="left" valign="top"></td>
               <td height="5" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                   <td width="20" height="20" valign="top">a.</td>
                   <td width="570" valign="top">If he has violated any condition for  membership or</td>
                 </tr>
                 <tr>
                   <td height="20" valign="top">b.</td>
                   <td valign="top">If he has been  in arrears in regard to the payment of membership fee or of any other amounts  due from him to the Council for more than six months; or</td>
                 </tr>
				  <tr>
                   <td height="20" valign="top">c.</td>
                   <td valign="top">If he has not  been guilty of disorderly conduct at meeting of the council or the committee;  or</td>
                 </tr>
				  <tr>
                   <td height="20" valign="top">d.</td>
                   <td valign="top">If he has otherwise been guilty of conduct in becoming of a member; or</td>
                 </tr>
				  <tr>
                   <td height="20" valign="top">e.</td>
                   <td valign="top">If he has become disqualified under article 8.1</td>
                 </tr>
                 
                 
               </table></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top"><strong>8.3</strong></td>
               <td align="left" valign="top"><strong>Conversion into Associate membership</strong></td>
             </tr>
             <tr>
               <td align="left" valign="top"></td>
               <td align="left" valign="top">The Committee may, after giving a member reasonable opportunity of hearing, convert the membership of an Ordinary Member into an Associate Membership, if his performance as an exporter of the product has, during the financial year immediately preceding been below the average mentioned in clause (b) of article 3.2.</td>
             </tr>
             <tr>
               <td height="5" align="left" valign="top"></td>
               <td height="5" align="left" valign="top"></td>
             </tr>
             
             
           </table></td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top"><strong>11.</strong></td>
           <td align="left" valign="top"><strong>PRIVILEGES OF MEMBERS</strong></td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top"></td>
           <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td width="38" height="23" align="left" valign="top"><strong>11.1</strong></td>
               <td width="582" align="left" valign="top"><strong>Ordinary Members</strong></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Without prejudice to any other rights conferred on Ordinary Members by the Memorandum of Association of the Council, but subject to the other provisions of these articles, Ordinary Members shall have the following rights and privileges, namely:</td>
             </tr>
             
             <tr>
               <td height="23" align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                 
                 <tr>
                   <td width="20" height="20" valign="top">a.</td>
                   <td width="570" valign="top">Right to stand as a candidate, and to vote at the election of the members of the&nbsp;&nbsp; Committee and the right to vote on all matters brought before a meeting of the Council, provided there are no arrears of subscription of other dues or charges payable by them to the Council on 1st April in the year of voting;</td>
                 </tr>
                 
                 <tr>
                   <td height="20" valign="top">b.</td>
                   <td valign="top">Right to requisition a meeting, as provided in these articles;</td>
                 </tr>
                 <tr>
                   <td height="20" valign="top">c.</td>
                   <td valign="top">Right to receive the annual reports of the Committee, on payment of the prescribed fee;</td>
                 </tr>
                 <tr>
                   <td height="20" valign="top">d.</td>
                   <td valign="top">Right to receive publication of the Council, on the prescribed conditions; and </td>
                 </tr>
                 <tr>
                   <td height="20" valign="top">e.</td>
                   <td valign="top">Right to use all such facilities<strong>*</strong> as may be made available to such members by the Council from time to time, on the prescribed conditions.</td>
                 </tr>
                 
               </table></td>
             </tr>
             <tr>
               <td align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">(<strong>*</strong> Facilities such as </td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                 
                 <tr>
                   <td width="20" height="20" valign="top">i.</td>
                   <td width="570" valign="top">Any event/ exhibitions in India/abroad,&nbsp;&nbsp;</td>
                 </tr>
                 <tr>
                   <td height="20" valign="top">ii.</td>
                   <td valign="top">Delegations,</td>
                 </tr>
                 <tr>
                   <td height="20" valign="top">iii.</td>
                   <td valign="top">Buyer Seller Meets,</td>
                 </tr>
                 <tr>
                   <td height="20" valign="top">iv.</td>
                   <td valign="top">Annual Awards</td>
                 </tr>
                 <tr>
                   <td height="20" valign="top">v.</td>
                   <td valign="top">Receipt of Solitaire International, Ideal Cut &amp; Circulars</td>
                 </tr>
                 <tr>
                   <td height="20" valign="top">vi.</td>
                   <td valign="top">Attending Seminars &amp; Workshops&nbsp;</td>
                 </tr>
                 <tr>
                   <td height="20" valign="top">vii.</td>
                   <td valign="top">Recommendation letter for visa</td>
                 </tr>
                 <tr>
                   <td height="20" valign="top">viii.</td>
                   <td valign="top">Permissions for Hand carry for foreign exhibitions &amp; etc. )&nbsp;</td>
                 </tr>
                 
               </table></td>
             </tr>
             
             <tr>
               <td height="23" align="left" valign="top"><strong>11.2</strong></td>
               <td align="left" valign="top"><strong>Associate Members</strong></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">Without prejudice to any other rights conferred an Associate Members by the Memorandum of Association, of the Council, such members shall have the following rights and privileges namely;</td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                 
                 <tr>
                   <td width="20" height="20" valign="top">i.</td>
                   <td width="570" valign="top">Right to receive the annual report of the Committee, on payment of the prescribed fee;</td>
                 </tr>
                 <tr>
                   <td height="20" valign="top">ii.</td>
                   <td valign="top">Right too receive publications of the Council, on the prescribed conditions;</td>
                 </tr>
                 <tr>
                   <td height="20" valign="top">iii.</td>
                   <td valign="top">Right to use all such facilities as may be made available form time to time, on the prescribed conditions.</td>
                 </tr>
                 
               </table></td>
             </tr>
             <tr>
               <td height="5" align="left" valign="top"></td>
               <td height="5" align="left" valign="top"></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top"><strong>11.3</strong></td>
               <td align="left" valign="top"><strong>Nominated and Co-opted Members</strong></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">A nominated or co-opted member shall have no right to vote</td>
             </tr>
             
           </table></td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top">13.</td>
           <td align="left" valign="top"><strong>SUSPENSION OF PRIVILEGES.</strong></td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top"></td>
           <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
             <tr>
               <td width="38" height="23" align="left" valign="top"><strong>13.1</strong></td>
               <td width="582" align="left" valign="top"><strong>Non-payment of subscription.</strong></td>
             </tr>
             <tr>
               <td height="23" align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top">If a member (Ordinary or Associate) fails to pay his annual subscription by the 30th April of the year for which it has become due, then</td>
             </tr>
             
             <tr>
               <td height="23" align="left" valign="top">&nbsp;</td>
               <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                   
                   <tr>
                     <td width="20" height="20" valign="top">a.</td>
                     <td width="570" valign="top">He shall not be entitled to exercise any right or privilege as such member and</td>
                   </tr>
                   
                   <tr>
                     <td height="20" valign="top">b.</td>
                     <td valign="top">The committee may suspend his membership, which suspension shall remain operative until he pays the arrears and the Committee accepts in writing such arrears and restores his membership after revoking his suspension</td>
                   </tr>
                   
                   <tr>
                     <td height="20" valign="top">c.</td>
                     <td valign="top">Also agree to abide by the decisions and resolutions of the Committee of Administration and their sub-committees of the council from time to time such as: </td>
                   </tr>
                   
                   <tr>
                     <td height="20" valign="top">d.</td>
                     <td valign="top">Agree to pay service tax/vat etc. as applicable </td>
                   </tr>
                   
               </table></td>
             </tr>
             
           </table></td>
         </tr>
         
         <tr>
           <td height="15" align="left" valign="top"></td>
           <td align="left" valign="top">&nbsp;</td>
         </tr>
         <tr>
           <td height="25" align="left" valign="top"></td>
           <td align="left" valign="top"><strong>Signature of the Proprietor/Partner/Director of the Company with Rubber Stamp</strong></td>
         </tr>
         

	  </table></td>
  </tr>
</table> 
EOD;
// print a block of text using Write()

$pdf->writeHTML($txt, true, false, true, false, '');
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('RenewalChallan.pdf', 'I');

