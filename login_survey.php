<?php 

session_start();
 $_SESSION['checkInFor'] = 'survey';
 header('location:login.php'); 
?>