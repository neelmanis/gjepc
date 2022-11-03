<div class="form-panel">
    <h4 class="mb">Add Cms</h4>
	<form id="cmsform" class="form-horizontal style-form categoryform" action="<?php echo base_url()?>cms/newcms">
		<div class="form-group" id='message'>
			<div class="col-sm-12">
			</div>
		</div>
		
		<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Page title</label>
		    <div class="col-sm-9">
				<input type="text" name="name" id="name" class="form-control" />
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" for="slug">Url Key</label>
			<div class="col-sm-9">
				<input type="text" name="slug" class="form-control slug" />
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" for="description">Description</label>
			<div class="col-sm-9">
				 <textarea id="content" name="content"></textarea>
			</div>
		</div>

	    <div class="form-group">
		    <label class="col-sm-3 control-label">Status</label>
		    <div class="col-sm-9">
			    <select  name="isActive" id="category_status" class="form-control">
			    	<option value="">Choose One</option>
			        <option value="1" selected >Active</option>
			        <option value="0">Deactivate</option>
			    </select>
		    </div>
		</div>
		
		<div class="form-group">
			<label class="col-sm-3 control-label">&nbsp;</label>
			<div class="col-sm-9">
				<input type="submit" class="btn btn-primary noreset" id="banner_btn" value='Save'>
				<a href="<?php echo base_url("cms/lists")?>" class="btn btn-primary">Cancel</a>
			</div>
		</div>
	</form>
</div>	

 <script type="text/javascript" src="<?php echo base_url();?>uploads/ckeditor/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>uploads/ckeditor/ckfinder/ckfinder.js"></script>
    <script type="text/javascript">
	var baseUrl = '<?php echo base_url() ?>';
	var editor = CKEDITOR.replace( 'content', {
	filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
	filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
	filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
	filebrowserUploadUrl : baseUrl+'uploads/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
	filebrowserImageUploadUrl : baseUrl+'uploads/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
	filebrowserFlashUploadUrl : baseUrl+'uploads/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
});
CKFinder.setupCKEditor( editor, '../' );

</script>		
<script>
(function($){

	jQuery('#name').on('keyup',function(event){
		//var value = String.fromCharCode(event.keyCode).toLowerCase();
		var $this = jQuery(this);

		var text = $this.val();
		text = text.replace(/ /g,'-').toLowerCase();
		jQuery('input[name=slug]').val(text);
	});

	jQuery('#cmsform').on('submit',function(e){
		e.preventDefault();

		var formObj = jQuery(this);
		var formUrl = formObj.attr('action');
		  for ( instance in CKEDITOR.instances )
			{
				CKEDITOR.instances[instance].updateElement();
				CKEDITOR.instances[instance].setData('');
			}
		if(window.FormData != 'undefined'){
			var formData = new FormData(this);

			jQuery.ajax({
				url: formUrl,
				type: 'POST',
				data: formData,
				mimeType: 'multipart/form-data',
				contentType: false,
				cache: false,
				processData: false,
				beforeSend: function(xhr, opts){

				},
				success: function(data, textStatus, jqXHR){
						//alert(data);
				 if(data=='success') {
					
						jQuery('input:not(".noreset")').val('');
						jQuery('div#message').find('div').html('<div class="alert alert-success">New page content has been added successfully !!!</div>');
					}
					else {
						jQuery('div#message').find('div').html('<div class="alert alert-danger">' + data + '</div>');
					}
					window.scrollTo(0,0); 
				},
				error: function(jqXHR, textStatus, errorThrown){
					console.log(errorThrown);
				}
			});
		}
	});
})(jQuery)	
</script>			
			