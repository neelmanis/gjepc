<?php 


$visitorMobiles = "919834797281";
    $name = "Santosh";
    $website = "www.aaa.com";
    $$Posturl = "sdsdsdsds";

    $url = "https://app.yellowmessenger.com/api/engagements/notifications/v2/push?bot=x1652181273571";

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
  CURLOPT_POSTFIELDS =>'
    {
    "userDetails": {
        "number": "'.$visitorMobiles.'"
    },

   "notification": {
       "templateId": "single_visitor_approval", 
       "params": { 
           "1" : "'.$name.'",
           "2" : "'.$website.'",
           "3" : "'.$Posturl.'"
          },
       "type": "whatsapp", 
       "sender": "919619500999",
       "language": "en",
       "namespace": "f6d069b8_cb39_4d42_a8e1_045b5ea5d255"
    }
    }',
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
    //  header('Content-type: application/json');
        echo  $response;    
    }?>