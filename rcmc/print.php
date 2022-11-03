<?php 
ob_start();

require_once('tcpdf_include.php');  
require_once('../db.inc.php'); 
require_once('../functions.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

	//Page header
	public function Header() {
		//right Logo
    		$left_image_file =  K_PATH_IMAGES.'logo_gjepc.png';
    		$this->Image($left_image_file, 165, 10, '', 20, 'PNG', '', 'T', false, 72, '', false, false, 0, false, false, false);
    		//left Logo
    		/*$right_image_file =  K_PATH_IMAGES.'logo_in.png';
    		$this->Image($right_image_file, 10, 10, '', 20, 'PNG', '', 'T', false, 72, '', false, false, 0, false, false, false);
            $this->SetLineStyle(1);
            $this->Rect(8,8,193,275);*/
			
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
    		$this->SetY(-15);
    		// Set font
    		$this->SetFont('helvetica', 'I', 8);
    		// Page number
    		$this->Cell(80, 10, 'Gold Rate - Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			$this->Cell(-80, 10, date("m/d/Y h:i a"), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

$id = $_REQUEST['id'];
$sql= "SELECT * FROM `gold_rate_master_demo` WHERE id = $id";
$query = mysql_query($sql);
$row = mysql_fetch_array($query);

$ref_no = $row['ref_no'];
$gold_rate = $row['gold_rate'];
$date = date('d/m/Y',strtotime($row['post_date']));
$post_date = date('jS F Y', strtotime($row['post_date']));
$silver_rate = $row['silver_rate'];
$platinum = $row['platinum'];
$us_dollar = $row['us_dollar'];
$euro = $row['euro'];
$cYear=date('Y');
$nYear=date('Y', strtotime('+1 year'));
$year = $cYear.'-'.$nYear;


// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sanjeet Tiwari');
$pdf->SetTitle('Gold Metal Rate');
$pdf->SetSubject('Gold Rate');
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
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:'Lucida Sans'; margin-left:10%; font-size:12px; color:#333333; text-align:justify;">
   <tr>
   		<td height="25" valign="top">&nbsp;</td>
		<td height="25" valign="top">&nbsp;</td>
   </tr> 
      <tr>
   		<td height="25" valign="top">&nbsp;</td>
		<td height="25" valign="top">&nbsp;</td>
   </tr> 
	<tr>
		<td align="left"><strong>Ref.No.</strong>GJC/GOLD/N/RATE/$year/$ref_no</td>
		<td align="right"><strong>$post_date</strong></td>
	</tr>
	<tr>
   		<td height="25" valign="top">&nbsp;</td>
   </tr> 	
	<tr>
		<td colspan="2">Dear Sir/Madam,
		<br /><br>
		<strong>SUB: DIAMOND, GEM & JEWELLERY EXPORT PROMOTION SCHEME (DGJEPS) NATIONAL RATE</strong>
		</td>		
	</tr>
	<tr>
   		<td height="25" valign="top">&nbsp;</td>
   </tr> 
	<tr>
		<td colspan="2">In terms of the provisions of para 4.84 (d) (i), of Hand Book Procedure, we are furnishing the national rate as under: -</td>		
	</tr>
	<tr>
   		<td height="25" valign="top">&nbsp;</td>
   </tr> 
   <tr valign="top">
   		<td width="10%"></td>
        <td width="80%" align="center">
			<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-color:#666666;margin:0 auto; border-collapse:collapse;">
				<tr align="center" bgcolor="#EBEBEB">
					<td width="10%" height="40px"><strong>Sr.No.</strong></td>
					<td colspan="2" width="90%"><strong>EXIM POLICY 2015-2020</strong></td>		
				</tr>
				<tr align="center">
					<td width="10%" height="40px"><strong>1</strong></td>
					<td width="30%"><strong>GOLD</strong></td>
					<td width="60%">$gold_rate<br>$date</td>		
				</tr>
				<tr align="center">
					<td width="10%" height="40px"><strong>2</strong></td>
					<td width="30%"><strong>SILVER</strong></td>		
     				<td width="60%">$silver_rate</td>		
				</tr>
				<tr align="center">
					<td width="10%" height="40px"><strong>3</strong></td>
					<td width="30%"><strong>PLATINUM</strong></td>
					<td width="60%">$platinum<br>$date</td>		
				</tr>
				<tr align="center">
					<td width="10%" height="40px"><strong>4</strong></td>
					<td width="30%"><strong>US DOLLAR</strong></td>		
     				<td width="60%">$us_dollar</td>		
				</tr>
				<tr align="center">
					<td width="10%" height="40px"><strong>5</strong></td>
					<td width="30%"><strong>EURO</strong></td>
					<td width="60%">$euro</td>		
				</tr>				
		</table><div align = "left">Source for conversion rate: www.oanda.com<br>Source for precious metal rate: www.kilco.com</div></td>
		<td width="10%"></td>
		
   </tr>
  
   		
	
    
   <tr>
   		<td height="25px" valign="top">&nbsp;</td>
   </tr> 
   <tr>
   		<td height="25px" valign="top">&nbsp;</td>
   </tr>
	<tr>
	    <td>&nbsp;</td>	
		<td align="right">KAVITA HEBALKAR<br>DEPUTY DIRECTOR</td>		
	</tr> 
	<tr>
   		<td height="25px" valign="top">&nbsp;</td>
    </tr>
	<tr>	    
		<td colspan="2">Please Note that this national rate has been issued by us without any risk and responsibility on our part.</td>		
	</tr>
	<tr>
   		<td height="25px" valign="top">&nbsp;</td>
    </tr>
	<tr>	    
		<td colspan="2">
		<ol>
		<li>The Rate is valid for seven working days only from the date of issue.</li>
		</ol>
		</td>		
	</tr>
	<tr>
   		<td height="25px" valign="top">&nbsp;</td>
    </tr>
	<tr>	    
		<td colspan="2" width="10%">M/S</td>				
	</tr>
	<tr>	    
		<td width="10%"></td>
		<td width="90%"><hr></td>		
	</tr>
	<tr>
   		<td height="25px" valign="top">&nbsp;</td>
    </tr>
	<tr>	    
		<td width="10%"></td>
		<td width="90%"><hr></td>	
			
	</tr>
</table><br><br>
<div style="height:30px; display:block;"><img src="images/txt.jpg"></div>
EOD;

// print a block of text using Write()
$pdf->writeHTML($txt, true, false, true, false, '');
ob_clean();
$pdf->Output('signature_slip.pdf', 'I');
?>
