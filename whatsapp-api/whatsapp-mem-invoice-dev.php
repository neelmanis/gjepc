<?php
$mobile = "9619662253";
/* First optin API After that Msg API */
$apiurl = sendOPTIN($mobile);
print_r($apiurl);
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

function sendSms($mobile)
{
	$mobile = trim($mobile);
	$fy = "2021-22";
	$registration_id = "600714127";
	$link = "https://gjepc.org/rcmc/membership.php?registration_id=".$registration_id;

	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=SendMessage&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$mobile."&v=1.1&auth_scheme=plain&msg_type=TEXT";
	//$url.="&msg=Dear%20Sir%2C%0AThank%20you%20for%20renewing%20your%20Membership%20for%20the%20year%202021-22.%20Please%20click%20here%20for%20Invoice%20%26%20Membership%20certificate%20%20%20https%3A%2F%2Fgjepc.org%2Frcmc%2Fmembership.php%3Fregistration_id%3D600714127%20%20%20also%20note%20that%20Membership%20Certificate%20and%20invoice%20will%20also%20available%20on%20your%20dais%20board%20for%20your%20records%20%0A%20%0ARegards%2C%0ATeam%20Membership%20GJEPC"; 
	$url.="&msg=Dear%20Sir%2C%0AThank%20you%20for%20renewing%20your%20Membership%20for%20the%20year%20".$fy.".%20Please%20click%20here%20for%20Invoice%20%26%20Membership%20certificate%20%20%20https%3A%2F%2Fgjepc.org%2Frcmc%2Fmembership.php%3Fregistration_id%3D".$registration_id."%20%20%20also%20note%20that%20Membership%20Certificate%20and%20invoice%20will%20also%20available%20on%20your%20dashboard%20for%20your%20records%20%0A%20%0ARegards%2C%0ATeam%20Membership%20GJEPC"; 
	//$url.="&isTemplate=true&buttonUrlParam=abcdxyz";
//echo $url; exit;
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