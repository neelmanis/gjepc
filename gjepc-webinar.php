<?php 
include('db.inc.php');
include('functions.php');
$pageTitle = "Gems And Jewellery Industry In India | Vision & Mission - GJEPC India";
$pageDescription  = "The Gem & Jewellery Export Promotion Council (GJEPC) was set up by the Ministry of Commerce, Government of India (GoI) in 1966. It was one of several Export Promotion Councils (EPCs) launched by the Indian Government";
?>
<?php include 'include-new/header.php'; ?>

<section>
    

         
        
        <div class="container mb-5 position-relative inner_banner">
            <img src="assets/images/inner_banner/webinar.jpg" class="img-fluid d-block" />
            <div class="innerpg_title">
                <div class="d-flex h-100">
                    <div class="my-auto"><h1> Webinar</h1></div>
                </div>
            </div>
        </div>
               

    
    <div class="container">
        
        <div class="row mb-5 orgIntro_txt">
        
            <!--<h1 class="col-12 title">Vision & Values</h1>-->
                    
            <div class="col-lg-6 mb-4 mb-lg-0">
                
                <h1 class="bold_font font_responsive"><div class="d-block"><img src="assets/images/gold_star.png"></div>Access a wealth of up-to-the-minute information from  <span> industry leaders </span> through these <span> webinars. </span></h1>
            
                <div class="mb-5">
                    <p>Tune in for more live virtual sessions on a broad spectrum of issues that matter to your business most today.</p>
                </div>
            <div>
                        
                        
                        
                        </div>
                    </div>
                    
            <div class="col-lg-6 webnarVideo">
            <h2 class="title">expert's view</h2>
                <iframe src="https://www.youtube.com/embed/iIivuaQ-_aw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen=""></iframe>
            </div>
        
        </div>
        <?php 

        $sql_webinars = "SELECT * FROM webinar_master WHERE type='webinar' AND status='1' AND post_date >= CURDATE() ORDER BY post_date ASC";
        $result_webinars = $conn->query($sql_webinars);
        $count_webinars = $result_webinars->num_rows;


        ?>
        <h1 class="title">webinar</h1>
        
        <div class="row mb-5">
            <div class="col-12">
                <div class="webinar_slider">
                    <?php if($count_webinars>0){
                        while ($row_webinars = $result_webinars->fetch_assoc() ) {  $id = $row_webinars['id'];?>
                     <div>
                    <div class="webinarBox goldenBorder">
                            <div class="pic"><img src="assets/images/webinar/new/<?php echo $row_webinars['banner']; ?>" class="img-fluid d-block mb-3" /></div>
                            <div class="p-4 webinarBrief">
                                <h1 class="mb-3"><?php echo $row_webinars['title'];?></h1>
                                <p class="mb-3"> <?php echo html_entity_decode($row_webinars['short_desc']);?></p>
                                <div class="webinarInfo">
                                <div class="row ab_none justify-content-between mb-4">
                                    <div class="col">
                                        <div class="speaker d-flex h-100">
                                        <div class="align-self-center">
                                        <div class="headT mb-2">SPEAKER :</div>

                                        <?php 
                                        $webinar_speakers = "SELECT * FROM webinar_speaker_details WHERE webinar_id = '$id'";
                                        $result_web_speakers = $conn->query($webinar_speakers);
                                        $count_web_speakers =  $result_web_speakers->num_rows;
                                        if($count_web_speakers>0){while ($row_web_speakers = $result_web_speakers->fetch_assoc()) {?>
                                            <div class="speakerName"><?php echo $row_web_speakers['speaker_name'];?><span><?php echo $row_web_speakers['speaker_disignation'];?></span></div>
                                        <?php } } ?>
                                        
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col pl-5">
                                        <div class=" d-flex h-100">
                                        <div class="align-self-center">
                                        <div class="d-block webinarDay goldBg"><?php echo date("l j M, Y ", strtotime($row_webinars['post_date']));?></div>
                                        <div class="d-block webinarDay blackBg"> <?php echo date("h:i A", strtotime($row_webinars['start_time']));?></div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-6" class="text-left"><a href="gjepc-webinar-details.php?page=<?php echo $row_webinars['id'];?>" class="text-left">Read more</a>
                                    </div>
                                        <div class="col-6" class="text-right">
                                    <?php if($row_webinars['pre_reg_url'] !="" && !is_null($row_webinars['pre_reg_url'])){?>
                                     <a href="<?php echo $row_webinars['pre_reg_url']; ?>" target="_blank" >Registration Link</a>
                                   <?php  }?>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </div>
                       
                    <?php } }else{?>
                <div class="mb-5">
                    <p> coming soon..</p>
                </div>
                   <?php }?>
                    
                    
  
                </div>
                                        
                                       
            </div>
        </div>
        
        
         <h1 class="title">workshop</h1>
         <?php 

        $sql_workshop = "SELECT * FROM webinar_master WHERE type='workshop' AND status='1' AND post_date >= CURDATE() ORDER BY post_date ASC";
        $result_workshop = $conn->query($sql_workshop);
        $count_workshop = $result_workshop->num_rows;


        ?>
        <div class="row mb-5">
            <div class="col-12">
                <div class="workshop_slider">
                    
                    
                   <?php if($count_workshop>0){
                        while ($row_workshop = $result_workshop->fetch_assoc() ) {  $id = $row_workshop['id'];?>
                     <div>
                    <div class="webinarBox goldenBorder">
                            <div class="pic"><img src="assets/images/webinar/new/<?php echo $row_workshop['banner']; ?>" class="img-fluid d-block mb-3" /></div>
                            <div class="p-4 webinarBrief">
                                <h1 class="mb-3"><?php echo $row_workshop['title'];?></h1>
                                <p class="mb-3"> <?php echo html_entity_decode($row_workshop['short_desc']);?></p>
                                <div class="webinarInfo">
                                <div class="row ab_none justify-content-between mb-4">
                                    <div class="col">
                                        <div class="speaker d-flex h-100">
                                        <div class="align-self-center">
                                        <div class="headT mb-2">SPEAKER :</div>

                                        <?php 
                                        $workshop_speakers = "SELECT * FROM webinar_speaker_details WHERE webinar_id = '$id'";
                                        $result_work_speakers = $conn->query($workshop_speakers);
                                        $count_work_speakers =  $result_work_speakers->num_rows;
                                        if($count_work_speakers>0){while ($row_work_speakers = $result_work_speakers->fetch_assoc()) {?>
                                            <div class="speakerName"><?php echo $row_work_speakers['speaker_name'];?><span><?php echo $row_work_speakers['speaker_disignation'];?></span></div>
                                        <?php } } ?>
                                        
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col pl-5">
                                        <div class=" d-flex h-100">
                                        <div class="align-self-center">
                                        <div class="d-block webinarDay mb-2 goldBg"><?php echo date("l j M, Y ", strtotime($row_workshop['post_date']));?></div>
                                        <div class="d-block webinarDay blackBg"> <?php echo date("h:i A", strtotime($row_workshop['start_time']));?></div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col"><a href="gjepc-webinar-details.php?page=<?php echo $row_workshop['id'];?>">Read more</a></div>
                                </div>
                            </div>
                    </div>
                    </div>
                       
                    <?php } }else{?>
                <div class="mb-5">
                    <p> coming soon..</p>
                </div>
                   <?php }?>
                    
                    
                    
               
                   
                    
                  
                </div>
                                        
                                       
            </div>
        </div>
        
        <a href="past-webinar.php" class="gold_btn d-table mx-auto mb-5 px-5">Past Webinar</a>
       
    </div>
    
</section>

<?php include 'include-new/footer.php'; ?>


<script>
$(".webinar_slider").slick({slidesToShow:2,slidesToScroll:1,autoplay:!1,autoplaySpeed:2e3,arrows:!0,dots:!1,responsive:[{breakpoint:990,settings:{slidesToShow:1,slidesToScroll:1}},{breakpoint:500,settings:{slidesToShow:1,slidesToScroll:1}}]});

$(".workshop_slider").slick({slidesToShow:2,slidesToScroll:1,autoplay:!1,autoplaySpeed:2e3,arrows:!0,dots:!1,responsive:[{breakpoint:990,settings:{slidesToShow:1,slidesToScroll:1}},{breakpoint:500,settings:{slidesToShow:1,slidesToScroll:1}}]});
    
</script>
