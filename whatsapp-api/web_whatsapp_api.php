<?php
include('../db.inc.php');


$sqlx = "SELECT * FROM whatsapp_temp_data WHERE platform='Y' order by id asc limit 2000";

$result = $conn ->query($sqlx);
while($row = $result->fetch_assoc())
{  
$rowId = $row['id'];
//$mobile = "919834797281";	
$mobile = "91".trim($row['mobile']);	
$type = trim($row['type']);
$variable = $row['variable_name'];
$template_id = $row['template_id'];
$description = $row['description'];
$title = $row['title'];
if($row['attatchment'] !==""){
	// $attatchment = "https://cdn.yellowmessenger.com/tf3W1OLFlPAv1661331338233.jpeg";
	$attatchment = "https://gjepc.org/admin/whatsappAttatchments/".$row['attatchment'];
	
}else{
	$attatchment="";
}

$userDetails = array("number"=>$mobile);
$notification = array();
if($type =="TEXT"){
	$param = unserialize($variable);
	//print_r($param);exit;
}else{
	$param =array("media"=>array("mediaLink"=>$attatchment,"title"=>$title));
  $variable_arr = json_decode( json_encode(unserialize($variable),JSON_FORCE_OBJECT));
 

  foreach($variable_arr as $variable_array){
  	$param[] = $variable_array;
  }

	
}

array_unshift($param,"");
unset($param[0]);

// echo "<pre>";print_r($param);exit;
$notification = array(
		"templateId"=>trim($template_id),
		"params"=>$param,
		"type"=>"whatsapp",
		"sender"=>"919619500999",
		"language"=>"en",
		"namespace"=>"f6d069b8_cb39_4d42_a8e1_045b5ea5d255"
	);
$payload = array( "userDetails" => $userDetails ,"notification" => $notification );
 // echo "<pre>";echo json_encode($payload);exit;
$boat_id = "x1652181273571";
$send_messagae = sendMsg($payload,$boat_id);
 $sqlDelete= "DELETE FROM whatsapp_temp_data WHERE `id`='$rowId'";
 $conn->query($sqlDelete);

}
$conn->close();

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
		
	 echo $response."<br>";
	}
}

?>