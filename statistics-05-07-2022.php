<?php 
$pageTitle = "Gem Jewellery Import & Export Statistics - GJEPC India";
$pageDescription  = "The GJEPC tracks the import-export performance of the Indian gem & jewellery industry and maintains a comprehensive data base of statistical information dating back to when the Council was launched in 1966-67.";
?>
<?php 
include 'include-new/header-05-07-2022.php';
include 'db.inc.php';
include 'functions.php';
?>
<style type="text/css">
    label{
        margin-bottom: 0;
        font-size: 10px;
    }
</style>
<div class="modal fade" id="myModal2">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">

        <div class="modal-content">
           
            <div class="modal-body p-3 popup_txt" style="background:#fff; border-radius:5px;">               
                    
                <h2 class="title text-center my-3">Verify E-mail Id </h2>
                <form> 
                <div class="form-group">
                     <div class="row ">
                        <div class="col-8 pr-0"><input type="text" id="v_email"  name="v_email" class="form-control " placeholder="Email ID">                          
                        </div>
                        <div class="col-4 pl-0"><a href="javascript:void(0);" class="cta fade_anim d-table mx-auto btn-block h-100" id="v_send_otp">Verify</a></div>
                         <div class="col-12"><label for="v_email" class="error" style="display:none;"></label></div>                  
                     </div>                   
                </div>
                <div class="form-group" id="v_email_otp">
                     <div class="row ">
                        <div class="col-8 pr-0"><input type="text" id="v_otp"  name="v_otp" class="form-control " placeholder="Enter OTP"> </div>
                        <div class="col-4 pl-0"><a href="javascript:void(0);" class="cta fade_anim d-table mx-auto btn-block h-100" id="v_confirm_otp">Confirm OTP </a></div>
                        <div class="col-12"><label for="v_otp" class="error" style="display:none;"></label></div> 
                     </div>                   
                </div>
                    <p> <a class="text-info" id="registrationModal" href="javascript:void(0)" >Click here</a> for Registration form</p>
             </form>               
            </div>
           
        </div>
    </div>
</div> <!-- /MODAL POPUP 2 -->

<style>
@media (min-width: 576px){
.modal-dialog {
    /*max-width: 450px;*/
    max-width: 600px;
}
}

@media (max-width: 767px){
.modal .close {
    position: absolute;
    top: 10px;
}
}

