 <?php
// client.php
$options = array(
	'trace' => true
);
//$client = new SOAPClient('http://kwebmakerdigitalagency.com/gjepc/soapcreate/create1/server.php?wsdl', $options);
$client = new SOAPClient('https://gjepc.org/admin/sapERP/server.php?wsdl', $options);
var_dump($client->Average(['num1' => 10, 'num2' => 6])->Result);
?>