<?php
session_start();
?>
<title> Thank you</title>
<link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/css/bootstrap.min.css' rel='stylesheet'>
<?php
if(isset($_REQUEST['orderid']))
{
$orderid = $_REQUEST['orderid'];
?>
<div class="jumbotron text-xs-center">
  <h1 class="display-3">Thank You!</h1>
  <p class="lead"><strong>You have been successfully Submitted Form.</strong></p>
  <?php
   $member = $_SESSION['verifyMember'];
   if($member == 'NM')
   { ?>
   <p class="lead">Thank you for registered.</p>
  <?php } ?> 
  <hr>
  
  <p class="lead">
    <a class="btn btn-primary btn-sm" href="checkMember.php" role="button">Register Again</a>
  </p>
</div>
<?php
} else {
	echo 'error';
}
?>

