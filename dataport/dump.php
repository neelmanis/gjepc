<?php include('../header_include.php');
	
	$filename = "EP2022.xml";
	$fp = fopen($filename,'w') or die('Cannot open file');
					 
	$preparedon1 = date('d/m/Y');
	$pieces = explode("/", $preparedon1);
	
	$query=$conn->query("select * from dgft_download_count_check where dgft_download_dt='$preparedon1' and member_type_id='5'");
	$result=$query->fetch_assoc();
	$count1=$result['dgft_download_count'];
	if($count1==""){$count1=0;}
	$count1=$count1+1;
	
	$preparedon=$pieces[0]."".$pieces[1]."".$pieces[2];
	$file_basename = "EP013".$preparedon.$count1.".xml";
	
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
	$sql="SELECT * FROM gjepclivedatabase.dump_rcmc";
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
		$rcmcnumber = str_replace('HO-MUM (M)','HO-MUM-M',$result['rcmc_no']);
		$iec = $result['iec_no'];
		$issuedate1 = $result['rcmc_date'];
		$pieces = explode("/", $issuedate1);
		$issuedate=$pieces[0].".".$pieces[1].".".$pieces[2];
		$validupto = $result['valid_date'];
		$proddesc = $result['panel'];
		$status="A";
		
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

/*
$query=$conn->query("select * from dgft_download_count_check where dgft_download_dt='$preparedon1' and member_type_id='5'");
$num=$query->num_rows;
if($num>0)
{
	$conn->query("update dgft_download_count_check set dgft_download_count='$count1' where dgft_download_dt='$preparedon1'");
}
else
{
	$conn->query("insert into dgft_download_count_check set member_type_id='5',dgft_download_dt='$preparedon1',dgft_download_count='$count1'");
} */
$fsize = filesize($filename);
header("Content-Type: text/xml");
header("Content-length: $fsize");
header("Content-Disposition: attachment; filename=\"$file_basename"); 
$fp=fopen($filename,'r');
fpassthru($fp);
fclose($fp);
?>