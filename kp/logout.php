<?php
session_start();
ob_start();
//session_destroy();

unset($_SESSION['MEMBERTYPE']);
unset($_SESSION['USERNAME']);
unset($_SESSION['AGENT_ID']);
unset($_SESSION['MEMBER_ID']);
unset($_SESSION['NON_MEMBER_ID']);
header("Location:login.php");  

?>