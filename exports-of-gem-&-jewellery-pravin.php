<?php 
$pageTitle = "Gems & Jewellery Industry | EXPORTS OF GEM & JEWELLERY - GJEPC India";
$pageDescription  = "The Gem and Jewellery Export promotion Council (GJEPC) is an Apex body in India for Gems and Jewellery Sector
since year 1966, and is sponsored by Ministry of Commerce and Industry, Government of India";
?>
<?php
include 'include-new/header.php';
include 'db.inc.php'; 
?>
<section>
    
	<div class="container inner_container">

		<div class="row justify-content-center mb-0 mt-3">
			<div class="col-12 text-center">
				<h1 class="bold_font"><div class="d-block"><img src="assets/images/gold_star.png"></div>
				EXPORTS OF GEM & JEWELLERY</h1>
			</div>
		</div>

		<div class="col-2 mb-3" style="margin: 0 auto;">
			<div class="year_box">
				<select data-switch="export" class="select_box">
					<option value="export_2021">2021</option>
					<option value="export_2020">2020</option>
					<option value="export_2019">2019</option>
				</select>
			</div>
		</div> 
		
		<div id="export_2021" class="export_hide statistic_Box" style="margin-bottom: 3rem">                                        
			<ul class="row p-3">
				<?php
				$sql2="SELECT name,upload_statistics_export FROM `statistics_export_master` WHERE 1 and status='1' and set_archive='0' and year='2021' order by post_date desc";
				$result2= $conn ->query($sql2);
				$export_cnt= $result2->num_rows;
				if($export_cnt>0){
				while($rows2 = $result2->fetch_assoc()){ ?>
				<li class="col-md-6 px-2">
				<a target="_blank" href="admin/StatisticsExport/<?php echo $rows2['upload_statistics_export'];?>" class="new_pdf_wrp"><?php echo $rows2['name'];?></a>
				</li>
				<?php }
				}
				?>
			</ul>                                        
		</div>
	</div>

</section>
<!-- <style>
	.new_pdf_wrp:after{
		background: url("https://gjepc.org/assets/images/gold_star.png") norepeat;
	}
</style> -->
<?php include 'include-new/footer.php'; ?>

<script>
$(document).ready(function(){
	$("#search").on("keydown",function(){
		var search = $("#search").val();
		var cat_id = $("#cat_id2").val();
		if(search != ""){
	$.ajax({
          type: "POST",
          url: "ajax.php",
		  data: "actiontype=chkdata&search="+search+"&cat_id="+cat_id,
          success: function(result){
			  $("#result").show();
			$("#result").html(result);
          }
          });
		 } else { $("#result").show(); console.log("search val was empty"); }
		});
	});
</script>
<!-- Govt Circulars  -->
<script>
$(document).ready(function(){
	$("#gsearch").on("keydown",function(){
		var gsearch = $("#gsearch").val();
		var govt_id = $("#govt_id").val();
		if(gsearch != ""){
	$.ajax({
          type: "POST",
          url: "ajax.php",
		  data: "actiontype=chkgdata&gsearch="+gsearch+"&govt_id="+govt_id,
          success: function(result){
			  $("#gresult").show();
			$("#gresult").html(result);
          }
          });
		 } //else { $("#gresult").show(); console.log("search val was empty"); }
		});
	});
</script>

<script>
$('#select_box').change(function () {
var select=$(this).find(':selected').val();        
 $(".hide").hide();
 $('#' + select).show();
	    }).change();
</script>