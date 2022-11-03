<div class="form-panel">
    <h4 class="mb">Details</h4>
	
	<form class="form-horizontal style-form categoryform" >
				   <?php 
					if(is_array($view_details)){
						foreach($view_details as $row){ //print_r($row);
					?>
						
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Email</label>
		    <div class="col-sm-9">
				<input type="text" name="title" id="title" class="form-control" value="<?php echo $row->email;?>" readonly/>
			</div>
			</div>
						
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Mobile</label>
		    <div class="col-sm-9">
				<input type="text" name="mobile" id="mobile" class="form-control" value="<?php echo $row->mobile;?>" readonly/>
			</div>
			</div>
						
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Enquiry</label>
		    <div class="col-sm-9">
			<textarea class="form-control" Placeholder="Description Here" name="description" id="description" rows="3" disabled="disabled" required><?php echo $row->enquiry;?></textarea>			
			</div>
			</div>
			
			<?php if($row->description!=''){?>
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Your Feedback</label>
		    <div class="col-sm-9">
			<textarea class="form-control" Placeholder="Write Your Description Here" name="description" id="description" rows="3" disabled="disabled"><?php echo $row->description;?></textarea>			
			</div>
			</div>	
			<?php } ?>
			
			<div class="form-group">
			<label class="col-sm-3 control-label">&nbsp;</label>
			<div class="col-sm-9">
				<a href="<?php echo base_url("enquiry/enquiryList");?>"><button class="btn btn-primary" type="button">BACK</button></a>
			</div>
			</div>			
			
			<?php } } ?>
    </form>
</div>
					