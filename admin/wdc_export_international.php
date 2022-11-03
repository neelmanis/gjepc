<?php
session_start(); 
ob_start();
include('../db.inc.php');

function getCountryName($countrycode)
{
	$query_sel = "SELECT country_name FROM  country_master  where country_code='$countrycode'";
	$result_sel = mysql_query($query_sel);								
	if($row = mysql_fetch_array($result_sel))		 	
	{ 		
		return $row['country_name'];
		
	}
}
?>
<?php
$fn = "wdc_report_" . date('Ymd') . "";

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Date</td>
<td>First Name</td>
<td>Last Name</td>
<td>Company Name</td> 
<td>Mobile No</td>
<td>Email</td>
<td>Gender</td>
<td>Country</td>
<td>Visa</td>
<td>PAN</td>
<td>Passport No</td>
<td>Passport issue date</td>
<td>Passport issue Authority</td>
<td>Passport Expire Date</td>
<td>Nationality</td>
<td>DOB</td>
<td>Dietary Pref</td>
<td>Arrival Date</td>
<td>Departure Date</td>
<td>Accomodation</td>
<td>Badge</td>
<td>Region</td>
</tr>';

$sql="SELECT * FROM `wdc_registration`";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result))
{	
$post_date=date("d-m-Y",strtotime($row['post_date']));
$first_name=$row['first_name'];
$last_name=$row['last_name'];
$company_name=$row['company_name'];
$mobile_no=$row['mobile_no'];
$email	=$row['email'];
$gender	=$row['gender'];
$country	=getCountryName($row['country']);
$visa	=$row['visa'];
$pan	=$row['pan_no'];
$passport_number	=$row['passport_number'];
$passport_issue_date	=$row['passport_issue_date'];
$passport_issue_authority	=$row['passport_issue_authority'];
$passport_expiry_date	=$row['passport_expiry_date'];
$nationality	=$row['nationality'];
$dob	=$row['dob'];
$dietary_pref	=$row['dietary_pref'];
$arrival_date	=$row['arrival_date'];
$departure_date	=$row['departure_date'];
$accomodation	=$row['accomodation'];
$badge	=$row['badge'];
$region	=$row['region'];

$table .= '<tr>
<td>'.$post_date.'</td>
<td>'.$first_name.'</td>
<td>'.$last_name.'</td>
<td>'.$company_name.'</td>
<td>'.$mobile_no.'</td>
<td>'.$email.'</td>
<td>'.$gender.'</td>
<td>'.$country.'</td>
<td>'.$visa.'</td>
<td>'.$pan.'</td>
<td>'.$passport_number.'</td>
<td>'.$passport_issue_date.'</td>
<td>'.$passport_issue_authority.'</td>
<td>'.$passport_expiry_date.'</td>
<td>'.$nationality.'</td>
<td>'.$dob.'</td>
<td>'.$dietary_pref.'</td>
<td>'.$arrival_date.'</td>
<td>'.$departure_date.'</td>
<td>'.$accomodation.'</td>
<td>'.$badge.'</td>
<td>'.$region.'</td>
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
