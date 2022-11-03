<?php 
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
$type_of_firm = strtoupper($default['type_of_firm']);
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
$fax_no = strtoupper($default['fax_no']);
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
$com_default = mysql_fetch_array(mysql_query("SELECT * FROM communication_details_master WHERE registration_id = '$registration_id'"));

$panel_name = $com_default['panel_name'];

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
    <td colspan="2" align="left"><strong> NAME OF MEMBER-FIRM</strong> <em>(in block letters):</em>&nbsp;$type_of_firm</td>
  </tr>
  
  <tr>
  <td colspan="2">&nbsp; </td>
    </tr>
  <tr>
    <td colspan="2" align="left"> <strong>OFFICE ADDRESS</strong> <em>(in block letters):</em>&nbsp;$head_reg_office_print</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp; </td>
   </tr>
   <tr>
    <td colspan="2">&nbsp; </td>
   </tr>
  <tr>
    <td colspan="2">PANEL:&nbsp;$panel_name</td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left"><strong>WHETHER PROPRIETOR/ PARTNERSHIP/ LIMITED/<br />
    ASSOCIATION/ HUF/ TRUST/ CO-OPERATIVE SOCIETY</strong>:</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
 <tr>
    <td colspan="2" align="left"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-color:#666666; border-collapse:collapse;">
      <tr align="center">
        <td width="33%" height="50" bgcolor="#EBEBEB"><strong>Name of the Authorized Representative<br />
          with Designation (in block letters)</strong></td>
        <td width="33%" bgcolor="#EBEBEB"><strong>Signature</strong></td>
        <td width="34%" bgcolor="#EBEBEB"><strong>Duly verified and<br />
          attested by Bank</strong></td>
      </tr>
	  
      <tr>
        <td height="100" align="center" bgcolor="#FFFFFF">
		<table width="100%" border="0" align="right"> 
		<tr><td>&nbsp;</td></tr>
          <tr>
            <td width="87" align="left"><strong>Name:</strong></td>
            <td width="216" align="left">$contact_name</td>
          </tr>
		  <tr><td align="left">&nbsp;</td>
		  </tr>
          <tr>
            <td align="left"><strong>Designation:</strong></td>
            <td align="left">$designation</td>
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
    <td colspan="2" align="left">Signature:</td>
  </tr>
  <tr>
    <td colspan="2" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" align="left">Name in Block Letters:&nbsp;&nbsp;$contact_name</td>
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
    <td width="53%" align="left">Tel. Number:&nbsp;&nbsp;$and_line_no</td>
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
$pdf->Output('signature_slip.pdf', 'I');
