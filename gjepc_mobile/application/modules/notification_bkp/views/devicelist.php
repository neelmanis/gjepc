<?php $path="http://localhost/lifefeed/"; ?>

<div class="row mt">
    <div class="col-lg-12">
        <div class="content-panel">
        	<h4 style="display: inline-block; padding-right: 1em">Device - List</h4>
             <div style="display: none;" class="form_error"></div>
           <div style="display: none;" class="form_success"></div> 
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
                       <th class="nosort"><input type="checkbox" id="allchk"  class="checkall" /></th>
					   <th>User Name</th>
                       <th>Device Id</th>
                       <th>Device Type</th>
                       <th>User Type</th>
					</tr>
				</thead>
              
				<tbody>
                  <?php 
				       if(is_array($devicelist)){
						
				       $i= 1;
                       foreach($devicelist as $row){	
					
					    $devicetype=$row->deviceType=='A'?"Android":"iPhone";
					    $userType=$row->usertype=='N'?"Normal":"Premium";
				  ?>
					 <tr>
                     	 <td class="aligncenter"><span class="center" style="padding-left:7px">
                            <input type="checkbox" class="checkbox1" name="chk[]" id="deviceIds" value='<?php echo $row->regId;?>' />
                          </span></td>
                        <td><?php echo $row->username; ?></td>
                        <td><?php echo $row->deviceId; ?></td>
                        <td><?php echo $devicetype; ?></td>
                        <td><?php echo $userType; ?></td>
					 </tr>
                       <?php } } ?>
				</tbody>
	        </table>
            
          
            
            <div class="textMsg">                                
                <textarea class="newTextArea" rows="10" id="txtmsg" name="message" cols="100" placeholder="Type message"></textarea>
            </div>
            <div class="textMsg">
                <input id="btnsubmit" type="button"  value="Send Push Notification" />
            </div>
            
           </section>
        </div>
    </div>
</div>
<script type="text/javascript">
   $(document).ready(function(){
   
		$('#example').dataTable( {
		  "columnDefs": [ {
			  "targets": 'nosort',
			  "orderable": false
			} ]
		} );
     });
</script>
<script src="http://localhost/lifefeed/admin_assets/js/notification.js"></script>

<style>
.optbtns{
	margin:0px 5px;
}
</style>
		
        