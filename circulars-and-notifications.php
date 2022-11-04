<?php 
$pageTitle = "Gems & Jewellery Industry | Circulars & Notifications - GJEPC India";
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
			Circulars & Notifications</h1>
		</div>
	</div>

	<div class="row mb-5">		
		<div class="col-12 text-center mb-4">
			<div class="form-group border-dark border d-flex my-0 mx-auto" style="line-height:40px;width:200px">
			<label class="d-inline-block mb-0 col-auto pr-0" for="selectyear">YEAR</label>
			<select class="form-control d-inline-block border-0 col" id="select_box" style="font-size:16px;color:#333">
					<?php
					$sql="SELECT id,cat_name FROM `circulars_category` WHERE 1 and status=1 order by cat_name desc";
					$result = $conn ->query($sql);
					while($rows=$result->fetch_assoc())	{	?>
					<option value="<?php echo filter($rows['id']);?>"><?php echo filter($rows['cat_name']);?></option>
					<?php } ?>
			</select>
			</div>
		</div>		
	</div>
    
	<?php
	$sqlx="SELECT id,cat_name FROM `circulars_category` WHERE 1 and status=1 order by cat_name desc";
	$resultx = $conn ->query($sqlx);
	while($rowsx=$resultx->fetch_assoc())	{	?>
		
	<div class="row hide mb-5" id="<?php echo filter($rowsx['id']);?>">        
		
		<div class="col-lg-6 pr-lg-5 mb-5">			
			<h2 class="title mb-3">Government Circulars</h2>
			<input type="text" id="gsearch" name="gsearch" class="form-control" placeholder="Search Govt Circulars here..">
			<input type="hidden" name="govt_id" id="govt_id" value="<?php echo $rowsx['id'];?>">
			
			<ul class="circular_wrap mt-4">            
            <div class="circular_slider row">
					<div id="gresult">
					<?php 
					$sql2="SELECT * FROM `circulars_to_member_master` WHERE 1 and status='1' and cat_id='$rowsx[id]' order by post_date desc";
					$result2=$conn ->query($sql2);
					while($rows2=$result2->fetch_assoc()){ ?>
                    <div class="col-12">				
				      <a href="admin/Circulars/<?php echo $rows2['upload_circulars'];?>" target="_blank" class="new_pdf_wrp">
				          <p class="blue"><?php echo $rows2['post_date'];?></p> 
				          <div class="circular_text"><?php echo filter($rows2['name']);?></div>
				      </a>				
                    </div>
					<?php } ?>                    
					</div>                   
            </div>                   
			</ul>               
		</div>
		
		<div class="col-lg-6 pl-lg-5">			
			<h2 class="title mb-3">GJEPC Circulars</h2>
				<input type="text" id="search" name="search" class="form-control" placeholder="Search GJEPC Circulars here..">
				<input type="hidden" name="cat_id" id="cat_id2" value="<?php echo $rowsx['id'];?>">
				
				<ul class="circular_wrap mt-4">
                 <div class="circular_slider row">
					<div id="result">
						<div class="col-12">
				      <a href="https://gjepc.org/emailer_gjepc/29.09.2022/index.html" target="_blank" class="new_pdf_wrp">
				          <p class="blue">2022-09-29</p> 
				          <div class="circular_text">Best export award for the performance year 2018-2019 & 2019-20</div>
				      </a>
					</div>
					<div class="col-12">
				      <a href="https://www.youtube.com/watch?v=ReCnJV1ZsyA&feature=youtu.be" target="_blank" class="new_pdf_wrp">
				          <p class="blue">2022-08-20</p> 
				          <div class="circular_text">You tube recording for online voting process of COA 2022-24 </div>
				      </a>
					</div>
					<?php 
					$sqlC="SELECT * FROM `circulars_master` WHERE 1 and status='1' and cat_id='$rowsx[id]' order by post_date desc";
					$resultC=$conn ->query($sqlC);
					while($rowsC=$resultC->fetch_assoc()){ ?>
					
					<div class="col-12">
				      <a href="admin/Circulars/<?php echo $rowsC['upload_circulars'];?>" target="_blank" class="new_pdf_wrp">
				          <p class="blue"><?php echo $rowsC['post_date'];?></p> 
				          <div class="circular_text"><?php echo filter($rowsC['name']);?></div>
				      </a>
					</div>
					
					<?php } ?>
					</div>
                </div>
				</ul>                
		</div>        
    </div>
	<?php } ?>
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

<style>
/*.circular_slider .slick-arrow {background:none; border:0; transform:inherit; position:absolute; top:-20px; right:0;}
.circular_slider .slick-arrow:before {color:#000; font-family:FontAwesome; font-size:16px;}
.circular_slider .slick-arrow.slick-prev {right:20px; left:auto;}

.circular_slider .slick-arrow.slick-prev:before {content:"\f176";}
.circular_slider .slick-arrow.slick-next:before {content:"\f175";}

.circular_slider .slick-arrow.slick-disabled:before {color:#ddd;}*/

.circular_slider {height:500px; overflow-y: scroll; }
</style>