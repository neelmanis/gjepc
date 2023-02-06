<?php 
error_reporting(E_ERROR | E_WARNING | E_PARSE);
include('../db.inc.php');
include('../functions.php');
if(!empty($_POST))  
//if(true)  
{
	$id = trim($_POST['id']);
	$registration_id = trim($_POST['registration_id']);
	$company_name=str_replace(" ",'%20',getCompanyName($registration_id,$conn));
	$query_sel = "SELECT c_bp_number,pan_no FROM communication_address_master where registration_id='$registration_id' and type_of_address='2'";	
	$result_sel =  $conn ->query($query_sel);
	$row = $result_sel->fetch_assoc();	
	$company_pan=$row['pan_no'];
	$company_bp_number=$row['c_bp_number'];
	
	//echo "https://api.mykycbank.org/service.svc/44402aeb2e5c4eef8a7100f048b97d84/newbpid/".$company_bp_number."/".$company_pan."/".$company_name; exit;
		$curl = curl_init();
		
		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.mykycbank.org/service.svc/44402aeb2e5c4eef8a7100f048b97d84/newbpid/".$company_bp_number."/".$company_pan."/".$company_name,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 30,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
		"cache-control: no-cache",
		"postman-token: d321efdc-8350-2b11-765c-b23833aa5ab1"
		),
		));
		
		$response = curl_exec($curl);
		$err = curl_error($curl);
		//echo '<pre>'; print_r($response); exit;
		curl_close($curl);
		
		if ($err) {
		 	echo $flag=0;
		} else {
			$resultx =  $conn ->query("update communication_address_master set push_to_kyc='1' where id='$id'");
			echo $flag=1;
		}
}
?>