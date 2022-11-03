<?php 
session_start();
include('../db.inc.php');
include('../functions.php');
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
$adminID = $_SESSION['curruser_login_id'];

$table ="";	
$fn = "parichay-card-company-report-". date('Ymd');

$table .= '
<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td style="background:green;color:#fff">Registration id</td>
<td style="background:green;color:#fff">Registration Date</td>
<td style="background:green;color:#fff">Company Name</td>
<td style="background:green;color:#fff">Parichay Type</td>
<td style="background:green;color:#fff">PAN No</td>
<td style="background:green;color:#fff">GST No</td>
<td style="background:green;color:#fff">Company Email</td>
<td style="background:green;color:#fff">Address 1</td>
<td style="background:green;color:#fff">Address 2</td>
<td style="background:green;color:#fff">City</td>
<td style="background:green;color:#fff">State</td>
<td style="background:green;color:#fff">Region</td>
<td style="background:green;color:#fff">Pincode</td>
<td style="background:green;color:#fff">Phone</td>
<td style="background:green;color:#fff">Mobile</td>
<td style="background:green;color:#fff">Nature Of Business</td>

<td style="background:green;color:#fff">Association Registration No</td>
<td style="background:green;color:#fff">Association Head Name</td>
<td style="background:green;color:#fff">Association Head Designation</td>
<td style="background:green;color:#fff">Association Head Mobile</td>
<td style="background:green;color:#fff">Total Member</td>

<td style="background:green;color:#fff">No of Parichay Card </td>
<td style="background:green;color:#fff">Authorised Person </td>
<td style="background:green;color:#fff">Authorised Designation </td>
<td style="background:green;color:#fff">Authorised Mobile</td>
<td style="background:green;color:#fff">Authorised Email</td>
<td style="background:green;color:#fff">Parichay Status </td>
<td style="background:green;color:#fff">Disapprove Reason </td>
<td style="background:green;color:#fff">Company/Assocation Approved by Admin </td>
<td style="background:green;color:#fff">Admin Approval Date</td>

<td style="background:green;color:#fff">Application Date</td>
<td style="background:green;color:#fff">Parichay Card Number</td>
<td style="background:green;color:#fff">Karigar Name</td>
<td style="background:green;color:#fff">DOB</td>
<td style="background:green;color:#fff">Gender</td>
<td style="background:green;color:#fff">Karigar Mobile</td>
<td style="background:green;color:#fff">Karigar Email</td>
<td style="background:green;color:#fff">Address 1</td>
<td style="background:green;color:#fff">Address 2</td>
<td style="background:green;color:#fff">City</td>
<td style="background:green;color:#fff">State</td>
<td style="background:green;color:#fff">Pincode</td>

<td style="background:green;color:#fff">Bank</td>
<td style="background:green;color:#fff">Account No</td>
<td style="background:green;color:#fff">IFSC Code</td>
<td style="background:green;color:#fff">Employment status</td>
<td style="background:green;color:#fff">Work experience in G&J industry</td>
<td style="background:green;color:#fff">Applicable Industry</td>
<td style="background:green;color:#fff">Applicable Skills</td>
<td style="background:green;color:#fff">Swasthya Kosh Opted</td>

<td style="background:green;color:#fff">Spouse Name</td>
<td style="background:green;color:#fff">Spouse Gender</td>
<td style="background:green;color:#fff">Spouse DOB</td>
<td style="background:green;color:#fff">Spouse Age</td>
<td style="background:green;color:#fff">Child 1</td>
<td style="background:green;color:#fff">Child 1 Gender</td>
<td style="background:green;color:#fff">Child 1 DOB</td>
<td style="background:green;color:#fff">Child 1 Age</td>
<td style="background:green;color:#fff">Child 2</td>
<td style="background:green;color:#fff">Child 2 Gender</td>
<td style="background:green;color:#fff">Child 2 DOB</td>
<td style="background:green;color:#fff">Child 2 Age</td>

<td style="background:green;color:#fff">Company/Assocation Approved by Admin </td>
<td style="background:green;color:#fff">Admin Approval Date</td>
<td style="background:green;color:#fff">Company Approval</td>
<td style="background:green;color:#fff">Company Remark</td>
<td style="background:green;color:#fff">Agency Approval</td>
<td style="background:green;color:#fff">Agency Remark</td>
</tr>';


$sqlExport = "select rm.id,rm.post_date,rm.company_name,rm.company_pan_no,rm.company_gstn,rm.land_line_no,rm.mobile_no,rm.email_id,rm.address_line1,rm.address_line2,
rm.city,rm.state,rm.pin_code,rm.nature_of_buisness,rm.parichay_type,
pc.association_registration_no,pc.association_head_name,pc.association_head_designation,pc.association_head_mobile_no1,pc.total_member,pc.no_of_parichay_card,pc.authorised_person,pc.authorised_designation,pc.authorised_mobile1,pc.authorised_email,pc.parichay_status,pc.disapprove_reason,pc.adminId as 'admin',pc.admin_update_date as 'admin_date',pp.person_series,pp.post_date as 'application_date',pp.fname,pp.mname,pp.surname,pp.date_of_birth,pp.gender,pp.blood_group,pp.mobile1,pp.email,pp.p_address1,pp.p_address2,pp.p_state,pp.p_city,pp.p_pin_code,pp.bank,pp.account_no,pp.ifsc,pp.employment_status,pp.work_experience,pp.applicable_industry,pp.applicable_skills,pp.swasthya_kosh_option,pp.spouse_name,pp.spouse_gender,pp.spouse_dob,pp.spouse_age,pp.child1,pp.child1_gender,pp.child1_dob,pp.child1_age,pp.child2,pp.child2_gender,pp.child2_dob,pp.child2_age,
pp.adminId as 'person_admin',pp.admin_update_date as 'person_admin_date' ,pp.company_approval,pp.agency_approval,pp.company_remark,pp.agency_remark
from parichay_person_details pp inner join registration_master rm on pp.registration_id=rm.id 
inner join parichay_card pc on pp.registration_id=pc.registration_id 
where rm.website='parichay' order by rm.company_name";

