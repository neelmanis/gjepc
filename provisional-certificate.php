<?php
session_start(); ob_start();
include 'db.inc.php';
//include 'functions.php';

if(!isset($_SESSION['USERID'])){ header('location:login.php'); exit; } 
$registration_id = intval(filter($_SESSION['USERID'])); 
?>
<?php 
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

	$year=2022;
	$fetch_data="select * from approval_master where registration_id='$registration_id' ";
	$fetch_user="select * from registration_master where id='$registration_id'";
	$fetch_panel="select * from communication_details_master where registration_id='$registration_id'";
	$fetch_address ="select * from communication_address_master where registration_id='$registration_id' and type_of_address=2";
	$fetch_pin="select * from information_master where registration_id='$registration_id'";
	$fetch_transaction="select Transaction_Date,total_payable from challan_master where registration_id='$registration_id' and challan_financial_year='$year'";
	
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
	
	if($rows_transaction['total_payable']==1180){ $gmember = "MICRO"; } else { $gmember = ""; }
	
	//$date=date('d/m/Y',strtotime($rows['membership_issued_certificate_dt']));
	$date=date('d/m/Y',strtotime($rows['invoice_date']));
	
	$first_name = $rows_user['first_name'];
	$last_name = $rows_user['last_name']; 
	$company_name = strtoupper(str_replace(array('&amp;','&AMP;'), '&', $rows_user['company_name']));
					 
	$address_line1=$rows_address['address1'];
	$address_line1=strtoupper(str_replace(array('&amp;','&AMP;'), '&', $address_line1));
	
	$address_line2=$rows_address['address2'];
	$address_line2=strtoupper(str_replace(array('&amp;','&AMP;'), '&', $address_line2));
	
	$address_line3=$rows_address['address3'];
	$address_line3=strtoupper(str_replace(array('&amp;','&AMP;'), '&', $address_line3));
	
	$city = strtoupper($rows_address['city']);
	
	$state=$rows_address['state'];
	$state_decode=$rows_address['state'];
	
	$state=strtoupper(getStateName($state,$conn));
	if($state == '')
		$state=strtoupper($state_decode);
	
	$country=$rows_address['country'];

	$pinCode = $rows_address['pincode'];
	$region_id = $rows_pin['region_id'];
	$address = getRegionAddress($region_id,$conn);
	
	$reg_tel_no = getRegionTelno($region_id,$conn);
	$reg_email = getRegionEmail($region_id,$conn);
	$reg_fax = getRegionFax($region_id,$conn);
		
	$panel_name = strtoupper($rows_panel['panel_name']);
		
	//$merchant_certificate_no=$rows['merchant_certificate_no'];
	$membership_certificate_type = $rows['membership_certificate_type'];
	if($membership_certificate_type!=''){
		if($membership_certificate_type=="ZASSOC")
		{
			$membership_certificate_type="ASSOCIATE";
		}
		if($membership_certificate_type=="ZORDIN")
		{
			$membership_certificate_type="ORDINARY";
		}
	} else { $membership_certificate_type="ASSOCIATE"; }
	
	$membership_ids=$rows['membership_id'];
	$signing_authority=$rows['signing_authority'];
	//$memID  = "GJEPC/1020/G14250/OM/IV";
	$hocode1 = ['/1010/','/1020/','/1030/', '/1040/', '/1050/','/1060/'];
	$ho1   = ['/HO-MUM (M)/','/RO-JAI/','/RO-SRT/', '/RO-CHE/', '/RO-DEL/','/RO-KOL/'];
	$membership_id = str_replace($hocode1, $ho1, $membership_ids);
	$membership_type=$rows['eligible_for_renewal'];
	$print_date = date('d/m/Y',strtotime($rows_transaction['Transaction_Date']));
		
	if($region_id=="HO-MUM (M)")
	{
		$hod = 'Mithilesh Pandey';
		$designation = 'DIRECTOR - HEAD MEMBERSHIP';
	}
	elseif($region_id=="RO-DEL")
	{
		$hod = 'SURUCHI KHINDRIA';
		$designation = 'ASST. DIRECTOR';
	}
	elseif($region_id=="RO-SRT")
	{		
		$hod = 'RAJAT WANI';
		$designation = 'ASST. DIRECTOR';
	}
	elseif($region_id=="RO-JAI")
	{
		$hod = 'Nitin Khandelwal';
		$designation = 'DEPUTY DIRECTOR';
	}
	elseif($region_id=="RO-KOL")
	{
		$hod = 'Nitin Khandelwal';
		$designation = 'DEPUTY DIRECTOR';
	}
	elseif($region_id=="RO-CHE")
	{
		$hod = 'Surya Narayanan';
		$designation = 'ASST. DIRECTOR';
	}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
	<title>Provisional Certificate</title>
	<link rel="shortcut icon" href="assets/images/fav_icon.png">
	<style>
	#divtoprint { width:80%; margin:0 auto;	}
	</style>
</head>
<body>

<div id="divtoprint">
<!--<table style="margin:0 auto; text-align:center; font-family: 'Roboto', sans-serif; font-size:12px;" cellpadding="0" cellspacing="0" align="center"><a onClick="PrintContent();" target="_blank" style="cursor:pointer;float:right;color:#FF0000;font-size:13px;">Print</a>-->

<table width="80%" align="center" style="margin:2% auto; border:1px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;padding:10px;">

