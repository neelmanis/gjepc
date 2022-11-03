<?php
session_start();  
ob_start();
require_once('tcpdf_include.php'); 
require_once('../db.inc.php');
//require_once('../functions.php');

if(isset($_REQUEST['registration_id']) && $_REQUEST['registration_id']!='')
{
	$registration_id=$_REQUEST['registration_id'];
}else
{
	$registration_id=$_SESSION['USERID'];
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
	public function Footer() {
			
		// Position at 15 mm from bottom
    		$this->SetY(-72);
			$this->SetFont('times', '', 10);
			$this->Cell(180, 5, 'This certificate is digitally signed and does not require physical signature. ', 0, 0, 'C', 0, '', 0, false, 'T', 'M');
			$this->Ln();
    		// Set font 
    		$this->SetFont('times', 'B', 13);
    		// Page number
			$this->Cell(180, 6, '', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
    		$this->Cell(180, 6, 'The Gem & Jewellery Export Promotion Council ', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			
			$this->SetFont('times', '', 8);
			$this->Cell(180, 5, 'CIN U99100MH1966GAP013486', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			
			
    		// Page number
			if($this->email != "gjepc@vsnl.com")
			{
			$this->SetFont('times', 'B', 8);
			$this->Cell(180, 5, 'Regional Office:'.$this->address, 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			}
			else
			{	
				$this->SetFont('times', '', 8);
				$this->Cell(180, 5, 'Head office:'.$this->address, 0, 1, 'C', 0, '', 0, false, 'T', 'M');
				
			}
			$this->SetFont('times', 'b', 8);
    		// Page number
    		$this->Cell(180, 5, 'Tel: '. $this->tel_no .' Fax:'. $this->fax.' E-mail: '. $this->email .' Website: http://www.gjepc.org' , 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			
			
			if($this->email != "gjepc@vsnl.com"){
				$this->SetFont('times', '', 8);
				$this->Cell(180, 5, 'Head Office : Tower A, AW 1010, G Block, Bharat Diamond Bourse, Bandra-Kurla Complex, Bandra - East, Mumbai - 400 051', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
				$this->Cell(180, 5, 'Tel: 91-22-26544600 , Email: gjepc@vsnl.com', 0, 1, 'C', 0, '', 0, false, 'T', 'M');
			}
	}
}

function getRegionAddress($region_name,$conn)
{
	$query = "select region_address from region_master where region_name='$region_name'";
	$result = $conn->query($query);
	$row = $result->fetch_assoc();	
	return $row['region_address'];
}

function getRegionEmail($region_name,$conn)
{
	$query = "select region_email from region_master where region_name='$region_name'";	
	$result = $conn->query($query);
	$row = $result->fetch_assoc();
	return $row['region_email'];
}

function getRegionTelno($region_name,$conn)
{
	$query = "select region_tel_no from region_master where region_name='$region_name'";	
	$result = $conn->query($query);
	$row = $result->fetch_assoc();	
	return $row['region_tel_no'];
}

function getRegionFax($region_name,$conn)
{
	$query = "select region_fax from region_master where region_name='$region_name'";	
	$result = $conn->query($query);
	$row = $result->fetch_assoc();	
	return $row['region_fax'];
}

function getStateName($id,$conn)
{
	$query_sel = "SELECT state_name FROM  state_master  where state_code='$id'";
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc();	 		
	return $row['state_name'];
}

if(isset($_REQUEST['registration_id']) && $_REQUEST['registration_id']!='')
{
		 $uid=$_REQUEST['registration_id'];
}else{
		$uid=$_SESSION['USERID'];
}
	$year=2019;
	$fetch_data="select * from approval_master where registration_id='$registration_id' ";
	$fetch_user="select * from registration_master where id='$registration_id' ";
	$fetch_panel="select * from communication_details_master where registration_id='$registration_id'";
	$fetch_address ="select * from communication_address_master where registration_id='$registration_id' and type_of_address=2";
	$fetch_pin="select * from information_master where registration_id='$registration_id'";
	$fetch_transaction="select Transaction_Date from challan_master where registration_id='$registration_id' and challan_financial_year='$year'";
	
	$result = $conn ->query($fetch_data);
	$result_user = $conn ->query($fetch_user);
	$result_panel = $conn ->query($fetch_panel);
	$result_pin = $conn ->query($fetch_pin);
	$result_add = $conn ->query($fetch_address);
	$result_transaction = $conn ->query($fetch_transaction);
	
	if(!$result){	die ($conn->error);	exit;	}
	if(!$result_user){	die ($conn->error);	exit; }	
	if(!$result_add) {  die ($conn->error);	exit; }

	$rows = $result->fetch_assoc();
	$rows_user = $result_user->fetch_assoc(); 
	$rows_panel = $result_panel->fetch_assoc(); 
	$rows_pin = $result_pin->fetch_assoc(); 
	$rows_address = $result_add->fetch_assoc(); 
	$rows_transaction = $result_transaction->fetch_assoc(); 
	//$date=date('d/m/Y',strtotime($rows['membership_issued_certificate_dt']));
	$date=date('d/m/Y',strtotime($rows['invoice_date']));
	
	$company_name = strtoupper(str_replace('&amp;', '&', $rows_user['company_name']));
	
	$address_line1=$rows_address['address1'];
	$address_line1=strtoupper($address_line1);
	
	$address_line2=$rows_address['address2'];
	$address_line2=strtoupper($address_line2);
	
	$address_line3=$rows_address['address3'];
	$address_line3=strtoupper($address_line3);
	
	$city=$rows_address['city'];
	$city=strtoupper($city);
	
	$state=$rows_address['state'];
	$state_decode=$rows_address['state'];
	
	$state=strtoupper(getStateName($state,$conn));
	if($state == '')
		$state=strtoupper($state_decode);
	
	$country=$rows_address['country'];
	//$country=strtoupper(getCountryName($country));
	$pinCode = $rows_address['pincode'];
	$region_id = $rows_pin['region_id'];
	$address = getRegionAddress($region_id,$conn);
	
	$reg_tel_no = getRegionTelno($region_id,$conn);
	$reg_email = getRegionEmail($region_id,$conn);
	$reg_fax = getRegionFax($region_id,$conn);
		
	$panel_name=$rows_panel['panel_name'];
	$panel_name=strtoupper($panel_name);
		
	//$merchant_certificate_no=$rows['merchant_certificate_no'];
	$membership_certificate_type=$rows['membership_certificate_type'];
	if($membership_certificate_type=="ZASSOC")
	{
		$membership_certificate_type="ASSOCIATE";
	}
	if($membership_certificate_type=="ZORDIN")
	{
		$membership_certificate_type="ORDINARY";
	}
	$membership_ids=$rows['membership_id'];
	$signing_authority=$rows['signing_authority'];
	//$memID  = "GJEPC/1020/G14250/OM/IV";
	$hocode1 = ['/1010/','/1020/','/1030/', '/1040/', '/1050/','/1060/'];
	$ho1   = ['/HO-MUM (M)/','/RO-JAI/','/RO-SRT/', '/RO-CHE/', '/RO-DEL/','/RO-KOL/'];
	$membership_id = str_replace($hocode1, $ho1, $membership_ids);

	$membership_type=$rows['eligible_for_renewal'];
		
	/*if($membership_type=='Y')
		$print_date = $rows['membership_renewal_dt'];
	else
		$print_date = $rows['membership_issued_dt'];*/
		
		//echo $result_transaction['Transaction_Date']."===";

		$print_date = date('d/m/Y',strtotime($rows_transaction['Transaction_Date']));
		
		$showVotes = 0;
		$dateToday = date('Y-m-d');
		$renewalmonth = date('m',strtotime($rows_transaction['Transaction_Date']));
		if($renewalmonth == 4)
			$showVotes = 1;
		else
			$showVotes = 0;

	$content='';
	
	if(strtoupper($membership_certificate_type)=='ORDINARY' || strtoupper($membership_certificate_type)=='ZORDIN')
	{
		$content.='
		<br>
		<br>
		<table style="margin:2% auto;font-size:13px">
		<tr>
		<td>
    <table width="100%" border="0px">
    
     <tr>
    <td>Ref. No.: GJC/P/RNW/2019-2020</td>
    <td align="right">Date : '.$print_date.'</td>
    </tr>
    
    <tr>
    <td> </td>
    <td align="right"></td>
    </tr>
     
    <tr>
    <td align="left" colspan="2" style="text-align:left; font-size:12px; font-weight:bold;">'.
	$company_name.' <br />
       '.$address_line1.'<br />';
	   
	if($address_line2!='')   
	{
		$content.=$address_line2.'<br />';
	}
	
	if($address_line3!='')   
	{
		$content.=$address_line3.'<br />';
	}
       $content.=$city.': '.$pinCode.'<br />
        '.$state.'  
        </td>
    </tr>
    
     <tr>
    <td align="right" colspan="2" ></td>
    </tr>
    
     <tr>
    <td align="center" colspan="2" style="text-align:center; font-size:13px; font-weight:bold;"> ORDINARY MEMBERSHIP CERTIFICATE</td>
    </tr>
    
    <tr>
    <td colspan="2" ></td>
    </tr>
    
    <tr>
    <td align="center" colspan="2" style="text-align:center; font-size:13px; font-weight:bold;">Sub: Renewal as an '.$membership_certificate_type.' Member for the year 2019-2020 </td>
    </tr>
    
    <tr>
    <td colspan="2" style="font-size:12px;">
    
    <p>Dear Sir,</p>

<p>We acknowledge the receipt of your application dated '.$print_date.' for renewal of your membership for the year 2019-2020.

We have pleasure to inform you that your membership has been renewed as an '.$membership_certificate_type.' Member of the Council for the year 2019-2020.</p>

<p>Your '.$membership_certificate_type.' Membership Number is <b>'.$membership_id.'.</b></p>

<p>Your membership has been renewed under the <b>'.$panel_name.'</b> Panel ';

if($showVotes==1)
	$content.='for the purpose of exercising your voting rights etc.as provided under the Articles of Association of the Council';
	
$content.='
.</p>
<p>Yours truly,</p>   

</td>
    </tr>
    </table>
</td>
</tr>

</table>';
}
elseif((strtoupper($membership_certificate_type)=='ASSOCIATE' || strtoupper($membership_certificate_type)=='ZASSOC') && $membership_type!='Y')
{
		$content.='
		<br>
		<br>
		<table style="margin:2% auto;font-size:13px">

<tr>
<td>

    <table width="100%" border="0px" >
     <tr>
    <td>Ref. No.: GJC/P/FRM/2019-2020</td>
    <td align="right">Date : '.$print_date.'</td>
    </tr>
    
    <tr>
    <td> </td>
    <td align="right"></td>
    </tr>
    
    <tr>
    <td align="left" colspan="2" style="text-align:left; font-size:12px; font-weight:bold;">'.
	$company_name.' <br />
         '.$address_line1.'<br />';
	   
	if($address_line2!='')   
	{
		$content.=$address_line2.'<br />';
	}
	
	if($address_line3!='')   
	{
		$content.=$address_line3.'<br />';
	}
       $content.=$city.': '.$pinCode.'<br />
      '.$state.'  
        </td>
    </tr>
    
     <tr>
    <td align="right" colspan="2" ></td>
    </tr>
    
    <tr>
    <td align="center" colspan="2" style="text-align:center; font-size:13px; font-weight:bold;"> ASSOCIATE MEMBERSHIP CERTIFICATE</td>
    </tr>
    
    <tr>
    <td colspan="2" ></td>
    </tr>
    
    <tr>
    <td align="center" colspan="2" style="text-align:center; font-size:13px; font-weight:bold;">Sub: Enrollment as an '.$membership_certificate_type.' Member for the year 2019-2020</td>
    </tr>
    
    <tr>
    <td colspan="2" style="font-size:10px;">
    
    <p>Dear Sir,</p>

<p>We acknowledge receipt of your application dated '.$print_date.' for Enrollment as an '.$membership_certificate_type.' Member for the year 2019-2020.</p>

<p>We have pleasure to inform you that your membership has been enrolled as an '.$membership_certificate_type.' Member of the Council for the year 2019-2020.</p>

<p>Your '.$membership_certificate_type.' Membership Number is <b>'.$membership_id.'.</b></p>

<p>Your membership has been enrolled under the <b>'.$panel_name.'</b> Panel.</p>

<p style="text-align:justify">
With reference to the provisions of Article 5.3 of Memorandum & Article of Association of the Council,
this membership certificate and RCMC thereof are being issued provisionally, subject to approval of your
membership by Committee of Administration or its assigned Committee / authority of the Council. If you
do not receive any further communication within 3 (three) months from the date of your application for
membership with the Council, this membership and RCMC will be deemed to have been accepted by the
Council and you will be inducted as an associate member of the Council from the date of issue of
certificate.</p>
<p style="text-align:justify">You are requested to ensure submission of all the online forms along with the relevant supporting documents (duly signed by Proprietor/Partner/Director as the case may be) in the manner as prescribed by GJEPC, vide email on membership@gjepcindia.com.</p>
<p style="text-align:justify">Members are also requested to ensure dispatch of such original documents through post/courier to the respective to  Council’s offices within 15 days of the withdrawal of the lockdown by the Government or within 3 (three) months from the date of issuance of this certificate whichever is earlier. </p>
<p style="text-align:justify">In case of non- receipt of the original signed documents within the above-mentioned period, the Membership & RCMC will stand as cancelled.</p>
<p>Yours truly,</p>  

</td>
    </tr>
    </table>

</td>
</tr>

</table>';
}
elseif((strtoupper($membership_certificate_type)=='ASSOCIATE' || strtoupper($membership_certificate_type)=='ZASSOC') && $membership_type=='Y')	
{
	$content.='
	<br>
	<br><table style="margin:2% auto;font-size:13px">

	<tr>
	<td>
    <table width="100%" border="0px" >
    <tr>
    <td>Ref. No.: GJC/P/RNW/2019-2020</td>
    <td align="right">Date : '.$print_date.'</td>
    </tr>
    
    <tr>
    <td> </td>
    <td align="right"></td>
    </tr>
      
    <tr>
    <td align="left" colspan="2" style="text-align:left; font-size:12px; font-weight:bold;">'.
	$company_name.' <br />
          '.$address_line1.'<br />';
	   
	if($address_line2!='')   
	{
		$content.=$address_line2.'<br />';
	}
	
	if($address_line3!='')   
	{
		$content.=$address_line3.'<br />';
	}
       $content.=$city.': '.$pinCode.'<br />
     '.$state.'  
        </td>
    </tr>
    
     <tr>
    <td align="right" colspan="2" ></td>
    </tr>
    
    <tr>
    <td align="center" colspan="2" style="text-align:center; font-size:13px; font-weight:bold;"> ASSOCIATE MEMBERSHIP CERTIFICATE</td>
    </tr>
    
    <tr>
    <td colspan="2" ></td>
    </tr>    
    <tr>
    <td align="center" colspan="2" style="text-align:center; font-size:13px; font-weight:bold;">Sub: Renewal as an '.$membership_certificate_type.' Member for the year 2019-2020</td>
    </tr>    
    <tr>
    <td colspan="2" style="font-size:12px;">
    
<p>Dear Sir,</p>

<p>We acknowledge receipt of your application dated '.$print_date.' for Renewal as an '.$membership_certificate_type.' Member for the year 2019-2020.</p>
<p>We have pleasure to inform you that your membership has been renewed as an '.$membership_certificate_type.' Member of the Council for the year 2019-2020.</p>

<p>Your '.$membership_certificate_type.' Membership Number is <b>'.$membership_id.'.</b></p>

<p>Your membership has been renewed under the <b>'.$panel_name.'</b> Panel</p>

<p>Yours truly,</p>   

</td>
    </tr>
    </table>
</td>
</tr>

</table>';
}
else
{}
//echo $content;exit;
// create new PDF document
$pdf = new MYPDF($address, $reg_tel_no, $reg_email, $reg_fax, PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mukesh Singh');
$pdf->SetTitle('MEMBERSHIP CERTIFICATE');
$pdf->SetSubject('MEMBERSHIP CERTIFICATE');
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
elseif($region_id=="RO-DEL")
{
		if($signing_authority=="SU"){
		$certificate = 'file://'.realpath('suruchi_delhi.cer');
		$info = array(
			'Name' => 'SURUCHI KHINDRIA',
			'Location' => 'New Delhi',
			'Reason' => 'digital signature for rcmc',
			'ContactInfo' => 'suruchi.khindria@gjepcindia.com',
			);
		$signature = 'images/suruchiRCMC.jpg';
	} else {
			$certificate = 'file://'.realpath('KK_delhi.cer');
		$info = array(
			'Name' => 'K.K. Duggal',
			'Location' => 'New Delhi',
			'Reason' => 'digital signature for rcmc',
			'ContactInfo' => 'kkduggal@gjepcindia.com',
			);
		$signature = 'images/kkduggalRCMC.jpg';
	}
}
elseif($region_id=="RO-SRT")
{		
	$certificate = 'file://'.realpath('surat.crt');
	$info = array(
		'Name' => 'Jilpa Sheth',
		'Location' => 'Surat',
		'Reason' => 'digital signature for rcmc',
		'ContactInfo' => 'jilpa.sheth@gjepcindia.com',
		);
	$signature = 'images/jilpa.jpg';
}
elseif($region_id=="RO-JAI")
{	
	$certificate = 'file://'.realpath('jaipur.crt');
	$info = array(
		'Name' => 'Sanjay Singh',
		'Location' => 'Jaipur',
		'Reason' => 'digital signature for rcmc',
		'ContactInfo' => 'sanjaysingh@gjepcindia.com',
		);
	$signature = 'images/sanjay.jpg';
}
elseif($region_id=="RO-KOL")
{	
	$certificate = 'file://'.realpath('kol.crt');
	$info = array(
		'Name' => 'Sanjay Singh',
		'Location' => 'Kolkata',
		'Reason' => 'digital signature for rcmc',
		'ContactInfo' => 'sanjaysingh@gjepcindia.com',
		);
	$signature = 'images/sanjay_kol.jpg';
}
elseif($region_id=="RO-CHE")
{	
	$certificate = 'file://'.realpath('surya.crt');
	$info = array(
		'Name' => 'Surya Narayanan',
		'Location' => 'Chennai',
		'Reason' => 'digital signature for rcmc',
		'ContactInfo' => 'chennai@gjepcindia.com',
		);
	$signature = 'images/surya.jpg';
}
else
{}

// set document signature
$pdf->setSignature($certificate, $certificate, 'kwebmaker', '', 2, $info);

$pdf->writeHTML($txt, true, false, true, false, '');

if(strtoupper($membership_certificate_type)=='ASSOCIATE' || strtoupper($membership_certificate_type)=='ZASSOC' && $membership_type!='Y')
{
$pdf->Image($signature, 15, 200, 65, 30, 'JPG');

// define active area for signature appearance
$pdf->setSignatureAppearance(15, 195, 65, 13);

}
else
{	
$pdf->Image($signature, 15, 165, 65, 14, 'JPG');

// define active area for signature appearance
$pdf->setSignatureAppearance(15, 165, 65, 13);
}
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('acknowledge.pdf', 'I');

