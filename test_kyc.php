<?php
$url ="";
$env = "live"; //test OR prod
if($env =="test"){
	$url .= "http://test.mykycbank.com/sso.aspx";
}else{
	$url .= "https://www.mykycbank.com/sso.aspx";
}

$secretKey = "Tasya Te Pavitra-Pate mantra";
$b = "7000004804";
$p = "AABCC2744F";
$c = "JEWEL INDIA PVT.LTD.";

// $b = "7000008018";
// $p = "AALFM5529M";
// $c = "MAA KALI JEWELLERS";

$k =  MD5(MD5($b.$p.$c).$secretKey);

echo  $url .='?b='.$b.'&p='.$p.'&c='.$c.'&k='.$k.'';

header("Location: ".$url);
?>