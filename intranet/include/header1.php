<?php 
session_start();
ob_start();
include_once('db.inc.php');
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
	
?>
	<div class="header">
	<div class="logo"><a href="index.php"><img src="images/logo.png" title="GJEPC" /></a></div>
    <div class="profile">
    	<div class="name"><img src="images/idris.jpg"/><?php echo $_SESSION['username'];?></div>
        <div class="logout"><a href="logout.php">Logout</a></div>
    </div>
</div>
<?php	
}

?>
<!------------------------------------------- header ends ----------------------------------------->

<!------------------------------------------- menu starts --------------------------------------->
<div class="nav_wrap">
	<div class="nav">
    	<ul>
        	<li><a href="index.php">Home</a></li>
            <li><a href="verticals.php">Verticals</a></li>
            <li><a href="policies.php">Policies</a></li>
            <li><a href="training_calendar.php">Training Calendar</a></li>
            <li><a href="polls.php">Polls</a></li>
            <li><a href="forum.php">Forum</a></li>
            <li><a href="suggetions.php">Suggestions</a></li>
            <li><a href="mis.php">MIS</a></li>
            <li><a href="gallery_photos.php">Gallery</a></li>
        </ul>
    </div>
</div>