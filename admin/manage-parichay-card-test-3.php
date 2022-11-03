<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('../db.inc.php');
include('../functions.php');
use Mpdf\Mpdf;
require_once('dompdf/autoload.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;
define("DOMPDF_ENABLE_REMOTE", false);
require_once('tcpdf/tcpdf.php');
require('vendor/autoload.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
		$adminID = intval(filter($_SESSION['curruser_login_id']));
$adminRegion = $_SESSION['curruser_region_id'];
$region = gotStatesName($adminRegion,$conn);

$adminRegionWiseAccess = rtrim($_SESSION['curruser_region_access'], ',');
$getRegionAccess = gotRegionwiseAccess($adminRegionWiseAccess,$conn);
		
$registration_id = intval(filter($_REQUEST['regid']));
		$orderId = filter($_REQUEST['orderId']);
			 $id = intval(filter($_REQUEST['id']));

function getCompanyNameFormRegistrationMaster($registration_id,$conn)
{
	$query_sel = "SELECT company_name FROM  registration_master  where id='$registration_id'";	
	$result = $conn->query($query_sel);
	$row = $result->fetch_assoc(); 		
	return $row['company_name'];
}			 
?>

<?php
$regsql = "select * from registration_master where id = '$registration_id'";
$regquery = $conn ->query($regsql);
while($regrow = $regquery->fetch_assoc())
{
$companyname = filter($regrow['company_name']);
  $email_id = filter($regrow['email_id']);
}
?>

<?php
if(($_REQUEST['action']=='update')&&($_REQUEST['id']!=''))
{	//echo '---';  print_r($_POST); exit;
	$person_id    = intval(filter($_REQUEST['id']));
	$fname  = filter(strtoupper($_REQUEST['fname']));
	$mname = filter(strtoupper($_REQUEST['mname']));
	$surname = filter(strtoupper($_REQUEST['surname']));
	$email = filter($_REQUEST['email_id']);
	$date_of_birth	=	date('Y-m-d',strtotime($_REQUEST['date_of_birth']));
	
	$agency_approval   = filter($_REQUEST['agency_approval']);
	$agency_remark = filter($_REQUEST['agency_remark']);
		
		 if($agency_approval == "Y"){ $agency_remark = ""; }
	else if($agency_approval == "P"){ $agency_remark = ""; }
	
	
	  $sqlx = "UPDATE `parichay_person_details` SET `admin_update_date`=NOW(),date_of_birth='$date_of_birth', `agency_approval`='$agency_approval', `agency_remark`='$agency_remark',adminId='$adminID',admin_update_date=NOW() WHERE person_id='$person_id' AND registration_id='$registration_id'";
	$resultx = $conn ->query($sqlx);
	
if($resultx)
{	
		/*.......................Send mail ........................*/
if($agency_approval=='Y')
{

$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
       <td align="left"><img src="https://registration.gjepc.org/images/mailer/gjepc_logo.png" /></td>
       <td></td>
       <td></td>
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>Parichay Card Karigar Application</u></strong></td></tr>
	<tr>
    <td align="left"  style="text-align:justify;"><strong>Company Name :</strong> '. $companyname .' </td>
    </tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table width="100%" style="border: 1px solid #ccc; border-collapse: separate; margin: 0; padding: 0; background: white; width: 100%; text-align:center; table-layout: fixed;">                
                <thead>
                  <tr style="background: #f8f8f8; border: 1px solid #ddd; padding:.35em;">
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54; height: 43px;">Name of Visitor</th>
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54; height: 43px;">Status </th>                                       
                  </tr>
                </thead>
                <tbody>
                  <tr style="background: #f8f8f8; border: 1px solid #ddd; padding: .35em;">
                    <td data-label="Pattern Name" style="padding: .625em; text-align: center; padding: 10px 20px;">'.$fname.' '.$mname.' '.$surname.'</td>
                    <td data-label="SIZE" style="padding: .625em; text-align: center; padding: 10px 20px;">Approved</td>                                       
                  </tr>
                </tbody>
              </table>
    </tr>
    <tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <p>
                <b>The Gem &amp; Jewellery Export Promotion Council</b><br>
                Unit G2-A, Trade Center, Opp. BKC Telephone Exchange, Bandra Kurla Complex, Bandra (E) Mumbai 400 051 <br> <b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br> Website: <a href="http://gjepc.org">http://gjepc.org/</a>
            </p>
        </td>
    </tr>       
</tbody>
</table>';

	$to =$email_id;	
	$subject = "YOUR KARIGAR APPLICATION FOR PARICHAY CARD APPROVED"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .= 'From:admin@gjepc.org';			
	mail($to, $subject, $message, $headers);
}
else if($agency_approval=='N') //Send mail For DisApproved
{

$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
       <td align="left"><img src="https://registration.gjepc.org/images/mailer/gjepc_logo.png" /></td>
       <td></td>
       <td></td>
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>Parichay Card Karigar Application</u></strong></td></tr>
	<tr>
    <td align="left"  style="text-align:justify;"><strong>Company Name :</strong> '. $companyname .' </td>
    </tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table style="border: 1px solid #ccc; border-collapse: separate; margin: 0; padding: 0; background: white; width: 100%; text-align:center; table-layout: fixed;">                
                <thead>
                  <tr style="background: #f8f8f8;border: 1px solid #ddd;padding: .35em;">
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">Name of Visitor</th>
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">Status </th>
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">Reason for Disapproval  </th>                                       
                  </tr>
                </thead>
                <tbody>
                  <tr style="background: #f8f8f8;border: 1px solid #ddd; padding: .35em;">
                    <td data-label="Pattern Name" style="padding: .625em;text-align: center; padding: 10px 20px;">'.$fname.' '.$mname.' '.$surname.'</td>
                    <td data-label="SIZE" style="padding: .625em;text-align: center; padding: 10px 20px;">Disapproved</td>
                    <td data-label="Star Rating" style="padding: .625em;text-align: center; padding: 10px 20px;">'.$disapprove_reason.'</td>                    
                  </tr>
                </tbody>
              </table>
    </tr>
    <tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <p>
                <b>The Gem &amp; Jewellery Export Promotion Council</b><br>
                Unit G2-A, Trade Center, Opp. BKC Telephone Exchange, Bandra Kurla Complex, Bandra (E) Mumbai 400 051 <br> <b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br> Website: <a href="http://gjepc.org/">http://gjepc.org/</a>
            </p>
        </td>
    </tr>       
</tbody>
</table>';

	$to = $email_id;
	$subject = "YOUR KARIGAR APPLICATION FOR PARICHAY CARD DISAPPROVED";
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .= 'From:admin@gjepc.org';			
	mail($to, $subject, $message, $headers);
}
/***  Emailer End **/
echo"<meta http-equiv=refresh content=\"0;url=manage-parichay-card.php?action=viewReg&regid=$registration_id\">";
}
}
?>
<!---------- Send mail to Authorised person's Email For Approval -->
<?php 
if(($_REQUEST['actions']=='compupdate')&&($_REQUEST['regid']!=''))
{	
	$comp_name = filter($_REQUEST['comp_name']);
	$authorised_email   = filter($_REQUEST['authorised_email']);
	$approval_status = filter($_REQUEST['approval_status']);
	$disapprove	=	filter($_REQUEST['disapprove']);
	$company_type = filter($_REQUEST['comp_type']);
	
	$getParichay_type = isApplied_for_parichay($registration_id,$conn); 
	
		 if($approval_status == "Y"){ $disapprove = ""; }
	else if($approval_status == "P"){ $disapprove = ""; }
	else if($approval_status == ""){ $disapprove = ""; }
	else { $approval_status = "D";}
	
	$sqlreg = "UPDATE `registration_master` SET company_type='$company_type' WHERE id='$registration_id'";
	$resultreg = $conn ->query($sqlreg);
	
	$updateStatus = "UPDATE `parichay_card` SET `admin_update_date`=NOW(),parichay_status='$approval_status',disapprove_reason='$disapprove',`adminId`='$adminID' WHERE registration_id='$registration_id'";
	$resultStatus = $conn ->query($updateStatus);
	
if($resultreg)
{	
		/*.......................Send mail For Approved........................*/
if($approval_status=='Y')
{
$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
       <td align="left"><img src="https://registration.gjepc.org/images/mailer/gjepc_logo.png" /></td>
       <td></td>
       <td></td>
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>Parichay Card Application</u></strong></td></tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table width="100%" style="border: 1px solid #ccc; border-collapse: separate; margin: 0; padding: 0; background: white; width: 100%; text-align:center; table-layout: fixed;">                
                <thead>
                  <tr style="background: #f8f8f8;border: 1px solid #ddd;padding: .35em;">
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54; height: 43px;">Company Name</th>
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54; height: 43px;">Status </th>                                       
                  </tr>
                </thead>
                <tbody>
                  <tr style="background: #f8f8f8; border: 1px solid #ddd; padding: .35em;">
                    <td data-label="Pattern Name" style="padding: .625em; text-align: center; padding: 10px 20px;">'.$comp_name.'</td>
                    <td data-label="SIZE" style="padding: .625em; text-align: center; padding: 10px 20px;">Approved</td>                                       
                  </tr>
                </tbody>
    </table>
    </tr>
	
	<tr>
	<td colspan="2"><br/>
	<p><strong>Share below links with your Karigar </strong> <br/>
	https://gjepc.org/add-karigar-person.php?type='.$getParichay_type.'&via=links&uid='.$registration_id.'</p>
	</td>
	</tr>
	
    <tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <p>
                <b>The Gem &amp; Jewellery Export Promotion Council</b><br>
                Unit G2-A, Trade Center, Opp. BKC Telephone Exchange, Bandra Kurla Complex, Bandra (E) Mumbai 400 051 <br> <b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br> Website: <a href="http://gjepc.org/iijs-virtual/">http://gjepc.org/iijs-virtual/</a>
            </p>
        </td>
    </tr>       
</tbody>
</table>';

	$to =$authorised_email;
	$subject = "YOUR Parichay Card Application is Approved"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .= 'From: GJEPC <admin@gjepc.org>';			
	mail($to, $subject, $message, $headers);
}
else if($approval_status=='D') //Send mail For DisApproved
{
$message='<table width="80%" bgcolor="#fbfbfb" align="center" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">
<tbody>
	<tr>
       <td align="left"><img src="https://registration.gjepc.org/images/mailer/gjepc_logo.png" /></td>
       <td></td>
       <td></td>
	</tr>
    <tr>
    	<td colspan="3" height="30"><hr></td>
    </tr>
	<tr><td align="center"><strong><u>Parichay Card Application</u></strong></td></tr>
    <tr>
    <td colspan="3" id="content">
	<br><span style="background-color: rgb(255, 255, 255);"><br></span>
	<table style="border: 1px solid #ccc; border-collapse: separate; margin: 0; padding: 0; background: white; width: 100%; text-align:center; table-layout: fixed;">                
                <thead>
                  <tr style="background: #f8f8f8;border: 1px solid #ddd;padding: .35em;">
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">Company Name</th>
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">Status </th>
                    <th scope="col" style="font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;">Reason for Disapproval  </th>                                       
                  </tr>
                </thead>
                <tbody>
                  <tr style="background: #f8f8f8;border: 1px solid #ddd;padding: .35em;">
                    <td data-label="Pattern Name" style="padding: .625em;text-align: center; padding: 10px 20px;">'.$comp_name.'</td>
                    <td data-label="SIZE" style="padding: .625em;text-align: center; padding: 10px 20px;">Disapproved</td>
                    <td data-label="Star Rating" style="padding: .625em;text-align: center; padding: 10px 20px;">'.$disapprove.'</td>                    
                  </tr>
                </tbody>
              </table>
    </tr>
    <tr>
	<td colspan="2"><br/>
	<p><strong>Regards</strong> <br/>
	GJEPC INDIA,</p>
	</td>
	</tr>	
    <tr>
        <td colspan="3" height="30"><hr></td>
    </tr>
    <tr>
        <td align="center" colspan="3">
            <p>
                <b>The Gem &amp; Jewellery Export Promotion Council</b><br>
                Unit G2-A, Trade Center, Opp. BKC Telephone Exchange, Bandra Kurla Complex, Bandra (E) Mumbai 400 051 <br> <b>Toll Free Number :</b> 1800-103-4353, <b>Missed Call Number :</b> +91-7208048100<br> Website: <a href="http://gjepc.org/iijs-virtual/">http://gjepc.org/iijs-virtual/</a>
            </p>
        </td>
    </tr>       
</tbody>
</table>';

	$to = $authorised_email;
	$subject  = "YOUR Parichay Card Application is Disapproved"; 
	$headers  = 'MIME-Version: 1.0' . "\n"; 
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	$headers .= 'From: GJEPC <admin@gjepc.org>';			
	mail($to, $subject, $message, $headers);
}
/***  Emailer End **/
echo"<meta http-equiv=refresh content=\"0;url=manage-parichay-card.php?action=view\">";
}
}
?>

<?php
if($_REQUEST['Reset']=="Reset")
{
  $_SESSION['company_name']="";
  $_SESSION['parichay_status']="";
  
  header("Location: manage-parichay-card.php?action=view");
} else
{
	$search_type=$_REQUEST['search_type'];
	if($search_type=="SEARCH")
	{ 
	$_SESSION['company_name']=	filter($_REQUEST['company_name']);
	$_SESSION['parichay_status'] = $_REQUEST['parichay_status'];
	}
}

if($_REQUEST['KReset']=="Reset")
{
  $_SESSION['f_name']="";  
  header("Location: manage-parichay-card.php?action=viewReg&regid=".$registration_id); exit;
} else
{
	$search_ktype=$_REQUEST['search_ktype'];
	if($search_ktype=="SEARCH")
	{ 
	$_SESSION['f_name']=	filter($_REQUEST['f_name']);
	}
}
?>


<?php
if($_REQUEST['company_action']=='ssave_document')
{
	//echo phpinfo();die();
  if(count($_POST['person_id']) <= 0) {
    $error .= "* Please select at least one Karigar";
  }

  $zip = new \ZipArchive(); // Load zip library 
  $tmp = 'pdf/';
  $zip_name = '/Karigar-pdf.zip';
  $person_id = $_POST['person_id'];
  $get_pdf   = '';
 	
  if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
  { 
  	echo "hii";die();
    //echo "zip error ";die();
  } else {

    //foreach($person_id as $i => $person_id){
      $sqlx = "SELECT * FROM `parichay_person_details` WHERE `person_id`='$person_id' LIMIT 1";
      $resultx = $conn ->query($sqlx);
      $rowsX = $resultx->fetch_assoc();
      if($rowsX['company_approval'] != "Y"){
        die();
	  }
      $registration_id = $rowsX['registration_id'];
      $sqly = "SELECT * FROM `parichay_card` WHERE `registration_id`= $registration_id LIMIT 1";
      $resulty = $conn ->query($sqly);
      $rowsy = $resulty->fetch_assoc();
      $date = date("jS M y", strtotime($rowsX['post_date']));
      $created_date = $rowsX['post_date'];
      $parichay_type = $rowsX['parichay_type'];
      if($parichay_type=="association"){ $class= "parichayCard_White"; } else { $class= "parichayCard"; }
      /*Generate Parichay Card Number*/
		$sql_reg="SELECT * FROM registration_master WHERE id='$registration_id'";
		$result_reg =$conn->query($sql_reg);
		$row_reg = $result_reg->fetch_assoc();
		$state = $row_reg['state'];
		$company_association_digits = $row_reg['parichay_series'];
		$region = trim(getRegionNameFromState($state,$conn));

		$sql_region_master = "SELECT parichay_series FROM region_master WHERE region_name='$region'";
		$result_region_master = $conn->query($sql_region_master);
		$row_region_master=$result_region_master->fetch_assoc();
		$region_digit =$row_region_master['parichay_series'];
		if($company_association_digits < 10){
			$company_association_digits = "00".$company_association_digits;
		}elseif($company_association_digits >=10 || $company_association_digits < 100){
			$company_association_digits = "0".$company_association_digits;
		}elseif( $company_association_digits >= 100){
			$company_association_digits = $company_association_digits;
		}
		$person_digits = $rowsX['person_series'];

		$card_no = $region_digit."-".$company_association_digits."-".$person_digits;
        $filename = $rowsX['fname'];
		$image = $rowsX['photo'];
		if($rowsX['photo'] == "" || $rowsX['photo'] == null){
			$photo = '';
		}else {
			$file_parts = pathinfo($image);
			if($file_parts['extension'] == "pdf")
			{
				//$imagick = new Imagick();
				//$pdf = $image;
				//$save = 'output.jpg';
			
				//$image = exec('convert "'.$pdf.'" -colorspace RGB -resize 800 "'.$save.'"', $output, $return_var);
				$photo = "<img src='https://gjepc.org/images/parichay_card/person/photo/$image' class='parichayPhoto'  alt=''>";
			} else {
				$photo = "<img src='https://gjepc.org/images/parichay_card/person/photo/$image' class='parichayPhoto'  alt=''>";
			}
			
		}
      $html = "<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title></title>

	<style>
		
	</style>
</head>
<body>

	<table cellpadding='5' cellspacing='0' class='goldParichay_card'>

		<tr>
			<td colspan='2' class='title'>Gem & Jewellery <div class='titleSpan'>Parichay Card </div> </td>
		</tr>

		<tr>
			<td>
				<table cellpadding='5' cellspacing='0'>
					<tr>
						<td>NAME</td>
						<td><strong>". $rowsX['fname'].' '.$rowsX['mname'].' '.$rowsX['surname']."</strong></td>
					</tr>
					<tr>
						<td>ID</td>
						<td>". $card_no ."</td>
					</tr>
					<tr>
						<td>D.O.B</td>
						<td><strong>". date("d-m-Y",strtotime($rowsX['date_of_birth']))."</strong></td>
					</tr>
					<tr>
						<td>BLOOD G</td>
						<td><strong>". $rowsX['blood_group']."</strong></td>
					</tr>
					<tr>
						<td>VALID FROM</td>
						<td><strong>". $date." TO ". $expiry."</strong></td>
					</tr>
				</table>
			</td>
			
			<td align='right' >$photo</td>
		</tr>

		<tr class=''>
			<td>COLIN SHAH <br> GJEPC <br> CHAIRMAN</td>
			<td class='text-right'>". strtoupper($rowsy['association_head_name'])." <br> ". getCompanyNameFormRegistrationMaster($rowsX['registration_id'],$conn) ." <br> ". strtoupper($rowsy['association_head_designation']) ."  </td>
		</tr>
		
	</table>

	<br> <br>

	<table cellpadding='5' class='goldParichay_card'>

		<tr>
			<td>GEM & JEWELLERY <span>PARICHAY CARD</span> </td>
			<td align='right'><img src='https://gjepc.org/assets/images/gjepcLogo_black.png' class='gjepcLogo' alt=''></td>
		</tr>

		<tr>
			<td colspan='2'><strong>". getCompanyNameFormRegistrationMaster($rowsX['registration_id'],$conn) ."</strong></td>
		</tr>

		<tr>
			<td colspan='2'>This card is the property of The Gem & Jewellery Export Promotion Council (GJEPC) & the Local Association / Company / Individual. This is an identity card issued by GJEPC on the basis of documents information given by the card holder.</td>
		</tr>

		<tr>
			<td colspan='2'>GJEPC takes no responsibility for any inaccuracy of the information details of the card holder printed on this card. The holder of this card is not an employee or agent or servant of GJEPC and GJEPC takes no responsibility for any acts or omissions of this card.</td>
		</tr>

		<tr>
			<td colspan='2'><strong>If found, please return the card to the Association / Company office.</strong></td>
		</tr>

		<tr>
			<td colspan='2'>Or call GJEPC Call Center: Toll Free Number: 1800-103-4353 | Missed Call Number: +91-7208048100</td>
		</tr>

		<tr>
			<td colspan='2'>You can also log on to GJEPC website for more details: https://www.gjepc.org/parichay-card.php</td>
		</tr>

		<tr>
			<td colspan='2'>TO VERIFY THE CARD, SMS PAR(LAST 7 DIGITS OF PARICHAY CARD NUMBER) TO +91 9223599301</td>
		</tr>
		
	</table>

</body>
</html>";
  
    //echo $html;die();
      $mpdf = new Mpdf();
      $stylesheet  = '';
      $stylesheet .= file_get_contents('../assets-new/css/parichay-font-custom.css');
      $mpdf->WriteHTML($stylesheet,1); 
      // Writing style to pdf
      $html1 =  html_entity_decode($html, ENT_QUOTES);
      $mpdf->allow_charset_conversion = true;
      $mpdf->WriteHTML($html1,2);
      $mpdf->showImageErrors = true;
      //$file = time().'.pdf'; 
      //$mpdf->Output($file, 'D');
	  ob_clean();
      //$mpdf->Output($filename.'.pdf', 'D');
	  chunk_split(base64_encode($mpdf->Output($filename.'.pdf', 'D')));
	  
      //$mpdf->Output($tmp.''.$filename.'.pdf', 'F');
      // ADD PDF FILE TO ZIP
      //$zip->addFile($tmp.'-'.$filename.'.pdf', $filename.'.pdf');
      //unset($mpdf);
      //unset($html);
      

      
   //}
    
    
  }
  // $zip->close();
  // ob_end_clean();
  // header('Content-Type: application/zip');
  // header('Content-disposition: attachment; filename='  .basename($zip_name));
  // header('Content-Length: ' . filesize($zip_name));
  // readfile($zip_name);
  // exit;
 

}  
?>
<?php 
if($_REQUEST['company_action']=='sssave_document')
{
	//echo phpinfo();die();
  if(count($_POST['person_id']) <= 0) {
    $error .= "* Please select at least one Karigar";
  }

  $zip = new \ZipArchive(); // Load zip library 
  $tmp = 'pdf/';
  $zip_name = '/Karigar-pdf.zip';
  $person_id = $_POST['person_id'];
  $get_pdf   = '';
 	
  if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
  { 
  	echo "hii";die();
    //echo "zip error ";die();
  } else {

    //foreach($person_id as $i => $person_id){
      $sqlx = "SELECT * FROM `parichay_person_details` WHERE `person_id`='$person_id' LIMIT 1";
      $resultx = $conn ->query($sqlx);
      $rowsX = $resultx->fetch_assoc();
      if($rowsX['company_approval'] != "Y"){
        die();
	  }
      $registration_id = $rowsX['registration_id'];
      $sqly = "SELECT * FROM `parichay_card` WHERE `registration_id`= $registration_id LIMIT 1";
      $resulty = $conn ->query($sqly);
      $rowsy = $resulty->fetch_assoc();
      $date = date("jS M y", strtotime($rowsX['post_date']));
      $created_date = $rowsX['post_date'];
      $parichay_type = $rowsX['parichay_type'];
      if($parichay_type=="association"){ $class= "parichayCard_White"; } else { $class= "parichayCard"; }
      /*Generate Parichay Card Number*/
		$sql_reg="SELECT * FROM registration_master WHERE id='$registration_id'";
		$result_reg =$conn->query($sql_reg);
		$row_reg = $result_reg->fetch_assoc();
		$state = $row_reg['state'];
		$company_association_digits = $row_reg['parichay_series'];
		$region = trim(getRegionNameFromState($state,$conn));

		$sql_region_master = "SELECT parichay_series FROM region_master WHERE region_name='$region'";
		$result_region_master = $conn->query($sql_region_master);
		$row_region_master=$result_region_master->fetch_assoc();
		$region_digit =$row_region_master['parichay_series'];
		if($company_association_digits < 10){
			$company_association_digits = "00".$company_association_digits;
		}elseif($company_association_digits >=10 || $company_association_digits < 100){
			$company_association_digits = "0".$company_association_digits;
		}elseif( $company_association_digits >= 100){
			$company_association_digits = $company_association_digits;
		}
		$person_digits = $rowsX['person_series'];

		$card_no = $region_digit."-".$company_association_digits."-".$person_digits;
        $filename = $rowsX['fname'];
		$image = $rowsX['photo'];
		if($rowsX['photo'] == "" || $rowsX['photo'] == null){
			$photo = '';
		}else {
			$file_parts = pathinfo($image);
			if($file_parts['extension'] == "pdf")
			{
				//$imagick = new Imagick();
				//$pdf = $image;
				//$save = 'output.jpg';
			
				//$image = exec('convert "'.$pdf.'" -colorspace RGB -resize 800 "'.$save.'"', $output, $return_var);
				$photo = "<img src='https://gjepc.org/images/parichay_card/person/photo/$image' class='parichayPhoto'  alt=''>";
			} else {
				$photo = "<img src='https://gjepc.org/images/parichay_card/person/photo/$image' class='parichayPhoto'  alt=''>";
			}
			
		}
      $html = "<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title></title>

	<style>
	/* cyrillic-ext */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4taVIGxA.woff2) format('woff2');
	  unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
	}
	/* cyrillic */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4kaVIGxA.woff2) format('woff2');
	  unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
	}
	/* greek-ext */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4saVIGxA.woff2) format('woff2');
	  unicode-range: U+1F00-1FFF;
	}
	/* greek */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4jaVIGxA.woff2) format('woff2');
	  unicode-range: U+0370-03FF;
	}
	/* hebrew */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4iaVIGxA.woff2) format('woff2');
	  unicode-range: U+0590-05FF, U+200C-2010, U+20AA, U+25CC, U+FB1D-FB4F;
	}
	/* vietnamese */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4vaVIGxA.woff2) format('woff2');
	  unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
	}
	/* latin-ext */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4uaVIGxA.woff2) format('woff2');
	  unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
	}
	/* latin */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4gaVI.woff2) format('woff2');
	  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
	}
	
	body {font-family: 'Open Sans', sans-serif;}
			.goldParichay_card {background: #b8ad6f; width:600px; margin: 0 auto; border-radius: 15px; padding: 10px; font-size: 14px;}
			.parichayPhoto {width:100px}
			.text-right {text-align: right;}
			.title {color:#fff; background: url(https://gjepc.org/assets/images/cardPattern.png) no-repeat center right; font-size: 30px;}
			.titleSpan {display: block; font-weight: bold;}
			.gjepcLogo {width: 100px; display: table; margin-left: auto}
	</style>
</head>
<body>

	<table cellpadding='5' cellspacing='0' class='goldParichay_card'>

		<tr>
			<td colspan='2' class='title'>Gem & Jewellery <div class='titleSpan'>Parichay Card </div> </td>
		</tr>

		<tr>
			<td>
				<table cellpadding='5' cellspacing='0'>
					<tr>
						<td>NAME</td>
						<td><strong>". $rowsX['fname'].' '.$rowsX['mname'].' '.$rowsX['surname']."</strong></td>
					</tr>
					<tr>
						<td>ID</td>
						<td>". $card_no ."</td>
					</tr>
					<tr>
						<td>D.O.B</td>
						<td><strong>". date("d-m-Y",strtotime($rowsX['date_of_birth']))."</strong></td>
					</tr>
					<tr>
						<td>BLOOD G</td>
						<td><strong>". $rowsX['blood_group']."</strong></td>
					</tr>
					<tr>
						<td>VALID FROM</td>
						<td><strong>". $date." TO ". $expiry."</strong></td>
					</tr>
				</table>
			</td>
			
			<td align='right' >$photo</td>
		</tr>

		<tr class=''>
			<td>COLIN SHAH <br> GJEPC <br> CHAIRMAN</td>
			<td class='text-right'>". strtoupper($rowsy['association_head_name'])." <br> ". getCompanyNameFormRegistrationMaster($rowsX['registration_id'],$conn) ." <br> ". strtoupper($rowsy['association_head_designation']) ."  </td>
		</tr>
		
	</table>

	<br> <br>

	<table cellpadding='5' class='goldParichay_card'>

		<tr>
			<td>GEM & JEWELLERY <span>PARICHAY CARD</span> </td>
			<td align='right'><img src='https://gjepc.org/assets/images/gjepcLogo_black.png' class='gjepcLogo' alt=''></td>
		</tr>

		<tr>
			<td colspan='2'><strong>". getCompanyNameFormRegistrationMaster($rowsX['registration_id'],$conn) ."</strong></td>
		</tr>

		<tr>
			<td colspan='2'>This card is the property of The Gem & Jewellery Export Promotion Council (GJEPC) & the Local Association / Company / Individual. This is an identity card issued by GJEPC on the basis of documents information given by the card holder.</td>
		</tr>

		<tr>
			<td colspan='2'>GJEPC takes no responsibility for any inaccuracy of the information details of the card holder printed on this card. The holder of this card is not an employee or agent or servant of GJEPC and GJEPC takes no responsibility for any acts or omissions of this card.</td>
		</tr>

		<tr>
			<td colspan='2'><strong>If found, please return the card to the Association / Company office.</strong></td>
		</tr>

		<tr>
			<td colspan='2'>Or call GJEPC Call Center: Toll Free Number: 1800-103-4353 | Missed Call Number: +91-7208048100</td>
		</tr>

		<tr>
			<td colspan='2'>You can also log on to GJEPC website for more details: https://www.gjepc.org/parichay-card.php</td>
		</tr>

		<tr>
			<td colspan='2'>TO VERIFY THE CARD, SMS PAR(LAST 7 DIGITS OF PARICHAY CARD NUMBER) TO +91 9223599301</td>
		</tr>
		
	</table>

</body>
</html>";

//$html .= '<style>'.file_get_contents('../assets-new/css/parichay-font-custom.css').'</style>';
    //echo $html;die();
	  $obj_pdf = new TCPDF('P', 'pt',  'PDF_PAGE_FORMAT' , true, 'UTF-8', false);
      $stylesheet  = '';
      //$stylesheet .= file_get_contents('../assets-new/css/parichay-font-custom.css');
	  
      $obj_pdf->WriteHTML($stylesheet,1); 
      // Writing style to pdf
     // $html1 =  html_entity_decode($html, ENT_QUOTES);
      //$mpdf->allow_charset_conversion = true;\
	  $obj_pdf->AddPage();
      $obj_pdf->WriteHTML($html,true, false , true, false, "F");
      //$mpdf->showImageErrors = true;
      //$file = time().'.pdf'; 
      //$mpdf->Output($file, 'D');
	  ob_clean();
	  //echo $_SERVER['DOCUMENT_ROOT'];die();
      //$obj_pdf->Output($filename.'.pdf', 'D');
	  //chunk_split(base64_encode($obj_pdf->Output($filename.'.pdf', 'D')));
	  
      $obj_pdf->Output($_SERVER['DOCUMENT_ROOT'].'/admin/pdf/'.'-'.$filename.'.pdf', 'F');
      // ADD PDF FILE TO ZIP
      $zip->addFile($_SERVER['DOCUMENT_ROOT'].'/admin/pdf/'.'-'.$filename.'.pdf', $filename.'.pdf');
      //unset($mpdf);
      //unset($html);
      

      
   //}
    
    
  }
  $zip->close();
  //ob_end_clean();
  //flush();
  header('Content-Type: application/zip');
  header('Content-disposition: attachment; filename='  .basename($zip_name));
  header('Content-Length: ' . filesize($zip_name));
  readfile($zip_name);
  exit;
 

}  

