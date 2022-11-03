
<div class="form-panel">
        <h4 class="mb">Add Event Details</h4>
			 
			<form method="post" class="form-horizontal style-form categoryform" action="<?php echo base_url("gjepcintevents/addEventsDetails");?>" enctype="multipart/form-data">		
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Event</label>
		    <div class="col-sm-9">
			<input type="text" name="title" id="title" class="form-control" placeholder="Event Name" autocomplete="off" required/>
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
					<option value="<?php echo $year['year'];?>"><?php echo $year['year'];?></option>
					<?php }  } ?>
				</select>				
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="From">From </label>
		    <div class="col-sm-4">
				<input type="date" name="fromDate" id="fromDate" class="form-control" autocomplete="off" required/>				
			</div>
			<label class="col-sm-1 control-label" for="To">To </label>
			<div class="col-sm-4">
				<input type="date" name="toDate" id="toDate" class="form-control" autocomplete="off" required/>				
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="Venue">Event Venue</label>
		    <div class="col-sm-9">
			<input type="text" name="eventVenue" id="eventVenue" class="form-control" placeholder="Event Venue" autocomplete="off" required/>
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="url">Event Url</label>
		    <div class="col-sm-9">
			<input type="text" name="eventUrl" id="eventUrl" class="form-control" placeholder="Event Url" autocomplete="off" required/>
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="Image">Image</label>
		    <div class="col-sm-9">
				<input type="file" name="image" id="image" accept="image/x-png,image/jpg,image/jpeg" class="form-control" required/>
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="Description">Description</label>
		    <div class="col-sm-12">
				<textarea name="content" class="ckeditor" id="content"></textarea>
			</div>
			</div>
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="Status">Type</label>
		    <div class="col-sm-9">
			<select class="form-control" name="type">
				<option value="">Select Type</option>
				<option value="bsm">BSM</option>
				<option value="indpav">India Pavilian</option>
			</select>
			</div>
			</div>
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="Status">Status</label>
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