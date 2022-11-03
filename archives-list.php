<?php 
$pageTitle = "Gem & Jewellery | Archieve List - GJEPC India";
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
            <li>Members</li>
            <li>Trade Information</li>
    		<li class="active">Archieve List</li>
  		</ul>        
    </div>

<div class="container inner_container">	
	<div class="row mb">    
		<div class="col-12">
        	<div class="innerpg_title"><h1>Archieve List</h1></div>
       	</div>
	     <div class="col-12">            	
                
                <p><strong>Circulars to Members</strong></p>
                	<ul class="download_pdf">
					<?php
					$sql="SELECT * FROM `circulars_master` WHERE 1 and `status`='1' and `set_archive`='1' order by post_date desc";
					$result=mysql_query($sql);
					while($rows=mysql_fetch_array($result))
					{
					?>
                    <li class="col-lg-3 col-md-4 col-sm-6 col-12"><p class="blue"><?php echo date("M d, Y",strtotime($rows['post_date']));?></p><a href="admin/Circulars/<?php echo $rows['upload_circulars'];?>" target="_blank" class="pdf_wrp"><p class="mb-5"><?php echo stripslashes($rows['name']);?> </p></a></li>
					<?php } ?>
                    </ul>
                
                
                <p><strong>Notification</strong></p>
                	<ul class="download_pdf row">
					<?php
					$sql="SELECT * FROM `notifications_master` WHERE 1 and `status`='1' and `set_archive`='1' order by post_date desc";
					$result=mysql_query($sql);
					while($rows=mysql_fetch_array($result))
					{
					?>
                    <li  class="col-lg-3 col-md-4 col-sm-6 col-12">
					<a href="admin/Notifications/<?php echo $rows['upload_notifications'];?>" target="_blank" class="pdf_wrp"><?php echo stripslashes($rows['name']);?></a><?php echo date("M d, Y",strtotime($rows['post_date']));?></li>                        
					<?php } ?>	
                    </ul>               
			 </div> 
	</div>    
</div>
 <div class="container mb"></div> 
    <div class="container mb">
	<?php include 'include/inner_videos.php'; ?>
	</div>
</section>
<?php include 'include/footer.php'; ?>