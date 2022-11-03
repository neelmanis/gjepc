<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
        	<h4 style="display: inline-block; padding-right: 1em">Exhibitor - List</h4>
			<?php
			/*?><div class="btn-group">
				<button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
					View <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="<?php echo base_url("users/listUsers/active"); ?>">Active Feeds</a></li>
					<li><a href="<?php echo base_url("users/listUsers/inactive"); ?>">De-activated Feeds</a></li>
				</ul>
			</div><?php */?>
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
						<td>
                        <a class="optbtns" href="<?php echo base_url()."exhibitors/editexhibitors/".$row['Exhibitor_ID']; ?>" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true" title="Edit"></i></a>
                        <a class="optbtns" href="<?php echo base_url()."feed/viewFeeds/".$row['Exhibitor_ID']; ?>" title="View Feeds"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        <?php 
						 $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
						 $exp = explode('/',$actual_link);
						 
						 if($exp[5]=='active')
						  { ?>
							 <a class="optbtns" href="<?php echo base_url()."exhibitors/deactivateUser/".$row['Exhibitor_ID']; ?>" title="Deactive"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>
					<?php } 
						 else
						  { ?>
							<a class="optbtns" href="<?php echo base_url()."users/activateUser/".$row['Exhibitor_ID']; ?>" title="Active"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i></a> 
				    <?php } ?>
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
		
        