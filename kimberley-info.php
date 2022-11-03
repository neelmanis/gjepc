<?php 
$pageTitle = "Gem & Jewellery | Kimberley Info - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php 
include 'include-new/header.php'; 
include 'db.inc.php'; 
?>
<section>
	<div class="container inner_container">	
    <div class="row justify-content-center mb-0 mt-3">
        <div class="col-12 text-center">
            <h1 class="bold_font"><div class="d-block"><img src="assets/images/gold_star.png"></div>
            Kimberley Info</h1>
        </div>
    </div>
	      		
        <div class="col-lg-12">
            	<?php 
        		$sql="SELECT * FROM `kimberly_info_master` WHERE status=1 order by post_date desc";
                $result=$conn->query($sql);
                while($rows2=$result->fetch_assoc()){
        		?>
                <li class="col-12 item year-<?php echo $rows2['post_date'];?>">
                	   	<a href="admin/KimberlyInfo/<?php echo $rows2['upload_kimberly_info'];?>" target="_blank" class="new_pdf_wrp">
                        	<p class="blue"><?php echo $rows2['post_date'];?></p> 
                            <div class="circular_text"><?php echo filter($rows2['name']);?></div>
                            <div class="clearfix"></div> 
                        </a>        		
        		</li>
				<?php } ?>        
        </div>
	</div>
</section>
<?php include 'include-new/footer.php'; ?>