//$sqlExport = "SELECT rm.*,pc.* FROM registration_master rm inner join parichay_card pc on rm.id=pc.registration_id AND rm.website='parichay'";

$resultExport = $conn->query($sqlExport);
 $countExport=$resultExport->num_rows;

if($countExport > 0){
	$i=0;
	while($rowExport = $resultExport->fetch_assoc()){
	if($rowExport['parichay_type']=="M"){ $parichay_type="Company"; } else { $parichay_type="Assocation"; }
	
    $table .= '<tr>
	<td>'.$rowExport['id'].'</td>
	<td>'.$rowExport['post_date'].'</td>
	<td>'.$rowExport['company_name'].'</td>
	<td>'.$parichay_type.'</td>
	<td>'.$rowExport['company_pan_no'].'</td>
	<td>'.$rowExport['company_gstn'].'</td>
	<td>'.$rowExport['email_id'].'</td>
	<td>'.$rowExport['address_line1'].'</td>
	<td>'.$rowExport['address_line2'].'</td>
	<td>'.strtoupper($rowExport['city']).'</td>
	<td>'.strtoupper(getState($rowExport['state'],$conn)).'</td>
	<td>'.strtoupper(getRegionNameFromState($rowExport['state'],$conn)).'</td>
	<td>'.$rowExport['pin_code'].'</td>
	<td>'.$rowExport['land_line_no'].'</td>
	<td>'.$rowExport['mobile_no'].'</td>
	<td>'.$rowExport['nature_of_buisness'].'</td>
	<td>'.$rowExport['association_registration_no'].'</td>
	<td>'.$rowExport['association_head_name'].'</td>
	<td>'.$rowExport['association_head_designation'].'</td>
	<td>'.$rowExport['association_head_mobile_no1'].'</td>
	<td>'.$rowExport['total_member'].'</td>
	<td>'.$rowExport['no_of_parichay_card'].'</td>
	<td>'.$rowExport['authorised_person'].'</td>
	<td>'.$rowExport['authorised_designation'].'</td>
	<td>'.$rowExport['authorised_mobile1'].'</td>
	<td>'.$rowExport['authorised_email'].'</td>
	<td>'.$rowExport['parichay_status'].'</td>
	<td>'.$rowExport['disapprove_reason'].'</td>
	<td>'.getAdminName($rowExport['admin'],$conn).'</td>
	<td>'.date("d-m-Y", strtotime($rowExport['admin_date'])).'</td>
	
	<td>'.$rowExport['application_date'].'</td>
	<td>'.$rowExport['person_series'].'</td>
	<td>'.$rowExport['fname'].' '.$rowExport['mname'].' '.$rowExport['surname'].'</td>
	<td>'.$rowExport['date_of_birth'].'</td>
	<td>'.$rowExport['gender'].'</td>
	<td>'.$rowExport['mobile1'].'</td>
	<td>'.$rowExport['email'].'</td>
	<td>'.$rowExport['p_address1'].'</td>
	<td>'.$rowExport['p_address2'].'</td>
	<td>'.strtoupper($rowExport['p_city']).'</td>
	<td>'.strtoupper(getState($rowExport['p_state'],$conn)).'</td>
	<td>'.$rowExport['p_pin_code'].'</td>
	
	<td>'.$rowExport['bank'].'</td>
	<td>'.$rowExport['account_no'].'</td>
	<td>'.$rowExport['ifsc'].'</td>
	<td>'.$rowExport['employment_status'].'</td>
	<td>'.$rowExport['work_experience'].'</td>
	<td>'.$rowExport['applicable_industry'].'</td>
	<td>'.$rowExport['applicable_skills'].'</td>
	<td>'.$rowExport['swasthya_kosh_option'].'</td>
	<td>'.$rowExport['spouse_name'].'</td>
	<td>'.$rowExport['spouse_gender'].'</td>
	<td>'.$rowExport['spouse_dob'].'</td>
	<td>'.$rowExport['spouse_age'].'</td>
	<td>'.$rowExport['child1'].'</td>
	<td>'.$rowExport['child1_gender'].'</td>
	<td>'.$rowExport['child1_dob'].'</td>
	<td>'.$rowExport['child1_age'].'</td>
	<td>'.$rowExport['child2'].'</td>
	<td>'.$rowExport['child2_gender'].'</td>
	<td>'.$rowExport['child2_dob'].'</td>
	<td>'.$rowExport['child2_age'].'</td>
	
	<td>'.getAdminName($rowExport['person_admin'],$conn).'</td>
	<td>'.date("d-m-Y", strtotime($rowExport['person_admin_date'])).'</td>
	<td>'.$rowExport['company_approval'].'</td>
	<td>'.$rowExport['company_remark'].'</td>
	<td>'.$rowExport['agency_approval'].'</td>
	<td>'.$rowExport['agency_remark'].'</td>
	
	</tr>';
	}

} else {
	$table .= '
	<tr>
	<td colspan="8">  Company Not Found</td>
	</tr>';
}
	
	$table .= '</table>';

		header("Content-type: application/x-msdownload"); 
		# replace excelfile.xls with whatever you want the filename to default to
		header("Content-Disposition: attachment; filename=$fn.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $table;
		exit;
	
?>