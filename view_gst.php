<?php 
include 'include/header.php';
include 'db.inc.php'; 
?>

<section>
	
    <div class="banner_wrap mb">
		<?php include 'include/inner_banner.php'; ?>        
        <ul class="d-flex breadcrumb">
    		<li><a href="index.php">Home</a></li>
    		<li class="active">View GST</li>
  		</ul>        
    </div>
    







<div class="container inner_container">
	
	<div class="row mb">
		
        <div class="col-12">
            <div class="innerpg_title">
                <h1>View GST</h1>
            </div>
     	</div>

	    <div class="col-12">
        
        	<p class="blue">Govt Circular</p>
         
			<?php
	$sql2="SELECT * FROM `gst_upload` WHERE section_id='2' and status='1' order by id desc";
	$result2=mysql_query($sql2);
	?>
	<ul class="download_pdf row">    
    <?php
	while($rows2=mysql_fetch_array($result2))
	{ ?>
    <li class="col-md-4 mb-4"><a href="admin/gstpdf/<?php echo $rows2['upload_pdf'];?>" target="_blank" class="pdf_wrp"><?php echo $rows2['name'];?></a></li>   
    <?php
	}
	echo "</ul>";
	?>
				
	</div>
    
    </div>
    
    </div>
	
</section>


<?php include 'include/footer.php'; ?>