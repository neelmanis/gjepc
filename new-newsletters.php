<?php 
$pageTitle = "Gem & Jewellery | Newsletter - GJEPC India";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
?>
<?php 
include 'include-new/header.php';
include 'db.inc.php'; 
?>
<section>

	<div class="container mb position-relative inner_banner">
        <img src="assets/images/inner_banner/demo_banner.jpg" class="img-fluid d-block" /> 
        <div class="innerpg_title">
            <div class="d-flex h-100">
                <div class="my-auto"><h1>Newsletters</h1></div>
            </div>
        </div>
	</div>
    
    <div class="container">	
    	
        <div class="row mb grid_gallery" data-spy="scroll" data-target=".nav-tabs" data-offset="50">        
        	
            	<div class="col-12"  id="nav" data-sticky_parent>
                   	
                <ul id="tabs" class="nav nav-tabs justify-content-center d-flex" role="tablist" data-sticky_column>
					<?php
					$sql="SELECT * FROM `newsletter_master` WHERE status=1 group by year order by year desc";
					$result=$conn->query($sql);
					//if(!$result) die ($conn->error); exit;
					while($rows=$result->fetch_assoc())
					{	
						$id = filter($rows['id']);
						$year = filter($rows['year']);
					?> 	
                    <li class="nav-item">
                    <a id="tab-<?php echo $id;?>" href="#pane-<?php echo $id;?>" class="nav-link active" data-toggle="tab" role="tab"><?php echo $year;?></a>
                    </li>  
					<?php } ?>
					       
        			
                        <!--<li class="nav-item">
                            <a id="tab-A" href="#pane-A" class="nav-link active" data-toggle="tab" role="tab"><?php echo $year;?></a>
                        </li>  
						<li class="nav-item">
                            <a id="tab-B" href="#pane-B" class="nav-link" data-toggle="tab" role="tab">2019</a>
                        </li>
                    
                        <li class="nav-item">
                            <a id="tab-C" href="#pane-C" class="nav-link" data-toggle="tab" role="tab"> 2018</a>
                        </li>
        			
                        <li class="nav-item">
                            <a id="tab-D" href="#pane-D" class="nav-link" data-toggle="tab" role="tab">2017</a>
                        </li>
                 
                        <li class="nav-item">
                            <a id="tab-E" href="#pane-E" class="nav-link" data-toggle="tab" role="tab">2016</a>
                        </li>
                    
        				<li class="nav-item">
                            <a id="tab-F" href="#pane-F" class="nav-link" data-toggle="tab" role="tab">2015</a>
                        </li>-->
                                  
                </ul>
                
                </div>

				<div id="content" class="col-12 tab-content" role="tablist">
								<?php
								$sql="SELECT * FROM `newsletter_master` WHERE status=1 group by year order by year desc";
								$result=$conn->query($sql);
								//if(!$result) die ($conn->error); exit;
								while($rows=$result->fetch_assoc())
								{	
									$id = filter($rows['id']);
									$year = filter($rows['year']);
									$name = filter($rows['name']); 
								?>
                    <div id="pane-<?php echo $id;?>" class="card tab-pane fade show <?php if($year==2020){?>active<?php } ?>" role="tabpanel" aria-labelledby="tab-<?php echo $id;?>">
                    
            			<div class="card-header" role="tab" id="heading-<?php echo $id;?>">
                			<h5 class="mb-0">
                    			<a data-toggle="collapse" href="#collapse-<?php echo $id;?>" aria-expanded="true" aria-controls="collapse-<?php echo $id;?>"><?php echo $year;?></a>
                			</h5>
            			</div>

                        <div id="collapse-<?php echo $id;?>" class="collapse show" data-parent="#content" role="tabpanel" aria-labelledby="heading-<?php echo $id;?>">
                			
                            <div class="card-body">
                            
                            	<ul id="masonry-list" class="circular_wrap row">
                	                    <!--<div class="col-12"><p class="blue">Year <?php echo $year;?></p></div>-->
										<?php
                            $sqlx="SELECT `id`, `post_date`, `name`, `html_files` FROM `newsletter_master` WHERE year=".$year." order by post_date desc";
                            $resultx=$conn->query($sqlx);
                            while($rowx=$resultx->fetch_assoc())
                            { ?>
							<li class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4"> <a href="<?php echo $rowx['html_files'];?>" target="_blank" class="pdf_wrp">
							<?php echo stripslashes($rowx['name']);?></a></li>
							<?php } ?>
							              
							</ul>                			
                            </div>                            
            			</div>        			
                    </div>
					<?php } ?>

                    </div>
                </div>    		
            </div>
    
    </div>

</section>
<?php include 'include-new/footer.php'; ?>