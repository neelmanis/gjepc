<?php include('header_include.php');?>

<?php
$action=$_REQUEST['action'];
if($action=='ADD')
{
$applicant_name=mysql_real_escape_string($_REQUEST['applicant_name']);
$applicant_company_name=mysql_real_escape_string($_REQUEST['applicant_company_name']);
$applicant_email_id=mysql_real_escape_string($_REQUEST['applicant_email_id']);
$applicant_mobile_no=mysql_real_escape_string($_REQUEST['applicant_mobile_no']);
$applicant_country=mysql_real_escape_string($_REQUEST['applicant_country']);
$applicant_state=mysql_real_escape_string($_REQUEST['applicant_state']);
$hotel_id=mysql_real_escape_string($_REQUEST['hotel_id']);
$hotel_details_id=mysql_real_escape_string($_REQUEST['hotel_details_id']);
$no_of_room=mysql_real_escape_string($_REQUEST['no_of_room']);
$guest_name=mysql_real_escape_string($_REQUEST['guest_name']);
$guest_company_name=mysql_real_escape_string($_REQUEST['guest_company_name']);
$guest_email_id=mysql_real_escape_string($_REQUEST['guest_email_id']);
$guest_mobile_no=mysql_real_escape_string($_REQUEST['guest_mobile_no']);
$guest_city=mysql_real_escape_string($_REQUEST['guest_city']);
$guest_country=mysql_real_escape_string($_REQUEST['guest_country']);
$sharer_name=mysql_real_escape_string($_REQUEST['sharer_name']);

$arrival_flight_no=mysql_real_escape_string($_REQUEST['arrival_flight_no']);
$arrival_from=mysql_real_escape_string($_REQUEST['arrival_from']);
$arrival_date=$_REQUEST['arrival_dd']."-".$_REQUEST['arrival_mm']."-".$_REQUEST['arrival_yyyy'];
$arrival_time=$_REQUEST['arrival_hh'].":".$_REQUEST['arrival_ss']." ".$_REQUEST['arrival_am'];
$departure_flight_no=mysql_real_escape_string($_REQUEST['departure_flight_no']);
$departure_from=mysql_real_escape_string($_REQUEST['departure_from']);
$departure_date=$_REQUEST['departure_dd']."-".$_REQUEST['departure_mm']."-".$_REQUEST['departure_yyyy'];
$departure_time=$_REQUEST['departure_hh'].":".$_REQUEST['departure_ss']." ".$_REQUEST['departure_am'];
$check_in_date=$_REQUEST['ck_in_dd']."-".$_REQUEST['ck_in_mm']."-".$_REQUEST['ck_in_yyyy'];
$check_in_time=$_REQUEST['ck_in_hh'].":".$_REQUEST['ck_in_ss']." ".$_REQUEST['ck_in_am'];
$check_out_date=$_REQUEST['ck_out_dd']."-".$_REQUEST['ck_out_mm']."-".$_REQUEST['ck_out_yyyy'];
$check_out_time=$_REQUEST['ck_out_hh'].":".$_REQUEST['ck_out_ss']." ".$_REQUEST['ck_out_am'];
$total_payable=mysql_real_escape_string($_REQUEST['total_payable']);
$credit_card_type=mysql_real_escape_string($_REQUEST['credit_card_type']);
$any_other=mysql_real_escape_string($_REQUEST['any_other']);
$credit_card_no=mysql_real_escape_string($_REQUEST['credit_card_no']);
$exp_mm=mysql_real_escape_string($_REQUEST['exp_mm']);
$exp_yyyy=mysql_real_escape_string($_REQUEST['exp_yyyy']);
$ip_address=$_SERVER['REMOTE_ADDR'];
$post_date=date("Y-m-d");

$sqlhotel="INSERT INTO  `iijs_hotel_registration_details` (`applicant_name` ,`applicant_company_name` ,`applicant_email_id` ,`applicant_mobile_no` ,`applicant_country` ,`applicant_state`,`hotel_id` ,`hotel_details_id` ,`no_of_room` ,`guest_name` ,`guest_company_name` ,`guest_email_id` ,`guest_mobile_no` ,`guest_city` ,`guest_country` ,`sharer_name` ,`arrival_flight_no` ,`arrival_from` ,`arrival_date` ,`arrival_time` ,`departure_flight_no` ,`departure_from` ,`departure_date` ,`departure_time` ,`check_in_date` ,`check_in_time` ,`check_out_date` ,`check_out_time` ,`total_payable` ,`credit_card_type` ,`any_other` ,`credit_card_no` ,`exp_mm` ,`exp_yyyy` ,`status` ,`ip_address` ,`post_date`)VALUES ('$applicant_name' ,  '$applicant_company_name',  '$applicant_email_id',  '$applicant_mobile_no','$applicant_country','$applicant_state','$hotel_id',  '$hotel_details_id',  '$no_of_room',  '$guest_name',  '$guest_company_name',  '$guest_email_id',  '$guest_mobile_no',  '$guest_city',  '$guest_country',  '$sharer_name',  '$arrival_flight_no',  '$arrival_from',  '$arrival_date',  '$arrival_time',  '$departure_flight_no',  '$departure_from',  '$departure_date','$departure_time',  '$check_in_date',  '$check_in_time',  '$check_out_date',  '$check_out_time',  '$total_payable',  '$credit_card_type',  '$any_other',  '$credit_card_no',  '$exp_mm',  '$exp_yyyy',  '1',  '$ip_address',  '$post_date')";

 $resulthotel=mysql_query($sqlhotel);
 $id=mysql_insert_id();
 $message ='<table width="96%" bgcolor="#fbfbfb" style="margin:2% auto; border:2px solid #ddd; font-family:Arial, sans-serif; color:#333333; font-size:13px; border-radius:10px;">

<tr>
<td style="padding:30px;">
    <table width="100%" border="0px" background="#fbfbfb" cellpadding="0px" cellspacing="0px">
    
    <tr>
    <td align="left"> <img src="http://www.gjepc.org/emailer_gjepc/Mailer/logos/iijs.png" width="190px"> </td>
	<td align="right" height="60px"><img src="http://iijs.org/images/gjepc_logo.png"  width="200"  border="0" /></td>
    </tr>
    
    
    <tr>
    <td></td>
    <td align="right"></td>
    </tr>
    
    <tr>
    <td align="right" colspan="2" height="30px"><hr /></td>
    </tr>
   
   <tr>
    <td colspan="2" style="font-size:13px; line-height:22px;">
    
   <p> Dear '.$applicant_name.',</p>
   
   <p>Thank you for confirming your presence at IIJS 2016. Our representative will get in touch with you shortly via your email address submitted in the form.</p>
   <p>Below are the reservation details provided by you:-</p>
<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="300" style="font-weight:bold">Hotel Name</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.getHotelName($hotel_id).'</td>
  </tr>
  <tr>
    <td width="300" style="font-weight:bold">Email ID</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.$guest_email_id.'</td>
  </tr>
  <tr>
    <td width="300" style="font-weight:bold">Guest Name</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.ucfirst($guest_name).'</td>
  </tr>
  <tr>
    <td width="300" style="font-weight:bold">Company Name</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.ucfirst($guest_company_name).'</td>
  </tr>
  <tr>
    <td width="300" style="font-weight:bold">Mobile No</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.$guest_mobile_no.'</td>
  </tr>
  
<!--  <tr>
    <td width="300" style="font-weight:bold">City</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.ucfirst($guest_city).'</td>
  </tr>
  <tr>
    <td width="300" style="font-weight:bold">Country</td>
    <td width="50">:</td>
    <td width="300" style="color:#751b53;">'.getguestcountry($guest_country).'</td>
  </tr>-->
 
  
</table>

<p></p>

<table width="542" border="0" cellspacing="0" cellpadding="0" style="border:1px solid #ccc;">
  <tr style="background:#CCCCCC;">
    <td width="279" style="border:1px solid #ccc;"><p align="center"><strong>Room   Type</strong></p></td>
    <td width="122" style="border:1px solid #ccc;"><p align="center"><strong>No. Of   Rooms</strong></p></td>
    <td width="141" style="border:1px solid #ccc;"><p align="center"><strong>Cost   in INR</strong></p></td>
  </tr>
  <tr style="background:#fff;">
    <td style="border:1px solid #ccc;"><p align="center">'.getRoomType($hotel_details_id).'</p></td>
    <td style="border:1px solid #ccc;"><p align="center">'.$no_of_room.'</p></td>
    <td style="border:1px solid #ccc;"><p align="center">'.$total_payable.'</p></td>
  </tr>
</table>

<p></p>

<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="160" style="font-weight:bold">Arrival Flight No.</td>
    <td width="21">:</td>
    <td width="219" style="color:#751b53;">'.$arrival_flight_no.'</td>
  </tr>
  <tr>
    <td width="160" style="font-weight:bold">Departure Flight No.</td>
    <td width="21">:</td>
    <td width="219" style="color:#751b53;">'.$departure_flight_no.'</td>
  </tr>
  <tr>
    <td width="160" style="font-weight:bold">Check-In</td>
    <td width="21">:</td>
    <td width="219" style="color:#751b53;">'.$check_in_date.'</td>
  </tr>
  <tr>
    <td width="160" style="font-weight:bold">Check-Out</td>
    <td width="21">:</td>
    <td width="219" style="color:#751b53;">'.$check_out_date.'</td>
  </tr>
  <tr>
    <td width="160" style="font-weight:bold">&nbsp;</td>
    <td width="21">&nbsp;</td>
    <td width="219" style="color:#751b53;">&nbsp;</td>
  </tr>
  <tr>
    <td width="160" style="font-weight:bold">Credit Card No.</td>
    <td width="21">:</td>
    <td width="219" style="color:#751b53;">'.substr_replace($credit_card_no, str_repeat("X", 12),0, 12).'</td>
  </tr>
  <tr>
    <td width="160" style="font-weight:bold">Expiry Date </td>
    <td width="21">:</td>
    <td width="219" style="color:#751b53;">'.$exp_mm.'/'.$exp_yyyy.'</td>
  </tr>
  <tr>
    <td width="160" style="font-weight:bold">Credit Card Type </td>
    <td width="21">:</td>
    <td width="219" style="color:#751b53;">'.$credit_card_type.'</td>
  </tr>
 
</table>

<p></p>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#751b53">
    <td style="text-align:center; color:#fff;">Copyright , IIJS 2016. All Rights Reserved.</td>
  </tr>
</table>
   </td>
    </tr>
    
    <tr>
    <td align="right" colspan="2" height="30px"><hr /></td>
    </tr>
	
    <tr>
   <!-- <td align="right" colspan="2" height="30px" style="text-align:left;"><b>Note:</b> We do not have any triple occupancy rooms available in any of the hotels. Please provide credit card numbers with the expiry date to hold the reservation on a guaranteed basis. Reservations not guaranteed by credit card will not be confirmed. In the event of "no-show" or cancellation, following is applicable:<br><br>-->
   <td align="right" colspan="2" height="30px" style="text-align:left;"><b>Please Note:</b><br><br> 
	1) All reservations are to be guaranteed with a valid credit card/advance payment.<br>
	2) Kindly share with us your credit card number along with the expiration date to hold the reservation on a guaranteed basis. Reservations not guaranteed by credit card will not be confirmed .<br>
	3) 100% retention for the entire length of stay will be applicable incase of any No-Show .<br />
	4) 100% retention for the entire length of stay will be applicable for any cancellation/amendments post 15th July 2016.<br />
    5) The credit card shared will be considered as a guarantee for the reservation made and the same will be charged in the event of any No Show or Cancellation for the above booking .<br />
    6) Airport Transfers will be organised only on receipt of flight details.<br />
	7) The hotels currently do not have triple occupancy rooms available.<br />
	8) The Check In time at the hotel for all guests is 1400 hrs (02:00 pm). Guests arriving prior to this time will be allocated rooms as soon as they become available.  For all early check-ins, we recommend that rooms are reserved and paid for the night before in order to guarantee early check-in.<br />
	9) The Check Out time at the hotel for all guests is 1200 hrs (12:00 pm), late check outs will  be subject to availability upon request.</td>
    </tr>
    
    <tr>
    <td colspan="2" align="center" style="font-size:13px; line-height:22px;">    
   </td>
    </tr>
    </table>



