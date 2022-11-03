<div class="row mt">
    <div class="col-lg-12">
		<div class="alert alert-danger errorMsg hide alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			"<b>Oops. </b>Something went wrong. Please try again later."
		</div>
		<?php if(!empty($this->session->flashdata('success'))): ?>
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<?php echo $this->session->flashdata('success'); ?>
		</div>
		<?php endif; ?>

        <div class="content-panel">
			<h4 style="display: inline-block; padding-right: 1em">Cms - Lists</h4>
			<div class="btn-group">
				<button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
					View <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="<?php echo base_url("cms/lists/active"); ?>">Active Cms</a></li>
					<li><a href="<?php echo base_url("cms/lists/inactive"); ?>">De-activated Cms</a></li>
				</ul>
			</div>

			<section id="no-more-tables">
	            <table class="table table-striped table-condensed cf" id='cmsTable'>
					<thead class="cf">
						<tr>
							<th>Name</th>
							<th>isActive</th>
							<th><i class=" fa fa-edit"></i> Actions</th>
						</tr>
					</thead>

					<tbody>
						<?php if(is_array($getAllCms) && !empty($getAllCms)):
						foreach($getAllCms as $getcms):
								$category_status = ($getcms->isActive == '1') ? 'Active' : 'De-active';
						?>
						<tr>
							<td data-title="Name"><?php echo $getcms->name;?></td>
							<td data-title="Status"><?php echo $category_status; ?></td>
							<td data-title="Actions">
								<a class="deleterows btn btn-danger btn-xs" data-target="#deleteModal" data-toggle="modal" data-category="<?php echo $getcms->cmsId;?>" data-text="<?php echo $getcms->name;?>" title='Delete Cms'><i class="fa fa-trash-o "></i></a>
								<a class="btn btn-primary btn-xs" href='<?php echo base_url();?>cms/edit/<?php echo $getcms->cmsId;?>' title='edit Cms'><i class="fa fa-pencil"></i></a>
							</td>
						</tr>
						<?php 
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
					<h4 class="modal-title" id="myModalLabel">Delete Cms</h4>
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
	$('#cmsTable').DataTable({stateSave: true});
	/* Setting up the delete button in modal box by adding id attribute to delete button in modal */
	jQuery(document).on('click', 'a.deleterows',function(){
		var $this = jQuery(this);
		var deleteModal = jQuery('#deleteModal');
		var text = $this.data('text');
		var cmsId = $this.data('category');

		deleteModal.find('button.btn-danger').attr('id', cmsId).end().find('b.name').text(text);
	})

	/* Click on delete button in delete Modal */
	jQuery('#deleteModal').find('button.btn-danger').on('click',function(e){
		e.preventDefault();
		var $this = jQuery(this);
		var cmsId = $this.attr('id');

		$.ajax({
			url: baseUrl+'cms/delcms/'+cmsId,
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