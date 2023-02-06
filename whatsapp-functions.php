<?php

// YELLOW AI MESSAGE FUNCTION
function sendMsg($payload,$boat_id)
{

$url = "https://app.yellowmessenger.com/api/engagements/notifications/v2/push?bot=".$boat_id;
$payload = json_encode($payload,JSON_PRETTY_PRINT);
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$payload,
  CURLOPT_HTTPHEADER => array(
    'x-api-key: w_I8aJAEmNQz36y3i1QaZMHQrydyEj-I2GZ8_ySG',
    'Content-Type: application/json'
  ),
));
	//print_r($curl);
	$response = curl_exec($curl);	
	if($err) {
	 echo "cURL Error #:" . $err;
	} else {
		header('Content-type: application/json');
		
	  return  $response;
	}
}


// GUPSHUP MESSAGE FUNCTION

// function sendMediaMsg($type,$mobile,$attatchment,$description,$title)
// {
// 	$mobile = trim($mobile);
// 	$url ="https://media.smsgupshup.com/GatewayAPI/rest?";
// 	if($type =="TEXT"){
// 	    $url.="method=SendMessage";
//     }else{
//         $url.="method=SendMediaMessage";
//     }
// 	$url.="&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$mobile."&v=1.1&auth_scheme=plain";
// 	if($type !="TEXT"){
// 		$url.="&isHSM=true";
// 	}

// 	$url.="&msg_type=".trim($type);

// 	if($attatchment !==""){
// 		$url.="&media_url=".trim($attatchment);
// 	}
// 	if($type=="TEXT"){
// 		$url.="&msg=".$description;
// 	}else{
//     if($description !==""){
// 		$url.="&caption=".$description;
// 	}	
	
// 	}
//     if($title !==""){
//     	$url.="&filename=".trim($title);
//     }
//    //$url.="&isTemplate=true&buttonUrlParam=send";
   
// 	$headers = array("Content-Type: application/json");	 
//     $curl = curl_init();
//     $timeout = 5;
//     curl_setopt($curl, CURLOPT_URL, $url);
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
//     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
//     curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
// 	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
//     curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
//     curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	
//     $response = curl_exec($curl);
// 	$err = curl_error($curl);
// 	curl_close($curl);
	
// 	if($err) {
// 	 echo "cURL Error #:" . $err;
// 	} else {
		
// 		$getResult = json_decode($response,true);
		
// 		return $getResult;
	
// 	}


// }

// function sendOPTIN($mobile)
// {
// 	$mobile = trim($mobile);
// 	$url ="https://media.smsgupshup.com/GatewayAPI/rest?method=OPT_IN&format=json&userid=2000193706&password=dCtjkxnX&phone_number=".$mobile; 
// 	$url.="&v=1.1&auth_scheme=plain&channel=WHATSAPP";
	
// 	$headers = array("Content-Type: application/json");
				 
//     $curl = curl_init();
//     $timeout = 5;
//     curl_setopt($curl, CURLOPT_URL, $url);
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,false);
//     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,false);
//     curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
// 	curl_setopt($curl, CURLOPT_HTTPHEADER, $headers); 
//     curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
//     curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
	
//     $response = curl_exec($curl);
// 	$err = curl_error($curl);
// 	curl_close($curl);
	
// 	if($err) {
// 	 echo "cURL Error #:" . $err;
// 	} else {

// 		$getResult = json_decode($response,true);
// 		//header('Content-type: application/json');
// 		return $getResult;
	
// 	}
// }

?>