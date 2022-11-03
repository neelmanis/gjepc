<div class="inner_maintopbg">
<div class="mainwidth">
<div class="logo"><a href="kimberley_process_search_applications.php"><img src="images/gjepc_logo.png" alt="GJEPC INDIA" title="GJEPC INDIA" border="0" /></a></div>

<!-- Search -->
<div class="search">

<div class="login">
<?php if(isset($_SESSION['USERNAME'])){ ?>
	<div class="welcome">
		Welcome <b><a href="kimberley_process_search_applications.php"><?php echo $_SESSION['USERNAME'];?></a></b>
    </div>
<div class="whitestrip_min"></div><?php }?>
<?php if(isset($_SESSION['USERNAME'])){?>
<div class="login_img"><img src="images/logout_icon.png" alt="Logout " title="Logout " /></div>
<div class="login_texr"><a href="logout.php">Logout </a></div>
<?php } else { ?>
<div class="login_img"><img src="images/login_icon.png" alt="Login " title="Login " /></div>
<div class="login_texr"><a href="login.php">Login/Registraiton</a></div>
<?php } ?>
</div>

<div class="whitestrip"></div>

<div class="fbicon"><a href="https://www.facebook.com/GJEPC" target="_blank"><img src="images/fb_icon.png" alt="Facebook" title="Facebook" /></a></div>
<div class="fbicon"><a href="https://twitter.com/gjepc" target="_blank"><img src="images/tw_icon.png" alt="Twitter" title="Twitter" /></a></div>
</div>
<!-- Search -->

<?php 
$url = $_SERVER['PHP_SELF'];
#for live
$attach = "/";
?>
<?php
function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
$currName=curPageName();
?>
<!-- Menu -->
<div class="menuwidth">
<div id="smoothmenu1" class="ddsmoothmenu">
<ul>
<li style="margin-top:5px;"><a href="kimberley_process_search_applications.php"><img src="images/home.png" border="0" /></a></li>
<li><a href="images/pdf/KP-User-Manual.pdf" target="_blank">Online Manual</a></li>
<?php if(isset($_SESSION['USERNAME'])){ ?>
<li><a href="import_application.php"><?php if($currName=="import_application.php"){?><span class="active"> <?php }?>Import Application</a></li>

<li><a href="export_application.php"><?php if($currName=="export_application.php"){?><span class="active"> <?php }?>Export Application </a></li>
<li><a href="kimberley_process_search_applications.php"><?php if($currName=="kimberley_process_search_applications.php"){?><span class="active"> <?php }?>Application History </a>
</li>
<?php }?>
<li><a href="kimberly_info_certification_scheme.php"  style="background:none;" ><?php if($currName=="kimberly_info_certification_scheme.php"){?><span class="active"> <?php }?> Kimberley Info</a></li>

<!--<li><a href="invoice_details.php"  style="background:none;" ><?php if($currName=="invoice_details.php"){?><span class="active"> <?php }?> Invoice </a></li>-->
</ul>

</div>
</div>
<!-- Menu -->
</div>
</div>