<?php include('../header_include.php');
	
	$filename = "EP013091120103.xml";
	$fp = fopen($filename,'w') or die('Cannot open file');
					 
	$preparedon1 = date('d/m/Y');
	$pieces = explode("/", $preparedon1);
	
	$query=$conn->query("select * from dgft_download_count_check where dgft_download_dt='$preparedon1' and member_type_id='5'");
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
	
	
	/*................................Renewal Member...............................*/
	echo $sql="select a.registration_id,a.merchant_certificate_no,a.manufacturer_certificate_no,a.rcmc_certificate_issue_date,a.rcmc_certificate_expire_date,a.membership_type,b.iec_no from approval_master a , information_master b  where (a.`membership_issued_certificate_dt` between '$date_from' and '$date_to' || (a.`membership_renewal_dt` between '$date_from' and '$date_to')) and a.registration_id=b.registration_id and b.member_type_id=5 and a.merchant_certificate_no like 'GJC%' and (a.merchant_certificate_no like '%2019-2024%' or a.merchant_certificate_no like '%2020-2025%' or a.merchant_certificate_no like '%2021-2026%' or a.merchant_certificate_no like '%2022-2027%') and a.issue_membership_certificate_expire_status='Y' and eligible_for_renewal='Y'";	
	
	
	/*................................New Member...............................*/
	//echo $sql="select a.registration_id,a.merchant_certificate_no,a.manufacturer_certificate_no,a.rcmc_certificate_issue_date,a.rcmc_certificate_expire_date,a.membership_type,b.iec_no from  approval_master a , information_master b  where (a.`membership_issued_certificate_dt` between '$date_from' and '$date_to' || (a.`membership_renewal_dt` between '$date_from' and '$date_to')) and a.registration_id=b.registration_id and b.member_type_id=5 and a.merchant_certificate_no like 'GJC%' and (a.merchant_certificate_no like '%2019-2024%' or a.merchant_certificate_no like '%2020-2025%' or a.merchant_certificate_no like '%2021-2026%' or a.merchant_certificate_no like '%2022-2027%')";
	exit;
	$query=$conn->query($sql);
	$reccount = $query->num_rows;
	
$r = '<?xml version="1.0" encoding="utf-8"?>
	   <RCMC>
		<epccode>EP013</epccode>
		<epcname>The Gem and Jewellery Export Promotion Council</epcname>
		<preparedon>'.$preparedon.'</preparedon>
		<reccount>'.$reccount.'</reccount>';
		

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
	
		$rcmcnumber = str_replace('HO-MUM (M)','HO-MUM-M',$result['merchant_certificate_no']);
		$count = count($rcmcnumber);
		$pos=$count-30;
		$rcmcnumber=substr($rcmcnumber, $pos,30);
		
		$exptype=1;	
		$r = $r.'<RCMCDATA>
			<rcmcnumber>' .  trim($rcmcnumber) . '</rcmcnumber>
			<issuedate>' .  $issuedate . '</issuedate>
			<iec>' . $iec . '</iec>
			<validupto>' . $validupto . '</validupto>
			<proddesc>' . $proddesc . '</proddesc>
			<exptype>' . $exptype . '</exptype>
			<status>' . $status . '</status>
		</RCMCDATA>';
	}
$r .= '</RCMC>';

 echo htmlentities( $r); exit;

fwrite($fp, $r);
fclose($fp);

$query=$conn->query("select * from dgft_download_count_check where dgft_download_dt='$preparedon1' and member_type_id='5'");
$num=$query->num_rows;
if($num>0)
{
	$conn->query("update dgft_download_count_check set dgft_download_count='$count1' where dgft_download_dt='$preparedon1'");
}
else
{
	$conn->query("insert into dgft_download_count_check set member_type_id='5',dgft_download_dt='$preparedon1',dgft_download_count='$count1'");
}
$fsize = filesize($filename);
header("Content-Type: text/xml");
header("Content-length: $fsize");
header("Content-Disposition: attachment; filename=\"$file_basename"); 
$fp=fopen($filename,'r');
fpassthru($fp);
fclose($fp);

?>