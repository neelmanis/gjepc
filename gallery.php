<?php include 'include/header.php'; ?>




<section>

    <div class="banner_wrap mb">
        <?php include 'include/inner_banner.php'; ?>
        <ul class="d-flex breadcrumb">
            <li> <a href="index.php">Home</a></li>
            <li><a href="#"> Photo Gallery </a></li>
        </ul>
    </div>


<div class="container inner_container">
	
	<div class="row mb">
    
    <div class="col-12">
		<div class="innerpg_title">
 			<h1>IIGJ Convocation</h1> 
		</div>
	</div>
    
	<div class="col-12">       
          

		  

		     	<div class="row image_gallery">
				 
				  <?php
				  	https://gjepc.org/images/gallery/2017/gallery%20(153).jpg
		     		for ($i=1; $i <= 181; $i++) { 
		     			echo "<div class='col-6 col-md-4 col-lg-3'>
		     					<a data-fancybox='gallery'  href='https://gjepc.org/images/gallery/2017/gallery%20(".$i.").jpg'>
		     						<img class='img-fluid d-block' src='https://gjepc.org/images/gallery/2017/gallery%20(".$i.").jpg'>
									<div class='overlay'></div>
		     				  </a></div>";
		     		}

		     	  ?>
				 
				</div>
		     
		     	
			
			    	


	</div>

	</div>

</div>


</section>

<?php include 'include/footer.php'; ?>

