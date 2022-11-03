<?php
session_start();
ob_start();
//session_destroy();

unset($_SESSION['vendorId']);
unset($_SESSION['company_name']);

unset($_SESSION['USERID']);
unset($_SESSION['EMAILID']);
unset($_SESSION['COMPANYNAME']);
header("Location:index.php");  

?>