<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url(); ?>assets/ckfinder/ckfinder.js"></script>

<div class="form-panel">
        <h4 class="mb">Add Laboratories Details</h4>
			 
			<form method="post" class="form-horizontal style-form categoryform" action="<?php echo base_url("labeduinfo/addLabDetails");?>" enctype="multipart/form-data">		
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Title</label>
		    <div class="col-sm-9">
				<input type="text" name="title" id="title" class="form-control" value="" required/>
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Browse</label>
		    <div class="col-sm-9">
				<input type="file" name="image" id="image" class="form-control" required/>
			</div>
			</div>
			
			<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Description</label>
		    <div class="col-sm-12">
				<textarea name="content" class="ckeditor" id="content"></textarea>
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
<!-- ckeditor script -->
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