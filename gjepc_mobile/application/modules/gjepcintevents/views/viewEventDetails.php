<div class="form-panel">
    <h4 class="mb">Details</h4>
	
	<form class="form-horizontal style-form categoryform">
			<?php
			if(is_array($view_details)){
			foreach($view_details as $row){ 
			?>
		
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Title</label>
		    <div class="col-sm-9">
				<input type="text" name="title" id="title" value="<?php echo $row->event;?>" class="form-control" readonly/>
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="Year">Year</label>
		    <div class="col-sm-9">
				<select class="form-control" name="year" id="year" disabled>
					<option value="">Choose Year</option>
					<?php						
					if(is_array($years)){
					foreach($years as $year) { ?>					
					<option value="<?php echo $year['year'];?>" <?php if($year['year']==$row->year){?> selected="selected"<?php }?>><?php echo $year['year'];?></option>
					<?php }  } ?>
				</select>
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="From">From </label>
		    <div class="col-sm-4">
				<input type="date" name="fromDate" id="fromDate" class="form-control" value="<?php echo $row->fromDate;?>" autocomplete="off" readonly required/>				
			</div>
			<label class="col-sm-1 control-label" for="To">To </label>
			<div class="col-sm-4">
				<input type="date" name="toDate" id="toDate" class="form-control" value="<?php echo $row->toDate;?>" autocomplete="off" readonly required/>				
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="Image">Image</label>		    
			<div class="col-sm-6">
			<?php if(!empty($row->image)) { ?>
			<img src="<?php echo base_url();?>uploads/gjepcevents/<?php echo $row->image;?>" width="150">
			<?php } ?>
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Description</label>
		    <div class="col-sm-12">
				<textarea name="content" class="ckeditor" id="content" disabled><?php echo $row->eventDescription;?></textarea>
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
				<a href="<?php echo base_url("gjepcintevents/gjepcEventsList");?>"><button class="btn btn-primary" type="button">BACK</button></a>
			</div>
			</div>			
			
			<?php } } ?>
    </form>
</div>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/ckfinder/ckfinder.js"></script>				