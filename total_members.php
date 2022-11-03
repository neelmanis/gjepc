<?php include 'include/header.php'; ?>

<div class="col-md-12 text-left">
	<ol class="col-md-12 breadcrumb">
		<li>
			<a href="#">Home</a>
		</li>
		<li>
			<a href="#">Members</a>
		</li>
		<li class="active">TOTAL MEMBERS</li>
	</ol>
</div>

<div class="col-md-8 col-sm-12 col-xs-12 wrapper">
	
	<div class="inneContent">
		<div class="title">
	        <h4>total members</h4>
	     </div>

	     <div class="content">
		     <!-- <h5 class="ab_title">Leading From the Front</h5> -->
		     <div class="ab_description">
			    	<div class="table_job" id="no-more-tables-job">
                  
                                            
                    <table class="table-bordered-job table-striped table-condensed-job cf">
                  <thead>
                      <tr>
                          <th> Region Code  </th>
                          <th> Total Members 2013-14 </th>
                          <th> Total Members 2012-13</th>
                          <th> % growth in Members</th>
                      </tr>
                  </thead>
                    <tbody>
                    
                    <tr>
                        <td data-title="Region Code">MUMBAI</td>
                        <td data-title="Total Members 2013-14">2672 </td>
                        <td data-title="Total Members 2012-13">2528 </td>
                        <td data-title="% growth in Members">5.70</td>
                    </tr>
                    <tr>
                        <td data-title="Region Code">CHENNAI</td>
                        <td data-title="Total Members 2013-14">500</td>
                        <td data-title="Total Members 2012-13">408</td>
                        <td data-title="% growth in Members">22.55</td>
                    </tr>
                    <tr>
                        <td data-title="Region Code">DELHI</td>
                        <td data-title="Total Members 2013-14">858</td>
                        <td data-title="Total Members 2012-13">758</td>
                        <td data-title="% growth in Members">13.19</td>
                    </tr>
                    <tr>
                        <td data-title="Region Code">JAIPUR</td>
                        <td data-title="Total Members 2013-14">947</td>
                        <td data-title="Total Members 2012-13">902</td>
                        <td data-title="% growth in Members">4.99</td>
                    </tr>
                    <tr>
                        <td data-title="Region Code">KOLKATA</td>
                        <td data-title="Total Members 2013-14">191</td>
                        <td data-title="Total Members 2012-13">187</td>
                        <td data-title="% growth in Members">2.14</td>
                    </tr>
                    <tr>
                        <td data-title="Region Code">SURAT</td>
                        <td data-title="Total Members 2013-14">548</td>
                        <td data-title="Total Members 2012-13">404</td>
                        <td data-title="% growth in Members">35.64</td>
                    </tr>
                    <tr class="grand_total">
                        <td data-title="Region Code">Grand Total</td>
                        <td data-title="Total Members 2013-14">5716</td>
                        <td data-title="Total Members 2012-13">5187</td>
                        <td data-title="% growth in Members">10.20</td>
                    </tr>
                     
                    </tbody>
              </table> 
                    <div class="clear"></div>                    
        	</div>
                 		<p><img src="images/total_member.jpg" width="100%"></p>
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