<?php
include('../db.inc.php'); 
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }

function reportLogs($category,$report_name,$conn)
{
	$adminID = intval($_SESSION['curruser_login_id']);
	$adminName = strtoupper($_SESSION['curruser_contact_name']);
	$ip = get_client_ip();
	$query = "INSERT INTO report_logs SET post_date=NOW(),admin_id='$adminID',admin_name='$adminName',category='$category',report_name='$report_name',ip='$ip'";
	$result = $conn->query($query);
	if($result)
	{
		return "TRUE";
	} else {
		return "FALSE";
	}
}

$category = 'EXHIBITOR';
$report_name = 'DOWNLOAD IIJS TDS DATA';
$logs = reportLogs($category,$report_name,$conn);
?>

<?php
	function getTDSAmount($registration_id,$conn)
	{
		$query_sel = "select cheque_tds_amount from exh_reg_payment_details where uid='$registration_id' AND `show`='IIJS PREMIERE 2022' AND event_selected='iijs' limit 0,1";
		$result_sel = $conn->query($query_sel);								
		$row = $result_sel->fetch_assoc();								
		return $row['cheque_tds_amount'];							
	}
			
$table = $display = "";	
$fn = "report_tds_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>ID</td>
<td>Company Name</td>
<td>Company BP</td>
<td>show</td>
<td>Order No</td>
<td>razorpay_order_id</td>
<td>payment_status</td>
<td>Amount paid</td>
<td>Tds Amount</td>
<td>Payment for</td>
</tr>';

$sql="SELECT a.id,a.company_name,c.c_bp_number, 
u.`show`,u.utr_number as 'Order No', u.razorpay_order_id,u.payment_date,u.razorpay_payment_id,u.merchant_order_id,u.order_id,u.method,u.payment_status,u.amountPaid,u.tdsAmount,u.utr_approved,u.utr_date,u.comment,u.payment_made_for 
FROM utr_history u left join registration_master a 
ON u.registration_id=a.id
LEFT join communication_address_master c
ON u.registration_id=c.registration_id where c.type_of_address=2 and u.show='IIJS PREMIERE 2022' AND u.payment_status='captured' group by u.utr_number";
$result = $conn ->query($sql);
while($row = $result->fetch_assoc())
{	//echo '<pre>'; print_r($row); exit;
$registration_id=$row['id'];
$company_name=$row['company_name'];
$c_bp_number=$row['c_bp_number'];
$show=$row['show'];
$order=$row['Order No'];
$razorpay_order_id=$row['razorpay_order_id'];
$payment_status=$row['payment_status'];
$amountPaid=$row['amountPaid'];
$tdsAmount=$row['tdsAmount'];
$payment_made_for=$row['payment_made_for'];
if($payment_made_for == 'SPACE'){ 
if($tdsAmount=='0'){ $tdsAmount = getTDSAmount($registration_id,$conn); }
}

$table .= '<tr>
<td>'.$registration_id.'</td>
<td>'.$company_name.'</td>
<td>'.$c_bp_number.'</td>
<td>'.$show.'</td>
<td>'.$order.'</td>
<td>'.$razorpay_order_id.'</td>
<td>'.$payment_status.'</td>
<td>'.$amountPaid.'</td>
<td>'.$tdsAmount.'</td>
<td>'.$payment_made_for.'</td>
</tr>';
	
}
 $table .= $display;
$table .= '</table>';

		header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=$fn.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
exit;	
?>
