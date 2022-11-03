<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
        	 <h2><b>View Users</b></h2>
	        <section id="no-more-tables">
	            <table class="table table-striped table-condensed cf" id='bannerTable'>
	            <thead class="cf">
					<tr>
                       <th>Sr. No.</th>
					  	<th>User Name</th>
					  	<th>Email</th>
					  	<th>isActive</th>
						<th><i class=" fa fa-edit"></i> Option</th>
					</tr>
				</thead>
                <?php if(is_array($user)){
				      $i= 1;
                       foreach($user as $row){				
				?>
				<tbody>
					 <tr>
                     	<td><?php echo $i++; ?></a></td>
					  	<td data-title="Name"><?php echo $row->username; ?></a></td>
						<td data-title="Order"><?php echo $row->email; ?></td>
						<td data-title="Status"><?php echo $row->isActive;?></td>
						<td data-title="Actions">
				
                       <a class="optbtns" href="<?php echo base_url()."dashboard/userInfo/".$row->regId; ?>" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                      <!--<a class="optbtns" href="<?php echo base_url()."dashboard/deactivateUser/".$row->regId; ?>" title="Deactive"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>-->
                       <a class="optbtns" href="<?php echo base_url()."dashboard/deletRegisterUser/".$row->regId; ?>" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>                       
						</td>
					</tr>
				</tbody>
                
                <?php } } ?>
	        </table>        	
        </div>
    </div>
</div>
<style>
.optbtns{
	margin:0px 5px;
}
</style>
		