<?php include('../header_include.php');
	
	$filename = "EP013091120103.xml";
	$fp = fopen($filename,'w') or die('Cannot open file');
					 
	$preparedon1 = date('d/m/Y');
	$pieces = explode("/", $preparedon1);
	
	$query=$conn->query("select * from dgft_download_count_check where dgft_download_dt='$preparedon1' and member_type_id='6'");
	$result=$query->fetch_assoc();
	$count1=$result['dgft_download_count'];
	if($count1==""){$count1=0;}
	$count1=$count1+1;
	
	$preparedon=$pieces[0]."".$pieces[1]."".$pieces[2];
	echo $file_basename = "EP013".$preparedon.$count1.".xml";
	
	$currdate=date('Y-m-d');
	
	// current challan yr calculation
    $cur_year = (int)date('Y');
    $cur_month = (int)date('m');
    if ($cur_month < 4) {
     $cur_fin_yr = $cur_year-1;
    }
    else {
     $cur_fin_yr = $cur_year;
    }
	$last_yr=$cur_fin_yr+1;
	
	$date_from=date('Y-m-d',strtotime($_POST['date_from']));
	$date_to=date('Y-m-d',strtotime($_POST['date_to']));
	
	/*........................................New member.................................*/
	//echo $sql="select a.registration_id,a.merchant_certificate_no,a.manufacturer_certificate_no,a.rcmc_certificate_issue_date,a.rcmc_certificate_expire_date,a.xml_status,b.iec_no from approval_master a, information_master b  where (a.`membership_issued_certificate_dt` between '$date_from' and '$date_to' || (a.`membership_renewal_dt` between '$date_from' and '$date_to')) and a.registration_id=b.registration_id and b.member_type_id=6 and a.manufacturer_certificate_no!='' and (a.manufacturer_certificate_no like '%2019-2024%' or a.manufacturer_certificate_no like '%2019-2024%' || a.manufacturer_certificate_no like '%2020-2025%' || a.manufacturer_certificate_no like '%2021-2026%' || a.manufacturer_certificate_no like '%2022-2027%') and a.issue_membership_certificate_expire_status='Y' and eligible_for_renewal='N'";
	
	
	/*........................................Renewal.................................*/
	echo $sql="select a.registration_id,a.merchant_certificate_no,a.manufacturer_certificate_no,a.rcmc_certificate_issue_date,a.rcmc_certificate_expire_date,a.xml_status,b.iec_no from approval_master a, information_master b  where (a.`membership_issued_certificate_dt` between '$date_from' and '$date_to' || (a.`membership_renewal_dt` between '$date_from' and '$date_to')) and a.registration_id=b.registration_id and b.member_type_id=6 and a.manufacturer_certificate_no!='' and (a.manufacturer_certificate_no like '%2017-2022%' or a.manufacturer_certificate_no like '%2018-2023%' or a.manufacturer_certificate_no like '%2019-2024%' || a.manufacturer_certificate_no like '%2020-2025%' || a.manufacturer_certificate_no like '%2021-2026%' || a.manufacturer_certificate_no like '%2022-2027%') and a.issue_membership_certificate_expire_status='Y' and eligible_for_renewal='Y'";
	exit;
	$query=$conn->query($sql);
	$reccount = $query->num_rows;

$r = "<?xml version='1.0' encoding='UTF-8'?>\n<RCMC>\n<epccode>EP013</epccode>\n<epcname>The Gem and Jewellery Export Promotion Council</epcname>\n<preparedon>".$preparedon."</preparedon>\n<reccount>".$reccount."</reccount>\n";

while($result=$query->fetch_assoc())
{
	$iec = getIec($result['registration_id'],$conn);
	$member_type_id=getMemberType($result['registration_id'],$conn);
	
	
	
	$issuedate1 = date('d/m/Y',strtotime($result['rcmc_certificate_issue_date']));
	$pieces = explode("/", $issuedate1);
	$issuedate=$pieces[0].".".$pieces[1].".".$pieces[2];
	
	$validupto="31.03.".$last_yr;
	$proddesc = getPanelName($result['registration_id'],$conn);
	$status="A";
	
		$rcmcnumber = str_replace('HO-MUM (M)','HO-MUM-M',$result['manufacturer_certificate_no']);
		$count = count($rcmcnumber);
		$pos=$count-30;
		$rcmcnumber=substr($rcmcnumber, $pos,30);
		
		
		$exptype=2;	
		$r = $r."<RCMCDATA> " . "\r\n" .
		"<rcmcnumber>" . trim($rcmcnumber) . "</rcmcnumber>" . "\r\n" .
		"<issuedate>" .  $issuedate . "</issuedate>" . "\r\n" .
		"<iec>" . $iec . "</iec>" . "\r\n" .
		"<validupto>" . $validupto . "</validupto>" . "\r\n" .
		"<proddesc>" . $proddesc . "</proddesc>" .  "\r\n" .
		"<exptype>" . $exptype . "</exptype>" . "\r\n" .
		"<status>" . $status . "</status>" . "\r\n" .
		"</RCMCDATA>" . "\r\n";
}	
$r .= "</RCMC>"."\r\n";


echo htmlentities( $r); exit;

fwrite($fp, $r);
fclose($fp);

$query=mysql_query("select * from dgft_download_count_check where dgft_download_dt='$preparedon1' and member_type_id='6'");
$num=mysql_num_rows($query);
if($num>0)
{
	mysql_query("update dgft_download_count_check set dgft_download_count='$count1' where dgft_download_dt='$preparedon1'");
}
else
{
	mysql_query("insert into dgft_download_count_check set member_type_id='6',dgft_download_dt='$preparedon1',dgft_download_count='$count1'");
}			

$fsize = filesize($filename);
header("Content-Type: text/xml");
header("Content-length: $fsize");
header("Content-Disposition: attachment; filename=\"$file_basename"); 
$fp=fopen($filename,'r');
fpassthru($fp);
fclose($fp);
?>