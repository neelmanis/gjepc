<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title>IIJS SIGNATURE 2021 e-Badges</title>
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
		<!--  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css"> -->

		<style>
			@import url("https://fonts.googleapis.com/css2?family=Montserrat&family=Roboto&display=swap");
			body {font-family: "Roboto", sans-serif; font-size: 16px;}
			.top_strip {height: 50px;}
			.grey_bg {background:#cacaca;}
			.orange_bg {background: #f58220;}
			.green_bg {background: #50b748;}
			.pink_bg {background: #db6784;}
			.content_wrp {width: 100%; max-width: 500px;}
			.visitor_pic {overflow: hidden; border-radius: 15px;}
			h1 {font-size: 18px; font-weight: 700; font-family: "Montserrat", sans-serif; line-height: 24px;}
			h2 {font-size: 25px;}
			h3 {font-size: 18px; color:#6d6f70; margin-bottom: 15px; line-height: 25px;}
			p {color: #6D6F70}
			.customer_care {text-align: center; border-radius: 100px; padding: 15px; color: #fff;}
		</style>
	</head>
	<body>
		
		<div class="main_container mb-5">
			
			<div class="mb-3 top_strip <?php echo $color;?>"></div>
				<div class="container-fluid content_wrp">
					<div class="row mb-4">
						<div class="col-6">
							
						    <div class="mb-3 visitor_pic"><img src="<?php echo $photo;?>" class="img-fluid d-block" alt=""></div> 
						 

						   
							<h1 class="text-uppercase"><?php echo strtoupper($name); ?></h1>
							<h3 class="mb-2"><?php echo strtoupper($company); ?></h3>
							<h3><?php echo $designation; ?></h3>
							<h3><?php echo $location; ?></h3>
						</div>
						<div class="col-6">

							<?php
							?>
							<img src="<?php echo base_url()."assets/images/visitor_badges/scan.jpg";?>" class="img-fluid d-block" alt="">
							<h3><?php echo $uniqueId;?></h3>
							<p class="d-table text-center mb-0" style="color:#000;"><?php echo $participantType; ?></p>
							<h3>Badge Status:
							<?php echo $badgeStatus; ?></h3>
							<h3>Entry to the show <br>
							<?php echo $days; ?></h3>
					    </div>
				    </div>
				    <div class="grey_bg customer_care mb-4">
				    	<strong>CUSTOMER CARE: +91.22.2652 4791/2/3/4</strong>
				    </div>
				    <h2 class="text-center mb-4" style="color: #8E8F90;">No entry without mask</h2>
				    <p class="mb-4">GJEPC reserves the right of entry to IIJS. This entry badge is issued subject to terms and conditions as enclosed. Please read them carefully before entering to the show.</p>
				    <div class="row justify-content-center mb-4">
						<div class="col-auto mb-3">
							<img src="<?php echo base_url()."assets/images/visitor_badges/grey_icon/01.png";?>" alt="">
						</div>
						<div class="col-auto mb-3">
							<img src="<?php echo base_url()."assets/images/visitor_badges/grey_icon/02.png";?>" alt="">
						</div>
						<div class="col-auto mb-3">
							<img src="<?php echo base_url()."assets/images/visitor_badges/grey_icon/03.png";?>" alt="">
						</div>
						<div class="col-auto mb-3">
							<img src="<?php echo base_url()."gjepc_mobile/assets/images/visitor_badges/grey_icon/04.png";?>" alt="">
						</div>
						<div class="col-auto mb-3">
							<img src="<?php echo base_url()."assets/images/visitor_badges/grey_icon/05.png";?>" alt="">
						</div>
				    </div>
				    <img src="<?php echo base_url()."gjepc_mobile/assets/images/visitor_badges/grey_icon/gjepc-signature.png";?>" class="img-fluid d-table mx-auto" alt="">
			   
				<div class="mt-5 p-3 text-center text-white grey_bg">
					<strong>Valid for IIJS Signature 2021 on <?php echo $days; ?> only</strong>
				</div>
			</div>
	    </div> 
	</body>
</html>