?>

<?php
if($_REQUEST['company_action']=='save_document')
{
	//echo phpinfo();die();
  if(count($_POST['person_id']) <= 0) {
    $error .= "* Please select at least one Karigar";
  }

  $zip = new \ZipArchive(); // Load zip library 
  $tmp = 'parichay_card_pdf/';
  $zip_name = '/Karigar-pdf.zip';
  $person_id = $_POST['person_id'];
  $get_pdf   = '';
 	$html = '';
  if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
  { 
  	//echo "hii";die();
    echo "zip error ";die();
  } else {

    foreach($person_id as $i => $person_id){
      $sqlx = "SELECT * FROM `parichay_person_details` WHERE `person_id`='$person_id' LIMIT 1";
      $resultx = $conn ->query($sqlx);
      $rowsX = $resultx->fetch_assoc();
	    if($rowsX['company_approval'] != "Y"){
	        die();
		}
      $registration_id = $rowsX['registration_id'];
      $sqly = "SELECT * FROM `parichay_card` WHERE `registration_id`= $registration_id LIMIT 1";
      $resulty = $conn ->query($sqly);
      $rowsy = $resulty->fetch_assoc();
      $date = date("jS M y", strtotime($rowsX['post_date']));
      $created_date = $rowsX['post_date'];
      $parichay_type = $rowsX['parichay_type'];
      if($parichay_type=="association"){ $class= "parichayCard_White"; } else { $class= "parichayCard"; }
      /*Generate Parichay Card Number*/
		$sql_reg="SELECT * FROM registration_master WHERE id='$registration_id'";
		$result_reg =$conn->query($sql_reg);
		$row_reg = $result_reg->fetch_assoc();
		$state = $row_reg['state'];
		$company_association_digits = $row_reg['parichay_series'];
		$region = trim(getRegionNameFromState($state,$conn));

		$sql_region_master = "SELECT parichay_series FROM region_master WHERE region_name='$region'";
		$result_region_master = $conn->query($sql_region_master);
		$row_region_master=$result_region_master->fetch_assoc();
		$region_digit =$row_region_master['parichay_series'];
		if($company_association_digits < 10){
			$company_association_digits = "00".$company_association_digits;
		}elseif($company_association_digits >=10 || $company_association_digits < 100){
			$company_association_digits = "0".$company_association_digits;
		}elseif( $company_association_digits >= 100){
			$company_association_digits = $company_association_digits;
		}
		$person_digits = $rowsX['person_series'];

		$card_no = $region_digit."-".$company_association_digits."-".$person_digits;
        $filename = $rowsX['fname'];
        $image = $rowsX['photo'];

		if($rowsX['photo'] == "" || $rowsX['photo'] == null){
			$photo = '';
		}else {
			$photo = "https://gjepc.org/images/parichay_card/person/photo/$image";
			//$photo = $_SERVER['DOCUMENT_ROOT'].'/'."gjepc/images/parichay_card/person/photo/$image";
		}
		//$gjepc_image = $_SERVER['DOCUMENT_ROOT'].'/'."gjepc/assets/images/gjepcLogo_black.png";
		$gjepc_image = "https://gjepc.org/assets/images/gjepcLogo_black.png";
		//echo $photo;die();
      $html = "<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8'>
	<meta name='viewport' content='width=device-width, initial-scale=1'>
	<title></title>

	<style>
	@import url('https://p.typekit.net/p.css?s=1&k=gwk8rom&ht=tk&f=28155.28158.28167.28175&a=18300888&app=typekit&e=css');@font-face{font-family:eloquent-jf-small-caps-pro;src:url('https://use.typekit.net/af/d5c128/00000000000000003b9ada7d/27/l?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('woff2'),url('https://use.typekit.net/af/d5c128/00000000000000003b9ada7d/27/d?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('woff'),url('https://use.typekit.net/af/d5c128/00000000000000003b9ada7d/27/a?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('opentype');font-display:auto;font-style:normal;font-weight:400}@font-face{font-family:eloquent-jf-small-caps-pro;src:url('https://use.typekit.net/af/ad5756/00000000000000003b9ada80/27/l?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=i4&v=3') format('woff2'),url('https://use.typekit.net/af/ad5756/00000000000000003b9ada80/27/d?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=i4&v=3') format('woff'),url('https://use.typekit.net/af/ad5756/00000000000000003b9ada80/27/a?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=i4&v=3') format('opentype');font-display:auto;font-style:italic;font-weight:400}@font-face{font-family:eloquent-jf-pro;src:url('https://use.typekit.net/af/51a7cb/00000000000000003b9ada89/27/l?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('woff2'),url('https://use.typekit.net/af/51a7cb/00000000000000003b9ada89/27/d?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('woff'),url('https://use.typekit.net/af/51a7cb/00000000000000003b9ada89/27/a?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('opentype');font-display:auto;font-style:normal;font-weight:400}@font-face{font-family:eloquent-jf-pro;src:url('https://use.typekit.net/af/6d1a40/00000000000000003b9ada91/27/l?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=i4&v=3') format('woff2'),url('https://use.typekit.net/af/6d1a40/00000000000000003b9ada91/27/d?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=i4&v=3') format('woff'),url('https://use.typekit.net/af/6d1a40/00000000000000003b9ada91/27/a?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=i4&v=3') format('opentype');font-display:auto;font-style:italic;font-weight:400}.tk-eloquent-jf-small-caps-pro{font-family:eloquent-jf-small-caps-pro,serif}.tk-eloquent-jf-pro{font-family:eloquent-jf-pro,serif}/*! Generated by Font Squirrel (https://www.fontsquirrel.com) on April 24, 2020 */@font-face{font-family:gotham_htfblack;src:url('../assets/../fonts/gotham_htf_black-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_black-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gotham_htfbold_2;src:url('../assets/../fonts/gotham_htf_bold_2-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_bold_2-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gotham_htfbook_italic;src:url('../assets/../fonts/gotham_htf_book_italic-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_book_italic-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gothamhtf-bookregular;src:url('../assets/../fonts/gotham_htf_book-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_book-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gotham_htflight;src:url('../assets/../fonts/gotham_htf_light-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_light-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gotham_htfmedium_2;src:url('../assets/../fonts/gotham_htf_medium_2-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_medium_2-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gotham_htfmedium_italic;src:url('../assets/../fonts/gotham_htf_medium_italic-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_medium_italic-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gotham_htfextrabold_italic;src:url('../assets/../fonts/gotham_htf_ultra_italic-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_ultra_italic-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gotham_htfextrabold;src:url('../assets/../fonts/gotham_htf_ultra-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_ultra-webfont.woff') format('woff');font-weight:400;font-style:normal}@import url(https://p.typekit.net/p.css?s=1&k=gwk8rom&ht=tk&f=28155.28158.28167.28175&a=18300888&app=typekit&e=css);@font-face{font-family:eloquent-jf-small-caps-pro;src:url('https://use.typekit.net/af/d5c128/00000000000000003b9ada7d/27/l?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('woff2'),url('https://use.typekit.net/af/d5c128/00000000000000003b9ada7d/27/d?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('woff'),url('https://use.typekit.net/af/d5c128/00000000000000003b9ada7d/27/a?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('opentype');font-display:auto;font-style:normal;font-weight:400}@font-face{font-family:eloquent-jf-small-caps-pro;src:url('https://use.typekit.net/af/ad5756/00000000000000003b9ada80/27/l?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=i4&v=3') format('woff2'),url('https://use.typekit.net/af/ad5756/00000000000000003b9ada80/27/d?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=i4&v=3') format('woff'),url('https://use.typekit.net/af/ad5756/00000000000000003b9ada80/27/a?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=i4&v=3') format('opentype');font-display:auto;font-style:italic;font-weight:400}@font-face{font-family:eloquent-jf-pro;src:url('https://use.typekit.net/af/51a7cb/00000000000000003b9ada89/27/l?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('woff2'),url('https://use.typekit.net/af/51a7cb/00000000000000003b9ada89/27/d?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('woff'),url('https://use.typekit.net/af/51a7cb/00000000000000003b9ada89/27/a?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=n4&v=3') format('opentype');font-display:auto;font-style:normal;font-weight:400}@font-face{font-family:eloquent-jf-pro;src:url('https://use.typekit.net/af/6d1a40/00000000000000003b9ada91/27/l?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=i4&v=3') format('woff2'),url('https://use.typekit.net/af/6d1a40/00000000000000003b9ada91/27/d?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=i4&v=3') format('woff'),url('https://use.typekit.net/af/6d1a40/00000000000000003b9ada91/27/a?primer=7cdcb44be4a7db8877ffa5c0007b8dd865b3bbc383831fe2ea177f62257a9191&fvd=i4&v=3') format('opentype');font-display:auto;font-style:italic;font-weight:400}.tk-eloquent-jf-small-caps-pro{font-family:eloquent-jf-small-caps-pro,serif}.tk-eloquent-jf-pro{font-family:eloquent-jf-pro,serif}/*! Generated by Font Squirrel (https://www.fontsquirrel.com) on April 24, 2020 */@font-face{font-family:gotham_htfblack;src:url('../assets/../fonts/gotham_htf_black-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_black-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gotham_htfbold_2;src:url('../assets/../fonts/gotham_htf_bold_2-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_bold_2-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gotham_htfbook_italic;src:url('../assets/../fonts/gotham_htf_book_italic-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_book_italic-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gothamhtf-bookregular;src:url('../assets/../fonts/gotham_htf_book-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_book-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gotham_htflight;src:url('../assets/../fonts/gotham_htf_light-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_light-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gotham_htfmedium_2;src:url('../assets/../fonts/gotham_htf_medium_2-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_medium_2-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gotham_htfmedium_italic;src:url('../assets/../fonts/gotham_htf_medium_italic-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_medium_italic-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gotham_htfextrabold_italic;src:url('../assets/../fonts/gotham_htf_ultra_italic-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_ultra_italic-webfont.woff') format('woff');font-weight:400;font-style:normal}@font-face{font-family:gotham_htfextrabold;src:url('../assets/../fonts/gotham_htf_ultra-webfont.woff2') format('woff2'),url('../assets/../fonts/gotham_htf_ultra-webfont.woff') format('woff');font-weight:400;font-style:normal}
		/* cyrillic-ext */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4taVIGxA.woff2) format('woff2');
	  unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
	}
	/* cyrillic */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4kaVIGxA.woff2) format('woff2');
	  unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
	}
	/* greek-ext */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4saVIGxA.woff2) format('woff2');
	  unicode-range: U+1F00-1FFF;
	}
	/* greek */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4jaVIGxA.woff2) format('woff2');
	  unicode-range: U+0370-03FF;
	}
	/* hebrew */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4iaVIGxA.woff2) format('woff2');
	  unicode-range: U+0590-05FF, U+200C-2010, U+20AA, U+25CC, U+FB1D-FB4F;
	}
	/* vietnamese */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4vaVIGxA.woff2) format('woff2');
	  unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
	}
	/* latin-ext */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4uaVIGxA.woff2) format('woff2');
	  unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
	}
	/* latin */
	@font-face {
	  font-family: 'Open Sans';
	  font-style: normal;
	  font-weight: 400;
	  font-stretch: 100%;
	  font-display: swap;
	  src: url(https://fonts.gstatic.com/s/opensans/v28/memSYaGs126MiZpBA-UvWbX2vVnXBbObj2OVZyOOSr4dVJWUgsjZ0B4gaVI.woff2) format('woff2');
	  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
	}
	
	body {font-family: 'Open Sans', sans-serif;}
			.goldParichay_card {background: #b8ad6f; width:600px; margin: 0 auto; border-radius: 15px; padding: 10px; font-size: 14px;}
			.parichayPhoto {width:100px}
			.text-right {text-align: right;}
			.title {color:#fff; background: url(https://gjepc.org/assets/images/cardPattern.png) no-repeat center right; font-size: 30px;}
			.titleSpan {display: block; font-weight: bold;}
			.gjepcLogo {width: 100px; display: table; margin-left: auto}
			.cardHead_2 {color: #fff;text-transform: uppercase;font-size: 14px;line-height: 20px;}
	</style>
</head>
<body>

	<table cellpadding='5' cellspacing='0' class='goldParichay_card'>

		<tr>
			<td colspan='2' class='title'>Gem & Jewellery <div class='titleSpan'>Parichay Card </div> </td>
		</tr>

		<tr>
			<td>
				<table cellpadding='5' cellspacing='0'>
					<tr>
						<td>NAME</td>
						<td><strong>". $rowsX['fname'].' '.$rowsX['mname'].' '.$rowsX['surname']."</strong></td>
					</tr>
					<tr>
						<td>ID</td>
						<td>". $card_no ."</td>
					</tr>
					<tr>
						<td>D.O.B</td>
						<td><strong>". date("d-m-Y",strtotime($rowsX['date_of_birth']))."</strong></td>
					</tr>
					<tr>
						<td>BLOOD G</td>
						<td><strong>". $rowsX['blood_group']."</strong></td>
					</tr>
					<tr>
						<td>VALID FROM</td>
						<td><strong>". $date." TO ". $expiry."</strong></td>
					</tr>
				</table>
			</td>

			<td align='right' ><img src='".$photo."' class='parichayPhoto' alt=''></td>
		</tr>

		<tr class=''>
			<td>COLIN SHAH <br> GJEPC <br> CHAIRMAN</td>
			<td class='text-right'>". strtoupper($rowsy['association_head_name'])." <br> ". getCompanyNameFormRegistrationMaster($rowsX['registration_id'],$conn) ." <br> ". strtoupper($rowsy['association_head_designation']) ."  </td>
		</tr>
		
	</table>

	<br> <br>

	<table cellpadding='5' class='goldParichay_card'>

		<tr>
			<td class='cardHead_2 mb-2'>GEM & JEWELLERY <span>PARICHAY CARD</span> </td>
			<td align='right'><img src='".$gjepc_image."' alt='' style='width: 130px;'></td>
		</tr>

		<tr>
			<td colspan='2'><strong>". getCompanyNameFormRegistrationMaster($rowsX['registration_id'],$conn) ."</strong></td>
		</tr>

		<tr>
			<td colspan='2'>This card is the property of The Gem & Jewellery Export Promotion Council (GJEPC) & the Local Association / Company / Individual. This is an identity card issued by GJEPC on the basis of documents information given by the card holder.</td>
		</tr>

		<tr>
			<td colspan='2'>GJEPC takes no responsibility for any inaccuracy of the information details of the card holder printed on this card. The holder of this card is not an employee or agent or servant of GJEPC and GJEPC takes no responsibility for any acts or omissions of this card.</td>
		</tr>

		<tr>
			<td colspan='2'><strong>If found, please return the card to the Association / Company office.</strong></td>
		</tr>

		<tr>
			<td colspan='2'>Or call GJEPC Call Center: Toll Free Number: 1800-103-4353 | Missed Call Number: +91-7208048100</td>
		</tr>

		<tr>
			<td colspan='2'>You can also log on to GJEPC website for more details: https://www.gjepc.org/parichay-card.php</td>
		</tr>

		<tr>
			<td colspan='2'>TO VERIFY THE CARD, SMS PAR(LAST 7 DIGITS OF PARICHAY CARD NUMBER) TO +91 9223599301</td>
		</tr>
		
	</table>

</body>
</html>";
  //echo $html;die();
		ob_get_clean();
		$options = new Options();
		$options->set('isRemoteEnabled', true);
		$dompdf = new DOMPDF($options);
	
		$dompdf->loadHtml($html);
		//$dompdf->setPaper('A4', 'landscape');
		$dompdf->render();
		
		//$dompdf->stream($filename, array("Attachment" => 1));
		file_put_contents($_SERVER['DOCUMENT_ROOT'].'/admin/parichay_card_pdf/'.'-'.$filename.'.pdf', $dompdf->output()); 
		//ADD PDF FILE TO ZIP
        //$zip->addFile($_SERVER['DOCUMENT_ROOT'].'/admin/pdf/'.'-'.$filename.'.pdf', $filename.'.pdf');
        $filePath = $_SERVER['DOCUMENT_ROOT'].'/admin/parichay_card_pdf/'.'-'.$filename.'.pdf';
        //echo $filePath;die();
		// if (file_exists($filePath)) {
		// 	  $zip->close();
		// 	  //ob_end_clean();
		// 	header('Content-Type: application/zip');
		// 	header('Content-Length: ' . filesize($zip_name));
		
		// 	// download zip
		// 	readfile($zip_name);
			
		// 	// delete after download
		// 	//unlink($filename);
		// }
    }
    
    
  }
 
    $file_array = array();
  foreach($_POST['person_id'] as $i => $person_id){
	$sqlx = "SELECT * FROM `parichay_person_details` WHERE `person_id`='$person_id' LIMIT 1";
	$resultx = $conn ->query($sqlx);
	$rowsX = $resultx->fetch_assoc();
	$filename = $rowsX['fname'];
	 $filePath = 'https://gjepc.org/admin/parichay_card_pdf/'.'-'.$filename.'.pdf';
	 
	 array_push($file_array, $filePath);
	 
	 if (file_exists($filePath)) {
		
	}
  }

  $array = http_build_query(array($file_array));
  header("location:pdf_test.php?".$array);
  	
  // $zip->close();
  // ob_end_clean();
  // header('Content-Type: application/zip');
  // header('Content-disposition: attachment; filename='  .basename($zip_name));
  // header('Content-Length: ' . filesize($zip_name));
  // readfile($zip_name);
  exit;
 

}  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manage Parichay Card</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<!--navigation-->
<script type="text/javascript" src="fancybox/jquery-3.3.1.js"></script> 
<script type="text/javascript" src="fancybox/fancybox_js.js"></script>
<script type="text/javascript">		
$("div.fancyDemo a").fancybox();
</script>     
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<script type="text/javascript" src="js/ddsmoothmenu.js"></script>
<!--navigation end-->
<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script> 
<link href="css/jquery.datepick.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {
	$('#date_of_birth').datepick();	
});
</script>

