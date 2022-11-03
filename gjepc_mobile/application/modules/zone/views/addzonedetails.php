<div class="form-panel">
        <h4 class="mb">Add Zone Details</h4>
			
			<form method="post" class="form-horizontal style-form categoryform" action="<?php echo base_url("zone/addDetails");?>" enctype="multipart/form-data">			   
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Hall</label>
		    <div class="col-sm-9">
				<select class="form-control" name="hall" id="hall" required>
					<option value="">Choose Hall</option>
					<?php
					if(is_array($hall)){ 
					foreach($hall as $hall) { ?>
					<option value="<?php echo $hall->hall;?>" ><?php echo $hall->hall;?></option>	
					<?php }  } ?>					
				</select>	
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Zone</label>
		    <div class="col-sm-9">
				<select class="form-control" name="zone" id="zone" required>
					<option value="">Choose Zone</option>
					<?php
					if(is_array($zone)){ 
					foreach($zone as $zones) { ?>
					<option value="<?php echo $zones->zone;?>" ><?php echo $zones->zone;?></option>	
					<?php }  } ?>					
				</select>	
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Event Name</label>
		    <div class="col-sm-9">
				<select class="form-control" name="event" id="event" required>
					<option value="">Choose Event</option>
					<?php
					if(is_array($events)){ 
					foreach($events as $event) { ?>
					<option value="<?php echo $event->event;?>" ><?php echo $event->event;?></option>	
					<?php }  } ?>					
				</select>	
			</div>
			</div>	
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Year</label>
		    <div class="col-sm-9">
				<select class="form-control" name="year" id="year" required>
					<option value="">Choose Year</option>
					<?php
					if(is_array($years)){
					foreach($years as $year) { ?>					
					<option value="<?php echo $year->year;?>"><?php echo $year->year;?></option>
					<?php }  } ?>
				</select>				
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Name</label>
		    <div class="col-sm-9">
			<input type="text" name="name" id="name" class="form-control" value="" required/>			
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Email</label>
		    <div class="col-sm-9">
			<input type="email" name="email" id="email" class="form-control" value="" required/>			
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Mobile</label>
		    <div class="col-sm-9">
			<input type="text" name="mob" id="mob" class="form-control" value="" required/>			
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Status</label>
		    <div class="col-sm-9">
			<select class="form-control" name="status">
				<option value="1">Active</option>
				<option value="0">Inactive</option>
			</select>
			</div>
			</div>
			
			<div class="form-group">
			<input type="submit" class="btn btn-primary" name="submit" value="ADD">
			</div>
			</form>			
</div>
		
        