</td>

<map name="Map" id="Map"><area shape="rect" coords="0,0,185,67" href="https://www.iijs-signature.org/"  target="_blank" style="outline:none;"/><area shape="rect" coords="82,58,83,71" href="#" /></map>
<map name="Map2" id="Map2">

<area shape="rect" coords="2,0,312,68" href="https://www.gjepc.org/"  target="_blank" style="outline:none;" />
</map>

</tr>

</table>';
  if($hotel_id==1)
	{
		$hotel_email_id="kris.reynolds@hyatt.com";
	}
	else if($hotel_id==2)
	{
		$hotel_email_id="h6451-re@sofitel.com";
	}
	else if($hotel_id==4)
	{
		$hotel_email_id="mumresv@thelalit.com,mumgroupresv@thelalit.com";
	}
	else if($hotel_id==5)
	{
		$hotel_email_id="aliasgar.chulawala@hyatt.com";
	}
	else if($hotel_id==6)
	{
		$hotel_email_id="groups.mumbai@theleela.com";
	}
	else if($hotel_id==7)
	{
		$hotel_email_id="Pooja.kalyankar@marriott.com";
	}
	else if($hotel_id==8)
	{
		$hotel_email_id="Pooja.kalyankar@marriott.com";
	}
	else if($hotel_id==9)
	{
		$hotel_email_id="Pooja.kalyankar@marriott.com";
	}
	else if($hotel_id==10)
	{
		$hotel_email_id="sonam.verma@oberoigroup.com";
	}
	
	
	//$to =$applicant_email_id.','.$guest_email_id.','.$hotel_email_id.',hotels@gjepcindia.com';
	 $to = "mukesh@kwebmaker.com";
	 $subject = "Hotel Registration Application Status - IIJS 2017"; 
	 $headers  = 'MIME-Version: 1.0' . "\n"; 
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\n"; 
	 $headers .= 'From: Hotel IIJS 2017 <admin@gjepc.org>';	
	
	mail($to, $subject, $message, $headers);
