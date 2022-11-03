<?php 
$pageTitle = "Webinar";
$pageDescription  = "Gem Jewellery Export Promotion Council (GJEPC) is Indias Apex body supported by the ministry of commerce and industry.";
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
			GJEPC Webinar</h1>
		</div>
	</div>

	<div class="row ab_none  justify-content-between mb-5">
    	<div class="col-12 col-md-8 pr-5 webnarDetails">
        	<div class="pic"><img src="assets/images/webinar/new_1.jpg" class="img-fluid d-block mb-3"></div>
            
            <h2 class="webinarTitle mb-5">Leveraging Cross Border E-Commerce With Amazon</h2>
            
            <div class="mb-5">
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
            </div>
            
            <div class="subTitle mb-4">AGENDA :</div>
            
            <ul class="agendaPoints mb-5">
            	<li>Impact of Covid-19 on Jewellery in india and the rise of e-commerce.</li>
                <li>What is Global selling?</li>
                <li>Why Global selling during these uncertain times?</li>
                <li>Amazon Global Selling and its focus on MSME.</li>
                <li>How can the offline sellers be a part of Global Selling.</li>
            </ul>
            
            <div class="webinarInfo">
            <div class="row ab_none justify-content-between mb-4">
                <div class="col">
                    <div class="speaker d-flex h-100">
                    <div class="align-self-center">
                    <div class="headT mb-2">SPEAKER :</div>
                    <div class="speakerName">Nickhie Antony <span>(Manager, Amazon)</span></div>
                    <div class="speakerName">Ram Sharma <span>(Manager, Amazon)</span></div>
                    </div>
                    </div>
                </div>
                <div class="col pl-5">
                    <div class=" d-flex h-100">
                    <div class="align-self-center">
                    <div class="d-block webinarDay mb-2 goldBg">Friday 7 Aug, 2020</div>
                    <div class="d-block webinarDay blackBg">04.00 PM</div>
                    </div>
                    </div>
                </div>
            </div>
            </div>
            
        </div>
        
        <div class="col-12 col-md-4 " >
        	<form class="webinarRegister">
            	<h3>register</h3>
                <div class="form-group">
                	<input type="text" class="form-control mb-2" placeholder="Name" />
                    <input type="email" class="form-control mb-2" placeholder="Email" />
                    <input type="text" class="form-control mb-2" placeholder="Mobile No." />
                    <input type="text" class="form-control mb-2" placeholder="Company Name" />
                    <input type="text" class="form-control mb-2" placeholder="Category" />
                    <button class="form-control text-center">SUBMIT</button>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
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

