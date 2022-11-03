<?php include('db.inc.php');?>

<?php
function getStateName($id)
{
	$query_sel = "SELECT state_name FROM  state_master  where state_code='$id'";
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['state_name'];
		
	}
}
function CheckMembership($registration_id)
{
	$sql="select * from approval_master where registration_id='".$registration_id."' AND (`membership_issued_certificate_dt` between '2018-03-31' and '2019-03-31' || membership_renewal_dt between '2018-03-31' and '2019-03-31')";
	$result=mysql_query($sql);
	$num_rows=mysql_num_rows($result);
	if($num_rows>0)
	{
		return 'M';
	} else {
		return 'NM';
	}
}
function getCompanyNonMemBPNO($registration_id)
{
	$sql="SELECT NM_bp_number FROM registration_master where id='$registration_id'";
	$result=mysql_query($sql);
	if($row = mysql_fetch_array($result))		 	
	{ 		
		return $row['NM_bp_number'];
	}
}
function getBPNO($registration_id)
{
	$query_sel = "SELECT c_bp_number FROM communication_address_master where registration_id='$registration_id' and type_of_address='2'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['c_bp_number'];
	}
}
function getVisitorDesignationID($id)
{
	$query_sel = "SELECT type_of_designation FROM visitor_designation_master where id='$id'";	
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['type_of_designation'];
	}
}
$table = $display = "";	
$fn = "report";

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Person BP Number</td>
<td>Badge Id</td>
<td>Degignation Type</td>
<td>First Name</td>
<td>Last Name</td>
<td>Gender</td>
<td>Designation</td>
<td>Person Mobile</td>
<td>Person Email</td>
<td>Person Aadhar no</td>
<td>Person Pan no</td>
<td>Gcode</td>
<td>Company Bp Number</td>
<td>Company Email Id</td>
<td>Company pan no</td>
<td>Company gstn</td>
<td>Company Type</td>
<td>Company Name</td>
<td>address line1</td>
<td>address line2</td>
<td>address line3</td>
<td>City</td>
<td>Country</td>
<td>State</td>
<td>Pin Code</td>
<td>land line no</td>
<td>mobile no</td>
<td>member of any other organisation</td>
<td>name of organisation</td>
<td>nature_of_buisness</td>
<td>pd jewellery</td>
<td>pd_other</td>
<td>obj_of_visit</td>
<td>obj_of_visit_other</td>
<td>how_you_learn_abt_iijs</td>
<td>how_you_learn_abt_iijs_other</td>
</tr>';

$sql="select a.bp_number,a.badge_id,a.degn_type,a.name,a.lname,a.gender,a.designation,a.mobile,a.email,a.aadhar_no,a.pan_no,b.gcode,b.id,b.email_id,b.company_pan_no,b.company_gstn,b.company_type,b.company_name,b.address_line1,b.address_line2,b.address_line3,b.city,b.country,b.state,b.pin_code,b.land_line_no,b.mobile_no,b.member_of_any_other_organisation,b.name_of_organisation,b.nature_of_buisness,c.pd_jewellery,c.pd_other,c.obj_of_visit,c.oov_other,c.how_you_learn_abt_iijs,c.how_you_learn_abt_iijs_other from visitor_directory a inner join registration_master b on a.`registration_id`=b.id left join visitor_obmp_details c on a.`registration_id`=c.uid limit 29980,10000";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{	
	
$bp_number=$row['bp_number'];
$badge_id=$row['badge_id'];
$degn_type=$row['degn_type'];
$name=$row['name'];
$lname=$row['lname'];
$gender=$row['gender'];
$designation=getVisitorDesignationID($row['designation']);
$mobile=$row['mobile'];
$email=$row['email'];
$aadhar_no=$row['aadhar_no'];
$pan_no=$row['pan_no'];
$gcode=$row['gcode'];
$registration_id=$row['id'];

$checkMember = CheckMembership($registration_id);
if($checkMember=="M")
{
 $company_bp_no = getBPNO($registration_id);
} else {
  $company_bp_no = getCompanyNonMemBPNO($registration_id);
}

$email_id=$row['email_id'];
$company_pan_no=$row['company_pan_no'];
$company_gstn=$row['company_gstn'];
$company_type=$row['company_type'];
$company_name=$row['company_name'];
$address_line1=$row['address_line1'];
$address_line2=$row['address_line2'];
$address_line3=$row['address_line3'];
$city=$row['city'];
$country=$row['country'];
$state=getStateName($row['state']);
$pin_code=$row['pin_code'];
$land_line_no=$row['land_line_no'];
$mobile_no=$row['mobile_no'];
$member_of_any_other_organisation=$row['member_of_any_other_organisation'];
$name_of_organisation=$row['name_of_organisation'];
$nature_of_buisness=$row['nature_of_buisness'];
$pd_jewellery=$row['pd_jewellery'];
$pd_other=$row['pd_other'];
$obj_of_visit=$row['obj_of_visit'];
$oov_other=$row['oov_other'];
$how_you_learn_abt_iijs=$row['how_you_learn_abt_iijs'];
$how_you_learn_abt_iijs_other=$row['how_you_learn_abt_iijs_other'];


	
$table .= '<tr>
<td>'.$bp_number.'</td>
<td>'.$badge_id.'</td>
<td>'.$degn_type.'</td>
<td>'.$name.'</td>
<td>'.$lname.'</td>
<td>'.$gender.'</td>
<td>'.$designation.'</td>
<td>'.$mobile.'</td>
<td>'.$email.'</td>
<td>'.$aadhar_no.'</td>
<td>'.$pan_no.'</td>
<td>'.$gcode.'</td>
<td>'.$company_bp_no.'</td>
<td>'.$email_id.'</td>
<td>'.$company_pan_no.'</td>
<td>'.$company_gstn.'</td>
<td>'.$company_type.'</td>
<td>'.$company_name.'</td>
<td>'.$address_line1.'</td>
<td>'.$address_line2.'</td>
<td>'.$address_line3.'</td>
<td>'.$city.'</td>
<td>'.$country.'</td>
<td>'.$state.'</td>
<td>'.$pin_code.'</td>
<td>'.$land_line_no.'</td>
<td>'.$mobile_no.'</td>
<td>'.$member_of_any_other_organisation.'</td>
<td>'.$name_of_organisation.'</td>
<td>'.$pd_jewellery.'</td>
<td>'.$pd_other.'</td>
<td>'.$how_you_learn_abt_iijs.'</td>
<td>'.$how_you_learn_abt_iijs_other.'</td>
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
