<?php
session_start();  
ob_start();
require_once('../rcmc/tcpdf_include.php'); 
require_once('../db.inc.php');
//require_once('../functions.php');

if(isset($_REQUEST['registration_id']) && $_REQUEST['registration_id']!='')
{
	$registration_id=$_REQUEST['registration_id'];
}else{
	 echo "USER DOES NOT EXIST";exit;
}

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	//Page header
	protected $address;
	protected $email;
	protected $tel_no;
	protected $fax;
	
	function __construct( $address , $tel_no, $email, $fax, $orientation, $unit, $format ) 
    {
        parent::__construct( $orientation, $unit, $format, true, 'UTF-8', false );		
        $this->address = $address ;
		$this->email = $email ;
		$this->tel_no = $tel_no ;
		$this->fax = $fax ;        
    }
	
	public function Header() {
		
		    //right Logo
    		$left_image_file =  K_PATH_IMAGES.'logo_gjepc.png';
    		$this->Image($left_image_file, 162, 15, '', 20, 'PNG', '', 'T', false, 72, '', false, false, 0, false, false, false);
    		// //left Logo
    		//$right_image_file =  K_PATH_IMAGES.'logo_gjepc.png';
    		//$this->Image($right_image_file, 15, 15, '', 20, 'PNG', '', 'T', false, 72, '', false, false, 0, false, false, false);
            // $this->SetLineStyle(1);
            // $this->Rect(8,8,193,275);
	 }

	// Page footer
	// public function Footer() {
			
	// 	// Position at 15 mm from bottom
 //    		$this->SetY(-72);
	// 		$this->SetFont('times', '', 10);
	// 		$this->Cell(180, 5, 'This certificate is digitally signed and does not require physical signature. ', 0, 0, 'C', 0, '', 0, false, 'T', 'M');
	// 		$this->Ln();
 //    		// Set font 
 //    		$this->SetFont('times', 'B', 13);
 //    		// Page number
	// 		$this->Cell(180, 6, '', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
 //    		$this->Cell(180, 6, 'The Gem & Jewellery Export Promotion Council ', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			
	// 		$this->SetFont('times', '', 8);
	// 		$this->Cell(180, 5, 'CIN U99100MH1966GAP013486', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			
			
 //    		// Page number
	// 		if($this->email != "gjepc@vsnl.com")
	// 		{
	// 		$this->SetFont('times', 'B', 8);
	// 		$this->Cell(180, 5, 'Regional Office:'.$this->address, 0, 1, 'C', 0, '', 0, false, 'T', 'M');
	// 		}
	// 		else
	// 		{	
	// 			$this->SetFont('times', '', 8);
	// 			$this->Cell(180, 5, 'Head office:'.$this->address, 0, 1, 'C', 0, '', 0, false, 'T', 'M');
				
	// 		}
	// 		$this->SetFont('times', 'b', 8);
 //    		// Page number
 //    		$this->Cell(180, 5, 'Tel: '. $this->tel_no .' Fax:'. $this->fax.' E-mail: '. $this->email .' Website: http://www.gjepc.org' , 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			
			
	// 		if($this->email != "gjepc@vsnl.com"){
	// 			$this->SetFont('times', '', 8);
	// 			$this->Cell(180, 5, 'Head Office : Tower A, AW 1010, G Block, Bharat Diamond Bourse, Bandra-Kurla Complex, Bandra - East, Mumbai - 400 051', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
	// 			$this->Cell(180, 5, 'Tel: 91-22-26544600 , Email: gjepc@vsnl.com', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
	// 		}
	// }
}

if(isset($_REQUEST['registration_id']) && $_REQUEST['registration_id']!='')
{
		 $uid=$_REQUEST['registration_id'];
}
	
	$fetch_general_info="select * from igja_best_bank_financing_award where id='$registration_id' ";
	$result_general_info = $conn ->query($fetch_general_info);
	$rows_general_info = $result_general_info->fetch_assoc();

	//$date=date('d/m/Y',strtotime($rows['membership_issued_certificate_dt']));
	$date=date('d/m/Y',strtotime($rows_general_info['created_at']));
	$senior_management = unserialize($rows_general_info['senior_management']);
	$finance_details = unserialize($rows_general_info['finance_details']);
	$respondant_details = unserialize($rows_general_info['respondant_details']);
	$ca_details = unserialize($rows_general_info['ca_details']);
