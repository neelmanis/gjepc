<?php
include('../db.inc.php');
//$mobile = "7045795199,9619662253,8879310457";

$sqlx = "SELECT c.registration_id,i.company_name,b.type_of_comaddress_name,c.type_of_address,c.c_bp_number,c.name,c.mobile_no FROM `approval_master` a,`type_of_comaddress_master` b, `information_master` i ,`communication_address_master` c WHERE c.type_of_address = b.id and c.`registration_id`=i.`registration_id` AND c.`registration_id`=a.`registration_id` and a.eligible_for_renewal='Y' AND c.type_of_address='7' AND c.mobile_no!='' AND c.mobile_no!=0 AND c.name!='' GROUP BY c.mobile_no order by i.company_name ";
$result = $conn ->query($sqlx);
while($row = $result->fetch_assoc())
{   //echo '<pre>'; print_r($row);
	//echo $mobile = trim($row['mobile_no']);    echo "<br/>";
	
$apiurl = sendMediaMsg($mobile);
//print_r($apiurl);
$getResult = json_decode($apiurl,true);

if($getResult['response']['status']=="success")
{
	echo $getResult['response']['status'];
} else { 
	echo $getResult['response']['details'];
}
}

function sendMediaMsg($mobile)
{
	$mobile = trim($mobile);

	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=SendMediaMessage&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$mobile."&v=1.1&auth_scheme=plain&isHSM=true";
	$url.="&msg_type=IMAGE";
	$url.="&media_url=https://www.gjepc.org/whatsapp-api/images/igjs.jpeg";
	$url.="&caption=Dear%20Member%2C%0A%0ARegistration%20for%20IGJS%20Dubai%20is%20Open.%20%0A%0AKindly%20login%20to%20apply%20at%20https%3A%2F%2Fintl.gjepc.org%2Fexhibitor-login%20%0A%0ARegards%2C%0A%0ATeam%20IGJS%20Dubai.";
//	$url.="&isTemplate=true";
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