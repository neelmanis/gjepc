<?php
session_start();
ob_start();
include('db.inc.php');
include('functions.php');
?>
<?php
$q = strtolower($_GET["q"]);
$c_id=$_GET['c_id'];
if (!$q) return;

$sql = "select * from kp_foreign_imp_master where 1 and LONGNAME LIKE '$q%'";
$rsd = mysql_query($sql);
while($rs = mysql_fetch_array($rsd)) {
	$PARTY_ID = $rs['PARTY_ID'];
	$LONGNAME = $rs['LONGNAME'];
	
	$query=mysql_query("select * from kp_foreign_imp_master where PARTY_ID='$PARTY_ID'");	
	$result=mysql_fetch_array($query);
	$IE_PARTY_NAME=$result['LONGNAME'];
	$IE_ADDRESS1=$result['ADDRESS1'];
	$IE_ADDRESS2=$result['ADDRESS2'];
	$IE_ADDRESS3=$result['ADDRESS3'];
	$IE_COUNTRY=$result['COUNTRYID'];
	$IE_TEL1=$result['PHONE1'];
	$IE_TEL2=$result['PHONE2'];
	$IE_FAX=$result['FAX1'];
	$IE_CITY=$result['CITY_NAME'];
	$IE_PIN=$result['PINCODE'];
	
	echo "$LONGNAME|$PARTY_ID|$IE_PARTY_NAME|$IE_ADDRESS1|$IE_ADDRESS2|$IE_ADDRESS3|$IE_TEL1|$IE_TEL2|$IE_FAX|$IE_CITY|$IE_PIN|$IE_COUNTRY\n";
	
}
?>
