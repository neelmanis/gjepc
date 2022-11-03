<?php include('include-new/header.php');?>

<section>
	
    <div class="container mb-5 position-relative inner_banner">
        <img src="assets/images/inner_banner/IGJA.jpg" class="img-fluid d-block"> 
        <div class="innerpg_title">
            <div class="d-flex h-100">
                <div class="my-auto"><h1>India Gem & Jewellery Awards</h1></div>
            </div>
        </div>
    </div>
    
    <div class="container">
    
    	<div class="row justify-content-center  mb-5">
        
        	<div class="col-md-11 text-center">
    	
                <img src="assets/images/IGJA_logo.png" class="d-table mx-auto mb-5" />
                
               <p>The GJEPC established the India Gem & Jewellery Awards (IGJA) 48 years ago to honor leading exporters of gems and Jewellery. The selection criteria now include export performance, value addition, employment generation and investment in R&D among other parameters, during each financial year.</p>
                 
                <p>In recognition of the business excellence demonstrated by companies that are helping to strengthen 'Brand India', the GJEPC not only felicitates industry players for their exemplary performance, but also recognizes entities such as banks and agencies supplying gold that play a key role in the growth of the sector.</p>
                
                <p>Ernst & Young LLP, one of the world's leading multinational professional services providers, is the Knowledge Partner for IGJA. </p>

        	</div>
       	
        </div>
        
        <div class="row">
        	
            <div class="col-12 mb-5">
            	
                <img src="assets/images/gold_star.png" class="d-table mx-auto mb-5" />
               	
                <ul class="d-md-flex igja_nav justify-content-center mb-4">
                	<li class="flex-fill px-2"><a href="igja-awards.php" class="d-block">Awards category</a></li>
                    <li class="flex-fill px-2"><a href="igja-guidelines.php" class="d-block">Guidelines & Definitions</a></li>
                    <li class="flex-fill px-2"><a href="igja-nominations-form.php" class="d-block active">Nomination Form</a></li>
                    <li class="flex-fill px-2"><a href="igja-winners.php" class="d-block">2020 Winners</a></li>
                    <li class="flex-fill px-2"><a href="igja-gallery.php" class="d-block">Gallery</a></li>
                </ul>
                
                <div class="igja_container">
                	
                    <div class="nomination_wrp pb-3 mb-4">
                    
<!--                    	<h6 class="h6 text-uppercase"> <strong> There are two nomination forms for council members. These are : -</strong> </h6>
-->                    
						<h1 class="igja_head mt-5 mb-4">IGJA 2021 Nomination Forms</h1>

                    	<!-- <div class="nomination_box border-0 mb-3" >
                        	<p class="text-capitalize"><strong>Form 1 - Nomination Form For Council Members</strong></p>
                            <a href="igja-form.php" class="gold_btn d-table px-3 py-1 m-0">Apply</a>
                        </div>
                         <div class="nomination_box border-0 mb-3">
                            <p class="text-capitalize"><strong>Form 2 - Nomination Form For Bank Financing the Industry</strong></p>
                            <a href="nomination-form-bank-financing-the-Industry.php" class="gold_btn d-table px-3 py-1 m-0">Apply</a>
                        </div>
                        <div class="nomination_box border-0 mb-3">
                            <p class="text-capitalize"><strong>Form 3 - Nomination Form For Importer </strong></p>
                            <a href="nomination-form-importer.php" class="gold_btn d-table px-3 py-1 m-0">Apply</a>
                        </div> -->
                    	<div class="nomination_box border-0 mb-3" >
                        	<p class="text-capitalize"><strong>Form 1 - Nomination Form For Council Members</strong></p>
                            <a href="#" class="gold_btn d-table px-3 py-1 m-0">Apply</a>
                        </div>
                         <div class="nomination_box border-0 mb-3">
                            <p class="text-capitalize"><strong>Form 2 - Nomination Form For Bank Financing the Industry</strong></p>
                            <a href="#" class="gold_btn d-table px-3 py-1 m-0">Apply</a>
                        </div>
                        <div class="nomination_box border-0 mb-3">
                            <p class="text-capitalize"><strong>Form 3 - Nomination Form For Importer </strong></p>
                            <a href="#" class="gold_btn d-table px-3 py-1 m-0">Apply</a>
                        </div>
                        
                    </div>
                    
                    <!--<div class="nomination_wrp pb-3 mb-4">
                    
                    	<h6 class="h6 text-uppercase"> <strong> The awards will also felicitate supporters of the industry like banks and agencies supplying gold, CHA, etc.</strong> </h6>
                    
                    	<div class="nomination_box py-3 mb-3"><p class="text-capitalize"><strong>A. Best Bank Financing the Industry</strong></p></div>
                        
                        <div class="nomination_box border-0"><p class="text-capitalize"><strong>b. Apex and Special Recognition Awards (Theme based awards).</strong></p></div>
                    
					
                    </div>-->
                    
                    
                    <h2 class="title mb-3">For more information</h2>
                    
                    <p class="text-capitalize"><strong>Contact Person : </strong> <br> Mr. Ankit Gupta - 7020280959, Mr. Shreerangan Shrinivasan - 9619913515, Mrs. Pranali Pakhale - 7972475097</p>
                    
                   <!--  <p class="text-capitalize"> <strong>Address : Dun & Bradstreet Information Services India Pvt. Ltd.</strong> <br />
ICC Chambers 2, 2nd Floor, Near Saki Vihar Telephone Exchange, Saki Vihar Road, Powai, Mumbai – 400072</p>
					
                    <p>CIN : U74140MH1997PTC107813</p>
                    
                    <p> <strong> Phone : </strong> 91-22-66801300</p>
                    
                    <p> <strong>Fax : </strong>  91-22-28476281/82</p> -->
                    
                    <p> <strong>Email :</strong> <a href="mailto:igja@gjepcindia.com"> igja@gjepcindia.com </a> </p>
                                                          
                </div>
                
            </div>
            
        </div>
         
    </div>
	
</section>

<?php include('include-new/footer.php');?>

<script>
$(document).ready(function(){
    // Add minus icon for collapse element which is open by default
    $(".collapse.show").each(function(){
      $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
    });
    // Toggle plus minus icon on show hide of collapse element
    $(".collapse").on('show.bs.collapse', function(){
      $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");        
    }).on('shown.bs.collapse',function(){
      $('html,body').animate({scrollTop:$(this).offset().top-150});
    }).on('hide.bs.collapse', function(){
      $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
    });


});
</script>

