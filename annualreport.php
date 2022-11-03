<?php 
include 'include/header.php';
include 'db.inc.php'; 
?>
<?php if(!isset($_SESSION['USERID'])){header('location:login.php');}?>

<section>
	<div class="banner_wrap mb">
		<?php include 'include/inner_banner.php'; ?>
        
        <ul class="d-flex breadcrumb">
    		<li><a href="index.php">Home</a></li>
            <li>Members</li>
    		<li class="active">Annual Report</li>
  		</ul>
        
    </div>

	<div class="container inner_container">
	
        <div class="row mb">
        
            <div class="col-12">
                <div class="innerpg_title">
                    <h1>Annual Report</h1>
                 </div>
            </div>
    
             <div class="col-12">
                 <div class="ab_description">                    
                
                    <ul id="masonry-list" class="circular_wrap">
                        <?php
                        $sql="SELECT year FROM `manage_annual_report` WHERE status='1' group by year desc";
                        $result=mysql_query($sql);
                        while($rows=mysql_fetch_array($result)) 
                        {
                        ?>
                        <li class="item year-<?php echo $rows['year'];?>">
                            <div class="sub_head"><?php echo $rows['year'];?></div>
                            <div class="circular">
                            <?php 
                            $sql2="SELECT `id`, `post_date`, `name`, `upload_pdf` FROM `manage_annual_report` WHERE status='1' and  year='$rows[year]' order by post_date desc";
                            $result2=mysql_query($sql2);
                            while($rows2=mysql_fetch_array($result2))
                            {							
                            ?>						
                            <a href="admin/annual_report/<?php echo $rows2['upload_pdf'];?>" target="_blank">
                                <span><?php echo $rows2['post_date'];?></span> 
                                <div class="circular_text"><?php echo stripslashes($rows2['name']);?></div>
                                <div class="clearfix"></div> 
                                </a>
                            <?php } ?>
                            </div>
                                
                        </li>
                        <?php } ?>
                    </ul>                
                 </div> 
             </div>
        </div>
	</div>
    <div class="container mb"> </div>
    
    <div class="container mb">
    	<?php include 'include/inner_videos.php'; ?>
    </div>
</div>
<?php include 'include/footer.php'; ?>