//	print_r($finance_details);exit;
	
    // echo "=----------".$rows_innovative['amount_of_r_n_d_expenditure']; print_r($amount_of_r_n_d_expenditure);exit;
    // echo "<pre>";print_r($senior_management); $senior_management['sm_title'][0];exit;
	$content='';

		$content.='
		<br>
		<br>
		<table style="margin:2% auto;font-size:13px">
		<tr>
    <td></td>
    <td align="right">Date : '.$date.'</td>
    </tr>
      <tr>
    
    <td align="center"  colspan="2" ><p style="color:blue;font-size:18px;"> General Information </p></td>
    </tr>
    <tr>
    
    <td colspan="2" >1. Basic Information</td>
    </tr>
    
    <tr>
	    <td  width="100%" colspan="2"> 
	   
		<table width="100%" border="1px" cellpadding="5px">
			<tbody>
			<tr>
			<td><strong>Company Name</strong></td>
			<td>'.$rows_general_info['bank_name'].'</td>
			</tr>
			<tr>
			<td><strong>Year of Establishment</strong></td>
			<td>'.$rows_general_info['year'].'</td>
			</tr>
			
			<tr>
			<td><strong>Tel No.:</strong></td>
			<td>'.$rows_general_info['tel_no'].'</td>
			</tr>
			<tr>
			<td><strong>Fax No.:</strong></td>
			<td>'.$rows_general_info['fax_no'].'</td>
			</tr>
			<tr>
			<td><strong>Email ID:</strong></td>
			<td>'.$rows_general_info['email_id'].'</td>
			</tr>
			<tr>
			<td><strong>Website:</strong></td>
			<td>'.$rows_general_info['website'].'</td>
			</tr>
			<tr>
			<td><strong>Address:</strong></td>
			<td>'.$rows_general_info['address_line_1'].'</td>
			</tr>
			<tr>
			<td><strong>Address Line 2 (optional):</strong></td>
			<td>'.$rows_general_info['address_line_2'].'</td>
			</tr>
			 <tr>
			<td><strong>City</strong></td>
			<td>'.$rows_general_info['city'].'</td>
			</tr>
			<tr>
			<td><strong>State</strong></td>
			<td>'.$rows_general_info['state'].'</td>
			</tr>
			<tr>
			<td><strong>Zipcode</strong></td>
			<td>'.$rows_general_info['zipcode'].'</td>
			</tr>
			
			
			<tr>
			<td><strong>Ownership Pattern</strong></td>

				<td>'.$rows_general_info['bank_type'].'</td>
			</tr>
			
			</tbody>
		</table>
		</td>
		
	</tr>
	<tr>
    <td colspan="2"><br></td>
    </tr>
	<tr>
    <td colspan="2">2. Senior Management </td>
    </tr>
    <tr>
	    <td colspan="2"> 
	   
		<table width="100%" border="1px" cellpadding="5px" >
			<thead>
			<tr>
			<th><strong>Title</strong></th>
			<th><strong>Name</strong></th>
			<th> <strong>Designation</strong></th>
			</tr>
			</thead>
			<tbody>
			<tr>
			<td>'.$senior_management['sm_title'][0].'</td>
			<td>'.$senior_management['sm_name'][0].'</td>
			<td>'.$senior_management['sm_designation'][0].'</td>
			
			</tr>
			<tr>
			<td>'.$senior_management['sm_title'][1].'</td>
			<td>'.$senior_management['sm_name'][1].'</td>
			<td>'.$senior_management['sm_designation'][1].'</td>
			
			</tr>
			<tr>
			<td>'.$senior_management['sm_title'][2].'</td>
			<td>'.$senior_management['sm_name'][2].'</td>
			<td>'.$senior_management['sm_designation'][2].'</td>
			
			</tr>
			</tbody>
		</table>
		</td>
		
	</tr>
	<tr>
    <td colspan="2"><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
    </tr>

	<tr>
    <td colspan="2">3. Financial Details </td>
    </tr>
    <tr>
	    <td colspan="2"> 
	   
		<table width="100%" border="1px" cellpadding="5px">
			<thead>
		    <tr>
			<th>Particular</th>
			<th>FY20</th>
			<th>FY19</th>
			<th>FY18</th>
			</tr>
			</thead>
			<tbody>
			<tr>
			
			<td>'.$finance_details['particular'][0].'</td>
			<td>'.$finance_details['FY20'][0].'</td>
			<td>'.$finance_details['FY19'][0].'</td>
			<td>'.$finance_details['FY18'][0].'</td>
			
			</tr>
			<tr>
			<td>'.$finance_details['particular'][1].'</td>
			<td>'.$finance_details['FY20'][1].'</td>
			<td>'.$finance_details['FY19'][1].'</td>
			<td>'.$finance_details['FY18'][1].'</td>
		
			</tr>
			<tr>
			<td>'.$finance_details['particular'][2].'</td>
			<td>'.$finance_details['FY20'][2].'</td>
			<td>'.$finance_details['FY19'][2].'</td>
			<td>'.$finance_details['FY18'][2].'</td>
			
			</tr>
			<tr>
			<td>'.$finance_details['particular'][3].'</td>
			<td>'.$finance_details['FY20'][3].'</td>
			<td>'.$finance_details['FY19'][3].'</td>
			<td>'.$finance_details['FY18'][3].'</td>
		
			</tr>
			<tr>
			<td>'.$finance_details['particular'][4].'</td>
			<td>'.$finance_details['FY20'][4].'</td>
			<td>'.$finance_details['FY19'][4].'</td>
			<td>'.$finance_details['FY18'][4].'</td>
			
			</tr>
			<tr>
			<td>'.$finance_details['particular'][5].'</td>
			<td>'.$finance_details['FY20'][5].'</td>
			<td>'.$finance_details['FY19'][5].'</td>
			<td>'.$finance_details['FY18'][5].'</td>
			</tr>
			<tr>
			<td>'.$finance_details['particular'][6].'</td>
			<td>'.$finance_details['FY20'][6].'</td>
			<td>'.$finance_details['FY19'][6].'</td>
			<td>'.$finance_details['FY18'][6].'</td>
			
			</tr>
			<tr>
			<td>'.$finance_details['particular'][7].'</td>
			<td>'.$finance_details['FY20'][7].'</td>
			<td>'.$finance_details['FY19'][7].'</td>
			<td>'.$finance_details['FY18'][7].'</td>
			</tr>
			<tr>
			<td>'.$finance_details['particular'][8].'</td>
			<td>'.$finance_details['FY20'][8].'</td>
			<td>'.$finance_details['FY19'][8].'</td>
			<td>'.$finance_details['FY18'][8].'</td>
	
			</tr>
			

			</tbody>
		</table>
		</td>
		
	</tr>
	
     <tr>
    <td colspan="2"><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br></td>
    </tr>
    
	
    <tr>
    	<td align="center"  colspan="2" ><p style="color:blue;font-size:18px;">Declaration</p></td>
    </tr>
    
    <tr>
        <td colspan="2">
        
        
        <p><strong>Name of the Respondent</strong> : '.$respondant_details['respondant_name'].'  </p>
	 
	    <p><strong>Designation</strong> : '.$respondant_details['designation'].' </p>
	 
	     <p><strong>Mobile</strong> : '.$respondant_details['mobile'].' </p>
	 
	    <p><strong>Email Id</strong> : '.$respondant_details['email_id'].'</p>
	    <p><strong>Declaration Date</strong> : '.$respondant_details['declaration_date'].'</p>
	 

	    </td>
	</tr>
	<tr>
        <p><strong>Chartered Accountant Declaration</strong></p>
    </tr>
    <tr>
        <td colspan="2">
        
        
        <p><strong>Name of the CA Firm</strong> : '.$ca_details['ca_firm_name'].' </p>
	 
	    <p><strong>Name of the individual</strong> : '.$ca_details['ca_name'].' </p>
	 
	     <p><strong>Designation</strong> : '.$ca_details['ca_designation'].' </p>
	 
	    <p><strong>Mobile</strong> : '.$ca_details['ca_mobile'].'</p>
	 
	    <p><strong>Email</strong> : '.$ca_details['ca_email'].' </p>
	    <p><strong>declaration date</strong> : '.$ca_details['ca_declaration_date'].' </p>
	 

	    </td>
	</tr>
	

