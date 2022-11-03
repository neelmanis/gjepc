<?php
$gst_number = trim($_POST['gst_val']);
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
}
?>