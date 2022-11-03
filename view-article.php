<?php 
$pageTitle = "Gem & Jewellery | View Article - GJEPC India";
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
    		<li class="active">Updates</li>
  		</ul>        
    </div>

<div class="container inner_container">	
	<div class="row mb">    
		<div class="col-12">
                <div class="innerpg_title">
                    <h1>Daily Updates</h1>
                </div>
            </div>

	    <div class="content">			
            <div class="ab_description">        					
                <ul id="masonry-list" class="2">
					<?php
					$sql="SELECT `id`, `title`, `article_url` FROM `update_article` WHERE status='1' order by post_date desc";
					$result=$conn->query($sql);
					while($rows=$result->fetch_assoc())
					{	
						$id = filter($rows['id']);
						$title = filter($rows['title']); 
						$article_url=$rows['article_url']; 
					?>
                    <li class="item year-2018-02-19">                        
                        <div class="circular">							
                            <a href="<?php echo $article_url;?>" target="_blank">
                            	<!--<span>*</span>--> 
                                <div class="circular_text"><?php echo $title;?></div>
                                <div class="clearfix"></div> 
                            </a>							
                        </div>
					</li>
					<?php } ?>
                 </ul>                 
			 </div>              
	     </div>	
	</div>
</div>
</section>
<?php include 'include/footer.php'; ?>

<style>
.wrapper {border-right:none;}
.ab_description ul li {margin: 0 0 10px 20px; padding:0 0 10px 25px; border-bottom: 1px solid #ddd; background:url(https://gjepc.org/images/gst_list_icn.png) no-repeat 5px 5px; background-size:12px;}
.ab_description ul li a:hover {text-decoration:none;}
</style>
