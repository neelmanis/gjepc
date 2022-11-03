<div class="form-panel">
        <h4 class="mb">Add FAQ Details</h4>
			 
			<form method="post" class="form-horizontal style-form categoryform" action="<?php echo base_url("showinfo/addfaqDetails");?>" enctype="multipart/form-data">		
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Title</label>
		    <div class="col-sm-9">
				<input type="text" name="title" id="title" class="form-control" value="" required/>
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
					<option value="<?php echo $year->id;?>"><?php echo $year->year;?></option>
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
					<option value="<?php echo $event->id;?>" ><?php echo $event->event;?></option>	
					<?php }  } ?>					
				</select>	
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Browse</label>
		    <div class="col-sm-9">
				<input type="file" name="my_file" id="my_file" class="form-control" required/>
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
		
        