<?php
$url="https://gjepc.org/linkedin_count.php";
$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_URL => 'http://www.linkedin.com/countserv/count/share?url=' . $url . '&format=json'
));

$response = curl_exec($curl);

$results = json_decode($response);
print_r($response);

curl_close($curl);

return $results->fCntPlusOne;
?>
<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
<script type="IN/Share" data-url="https://gjepc.org/linkedin_count.php/"></script>