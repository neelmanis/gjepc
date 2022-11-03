<?php
 session_start();
include('db.inc.php'); 
$registration_id=$_SESSION['USERID'];
 if(isset($_POST["id"]))  
 {  
      $query = "SELECT * FROM other_contact_detail WHERE id = '".$_POST["id"]."' and registration_id='$registration_id'";  
      $result = mysql_query($query);  
      $row = mysql_fetch_array($result);  
      echo json_encode($row);  
 }  
 ?>