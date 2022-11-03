<?php
session_start();
ob_start();
session_destroy();

unset($_SESSION['email_id']);
unset($_SESSION['survey_id']);
header("Location:survey_start.php");  
?>