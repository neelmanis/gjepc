<?php 
$pageTitle = "Gem & Jewellery Export Promotion Council - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>

<?php 
include 'include-new/header.php';
include 'db.inc.php'; 
?>

<style>
    .panelVote, .panelVote:focus {border:2px solid #a89c5d; color: #a89c5d; display: block; padding: 20px 15px; text-transform: uppercase; font-size: 16px; font-weight: 600; position: relative;}
    .panelVote .blink {position: absolute;
    right: 15px;
    top: 50%;
   text-transform: capitalize;
  
    transform: translateY(-50%);}
    .panelVote:hover {background: #a89c5d; color: #fff;}

    .voteLink {display: block; text-transform: lowercase; font-size: 14px; margin-top: 5px;}
</style>

<!-- <div id="myModal" class="modal fade" role="dialog">
    <div class=" modal-dialog" style="max-width: 500px;">    
        <button type="button" id="click_popup" class="close"></button>   
        <div class="clear"></div>        
        <div class="modal-body popup_txt p-0">  -->
           <!-- <a href="https://floorplan.gjepc.org/" target="_blank" class="d-block "><img src="https://gjepc.org/iijs-premiere/assets/images/popup/02.07.2022.jpg" class="img-fluid d-table mx-auto" alt=""></a>
           <a href="https://registration.gjepc.org/single_visitor.php" target="_blank"><img src="https://registration.gjepc.org/images/visitor-reg-live.jpg" class="img-fluid d-table mx-auto" alt=""></a> -->
           <!-- <a href="https://amritmahotsav.nic.in/har-ghar-tiranga.htm" target="_blank"><img src="assets/images/popup/harghar-tiranga-popup-min.webp" class="img-fluid d-table mx-auto" alt=""></a> -->
           <!-- <img src="assets/images/popup/harghar-tiranga-popup.jpg" alt=""> -->
 <!--        </div>
    </div>
</div>  -->
<!-- /MODAL POPUP 1 -->

<!-- <div id="myModal2" class="modal fade" role="dialog">
    <div class="modal-dialog">    
        <button type="button" class="close" data-dismiss="modal" data-toggle="modal"></button>
        <div class="clear"></div>        
        <div class="modal-body p-3" style="background:#fff;">
            <a href="https://iijs.org/" target="_blank"> <img src="assets/images/popup.jpg" class="img-fluid d-block" /> </a>
        </div>
    </div>
</div>  --> <!-- /MODAL POPUP 2 -->

<section>

    <div class="container">
        <?php 
        $banner = "SELECT * FROM home_banner_master WHERE  (`type` ='web' OR `type` ='both') AND banner_website='GJEPC' AND `section`='home_banner' AND status='1' ORDER BY `order` ASC";
        $result_banner = $conn->query($banner);
        $count_banner = $result_banner->num_rows;
        ?>
        <div class="mb banner_slider">
                <?php if($count_banner>0){
                    while($row_banner = $result_banner->fetch_assoc()){ ?>
                        <div>
                            <div class="banner_box">                            
                            <div class="row">                                
                                <div class="col-md-6 align-items-center"><img src="assets/images/banner/<?php echo trim($row_banner['banner']);?>" id='<?php echo trim($row_banner['id']);?>' class="img-fluid d-table mx-auto capture_hits"></div>
                                    
                                <div class="col-md-6 align-items-center">
                                        <div class="d-flex h-100 banner_txt">
                                            <div class="my-auto">
                                            <?php if(!is_null($row_banner['text1']) && !empty($row_banner['text1'])){ ?>
                                                  <h2 class="animated" data-animation-in="fadeInUp"><?php echo $row_banner['text1']; ?></h2>
                                                <?php } ?>
                                                <?php if(!is_null($row_banner['text2']) && !empty($row_banner['text2'])){?>
                                                  <h2 class="animated" data-animation-in="fadeInUp"><?php echo $row_banner['text2']; ?></h2>
                                                <?php } ?>
                                            </div>                              
										</div>
								</div>                                
                            </div>                            
                            </div>                        
                        </div>
            <?php  }   } ?>           
          
                        
           <!--  <div>
                <div class="banner_box">
                    <div class="row">
                    
                        <div class="col-md-6"><img src="assets/images/banner/02.jpg" class="img-fluid d-table mx-auto"></div>
                        
                        <div class="col-md-6">
                        <div class="d-flex h-100 banner_txt">
                            <div class="my-auto">
                                <h2 class="animated" data-animation-in="fadeInUp">Every Stone Is Born Out Of the Expertise & Craft Of A Cutter. </h2>
                                <h2 class="animated" data-animation-in="fadeInUp"><span>95% </span>Of The World's Cutters Are In India</h2>
                           
                        </div>
                     </div></div>
                    
                    </div>
                    
                 </div>
            </div>
                        
            <div>
                <div class="banner_box">
                    <div class="row">
                    
                        <div class="col-md-6"><img src="assets/images/banner/03.jpg" class="img-fluid d-table mx-auto"></div>
                        
                        <div class="col-md-6">
                    <div class="d-flex h-100 banner_txt">
                        <div class="my-auto">
                            <h2 class="animated" data-animation-in="fadeInUp"><span>Bespoke Jewellery.</span></h2>
                            <h2 class="animated" data-animation-in="fadeInUp">Crafted In India, Imagined By You</h2>                       
                    </div>
                </div></div>                    
                    </div>                
            </div>        
                 
            </div>
                        
            <div>
                <div class="banner_box">
                    <div class="row">                    
                        <div class="col-md-6"><img src="assets/images/banner/04.jpg" class="img-fluid d-table mx-auto"></div>                        
                        <div class="col-md-6">
                        <div class="d-flex h-100 banner_txt">
                        <div class="my-auto">
                        <h2 class="animated" data-animation-in="fadeInUp">How Do We Deliver <span> 90% </span> Of The World's Cut & Polished Diamonds?</h2>
                        <h2 class="animated" data-animation-in="fadeInUp"><span> With Expertise & Precision.</span></h2>
                        </div>                      
                     </div></div>                    
                    </div>                    
                </div>
            </div>
                        
            <div>
            <div class="row">                    
                        <div class="col-md-6"><img src="assets/images/banner/05.jpg" class="img-fluid d-table mx-auto"></div>                        
                        <div class="col-md-6">
                        <div class="d-flex h-100 banner_txt">
                        <div class="my-auto">
                        <h2 class="animated" data-animation-in="fadeInUp">If It Can't be Made Anywhere, It Can Be Made In India</h2>
                        </div>                       
                        </div>
                        </div>                    
            </div>                    
            </div>        
        </div> -->
    
    </div> </div><!-- /banner slider -->
    
    <div class="black_bg">
        <div class="row justify-content-end">
            <div class="col-lg-11"> 
               <div class="row no-gutters align-items-center">
                    <div class="col-lg-6"> 
                        <div class="covid_wrp"> 
                           <div class="row">
                                <div class="col-lg-10">
                                    <div class="covid_links mb-4">
                                        <div class="d-flex mb-3 ab_none justify-content-between align-items-center">
                                            <div><h1 class="title mb-0">ViewPoint</h1></div>
                                            <div><a href="https://gjepc.org/solitaire/category/viewpoint/" target="_blank" class="fade_anim d-block viewPoint_btn"> View All</a></div>
                                        </div>
                                       <!--  <a href="https://gjepc.org/solitaire/south-india-is-opening-up-to-18-kt-gold/" target="_blank">South India Is Opening Up To 18-Kt Gold</a> -->

                                        <a href="https://gjepc.org/solitaire/orders-worth-%e2%82%b949407-crores-placed-at-iijs-premiere-2022-hansa-report/" target="_blank">Orders Worth ₹49407 crores Placed at IIJS Premiere 2022: Hansa Report</a>

                                        <a href="https://gjepc.org/solitaire/uks-financial-crisis-triggers-big-challenges-for-importing-jewellers/" target="_blank">UK’s Financial Crisis Triggers Big Challenges For Importing Jewellers</a>
                                        
                                
                                    </div>
                                    <a href="gjepc-webinar.php" class="fade_anim d-block viewPoint_btn rounded-0 text-center py-2 mb-4"><i class="fa fa-desktop" aria-hidden="true"></i> Click Here For Webinar</a>

                                    <!-- <a href="https://gjepc.org/igja-nominations-form.php" class="d-block position-relative"> -->
                                    <a href="https://intl.gjepc.org/dubai" class="d-block position-relative" target="_blank">
                                        <img src="assets/images/IIJS-Dubai-2022-Logo-min.webp" class="img-fluid">
                                        <!-- <span class="blink" style="position: absolute;/* top: 6px; */left: 0;right: 0; text-align: center; bottom: 20px;z-index: 1;color: #f00;/* display: table; */margin: 0 auto;font-size: 18px;">Live Now...</span> -->
                                    </a>
                                </div>                        
                            </div> 
                        </div>
                    </div>                    
                    <div class="col-lg-6 other_link">                        
                        <a href="https://indiajewelleryhub.com/" target="_blank" class="adv_slider"  style="border-bottom:5px solid #fff">
                            <div><img src="assets-new/images/home_page/rightBox01/ijh1.webp" class="w-100 border-0" alt=""></div>
                            <div><img src="assets-new/images/home_page/rightBox01/ijh2.webp" class="w-100 border-0" alt=""></div>
                            <div><img src="assets-new/images/home_page/rightBox01/ijh3.webp" class="w-100 border-0" alt=""></div>
                        </a>
                        <a href="https://gjepc.org/iijs-signature/" target="_blank" class="d-block"><img src="assets-new/images/home_page/rightBox02/iijs-signature-extend.jpg" class="w-100 d-block" alt=""></a>                                         
                    </div>  
                </div>
            </div> 
        </div>
    </div> <!-- /Covid Section -->

    <div class="d-flex align-items-center newsticker mb-5">    
        <div class="col-auto trending">Latest Updates</div>        
        <div class="col">        
            <div class="ticker_slider">
                <div> <a href="https://gjepc.org/emailer_gjepc/14.07.2022/index.html" target="_blank">Inviting Expression of Interest from Overseas miners of Coloured Gemstones for participating in 6th India Rough Gemstones Sourcing Show 2022.<span class="blink" style="color:red;">New</span></a> </div>
                <!-- <div> <a href="pdf/GJ-Trade-Trends-Annual-report-2021-22.pdf" target="_blank">Gem & Jewellery Trade Trends <span class="blink" style="color:red;">New</span></a> </div>
                <div> <a href="pdf/India_Malaysia_Global_Connect_Report4_july.pdf" target="_blank">India Global Connect Meet with Malaysia <span class="blink" style="color:red;">New</span></a> </div>
                <div> <a href="pdf/Cluster-Mapping-Study-of-the-Gems-&-Jewellery-Sector-in-India.pdf" target="_blank">Cluster Mapping Study of the Gems & Jewellery Sector in India <span class="blink" style="color:red;">New</span></a> </div>
                <div> <a href="pdf/Expression-of-Interest-Circular.pdf" target="_blank">Circular inviting Expression of interest from Overseas Miners for 5th IRGSS 2022 Show <span class="blink" style="color:red;">New</span></a> </div>
                <div> <a href="https://gjepc.org/emailer_gjepc/14.04.2021/index.html" target="_blank"> DGFT mandate to IEC holders to update IEC yearly between Apr- Jun <span class="blink" style="color:red;">New</span></a> </div>     -->
                <!-- <div> <a href="https://gjepc.org/solitaire/bulletin/gjepc-signs-mou-with-ebay-to-boost-retail-exports-of-gems-jewellery-from-india/" target="_blank"> GJEPC signs MoU with eBay to boost retail exports of Gems & Jewellery from India</a> </div>   -->  
                <!-- <div> <a href="https://gjepc.org/solitaire/policy/shortage-of-duty-free-gold-hurting-jewellery-exports-gjepc-seeks-solutions/" target="_blank"> Shortage of Duty-Free Gold Hurting Jewellery Exports; GJEPC Seeks Solutions</a> </div>            -->
            </div>
        </div>        
    </div> <!-- /ticker Section -->

   <!-- <div class="container mb-5">
        <h2 class="title text-center">EVS Voting</h2>
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <a href="https://gjepcdpgc2022.in/" target="_blank" class="panelVote">
                    Diamond Panel Voting 
                   

<span class="blink" style="color:#f00; font-size: 14px;">New*</span>

                </a></div>
                
            <div class="col-md-6"><a href="https://gjepcsjpgc2022.in/" target="_blank" class="panelVote">Studded Jewellery Panel Voting <span class="blink" style="color:#f00; font-size: 14px;">New*</span>  
</a></div>
        </div>
    </div> -->

    <div class="container mb-5">
        <div class="adv_slider">
            
             <div>
                <div class="row">
                    
                    
                     <!-- <div class="col-md-6"><a href="banking-summit-2022.php" target="_blank" class="d-block capture_click"><img src="assets-new/images/600x200bs.jpg" class="img-fluid" alt=""></a></div> -->
                     <div class="col-md-6"><a href="https://www.giaindia.in/pearl-analysis/?utm_source=GJEPC_IIJS_Pearl_GIA&utm_medium=GJEPC_IIJS_Pearl_GIA&utm_campaign=GJEPC_IIJS_Pearl_GIA&utm_id=GJEPC_IIJS_Pearl_GIA&utm_term=GJEPC_IIJS_Pearl_GIA" class="d-block capture_click" target="_blank"><img src="assets-new/images/home_page/advertisement/Pearl web banner_GJEPC-min.webp" class="img-fluid" alt=""></a></div>

                       <div class="col-md-6"><a href="https://www.gold.org/" target="_blank" class="d-block capture_click"><img src="assets-new/images/600x200%20pixel_2.jpg" class="img-fluid" alt=""></a></div>
                </div>
            </div>

            <div>
                <div class="row">
                 

                  

                    <div class="col-md-6"><a href="https://gjepc.org/solitaire/" data-id="4" class="d-block capture_click" target="_blank"><img src="assets-new/images/home_page/advertisement/solitaire.webp" class="img-fluid" alt=""></a></div>

                    
                </div>
            </div>
            
        </div>
    </div>
    
    <div class="mb grey_bg newsroom_wrp">    
        <div class="container position-relative">        
            <h1 class="title"> Newsroom </span> </h1>            
            <div class="news_slider">                
                <?php 
                $newscount = 1;
                while($newscount <= 4 )  
                { 
                $result=$conn->query("select slug,news_pic,post_date,name from news_master where status=1 and section='".$newscount."'");
                $row_news=$result->fetch_assoc();
                ?>                
                <div>
                    <a href="news_detail.php?news=<?php echo $row_news['slug'];?>">
                        <div class="news_box">
                            <img src="admin/images/news_images/<?php echo $row_news['news_pic'];?>" alt="News" class="img-fluid">
                            <span class="news_date"><?php echo date("M d, Y",strtotime($row_news['post_date']));?></span>
                            <h2><?php echo stripslashes(substr($row_news['name'],0,200));?></h2>
                            <div class="news_read_more long_arw">Read More <span></span></div>
                        </div>
                    </a>  
                </div>         
                <?php $newscount++; } ?>             
             </div>          
             <a href="news.php" class="view long_arw">View All <span></span></a>         
         </div>
               
    </div> <!-- /newsroom Section -->
    
    <div class="container mb">       
        
        <div class="event_slider"> 

           
             <div>
                <div class="event_wrp">
                    <a href="annual_reports.php"> <img src="assets/images/annualReport.jpg" class="img-fluid"> </a>
                </div>
            </div> 

            <div>
                <div class="event_wrp">
                    <a href="pdf/Unleashing-The-Export-Potential-Of-Indian-Gem&Jewellery-Sector.pdf" target="_blank"> <img src="assets-new/images/home_page/event/Unleashing-The-Export-Potential-Of-Indian-Gem&Jewellery-Sector.jpg" class="img-fluid"> </a>
                </div>
            </div> 
           
            <div>
                <div class="event_wrp">
                    <a href="pdf/The-10-Glorious-Years-of-GJEPC.pdf" target="_blank"> <img src="assets-new/images/home_page/event/gjepc-10-years-min.webp" class="img-fluid"> </a>
                </div>
            </div> 
            <div>
                <div class="event_wrp">
                    <a href="pdf/GJ-Trade-Trends-Annual-report-2021-22.pdf" target="_blank"> <img src="assets-new/images/home_page/event/annual-report-april-march-2022-min.webp" class="img-fluid"> </a>
                </div>
            </div> 
            <div>
                <div class="event_wrp">
                    <a href="pdf/India_Malaysia_Global_Connect_Report4_july.pdf" target="_blank"> <img src="assets-new/images/home_page/event/India_Malaysia_Global_Connect_Report4_july-min.webp" class="img-fluid"> </a>
                </div>
            </div> 
            <div>
                <div class="event_wrp">
                    <a href="vbsm/index.php"> <img src="assets-new/images/home_page/event/vbsm.webp" class="img-fluid"> </a>
                </div>
            </div> 
            <div>
                <div class="event_wrp">
                    <a href="parichay-card.php"> <img src="assets-new/images/home_page/event/parichay-card.webp" class="img-fluid"> </a>
                </div>
            </div>                
            <div>
                <div class="event_wrp">
                    <a href="swasthya-ratna.php"> <img src="assets-new/images/home_page/event/swasthya-ratna.webp" class="img-fluid"> </a>
                </div>
            </div>      
            <div>
                <div class="event_wrp">
                    <a href="cluster-mapping.php"> <img src="assets-new/images/home_page/event/cluster_mapping.webp" class="img-fluid"> </a>
                </div>
            </div> 
        </div>
                
    </div> <!-- /event posters Section -->
    
    <div class="container mb">                  
        <h1 class="title">GJEPC Initiative</h1>        
        <div class="logo_ticker">  
            <div>
                <div class="ticker_logo_wrp"><a href="https://gjepc.org/iijs-premiere/"><img src="assets/images/logo_ticker/iijs-premiere-23-06-2022.webp" class="img-fluid"> </a></div>
            </div>   
            <div>
                <div class="ticker_logo_wrp"><a href="https://gjepc.org/iijs-signature/"><img src="assets/images/logo_ticker/iijs-signature-23-06-2022.webp" class="img-fluid"> </a></div>
            </div>   
            <div>
                <div class="ticker_logo_wrp"><a href="design-inspiration.php"><img src="assets/images/logo_ticker/di.webp" class="img-fluid"> </a></div>
            </div> 
            <div>
                <div class="ticker_logo_wrp"><a href="india-gold-submit.php"><img src="assets/images/logo_ticker/igjs.webp" class="img-fluid"> </a></div>
            </div>  
            <div>
                <div class="ticker_logo_wrp"><a href="gems-and-jewellery-conclave.php"><img src="assets/images/logo_ticker/gjc.webp" class="img-fluid"> </a></div>
            </div>            
            <div>
                <div class="ticker_logo_wrp"><a href="https://gjepc.org/igjme/"><img src="assets/images/logo_ticker/igjme.webp" class="img-fluid"> </a></div>
            </div>  
        </div> 

    </div> <!-- /logos slider Section-->
    
    <div class="container mb-5">      

        <div class="row justify-content-center">   

            <div class="col-md-6 col-lg-4 px-4 mb-4">               
                <div class="d-flex align-items-center mb-3">                    
                    <div class="mr-2"><img src="assets/images/clr-insta.svg" class="d-block" style="width:25px; height:25px;"></div>
                    <div><h2 class="title mb-0"> @gjepcindia</h2></div>                    
                </div>
                <div id="instafeed" class="row"></div>
                <script src="assets-new/js/instafeed.min.js"></script>            
            </div>
            
            <div class="col-md-6 col-lg-4 px-4 mb-4">            
                <div class="d-flex align-items-center mb-3">                    
                    <div class="mr-2"><img src="assets/images/clr-twitter.svg" class="d-block" style="width:25px; height:25px;"></div>
                    <div><h2 class="title mb-0 ab_none" style="line-height:inherit"> @gjepcindia</h2></div>                    
                </div>              
                <div class="feed_box">                
                <a class="twitter-timeline" href="https://twitter.com/GJEPCIndia?ref_src=twsrc%5Etfw"></a> <script defer async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>                
                </div>            
            </div>

            <div class="col-md-12 col-lg-4 px-4 mb-4">   

                <div class="d-flex align-items-center mb-3">                    
                    <div class="mr-2"><img src="assets/images/money.svg" class="d-block" style="width:25px; height:25px;"></div>
                    <div><h2 class="title mb-0 ab_none" style="line-height:inherit"> Metal & Currency Rates</h2></div>                    
                </div>

                <div class="row">

                    <div class="col-lg-12 col-md-6">
                        <div class="metal_slider">
                            <?php
                            $query = "select name,rate from current_market_rate_master where status=1 order by post_date desc limit 4";
                            $result=$conn->query($query);
                            while($row=$result->fetch_assoc()){  ?>
                            <div>
                                <table class="table" style="border:1px solid #ddd; border-collapse:collapse; text-align:center;">
                                    <thead>
                                        <tr><th style="background:#f2f2f2;"><?php echo $row['name'];?></th></tr>
                                    </thead>
                                    <tr><td><?php echo $row['rate'];?></td></tr>
                                </table>
                            </div>            
                            <?php } ?>
                        </div>
                        <a href="gold-rates.php" class="cta_btn long_arw">View More<span></span></a>
                    </div>

                    <div class="col-lg-12 col-md-6">
                        
                        <div class="duty_wrp p-3 mt-md-0 mt-4 mt-lg-4">
                            <h4 class="title mb-3">Product Category Duty Chart</h4>
                            <div class="duty_slider">
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Rough Diamond </td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>NIL</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>NIL</td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>NIL</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>0.25</td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Cut & Polished Diamond</td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>7.5 </td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>10</td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>0.25</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>8.52063</td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Pearls (Process / Drill) </td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>10 </td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>10</td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>3</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>14.3 </td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Pearls (Raw)</td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>5</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>10</td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>3</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>8.665</td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Gold/silver Jewellery </td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>20</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>10 </td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>3</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>25.66</td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>SYN.IND.Diamond Powder</td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>10</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>10 </td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>3</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>14.3 </td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Semi Pre Stones (C&p) </td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>7.5</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>10 </td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>3</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>11.4974</td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Precious Stones (C&p) </td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>7.5</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>10 </td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>0.25</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>8.52063</td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Cubic Zirconia (CPD) </td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>5</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>10 </td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>3</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>8.665</td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Synthetic Stones (CPD) </td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>10</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>10 </td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>0.25</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>11.2773</td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Gold Findings/mountings</td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>20</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>10</td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>3</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>25.66</td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Imitation Jewellery</td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>20</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>10</td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>3</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>25.66</td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Lab Grown RD </td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>NIL</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>NIL</td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>0.25</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>NIL</td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Lab Grown RD </td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>7.5</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>10</td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>0.25</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>8.52063</td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Gold Bars</td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>12.5</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>3</td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>3</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>16.3 </td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                
                                <div>
                                    <div class="duty_box">
                                        <table width="100%">
                                            <tr>
                                              <td> <strong> Product </strong></td> <td>Gold (Grain/alloy/dore Bars) </td>
                                            </tr>  
                                            <tr>
                                              <td><strong>Basic</strong></td> <td>12.5</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>SWS</strong></td> <td>3</td>
                                            </tr> 
                                             <tr>
                                              <td><strong>IGST</strong></td> <td>3</td>
                                            </tr> 
                                            <tr>
                                              <td><strong>Duty%</strong></td> <td>16.3 </td>
                                            </tr> 
                                            </tr>
                                        </table>
                                    </div>
                                </div>                        
                            </div>
                        </div>                
                    </div>                
                </div>
            </div>
        </div>
    </div>
        
    <div class="container mb-5 position-relative">
        
        <div class="video_wrp">
        
            <div class="video_slider">

                <div><iframe src="https://www.youtube.com/embed/BiAafZ6M0XY" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
            
                <div><iframe src="https://www.youtube.com/embed/EMvnR4czVI0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                
                <!-- <div><iframe src="https://www.youtube.com/embed/B5zrx5k8QC4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>

                <div><iframe src="https://www.youtube.com/embed/6NupxWTLUCY" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
            
                <div><iframe src="https://www.youtube.com/embed/CztrzA0Rz5k" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
            
                <div><iframe src="https://www.youtube.com/embed/iIivuaQ-_aw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
            
                <div><iframe src="https://www.youtube.com/embed/zkHyZECmjqE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
            
                <div><iframe src="https://www.youtube.com/embed/K8zdLv5iyeI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                
                <div><iframe src="https://www.youtube.com/embed/pHIA4hMRefA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
        
                <div><iframe src="https://www.youtube.com/embed/jkDvodkUiLA" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                
                <div><iframe src="https://www.youtube.com/embed/_CSfZaq_4Qk" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                
                <div><iframe src="https://www.youtube.com/embed/xqupUE7T3Ks" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                
                <div><iframe src="https://www.youtube.com/embed/r76lqtj_olY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                
                <div><iframe src="https://www.youtube.com/embed/5GPsXPpCrLw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                
                <div><iframe src="https://www.youtube.com/embed/vvctbl_0uBY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
                
                <div><iframe src="https://www.youtube.com/embed/G-ptPaSSdOo" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div> -->         
            </div> 
         
            <div class="video_thumb_slider">
                <div><img src="assets-new/images/home_page/video_thumb/gjepc-brand.webp" class="w-100 d-block"/></div>
                <div><img src="assets-new/images/home_page/video_thumb/gjepc-corporate-new2.webp" class="w-100 d-block"/></div>
            
                <!-- <div><img src="assets-new/images/home_page/video_thumb/dgft.webp" class="w-100 d-block" /></div>
                <div><img src="assets-new/images/home_page/video_thumb/0001.webp" class="w-100 d-block" /></div>                
                <div><img src="assets-new/images/home_page/video_thumb/0002.webp" class="w-100 d-block" /></div>                
                <div><img src="assets-new/images/home_page/video_thumb/000.webp" class="w-100 d-block" /></div>                
                <div><img src="assets-new/images/home_page/video_thumb/001.webp" class="w-100 d-block" /></div>                
                <div><img src="assets-new/images/home_page/video_thumb/002.webp" class="w-100 d-block" /></div>                
                <div><img src="assets-new/images/home_page/video_thumb/003.webp" class="w-100 d-block" /></div>        
                <div><img src="assets-new/images/home_page/video_thumb/01.webp" class="w-100 d-block" /></div>                
                <div><img src="assets-new/images/home_page/video_thumb/02.webp" class="w-100 d-block" /></div>                
                <div><img src="assets-new/images/home_page/video_thumb/03.webp" class="w-100 d-block" /></div>                
                <div><img src="assets-new/images/home_page/video_thumb/04.webp" class="w-100 d-block" /></div>                
                <div><img src="assets-new/images/home_page/video_thumb/05.webp" class="w-100 d-block" /></div>                
                <div><img src="assets-new/images/home_page/video_thumb/06.webp" class="w-100 d-block" /></div>                
                <div><img src="assets-new/images/home_page/video_thumb/07.webp" class="w-100 d-block" /></div> -->
            </div>
            <a href="video-gallery.php" class="d-table mx-auto" style="color: #a89c5d;"><strong>View All</strong></a>        
        </div>
    
    </div> <!-- /video section -->
    
    <div class="grey_bg download_app">        
        <div class="container">            
            <div class="row align-items-center">                
                <div class="col-md-6">                    
                    <div class="d-table mx-auto">                    
                        <div class="mb-4 app_txt">
                            <h1 class="title mb-4"> Get The App</h1>
                            <p>Scan the below QR Code to download the GJEPC App</p>
                        </div>
                        
                        <div class="row align-items-center mb-4">                        
                            <div class="col text-center">
                                 <a href="https://play.google.com/store/apps/details?id=org.gjepc&amp;hl=en" target="_blank" class="d-block my-2"><img src="assets/images/android.webp"></a>                                
                                <a href="https://apps.apple.com/tr/app/gjepc/id1194017236" target="_blank" class="d-block my-2"><img src="assets/images/ios.webp"></a>
                            </div>                            
                            <div class="col text-center">
                                <img src="assets/images/qr.webp" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mobile_slider">
                        <div><img src="assets-new/images/home_page/mobile1.webp" class="img-fluid d-table mx-auto" /></div>
                        <div><img src="assets-new/images/home_page/mobile2.webp" class="img-fluid d-table mx-auto" /></div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /App Download-->

</section> <!-- main container wrp -->

<?php include 'include-new/footer.php'; ?>
<script>
$(document).ready(function(){
    $("#click_popup").on("click", function(e){
        e.preventDefault();
        $("#myModal").modal('toggle').fadeOut();
        $("#myModal2").modal('toggle').fadeIn();
        });
    $(".capture_click").on("click",function(e){
        e.preventDefault();
        let href = $(this).attr('href');
        let actiontype = "captureBannerClick";
        $.ajax({
        type:'POST',
        url:"ajax.php",
        data:"actionType=captureBannerClick&href="+href,
        dataType: "json",
        beforeSend: function(){
            $('#preloader').show();
            $('#status').show();
        },
        success:function(data){
        if(data.status=="success"){
            //window.location.href=data.href;
            window.open(data.href);
             $('#preloader').hide();
            $('#status').hide();
        }else{
            $('#preloader').hide();
            $('#status').hide(); 
        }
        }
        });
    });
});
</script>

<script>
    $(document).ready(function(){
        $(".capture_hits").on("click",function(e){
            e.preventDefault();
            //console.log($(this).attr('id'));
            let ids = $(this).attr('id');

            let actiontype = "captureBannerHits";
            $.ajax({
            type:'POST',
            url:"ajax.php",
            data:"actionType=captureBannerHits&id="+ids,
            dataType: "json",
            beforeSend: function(){
            //    $('#preloader').show();
            //    $('#status').show();
            },
            success:function(data){
            if(data.status=="success"){
            //window.location.href=data.href;
            //  window.open(data.banner_id);
            $('#preloader').hide();
            $('#status').hide();
            }else{
            $('#preloader').hide();
            $('#status').hide(); 
            }
            }
            });
        });
    });
</script>

<script>
    var userFeed = new Instafeed({
        get: 'GJEPCIFeed',
        userId: '243763803387644',
        accessToken: 'IGQVJXTl9pYmRaSURCeU5JQU5HVVB6Y1JtTXp4aGh3bm9jOEg1U0N5ajNiVFAyQnRaNGZAYZA3lnVHBTdUlSclUwNDYyVVVzNkxQLUJBaGJ5X2M5akFoMFhNUUJtb1lGNkhwR3RuQXlLMlNOSTZAqT0N0aAZDZD',
        limit: 9,
        template: '<div class="col-4 mb-3 px-1"><a href="{{link}}" target="_blank" class="d-block"><img src="{{image}}" class="img-fluid d-block" /></a></div>',
        resolution: 'square', 
        success: function(response){
        response.data.forEach(function(e){
        e.images.square = {
        url: e.images.thumbnail.url.replace(/vp.*\/.{32}\/.{8}\//, '').replace('150x150', '600x600'),
        width: 600,
        height: 600
        };
        });
        }
    });
    userFeed.run();
</script>