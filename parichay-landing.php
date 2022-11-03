<?php 
$pageTitle = "Gem & Jewellery |REGISTRATION - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
include 'include-new/header.php'; 
include 'db.inc.php';
?>
<section>
<div class="container inner_container">  
	<div class="grey_title_bg mb-4">              
		<div class="bold_font text-center mb-2"> 
		<div class="d-block"><img src="assets/images/gold_star.png"></div>Parichay Cards Registration 
        
        </div>    
        
      
        
           <div class="langBtn d-table mx-auto" style="position:relative; top:auto">
            <div class="d-flex justify-content-center mb-3 lang_switcher">
                <div><button onclick="location.href = 'parichay-landing.php#english';" class="lang active">English</button></div>
                <div><button onclick="location.href = 'parichay-landing-hindi.php#hindi';" class="lang">Hindi</button></div>
            </div>
        </div>
                        
	</div> 
     <div class="row justify-content-center grey_title_bg">              
		
		If your Association / Member Firm / Company has already registered for Parichay Card please&nbsp;&nbsp; <a href="https://gjepc.org/login.php" style="color:blue;">click here to login </a> <br/><br/>                   
	</div>          
	
	<div class="row mb">
        <div class="col-12">        	
            <div class="row justify-content-center">
                <div class="col-sm-4">                
                    <a href="association_registration.php" class="user_link" title="For Association Registration Click here"> 
                    <div class="d-flex user_link_ic"><img src="assets/images/parichay_icon/association.png" class="img-fluid d-block m-auto"></div>
                        Association Registration 
                    </a>                    
                </div>              	
                <div class="col-sm-4">                	
                    <a href="member-verification.php" class="user_link" title="For Company Registration Click here"> 
                    <div class="d-flex user_link_ic"><img src="assets/images/parichay_icon/company.png" class="img-fluid d-block m-auto"></div>Member Firm/Company registration
                    </a>                    
                </div>
                
				<div class="col-sm-4">                
                	<a href="add-karigar-person.php?via=person" class="user_link" title="For Karigar/Person Click here"> 
                    <div class="d-flex user_link_ic"><img src="assets/images/parichay_icon/karigar.png" class="img-fluid d-block m-auto"></div>
                   		Direct Registration
                    </a>                    
                </div> 
            </div>            
        </div>        
    </div>
    <div class="row mb justify-content-center">
        <div class="col-md-4">
            <a href="order-parichay-card.php" target="_blank" class="user_link" title="Order Parichay Card"> 
    <div class="d-flex user_link_ic"><img src="assets/images/parichay_icon/right-arrow.png" class="img-fluid d-block m-auto"></div>
    Get Your Parichay Card
    </a>
        </div>
    </div>

	
</div>
</section>
<?php include 'include-new/footer.php'; ?>