<a onClick="PrintContent();" target="_blank" style="cursor:pointer;float:right;color:#FF0000;font-size:13px;">Print</a>
  <tbody>
    <tr>
        <td align="left">&nbsp;</td>
        <td align="right"><img src="https://gjepc.org/assets/images/logo.png"></td>
    </tr>
      <tr><td colspan="3" height="30"><hr></td></tr>
      <tr>
		
        <td colspan="3" id="content">

          <table width="100%">
            <tr>
              <td align="left">Ref. No.: GJC/P/FRM/2022-2023</td>
              <td align="right">Date : <?php echo $print_date;?></td>
            </tr>
          </table>

          <p style="line-height:22px;"><strong>
		  <?php echo $company_name.' <br />'.$address_line1.'<br />'. $address_line2.'<br />'. $address_line3.'<br />'. $city.' : '.$pinCode.'<br />';?></strong></p>

          <p style="line-height:22px;" align="center"><strong><?php echo $membership_certificate_type;?> MEMBERSHIP CERTIFICATE</strong></p>

          <p style="line-height:22px;" align="center"><strong>sub: Enrollment as an <?php echo $membership_certificate_type;?> Member for the year 2022-2023</strong></p>

          <p style="line-height:22px;">Dear Sir,</p>

          <p style="line-height:22px;">We welcome you in GJEPC family & our best wishes for your future association with Council.</p>

          <p style="line-height:22px;">We acknowledge receipt of your application dated <?php echo $print_date;?> for Enrollment as an <?php echo $membership_certificate_type;?> Member for the year 2022-2023.</p>

          <p style="line-height:22px;">We have pleasure to inform you that your membership has been enrolled as an <?php echo $membership_certificate_type;?> Member of the Council for the year 2022-2023.</p>

          <!--<p style="line-height:22px;">Your <?php echo $membership_certificate_type;?> Membership Number is <strong> GJEPC/HO-MUM (M)/7000038423/AM/I.</strong></p>-->

          <p style="line-height:22px;">Your membership has been enrolled under the <strong><?php echo $panel_name?> </strong> Panel.</p>

          <p style="line-height:22px;">With reference to the provisions of Article 5.3 of Memorandum & Article of Association of the Council, this membership certificate and RCMC thereof are being issued provisionally, subject to approval of your membership by Committee of Administration or its assigned Committee / authority of the Council. (subject to submission of all documents ) If you do not receive any further communication within 3 (three) months from the date of your application for membership with the Council, this membership and RCMC will be deemed to have been accepted by the Council and you will be inducted as an associate member of the Council from the date of issue of certificate.</p>

          <p style="line-height:22px;">You are requested to ensure submission of all the online forms along with the relevant supporting documents (duly signed by Proprietor/Partner/Director as the case may be) in the manner as prescribed by GJEPC, vide email  <a href="mailto:membership@gjepcindia.com">membership@gjepcindia.com </a>Or upload on GJEPC portal.</p>

          <p style="line-height:22px;">Members are also requested to ensure dispatch of bank attested signature slip  through post/courier to respective Council’s offices within 15 days .</p>

          <p style="line-height:22px;">FOLLOWING DOCUMENTS TO BE SUBMITTED TO HEAD OFFICE OR RESPECTIVE REGIONAL OFFICE OF GJEPC:</p>

          <ul style="line-height:22px;">
            <li>Application form for Associate Membership, Application form for (RCMC) and challan form duly signed by Proprietor/Partner/Director as the case may be.</li>
            <li>Signature Slip (Online form) signed by Proprietor/Partner/Director as the case may be and attested by banker of applicant.</li>
            <li>Self-attested copy of Import Export Code (IEC) issued by O/o Director General of Foreign Trade.</li>
            <li>Self-attested copy of PAN and Partnership Deed / Memorandum & Articles of Association as the case may be.</li>
            <li>Self-attested copy of MSME(UAN)/SSI/IM, if applied under Manufacturer category.</li>
            <li>Self-attested copy GST certificate (for all states if office/branches situated in different states), Not applicable for Micro Associate Membership.</li>
            <li>Self-attested copy of PAN, Passport and Aadhar of Proprietor /Partner / Director as the case may be</li>
          </ul>

          <p style="line-height:22px;">In addition to the submission of above-mentioned documents completion of MYKYC is mandatory , within a maximum period of three months from the date of this certificate, for issuance of Registration-cum- Membership Certificate ( RCMC)</p>


          <p style="line-height:22px;"><strong>In case of non- receipt of the original signed documents within the above-mentioned period, the Membership will stand as cancelled.</strong></p>

          <p style="line-height:22px;">Yours truly, </p>

          <p style="line-height:22px;"><?php echo $hod;?> <br>
<?php echo $designation;?><br>
The Gem & Jewellery Export Promotion Council <br>
  <?php echo $address.' <br />';?></strong>
</p>    
      </td>
                  
    </tr>
      
        <tr>
            <td colspan="3" height="30"><hr></td>
        </tr>
        
        <tr>
            <td align="center" colspan="3">
            

              <p><i>This certificate is digitally signed and does not require physical signature.</i></p>
                
                <p style="line-height:22px;">
                    <b>The Gem &amp; Jewellery Export Promotion Council</b><br>AW 1010, Tower A, 1st Flr, Bharat Diamond Bourse, Bandra-Kurla Complex, Bandra (E), Mumbai - 51,India 
 <br> Tel: 91 22-42263600 , E-mail: <a href="mailto:membership@gjepcindia.com">membership@gjepcindia.com</a> 
                </p>

                
                
                
            </td>
        </tr>    
           
  </tbody>
    
</table>
</div>
</body>
</html>
<script type="text/javascript">
function PrintContent(){
	var DocumentContainer = document.getElementById("divtoprint");
	var WindowObject = window.open("", "PrintWindow","width=1200,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
	WindowObject.document.writeln(DocumentContainer.innerHTML);
	WindowObject.document.close();
	WindowObject.focus();
	WindowObject.print();
	WindowObject.close();
}
</script>