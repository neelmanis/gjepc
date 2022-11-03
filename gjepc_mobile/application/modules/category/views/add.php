<div class="form-panel">
    <h4 class="mb">Add Category</h4>
	<form id="form" class="form-horizontal style-form" action="<?php echo base_url()?>category/newcategory">
		<div class="form-group" id='message'>
			<div class="col-sm-12">
			</div>
		</div>

		<div class="form-group">
	       	<label class="col-sm-3 control-label" for="username">Category Name</label>
		    <div class="col-sm-9">
				<input type="text" name="catName" id="catName" class="form-control" />
			</div>
		</div>

		<div class="form-group">
		    <label class="col-sm-3 control-label">Parent Category</label>
		    <div class="col-sm-9">
			    <input type="text"  name="parentId" id="parent_category" class="form-control noreset" />
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
				<a href="<?php echo base_url("category/lists")?>" class="btn btn-primary">Cancel</a>
			</div>
		</div>
	</form>
</div>			
<script>
(function($){

	jQuery('#name').on('keyup',function(event){
		//var value = String.fromCharCode(event.keyCode).toLowerCase();
		var $this = jQuery(this);

		var text = $this.val();
		text = text.replace(/ /g,'-').toLowerCase();
		jQuery('input[name=slug]').val(text);
	});

	function fillcategory(){
		$.ajax({
			url: baseUrl+'index.php/category/jsonCategories',
			dataType:'JSON',
			success: function(data, textStatus, jqXHR){
				$('#parent_category').select2({data: data, placeholder: 'Select parent category'});
				$('#parent_category').select2("val", '1');
			}
		})
	}

	window.onload = function(){ fillcategory() };
	//;

	jQuery('#form').on('submit',function(e){
		e.preventDefault();

		var formObj = jQuery(this);
		var formUrl = formObj.attr('action');

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
					if(data=='success') {
						fillcategory();
						jQuery('input:not(".noreset")').val('');
						jQuery('div#message').find('div').html('<div class="alert alert-success">New category has been added successfully !!!</div>');
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
			