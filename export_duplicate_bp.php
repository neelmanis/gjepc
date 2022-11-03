<?php
session_start(); 
ob_start();
include('db.inc.php');
?>
<?php 
	
	echo "select a.*,b.company_name,b.region_id FROM gjepclivedatabase.communication_address_master a, gjepclivedatabase.information_master b WHERE 1 and a.registration_id=b.id GROUP BY c_bp_number HAVING count(c_bp_number)>1";exit;
	$result =$conn ->query("select a.*,b.company_name,b.region_id FROM gjepclivedatabase.communication_address_master a, gjepclivedatabase.information_master b WHERE 1 and a.registration_id=b.id GROUP BY c_bp_number HAVING count(c_bp_number)>1");
	while ($row = mysqli_fetch_assoc($result)) { 
		$c_bp_number=$row['c_bp_number'];
		//echo "SELECT * FROM gjepclivedatabase.communication_address_master where c_bp_number='$c_bp_number'";echo "<br/>";
		$result1=$conn ->query("SELECT * FROM gjepclivedatabase.communication_address_master where c_bp_number='$c_bp_number'");
		while($row1 = mysqli_fetch_assoc($result1)){
		   echo $row1['registration_id']."==".$row['region_id']."==".$row['company_name']."==".$row1['c_bp_number']."==".$row1['address1']." ".$row1['address2']." ".$row1['address3']." ".$row1['city']." ".$row1['pincode'];echo "<br/>";
		}
	}
?>