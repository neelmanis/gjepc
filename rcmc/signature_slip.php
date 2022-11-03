<?php 
ob_start();
//============================================================+
// File name   : Signature Slip
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Signature Slip for TCPDF class
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
    		$this->Cell(80, 10, 'Signature Form - Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			$this->Cell(-80, 10, date("m/d/Y h:i a"), 0, false, 'C', 0, '', 0, false, 'T', 'M');
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

$queryInfo = $conn ->query("SELECT * FROM information_master where registration_id='$registration_id'");
$default= $queryInfo->fetch_assoc();
$company_name = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $default['company_name']));

$member_type_id = $default['member_type_id'];
$type_of_firm = $default['type_of_firm'];
$get_type_of_firm = strtoupper(getFirmType($type_of_firm,$conn));
$tan_no = strtoupper($default['tan_no']);
$iec_no = strtoupper($default['iec_no']);

$fax_no = strtoupper($default['fax_no']);
$joining_date = strtoupper($default['joining_date']);
$retirement_date = strtoupper($default['retirement_date']);
$date = date('d-m-Y');

//Head Office  or  Registered Office
if ($type_of_firm == "13" || $type_of_firm == "12")
{
    $register_office = "6";
	$head_register_office="REGISTERED OFFICE";
} else {
    $register_office = "2";
	$head_register_office="HEAD OFFICE";
}

$head_reg = $conn ->query("SELECT name, father_name, address1, address2, address3, country, state, city, pincode, landline_no1, mobile_no, fax_no1, fax_no2, email_id FROM communication_address_master  WHERE registration_id = '$registration_id'  and type_of_address='$register_office' limit 0,1");
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

$head_reg_office_print = "$haddress1 $haddress2 $haddress3 $hcity $hstate $hcountry $hpincode";

$cms = $conn ->query("SELECT * FROM communication_details_master WHERE registration_id = '$registration_id'");
$com_default = $cms->fetch_assoc();

$panel_name = strtoupper($com_default['panel_name']);

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mukesh Singh');
$pdf->SetTitle('Signature Slip');
$pdf->SetSubject('Signature Slip');
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-family:'Lucida Sans'; font-size:12px; color:#333333; text-align:justify; ">
  <tr>
    <td height="25" align="center" valign="top"><strong>THE GEM & JEWELLERY EXPORT PROMOTION COUNCIL<br /><br/>
	FOR OFFICIAL USE: SIGNATURE SLIP
	</strong></td>
  </tr>
  
  <tr>
    <td height="25" valign="top">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="2" align="left"><strong>NAME OF MEMBER-FIRM:</strong>&nbsp;&nbsp;$company_name</td>
  </tr>
  
  <tr>
  <td colspan="2">&nbsp; </td>
    </tr>
  <tr>
    <td colspan="2" align="left"><strong>OFFICE ADDRESS&nbsp;&nbsp;:</strong> $head_reg_office_print</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp; </td>
   </tr>
    <tr>
    <td colspan="2"><strong>IEC No.&nbsp;&nbsp;:</strong> $iec_no</td>
  </tr>
   <tr>
    <td colspan="2">&nbsp; </td>
   </tr>
   
  <tr>
    <td colspan="2"><strong>PANEL&nbsp;&nbsp;:</strong> $panel_name</td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left"><strong>WHETHER PROPRIETOR/ PARTNERSHIP/ LIMITED/<br />
    ASSOCIATION/ HUF/ TRUST/ CO-OPERATIVE SOCIETY</strong>&nbsp;&nbsp;: $get_type_of_firm</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
 <tr>
    <td colspan="2" align="left"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#666666; border-collapse:collapse;">
      <tr align="center">
        <td width="33%" height="50" bgcolor="#EBEBEB"><strong>Name of the Authorized Representative<br />
          with Designation </strong></td>
        <td width="33%" bgcolor="#EBEBEB"><strong>Signature</strong></td>
        <td width="34%" bgcolor="#EBEBEB"><strong>Duly verified and<br />
          attested by Bank</strong></td>
      </tr>
	  
      <tr>
        <td height="100" align="center" bgcolor="#FFFFFF">
		<table width="100%" border="0" align="right"> 
		<tr><td>&nbsp;</td></tr>
          <tr>
            <td width="216" align="center">$contact_name</td>
          </tr>
		  <tr><td align="left">&nbsp;</td>
		  </tr>
          <tr>
            <td align="center">$designation</td>
          </tr>
        </table>
		</td>
        <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
        <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
   <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">Signature:</td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">Name:&nbsp;&nbsp;$contact_name</td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">Designation:&nbsp;&nbsp;$designation</td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">Firms Rubber Stamp with Office Address:</td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td width="47%" align="left">&nbsp;</td>
    <td width="53%" align="left">Tel. Number:&nbsp;&nbsp;$land_line_no</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">Mobile Number:&nbsp;&nbsp;$info_mobile_no</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">Fax No:&nbsp;&nbsp;$fax_no</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">E-mail:&nbsp;&nbsp;$info_email_id</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>  
</table>
EOD;

// print a block of text using Write()
$pdf->writeHTML($txt, true, false, true, false, '');
ob_clean();
$pdf->Output('signature_slip.pdf', 'I');
