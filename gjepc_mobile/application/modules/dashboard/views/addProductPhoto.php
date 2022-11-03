<?php 
//echo "<pre>"; print_r($productConditionImage);

	 if($before=='') 
	 { ?> 
 
		 <div class="form-group row">
				<form id="imageuploadArrival">
				 
				  <label class="col-xs-12 control-label">Product on Arrival</label>
				  <div class="validError">
			  </div>
				  <div class="col-xs-6 col-md-3">
					<div class="uploadImg"> <a href="" onclick="document.getElementById('upload1').click(); return false" class="add"id="1"></a>
					
					  <input id="upload1" type="file" class="hiddenFile uploadsProductArrival" name="upload1" data-srcid="up1">
					  <img src="<?php echo  base_url();?>assets/images/uploadDefault.jpg" id="up1"> </div>
				  </div>
				  <div class="col-xs-6 col-md-3">
					<div class="uploadImg"> <a href="" onclick="document.getElementById('upload2').click(); return false" class="add"id="2"></a>
					  <input id="upload2" type="file" class="hiddenFile uploadsProductArrival" name="upload2" data-srcid="up2">
					  <img src="<?php echo  base_url();?>assets/images/uploadDefault.jpg" id="up2"> </div>
				  </div>
				  <div class="col-xs-6 col-md-3">
					<div class="uploadImg"> <a href="" onclick="document.getElementById('upload3').click(); return false" class="add"id="3"></a>
					  <input id="upload3" type="file" class="hiddenFile uploadsProductArrival" name="upload3" data-srcid="up3">
					  <img src="<?php echo  base_url();?>assets/images/uploadDefault.jpg" id="up3"> </div>
				  </div>
				  <div class="col-xs-6 col-md-3">
					<div class="uploadImg"> <a href="" onclick="document.getElementById('upload4').click(); return false" class="add"id="4"></a>
					  <input id="upload4" type="file" class="hiddenFile uploadsProductArrival" name="upload4" data-srcid="up4" >
					  <img src="<?php echo  base_url();?>assets/images/uploadDefault.jpg" id="up4"> </div>
				  </div>
				   <div class="col-xs-6 col-md-3">
					<div class="uploadImg"> <a href="" onclick="document.getElementById('upload5').click(); return false" class="add"id="5"></a>
					  <input id="upload5" type="file" class="hiddenFile uploadsProductArrival" name="upload5" data-srcid="up5" >
					  <img src="<?php echo  base_url();?>assets/images/uploadDefault.jpg" id="up5"> </div>
				  </div>
				  <input type="hidden" name="orderItemId" value="<?php echo $orderItemId; ?>" />
				  <input type="hidden" name="renterId" value="<?php //echo $renterId; ?>" />
				   <input type="hidden" name="type" value="borrower-arrival" />
				  <div class="form-group text-center">
					<input type="submit" class="btn" value="Upload All" >
				 </div>
				</form>	
            </div>
  <?php  }	