<!-- lightbox Thum -->
<link rel="stylesheet" type="text/css" href="fancybox/fancybox_css.css" media="screen" />
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
</script>
<!-- lightbox Thum -->

<script>
$(document).ready(function(){


$('#disapprove').click(function(){
//alert('disapprove');
		$('#disapproval').show();
      });
	  $('#approve').click(function(){
//alert('disapprove');
		$('#disapproval').hide();
      });
});
</script>

<?php
$sql3 = "SELECT parichay_status FROM parichay_card where registration_id='$id'";
$result3 = $conn ->query($sql3);
if($row3 = $result3->fetch_assoc())
{
$approved = filter($row3['parichay_status']);
}
?>
<script>
var approv = '<?php echo $approved; ?>';
$(document).ready(function(){
 if(approv == 'D' || approv == 'U')
 {
 $('#disapproval').show();
 }
});
</script>

<script>
$(document).ready(function(){
$('#reg_disapprove').hide();
$('#regdisapprove').click(function(){
		$('#reg_disapprove').show();
});
$('#regapprove').click(function(){
		$('#reg_disapprove').hide();
});
});
</script>
<script>
    function imageAppear(id) { 
    document.getElementById(id).style.visibility = "visible";
	document.getElementById(id).style.height = "200px";
	document.getElementById(id).style.width = "auto";
	}
    function imageDisappear(id) { 
    document.getElementById(id).style.visibility = "hidden";}
