<?php 
$pageTitle = "Gems & Jewellery Industry | Gem & Jewellery Trade Update Report (Quarterly) - GJEPC India";
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
				Gem & Jewellery Trade Update Report (Quarterly)</h1>
			</div>
		</div>

		<div class="card-body" style="margin-bottom: 3rem">                                                     
                                                
            <ul class="row">  

                <li class="col-md-4 px-2">
                    <a href="pdf/GJ-Trade-Trends-Annual-report-2021-22.pdf" target="_blank" class="new_pdf_wrp">Gem & Jewellery Trade Trends - April - March 2022 </a>
                </li>

                <li class="col-md-4 px-2">
                    <a href="pdf/G&J-Trade-Trends-April-December-2021-Report.pdf" target="_blank" class="new_pdf_wrp">Gem & Jewellery Trade Trends - April - December 2021 </a>
                </li>

                <li class="col-md-4 px-2">
                    <a href="pdf/Gem-and-Jewellery-Trade-Trends-half-Report-April-september-2021.pdf" target="_blank" class="new_pdf_wrp">Gem & Jewellery Trade Trends - Half Yearly Report - April September 2021</a>
                </li>

                <li class="col-md-4 px-2">
                    <a href="pdf/Gem-and-Jewellery-Trade-Trends-Quarterly-Report-April-June-2021.pdf" target="_blank" class="new_pdf_wrp">Gem & Jewellery Trade Trends - Quarterly Report April - June 2021</a>
                </li>

                <li class="col-md-4 px-2">
                    <a href="pdf/Gem- Jewellery-Trade-Trends-Quarterly-Report-April-December-2020.pdf" target="_blank" class="new_pdf_wrp">Gem & Jewellery Trade Trends - Quarterly Report April-December 2020</a>
                </li>                                               
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