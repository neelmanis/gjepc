<?php
include('db.inc.php');
$url = "";
$env = "UAT"; //UAT OR PROD

if($env =="UAT"){
	$url .= "http://testapi.mykycbank.com/service.svc"; // UAT
} else {
	$url .= "http://api.mykycbank.com/service.svc";	   // PROD
}

	$registration_id = 600896658; //New Member Registration ID

/*............................Get PAN and GST of HO.............................*/
	$qho = $conn->query("SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' and type_of_address='2' limit 1");
	$rho = $qho->fetch_assoc();
	$hopanno=strtoupper($rho['pan_no']);
	$hogstno=strtoupper($rho['gst_no']);
	$hoBPno=$rho['c_bp_number'];
	$hoAddress1 = $rho['address1'];
	$hoAddress2 = $rho['address2'];
	$hoState = $rho['state'];
	$hoCity = $rho['city'];
	$hoPincode = $rho['pincode'];
	$hoLandline_no = $rho['landline_no1'];
	$fax = $rho['fax_no1'];
	$hoEmail_id = $rho['email_id'];
	
	
	$commAddress = "SELECT * FROM `communication_address_master` WHERE `registration_id` = '$registration_id' AND `type_of_address`='13'";
	$result = $conn->query($commAddress);
	$addressRow = $result->fetch_assoc();
	$FIRST_NAME = $addressRow['name'];	
	$LAST_NAME = '';
	$mobile_no = $addressRow['mobile_no'];
		
	$regis = "SELECT * FROM `registration_master` WHERE `registration_id` = '$registration_id'";
	$regisResult = $conn->query($regis);
	$rowy = $regisResult->fetch_assoc();
	$company_type = $rowy['company_type'];
	
	$info = "SELECT * FROM `information_master` WHERE `registration_id` = '$registration_id'";
	$infoResult = $conn->query($info);
	$rows = $infoResult->fetch_assoc();
	$company_name = $rows['company_name'];
	$year_of_starting_bussiness = $rows['year_of_starting_bussiness'];
	
	$BUSINESS_SEGMENT = '';
	
echo  $url .='?BPID='.$hoBPno.
			 '&COMPANY_NAME='.$company_name.
			 '&BUSINESS_SEGMENT='.$company_type.
			 '&FIRST_NAME='.$FIRST_NAME.
			 '&LAST_NAME='.$LAST_NAME.
			 'Address1='.$hoAddress1.
			 '&Address2='.$hoAddress2.
			 '&state='.$hoState.
			 '&city='.$hoCity.
			 '&pincode='.$hoPincode.
			 '&landline='.$hoLandline_no.
			 '&fax='.$fax.
			 '&email='.$hoEmail_id.
			 '&incorporation_type='.$incorporation_type.
			 '&year_of_starting_bussiness='.$year_of_starting_bussiness.
			 '&mobile_no='.$mobile_no.
			 ''; 

header("Location: ".$url);
exit;
//Incorporation Type
// Business Segment

/*http://testapi.mykycbank.com/service.svc?BPID=7000052385&COMPANY_NAME=SHIRISH%20SPARKLE%20GEMS&BUSINESS_SEGMENT=&FIRST_NAME=MR.%20SHIRISH%20KUMAR%20SHEKHAWAT&LAST_NAME=Address1=2026%201ST%20FLOOR%20PITALIYO%20KA%20CHOWK&Address2=JOHARI%20BAZAR&state=20&city=JAIPUR&pincode=302003&landline=01414036682&fax=&email=shirish.sparklegems@gmail.com&incorporation_type=&year_of_starting_bussiness=25-01-2019&mobile_no=9887590786*/
?>