</script>
<?php
$sqlreg1 = "SELECT parichay_status FROM parichay_card where registration_id='$registration_id'";
$res = $conn ->query($sqlreg1);
if($vals = $res->fetch_assoc())
{
$reg_approved = $vals['parichay_status'];
}
?>
<script>
var reg_approv = '<?php echo $reg_approved; ?>';
$(document).ready(function(){
 if(reg_approv == 'D')
 {
 $('#reg_disapprove').show();
 }
});
</script>

<style type="text/css">
.style1 {color: #FF0000}
.style2 {
	font-size: 16px;
	font-weight: bold;
}
<?php if($_REQUEST['action']=='view') { ?>
#search{display:block;}
#page_ids{display:block;}
<?php  } else { ?>
#search{display:none;}
#page_ids{display:none;}
<?php } ?>

.blah{
    width: 100px;
    height: 100px;
}
-->
.fancybox-button--zoom,.fancybox-button--play,.fancybox-button--thumbs,.fancybox-button--arrow_left,.fancybox-button--arrow_right,.fancybox-infobar{display:none!important;}
</style>
<style type="text/css">
 border: 1px solid #ccc;
    border-collapse: separate;
    margin: 0;
    padding: 0;
    background: white;
    width: 50%;
    table-layout: fixed;
}
.inner tr {
background: #f8f8f8;
border: 1px solid #ddd;
padding: .35em;
}
.inner th,
.inner td {padding: .625em;text-align: left;padding: 10px 20px;}
.inner th {font-size: 13px;letter-spacing: 0;text-transform: uppercase;color: #fff;background: #751c54;}
</style>
</head>

<body>
<div id="header_wrapper"><?php include("include/header.php");?></div>

<div id="nav_wrapper">
	<div class="nav"><?php include("include/menu.php");?></div>
</div>

<div class="clear"></div>

<div class="breadcome_wrap">
	<div class="breadcome"><a href="admin.php">Home</a>
    <?php if($_REQUEST['actions']=='companyedit'){ ?> Details
    <?php } else { ?> Parichay Card <?php } ?></div>
</div>

<div id="main">
	<div class="content">
    
    	<div class="content_head">
		<?php if($_REQUEST['actions']!='companyedit'){ ?>
		<?php echo strtoupper(getNameCompany($_REQUEST['regid'],$conn)); echo "&nbsp;"; echo getFirmType(getCompanyType($_REQUEST['regid'],$conn),$conn);?>&nbsp;
		<?php } ?>
        <?php if($_REQUEST['action']=='viewReg'){ ?> - Karigar Details
        <div style="float:left; padding-right:10px; font-size:15px;"><a href="parichay_companywise_report.php?regid=<?php echo $_REQUEST['regid'];?>">Download Report</a></div>
        <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;"><a href="manage-parichay-card.php?action=view">Parichay Card</a></div>
        <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;"><a href="manage-parichay-card.php?action=view">Back</a></div> 
        <?php } elseif($_REQUEST['action']=='edit'){ ?>
        Parichay Card  <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;">
        <a href="manage-parichay-card.php?action=viewReg&regid=<?php echo $registration_id; ?>">Back</a></div>
        <?php } elseif($_REQUEST['actions']=='companyedit'){ ?>
        Details  <div class="content_head_button" style="float:right; padding-right:10px; font-size:12px;">
        <a href="manage-parichay-card.php?action=view">Back</a></div> 
        <?php } ?>		
        </div>
		
<?php if($_REQUEST['action']=='view') { ?>
<div class="content_details1">

	<?php 
	$sql5 = "SELECT rm.id, rm.company_name,rm.website, rm.email_id,pc.* FROM registration_master rm inner join parichay_card pc on rm.id=pc.registration_id AND rm.website='parichay' AND rm.status='1'";
	if($_SESSION['curruser_role']=="Admin")
	{
		$sql5.=" and rm.state IN(".$getRegionAccess.") ";
	}
	$result5 = $conn ->query($sql5);
	$total_application= $result5->num_rows;
	
	$total_approve=0;
	$total_pending=0;
	$total_disapprove=0;
	while($rows5 = $result5->fetch_assoc())
	{
		if($rows5['parichay_status']=='Y')
		{
			$total_approve=$total_approve+1;
		}else if($rows5['parichay_status']=='P')
		{
			$total_pending=$total_pending+1;
		}else if($rows5['parichay_status']=='D')
		{
			$total_disapprove=$total_disapprove+1;
		}
	}	
?>        <div><a href="parichay_company_report.php" style="float: right;margin-bottom: 10px">Export Parichay Data</a></div>
   	      <table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
   	        <tr class="orange1">
   	          <td colspan="11">Report Summary</td>
            </tr>
   	        <tr>
   	          <td><strong>Total Application</strong></td>
   	          <td><strong>Approve Application</strong></td>
   	          <td><strong>Disapprove Application</strong></td>
   	          <td><strong>Pending Application</strong></td>
            </tr>
   	        <tr>
   	          <td><?php echo $total_application;?></td>
   	          <td><?php echo $total_approve;?></td>
   	          <td><?php echo $total_disapprove;?></td>
   	          <td><?php echo $total_pending;?></td>
            </tr>
        </table>
      </div>
<?php } ?>
<div class="content_details1" id="search">
<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<form name="search" action="" method="post" > 
<input type="hidden" name="search_type" id="search_type" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Search Options</td>
</tr>
<tr>
    <td width="19%"><strong>Company Name</strong></td>
    <td width="81%"><input type="text" name="company_name" id="company_name" class="input_txt" value="<?php echo $_SESSION['company_name'];?>" autocomplete="off"/></td>
</tr>     
<tr>
<td><strong> Status</strong></td>        
    <td>
        <select name="parichay_status" class="input_txt-select">
        <option value="">Select Status</option>
        <option value="P" <?php if($_SESSION['parichay_status']=='P'){echo "selected='selected'";}?>>Pending</option>
        <option value="Y" <?php if($_SESSION['parichay_status']=='Y'){echo "selected='selected'";}?>>Approved</option>
        <option value="D" <?php if($_SESSION['parichay_status']=='D'){echo "selected='selected'";}?>>Disapproved</option>
        <!--<option value="U" <?php if($_SESSION['parichay_status']=='U'){echo "selected='selected'";}?>>Updated</option>-->
        </select>
    </td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Search" class="input_submit"/> <input type="submit" name="Reset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      
</div>

<!------------------------------- ORDER DIRECTORY ---------------------------------->

<?php if($_REQUEST['action']=='view') { ?>  
<div class="content_details1">
<form name="form1" action="" method="post" > 
<input type="hidden" name="action_update" value="UPDATE_STATUS" />
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
    <td>Region</td>
    <td>Type</td>
    <td>Company Name</td>
    <td>Email</td>
    <td>Company</td>
	<td>Co Status</td>
    <td>View Details</td>
  </tr>
	<?php  
	$page=1;//Default page
	$limit=20;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
  
	$sql="SELECT rm.id, rm.company_name,rm.website, rm.email_id,rm.state,pc.* FROM registration_master rm inner join parichay_card pc on rm.id=pc.registration_id AND rm.website='parichay' AND rm.status='1'";
  
	if($_SESSION['company_name']!="")
	{
	$sql.=" and rm.company_name like '%".$_SESSION['company_name']."%'";
	}
	
	if($_SESSION['parichay_status']!="")
	{ 
		if($_SESSION['parichay_status']=='Y')
		{
			$sql.=" and parichay_status='Y' ";
		}else if($_SESSION['parichay_status']=='P')
		{
			$sql.=" and parichay_status='P' ";
		} else {
			$sql.=" and application_status='D' ";
		}
	}
  
	if($_SESSION['curruser_role']=="Admin")
	{
		$sql.=" and rm.state IN(".$getRegionAccess.") ";
	}
	
//	echo $sql;
	$result = $conn ->query($sql);
	$rCount = $result->num_rows;
	$sql1= $sql."  limit $start, $limit";
	$result1= $conn ->query($sql1);
		
  if($rCount>0)
  {	
  while($rows = $result1->fetch_assoc())
  {
  ?>
  <tr>
     <td><?php echo gotStateRegionName($rows['state'],$conn);?></td> 
	<td><?php if($rows['parichay_type']=="M" || $rows['parichay_type']=="NM") { echo "COMPANY "; } else { echo strtoupper($rows['parichay_type']); }?></td>  
    <td><?php echo strtoupper($rows['company_name']);?></td> 
    <td><?php echo filter($rows['email_id']);?></td>
    <td align="center" valign="middle"><a href="manage-parichay-card.php?actions=companyedit&regid=<?php echo $rows['id'];?>">
    <img class="icons" src="images/view.png" title="Company Details" border="0" /></a></td>
	<td>
	<?php
	if($rows['parichay_status']=="") 
        		echo "<img src='images/notification-exclamation.gif' border='0' />";	
			elseif($rows['parichay_status']=="Y")
				echo "<img src='images/yes.gif' border='0' title='APPROVED'/>";	
			elseif($rows['parichay_status']=="P")
				echo "<img src='images/notification-exclamation.gif' border='0' title='PENDING' />";	
			elseif($rows['parichay_status']=="D")
				echo "<img src='images/no.gif' border='0' title='DISAPPROVED'/>";
			elseif($rows['parichay_status']=="U")
				echo "Updated";
	?>
	</td>
    <td align="left" valign="middle">  
    <a href="manage-parichay-card.php?action=viewReg&regid=<?php echo $rows['id'];?>">Karigar Details</a></td>
  </tr>
  <?php
   $i++;
   } 
}
   else
   {
   ?>
  <tr>
    <td colspan="8">Records Not Found</td>
  </tr>
  <?php  }  	?>
</table>
</form>
</div>
<?php } ?>  
<?php
function pagination($per_page = 10, $page = 1, $url = '', $total){ 

$adjacents = "2";

$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$lastpage = ceil($total/$per_page);
$lpm1 = $lastpage - 1;

$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<ul class='pagination'>";
$pagination .= "<li class='details'>Page $page of $lastpage</li>";
if ($lastpage < 7 + ($adjacents * 2))
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2))
{
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>...</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>..</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
else
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>..</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
}

