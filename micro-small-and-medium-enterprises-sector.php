<?php 
$pageTitle = "Micro Small And Medium Enterprises Sector - GJEPC India";
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
    		<li class="active">MSME</li>
  		</ul>        
    </div>

<div class="container inner_container">
	<div class="row mb">
         <div class="col-12">
                <div class="innerpg_title">
                    <h1>Micro Small And Medium Enterprises Sector</h1>
                </div>
            </div>

	     <div class="col-12">
                	<ul class="download_pdf row">
						<?php
						$sql="SELECT * FROM `msme_circular` WHERE status='1' ORDER BY mid DESC";
						$result=$conn->query($sql);
						while($rows=$result->fetch_assoc())
						{
						echo "<li class='col-12 col-sm-6 col-md-4 col-lg-3 mb-4'><a href='admin/msmecircular/$rows[upload_msme_info]' target='_blank' class='pdf_wrp'>$rows[name]</a></li>";
						}
						?>                    	
                    </ul>                
	     </div>         
	</div>    
</div>

<div class="container mb"> </div>    
    <div class="container mb"> <?php include 'include/inner_videos.php'; ?> </div>
</section>
<?php include 'include/footer.php'; ?>