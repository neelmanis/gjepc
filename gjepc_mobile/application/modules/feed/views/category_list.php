<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
        	 <h2><b>View Category</b></h2>
             <a href="<?php echo base_url("dashboard/addNewCat") ?>"><button>Add New</button></a>
	        <section id="no-more-tables">
	            <table class="table table-striped table-condensed cf" id='bannerTable'>
	            <thead class="cf">
					<tr>
                       <th>Sr. No.</th>
					  	<th>Category Name</th>
					  	<th>Parent Category</th>
					  	<th>isActive</th>
						<th><i class=" fa fa-edit"></i> Option</th>
					</tr>
				</thead>
               
				<tbody>
                 <?php if(is_array($category)){
				      $i = 1;
                        foreach($category as $row){				
				?>
					 <tr>
                     	<td><?php echo $i++; ?></a></td>
					  	<td><?php echo $row->catName; ?></a></td>
						<td><?php ?></td>
						<td data-title="Status"><?php ?></td>
						<td data-title="Actions">
				
                       <!-- <a class="optbtns" href="<?php echo base_url()."dashboard/userInfo/".$row->regId; ?>" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                     <a class="optbtns" href="<?php echo base_url()."dashboard/deactivateUser/".$row->regId; ?>" title="Deactive"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>
                       <a class="optbtns" href="<?php echo base_url()."dashboard/deletRegisterUser/".$row->regId; ?>" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>    -->                   
						</td>
					</tr>
                      <?php } } ?>
				</tbody>
	        </table>        	
        </div>
    </div>
</div>
<style>
.optbtns{
	margin:0px 5px;
}
</style>
		