header("location: thanks.php?id=$id");
exit;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>IIJS - Hotel Registration</title>

<link rel="shortcut icon" href="images/fav.png" />

<link rel='stylesheet' type='text/css' href='https://fonts.googleapis.com/css?family=Cabin'>

<link rel="stylesheet" type="text/css" href="css/general.css" />
<link rel="stylesheet" type="text/css" href="css/inner_pg_style.css" />
<link rel="stylesheet" type="text/css" href="css/form.css" />
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<!--<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>-->
<!-- Menu -->
<link rel="stylesheet" type="text/css" href="css/ddsmoothmenu.css" />
<link href="css/flexnav.css" media="screen, projection" rel="stylesheet" type="text/css">
<script src="js/jquery.flexnav.js" type="text/javascript"></script>
<script src="js/common.js"></script> 
<!--<script type="text/javascript" src="js/ddsmoothmenu.js"></script>-->
<link rel="stylesheet" type="text/css" href="css/ddaccordion.css" />
<script type="text/javascript">

ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

</script>
<!-- UItoTop plugin -->
<link rel="stylesheet" type="text/css" media="screen,projection" href="css/ui.totop.css" />
<script src="js/easing.js" type="text/javascript"></script>
<script src="js/jquery.ui.totop.js" type="text/javascript"></script>    
<script type="text/javascript">
    $(document).ready(function() {        
        $().UItoTop({ easingType: 'easeOutQuart' });        
    });
</script>

<script src="jsvalidation/jquery.validate.js" type="text/javascript"></script> 
<link rel="stylesheet" type="text/css" media="screen" href="css/rcmc.validation.css" /> 
<!--<script type="text/javascript" src="js/creditcard.js"></script>-->


