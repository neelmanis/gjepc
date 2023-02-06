<?php
session_start();
include('db.inc.php');

$company_gstn = trim($_POST['gst_val']);
    $fieldsArr = '{
				"data": 
				{
				"business_gstin_number": "'.$company_gstn.'",
				"consent": "Y",
				"consent_text": "Approve the values here"
				}
				}';
			
	$headers = array(
		    "auth: false",
            "app-id: 62a31a45791920001dd1a099",
			"api-key: TK761JV-5KFM7MF-PAFQHR7-ZFKF25K",
            "Content-Type: application/json"
        );
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => 'https://live.zoop.one/api/v1/in/merchant/gstin/lite',
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => '',
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => 'POST',
	  CURLOPT_POSTFIELDS => $fieldsArr,
	  CURLOPT_HTTPHEADER => $headers,
	));

	$response = curl_exec($curl);
	curl_close($curl);
  
   
   //echo '<pre>'; print_r($response); 
$obj = json_decode($response);
//echo '<pre>'; print_r($obj); exit;
$response_code = $obj->response_code;
$result = $obj->result;
$name = $result->trade_name;

$logs = "INSERT INTO zoop_logs SET post_date = NOW(),document = 'GST',document_no='$company_gstn',name='$name',zoop_verified='$response_code',section='MEMBER CHALLAN',ip='".$_SERVER['REMOTE_ADDR']."'";
$result = $conn->query($logs);
 echo $response; exit;

/*
//$gst_number ='24AAAPZ0807C1Z5';
$key_secret = 'EvQwMafkbFRstByGbvr9fwiEI1m1';//mukesh singh acc
//$key_secret = 'juNX5vcKmkTsvEcZG1BqNXsVUjc2';// krishna dhumal acc

$url="https://appyflow.in/api/verifyGST?gstNo=".$gst_number."&key_secret=".$key_secret;
$data_json = file_get_contents($url);
$response = json_decode($data_json,true);
// echo '<pre>';print_r($response);
$status = $response['taxpayerInfo']['sts'];
$status2= $response['error'];
if(isset($status)){
	if($status=="Active")
	{
	    $data = array('status' =>'success','message'=>'GST is Valid' );
	    echo json_encode($data);exit;
	}else{
		$data = array('status' =>'error1','message'=>'GST is Inactive' );
		echo json_encode($data);exit;
	}
}else{
    if($status2 =='1'){
        $data = array('status' =>'error2','message'=>'Invalid GST Number' );	
        echo json_encode($data);exit;
    }
} */
?>