.select_box_wrp {position: relative;}
.select_box_wrp:before {content:'\f0dd';font-family:FontAwesome;position:absolute;top: 5px;right: 15px;color: #767e86;font-size: 18px;width:10px;height: 10px;}
</style>

<section class="py-5">

    <div class="container">

        <div class="mb-5" data-aos="fade-up">
            <h1 class="bold_font text-center" style="color:#000;"> <img src="assets/images/gold_star.png" class="d-block mx-auto mb-3"> Gem & Jewellery Analytical Reports </h1>
            
            <div class="any_slider">
            <div class="px-3">
                    <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-May-2022.pdf" target="_blank" class="any_box">
                        <img src="assets/images/market_reports/April-May-2022.jpg" class="img-fluid d-block">
                    </a>
                </div>
                <div class="px-3">
                    <a href="pdf/GJ-Trade-Trends-Annual-report-2021-22.pdf" target="_blank" class="any_box">
                        <img src="assets/images/market_reports/Annual-report-2021-22.jpg" class="img-fluid d-block">
                    </a>
                </div>
                <div class="px-3">
                    <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-March-2022.pdf" target="_blank" class="any_box">
                        <img src="assets/images/market_reports/Gem-and-Jewellery-Trade-Quick-Update-April-March-2022.jpg" class="img-fluid d-block">
                    </a>
                </div>
                <div class="px-3">
                    <a href="pdf/G&J-Trade-Trends-April-December-2021-Report.pdf" target="_blank" class="any_box">
                        <img src="assets/images/market_reports/G&J-Trade-Trends-April-December-2021-Report.jpg" class="img-fluid d-block">
                    </a>
                </div>
                <div class="px-3">
                    <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-February-2022.pdf" target="_blank" class="any_box">
                        <img src="assets/images/market_reports/Gem-and-Jewellery-Trade-Quick-Update-April-February-2022.jpg" class="img-fluid d-block mb-3">
                    </a>
                </div>
                <div class="px-3">
                    <a href="pdf/market_reports/India-Malaysia-Global-Connect-Report.pdf" target="_blank" class="any_box">
                        <img src="assets/images/market_reports/India-Malaysia-Global-Connect-Report.jpg" class="img-fluid d-block mb-3">
                    </a>
                </div>
				<div class="px-3">
                    <a href="pdf/market_reports/India-Egypt-Global-Connect-Report.pdf" target="_blank" class="any_box">
                        <img src="assets/images/market_reports/global-connect.png" class="img-fluid d-block">
                    </a>
                </div>
                <div class="px-3">
                    <a href="pdf/market_reports/India???Lebanon-IGC-Report.pdf" target="_blank" class="any_box">
                        <img src="assets/images/market_reports/India???Lebanon-IGC-Report.jpg" class="img-fluid d-block"> 
                    </a>
                </div>
                <!-- <div class="px-3">
                    <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-Jan-2022.pdf" target="_blank" class="any_box">
                        <img src="assets/images/market_reports/Gem-and-Jewellery-Trade-Quick-Update-April-Jan-2022.jpg" class="img-fluid d-block"> 
                    </a>
                </div> -->
                <!-- <div class="px-3">
                    <a href="pdf/Gem-and-Jewellery-Trade-Trends-half-Report-April-september-2021.pdf" target="_blank" class="any_box">
                        <img src="assets/images/market_reports/half_report.jpg" class="img-fluid d-block">
                    </a>
                </div> -->
                <div class="px-3">
                    <a href="pdf/Reasons-of-fall-in-G&J-exports-2005-17.pdf" target="_blank" class="any_box">
                        <img src="assets/images/market_reports/Reasons-of-fall-in-G&J-exports-2005-17.jpg" class="img-fluid d-block">
                    </a>
                </div>
                <div class="px-3">
                    <a href="/assets/images/statistics/sez/SEZ-Focus-GJEPC-Quarterly-Newsletter2.pdf" target="_blank" class="any_box">
                        <img src="assets/images/market_reports/SEZ-Focus-GJEPC-Quarterly-Newsletter2.jpg" class="img-fluid d-block"> 
                    </a>
                </div>                
                <!-- <div class="px-3">
                    <a href="pdf/market_reports/India-Global-Connect-Business-Networking-Meet-India-United-Arab-Emirates-(UAE).pdf" target="_blank" class="any_box">
                        <img src="assets/images/market_reports/India???UAE-Collaboration-Possibilities.jpg" class="img-fluid d-block"> 
                    </a> 
                </div>             -->
            </div>
                
        </div> <!-- Analytical Reports Slider-->
        
        <div class="mb-5" data-aos="fade-up">
            
            <h1 class="bold_font text-center" style="color:#000;"> <img src="assets/images/gold_star.png" class="d-block mx-auto mb-3">Statistics & Trade Research</h1>            
            <!-- <h1 class="bold_font text-center" style="color:#000;"> <img src="assets/images/gold_star.png" class="d-block mx-auto mb-3"> Research & Statistics </h1>             -->
            
            <div class="d-flex newsticker statistic_ticker mb-4">    
                <div class="col-auto trending">Upcoming Releases <span class="blink" style="color:#f00; font-size:11px;">New</span></div>
        
                <div class="col">                
                    <marquee class="d-block"> 
                        <!-- <a href="#">May 2022 Export/Import figures</a> -->
                        <!-- <a href="#">G&J Trade Quick Update ??? May  2022 </a>  -->
                        <!-- <a href="#">G&J Trade Quick Update ??? April 2022 </a> -->
                        <a href="#">India ??? Malaysia Collaboration Possibilities # 2</a> 
                        <a href="#">June 2022 Export/Import Figures</a> 
                        <a href="#">G&J trade quick update ??? June 2022</a> 
                        <a href="#">G&J Trade trends quarterly report ??? (April -June 2022)</a> 
                        <a href="#">SEZ Focus Quarterly Newsletter # 3</a> 
                    </marquee>                 
                </div>  
			</div>

            <div class="d-flex newsticker statistic_ticker mb-4">    
                <div class="col-auto col-sm-2 trending">New Releases <span class="blink" style="color:#f00; font-size:11px;">New</span></div>
        
                <div class="col">                
                    <marquee class="d-block"> 
                        <a href="pdf/GJ-Trade-Trends-Annual-report-2021-22.pdf" target="_blank" class="new_pdf_wrp">Gem & Jewellery Trade Trends - April - March 2022 </a>
                        <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-March-2022.pdf" target="_blank">G&J Trade Quick update ( April -March 2022 ) </a>
                        <a href="pdf/G&J-Trade-Trends-April-December-2021-Report.pdf" target="_blank">Gems and Jewellery Trade trends Quarterly report ( April ??? December  2021 )</a> 
                        <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-February-2022.pdf" target="_blank">G&J Trade Quick update (April - February 2022)</a>    
                        <a href="pdf/market_reports/India-Malaysia-Global-Connect-Report.pdf" target="_blank">India ??? Malaysia Collaboration possibilities </a>
                        <a href="pdf/market_reports/India-Egypt-Global-Connect-Report.pdf" target="_blank">India - Egypt Collaboration possibilities </a>
                        <a href="pdf/market_reports/India???Lebanon-IGC-Report.pdf" target="_blank">India - Lebanon Collaboration possibilities</a> 
                        <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-Jan-2022.pdf" target="_blank">G&J Trade Quick update ( April -January 2022)</a>
                        <a href="assets/images/statistics/sez/SEZ-Focus-GJEPC-Quarterly-Newsletter2.pdf" target="_blank">SEZ Focus # 2 quarterly newsletter </a>     


                    </marquee>                 
                </div>        
            </div>

            <div class="row align-items-center">
                
                <div class="col-12 mb-4 mb-md-0">
                    <p>The Statistics & Trade Research section is a reservoir of Gem & Jewellery Exports/Imports statistics collected, compiled & disseminated by the Gem & Jewellery Export Promotion Council. The data is catalogued in a way which gives you the comparison for the current year and the previous year. Based on the extensive data interface a user can build upon data intelligence and take various decisions related to policy, business and projects amongst others.</p>
                </div>
            </div> 
        </div>        
        <div class="mb-5" data-aos="fade-up">
       
            <div class="statistic_Box statisticTab_wrp">
            
                <ul id="tabs" class="nav nav-tabs d-lg-flex no-gutters justify-content-center statisticTabs" role="tablist">                    
                    <li class="col nav-item">
                        <a id="tab-A" href="#pane-A" class="nav-link active text-center" data-toggle="tab" role="tab">Trade Statistics</a>
                    </li>
                    <li class="col nav-item">
                        <a id="tab-B" href="#pane-B" class="nav-link text-center" data-toggle="tab" role="tab">Trade Data Bank </a>
                    </li> 
                    <li class="col nav-item">
                        <a id="tab-C" href="#pane-C" class="nav-link text-center" data-toggle="tab" role="tab">Analytical Reports </a>
                    </li>     
                    <li class="col nav-item">
                        <a id="tab-D" href="#pane-D" class="nav-link text-center" data-toggle="tab" role="tab">Market Reports</a>
                    </li>                    
                    <li class="col nav-item">
                        <a id="tab-F" href="#pane-F" class="nav-link text-center" data-toggle="tab" role="tab">Trade Tools</a>
                    </li>                              
                    <li class="col nav-item">
                        <a id="tab-E" href="#pane-E" class="nav-link text-center" data-toggle="tab" role="tab">Trade Information</a>
                    </li>
                    <?php /* if(isset($_SESSION['USERID']) && !empty($_SESSION['USERID'])){ */?>
                    <li class="col nav-item">
                    <a id="tab-G" href="#pane-G" class="nav-link text-center" data-toggle="tab" role="tab"><strong>SEZ</strong> <span class="blink" style="color:#f00; font-size:11px; line-height: initial;">New</span></a>
                    </li>
                    <?php /* }  else { ?>
                    <li class="col nav-item">
                    <a href="javascript: void(0)" onclick = "first_alert()" class="nav-link text-center" data-toggle="tab" role="tab"><strong>SEZ</strong>
                    <span class="blink" style="color:#f00; font-size:11px;">New</span></a>
                    </li>
                    <?php } */  ?>                  
                </ul>
    
                <div id="content" class="tab-content" role="tablist">
                    <div id="pane-A" class="card tab-pane fade show active" role="tabpanel" aria-labelledby="tab-A">                    
                        <div class="card-header" role="tab" id="heading-A">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-A" aria-expanded="true" aria-controls="collapse-A">Trade Statistics</a>
                            </h5>
                        </div>
        
                        <div id="collapse-A" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-A">                          
                            <div class="card-body p-lg-0">                                            
                                <div class="row justify-content-center">                                        
                                    <div class="col-12 col-lg-6 mb-5 mb-lg-0">                                      
                                        <div class="d-flex align-items-center mb-3">                                            
                                            <div class="col p-0"><h2 class="title mb-0">Exports Of Gem & Jewellery</h2></div>                                           
                                            <div class="col-auto">
                                                <div class="year_box">
                                                    <select data-switch="export" class="select_box">
                                                        <option value="export_2022">2022</option>
                                                        <option value="export_2021">2021</option>
                                                        <option value="export_2020">2020</option>
                                                        <option value="export_2019">2019</option>
                                                    </select>
                                                </div>
                                            </div> 
                                        </div>

                                        <div id="export_2022" class="export_hide show">                                        
                                            <ul class="row">
                                                <?php
                                                $sql2="SELECT name,upload_statistics_export FROM `statistics_export_master` WHERE 1 and status='1' and set_archive='0' and year='2022' order by post_date desc";
                                                $result2= $conn ->query($sql2);
                                                $export_cnt= $result2->num_rows;
                                                if($export_cnt>0){
                                                while($rows2 = $result2->fetch_assoc()){ ?>
                                                <li class="col-sm-6 px-2">
                                                <a target="_blank" href="admin/StatisticsExport/<?php echo $rows2['upload_statistics_export'];?>" class="new_pdf_wrp"><?php echo $rows2['name'];?></a>
                                                </li>
                                                <?php }
                                                }
                                                ?>
                                            </ul>                                        
                                        </div>
                                        
                                        <div id="export_2021" class="export_hide">                                        
                                            <ul class="row">
                                                <?php
                                                $sql2="SELECT name,upload_statistics_export FROM `statistics_export_master` WHERE 1 and status='1' and set_archive='0' and year='2021' order by post_date desc";
                                                $result2= $conn ->query($sql2);
                                                $export_cnt= $result2->num_rows;
                                                if($export_cnt>0){
                                                while($rows2 = $result2->fetch_assoc()){ ?>
                                                <li class="col-sm-6 px-2">
                                                <a target="_blank" href="admin/StatisticsExport/<?php echo $rows2['upload_statistics_export'];?>" class="new_pdf_wrp"><?php echo $rows2['name'];?></a>
                                                </li>
                                                <?php }
                                                }
                                                ?>
                                            </ul>                                        
                                        </div>
                                        
                                        <div id="export_2020" class="export_hide">                                        
                                            <ul class="row">
                                                <?php
                                                $sql2="SELECT name,upload_statistics_export FROM `statistics_export_master` WHERE 1 and status='1' and set_archive='0' and year='2020' order by post_date desc";
                                                $result2= $conn ->query($sql2);
                                                $export_cnt= $result2->num_rows;
                                                if($export_cnt>0){
                                                while($rows2 = $result2->fetch_assoc()){ ?>
                                                <li class="col-sm-6 px-2">
                                                <a target="_blank" href="admin/StatisticsExport/<?php echo $rows2['upload_statistics_export'];?>" class="new_pdf_wrp"><?php echo $rows2['name'];?></a>
                                                </li>
                                                <?php }
                                                }
                                                ?>
                                            </ul>                                        
                                        </div>
                                        
                                        <div id="export_2019" class="export_hide">                                        
                                            <ul class="row">
                                                <?php
                                                $sql2="SELECT name,upload_statistics_export FROM `statistics_export_master` WHERE 1 and status='1' and set_archive='0' and year='2019' order by post_date desc";
                                                $result2= $conn ->query($sql2);
                                                $export_cnt= $result2->num_rows;
                                                if($export_cnt>0){
                                                while($rows2 = $result2->fetch_assoc()){ ?>
                                                <li class="col-sm-6 px-2">
                                                <a target="_blank" href="admin/StatisticsExport/<?php echo $rows2['upload_statistics_export'];?>" class="new_pdf_wrp"><?php echo $rows2['name'];?></a>
                                                </li>
                                                <?php }
                                                }
                                                ?>
                                            </ul>                                        
                                        </div>                                        
                                    </div>
                                    
                                    <div class="col-12 col-lg-6">                                       
                                        <div class="d-flex align-items-center mb-3">                                            
                                            <div class="col p-0"><h2 class="title mb-0">Imports Of Gem & Jewellery</h2></div>                                          
                                            <div class="col-auto">
                                                <div class="year_box">
                                                <select data-switch="import" class="select_box">
                                                    <option value="import_2022">2022</option>
                                                    <option value="import_2021">2021</option>
                                                    <option value="import_2020">2020</option>
                                                    <option value="import_2019">2019</option>
                                                </select>
                                                </div>
                                            </div> 
                                        </div>

                                        <div id="import_2022" class="import_hide show">                                        
                                            <ul class="row">
                                                <?php
                                                $sql2="SELECT name,upload_statistics_import FROM `statistics_import_master` WHERE 1 and status='1' and set_archive='0' and year='2022' order by post_date desc";
                                                $result2= $conn ->query($sql2);
                                                $export_cnt= $result2->num_rows;
                                                if($export_cnt>0){
                                                while($rows2 = $result2->fetch_assoc()){ ?>
                                                <li class="col-sm-6 px-2">
                                                <a target="_blank" href="admin/StatisticsImport/<?php echo $rows2['upload_statistics_import'];?>" class="new_pdf_wrp"><?php echo $rows2['name'];?></a>
                                                </li>
                                                <?php }
                                                }
                                                ?>
                                            </ul>                                        
                                        </div>
                                        
                                        <div id="import_2021" class="import_hide">                                        
                                            <ul class="row">
                                                <?php
                                                $sql2="SELECT name,upload_statistics_import FROM `statistics_import_master` WHERE 1 and status='1' and set_archive='0' and year='2021' order by post_date desc";
                                                $result2= $conn ->query($sql2);
                                                $export_cnt= $result2->num_rows;
                                                if($export_cnt>0){
                                                while($rows2 = $result2->fetch_assoc()){ ?>
                                                <li class="col-sm-6 px-2">
                                                <a target="_blank" href="admin/StatisticsImport/<?php echo $rows2['upload_statistics_import'];?>" class="new_pdf_wrp"><?php echo $rows2['name'];?></a>
                                                </li>
                                                <?php }
                                                }
                                                ?>
                                            </ul>                                        
                                        </div>
                                        
                                        <div id="import_2020" class="import_hide">                                        
                                            <ul class="row">
                                                <?php
                                                $sql2="SELECT name,upload_statistics_import FROM `statistics_import_master` WHERE 1 and status='1' and set_archive='0' and year='2020' order by post_date desc";
                                                $result2= $conn ->query($sql2);
                                                $export_cnt= $result2->num_rows;
                                                if($export_cnt>0){
                                                while($rows2 = $result2->fetch_assoc()){ ?>
                                                <li class="col-sm-6 px-2">
                                                <a target="_blank" href="admin/StatisticsImport/<?php echo $rows2['upload_statistics_import'];?>" class="new_pdf_wrp"><?php echo $rows2['name'];?></a>
                                                </li>
                                                <?php }
                                                }
                                                ?>
                                            </ul>                                        
                                        </div>
                                        
                                        <div id="import_2019" class="import_hide">
                                        
                                            <ul class="row">
                                                <?php
                                                $sql2="SELECT name,upload_statistics_import FROM `statistics_import_master` WHERE 1 and status='1' and set_archive='0' and year='2019' order by post_date desc";
                                                $result2= $conn ->query($sql2);
                                                $export_cnt= $result2->num_rows;
                                                if($export_cnt>0){
                                                while($rows2 = $result2->fetch_assoc()){ ?>
                                                <li class="col-sm-6 px-2">
                                                <a target="_blank" href="admin/StatisticsImport/<?php echo $rows2['upload_statistics_import'];?>" class="new_pdf_wrp"><?php echo $rows2['name'];?></a>
                                                </li>
                                                <?php }
                                                }
                                                ?>
                                            </ul>                                        
                                        </div>                                        
                                    </div>                              
                                </div>                                                          
                            </div>
                        </div>
                    </div>
                    
                    <div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">   
                                         
                        <div class="card-header" role="tab" id="heading-B">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-B" aria-expanded="false" aria-controls="collapse-B">
                                 Trade Data Bank</a>
                            </h5>
                        </div>
                        
                        <div id="collapse-B" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-B">
                            
                            <div class="card-body p-lg-0"> 
                                                        
                                <div class="row justify-content-center">                    
    
                                    <div class="col-md-6 mb-4 mb-md-0">                                    
                                        <h2 class="title">Exports</h2>
                                        <div class="cvMan_wrp pt-1 pb-1">                            
                                            <div class="row">
                                                <div class="col-12">
                                                    
                                                    <ul class="row">
                                                        <li class="col-12"><a href="value-wise-export.php" class="new_pdf_wrp">
                                                        <p class="blue">Value-wise</p>                                     
                                                        
                                                        </a></li>
                                                        <li class="col-12"><a href="commodity-wise-export.php" class="new_pdf_wrp">
                                                        <p class="blue">Commodity-wise</p>                   
                                                        
                                                        </a></li>
                                                        <li class="col-12"><a href="commodity-vs-country-wise.php" class="new_pdf_wrp">
                                                        <p class="blue">Commodity x Country-wise</p>                    
                                                        
                                                        </a></li>
                                                        <li class="col-12"><a href="country-wise-export.php" class="new_pdf_wrp">
                                                        <p class="blue">Country-wise</p> 
                                                        
                                                        </a></li>
                                                        <li class="col-12"><a href="country-wise-all-commodities.php" class="new_pdf_wrp">
                                                        <p class="blue">Country-wise all Commodities</p> 
                                                        
                                                        </a></li>
                                                        <li class="col-12"><a href="region-wise-export.php" class="new_pdf_wrp">
                                                        <p class="blue">Region-wise</p> 
                                                        
                                                        </a></li>
                                                        
                                                        <li class="col-12"><a href="region-wise-all-commodities.php" class="new_pdf_wrp">
                                                        <p class="blue">Region-wise all Commodities</p> 
                                                        
                                                        </a></li>
                                                        
                                                    </ul>
                                                </div>
                                            </div>                            
                                        </div>                                
                                    </div>
                    
                                    <div class="col-md-6">   
                                  
                                        <h2 class="title">Imports</h2>                          
                                        <div class="cvMan_wrp pt-1 pb-1">                            
                                            <div class="row">
                                                <div class="col-12">
                                                   
                                                    <ul class="row">
                                                        <li class="col-12"><a target="_blank" href="value-wise-import.php" class="new_pdf_wrp">
                                                        <p class="blue">Value-wise</p>                                     
                                                        
                                                        </a></li>
                                                        <li class="col-12"><a target="_blank" href="commodity-wise-import.php" class="new_pdf_wrp">
                                                        <p class="blue">Commodity-wise</p>                                     
                                                        
                                                        </a></li>
                                                        <li class="col-12"><a target="_blank" href="commodity-vs-country-wise-import.php" class="new_pdf_wrp">
                                                        <p class="blue">Commodity x Country-wise</p> 
														
                                                        </a></li>
                                                        <li class="col-12"><a target="_blank" href="country-wise-import.php" class="new_pdf_wrp">
                                                        <p class="blue">Country-wise</p>                                       
                                                        
                                                        </a></li>
                                                        <li class="col-12"><a target="_blank" href="country-wise-all-commodities-import.php" class="new_pdf_wrp">
                                                        <p class="blue">Country-wise all Commodities</p>   
														
                                                        </a></li>                             
                                                        <li class="col-12"><a target="_blank" href="region-wise-import.php" class="new_pdf_wrp">
                                                        <p class="blue">Region-wise</p>                                    
                                                        
                                                        </a></li>
                                                        
                                                        <li class="col-12"><a target="_blank" href="region-wise-all-commodities-import.php" class="new_pdf_wrp">
                                                        <p class="blue">Region-wise all Commodities</p>
														
                                                        </a></li>                                       
                                                    </ul>
                                                </div>                                
                                            </div>                            
                                        </div>                                
                                    </div> 
                                </div>              
                            </div>
                        </div>
                    </div>
        
                    <div id="pane-C" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-C">
                                            
                        <div class="card-header" role="tab" id="heading-C">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-C" aria-expanded="false" aria-controls="collapse-C">
                                Analytical Reports</a>
                            </h5>
                        </div>
                        
                        <div id="collapse-C" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-C"> 
                                                  
                            <div class="card-body p-lg-0">                              
                                <div class="newAccordion" id="accordion1">

                                    <div class="card">                                    
                                        <div class="card-header" id="heading1">
                                            <a class="" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>Gem & Jewellery Trade Update ??? Monthly</a>
                                        </div>
                                    
                                        <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordion1"> 
                                            <div class="card-body">   

                                                <div id="monthly_2022">

                                                    <div class="row">
                                                    <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-May-2022.pdf" target="_blank" class="new_pdf_wrp">April - May 2022 </a>
                                                        </li>
                                                         <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-March-2022.pdf" target="_blank" class="new_pdf_wrp">April - March 2022 </a>
                                                        </li>
                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-February-2022.pdf" target="_blank" class="new_pdf_wrp">April - February 2022 </a>
                                                        </li>
                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-Jan-2022.pdf" target="_blank" class="new_pdf_wrp">April - January 2022 </a>
                                                        </li>
                                                    </div>                                        
                                                                                           
                                                </div>

                                                <div id="monthly_2021" class="monthly_hide show">                                        
                                                    <ul class="row">                                              
                                                        <li class="col-md-4 px-2">
                                                        <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-December-2021.pdf" target="_blank" class="new_pdf_wrp">April - December 2021</a>
                                                        </li>
                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-November-2021.pdf" target="_blank" class="new_pdf_wrp">April - November 2021 
                                                            </a>
                                                        </li>
                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-October-2021.pdf" target="_blank" class="new_pdf_wrp">April - October 2021 
                                                            </a>
                                                        </li>
                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-September-2021.pdf" target="_blank" class="new_pdf_wrp">April - September 2021 
                                                            </a>
                                                        </li>
                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-August-2021.pdf" target="_blank" class="new_pdf_wrp">April - August 2021 </a>
                                                        </li>
                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-July-2021.pdf" target="_blank" class="new_pdf_wrp">April - July 2021</a>
                                                        </li>
                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-June-2021.pdf" target="_blank" class="new_pdf_wrp">April - June 2021
                                                            </a>
                                                        </li>
                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick Update-April-May-2021.pdf" target="_blank" class="new_pdf_wrp">April - May 2021 </a>
                                                        </li>
                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/G&J-Trade-Update-Monthly-April-2021.pdf" target="_blank" class="new_pdf_wrp">
                                                            April 2021</a>
                                                        </li> 

                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-Apr-Mar-2021.pdf" target="_blank" class="new_pdf_wrp">April???March 2021 </a>
                                                        </li>   

                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-feb-2021.pdf" target="_blank" class="new_pdf_wrp">April-February 2021</a>
                                                        </li>

                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-January-2021.pdf" target="_blank" class="new_pdf_wrp">April-January 2021</a>
                                                        </li>                                             
                                                                                     
                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-November-2020.pdf" target="_blank" class="new_pdf_wrp">April-November 2020 </a>
                                                        </li>
                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick-Update-April-September-2020.pdf" target="_blank" class="new_pdf_wrp">April-September 2020</a>
                                                        </li>

                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Quick Update-April-July-2020.pdf" target="_blank" class="new_pdf_wrp">April-July 2020
                                                            </a>
                                                        </li> 

                                                        <li class="col-md-4 px-2">
                                                            <a href="pdf/Gem-Jewellery-Trade-Update-Q1-April-June-2020.pdf" target="_blank" class="new_pdf_wrp">April-June 2020
                                                            </a>
                                                        </li>  

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Update-w.r.t-FY2020-Complete-and-Partial-Lockdown-(007).pdf" target="_blank" class="new_pdf_wrp border-0">Trade Update w.r.t FY2020-Complete and Partial Lockdown (007)
                                                            </a>
                                                        </li> 

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/Gem-and-Jewellery-Trade-Trends.pdf" target="_blank" class="new_pdf_wrp border-0">
                                                            Trends Monthly Brief Update Apr-Feb 2020</a>
                                                        </li>
                                                    </ul> 
                                                </div>                                            
                                            </div>
                                        </div>    

                                    </div>

                                    <div class="card">                                    
                                        <div class="card-header" id="heading4">
                                            <a class="" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>Gem & Jewellery Trade Update Report (Quarterly)</a>
                                        </div>
                                    
                                        <div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordion1"> 
                                            
                                            <div class="card-body">                                                     
                                                
                                            <ul class="row">  


<li class="col-md-4 px-2">
                                            <a href="pdf/GJ-Trade-Trends-Annual-report-2021-22.pdf" target="_blank" class="new_pdf_wrp">Gem & Jewellery Trade Trends - April - March 2022 </a>
                                            </li>

                                            <li class="col-md-4 px-2">
                                            <a href="pdf/G&J-Trade-Trends-April-December-2021-Report.pdf" target="_blank" class="new_pdf_wrp">Gem & Jewellery Trade Trends - April - December 2021 </a>
                                            </li>

                                            <li class="col-md-4 px-2">
                                            <a href="pdf/Gem-and-Jewellery-Trade-Trends-half-Report-April-september-2021.pdf" target="_blank" class="new_pdf_wrp">Gem & Jewellery Trade Trends - Half Yearly Report - April September 2021</a>
                                            </li>

                                            <li class="col-md-4 px-2">
                                            <a href="pdf/Gem-and-Jewellery-Trade-Trends-Quarterly-Report-April-June-2021.pdf" target="_blank" class="new_pdf_wrp">Gem & Jewellery Trade Trends - Quarterly Report April - June 2021</a>
                                            </li>
                                                
                                            <li class="col-md-4 px-2">
                                            <a href="pdf/Gem- Jewellery-Trade-Trends-Quarterly-Report-April-December-2020.pdf" target="_blank" class="new_pdf_wrp">Gem & Jewellery Trade Trends - Quarterly Report April-December 2020</a>
                                            </li>                                               
                                        </ul> 
                                            </div>
                                        </div>                                    
                                    </div>
                                    
                                    <div class="card">
                        
                                        <div class="card-header" id="heading2">
                                            <a class="" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                            <i class="fa fa-angle-down" aria-hidden="true"></i> Research Reports</a>
                                        </div>
                        
                                        <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordion1">
                                            
                                            <div class="card-body">    
                                                <ul class="row">   

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/Reasons-of-fall-in-G&J-exports-2005-17.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                           Causes of Decline in Gem and Jewellery Exports  from India FY2005 ??? FY2017 
                                                            </a>
                                                        </li>    

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/Potential-Impact-of-COVID-on-India.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            A Study on Impact of Disruption of Supply Chain on India's Gem and Jewellery Exports & Ways to Mitigate the Impact
                                                            </a>
                                                        </li>

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/A-Brief-Assessment-Section-301-and-Adverse-Impact-on-India's-G&J-Sector.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            A  Brief Assessment - Section 301 and Adverse Impact on India's G&J Sector
                                                            </a>
                                                        </li>

                                                        <li class="col-md-6 px-2">
                                                            <a href="https://gjepc.org/pdf/Impact-of-COVID-19-on-GJ-Sector.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            Impact of COVID-19 on G&J sector
                                                            </a>
                                                        </li>                                                        
                                                        <li class="col-md-6 px-2">
                                                            <a href="https://gjepc.org/pdf/Indian-USA-G&amp;J-Trade-Relations-w.r.t-CPD.pdf" target="_blank" class="h-100 new_pdf_wrp">India-USA G&J Trade</a>
                                                        </li>                                                        
                                                        <li class="col-md-6 px-2">
                                                            <a href="https://gjepc.org/pdf/Enhancing-Global-Presence-of-Jewellery-Products.pdf" target="_blank" class="h-100 new_pdf_wrp border-0">Enhancing Global Presence of Jewellery Products</a>
                                                        </li>                                                        
                                                    </ul>               
                                            </div>                                            
                                        </div>                        
                                    </div>
                                    
                                    <div class="card">
                        
                                        <div class="card-header" id="heading3">
                                            <a class="" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                            <i class="fa fa-angle-down" aria-hidden="true"></i> Economy Updates</a>
                                        </div>
                        
                                        <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordion1">
                                            
                                            <div class="card-body">

                                                <div class="d-flex justify-content-end mb-4">
                                                    <div class="col-auto">
                                                        <div class="year_box" style="max-width: 100px;">
                                                            <select data-switch="Economy_Updates" class="select_box">
                                                                <option value="EP_2022">2022</option>
                                                                <option value="EP_2021">2021</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="EP_2022" class="Economy_Updates_hide show">                                        
                                                    <ul class="row">  

                                                    <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/Foreign-Trade-Data-May-2022.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                                India???s Merchandise Exports and Gem and Jewellery Exports</a>
                                                        </li>

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/IIP-April-2022.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            Index Of Industrial Production And Use-based Index
April 2022</a>
                                                        </li>

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/World-Bank-economic-update-June-2022.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            World Bank Global Economic Perspectives, June 2022</a>
                                                        </li>

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/Foreign-Trade-Data-April-2022.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            India???s Merchandise Exports and Gem and Jewellery Exports - April 2022</a>
                                                        </li> 

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/IIP-March-2022.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            INDEX OF INDUSTRIAL PRODUCTION AND USE-BASED INDEX - March 2022</a>
                                                        </li>

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/FDI-Inflows-in-Gem-and-Jewellery-Sector-FY-2021-22.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            FDI Inflows in Indian Gem and Jewellery Sector FY 2021-2022</a>
                                                        </li> 

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/WTO-Trade-Outlook-&-Statistics-2022.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            WTO Trade Statistics & Outlook - April 2022</a>
                                                        </li> 

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/ADB-Outlook-April-2022.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            Asian Development Outlook, April 2022</a>
                                                        </li> 

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/FDI-Inflows-in-Gem-and-Jewellery-Sector-April-December-2021.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            FDI Inflows in Indian Gem and Jewellery Sector April ??? December 2021 </a>
                                                        </li> 

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/Foreign-Trade-Data-March-2022.pdf" target="_blank" class="h-100 new_pdf_wrp">India's Merchandise Exports and Gem and Jewellery Exports March 2022</a>
                                                        </li> 

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/IIP-February-2022.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            Index of industrial production and USE-based index</a>
                                                        </li> 

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/IMF-WEO-April-2022.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            IMF World Economic Outlook (WEO), April 2022</a>
                                                        </li>                                             
                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/Developing-Asia-is-projected-to-grow-by-7-in-2021-ADB.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            Asian Development Outlook, December 2021</a>
                                                        </li> 
                                                    
                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/Foreign-Trade-Data-December-2021.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            India's Merchandise Exports and Gem and Jewellery Export - December 2021 </a>
                                                        </li> 
                                                    
                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/Foreign-Trade-Data-January-2022.pdf" target="_blank" class="h-100 new_pdf_wrp">I
                                                            India's Merchandise Exports and Gem and Jewellery Exports - January 2022
                                                            </a>
                                                        </li> 
                                                        
                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/IIP-December-2021-economic-update.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            Index Of Industrial Production & Use-based Index - December 2021 </a>
                                                        </li> 
                                                                                   
                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/IIP-November-2021-economic-update.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            Index Of Industrial Production & Use-based Index - November 2021 </a>
                                                        </li>  

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/IMF-WEO-January-2022-Economic-update.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            IMF World Economic Outlook (WEO), January 2022</a>
                                                        </li>   

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/Unctad-Global-trade-update-February-2022.pdf" target="_blank" class="h-100 new_pdf_wrp border-0">
                                                            UNCTAD Global Trade Update, February 2022</a>
                                                        </li>      

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/economy_updates/2022/World-Bank-Global-economic-perspectives-Jan-2022.pdf" target="_blank" class="h-100 new_pdf_wrp border-0">
                                                            World Bank Global Economic Perspectives, January 2022</a>
                                                        </li> 

                                                    </ul>                                       
                                                </div>

                                                <div id="EP_2021" class="Economy_Updates_hide">                                        
                                                    
                                                    <ul class="row">  
                                            
                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/Global-Economy-is-projected-to-expand-by-6-IMF.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                           Global Economy is projected to expand by 6 % - IMF</a>
                                                        </li> 
                                                    
                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/UNCTAD-Global-trade-fell-by-during-2020.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            UNCTAD - Global trade fell by (-) 9% during 2020</a>
                                                        </li> 
                                                    
                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/Global-Economy-is-projected-to-expand-by-5.5.pdf" target="_blank" class="h-100 new_pdf_wrp">I
                                                            MF World economic outlook report</a>
                                                        </li> 
                                                        
                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/Global-Economy-is-projected-to-expand-by-4.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            World Bank???s Global Economic perspectives for the month of January 2021</a>
                                                        </li> 
                                                                                   
                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/GDP-in-Q1-April-June-2020-declines-by-23.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            GDP in Q1 April-June 2020 declines by 23% </a>
                                                        </li>  

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/Global-Economy-is-projected-to-contract-by-3.pdf" target="_blank" class="h-100 new_pdf_wrp">
                                                            Global Economy is projected to contract by 3%</a>
                                                        </li>   

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/FDI-Inflows-in-G-J-Sector.pdf" target="_blank" class="h-100 new_pdf_wrp border-0">
                                                            FDI Inflows in G&amp;J Sector</a>
                                                        </li>      

                                                        <li class="col-md-6 px-2">
                                                            <a href="pdf/World_merchandise_exports_decline_by_(-)3%_in_2019_projected_to_fell_between_(-)13%_&amp;_32%_converted.pdf" target="_blank" class="h-100 new_pdf_wrp border-0">
                                                            World merchandise exports decline by (-)3% in 2019 , projected to fell between (-)13% and 32% </a>
                                                        </li> 
                                                    </ul> 
                                                </div>                                            
                                            </div> 
                                        </div> 
									</div>                                    
                                </div>                                                           
                            </div>           
                        </div> 
                    </div>
        
                    <div id="pane-D" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-D">
                        
                        <div class="card-header" role="tab" id="heading-D">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-D" aria-expanded="false" aria-controls="collapse-D"> Market Reports   </a>
                            </h5>
                        </div>                        
                        <div id="collapse-D" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-D">
                        <div class="card-body p-lg-0"> 
                                <div class="row justify-content-center">                    
                                    <ul class="download_pdf row market">

                                        <li class="col-md-4 mb-4">
<a href="pdf/market_reports/India-Malaysia-Global-Connect-Report.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/India-Malaysia-Global-Connect-Report.jpg" class="img-fluid d-block mb-3">India ??? Malaysia Collaboration possibilities</i></a> </li>

									<li class="col-md-4 mb-4">
<a href="pdf/market_reports/India-Egypt-Global-Connect-Report.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/global-connect.png" class="img-fluid d-block mb-3">India Egypt Collaboration possibilities</i></a> </li>
                                        <li class="col-md-4 mb-4">
<a href="pdf/market_reports/India???Lebanon-IGC-Report.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/India???Lebanon-IGC-Report.jpg" class="img-fluid d-block mb-3"> India - Lebanon Collaboration possibilities  </i></a> </li>

                                        <li class="col-md-4 mb-4">
<a href="pdf/market_reports/India-Global-Connect-Business-Networking-Meet-India-Thailand.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/India-Global-Connect-Business-Networking-Meet-India-Thailand.jpg" class="img-fluid d-block mb-3"> India - Thailand Collaboration Possibilities  </i></a> </li>

                                         <li class="col-md-4 mb-4">
<a href="pdf/market_reports/India-Global-Connect-Business-Networking-Meet-India-Qatar.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/India-Global-Connect-Business-Networking-Meet-India-Qatar.jpg" class="img-fluid d-block mb-3"> India - Qatar Collaboration Possibilities  </i></a> </li>

                                         <li class="col-md-4 mb-4">
<a href="pdf/market_reports/India-Global-Connect-Business-Networking-Meet-India-Hong-Kong.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/India-Global-Connect-Business-Networking-Meet-India-Hong-Kong.jpg" class="img-fluid d-block mb-3"> India - Hong Kong Collaboration Possibilities  </i></a> </li>

 <li class="col-md-4 mb-4">
<a href="pdf/market_reports/India-Global-Connect-Business-Networking-Meet-India-Saudi-Arabia.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/India-Global-Connect-Business-Networking-Meet???India-Saudi-Arabia.jpg" class="img-fluid d-block mb-3"> India-Saudi Arabia Collaboration Possibilities  </i></a> </li>
                             
<li class="col-md-4 mb-4">
<a href="pdf/market_reports/Indian-Morocco-Global-Connect-Collaboration-Possibilities-1.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/Indian-Morocco-Global-Connect-Collaboration-Possibilities-1.jpg" class="img-fluid d-block mb-3"> 
Indian-Morocco Collaboration Possibilities</i></a> </li>

<li class="col-md-4 mb-4">
<a href="pdf/market_reports/India-Singapore-Unleashing-Untapped-Trade-Potential.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/india-singapore.jpg" class="img-fluid d-block mb-3"> 
India -Singapore Unleashing Untapped Trade Potential</i></a> </li>
                                                                   
<li class="col-md-4 mb-4">
<a href="pdf/market_reports/India-USA Trade Relations - Trends and Observations.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/india-usa.png" class="img-fluid d-block mb-3"> 
India-USA Trade Relations - Trends and Observations</i></a> </li>
                                    
<li class="col-md-4 mb-4">
<a href="pdf/market_reports/India-Oman-Trade-and-Investment-Possibilities.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/india-oman.jpg" class="img-fluid d-block mb-3"> 
India Oman Trade & Investment Possibilities</i></a> </li>
                                    
<li class="col-md-4 mb-4">
<a href="pdf/market_reports/India-Switzerland-Integration-Possibilities.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/switzerland.jpg" class="img-fluid d-block mb-3"> 
India Switzerland Diamond & Jewellery Integration a correct fit</i></a> </li>
                                    
<li class="col-md-4 mb-4">
<a href="pdf/market_reports/India-Angola-Collaboration-Possibilities-Reports.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/001.jpg" class="img-fluid d-block mb-3"> 
India Angola Collaboration Possibilities Reports</i></a> </li>

<li class="col-md-4 mb-4">
<a href="pdf/market_reports/India-Colombia-Trade-Synergies-Possibilities-report.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/003.jpg" class="img-fluid d-block mb-3"> 
India Colombia Trade Synergies Possibilities Reports</i></a></li>

<li class="col-md-4 mb-4">
<a href="pdf/market_reports/India-Global-Connect-IndiaUK-Key-Highlights.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/002.jpg" class="img-fluid d-block mb-3"> 
India Global Connect India-UK Key Highlights <br /> Showcasing Manufacturing Prowess of Indian G&J Sector </a> </li>

<li class="col-md-4 mb-4">
<a href="pdf/market_reports/India-Africa-Oportunities-for-Bilateral-Cooperation-in-Imitation-Jewellery-Sector.pdf" target="_blank" class="pdf_wrp enhancing h-100">
<img src="assets/images/market_reports/03.jpg" class="img-fluid d-block mb-3"> 
India-Africa Oportunities for Bilateral Cooperation in Imitation Jewellery Sector (October 2020) </a> </li> 
                                    </ul>                    
                                </div>
                            </div>                                                  
                        </div>                                          
                    </div>
                    
                    <div id="pane-E" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-E">
                        <div class="card-header" role="tab" id="heading-E">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-E" aria-expanded="false" aria-controls="collapse-E"> Trade Information</a>
                            </h5>
                        </div>
                        
                        <div id="collapse-E" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-E">
                        <div class="card-body p-lg-0">                              
                                <ul class="row">                            
                                    <li class="col-md-6 px-2">
                                        <a href="pdf/HS-Code-List.pdf" target="_blank" class="new_pdf_wrp">
                                        List Of HS Codes at 8-digit level list</a>
                                    </li>                                    
                                    <li class="col-md-6 px-2">
                                        <a href="pdf/India-Imports-Tariff-Rates-20at-HS-Code-8-digit-level.pdf" target="_blank" class="new_pdf_wrp">
                                        India's Import Tariff Rates at HS Codes - 8-digit level</a>
                                    </li>                                    
                                </ul>                    
                        </div>                                
                        </div>                        
                    </div>
                    
                    <div id="pane-F" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-F">
                        <div class="card-header" role="tab" id="heading-F">
                            <h5 class="mb-0">
                                <a class="collapsed" data-toggle="collapse" href="#collapse-F" aria-expanded="false" aria-controls="collapse-F"> Trade Tools</a>
                            </h5>
                        </div>  
                                              
                        <div id="collapse-F" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-F">   
                        <div class="card-body p-lg-0">        
                                <p>There are different Trade Tools such as detailed HS Code list, Tariff structure in India & Tariff calculators for Imports. These tools are one of its kind information and an impetus for the industry members of the Gem & Jewellery sector to boost the trade.</p> 
                                <div class="row">                                   
                                    <div class="col-sm"><a href="hs_code_list.php" class="d-block gold_btn">HS Code List</a></div>
                                    <div class="col-sm"><a href="tariff_structure_india.php" class="d-block gold_btn">Tariff structure in India</a></div>                                    
                                    <div class="col-sm"><a href="calculate-your-duty.php" class="d-block gold_btn">Tariff calculator (imports)</a></div>
                                    <div class="col-sm"><a href="tariff_structure_intl.php" class="d-block gold_btn">Import Tariff structure in different countries for India</a></div>
                                </div>                                                                
                        </div>                                                  
                        </div>   
                    </div>  
                    
                    <div id="pane-G" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-G">
                        <div class="card-header" role="tab" id="heading-G">
                            <h5 class="mb-0">
                                <a class="collapsed border-0" data-toggle="collapse" href="#collapse-G" aria-expanded="false" aria-controls="collapse-G">SEZ <span class="blink" style="color:#f00; font-size:11px;">New</span></a>
                            </h5>
                        </div>  
                                              
                        <div id="collapse-G" class="collapse" data-parent="#content" role="tabpanel" aria-labelledby="heading-G">   
                        <div class="card-body p-lg-0"> 
                            <ul class="row">

                                <li class="col-md-6 px-2">
                                <a href="assets/images/statistics/sez/SEZ-Members-Meet-sep-2021.pdf" target="_blank" class="new_pdf_wrp">SEZ Interactive Meet - September 2021</a>
                                </li>

                                <li class="col-md-6 px-2">
                                <a href="assets/images/statistics/sez/SEZ-Pulse-of-India-Gem-and-Jewellery-Exports.pdf" target="_blank" class="new_pdf_wrp">SEZ Pulse of India's Gem and Jewellery Exports</a>
                                </li>
                                
                                <li class="col-md-6 px-2">
                                <a href="assets/images/statistics/sez/Intercative-Meet.pdf" target="_blank" class="new_pdf_wrp">SEZ Interactive Meet - February 2021</a>
                                </li>
								
								<li class="col-md-6 px-2">
                                <a href="assets/images/statistics/sez/SEZ-Focus-GJEPC-Quarterly-Newsletter.pdf" target="_blank" class="new_pdf_wrp">SEZ Focus Issue 01 <span class="blink" style="color:#f00; font-size:11px;"> New </span></a>
                                </li>

                                <li class="col-md-6 px-2">
                                <a href="assets/images/statistics/sez/SEZ-Focus-GJEPC-Quarterly-Newsletter2.pdf" target="_blank" class="new_pdf_wrp">SEZ Focus Issue 02 <span class="blink" style="color:#f00; font-size:11px;"> New</span></a>
                                </li>
                                                                
                                <?php /*?><?php if(isset($_SESSION['USERID']) && !empty($_SESSION['USERID'])){ ?>
                                <li class="col-md-6 px-2">
                                <a href="assets/images/statistics/sez/Intercative-Meet.pdf" target="_blank" class="new_pdf_wrp">SEZ Interactive Meet</a>
                                </li> 
                                <?php } else { ?>
                                <li class="col-md-6 px-2">
                                <a href="javascript: void(0)" onclick = "first_alert()" class="new_pdf_wrp">SEZ Interactive Meet</a>
                                </li>
                                <?php } ?><?php */?>
                            </ul>                                                                                              
                        </div>                                                  
                        </div>   
                    </div>                    
                </div>   
            </div>              
      
        </div> <!-- Tabs wrp -->   
        
        <div class="mb-5" data-aos="fade-up">           
            <h2 class="title">Gem & Jewellery Trade Performance-At a Glance</h2>            
            <div class="row align-items-center glance_tab normal_tab">              
                <div class="col-lg-2 mb-3 mb-lg-0">
                    <ul class="nav nav-tabs d-flex justify-content-center justify-content-md-start" role="tablist">
                        <li class="col-auto px-2 px-lg-0 col-lg-12 nav-item">
                    <!--<a class="dashboard nav-link active" data-url="monthData" data-toggle="tab" href="#tabs-1" role="tab">MARCH 2021</a>
                        <a class="dashboard nav-link active" data-url="monthData" data-toggle="tab" href="#tabs-1" role="tab" aria-selected="false">NOV 2021</a>-->
						<a class="dashboard nav-link active" data-url="monthData" data-toggle="tab" href="#tabs-1" role="tab">MARCH 2022</a>
                        </li>
                        <li class="col-auto px-2 px-lg-0 col-lg-12 nav-item">
                    <!--<a class="dashboard nav-link" data-url="fyData" data-toggle="tab" href="#tabs-2" role="tab">APR-MARCH 2021</a>
                        <a class="dashboard nav-link" data-url="fyData" data-toggle="tab" href="#tabs-2" role="tab" aria-selected="false">APR-NOV 2021</a>-->
						<a class="dashboard nav-link" data-url="fyData" data-toggle="tab" href="#tabs-2" role="tab">APR-MARCH 2022</a>
                        </li>
                    </ul>
                </div>
            
            <div class="col-lg-10">                
            <div class="tab-content">
            
                        <div id='imgLoading4' class="month_fy_loader" style='display:none'>
                        <img src="https://registration.gjepc.org/images/loader.gif" alt="Uploading...."/></div>
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="row">
                                <div class="col-6 col-md mb-4 mb-md-0">
                                    <div class="glance_box bg1"> 
                                        <p class="text-center">Total Exports US$ <span>Million</span></p>
                                        <h1 class="glance_no" id="totalExportUSDMillion"></h1> 
                                    </div>
                                </div>
                                <div class="col-6 col-md mb-4 mb-md-0">
                                    <div class="glance_box bg2">
                                        <p class="text-center">Total Imports US$ <span>Million</span></p>
                                        <h1 class="glance_no" id="totalImportUSDMillion"></h1> 
                                    </div>
                                </div>
                                <div class="col-6 col-md mb-4 mb-md-0">
                                    <div class="glance_box bg3">
                                        <p class="text-center">YOY % Growth Export</p>
                                        <h1 class="glance_no" id="growthMothExportPer"></h1>
                                    </div>
                                </div>
                                <div class="col-6 col-md mb-4 mb-md-0">
                                    <div class="glance_box bg4">
                                        <p class="text-center">YOY % Growth Import</p>
                                        <h1 class="glance_no" id="growthMotImportPer"></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="tab-pane" id="tabs-2" role="tabpanel">
                            <div class="row">
                                <div class="col-6 col-md mb-4 mb-md-0">
                                    <div class="glance_box bg1">
                                        <p class="text-center">Total Exports US$ <span>Million</span></p>
                                        <h1 class="glance_no" id="totalExportFYUSDMillion"></h1>                                        
                                    </div>
                                </div>
                                <div class="col-6 col-md mb-4 mb-md-0">
                                    <div class="glance_box bg2">
                                        <p class="text-center">Total Imports US$ <span>Million</span></p>
                                        <h1 class="glance_no" id="totalImportFYUSDMillion"></h1>                                        
                                    </div>
                                </div>
                                <div class="col-6 col-md mb-4 mb-md-0">
                                    <div class="glance_box bg3">
                                        <p class="text-center">YOY % Growth Export</p>
                                        <h1 class="glance_no" id="growthFYExportPer"></h1>                                      
                                    </div>
                                </div>
                                <div class="col-6 col-md mb-4 mb-md-0">
                                    <div class="glance_box bg4">
                                        <p class="text-center">YOY % Growth Import</p>
                                        <h1 class="glance_no" id="growthFYImportPer"></h1>                                      
                                    </div>
                                </div>
                            </div>
                        </div>                  
                    </div>                    
                </div>                
            </div>            
        </div>  <!-- Glance tab -->
        
        <div class="mb-5 pb-5" data-aos="fade-up">          
            <h2 class="title">Gem & Jewellery Exports & Imports (US$ million)</h2>            
            <div class="row normal_tab">                
                <div class="col-lg-6 mb-4" data-aos="fade-right">                   
                    <div class="statistic_Box h-100">                       
                        <div class="statistic_Box_head">                            
                            <div class="row mx-0 ab_none align-items-center justify-content-center justify-content-lg-between">
                                
                                <div class="col-12 col-sm text-center text-sm-left mb-2 mb-sm-0">
                                    <div class="d-flex align-items-center justify-content-center justify-content-md-start graph_title">
                                        <div class="mr-3"><img src="assets/images/month_icon.png"/></div>
                                        <div><h5>Month Wise Exports & Imports <br/>(US$ Million)</h5></div>
                                    </div>
                                </div>
                                
                                <div class="col-auto line">                                
                                    <ul class="nav nav-tabs d-flex graph_tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="month nav-link active" data-findby="Export" data-toggle="tab" href="#month-export" role="tab">Exports</a>
                                        </li>
                                        <li class="nav-item">
                                           <a class="month nav-link" data-findby="Import" data-toggle="tab" href="#month-import" role="tab">Imports</a>
                                        </li>
                                    </ul>                                    
                                </div>                                
                            </div>                        
                        </div>
                        
                        <div class="tab-content position-relative">
                        <div id='imgLoading1' class="graph_loader" style='display:none'>
                            <div class="d-flex h-100">
                                <div class="m-auto"><img src="https://registration.gjepc.org/images/loader.gif" alt="Uploading...."/></div>
                            </div>
                        </div>
                            <div class="graph_year">
                            <select class="border-0" name="year1" id="year1">
                                <!--<option value="04-<?php echo $month = getCurrentMonth($conn);?>">APR-<?php echo getCurrentMonthName($conn);?> 2021</option>-->
                                <option value="2021-2022">2021-2022</option>
                                <option value="2020-2021">2020-2021</option>
                                <option value="2019-2020">2019-2020</option>
                                <option value="2018-2019">2018-2019</option>
                            </select>
                            </div>
                            
                            <div class="tab-pane active" id="month-export" role="tabpanel">
                                <div class="p-3">                                    
                                    <div class="form-group d-flex align-items-center my-0 mx-auto" style="width:200px">
                                        <div class="col-auto pr-0"><label class="mb-0">Exports FY</label></div>
                                    </div>                                  
                                </div>   
                            </div>                    
                            <div class="tab-pane" id="month-import" role="tabpanel">
                                <div class="p-3">
                                    <div class="form-group d-flex align-items-center my-0 mx-auto" style="width:200px">
                                        <div class="col-auto pr-0"><label class="mb-0">Imports FY</label></div>
                                    </div>
                                </div> 
                            </div>
                            <canvas class="p-3" id="month_export" width="600" height="400"></canvas>
                        </div>                        
                    </div>                    
                </div>
                
                <!-- Destination wise -->
                <div class="col-lg-6 mb-4" data-aos="fade-left">                    
                    <div class="statistic_Box h-100">                       
                        <div class="statistic_Box_head">                            
                            <div class="row mx-0 ab_none align-items-center justify-content-center justify-content-lg-between">                     
                                <div class="col-12 col-sm text-center text-sm-left mb-2 mb-sm-0">
                                    <div class="d-flex align-items-center justify-content-center justify-content-md-start graph_title">
                                        <div class="mr-2"><img src="assets/images/destination_icon.png" /></div>
                                        <div><h5>Destination Wise Exports & Imports <br/>(US$ Million)</h5></div>
                                    </div>
                                </div>
                                
                                <div class="col-auto pie">                                
                                    <ul class="nav nav-tabs d-flex graph_tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="dest nav-link active" data-findby="Export" data-toggle="tab" href="#destination-export" role="tab">Exports</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="dest nav-link" data-findby="Import" data-toggle="tab" href="#destination-import" role="tab">Imports</a>
                                        </li>
                                    </ul>                                    
                                </div>                                
                            </div>                        
                        </div>
                        
                        <div class="tab-content position-relative">
                        
                            <div id='imgLoading2' class="graph_loader" style='display:none'>
                                <div class="d-flex h-100">
                                <div class="m-auto"><img src="https://registration.gjepc.org/images/loader.gif" alt="Uploading...."/></div>
                                </div>
                            </div>
                            <div class="graph_year">
                            <select class="border-0" name="year" id="year">
                                <!-- /*	Sept Code 29/09/2021
								<option value="<?php echo $month = getCurrentMonth($conn);?>"><?php echo getCurrentMonthName($conn);?> 2020</option>
                                <option value="04-<?php echo $month = getCurrentMonth($conn);?>">APR-<?php echo getCurrentMonthName($conn);?> 2020</option>							
								<option value="<?php echo $month = getCurrentMonth($conn);?>"><?php echo getCurrentMonthName($conn);?> 2021</option>-->	
                                <option value="2021-2022">2021-2022</option>
                                <option value="2020-2021">2020-2021</option>
                                <option value="2019-2020">2019-2020</option>
                                <option value="2018-2019">2018-2019</option>
                            </select>
                            </div>
                            
                            <div class="tab-pane active" id="destination-export" role="tabpanel">
                                <div class="p-3">                                   
                                    <div class="form-group d-flex align-items-center my-0 mx-auto" style="width:200px">
                                        <div class="col-auto pr-0"><label class="mb-0">Exports FY</label></div>
                                    </div>
                                </div>   
                            </div>
                    
                            <div class="tab-pane" id="destination-import" role="tabpanel">
                                <div class="p-3">
                                    <div class="form-group d-flex align-items-center my-0 mx-auto" style="width:200px">
                                        <div class="col-auto pr-0"><label class="mb-0">Imports FY</label></div>
                                    </div>
                                </div> 
                            </div>                          
                            <canvas id="destination_export" width="600" height="400"></canvas>                              
                        </div>                        
                    </div>                    
                </div>
                
                <!-- Commodity-wise wise -->
                
                <div class="col-12" data-aos="fade-up">                 
                    <div class="statistic_Box">                     
                        <div class="statistic_Box_head">                            
                            <div class="row mx-0 ab_none align-items-center justify-content-center justify-content-lg-between">
                                
                                <div class="col-12 col-sm text-center text-sm-left mb-2 mb-sm-0">
                                    <div class="d-flex align-items-center  justify-content-center  justify-content-md-start graph_title">
                                        <div class="mr-2"><img src="assets/images/commodity_icon.png" /></div>
                                        <div><h5>Commodity Wise Exports & Imports (US$ Million)</h5></div>
                                    </div>
                                </div>
                                
                                <div class="col-auto bar">                                
                                    <ul class="nav nav-tabs d-flex graph_tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="comm nav-link active" data-findby="Export" data-toggle="tab" href="#commodity-export" role="tab">Exports</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="comm nav-link" data-findby="Import" data-toggle="tab" href="#commodity-import" role="tab">Imports</a>
                                        </li>
                                    </ul>                                    
                                </div>                                
                            </div>                        
                        </div>
                        
                            <div class="tab-content position-relative">
                            <div id='imgLoading3' class="graph_loader" style='display:none'>
                                <div class="d-flex h-100">
                                <div class="m-auto"><img src="https://registration.gjepc.org/images/loader.gif" alt="Uploading...."/></div>
                                </div>
                            </div>
                            <div class="graph_year">
                            <select class="border-0" name="year2" id="year2">
                                <!--<option value="<?php echo $month = getCurrentMonth($conn);?>"><?php echo getCurrentMonthName($conn);?> 2021</option>
                                <option value="04-<?php echo $month = getCurrentMonth($conn);?>">APR-<?php echo getCurrentMonthName($conn);?> 2021</option>-->
                                <option value="2021-2022">2021-2022</option>
                                <option value="2020-2021">2020-2021</option>
                                <option value="2019-2020">2019-2020</option>
                                <option value="2018-2019">2018-2019</option>
                            </select>
                            </div>
                            <div class="tab-pane active" id="commodity-export" role="tabpanel">
                                <div class="p-3">
                                    <div class="form-group d-flex align-items-center my-0 mx-auto" style="width:200px">
                                        <div class="col-auto pr-0"><label class="mb-0">Exports FY</label></div>
                                    </div>                                  
                                </div>   
                            </div>
                    
                            <div class="tab-pane" id="commodity-import" role="tabpanel">
                                <div class="p-3">
                                    <div class="form-group d-flex align-items-center my-0 mx-auto" style="width:200px">
                                        <div class="col-auto pr-0"><label class="mb-0">Imports FY</label></div>
                                    </div>
                                </div> 
                            </div>   
                            <canvas id="commodity_export"></canvas>
                        </div>                        
                    </div>                    
                </div>                
            </div>            
        </div> <!-- Graphs -->       
                
        <div class="mb-5" data-aos="fade-up">

            <h1 class="bold_font text-center" style="color:#000;"> <img src="assets/images/gold_star.png" class="d-block mx-auto mb-3"> Key Gem & Jewellery Exports <br /> World & India's Position in 2020 & 2019</h1>
            
            <div class="position_slider py-4 position_bg">
                        
                <div class="px-3">
                    
                    <div class="row align-items-center mb-4">
                        <div class="col-md-2">
                            <img src="assets/images/position_pic/01.jpg" class="img-fluid d-table mx-auto" />
                        </div>                        
                        <div class="col-md-10 position_slider_title">
                            <h3>India's Gem & Jewellery Sector - 2020 & 2019 <span>A Leading Exporter in Global Market</span></h3>
                        </div>                    
                    </div> 

                    <ul class="nav nav-tabs d-flex pr_tab" role="tablist">
                        <li class="nav-item mr-2">
                            <a class="nav-link active" data-toggle="tab" href="#pr_tab1" role="tab">2020</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pr_tab2" role="tab">2019</a>
                        </li>
                    </ul><!-- Tab panes -->

                    <div class="tab-content">

                        <div class="tab-pane active" id="pr_tab1" role="tabpanel">
                            
                            <div class="row align-items-center">     

                                <div class="col-lg-6">  
                                    
                                    <div class="row">                            
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>World Exports</h3>
                                            <h2>US $ 693.70 bn</h2> 
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's % Share in World's Exports</h3>
                                            <h2>3.50%</h2>   
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's Rank</h3>
                                            <h2>7th</h2>    
                                        </div>                                
                                    </div> 

                                </div>  

                                <div class="col-lg-6">   

                                    <div id="skills">                                
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>Switzerland</h4></div>
                                            <div class="col px-2">
                                                <progress value="12.45" max="15"></progress><span>12.45%</span> 
                                            </div>
                                        </div>   
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>Hong Kong</h4></div>
                                            <div class="col px-2">
                                                <progress value="10.19" max="15"></progress><span>10.19%</span>
                                            </div>
                                        </div>          
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>USA</h4></div>
                                            <div class="col px-2">
                                                <progress value="8.64" max="15"></progress><span>8.64%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>UK</h4></div>
                                            <div class="col px-2">
                                                <progress value="6.19" max="15"></progress><span>6.19%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>UAE</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="5.52" max="15"></progress><span>5.52%</span>
                                            </div>
                                        </div>  
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Russia</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="4.39" max="15"></progress><span>4.39%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>India</h4></div>
                                            <div class="col px-2">
                                                <progress value="3.53" max="15"></progress><span>3.53%</span>
                                            </div>
                                        </div>            
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Canada</h4> 
                                            </div>
                                            <div class="col px-2">
                                                <progress value="3.31" max="15"></progress><span>3.31%</span>
                                            </div>
                                        </div>                                
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Germany</h4>  
                                            </div>
                                            <div class="col px-2">
                                                <progress value="3.28" max="15"></progress><span>3.28%</span>
                                            </div>
                                        </div>                                
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Singapore</h4>        
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2.94" max="15"></progress><span>2.94%</span>
                                            </div>
                                        </div>                                
                                    </div> 
                                </div>
                                
                            </div>

                        </div> <!-- 2020 -->

                        <div class="tab-pane" id="pr_tab2" role="tabpanel">

                            <div class="row align-items-center">     

                                <div class="col-lg-6">  
                                    
                                    <div class="row">                            
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>World Exports</h3>
                                            <h2>US $ 628.59 bn</h2> 
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's % Share in World's Exports</h3>
                                            <h2>5.8%</h2>   
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's Rank 2019</h3>
                                            <h2>5th</h2>    
                                        </div>                                
                                    </div> 

                                </div>  

                                <div class="col-lg-6">   

                                    <div id="skills">                                
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>Switzerland</h4></div>
                                            <div class="col px-2">
                                                <progress value="12.33" max="15"></progress><span>12.33%</span> 
                                            </div>
                                        </div>   
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>USA</h4></div>
                                            <div class="col px-2">
                                                <progress value="9.19" max="15"></progress><span>9.19%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>Hong Kong</h4></div>
                                            <div class="col px-2">
                                                <progress value="8.33" max="15"></progress><span>8.33%</span>
                                            </div>
                                        </div>       

                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>UAE</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="7.36" max="15"></progress><span>7.36%</span>
                                            </div>
                                        </div>   
                                        
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>UK</h4></div>
                                            <div class="col px-2">
                                                <progress value="6.55" max="15"></progress><span>6.55%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>India</h4></div>
                                            <div class="col px-2">
                                                <progress value="5.65" max="15"></progress><span>5.65%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Canada</h4> 
                                            </div>
                                            <div class="col px-2">
                                                <progress value="3.28" max="15"></progress><span>3.28%</span>
                                            </div>
                                        </div>   

                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Germany</h4>  
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2.73" max="15"></progress><span>2.73%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Singapore</h4>        
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2.73" max="15"></progress><span>2.73%</span>
                                            </div>
                                        </div>  
                                          
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Russia</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2.35" max="15"></progress><span>2.35%</span>
                                            </div>
                                        </div>                        
                                    </div> 
                                </div>                                
                            </div>                            
                        </div>
                    </div>
                </div>

                <div class="px-3">  

                    <div class="row align-items-center mb-4">                       
                       <div class="col-md-2">
                            <img src="assets/images/position_pic/global.jpg" class="img-fluid d-table mx-auto" />
                        </div>                       
                        <div class="col-md-10 position_slider_title">
                            <h3>Global Vis-a-vis India's Position</span></h3>
                        </div>
                    </div>

                    <ul class="nav nav-tabs d-flex pr_tab" role="tablist">
                        <li class="nav-item mr-2">
                            <a class="nav-link active" data-toggle="tab" href="#pr_tab3" role="tab">2020</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pr_tab4" role="tab">2019</a>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane active" id="pr_tab3" role="tabpanel">
                            
                            <table class="responsive_table">

                                <thead>
                                    <tr style="background:none;">
                                        <th style="background:#408894">HS Codes</th>
                                        <th style="background:#408894">Commodities</th>
                                        <th style="background:#408894">World Exports (US$ billion)</th>
                                        <th style="background:#408894">India's Exports (US$ billion)</th>
                                        <th style="background:#408894">India's Share (%)</th>
                                        <th style="background:#408894">India's Ranking</th>
                                    </tr>
                                </thead>
                        
                                <tbody>                         
                                     <tr style="background:none;">
                                        <td data-column="HS Codes" class="text-lg-center">711319</td>
                                        <td data-column="Commodities"  class="text-lg-center">Gold Jewellery</td>
                                        <td data-column="World Exports" class="text-lg-center">66.21</td>
                                        <td data-column="India's Exports" class="text-lg-center">5.67</td>
                                        <td data-column="India's Share(%)" class="text-lg-center">8.60</td>
                                        <td data-column="India's Ranking" class="text-lg-center">4th</td>
                                     </tr>                             
                                     <tr>
                                        <td data-column="HS Codes" class="text-lg-center">710239</td>
                                        <td data-column="Commodities"  class="text-lg-center">Cut & Polished Diamonds</td>
                                        <td data-column="World Exports" class="text-lg-center">49.77</td>
                                        <td data-column="India's Exports" class="text-lg-center">14.65</td>
                                        <td data-column="India's Share (%)" class="text-lg-center">29.70</td>
                                        <td data-column="India's Ranking" class="text-lg-center">1st</td>
                                     </tr>                           
                                     <tr style="background:none;">
                                        <td data-column="HS Codes" class="text-lg-center">711311</td>
                                        <td data-column="Commodities"  class="text-lg-center">Silver Jewellery</td>
                                        <td data-column="World Exports" class="text-lg-center">9</td>
                                        <td data-column="India's Exports" class="text-lg-center">1.97</td>
                                        <td data-column="India's Share (%)" class="text-lg-center">22.00</td>
                                        <td data-column="India's Ranking" class="text-lg-center">1st</td>
                                     </tr> 
                                     <tr>
                                        <td data-column="HS Codes" class="text-lg-center">7103</td>
                                        <td data-column="Commodities"  class="text-lg-center">Coloured Gems Stones</td>
                                        <td data-column="World Exports" class="text-lg-center">5.51</td>
                                        <td data-column="India's Exports" class="text-lg-center">0.251</td>
                                        <td data-column="India's Share (%)" class="text-lg-center">4.60</td>
                                        <td data-column="India's Ranking" class="text-lg-center">5th</td>
                                     </tr>                             
                                     <tr style="background:none;">
                                        <td data-column="HS Codes" class="text-lg-center">7117</td>
                                        <td data-column="Commodities"  class="text-lg-center">Imitation Jewellery</td>
                                        <td data-column="World Exports" class="text-lg-center">6.07</td>
                                        <td data-column="India's Exports" class="text-lg-center">0.14</td>
                                        <td data-column="India's Share (%)" class="text-lg-center">2.30</td>
                                        <td data-column="India's Ranking" class="text-lg-center">10th</td>
                                     </tr>                           
                                     <tr>
                                        <td data-column="HS Codes" class="text-lg-center">7104</td>
                                        <td data-column="Commodities"  class="text-lg-center">Synthetic Diamonds/Stones</td>
                                        <td data-column="World Exports (US$ billion)" class="text-lg-center">2.62</td>
                                        <td data-column="India's Exports (US$ billion)" class="text-lg-center">0.569</td>
                                        <td data-column="India's Share (%)" class="text-lg-center">21.70</td>
                                        <td data-column="India's Ranking" class="text-lg-center">2nd</td>
                                     </tr>                             
                                </tbody> 
                            </table> 
                        </div> 

                        <div class="tab-pane" id="pr_tab4" role="tabpanel">

                            <table class="responsive_table">
                                <thead>
                                    <tr style="background:none;">
                                        <th style="background:#408894">HS Codes</th>
                                        <th style="background:#408894">Commodities</th>
                                        <th style="background:#408894">World Exports (US$ billion)</th>
                                        <th style="background:#408894">India's Exports (US$ billion)</th>
                                        <th style="background:#408894">India's Share (%)</th>
                                        <th style="background:#408894">India's Ranking</th>
                                    </tr>
                                </thead>
                        
                                <tbody>                         
                                     <tr style="background:none;">
                                        <td data-column="HS Codes" class="text-lg-center">711319</td>
                                        <td data-column="Commodities"  class="text-lg-center">Gold Jewellery</td>
                                        <td data-column="World Exports" class="text-lg-center">101.89</td>
                                        <td data-column="India's Exports" class="text-lg-center">12.36</td>
                                        <td data-column="India's Share(%)" class="text-lg-center">12.1</td>
                                        <td data-column="India's Ranking" class="text-lg-center">2nd</td>
                                     </tr>                             
                                     <tr>
                                        <td data-column="HS Codes" class="text-lg-center">710239</td>
                                        <td data-column="Commodities"  class="text-lg-center">Cut & Polished Diamonds</td>
                                        <td data-column="World Exports" class="text-lg-center">76.51</td>
                                        <td data-column="India's Exports" class="text-lg-center">20.57</td>
                                        <td data-column="India's Share (%)" class="text-lg-center">26.9</td>
                                        <td data-column="India's Ranking" class="text-lg-center">1st</td>
                                     </tr>                           
                                     <tr style="background:none;">
                                        <td data-column="HS Codes" class="text-lg-center">711311</td>
                                        <td data-column="Commodities"  class="text-lg-center">Silver Jewellery</td>
                                        <td data-column="World Exports" class="text-lg-center">7.12</td>
                                        <td data-column="India's Exports" class="text-lg-center">1.18</td>
                                        <td data-column="India's Share (%)" class="text-lg-center">16.7</td>
                                        <td data-column="India's Ranking" class="text-lg-center">2nd</td>
                                     </tr> 
                                     <tr>
                                        <td data-column="HS Codes" class="text-lg-center">7103</td>
                                        <td data-column="Commodities"  class="text-lg-center">Coloured Gems Stones</td>
                                        <td data-column="World Exports" class="text-lg-center">9.89</td>
                                        <td data-column="India's Exports" class="text-lg-center">0.427</td>
                                        <td data-column="India's Share (%)" class="text-lg-center">4.3</td>
                                        <td data-column="India's Ranking" class="text-lg-center">5th</td>
                                     </tr>                             
                                     <tr style="background:none;">
                                        <td data-column="HS Codes" class="text-lg-center">7117</td>
                                        <td data-column="Commodities"  class="text-lg-center">Imitation Jewellery</td>
                                        <td data-column="World Exports" class="text-lg-center">7.15</td>
                                        <td data-column="India's Exports" class="text-lg-center">0.189</td>
                                        <td data-column="India's Share (%)" class="text-lg-center">2.6</td>
                                        <td data-column="India's Ranking" class="text-lg-center">11th</td>
                                     </tr>                           
                                     <tr>
                                        <td data-column="HS Codes" class="text-lg-center">7104</td>
                                        <td data-column="Commodities"  class="text-lg-center">Synthetic Diamonds/Stones</td>
                                        <td data-column="World Exports (US$ billion)" class="text-lg-center">2.12</td>
                                        <td data-column="India's Exports (US$ billion)" class="text-lg-center">0.45</td>
                                        <td data-column="India's Share (%)" class="text-lg-center">21.2</td>
                                        <td data-column="India's Ranking" class="text-lg-center">2nd</td>
                                     </tr>                             
                                </tbody> 
                            </table> 
                        </div>
                    </div>
                </div>

                <div class="px-3 gold"> 

                    <div class="row align-items-center mb-4">
                        <div class="col-md-2">
                            <img src="assets/images/position_pic/02.jpg" class="img-fluid d-table mx-auto" />
                        </div>                        
                        <div class="col-md-10 position_slider_title">
                            <h3>India's Diamond Sector - 2020 & 2019 <span>A Leading Exporter in Global Market</span></h3>
                        </div>
                    </div>
                    
                    <ul class="nav nav-tabs d-flex pr_tab" role="tablist">
                        <li class="nav-item mr-2">
                            <a class="nav-link active" data-toggle="tab" href="#pr_tab5" role="tab">2020</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pr_tab6" role="tab">2019</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="pr_tab5" role="tabpanel">                            
                            <div class="row align-items-center"> 
                                <div class="col-lg-6">  
                                    
                                    <div class="row">                            
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>World Exports</h3>
                                            <h2>US $ 50.56 bn</h2> 
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's % Share in World's Exports</h3>
                                            <h2>29%</h2>   
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's Rank</h3>
                                            <h2>1st</h2>    
                                        </div>                                
                                    </div> 
                                </div>  

                                <div class="col-lg-6">   

                                    <div id="skills"> 

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2"><h4>India</h4></div>
                                            <div class="col px-2">
                                                <progress value="29" max="30"></progress><span>29%</span> 
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2"><h4>USA</h4></div>
                                            <div class="col px-2">
                                                <progress value="20" max="30"></progress><span>20%</span>
                                            </div>
                                        </div>  

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2"><h4>Hong Kong</h4></div>
                                            <div class="col px-2">
                                                <progress value="19.4" max="30"></progress><span>19.4%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2"><h4>Israel</h4></div>
                                            <div class="col px-2">
                                                <progress value="8.9" max="30"></progress><span>8.9%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2">
                                                <h4>Belgium</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="5.1" max="30"></progress><span>5.1%</span>
                                            </div>
                                        </div>  

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2">
                                                <h4>UAE</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2.4" max="30"></progress><span>2.4%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2"><h4>Switzerland</h4></div>
                                            <div class="col px-2">
                                                <progress value="2.3" max="30"></progress><span>2.3%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2">
                                                <h4>China</h4> 
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2" max="30"></progress><span>2%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2">
                                                <h4>Thailand</h4>  
                                            </div>
                                            <div class="col px-2">
                                                <progress value="1.8" max="30"></progress><span>1.8%</span>
                                            </div>
                                        </div>                                  
                                                                
                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2">
                                                <h4>Botswana</h4>        
                                            </div>
                                            <div class="col px-2">
                                                <progress value="1.1" max="30"></progress><span>1.1%</span>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div> 

                        <div class="tab-pane" id="pr_tab6" role="tabpanel">

                            <div class="row align-items-center">     

                                <div class="col-lg-6">  
                                        
                                    <div class="row">                            
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>World Exports</h3>
                                            <h2>US $ 76.51 bn</h2> 
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's % Share in World's Exports</h3>
                                            <h2>27%</h2>   
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's Rank</h3>
                                            <h2>1st</h2>    
                                        </div>                                
                                    </div>

                                </div>  

                                <div class="col-lg-6">   

                                    <div id="skills">  

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2"><h4>India</h4></div>
                                            <div class="col px-2">
                                                <progress value="27" max="30"></progress><span>27%</span> 
                                            </div>
                                        </div>   

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2"><h4>USA</h4></div>
                                            <div class="col px-2">
                                                <progress value="23" max="30"></progress><span>23%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2"><h4>Hong Kong</h4></div>
                                            <div class="col px-2">
                                                <progress value="16" max="30"></progress><span>16%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2"><h4>Israel</h4></div>
                                            <div class="col px-2">
                                                <progress value="13" max="30"></progress><span>13%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2">
                                                <h4>Belgium</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="5" max="30"></progress><span>5%</span>
                                            </div>
                                        </div>  

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2">
                                                <h4>UAE</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="5" max="30"></progress><span>5%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2"><h4>Switzerland</h4></div>
                                            <div class="col px-2">
                                                <progress value="3" max="30"></progress><span>3%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2">
                                                <h4>China</h4> 
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2" max="30"></progress><span>2%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2">
                                                <h4>Thailand</h4>  
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2" max="30"></progress><span>2%</span>
                                            </div>
                                        </div>                               
                                                                       
                                        <div class="row mb-3 align-items-center progress2">
                                            <div class="col-lg-auto px-2">
                                                <h4>Botswana</h4>        
                                            </div>
                                            <div class="col px-2">
                                                <progress value="1" max="30"></progress><span>1%</span>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>                            
                        </div>
                    </div>                                     
                </div>
                        
                <div class="px-3">  

                    <div class="row align-items-center mb-4">
                        <div class="col-md-2">
                            <img src="assets/images/position_pic/03.jpg" class="img-fluid d-table mx-auto" />
                        </div>                        
                        <div class="col-md-10 position_slider_title">
                            <h3>Gold Jewellery Sector - 2020 & 2019 <span>Global Exports & India's Position</span></h3>
                        </div>
                    </div>

                    <ul class="nav nav-tabs d-flex pr_tab" role="tablist">
                        <li class="nav-item mr-2">
                            <a class="nav-link active" data-toggle="tab" href="#pr_tab7" role="tab">2020</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pr_tab8" role="tab">2019</a>
                        </li>
                    </ul><!-- Tab panes -->

                    <div class="tab-content">

                        <div class="tab-pane active" id="pr_tab7" role="tabpanel">
                            
                            <div class="row align-items-center">     

                                <div class="col-lg-6">  
                                    
                                    <div class="row">                            
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>World Exports</h3>
                                            <h2>US $ 66.22 bn</h2> 
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's % Share in World's Exports</h3>
                                            <h2>8.6%</h2>   
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's Rank</h3>
                                            <h2>4th</h2>    
                                        </div>                                
                                    </div> 

                                </div>  

                                <div class="col-lg-6">   

                                    <div id="skills"> 
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2">
                                                <h4>Switzerland</h4>        
                                            </div>
                                            <div class="col px-2">
                                                <progress value="12.1" max="18"></progress><span>12.1%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2">
                                                <h4>China</h4>  
                                            </div>
                                            <div class="col px-2">
                                                <progress value="11.0" max="18"></progress><span>11.0%</span>
                                            </div>
                                        </div>  
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2">
                                                <h4>Hong Kong</h4> 
                                            </div>
                                            <div class="col px-2">
                                                <progress value="8.9" max="18"></progress><span>8.9%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2"><h4>India</h4></div>
                                            <div class="col px-2">
                                                <progress value="8.6" max="18"></progress><span>8.6%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2">
                                                <h4>USA</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="7.3" max="18"></progress><span>7.3%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2">
                                                <h4>Italy</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="7.0" max="18"></progress><span>7.0%</span>
                                            </div>
                                        </div>  
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2"><h4>France</h4></div>
                                            <div class="col px-2">
                                                <progress value="6.5" max="18"></progress><span>6.5%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2"><h4>UAE</h4></div>
                                            <div class="col px-2">
                                                <progress value="6.0" max="18"></progress><span>6.0%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2"><h4>Turkey</h4></div>
                                            <div class="col px-2">
                                                <progress value="5.3" max="18"></progress><span>5.3%</span>
                                            </div>
                                        </div>                               
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2"><h4>UK</h4></div>
                                            <div class="col px-2">
                                                <progress value="4.3" max="18"></progress><span>4.3%</span> 
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                        </div> 

                        <div class="tab-pane" id="pr_tab8" role="tabpanel">

                            <div class="row align-items-center">

                                <div class="col-lg-6">  
                                        
                                    <div class="row">                            
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>World Exports</h3>
                                            <h2>US $ 101.89 bn</h2> 
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's % Share in World's Exports</h3>
                                            <h2>12.1%</h2>   
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's Rank</h3>
                                            <h2>2nd</h2>    
                                        </div>                                
                                    </div> 

                                </div>  

                                <div class="col-lg-6">   

                                    <div id="skills">
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2">
                                                <h4>Switzerland</h4>        
                                            </div>
                                            <div class="col px-2">
                                                <progress value="11.4" max="18"></progress><span>11.4%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2">
                                                <h4>China</h4>  
                                            </div>
                                            <div class="col px-2">
                                                <progress value="11.0" max="18"></progress><span>12.5%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2">
                                                <h4>Hong Kong</h4> 
                                            </div>
                                            <div class="col px-2">
                                                <progress value="8.9" max="18"></progress><span>7.3%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2"><h4>India</h4></div>
                                            <div class="col px-2">
                                                <progress value="8.6" max="18"></progress><span>12.1%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2">
                                                <h4>USA</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="7.3" max="18"></progress><span>8.5%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2">
                                                <h4>Italy</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="7.0" max="18"></progress><span>6.4%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2"><h4>France</h4></div>
                                            <div class="col px-2">
                                                <progress value="6.5" max="18"></progress><span>7.0%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2"><h4>UAE</h4></div>
                                            <div class="col px-2">
                                                <progress value="6.0" max="18"></progress><span>16.1%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2"><h4>Turkey</h4></div>
                                            <div class="col px-2">
                                                <progress value="5.3" max="18"></progress><span>4.9%</span>
                                            </div>
                                        </div>                                
                                        <div class="row mb-3 align-items-center progress3">
                                            <div class="col-lg-auto px-2"><h4>UK</h4></div>
                                            <div class="col px-2">
                                                <progress value="4.3" max="18"></progress><span>6.4%</span> 
                                            </div>
                                        </div>                         
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 

                <div class="px-3">                    
                    <div class="row align-items-center mb-4">
                        <div class="col-md-2">
                            <img src="assets/images/position_pic/04.jpg" class="img-fluid d-table mx-auto" />
                        </div>                        
                        <div class="col-md-10 position_slider_title">
                            <h3>Silver Jewellery - 2020 & 2019 <span>Global Exports & India's Position</span></h3>
                        </div>
                    </div>
                    
                    <ul class="nav nav-tabs d-flex pr_tab" role="tablist">
                        <li class="nav-item mr-2">
                            <a class="nav-link active" data-toggle="tab" href="#pr_tab9" role="tab">2020</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pr_tab10" role="tab">2019</a>
                        </li>
                    </ul><!-- Tab panes -->

                    <div class="tab-content">

                        <div class="tab-pane active" id="pr_tab9" role="tabpanel">
                            
                            <div class="row align-items-center">     

                                <div class="col-lg-6">  
                                    
                                    <div class="row">                            
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>World Exports</h3>
                                            <h2>US $ 9 bn</h2> 
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's % Share in World's Exports</h3>
                                            <h2>22%</h2>   
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's Rank</h3>
                                            <h2>1st</h2>    
                                        </div>                                
                                    </div> 

                                </div>  

                                <div class="col-lg-6">   

                                    <div id="skills">
                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2">
                                                <h4>India</h4>        
                                            </div>
                                            <div class="col px-2">
                                                <progress value="22.0" max="25"></progress><span>22.0%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2">
                                                <h4>Thailand</h4>  
                                            </div>
                                            <div class="col px-2">
                                                <progress value="15.5" max="25"></progress><span>15.5%</span>
                                            </div>
                                        </div>  
                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2">
                                                <h4>Germany</h4> 
                                            </div>
                                            <div class="col px-2">
                                                <progress value="9.1" max="25"></progress><span>9.1%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2"><h4>China</h4></div>
                                            <div class="col px-2">
                                                <progress value="7.8" max="25"></progress><span>7.8%</span>
                                            </div>
                                        </div>  
                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2">
                                                <h4>Italy</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="7.0" max="25"></progress><span>7.0%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2">
                                                <h4>Hong Kong</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="5.0" max="25"></progress><span>5.0%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2"><h4>USA</h4></div>
                                            <div class="col px-2">
                                                <progress value="4.3" max="25"></progress><span>4.3%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2"><h4>France</h4></div>
                                            <div class="col px-2">
                                                <progress value="1.1" max="25"></progress><span>1.1%</span> 
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2"><h4>Spain</h4></div>
                                            <div class="col px-2">
                                                <progress value="1.1" max="25"></progress><span>1.1%</span>
                                            </div>
                                        </div>  
                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2"><h4>UK</h4></div>
                                            <div class="col px-2">
                                                <progress value="1.1" max="25"></progress><span>1.1%</span>
                                            </div>
                                        </div>                                                                         
                                    </div> 
                                </div>                                
                            </div>

                        </div> 

                        <div class="tab-pane" id="pr_tab10" role="tabpanel">

                            <div class="row align-items-center">

                                <div class="col-lg-6">  
                                        
                                    <div class="row">                            
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>World Exports</h3>
                                            <h2>US $ 7.12 bn</h2> 
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's % Share in World's Exports</h3>
                                            <h2>16.7%</h2>   
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's Rank</h3>
                                            <h2>2nd</h2>    
                                        </div>                                
                                    </div>

                                </div>  

                                <div class="col-lg-6">   

                                    <div id="skills">  

                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2">
                                                <h4>Thailand</h4>  
                                            </div>
                                            <div class="col px-2">
                                                <progress value="21.7" max="25"></progress><span>21.7%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress4">
                                                <div class="col-lg-auto px-2">
                                                    <h4>India</h4>        
                                                </div>
                                                <div class="col px-2">
                                                    <progress value="16.7" max="25"></progress><span>16.7%</span>
                                                </div>
                                            </div>  
                                                       
                                            <div class="row mb-3 align-items-center progress4">
                                                <div class="col-lg-auto px-2">
                                                    <h4>Germany</h4> 
                                                </div>
                                                <div class="col px-2">
                                                    <progress value="14.1" max="25"></progress><span>14.1%</span>
                                                </div>
                                            </div>    

                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2">
                                                <h4>Italy</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="9.3" max="25"></progress><span>9.3%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2"><h4>China</h4></div>
                                            <div class="col px-2">
                                                <progress value="7.5" max="25"></progress><span>7.5%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2"><h4>USA</h4></div>
                                            <div class="col px-2">
                                                <progress value="7.4" max="25"></progress><span>7.4%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2">
                                                <h4>Hong Kong</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="6.2" max="25"></progress><span>6.2%</span>
                                            </div>
                                        </div>  

                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2"><h4>Spain</h4></div>
                                            <div class="col px-2">
                                                <progress value="1.8" max="25"></progress><span>1.8%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2"><h4>UK</h4></div>
                                            <div class="col px-2">
                                                <progress value="1.5" max="25"></progress><span>1.5%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress4">
                                            <div class="col-lg-auto px-2"><h4>France</h4></div>
                                            <div class="col px-2">
                                                <progress value="1.1" max="25"></progress><span>1.1%</span> 
                                            </div>
                                        </div>                           
                                        </div>
                                </div>                            
                            </div>
                        </div>
                    </div> 
                </div>
                        
                <div class="px-3">
                    
                    <div class="row align-items-center mb-4">
                        <div class="col-md-2">
                            <img src="assets/images/position_pic/05.jpg" class="img-fluid d-table mx-auto" />
                        </div>                        
                        <div class="col-md-10 position_slider_title">
                            <h3>Colour Gemstones - 2020 & 2019 <span>Global Exports & India's Position</span></h3>
                        </div>
                    </div>
                    
                    <ul class="nav nav-tabs d-flex pr_tab" role="tablist">
                        <li class="nav-item mr-2">
                            <a class="nav-link active" data-toggle="tab" href="#pr_tab11" role="tab">2020</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pr_tab12" role="tab">2019</a>
                        </li>
                    </ul><!-- Tab panes -->

                    <div class="tab-content">

                        <div class="tab-pane active" id="pr_tab11" role="tabpanel">
                            
                            <div class="row align-items-center">     

                                <div class="col-lg-6">  
                                    
                                    <div class="row">                            
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>World Exports</h3>
                                            <h2>US $ 4.99 bn</h2> 
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's % Share in World's Exports</h3>
                                            <h2>4.45%</h2>   
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's Rank</h3>
                                            <h2>5th</h2>    
                                        </div>                                
                                    </div> 

                                </div>  

                                <div class="col-lg-6">   

                                    <div id="skills"> 

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2"><h4>Hong Kong</h4></div>
                                            <div class="col px-2">
                                                <progress value="21.8" max="30"></progress><span>21.8%</span> 
                                            </div>
                                        </div>   

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2"><h4>USA</h4></div>
                                            <div class="col px-2">
                                                <progress value="21.2" max="30"></progress><span>21.2%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2"><h4>Switzerland</h4></div>
                                            <div class="col px-2">
                                                <progress value="10.3" max="30"></progress><span>10.3%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2"><h4>Thailand</h4></div>
                                            <div class="col px-2">
                                                <progress value="9.8" max="30"></progress><span>9.8%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2">
                                                <h4>India</h4> 
                                            </div>
                                            <div class="col px-2">
                                                <progress value="4.5" max="30"></progress><span>4.5%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2">
                                                <h4>Italy</h4>  
                                            </div>
                                            <div class="col px-2">
                                                <progress value="3.4" max="30"></progress><span>3.4%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2">
                                                <h4>Germany</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2.4" max="30"></progress><span>2.4%</span>
                                            </div>
                                        </div>  

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2">
                                                <h4>France</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="1.9" max="30"></progress><span>1.9%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2"><h4>UAE</h4></div>
                                            <div class="col px-2">
                                                <progress value="1.8" max="30"></progress><span>1.8%</span>
                                            </div>
                                        </div>            
                                                                       
                                                                        
                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2">
                                                <h4>Brazil</h4>        
                                            </div>
                                            <div class="col px-2">
                                                <progress value="1.5" max="30"></progress><span>1.5%</span>
                                            </div>
                                        </div>                                
                                    </div> 
                                </div>
                                
                            </div>

                        </div> 

                        <div class="tab-pane" id="pr_tab12" role="tabpanel">

                            <div class="row align-items-center">   

                                <div class="col-lg-6">  
                                        
                                    <div class="row">                            
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>World Exports</h3>
                                            <h2>US $ 8.70 bn</h2> 
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's % Share in World's Exports</h3>
                                            <h2>4.73%</h2>   
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's Rank</h3>
                                            <h2>5th</h2>    
                                        </div>                                
                                    </div> 

                                </div>  

                                <div class="col-lg-6">   

                                    <div id="skills"> 

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2"><h4>USA</h4></div>
                                            <div class="col px-2">
                                                <progress value="25.9" max="30"></progress><span>25.9%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2"><h4>Hong Kong</h4></div>
                                            <div class="col px-2">
                                                <progress value="17.5" max="30"></progress><span>17.5%</span> 
                                            </div>
                                        </div>   

                                         <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2"><h4>Thailand</h4></div>
                                            <div class="col px-2">
                                                <progress value="12.0" max="30"></progress><span>12.0%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2"><h4>Switzerland</h4></div>
                                            <div class="col px-2">
                                                <progress value="8.1" max="30"></progress><span>8.1%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2">
                                                <h4>India</h4> 
                                            </div>
                                            <div class="col px-2">
                                                <progress value="4.7" max="30"></progress><span>4.7%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2">
                                                <h4>Italy</h4>  
                                            </div>
                                            <div class="col px-2">
                                                <progress value="4.2" max="30"></progress><span>4.2%</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2"><h4>UAE</h4></div>
                                            <div class="col px-2">
                                                <progress value="3.1" max="30"></progress><span>3.1%</span>
                                            </div>
                                        </div> 

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2">
                                                <h4>Germany</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2.0" max="30"></progress><span>2.0%</span>
                                            </div>
                                        </div>  

                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2">
                                                <h4>France</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="1.9" max="30"></progress><span>1.9%</span>
                                            </div>
                                        </div> 
                            
                                        <div class="row mb-3 align-items-center progress5">
                                            <div class="col-lg-auto px-2">
                                                <h4>Brazil</h4>        
                                            </div>
                                            <div class="col px-2">
                                                <progress value="1.5" max="30"></progress><span>1.5%</span>
                                            </div>
                                        </div>                                
                                    </div> 
                                </div>

                            </div>
                            
                        </div>

                    </div> 
                    
                </div> <!-- 6 slide -->
                        
                <div class="px-3">
                    
                    <div class="row align-items-center mb-4">
                        <div class="col-md-2">
                            <img src="assets/images/position_pic/06.jpg" class="img-fluid d-table mx-auto" />
                        </div>
                        
                        <div class="col-md-10 position_slider_title">
                            <h3>Imitation Jewellery - 2020 & 2019 <span>Global Exports & India's Position</span></h3>
                        </div>
                    </div>
                    
                    <ul class="nav nav-tabs d-flex pr_tab" role="tablist">
                        <li class="nav-item mr-2">
                            <a class="nav-link active" data-toggle="tab" href="#pr_tab13" role="tab">2020</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pr_tab14" role="tab">2019</a>
                        </li>
                    </ul><!-- Tab panes -->

                    <div class="tab-content">

                        <div class="tab-pane active" id="pr_tab13" role="tabpanel">
                            
                            <div class="row align-items-center">     

                                <div class="col-lg-6">  
                                    
                                    <div class="row">                            
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>World Exports</h3>
                                            <h2>US $ 6.07 bn</h2> 
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's % Share in World's Exports</h3>
                                            <h2>2.3%</h2>   
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's Rank</h3>
                                            <h2>10th</h2>    
                                        </div>                                
                                    </div> 

                                </div>  

                                <div class="col-lg-6">   

                                    <div id="skills">                                
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2"><h4>China</h4></div>
                                            <div class="col px-2">
                                                <progress value="27.2" max="30"></progress><span>27.2%</span> 
                                            </div>
                                        </div>   
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2"><h4>Hong Kong</h4></div>
                                            <div class="col px-2">
                                                <progress value="9.9" max="30"></progress><span>9.9%</span>
                                            </div>
                                        </div>          
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2"><h4>France</h4></div>
                                            <div class="col px-2">
                                                <progress value="9.0" max="30"></progress><span>9.0%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2"><h4>Germany</h4></div>
                                            <div class="col px-2">
                                                <progress value="5.8" max="30"></progress><span>5.8%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2">
                                                <h4>Italy</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="5.8" max="30"></progress><span>5.8%</span>
                                            </div>
                                        </div>  
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2">
                                                <h4>Thailand</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="4.0" max="30"></progress><span>4.0%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2"><h4>Australia</h4></div>
                                            <div class="col px-2">
                                                <progress value="3.3" max="30"></progress><span>3.3%</span>
                                            </div>
                                        </div>            
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2">
                                                <h4>Singapore</h4> 
                                            </div>
                                            <div class="col px-2">
                                                <progress value="3.1" max="30"></progress><span>3.1%</span>
                                            </div>
                                        </div>                                
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2">
                                                <h4>Israel</h4>  
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2.7" max="30"></progress><span>2.7%</span>
                                            </div>
                                        </div>                                
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2">
                                                <h4>India</h4>        
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2.3" max="30"></progress><span>2.3%</span>
                                            </div>
                                        </div>                                
                                    </div> 
                                </div>
                                
                            </div>

                        </div> 

                        <div class="tab-pane" id="pr_tab14" role="tabpanel">

                            <div class="row align-items-center">   

                                <div class="col-lg-6">  
                                        
                                    <div class="row">                            
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>World Exports</h3>
                                            <h2>US $ 7.15 bn</h2> 
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's % Share in World's Exports</h3>
                                            <h2>2.6%</h2>   
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's Rank</h3>
                                            <h2>11th</h2>    
                                        </div>                                
                                    </div> 

                                </div>  

                                <div class="col-lg-6">   

                                    <div id="skills">                                
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2"><h4>China</h4></div>
                                            <div class="col px-2">
                                                <progress value="26.3" max="30"></progress><span>26.3%</span> 
                                            </div>
                                        </div>   
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2"><h4>Hong Kong</h4></div>
                                            <div class="col px-2">
                                                <progress value="11.1" max="30"></progress><span>11.1%</span>
                                            </div>
                                        </div>          
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2"><h4>France</h4></div>
                                            <div class="col px-2">
                                                <progress value="7.3" max="30"></progress><span>7.3%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2">
                                                <h4>Singapore</h4> 
                                            </div>
                                            <div class="col px-2">
                                                <progress value="6.2" max="30"></progress><span>6.2%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2">
                                                <h4>Thailand</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="5.8" max="30"></progress><span>5.8%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2"><h4>Australia</h4></div>
                                            <div class="col px-2">
                                                <progress value="5.5" max="30"></progress><span>5.5%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2"><h4>Germany</h4></div>
                                            <div class="col px-2">
                                                <progress value="5.4" max="30"></progress><span>5.4%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2">
                                                <h4>Italy</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="5.4" max="30"></progress><span>5.4%</span>
                                            </div>
                                        </div>  
                                        
                                         <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2">
                                                <h4>India</h4>        
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2.6" max="30"></progress><span>2.6%</span>
                                            </div>
                                        </div>             
                                                                        
                                        <div class="row mb-3 align-items-center progress6">
                                            <div class="col-lg-auto px-2">
                                                <h4>Israel</h4>  
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2.3" max="30"></progress><span>2.3%</span>
                                            </div>
                                        </div>                               
                                                                      
                                    </div> 
                                </div>

                            </div>
                            
                        </div>

                    </div> 
                    
                </div> <!-- 7 slide -->

                <div class="px-3">
                    
                    <div class="row align-items-center mb-4">
                        <div class="col-md-2">
                            <img src="assets/images/position_pic/pgd.jpg" class="img-fluid d-table mx-auto" />
                        </div>
                        
                        <div class="col-md-10 position_slider_title">
                            <h3>Lab Grown Diamonds & Synthetic Stones - 2020 & 2019 <span>Global Exports & India's Position</span></h3>
                        </div>
                    </div>
                    
                    <ul class="nav nav-tabs d-flex pr_tab" role="tablist">
                        <li class="nav-item mr-2">
                            <a class="nav-link active" data-toggle="tab" href="#pr_tab15" role="tab">2020</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pr_tab16" role="tab">2019</a>
                        </li>
                    </ul><!-- Tab panes -->

                    <div class="tab-content">

                        <div class="tab-pane active" id="pr_tab15" role="tabpanel">
                            
                            <div class="row align-items-center">     

                                <div class="col-lg-6">  
                                    
                                    <div class="row">                            
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>World Exports</h3>
                                            <h2>US $ 1.63 bn</h2> 
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's % Share in World's Exports</h3>
                                            <h2>32.67%</h2>   
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's Rank</h3>
                                            <h2>1st</h2>    
                                        </div>                                
                                    </div> 

                                </div>  

                                <div class="col-lg-6">   

                                    <div id="skills">                                
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>India </h4></div>
                                            <div class="col px-2">
                                                <progress value="32.7" max="35"></progress><span>32.7%</span> 
                                            </div>
                                        </div>   
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>China</h4></div>
                                            <div class="col px-2">
                                                <progress value="17.2" max="35"></progress><span>17.2%</span>
                                            </div>
                                        </div>          
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>Hong Kong</h4></div>
                                            <div class="col px-2">
                                                <progress value="16.6" max="35"></progress><span>16.6%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>USA</h4></div>
                                            <div class="col px-2">
                                                <progress value="7.4" max="35"></progress><span>7.4%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Belgium</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="5.2" max="35"></progress><span>5.2%</span>
                                            </div>
                                        </div>  
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Russia</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2.5" max="35"></progress><span>2.5%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>Thailand</h4></div>
                                            <div class="col px-2">
                                                <progress value="2.5" max="35"></progress><span>2.5%</span>
                                            </div>
                                        </div>            
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Israel</h4> 
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2.2" max="35"></progress><span>2.2%</span>
                                            </div>
                                        </div>                                
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Korea</h4>  
                                            </div>
                                            <div class="col px-2">
                                                <progress value="2.0" max="35"></progress><span>2.0%</span>
                                            </div>
                                        </div>                                
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>UAE</h4>        
                                            </div>
                                            <div class="col px-2">
                                                <progress value="1.6" max="35"></progress><span>1.6%</span>
                                            </div>
                                        </div>                                
                                    </div> 
                                </div>
                                
                            </div>

                        </div> 

                        <div class="tab-pane" id="pr_tab16" role="tabpanel">

                            <div class="row align-items-center">   

                                <div class="col-lg-6">  
                                        
                                    <div class="row">                            
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>World Exports</h3>
                                            <h2>US $ 1.53 bn</h2> 
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's % Share in World's Exports</h3>
                                            <h2>29.30%</h2>   
                                        </div>                                
                                        <div class="col-sm-12 col-md-6 col-lg-12 mb-3 mb-lg-5 position_slider_txt">
                                            <h3>India's Rank</h3>
                                            <h2>1st</h2>    
                                        </div>                                
                                    </div> 

                                </div>  

                                <div class="col-lg-6">   

                                    <div id="skills">                                
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>India </h4></div>
                                            <div class="col px-2">
                                                <progress value="29.3" max="35"></progress><span>29.3%</span> 
                                            </div>
                                        </div>   
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>Hong Kong</h4></div>
                                            <div class="col px-2">
                                                <progress value="19.1" max="35"></progress><span>19.1%</span>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>China</h4></div>
                                            <div class="col px-2">
                                                <progress value="13.5" max="35"></progress><span>13.5%</span>
                                            </div>
                                        </div>          
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>UAE</h4>        
                                            </div>
                                            <div class="col px-2">
                                                <progress value="12.1" max="35"></progress><span>12.1%</span>
                                            </div>
                                        </div>    
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>USA</h4></div>
                                            <div class="col px-2">
                                                <progress value="7.0" max="35"></progress><span>7.0%</span>
                                            </div>
                                        </div>
                                         <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2"><h4>Thailand</h4></div>
                                            <div class="col px-2">
                                                <progress value="4.4" max="35"></progress><span>4.4%</span>
                                            </div>
                                        </div>  
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Russia</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="1.9" max="35"></progress><span>1.9%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Korea</h4>  
                                            </div>
                                            <div class="col px-2">
                                                <progress value="1.0" max="35"></progress><span>1.0%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Israel</h4> 
                                            </div>
                                            <div class="col px-2">
                                                <progress value="0.8" max="35"></progress><span>0.8%</span>
                                            </div>
                                        </div> 
                                        <div class="row mb-3 align-items-center progress1">
                                            <div class="col-lg-auto px-2">
                                                <h4>Belgium</h4>    
                                            </div>
                                            <div class="col px-2">
                                                <progress value="0.6" max="35"></progress><span>0.6%</span>
                                            </div>
                                        </div>  
                                                                  
                                    </div> 
                                </div>

                            </div>
                            
                        </div>

                    </div> 
                    
                </div> <!-- 8 slide -->
                
            </div>

            <style>
                .pr_tab {border-bottom: 1px solid #a39258; margin-bottom: 15px;}
                .pr_tab li a {display: block; background: #ddd; color: #000; }
                .pr_tab li a.nav-link.active{background: #a39258; color: #fff;}
                /*.tab-content>.tab-pane {display: none;}*/
               /* .tab-content>.active {display: block!important;}*/
            </style>
                
        </div> 
    </div> 
</section>

<?php include 'include-new/footer_stats.php'; ?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
 <script src="jsvalidation/jquery.validate.js" type="text/javascript"></script>
 <script>
   $(document).ready(function()
    {   
        let cookieSet = $.cookie("isInfoSubmitted");
        let cookieEmail = $.cookie("email");
        if( typeof cookieSet !=="undefined" || typeof cookieSet !==""){
            recordUserVisits(cookieEmail);
        }
    });
    let recordUserVisits = (email)=>
    {
        let action = "recordVisits";
        $.ajax({
            type:'POST',
            url:"statisticsVisitorEntry.php",
            data:{email:email,action:action},
            dataType: "json",
            success:function(data){
                console.log(data);
            }
        });
    };
 
    $(window).on('load',function(){
    let cookieSet = $.cookie("isInfoSubmitted");
    let cookieEmail = $.cookie("email");

    console.log(cookieSet);
 if(typeof cookieSet =="undefined" || typeof cookieSet ==""){
var delayMs = 1500; // delay in milliseconds
    setTimeout(function(){
        //$('#myModal').modal('show');
        $('#myModal').modal({backdrop: 'static', keyboard: false})  
    }, delayMs);
  }
});
</script>
<!--
<script>
$(document).ready(function()
{   
    $("#statistics-visitor-entry").validate({
    rules: {
        name:{
        required:true,
        },
        org_name:{
        required:true,
        },
        degn:{
        required:true,
        },
        email:{
        required:true,
        email:true,
        },
        mobile:{
        required:true,
        number:true,
        },
        country:{
        required:true,
        },
        isNotification:{
        required:true,
        },
        isMember:{
        required:true,
        },
        wantMember:{
        required:true,
        },
        purpose:{
        required:true,
        },
    },
    messages: {
         name:{
        required:"Name is required",
        },
        org_name:{
        required:"Organisation required",
        },
        degn:{
        required:"Designation is required",
        },
        email:{
        required:"E-mail ID required",
        email:"Enter Valid Email",
        },
        mobile:{
        required:"Mobile No. is required",
        number:"Enter valid Mobile number",
        },
        country:{
        required:"Country is required",
        },
        isNotification:{
        required:"Select yes if you want update notification",
        },
        isMember:{
        required:"Select yes if Member",
        },
        wantMember:{
        required:"Select yes if you want to become a member of the GJEPC",
        },
        purpose:{
        required:"Purpose of information required",
        }
    },
    submitHandler: statisticsVisitorEntryAction  
    }); 
    $("#wantMemberDiv").slideUp();
    $("input[name='wantMember']").attr("disabled",true);
    $("input[name='isMember']").on("change",function(){
        let value = $(this).val();
        if(value=="N"){
            $("#wantMemberDiv").slideDown();
            
             $("input[name='wantMember']").attr("disabled",false);
        }else{

            $("#wantMemberDiv").slideUp();
            $("input[name='wantMember']").attr("disabled",true);
        }
    });
  
    $("#email_otp").hide();
    $("#send_otp").on("click", (e)=>{
     e.preventDefault();
     let email = $("#email").val();
     let action = "send_otp";
   
            $.ajax({
            type:'POST',
            url:"statisticsVisitorEntry.php",
            data:{email:email,action:action},
            dataType: "json",
            
            beforeSend: function(){
                $('#send_otp').html('Sending..');
                $('#send_otp').attr('disabled',true); 
            },
            success:function(data){
              
                $('#send_otp').attr('disabled',false); 
               
                if(data.status=="sent"){
                     $('#send_otp').html('OTP Sent');
                    $("#email_otp").show();
                    $("#otp").focus();
                    $("label[for='email']").html("");
                }else if(data.status=="invalid"){
                    $('#send_otp').html('Verify');
                     $("label[for='email']").show();
                     $("label[for='email']").html("Invalid E-mail Id");
                    
                    $("#email").focus();
                }else if(data.status =="notExist"){
                    $("label[for='v_email']").html("E-mail ID not registered");
                }else{
                     $('#send_otp').html('OTP Failed');
                    $("#email_otp").hide();
                    $("#email").focus();
                }                
            }
            });            
       
    });
    $("#confirm_otp").on("click", (e)=>{
     e.preventDefault();
     let email = $("#email").val();
     let otp = $("#otp").val();
     let action = "confirm_otp";
     
            $.ajax({
            type:'POST',
            url:"statisticsVisitorEntry.php",
            data:{email:email,otp:otp,action:action},
            dataType: "json",
            
            beforeSend: function(){
               
                $('#send_otp').attr('disabled',true); 
                $('#confirm_otp').attr('disabled',true); 
            },
            success:function(data){

                $('#send_otp').attr('disabled',false); 
               
                if(data.status=="verified"){
                     $('#send_otp').html('<i class="fa fa-check"></i>');
                     $('#send_otp').attr('disabled',true); 
                    $("#email_otp").hide();

                      $('label[for="email"]').html("");  
                }else{
                    $('#confirm_otp').html('Confirm OTP');
                    $("#email_otp").show();
                    $("label[for='otp']").html("Invalid OTP").show();
                    $("#otp").focus();
                }
            }
            });
    });    
  
    $("#emailVerificationModal").on("click",()=>{
       // $("#myModal").modal({backdrop: false, keyboard: false}).hide();
       //  $('#myModal2').modal({backdrop: 'static', keyboard: false}).show()  ; 
       $("#myModal").modal({backdrop: false, keyboard: false}).hide();
       $(".modal-backdrop").remove();
    });
    $("#registrationModal").on("click",()=>{
       $("#myModal2").modal({backdrop: false, keyboard: false}).hide();
        $('#myModal').modal({backdrop: 'static', keyboard: false}).show() ; 
        
    });
    $("#v_email_otp").hide();
    $("#v_send_otp").on("click", (e)=>{
     e.preventDefault();
     let email = $("#v_email").val();
     let action = "send_otp";
   
            $.ajax({
            type:'POST',
            url:"statisticsVisitorEntry.php",
            data:{email:email,action:action},
            dataType: "json",
            
            beforeSend: function(){
                $('#v_send_otp').html('Sending..');
                $('#v_send_otp').attr('disabled',true); 
            },
            success:function(data){
              
                $('#v_send_otp').attr('disabled',false); 
               
                if(data.status=="sent"){
                     $('#v_send_otp').html('OTP Sent');
                    $("#v_email_otp").show();
                    $("#v_otp").focus();
                    $("label[for='v_email']").html("");
                }else if(data.status=="invalid"){
                    $('#v_send_otp').html('Verify');
                     $("label[for='v_email']").show();
                     $("label[for='v_email']").html("Invalid E-mail Id");
                    
                    $("#email").focus();
                }else if(data.status =="notExist"){
                    $("label[for='v_email']").html("E-mail ID not registered");
                }else{
                     $('#v_send_otp').html('OTP Failed');
                    $("#v_email_otp").hide();
                    $("#v_email").focus();
                }
                
            }
            });
            
       
    });
       $("#v_confirm_otp").on("click", (e)=>{
     e.preventDefault();
     let email = $("#v_email").val();
     let otp = $("#v_otp").val();
     let action = "confirm_otp";
     
            $.ajax({
            type:'POST',
            url:"statisticsVisitorEntry.php",
            data:{email:email,otp:otp,action:action},
            dataType: "json",
            
            beforeSend: function(){
               
                $('#v_send_otp').attr('disabled',true); 
                $('#v_confirm_otp').attr('disabled',true); 
            },
            success:function(data){

                $('#v_send_otp').attr('disabled',false); 
               
                if(data.status=="verified"){
                     var successHtml = '<p><i class="fa fa-check" style="font-size:25px;color:#69af8e"></i> Email has been verified successfully</p>';
              
                     $(".modal-body").html(successHtml);
                     
                    $.cookie("isInfoSubmitted", "yes");
                    $.cookie("email", email);
                    setTimeout(function(){
                    $("#myModal2").hide();
                       $(".modal-backdrop").remove();
                    }, 3000);

                }else{
                    $('#v_confirm_otp').html('Confirm OTP');
                    $("#v_email_otp").show();
                    $("label[for='v_otp']").html("Invalid OTP").show();
                    $("#v_otp").focus();
                }
                
            }
            });
    }); 
    }); 

 function statisticsVisitorEntryAction(){
        
        $('.error').hide();
        $('#submit').val('please wait...');
        $('#submit').attr('disabled',true);
        // $('#preloader').show();
        // $('#status').show();
        var formdata = $('#statistics-visitor-entry').serialize();
        $.ajax({
        type:'POST',
        url:"statisticsVisitorEntry.php",
        data:formdata,
        dataType: "json",
        
        beforeSend: function(){
            $('#submit').html('please wait...');
            $('#submit').attr('disabled',true); 
            // $('#preloader').show();
            // $('#status').show();

        },
        success:function(data){
            // $('#preloader').delay(5000).hide();
            // $('#status').delay(5000).hide();


            var successHtml = '<p><i class="fa fa-check" style="font-size:25px;color:#69af8e"></i> Details has been submitted successfully</p>';
            if(data.status == 'success'){
                $("#statistics-visitor-entry")[0].reset();
                $(".modal-body").html(successHtml   );
                 $.cookie("isInfoSubmitted", "yes");
                 $.cookie("email", data.email);
                 
                  setTimeout(function(){
                    $("#myModal").hide();
                       $(".modal-backdrop").remove();
                    }, 3000);
              
            } else if(data.status =='error'){
                
                $('label[for="'+data.label+'"]').html(data.message);     
                $('label[for="'+data.label+'"]').show();     
                $('#submit').html('Submit');     
                $('#submit').attr('disabled',false);        
               
            }
        }
        });
    }
</script>-->
<script language="javascript">
function first_alert()
{
    alert("Only Registered Members can access the Link. \n Please Login First");
    window.location.href = "https://gjepc.org/login.php";
}
</script>
<script>
$('.select_box').change(function () {
 var select=$(this).find(':selected').val();  
 var switchbox = $(this).attr('data-switch');

 $("."+switchbox+"_hide").hide();
 $('#' + select).show();

}).change();

// event poster slider
$(".any_slider").slick({slidesToShow:3,slidesToScroll:1,autoplay:!0,autoplaySpeed:2e3,arrows:!0,dots:!1,responsive:[{breakpoint:700,settings:{slidesToShow:2,slidesToScroll:1}},{breakpoint:500,settings:{slidesToShow:1,slidesToScroll:1}}]});

// event poster slider
$(".position_slider").slick({slidesToShow:1,adaptiveHeight: true,slidesToScroll:1,autoplay:!1,autoplaySpeed:1500, speed:1500,arrows:!0,dots:!1});
</script>

<script src="assets-new/js/Chart.min.js"></script> 
<style>
.graph_loader {
    position: absolute;
    left: 15px;
    top: 0;
    right:15px;
    bottom:0; 
    background:#fff;
    z-index: 9999;
    }
.month_fy_loader
    {
    position: absolute;
    left: 15px;
    top: 0;
    right:15px;
    bottom:0; 
    background:#fff;
    z-index: 9999;
    }
</style>
<script>
// Month wise
function drawMonthLinechart(){
        var year = $('#year1').val();
        var type = '';
        $(".line .month").each(function(){
            if($(this).hasClass('active')){
            //  console.log(type);
                type = $(this).attr('data-findby');
            }
        });
    //console.log(year + ":" + type);   
    if(year != '' && type != '')  
    {
        $.ajax({
            type: "POST",
            url: 'getStatsData.php',
            dataType: 'json',
            data: "actiontype=sendMonthDetails&year="+year+"&type="+type,
            beforeSend: function(){
            $('#imgLoading1').show();   
            },
            success: function(data) { 
            // console.log(data.data); 
            $('#imgLoading1').hide();   
                var lbl = data.labels;          
                var totalcurrentyearval = data.datasets.totalUSDBillionData;
                var totallastyearval = data.datasets.totalUSDBillionDataLast;
                var currentval = data.currentyear;
                var lastval = data.lastyear; 

                //Draw new chart with ajax data
                var ctxz = document.getElementById('month_export');
                if(window.myLineCharts != undefined){
                window.myLineCharts.destroy();}
                window.myLineCharts = new Chart(ctxz, {
                    type: 'line',    // Define chart type
                    data: {
                      labels: lbl,
                      datasets: [{
                        label: currentval,
                        fill: false,
                        backgroundColor: '#81b214',
                        borderColor: '#81b214',
                        data: totalcurrentyearval,
                        borderWidth: 2
                        },
                        {
                        label: lastval,
                        fill: false,
                        backgroundColor: '#206a5d',
                        borderColor: '#206a5d',
                        data: totallastyearval,
                        borderWidth: 3
                        }
                        ]
                    },
                    options: {
                        legend: {
                            display: true,
                            position:'bottom',
                            labels: {
                                boxWidth: 10,
                                boxHeight: 10,
                            }
                        }
                    }
                });             
            }
        });
    
    } else {  
       alert("Please Select Export/Import Type & Year");  
    } 
    }

// Draw chart with Ajax request         
    $('#year1').on('change', function (e) {   
        drawMonthLinechart();
    });

    $('.line .nav-tabs').find('a').on('shown.bs.tab', function () {
        drawMonthLinechart();
    }); 
</script>

<script>
function drawDestinationpiechart(){
        var year = $('#year').val();
        var type = '';
        $(".pie .dest").each(function(){
            if($(this).hasClass('active')){
            //  console.log(type);
                type = $(this).attr('data-findby');
            }
        });
        
    //console.log(year + ":" + type);   
    if(year != '' && type != '')  
    {   
    $.ajax({
            type: "POST",
            url: 'getStatsData.php',
            dataType: 'json',
            data: "actiontype=sendDetails&year="+year+"&type="+type,
            beforeSend: function(){
            $('#imgLoading2').show();
            },
            success: function(data) {
                $('#imgLoading2').hide();
            // console.log(data.data); 
                var lbl = data.labels;          
                var val = data.datasets.data;
                
                // Delete previous chart
                //   myChart.destroy();

                //Draw new chart with ajax data
                var ctx = document.getElementById('destination_export');
                //console.log(window.myPieCharts);
                if(window.myPieCharts != undefined){
                window.myPieCharts.destroy(); }
                window.myPieCharts = new Chart(ctx, {
                    type: 'pie',    // Define chart type
                    data: {
                      labels: lbl,
                      datasets: [{
                        label: "Chart.JS",
                        fill: false,
                        backgroundColor: ["#ffc93c","#07689f","#40a8c4","#a2d5f2","#8d93ab"],
                        data: val,
                    }]
                    },
                    options: {
                    legend: {
                        display: true,
                        position:'bottom',
                        pieSliceText: 'value-and-percentage',
                        labels: {
                            boxWidth: 10,
                            boxHeight: 10,
                        }
                    },
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var dataset = data.datasets[tooltipItem.datasetIndex];
                                var meta = dataset._meta[Object.keys(dataset._meta)[0]];
                                var total = meta.total;
                                var currentValue = dataset.data[tooltipItem.index];
                                var percentage = parseFloat((currentValue/total*100).toFixed(1));
                                return currentValue + ' (' + percentage + '%)';
                            },
                            title: function(tooltipItem, data) {
                                return data.labels[tooltipItem[0].index];
                            }
                        }
                    },
                }
                });                             
            }           
        });
    } else {  
       alert("Please Select Export/Import Type & Year");  
    } 
}

