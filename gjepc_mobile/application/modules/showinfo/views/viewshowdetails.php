<div class="form-panel">
    <h4 class="mb">Details</h4>
	
	<form class="form-horizontal style-form categoryform" >
				   <?php 
					if(is_array($view_details)){
						foreach($view_details as $row){ 
					?>
		
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Title</label>
		    <div class="col-sm-9">
				<input type="text" name="title" id="title" class="form-control" value="<?php echo $row->title;?>" readonly/>
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Year</label>
		    <div class="col-sm-9">
				<select class="form-control" name="year" id="year" disabled="disabled">
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
				<select class="form-control" name="event" id="event" disabled="disabled"/>
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
			<label class="col-sm-3 control-label" for="username">File</label>
			<div class="col-sm-9">
					 <?php if(!empty($row->html_files)) { ?>
				 <a href="<?php echo base_url();?>uploads/showdetails/<?php echo $row->html_files;?>" target="_blank">Your File</a>
					<?php } ?>
			</div>
			</div>	

			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Status</label>
		    <div class="col-sm-9">
			<select class="form-control" name="status" disabled="disabled">
				<option value="1" <?php if($row->status=="1") echo 'selected="selected"';?> >Active</option>
				<option value="0" <?php if($row->status=="0") echo 'selected="selected"';?> >Inactive</option>
			</select>
			</div>
			</div>
			
			<div class="form-group">
			<label class="col-sm-3 control-label">&nbsp;</label>
			<div class="col-sm-9">
				<a href="<?php echo base_url("showinfo/listShowDetails");?>"><button class="btn btn-primary" type="button">BACK</button></a>
			</div>
			</div>			
			
			<?php } } ?>
    </form>
</div>
					