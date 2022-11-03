<?php include 'include-new/header.php'; ?>
<?php if(!isset($_SESSION['USERID'])){header('location:login.php');}
$uid=$_SESSION['USERID'];
include 'db.inc.php';
include 'functions.php';
?>

<section class="py-5">
	
	<div class="container inner_container">
    
        <h1 class="bold_font text-center mb-5"> <img src="assets/images/gold_star.png" class="title_star d-block mx-auto"> My Account - Trade Show</h1>

		<div class="row">
        	
            <div class="col-lg-3 col-md-4 order-sm-12" data-sticky_parent>
				<?php include 'include/regMenu.php'; ?>
			</div>
	
            <div class="col-lg-9 col-md-8 col-sm-12 order-sm-1">
            
				<p class="blue">IIJS</p>
                
                <p>The India International Jewellery Show (IIJS), has continuously evolved as India's official platform for showcasing the country's manufacturing capabilities. The Council's efforts to uniquely position IIJS is reaping huge benefits with participation from 800+ leading companies from India and overseas.</p>
                
                
        	</div>
            
        </div>
        
    </div>
    
</section>



	

	
<?php include 'include-new/footer.php'; ?>