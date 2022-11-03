<?php
session_start(); 
ob_start();
include('../db.inc.php');
$date=date("d_m_Y");
?>
<?PHP
 $table = $display = "";	
$fn = "report";
  
  $table .= '<table border="1" cellpadding="0" cellspacing="0" width="100%">
	<tr>
	<td>Date</td>
	<td>Event Name</td>
	<td>Designation</td>
	<td>Organization</td>
	<td>Address</td>
	<td>Pincode</td>
	<td>Phone</td>
	<td>Email</td>
	</tr>';

  $result = mysql_query("SELECT * FROM `seminar_registration` WHERE 1") or die('Query failed!');
  while(false !== ($row = mysql_fetch_assoc($result))) {
	  
	  $post_date=date("d-m-Y",strtotime($row['post_date']));
	  $event_title=$row['event_title'];
	  $name=$row['name'];
	  $designation=$row['designation'];
	  $organization=$row['organization'];
	  $address=$row['address'];
	  $pincode=$row['pincode'];
	  $phone=$row['phone'];
	  $email=$row['email'];
	  
	  $table .= '<tr>
<td>'.$post_date.'</td>
<td>'.$event_title.'</td>
<td>'.$name.'</td>
<td>'.$designation.'</td>
<td>'.$organization.'</td>
<td>'.$address.'</td>
<td>'.$pincode.'</td>
<td>'.$phone.'</td>
<td>'.$email.'</td>
</tr>';

   /* if(!$flag) {
      // display field/column names as first row
      fputcsv($out, array_keys($row), ',', '"');
      $flag = true;
    }
    array_walk($row, 'cleanData');
    fputcsv($out, array_values($row), ',', '"'); */
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