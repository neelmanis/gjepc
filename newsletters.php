<?php 
$pageTitle = "Gem & Jewellery | Newsletter - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php 
include 'include/header.php';
include 'db.inc.php'; 
?>
<section>
	<div class="banner_wrap mb">
		<?php include 'include/inner_banner.php'; ?>        
        <ul class="d-flex breadcrumb">
    		<li><a href="index.php">Home</a></li>
            <li>Media</li>
    		<li class="active">Newsletter</li>
  		</ul>        
    </div>
    
<div class="container inner_container">	
	<div class="row mb">    
		<div class="col-12">
                <div class="innerpg_title">
                    <h1>Newsletter</h1>
                </div>
            </div>

	    <div class="col-12">
              	<ul id="masonry-list" class="circular_wrap row">
                	<?php
					$sql="SELECT year FROM `newsletter_master` WHERE status=1 group by year order by year desc";
					$result=$conn->query($sql);
					//if(!$result) die ($conn->error); exit;
					while($rows=$result->fetch_assoc())
					{	
						$year = filter($rows['year']);
						$name = filter($rows['name']); 
					?>
                    <div class="col-12"><p class="blue">Year <?php echo $year;?></p></div>
							<?php
							$sqlx="SELECT `id`, `post_date`, `name`, `html_files` FROM `newsletter_master` WHERE year=".$year." order by post_date desc";
							$resultx=$conn->query($sqlx);
							while($rowx=$resultx->fetch_assoc())
							{ ?>
                        	<li class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4"> <a href="<?php echo $rowx['html_files'];?>" target="_blank" class="pdf_wrp">
							<?php echo stripslashes($rowx['name']);?></a></li>
							<?php } ?>                        
					<?php } ?>      
                </ul>
	    </div>	
	</div>
</div>
<div class="container mb"></div>    
    <div class="container mb"><?php include 'include/inner_videos.php'; ?></div>
</section>
<?php include 'include/footer.php'; ?>