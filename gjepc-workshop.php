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
        

        <h1 class="bold_font text-center"><div class="d-block"><img src="assets/images/gold_star.png"></div> GJEPC Workshop</h1>

        <?php 
            $sql_workshop = "SELECT * FROM webinar_master WHERE type='workshop' AND status='1' AND post_date >= CURDATE() ORDER BY post_date ASC";
        $result_workshop = $conn->query($sql_workshop);
        $count_workshop = $result_workshop->num_rows;
        ?>
     
        <div class="workshop_slider">
            
            <?php if($count_workshop>0){
                        while ($row_workshop = $result_workshop->fetch_assoc() ) {  $id = $row_workshop['id'];?>
            <div>
                
                <div class="webinarBox goldenBorder">

                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="pic"><img src="assets/images/webinar/new/<?php echo $row_workshop['banner']; ?>" class="img-fluid d-block" /></div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 webinarBrief">
                                <h2 class="title text-center mb-3"><?php echo $row_workshop['title'];?></h2>
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
                                            <div class="d-flex h-100">
                                                <div class="align-self-center">
                                                    <div class="d-block webinarDay mb-2 goldBg"><?php echo date("l j M, Y ", strtotime($row_workshop['post_date']));?></div>
                                                    <div class="d-block webinarDay blackBg"> <?php echo date("h:i A", strtotime($row_workshop['start_time']));?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col"><a href="gjepc-webinar-details-rz.php?page=<?php echo $row_workshop['id'];?>" class="bookNow">Register Now</a></div>
                                </div>
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
                                        
        <!-- <a href="past-webinar.php" class="gold_btn d-table mx-auto mb-5 px-5">Past Webinar</a> -->
       
    </div>
    
</section>



<?php include 'include-new/footer.php'; ?>



<script>


$(".workshop_slider").slick({slidesToShow:1,slidesToScroll:1,autoplay:!1,autoplaySpeed:2e3,arrows:!0,dots:!1,responsive:[{breakpoint:990,settings:{slidesToShow:2,slidesToScroll:1}},{breakpoint:500,settings:{slidesToShow:1,slidesToScroll:1}}]});


    
</script>