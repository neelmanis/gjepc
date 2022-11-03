<?php include('../header_include.php');
	
	$filename = "EP013091120103.xml";
	$fp = fopen($filename,'w') or die('Cannot open file');
					 
	$preparedon1 = date('d/m/Y');
	$pieces = explode("/", $preparedon1);
	$preparedon=$pieces[0]."".$pieces[1]."".$pieces[2];
	$file_basename = "EP013".$preparedon.".xml";
	
	$currdate=date('Y-m-d');
	
	$cur_year = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {$upto_year=$cur_year;}
    else {$upto_year=$cur_year+1;
	}
	echo "select registration_id,merchant_certificate_no,manufacturer_certificate_no,rcmc_certificate_issue_date,rcmc_certificate_expire_date,xml_status from approval_master  where rcmc_certificate_issue_status='Y' and membership_issued_certificate_dt between '2013-04-01' and '$currdate'";
	exit;
	$query=mysql_query("select registration_id,merchant_certificate_no,manufacturer_certificate_no,rcmc_certificate_issue_date,rcmc_certificate_expire_date,xml_status from approval_master  where rcmc_certificate_issue_status='Y' and membership_issued_certificate_dt between '2013-04-01' and '$currdate'");
	
	$reccount = mysql_num_rows($query);

$r = "<?xml version='1.0' encoding='UTF-8'?>\n<RCMC>\n<epccode>EP013</epccode>\n<epcname>The Gem and Jewellery Export Promotion Council</epcname>\n<preparedon>".$preparedon."</preparedon>\n<reccount>".$reccount."</reccount>\n";

while($result=mysql_fetch_array($query))
{
	$iec = getIec($result[0]);
	$member_type_id=getMemberType($result[0]);
	if($member_type_id='Merchant')
	{
		$rcmcnumber = $result[1];
		$exptype=1;
	}
	else
	{
		$rcmcnumber = $result[2];
		$exptype=2;
	}
	$count = count($rcmcnumber);
	$pos=$count-30;
	$rcmcnumber=substr($rcmcnumber, $pos,30);
	
	$issuedate1 = date('d/m/Y',strtotime($result[3]));
	$pieces = explode("/", $issuedate1);
	$issuedate=$pieces[0].".".$pieces[1].".".$pieces[2];
	
	$validupto="31.03.".$upto_year;
	$proddesc = getPanelName($result[0]);
	$status = $result[5];
	//Code begins : Creating XML (format of file : EP013DDMMYYY3)
		
	$r = $r."<RCMCDATA> " . "\r\n" .
		"<rcmcnumber>" . $rcmcnumber . "</rcmcnumber>" . "\r\n" .
		"<issuedate>" .  $issuedate . "</issuedate>" . "\r\n" .
		"<iec>" . $iec . "</iec>" . "\r\n" .
		"<validupto>" . $validupto . "</validupto>" . "\r\n" .
		"<proddesc>" . $proddesc . "</proddesc>" .  "\r\n" .
		"<exptype>" . $exptype . "</exptype>" . "\r\n" .
		"<status>" . $status . "</status>" . "\r\n" .
	"</RCMCDATA>" . "\r\n";

}	
$r .= "</RCMC>";

fwrite($fp, $r);
fclose($fp);
			

$fsize = filesize($filename);
header("Content-Type: text/xml");
header("Content-length: $fsize");
header("Content-Disposition: attachment; filename=\"$file_basename"); 
$fp=fopen($filename,'r');
fpassthru($fp);
fclose($fp);

?>