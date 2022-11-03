<?php

include 'db.inc.php';


echo "Export Value : ".$export_fob_value = 500000000;
echo "<br/>Membership Fee : ".$membership_fees  =	30000;
echo '<br/>';
	$query = $conn ->query("select export_start_amount,export_end_amount,membership_fee from export_amount_master where status=1 and financial_year='2021'");
	if(!$query) die ($conn->error);
	while($result = $query->fetch_assoc())
	{ echo $export_fob_value."<-->".$result['export_start_amount'];
		if($export_fob_value>=$result['export_start_amount'] && $export_fob_value<=$result['export_end_amount'])
		{
			echo '---=>'.$membershipfeesData = $result['membership_fee']; echo '<br/>';	
			if($membershipfeesData!=$membership_fees){
			echo "<script type='text/javascript'> alert('You are a New Member');
			window.location.href='challan_form.php';
			</script>";
			return;	exit;
			}
		}
	}
?>