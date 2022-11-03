<div class="row mt">
    <div class="col-lg-12">
	
        <div class="content-panel">
        	<h4 style="display: inline-block; padding-right: 1em">Show Enquiry List</h4>
			<section id="no-more-tables">
	    <table id="example" class="table table-striped table-advance table-hover">
	            <thead class="cf">
					<tr>
                       <th>Sr. No.</th>
					   <th>Date</th>
					   <th>Gcode</th>
					   <th>Email</th>
                       <th>Mobile</th>
					   <th>Dept</th>
					   <th>Reply</th>
                       <th>View</th>
					</tr>
				</thead>
              
				<tbody>
                  <?php 
				       if(is_array($details)){
				       $i= 1;
                       foreach($details as $row){
				  ?>
					 <tr>
                     	<td><?php echo $i++; ?></td>
						<td><?php echo $row['post_date']; ?></td>
						<td><?php echo $row['gcode']; ?></td>
						<td><?php echo $row['email']; ?></td>
						<td><?php echo $row['mobile']; ?></td>
						<td><?php echo $row['dept']; ?></td>
						<td>
						<?php 
						$replied = $row['replied']; 		   	
						if($replied == 1) { ?>
						<a onclick="return(window.confirm('Already Replied'));"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
						<?php } else { ?>
						<a class="optbtns" href="<?php echo base_url()."enquiry/editinfo/".$row['id']; ?>" title="Reply"><i class="fa fa-reply" aria-hidden="true"></i></a>
						<?php } ?>
						</td>
						<td>
						<a class="optbtns" href="<?php echo base_url()."enquiry/viewDetails/".$row['id']; ?>" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></a>
						</td>
						<!--<td>
                        <a class="optbtns" href="<?php echo base_url()."show/editinfo/".$row['id']; ?>" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a>--->
						
                        <!--<a class="optbtns" href="<?php echo base_url()."show/viewDetails/".$row['id']; ?>" title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></a>
	 
						<a class="btn btn-danger btn-xs" href="<?php echo base_url()."show/delete_details/".$row['id']; ?>" title="Delete" id="delete" onClick="return confirmDelete();"><i class="fa fa-trash-o"></i></a>
                        </td>-->
					 </tr>
                       <?php } } ?>
				</tbody>
	        </table>
           </section>   	
        </div>
    </div>
</div>
<script type='text/javascript'>
function confirmDelete()
{
   return confirm("Are you sure you want to delete this?");
}
</script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>admin_assets/datatable/css/jquery.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="<?php echo base_url(); ?>/admin_assets/datatable/js/jquery.dataTables.js"></script>   
<script type="text/javascript">
   $(document).ready(function(){
   $("#example").DataTable();
     });
</script>
<style>
.optbtns{
	margin:0px 5px;
}
</style>
		
        