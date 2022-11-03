<?php 
include 'include/header.php';
include 'db.inc.php'; 
?>
<div class="col-md-12 text-left">
	<ol class="col-md-12 breadcrumb">
		<li>
			<a href="#">Home</a>
		</li>
		<li>
			<a href="#">CIRCULARS AND NOTIFICATIONS</a>
		</li>
	</ol>
</div>

<div class="col-md-8 col-sm-12 col-xs-12 wrapper">
	
	<div class="inneContent">
		<div class="title">
	        <h4>circulars and notifications</h4>
	     </div>

	     <div class="content">
		     <!-- <h5 class="ab_title">Leading From the Front</h5> -->
		     <div class="ab_description">                	
                      
                <div class="filter sorter">
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
                </div>
           
            
                <ul id="masonry-list" class="circular_wrap">
                    <?php
					$sql="SELECT * FROM `circulars_category` WHERE 1 and status=1 order by id desc";
					$result=mysql_query($sql);
					while($rows=mysql_fetch_array($result))
					{
					?>
					<li class="item year-<?php echo $rows['cat_name'];?>">
                    	<div class="sub_head"><?php echo $rows['cat_name'];?></div>
                        <div class="circular">
						<?php 
							$sql2="SELECT * FROM `circulars_master` WHERE 1 and status='1' and set_archive='0' and cat_id='$rows[id]' order by post_date desc";
							$result2=mysql_query($sql2);
							$i=0;
							while($rows2=mysql_fetch_array($result2))
							{							
						?>						
                        	<a href="admin/Circulars/<?php echo $rows2['upload_circulars'];?>" target="_blank">
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

<div class="col-md-4 col-sm-12 col-xs-12">

	<div class="innerContent">
		<div class="widget">
			<div class="title">
		        <h4>Related Links</h4>
		    </div>
		    <div>
            	<?php include 'include/members_links.php'; ?>
		    </div>	
		</div>

		<?php include 'include/newsletter.php';?>
		
	</div>

</div>


<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="row mainRow">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="title">
	        	<h4>videos on the Indian industry :</h4>
	      	</div>
		</div>
		<div class="col-md-4">
			<div class="embed-responsive embed-responsive-16by9">
				<iframe width="420" height="315" class="embed-responsive-item" src="https://www.youtube.com/embed/ZUp6X8BXF6Q?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
			</div>
			<h5 class="videoTitle text-center">India Your First Choice</h5>
		</div>
		<div class="col-md-4">
			<div class="embed-responsive embed-responsive-16by9">
				<iframe width="420" height="315" class="embed-responsive-item" src="https://www.youtube.com/embed/b7C12-07OTc?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
			</div>
			<h5 class="videoTitle text-center">India – Where Diamonds Come Alive!</h5>
		</div>
		<div class="col-md-4">
			<div class="embed-responsive embed-responsive-16by9">
				<iframe width="420" height="315" class="embed-responsive-item" src="https://www.youtube.com/embed/BmsTKUCEWZo?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
			</div>
			<h5 class="videoTitle text-center">Jewellers for Hope</h5>
		</div>
	</div>

	<div class="row mainRow">
		<div class="col-md-12">
			<div class="upcomingEvents">
		        <div class="title">
		          <h4>Upcoming Events</h4>
		        </div>
		         <?php include 'include/eventsslider.php'; ?>
	      </div>
		</div>
	</div>	
</div>

<?php include 'include/footer.php'; ?>



