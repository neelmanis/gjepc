<?php
include('../db.inc.php');
//$mobile = "9619662253";

$sqlx = "SELECT * FROM whatsapp_temp_data  WHERE platform='G' order by id asc limit 2000 ";

$result = $conn ->query($sqlx);
while($row = $result->fetch_assoc())
{  
$rowId = $row['id'];
$mobile = trim($row['mobile']);	
$type = trim($row['type']);	
$variable = trim($row['variable_name']);

if($row['attatchment'] !==""){
	$attatchment = "https://gjepc.org/admin/whatsappAttatchments/".$row['attatchment'];
}else{
	$attatchment="";
}

$description = $row['description'];
$title = $row['title'];
$isOPTIN = sendOPTIN($mobile);

$apiurl = sendMediaMsg($type,$mobile,$attatchment,$description,$title);
$getResult = json_decode($apiurl,true);

if($getResult['response']['status']=="success")
{
	echo $getResult['response']['status']."<br>";
} else { 
	echo $getResult['response']['details']."<br>";
}
$sqlDelete= "DELETE FROM whatsapp_temp_data WHERE `id`='$rowId'";
$conn->query($sqlDelete);


}

$conn->close();


function sendMediaMsg($type,$mobile,$attatchment,$description,$title)
{
	$mobile = trim($mobile);
	$url ="https://media.smsgupshup.com/GatewayAPI/rest?";
	if($type =="TEXT"){
	    $url.="method=SendMessage";
    }else{
        $url.="method=SendMediaMessage";
    }
	$url.="&format=json&userid=2000193706&password=dCtjkxnX&send_to=".$mobile."&v=1.1&auth_scheme=plain";
	if($type !="TEXT"){
		$url.="&isHSM=true";
	}

	$url.="&msg_type=".trim($type);

	if($attatchment !==""){
		$url.="&media_url=".trim($attatchment);
	}
	if($type=="TEXT"){
		$url.="&msg=".$description;
	}else{
    if($description !==""){
		$url.="&caption=".$description;
	}	
	
	}
    if($title !==""){
    	$url.="&filename=".trim($title);
    }

   // if($isButton){
    	//$url.="&isTemplate=true&buttonUrlParam=abcdxyz";
   // }
   
   
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
					return $getResults['response']['status'];
				} else { 
					return $getResults['response']['details'];
				}		
			}
		} else { 
			return $getResult['response']['details'];
		}
	    
	}
}
?>