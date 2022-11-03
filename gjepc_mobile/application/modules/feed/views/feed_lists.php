<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
        	<h4 style="display: inline-block; padding-right: 1em">Feed - List</h4>
			<?php /*?><div class="btn-group">
				<button type="button" class="btn btn-theme dropdown-toggle" data-toggle="dropdown">
					View <span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li><a href="<?php echo base_url("feed/listFeed/active"); ?>">Active Feeds</a></li>
					<li><a href="<?php echo base_url("feed/listFeed/inactive"); ?>">De-activated Feeds</a></li>
				</ul>
			</div><?php */?>
	        <section id="no-more-tables">
	        <table id="example" class="table table-striped table-advance table-hover">
	            <thead class="cf">
					<tr>
                       <th>Sr. No.</th>
					  	<th>Description</th>
						<th><i class=" fa fa-edit"></i>Option</th>
					</tr>
				</thead>
              
				<tbody>
                  <?php if(is_array($feed)){
				  
				      $i= 1;
                       foreach($feed as $row){
						     $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
						 $exp = explode('/',$actual_link);
				  ?>
					 <tr>
                     	<td><?php echo $i++; ?></td>
                        <td><?php echo $row->description; ?></td>
						<td data-title="Actions">
                       <a class="optbtns" href="<?php echo base_url()."feed/feedInfo/".$row->feedId; ?>" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                       
                       <a class="optbtns" href="<?php echo base_url()."feed/deletefeed/".$row->feedId."/".$exp[7]; ?>" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></a>                       
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
		
        