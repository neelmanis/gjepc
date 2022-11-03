<?php 
include 'include/header.php'; 

if(!isset($_SESSION['USERID'])){header('location:login.php');}
$uid=$_SESSION['USERID'];
include 'db.inc.php';
include 'functions.php';
?>

	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="title">
			<h4>GJEPC Annual Report</h4>
		</div>
	</div>

	<div class="col-md-4 col-sm-4 col-xs-12 wrapper selectedSpeaker">
		<?php include 'include/regMenu.php'; ?>
	</div>

	<div class="col-md-8 col-sm-8 col-xs-12 speakerSelector">
	
	<ul id="masonry-list" class="circular_wrap">
					
	    <li class="item year-2018-02-19">                                                   

	        <div class="circular">
				
	            <a href="pdf/GJEPC_Annual_report_2016-17.pdf" target="_blank">
	                <div class="circular_text">GJEPC Annual Report 2017-18</div>
	                <div class="clearfix"></div> 
	            </a>
				
	        </div>

	        <div class="circular">
				
	            <a href="pdf/NOTICE%20OF%2051ST%20AGM%20COMP.PDF" target="_blank">
	                <div class="circular_text">51st Annual General Meeting</div>
	                <div class="clearfix"></div> 
	            </a>
				
	        </div>   
		</li>
                 
                 </ul>	
		
	</div>


<?php include 'include/footer.php'; ?>