//-------------------------------------------------------------------------------------------------------------------------
if($before!='') 
	 { ?> 
 
		 <div class="form-group row">
			<label class="col-xs-12 control-label">Product on Arrival</label>
				<?php 
				
				foreach($productConditionImage as $img)
				{ 
				 if($img->isBefore==1)
				 {
				?>
				<?php if($img->image1!='') 
				{ ?>
					<div class="col-xs-6 col-md-3">	
						<div class="uploadImg">				
						<img src="<?php echo  base_url();?>uploads/users/<?php echo $regId ?>/products/before/<?php echo $img->image1; ?>" id="up1"> </div>
					</div>
				<?php } ?>
					
					<?php if($img->image2!='') 
				{ ?>
					<div class="col-xs-6 col-md-3">	
						<div class="uploadImg">				
						<img src="<?php echo  base_url();?>uploads/users/<?php echo $regId ?>/products/before/<?php echo $img->image2; ?>" id="up1"> </div>
					</div>
				<?php } ?>
					
					<?php if($img->image3!='') 
				{ ?>
					<div class="col-xs-6 col-md-3">	
						<div class="uploadImg">				
						<img src="<?php echo  base_url();?>uploads/users/<?php echo $regId ?>/products/before/<?php echo $img->image3; ?>" id="up1"> </div>
					</div>
				<?php } ?>
					
					<?php if($img->image4!='') 
				{ ?>
					<div class="col-xs-6 col-md-3">	
						<div class="uploadImg">				
						<img src="<?php echo  base_url();?>uploads/users/<?php echo $regId ?>/products/before/<?php echo $img->image4; ?>" id="up1"> </div>
					</div>
				<?php } ?>
					
					<?php if($img->image5!='') 
				{ ?>
					<div class="col-xs-6 col-md-3">	
						<div class="uploadImg">				
						<img src="<?php echo  base_url();?>uploads/users/<?php echo $regId ?>/products/before/<?php echo $img->image5; ?>" id="up1"> </div>
					</div>
				<?php } ?>
		<?php	
				 }
				} ?>
				
				  
			</div>
  <?php  }	?>




  
   <?php  if($after=='') 
	 { ?>        
		  <div class="form-group row">
				<form id="imageuploadDeparture">
				
				  <label class="col-xs-12 control-label">Product on Departure</label>
				  <div class="validError">
			  </div>
				  <div class="col-xs-6 col-md-3">
					<div class="uploadImg"> <a href="" onclick="document.getElementById('upload6').click(); return false" class="add"id="6"></a>
					 <!-- <div class="title">Cover Photo</div>-->
					  <input id="upload6" type="file" class="hiddenFile uploadsProductDeparture" name="upload6" data-srcid="up6">
					  <img src="<?php echo  base_url();?>assets/images/uploadDefault.jpg" id="up6"> </div>
				  </div>
				  <div class="col-xs-6 col-md-3">
					<div class="uploadImg"> <a href="" onclick="document.getElementById('upload7').click(); return false" class="add"id="7"></a>
					  <input id="upload7" type="file" class="hiddenFile uploadsProductDeparture" name="upload7" data-srcid="up7">
					  <img src="<?php echo  base_url();?>assets/images/uploadDefault.jpg" id="up7"> </div>
				  </div>
				  <div class="col-xs-6 col-md-3">
					<div class="uploadImg"> <a href="" onclick="document.getElementById('upload8').click(); return false" class="add"id="8"></a>
					  <input id="upload8" type="file" class="hiddenFile uploadsProductDeparture" name="upload8" data-srcid="up8">
					  <img src="<?php echo  base_url();?>assets/images/uploadDefault.jpg" id="up8"> </div>
				  </div>
				  <div class="col-xs-6 col-md-3">
					<div class="uploadImg"> <a href="" onclick="document.getElementById('upload9').click(); return false" class="add"id="9"></a>
					  <input id="upload9" type="file" class="hiddenFile uploadsProductDeparture" name="upload9" data-srcid="up9" >
					  <img src="<?php echo  base_url();?>assets/images/uploadDefault.jpg" id="up9"> </div>
				  </div>
				  <div class="col-xs-6 col-md-3">
					<div class="uploadImg"> <a href="" onclick="document.getElementById('upload10').click(); return false" class="add"id="10"></a>
					  <input id="upload10" type="file" class="hiddenFile uploadsProductDeparture" name="upload10" data-srcid="up10" >
					  <img src="<?php echo  base_url();?>assets/images/uploadDefault.jpg" id="up10"> </div>
				  </div>
				   <input type="hidden" name="orderItemId" value="<?php echo $orderItemId; ?>" />
				  <input type="hidden" name="renterId" value="<?php //echo $renterId; ?>" />
				   <input type="hidden" name="type" value="borrower-departure" />
				  <div class="form-group text-center">
					<input type="submit" class="btn" value="Upload All" >
				 </div>
				</form>	
            </div>
	 <?php  }  

//-------------------------------------------------------------------------------------------------------------------------
if($after!='') 
	 { ?> 
 
		 <div class="form-group row">
			<label class="col-xs-12 control-label">Product on Departure</label>
				<?php 
				
				foreach($productConditionImage as $img)
				{ 
				if($img->isBefore==0)
				 {
				?>
				<?php if($img->image1!='') 
				{ ?>
					<div class="col-xs-6 col-md-3">	
						<div class="uploadImg">				
						<img src="<?php echo  base_url();?>uploads/users/<?php echo $regId ?>/products/after/<?php echo $img->image1; ?>" id="up1"> </div>
					</div>
				<?php } ?>
					
					<?php if($img->image2!='') 
				{ ?>
					<div class="col-xs-6 col-md-3">	
						<div class="uploadImg">				
						<img src="<?php echo  base_url();?>uploads/users/<?php echo $regId ?>/products/after/<?php echo $img->image2; ?>" id="up1"> </div>
					</div>
				<?php } ?>
					
					<?php if($img->image3!='') 
				{ ?>
					<div class="col-xs-6 col-md-3">	
						<div class="uploadImg">				
						<img src="<?php echo  base_url();?>uploads/users/<?php echo $regId ?>/products/after/<?php echo $img->image3; ?>" id="up1"> </div>
					</div>
				<?php } ?>
					
					<?php if($img->image4!='') 
				{ ?>
					<div class="col-xs-6 col-md-3">	
						<div class="uploadImg">				
						<img src="<?php echo  base_url();?>uploads/users/<?php echo $regId ?>/products/after/<?php echo $img->image4; ?>" id="up1"> </div>
					</div>
				<?php } ?>
					
					<?php if($img->image5!='') 
				{ ?>
					<div class="col-xs-6 col-md-3">	
						<div class="uploadImg">				
						<img src="<?php echo  base_url();?>uploads/users/<?php echo $regId ?>/products/after/<?php echo $img->image5; ?>" id="up1"> </div>
					</div>
				<?php } ?>
		<?php	
				 }
				
				} ?>
				
				  
			</div>
  <?php  }	?>
     