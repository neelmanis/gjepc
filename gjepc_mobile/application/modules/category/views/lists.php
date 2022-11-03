<div class="row mt">
    <div class="col-lg-12">
		<div class="alert alert-danger errorMsg hide alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			"<b>Oops. </b>Something went wrong. Please try again later."
		</div>
		<?php /*?><?php if(!empty($this->session->flashdata('success'))): ?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<?php echo $this->session->flashdata('success'); ?>
		</div>
		<?php endif; ?><?php */?>

        <div class="content-panel">
			<h4 style="display: inline-block; padding-right: 1em">Categories - Lists</h4>
			<div class="btn-group">
				<button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
					View <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="<?php echo base_url("category/lists/active"); ?>">Active Categories</a></li>
					<li><a href="<?php echo base_url("category/lists/inactive"); ?>">De-activated Categories</a></li>
				</ul>
			</div>

			<section id="no-more-tables">
	            <table class="table table-striped table-condensed cf" id='listTable'>
					<thead class="cf">
						<tr>
							<th>Name</th>
							<th>ParentId</th>
							<th>Parent</th>
							<th>isActive</th>
							<th><i class=" fa fa-edit"></i> Actions</th>
						</tr>
					</thead>

					<tbody>
						<?php if(is_array($getAllCategories) && !empty($getAllCategories)):
						foreach($getAllCategories as $getcategory):
					
							if($getcategory->parentId != 0):
								$category_status = ($getcategory->isActive == '1') ? 'Active' : 'De-active';
						?>
						<tr>
							<td data-title="Name"><?php echo $getcategory->catName;?></td>
							<td data-title="ParentId"><?php echo $getcategory->parentId;?></td>
							<td data-title="Parent"><?php echo Modules::run('category/_getName', $getcategory->parentId);?></td>
							<td data-title="Status"><?php echo $category_status; ?></td>
							<td data-title="Actions">
								<a class="deleterows btn btn-danger btn-xs" data-target="#deleteModal" data-toggle="modal" data-id="<?php echo $getcategory->catId;?>" data-text="<?php echo $getcategory->catName;?>" title='Delete Category'><i class="fa fa-trash-o "></i></a>
								<a class="btn btn-primary btn-xs" href='<?php echo base_url();?>category/edit/<?php echo $getcategory->catId;?>' title='edit Category'><i class="fa fa-pencil"></i></a>
							</td>
						</tr>
						<?php endif;
						endforeach;
						endif; ?>
					</tbody>
	        	</table>
			</section>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form class="form-horizontal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Delete Category</h4>
				</div>
				<div class="modal-body">
					<p>Are you sure you want to <b class='name'></b> ?</p>
				</div>
				<div class="modal-footer">
					<button class="btn btn-default" data-dismiss="modal">Close</button>
					<button class="btn btn-danger" id=''>Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$('#listTable').DataTable({
		stateSave: true,
		"order": [[1, "asc"]],
		"columnDefs": [
			{
				"targets": [1],
				"visible": false,
				"searchable": false,
			}],
	});

	/* Setting up the delete button in modal box by adding id attribute to delete button in modal */
	jQuery(document).on('click', 'a.deleterows',function(){
		var $this = jQuery(this);
		var deleteModal = jQuery('#deleteModal');
		var text = $this.data('text');
		var dataid = $this.data('id');

		deleteModal.find('button.btn-danger').attr('id', dataid).end().find('b.name').text(text);
	})

	/* Click on delete button in delete Modal */
	jQuery('#deleteModal').find('button.btn-danger').on('click',function(e){
		e.preventDefault();
		var $this = jQuery(this);
		var id = $this.attr('id');

		$.ajax({
			url: baseUrl+'index.php/category/delcategory/'+id,
			success: function(data){
				if(data == 'success'){
					$this.siblings('button').trigger('click');
					jQuery('.errorMsg').addClass('hide');
					location.reload(true);
				}
				else{
					$this.siblings('button').trigger('click');
					jQuery('.errorMsg').removeClass('hide');
				}
			}
		})
	});
</script>