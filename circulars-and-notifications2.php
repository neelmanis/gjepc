<?php 
$pageTitle = "Circulars & Notifications - GJEPC India";
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
		
		<div class="col-lg-6 pr-lg-5">			
			<h2 class="title mb-3">Government Circulars</h2>
			<div class="circular_wrap mb-4">
            
            <div class="circular_slider row">
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
		</div>
		
		<div class="col-lg-6 pl-lg-5">			
			<h2 class="title mb-3">GJEPC Circulars</h2>
				<input type="text" id="search" name="search" class="form-control">
				<input type="hidden" name="cat_id" id="cat_id2" value="<?php echo $rowsx['id'];?>">
				<ul class="circular_wrap">
                 <div class="circular_slider row">
					<div id="result">
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
	// search = $("#search").val();
	// search.keyup(function(){
	// 	//$("#result").hide();
		
	// $.ajax({
 //          type: "POST",
 //          url: "ajax.php",
 //          data: "searchkey=data_from_user_input",
	// 	  data: "actiontype=chkdata&search="+search,
 //          success: function(result){
	// 		  $("#result").show();
	// 		$("#result").html(result);
 //          }
 //          });
	// }); 
	$("#search").on("keydown",function(){
		var input =$(this).val();
		var actiontype ="chkdata";
		var cat_id = $("#cat_id2").val();
		
         $.ajax({
          type: "POST",
          url: "ajax.php",
          //data: "searchkey=data_from_user_input",
		  data: {actiontype:actiontype,search:input,cat_id:cat_id},
          success: function(result){
			  $("#result").show();
			$("#result").html(result);
          }
          });
	

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