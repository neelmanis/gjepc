<?php
$mobile = "7045795199";

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
		if($code ==312){ echo $msg; } else { echo "Mobile No $phone has been successfully ".$msg; }
	}
} else { 
	echo $getResult['response']['details'];
}

function sendOPTIN($mobile)
{
	$mobile = trim($mobile);
/*prod	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=OPT_IN&format=json&userid=2000193706&password=dCtjkxnX&phone_number=".$mobile; */
	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=OPT_IN&format=json&userid=2000193705&password=S%23FgLwhc&phone_number=".$mobile;
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