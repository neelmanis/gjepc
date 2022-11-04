<?php
 session_start();
include('db.inc.php'); 
$registration_id=$_SESSION['USERID'];
 if(isset($_POST["id"]))  
 {  
      $sqlx = "SELECT * FROM other_contact_detail WHERE id = '".$_POST["id"]."' and registration_id='$registration_id'";  
      $result = $conn ->query($sqlx);
	  $row = $result->fetch_assoc();
      echo json_encode($row);  
 }  
 ?>