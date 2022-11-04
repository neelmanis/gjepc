<?php 
include('db.inc.php');
include('functions.php');
$pageTitle = "Gems And Jewellery Industry In India | Vision & Mission - GJEPC India";
$pageDescription  = "The Gem & Jewellery Export Promotion Council (GJEPC) was set up by the Ministry of Commerce, Government of India (GoI) in 1966. It was one of several Export Promotion Councils (EPCs) launched by the Indian Government";
?>
<?php include 'include-new/header.php'; ?>

<style>
    .cta:focus {background: #000; color: #fff;}
</style>

<section>
    

         
   
               

    
    <div class="container my-5">
        
        
                    
            
        
     
        <?php 

        $sql_webinars = "SELECT * FROM webinar_master WHERE type='webinar' AND status='1' AND id = 162 ORDER BY post_date ASC";
        $result_webinars = $conn->query($sql_webinars);
        $count_webinars = $result_webinars->num_rows;


        ?>
        
        <div class="row mb-5 justify-content-center">

            <div class="col-12 col-md-8">
                <div class="webinar_slider">
                    <?php if($count_webinars>0){
                        while ($row_webinars = $result_webinars->fetch_assoc() ) {  $id = $row_webinars['id'];?>
                    <div>
                        <a href="https://gjepc.org/pdf/banking-summit-schedule-2022.pdf" target="_blank" class="text-white d-table mx-auto mb-4">
                            <div class="webinarBox goldenBorder m-0">
                                <div class="pic"><img src="assets/images/banking.jpg" class="img-fluid d-block mb-3" /></div>
                                <!-- <div class="p-4 cta text-center" style="font-size: 20px;">
                                   
                                    Click Here
                                </div> -->
                            </div>
                        </a>
                    </div>
                       
                    <?php } }else{?>
                    <div class="mb-5">
                        <p> coming soon..</p>
                    </div>
                   <?php }?>
                    
                </div>
            
            </div>


            <div class="col-md-4">

                <a href="pdf/banking-summit-schedule-2022.pdf" target="_blank" class="cta d-block p-3 mb-4 text-center" style="font-size: 16px;">Banking Summit Schedule </a>

                 <div class="row">
                        <div class="col-6 col-lg-6 mb-4">
                            <p class="text-center"><strong>Powered by</strong></p>
                            <a href="https://www.gold.org/" target="_blank" class="d-table mx-auto"><img src="assets/images/wgc2.jpg" alt=""></a>
                        </div>
                        <div class="col-6 col-lg-6 mb-4">
                            <p class="text-center"><strong>In Association With</strong></p>
                            <a href="https://www.indusind.com/in/en/personal.html" target="_blank" class="d-table mx-auto"><img src="assets/images/indusland.jpg" alt=""></a>
                        </div>
                        <div class="col-12">
                            <p class="text-center"><strong>Co-Partners</strong></p>
                            <div class="row justify-content-center align-items-center">

                                <div class="col-sm-4">
                                    <a href="https://www.ecgc.in/" target="_blank" class="d-table mx-auto"><img src="assets/images/ecgc.jpg" class="img-fluid" alt=""></a>
                                </div>

                                <div class="col-sm-4">
                                    <a href="https://allianceinsurance.in/" target="_blank" class="d-table mx-auto"><img src="assets/images/Alliance.png" class="img-fluid" alt=""></a>
                                </div>
                                
                                <div class="col-sm-4">
                                    <a href="http://www.diamondindia.net/" target="_blank" class="d-table mx-auto"><img src="assets/images/dil.jpg" class="img-fluid" alt=""></a>
                                </div>
                                
                                <div class="col-sm-4">
                                    <a href="https://www.greenlab.diamonds/" target="_blank" class="d-table mx-auto"><img src="assets/images/green.jpg" class="img-fluid" alt=""></a>
                                </div>
                                <div class="col-sm-4">
                                    <a href="https://www.malca-amit.com/" target="_blank" class="d-table mx-auto"><img src="assets/images/amit.jpg" class="img-fluid" alt=""></a>
                                </div>
                                <div class="col-sm-4">
                                    <a href="https://www.yesbank.in/" target="_blank" class="d-table mx-auto"><img src="assets/images/YES-BANK-Logo.png" class="img-fluid" alt=""></a>
                                </div>


                            </div>  
                        </div>
                        
                    </div>
            </div>

        </div>
        
        
        
        
    </div>
    
</section>

<?php include 'include-new/footer.php'; ?>



