<?php 
include 'include/header.php'; 
include 'db.inc.php';
?>
<?php
if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']))
{
    $email = filter($_GET['email']); 
    $hash = filter($_GET['hash']); 

	$sqlx = "SELECT email_id, hash, status FROM registration_master WHERE email_id='$email' AND hash='$hash' AND status='0'";
	$result = $conn ->query($sqlx);
	$match = $result->num_rows;
                 
    if($match > 0){
	$updx = "UPDATE registration_master SET status='1' WHERE email_id='".$email."' AND hash='".$hash."' AND status='0'";
	$result = $conn ->query($updx);
        echo "<div class='text-center py-5'><span style='color: green;'>Your account has been activated, you can now login</span></div>";
    } else {
        echo "<div class='text-center'><span style='color: red;'>The url is either invalid or you already have activated your account.</span></div>";
    }
                 
} else {
    echo "<div class='text-center'><span style='color: red;'>Invalid approach, please use the link that has been send to your email.</span></div>";
}
 include 'include/footer.php'; 
 ?>
