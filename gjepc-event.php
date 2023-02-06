<?php 
include('db.inc.php');
include('functions.php');
$pageTitle = "Gems And Jewellery Industry In India | Vision & Mission - GJEPC India";
$pageDescription  = "The Gem & Jewellery Export Promotion Council (GJEPC) was set up by the Ministry of Commerce, Government of India (GoI) in 1966. It was one of several Export Promotion Councils (EPCs) launched by the Indian Government";
?>
<?php include 'include-new/header.php'; ?>

<style>
    .webinar_slider h2.title {font-size: 22px;}
    .webinarBox {background: #f1f1f1;}

    .bookNow {text-align: center; display: table; margin: 0 auto; font-size: 16px; font-weight: bold; text-decoration: none!important; position: relative;}

.bookNow:before {content: ''; position: absolute; left: 0; bottom: 0; width: 100%; height: 2px; background: #7b6c39;}

</style>

<section>
    
    <div class="container my-5">
        
       
        <?php 

        $sql_webinars = "SELECT * FROM webinar_master WHERE type='event' AND status='1'  AND post_date >= CURDATE() ORDER BY post_date ASC ";
        $result_webinars = $conn->query($sql_webinars);
        $count_webinars = $result_webinars->num_rows;


        ?>

        <h1 class="bold_font text-center"><div class="d-block"><img src="assets/images/gold_star.png"></div> GJEPC EVENT</h1>
        
        <div class="webinar_slider">
            
            <?php if($count_webinars>0){ while ($row_webinars = $result_webinars->fetch_assoc() ) {  $id = $row_webinars['id'];?>
            
            <div>

                <div class="webinarBox goldenBorder">

                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="pic"><img src="assets/images/webinar/new/<?php echo $row_webinars['banner']; ?>" class="img-fluid d-block" /></div>
                        </div>
                        <div class="col-md-6">

                            <div class="p-4 webinarBrief">
                                <h2 class="mb-4 title text-center"><?php echo $row_webinars['title'];?></h2>
                                <p class="mb-3"> <?php echo html_entity_decode($row_webinars['short_desc']);?></p>

                                <div class="d-flex mb-4">
                                    <div class="col"> 
                                        <div class="d-block webinarDay goldBg"><?php echo date("l j M, Y ", strtotime($row_webinars['post_date']));?></div>
                                    </div>
                                    <div class="col">
                                        <div class="d-block webinarDay blackBg"> <?php echo date("h:i A", strtotime($row_webinars['start_time']));?></div>
                                    </div>
                                </div>

                                <a href="gjepc-webinar-details-rz.php?page=<?php echo $row_webinars['id'];?>" class="bookNow">Book Now</a>

                               
                                    

                        <!-- <div class="webinarInfo">
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
                        </div> -->
                        <div class="row">
                            
                            
                                <div class="col-6" class="text-right">
                            <?php if($row_webinars['pre_reg_url'] !="" && !is_null($row_webinars['pre_reg_url'])){?>
                             <a href="<?php echo $row_webinars['pre_reg_url']; ?>" target="_blank" >Registration Link</a>
                           <?php  }?>
                            </div>
                        </div>
                    </div>

                        </div>
                    </div>

                    
                    
                </div>

            </div>
                       
            <?php } }else{?>
                <div class="mb-5">
                    <p> Booking  closed</p>
                </div>
            <?php }?>
        
        </div>
        
      
        
        
        <!-- <a href="past-webinar.php" class="gold_btn d-table mx-auto mb-5 px-5">Past Webinar</a> -->
       
    </div>
    
</section>

<?php include 'include-new/footer.php'; ?>


<script>
$(".webinar_slider").slick({slidesToShow:1,slidesToScroll:1,autoplay:!1,autoplaySpeed:2e3,arrows:!0,dots:!1,responsive:[{breakpoint:990,settings:{slidesToShow:1,slidesToScroll:1}},{breakpoint:500,settings:{slidesToShow:1,slidesToScroll:1}}]});


    
</script>
