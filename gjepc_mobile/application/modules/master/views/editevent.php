<div class="form-panel">
        <h4 class="mb">Edit Event Details</h4>
		
			<?php
			if(is_array($editevent)){
            foreach($editevent as $row){
			 //echo '<pre>';print_r($row);
			?>
		<form method="post" class="form-horizontal style-form categoryform" action="<?php echo base_url("master/updateEvent");?>" >
		
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Event</label>
		    <div class="col-sm-9">
				<input type="text" name="event" id="event" value="<?php echo $row->event;?>"  class="form-control" value=""/>
			</div>
			</div>
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="Description">Description</label>
		    <div class="col-sm-12">
				<textarea name="content" class="ckeditor" id="content"><?php echo $row->description;?></textarea>
			</div>
			</div>
				<div class="form-group">
	       	<label class="col-sm-3 control-label" for="temp">Set Temporary Or Permenant</label>
		    <div class="col-sm-9">
			<select class="form-control" name="temp">
				<option value="1" <?php if($row->isTemp=="1") echo 'selected="selected"';?> >Temporary</option>
				<option value="0" <?php if($row->isTemp=="0") echo 'selected="selected"';?> >Permenant</option>
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
        
        