<script type="text/javascript">
function formValidator()
{
	
	if(document.getElementById('applicant_name').value == '')
	{
		alert("Please Enter Applicant Name");
		document.getElementById('applicant_name').focus();
		return false;
	}
	if(document.getElementById('applicant_company_name').value == '')
	{
		alert("Please Enter Company Name");
		document.getElementById('applicant_company_name').focus();
		return false;
	}
	if(document.getElementById('applicant_email_id').value == '')
	{
		alert("Please enter Email ID.");
		document.getElementById('applicant_email_id').focus();
		return false;
	}
	if(echeck(document.getElementById('applicant_email_id').value)==false)
	{
		document.getElementById('applicant_email_id').focus();
		return false;
	}
	if(document.getElementById('applicant_mobile_no').value == '')
	{
		alert("Please Enter Mobile No.");
		document.getElementById('applicant_mobile_no').focus();
		return false;
	}
	if(!IsNumeric(document.getElementById('applicant_mobile_no').value))
	{
		alert("Please enter valid Mobile No.")
		document.getElementById('applicant_mobile_no').focus();
		return false;
	}
	if(document.getElementById('applicant_mobile_no').value.length < 10)
	{
		alert("Please enter 10 digit Mobile No.");
		document.getElementById('applicant_mobile_no').focus();
		return false;
	}
	
	if(document.getElementById('applicant_country').value == '')
	{
		alert("Please Select Country");
		document.getElementById('applicant_country').focus();
		return false;
	}
	if(document.getElementById('applicant_state').value == '')
	{
		alert("Please Select State");
		document.getElementById('applicant_state').focus();
		return false;
	}
	if(document.getElementById('hotel_id').value == '')
	{
		alert("Please Select Hotel Name");
		document.getElementById('hotel_id').focus();
		return false;
	}
	
	if(document.getElementById('hotel_details_id').value == '')
	{
		alert("Please Select Room Type");
		document.getElementById('hotel_details_id').focus();
		return false;
	}
	
	if(document.getElementById('no_of_room').value == '')
	{
		alert("Please Enter Room Number");
		document.getElementById('no_of_room').focus();
		return false;
	}	
	
	if(!IsNumeric(document.getElementById('no_of_room').value))
	{
		alert("Please enter Numeric Value Only.")
		document.getElementById('no_of_room').focus();
		return false;
	}
	
	if(document.getElementById('guest_name').value == '')
	{
		alert("Please Enter Guest Name");
		document.getElementById('guest_name').focus();
		return false;
	}
	if(document.getElementById('guest_company_name').value == '')
	{
		alert("Please Enter Guest Company Name");
		document.getElementById('guest_company_name').focus();
		return false;
	}
	if(document.getElementById('guest_email_id').value == '')
	{
		alert("Please enter Guest Email ID.");
		document.getElementById('guest_email_id').focus();
		return false;
	}
	if(echeck(document.getElementById('guest_email_id').value)==false)
	{
		document.getElementById('guest_email_id').focus();
		return false;
	}
	if(document.getElementById('guest_mobile_no').value == '')
	{
		alert("Please Enter Guest Mobile No.");
		document.getElementById('guest_mobile_no').focus();
		return false;
	}
	if(!IsNumeric(document.getElementById('guest_mobile_no').value))
	{
		alert("Please enter valid Mobile No.")
		document.getElementById('guest_mobile_no').focus();
		return false;
	}
	if(document.getElementById('guest_mobile_no').value.length < 10)
	{
		alert("Please enter 10 digit Mobile No.");
		document.getElementById('guest_mobile_no').focus();
		return false;
	}
	
	
	
	if(document.getElementById('ck_in_dd').value == '')
	{
		alert("Please Select CheckIn Date");
		document.getElementById('ck_in_dd').focus();
		return false;
	}
	if(document.getElementById('ck_in_mm').value == '')
	{
		alert("Please Select CheckIn Date");
		document.getElementById('ck_in_mm').focus();
		return false;
	}
	if(document.getElementById('ck_in_yyyy').value == '')
	{
		alert("Please Select CheckIn Date");
		document.getElementById('ck_in_yyyy').focus();
		return false;
	}
	if(document.getElementById('ck_in_hh').value == '')
	{
		alert("Please Select CheckIn Time");
		document.getElementById('ck_in_hh').focus();
		return false;
	}
	if(document.getElementById('ck_in_ss').value == '')
	{
		alert("Please Select CheckIn Time");
		document.getElementById('ck_in_ss').focus();
		return false;
	}
	if(document.getElementById('ck_in_am').value == '')
	{
		alert("Please Select CheckIn Time");
		document.getElementById('ck_in_am').focus();
		return false;
	}
	
	if(document.getElementById('ck_out_dd').value == '')
	{
		alert("Please Select CheckOut Date");
		document.getElementById('ck_out_dd').focus();
		return false;
	}
	if(document.getElementById('ck_out_mm').value == '')
	{
		alert("Please Select CheckOut Date");
		document.getElementById('ck_out_mm').focus();
		return false;
	}
	if(document.getElementById('ck_out_yyyy').value == '')
	{
		alert("Please Select CheckOut Date");
		document.getElementById('ck_out_yyyy').focus();
		return false;
	}
	if(document.getElementById('ck_out_hh').value == '')
	{
		alert("Please Select CheckOut Time");
		document.getElementById('ck_out_hh').focus();
		return false;
	}
	if(document.getElementById('ck_out_ss').value == '')
	{
		alert("Please Select CheckOut Time");
		document.getElementById('ck_out_ss').focus();
		return false;
	}
	if(document.getElementById('ck_out_am').value == '')
	{
		alert("Please Select CheckOut Time");
		document.getElementById('ck_out_am').focus();
		return false;
	}
	if(document.getElementById('total_payable').value == '')
	{
		alert("Please Calculate Total Payable");
		document.getElementById('total_payable').focus();
		return false;
	}
	if(document.getElementById('credit_card_type').value == '')
	{
		alert("Please Select Credit Card Type");
		document.getElementById('credit_card_type').focus();
		return false;
	}
	if(document.getElementById('credit_card_no').value == '')
	{
		alert("Please Enter Credit Card Number");
		document.getElementById('credit_card_no').focus();
		return false;
	}
	if(!IsNumeric(document.getElementById('credit_card_no').value))
	{
		alert("Please enter valid Credit Card No.")
		document.getElementById('credit_card_no').focus();
		return false;
	}
	
	if(document.getElementById('credit_card_type').value=="AmEx")
	{
		if(document.getElementById('credit_card_no').value.length < 15)
		{
			alert("Please enter 15 digit credit card No.");
			document.getElementById('credit_card_no').focus();
			return false;
		}
	}
	else 
	{
		if(document.getElementById('credit_card_no').value.length < 16)
		{
			alert("Please enter 16 digit credit card No.");
			document.getElementById('credit_card_no').focus();
			return false;
		}
	}

	var expd = document.getElementById('exp_mm').value;
	if(document.getElementById('exp_mm').value == '')
	{
		alert("Please Select Credit Card Expiry Month");
		document.getElementById('exp_mm').focus();
		return false;
	}
	if(document.getElementById('exp_yyyy').value == '')
	{
		alert("Please Select Credit Card Expiry Year");
		document.getElementById('exp_yyyy').focus();
		return false;
	}
	if(document.getElementById('exp_yyyy').value == '')
	{
		alert("Please Select Credit Card Expiry Year");
		document.getElementById('exp_yyyy').focus();
		return false;
	}
	if(document.getElementById("agree").checked==false)
	{
		alert("Please Check Terms & Conditions");
		document.getElementById('agree').focus();
		return false;
	}
	
	/*credit_card_no = document.getElementById('credit_card_no').value;
 	credit_card_type = document.getElementById('credit_card_type').value;
  
	if (!checkCreditCard (credit_card_no,credit_card_type)) {
		alert (ccErrors[ccErrorNo]);
		document.getElementById('credit_card_no').focus();
		return false;
	}*/
	
	

	
}

