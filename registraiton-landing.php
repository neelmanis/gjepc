<?php 
$pageTitle = "Gem & Jewellery |REGISTRATION - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php include 'include/header.php'; ?>
<?php
include 'db.inc.php';
include 'functions.php';
?>

<section>

<div class="container inner_container">
	
    <div class="banner_wrap mb">
		<?php include 'include/inner_banner.php'; ?>
        
    </div>
    
	<div class="row mb">
    	
        <div class="col-12">
   			<div class="title inner_title">
            	<h1>Registration</h1>
            </div>
		</div>
        
        <div class="col-12">
        	
            <div class="row justify-content-center">
            	
                <div class="col-sm-4">
                	
                    <a href="new_user_registration.php" class="user_link"> 
                    	<div class="d-flex  user_link_ic"><img src="assets/images/international_user.png" class="img-fluid d-block m-auto"></div>
                   		Domestic User Registration
                    </a>
                    
                </div>
                
                <div class="col-sm-4">
                
                	<a href="new_user_registration_international.php" class="user_link"> 
                    	<div class="d-flex  user_link_ic"><img src="assets/images/international_user.png" class="img-fluid d-block m-auto"></div>
                   		International User Registration 
                    </a>
                    
                </div>
                
            </div>
            
        </div>
        
    </div>

</div>

</section>

<?php include 'include/footer.php'; ?>