// Draw chart with Ajax request         
    $('#year').on('change', function (e) {   
        drawDestinationpiechart();
    });

    $('.pie .nav-tabs').find('a').on('shown.bs.tab', function () {
        drawDestinationpiechart();
    }); 
</script>

<script>
//commodity export/import

function drawCommoditybarchart(){
        var year = $('#year2').val();
        var type = '';
        $(".bar .comm").each(function(){
            if($(this).hasClass('active')){
            //  console.log(type); 
                type = $(this).attr('data-findby');
            }
        });
        
    //console.log(year + ":" + type);   
    if(year != '' && type != '')  
    {
    $.ajax({
            type: "POST",
            url: 'getStatsData.php',
            dataType: 'json',
            data: "actiontype=sendCommodityDetails&year="+year+"&type="+type,
            beforeSend: function(){
            $('#imgLoading3').show();
            },
            success: function(data) {
                $('#imgLoading3').hide();
            // console.log(data.data); 
                var lbl = data.labels;          
                var totalcurrentyearval = data.datasets.totalUSDBillionData;
                var totallastyearval = data.datasets.totalUSDBillionDataLast;
                var currentval = data.currentyear;
                var lastval = data.lastyear; 

                var canvas = document.getElementById("commodity_export");
                var ctx = canvas.getContext("2d");
                
                // Data with datasets options
                var data = {
                    labels: lbl,
                    datasets: [
                    {
                        label: currentval,
                        fill: true,
                        backgroundColor: ["#5588bb","#66bbbb","#aa6644","#99bb55","#ee9944","#444466","#bb5555"],
                        data: totalcurrentyearval
                    },
                    {
                        label: lastval,
                        fill: true,
                        backgroundColor: ["#5588bb","#66bbbb","#aa6644","#99bb55","#ee9944","#444466","#bb5555"],
                        data: totallastyearval
                    }
                    ]
                };
                
                // Notice how nested the beginAtZero is
                var options = {
                    scales: {
                        xAxes: [
                        {
                            gridLines: {
                                display: false,
                                drawBorder: true,
                                drawOnChartArea: false
                            }
                        }
                        ],
                        yAxes: [
                        {
                            ticks: {
                                beginAtZero: true
                            }
                        }
                        ]
                    }
                };
                
                // added custom plugin to wrap label to new line when \n escape sequence appear
                var labelWrap = [
                {
                    beforeInit: function (chart) {
                        chart.data.labels.forEach(function (e, i, a) {
                            if (/\n/.test(e)) {
                                a[i] = e.split(/\n/);
                            }
                        });
                    }
                }
                ];

                // Chart declaration:
                if(window.myBarCharts != undefined){
                window.myBarCharts.destroy(); }
                window.myBarCharts = new Chart(ctx, {
                    type: "bar",
                    data: data,
                    options: {
                        legend: {
                            display: false,
                            position:'bottom',
                            labels: {
                                boxWidth: 10,
                                boxHeight: 10,
                            }
                        }
                    },
                    plugins: [{
                        beforeInit: function(chart) {
                            chart.data.labels.forEach(function(value, index, array) {
                                var a = [];
                                a.push(value.slice(0, 25));
                                var i = 1;
                                while (value.length > (i * 25)) {
                                    a.push(value.slice(i * 25, (i + 1) * 25));
                                    i++;
                                }
                                array[index] = a;
                            })
                        }
                    }]
                });                     
            }           
        });
    } else {  
       alert("Please Select Export/Import Type & Year");  
    } 
}

