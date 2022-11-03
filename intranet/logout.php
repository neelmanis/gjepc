<?php
session_start();
ob_start();
session_destroy();
unset($_SESSION['username']);
/*unset($_SESSION['email']);
unset($_SESSION['first_name']);
unset($_SESSION['last_name']);
unset($_SESSION['company_name']);
unset($_SESSION['registration_id']);
unset($_SESSION['participation_type']);*/
header("Location:index.php");  

?>