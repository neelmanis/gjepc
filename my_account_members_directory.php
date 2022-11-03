<?php 
include 'include/header.php'; 

if(!isset($_SESSION['USERID'])){header('location:login.php');}
$uid=$_SESSION['USERID'];
include 'db.inc.php';
include 'functions.php';
?>

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="title">
			<h4>My Account</h4>
		</div>
	</div>

	<div class="col-md-4 col-sm-4 col-xs-12 wrapper selectedSpeaker">
		<?php include 'include/regMenu.php'; ?>
	</div>

	<div class="col-md-8 col-sm-8 col-xs-12 speakerSelector">
		
		<div class="sub_head">Members Directory</div>

		<p class="ab_description">Online Buy / Sell program enables website registered users to find and interact with GJEPC members that match their business profile.</p>

		<form action="search_result.php" method="get" >
			
			<div class="form-block form-group row">
				<div class="sub_head"><i class="fa fa-users" aria-hidden="true"></i> Members Profile</div>
				<hr>
				<div class="col-md-10">
					<p class="ab_description">View / Edit your Buy/ Sell company profile</p>
				</div>
				<div class="col-md-2 text-right">
					<a class="btn" href="members_profile.php">Click here <i class="fa fa-arrow-up" aria-hidden="true"></i></a>
				</div>
			</div>

			<div class="form-block form-group row">
				<div class="sub_head"><i class="fa fa-clone" aria-hidden="true"></i> Auto Match</div>
				<hr>
				<div class="col-md-10">
					<p class="ab_description">Auto match will display list of companies that match your business profile entered at the time of registration. You can view their storefront and send enquiries.</p>
				</div>
				<div class="col-md-2 text-right">
					<a class="btn" href="auto_match.php">Click here <i class="fa fa-arrow-up" aria-hidden="true"></i></a>
				</div>
			</div>

			<div class="form-block form-group row">
				<div class="sub_head"><i class="fa fa-search" aria-hidden="true"></i> Advance Member Search</div>
				<hr>
				<div class="col-md-10">
					<p class="ab_description">You can search companies according to business types and line of products they deal in. Search for companies dealing in diamonds or colourstones as per your needs.</p>
				</div>
				<div class="col-md-2 text-right">
					<a class="btn" href="advance_member_search.php">Click here <i class="fa fa-arrow-up" aria-hidden="true"></i></a>
				</div>
			</div>

			<div class="form-block form-group row">
				<div class="sub_head"><i class="fa fa-phone" aria-hidden="true"></i> My Enquires</div>
				<hr>
				<div class="col-md-10">
					<p class="ab_description">View enquiries you have made to companies and enquiries your have received replies to.</p>
				</div>
				<div class="col-md-2 text-right">
					<a class="btn" href="advance_member_search.php">Click here <i class="fa fa-arrow-up" aria-hidden="true"></i></a>
				</div>
			</div>

		</form>
		
	</div>


<?php include 'include/footer.php'; ?>