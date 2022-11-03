<?php
include('../db.inc.php');
session_start();
if(!isset($_SESSION['curruser_login_id'])) { header("location:index.php"); exit; }

$gid	=	intval($_REQUEST['id']);
$registration_id	=	intval($_REQUEST['registration_id']);

if(($_REQUEST['action']=='del') && ($_REQUEST['id']!=''))
{
	$gid = intval($_REQUEST['id']);
	if(!empty($gid) && !empty($registration_id)){
	$sql="DELETE from exh_reg_general_info where id='$gid' AND uid='$registration_id' AND year='2023'";
	$successResult = $conn->query($sql);
	if($successResult)
	{
		$sql2="DELETE from exh_reg_company_details where gid='$gid' AND uid='$registration_id' AND year='2023'";
		$successResult2 = $conn->query($sql2);
		$sql3="DELETE from exh_registration where gid='$gid' AND uid='$registration_id' AND year='2023'";
		$successResult3 = $conn->query($sql3);
		$sql4="DELETE from exh_reg_payment_details where gid='$gid' AND uid='$registration_id' AND year='2023'";
		$successResult4 = $conn->query($sql4);
	} else
	{
		die('Error: ' . mysqli_error());
	}
	echo"<meta http-equiv=refresh content=\"0;url=signature_exhibitor_rgistration.php?action=view\">";
	}
}

if(!empty($gid) && !empty($registration_id))
{	
$getStep1 ="SELECT * FROM `exh_reg_general_info` WHERE id='$gid' AND uid='$registration_id' AND year='2023'";
$resultStep1 = $conn->query($getStep1);
$numStep1 = $resultStep1->num_rows;;
if($numStep1 > 0)
{   echo "<table border='1'><tr><th>Delete</th><th>Company Name</th><th>Event</th><th>Event Selected</th></tr>";
	$rowStep1 = $resultStep1->fetch_assoc();
	?>
	<tr>
	<td><a href="delete_exh_registration.php?action=del&id=<?php echo $rowStep1['id'];?>&registration_id=<?php echo $rowStep1['uid'];?>" onClick="return(window.confirm('Are you sure you want to delete?'));"><img src="images/delete.png" title="Delete" border="0" /></a></td>
	<td><?php echo $rowStep1['company_name'];?></td>
	<td><?php echo $rowStep1["event_for"];?></td>
	<td><?php echo $rowStep1["event_selected"];?></td>
	</tr>
	</table>
<?php	
} else {
  echo 'Missing';
}
}
?>