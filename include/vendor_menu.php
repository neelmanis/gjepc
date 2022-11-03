<?php
session_start();
if(!isset($_SESSION['vendorId'])){header('location:vendor_login.php');}
$uid=$_SESSION['vendorId'];
//include '../db.inc.php';
//include 'functions.php';
?>
	
	<!-- <div class="hidden-lg hidden-md hidden-sm col-xs-12 nopadding"><button class="btn regMenuBtn col-md-12 form-control">Navigation <i class="text-right fa fa-caret-square-o-down" aria-hidden="true"></i></button></div> -->
<!-- 	<div class="clearfix"></div> -->
	<div class="live_update ">
		
			MANAGE VENDOR 
				<ul class="inner_under_listing">	
				
					<li> <a href="pdf/Minimum-Pre-qualification-2022-2023.pdf"  target="_blank" > Minimum Pre qualification  2022-2024 </a> </li>
					<li> <a href="vendor_profile.php" > Profile Details </a> </li>
					<li> <a href="vendor_documents.php" >Upload Documents </a> </li>
					<li> <a href="vendor_area_list.php" >EOI Application List</a> </li>
				</ul>		
	
	</div>

<script type="text/javascript">
if ($(window).width()<768) {
	$(".manageBox").hide();
	$(".regMenuBtn").click(function(event) {
		// $(".manageBox").slideToggle();
		$(".manageBox").fadeToggle();
		$(".manageBox").toggleClass('activated');
	});
}
</script>

<style type="text/css">
	.regMenuBtn{
		background-color: #a43b76;
    	color: #fff;
	}
	.regMenuBtn.closebtn{
		background-color: #a43b76;
	    color: #fff;
	    position: absolute;
	    left: 85%;
	    top: 2.7%;
	}
	.manageBox.activated{
		display: block;
	    position: fixed;
	    top: 0;
	    right: 0px;
	    left: 0px;
	    overflow: scroll;
	    bottom: 0px;
	    padding: 15px!important;
	    background: rgba(0, 0, 0, 0.41);
	}
</style>