<?php include 'include/header.php'; ?>

<div class="col-md-12 text-left">
	<ol class="col-md-12 breadcrumb">
		<li>
			<a href="#">Home</a>
		</li>
		<li>
			<a href="#">Goods and Services Tax</a>
		</li>		
	</ol>
</div>

<div class="col-md-8 col-sm-12 col-xs-12 wrapper">
	
	<div class="inneContent">
		<div class="title">
	        <h4>Goods and Services Tax (GST) </h4>
	       
	     </div>

	     <div class="content">
		     
             <ul class="gst">
             	<li><a href="https://gjepc.org/admin/Circulars/427546299_GST%20FAQs.pdf" target="_blank">GST FAQs</a></li>
                <li><a href="member_gst.php" >Member GST</a></li>
                <li><a href="https://gjepc.org/gst_cust.php" >GST Enquiry</a></li>
             </ul>
             
             
		          	
	     </div>

	 </div>

</div>

<div class="col-md-4 col-sm-12 col-xs-12">

	<div class="innerContent">
		
		<div class="widget">
			<div class="title">
		        <h4>What's New</h4>
		    </div>
		    <div>
		    	<ul class="whtsdLinks">
		    		<li><a href="#">Facility Circular for ems exports at Chennai Airport</a></li>
		    	</ul>
		    </div>	
		</div>

		<div class="widget">
			<div class="title">
		        <h4>Related Links</h4>
		    </div>
		    <div>
		    	<ul class="reltdLinks">
					<li><a href="about_us.php">GJEPC</a></li>
					<li><a href="mission_and_vision.php"> Mission &amp; Vision Statement</a></li>
					<li><a href="india_center.php">India Centre</a></li>		    		
					<li><a href="#" class="show_hide sub_link">Committees</a>
					<div class="slidingDiv">
						<a href="coa.php">COA</a>
						<a href="sub_committee.php"> Sub-Committees</a>
					</div>
					</li>
					<li><a href="pdf/Code_of_Ethics_GJEPC_Version_2011.pdf" target="_blank">Code of Ethics</a></li>
		    	</ul>
		    </div>	
		</div>

		<?php include 'include/newsletter.php';?>
		
	</div>

</div>


<div class="col-md-12">
	<div class="row mainRow">
		<div class="col-md-12">
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

<style>
	.gst {width:100%; margin-top:10px;}
	.gst li{width:100%; background:url(images/gst_list_icn.png) no-repeat left center; padding-left:35px; margin-bottom:25px; font-size:16px;}
</style>