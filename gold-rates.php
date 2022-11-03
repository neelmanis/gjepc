<?php 
$pageTitle = "Gold India online | Gold Rates - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php 
include 'include-new/header.php';
include 'db.inc.php'; 
?>

<section class="py-5">
    
	
    <div class="container inner_container">
		<div class="row justify-content-center">        
        	<div class="col-12 text-center">
      <h1 class="bold_font"><div class="d-block"><img src="assets/images/gold_star.png"></div>
      Metal & Currency Rates</h1>
    </div>
        	<div class="col-12">
			<ul id="masonry-list" class="circular_wrap row">
						<?php 
                        $sql="SELECT * FROM `gold_rate_master` WHERE 1 and status=1 order by post_date desc";
                        $result=$conn->query($sql);
                        while($rows=$result->fetch_assoc())
                        {
                        ?>
                            <li class="col-md-4 col-sm-6 mb-4  item year-<?php echo date("d-M-Y",strtotime($rows['post_date']));?>">
								<div class="circular">                                
                                    <a href="admin/GoldRate/<?php echo $rows[upload_gold_rate];?>" target="_blank" class="pdf_wrp">
                                       
                                        <p class="blue"><?php echo date("d-M-Y",strtotime($rows['post_date']));?></p>
                                        <div class="circular_text">Metal & Currency Rates</div>
                                        <div class="clearfix"></div> 
                                    </a>                                    
                                </div>                                
                            <?php } ?>
                            </li>
                        </ul>     
                 </div>            
            </div>        
        </div>
</section>
<?php include 'include-new/footer.php'; ?>