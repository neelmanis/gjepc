<div class="form-panel">
        <h4 class="mb">Edit Registration Details</h4>
		
			<?php
			if(is_array($editregistration)){
            foreach($editregistration as $row){
			 //echo '<pre>';print_r($row);
			?>
			<form method="post" class="form-horizontal style-form categoryform" action="<?php echo base_url("showinfo/updateRegistration");?>" enctype="multipart/form-data">
		
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Title</label>
		    <div class="col-sm-9">
				<input type="text" name="title" id="title" value="<?php echo $row->title;?>"  class="form-control" value=""/>
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
					<option value="<?php echo $year->id;?>" <?php if($year->id==$row->year){?> selected="selected"<?php }?>><?php echo $year->year;?></option>
					<?php }  } ?>
				</select>
			</div>
			</div>
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Event Name</label>
		    <div class="col-sm-9">
				<select class="form-control" name="event" id="event"/>
					<option value="">Choose Event</option>
					<?php
					if(is_array($events)){ 
					foreach($events as $event) { ?>					
					<option value="<?php echo $event->id;?>" <?php if($event->id==$row->event_name){?> selected="selected"<?php }?>><?php echo $event->event;?></option>
					<?php }  } ?>
				</select>	
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Browse</label>
		    <div class="col-sm-3">
				<input type="file" name="my_file" id="my_file" value="<?php echo $row->html_files;?>" class="form-control" />
			</div>
			<div class="col-sm-6">
			<?php if(!empty($row->html_files)) { ?>
				 <a href="<?php echo base_url();?>uploads/registration/<?php echo $row->html_files;?>" target="_blank">Your File</a>
					<?php } ?>
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
			<input type="hidden" name="my_file" id="my_file" value="<?php echo $row->html_files;?>">
			<input type="hidden" name="id" value="<?php echo $row->id?>">
			<input type="submit" class="btn btn-primary" name="submit" value="Update">
			</div>
			</form>			

		    <?php
			 }
			 } 
			?> 
</div>

        