function echeck(str) 
{
	var at="@"
	var dot="."
	var lat=str.indexOf(at)
	var lstr=str.length
	var ldot=str.indexOf(dot)
	if (str.indexOf(at)==-1){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
	   alert("Invalid E-mail ID")
	   return false
	}
	if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		alert("Invalid E-mail ID")
		return false
	}
	 if (str.indexOf(at,(lat+1))!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(dot,(lat+2))==-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 if (str.indexOf(" ")!=-1){
		alert("Invalid E-mail ID")
		return false
	 }
	 return true					
}

function IsNumeric(strString)
{
   var strValidChars = "0123456789,\. /-";
   var strChar;
   var blnResult = true;

   //if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
   {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
			blnResult = false;
         }
   }
   return blnResult;
}

</script>

<script>
$(document).ready(function(){
$("#applicant_country").change(function(){
	country=$("#applicant_country").val();
	$.ajax({ type: 'POST',
					url: 'ajax_hotel.php',
					data: "actiontype=getState&country="+country,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							    // alert(data);
							     $("#stateDiv").html(data);  
							}
		});
 });

	$("#hotel_id").change(function(){
	hotel_id=$("#hotel_id").val();
	$.ajax({ type: 'POST',
					url: 'ajax_hotel.php',
					data: "actiontype=getRoom&hotel_id="+hotel_id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     ///alert(data);
							     $("#hotelDiv").html(data);  
							}
		});
 	});
	
	
	/*$("#hotel_details_id").change(function(){
	hotel_details_id=$("#hotel_details_id").val();
	$.ajax({ type: 'POST',
					url: 'ajax_hotel.php',
					data: "actiontype=getRoom&hotel_id="+hotel_id,
					dataType:'html',
					beforeSend: function(){
							},
					success: function(data){
							     ///alert(data);
							     $("#hotelDiv").html(data);  
							}
		});
 	});*/
	
	
	$("#hotel_details_id").live('change',function(){
	hotel_details_id=$("#hotel_details_id").val();
	if(hotel_details_id==2 || hotel_details_id==4 || hotel_details_id==6 || hotel_details_id==8 || hotel_details_id==10 || hotel_details_id==12|| hotel_details_id==14 || hotel_details_id==16 || hotel_details_id==18 || hotel_details_id==20)
	{
		$('#share_div').show("");
	}else
	{
		$('#share_div').hide("");
	}
		$.ajax({ 
			type: 'POST',
			url: 'ajax_hotel.php',
			data: "actiontype=getRate&hotel_details_id="+hotel_details_id,
			dataType:'html',
			beforeSend: function(){
						   },
			success: function(data){
								$("#rateDiv").html(data);  
								//alert(data);
			}
		});
	});
	
	/*$("#hotel_details_id").live('change',function(){
	hotel_details_id=$("#hotel_details_id").val();
	if(hotel_details_id==2 || hotel_details_id==4 || hotel_details_id==6 || hotel_details_id==8 || hotel_details_id==10 || hotel_details_id==12|| hotel_details_id==14 || hotel_details_id==16 || hotel_details_id==18 || hotel_details_id==20)
	{
		$('#share_div').show("");
	}else
	{
		$('#share_div').hide("");
	}
	});*/
	
	$("#cal_total_pay").click(function(){
	ck_in_dd=$("#ck_in_dd").val();
	//alert(ck_in_dd);
	ck_out_dd=$("#ck_out_dd").val();
	//alert(ck_out_dd);
	no_of_room=$("#no_of_room").val();
	hotel_details_id=$("#hotel_details_id").val();
	$.ajax({ type: 'POST',
	url: 'ajax_hotel.php',
	data: "actiontype=calculatePayment&ck_in_dd="+ck_in_dd+"&ck_out_dd="+ck_out_dd+"&hotel_details_id="+hotel_details_id+"&no_of_room="+no_of_room,
	dataType:'html',
	beforeSend: function(){
				   },
	success: function(data){  
						//alert(data);
						$('#total_payable').val(data);
		}
	  });
	
});
});
 </script>
<SCRIPT type="text/javascript">
$(document).ready(function(){
	$("#ck_in_dd").change(function(){
		ck_in_dd=$("#ck_in_dd").val();
		$.ajax({ type: 'POST',
		url: 'ajax_hotel.php',
		data: "actiontype=getoutDate&ck_in_dd="+ck_in_dd,
		dataType:'html',
		beforeSend: function(){
					   },
		success: function(data){  
				$('#ck_out_dd').html(data);
			}
		});
	});
});
</SCRIPT>

</head>

<body>

<div class="wrapper">

<div class="header">
	<?php include('header1.php'); ?>
</div>

<!--<div class="index_banner">

<div class="banner_area">
    
    <div class="menu_area">
    <div class="menu_shdw_l"></div>
		<?php //* include('menus/general.php'); ?>
    <div class="menu_shdw_r"></div>
    </div>

	<div class="shdw_l"></div>        
    <div class="shdw_r"></div>    
        
	<img src="images/banners/council.jpg" />

</div>

</div>-->

<div class="new_banner">
<img src="images/banners/banner.jpg" />
</div>

