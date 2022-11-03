<?php 
include 'include-new/header.php';
include 'db.inc.php';
?>

<section>

	<div class="container inner_container py-5">
		<div class="row mb">
        
			

            <div class="col-12 bold_font text-center d-block"> <div class="d-block"><img src="assets/images/gold_star.png"></div> Past Seminars </div>
            
		    <div class="col-12">		
		    	<!-- <ul class="reltdLinks inner_under_listing post_seminar"> -->
		    		<ul class="row circular_wrap ab_none justify-content-between">
				<?php
				/*$currentMonth = date("m");
				$currentYear = date("Y");
				$startDate = '01-'.$currentMonth.'-'.$currentYear;
				$interval1 = date('Y-m-d h:i:s', strtotime($startDate)); //First Date of Month
				$interval2 = date('Y-m-d h:i:s'); // Current Date
				$sqlx = "SELECT * FROM seminar_calendar WHERE start between '$interval1' AND '$interval2' and status='1' order by start desc"; */
				//$sqlx = "SELECT * FROM seminar_calendar WHERE status='1' order by start desc";
				$sqlx = "SELECT * FROM seminar_calendar WHERE status='1' and end <=DATE(NOW())order by end desc";
				$resultx = $conn ->query($sqlx);
				while($rowx = $resultx->fetch_assoc()){ ?>
				<li class="col-md-6">

					<a href="seminar_detail.php?id=<?php echo $rowx['id'];?>" target="_blank" class="new_pdf_wrp h-100">
						<p class="blue"><?php echo date("d-m-Y",strtotime($rowx['start'])); ?></p>
						<div class="circular_text"><?php echo $rowx['title'];?></div>
					</a>
					</li>
					<?php } ?>
		    	</ul>
		    </div>	
		</div>	
	</div>
</section>

<?php include 'include-new/footer_stats.php'; ?>