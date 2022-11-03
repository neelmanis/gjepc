<?php
include('../db.inc.php');

$mobile = "7045795199,9619662253,9834797281";
$name = "Pradeesh";  
$count = "2486";

$sqlx = "SELECT c.registration_id,i.company_name,b.type_of_comaddress_name,c.type_of_address,c.c_bp_number,c.name,c.mobile_no FROM `approval_master` a,`type_of_comaddress_master` b, `information_master` i ,`communication_address_master` c WHERE c.type_of_address = b.id and c.`registration_id`=i.`registration_id` AND c.`registration_id`=a.`registration_id` AND c.type_of_address='7' AND c.mobile_no!='' AND c.mobile_no!=0 AND c.name!='' GROUP BY c.mobile_no order by i.company_name limit 1";

//$sqlx = "SELECT c.registration_id,i.company_name,b.type_of_comaddress_name,c.type_of_address,c.c_bp_number,c.name,c.mobile_no FROM `approval_master` a,`type_of_comaddress_master` b, `information_master` i ,`communication_address_master` c WHERE c.type_of_address = b.id and c.`registration_id`=i.`registration_id` AND c.`registration_id`=a.`registration_id` and a.eligible_for_renewal='Y' AND c.type_of_address='7' AND c.mobile_no!='' AND c.mobile_no!=0 AND c.name!='' GROUP BY c.mobile_no order by i.company_name limit 1";

//$sqlx = "SELECT c.registration_id,i.company_name,b.type_of_comaddress_name,c.type_of_address,c.c_bp_number,c.name,c.mobile_no FROM `approval_master` a,`type_of_comaddress_master` b, `information_master` i ,`communication_address_master` c WHERE c.type_of_address = b.id and c.`registration_id`=i.`registration_id` and c.`registration_id`=a.`registration_id` and a.eligible_for_renewal='Y' AND c.type_of_address='7' AND c.mobile_no!='' and c.mobile_no!=0 and i.registration_id ='600714127' GROUP BY c.mobile_no order by i.company_name limit 5";  
$result = $conn ->query($sqlx);
while($row = $result->fetch_assoc())
{   //echo '<pre>'; print_r($row);
	/*echo $mobile = trim($row['mobile_no']);   echo "<br/>";
	echo $name = strtoupper(trim($row['name']));  echo "<br/>";
	*/
$apiurls = sendOPTIN($mobile); 
//print_r($apiurl);
$getResults = json_decode($apiurls,true);

$apiurl = sendMediaMsg($mobile,$name);
//print_r($apiurl); 
$getResult = json_decode($apiurl,true);

if($getResult['response']['status']=="success")
{
	echo $getResult['response']['status'];
} else { 
	echo $getResult['response']['details'];
}
}

function sendMediaMsg($mobile,$name)
{
	$mobile = trim($mobile);
	$name = str_replace(" ","%20",$name);

	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=SendMediaMessage&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$mobile."&v=1.1&auth_scheme=plain&isHSM=true";
	$url.="&msg_type=DOCUMENT";
	$url.="&media_url=https://gjepc.org/pdf/solitaire/Solitaire-International-Weekly-Digest-LVII.pdf";
	//$url.="&caption=Dear%20".$name."%2C%0A%0AYour%20Request%20for%20Solitaire%20International%20is%20here.%0A%0AYou%20can%20now%20access%20%20Solitaire%20International%20Weekly%20Digest%2C%20Edition%20XXI%20%0A%0AKindly%20login%20in%20to%20%20https%3A%2F%2Fgjepc.org%2Fsolitaire%2F%20to%20read%20more%20%0A%0ARegards%2C%0A%0ATeam%20Solitaire%20International";
	$url.="&caption=Dear%20".$name."%2C%0A%0AYour%20Request%20for%20Solitaire%20International%20is%20here.%0A%0AYou%20can%20now%20access%20Solitaire%20International%20Weekly%20Digest%2C%20Edition%20LVII.%0A%0AKindly%20login%20in%20to%20https%3A%2F%2Fgjepc.org%2Fsolitaire%2F%20to%20read%20more%0A%0ARegards%2C%0A%0ATeam%20Solitaire%20International";
	$url.="&filename=SOLITARE%20INTERNATIONAL%20WEEKLY%20DIGEST";
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