<div class="inner_container">

	<div class="breadcrum"><a href="index.php">Home</a> > Hotel Registration</div>    
    <div class="clear"></div>
    
    <div class="content_area">
    
    <div class="pg_title">
    
    <div class="title_cont">
        <span class="top">Hotel <img src="images/titles/joint.png" style="position:absolute; top:31px; right:0px;" /></span>   
        <span class="below">Registration</span>
        <div class="clear"></div>
    </div>
    
    </div> 
    <div class="clear"></div>
    
    
    <form name="form1" method="post" enctype="multipart/form-data" onsubmit="return formValidator()">
    <input type="hidden" name="action" value="ADD" /> 
    <div id="formContainer">
    <div id="form">
    
    <div class="title">Applicant Details</div>
    <div class="borderBottom"></div>
    
  	<table border="0" cellspacing="0" cellpadding="0" class="formManual">
   <tr>
    <td width="19%">Name <sup>*</sup> :</td>
    <td width="30%"><input type="text" name="applicant_name" id="applicant_name" class="bgcolor" /></td>
    <td width="3%">&nbsp;</td>
    <td width="18%">Company Name <sup>*</sup> :</td>
    <td width="30%"><input type="text" name="applicant_company_name" id="applicant_company_name" class="bgcolor" /></td>
  </tr>
  
  <tr>
    <td>Email ID <sup>*</sup> :</td>
    <td><input type="text" name="applicant_email_id" id="applicant_email_id" class="bgcolor" /></td>
    <td>&nbsp;</td>
    <td>Mobile No  <sup>*</sup> :</td>
    <td><input type="text" name="applicant_mobile_no" id="applicant_mobile_no" class="bgcolor" /></td>
  </tr>
  
  <tr>
    <td>Country <sup>*</sup> :</td>
    <td><select name="applicant_country" id="applicant_country" class="bgcolor">
      <option value="" selected="selected">-- Select -- </option>
      <?php 
	$sql="SELECT * FROM  `country_master` where status=1";

	  $result=mysql_query($sql);
	  while($rows=mysql_fetch_array($result))
	  {
	  echo "<option value='$rows[country_code]'>$rows[country_name]</option>"; 
	  }
	  ?>
    </select></td>
    <td>&nbsp;</td>
    <td>State  <sup>*</sup> :</td>
    <td id="stateDiv">
    <select name="applicant_state" id="applicant_state" class="bgcolor">
      <option value="" selected="selected">-- Select -- </option>
      <?php 
	  $sql="SELECT * from state_master WHERE country_code = 'IND'";
	  $result=mysql_query($sql);
	  while($rows=mysql_fetch_array($result))
	  {
	  echo "<option value='$rows[state_code]'>$rows[state_name]</option>";	  	  }
	  ?>
    </select>
    </td>
  </tr>

</table>
    
    <div class="clear" style="height:15px;"></div>
    
    <div class="title">Hotel Information</div>
    <div class="borderBottom"></div>
    
    <table border="0" cellspacing="0" cellpadding="0" class="formManual">
   <tr>
    <td width="19%">Hotel Name <sup>*</sup> :</td>
    <td width="30%"><select name="hotel_id" id="hotel_id" class="bgcolor">
      <option value="" selected="selected">-- Select -- </option>
        <?php 
		  $sql1="SELECT * FROM  `iijs_hotel_master` where status=1";
		  $result1=mysql_query($sql1);
		  while($rows1=mysql_fetch_array($result1))
		  {
			  if($rows1['hotel_id']==$_REQUEST['hid'])
			  {
		           echo "<option value='$rows1[hotel_id]' selected='selected'>$rows1[hotel_name]</option>"; 
			  }else
			  {
				  echo "<option value='$rows1[hotel_id]'>$rows1[hotel_name]</option>";
			  }
		  }
		 ?>
    </select></td>
    <td width="3%">&nbsp;</td>
    <td width="18%">Rate :</td>
    <td width="30%" id="rateDiv">Rs. 0/-</td>
  </tr>
  
  <tr>
    <td>Room Type <sup>*</sup> :</td>
    <td id="hotelDiv"><select name="hotel_details_id" id="hotel_details_id" class="bgcolor">
        
        <?php 
        $query=mysql_query("SELECT * from iijs_hotel_details WHERE hotel_id = '$_REQUEST[hid]'");
		?>
	  	<option value="">--Select Room Type--</option>
        <?php while($result=mysql_fetch_array($query)){?>
        <option value="<?php echo $result['hotel_details_id'];?>"><?php echo $result['room_name'];?></option>
		<?php }?>
      </select></td>
    <td>&nbsp;</td>
    <td>No of Rooms  <sup>*</sup> :</td>
    <td><input type="text" name="no_of_room" id="no_of_room" class="bgcolor" /></td>
  </tr>
</table>

    
    <div class="clear" style="height:15px;"></div>
    
    <div class="title">Guest Information</div>
    <div class="borderBottom"></div>
    
    <table border="0" cellspacing="0" cellpadding="0" class="formManual">
   <tr>
    <td width="19%">Name <sup>*</sup> :</td>
    <td width="30%"><input type="text" name="guest_name" id="guest_name" class="bgcolor" /></td>
    <td width="3%">&nbsp;</td>
    <td width="18%">Company Name <sup>*</sup> :</td>
    <td width="30%"><input type="text" name="guest_company_name" id="guest_company_name" class="bgcolor" /></td>
  </tr>
  
  <tr>
    <td>Email ID <sup>*</sup> :</td>
    <td><input type="text" name="guest_email_id" id="guest_email_id" class="bgcolor" /></td>
    <td>&nbsp;</td>
    <td>Mobile No  <sup>*</sup> :</td>
    <td><input type="text" name="guest_mobile_no" id="guest_mobile_no" class="bgcolor" /></td>
  </tr>
  
  <!--<tr>
    <td>City <sup>*</sup> :</td>
    <td><input type="text" name="guest_city" id="guest_city" class="bgcolor" /></td>
    <td>&nbsp;</td>
    <td>Country  <sup>*</sup> :</td>
    <td>
    <select name="guest_country" id="guest_country" class="textField">
      <option value="" selected="selected">-- Select -- </option>
      <?php 
	  /*$sql="SELECT * FROM  `country_master` where status=1";
	  $result=mysql_query($sql);
	  while($rows=mysql_fetch_array($result))
	  {
	  echo "<option value='$rows[id]'>$rows[country_name]</option>"; 
	  }*/
	  ?>
    </select>
    </td>
  </tr> --> 
 <tr id="share_div" style="display:none;">
    <td>Sharer Name :</td>
    <td><input type="text" name="sharer_name" id="sharer_name" class="bgcolor" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  
