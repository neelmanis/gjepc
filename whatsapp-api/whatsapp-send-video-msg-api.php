<?php
$mobile = "9834797281";

$apiurl = sendVideoMsg($mobile);
print_r($apiurl);
$getResult = json_decode($apiurl,true);

if($getResult['response']['status']=="success")
{
	echo $getResult['response']['status'];
} else { 
	echo $getResult['response']['details'];
}

function sendVideoMsg($mobile)
{
	$mobile = trim($mobile);

	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=SendMediaMessage&format=json&userid=2000193705&password=S%23FgLwhc&send_to=".$mobile."&v=1.1&auth_scheme=plain&isHSM=true&msg_type=VIDEO";
	$url.="&media_url=https://gjepc.org/video/igjs.mp4";
	$url.="&caption=Dear%20Member%2C%20%0A%0AGreetings%20from%20IIJS!%0A%0AWelcome%20to%20IIJS%2C%20We%20pleased%20to%20inform%20you%20that%20your%20registration%20is%2010-02-2021.%20%0A%0APlease%20login%20with%20iijs.org%20to%20access%20the%20login%20%0A%0ATeam%0A%0AKindly%20login%20to%20visit%20iijs%20at%20gjepc.org%0A%0ARegards%2C%0A%0ATeam%20IIJS.";
	$url.="&isTemplate=true&buttonUrlParam=send";
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
?>