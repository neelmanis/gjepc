<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
        	<h4 style="display: inline-block; padding-right: 1em">Exhibitor - List</h4>
			
	        <section id="no-more-tables">
	    <table id="example" class="table table-striped table-advance table-hover">
	            <thead class="cf">
					<tr>
                       <th>Sr. No.</th>
					   <th>Exhibitor Name</th>
                       <th>Customer No</th>
                       <th>Exhibitor Contact Person</th>
                       <th>Exhibitor Designation</th>
                       <th>Exhibitor Code</th>
					   <th>Event</th>
                       <th>Action</th>
					</tr>
				</thead>
              
				<tbody>
                  <?php 
				       if(is_array($users)){
				       $i= 1;
                       foreach($users as $row){						 
				  ?>
					 <tr>
                     	<td><?php echo $i++; ?></td>
                        <td><?php echo $row['Exhibitor_Name']; ?></td>
                        <td><?php echo $row['Customer_No']; ?></td>
                        <td><?php echo $row['Exhibitor_Contact_Person']; ?></td>
                        <td><?php echo $row['Exhibitor_Designation']; ?></td>
                        <td><?php echo $row['Exhibitor_Code']; ?></td>
						<td><?php echo $row['event_name']; ?></td>
											
						<td>
                        <a class="optbtns" href="<?php echo base_url()."exhibitors/edit_exhibitors/".$row['Exhibitor_ID']; ?>" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a>
                        </td>
						
					 </tr>
                       <?php } } ?>
				</tbody>
	        </table>
           </section>   	
        </div>
    </div>
</div>
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
		
        