</table>';


//echo $content;exit;
// create new PDF document
$pdf = new MYPDF($address, $reg_tel_no, $reg_email, $reg_fax, PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mukesh Singh');
$pdf->SetTitle('IGJA AWARDS FORM');
$pdf->SetSubject('Application form details');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
//$pdf->setAddress('test');

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
$pdf->SetFont('helvetica', '', 20);

// set some text to print
$txt = <<<EOD
$content
EOD;
// print a block of text using Write()

if($region_id=="HO-MUM (M)")
{
		
	$certificate = 'file://'.realpath('sslcertificate.crt');
	$info = array(
		'Name' => 'Mithilesh Pandey',
		'Location' => 'Mumbai',
		'Reason' => 'digital signature for rcmc',
		'ContactInfo' => 'mithilesh@gjepcindia.com',
		);
	$signature = 'images/digital-sign-1.jpg';
}


// set document signature
//$pdf->setSignature($certificate, $certificate, 'kwebmaker', '', 2, $info);

$pdf->writeHTML($txt, true, false, true, false, '');

$pdf->Image($signature, 15, 165, 65, 14, 'JPG');

// define active area for signature appearance
$pdf->setSignatureAppearance(15, 165, 65, 13);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('IGJA-bank-financing-'.$registration_id.'.pdf', 'D');

