<?php 
function sendOtp($mobile_number,$otp){
  $service_id = 287;
  //$msg = "MOFSL: $otp is One time password for MOHFL";
  $msg = "$otp is Your One time Password for Motilal Oswal HF website";
  $response = file_get_contents("http://192.168.99.36/longcodeSMS/SingleMessage.asmx/SingleMessage?mobileno=$mobile_number&message=" . urlencode($msg) . "&Serviceid=" . $service_id);
}
$send = sendOtp("9834797281",'1234');
print_r($send);exit;


?>