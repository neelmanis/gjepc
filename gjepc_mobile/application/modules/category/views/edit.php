<div class="form-panel">
	<h4 class="mb">Edit Category</h4>
	<form id="form" class="form-horizontal style-form" action="<?php echo base_url()?>category/editcategory">
		<input type="hidden" name="catId" value="<?php echo $categories->catId; ?>" />
		<span id="pagestatus"><?php echo $status; ?></span>
		<div class="form-group" id='message'>
			<div class="col-sm-12">
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label" for="username">Category Name</label>
			<div class="col-sm-9">
				<input type="text" name="catName" id="catName" class="form-control" value="<?php echo $categories->catName; ?>" />
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
					<option value="1" <?php echo ($categories->isActive == 1) ? 'selected':'' ?>>Active</option>
					<option value="0" <?php echo ($categories->isActive == 0) ? 'selected':'' ?>>Deactivate</option>
				</select>
			</div>
		</div>

		<div class="form-group">
			<label class="col-sm-3 control-label">&nbsp;</label>
			<div class="col-sm-9">
				<input type="submit" class="btn btn-primary noreset" id="banner_btn" value='Save'>
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
			var parentVal = '<?php echo $categories->parentId; ?>';
			$.ajax({
				url: baseUrl+'index.php/category/jsonCategories',
				dataType:'JSON',
				success: function(data, textStatus, jqXHR){
					$('#parent_category').select2({data: data, placeholder: 'Select parent category'});
					$('#parent_category').select2("val", parentVal);
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
							var statusVal = parseInt(jQuery('#pagestatus').text());
							var redirectTo = (statusVal) ? 'active':'inactive';
							location.href = baseUrl + "index.php/category/lists/" + redirectTo;
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
			