<?php 
session_start();
if($_REQUEST['captcha_code'] == $_SESSION['captcha_code'])
{
	echo "true";
}
  else echo "false";
 ?>
 