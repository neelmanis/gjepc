<?php
session_start(); 
ob_start();
//if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
include('../db.inc.php');
include('../functions.php');
$date=date("d_m_Y");
$adminRegion = $_SESSION['curruser_region_id'];
$region = gotStatesName($adminRegion,$conn);

$adminRegionWiseAccess = rtrim($_SESSION['curruser_region_access'], ',');
$getRegionAccess = gotRegionwiseAccess($adminRegionWiseAccess,$conn);

?>
<?php	
$table = $display = "";	
$fn = "relief-aid_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Date</td>
<td>Modified Date</td>
<td>Registration No</td>
<td>Region</td>
<td>Worker Type</td>
<td>Parichay Card</td>
<td>Name</td>
<td>Father Name</td>
<td>Gender</td>
<td>Birth Date</td>
<td>Address</td>
<td>City</td>
<td>State</td>
<td>Pincode</td>
<td>Mobile</td>
<td>OTP Verified</td>
<td>Email</td>
<td>Owner Name 1</td>
<td>Owner Mobile 1</td>
<td>Owner Name 2</td>
<td>Owner Mobile 2</td>
<td>Industry Type</td>
<td>Nature of Work</td>
<td>Member of Any Registered Association</td>
<td>Name of Registered Association</td>
<td>AADHAR NO</td>
<td>BANK NAME</td>
<td>BANK BRANCH</td>
<td>BANK IFSC</td>
<td>BANK Account No</td>
<td>Passbook Copy</td>
<td>ID Copy</td>
<td>Statement 1</td>
<td>Statement 2</td>
<td>Statement 3</td>
<td>Application Status</td>
<td>By Admin</td>
<td>Admin Modified Date</td>
<td>Reject Reason</td>
<td>Remark</td>
</tr>';

$sql="SELECT * FROM relief_aid WHERE 1 ";
if($_GET["region"]!="")
	{
	$getRegion = $_GET["region"];
	$myRegion = gotStatesName($getRegion,$conn);
	$sql.=" and state IN (".$myRegion.")";
	} else {
		if($_SESSION['curruser_role']=="Admin")
		{
		  $sql.=" and state IN (".$getRegionAccess.") ";
		}
	}
//echo $sql; exit;

$result = $conn ->query($sql);
/*$itemcount = $result->num_rows;
$batches = $itemcount / 5000;
for ($i = 0; $i <=$batches; $i++) { 
	$offset = $i * 5000;
	*/
	//$sql1= $sql." limit $offset,5000";
	//$sql1= $sql." order by post_date desc limit 0,5000";
	//$sql1= $sql." and mod_date between '2020-09-12 00:00:00' and '2020-09-29 23:59:59' order by mod_date asc";
	//$sql1= $sql." and post_date between '2020-09-01 00:00:00' and '2020-09-29 23:59:59' order by post_date asc";
	$sql1= $sql." and application_status='P' order by post_date asc LIMIT 7000 OFFSET 25000";
	// echo $sql1; exit;
	
	/*$start_from = ($page-1) * $results_per_page;
	$sql = "SELECT * FROM ".$datatable." ORDER BY ID ASC LIMIT $start_from, ".$results_per_page; */
	$results=$conn ->query($sql1);

while($row2 = $results->fetch_assoc())
{
			//$post_date = date("d-m-Y", strtotime($row2['post_date']));
			$post_date = $row2['post_date'];
			$mod_date = $row2['mod_date'];
			$id = $row2['id'];
			$worker_type=filter($row2['worker_type']);
			$fname=filter($row2['fname']);
			$father_name=filter($row2['father_name']);
			$gender=filter($row2['gender']);
			$birth_date=filter($row2['birthdate']);
			$address=filter($row2['address']);
			$city=filter($row2['city']);
			$state=filter($row2['state']);
			$region=filter(gotStateRegionName($row2['state'],$conn));
			$pincode=filter($row2['pincode']);

			$mobile_no=filter($row2['mobile_no']);
			if($row2['otpVerified']==1){ $otpVerified='VERIFIED';}
			if($row2['otpVerified']==0){ $otpVerified='NOT VERIFIED';}
			$email=filter($row2['email']);	
			$owner_name1=filter($row2['owner_name1']);
			$owner_mobile1=filter($row2['owner_mobile1']);					
			$owner_name2=filter($row2['owner_name2']);			
			$owner_mobile2=filter($row2['owner_mobile2']);
			
			$industry_type=filter($row2['industry_type']);
			$nature_work=$row2['nature_work'];
			
			$member_of_any_other_organisation=filter($row2['member_of_any_other_organisation']);
			$name_of_organisation=filter($row2['name_of_organisation']);
			$bank_name=filter($row2['bank_name']);
			$bank_branch=filter($row2['bank_branch']);
			$bank_ifsc=filter($row2['bank_ifsc']);
			$bank_account_no=filter($row2['bank_account_no']);
			$aadhar_no=$row2['aadhar_no'];
			$parichay_card_no=filter($row2['parichay_card_no']);
			
			$upload_bank_passbook=$row2['upload_bank_passbook'];
			$id_scan_copy=$row2['id_scan_copy'];
			$statment_1=$row2['statement_1'];
			$statment_2=$row2['statement_2'];
			$statment_3=$row2['statement_3'];
			
			$application_getstatus=filter($row2['application_status']);
			if($application_getstatus == "Y"){ $application_status="APPROVED"; }
			if($application_getstatus == "P"){ $application_status="PENDING"; }
			if($application_getstatus == "C"){ $application_status="REJECT"; }
			$byAdmin =filter(getAdminName($row2['adminId'],$conn));
			$disapprove_reason=filter($row2['disapprove_reason']);
			$adminModifyDate=filter($row2['admin_update_date']);
			$remark=filter($row2['remark']);
	
$table .= '<tr>
<td>'.$post_date.'</td>
<td>'.$mod_date.'</td>
<td>GJEPC/CARE/00000'.$id.'</td>
<td>'.$region.'</td>
<td>'.$worker_type.'</td>
<td>'.$parichay_card_no.'</td>
<td>'.$fname.'</td>
<td>'.$father_name.'</td>
<td>'.$gender.'</td>
<td>'.$birth_date.'</td>
<td>'.$address.'</td>
<td>'.$city.'</td>
<td>'.getState($state,$conn).'</td>
<td>'.$pincode.'</td>
<td>'.$mobile_no.'</td>
<td>'.$otpVerified.'</td>
<td>'.$email.'</td>
<td>'.$owner_name1.'</td>
<td>'.$owner_mobile1.'</td>
<td>'.$owner_name2.'</td>
<td>'.$owner_mobile2.'</td>
<td>'.$industry_type.'</td>
<td>'.$nature_work.'</td>
<td>'.$member_of_any_other_organisation.'</td>
<td>'.$name_of_organisation.'</td>
<td>'.$aadhar_no.'</td>
<td>'.$bank_name.'</td>
<td>'.$bank_branch.'</td>
<td>'.$bank_ifsc.'</td>
<td>'.'\''.$bank_account_no.'</td>
<td>'.$upload_bank_passbook.'</td>
<td>'.$id_scan_copy.'</td>
<td>'.$statment_1.'</td>
<td>'.$statment_2.'</td>
<td>'.$statment_3.'</td>
<td>'.$application_status.'</td>
<td>'.$byAdmin.'</td>
<td>'.$adminModifyDate.'</td>
<td>'.$disapprove_reason.'</td>
<td>'.$remark.'</td>
</tr>';
}
//echo "Run Number: ".$i."<br />";
//}
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