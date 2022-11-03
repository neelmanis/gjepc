<?php 
include 'include/header.php';
include 'db.inc.php'; 
include('functions.php');
?>
<?php
$id=mysql_real_escape_string($_REQUEST['id']);
$sql="select * from `news_master` WHERE 1 and status='1' and id='$id'";
$result=mysql_query($sql);
$rows=mysql_fetch_array($result);
// print_r($rows);
?>

<div class="col-md-8 col-sm-12 col-xs-12 wrapper">
	
	<div class="inneContent">
		<div class="title">
	        <h4>News</h4>
	     </div>

	     <div class="content">
		     <!-- <h5 class="ab_title">Leading From the Front</h5> -->
		     <div class="ab_description">
	             <div class="news_contentdetail">
	             
	             <h5><?php echo stripslashes($rows['name']);?></h5>
				 <div class="date_social">	
		             <div class="date">
		             	<p style="border:none;"><?php echo date("M d, Y",strtotime($rows['post_date']));?></p>
		             </div>
		             <div class="clear"></div> 
	             </div>
	             <p><span><img src="../admin/images/news_images/<?php echo $rows['news_pic']; ?>" width="40%" align="left" style="padding:10px; padding-left:0px;"/></span><?php echo stripslashes($rows['long_desc']);?></p>
	             </div>
			 </div>     	
	     </div>
	</div>

</div>

<div class="col-md-4 col-sm-12 col-xs-12">

	<div class="innerContent">
		<div class="widget">
			<div class="title">
		        <h4>Latest news</h4>
		    </div>
		    <div>
		    	<ul class="reltdLinks">
		        <?php 
		        $query_news = "select * from news_master where section!=0 & status='1' order by section asc limit 10";
		        $result_news = mysql_query($query_news);
		        while($row_news = mysql_fetch_array($result_news))
		        {
		        ?>		    	
		    		<li><a href="news_detail.php?id=<?php echo $row_news['id'];?>"> <?php echo stripslashes(substr($row_news['name'],0,100));?> </a></li>
		    	<?php } ?>
		    	</ul>
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