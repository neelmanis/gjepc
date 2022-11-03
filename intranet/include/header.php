<?php 

//$_SESSION['username'];
if(!isset($_SESSION['username']))
{
	header('location:login.php');
/*<!--<div class="header">
	<div class="logo"><a href="index.php"><img src="images/logo.png" title="GJEPC" /></a></div>
    <div class="profile">
    	
        <div class="logout"><a href="login.php">Login</a></div>
    </div>
</div>-->*/

}
else
{
	include_once('functions.php');
?>
	<div class="header">
	<div class="logo"><a href="index.php"><img src="images/logo.png" title="GJEPC" /></a></div>
    <div class="profile">
    	<div class="salaryslip"><img src="images/payslip_icon.png" /><a href="https://epic.talentproindia.com" target="_blank">Salary Slip</a></div>
    	<div class="name"><a href="employee_profile.php"><img src="images/profile/<?php echo get_profile_pic($_SESSION['user_id']); ?>"/><?php echo $_SESSION['username'];?></a></div>
        <div class="logout"><a href="logout.php" style="color:#fff;">Logout</a></div>
		<div class='clear'></div>
		    <a href='change_password1.php' style='text-align:right; float:right; '>Change Password</a>

	</div>
	
</div>
<?php	
}
 $url = $_SERVER['PHP_SELF'];
#for Local
 //$attach = "/Gjepc_intranet/";
 
 #for live
 
 $attach="/";
?>

<!------------------------------------------- header ends ----------------------------------------->

<!------------------------------------------- menu starts --------------------------------------->
<div class="nav_wrap">
	<div class="nav">
    	<ul>
        	<li><a href="index.php">Home</a></li>
            <li><a href="policies.php">Policies</a></li>
            <li><a href="training_calendar.php">EEA</a></li>
            <li><a href="polls.php">Polls</a></li>
            <li><a href="forum.php">Forum</a></li>
            <li><a href="suggestions.php">Suggestions</a></li>
           
            <li  <?php if(($url == $attach.'gallery_photos.php') || ($url== $attach.'gallery_videos.php')) { ?> class="active" <?php } ?>><a href="gallery_photos.php">Gallery</a></li>
            <li><a href="emp_directory.php">Employee Directory</a></li>
			<li><a href="verticals.php">Verticals</a></li>
			 <li><a href="mis.php">MIS</a></li>
        </ul>
    </div>
</div>