</table>

    
    <div class="clear" style="height:15px;"></div>
    
    <div class="title">Flight Schedule</div>
    <div class="borderBottom"></div>
    
    <table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="19%">Arrival Flight No :</td>
    <td width="30%"><input type="text" name="arrival_flight_no" id="arrival_flight_no" class="bgcolor" /></td>
    <td width="3%">&nbsp;</td>
    <td width="18%">Arrival From :</td>
    <td width="30%"><input type="text" name="arrival_from" id="arrival_from" class="bgcolor" /></td>
  </tr>
  <tr>
    <td>Arrival Date :</td>
    <td>
    <select name="arrival_dd" id="arrival_dd" class="bgcolor" style="width:54px;">
        <option value="" selected="selected">DD</option>
		<option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option> 
       
        
        </select>
    <select name="arrival_mm" id="arrival_mm" class="bgcolor" style="width:55px;">
      <option value="07">07</option>
    </select>
    <select name="arrival_yyyy" id="arrival_yyyy" class="bgcolor" style="width:70px;">
      <option value="2017">2017</option>
      </select>
      
    </td>
    <td>&nbsp;</td>
    <td>Arrival Time : </td>
    <td>
    <select name="arrival_hh" id="arrival_hh" class="bgcolor" style="width:50px;">
        <option value="" selected="selected">HH</option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        </select>
      <select name="arrival_ss" id="arrival_ss" class="bgcolor" style="width:55px;">
        <option value="" selected="selected">MM</option>
        <option value="00">00</option>
        <option value="05">05</option>
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="25">25</option>
        <option value="30">30</option>
        <option value="35">35</option>
        <option value="40">40</option>
        <option value="45">45</option>
        <option value="50">50</option>
        <option value="55">55</option>
      </select>
      <select name="arrival_am" id="arrival_am" class="bgcolor" style="width:70px;">
        <option value="AM" selected="selected">AM</option>
        <option value="PM">PM</option>
      </select>
    </td>
  </tr>
  <tr>
    <td>Departure Flight No :</td>
    <td><input type="text" name="departure_flight_no" id="departure_flight_no" class="bgcolor" /></td>
    <td>&nbsp;</td>
    <td>Departure From :</td>
    <td><input type="text" name="departure_from" id="departure_from" class="bgcolor" /></td>
  </tr>
  <tr>
    <td>Departure Date :</td>
    <td>
    <select name="departure_dd" id="departure_dd" class="bgcolor" style="width:54px;">
        <option value="" selected="selected">DD</option>		       
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
		<option value="01">01</option>
		<option value="02">02</option> 
        
        </select>
      <select name="departure_mm" id="departure_mm" class="bgcolor" style="width:55px;">
        
        <option value="07">07</option>
        <option value="08">08</option>
      </select>
      <select name="departure_yyyy" id="departure_yyyy" class="bgcolor" style="width:70px;">
        <option value="2017">2017</option>
      </select>
    </td>
    <td>&nbsp;</td>
    <td>Departure Time :</td>
    <td>
    <select name="departure_hh" id="departure_hh" class="bgcolor" style="width:50px;">
        <option value="" selected="selected">HH</option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        </select>
      <select name="departure_ss" id="departure_ss" class="bgcolor" style="width:55px;">
        <option value="" selected="selected">MM</option>
        <option value="00">00</option>
        <option value="05">05</option>
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="25">25</option>
        <option value="30">30</option>
        <option value="35">35</option>
        <option value="40">40</option>
        <option value="45">45</option>
        <option value="50">50</option>
        <option value="55">55</option>
      </select>
      <select name="departure_am" id="departure_am" class="bgcolor" style="width:70px;">
        <option value="AM" selected="selected">AM</option>
        <option value="PM">PM</option>
      </select>
    </td>
  </tr>
 

  
</table>

    
    <div class="clear" style="height:15px;"></div>
    
    <div class="title">Check-In Check-Out Details</div>
    <div class="borderBottom"></div>
    
    <table border="0" cellspacing="0" cellpadding="0" class="formManual">
  <tr>
    <td width="19%">Check-In Date <sup>*</sup> :</td>
    <td width="30%"><select name="ck_in_dd" id="ck_in_dd" class="bgcolor" style="width:54px;">
        <option value="" selected="selected">DD</option>
		<option value="24">24</option>
        <option value="25">25</option>
        <option value="26">26</option>
        <option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option> 
        
        
        </select>
      <select name="ck_in_mm" id="ck_in_mm" class="bgcolor" style="width:55px;">
        
        <option value="07">07</option>
      </select>
      <select name="ck_in_yyyy" id="ck_in_yyyy" class="bgcolor" style="width:70px;">
        
        <option value="2017">2017</option>
      </select>
    </td>
    <td width="3%">&nbsp;</td>
    <td width="18%">Check-In Time <sup>*</sup> :</td>
    <td width="30%">
     <select name="ck_in_hh" id="ck_in_hh" class="textField" style="width:55px;">
        <option value="" selected="selected">HH</option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        </select>
      <select name="ck_in_ss" id="ck_in_ss" class="textField" style="width:55px;">
        <option value="" selected="selected">MM</option>
        <option value="00">00</option>
        <option value="05">05</option>
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="25">25</option>
        <option value="30">30</option>
        <option value="35">35</option>
        <option value="40">40</option>
        <option value="45">45</option>
        <option value="50">50</option>
        <option value="55">55</option>
      </select>
      <select name="ck_in_am" id="ck_in_am" class="textField" style="width:55px;">
        <option value="AM" selected="selected">AM</option>
        <option value="PM">PM</option>
      </select>
    </td>
    </tr>
  
  
  <tr>
    <td>Check-Out Date <sup>* </sup> :</td>
    <td>
    <select name="ck_out_dd" id="ck_out_dd" class="textField" style="width:54px;">
		<option value="" selected="selected">DD</option>
		<option value="27">27</option>
        <option value="28">28</option>
        <option value="29">29</option>
        <option value="30">30</option>
        <option value="31">31</option>
		<option value="01">01</option>
		<option value="02">02</option> 
    </select>
      <select name="ck_out_mm" id="ck_out_mm" class="textField" style="width:55px;">
        
        <option value="07">07</option>
        <option value="08">08</option>
      </select>
      <select name="ck_out_yyyy" id="ck_out_yyyy" class="textField" style="width:70px;">
        
        <option value="2017">2017</option>
      </select>
    
    </td>
    <td>&nbsp;</td>
    <td>Check-Out Time <sup>*</sup> :</td>
    <td>
     <select name="ck_out_hh" id="ck_out_hh" class="textField" style="width:55px;">
        <option value="" selected="selected">HH</option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
        </select>
      <select name="ck_out_ss" id="ck_out_ss" class="textField" style="width:55px;">
        <option value="" selected="selected">MM</option>
        <option value="00">00</option>
        <option value="05">05</option>
        <option value="10">10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="25">25</option>
        <option value="30">30</option>
        <option value="35">35</option>
        <option value="40">40</option>
        <option value="45">45</option>
        <option value="50">50</option>
        <option value="55">55</option>
      </select>
      <select name="ck_out_am" id="ck_out_am" class="textField" style="width:55px;">
        <option value="AM" selected="selected">AM</option>
        <option value="PM">PM</option>
      </select>
    </td>
  </tr>
 
