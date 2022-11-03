<?php 
$pageTitle = "Gems & Jewellery Industry | Research Reports - GJEPC India";
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
				Research Reports</h1>
			</div>
		</div>

		<div class="card-body" style="margin-bottom: 3rem">    
            <ul class="row">   

                    <li class="col-md-6 px-2">
                        <a href="pdf/Reasons-of-fall-in-G&J-exports-2005-17.pdf" target="_blank" class="h-100 new_pdf_wrp">
                        Causes of Decline in Gem and Jewellery Exports  from India FY2005 - FY2017 
                        </a>
                    </li>    

                    <li class="col-md-6 px-2">
                        <a href="pdf/Potential-Impact-of-COVID-on-India.pdf" target="_blank" class="h-100 new_pdf_wrp">
                        A Study on Impact of Disruption of Supply Chain on India's Gem and Jewellery Exports & Ways to Mitigate the Impact
                        </a>
                    </li>

                    <li class="col-md-6 px-2">
                        <a href="pdf/A-Brief-Assessment-Section-301-and-Adverse-Impact-on-India's-G&J-Sector.pdf" target="_blank" class="h-100 new_pdf_wrp">
                        A  Brief Assessment - Section 301 and Adverse Impact on India's G&J Sector
                        </a>
                    </li>

                    <li class="col-md-6 px-2">
                        <a href="https://gjepc.org/pdf/Impact-of-COVID-19-on-GJ-Sector.pdf" target="_blank" class="h-100 new_pdf_wrp">
                        Impact of COVID-19 on G&J sector
                        </a>
                    </li>                                                        
                    <li class="col-md-6 px-2">
                        <a href="https://gjepc.org/pdf/Indian-USA-G&amp;J-Trade-Relations-w.r.t-CPD.pdf" target="_blank" class="h-100 new_pdf_wrp">India-USA G&J Trade</a>
                    </li>                                                        
                    <li class="col-md-6 px-2">
                        <a href="https://gjepc.org/pdf/Enhancing-Global-Presence-of-Jewellery-Products.pdf" target="_blank" class="h-100 new_pdf_wrp border-0">Enhancing Global Presence of Jewellery Products</a>
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