// Draw chart with Ajax request         
    $('#year2').on('change', function (e) {   
        drawCommoditybarchart();
    });

    $('.bar .nav-tabs').find('a').on('shown.bs.tab', function () {
        drawCommoditybarchart();
    }); 
</script>
<script type="text/javascript">
        $('.nav-link.dashboard').click(function(){
            // $('.nav-link.dashboard').removeClass("active");
            // $(this).addClass("active");
            drawWholeData();
        });
        
        function drawWholeData(){
                var values = "";
                $('.nav-link.dashboard').each(function(){
                    if($(this).hasClass('active')){
                        values = $(this).data('url').split(" ");
                    }
                });            
                
                var info = values[0]; //alert(registration_id);
                $.ajax({
                    type: "POST",
                    url: "getStatsData.php",
                    data: "actiontype=getDetails&info="+info,
                    dataType:"json",
                    beforeSend: function(){
                    $('#imgLoading4').show();
                    //$('#tabs-1').hide();
                    },
                    success: function(data) {
                        if(data.success){
                        $('#imgLoading4').hide();
                            //$('#tabs-1').show();                      
                              // console.log(data); 
                              if(data.monthData=="monthData"){
                                 // $('#tabs-1').show(); 
                                 // $('#tabs-2').hide(); 
                               $('#totalExportUSDMillion').html(data.totalExportUSDMillion);
                               $('#totalImportUSDMillion').html(data.totalImportUSDMillion);
                               $('#growthMothExportPer').html(data.growthMothExportPer);
                               $('#growthMotImportPer').html(data.growthMotImportPer);
                              }
                               if(data.monthData=="fyData"){
                                   // $('#tabs-2').show(); 
                                   // $('#tabs-1').hide();
                               $('#totalExportFYUSDMillion').html(data.totalExportFYUSDMillion);
                               $('#totalImportFYUSDMillion').html(data.totalImportFYUSDMillion);
                               $('#growthFYExportPer').html(data.growthFYExportPer);
                               $('#growthFYImportPer').html(data.growthFYImportPer);
                               }
                        }
                    }
                });
                return false;            
        };
</script>

<script>
$(function(){
  var hash = window.location.hash;
  hash && $('ul.statisticTab a[href="' + hash + '"]').tab('show'); 
  $('ul.statisticTab a').click(function (e) {
     $(this).tab('show');
     var scrollmem = $('body').scrollTop();
     window.location.hash = this.hash;
  });
});
</script>

<script>
    $('.adv_slider').slick({
  slidesToShow: 1,
  autoplay:true,
  dots:false,
  slidesToScroll: 1,
  speed:1000,
  arrows: false,
  fade: true,
});
</script>

<script>
 drawWholeData();
 drawDestinationpiechart();
 drawMonthLinechart();
 drawCommoditybarchart();
</script>