</table>

    
    <div class="clear" style="height:15px;"></div>
    
    <div class="title">Payment Details</div>
    <div class="borderBottom"></div>
    
    <table border="0" cellpadding="0" cellspacing="0" class="formManual">
  <tr>
    <td width="22%">Total Payable :</td>
    <td width="30%"><input type="text" name="total_payable" id="total_payable" class="bgcolor" readonly="readonly" /></td>
    <td width="18%"><input name="cal_total_pay" id="cal_total_pay" type="button" value="CALCULATE" style="height:30px; padding:3px 10px;" /></td>
    <td width="30%">&nbsp;</td>
  </tr>
</table>

    
    <div class="clear" style="height:15px;"></div>
    
    <div class="title">Credit Card Details</div>
    <div class="borderBottom"></div> 
        
    <table border="0" cellpadding="0" cellspacing="0" class="formManual">
    <tr>
    <td width="22%">Credit Card Details <sup>*</sup> :</td>
    <td width="30%">
    <select name="credit_card_type" id="credit_card_type" class="bgcolor">
      <option value="" selected="selected">-- Select -- </option>
      <option value="AmEx">American Express</option>
      <option value="Visa">Visa Card</option>
      <option value="MasterCard">Master Card</option>
      <option value="DinersClub">Dinners Card</option>
    </select></td>
    <td width="18%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
    </tr>
    <tr>
    <td width="22%">Credit Card Number  : <br />(Don't include space)</td>
    <td width="30%"><input type="text" name="credit_card_no" id="credit_card_no" class="bgcolor" maxlength="16" /></td>
    <td width="18%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
    </tr>
    <tr>
    <td width="22%">Expiry Date :</td>
    <td width="30%">
      <select name="exp_mm" id="exp_mm" class="bgcolor" style="width:60px;">
        <option value="" selected="selected">MM</option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
      </select>
      <select name="exp_yyyy" id="exp_yyyy" class="bgcolor" style="width:70px;">
        <option value="" selected="selected">YYYY</option>
        <option value="2016">2016</option>
        <option value="2017">2017</option>
        <option value="2018">2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
        <option value="2020">2021</option>
        <option value="2020">2022</option>
        <option value="2020">2023</option>
        <option value="2020">2024</option>
      </select></td>
    <td width="18%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
    </tr>
    </table>
    
    
    <div class="clear" style="height:15px;"></div>
    
    <div class="title">Terms & conditions</div>
    <div class="borderBottom"></div> 
    
    <ol style="list-style:decimal;">
    <li>All reservations are to be guaranteed with a valid credit card/advance payment.</li>
    <li>Kindly share with us your credit card number along with the expiration date to hold the reservation on a guaranteed basis. Reservations not guaranteed by credit card will not be confirmed.</li>
    <li>100% retention for the entire length of stay will be applicable incase of any No-Show.</li>
    <li>100% retention for the entire length of stay will be applicable for any cancellation/amendments post 10th July 2017. </li>
    <li>The credit card shared will be considered as a guarantee for the reservation made and the same will be charged in the event of any No Show or Cancellation for the above booking.</li>
    <li>Airport Transfers will be organised only on receipt of flight details. </li>
	<li>The hotels currently do not have triple occupancy rooms available. </li>
	<li>The Check In time at the hotel for all guests is 1400 hrs (02:00 pm). Guests arriving prior to this time will be allocated rooms as soon as they become available.  For all early check-ins, we recommend that rooms are reserved and paid for the night before in order to guarantee early check-in.</li>
	<li>The Check Out time at the hotel for all guests is 1200 hrs (12:00 pm), late check outs will be subject to availability upon request.</li>
    </ol>

    
    <!--<p>We do not have any triple occupancy rooms available in any of the hotels. Please advice credit card number with the expiry date to hold the reservation on a guaranteed basis. Reservations not guaranteed by credit card will not be confirmed. In the event of "no-show" or cancellation, following is applicable :</p>
    
    <ol style="list-style:decimal;">
    <li>Any cancellation after the <strong>25th of June 2014</strong>, will attract 100% retention on the entire booking.</li>
    <li>In case of NO - Show the entire length of stay will be charged to the credit card.</li>
    <li>Please note airport transfers would be arranged only on receipt of flight details.</li>
    </ol>-->

    <div class="clear" style="height:15px;"></div>

<p><input type="checkbox" name="agree" id="agree" checked="checked" /> <sup>*</sup> I agree the above mentioned Terms & Conditions.</p>
    
    	<div class="clear"></div>
     
        
    <table border="0" cellpadding="0" cellspacing="0" class="formManual">
    <tr>
    <td><input name="input2" type="submit" value="Submit" /></td>
    </tr>
    </table>
       
    
    <div class="clear"></div>
    </div>
    </div>    
	</form>     
     
    <div class="clear"></div>
	</div>

	<div class="right_area">
    
    <?php include('include_account_links.php'); ?>
    
    <div class="clear"></div>
    </div>
 

<div class="clear" style="height:10px;"></div>
</div>

<div class="footer">
	<?php include('footer.php'); ?>
<div class="clear"></div>
</div>

<div class="clear"></div>
</div>

</body>
</html>
