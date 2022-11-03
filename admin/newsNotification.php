<?php include('../db.inc.php');?>
<?php
function get_data($message,$number) {
	$message=str_replace(" ","%20",$message);
	$url = 'http://www.tecogis.com/tec_sms_engine/smsapi/sendsms.asmx/erpapi?action=send&Message='.$message.'&Phone='.$number;
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
?>
<?php
$sqlx = "SELECT * FROM `news_master` WHERE status='1' and DATE(`post_date`) = CURDATE() and section!=0";
$result = mysql_query($sqlx);
$countx = mysql_num_rows($result);
if ($countx > 0) {
    // Get News
    while($row = mysql_fetch_array($result))
	{
        $id = $row["id"];
        $getNews = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $row["name"]);
		
		//Get Active Members
		$sql = "SELECT a.email_id,a.mobile_no FROM `registration_master` a , approval_master b WHERE a.id=b.registration_id and (`membership_issued_certificate_dt` between '2017-03-31' and '2018-04-1' || membership_renewal_dt between '2017-03-31' and '2018-04-1') limit 1";
	    $resultx = mysql_query($sql);
		$counts = mysql_num_rows($resultx);
	    if ($counts > 0)
		{
			// Get Mobile No. of Members
			while($rowx = mysql_fetch_array($resultx))
			{
			$number = $rowx["mobile_no"];
			// Send News To members
			//$message = "<a href='https://www.gjepc.org/news_detail.php?id=$id'>$getNews</a>";
			$message = $getNews." ...read full story on gjepc.org/news_detail.php?id=$id";
			$msgSend = get_data($message,$number);			
		    }
		
		} else {
			echo "Members Not Found";
		}
		
    }
} else {
    echo "No News Found for Today";
}
?>