if ($page < $counter - 1){
$pagination.= "<li><a href='{$url}$next'>Next</a></li>";
// $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
}else{
//$pagination.= "<li><a class='current'>Next</a></li>";
// $pagination.= "<li><a class='current'>Last</a></li>";
}
$pagination.= "</ul>\n"; 
} 
return $pagination;
}
?>	
<div class="pages_1" id="page_ids">Total Number Company : <?php echo $rCount;?>
<?php echo pagination($limit,$page,'manage-parichay-card.php?action=view&page=',$rCount); //call function to show pagination?>
</div>  

<!------------------------------- VIEW Karigar REGISTRATION ---------------------------------->
      
<?php if($_REQUEST['action']=='viewReg') { ?>  
<div class="content_details1">
<?php 
$company_approval = "SELECT company_approval FROM parichay_person_details where registration_id = '$registration_id'";
$resultCompany_approval = $conn->query($company_approval);
$total_application = $resultCompany_approval->num_rows;
	$total_approve=0;
	$total_pending=0;
	$total_disapprove=0;
	while($rows5 = $resultCompany_approval->fetch_assoc())
	{
		if($rows5['company_approval']=='Y')
		{
			$total_approve=$total_approve+1;
		}else if($rows5['company_approval']=='P')
		{
			$total_pending=$total_pending+1;
		}else if($rows5['company_approval']=='N')
		{
			$total_disapprove=$total_disapprove+1;
		}
	}	
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
	<tr class="orange1"><td colspan="11">Karigar Summary</td></tr>
	<tr>
   	<td><strong>Parichay Cards Requested</strong></td>
   	<td><strong>Parichay Cards Issued</strong></td>
   	<td><strong>Parichay Cards DisApproved</strong></td>
   	<td><strong>Parichay Cards Pending</strong></td>
    </tr>
   	<tr>
   	<td><?php echo no_of_parichay_card($registration_id,$conn);?></td>
   	<td><?php echo $total_approve;?></td>
   	<td><?php echo $total_disapprove;?></td>
   	<td><?php echo $total_pending;?></td>
    </tr>
</table>


<?php 
if($_SESSION['succ_msg']!=""){
echo "<span class='notification n-success'>".$_SESSION['succ_msg']."</span>";
$_SESSION['succ_msg']="";
}
?>
<form name="search" action="" method="post" > 
<input type="hidden" name="search_ktype" id="search_ktype" value="SEARCH" />
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
<tr class="orange1">
    <td colspan="11">Search Options</td>
</tr>
<tr>
    <td width="19%"><strong>Karigar Name</strong></td>
    <td width="81%"><input type="text" name="f_name" id="f_name" class="input_txt" value="<?php echo $_SESSION['f_name'];?>" autocomplete="off"/></td>
</tr>     
<!--<tr>
<td><strong> Status</strong></td>        
    <td>
        <select name="parichay_status" class="input_txt-select">
        <option value="">Select Status</option>
        <option value="P" <?php if($_SESSION['parichay_status']=='P'){echo "selected='selected'";}?>>Pending</option>
        <option value="Y" <?php if($_SESSION['parichay_status']=='Y'){echo "selected='selected'";}?>>Approved</option>
        <option value="D" <?php if($_SESSION['parichay_status']=='D'){echo "selected='selected'";}?>>Disapproved</option>
        </select>
    </td>
</tr>-->
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Search" class="input_submit"/> <input type="submit" name="KReset" value="Reset"  class="input_submit" /></td>
</tr>	
</table>
</form>      

	
<form name="form1" action="" method="POST" > 
<!-- <input type="hidden" name="action_update" value="UPDATE_STATUS" /> -->
<input type="hidden" name="company_action" value="save_document"/>
<div><input type="submit" name="print_pdf" action="print_pdf" value="Download"  class="input_submit" /></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="detail_txt" >
  <tr class="orange1">
  	<td>Select</td>
    <td width="8%">Date</td>
    <td>Series</td>
    <td>Name</td>
	<td>Mobile No</td>
    <td>Email</td>   
    <td>Agency Approval</td>
    <td>Association/Company Approval</td>
    <td>View Details</td>
  </tr>
    <?php  
	$page=1;//Default page
	$limit=50;//Records per page
	$start=0;//starts displaying records from 0
	if(isset($_GET['page']) && $_GET['page']!=''){
	$page=$_GET['page'];	
	}
	$start=($page-1)*$limit;
  
    $sql="SELECT * FROM parichay_person_details where registration_id = '$registration_id' AND registration_id!=0";
	  if($_SESSION['f_name']!="")
      {
      $sql.=" and fname like '%".$_SESSION['f_name']."%'";
      }
	$sql .="  order by post_date desc";
	$result = $conn ->query($sql);
	$rCount =  $result->num_rows;
	$sql1= $sql."  limit $start, $limit";
	$result1=$conn ->query($sql1);
	
  if($rCount>0)
  {	
  while($rows = $result1->fetch_assoc())
  { 
  $agency_approval = $rows['agency_approval'];
	$company_approval = $rows['company_approval'];
	if($agency_approval == "Y"){ $agency_approval= "<span style='color:green'>Approved</span>"; $v_date = date("d-m-Y",strtotime($rows['post_date'])); } 
	if($agency_approval == "P"){ $agency_approval= "<span style='color:blue'>Pending</span>";   $v_date = date("d-m-Y",strtotime($rows['post_date']));}
	if($agency_approval == "N"){ $agency_approval= "<span style='color:red'>Disapproved</span>"; $v_date = date("d-m-Y",strtotime($rows['mod_date']));}
	if($agency_approval == "U"){ $agency_approval= "<span style='color:green'>Updated</span>";  $v_date = date("d-m-Y",strtotime($rows['mod_date']));}
  if($company_approval == "Y"){ $company_approval= "<span style='color:green'>Approved</span>"; $v_date = date("d-m-Y",strtotime($rows['post_date'])); } 
  if($company_approval == "P"){ $company_approval= "<span style='color:blue'>Pending</span>";   $v_date = date("d-m-Y",strtotime($rows['post_date']));}
  if($company_approval == "N"){ $company_approval= "<span style='color:red'>Disapproved</span>"; $v_date = date("d-m-Y",strtotime($rows['mod_date']));}
  if($company_approval == "U"){ $agency_approval= "<span style='color:green'>Updated</span>";  $v_date = date("d-m-Y",strtotime($rows['mod_date']));}

  ?>
  <tr>
	<?php if($rows['company_approval'] == "Y") {?>
  	   <td><input type="checkbox" name="person_id[<?php echo $i+1; ?>]" value="<?php echo $rows['person_id']; ?>"  /></td>
	<?php } else { ?>
		<td><input type="checkbox" name="person_id[<?php echo $i+1; ?>]" value="<?php echo $rows['person_id']; ?>"  disabled/></td>	
	<?php } ?>	
    <td><?php echo date("d-m-Y",strtotime($rows['post_date']));?></td>
    <td><?php echo $rows['person_series'];?></td>
    <td><?php echo strtoupper(filter($rows['fname']).' '.filter($rows['mname']).' '.filter($rows['surname']));?></td>
	<td><?php echo strtoupper(filter($rows['mobile1']));?></td>
    <td><?php echo $rows['email'];?></td> 
    <td><?php echo $agency_approval;?></td>   
    <td><?php echo $company_approval;?></td>   
    <td align="left" valign="middle"><a href="manage-parichay-card.php?action=edit&id=<?php echo $rows['person_id'];?>&regid=<?php echo $rows['registration_id'];?>">
    <img src="images/edit.gif" title="Edit" border="0"/></a></td>
  </tr>
  <?php
   $i++;
   }  
   }
   else
   {
   ?>
  <tr>
    <td colspan="8">Records Not Found</td>
  </tr>
  <?php  }  ?>
</table>
</form>
</div>
<?php
function pagination2($per_page = 10, $page = 1, $url = '', $total){ 

$adjacents = "2";

$page = ($page == 0 ? 1 : $page); 
$start = ($page - 1) * $per_page; 

$prev = $page - 1; 
$next = $page + 1;
$lastpage = ceil($total/$per_page);
$lpm1 = $lastpage - 1;

$pagination = "";
if($lastpage > 1)
{ 
$pagination .= "<ul class='pagination'>";
$pagination .= "<li class='details'>Page $page of $lastpage</li>";
if ($lastpage < 7 + ($adjacents * 2))
{ 
for ($counter = 1; $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
elseif($lastpage > 5 + ($adjacents * 2))
{
if($page < 1 + ($adjacents * 2)) 
{
for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>...</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>...</li>";
for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
$pagination.= "<li class='dot'>..</li>";
$pagination.= "<li><a href='{$url}$lpm1'>$lpm1</a></li>";
$pagination.= "<li><a href='{$url}$lastpage'>$lastpage</a></li>"; 
}
else
{
$pagination.= "<li><a href='{$url}1'>1</a></li>";
$pagination.= "<li><a href='{$url}2'>2</a></li>";
$pagination.= "<li class='dot'>..</li>";
for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
{
if ($counter == $page)
$pagination.= "<li><a class='current'>$counter</a></li>";
else
$pagination.= "<li><a href='{$url}$counter'>$counter</a></li>"; 
}
}
}

if ($page < $counter - 1){
$pagination.= "<li><a href='{$url}$next'>Next</a></li>";
// $pagination.= "<li><a href='{$url}$lastpage'>Last</a></li>";
}else{
//$pagination.= "<li><a class='current'>Next</a></li>";
// $pagination.= "<li><a class='current'>Last</a></li>";
}
$pagination.= "</ul>\n"; 
} 
return $pagination;
}
?>	
<div class="pages_1" id="page_id">Total Number Company : <?php echo $rCount;?>
<?php echo pagination2($limit,$page,'manage-parichay-card.php?action=viewReg&regid='.$registration_id.'&page=',$rCount); //call function to show pagination?>
</div> 
<?php } ?>  

<!------------------------ UPDATE FOR Karigar ------------------------------->
  
<?php    
if(($_REQUEST['action']=='add') || ($_REQUEST['action']=='edit'))
{
    $action='save';
    if(($_REQUEST['id']!='') || ($_REQUEST['action']=='edit'))
    {
		$action='update';
		$result2 = $conn ->query("SELECT * FROM parichay_person_details where registration_id = '$registration_id' AND person_id='$id' limit 1");
		if($row2 = $result2->fetch_assoc())
		{			
			$parichay_type = isApplied_for_parichay($registration_id,$conn);
          $agency_approval = $row2['agency_approval'];
			$agency_remark = $row2['agency_remark'];
			
			$photo	=	$row2['photo'];
			$id_proof	=	$row2['id_proof'];
			$upload_bank_documents	=	$row2['upload_bank_documents'];
			
			$fname	 =	strtoupper(filter($row2['fname']));
			$mname	 =	strtoupper(filter($row2['mname']));
			$surname =	strtoupper(filter($row2['surname']));
			$date_of_birth	=	date('d-m-Y',strtotime($row2['date_of_birth']));
			$gender			=	strtoupper(filter($row2['gender']));
			$blood_group	=	$row2['blood_group'];
			$education	=	filter($row2['education']);
			$mobile1	=	filter($row2['mobile1']);
			$mobile2	=	filter($row2['mobile2']);
			$email_id	=	filter($row2['email']);
			$p_address1	= strtoupper(filter($row2['p_address1']));
			$p_address2	= strtoupper(filter($row2['p_address2']));
			$p_city	= strtoupper(filter($row2['p_city']));
			$p_state	= strtoupper(filter($row2['p_state']));
			$p_pin_code	= strtoupper(filter($row2['p_pin_code']));
			
			$same_address = $row2['same_address'];	
			
			$c_address1 = strtoupper(filter($row2['c_address1']));
			$c_address2 = strtoupper(filter($row2['c_address2']));
			$c_city = strtoupper(filter($row2['c_city']));
			$c_state = filter($row2['c_state']);
			$c_pin_code = filter($row2['c_pin_code']);
			$c_address1 = strtoupper(filter($row2['c_address1']));
				
			$bank			=	filter($row2['bank']);
			$account_no		=	filter($row2['account_no']);
			$ifsc			=	filter($row2['ifsc']);
			$employment_status	=	filter($row2['employment_status']);
			$work_experience	=	filter($row2['work_experience']);
			$applicable_industry =	filter($row2['applicable_industry']);
				
			$applicable_skills   = $row2['applicable_skills'];	
			foreach($applicable_skills as $val)
			{
				if($val=="other")
				{
					$skills_other=$row2['skills_other'];
					$applicable_skills_new.=$skills_other.",";
				} else	{
					$applicable_skills_new.=$val.",";	
				}
			}
			
			$swasthya_kosh_option	=	filter($row2['swasthya_kosh_option']);
			if($row2['swasthya_kosh_option']=="Y"){ $swasthya_kosh_option	=	$row2['swasthya_kosh_option']; } else {  $swasthya_kosh_option	= "N"; }
			$isPremium			=	strtoupper(filter($row2['isPremium']));
			$spouse_name		=	strtoupper(filter($row2['spouse_name']));
			$spouse_dob			=	date('d-m-Y',strtotime($row2['spouse_dob']));
			$spouse_age			=	filter($row2['spouse_age']);
			$child1				=	strtoupper(filter($row2['child1']));
			$child1_gender		=	filter($row2['child1_gender']);
			$child1_dob			=	date('d-m-Y',strtotime($row2['child1_dob'])); 
			$child1_age			=	filter($row2['child1_age']);
			
			$child2				=	strtoupper(filter($row2['child2']));
			$child2_gender		=	filter($row2['child2_gender']);
			$child2_dob			=	date('d-m-Y',strtotime($row2['child2_dob'])); 
			$child2_age			=	filter($row2['child2_age']);
			//$parichay_type 		=   filter($row2['parichay_type']);
		}
	}
?>   
<div class="content_details1">
<form name="details" action="" method="POST">        	
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1">
     <td colspan="11">Parichay Card</td>
  </tr>
  <tr>
    <td ><strong>First Name</strong></td>
    <td><input type="text" name="fname" id="fname" class="input_txt" value="<?php echo $fname; ?>" maxlength="14" readonly/></td>
  </tr>
  <tr>
    <td ><strong>Middle Name</strong></td>
    <td><input type="text" name="mname" id="mname" class="input_txt" value="<?php echo $mname; ?>" maxlength="14" readonly/></td>
  </tr>
  <tr>
    <td ><strong>Sur Name</strong></td>
    <td><input type="text" name="surname" id="surname" class="input_txt" value="<?php echo $surname; ?>" readonly/></td>
  </tr>
	<tr>  
		<td><strong>Photo</strong></td>
		<td> 
		<?php if(!empty($photo)){ ?>
		<a href="../images/parichay_card/person/photo/<?php echo $photo;?>" target="_blank" class="gold_clr"><strong> View </strong></a><?php } ?>
		</td>
	</tr>
	<tr>
    <td><strong>Date of Birth</strong></td>
    <td><input type="text" name="date_of_birth" id="date_of_birth" class="input_txt" value="<?php echo $date_of_birth; ?>" readonly/></td>
	</tr>
	
    <tr>
	<td><strong>Gender</strong></td>
	<td><input type="radio" id="gender" name="gender" <?php if($gender=='MALE'){ echo 'checked="checked"'; } ?>/> Male
	<input type="radio" id="gender" name="gender" <?php if($gender=='FEMALE'){ echo 'checked="checked"'; } ?> />  FEMALE
	<input type="radio" id="gender" name="gender" <?php if($gender=='LGBTQ'){ echo 'checked="checked"'; } ?> />  LGBTQ</td>
	</tr>
	
	<tr>
	<td><strong>Blood Group </strong></td>
	<td>
	<select class="form-control" id="blood_group" name="blood_group">
    <option value="">-- Select Blood Group --</option>
    <option value="A+" <?php if($blood_group=="A+") echo 'selected="selected"';?>>A Positive</option>
    <option value="A-" <?php if($blood_group=="A-") echo 'selected="selected"';?>>A Negative</option>
    <option value="A" <?php if($blood_group=="A") echo 'selected="selected"';?>>A Unknown</option>
    <option value="B+" <?php if($blood_group=="B+") echo 'selected="selected"';?>>B Positive</option>
    <option value="B-" <?php if($blood_group=="B-") echo 'selected="selected"';?>>B Negative</option>
    <option value="B" <?php if($blood_group=="B") echo 'selected="selected"';?>>B Unknown</option>
    <option value="AB+" <?php if($blood_group=="AB+") echo 'selected="selected"';?>>AB Positive</option>
    <option value="AB-" <?php if($blood_group=="AB-") echo 'selected="selected"';?>>AB Negative</option>
    <option value="AB" <?php if($blood_group=="AB") echo 'selected="selected"';?>>AB Unknown</option>
    <option value="O+" <?php if($blood_group=="O+") echo 'selected="selected"';?>>O Positive</option>
    <option value="O-" <?php if($blood_group=="O-") echo 'selected="selected"';?>>O Negative</option>
    <option value="O" <?php if($blood_group=="O") echo 'selected="selected"';?>>O Unknown</option>
    <option value="unknown" <?php if($blood_group=="unknown") echo 'selected="selected"';?>>Unknown</option>
	</select>
	</td>
	</tr>

	<tr>
	<td><strong>Education</strong></td>
	<td><input type="radio" id="education" name="education" value="10" <?php if($education=='10'){ echo 'checked="checked"'; } ?>> 10th
	<input type="radio" id="education" name="education" value="12" <?php if($education=='12'){ echo 'checked="checked"'; } ?>> 12th
	<input type="radio" id="education" name="education" value="graduate" <?php if($education=='graduate'){ echo 'checked="checked"'; } ?>> Graduate
	<input type="radio" id="education" name="education" value="p_graduate" <?php if($education=='p_graduate'){ echo 'checked="checked"'; } ?>> Post Graduate</td>
	</tr>
	
	<tr>  
		<td><strong>ID Proof</strong></td>
		<td> 
		<?php if(!empty($id_proof)){ ?>
		<a href="../images/parichay_card/person/id_proof/<?php echo $id_proof;?>" target="_blank" class="gold_clr"><strong> View </strong></a><?php } ?>
		</td>
	</tr>
	
	<tr class="orange1">
     <td colspan="11">Contact Details</td>
	</tr>
  <tr>
    <td ><strong>Mobile 1</strong></td>
    <td><input type="text" name="mobile1" id="mobile1" class="input_txt" value="<?php echo $mobile1; ?>" maxlength="10" readonly/></td>
  </tr>
  <tr>
    <td ><strong>Mobile 2</strong></td>
    <td><input type="text" name="mobile2" id="mobile2" class="input_txt" value="<?php echo $mobile2; ?>" maxlength="10" readonly/></td>
  </tr>
  <tr>
    <td ><strong>Email Id</strong></td>
    <td><input type="text" name="email_id" id="email_id" class="input_txt" value="<?php echo $email_id; ?>" readonly/></td>
  </tr>
 <tr>
    <td ><strong>Permanent Address 1</strong></td>
    <td><input type="text" name="p_address1" id="p_address1" class="input_txt" value="<?php echo $p_address1; ?>" readonly/></td>
  </tr>
  <tr>
    <td><strong>Permanent Address 2</strong></td>
    <td><input type="text" name="p_address2" id="p_address2" class="input_txt" value="<?php echo $p_address2; ?>" readonly/></td>
  </tr>
	<tr>
        <td><strong>State</strong></td>
       <td class="text6"><?php echo getState($p_state,$conn); ?></td>
    </tr>     
    <tr>
       <td><strong>City</strong></td>
       <td class="text6"><?php echo $p_city; ?></td>
    </tr> 
	<tr>
       <td><strong>Pin Code</strong></td>
       <td class="text6"><?php echo $p_pin_code; ?></td>
    </tr> 
	<tr>
	<td><strong>Current Address</strong></td>
	<td><input type="radio" name="address" value="YES" <?php if($same_address=="YES"){ echo "checked=checked";}?>> YES
	<input type="radio" name="address" value="NO" <?php if($same_address=="NO"){ echo "checked=checked";}?> >NO</td>
	</tr>
	<tr>
    <td><strong>Permanent Address 1</strong></td>
    <td><input type="text" name="c_address1" id="c_address1" class="input_txt" value="<?php echo $c_address1; ?>" readonly/></td>
	</tr>
  <tr>
    <td><strong>Permanent Address 2</strong></td>
    <td><input type="text" name="c_address2" id="c_address2" class="input_txt" value="<?php echo $c_address2; ?>" readonly/></td>
  </tr>
	<tr>
        <td><strong>State</strong></td>
       <td class="text6"><?php echo getState($c_state,$conn); ?></td>
    </tr>     
    <tr>
       <td><strong>City</strong></td>
       <td class="text6"><?php echo $c_city; ?></td>
    </tr> 
	<tr>
       <td><strong>Pin Code</strong></td>
       <td class="text6"><?php echo $c_pin_code; ?></td>
    </tr>
	
	<tr>
	<td><strong>Bank Name </strong></td>
	<td>
    <select name="bank" id="bank" class="form-control">
    <option value="">-- Select Bank --</option>
    <?php 
    $bquery =  $conn ->query("select bank_name from bank_master where status='1' order by bank_name asc");
    while($bresult = $bquery->fetch_assoc()){
    ?>
    <option value="<?php echo $bresult['bank_name'];?>" <?php if($bresult['bank_name']==$bank){?> selected="selected" <?php }?>><?php echo strtoupper($bresult['bank_name']);?></option>
    <?php } ?>
    </select>
	</td>
	</tr>
	
	<tr>
    <td><strong>Account No.</strong></td>
    <td><input type="text" name="account_no" id="account_no" class="input_txt" value="<?php echo $account_no; ?>" readonly/></td>
	</tr>
	
	<tr>
    <td><strong>IFSC Code</strong></td>
    <td><input type="text" name="ifsc" id="ifsc" class="input_txt" value="<?php echo $ifsc; ?>" readonly/></td>
	</tr>
	
	<tr>  
		<td><strong>Bank details</strong></td>
		<td> 
		<?php if(!empty($upload_bank_documents)){ ?>
		<a href="../images/parichay_card/person/upload_bank_documents/<?php echo $upload_bank_documents;?>" target="_blank" class="gold_clr"><strong> View </strong></a><?php } ?>
		</td>
	</tr>
	
	<tr class="orange1">
     <td colspan="11">Work Profile</td>
	</tr>
	
	<tr>
	<td><strong>Current Employment status</strong></td>
	<td><input type="radio" id="employment_status" value="Permanent" name="employment_status" <?php if($employment_status=='Permanent'){ echo 'checked="checked"'; } ?>> Permanent
	<input type="radio" id="employment_status" value="Contracted" name="employment_status" <?php if($employment_status=='Contracted'){ echo 'checked="checked"'; } ?>> Contracted
	<input type="radio" id="employment_status" value="Unemployed" name="employment_status" <?php if($employment_status=='Unemployed'){ echo 'checked="checked"'; } ?>> Unemployed</td>
	</tr>
	
	<tr>
    <td><strong>Work experience in G&J industry (in years) </strong></td>
    <td><input type="text" name="work_experience" id="work_experience" class="input_txt" value="<?php echo $work_experience; ?>" readonly/></td>
	</tr>
	
	<tr>
	<td><strong>Applicable Industry</strong></td>
	<td> <input type="radio" id="applicable_industry" value="Diamond" name="applicable_industry" <?php if($applicable_industry=='Diamond'){ echo 'checked="checked"'; } ?>> Diamond
	<input type="radio" id="applicable_industry" value="Gemstones" name="applicable_industry" <?php if($applicable_industry=='Gemstones'){ echo 'checked="checked"'; } ?>> Gemstones
	<input type="radio" id="applicable_industry" value="Jewellery" name="applicable_industry" <?php if($applicable_industry=='Jewellery'){ echo 'checked="checked"'; } ?>> Jewellery</td>
	</tr>
	
	<tr>
	<td><strong>Applicable Skills</strong></td>	
    <td>
	<table border="0" cellspacing="0" cellpadding="0" class="bottomSpace">
      <tbody><tr>
        <td><input type="checkbox" id="applicable_skills" value="mould" name="applicable_skills[]" <?php if(preg_match('/mould/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Model & mould making</td>
        <td><input type="checkbox" id="applicable_skills" value="finishing" name="applicable_skills[]" <?php if(preg_match('/finishing/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Finishing / Polishing</td>
		<td><input type="checkbox" id="applicable_skills" value="retail" name="applicable_skills[]" <?php if(preg_match('/retail/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Retail Sales</td>
        <td><input type="checkbox" id="applicable_skills" value="waxing" name="applicable_skills[]" <?php if(preg_match('/waxing/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Waxing </td>		
        <td><input type="checkbox" id="applicable_skills" value="grading" name="applicable_skills[]" <?php if(preg_match('/grading/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Grading</td>
		<td><input type="checkbox" id="applicable_skills" value="grinding" name="applicable_skills[]" <?php if(preg_match('/grinding/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Grinding & Assembly</td>
      </tr>
    </tbody>
	</table>
	
	<table border="0" cellspacing="0" cellpadding="0" class="bottomSpace">
      <tbody><tr>
        <td><input type="checkbox" id="applicable_skills" value="procurement" name="applicable_skills[]" <?php if(preg_match('/procurement/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Procurement</td>
		<td><input type="checkbox" id="applicable_skills" value="casting" name="applicable_skills[]" <?php if(preg_match('/casting/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Casting</td>
		<td><input type="checkbox" id="applicable_skills" value="trading" name="applicable_skills[]" <?php if(preg_match('/trading/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Trading</td>
		<td><input type="checkbox" id="applicable_skills" value="assortment" name="applicable_skills[]" <?php if(preg_match('/assortment/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Assortment & Planning</td>		
		<td><input type="checkbox" id="applicable_skills" value="admin" name="applicable_skills[]" <?php if(preg_match('/admin/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Admin/HR/Finance</td>
		<td><input type="checkbox" id="applicable_skills" value="handcrafting" name="applicable_skills[]" <?php if(preg_match('/handcrafting/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Handcrafting </td>
		<td><input type="checkbox" id="applicable_skills" value="setting" name="applicable_skills[]" <?php if(preg_match('/setting/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Setting</td>
		<td><input type="checkbox" id="applicable_skills" value="designing" name="applicable_skills[]" <?php if(preg_match('/designing/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Designing</td>
		<td><input type="checkbox" id="applicable_skills" value="cutting" name="applicable_skills[]" <?php if(preg_match('/cutting/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Cutting / Polishing / Faceting</td>
		
		<td><input type="checkbox" id="applicable_skills" value="melting" name="applicable_skills[]" <?php if(preg_match('/melting/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Melting</td>
		<td><input type="checkbox" id="applicable_skills" value="wire" name="applicable_skills[]" <?php if(preg_match('/wire/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Wire or strip drawing</td>
		<td><input type="checkbox" id="applicable_skills" value="die" name="applicable_skills[]" <?php if(preg_match('/die/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Die cutting</td>
		<td><input type="checkbox" id="applicable_skills" value="soldering" name="applicable_skills[]" <?php if(preg_match('/soldering/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Soldering</td>
		<td><input type="checkbox" id="applicable_skills" value="mina" name="applicable_skills[]" <?php if(preg_match('/mina/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Mina work</td>
		<td><input type="checkbox" id="applicable_skills" value="electroplating" name="applicable_skills[]" <?php if(preg_match('/electroplating/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Electroplating</td>
		<td><input type="checkbox" id="applicable_skills" value="packaging" name="applicable_skills[]" <?php if(preg_match('/packaging/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Packaging</td>
		<td><input type="checkbox" id="applicable_skills" value="chains" name="applicable_skills[]" <?php if(preg_match('/chains/',$applicable_skills)){ echo 'checked="checked"'; } ?>> Chains Manufacturing (by machines)</td>
      </tr>
    </tbody>
	</table>
	</td>
    </tr>
	<?php if($parichay_type=="association"){ ?>
	<tr class="orange1">
     <td colspan="11">Swasthya Kosh <input type="checkbox" id="swasthya_kosh_option" value="Y" name="swasthya_kosh_option" <?php if(preg_match('/Y/',$swasthya_kosh_option)){ echo 'checked="checked"'; } ?>></td>
	</tr>
	
	<tr class="orange1">
	  <td colspan="11">Note: Self and Spouse below 80 year and Children below 25 years only</td>
	 </tr>
	<tr>
	
	<td></td>
	<td>
	<input type="radio" tj="<?php echo $isPremium; ?>" id="isPremiumSelf" value="self"  name="isPremium" <?php echo ( strtolower($isPremium)=="self" ? "checked":"");?>  > <label for="isPremiumSelf"> Self Only (Premium: Rs 1400)</label>	
	
	<input type="radio" id="isPremiumFamily" value="family" name="isPremium" <?php echo (strtolower($isPremium)=="family" ? "checked":"");?>> <label for="isPremiumFamily">Self & Family (Premium: Rs. 2200)</label>	
	</td>
	</tr>
	
	<tr>
	<td></td>	
    <td>
	<table class="responsive_table category_table" style="<?php echo ($isPremium=="SELF" ? "display: none" :""); ?>">
                                    <thead>
                                        <tr>
                                            <th>Particular</th>
                                            <th>Full Name</th>
                                            <th>Relation</th>
                                            <th>Gender</th>
                                            <th>DOB</th>
                                            <th>Age</th>
                                        </tr>
                                    </thead>                           
                                    <tbody>
                                        <tr>
                                            <td data-column="Particular">01</td>
                                            <td data-column="Full Name"><input type="text" name="spouse_name" id="spouse_name" class="form-control" value="<?php echo $spouse_name;?>"></td>
                                            <td data-column="Relation">Spouse</td>
                                            <td data-column="Gender">
											<select class="form-control">
											<option selected>Female</option>
											</select>
											</td>										
                                            <td data-column="DOB"><input type="text" name="spouse_dob" id="spouse_dob" class="form-control" value="<?php echo $spouse_dob;?>"></td>										
                                            <td data-column="Age"><input type="text" name="spouse_age" class="form-control numeric" value="<?php echo $spouse_age;?>"></td>
                                        </tr>
                                         
                                        <tr>
                                            <td data-column="Particular">02</td>
                                            <td data-column="Full Name"><input type="text" name="child1" id="child1" class="form-control" value="<?php echo $child1;?>"></td>
                                            <td data-column="Relation">Child 1</td>
                                            <td data-column="Gender">
											<select class="form-control" id="child1_gender" name="child1_gender">
											<option value="M" <?php if($child1_gender=="M") echo 'selected="selected"';?>>Male</option>
											<option value="F" <?php if($child1_gender=="F") echo 'selected="selected"';?>>Female</option>
											</select>
											</td>										
                                            <td data-column="DOB"><input type="text" name="child1_dob" id="child1_dob" class="form-control" value="<?php echo $child1_dob;?>" readonly></td>										
                                            <td data-column="Age"><input type="text" name="child1_age" class="form-control numeric" value="<?php echo $child1_age;?>"></td>
                                        </tr>                                        
                                        <tr>
                                            <td data-column="Particular">03</td>
                                            <td data-column="Full Name"><input type="text" name="child2" id="child2" class="form-control" value="<?php echo $child2;?>"></td>
                                            <td data-column="Relation">Child 2</td>
                                            <td data-column="Gender">
											<select class="form-control" id="child2_gender" name="child2_gender">
											<option value="M" <?php if($child2_gender=="M") echo 'selected="selected"';?>>Male</option>
											<option value="F" <?php if($child2_gender=="F") echo 'selected="selected"';?>>Female</option>
											</select>
											</td>										
                                            <td data-column="DOB"><input type="text" name="child2_dob" id="child2_dob" class="form-control" value="<?php echo $child2_dob;?>" readonly></td>										
                                            <td data-column="Age"><input type="text" name="child2_age" class="form-control numeric" value="<?php echo $child2_age;?>"></td>
                                        </tr>
                                    </tbody>                                        
                                </table>
	</td>
    </tr>
	<?php } ?>
	<?php if($adminID==165 || $adminID==166 || $adminID==167 || $adminID==168 || $adminID==169 || $adminID==170 ||  $adminID==1){ ?>
	<tr>
    <td><strong>Karigar Approval Status (Approval From Agency)</strong></td>
    <td>
    <input type='radio' name='agency_approval' id='approve' value='Y' <?php if($agency_approval=='Y'){ echo "checked='checked'"; }?> <?php if($parichay_status=="Y"){ echo "disabled"; }?>/>Approve
	<input type='radio' name='agency_approval' id='disapprove' value='N' <?php if($agency_approval=='N'){ echo "checked='checked'"; }?>/>Disapprove
	<input type='radio' name='agency_approval' id='regpending' value='P' <?php if($agency_approval=='P'){ echo "checked='checked'"; }?>/>Pending
    </td>
    </tr>

   <tr id="disapproval" <?php if($agency_remark !=""){?>style="display: block;" <?php }?> >
    <td><strong>Disapprove Reason</strong></td>
    <td><textarea name="agency_remark" id="disapprove" cols="25"><?php echo $agency_remark;?></textarea></td>
   </tr>
 
  <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="action" id="action" value="<?php echo $action;?>" />
    <input type="hidden" name="id" id="id"  value="<?php echo $_REQUEST['id'];?>" />
    </td>
  </tr>
  <?php } ?>

</table>
</form> 
</div>
<?php } ?>     

<!----------------------- Company Edits ---------------------------->
<?php 
  if($_REQUEST['actions']=='companyedit') {
  
  if(($_REQUEST['regid']!='') || ($_REQUEST['actions']=='companyedit'))
  {
  		$actions='compupdate';
		
		$result3 = $conn ->query("SELECT rm.id, rm.company_name,rm.website, rm.email_id,rm.company_type,rm.address_line1,rm.address_line2,rm.city,rm.state,rm.pin_code,rm.nature_of_buisness,pc.* FROM registration_master rm inner join parichay_card pc on rm.id=pc.registration_id AND rm.website='parichay' AND rm.id='$registration_id'");
		if($getRowsRegisData = $result3->fetch_assoc())
		{			
			$company_names = strtoupper(str_replace('&amp;', '&', $getRowsRegisData['company_name']));
			$head_email_id					=	$getRowsRegisData['email_id'];
			$comp_type					=	$getRowsRegisData['company_type'];
			$address_line1					=	$getRowsRegisData['address_line1'];
			$address_line2					=	$getRowsRegisData['address_line2'];
			$city							=	$getRowsRegisData['city'];
			$state							=	$getRowsRegisData['state'];
			$pin_code						=   $getRowsRegisData['pin_code'];	
			$nature_of_buisness   			=   $getRowsRegisData['nature_of_buisness'];
			
			$approval_status = $getRowsRegisData['parichay_status'];
			$parichay_type = $getRowsRegisData['parichay_type'];
			$disapprove_reason = $getRowsRegisData['disapprove_reason'];
			$parichay_card_id = $getRowsRegisData['parichay_card_id'];
			$association_request_letter		=	$getRowsRegisData['association_request_letter'];
			$association_registration_certificate	=	$getRowsRegisData['association_registration_certificate'];
			$association_head_visiting_card	=	$getRowsRegisData['association_head_visiting_card'];
			$association_office_address		=	$getRowsRegisData['association_office_address'];
			
			$association_registration_no	=	strtoupper(filter($getRowsRegisData['association_registration_no']));
			$association_head_name			=	strtoupper(filter($getRowsRegisData['association_head_name']));
			$association_head_designation	=	strtoupper(filter($getRowsRegisData['association_head_designation']));
			$association_head_mobile_no1	=	filter($getRowsRegisData['association_head_mobile_no1']);
			$association_head_mobile_no2	=	filter($getRowsRegisData['association_head_mobile_no2']);
			$total_member					=	filter($getRowsRegisData['total_member']);
			$no_of_parichay_card 			=   filter($getRowsRegisData['no_of_parichay_card']);
	
			$authorised_person			=	strtoupper(filter($getRowsRegisData['authorised_person']));
			$authorised_designation		=	strtoupper(filter($getRowsRegisData['authorised_designation']));
			$authorised_mobile1			=	filter($getRowsRegisData['authorised_mobile1']);
			$authorised_mobile2			=	filter($getRowsRegisData['authorised_mobile2']);
			$authorised_email			=	filter($getRowsRegisData['authorised_email']);
		}
	}
?>
<div class="content_details1">
<form name="company" action="" method="POST" >        	
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="detail_txt" >
  <tr class="orange1"><td colspan="11"><?php if($parichay_type=="association"){ ?>Association Details<?php } else { echo "Company Details";}?></td></tr>
  <tr>
    <td><strong>Company/Association Name</strong></td>
    <td><input type="text" name="comp_name" id="comp_name" class="input_txt" value="<?php echo $company_names; ?>" readonly/></td>
  </tr>
   <?php if($parichay_type=="association"){ ?>
	  <tr>  
		<td><strong>Request letter of Association</strong></td>
		<td> 
		<?php if(!empty($association_request_letter)){ ?>
		<a href="../images/parichay_card/association_request_letter/<?php echo $association_request_letter;?>" target="_blank" class="gold_clr"><strong> View </strong></a><?php } ?>
		</td>
	  </tr>
	  <tr>  
		<td><strong>Registration No. of Association</strong></td>
		<td><input type="text" name="association_registration_no" id="association_registration_no" class="input_txt" value="<?php echo $association_registration_no; ?>" readonly/></td>
	  </tr>
	  
   <?php } ?>
	<tr>  
		<td><strong>Registration certificate of Association/Company</strong></td>
		<td> 
		<?php if(!empty($association_registration_certificate)){ ?>
		<a href="../images/parichay_card/association_registration_certificate/<?php echo $association_registration_certificate;?>" target="_blank" class="gold_clr"><strong> View </strong></a><?php } ?>
		</td>
	</tr>							
  <?php if($parichay_type=="M" || $parichay_type=="NM"){ ?>
  <tr>
    <td><strong>Company Type</strong></td>
	<td><input type="radio" name="comp_type" id="comp_type" value="14" <?php if($comp_type=='propritory' || $comp_type==14){ echo "checked"; }?>>Proprietary
      <input type="radio" name="comp_type" id="comp_type" value="11" <?php if($comp_type=='partnership' || $comp_type==11){ echo "checked"; }?>>Partnership
      <input type="radio" name="comp_type" id="comp_type" value="13" <?php if($comp_type=='pvt' || $comp_type==13){ echo "checked"; }?>>Private Ltd.
      <input type="radio" name="comp_type" id="comp_type" value="12" <?php if($comp_type=='public' || $comp_type==12){ echo "checked"; }?>>Public Ltd.
      <input type="radio" name="comp_type" id="comp_type" value="19" <?php if($comp_type=='llp' || $comp_type==19){ echo "checked"; }?>>LLP
      <input type="radio" name="comp_type" id="comp_type" value="15" <?php if($comp_type=='huf' || $comp_type==15){ echo "checked"; }?>>HUF
      </td>
  </tr>
  <?php } ?>
  <tr>
    <td><strong>Full Name of Association/Company Head</strong></td>
    <td><input type="text" name="association_head_name" id="association_head_name" class="input_txt" value="<?php echo $association_head_name; ?>" maxlength="10"/></td>
  </tr>
	<tr>  
	<td><strong>Visiting Card of Association/Company Head</strong></td>
	<td> 
	<?php if(!empty($association_head_visiting_card)){ ?>
	<a href="../images/parichay_card/association_head_visiting_card/<?php echo $association_head_visiting_card;?>" target="_blank" class="gold_clr"><strong> View </strong></a><?php } ?>
	</td>
	</tr>
   <tr>
    <td><strong>Designation of Association/Company Head</strong></td>
    <td><input type="text" name="association_head_designation" id="association_head_designation" class="input_txt" value="<?php echo $association_head_designation; ?>" maxlength="10"/></td>
   </tr>
   <tr>
    <td><strong>Mobile No 1 of Association/Company Head</strong></td>
    <td><input type="text" name="association_head_mobile_no1" id="association_head_mobile_no1" class="input_txt" value="<?php echo $association_head_mobile_no1; ?>" maxlength="10"/></td>
   </tr>
   <tr>
    <td><strong>Mobile No 2 of Association/Company Head</strong></td>
    <td><input type="text" name="association_head_mobile_no2" id="association_head_mobile_no2" class="input_txt" value="<?php echo $association_head_mobile_no2; ?>" maxlength="10"/></td>
   </tr>
  <tr>
    <td><strong>Email ID of the Association/Company Head</strong></td>
    <td><input type="text" name="head_email_id" id="head_email_id" class="input_txt" value="<?php echo $head_email_id; ?>" maxlength="15"/></td>
  </tr>
   <tr>
    <td ><strong>Total No. of Members in Association/Company as on date</strong></td>
    <td><input type="text" name="total_member" id="total_member" class="input_txt" value="<?php echo $total_member; ?>" maxlength="10"/></td>
  </tr>
   <?php if($parichay_type=="M" || $parichay_type=="NM"){ ?>
	<tr>
	<td><strong>Business Nature</strong></td>	
    <td><table border="0" cellspacing="0" cellpadding="0" class="bottomSpace">
      <tbody><tr>
        <td><input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Jewellery" <?php if(preg_match('/Jewellery/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>Jewellery</td>
        <td><input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Diamond" <?php if(preg_match('/Diamond/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>> Diamond</td>
        <td><input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Coloured_Gemstone" <?php if(preg_match('/Coloured_Gemstone/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>Coloured Gemstone</td>
		<td><input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Retailer" <?php if(preg_match('/Retailer/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>> Retailer</td>
        <td><input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Job_work" <?php if(preg_match('/Job_work/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>Job Work</td>
		<td><input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Laboratory_Grown_Diamonds" <?php if(preg_match('/Laboratory_Grown_Diamonds/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>Laboratory Grown Diamonds</td>
      </tr>
    </tbody>
	</table></td>
    </tr>
   <?php } ?>
   <?php if($parichay_type=="association"){ ?>
   <tr>
	<td><strong>Profile of Members in your association</strong></td>	
    <td><table border="0" cellspacing="0" cellpadding="0" class="bottomSpace">
      <tbody><tr>
        <td><input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Exporters" <?php if(preg_match('/Exporters/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>Exporters</td>
        <td><input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Manufacturer" <?php if(preg_match('/Manufacturer/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>> Manufacturer</td>
		<td><input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Retailer" <?php if(preg_match('/Retailer/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>> Retailer</td>
        <td> <input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Brokers" <?php if(preg_match('/Brokers/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>> Brokers</td>		
        <td><input type="checkbox" name="nature_of_buisness[]" id="nature_of_buisness" value="Karigars" <?php if(preg_match('/Karigars/',$nature_of_buisness)){ echo 'checked="checked"'; } ?>>Karigars</td>
      </tr>
    </tbody>
	</table></td>
    </tr>
   <?php } ?>
   <tr class="orange1"><td colspan="11">Official Address of the Company/Association</td></tr>

	<tr>
       <td class="content_txt">Address Line1 </td>
       <td class="text6"><?php echo $address_line1; ?></td>
    </tr>     
     <tr>
       <td class="content_txt">Address Line2 </td>
       <td class="text6"><?php echo $address_line2; ?></td>
     </tr>         
     <tr>
       <td class="content_txt">State </td>
       <td class="text6"><?php echo getState($state,$conn); ?></td>
     </tr>     
     <tr>
       <td class="content_txt">City </td>
       <td class="text6"><?php echo $city; ?></td>
     </tr> 
	 <tr>
       <td class="content_txt">Pin Code </td>
       <td class="text6"><?php echo $pin_code; ?></td>
     </tr> 
	 <tr>
       <td class="content_txt">No. of Parichay Cards required by your Company/Association</td>
       <td class="text6"><?php echo $no_of_parichay_card; ?></td>
     </tr>
	<tr>  
	<td>Scanned proof of address of Association/Company</td>
	<td> 
	<?php if(!empty($association_office_address)){ ?>
	<a href="../images/parichay_card/association_office_address/<?php echo $association_office_address;?>" target="_blank" class="gold_clr"><strong> View </strong></a><?php } ?>
	</td>
	</tr>
	
	<tr class="orange1"><td colspan="11">Details of Authorised person from Company/Association for coordination and verification of information</td></tr>
	<tr>
    <td><strong>Full Name</strong></td>
    <td><input type="text" name="authorised_person" id="authorised_person" class="input_txt" value="<?php echo $authorised_person; ?>"/></td>
    </tr>
	<tr>
    <td><strong>Designation</strong></td>
    <td><input type="text" name="authorised_designation" id="authorised_designation" class="input_txt" value="<?php echo $authorised_designation; ?>"/></td>
    </tr>
	<tr>
    <td><strong>Mobile 1</strong></td>
    <td><input type="text" name="authorised_mobile1" id="authorised_mobile1" class="input_txt" value="<?php echo $authorised_mobile1; ?>"/></td>
    </tr>
	<tr>
    <td><strong>Mobile 2</strong></td>
    <td><input type="text" name="authorised_mobile2" id="authorised_mobile2" class="input_txt" value="<?php echo $authorised_mobile2; ?>"/></td>
    </tr>
	<tr>
    <td><strong>Email</strong></td>
    <td><input type="text" name="authorised_email" id="authorised_email" class="input_txt" value="<?php echo $authorised_email; ?>" readonly/></td>
    </tr>
  <?php if($adminID!=165 && $adminID!=166 && $adminID!=167 && $adminID!=168 && $adminID!=169 && $adminID!=170){ ?>
  <tr>
    <td><strong>Application Approval Status</strong></td>
    <td>
    <input type='radio' name='approval_status' id='regapprove' value='Y' <?php if($approval_status=='Y'){ echo "checked='checked'"; }?>/>Approve
	<input type='radio' name='approval_status' id='regdisapprove' value='D' <?php if($approval_status=='D'){ echo "checked='checked'"; }?>/>Disapprove
	<input type='radio' name='approval_status' id='regpending' value='P' <?php if($approval_status=='P'){ echo "checked='checked'"; }?>/>Pending
    </td>
  </tr>
  <tr id="reg_disapprove">
    <td><strong>Disapprove Reason</strong></td>
    <td><textarea name="disapprove" id="disapprove" cols="25"><?php echo $disapprove_reason;?></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>
    <input type="submit" value="Submit" class="input_submit"/>
    <input type="hidden" name="actions" id="actions" value="<?php echo $actions;?>" />
    <input type="hidden" name="regid" id="regid"  value="<?php echo $_REQUEST['regid'];?>" />
    </td>
  </tr>
  <?php } ?>
</table>
</form> 

</div> 
<?php } ?>
 
</div>
</div>

<div id="footer_wrap"><?php include("include/footer.php");?></div>

</body>
</html>