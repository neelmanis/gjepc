<?php
session_start();  
ob_start();
require_once('rcmc/tcpdf_include.php'); 
require_once('db.inc.php');
//require_once('functions.php');

if(isset($_REQUEST['card_id']) && $_REQUEST['card_id']!='')
{
	$card_id=$_REQUEST['card_id'];
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
    		
	 }


}

if(isset($_REQUEST['card_id']) && $_REQUEST['card_id']!='')
{
		 $card_id=$_REQUEST['card_id'];
}
	
		
					$sqlx = "SELECT * FROM `parichay_person_details` WHERE `person_id`='$card_id' LIMIT 1";
					$resultx = $conn ->query($sqlx);
					$rowsX = $resultx->fetch_assoc();
					$registration_id = $rowsX['registration_id'];
					$sqly = "SELECT * FROM `parichay_card` WHERE `registration_id`='$registration_id' LIMIT 1";
					$resulty = $conn ->query($sqly);
					$rowsy = $resulty->fetch_assoc();
					$date = date("jS M y", strtotime($rowsX['post_date']));
                    $created_date = $rowsX['post_date'];

					$EndDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $created_date);
					$EndDateTime->modify('+10 years');
					$expiry =  date("jS M y", strtotime($EndDateTime->format('Y-m-d H:i:s')));


	
     // echo "=----------".$rows_innovative['amount_of_r_n_d_expenditure']; print_r($amount_of_r_n_d_expenditure);exit;

// echo "<pre>";print_r($senior_management); $senior_management['sm_title'][0];exit;
	$content='';
$content   .=   '<html><head>';
$content   .= '
<style>
.card {
        box-shadow: 0 8px 8px 10px rgba(87, 84, 84, 0.4);
        max-width: 250px;
        padding: 10px;
        margin: auto;
        text-align: center;
      }
@media (max-width:600px) {
header, footer {display:none;}
}
.custom-file-label::after {height:38px; padding:0; line-height:38px; width:60px; text-align:center;}
.parichay-card{
 background: #aca161;
 padding: 30px;
 border-radius:15px;
 height: 350px
}
.parichay-card-title{
 color: #fff;
 font-size: 21px
}
.parichay-card-title span{
    
    font-family: "eloquent-jf-pro";
    letter-spacing: 1px;

}
.parichay-card-footer p{
 color:#000;
 font-weight: 500;
 font-size: 14px;
 text-align: left;
}
.parichay-card-footer span{
    border-top: 1px solid#bbb1b1;
    display: block;
    margin-bottom: 3px;
}
.parichay-card-details p{
    font-weight: bold;
}
.parichay-card-right{
    position: relative;
}
.parichay-card-img img{
    border-radius: 5px
}
.parichay-card-details-backside p{
    font-size: 11px;
    line-height: 15px;
    margin-bottom: 7px;
}
td {
  padding-left: 15px;
  padding-right: 15px;
}
/*.parichay-card-right:after {
    content: "";
    position: absolute;
    left: 0px;
    top: 0;
    width: 18%;
    height: 150px;
    background: url(https://gjepc.org/assets/images/star_pattern.png) no-repeat;
    background-size: cover;
}*/
</style>';
$content   .=   '</head><body>';
$content.='

		
<table width="100%" border="0" >
    <tr>
        <td> <p class="blue">Welcome! <strong><'. $rowsX['fname'].' '.$rowsX['mname'].' '.$rowsX['surname'].' </strong></p></td>
    </tr>
    <tr>
        <td>
            <table class="parichay-card"  width="50%" >
                <tr >
                    <td colspan="3"> <br></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <h3 class="parichay-card-title">
                                            GEM & JEWELLERY <br>
                                            <span>PARICHAY CARD</span>
                         </h3>
                    </td>

                </tr>
                <tr >
                    <td colspan="3"> <br></td>
                </tr>
                <tr>
                    <td width="25%">Name</td>
                    <td width="45%"><p style="font-size: 13px">'. $rowsX['fname'].' '.$rowsX['mname'].' '.$rowsX['surname'].'</p></td>
                <td  rowspan="5" style="vertical-align: middle;" width="30">
                    <img src="images/parichay_card/person/photo/'.$rowsX['photo'].'" style="width: 100px"  /></td>
                </tr>
                <tr>
                    <td>Card No</td>
                    <td><p style="font-size: 13px">0000000</p></td>
                    
                </tr>
                <tr>
                    <td>Date of Birth</td>
                    <td><p style="font-size: 13px">'. $rowsX['date_of_birth'].'</td>
                    
                </tr>
                <tr>
                    <td>Blood Group</td>
                    <td><p style="font-size: 13px"> '. $rowsX['blood_group'].'</td>
                    
                </tr>
                <tr>
                    <td>Valid From</td>
                    <td><p style="font-size: 13px">'. $date.' TO '.$expiry.'</td>
                    
                </tr>
                <tr>
                    <td colspan="3"><br><br></td>
                </tr>
                <tr>
                    <td >
                        <hr>
                                                
                      <p >Colin Shah<br> GJEPC Chairman </p></td>
                      <td>
                        
                      </td>
                    <td >
                        <hr>
                                                    
                        <p> '.ucwords(strtolower($rowsy['association_head_name'])).',<br>'. ucwords(strtolower($rowsy['association_head_designation'])).'</p>
                    </td>
                </tr>
                  <tr>
                    <td colspan="3"><br></td>
                  </tr>
            </table>
        </td>
    </tr>
    <tr >
        <td><br></td>
    </tr>
    <tr>
        <td>
            <table class="parichay-card" width="50%" >
                <tr>
                    <td ><br></td>
                </tr>
                <tr>
                    <td>
                        <h3 class="parichay-card-title">
                                            GEM & JEWELLERY <br>
                                            <span>PARICHAY CARD</span>
                                        </h3>
                    </td>
                </tr>
                <tr>
                    <td><br></td>
                </tr>
                <tr>
                    <td class=" parichay-card-details-backside">
                        <p class="mb-2"><strong></strong></p>
                                            <p>This card is the property of The Gem & Jewellery Export Promotion Council (GJEPC) & the Local Association / Company / Individual. This is an identity card issued by GJEPC on the basis of documents information given by the card holder. </p>
                                            <p>GJEPC takes no responsibility for any inaccuracy of the information details of the card holder printed on this card. The holder of this card is not an employee or agent or servant of GJEPC and GJEPC takes no responsibility for any acts or omissions of this card.</p>
                                            <p>If found, please return to:</p>
                                            <p class="mt-2">The Gem & Jewellery Export Promotion Council
                                            Office No. AW 1010, Tower A, G Block, Bharat Diamond Bourse, Next to ICICI Bank, Bandra-Kurla Complex, Bandra - East, Mumbai - 400 051, India
                                            Tel : 91 22 26544600, Email : ho@gjepcindia.com, Web : www.gjepc.org
                                            </p>
                    </td>
                </tr>
                <tr>
                    <td ><br></td>
                </tr>
            </table>
            
        </td>
    </tr>
    
</table>';
$content   .=  '</body></html>';

//echo $content;exit;
// create new PDF document
$pdf = new MYPDF($address, $reg_tel_no, $reg_email, $reg_fax, PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Mukesh Singh');
$pdf->SetTitle('Parichay Card');
$pdf->SetSubject('Parichay Card');
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
$txt = <<<EOF
$content
EOF;
// print a block of text using Write()



// set document signature
//$pdf->setSignature($certificate, $certificate, 'kwebmaker', '', 2, $info);

$pdf->writeHTML($txt, true, false, true, false, '');



// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Parichay_card-'.$registration_id.'.pdf', 'I');

