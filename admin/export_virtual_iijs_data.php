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
header("Content-Disposition: attachment; filename=exhibitor_list.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");
echo '<table border="1">';
echo '<tr>
		<th>Date</th>
		<th>RegistrationID</th>
		<th>Region</th>
		<th>BP No.</th>
		<th>Company Name</th>
		<th>Contact Person Name</th>
		<th>Contact Person Email</th>
		<th>Contact Person Mobile No</th>
		<th>Contact Person Name Show</th>
		<th>Contact Person Email Show</th>
		<th>Contact Person Mobile No Show</th>
		<th>Event</th>
		<th>Category</th>
		<th>Additional Image</th>
		<th>Meeting Room</th>
		<th>show_charge</th>
		<th>image_charge</th>
		<th>meeting_charge</th>
		<th>sub_total_cost</th>
		<th>gst_total_cost</th>
		<th>grand_total_cost</th>
		<th>Agree to receive info via Whats up</th>
		<th>Payment Approval</th>
		<th>Payment DisApproval</th>
		<th>Application Approval</th>
		<th>Application DisApproval</th>
		<th>SO</th>
	</tr>';
    $result = $conn ->query("SELECT * FROM virtual_event_registration where 1 and event_version='VIRL2' order by id desc");
    while ($row = $result->fetch_assoc()) { 
        echo "<tr>
			<td>".$row['post_date']."</td>
			<td>".$row['registration_id']."</td>
			<td>".getRegion($row['registration_id'],$conn)."</td>
			<td>".getBPNO($row['registration_id'],$conn)."</td>
			<td>".$row['company_name']."</td>
			<td>".$row['contact_person_name']."</td>
			<td>".$row['contact_person_email']."</td>
			<td>".$row['contact_person_mobile_no']."</td>
			<td>".$row['contact_person_name_show']."</td>
			<td>".$row['contact_person_email_show']."</td>
			<td>".$row['contact_person_mobile_no_show']."</td>
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
		</tr>";
    }
    echo '</table>';
?>