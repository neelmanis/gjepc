<?php 
include 'include/header.php';
include 'db.inc.php'; 
?>
<section>

<div class="banner_wrap mb">
	<?php include 'include/inner_banner.php'; ?>
        
	<ul class="d-flex breadcrumb">
		<li><a href="index.php">Home</a></li>
      	<li class="active">Circulars To Member</li>
	</ul>    

</div>

<div class="container inner_container">
	
    <div class="row justify-content-center mb">
		
        <div class="col-12">
			<div class="innerpg_title">
          		<h1>Circulars To Member</h1>
       		</div>
		</div>

	     <div class="col-12">
                      
                <!--<div class="filter sorter">
                    <select class="filters-select form-control">
                        <option value="*">Show all</option>
						<option value=".year-2017-2018">2017-2018</option>
                        <option value=".year-2016-2017">2016-2017</option>
                        <option value=".year-2015-2016">2015-2016</option>
                        <option value=".year-2014-2015">2014-2015</option>
                        <option value=".year-2013-2014">2013-2014</option>
                        <option value=".year-2012-2013">2012-2013</option>
                        <option value=".year-2011-2012">2011-2012</option>
                        <option value=".year-2010-2011">2010-2011</option>
                        <option value=".year-2009-2010">2009-2010</option>
                    </select>
                </div>--> 
                
                
			<div class="row justify-content-end">
                <!--<div class="col-md-3">
                <select id="select_box" class="form-control">
                	<option value="2017-2018">2017-2018</option>
                        <option value="2016-2017">2016-2017</option>
                        <option value="2015-2016">2015-2016</option>
                        <option value="2014-2015">2014-2015</option>
                        <option value="2013-2014">2013-2014</option>
                        <option value="2012-2013">2012-2013</option>
                        <option value="2011-2012">2011-2012</option>
                        <option value="2010-2011">2010-2011</option>
                        <option value="2009-2010">2009-2010</option>
                  
                </select>
                </div>-->
                
                </div>          
            
                <ul id="masonry-list">
                	<?php
					$sql="SELECT * FROM `circulars_category` WHERE 1 and status='1' order by order_no desc";
					$result = $conn ->query($sql);
					while($rows = $result->fetch_assoc())	{?>                    
                     <div class="sub_head blue"><?php echo $rows['cat_name'];?></div>
                    <li class=" item year-<?php echo $rows['cat_name'];?>">
                   
                    <div class="circular row">
					<?php 
					$sql2="SELECT * FROM `circulars_to_member_master` WHERE 1 and status='1' and set_archive='0' and cat_id='$rows[id]' order by post_date desc";
					$result2 = $conn ->query($sql2);
					while($rows2 = $result2->fetch_assoc()){ ?>		
                    
                    <div class="col-lg-4 col-md-4  col-sm-6 mb-4">				
                       	<a href="admin/Circulars/<?php echo $rows2['upload_circulars'];?>" target="_blank" class="pdf_wrp">
                       	<span><?php echo $rows2['post_date'];?></span> 
                        <div class="circular_text"><?php echo stripslashes($rows2['name']);?></div>
                        <div class="clearfix"></div> 
                        </a> 
                        </div>
						<?php } ?>
                        </div>
					<?php } ?>	                                              
                    </li>
                </ul>
			 </div> 
	     </div>	
	</div>
</div>

<?php include 'include/footer.php'; ?>