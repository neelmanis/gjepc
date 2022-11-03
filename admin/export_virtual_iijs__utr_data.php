<?php
session_start(); 
ob_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$date=date("d_m_Y");
?>
<?PHP
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=exhibitor_utr_list.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
echo '<table border="1">';
echo '<tr>
		<th>Date</th>
		<th>RegistrationID</th>
		<th>Region</th>
		<th>BP No.</th>
		<th>Company Name</th>
		<th>GST NO</th>
		<th>contact_person_name</th>
		<th>contact_person_email</th>
		<th>contact_person_mobile_no</th>
		<th>Event</th>
		<th>category</th>
		<th>additional_image</th>
		<th>Meeting Room</th>
		<th>Show Charge</th>
		<th>image_charge</th>
		<th>meeting_charge</th>
		<th>sub_total_cost</th>
		<th>gst_total_cost</th>
		<th>grand_total_cost</th>
		<th>Agree via Whats up</th>
		<th>Payment Approval</th>
		<th>Payment DisApproval</th>
		<th>Application Approval</th>
		<th>Application DisApproval</th>
		<th>SO</th>
		<th>UTR NO</th>
		<th>UTR Approval</th>
		<th>UTR Amount</th>
		<th>UTR TDS Amount</th>
		<th>UTR Date</th>
	</tr>';
    $result = $conn ->query("SELECT a.*,u.utr_number,u.utr_approved,u.amountPaid,u.utr_date,u.tdsAmount FROM virtual_event_registration a left join utr_history u on a.registration_id=u.registration_id AND a.event_selected=u.event_selected where a.event_selected='vbsm2'");
    while ($row = $result->fetch_assoc()) { 
        echo "<tr>
			<td>".$row['post_date']."</td>
			<td>".$row['registration_id']."</td>
			<td>".getRegion($row['registration_id'],$conn)."</td>
			<td>".getBPNO($row['registration_id'],$conn)."</td>
			<td>".$row['company_name']."</td>
			<td>".getCompanyGSTNO($row['registration_id'],$conn)."</td>
			<td>".$row['contact_person_name']."</td>
			<td>".$row['contact_person_email']."</td>
			<td>".$row['contact_person_mobile_no']."</td>
			<td>".$row['event']."</td>
			<td>".$row['category']."</td>
			<td>".$row['additional_image']."</td>
			<td>".$row['meeting_room']."</td>
			<td>".$row['show_charge']."</td>
			<td>".$row['image_charge']."</td>
			<td>".$row['meeting_charge']."</td>
			<td>".$row['sub_total_cost']."</td>
			<td>".$row['gst_total_cost']."</td>
			<td>".$row['grand_total_cost']."</td>
			<td>".$row['agree']."</td>
			<td>".$row['payment_status']."</td>
			<td>".$row['payment_dissapprove_reason']."</td>
			<td>".$row['application_status']."</td>
			<td>".$row['application_dissapprove_reason']."</td>
			<td>".$row['sales_order_no']."</td>
			<td>".$row['utr_number']."</td>
			<td>".$row['utr_approved']."</td>
			<td>".$row['amountPaid']."</td>
			<td>".$row['tdsAmount']."</td>
			<td>".$row['utr_date']."</td>
			
		</tr>";
    }
    echo '</table>';
?>