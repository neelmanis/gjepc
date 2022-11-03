<?php
session_start();
unset($_SESSION['curruser_email_id']);
unset($_SESSION['curruser_login_id']);
unset($_SESSION['curruser_region_id']);
unset($_SESSION['curruser_role']);
session_destroy();
echo"<meta http-equiv=refresh content=\"0;url=index.php\">";
?>
