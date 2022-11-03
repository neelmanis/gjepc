<?php
//include('../db.inc.php'); 
$hostname="localhost";
$uname="appadmin";
$pwd="#21SAq109@65%n";
$database="manual_signature";

// Create connection
$conn = new mysqli($hostname, $uname, $pwd, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
	
}
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }
?>
<?php  
function CompanyName($Exhibitor_Code,$conn)
{
	$query_visitor = "SELECT Exhibitor_Name FROM manual_signature.iijs_exhibitor where Exhibitor_Code='$Exhibitor_Code'";
	$result = $conn->query($query_visitor);
	$row = $result->fetch_assoc(); 		
		return $row['Exhibitor_Name'];
}
?>

<?php
$table = $display = "";	
$fn = "Exhibitor_Pending_vaccination_report_". date('Ymd');

$table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td>Sr. No.</td>
<td>Date</td>
<td>Company Name</td>
<td>Visitor Name</td>
<td>Mobile</td>
</tr>';
$sql="SELECT * FROM manual_signature.iijs_badge_items WHERE Badge_Item_ID NOT IN (SELECT visitor_id FROM gjepclivedatabase.visitor_lab_info where category_for='EXH')";
$result = $conn ->query($sql);
$result->num_rows;
$i=1;
while($row = $result->fetch_assoc())
{
$Exhibitor_Code = $row['Exhibitor_Code'];
$Badge_Item_ID = $row['Badge_Item_ID'];
$date = date("d-m-Y", strtotime($row['Create_Date']));
$name =$row['Badge_Name'];
$company_name = CompanyName($Exhibitor_Code,$conn);
$mobile=$row['Badge_Mobile'];
	
$table .= '<tr>
<td>'.$i.'</td>
<td>'.$date.'</td>
<td>'.$company_name.'</td>
<td>'.$name.'</td>
<td>'.$mobile.'</td>
</tr>';
$i++;	
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