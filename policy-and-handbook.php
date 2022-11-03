<?php 
$pageTitle = "Gem & Jewellery | Policy & Handbook - GJEPC India";
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
            <li>Policy</li>
    		<li class="active">Policy & Handbook</li>
  		</ul>        
    </div>    
    <div class="container inner_container">        
        <div class="row mb">        
            <div class="col-12">
                    <div class="innerpg_title">
                        <h1>Policy & Handbook</h1>
                    </div>
            </div>    
            <div class="col-12">            	
                <p class="blue">2015-16</p>
                
                <ul class="download_pdf row">
                            <?php
                            $sql="SELECT * FROM `policy_handbook_category` WHERE 1 and status=1 order by order_no";
                            $result=mysql_query($sql);
                            while($rows=mysql_fetch_array($result))
                            {
                            ?>
                            <?php 
                            $sql2="SELECT * FROM `policy_handbook_master` WHERE 1 and status='1' and cat_id='$rows[id]' order by post_date desc";
                            $result2=mysql_query($sql2);
                            while($rows2=mysql_fetch_array($result2))
                            {
                            ?>
                            <li class="col-lg-3"><a href="admin/PolicyHandbook/<?php echo $rows2['upload_policy_handbook'];?>" target="_blank" class="pdf_wrp"><?php echo $rows2['name'];?></a></li>					   
                            <?php
                            }
                            }
                            ?>
                        </ul>       
    
       		</div>        
		</div>
   </div> 
    <div class="container mb"> </div>
    
    <div class="container mb">
    	<?php include 'include/inner_videos.php'; ?>
    </div>
</section>
<?php include 'include/footer.php'; ?>