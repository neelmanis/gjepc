<div class="form-panel">
        <h4 class="mb">Edit Zone Details</h4>
        	
			<?php
			if(is_array($editinfo)){
            foreach($editinfo as $row){
		//	 echo '<pre>';print_r($row);
			?>
			<form method="post" class="form-horizontal style-form categoryform" action="<?php echo base_url("zone/updateDetails");?>" enctype="multipart/form-data">
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Hall</label>
		    <div class="col-sm-9">
				<select class="form-control" name="hall" id="hall" required>
					<option value="">Choose Hall</option>
					<?php
					if(is_array($hall)){ 
					foreach($hall as $halls) { ?>
					<option value="<?php echo $halls->hall;?>" <?php if($halls->hall==$row->hall){?> selected="selected"<?php }?>><?php echo $halls->hall;?></option>	
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
					foreach($zone as $zone) { ?>
					<option value="<?php echo $zone->zone;?>" <?php if($zone->zone==$row->zone){?> selected="selected"<?php }?>><?php echo $zone->zone;?></option>	
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
					<option value="<?php echo $event->event;?>" <?php if($event->event==$row->event_name){?> selected="selected"<?php }?>><?php echo $event->event;?></option>
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
					<option value="<?php echo $year->year;?>" <?php if($year->year==$row->year){?> selected="selected"<?php }?>><?php echo $year->year;?></option>
					<?php }  } ?>
				</select>
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Name</label>
		    <div class="col-sm-9">
			<input type="text" name="name" id="name" class="form-control" value="<?php echo $row->name;?>" required/>			
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Email</label>
		    <div class="col-sm-9">
			<input type="email" name="email" id="email" class="form-control" value="<?php echo $row->email;?>" required/>			
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Mobile</label>
		    <div class="col-sm-9">
			<input type="text" name="mob" id="mob" class="form-control" value="<?php echo $row->mob;?>" required/>			
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Status</label>
		    <div class="col-sm-9">
			<select class="form-control" name="status">
				<option value="1" <?php if($row->status=="1") echo 'selected="selected"';?> >Active</option>
				<option value="0" <?php if($row->status=="0") echo 'selected="selected"';?> >Inactive</option>
			</select>
			</div>
			</div>
			
			<div class="form-group">
			<input type="hidden" name="id" value="<?php echo $row->id?>">
			<input type="submit" class="btn btn-primary" name="submit" value="Update">	
			</div>
			</form>			

		  <?php
			}
			} 
			?> 
</div>

        