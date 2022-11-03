<?php 
$pageTitle = "Union Budget - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php include 'include/header.php'; include 'db.inc.php'; ?>

<section>

	<div class="banner_wrap mb">
		<?php include 'include/inner_banner.php'; ?>
        
        <ul class="d-flex breadcrumb">
    		<li><a href="index.php">Home</a></li>
            <li>Members</li>
            <li>Trade Information</li>
    		<li class="active">Union Budget</li>
  		</ul>
        
    </div>

    <div class="container inner_container">
        
        <div class="row mb">
        
            <div class="col-12">
                <div class="innerpg_title">
                    <h1>Union Budget</h1>
                </div>
            </div>
    
            <div class="col-12">       
                    <?php
                    $sql="SELECT * FROM `union_budget_category` WHERE 1 and status=1 order by order_no desc";
                    $result=$conn ->query($sql);
                    while($rows=$result->fetch_assoc())
                    {
                    ?>
                     <p class="blue m-0"><?php echo filter($rows['cat_name']);?></p>
                    <ul class="download_pdf row">
                        <?php 
                        $sql2="SELECT * FROM `union_budget_master` WHERE 1 and status='1' and cat_id='$rows[id]' order by post_date desc";
                        $result2=$conn ->query($sql2);
                        while($rows2=$result2->fetch_assoc())
                        {
                        ?>
                        <li class="col-lg-3 col-md-4 col-sm-6 col-12 mb-4"><a href="admin/UnionBudget/<?php echo $rows2['upload_union_budget'];?>" target="_blank" class="pdf_wrp"><?php echo filter($rows2['name']);?></a></li>   
                        <?php			
                        } ?>
						  </ul>
                      <?php  }  ?>
             </div>        
        </div>    
    </div>    
    <div class="container mb"> </div>    
    <div class="container mb">    		
    	<?php include 'include/inner_videos.php'; ?>        	    	
    </div>
</section>
<?php include 'include/footer.php'; ?>