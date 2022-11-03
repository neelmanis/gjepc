<div class="form-panel">
        <h4 class="mb">Edit Event Details</h4>
		
			<?php
			if(is_array($editlab)){
            foreach($editlab as $row){
			 //echo '<pre>';print_r($row);
			?>
			<form method="post" class="form-horizontal style-form categoryform" action="<?php echo base_url("gjepcintevents/updateEvent");?>" enctype="multipart/form-data">
		
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Title</label>
		    <div class="col-sm-9">
				<input type="text" name="title" id="title" value="<?php echo $row->event;?>" class="form-control" placeholder="Event Name" autocomplete="off" required/>
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="Year">Year</label>
		    <div class="col-sm-9">
				<select class="form-control" name="year" id="year" required>
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
				<input type="date" name="fromDate" id="fromDate" class="form-control" value="<?php echo $row->fromDate;?>" autocomplete="off" required/>				
			</div>
			<label class="col-sm-1 control-label" for="To">To </label>
			<div class="col-sm-4">
				<input type="date" name="toDate" id="toDate" class="form-control" value="<?php echo $row->toDate;?>" autocomplete="off" required/>				
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="Image">Image</label>
		    <div class="col-sm-3">
				<input type="file" name="image" id="image" value="<?php echo $row->image;?>" class="form-control" />
			</div>
			<div class="col-sm-6">
			<?php if(!empty($row->image)) { ?>
			<img src="<?php echo base_url();?>uploads/gjepcevents/<?php echo $row->image;?>" width="150">
			<?php } ?>
			</div>
			</div>

			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Description</label>
		    <div class="col-sm-12">
				<textarea name="content" class="ckeditor" id="content"><?php echo $row->eventDescription;?></textarea>
			</div>
			</div>
					<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Event Type</label>
		    <div class="col-sm-9">
			<select class="form-control" name="type">
				
				<option value="bsm" <?php if($row->type=="bsm") echo 'selected="selected"';?> >BSM</option>
				<option value="indpav" <?php if($row->type=="indpav") echo 'selected="selected"';?> >India Pavilian</option>
			</select>

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
			<input type="hidden" name="image" id="image" value="<?php echo $row->image;?>">
			<input type="hidden" name="id" value="<?php echo $row->id?>">
			<input type="submit" class="btn btn-primary" name="submit" value="Update">
			</div>
			</form>			

		    <?php
			 }
			 } 
			?> 
</div>
<!-- ckeditor script -->
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/ckfinder/ckfinder.js"></script>
<script type="text/javascript">
var baseUrl = '<?php echo base_url() ?>';       
var editor = CKEDITOR.replace( 'content', {
	filebrowserBrowseUrl: baseUrl+'assets/ckfinder/ckfinder.html',
	filebrowserImageBrowseUrl: baseUrl+'assets/ckfinder/ckfinder.html?Type=Files',
	filebrowserImageBrowseUrl: baseUrl+'assets/ckfinder/ckfinder.html?Type=Images',
	filebrowserFlashBrowseUrl: baseUrl+'assets/ckfinder/ckfinder.html?Type=Flash',
	filebrowserUploadUrl : baseUrl+'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
	filebrowserImageUploadUrl : baseUrl+'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
	filebrowserFlashUploadUrl : baseUrl+'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
});
CKFinder.setupCKEditor( editor, '../' );
</script>
<?php  ob_end_flush(); ?>
        