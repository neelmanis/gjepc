<?php
include('../db.inc.php');
//$mobile = "9834797281";
$mobile = "9619662253";
$name = "neel";



	
$apiurl = sendMediaMsg($mobile,$name);

$getResult = json_decode($apiurl,true);

if($getResult['response']['status']=="success")
{
	echo $getResult['response']['status'];
} else { 
	echo $getResult['response']['details'];
}


function sendMediaMsg($mobile,$name)
{
	$mobile = trim($mobile);
	$name = str_replace(" ","%20",$name);
    
	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=SendMediaMessage&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$mobile."&v=1.1&auth_scheme=plain&isHSM=true";
	$url.="&msg_type=DOCUMENT";
	$url.="&media_url=https://gjepc.org/pdf/solitaire/Solitaire-International-Weekly-Digest-(Edition-20).pdf";

	$url.="&caption=Dear%20".$name."%2C%0A%0AYour%20Request%20for%20Solitaire%20International%20is%20here.%0A%0AYou%20can%20now%20access%20Solitaire%20International%20Weekly%20Digest%2C%20Edition%20XXII.%0A%0AKindly%20login%20in%20to%20https%3A%2F%2Fgjepc.org%2Fsolitaire%2F%20to%20read%20more%0A%0ARegards%2C%0A%0ATeam%20Solitaire%20International";
	$url.="&filename=SOLITARE%20INTERNATIONAL%20WEEKLY%20DIGEST";
//echo $url; exit;

	//$headers = array("Content-Type: application/json");
				 
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