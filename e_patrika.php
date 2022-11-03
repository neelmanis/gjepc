<?php include 'include/header.php'; ?>

<div class="col-md-12 text-left">
	<ol class="col-md-12 breadcrumb">
		<li>
			<a href="#">Home</a>
		</li>
		<li>
			<a href="#">E - Patrika</a>
		</li>
	</ol>
</div>
<div class="col-md-8 col-sm-12 col-xs-12 wrapper">
	
	<div class="inneContent">
		<div class="title">
	        <h4>E - Patrika</h4>
	     </div>

	     <div class="content">
		     <!-- <h5 class="ab_title">Leading From the Front</h5> -->
		     <div class="ab_description">
             <ul class="connect_img">
             <li> <a href="pdf/1dec14newsletter.pdf" target="_blank">1 Dec, 2014</a> </li>

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
		    	<ul class="reltdLinks">
		    		<li><a href="#">Fortnightly E-Newsletter</a></li>
		    		<li><a href="e_patrika.php">E-Patrika</a></li>
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