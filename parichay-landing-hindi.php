<?php 
$pageTitle = "Gem & Jewellery |REGISTRATION - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
include 'include-new/header.php'; 
include 'db.inc.php';
?>
<section>
<div class="container inner_container">  
	<div class=" grey_title_bg mb-4">              
		<div class="bold_font text-center mb-2"> 
		<div class="d-block"><img src="assets/images/gold_star.png"></div> <strong>परिचय कार्ड रजिस्ट्रेशन </strong>
        </div> 
        
        
        
         <div class="langBtn d-table mx-auto" style="position:relative; top:auto">
            <div class="d-flex justify-content-center mb-3 lang_switcher">
                <div><button onclick="location.href = 'parichay-landing.php#english';" class="lang">English</button></div>
                <div><button onclick="location.href = 'parichay-landing-hindi.php#hindi';" class="lang active">Hindi</button></div>
            </div>
        </div>
                           
	</div> 
     <div class="row justify-content-center grey_title_bg mb-4">              
		
		यदि आपकी एसोसिएशन/मेंबर फर्म/कंपनी ने परिचय कार्ड के लिए पहले ही पंजीकरण करा लिया है, तो कृपया लॉग इन करने के लिए &nbsp;
        <a href="https://gjepc.org/login.php" style="color:blue; display:table"> यहां क्लिक करें </a>                  
	</div>          
	
	<div class="row mb">
        <div class="col-12">        	
            <div class="row justify-content-center">
                <div class="col-sm-4">                
                    <a href="association_registration.php" class="user_link" title="For Association Registration Click here"> 
                    <div class="d-flex user_link_ic"><img src="assets/images/parichay_icon/association.png" class="img-fluid d-block m-auto"></div>
                       एसोसिएशन रजिस्ट्रेशन
                    </a>                    
                </div>              	
                <div class="col-sm-4">                	
                    <a href="member-verification.php" class="user_link" title="For Company Registration Click here"> 
                    <div class="d-flex user_link_ic"><img src="assets/images/parichay_icon/company.png" class="img-fluid d-block m-auto"></div>मेंबर फर्म/ कंपनी रजिस्ट्रेशन
                    </a>                    
                </div>
                
				<div class="col-sm-4">                
                	<a href="add-karigar-person.php?via=person" class="user_link" title="For Karigar/Person Click here"> 
                    <div class="d-flex user_link_ic"><img src="assets/images/parichay_icon/karigar.png" class="img-fluid d-block m-auto"></div>
                   		डायरेक्ट रजिस्ट्रेशन
                    </a>                    
                </div> 
            </div>            
        </div>        
    </div>
    <div class="row mb justify-content-center">
        <div class="col-md-4">
            <a href="order-parichay-card.php" target="_blank" class="user_link" title="Order Parichay Card"> 
    <div class="d-flex user_link_ic"><img src="assets/images/parichay_icon/right-arrow.png" class="img-fluid d-block m-auto"></div>
   अपना परिचय कार्ड डाउनलोड करें
    </a>
        </div>
    </div>

	
</div>
</section>
<?php include 'include-new/footer.php'; ?>