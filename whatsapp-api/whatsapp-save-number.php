<?php
include('../db.inc.php');
//$mobile = "9619662253";


$sqlx = "SELECT c.registration_id,i.company_name,b.type_of_comaddress_name,c.type_of_address,c.c_bp_number,c.name,c.mobile_no FROM `approval_master` a,`type_of_comaddress_master` b, `information_master` i ,`communication_address_master` c WHERE c.type_of_address = b.id and c.`registration_id`=i.`registration_id` and c.`registration_id`=a.`registration_id` and a.eligible_for_renewal='Y' AND c.type_of_address='7' AND c.mobile_no!='' and c.mobile_no!=0 GROUP BY c.mobile_no order by i.company_name limit 1";
$result = $conn ->query($sqlx);
while($row = $result->fetch_assoc())
{   //echo '<pre>'; print_r($row);
	//echo $mobile = trim($row['mobile_no']); echo " <br/>";
	 
$apiurl = sendOPTIN($mobile); 
//print_r($apiurl);
$getResult = json_decode($apiurl,true);
if($getResult['response']['status']=="success")
{
	foreach($getResult['data'] as $value)
	{
		$code = $value[0]['id'];
		$msg  = $value[0]['details'];
		$phone = $value[0]['phone'];
		
		$msgurl = sendSms($mobile);
		$getResults = json_decode($msgurl,true);
		if($getResults['response']['status']=="success")
		{
			echo $getResults['response']['status'];
		} else { 
			echo $getResults['response']['details'];
		}		
	}
} else { 
	echo $getResult['response']['details'];
}
}


function sendSms($mobile)
{
	$mobile = trim($mobile);

	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=SendMessage&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$mobile."&v=1.1&auth_scheme=plain&msg_type=TEXT";
	$url.="&msg=Greetings!%20%0A%0AWelcome%20to%20GJEPC%20India%20on%20WhatsApp.%0A%0AClick%20on%20ADD%20button%20%F0%9F%91%86%20and%20save%20this%20number%20%2B918657896948%20as%20GJEPC%20India%20in%20your%20contact%20list.%20%0A%0AYou%20will%20start%20receiving%20services%20from%20GJEPC%20within%2024%20hrs.%20%0A%0AThank%20You!%0A%0AGJEPC%20India.";
	//$url.="&isTemplate=true&buttonUrlParam=abcdxyz";

	$headers = array("Content-Type: application/json");
				 
    $curl = curl_init();
    $timeout = 5;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	
    $response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
		header('Content-type: application/json');
		return $response;
	// echo $response;
	}
}

function sendOPTIN($mobile)
{
	$mobile = trim($mobile);
	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=OPT_IN&format=json&userid=2000193706&password=dCtjkxnX&phone_number=".$mobile; 
	$url.="&v=1.1&auth_scheme=plain&channel=WHATSAPP";
	
	$headers = array("Content-Type: application/json");
				 
    $curl = curl_init();
    $timeout = 5;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	
    $response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);
	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
		header('Content-type: application/json');
		return $response;
	// echo $response;
	}
}
?>